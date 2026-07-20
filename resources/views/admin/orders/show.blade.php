@extends("admin.layout.app")

@section("title", "Orders")

@section("main-content")
 <div class="main-content page-invoice-list">
        <div class="invoice-shell">

            <div class="invoice-hero">
                <div>
                    <span class="invoice-kicker">Order Receipt</span>
                    <h1>{{ $order->order_no }}</h1>
                    <p>
                        Full order details, payment confirmation, customer information,
                        magazine purchased and vendor commission breakdown.
                    </p>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    Back to Orders
                </a>
            </div>

            <div class="invoice-stat-grid">
                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon primary">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <div>
                        <strong>₦{{ number_format($order->total, 2) }}</strong>
                        <small>Order Total</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </span>
                    <div>
                        <strong>{{ ucfirst($order->payment_status) }}</strong>
                        <small>Payment Status</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon warning">
                        <i class="bi bi-wallet2"></i>
                    </span>
                    <div>
                        <strong>₦{{ number_format($order->commission_amount ?? 0, 2) }}</strong>
                        <small>Vendor Commission</small>
                    </div>
                </div>

                <div class="invoice-stat-card">
                    <span class="invoice-stat-icon danger">
                        <i class="bi bi-clock"></i>
                    </span>
                    <div>
                        <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                        <small>Order Date</small>
                    </div>
                </div>
            </div>

            <section class="invoice-panel">
                <div class="invoice-panel-header">
                    <div>
                        <span class="invoice-kicker">Details</span>
                        <h2>Order Information</h2>
                    </div>

                    <div class="invoice-toolbar">
                        <a href="javascript:;" class="btn btn-outline-secondary">
                            <i class="bi bi-printer"></i>
                            Print
                        </a>
                    </div>
                </div>

                <div class="row g-4 mt-2">

                    <div class="col-lg-8">
                        <div class="invoice-table-wrap">
                            <table class="invoice-table">
                                <tbody>
                                    <tr>
                                        <th>Order Number</th>
                                        <td><strong>{{ $order->order_no }}</strong></td>
                                    </tr>

                                    <tr>
                                        <th>Payment Reference</th>
                                        <td>{{ $order->payment_reference ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Gateway Reference</th>
                                        <td>{{ $order->gateway_reference ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Transaction ID</th>
                                        <td>{{ $order->transaction_id ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Payment Gateway</th>
                                        <td>{{ ucfirst($order->payment_gateway ?? 'N/A') }}</td>
                                    </tr>

                                    <tr>
                                        <th>Order Status</th>
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
                                    </tr>

                                    <tr>
                                        <th>Payment Status</th>
                                        <td>
                                            @if($order->payment_status === 'paid')
                                                <span class="invoice-status paid">Paid</span>
                                            @elseif($order->payment_status === 'refunded')
                                                <span class="invoice-status draft">Refunded</span>
                                            @else
                                                <span class="invoice-status pending">Unpaid</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Paid At</th>
                                        <td>{{ $order->paid_at?->format('M d, Y h:i A') ?? 'Not Paid Yet' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Processor Response</th>
                                        <td>{{ $order->processor_response ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-table-wrap mt-4">
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Magazine</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{ $order->product?->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small>{{ $order->product?->slug ?? '' }}</small>
                                        </td>

                                        <td>{{ $order->qty }}</td>

                                        <td>₦{{ number_format($order->unit_price, 2) }}</td>

                                        <td>
                                            <strong>₦{{ number_format($order->subtotal, 2) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-4">

                        <div class="invoice-stat-card mb-3 d-block">
                            <small>Customer</small>
                            <h5 class="mt-2 mb-1">
                                {{ $order->user?->name ?? 'Guest Customer' }}
                            </h5>
                            <p class="mb-0 text-muted">
                                {{ $order->user?->email ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="invoice-stat-card mb-3 d-block">
                            <small>Vendor Referral</small>
                            <h5 class="mt-2 mb-1">
                                {{ $order->vendor?->business_name ?? 'Direct Sale' }}
                            </h5>
                            <p class="mb-0 text-muted">
                                Referral: {{ $order->referral_slug ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="invoice-stat-card mb-3 d-block">
                            <small>Commission</small>

                            <div class="d-flex justify-content-between mt-3">
                                <span>Rate</span>
                                <strong>{{ $order->commission_rate ?? 0 }}%</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <span>Amount</span>
                                <strong>₦{{ number_format($order->commission_amount ?? 0, 2) }}</strong>
                            </div>
                        </div>

                        <div class="invoice-stat-card d-block">
                            <small>Payment Summary</small>

                            <div class="d-flex justify-content-between mt-3">
                                <span>Subtotal</span>
                                <strong>₦{{ number_format($order->subtotal, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <span>Discount</span>
                                <strong>₦{{ number_format($order->discount ?? 0, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <span>Gateway Fee</span>
                                <strong>₦{{ number_format($order->gateway_fee ?? 0, 2) }}</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <span>Total</span>
                                <strong class="fs-5">
                                    ₦{{ number_format($order->total, 2) }}
                                </strong>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

        </div>
@endsection