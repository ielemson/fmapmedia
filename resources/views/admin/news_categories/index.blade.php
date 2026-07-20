@extends("admin.layout.app")

@section("title", "News Categories")

@section("main-content")

 <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">News Categories</span>

            <h1>News Categories</h1>

            <p>
                Manage category structure, visibility, menu placement, homepage display, and sorting for FMAP Media news content.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.news-categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add Category
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Menu</th>
                            <th>Homepage</th>
                            <th>Sort</th>
                            <th class="text-end" width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $key => $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $key }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ asset($category->image) }}"
                                                 class="rounded me-2"
                                                 width="45"
                                                 height="45"
                                                 style="object-fit: cover;"
                                                 alt="{{ $category->name }}">
                                        @else
                                            <div class="avatar-xs me-2">
                                                <span class="avatar-title rounded bg-primary-subtle text-primary">
                                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div>
                                            <h6 class="mb-0">{{ $category->name }}</h6>
                                            <small class="text-muted">
                                                {{ Str::limit($category->description, 70) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $category->slug }}</td>

                                <td>
                                    @if($category->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    @if($category->show_on_menu)
                                        <span class="badge bg-info">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>

                                <td>
                                    @if($category->show_on_homepage)
                                        <span class="badge bg-primary">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>

                                <td>{{ $category->sort_order }}</td>

                                <td class="text-end">
                                    <a href="{{ route('admin.news-categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.news-categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this category?');">
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
                                    <i class="bi bi-tags display-5 d-block mb-2"></i>
                                    No news category found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>

        </div>
    </div>


@endsection