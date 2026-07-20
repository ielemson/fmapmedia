@extends("admin.layout.app")

@section("title", "Edit News")

@section("main-content")

 <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Management</span>

            <h1>Edit News</h1>

            <p>
                Update news content, publishing status, image, category, and SEO details for FMAP Media.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to News
            </a>

            <a href="{{ route('admin.news.show', $news->id) }}" class="btn btn-primary">
                <i class="bi bi-eye"></i>
                Preview
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.news.form', [
            'news' => $news,
            'categories' => $categories
        ])

        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Last updated:
                    {{ $news->updated_at ? $news->updated_at->format('d M, Y h:i A') : 'N/A' }}
                </div>

                <div>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Update News
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection