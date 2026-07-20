<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VendorBankAccount;
use App\Models\VendorWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\AdminNotification;


class VendorWithdrawalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Vendor profile not found.');
        }

        if ($vendor->status !== 'approved') {
            return redirect()->route('dashboard')
                ->with('error', 'Your vendor account is not approved.');
        }

        $totalCommission = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->sum('commission_amount');

        $paidWithdrawals = VendorWithdrawal::where('vendor_id', $vendor->id)
            ->where('status', 'paid')
            ->sum('amount');

        $pendingWithdrawals = VendorWithdrawal::where('vendor_id', $vendor->id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        $availableBalance = $totalCommission - $paidWithdrawals - $pendingWithdrawals;

        $bankAccounts = VendorBankAccount::where('vendor_id', $vendor->id)
            ->latest()
            ->get();

        $withdrawals = VendorWithdrawal::with('bankAccount')
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        return view('vendor.withdrawals.index', compact(
            'user',
            'vendor',
            'totalCommission',
            'paidWithdrawals',
            'pendingWithdrawals',
            'availableBalance',
            'bankAccounts',
            'withdrawals'
        ));
    }

   
    public function store(Request $request)
{
    $user = auth()->user();
    $vendor = $user->vendor;

    if (!$vendor) {
        abort(403, 'Vendor profile not found.');
    }

    $request->validate([
        'vendor_bank_account_id' => ['required', 'exists:vendor_bank_accounts,id'],
        'amount' => ['required', 'numeric', 'min:1000'],
    ]);

    $bankAccount = VendorBankAccount::where('id', $request->vendor_bank_account_id)
        ->where('vendor_id', $vendor->id)
        ->firstOrFail();

    $totalCommission = Order::where('vendor_id', $vendor->id)
        ->where('payment_status', 'paid')
        ->where('status', 'completed')
        ->sum('commission_amount');

    $paidWithdrawals = VendorWithdrawal::where('vendor_id', $vendor->id)
        ->where('status', 'paid')
        ->sum('amount');

    $pendingWithdrawals = VendorWithdrawal::where('vendor_id', $vendor->id)
        ->whereIn('status', ['pending', 'approved'])
        ->sum('amount');

    $availableBalance = $totalCommission - $paidWithdrawals - $pendingWithdrawals;

    if ($request->amount > $availableBalance) {
        return back()
            ->withInput()
            ->with('error', 'Withdrawal amount exceeds your available balance.');
    }

    $withdrawal = VendorWithdrawal::create([
        'vendor_id' => $vendor->id,
        'vendor_bank_account_id' => $bankAccount->id,
        'amount' => $request->amount,
        'reference' => 'WDR-' . strtoupper(Str::random(10)),
        'status' => 'pending',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Notify Admins
    |--------------------------------------------------------------------------
    */

    $admins = User::role('Admin')->get();

    foreach ($admins as $admin) {
        $admin->notify(
            new AdminNotification(
                title: 'New Withdrawal Request',
                message: "{$vendor->business_name} requested withdrawal of ₦" .
                    number_format($withdrawal->amount, 2),
                url: route('admin.withdrawals.show', $withdrawal->id),
                type: 'warning'
            )
        );
    }

    return redirect()
        ->route('vendor.withdrawals.index')
        ->with('success', 'Withdrawal request submitted successfully.');
}

}