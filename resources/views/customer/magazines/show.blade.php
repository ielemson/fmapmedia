@extends('customer.layout.app')

@section('main-content')

<div class="dashboard-section">

    <div class="dashboard-panel">

        <div class="dashboard-panel-header d-flex justify-content-between align-items-center">

            <div>

                <h3>{{ $product->name }}</h3>

                <p class="text-muted mb-0">
                    Enjoy your digital magazine.
                </p>

            </div>

            <a href="{{ route('customer.orders.index') }}"
               class="btn btn-outline-primary">

                <i class="bi bi-arrow-left"></i>

                Back to Orders

            </a>

        </div>

        <div class="mt-4">

            @if($product->file)

                <iframe
                    src="{{ asset('storage/'.$product->file) }}"
                    width="100%"
                    height="900"
                    style="border:1px solid #ddd;border-radius:12px;">
                </iframe>

            @else

                <div class="alert alert-warning">

                    Magazine file not available.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection