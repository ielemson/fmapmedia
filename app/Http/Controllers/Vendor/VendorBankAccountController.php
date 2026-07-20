<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorBankAccount;
use Illuminate\Http\Request;

class VendorBankAccountController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $accounts = VendorBankAccount::where('vendor_id', $vendor->id)
            ->latest()
            ->get();

        return view('vendor.bank_accounts.index', compact(
            'vendor',
            'accounts'
        ));
    }

    public function create()
    {
        return view('vendor.bank_accounts.create');
    }

    public function store(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'digits_between:10,15'],
            'bank_code' => ['nullable', 'string', 'max:20'],
        ]);

        if ($request->boolean('is_default')) {
            VendorBankAccount::where('vendor_id', $vendor->id)
                ->update([
                    'is_default' => false
                ]);
        }

        VendorBankAccount::create([
            'vendor_id' => $vendor->id,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_code' => $request->bank_code,
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()
            ->route('vendor.bank-accounts.index')
            ->with('success', 'Bank account added successfully.');
    }

    public function edit(VendorBankAccount $bankAccount)
    {
        abort_if(
            $bankAccount->vendor_id !== auth()->user()->vendor->id,
            403
        );

        return view(
            'vendor.bank_accounts.edit',
            compact('bankAccount')
        );
    }

    public function update(Request $request, VendorBankAccount $bankAccount)
    {
        abort_if(
            $bankAccount->vendor_id !== auth()->user()->vendor->id,
            403
        );

        $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'digits_between:10,15'],
            'bank_code' => ['nullable', 'string', 'max:20'],
        ]);

        if ($request->boolean('is_default')) {
            VendorBankAccount::where(
                'vendor_id',
                auth()->user()->vendor->id
            )->update([
                'is_default' => false
            ]);
        }

        $bankAccount->update([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_code' => $request->bank_code,
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()
            ->route('vendor.bank-accounts.index')
            ->with('success', 'Bank account updated successfully.');
    }

    public function destroy(VendorBankAccount $bankAccount)
    {
        abort_if(
            $bankAccount->vendor_id !== auth()->user()->vendor->id,
            403
        );

        $bankAccount->delete();

        return redirect()
            ->route('vendor.bank-accounts.index')
            ->with('success', 'Bank account deleted successfully.');
    }
}