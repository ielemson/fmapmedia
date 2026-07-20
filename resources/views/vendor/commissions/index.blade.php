@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Earnings</span>

        <h1>My Commissions</h1>

        <p>
            Track commissions earned from confirmed magazine sales through your referral links.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('vendor.sales.index') }}" class="btn btn-primary">
            <i class="bi bi-cart-check"></i>
            View Sales
        </a>

        <a href="{{ route('dashboard') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>
    </div>
</div>

<section class="section">
    <h5 class="section-title mb-3">Commission Overview</h5>

    <div class="row g-4">

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format($totalCommissionOrders ?? 0) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Commission Sales
                        </p>
                    </div>

                    <span class="badge bg-primary">Orders</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($totalCommission ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Total Commission
                        </p>
                    </div>

                    <span class="badge bg-success">Earned</span>
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
                            ₦{{ number_format($availableBalance ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Available Balance
                        </p>
                    </div>

                    <span class="badge bg-warning text-dark">Balance</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-info text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank2 fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($paidCommission ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Paid Commission
                        </p>
                    </div>

                    <span class="badge bg-info">Paid</span>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="section mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0">
            <h5 class="mb-0">
                <i class="bi bi-cash-stack text-success me-2"></i>
                Commission Records
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
                            <th>Commission Type</th>
                            <th>Rate</th>
                            <th>Commission</th>
                            <th>Date Paid</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commissionOrders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_no }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $order->payment_reference }}
                                    </small>
                                </td>

                                <td>
                                    <strong>{{ $order->product?->name ?? 'N/A' }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $order->product?->slug ?? '' }}
                                    </small>
                                </td>

                                <td>
                                    <strong>
                                        {{ $order->user?->first_name }} {{ $order->user?->last_name }}
                                    </strong>
                                    <small class="d-block text-muted">
                                        {{ $order->user?->email }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark text-capitalize">
                                        {{ str_replace('_', ' ', $order->commission_type ?? 'none') }}
                                    </span>
                                </td>

                                <td>
                                    @if(($order->commission_type ?? '') === 'percentage')
                                        {{ number_format($order->commission_rate ?? 0, 2) }}%
                                    @elseif(in_array(($order->commission_type ?? ''), ['fixed', 'target_fixed']))
                                        ₦{{ number_format($order->commission_rate ?? 0, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    <strong class="text-success">
                                        ₦{{ number_format($order->commission_amount ?? 0, 2) }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $order->paid_at ? $order->paid_at->format('d M, Y h:i A') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-wallet-x display-5 d-block mb-2"></i>
                                    No commission record yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $commissionOrders->links() }}
            </div>

        </div>
    </div>
</section>

@endsection