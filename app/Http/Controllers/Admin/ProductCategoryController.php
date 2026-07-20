<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(20);

        return view('admin.product_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $filename = time() . '_' . uniqid() . '.' . $request->image->extension();

            $request->image->move(public_path('uploads/categories'), $filename);

            $image = 'uploads/categories/' . $filename;
        }

        Category::create([
            'cat_name' => $request->cat_name,
            'slug' => $request->slug ?: Str::slug($request->cat_name),
            'description' => $request->description,
            'image' => $image,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'show_on_menu' => $request->boolean('show_on_menu'),
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ]);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $product_category)
    {
        return view('admin.product_categories.edit', [
            'category' => $product_category
        ]);
    }

    public function update(Request $request, Category $product_category)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name,' . $product_category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $product_category->id,
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        $image = $product_category->image;

        if ($request->hasFile('image')) {

            if ($product_category->image && File::exists(public_path($product_category->image))) {
                File::delete(public_path($product_category->image));
            }

            $filename = time() . '_' . uniqid() . '.' . $request->image->extension();

            $request->image->move(public_path('uploads/categories'), $filename);

            $image = 'uploads/categories/' . $filename;
        }

        $product_category->update([
            'cat_name' => $request->cat_name,
            'slug' => $request->slug ?: Str::slug($request->cat_name),
            'description' => $request->description,
            'image' => $image,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'show_on_menu' => $request->boolean('show_on_menu'),
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ]);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $product_category)
    {
        if ($product_category->products()->count()) {

            return back()->with(
                'error',
                'This category cannot be deleted because it contains products.'
            );
        }

        if ($product_category->image && File::exists(public_path($product_category->image))) {
            File::delete(public_path($product_category->image));
        }

        $product_category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}