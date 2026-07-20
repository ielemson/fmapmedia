@extends('layouts.app')

@section('title', 'Home | FutureMap Media')

@section("header")
@include("frontend.partials.page-header")
@endsection

@section('content')

@include("frontend.partials.banner",["header"=>" News"])

    <section class="content-inner">
        
        <div class="container">

            <div class="section-head style-1 text-center">
                <h6 class="text-primary sub-title">News & Updates</h6>
                <h2 class="title">Latest News Feed</h2>

                @if(request()->filled('search'))
                    <p>
                        Search results for:
                        <strong>{{ request('search') }}</strong>
                    </p>
                @elseif(request()->filled('category'))
                    <p>
                        News category:
                        <strong>{{ str(request('category'))->replace('-', ' ')->title() }}</strong>
                    </p>
                @endif
            </div>

            <div class="row">

                {{-- News Listing --}}
                <div class="col-xl-8 col-lg-8">

                    <div class="row">

                        @forelse($news as $index => $article)

                            <div class="col-xl-6 col-md-6">

                                <article class="dz-card blog-grid style-1 m-b50 aos-item h-100"
                                    data-aos="fade-up"
                                    data-aos-duration="1000"
                                    data-aos-delay="{{ 200 + (($index % 2) * 200) }}">

                                    {{-- News Image --}}
                                    <div class="dz-media">

                                        <a href="{{ route('news.show', $article->slug) }}">

                                            @if($article->image_url)

                                                <img src="{{ asset($article->image_url) }}"
                                                    alt="{{ $article->title }}"
                                                    loading="lazy"> 

                                                <img src="{{ asset('frontend/images/blog/default-news.jpg') }}"
                                                    alt="{{ $article->title }}"
                                                    loading="lazy">

                                            @endif

                                        </a>

                                        @if($article->category)

                                            <div class="post-category">

                                                <a href="{{ route('news.index', [
                                                    'category' => $article->category->slug,
                                                ]) }}">

                                                    {{ $article->category->name }}

                                                </a>

                                            </div>

                                        @endif

                                    </div>

                                    {{-- News Information --}}
                                    <div class="dz-info">

                                        <div class="dz-meta">
                                            <ul>

                                                <li class="post-date">
                                                    {{ $article->published_at?->format('d M Y') }}
                                                </li>

                                                @if($article->author)

                                                    <li class="post-user">

                                                        By

                                                        <span>
                                                            {{ trim(
                                                                $article->author->first_name . ' ' .
                                                                $article->author->last_name
                                                            ) }}
                                                        </span>

                                                    </li>

                                                @endif

                                            </ul>
                                        </div>

                                        <h3 class="dz-title">

                                            <a href="{{ route('news.show', $article->slug) }}">

                                                {{ \Illuminate\Support\Str::limit(
                                                    $article->title,
                                                    90
                                                ) }}

                                            </a>

                                        </h3>

                                        <div class="dz-post-text text">
                                            <p>

                                                {{ \Illuminate\Support\Str::limit(
                                                    strip_tags(
                                                        $article->summary
                                                        ?: $article->details
                                                    ),
                                                    150
                                                ) }}

                                            </p>
                                        </div>

                                        <a href="{{ route('news.show', $article->slug) }}"
                                            class="btn-link">

                                            Read More

                                        </a>

                                    </div>

                                </article>

                            </div>

                        @empty

                            <div class="col-12">

                                <div class="alert alert-info text-center">

                                    @if(request()->filled('search'))

                                        No news article matches your search for
                                        <strong>{{ request('search') }}</strong>.

                                    @else

                                        No published news articles are available at the moment.

                                    @endif

                                </div>

                            </div>

                        @endforelse

                    </div>

                    {{-- Pagination --}}
                    @if($news->hasPages())

                        <div class="row">
                            <div class="col-12">

                                <nav aria-label="News Pagination"
                                    class="news-pagination m-b30">

                                    {{ $news->links('frontend.partials.news-pagination') }}

                                </nav>

                            </div>
                        </div>

                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="col-xl-4 col-lg-4 m-b30 dz-order-1">

                    <aside class="side-bar sticky-top right">

                        {{-- Search --}}
                        <div class="widget widget_tag_cloud">

                            <div class="widget-title">
                                <h5 class="title">Search News</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <div class="search-bx">

                                <form role="search"
                                    method="GET"
                                    action="{{ route('news.index') }}">

                                    <div class="input-group">

                                        <input type="text"
                                            name="search"
                                            class="form-control"
                                            value="{{ request('search') }}"
                                            placeholder="Enter keywords..."
                                            aria-label="Search news">

                                        @if(request()->filled('category'))
                                            <input type="hidden"
                                                name="category"
                                                value="{{ request('category') }}">
                                        @endif

                                        <span class="input-group-btn">

                                            <button type="submit"
                                                class="btn btn-primary sharp radius-no"
                                                aria-label="Search">

                                                <i class="la la-search scale3"></i>

                                            </button>

                                        </span>

                                    </div>

                                </form>

                            </div>

                            @if(request()->hasAny([
                                'search',
                                'category',
                                'month',
                                'year',
                            ]))

                                <div class="m-t15">

                                    <a href="{{ route('news.index') }}"
                                        class="btn-link">

                                        Clear Filters

                                    </a>

                                </div>

                            @endif

                        </div>

                        {{-- Categories --}}
                        @if($categories->isNotEmpty())

                            <div class="widget widget_categories">

                                <div class="widget-title">
                                    <h5 class="title">Categories</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <ul>

                                    <li class="cat-item">

                                        <a href="{{ route('news.index') }}">
                                            All News
                                        </a>

                                        <span>
                                            ({{ $categories->sum('published_news_count') }})
                                        </span>

                                    </li>

                                    @foreach($categories as $category)

                                        <li class="cat-item">

                                            <a href="{{ route('news.index', [
                                                'category' => $category->slug,
                                            ]) }}">

                                                {{ $category->name }}

                                            </a>

                                            <span>
                                                ({{ $category->published_news_count }})
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        {{-- Recent Posts --}}
                        @if($recentPosts->isNotEmpty())

                            <div class="widget recent-posts-entry">

                                <div class="widget-title">
                                    <h5 class="title">Recent Posts</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <div class="widget-post-bx">

                                    @foreach($recentPosts as $recentPost)

                                        <div class="widget-post clearfix">

                                            <div class="dz-media">

                                                <a href="{{ route('news.show', $recentPost->slug) }}">

                                                    @if($recentPost->image_url)

                                                        <img src="{{ asset($recentPost->image_url) }}"
                                                            alt="{{ $recentPost->title }}"
                                                            loading="lazy">

                                                    @endif

                                                </a>

                                            </div>

                                            <div class="dz-info">

                                                <h4 class="title">

                                                    <a href="{{ route('news.show', $recentPost->slug) }}">

                                                        {{ \Illuminate\Support\Str::limit(
                                                            $recentPost->title,
                                                            55
                                                        ) }}

                                                    </a>

                                                </h4>

                                                <div class="dz-meta">
                                                    <ul>
                                                        <li class="post-date">

                                                            {{ $recentPost->published_at?->format(
                                                                'd M Y'
                                                            ) }}

                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                        {{-- Archives --}}
                        @if($archives->isNotEmpty())

                            <div class="widget widget_categories">

                                <div class="widget-title">
                                    <h5 class="title">Archives</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <ul>

                                    @foreach($archives as $archive)

                                        <li>

                                            <a href="{{ route('news.index', [
                                                'month' => $archive->month,
                                                'year' => $archive->year,
                                            ]) }}">

                                                {{ \Carbon\Carbon::create()
                                                    ->month((int) $archive->month)
                                                    ->format('F') }}

                                                {{ $archive->year }}

                                            </a>

                                            <span>
                                                ({{ $archive->total }})
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                    </aside>

                </div>

            </div>

        </div>
    </section>
		
@endsection

@push('styles')

    <style>
        .blog-grid.style-1 {
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;
        }

        .blog-grid.style-1 .dz-media {
            height: 260px;
            overflow: hidden;
            position: relative;
        }

        .blog-grid.style-1 .dz-media > a {
            display: block;
            width: 100%;
            height: 100%;
        }

        .blog-grid.style-1 .dz-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .blog-grid.style-1:hover .dz-media img {
            transform: scale(1.05);
        }

        .blog-grid.style-1 .dz-info {
            display: flex;
            flex: 1;
            flex-direction: column;
        }

        .blog-grid.style-1 .dz-post-text {
            flex: 1;
        }

        .blog-grid.style-1 .post-category {
            position: absolute;
            left: 18px;
            bottom: 15px;
            z-index: 2;
        }

        .blog-grid.style-1 .post-category a {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 4px;
            background: var(--primary);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
        }

        .widget_categories li {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .recent-posts-entry .widget-post .dz-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Compact News Pagination */
.pagination-bx {
    margin-top: 25px;
    width: 100%;
}

.pagination-bx .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
    margin: 0;
    padding: 0;
}

.pagination-bx .pagination .page-item {
    margin: 0 !important;
    padding: 0 !important;
}

.pagination-bx .pagination .page-link {
    display: flex !important;
    justify-content: center;
    align-items: center;

    width: 34px !important;
    min-width: 34px !important;
    height: 34px !important;

    margin: 0 !important;
    padding: 0 !important;

    font-size: 13px !important;
    line-height: 1 !important;

    border-radius: 6px !important;
    box-shadow: none !important;
}

.pagination-bx .pagination .page-link i {
    font-size: 11px !important;
}

.pagination-bx .pagination .page-item.active .page-link {
    font-weight: 600;
}

.pagination-bx .pagination .page-item.disabled .page-link {
    opacity: 0.55;
    cursor: not-allowed;
}

/* Mobile adjustment */
@media (max-width: 576px) {
    .pagination-bx .pagination {
        gap: 3px;
    }

    .pagination-bx .pagination .page-link {
        width: 30px !important;
        min-width: 30px !important;
        height: 30px !important;
        font-size: 12px !important;
    }
}
    </style>

@endpush