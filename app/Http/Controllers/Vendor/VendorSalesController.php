<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorSalesController extends Controller
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

        $sales = Order::with(['product', 'user'])
            ->where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        $totalSales = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->count();

        $totalSalesAmount = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->sum('total');

        $totalCommission = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->sum('commission_amount');

        return view('vendor.sales.index', compact(
            'user',
            'vendor',
            'sales',
            'totalSales',
            'totalSalesAmount',
            'totalCommission'
        ));
    }
}