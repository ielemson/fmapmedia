<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorWithdrawal;
class AdminWithdrawalController extends Controller
{

      public function index(Request $request)
    {
        $query = VendorWithdrawal::query()
            ->with([
                'vendor.user',
                'bankAccount',
            ])
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | Filter by status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Search withdrawal requests
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('reference', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery
                            ->where('business_name', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery
                                    ->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('bankAccount', function ($bankQuery) use ($search) {
                        $bankQuery
                            ->where('bank_name', 'like', "%{$search}%")
                            ->orWhere('account_name', 'like', "%{$search}%")
                            ->orWhere('account_number', 'like', "%{$search}%");
                    });
            });
        }

        $withdrawals = $query
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Withdrawal statistics
        |--------------------------------------------------------------------------
        */
        $totalWithdrawals = VendorWithdrawal::count();

        $pendingWithdrawals = VendorWithdrawal::where(
            'status',
            'pending'
        )->count();

        $approvedWithdrawals = VendorWithdrawal::where(
            'status',
            'approved'
        )->count();

        $paidWithdrawals = VendorWithdrawal::where(
            'status',
            'paid'
        )->count();

        $rejectedWithdrawals = VendorWithdrawal::where(
            'status',
            'rejected'
        )->count();

        $totalPaidAmount = VendorWithdrawal::where(
            'status',
            'paid'
        )->sum('amount');

        return view('admin.withdrawals.index', compact(
            'withdrawals',
            'totalWithdrawals',
            'pendingWithdrawals',
            'approvedWithdrawals',
            'paidWithdrawals',
            'rejectedWithdrawals',
            'totalPaidAmount'
        ));
    }

    /**
     * Display a single withdrawal request.
     */
    public function show(VendorWithdrawal $withdrawal)
    {
        $withdrawal->load([
            'vendor.user',
            'bankAccount',
        ]);

        return view(
            'admin.withdrawals.show',
            compact('withdrawal')
        );
    }

//     public function show(VendorWithdrawal $withdrawal)
// {
//     $withdrawal->load([
//         'vendor.user',
//         'bankAccount',
//     ]);

//     return view(
//         'admin.withdrawals.show',
//         compact('withdrawal')
//     );
// }

public function approve(VendorWithdrawal $withdrawal)
{
    if ($withdrawal->status !== 'pending') {
        return back()->with('error', 'Invalid withdrawal status.');
    }

    $withdrawal->update([
        'status' => 'approved',
        'remarks' => request('remarks'),
        'approved_at' => now(),
    ]);

    return back()->with(
        'success',
        'Withdrawal approved successfully.'
    );
}


public function reject(VendorWithdrawal $withdrawal)
{
    if ($withdrawal->status !== 'pending') {
        return back()->with('error', 'Invalid withdrawal status.');
    }

    $withdrawal->update([
        'status' => 'rejected',
        'remarks' => request('remarks'),
    ]);

    return back()->with(
        'success',
        'Withdrawal rejected successfully.'
    );
}

public function markAsPaid(VendorWithdrawal $withdrawal)
{
    if ($withdrawal->status !== 'approved') {
        return back()->with(
            'error',
            'Only approved withdrawals can be paid.'
        );
    }

    $withdrawal->update([
        'status' => 'paid',
        'remarks' => request('remarks'),
        'paid_at' => now(),
    ]);

    $withdrawal->vendor->increment(
        'total_paid',
        $withdrawal->amount
    );

    return back()->with(
        'success',
        'Withdrawal marked as paid successfully.'
    );
}

}
