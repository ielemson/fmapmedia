<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\News; 
use App\Models\Service; 
use App\Models\NewsCategory;

class NewsPageController extends Controller
{
    //  public function newsindex(string $slug)
    // {
    //     $article = News::query()
    //         ->with([
    //             'category',
    //             'author',
    //         ])
    //         ->where('slug', $slug)
    //         ->where('status', 'published')
    //         ->firstOrFail();

    //     $article->increment('view_count');

    //     $relatedNews = News::query()
    //         ->where('status', 'published')
    //         ->where('id', '!=', $article->id)
    //         ->where('category_id', $article->category_id)
    //         ->latest('published_at')
    //         ->take(4)
    //         ->get();

    //     return view(
    //         'frontend.news.show',
    //         compact(
    //             'article',
    //             'relatedNews'
    //         )
    //     );
    // }


      public function index(Request $request)
    {
        $news = News::query()
            ->with([
                'category:id,name,slug',
                'author:id,first_name,last_name',
            ])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())

            // Search by title, summary or details
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%");
                });
            })

            // Filter by category
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->category);
                });
            })

            // Filter by archive month
            ->when($request->filled('month'), function ($query) use ($request) {
                $query->whereMonth('published_at', $request->month);
            })

            // Filter by archive year
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('published_at', $request->year);
            })

            ->latest('published_at')
            ->paginate(6, ['*'], 'news_page')
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        |
        | Change Category to NewsCategory below if your category model is named
        | NewsCategory.
        |
        */

        $categories = NewsCategory::query()
            ->whereHas('news', function ($query) {
                $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
            })
            ->withCount([
                'news as published_news_count' => function ($query) {
                    $query->where('status', 'published')
                        ->whereNotNull('published_at')
                        ->where('published_at', '<=', now());
                },
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Posts
        |--------------------------------------------------------------------------
        */

        $recentPosts = News::query()
            ->select([
                'id',
                'title',
                'slug',
                'image',
                'old_image',
                'published_at',
            ])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(4)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | News Archives
        |--------------------------------------------------------------------------
        */

        $archives = News::query()
            ->selectRaw('YEAR(published_at) as year')
            ->selectRaw('MONTH(published_at) as month')
            ->selectRaw('COUNT(*) as total')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->groupByRaw('YEAR(published_at), MONTH(published_at)')
            ->orderByRaw('YEAR(published_at) DESC, MONTH(published_at) DESC')
            ->get();

        $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

        return view('frontend.news.index', compact(
            'news',
            'categories',
            'recentPosts',
            'archives',
            'services'
        ));
    }


   public function show(string $slug)
{
    $news = News::query()
        ->with([
            'category',
            'author',
        ])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $news->increment('view_count');

    $news->refresh();

    $categories = NewsCategory::query()
        ->whereHas('news', function ($query) {
            $query->where('status', 'published');
        })
        ->withCount([
            'news' => function ($query) {
                $query->where('status', 'published');
            },
        ])
        ->orderBy('name')
        ->get();

    $recentNews = News::query()
        ->with([
            'category',
            'author',
        ])
        ->where('status', 'published')
        ->whereKeyNot($news->id)
        ->latest()
        ->take(5)
        ->get();

    $relatedNews = News::query()
        ->with([
            'category',
            'author',
        ])
        ->where('status', 'published')
        ->whereKeyNot($news->id)
        ->when(
            $news->category_id,
            fn ($query, $categoryId) =>
                $query->where('category_id', $categoryId)
        )
        ->latest()
        ->take(4)
        ->get();

    $trendingNews = News::query()
        ->with([
            'category',
            'author',
        ])
        ->where('status', 'published')
        ->whereKeyNot($news->id)
        ->where(function ($query) {
            $query->where('trending', true)
                ->orWhere('view_count', '>', 0);
        })
        ->orderByDesc('trending')
        ->orderByDesc('view_count')
        ->latest()
        ->take(5)
        ->get();

   $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

    return view('frontend.news.show', compact(
        'news',
        'services',
        'categories',
        'recentNews',
        'relatedNews',
        'trendingNews'
    ));
}
}
