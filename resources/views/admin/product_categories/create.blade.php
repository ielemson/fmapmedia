@extends("admin.layout.app")

@section("title", "Add Product Category")

@section("main-content")

<div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Product Categories</span>

            <h1>Add Product Category</h1>

            <p>
                Create a category for organizing FMAP Media products, magazines, publications, and marketplace items.
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

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.product-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.product_categories.form')

                <div class="mt-4 text-end">
                    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Save Category
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection