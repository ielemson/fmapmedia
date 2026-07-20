<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('cat_name')
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'desc' => ['nullable', 'string'],

            'status' => ['required', 'in:draft,published,archived'],
            'competition_status' => ['required', 'in:none,active,closed'],

            /*
|--------------------------------------------------------------------------
| Vendor Commission Settings
|--------------------------------------------------------------------------
*/

            'commission_type' => [
                'required',
                'in:none,percentage,fixed,target_fixed'
            ],

            'commission_value' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'commission_target_qty' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:commission_type,target_fixed'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120'
            ],
        ]);

        if ($data['commission_type'] !== 'target_fixed') {
            $data['commission_target_qty'] = null;
        }

        if ($data['commission_type'] === 'none') {
            $data['commission_value'] = 0;
            $data['commission_target_qty'] = null;
        }

        // Generate unique slug
        $slug = Str::slug($request->name);

        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $data['slug'] = $slug;

        /*
|--------------------------------------------------------------------------
| Upload Product Image
|--------------------------------------------------------------------------
*/
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = $slug . '.' . $image->getClientOriginalExtension();

            $data['image'] = $image->storeAs(
                'products/images',
                $imageName,
                'public'
            );
        }

        /*
|--------------------------------------------------------------------------
| Upload Product File
|--------------------------------------------------------------------------
*/
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = $slug . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs(
                'products/files',
                $fileName,
                'public'
            );
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')
            ->orderBy('cat_name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'desc' => ['nullable', 'string'],

            'status' => ['required', 'in:draft,published,archived'],
            'competition_status' => ['required', 'in:none,active,closed'],

            /*
|--------------------------------------------------------------------------
| Vendor Commission Settings
|--------------------------------------------------------------------------
*/

            'commission_type' => [
                'required',
                'in:none,percentage,fixed,target_fixed'
            ],

            'commission_value' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'commission_target_qty' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:commission_type,target_fixed'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120'
            ],
        ]);

        if ($data['commission_type'] !== 'target_fixed') {
            $data['commission_target_qty'] = null;
        }

        if ($data['commission_type'] === 'none') {
            $data['commission_value'] = 0;
            $data['commission_target_qty'] = null;
        }

        $slug = Str::slug($request->name);

        if (
            Product::where('slug', $slug)
            ->where('id', '!=', $product->id)
            ->exists()
        ) {
            $slug .= '-' . time();
        }

        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');

            $imageName = $slug . '.' . $image->getClientOriginalExtension();

            $data['image'] = $image->storeAs(
                'products/images',
                $imageName,
                'public'
            );
        }

        if ($request->hasFile('file')) {
            if ($product->file) {
                Storage::disk('public')->delete($product->file);
            }

            $file = $request->file('file');

            $fileName = $slug . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs(
                'products/files',
                $fileName,
                'public'
            );
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->file) {
            Storage::disk('public')->delete($product->file);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
