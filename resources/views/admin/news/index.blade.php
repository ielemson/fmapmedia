@extends("admin.layout.app")

@section("title", "News Management")

@section("main-content")

  <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Management</span>

            <h1>News & Publications</h1>

            <p>
                Manage FMAP Media news articles, categories, publication status, breaking news, featured stories and editorial content.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add News
            </a>

            <a href="{{ route('admin.news-categories.index') }}" class="btn btn-light">
                <i class="bi bi-tags"></i>
                Categories
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.news.index') }}">
                <div class="row g-3 align-items-end">

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Search title...">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            @foreach(['draft', 'pending', 'published', 'archived'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">All Types</option>
                            @foreach([
                                'news' => 'News',
                                'article' => 'Article',
                                'opinion' => 'Opinion',
                                'editorial' => 'Editorial',
                                'interview' => 'Interview',
                                'press_release' => 'Press Release',
                                'video' => 'Video',
                                'photo_news' => 'Photo News',
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ request('type') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-funnel"></i>
                                Filter
                            </button>

                            <a href="{{ route('admin.news.index') }}" class="btn btn-light flex-fill">
                                Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.news.index', ['status' => 'published']) }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-check-circle"></i>
                    Published
                </a>

                <a href="{{ route('admin.news.index', ['status' => 'draft']) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark-text"></i>
                    Drafts
                </a>

                <a href="{{ route('admin.news.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-clock"></i>
                    Pending
                </a>

                <a href="{{ route('admin.news.index', ['featured' => 1]) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-star"></i>
                    Featured
                </a>

                <a href="{{ route('admin.news.index', ['breaking' => 1]) }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-lightning"></i>
                    Breaking News
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-1">News Records</h5>
                    <p class="text-muted mb-0">
                        Showing {{ $news->firstItem() ?? 0 }} - {{ $news->lastItem() ?? 0 }} of {{ $news->total() ?? 0 }} records
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.news.index') }}" class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    @foreach(request()->except('sort', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <span class="text-muted">Sort:</span>

                    <select name="sort" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="views" {{ request('sort') === 'views' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="70">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Published</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($news as $item)
                            <tr>
                                {{-- <td>
                                    <img src="{{ $item->image ? asset($item->image) : asset('backend/assets/images/default-news.jpg') }}"
                                         alt="{{ $item->title }}"
                                         style="width: 55px; height: 45px; object-fit: cover; border-radius: 8px;">
                                </td> --}}

                                <td>
                                    <img
                                        src="{{ $item->image_url }}"
                                        alt="{{ $item->title }}"
                                        class="img-thumbnail"
                                        style="width:55px;height:45px;object-fit:cover;border-radius:8px;"
                                        loading="lazy">
                                </td>

                                <td>
                                    <strong>{{ Str::limit($item->title, 60) }}</strong>

                                    <div class="mt-1">
                                        @if($item->breaking)
                                            <span class="badge bg-danger">Breaking</span>
                                        @endif

                                        @if($item->featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @endif

                                        @if($item->headline)
                                            <span class="badge bg-info">Headline</span>
                                        @endif

                                        @if($item->trending)
                                            <span class="badge bg-warning">Trending</span>
                                        @endif

                                        @if($item->editors_pick)
                                            <span class="badge bg-dark">Editor</span>
                                        @endif
                                    </div>
                                </td>

                                <td>{{ $item->category->name ?? 'Uncategorized' }}</td>

                                <td>{{ ucfirst(str_replace('_', ' ', $item->type)) }}</td>

                                <td>
                                    @if($item->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($item->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($item->status === 'archived')
                                        <span class="badge bg-danger">Archived</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>

                                <td>{{ number_format($item->view_count) }}</td>

                                <td>
                                    {{ $item->published_at ? $item->published_at->format('d M, Y') : 'Not published' }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.news.show', $item->id) }}"
                                       class="btn btn-sm btn-light">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.news.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.news.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this news item?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-newspaper display-5 d-block mb-2"></i>
                                    No news found.
                                    <div class="mt-3">
                                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i>
                                            Add News
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                <p class="text-muted mb-0">
                    Page {{ $news->currentPage() }} of {{ $news->lastPage() }}
                </p>

                <div>
                    {{ $news->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection