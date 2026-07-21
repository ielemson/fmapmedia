<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorImpersonationController extends Controller
{
    
public function loginAs(Request $request, Vendor $vendor): RedirectResponse
{
    abort_if(
        $request->session()->has('impersonator_id'),
        403,
        'You are already impersonating a vendor. Return to the administrator account first.'
    );

    $admin = Auth::user();

    abort_unless(
        $admin && $admin->hasRole('Admin'),
        403,
        'Only administrators can impersonate vendors.'
    );

    abort_unless(
        $vendor->user,
        404,
        'This vendor does not have a linked user account.'
    );

    abort_unless(
        $vendor->status === 'approved',
        422,
        'Only approved vendors can be accessed.'
    );

    $request->session()->put([
        'impersonator_id' => $admin->id,
        'impersonated_vendor_id' => $vendor->id,
        'impersonation_started_at' => now()->toDateTimeString(),
    ]);

    Auth::login($vendor->user);

    $request->session()->regenerate();

    return redirect()
        ->route('dashboard')
        ->with(
            'success',
            "You are now logged in as {$vendor->user->name}."
        );
}
    /**
     * Leave the vendor account and return to the administrator.
     */
    public function leave(Request $request): RedirectResponse
    {
        $adminId = session('impersonator_id');

        abort_unless($adminId, 403, 'No active impersonation session was found.');

        $admin = \App\Models\User::query()
            ->whereKey($adminId)
            ->firstOrFail();

        abort_unless(
            $admin->hasRole('Admin'),
            403,
            'The original administrator account is invalid.'
        );

        session()->forget([
            'impersonator_id',
            'impersonated_vendor_id',
            'impersonation_started_at',
        ]);

        Auth::login($admin);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'You have returned to your administrator account.');
    }
}