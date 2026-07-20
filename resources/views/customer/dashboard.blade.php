@extends("customer.layout.app")

@section("main-content")
<div class="dashboard-hero">

    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Customer Dashboard</span>

        <h1>Welcome back, {{ $user->name }}</h1>

        <p>
            Access your purchased FMAP Media magazines, track your orders, and manage your
            digital reading experience from your customer dashboard.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('customer.magazines.index') }}" class="btn btn-primary">
            <i class="bi bi-journal-richtext"></i>
            Browse Magazines
        </a>

        <a href="{{ route('customer.orders.index') }}" class="btn btn-light">
            <i class="bi bi-receipt"></i>
            My Orders
        </a>
    </div>

    <div class="dashboard-kpi-grid">

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon primary">
                <i class="bi bi-bag-check-fill"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Total Orders</span>
                <strong>{{ number_format($totalOrders) }}</strong>
                <small>
                    <i class="bi bi-cart-check"></i>
                    All magazine purchases
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon success">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Paid Orders</span>
                <strong>{{ number_format($paidOrders) }}</strong>
                <small>
                    <i class="bi bi-cloud-download"></i>
                    Ready to read/download
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon warning">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Pending Orders</span>
                <strong>{{ number_format($pendingOrders) }}</strong>
                <small>
                    <i class="bi bi-credit-card"></i>
                    Awaiting payment confirmation
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon info">
                <i class="bi bi-wallet2"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Total Spent</span>
                <strong>₦{{ number_format($totalSpent, 2) }}</strong>
                <small>
                    <i class="bi bi-cash-stack"></i>
                    Successful payments
                </small>
            </div>
        </div>

    </div>
</div>


<div class="dashboard-section mt-4">
    <div class="dashboard-panel">
        <div class="dashboard-panel-header d-flex justify-content-between align-items-center">
            <h5>Recent Magazine Orders</h5>

            <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-primary">
                View All
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Magazine</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_no }}</td>

                            <td>
                                <strong>{{ $order->product->name ?? 'Magazine unavailable' }}</strong>
                            </td>

                            <td>₦{{ number_format($order->total, 2) }}</td>

                            <td>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td class="text-end">
                                @if($order->payment_status === 'paid' && $order->product)
                                    <a href="{{ route('customer.magazines.show', $order->product->slug) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-book"></i>
                                        Read
                                    </a>
                                @else
                                    <a href="{{ route('customer.orders.show', $order->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                You have not purchased any magazine yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection