@extends('customer.layout.app')

@section('main-content')

<div class="dashboard-section">

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <h4>Order Details</h4>

        </div>

        <table class="table">

            <tr>
                <th>Order Number</th>
                <td>{{ $order->order_no }}</td>
            </tr>

            <tr>
                <th>Magazine</th>
                <td>{{ $order->product->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Vendor</th>
                <td>{{ $order->vendor->business_name ?? 'FMAP Media' }}</td>
            </tr>

            <tr>
                <th>Quantity</th>
                <td>{{ $order->qty }}</td>
            </tr>

            <tr>
                <th>Total Paid</th>
                <td>₦{{ number_format($order->total,2) }}</td>
            </tr>

            <tr>
                <th>Payment Status</th>
                <td>{{ ucfirst($order->payment_status) }}</td>
            </tr>

            <tr>
                <th>Order Status</th>
                <td>{{ ucfirst($order->status) }}</td>
            </tr>

            <tr>
                <th>Purchased</th>
                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
            </tr>

        </table>

        @if($order->payment_status=='paid')

            <a href="{{ route('customer.magazines.show',$order->product->slug) }}"
               class="btn btn-primary">

                <i class="bi bi-book"></i>

                Read Magazine

            </a>

        @endif

    </div>

</div>

@endsection