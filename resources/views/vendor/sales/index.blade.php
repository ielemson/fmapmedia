@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Sales</span>

        <h1>My Sales</h1>

        <p>
            View confirmed magazine purchases made through your product referral links.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('dashboard') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>
</div>

<section class="section">
    <h5 class="section-title mb-3">Sales Overview</h5>

    <div class="row g-4">

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">{{ number_format($totalSales ?? 0) }}</h6>
                        <p class="widget-user-location mb-0">
                            <i class="bi bi-bag-check"></i>
                            Total Sales
                        </p>
                    </div>

                    <span class="badge bg-primary">Sales</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($totalSalesAmount ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            <i class="bi bi-currency-exchange"></i>
                            Sales Value
                        </p>
                    </div>

                    <span class="badge bg-success">Value</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-warning text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($totalCommission ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            <i class="bi bi-cash-stack"></i>
                            Commission Earned
                        </p>
                    </div>

                    <span class="badge bg-warning text-dark">Commission</span>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="section mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0">
            <h5 class="mb-0">
                <i class="bi bi-cart-check text-primary me-2"></i>
                Confirmed Sales
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Magazine</th>
                            <th>Customer</th>
                            <th>Sale Amount</th>
                            <th>Commission</th>
                            <th>Date Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <strong>{{ $sale->order_no }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $sale->payment_reference }}
                                    </small>
                                </td>

                                <td>
                                    <strong>{{ $sale->product?->name ?? 'N/A' }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $sale->product?->slug ?? '' }}
                                    </small>
                                </td>

                                <td>
                                    <strong>
                                        {{ $sale->user?->first_name }} {{ $sale->user?->last_name }}
                                    </strong>
                                    <small class="d-block text-muted">
                                        {{ $sale->user?->email }}
                                    </small>
                                </td>

                                <td>
                                    ₦{{ number_format($sale->total ?? 0, 2) }}
                                </td>

                                <td>
                                    <strong class="text-success">
                                        ₦{{ number_format($sale->commission_amount ?? 0, 2) }}
                                    </strong>

                                    <small class="d-block text-muted text-capitalize">
                                        {{ str_replace('_', ' ', $sale->commission_type ?? 'none') }}

                                        @if(($sale->commission_type ?? '') === 'percentage')
                                            — {{ number_format($sale->commission_rate ?? 0, 2) }}%
                                        @elseif(in_array(($sale->commission_type ?? ''), ['fixed', 'target_fixed']))
                                            — ₦{{ number_format($sale->commission_rate ?? 0, 2) }}
                                        @endif
                                    </small>
                                </td>

                                <td>
                                    {{ $sale->paid_at ? $sale->paid_at->format('d M, Y h:i A') : 'N/A' }}
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        Paid
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-cart-x display-5 d-block mb-2"></i>
                                    No confirmed sales yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sales->links() }}
            </div>

        </div>
    </div>
</section>

@endsection