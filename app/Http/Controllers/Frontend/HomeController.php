<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\VendorWithdrawal;

class HomeController extends Controller
{

    public function index()
    {
        $user = auth()->user();
// Admin Dashboard
if ($user->hasRole('Admin')) {

    $totalUsers = User::count();
    $totalAdmins = User::role('Admin')->count();
    $totalVendors = User::role('Vendor')->count();
    $totalCustomers = User::role('Customer')->count();

    $totalProducts = Product::count();

    $totalOrders = Order::count();

    $paidOrders = Order::where('payment_status', 'paid')->count();

    $pendingOrders = Order::where('payment_status', 'unpaid')
        ->orWhere('status', 'pending')
        ->count();

    $totalSales = Order::where('payment_status', 'paid')
        ->sum('total');

        $totalCommission = Order::where('payment_status', 'paid')
        ->sum('commission_amount');

        $pendingWithdrawals = VendorWithdrawal::where('status', 'pending')->count();

        $approvedWithdrawals = VendorWithdrawal::where('status', 'approved')->count();

        $paidWithdrawals = VendorWithdrawal::where('status', 'paid')->count();

        $totalWithdrawalAmount = VendorWithdrawal::where('status', 'paid')
        ->sum('amount');

        $withdrawals = VendorWithdrawal::with([
        'vendor.user',
        'bankAccount',
        ])
        ->latest()
        ->take(10)
        ->get();

    return view('admin.dashboard', compact(
        'user',
        'totalUsers',
        'totalAdmins',
        'totalVendors',
        'totalCustomers',
        'totalProducts',
        'totalOrders',
        'paidOrders',
        'pendingOrders',
        'totalSales',
        'totalCommission',
         'pendingWithdrawals',
        'approvedWithdrawals',
        'paidWithdrawals',
        'totalWithdrawalAmount',
        'withdrawals'
    ));
}
    


// Vendor Dashboard
if ($user->hasRole('Vendor')) {

    $vendor = $user->vendor;

    if (!$vendor) {
        abort(403, 'Vendor profile not found.');
    }

    if ($vendor->status === 'pending') {
        return view('vendor.status.pending', compact('user', 'vendor'));
    }

    if ($vendor->status === 'rejected') {
        return view('vendor.status.rejected', compact('user', 'vendor'));
    }

    if ($vendor->status === 'suspended') {
        return view('vendor.status.suspended', compact('user', 'vendor'));
    }

    if ($vendor->status !== 'approved') {
        abort(403, 'Your vendor account is not approved.');
    }

    $magazines = Product::query()
        ->where('status', 'published')
        ->latest('published_at')
        ->take(6)
        ->get();

    $totalClicks = $vendor->clicks()->count();

    $todayClicks = $vendor->clicks()
        ->whereDate('created_at', today())
        ->count();

    /*
    |--------------------------------------------------------------------------
    | Vendor Sales & Commission From Orders Table
    |--------------------------------------------------------------------------
    */

    $paidOrdersQuery = $vendor->orders()
        ->where('payment_status', 'paid')
        ->where('status', 'completed');

    $totalSales = (clone $paidOrdersQuery)->count();

    $totalSalesAmount = (clone $paidOrdersQuery)->sum('total');

    $totalCommission = (clone $paidOrdersQuery)->sum('commission_amount');

    $pendingCommission = 0;

    $paidCommission = $vendor->total_paid ?? 0;

    $availableBalance = $totalCommission - $paidCommission;

    $recentClicks = $vendor->clicks()
        ->latest()
        ->take(5)
        ->get();

    $recentSales = $vendor->orders()
        ->with(['product', 'user'])
        ->where('payment_status', 'paid')
        ->where('status', 'completed')
        ->latest()
        ->take(5)
        ->get();

    $recentPayouts = $vendor->payouts()
        ->latest()
        ->take(5)
        ->get();

    return view('vendor.dashboard', compact(
        'user',
        'vendor',
        'magazines',
        'totalClicks',
        'todayClicks',
        'totalSales',
        'totalSalesAmount',
        'totalCommission',
        'pendingCommission',
        'paidCommission',
        'availableBalance',
        'recentClicks',
        'recentSales',
        'recentPayouts',
    ));
}

     if ($user->hasRole('Customer')) {

    $orders = Order::with('product')
        ->where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    $totalOrders = Order::where('user_id', $user->id)->count();

    $paidOrders = Order::where('user_id', $user->id)
        ->where('payment_status', 'paid')
        ->count();

    $pendingOrders = Order::where('user_id', $user->id)
        ->where('payment_status', '!=', 'paid')
        ->count();

    $totalSpent = Order::where('user_id', $user->id)
        ->where('payment_status', 'paid')
        ->sum('total');

    return view('customer.dashboard', compact(
        'user',
        'orders',
        'totalOrders',
        'paidOrders',
        'pendingOrders',
        'totalSpent'
    ));
}

        abort(403);
    }
}
