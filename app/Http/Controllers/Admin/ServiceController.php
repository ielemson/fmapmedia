<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($serviceQuery) use ($search) {
                    $serviceQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'is_active',
                    $request->status === 'active'
                )
            )
            ->when(
                $request->boolean('featured'),
                fn ($query) => $query->where('is_featured', true)
            )
            ->when(
                $request->sort === 'oldest',
                fn ($query) => $query->oldest()
            )
            ->when(
                $request->sort === 'title',
                fn ($query) => $query->orderBy('title')
            )
            ->when(
                $request->sort === 'order',
                fn ($query) => $query->orderBy('display_order')
            )
            ->when(
                !in_array(
                    $request->sort,
                    ['oldest', 'title', 'order'],
                    true
                ),
                fn ($query) => $query->latest()
            )
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateService($request);

        $imagePath = null;

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('services', 'public');
            }

            Service::create([
                'title'             => $validated['title'],
                'slug'              => $this->generateUniqueSlug(
                    $validated['slug'] ?: $validated['title']
                ),
                'icon'              => $validated['icon'] ?? null,
                'image'             => $imagePath,
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'button_text'       => $validated['button_text'] ?? null,
                'button_url'        => $validated['button_url'] ?? null,
                'display_order'      => $validated['display_order'] ?? 0,
                'is_featured'       => $request->boolean('is_featured'),
                'is_active'         => $request->boolean('is_active'),
                'published_at'      => $validated['published_at'] ?? null,
                'meta_title'        => $validated['meta_title'] ?? null,
                'meta_description'  => $validated['meta_description'] ?? null,
                'meta_keywords'     => $validated['meta_keywords'] ?? null,
            ]);

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service created successfully.');
        } catch (\Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to create the service.');
        }
    }

    public function show(Service $service): View
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(
        Request $request,
        Service $service
    ): RedirectResponse {
        $validated = $this->validateService($request, $service);

        $oldImage = $service->image;
        $newImage = null;

        try {
            $imagePath = $oldImage;

            if ($request->boolean('remove_image')) {
                $imagePath = null;
            }

            if ($request->hasFile('image')) {
                $newImage = $request->file('image')
                    ->store('services', 'public');

                $imagePath = $newImage;
            }

            $service->update([
                'title'             => $validated['title'],
                'slug'              => $this->generateUniqueSlug(
                    $validated['slug'] ?: $validated['title'],
                    $service->id
                ),
                'icon'              => $validated['icon'] ?? null,
                'image'             => $imagePath,
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'button_text'       => $validated['button_text'] ?? null,
                'button_url'        => $validated['button_url'] ?? null,
                'display_order'      => $validated['display_order'] ?? 0,
                'is_featured'       => $request->boolean('is_featured'),
                'is_active'         => $request->boolean('is_active'),
                'published_at'      => $validated['published_at'] ?? null,
                'meta_title'        => $validated['meta_title'] ?? null,
                'meta_description'  => $validated['meta_description'] ?? null,
                'meta_keywords'     => $validated['meta_keywords'] ?? null,
            ]);

            if (
                $oldImage &&
                $oldImage !== $imagePath &&
                Storage::disk('public')->exists($oldImage)
            ) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service updated successfully.');
        } catch (\Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to update the service.');
        }
    }

    public function destroy(Service $service): RedirectResponse
    {
        try {
            $imagePath = $service->image;

            $service->delete();

            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service deleted successfully.');
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->with('error', 'Unable to delete the service.');
        }
    }

    private function validateService(
        Request $request,
        ?Service $service = null
    ): array {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')
                    ->ignore($service?->id),
            ],

            'icon' => ['nullable', 'string', 'max:255'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],

            'remove_image' => ['nullable', 'boolean'],

            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'description' => ['nullable', 'string'],

            'button_text' => ['nullable', 'string', 'max:100'],

            'button_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'display_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_featured' => ['nullable', 'boolean'],
            'is_active'   => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);
    }

    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'service';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Service::query()
                ->when(
                    $ignoreId,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}