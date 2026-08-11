<section class="content-inner-2 bg-gray portfolio-area2"
    style="background-image: url('{{ asset('frontend/assets/images/background/pattern3.png') }}');">

    <div class="container">
        <div class="row align-items-center section-head-bx">

            <div class="col-md-8">
                <div class="section-head style-2">
                    <h6 class="text-primary sub-title">FMAP Media Gallery</h6>
                    <h2 class="title">Explore Our Latest Events</h2>

                    <p class="mt-3">
                        Discover photographs, reports and memorable moments from
                        FMAP Media programmes, competitions, engagements and events.
                    </p>
                </div>
            </div>

            @if($albums->count() > 1)
                <div class="col-md-4 text-md-end">
                    <div class="portfolio-pagination d-inline-block mb-5">

                        <div class="btn-prev swiper-button-prev2"
                            role="button"
                            aria-label="Previous gallery album">
                            <i class="las la-arrow-left"></i>
                        </div>

                        <div class="btn-next swiper-button-next2"
                            role="button"
                            aria-label="Next gallery album">
                            <i class="las la-arrow-right"></i>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>

    @if($albums->isNotEmpty())
        <div class="setResizeMargin">

            <div class="swiper-container swiper-portfolio lightgallery aos-item"
               >

                <div class="swiper-wrapper">

                    @foreach($albums as $album)
                        @php
                            $coverImage = $album->cover_image
                                ? asset('storage/' . $album->cover_image)
                                : asset('frontend/assets/images/default-gallery.jpg');

                            $albumUrl = route('gallery.show', $album->slug);
                        @endphp

                        <div class="swiper-slide">
                            <div class="dz-box overlay style-2">

                                <div class="dz-media">
                                    <img src="{{ $coverImage }}"
                                        alt="{{ $album->title }}"
                                        loading="lazy">
                                </div>

                                <div class="dz-info">

                                    <span data-exthumbimage="{{ $coverImage }}"
                                        data-src="{{ $coverImage }}"
                                        class="view-btn lightimg"
                                        title="{{ $album->title }}">
                                    </span>

                                    <h6 class="sub-title">
                                        {{ strtoupper($album->event_type ?: 'FMAP Media Event') }}
                                    </h6>

                                    <div class="port-info">

                                        <div class="dz-meta">
                                            <ul>

                                                @if($album->event_date)
                                                    <li class="post-date">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        {{ $album->event_date->format('d F Y') }}
                                                    </li>
                                                @endif

                                                @if($album->organizer)
                                                    <li class="post-user">
                                                        By
                                                        <a href="{{ $albumUrl }}">
                                                            {{ $album->organizer }}
                                                        </a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>

                                       <h2 class="title m-b15">
    <a href="{{ $albumUrl }}" title="{{ $album->title }}">
        {{ \Illuminate\Support\Str::limit($album->title, 45, '...') }}

        @if($album->location)
            <span>{{ $album->location }}</span>
        @endif
    </a>
</h2>

                                        @if($album->images_count > 0)
                                            <div class="text-white small mt-2">
                                                <i class="las la-images"></i>

                                                {{ number_format($album->images_count) }}

                                                {{ \Illuminate\Support\Str::plural(
                                                    'Photograph',
                                                    $album->images_count
                                                ) }}
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    @else
        <div class="container">
            <div class="text-center py-5">

                <i class="las la-images display-3 text-muted"></i>

                <h4 class="mt-3">No Gallery Albums Available</h4>

                <p class="text-muted mb-0">
                    Published event galleries will appear here.
                </p>

            </div>
        </div>
    @endif

</section>