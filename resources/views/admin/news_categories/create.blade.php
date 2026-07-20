@extends("admin.layout.app")

@section("title", "Add News Category")

@section("main-content")

  <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Categories</span>

            <h1>Add News Category</h1>

            <p>
                Create a category for grouping FMAP Media news posts and improving content organization.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news-categories.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Categories
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.news-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.news_categories.form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Save Category
                    </button>

                    <a href="{{ route('admin.news-categories.index') }}" class="btn btn-light">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
@endsection