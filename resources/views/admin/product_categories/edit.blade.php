@extends("admin.layout.app")

@section("title", "Edit Product Category")

@section("main-content")
<div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Product Categories</span>

            <h1>Edit Product Category</h1>

            <p>
                Update category information for FMAP Media products, magazines, publications, and marketplace items.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Categories
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.product-categories.update', $category->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.product_categories.form', [
            'category' => $category
        ])

        <div class="card">
            <div class="card-body text-end">
                <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Update Category
                </button>
            </div>
        </div>
    </form>


@endsection