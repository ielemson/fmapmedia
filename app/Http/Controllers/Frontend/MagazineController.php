<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    /**
     * Display one published magazine.
     */
    public function show(string $slug): View
    {
        $magazine = Product::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();

        $relatedMagazines = Product::query()
            ->where('status', 'published')
            ->whereKeyNot($magazine->id)
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->limit(3)
            ->get();

              $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();
        
        return view(
            'frontend.magazine.show',
            compact('magazine', 'relatedMagazines', 'services')
        );
    }
}