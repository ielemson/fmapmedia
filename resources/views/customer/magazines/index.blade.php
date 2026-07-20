@extends('customer.layout.app')

@section('main-content')

<div class="dashboard-section">
    <div class="dashboard-panel">

        <div class="dashboard-panel-header d-flex justify-content-between align-items-center">
            <div>
                <h4>My Magazines</h4>
                <p class="text-muted mb-0">Read your purchased FMAP Media magazines.</p>
            </div>

            <a href="{{ route('magazines.index') }}" class="btn btn-primary">
                <i class="bi bi-journal-richtext"></i>
                Browse More
            </a>
        </div>

        <div class="row g-4 mt-2 p-2">

            @forelse($products as $product)

                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card h-100">

                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="card-img-top"
                             alt="{{ $product->name }}">

                        <div class="card-body">
                            <h6>{{ $product->name }}</h6>

                            <p class="text-muted small">
                                {{ Str::limit(strip_tags($product->desc), 80) }}
                            </p>

                            <a href="{{ route('customer.magazines.show', $product->slug) }}"
                               class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-book"></i>
                                Read Magazine
                            </a>
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        You have not purchased any magazine yet.
                    </div>
                </div>

            @endforelse

        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
</div>

@endsection