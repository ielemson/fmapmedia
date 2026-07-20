@extends("admin.layout.app")

@section("title", "Product Categories")

@section("main-content")
<div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Product Categories</span>

            <h1>Product Categories</h1>

            <p>
                Manage marketplace categories for FMAP Media products, magazines, publications, and digital items.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add Category
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Created</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <img src="{{ $category->image ? asset($category->image) : asset('backend/assets/images/default-category.jpg') }}"
                                         width="55"
                                         height="55"
                                         class="rounded"
                                         style="object-fit: cover;"
                                         alt="{{ $category->name }}">
                                </td>

                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($category->description, 40) }}
                                    </small>
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
                                    <span class="badge bg-info">
                                        {{ $category->products->count() }}
                                    </span>
                                </td>

                                <td>
                                    {{ $category->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.product-categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.product-categories.destroy', $category->id) }}"
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
                                    <i class="bi bi-folder2-open display-5 d-block mb-2"></i>
                                    No product categories found.
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