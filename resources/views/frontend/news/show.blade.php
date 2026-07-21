@extends('layouts.app')

@php
    $newsDescription = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($news->summary ?: $news->details ?? ''))), 200, '');

    $newsUrl = route('news.show', $news->slug);

    $newsImage = $news->image_url
        ? asset($news->image_url)
        : asset("frontend/images/default-news.jpg");

    $imageExtension = strtolower(pathinfo(parse_url($newsImage, PHP_URL_PATH), PATHINFO_EXTENSION));

    $newsImageType = match ($imageExtension) {
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        default => 'image/png',
    };

    $authorName = optional($news->author)->name ?? 'FMAP Media';

    $publishedDate = $news->published_at
        ? \Carbon\Carbon::parse($news->published_at)->format('d F Y')
        : $news->created_at?->format('d F Y');
@endphp

@section('title', $news->title)
@section('meta_description', $newsDescription)
@section('meta_keywords', $news->title . ', FutureMap Media, FMAP Media, News, Africa, Business, Economy, Leadership')
@section('canonical_url', $newsUrl)

@section('og_type', 'article')
@section('og_title', $news->title . ' | FutureMap Media')
@section('og_description', $newsDescription)
@section('og_image', $newsImage)
@section('og_image_type', $newsImageType)
@section('og_image_alt', $news->title)

@section('twitter_card', 'summary_large_image')
@section('twitter_title', $news->title . ' | FutureMap Media')
@section('twitter_description', $newsDescription)
@section('twitter_image', $newsImage)
@section('twitter_image_alt', $news->title)

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

@include('frontend.partials.banner', ['header' => 'Our News'])

<!-- News Details -->
<div class="content-inner bg-img-fix">
    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 m-b30 dz-order-1">
                <aside class="side-bar sticky-top left">

                    <!-- Search -->
                    <div class="widget widget_tag_cloud">
                        <div class="widget-title">
                            <h5 class="title">Search</h5>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>

                        <div class="search-bx">
                            <form action="{{ route('news.index') }}" method="GET">
                                <div class="input-group">
                                    <input name="search" class="form-control" placeholder="Enter your keywords..." value="{{ request('search') }}" type="text">

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary sharp radius-no" aria-label="Search news">
                                            <i class="la la-search scale3"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Categories -->
                    @if (isset($categories) && $categories->isNotEmpty())
                        <div class="widget widget_categories">
                            <div class="widget-title">
                                <h5 class="title">Categories</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <ul>
                                @foreach ($categories as $category)
                                    <li class="cat-item">
                                        <a href="{{ route('news.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>

                                        @if (isset($category->news_count))
                                            <span>({{ number_format($category->news_count) }})</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Recent News -->
                    @if (isset($recentNews) && $recentNews->isNotEmpty())
                        <div class="widget recent-posts-entry">
                            <div class="widget-title">
                                <h5 class="title">Recent News</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <div class="widget-post-bx">
                                @foreach ($recentNews as $item)
                                    @php
                                        $recentImage = $item->image_url
                                            ? asset($item->image_url)
                                            : asset('frontend/images/default-news.jpg');

                                        $recentDate = $item->published_at
                                            ? \Carbon\Carbon::parse($item->published_at)->format('d M, Y')
                                            : $item->created_at?->format('d M, Y');
                                    @endphp

                                    <div class="widget-post clearfix">
                                        <div class="dz-media">
                                            <a href="{{ route('news.show', $item->slug) }}">
                                                <img src="{{ $recentImage }}" alt="{{ $item->title }}" loading="lazy">
                                            </a>
                                        </div>

                                        <div class="dz-info">
                                            <h4 class="title">
                                                <a href="{{ route('news.show', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 55) }}</a>
                                            </h4>

                                            <div class="dz-meta">
                                                <ul>
                                                    <li class="post-date">{{ $recentDate }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Trending News -->
                    @if (isset($trendingNews) && $trendingNews->isNotEmpty())
                        <div class="widget recent-posts-entry">
                            <div class="widget-title">
                                <h5 class="title">Trending News</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <div class="widget-post-bx">
                                @foreach ($trendingNews as $item)
                                    @php
                                        $trendingImage = $item->image_url
                                            ? asset($item->image_url)
                                            : asset('frontend/images/default-news.jpg');
                                    @endphp

                                    <div class="widget-post clearfix">
                                        <div class="dz-media">
                                            <a href="{{ route('news.show', $item->slug) }}">
                                                <img src="{{ $trendingImage }}" alt="{{ $item->title }}" loading="lazy">
                                            </a>
                                        </div>

                                        <div class="dz-info">
                                            <h4 class="title">
                                                <a href="{{ route('news.show', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 55) }}</a>
                                            </h4>

                                            <div class="dz-meta">
                                                <ul>
                                                    <li><i class="far fa-eye"></i> {{ number_format($item->view_count ?? 0) }} Views</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </aside>
            </div>

            <!-- Main News Content -->
            <div class="col-xl-8 col-lg-8 m-b20">

                <article class="dz-card blog-single sidebar style-1">

                    <!-- News Header -->
                    <div class="dz-info">

                        <!-- Status Badges -->
                        <div class="mb-3">
                            @if ($news->breaking)
                                <span class="badge bg-danger me-1">Breaking News</span>
                            @endif

                            @if ($news->featured)
                                <span class="badge bg-primary me-1">Featured</span>
                            @endif

                            @if ($news->headline)
                                <span class="badge bg-dark me-1">Headline</span>
                            @endif

                            @if ($news->trending)
                                <span class="badge bg-success me-1">Trending</span>
                            @endif

                            @if ($news->editors_pick)
                                <span class="badge bg-warning text-dark me-1">Editor's Pick</span>
                            @endif
                        </div>

                        <div class="dz-meta">
                            <ul>
                                <li class="post-date"><i class="far fa-calendar-alt me-1"></i> {{ $publishedDate }}</li>

                                <li class="post-user"><i class="far fa-user me-1"></i> By <span class="ms-1">{{ $authorName }}</span></li>

                                @if ($news->category)
                                    <li>
                                        <i class="far fa-folder-open me-1"></i>
                                        <a href="{{ route('news.index', ['category' => $news->category->slug]) }}">{{ $news->category->name }}</a>
                                    </li>
                                @endif

                                <li><i class="far fa-eye me-1"></i> {{ number_format($news->view_count ?? 0) }} Views</li>
                            </ul>
                        </div>

                        <h1 class="dz-title">{{ $news->title }}</h1>

                        @if ($news->summary)
                            <div class="news-summary mt-3">
                                <p class="lead mb-0">{{ $news->summary }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Featured Image -->
                    <div class="dz-media">
                        <img src="{{ $newsImage }}" alt="{{ $news->title }}" class="img-fluid w-100">

                        @if ($news->image_caption)
                            <div class="image-caption text-muted mt-2 px-2">
                                <small>{{ $news->image_caption }}</small>
                            </div>
                        @endif
                    </div>

                    <!-- Article Details -->
                    <div class="dz-info">
                        <div class="dz-post-text news-content">
                            {!! $news->details !!}
                        </div>

                        <!-- Source -->
                        @if ($news->source)
                            <div class="news-source mt-4 p-3 bg-light border-start border-primary border-4">
                                <strong>Source:</strong>

                                @if (filter_var($news->source, FILTER_VALIDATE_URL))
                                    <a href="{{ $news->source }}" target="_blank" rel="noopener noreferrer">{{ $news->source }}</a>
                                @else
                                    {{ $news->source }}
                                @endif
                            </div>
                        @endif

                        <!-- Share -->
                        <div class="dz-share-post mt-4">
                            <h5 class="title">Share:</h5>

                            <ul class="dz-social-icon">
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($newsUrl) }}" target="_blank" rel="noopener noreferrer" class="fab fa-facebook-f" title="Share on Facebook" aria-label="Share on Facebook"></a>
                                </li>

                                <li>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($newsUrl) }}&text={{ urlencode($news->title) }}" target="_blank" rel="noopener noreferrer" class="fab fa-twitter" title="Share on X" aria-label="Share on X"></a>
                                </li>

                                <li>
                                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . $newsDescription . ' ' . $newsUrl) }}" target="_blank" rel="noopener noreferrer" class="fab fa-whatsapp" title="Share on WhatsApp" aria-label="Share on WhatsApp"></a>
                                </li>

                                <li>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($newsUrl) }}" target="_blank" rel="noopener noreferrer" class="fab fa-linkedin-in" title="Share on LinkedIn" aria-label="Share on LinkedIn"></a>
                                </li>

                                <li>
                                    <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode($newsDescription . "\n\n" . $newsUrl) }}" class="far fa-envelope" title="Share by email" aria-label="Share by email"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </article>

                <!-- Related News -->
                @if (isset($relatedNews) && $relatedNews->isNotEmpty())
                    <div class="row extra-blog style-1">
                        <div class="col-lg-12">
                            <div class="widget-title">
                                <h5 class="title">Related News</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                @foreach ($relatedNews as $item)
                                    @php
                                        $relatedImage = $item->image_url
                                            ? asset($item->image_url)
                                            : asset('frontend/images/default-news.jpg');

                                        $relatedDate = $item->published_at
                                            ? \Carbon\Carbon::parse($item->published_at)->format('d F Y')
                                            : $item->created_at?->format('d F Y');

                                        $relatedAuthor = optional($item->author)->name ?? 'FMAP Media';
                                    @endphp

                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <div class="dz-card blog-grid style-1 m-b30">

                                            <div class="dz-media">
                                                <a href="{{ route('news.show', $item->slug) }}">
                                                    <img src="{{ $relatedImage }}" alt="{{ $item->title }}" loading="lazy">
                                                </a>
                                            </div>

                                            <div class="dz-info">
                                                <div class="dz-meta">
                                                    <ul>
                                                        <li class="post-date">{{ $relatedDate }}</li>
                                                        <li class="post-user">By {{ $relatedAuthor }}</li>
                                                    </ul>
                                                </div>

                                                <h5 class="dz-title">
                                                    <a href="{{ route('news.show', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 80) }}</a>
                                                </h5>

                                                @if ($item->summary)
                                                    <div class="dz-post-text text">
                                                        <p>{{ \Illuminate\Support\Str::limit($item->summary, 120) }}</p>
                                                    </div>
                                                @endif

                                                <a href="{{ route('news.show', $item->slug) }}" class="btn-link">Read More</a>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

@endsection