<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::latest()->paginate(20);

        return view('admin.news_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.news_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:news_categories,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:news_categories,slug'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news/categories'), $imageName);
            $imagePath = 'uploads/news/categories/' . $imageName;
        }

        NewsCategory::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'show_on_menu' => $request->boolean('show_on_menu'),
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ]);

        return redirect()
            ->route('admin.news-categories.index')
            ->with('success', 'News category created successfully.');
    }

    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news_categories.edit', compact('newsCategory'));
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:news_categories,name,' . $newsCategory->id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:news_categories,slug,' . $newsCategory->id],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imagePath = $newsCategory->image;

        if ($request->hasFile('image')) {
            if ($newsCategory->image && File::exists(public_path($newsCategory->image))) {
                File::delete(public_path($newsCategory->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news/categories'), $imageName);
            $imagePath = 'uploads/news/categories/' . $imageName;
        }

        $newsCategory->update([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'show_on_menu' => $request->boolean('show_on_menu'),
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ]);

        return redirect()
            ->route('admin.news-categories.index')
            ->with('success', 'News category updated successfully.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        if ($newsCategory->news()->exists()) {
            return back()->with('error', 'This category cannot be deleted because it has news posts.');
        }

        if ($newsCategory->image && File::exists(public_path($newsCategory->image))) {
            File::delete(public_path($newsCategory->image));
        }

        $newsCategory->delete();

        return back()->with('success', 'News category deleted successfully.');
    }
}