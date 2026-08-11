@extends("admin.layout.app")

@section("title", "Edit Gallery Album")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Gallery Management</span>

            <h1>Edit Gallery Album</h1>

            <p>
                Update the event details, report, cover image, photographs,
                publication status and display settings for this gallery album.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.gallery-albums.show', $album) }}"
               class="btn btn-primary">
                <i class="bi bi-eye"></i>
                View Album
            </a>

            <a href="{{ route('admin.gallery-albums.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <div class="mb-4">
                <h5 class="mb-1">{{ $album->title }}</h5>

                <p class="text-muted mb-0">
                    Last updated {{ $album->updated_at->format('d M, Y \a\t h:i A') }}
                </p>
            </div>

            <form action="{{ route('admin.gallery-albums.update', $album) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @include("admin.gallery_albums.form")

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Update Gallery Album
                    </button>

                    <a href="{{ route('admin.gallery-albums.show', $album) }}"
                       class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i>
                        View Album
                    </a>

                    <a href="{{ route('admin.gallery-albums.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection