@extends("admin.layout.app")

@section("title", "Products")

@section("main-content")

   <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Products</span>

            <h1>Products</h1>

            <p>
                Manage FMAP Media magazines, digital publications, marketplace items, pricing, publishing status, and competition settings.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add Product
            </a>

            <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light">
                <i class="bi bi-folder2-open"></i>
                Categories
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
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Published Date</th>
                <th>Status</th>
                <th>Competition</th>
                <th>Commission</th>
                <th width="160">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         width="50"
                                         height="50"
                                         class="rounded"
                                         style="object-fit: cover;"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="width:50px;height:50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h6 class="mb-0">{{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->slug }}</small>
                            </div>
                        </div>
                    </td>

                    <td>{{ $product->category?->cat_name ?? 'N/A' }}</td>

                    <td>₦{{ number_format($product->price, 2) }}</td>

                    <td>
                        {{ $product->published_at ? $product->published_at->format('d M, Y') : 'N/A' }}
                    </td>

                    <td>
                        @if($product->status === 'published')
                            <span class="badge bg-success">Published</span>
                        @elseif($product->status === 'draft')
                            <span class="badge bg-warning">Draft</span>
                        @else
                            <span class="badge bg-secondary">Archived</span>
                        @endif
                    </td>

                    <td>
                        @if($product->competition_status === 'active')
                            <span class="badge bg-primary">Active</span>
                        @elseif($product->competition_status === 'closed')
                            <span class="badge bg-danger">Closed</span>
                        @else
                            <span class="badge bg-light text-dark">None</span>
                        @endif
                    </td>

                    <td>
                        @if($product->commission_type === 'percentage')
                            <span class="badge bg-info text-dark">
                                {{ number_format($product->commission_value, 2) }}%
                            </span>
                            <small class="d-block text-muted">Percentage</small>

                        @elseif($product->commission_type === 'fixed')
                            <span class="badge bg-success">
                                ₦{{ number_format($product->commission_value, 2) }}
                            </span>
                            <small class="d-block text-muted">Fixed per sale</small>

                        @elseif($product->commission_type === 'target_fixed')
                            <span class="badge bg-warning text-dark">
                                ₦{{ number_format($product->commission_value, 2) }}
                            </span>
                            <small class="d-block text-muted">
                                Target: {{ number_format($product->commission_target_qty ?? 0) }} sales
                            </small>

                        @else
                            <span class="badge bg-light text-dark">No Commission</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-bag display-5 d-block mb-2"></i>
                        No product has been added yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>

        </div>
    </div>


@endsection