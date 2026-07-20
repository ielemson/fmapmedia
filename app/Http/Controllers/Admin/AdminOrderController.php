<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // public function index(Request $request)
    // {
    //     $orders = Order::with(['user', 'product', 'vendor.user'])
    //         ->latest()
    //         ->paginate(20);

    //     return view('admin.orders.index', compact('orders'));
    // }

    public function index(Request $request)
{
    $orders = Order::with(['user', 'product', 'vendor'])
        ->when($request->q, function ($query) use ($request) {
            $query->where('order_no', 'like', '%' . $request->q . '%')
                ->orWhere('payment_reference', 'like', '%' . $request->q . '%');
        })
        ->when($request->status, function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->latest()
        ->paginate(20)
        ->withQueryString();

    $totalOrders = Order::count();

    $pendingOrders = Order::where('status', 'pending')->count();

    $totalSales = Order::where('payment_status', 'paid')->sum('total');

    $totalCommission = Order::where('payment_status', 'paid')->sum('commission_amount');

    return view('admin.orders.index', compact(
        'orders',
        'totalOrders',
        'pendingOrders',
        'totalSales',
        'totalCommission'
    ));
}

    public function show(Order $order)
    {
        $order->load(['user', 'product', 'vendor.user']);

        return view('admin.orders.show', compact('order'));
    }
}
