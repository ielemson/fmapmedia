<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category', 'author')
            ->latest()
            ->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:news,slug'],
            'summary'          => ['nullable', 'string'],
            'details'          => ['required', 'string'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_caption'    => ['nullable', 'string', 'max:255'],
            'category_id'      => ['nullable', 'exists:news_categories,id'],
            'status'           => ['required', 'in:draft,pending,published,archived'],
            'type'             => ['required', 'in:news,article,opinion,editorial,interview,press_release,video,photo_news'],
            'published_at'     => ['nullable', 'date'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords'    => ['nullable', 'string'],
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            // Use the provided slug or generate one from the title
            $slug = $request->filled('slug')
                ? Str::slug($request->slug)
                : Str::slug($request->title);

            // Preserve the original extension
            $extension = $image->getClientOriginalExtension();

            // Generate filename
            $imageName = $slug . '.' . $extension;

            // Prevent overwriting existing files
            if (file_exists(public_path('uploads/news/' . $imageName))) {
                $imageName = $slug . '-' . time() . '.' . $extension;
            }

            // Save image
            $image->move(public_path('uploads/news'), $imageName);
        }

        News::create([
            'title' => $request->title,
            'slug' => $request->slug ?: Str::slug($request->title) . '-' . Str::random(5),
            'summary' => $request->summary,
            'details' => $request->details,
            'image' => $imageName,
            'image_caption' => $request->image_caption,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'type' => $request->type,

            'featured' => $request->boolean('featured'),
            'breaking' => $request->boolean('breaking'),
            'headline' => $request->boolean('headline'),
            'trending' => $request->boolean('trending'),
            'editors_pick' => $request->boolean('editors_pick'),

            'author_id' => Auth::id(),
            'published_at' => $request->published_at,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }

    public function show(News $news)
    {
        $news->load('category', 'author');

        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {



        $request->validate([
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('news', 'slug')->ignore($news->id),
            ],

            'summary' => ['nullable', 'string'],
            'details' => ['required', 'string'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'image_caption' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:news_categories,id'],
            'status' => ['required', 'in:draft,pending,published,archived'],

            'type' => [
                'required',
                'in:news,article,opinion,editorial,interview,press_release,video,photo_news',
            ],

            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        /*
|--------------------------------------------------------------------------
| Resolve the final slug
|--------------------------------------------------------------------------
*/

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->title);

        $imageName = $news->image;
        $uploadDirectory = public_path('uploads/news');

        /*
|--------------------------------------------------------------------------
| Ensure the upload directory exists
|--------------------------------------------------------------------------
*/

        if (!File::isDirectory($uploadDirectory)) {
            File::makeDirectory($uploadDirectory, 0755, true);
        }

        /*
|--------------------------------------------------------------------------
| Upload a new image
|--------------------------------------------------------------------------
*/

        if ($request->hasFile('image')) {
            /*
* Since only the filename is stored, prepend the directory
* when checking and deleting the existing image.
*/
            if (
                $news->image &&
                File::exists($uploadDirectory . DIRECTORY_SEPARATOR . $news->image)
            ) {
                File::delete(
                    $uploadDirectory . DIRECTORY_SEPARATOR . $news->image
                );
            }

            $image = $request->file('image');

            $extension = strtolower(
                $image->getClientOriginalExtension()
            );

            $imageName = $slug . '.' . $extension;

            /*
* Delete an existing file with the same slug-based name.
*/
            $newImagePath = $uploadDirectory
                . DIRECTORY_SEPARATOR
                . $imageName;

            if (File::exists($newImagePath)) {
                File::delete($newImagePath);
            }

            $image->move($uploadDirectory, $imageName);
        }

        $news->update([
            'title' => $request->title,
            'slug' => $request->slug ?: $news->slug,
            'summary' => $request->summary,
            'details' => $request->details,
            'image' => $imageName,
            'image_caption' => $request->image_caption,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'type' => $request->type,

            'featured' => $request->boolean('featured'),
            'breaking' => $request->boolean('breaking'),
            'headline' => $request->boolean('headline'),
            'trending' => $request->boolean('trending'),
            'editors_pick' => $request->boolean('editors_pick'),

            'published_at' => $request->published_at,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image && File::exists(public_path($news->image))) {
            File::delete(public_path($news->image));
        }

        $news->delete();

        return back()->with('success', 'News deleted successfully.');
    }
}
