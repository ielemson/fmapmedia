@extends('layouts.app')

@section('title', $service->title . ' | FutureMap Media')

@section('meta_description')
    {{ $service->short_description
        ? \Illuminate\Support\Str::limit(strip_tags($service->short_description), 160)
        : \Illuminate\Support\Str::limit(strip_tags($service->description), 160) }}
@endsection

@section('og_title', $service->title)

@section('og_description')
    {{ $service->short_description
        ? \Illuminate\Support\Str::limit(strip_tags($service->short_description), 160)
        : \Illuminate\Support\Str::limit(strip_tags($service->description), 160) }}
@endsection

@section('og_image')
    {{ $service->image
        ? asset('storage/' . $service->image)
        : asset('frontend/images/default-service.jpg') }}
@endsection

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', [
        'header' => $service->title,
    ])

    @php
        $serviceUrl = route('services.show', $service->slug);

        $serviceImage = $service->image
            ? asset('storage/' . $service->image)
            : asset('frontend/images/default-service.jpg');

        $contactRoute = Route::has('contact')
            ? route('contact')
            : route('contact');

        $whatsappNumber = setting('phone', '2348035082149');

        $cleanWhatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);

        if (str_starts_with($cleanWhatsappNumber, '0')) {
            $cleanWhatsappNumber = '234' . substr($cleanWhatsappNumber, 1);
        }

        $whatsappMessage = urlencode(
            'Hello FMAP Media, I would like to make an enquiry about: ' .
            $service->title .
            '. ' .
            $serviceUrl
        );
    @endphp

    {{-- Service Details --}}
    <section class="content-inner bg-img-fix">
        <div class="container">
            <div class="row">

                {{-- Sidebar --}}
                <div class="col-xl-4 col-lg-4 m-b30 dz-order-1">
                    <aside class="side-bar sticky-top left">

                        {{-- All Services --}}
                        <div class="widget widget_categories">
                            <div class="widget-title">
                                <h5 class="title">Our Services</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <ul>
                                <li class="{{ request()->routeIs('services.index') ? 'active' : '' }}">
                                    <a href="{{ route('services.index') }}">
                                        View All Services
                                    </a>
                                </li>

                                @if (isset($otherServices) && $otherServices->isNotEmpty())
                                    @foreach ($otherServices as $item)
                                        <li class="{{ $item->id === $service->id ? 'active' : '' }}">
                                            <a href="{{ route('services.show', $item->slug) }}">
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        {{-- Other Services With Images --}}
                        @if (isset($otherServices) && $otherServices->isNotEmpty())
                            <div class="widget recent-posts-entry">
                                <div class="widget-title">
                                    <h5 class="title">Explore More Services</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <div class="widget-post-bx">

                                    @foreach ($otherServices->take(5) as $item)
                                        @php
                                            $otherServiceImage = $item->image
                                                ? asset('storage/' . $item->image)
                                                : asset('frontend/images/default-service.jpg');
                                        @endphp

                                        <div class="widget-post clearfix">

                                            <div class="dz-media">
                                                <a href="{{ route('services.show', $item->slug) }}">
                                                    <img
                                                        src="{{ $otherServiceImage }}"
                                                        alt="{{ $item->title }}"
                                                        loading="lazy"
                                                    >
                                                </a>
                                            </div>

                                            <div class="dz-info">
                                                <h4 class="title">
                                                    <a href="{{ route('services.show', $item->slug) }}">
                                                        {{ \Illuminate\Support\Str::limit($item->title, 55) }}
                                                    </a>
                                                </h4>

                                                @if ($item->short_description)
                                                    <p class="mb-0">
                                                        {{ \Illuminate\Support\Str::limit(
                                                            strip_tags($item->short_description),
                                                            65
                                                        ) }}
                                                    </p>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif

                        {{-- Contact Card --}}
                        <div class="widget service-contact-widget">
                            <div class="service-contact-card">

                                <div class="service-contact-icon">
                                    <i class="fas fa-headset"></i>
                                </div>

                                <h4>Need Professional Support?</h4>

                                <p>
                                    Speak with the FMAP Media team about your project,
                                    organisation or service requirements.
                                </p>

                                <a
                                    href="{{ $contactRoute }}"
                                    class="btn btn-light w-100 mb-3"
                                >
                                    <i class="far fa-envelope me-2"></i>
                                    Request Consultation
                                </a>

                                <a
                                    href="https://wa.me/{{ $cleanWhatsappNumber }}?text={{ $whatsappMessage }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-success w-100"
                                >
                                    <i class="fab fa-whatsapp me-2"></i>
                                    Chat on WhatsApp
                                </a>

                            </div>
                        </div>

                        {{-- Contact Information --}}
                        {{-- <div class="widget widget_contact">
                            <div class="widget-title">
                                <h5 class="title">Contact Information</h5>
                                <div class="dz-separator style-1 text-primary mb-0"></div>
                            </div>

                            <ul class="service-contact-list">

                                @if (setting('phone'))
                                    <li>
                                        <i class="fas fa-phone-alt"></i>

                                        <div>
                                            <strong>Phone</strong>

                                            <a href="tel:{{ preg_replace('/\s+/', '', setting('phone')) }}">
                                                {{ setting('phone') }}
                                            </a>
                                        </div>
                                    </li>
                                @endif

                                @if (setting('email'))
                                    <li>
                                        <i class="far fa-envelope"></i>

                                        <div>
                                            <strong>Email</strong>

                                            <a href="mailto:{{ setting('email') }}">
                                                {{ setting('email') }}
                                            </a>
                                        </div>
                                    </li>
                                @endif

                                @if (setting('address'))
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>

                                        <div>
                                            <strong>Address</strong>

                                            <span>
                                                {{ setting('address') }}
                                            </span>
                                        </div>
                                    </li>
                                @endif

                            </ul>
                        </div> --}}

                    </aside>
                </div>

                {{-- Main Service Content --}}
                <div class="col-xl-8 col-lg-8 m-b20">

                    <article class="dz-card blog-single sidebar style-1">

                        {{-- Featured Image --}}
                        <div class="dz-media service-featured-image">
                            <img
                                src="{{ $serviceImage }}"
                                alt="{{ $service->title }}"
                                class="img-fluid w-100"
                            >
                        </div>

                        <div class="dz-info">

                            {{-- Service Heading --}}
                            <div class="service-heading">

                                @if ($service->featured ?? false)
                                    <span class="badge bg-primary mb-3">
                                        Featured Service
                                    </span>
                                @endif

                                <h1 class="dz-title">
                                    {{ $service->title }}
                                </h1>

                                @if ($service->short_description)
                                    <div class="service-summary mt-3">
                                        <p class="lead mb-0">
                                            {{ $service->short_description }}
                                        </p>
                                    </div>
                                @endif

                            </div>

                            {{-- Full Description --}}
                            <div class="dz-post-text service-content mt-4">
                                {!! $service->description !!}
                            </div>

                            {{-- Service Features --}}
                            @if (!empty($service->features))
                                @php
                                    $features = is_string($service->features)
                                        ? json_decode($service->features, true)
                                        : $service->features;
                                @endphp

                                @if (is_array($features) && count($features))
                                    <div class="service-features mt-5">

                                        <div class="section-head style-2 mb-4">
                                            <h3 class="title">What We Offer</h3>
                                            <div class="dz-separator style-1 text-primary mb-0"></div>
                                        </div>

                                        <div class="row g-3">

                                            @foreach ($features as $feature)
                                                <div class="col-md-6">
                                                    <div class="service-feature-item">

                                                        <span class="service-feature-icon">
                                                            <i class="fas fa-check"></i>
                                                        </span>

                                                        <span>
                                                            {{ is_array($feature)
                                                                ? ($feature['title'] ?? $feature['name'] ?? '')
                                                                : $feature }}
                                                        </span>

                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endif
                            @endif

                            {{-- Call To Action --}}
                            <div class="service-cta mt-5">

                                <div class="row align-items-center">

                                    <div class="col-lg-7">
                                        <span class="service-cta-subtitle">
                                            Start Your Project
                                        </span>

                                        <h3>
                                            Ready to work with FMAP Media?
                                        </h3>

                                        <p class="mb-lg-0">
                                            Tell us about your requirements and our team will
                                            provide the appropriate professional support.
                                        </p>
                                    </div>

                                    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">

                                        <a
                                            href="{{ $contactRoute }}"
                                            class="btn btn-primary me-2 mb-2"
                                        >
                                            Contact Us
                                        </a>

                                        <a
                                            href="https://wa.me/{{ $cleanWhatsappNumber }}?text={{ $whatsappMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn btn-success mb-2"
                                        >
                                            <i class="fab fa-whatsapp me-1"></i>
                                            WhatsApp
                                        </a>

                                    </div>

                                </div>

                            </div>

                            {{-- Share Service --}}
                            <div class="dz-share-post mt-5">
                                <h5 class="title">Share This Service:</h5>

                                <ul class="dz-social-icon">

                                    <li>
                                        <a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($serviceUrl) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-facebook-f"
                                            title="Share on Facebook"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="https://twitter.com/intent/tweet?url={{ urlencode($serviceUrl) }}&text={{ urlencode($service->title) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-twitter"
                                            title="Share on X"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="https://wa.me/?text={{ urlencode($service->title . ' ' . $serviceUrl) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-whatsapp"
                                            title="Share on WhatsApp"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="mailto:?subject={{ urlencode($service->title) }}&body={{ urlencode($serviceUrl) }}"
                                            class="far fa-envelope"
                                            title="Share by email"
                                        ></a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                    </article>

                    {{-- Related Services --}}
                    @if (isset($relatedServices) && $relatedServices->isNotEmpty())
                        <div class="row extra-blog style-1 mt-5">

                            <div class="col-lg-12">
                                <div class="widget-title">
                                    <h5 class="title">Related Services</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">

                                    @foreach ($relatedServices as $item)
                                        @php
                                            $relatedImage = $item->image
                                                ? asset('storage/' . $item->image)
                                                : asset('frontend/images/default-service.jpg');
                                        @endphp

                                        <div class="col-xl-6 col-lg-12 col-md-6">

                                            <div class="dz-card blog-grid style-1 m-b30 h-100">

                                                <div class="dz-media">
                                                    <a href="{{ route('services.show', $item->slug) }}">
                                                        <img
                                                            src="{{ $relatedImage }}"
                                                            alt="{{ $item->title }}"
                                                            loading="lazy"
                                                        >
                                                    </a>
                                                </div>

                                                <div class="dz-info">

                                                    <h5 class="dz-title">
                                                        <a href="{{ route('services.show', $item->slug) }}">
                                                            {{ $item->title }}
                                                        </a>
                                                    </h5>

                                                    <div class="dz-post-text text">
                                                        <p>
                                                            {{ \Illuminate\Support\Str::limit(
                                                                strip_tags(
                                                                    $item->short_description
                                                                        ?: $item->description
                                                                ),
                                                                120
                                                            ) }}
                                                        </p>
                                                    </div>

                                                    <a
                                                        href="{{ route('services.show', $item->slug) }}"
                                                        class="btn-link"
                                                    >
                                                        Learn More
                                                        <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>

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
    </section>

@endsection

@push('styles')
    <style>
        .service-featured-image img {
            width: 100%;
            max-height: 550px;
            object-fit: cover;
        }

        .service-summary {
            padding: 20px 25px;
            background: #f7f7f7;
            border-left: 4px solid var(--primary);
        }

        .service-content {
            font-size: 16px;
            line-height: 1.9;
        }

        .service-content img {
            max-width: 100%;
            height: auto;
        }

        .service-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            height: 100%;
            padding: 16px 18px;
            background: #f8f8f8;
            border-radius: 6px;
        }

        .service-feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 28px;
            width: 28px;
            height: 28px;
            color: #ffffff;
            background: var(--primary);
            border-radius: 50%;
        }

        .service-cta {
            padding: 35px;
            color: #ffffff;
            background: #171717;
            border-radius: 8px;
        }

        .service-cta h3,
        .service-cta p {
            color: #ffffff;
        }

        .service-cta-subtitle {
            display: block;
            margin-bottom: 7px;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .service-contact-card {
            padding: 30px;
            color: #ffffff;
            text-align: center;
            background: var(--primary);
            border-radius: 8px;
        }

        .service-contact-card h4,
        .service-contact-card p {
            color: #ffffff;
        }

        .service-contact-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin-bottom: 18px;
            color: var(--primary);
            font-size: 28px;
            background: #ffffff;
            border-radius: 50%;
        }

        .service-contact-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .service-contact-list li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .service-contact-list li:last-child {
            border-bottom: none;
        }

        .service-contact-list li > i {
            margin-top: 5px;
            color: var(--primary);
            font-size: 18px;
        }

        .service-contact-list strong {
            display: block;
            margin-bottom: 3px;
        }

        .widget_categories ul li.active > a {
            color: var(--primary);
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .side-bar.sticky-top {
                position: static !important;
            }

            .service-cta {
                padding: 25px;
            }
        }
    </style>
@endpush