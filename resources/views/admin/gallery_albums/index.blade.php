@extends("admin.layout.app")

@section("title", "Gallery Management")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Gallery Management</span>

            <h1>Event Galleries</h1>

            <p>
                Manage FMAP Media event albums, photographs, reports, publication
                status, featured galleries and display order.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.gallery-albums.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add Gallery Album
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    {{-- Search and filters --}}
    <div class="card mb-4">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.gallery-albums.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-6 col-md-12">
                        <label for="search" class="form-label">
                            Search Gallery
                        </label>

                        <input type="text"
                               name="search"
                               id="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Search title, event type, venue, location or organiser">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="status" class="form-label">
                            Publication Status
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select">

                            <option value="">All Statuses</option>

                            <option value="published"
                                @selected(request('status') === 'published')>
                                Published
                            </option>

                            <option value="draft"
                                @selected(request('status') === 'draft')>
                                Draft
                            </option>

                            <option value="archived"
                                @selected(request('status') === 'archived')>
                                Archived
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label d-block">
                            Featured Gallery
                        </label>

                        <div class="form-check form-switch mb-2">
                            <input type="checkbox"
                                   name="featured"
                                   id="featured"
                                   class="form-check-input"
                                   value="1"
                                   @checked(request()->boolean('featured'))>

                            <label for="featured"
                                   class="form-check-label">
                                Featured only
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2">

                            <button type="submit"
                                    class="btn btn-primary">
                                <i class="bi bi-funnel"></i>
                                Apply Filters
                            </button>

                            <a href="{{ route('admin.gallery-albums.index') }}"
                               class="btn btn-light">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- Quick filters --}}
    <div class="card mb-4">
        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('admin.gallery-albums.index') }}"
                   class="btn btn-sm {{ !request()->hasAny(['status', 'featured', 'search']) ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-images"></i>
                    All Albums
                </a>

                <a href="{{ route('admin.gallery-albums.index', ['status' => 'published']) }}"
                   class="btn btn-sm {{ request('status') === 'published' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="bi bi-check-circle"></i>
                    Published
                </a>

                <a href="{{ route('admin.gallery-albums.index', ['status' => 'draft']) }}"
                   class="btn btn-sm {{ request('status') === 'draft' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Drafts
                </a>

                <a href="{{ route('admin.gallery-albums.index', ['status' => 'archived']) }}"
                   class="btn btn-sm {{ request('status') === 'archived' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="bi bi-archive"></i>
                    Archived
                </a>

                <a href="{{ route('admin.gallery-albums.index', ['featured' => 1]) }}"
                   class="btn btn-sm {{ request()->boolean('featured') ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-star"></i>
                    Featured
                </a>

            </div>

        </div>
    </div>

    {{-- Album records --}}
    <div class="card">
        <div class="card-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-1">Gallery Album Records</h5>

                    <p class="text-muted mb-0">
                        Showing {{ $albums->firstItem() ?? 0 }}
                        –
                        {{ $albums->lastItem() ?? 0 }}
                        of
                        {{ $albums->total() }}
                        records
                    </p>
                </div>

                <a href="{{ route('admin.gallery-albums.create') }}"
                   class="btn btn-primary mt-3 mt-md-0">
                    <i class="bi bi-plus-circle"></i>
                    Add Album
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="90">Cover</th>
                            <th>Event Details</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th class="text-center">Photos</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($albums as $album)
                            <tr>

                                {{-- Cover image --}}
                                <td>
                                    @if($album->cover_image)
                                        <img src="{{ asset('storage/' . $album->cover_image) }}"
                                             alt="{{ $album->title }}"
                                             class="img-thumbnail"
                                             style="width:70px;height:55px;object-fit:cover;border-radius:8px;"
                                             loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                             style="width:70px;height:55px;">
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Event details --}}
                                <td>
                                    <strong>
                                        {{ \Illuminate\Support\Str::limit($album->title, 65) }}
                                    </strong>

                                    @if($album->subtitle)
                                        <div class="small text-muted mt-1">
                                            {{ \Illuminate\Support\Str::limit($album->subtitle, 70) }}
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @if($album->event_type)
                                            <span class="badge bg-info">
                                                {{ $album->event_type }}
                                            </span>
                                        @endif

                                        @if($album->is_featured)
                                            <span class="badge bg-primary">
                                                <i class="bi bi-star-fill"></i>
                                                Featured
                                            </span>
                                        @endif

                                        @if($album->sort_order > 0)
                                            <span class="badge bg-light text-dark">
                                                Order: {{ $album->sort_order }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Event date --}}
                                <td>
                                    @if($album->event_date)
                                        <div>
                                            <i class="bi bi-calendar-event text-primary me-1"></i>
                                            {{ $album->event_date->format('d M, Y') }}
                                        </div>

                                        @if(
                                            $album->end_date &&
                                            !$album->end_date->isSameDay($album->event_date)
                                        )
                                            <div class="small text-muted mt-1">
                                                Ends {{ $album->end_date->format('d M, Y') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif
                                </td>

                                {{-- Venue --}}
                                <td>
                                    @if($album->venue)
                                        <div>
                                            <i class="bi bi-geo-alt text-danger me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($album->venue, 40) }}
                                        </div>
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif

                                    @if($album->location)
                                        <div class="small text-muted mt-1">
                                            {{ $album->location }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Photograph count --}}
                                <td class="text-center">
                                    <span class="badge bg-dark fs-6">
                                        <i class="bi bi-images"></i>
                                        {{ number_format($album->images_count) }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
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
                                </td>

                                {{-- Publication date --}}
                                <td>
                                    @if($album->published_at)
                                        {{ $album->published_at->format('d M, Y') }}

                                        <div class="small text-muted">
                                            {{ $album->published_at->format('h:i A') }}
                                        </div>
                                    @else
                                        <span class="text-muted">Not published</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a href="{{ route('admin.gallery-albums.show', $album) }}"
                                           class="btn btn-sm btn-light"
                                           title="View album">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.gallery-albums.edit', $album) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Edit album">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.gallery-albums.destroy', $album) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this gallery album and all its photographs? This action cannot be undone.');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete album">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-images display-5 d-block mb-3"></i>

                                    <h5>No gallery albums found</h5>

                                    <p class="mb-3">
                                        No album matches the selected search or filter.
                                    </p>

                                    <a href="{{ route('admin.gallery-albums.create') }}"
                                       class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i>
                                        Add Gallery Album
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if($albums->hasPages())
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">

                    <p class="text-muted mb-0">
                        Page {{ $albums->currentPage() }}
                        of
                        {{ $albums->lastPage() }}
                    </p>

                    <div>
                        {{ $albums->links() }}
                    </div>

                </div>
            @endif

        </div>
    </div>

@endsection