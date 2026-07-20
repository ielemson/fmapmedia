@extends("admin.layout.app")

@section("title", "Add Product")

@section("main-content")
 <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Products</span>

            <h1>Add Product</h1>

            <p>
                Create a new FMAP Media product including magazines, digital publications, subscriptions, or marketplace items.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @include('admin.products._form', [
            'buttonText' => 'Save Product'
        ])

    </form>

@endsection