@extends("layouts.app")

@section("title", $album->title)

@section("meta_description", $album->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($album->report), 160))

@section("og_title", $album->title)

@section(
    "og_description",
    $album->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($album->report), 160)
)

@if($album->cover_image)
    @section("og_image", asset("storage/" . $album->cover_image))
@endif

@section("canonical_url", route("gallery.show", $album->slug))

@section("header")
    @include("frontend.partials.page-header")
@endsection

@section("content")

    @include("frontend.partials.banner", [
        "header" => "Our Galley"
    ])

    {{-- Album information --}}
    <section class="content-inner">
        <div class="container">

            <div class="row align-items-center g-5">

                @if($album->cover_image)
                    <div class="col-lg-6">
                        <div class="gallery-cover">
                            <img src="{{ asset('storage/' . $album->cover_image) }}"
                                 alt="{{ $album->title }}"
                                 class="img-fluid rounded w-100"
                                 style="max-height: 550px; object-fit: cover;">
                        </div>
                    </div>
                @endif

                <div class="{{ $album->cover_image ? 'col-lg-6' : 'col-12' }}">
                    <div class="section-head style-2 mb-3">

                        <h6 class="text-primary sub-title">
                            {{ $album->event_type ?: 'FMAP Media Event' }}
                        </h6>

                        <h2 class="title">
                            {{ $album->title }}
                        </h2>

                    </div>

                    @if($album->subtitle)
                        <h5 class="text-muted fw-normal mb-4">
                            {{ $album->subtitle }}
                        </h5>
                    @endif

                    @if($album->excerpt)
                        <p class="mb-4">
                            {{ $album->excerpt }}
                        </p>
                    @endif

                    <div class="row g-3">

                        @if($album->event_date)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="las la-calendar text-primary fs-3 me-3"></i>

                                    <div>
                                        <strong class="d-block">Event Date</strong>

                                        <span>
                                            {{ $album->event_date->format('d F Y') }}

                                            @if(
                                                $album->end_date
                                                && !$album->end_date->isSameDay($album->event_date)
                                            )
                                                – {{ $album->end_date->format('d F Y') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($album->venue || $album->location)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="las la-map-marker text-primary fs-3 me-3"></i>

                                    <div>
                                        <strong class="d-block">Venue</strong>

                                        @if($album->venue)
                                            <span>{{ $album->venue }}</span>
                                        @endif

                                        @if($album->location)
                                            <small class="d-block text-muted">
                                                {{ $album->location }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($album->organizer)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="las la-user-friends text-primary fs-3 me-3"></i>

                                    <div>
                                        <strong class="d-block">Organised By</strong>
                                        <span>{{ $album->organizer }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="las la-images text-primary fs-3 me-3"></i>

                                <div>
                                    <strong class="d-block">Gallery</strong>

                                    <span>
                                        {{ number_format($album->images->count()) }}

                                        {{ \Illuminate\Support\Str::plural(
                                            'Photograph',
                                            $album->images->count()
                                        ) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- Event photographs --}}
    @if($album->images->isNotEmpty())
        <section class="content-inner-2 bg-gray portfolio-area2"
                 style="background-image: url('{{ asset('frontend/assets/images/background/pattern3.png') }}');">

            <div class="container">
                <div class="row align-items-center section-head-bx">

                    <div class="col-md-8">
                        <div class="section-head style-2">
                            <h6 class="text-primary sub-title">
                                Event Gallery
                            </h6>

                            <h2 class="title">
                                Photographs from {{ $album->title }}
                            </h2>

                            <p>
                                Explore photographs and memorable moments captured
                                during this event.
                            </p>
                        </div>
                    </div>

                    @if($album->images->count() > 1)
                        <div class="col-md-4 text-md-end">
                            <div class="portfolio-pagination d-inline-block mb-5">

                                <div class="btn-prev swiper-button-prev2"
                                     role="button"
                                     aria-label="Previous photograph">
                                    <i class="las la-arrow-left"></i>
                                </div>

                                <div class="btn-next swiper-button-next2"
                                     role="button"
                                     aria-label="Next photograph">
                                    <i class="las la-arrow-right"></i>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="setResizeMargin">
                <div class="swiper-container swiper-portfolio lightgallery aos-item"
                     data-aos="fade-in"
                     data-aos-duration="1000"
                     data-aos-delay="400">

                    <div class="swiper-wrapper">

                        @foreach($album->images as $image)
                            @php
                                $imageUrl = asset('storage/' . $image->image);

                                $imageTitle = $image->title
                                    ?: $album->title;

                                $imageAlt = $image->alt_text
                                    ?: $imageTitle;
                            @endphp

                            <div class="swiper-slide">
                                <div class="dz-box overlay style-2">

                                    <div class="dz-media">
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $imageAlt }}"
                                             loading="lazy">
                                    </div>

                                    <div class="dz-info">

                                        <span data-exthumbimage="{{ $imageUrl }}"
                                              data-src="{{ $imageUrl }}"
                                              class="view-btn lightimg"
                                              title="{{ $imageTitle }}">
                                        </span>

                                        <h6 class="sub-title">
                                            {{ strtoupper($album->event_type ?: 'FMAP Media Event') }}
                                        </h6>

                                       
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </section>
    @endif

    {{-- Event report --}}
    @if($album->report)
        <section class="content-inner">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-11">

                        <div class="section-head style-2 text-center">
                            <h6 class="text-primary sub-title">
                                Event Report
                            </h6>

                            <h2 class="title">
                                About the Event
                            </h2>
                        </div>

                        <div class="gallery-event-report">
                            {!! $album->report !!}
                        </div>

                        <div class="mt-5">
                            
                        </div>

                    </div>
                </div>

            </div>
        </section>
    @endif

@endsection