<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorClick;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ReferralController extends Controller
{

   
     public function product($referralSlug, $productSlug, Request $request)
    {
        $vendor = Vendor::where('referral_slug', $referralSlug)
            ->where('status', 'approved')
            ->firstOrFail();

        $product = Product::where('slug', $productSlug)
            ->where('status', 'published')
            ->firstOrFail();

        $agent = new Agent();

        VendorClick::create([
            'vendor_id' => $vendor->id,
            'product_id' => $product->id,
            'referral_slug' => $vendor->referral_slug,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'country' => null,
            'referer' => $request->headers->get('referer'),
            'clicked_at' => now(),
        ]);

        session([
            'vendor_referral' => [
                'vendor_id' => $vendor->id,
                'vendor_slug' => $vendor->referral_slug,
                'product_id' => $product->id,
                'product_slug' => $product->slug,
                'clicked_at' => now()->toDateTimeString(),
            ],
        ]);
// dd(session('vendor_referral'));
        return redirect()->route('magazine.show', $product->slug);
    }

}