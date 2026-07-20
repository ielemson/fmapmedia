<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Models\Vendor;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Mail\VendorApprovedMail;
use App\Mail\VendorRejectedMail;
use App\Mail\VendorSuspendedMail;
use App\Mail\VendorPendingMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminVendorController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'status' => [
                'nullable',
                'in:pending,approved,rejected,suspended',
            ],
            'vendor_type' => ['nullable', 'string', 'max:100'],
        ]);

        $vendors = Vendor::query()
            ->with([
                'user:id,first_name,last_name,email,status,created_at',
            ])
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = trim($request->input('search'));

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('business_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('vendor_code', 'like', "%{$search}%")
                            ->orWhere('referral_slug', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery
                                    ->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                            });
                    });
                }
            )
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->input('status')
                )
            )
            ->when(
                $request->filled('vendor_type'),
                fn($query) => $query->where(
                    'vendor_type',
                    $request->input('vendor_type')
                )
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statistics = [
            'total' => Vendor::count(),
            'pending' => Vendor::where('status', 'pending')->count(),
            'approved' => Vendor::where('status', 'approved')->count(),
            'rejected' => Vendor::where('status', 'rejected')->count(),
            'suspended' => Vendor::where('status', 'suspended')->count(),
        ];

        $vendorTypes = Vendor::query()
            ->whereNotNull('vendor_type')
            ->distinct()
            ->orderBy('vendor_type')
            ->pluck('vendor_type');

        return view(
            'admin.vendors.index',
            compact('vendors', 'statistics', 'vendorTypes')
        );
    }

    public function show(Vendor $vendor): View
    {
        $vendor->load([
            'user.roles',
        ]);

        return view('admin.vendors.show', compact('vendor'));
    }

    public function approve(Vendor $vendor): RedirectResponse
    {
        // dd($vendor->user->email);
        if ($vendor->status === 'approved') {
            return back()->with(
                'info',
                'This vendor has already been approved.'
            );
        }

        $vendor->loadMissing('user');

        if (!$vendor->user) {
            return back()->with(
                'error',
                'The user account associated with this vendor could not be found.'
            );
        }

        DB::transaction(function () use ($vendor) {
            $vendor->update([
                'vendor_code' => $vendor->vendor_code
                    ?? $this->generateUniqueVendorCode(),

                'referral_slug' => $vendor->referral_slug
                    ?? $this->generateUniqueReferralSlug($vendor),

                'status' => 'approved',

                'approved_at' => $vendor->approved_at ?? now(),

                'rejection_reason' => null,
            ]);

            $vendor->user->update([
                'status' => 'active',
            ]);
        });

        $vendor->refresh()->load('user');

        $this->sendVendorStatusEmail(
            vendor: $vendor,
            status: 'approved'
        );

        return back()->with(
            'success',
            "{$vendor->business_name} has been approved successfully."
        );
    }

    private function generateUniqueVendorCode(): string
    {
        do {
            $vendorCode = 'VND-' . strtoupper(Str::random(8));
        } while (
            Vendor::where('vendor_code', $vendorCode)->exists()
        );

        return $vendorCode;
    }

    private function generateUniqueReferralSlug(Vendor $vendor): string
    {
        $baseSlug = Str::slug(
            $vendor->business_name
                ?: $vendor->user?->name
                ?: 'vendor'
        );

        do {
            $referralSlug = $baseSlug
                . '-'
                . strtolower(Str::random(6));
        } while (
            Vendor::where('referral_slug', $referralSlug)->exists()
        );

        return $referralSlug;
    }


    public function reject(
        Request $request,
        Vendor $vendor
    ): RedirectResponse {
        $data = $request->validate([
            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        if ($vendor->status === 'rejected') {
            return back()->with(
                'info',
                'This vendor application has already been rejected.'
            );
        }

        $vendor->loadMissing('user');

        if (!$vendor->user) {
            return back()->with(
                'error',
                'The user account associated with this vendor could not be found.'
            );
        }

        DB::transaction(function () use ($vendor, $data) {
            $vendor->update([
                'status' => 'rejected',
                'approved_at' => null,
                'rejection_reason' => $data['reason'],
            ]);

            /*
* The user remains active so they can log in
* and see the rejected-status page.
*/
            $vendor->user->update([
                'status' => 'active',
            ]);
        });

        $vendor->refresh()->load('user');

        $this->sendVendorStatusEmail(
            vendor: $vendor,
            status: 'rejected',
            reason: $data['reason']
        );

        return back()->with(
            'success',
            "{$vendor->business_name} has been rejected."
        );
    }

    public function suspend(Vendor $vendor): RedirectResponse
    {
        if ($vendor->status === 'suspended') {
            return back()->with(
                'info',
                'This vendor has already been suspended.'
            );
        }

        if ($vendor->status !== 'approved') {
            return back()->with(
                'error',
                'Only approved vendors can be suspended.'
            );
        }

        $vendor->loadMissing('user');

        if (!$vendor->user) {
            return back()->with(
                'error',
                'The user account associated with this vendor could not be found.'
            );
        }

        DB::transaction(function () use ($vendor) {
            $vendor->update([
                'status' => 'suspended',
            ]);

            $vendor->user->update([
                'status' => 'suspended',
            ]);
        });

        $vendor->refresh()->load('user');

        $this->sendVendorStatusEmail(
            vendor: $vendor,
            status: 'suspended'
        );

        return back()->with(
            'success',
            "{$vendor->business_name} has been suspended."
        );
    }

    public function markPending(Vendor $vendor): RedirectResponse
    {
        if ($vendor->status === 'pending') {
            return back()->with(
                'info',
                'This vendor application is already pending review.'
            );
        }

        $vendor->loadMissing('user');

        if (!$vendor->user) {
            return back()->with(
                'error',
                'The user account associated with this vendor could not be found.'
            );
        }

        DB::transaction(function () use ($vendor) {
            $vendor->update([
                'status' => 'pending',
                'approved_at' => null,
                'rejection_reason' => null,
            ]);

            /*
* Activate the user so they can access
* the vendor pending-status page.
*/
            $vendor->user->update([
                'status' => 'active',
            ]);
        });

        $vendor->refresh()->load('user');

        $this->sendVendorStatusEmail(
            vendor: $vendor,
            status: 'pending'
        );

        return back()->with(
            'success',
            "{$vendor->business_name} has been returned to pending status."
        );
    }

   


private function sendVendorStatusEmail(
    Vendor $vendor,
    string $status,
    ?string $reason = null
): bool {
    $vendor->loadMissing('user');

    $email = $vendor->user?->email;

    if (!$email) {
        Log::warning('Vendor status email was not sent because no email was found.', [
            'vendor_id' => $vendor->id,
            'user_id' => $vendor->user_id,
            'status' => $status,
        ]);

        return false;
    }

    $mailable = match ($status) {
        'approved' => new VendorApprovedMail($vendor),

        'rejected' => new VendorRejectedMail(
            $vendor,
            $reason
        ),

        'suspended' => new VendorSuspendedMail($vendor),

        'pending' => new VendorPendingMail($vendor),

        default => null,
    };

    if (!$mailable) {
        Log::warning('Unsupported vendor status email requested.', [
            'vendor_id' => $vendor->id,
            'status' => $status,
        ]);

        return false;
    }

    try {
        Mail::to($email)->send($mailable);

        Log::info('Vendor status email sent successfully.', [
            'vendor_id' => $vendor->id,
            'email' => $email,
            'status' => $status,
        ]);

        return true;
    } catch (Throwable $exception) {
        Log::error('Vendor status email failed.', [
            'vendor_id' => $vendor->id,
            'email' => $email,
            'status' => $status,
            'error' => $exception->getMessage(),
        ]);

        return false;
    }
}
}
