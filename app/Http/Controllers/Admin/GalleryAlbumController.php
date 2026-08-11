<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class GalleryAlbumController extends Controller
{
    /**
     * Display gallery albums.
     */
    public function index(Request $request): View
    {
        $albums = GalleryAlbum::query()
            ->withCount('images')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->string('search')->toString());

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%")
                        ->orWhere('event_type', 'like', "%{$search}%")
                        ->orWhere('venue', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('organizer', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->when(
                $request->boolean('featured'),
                fn ($query) => $query->where('is_featured', true)
            )
            ->orderBy('sort_order')
            ->latest('event_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.gallery_albums.index', compact('albums'));
    }

    /**
     * Show the album creation form.
     */
    public function create(): View
    {
        return view('admin.gallery_albums.create');
    }

    /**
     * Store a newly created gallery album.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $storedPaths = [];

        try {
            $coverImage = $request->file('cover_image')
                ->store('gallery/albums/covers', 'public');

            $storedPaths[] = $coverImage;

            unset($data['cover_image'], $data['images']);

            $data['cover_image'] = $coverImage;
            $data['is_featured'] = $request->boolean('is_featured');
            $data['published_at'] = $this->resolvePublishedAt($data);

            $album = DB::transaction(function () use (
                $request,
                $data,
                &$storedPaths
            ) {
                $album = GalleryAlbum::create($data);

                foreach ($request->file('images', []) as $index => $file) {
                    $imagePath = $file->store(
                        "gallery/albums/{$album->id}/images",
                        'public'
                    );

                    $storedPaths[] = $imagePath;

                    $album->images()->create([
                        'image' => $imagePath,
                        'title' => null,
                        'caption' => null,
                        'alt_text' => $album->title,
                        'sort_order' => $index,
                        'status' => true,
                    ]);
                }

                return $album;
            });

            return redirect()
                ->route('admin.gallery-albums.edit', $album)
                ->with(
                    'success',
                    'Gallery album created successfully. You can now manage the photograph details.'
                );
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);

            throw $exception;
        }
    }

    /**
     * Display an album in the administrator area.
     */
    public function show(GalleryAlbum $galleryAlbum): View
    {
        $galleryAlbum->load([
            'images' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return view('admin.gallery_albums.show', [
            'album' => $galleryAlbum,
        ]);
    }

    /**
     * Show the album editing form.
     */
    public function edit(GalleryAlbum $galleryAlbum): View
    {
        $galleryAlbum->load([
            'images' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return view('admin.gallery_albums.edit', [
            'album' => $galleryAlbum,
        ]);
    }

    /**
     * Update an existing gallery album.
     */
    public function update(
        Request $request,
        GalleryAlbum $galleryAlbum
    ): RedirectResponse {
        $data = $request->validate(
            $this->rules($galleryAlbum)
        );

        $storedPaths = [];
        $oldCoverImage = null;

        try {
            if ($request->hasFile('cover_image')) {
                $newCoverImage = $request->file('cover_image')
                    ->store('gallery/albums/covers', 'public');

                $storedPaths[] = $newCoverImage;
                $oldCoverImage = $galleryAlbum->cover_image;
                $data['cover_image'] = $newCoverImage;
            } else {
                unset($data['cover_image']);
            }

            unset($data['images']);

            $data['is_featured'] = $request->boolean('is_featured');
            $data['published_at'] = $this->resolvePublishedAt(
                $data,
                $galleryAlbum
            );

            DB::transaction(function () use (
                $request,
                $galleryAlbum,
                $data,
                &$storedPaths
            ) {
                $galleryAlbum->update($data);

                $nextSortOrder = (int) $galleryAlbum
                    ->images()
                    ->max('sort_order');

                if ($galleryAlbum->images()->exists()) {
                    $nextSortOrder++;
                }

                foreach ($request->file('images', []) as $index => $file) {
                    $imagePath = $file->store(
                        "gallery/albums/{$galleryAlbum->id}/images",
                        'public'
                    );

                    $storedPaths[] = $imagePath;

                    $galleryAlbum->images()->create([
                        'image' => $imagePath,
                        'title' => null,
                        'caption' => null,
                        'alt_text' => $galleryAlbum->title,
                        'sort_order' => $nextSortOrder + $index,
                        'status' => true,
                    ]);
                }
            });

            if (
                $oldCoverImage &&
                $oldCoverImage !== $galleryAlbum->cover_image
            ) {
                Storage::disk('public')->delete($oldCoverImage);
            }

            return redirect()
                ->route('admin.gallery-albums.edit', $galleryAlbum)
                ->with('success', 'Gallery album updated successfully.');
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);

            throw $exception;
        }
    }

    /**
     * Delete an album and its stored photographs.
     */
    public function destroy(
        GalleryAlbum $galleryAlbum
    ): RedirectResponse {
        $galleryAlbum->load('images');

        $storedPaths = collect([
            $galleryAlbum->cover_image,
            ...$galleryAlbum->images->pluck('image')->all(),
            ...$galleryAlbum->images->pluck('thumbnail')->all(),
        ])
            ->filter()
            ->unique()
            ->values()
            ->all();

        DB::transaction(function () use ($galleryAlbum) {
            /*
             * Gallery images are removed automatically by the
             * cascadeOnDelete foreign-key constraint.
             */
            $galleryAlbum->delete();
        });

        if ($storedPaths !== []) {
            Storage::disk('public')->delete($storedPaths);
        }

        return redirect()
            ->route('admin.gallery-albums.index')
            ->with('success', 'Gallery album deleted successfully.');
    }

    /**
     * Gallery album validation rules.
     */
    private function rules(
        ?GalleryAlbum $galleryAlbum = null
    ): array {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'subtitle' => [
                'nullable',
                'string',
                'max:255',
            ],
            'event_type' => [
                'nullable',
                'string',
                'max:150',
            ],
            'event_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:event_date',
            ],
            'venue' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'organizer' => [
                'nullable',
                'string',
                'max:255',
            ],
            'excerpt' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'report' => [
                'nullable',
                'string',
            ],
            'cover_image' => [
                $galleryAlbum ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'images' => [
                'nullable',
                'array',
                'max:50',
            ],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'status' => [
                'required',
                'in:draft,published,archived',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'published_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Determine the album publication date.
     */
    private function resolvePublishedAt(
        array $data,
        ?GalleryAlbum $galleryAlbum = null
    ): mixed {
        if (($data['status'] ?? 'draft') !== 'published') {
            return $data['published_at'] ?? null;
        }

        return $data['published_at']
            ?? $galleryAlbum?->published_at
            ?? now();
    }
}