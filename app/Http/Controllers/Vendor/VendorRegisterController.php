<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\NewVendorRegistrationAdminMail;
use App\Mail\VendorWelcomePendingApprovalMail;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\AdminNotification;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class VendorRegisterController extends Controller
{
    public function create()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);

        session([
            'vendor_captcha' => $a + $b,
        ]);

        return view('auth.vendor_register', compact('a', 'b'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'business_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'phone' => ['required', 'string', 'max:20'],
            'captcha' => ['required', 'integer'],

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

            'cf-turnstile-response' => [
                'required',
                'string',
                'max:2048',
            ],
        ], [
            'cf-turnstile-response.required' => 'Please complete the security verification.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Session Maths CAPTCHA
        |--------------------------------------------------------------------------
        */

        $expectedAnswer = $request->session()->get('vendor_captcha');

        if (
            $expectedAnswer === null ||
            (int) $validated['captcha'] !== (int) $expectedAnswer
        ) {
            throw ValidationException::withMessages([
                'captcha' => 'Incorrect or expired security answer. Please try again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Cloudflare Turnstile
        |--------------------------------------------------------------------------
        */

        $secretKey = config('services.turnstile.secret_key');
        $expectedHostname = config('services.turnstile.hostname');

        if (
            ! is_string($secretKey) || trim($secretKey) === '' ||
            ! is_string($expectedHostname) || trim($expectedHostname) === ''
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Registration is temporarily unavailable. Please try again later.',
            ]);
        }

        $verification = [];

        try {
            $response = Http::asForm()
                ->connectTimeout(5)
                ->timeout(10)
                ->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    [
                        'secret' => $secretKey,
                        'response' => $validated['cf-turnstile-response'],
                    ]
                );

            if ($response->successful()) {
                $result = $response->json();

                if (is_array($result)) {
                    $verification = $result;
                }
            }
        } catch (ConnectionException $exception) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Security verification is temporarily unavailable. Please refresh the page and try again.',
            ]);
        }

        if (
            ($verification['success'] ?? false) !== true ||
            ($verification['action'] ?? '') !== 'vendor_register' ||
            ($verification['hostname'] ?? '') !== $expectedHostname
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Security verification failed. Please refresh the page and try again.',
            ]);
        }

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
                'referral_code' => strtoupper('VND-'.uniqid()),
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

        // Clear the maths challenge after successful account creation.
        $request->session()->forget('vendor_captcha');

        /*
        |--------------------------------------------------------------------------
        | Send Registration Emails
        |--------------------------------------------------------------------------
        |
        | Emails are sent after the transaction succeeds.
        | Mail failures do not prevent account creation.
        |
        */

        try {
            Mail::to('info@fmapmedia.com')->send(
                new NewVendorRegistrationAdminMail(
                    user: $user,
                    vendor: $vendor
                )
            );
        } catch (Throwable $exception) {
            Log::error('Vendor registration admin email could not be sent.', [
                'user_id' => $user->id,
                'vendor_id' => $vendor->id,
                'error' => $exception->getMessage(),
            ]);
        }

        try {
            Mail::to($user->email)->send(
                new VendorWelcomePendingApprovalMail(
                    user: $user,
                    vendor: $vendor
                )
            );
        } catch (Throwable $exception) {
            Log::error('Vendor welcome email could not be sent.', [
                'user_id' => $user->id,
                'vendor_id' => $vendor->id,
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
