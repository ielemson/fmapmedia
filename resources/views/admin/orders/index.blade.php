@extends("admin.layout.app")

@section("title", "Orders")

@section("main-content")
 <div class="main-content page-invoice-list">
        <div class="invoice-shell">

            <div class="invoice-hero">
                <div>
                    <span class="invoice-kicker">Order Desk</span>
                    <h1>Orders</h1>
                    <p>
                        Track magazine purchases, payment status, customer orders,
                        vendor referrals and commission activity.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </div>

            <div class="invoice-stat-grid">
                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon primary">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <div>
                        <strong>{{ number_format($totalOrders ?? $orders->total()) }}</strong>
                        <small>Total Orders</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </span>
                    <div>
                        <strong>₦{{ number_format($totalSales ?? 0, 2) }}</strong>
                        <small>Paid Sales</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon warning">
                        <i class="bi bi-clock"></i>
                    </span>
                    <div>
                        <strong>{{ number_format($pendingOrders ?? 0) }}</strong>
                        <small>Pending Orders</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon danger">
                        <i class="bi bi-wallet2"></i>
                    </span>
                    <div>
                        <strong>₦{{ number_format($totalCommission ?? 0, 2) }}</strong>
                        <small>Vendor Commission</small>
                    </div>
                </div>
            </div>

            <section class="invoice-panel">
                <div class="invoice-panel-header">
                    <div>
                        <span class="invoice-kicker">Ledger</span>
                        <h2>All Orders</h2>
                    </div>

                    <form method="GET" action="{{ route('admin.orders.index') }}" class="invoice-toolbar">
                        <div class="invoice-search">
                            <i class="bi bi-search"></i>
                            <input type="search"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="Search orders...">
                        </div>

                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="paid" @selected(request('status') == 'paid')>Paid</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                            <option value="failed" @selected(request('status') == 'failed')>Failed</option>
                            <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                        </select>
                    </form>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Magazine</th>
                                <th>Vendor</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="invoice-id">
                                            #{{ $order->order_no }}
                                        </a>
                                        <br>
                                        <small>{{ $order->payment_reference ?? 'N/A' }}</small>
                                    </td>

                                    <td>
                                        <div class="invoice-client">
                                            <span>
                                                {{ strtoupper(substr($order->user?->name ?? 'C', 0, 2)) }}
                                            </span>
                                            <strong>{{ $order->user?->name ?? 'Guest Customer' }}</strong>
                                        </div>
                                    </td>

                                    <td>
                                        <strong>{{ $order->product?->name ?? 'N/A' }}</strong>
                                    </td>

                                    <td>
                                        {{ $order->vendor?->business_name ?? 'Direct Sale' }}
                                    </td>

                                    <td>
                                        <strong>₦{{ number_format($order->total, 2) }}</strong>
                                    </td>

                                    <td>
                                        @if($order->payment_status === 'paid')
                                            <span class="invoice-status paid">Paid</span>
                                        @elseif($order->payment_status === 'refunded')
                                            <span class="invoice-status draft">Refunded</span>
                                        @else
                                            <span class="invoice-status pending">Unpaid</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($order->status === 'paid')
                                            <span class="invoice-status paid">Paid</span>
                                        @elseif($order->status === 'pending')
                                            <span class="invoice-status pending">Pending</span>
                                        @elseif($order->status === 'failed')
                                            <span class="invoice-status overdue">Failed</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="invoice-status draft">Cancelled</span>
                                        @else
                                            <span class="invoice-status draft">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="dropdown"
                                                    title="Order actions">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.orders.show', $order->id) }}">
                                                        <i class="bi bi-eye me-2"></i>
                                                        View
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i class="bi bi-receipt me-2"></i>
                                                        Receipt
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </section>

        </div>
 </div>
 

@endsection