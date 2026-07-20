<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorCommissionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Vendor profile not found.');
        }

        if ($vendor->status !== 'approved') {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Your vendor account is not approved.');
        }

        $commissionOrders = Order::with(['product', 'user'])
            ->where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->where('commission_amount', '>', 0)
            ->latest()
            ->paginate(10);

        $totalCommission = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->sum('commission_amount');

        $paidCommission = $vendor->total_paid ?? 0;

        $availableBalance = $totalCommission - $paidCommission;

        $totalCommissionOrders = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->where('commission_amount', '>', 0)
            ->count();

        return view('vendor.commissions.index', compact(
            'user',
            'vendor',
            'commissionOrders',
            'totalCommission',
            'paidCommission',
            'availableBalance',
            'totalCommissionOrders'
        ));
    }
}