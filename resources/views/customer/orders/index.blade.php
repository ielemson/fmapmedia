@extends('customer.layout.app')

@section('main-content')

<div class="dashboard-section">

    <div class="dashboard-panel">

        <div class="dashboard-panel-header d-flex justify-content-between align-items-center">

            <h4>My Orders</h4>

            <a href="{{ route('magazines.index') }}"
               class="btn btn-primary">
                <i class="bi bi-journal-richtext"></i>
                Browse Magazines
            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Order No</th>
                        <th>Magazine</th>
                        <th>Vendor</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>

                </thead>

                <tbody>

                @forelse($orders as $order)

                    <tr>

                        <td>{{ $order->order_no }}</td>

                        <td>
                            {{ $order->product->name ?? '-' }}
                        </td>

                        <td>
                            {{ $order->vendor->business_name ?? 'FMAP Media' }}
                        </td>

                        <td>
                            ₦{{ number_format($order->total,2) }}
                        </td>

                        <td>

                            @if($order->payment_status=='paid')

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            @else

                                <span class="badge bg-warning">
                                    {{ ucfirst($order->payment_status) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            <span class="badge bg-info">
                                {{ ucfirst($order->status) }}
                            </span>

                        </td>

                        <td>

                            {{ $order->created_at->format('d M Y') }}

                        </td>

                        <td class="text-end">

                            <a href="{{ route('customer.orders.show',$order) }}"
                               class="btn btn-sm btn-outline-primary">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center py-5">

                            No orders found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $orders->links() }}

        </div>

    </div>

</div>

@endsection