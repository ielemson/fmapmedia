<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\News;
use App\Models\TeamMember;
use App\Models\Service;
class PageController extends Controller
{


public function index()
{
    $magazines = Product::query()
        ->where('status', 'published')
        ->latest('published_at')
        ->take(6)
        ->get();

    $news = News::query()
        ->with([
            'category:id,name,slug',
            'author:id,first_name,last_name',
        ])
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->paginate(6, ['*'], 'news_page');

    $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

    $teamMembers = TeamMember::query()
        ->with('user')
        ->published()
        ->orderBy('display_order')
        ->latest()
        ->get();

        $albums = GalleryAlbum::query()
        ->withCount([
            'images' => fn ($query) => $query->where('status', true),
        ])
        ->where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->latest('event_date')
        ->latest('id')
        ->get();


    return view('frontend.pages.home', compact(
        'magazines',
        'news',
        'albums',
        'services',
        'teamMembers'
    ));
}


    public function about()
    {
    $magazines = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        
    $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

  $teamMembers = TeamMember::query()
    ->with('user')
    ->withTrashed()
    ->orderBy('display_order')
    ->get();
    // dd($teamMembers);

        return view('frontend.pages.about', compact('magazines', 'services', 'teamMembers'));
    }
    public function contact()
    {
        $magazines = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $services = Service::query()
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.pages.contact', compact('magazines', 'services'));
    }

    public function becomeVendor()
    {
        $magazines = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $services = Service::query()
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.pages.become-vendor', compact('magazines', 'services'));
    }   

     public function project()
    {
     $services = Service::query()
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->latest()
            ->take(6)
            ->get();

    return view('frontend.projects.index', compact('services'));
    }



    public function gallery(GalleryAlbum $galleryAlbum): View
{
    abort_unless(
        $galleryAlbum->status === 'published'
        && (
            is_null($galleryAlbum->published_at)
            || $galleryAlbum->published_at->lte(now())
        ),
        404
    );

    $galleryAlbum->load([
        'images' => function ($query) {
            $query->where('status', true)
                ->orderBy('sort_order')
                ->orderBy('id');
        },
    ]);

    $magazines = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $services = Service::query()
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->latest()
            ->take(6)
            ->get();
            

    return view('frontend.pages.gallery', [
        'album' => $galleryAlbum,
        'magazines' => $magazines,
        'services' => $services,
    ]);
}
    
}