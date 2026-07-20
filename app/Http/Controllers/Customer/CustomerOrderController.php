<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Customer Orders
     */
    public function index(Request $request)
    {
        $orders = Order::with([
                'product',
                'vendor',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * View Single Order
     */
    public function show(Order $order)
    {
        abort_if($order->user_id != auth()->id(), 403);

        $order->load([
            'product',
            'vendor',
        ]);

        return view('customer.orders.show', compact('order'));
    }
}
