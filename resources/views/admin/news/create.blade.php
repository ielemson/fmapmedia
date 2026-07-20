@extends("admin.layout.app")

@section("title", "Add News")

@section("main-content")

  <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Management</span>

            <h1>Add News</h1>

            <p>
                Create and publish a new FMAP Media news article with category, image, content, and publication details.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to News
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.news.form')

        <div class="card">
            <div class="card-body text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Save News
                </button>

                <a href="{{ route('admin.news.index') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>
        </div>
    </form>

@endsection