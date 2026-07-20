<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

// use App\Models\User;
// use App\Models\Vendor;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule;
// use App\Notifications\AdminNotification;

use App\Mail\NewVendorRegistrationAdminMail;
use App\Mail\VendorWelcomePendingApprovalMail;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class VendorRegisterController extends Controller
{
    public function create(){
    

    $a = rand(1, 9);
    $b = rand(1, 9);

    session([
        'vendor_captcha' => $a + $b
    ]);

    return view('auth.vendor_register', compact('a', 'b'));

    }

public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
        'business_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:20'],
        'captcha' => ['required', 'numeric'],

        'vendor_type' => [
            'required',
            Rule::in([
                'Individual',
                'Business',
                'Organization',
                'Institution',
                'Student Ambassador',
            ]),
        ],

        'state' => ['required', 'string', 'max:100'],
        'city' => ['required', 'string', 'max:100'],
        'password' => ['required', 'confirmed', 'min:8'],
        'terms' => ['accepted'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Validate Session CAPTCHA
    |--------------------------------------------------------------------------
    */

    if ((int) $validated['captcha'] !== (int) session('vendor_captcha')) {
        return back()
            ->withErrors([
                'captcha' => 'Incorrect security answer.',
            ])
            ->withInput();
    }

    session()->forget('vendor_captcha');

    /*
    |--------------------------------------------------------------------------
    | Create User and Vendor
    |--------------------------------------------------------------------------
    */

    [$user, $vendor] = DB::transaction(function () use ($validated) {

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        $user->assignRole('Vendor');

        $vendor = Vendor::create([
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'phone' => $validated['phone'],
            'vendor_type' => $validated['vendor_type'],
            'state' => $validated['state'],
            'city' => $validated['city'],
            'status' => 'pending',
            'referral_code' => strtoupper('VND-' . uniqid()),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Database Notifications for Admin Users
        |--------------------------------------------------------------------------
        */

        $admins = User::role('Admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(
                new AdminNotification(
                    title: 'New Vendor Registration',
                    message: "{$vendor->business_name} has submitted a vendor application and is awaiting approval.",
                    url: route('admin.users.index'),
                    type: 'warning'
                )
            );
        }

        return [$user, $vendor];
    });

    /*
    |--------------------------------------------------------------------------
    | Send Registration Emails
    |--------------------------------------------------------------------------
    |
    | Emails are sent after the transaction succeeds. A mail-server problem
    | will therefore not prevent the vendor account from being created.
    |
    */

    try {
        Mail::to('info@fmapmedia.com')->send(
            new NewVendorRegistrationAdminMail(
                user: $user,
                vendor: $vendor
            )
        );

        Mail::to($user->email)->send(
            new VendorWelcomePendingApprovalMail(
                user: $user,
                vendor: $vendor
            )
        );
    } catch (Throwable $exception) {
        Log::error('Vendor registration email could not be sent.', [
            'user_id' => $user->id,
            'vendor_id' => $vendor->id,
            'email' => $user->email,
            'error' => $exception->getMessage(),
        ]);
    }

    return redirect()
        ->route('login')
        ->with(
            'success',
            'Your vendor application has been submitted successfully. Please wait for verification and approval.'
        );
}

}