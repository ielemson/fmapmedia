<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display all published news.
     */
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

    /**
     * Display a single published news article.
     */
    public function show(string $slug)
    {
        $article = News::query()
            ->with([
                'category:id,name,slug',
                'author:id,first_name,last_name',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $relatedNews = News::query()
            ->with('category:id,name,slug')
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($article->category_id, function ($query) use ($article) {
                $query->where('category_id', $article->category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

             $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

        return view('frontend.news.show', compact(
            'article',
            'services',
            'relatedNews'
        ));
    }
}