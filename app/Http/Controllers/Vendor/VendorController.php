<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Vendor profile not found.');
        }

        $magazines = Product::query()
            ->where('status', 'active')
            ->latest('published_at')
            ->take(6)
            ->get();

        $referralLink = $vendor->referral_slug
            ? route('referral.track', $vendor->referral_slug)
            : 'javascript:;';

        return view('vendor.dashboard', compact(
            'user',
            'vendor',
            'magazines',
            'referralLink'
        ));
    }
}