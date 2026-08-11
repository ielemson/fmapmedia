@extends("admin.layout.app")

@section("title", "Add Gallery Album")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Gallery Management</span>

            <h1>Add Gallery Album</h1>

            <p>
                Create an event gallery, add event information, prepare the full report
                and upload photographs for publication on FMAP Media.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.gallery-albums.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                @include("admin.gallery_albums.form")

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Save Gallery Album
                    </button>

                    <a href="{{ route('admin.gallery-albums.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection