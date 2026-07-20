@extends("admin.layout.app")

@section("title", "Edit News Category")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Categories</span>

            <h1>Edit News Category</h1>

            <p>
                Update the category name, image, visibility, description, and display order for FMAP Media news content.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news-categories.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Categories
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.news-categories.update', $newsCategory->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.news_categories.form', [
                    'category' => $newsCategory
                ])

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Update Category
                    </button>

                    <a href="{{ route('admin.news-categories.index') }}" class="btn btn-light">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection