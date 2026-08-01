<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Agent;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vendor;
use App\Models\VendorClick;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jenssegers\Agent\Agent as JenssegersAgent;

class MagazineController extends Controller
{
    /**
     * Display published magazine issues.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $sort = $request->input('sort', 'latest');

        $magazines = Product::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('desc', 'like', "%{$search}%");
                });
            })
            ->when(
                $sort === 'oldest',
                fn ($query) => $query->orderBy('published_at')
            )
            ->when(
                $sort === 'price_low',
                fn ($query) => $query->orderBy('price')
            )
            ->when(
                $sort === 'price_high',
                fn ($query) => $query->orderByDesc('price')
            )
            ->when(
                !in_array($sort, ['oldest', 'price_low', 'price_high'], true),
                fn ($query) => $query->latest('published_at')
            )
            ->paginate(9)
            ->withQueryString();

        $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

        return view(
            'frontend.magazine.index',
            compact('magazines', 'services')
        );
    }

   public function show(string $slug): View
{
    $magazine = Product::query()
        ->where('slug', trim($slug))
        ->firstOrFail();

    $vendorReferral = session('vendor_referral');

    $hasActiveReferral =
        is_array($vendorReferral)
        && !empty($vendorReferral['vendor_id'])
        && (int) ($vendorReferral['product_id'] ?? 0) === (int) $magazine->id
        && ($vendorReferral['product_slug'] ?? null) === $magazine->slug;

    if (!$hasActiveReferral) {
        $vendorReferral = null;
    }

    $relatedMagazines = Product::query()
        ->whereKeyNot($magazine->id)
        ->latest()
        ->limit(3)
        ->get();

    $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

    return view('frontend.magazine.show', compact(
        'magazine',
        'relatedMagazines',
        'services',
        'vendorReferral',
        'hasActiveReferral'
    ));
}

    public function product(
    string $referralSlug,
    string $productSlug,
    Request $request
) {
    $vendor = Vendor::query()
        ->where('referral_slug', trim($referralSlug))
        ->where('status', 'approved')
        ->firstOrFail();

    $product = Product::query()
        ->where('slug', trim($productSlug))
        ->firstOrFail();

    $agent = new JenssegersAgent();

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

    session()->put('vendor_referral', [
        'vendor_id' => $vendor->id,
        'vendor_slug' => $vendor->referral_slug,
        'vendor_code' => $vendor->vendor_code,
        'product_id' => $product->id,
        'product_slug' => $product->slug,
        'clicked_at' => now()->toDateTimeString(),
    ]);

    return redirect()->route('magazine.show', [
        'slug' => $product->slug,
    ]);
}
}