 <section class="content-inner-1">
    <div class="container">

        <div class="section-head style-1 text-center">
            <h6 class="text-primary sub-title">News & Updates</h6>
            <h2 class="title">Latest News Feed</h2>
        </div>

        <div class="blog-area">

            @if($news->count())

                <div class="swiper-container blog-swiper">
                    <div class="swiper-wrapper">

                        @foreach($news as $index => $article)

                            <div class="swiper-slide">

                                <div class="dz-card blog-grid style-1 aos-item h-100">

                                    {{-- News Image --}}
                                    <div class="dz-media">

                                        <a href="{{ route('news.show', $article->slug) }}">

                                            @if($article->image_url)
                                                <img src="{{ asset($article->image_url) }}"
                                                    alt="{{ $article->title }}"
                                                    loading="lazy">

                                            {{-- @elseif($article->old_image)
                                                <img src="{{ asset($article->old_image) }}"
                                                    alt="{{ $article->title }}"
                                                    loading="lazy">

                                            @else --}}
                                                {{-- <img src="{{ asset('images/blog/default-news.jpg') }}"
                                                    alt="{{ $article->title }}"
                                                    loading="lazy"> --}}
                                            @endif

                                        </a>

                                        @if($article->category)
                                            <div class="post-category">
                                                <span>
                                                    {{ $article->category->name }}
                                                </span>
                                            </div>
                                        @endif

                                    </div>

                                    {{-- News Information --}}
                                    <div class="dz-info text-center">

                                        <div class="dz-meta">
                                            <ul>

                                                <li class="post-date">
                                                    {{ optional($article->published_at)->format('d M Y') }}
                                                </li>

                                                @if($article->category)
                                                    <li class="post-user">
                                                        <span>
                                                            {{ $article->category->name }}
                                                        </span>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>

                                        <h5 class="dz-title">
                                            <a href="{{ route('news.show', $article->slug) }}">
                                                {{ \Illuminate\Support\Str::limit($article->title, 75) }}
                                            </a>
                                        </h5>

                                        <div class="dz-post-text text">
                                            <p>
                                                {{ \Illuminate\Support\Str::limit(
                                                    strip_tags($article->summary ?: $article->details),
                                                    130
                                                ) }}
                                            </p>
                                        </div>

                                        <a href="{{ route('news.show', $article->slug) }}"
                                            class="btn-link">
                                            Read More
                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- Swiper Pagination --}}
                    <div class="swiper-pagination"></div>
                </div>

                <div class="text-center m-t40">
                    <a href="{{ route('news.index') }}"
                        class="btn btn-primary shadow-primary">
                        View All News
                    </a>
                </div>

            @else

                <div class="alert alert-info text-center">
                    No published news articles are available at the moment.
                </div>

            @endif

        </div>

    </div>
</section>


@push("styles")
    <style>
        .blog-swiper .swiper-slide {
    height: auto;
}

.blog-swiper .dz-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.blog-swiper .dz-media {
    height: 260px;
    overflow: hidden;
    position: relative;
}

.blog-swiper .dz-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.blog-swiper .dz-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-swiper .dz-post-text {
    flex: 1;
}

.blog-swiper .post-category {
    position: absolute;
    left: 20px;
    bottom: 15px;
    z-index: 2;
}

.blog-swiper .post-category span {
    display: inline-block;
    padding: 6px 14px;
    color: #ffffff;
    background: var(--primary);
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
}
    </style>
@endpush