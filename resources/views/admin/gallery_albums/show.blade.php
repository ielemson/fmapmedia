@extends("admin.layout.app")

@section("title", $album->title)

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Gallery Management</span>

            <h5>{{ $album->title }}</h5>

            <p>
                Review the event information, publication details, report and
                photographs contained in this gallery album.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.gallery-albums.edit', $album) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil-square"></i>
                Edit Album
            </a>

            <a href="{{ route('admin.gallery-albums.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="row g-4">

        {{-- Album information --}}
        <div class="col-xl-8">

            {{-- Cover and introduction --}}
            <div class="card mb-4">
                <div class="card-body">

                    @if($album->cover_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $album->cover_image) }}"
                                 alt="{{ $album->title }}"
                                 class="img-fluid rounded w-100"
                                 style="max-height: 480px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if($album->event_type)
                            <span class="badge bg-info">
                                <i class="bi bi-calendar-event"></i>
                                {{ $album->event_type }}
                            </span>
                        @endif

                        @switch($album->status)
                            @case('published')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i>
                                    Published
                                </span>
                                @break

                            @case('archived')
                                <span class="badge bg-danger">
                                    <i class="bi bi-archive"></i>
                                    Archived
                                </span>
                                @break

                            @default
                                <span class="badge bg-secondary">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Draft
                                </span>
                        @endswitch

                        @if($album->is_featured)
                            <span class="badge bg-primary">
                                <i class="bi bi-star-fill"></i>
                                Featured Album
                            </span>
                        @endif
                    </div>

                    <h3 class="mb-2">{{ $album->title }}</h3>

                    @if($album->subtitle)
                        <h5 class="text-muted fw-normal mb-3">
                            {{ $album->subtitle }}
                        </h5>
                    @endif

                    @if($album->excerpt)
                        <div class="alert alert-light border mb-0">
                            {{ $album->excerpt }}
                        </div>
                    @endif

                </div>
            </div>

            {{-- Full event report --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-1"></i>
                        Event Report
                    </h5>
                </div>

                <div class="card-body">
                    @if($album->report)
                        <div class="gallery-report">
                            {!! $album->report !!}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-file-earmark-x display-5 d-block mb-3"></i>
                            <p class="mb-0">
                                No event report has been added to this album.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Album metadata --}}
        <div class="col-xl-4">

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Event Information
                    </h5>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">

                        <dt class="col-sm-5 mb-3">Event Date</dt>
                        <dd class="col-sm-7 mb-3">
                            @if($album->event_date)
                                {{ $album->event_date->format('d M, Y') }}
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </dd>

                        @if($album->end_date)
                            <dt class="col-sm-5 mb-3">End Date</dt>
                            <dd class="col-sm-7 mb-3">
                                {{ $album->end_date->format('d M, Y') }}
                            </dd>
                        @endif

                        <dt class="col-sm-5 mb-3">Venue</dt>
                        <dd class="col-sm-7 mb-3">
                            {{ $album->venue ?: 'Not specified' }}
                        </dd>

                        <dt class="col-sm-5 mb-3">Location</dt>
                        <dd class="col-sm-7 mb-3">
                            {{ $album->location ?: 'Not specified' }}
                        </dd>

                        <dt class="col-sm-5 mb-3">Organiser</dt>
                        <dd class="col-sm-7 mb-3">
                            {{ $album->organizer ?: 'Not specified' }}
                        </dd>

                        <dt class="col-sm-5 mb-3">Photographs</dt>
                        <dd class="col-sm-7 mb-3">
                            <span class="badge bg-dark">
                                <i class="bi bi-images"></i>
                                {{ number_format($album->images->count()) }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 mb-3">Display Order</dt>
                        <dd class="col-sm-7 mb-3">
                            {{ number_format($album->sort_order) }}
                        </dd>

                        <dt class="col-sm-5 mb-3">Published</dt>
                        <dd class="col-sm-7 mb-3">
                            @if($album->published_at)
                                {{ $album->published_at->format('d M, Y') }}

                                <div class="small text-muted">
                                    {{ $album->published_at->format('h:i A') }}
                                </div>
                            @else
                                <span class="text-muted">Not published</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5 mb-3">Created</dt>
                        <dd class="col-sm-7 mb-3">
                            {{ $album->created_at->format('d M, Y') }}
                        </dd>

                        <dt class="col-sm-5">Last Updated</dt>
                        <dd class="col-sm-7">
                            {{ $album->updated_at->format('d M, Y') }}

                            <div class="small text-muted">
                                {{ $album->updated_at->format('h:i A') }}
                            </div>
                        </dd>

                    </dl>
                </div>
            </div>

            {{-- Administrative actions --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-1"></i>
                        Album Actions
                    </h5>
                </div>

                <div class="card-body">
                    <div class="d-grid gap-2">

                        <a href="{{ route('admin.gallery-albums.edit', $album) }}"
                           class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                            Edit Gallery Album
                        </a>

                        <a href="{{ route('admin.gallery-albums.index') }}"
                           class="btn btn-light">
                            <i class="bi bi-list"></i>
                            View All Albums
                        </a>

                        <form action="{{ route('admin.gallery-albums.destroy', $album) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this gallery album and all its photographs? This action cannot be undone.');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash"></i>
                                Delete Album
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

        {{-- Gallery photographs --}}
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-images me-1"></i>
                            Gallery Photographs
                        </h5>

                        <p class="text-muted small mb-0">
                            {{ number_format($album->images->count()) }}
                            {{ \Illuminate\Support\Str::plural('photograph', $album->images->count()) }}
                            in this album
                        </p>
                    </div>

                    <a href="{{ route('admin.gallery-albums.edit', $album) }}"
                       class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Add Photographs
                    </a>
                </div>

                <div class="card-body">
                    <div class="row g-4">

                        @forelse($album->images as $image)
                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <div class="card h-100 border gallery-image-card">

                                    <a href="{{ asset('storage/' . $image->image) }}"
                                       target="_blank"
                                       rel="noopener"
                                       title="Open full-size photograph">

                                        <img src="{{ asset('storage/' . $image->image) }}"
                                             alt="{{ $image->alt_text ?: ($image->title ?: $album->title) }}"
                                             class="card-img-top"
                                             style="height: 220px; object-fit: cover;"
                                             loading="lazy">
                                    </a>

                                    <div class="card-body">
                                        @if($image->title)
                                            <h6 class="card-title mb-2">
                                                {{ $image->title }}
                                            </h6>
                                        @endif

                                        @if($image->caption)
                                            <p class="card-text small text-muted mb-3">
                                                {{ $image->caption }}
                                            </p>
                                        @endif

                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <span class="badge bg-light text-dark">
                                                Order: {{ $image->sort_order }}
                                            </span>

                                            @if($image->status)
                                                <span class="badge bg-success">
                                                    Visible
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Hidden
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center text-muted py-5">

                                    <i class="bi bi-images display-5 d-block mb-3"></i>

                                    <h5>No gallery photographs</h5>

                                    <p>
                                        This album does not yet contain additional
                                        photographs.
                                    </p>

                                    <a href="{{ route('admin.gallery-albums.edit', $album) }}"
                                       class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i>
                                        Add Photographs
                                    </a>

                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection