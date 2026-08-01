<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\VendorCommission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(string $slug)
{
    $product = Product::query()
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Check vendor referral session
    |--------------------------------------------------------------------------
    */

    $vendorReferral = session('vendor_referral');
    // dd($vendorReferral);
    $hasActiveReferral =
        is_array($vendorReferral)
        && !empty($vendorReferral['vendor_id'])
        && !empty($vendorReferral['vendor_slug'])
        && (int) ($vendorReferral['product_id'] ?? 0) === (int) $product->id
        && ($vendorReferral['product_slug'] ?? null) === $product->slug;

    if (!$hasActiveReferral) {
        $vendorReferral = null;
    }

    $relatedProducts = Product::query()
        ->where('status', 'published')
        ->whereKeyNot($product->id)
        ->latest()
        ->limit(4)
        ->get();

    $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

    return view('frontend.pages.checkout', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'services' => $services,
        'vendorReferral' => $vendorReferral,
        'hasActiveReferral' => $hasActiveReferral,
    ]);
}

    // public function store(Request $request, $slug)
    // {
    //     $product = Product::where('slug', $slug)
    //         ->where('status', 'published')
    //         ->firstOrFail();

    //     $request->validate([
    //         'first_name' => ['required', 'string', 'max:100'],
    //         'last_name'  => ['required', 'string', 'max:100'],
    //         'email'      => ['required', 'email', 'max:150'],
    //         'phone'      => ['required', 'string', 'max:30'],
    //         'terms'      => ['required'],
    //     ]);

    //     $user = Auth::user();

    //     if (!$user) {
    //         $existingUser = User::where('email', $request->email)->first();

    //         if ($existingUser) {
    //             return redirect()
    //                 ->route('login', [
    //                     'email' => $request->email,
    //                     'checkout' => route('checkout.show', $product->slug),
    //                 ])
    //                 ->with('info', 'An account already exists with this email. Please login to continue your purchase.');
    //         }

    //         $password = Str::random(12);

    //         $user = User::create([
    //             'first_name' => $request->first_name,
    //             'last_name'  => $request->last_name,
    //             'email'      => $request->email,
    //             'phone'      => $request->phone,
    //             'password'   => Hash::make($password),
    //             'status'     => 'active',
    //         ]);

    //         if (method_exists($user, 'assignRole')) {
    //             $user->assignRole('Customer');
    //         }

    //         Auth::login($user);
    //     }

    //     $referral = session('vendor_referral');

    //     $vendor = null;
    //     $referralSlug = null;
    //     $commissionType = $product->commission_type ?? 'none';
    //     $commissionRate = $product->commission_value ?? 0;

    //     if (
    //         $referral &&
    //         isset($referral['vendor_id'], $referral['vendor_slug'], $referral['product_id']) &&
    //         (int) $referral['product_id'] === (int) $product->id
    //     ) {
    //         $vendor = Vendor::where('id', $referral['vendor_id'])
    //             ->where('status', 'approved')
    //             ->first();

    //         if ($vendor) {
    //             $referralSlug = $referral['vendor_slug'];
    //         }
    //     }

    //     $reference = 'FMAP-' . strtoupper(Str::random(16));

    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'product_id' => $product->id,
    //         'vendor_id' => $vendor?->id,
    //         'order_no' => 'ORD-' . strtoupper(Str::random(10)),
    //         'qty' => 1,
    //         'unit_price' => $product->price,
    //         'subtotal' => $product->price,
    //         'discount' => 0,
    //         'total' => $product->price,
    //         'referral_slug' => $referralSlug,
    //         'commission_type' => $vendor ? $commissionType : 'none',
    //         'commission_rate' => $vendor ? $commissionRate : 0,
    //         'commission_amount' => 0,
    //         'payment_reference' => $reference,
    //         'payment_gateway' => 'paystack',
    //         'status' => 'pending',
    //         'payment_status' => 'unpaid',
    //         'competition_entry' => $product->competition_status === 'active' ? 1 : 0,

    //     ]);

    //     $response = Http::withToken(config('services.paystack.secret_key'))
    //         ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
    //             'email' => $user->email,
    //             'amount' => $order->total * 100,
    //             'reference' => $reference,
    //             'callback_url' => route('checkout.paystack.callback'),
    //             'metadata' => [
    //                 'order_id' => $order->id,
    //                 'order_no' => $order->order_no,
    //                 'product_id' => $product->id,
    //                 'user_id' => $user->id,
    //             ],
    //         ]);

    //     if (!$response->successful() || !$response->json('status')) {
    //         $order->update([
    //             'status' => 'failed',
    //             'payment_status' => 'failed',
    //             'processor_response' => $response->body(),
    //         ]);

    //         return back()->with('error', 'Unable to initialize payment. Please try again.');
    //     }

    //     return redirect($response->json('data.authorization_url'));
    // }

    public function store(Request $request, string $slug)
{
    $product = Product::query()
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name'  => ['required', 'string', 'max:100'],
        'email'      => ['required', 'email', 'max:150'],
        'phone'      => ['required', 'string', 'max:30'],
        'vendor_code' => ['nullable', 'string', 'max:100'],
        'terms'      => ['accepted'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Resolve the customer
    |--------------------------------------------------------------------------
    */

    $user = Auth::user();

    if (!$user) {
        $existingUser = User::query()
            ->where('email', $validated['email'])
            ->first();

        if ($existingUser) {
            return redirect()
                ->route('login', [
                    'email' => $validated['email'],
                    'checkout' => route('checkout.show', $product->slug),
                ])
                ->with(
                    'info',
                    'An account already exists with this email. Please login to continue your purchase.'
                );
        }

        $password = Str::random(12);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($password),
            'status'     => 'active',
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('Customer');
        }

        Auth::login($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve vendor referral
    |--------------------------------------------------------------------------
    |
    | Priority:
    | 1. Active referral stored in session
    | 2. Vendor code manually entered on the checkout page
    |
    */

    $referral = session('vendor_referral');

    $vendor = null;
    $referralSlug = null;
    $referralSource = null;

    /*
    |--------------------------------------------------------------------------
    | First: Check the referral session
    |--------------------------------------------------------------------------
    */

    if (
        is_array($referral) &&
        !empty($referral['vendor_id']) &&
        !empty($referral['vendor_slug']) &&
        !empty($referral['product_id']) &&
        (int) $referral['product_id'] === (int) $product->id
    ) {
        $vendor = Vendor::query()
            ->whereKey($referral['vendor_id'])
            ->where('status', 'approved')
            ->first();

        if ($vendor) {
            $referralSlug = $vendor->referral_slug;
            $referralSource = 'referral_link';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Second: Check manually entered vendor code
    |--------------------------------------------------------------------------
    |
    | This only runs when there is no valid active referral session.
    |
    */

    $enteredVendorCode = trim($validated['vendor_code'] ?? '');

    if (!$vendor && $enteredVendorCode !== '') {
        $vendor = Vendor::query()
            ->where('vendor_code', $enteredVendorCode)
            ->where('status', 'approved')
            ->first();

        if (!$vendor) {
            throw ValidationException::withMessages([
                'vendor_code' => 'The vendor code entered is invalid or the vendor is not active.',
            ]);
        }

        $referralSlug = $vendor->referral_slug;
        $referralSource = 'vendor_code';

        /*
         * Store the accepted manual referral in session so it remains
         * available if the customer returns from the payment gateway.
         */
        session([
            'vendor_referral' => [
                'vendor_id' => $vendor->id,
                'vendor_slug' => $vendor->referral_slug,
                'vendor_code' => $vendor->vendor_code,
                'product_id' => $product->id,
                'product_slug' => $product->slug,
                'source' => 'vendor_code',
                'clicked_at' => now()->toDateTimeString(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Commission settings
    |--------------------------------------------------------------------------
    */

    $commissionType = $vendor
        ? ($product->commission_type ?? 'none')
        : 'none';

    $commissionRate = $vendor
        ? ($product->commission_value ?? 0)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Create pending order
    |--------------------------------------------------------------------------
    */

    $reference = 'FMAP-' . strtoupper(Str::random(16));

    $order = Order::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'vendor_id' => $vendor?->id,

        'order_no' => 'ORD-' . strtoupper(Str::random(10)),

        'qty' => 1,
        'unit_price' => $product->price,
        'subtotal' => $product->price,
        'discount' => 0,
        'total' => $product->price,

        'referral_slug' => $referralSlug,

        'commission_type' => $commissionType,
        'commission_rate' => $commissionRate,
        'commission_amount' => 0,

        'payment_reference' => $reference,
        'payment_gateway' => 'paystack',

        'status' => 'pending',
        'payment_status' => 'unpaid',

        'competition_entry' =>
            $product->competition_status === 'active' ? 1 : 0,

        'meta' => [
            'referral_source' => $referralSource,
            'vendor_code' => $vendor?->vendor_code,
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Initialize Paystack payment
    |--------------------------------------------------------------------------
    */

    $response = Http::withToken(
        config('services.paystack.secret_key')
    )->post(
        config('services.paystack.payment_url') . '/transaction/initialize',
        [
            'email' => $user->email,
            'amount' => (int) round($order->total * 100),
            'reference' => $reference,
            'callback_url' => route('checkout.paystack.callback'),

            'metadata' => [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'product_id' => $product->id,
                'user_id' => $user->id,
                'vendor_id' => $vendor?->id,
                'vendor_code' => $vendor?->vendor_code,
                'referral_slug' => $referralSlug,
                'referral_source' => $referralSource,
            ],
        ]
    );

    if (!$response->successful() || !$response->json('status')) {
        $order->update([
            'status' => 'failed',
            'payment_status' => 'failed',
            'processor_response' => $response->body(),
        ]);

        return back()
            ->withInput()
            ->with(
                'error',
                'Unable to initialize payment. Please try again.'
            );
    }

    return redirect()->away(
        $response->json('data.authorization_url')
    );
}

    public function paystackCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('customer.library')
                ->with('error', 'Invalid payment reference.');
        }

        $order = Order::where('payment_reference', $reference)->firstOrFail();

        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.payment_url') . '/transaction/verify/' . $reference);

        if (!$response->successful() || !$response->json('status')) {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
                'processor_response' => $response->body(),
            ]);

            return redirect()->route('customer.library')
                ->with('error', 'Payment verification failed.');
        }

        $data = $response->json('data');

        if ($data['status'] === 'success') {
            $order->update([
                'status' => 'completed',
                'payment_status' => 'paid',
                'transaction_id' => $data['id'] ?? null,
                'gateway_reference' => $data['reference'] ?? $reference,
                'charged_amount' => isset($data['amount']) ? $data['amount'] / 100 : $order->total,
                'gateway_fee' => isset($data['fees']) ? $data['fees'] / 100 : 0,
                'processor_response' => $data['gateway_response'] ?? 'Approved',
                'paid_at' => now(),
            ]);

            $this->applyVendorCommission($order);
            session()->forget('vendor_referral');

            return redirect()->route('customer.library')
                ->with('success', 'Payment successful. Your magazine is now available.');
        }

        $order->update([
            'status' => 'failed',
            'payment_status' => 'failed',
            'processor_response' => $data['gateway_response'] ?? 'Payment failed',
        ]);

        return redirect()->route('customer.library')
            ->with('error', 'Payment was not successful.');
    }

    public function library()
    {
        $orders = Order::with('product')
            ->where('user_id', auth()->id())
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('customer.library', compact('orders'));
    }

    private function applyVendorCommission(Order $order): void
    {
        if (!$order->vendor_id) {
            return;
        }

        if ($order->commission_amount > 0) {
            return;
        }

        $order->loadMissing(['vendor', 'product']);

        $vendor = $order->vendor;
        $product = $order->product;

        if (!$vendor || !$product) {
            return;
        }

        if ($vendor->status !== 'approved') {
            return;
        }

        $commissionType = $order->commission_type ?? $product->commission_type ?? 'none';
        $commissionValue = $order->commission_rate ?? $product->commission_value ?? 0;

        $commissionAmount = 0;

        if ($commissionType === 'percentage') {
            $commissionAmount = ($order->total * $commissionValue) / 100;
        }

        if ($commissionType === 'fixed') {
            $commissionAmount = $commissionValue;
        }

        if ($commissionType === 'target_fixed') {
            $confirmedSales = Order::where('vendor_id', $vendor->id)
                ->where('product_id', $product->id)
                ->where('payment_status', 'paid')
                ->where('status', 'completed')
                ->count();

            if ($product->commission_target_qty && $confirmedSales >= $product->commission_target_qty) {
                $commissionAmount = $commissionValue;
            }
        }

        if ($commissionAmount <= 0) {
            return;
        }

        $order->update([
            'commission_type' => $commissionType,
            'commission_rate' => $commissionValue,
            'commission_amount' => $commissionAmount,
        ]);

        $vendor->increment('total_earned', $commissionAmount);
    }
}

