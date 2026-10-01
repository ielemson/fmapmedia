@extends('layouts.app')

@php
    $magazineDescription = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($magazine->desc ?? ''))), 200, '');

    $magazineUrl = route('magazine.show', $magazine->slug);

    $imagePath = $magazine->image ? ltrim($magazine->image, '/') : null;

    $magazineImage = $imagePath ? url('storage/' . $imagePath) : asset('frontend/images/default-magazine.jpg');

    $imageExtension = strtolower(pathinfo(parse_url($magazineImage, PHP_URL_PATH), PATHINFO_EXTENSION));

    $magazineImageType = match ($imageExtension) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        default => '',
    };

    /*
    |--------------------------------------------------------------------------
    | Read actual image dimensions from the local public file
    |--------------------------------------------------------------------------
    */

    $localImagePath = $imagePath
        ? public_path('storage/' . $imagePath)
        : public_path('frontend/images/default-magazine.jpg');

    $imageDimensions = is_file($localImagePath) && is_readable($localImagePath) ? @getimagesize($localImagePath) : false;

    $magazineImageWidth = $imageDimensions ? (string) $imageDimensions[0] : '';

    $magazineImageHeight = $imageDimensions ? (string) $imageDimensions[1] : '';

    if ($imageDimensions && !empty($imageDimensions['mime'])) {
        $magazineImageType = $imageDimensions['mime'];
    }
@endphp

@section('title', $magazine->name)
@section('meta_description', $magazineDescription)

@section('meta_keywords', $magazine->name . ', FutureMap Media, digital magazine, African magazine, leadership,
    development')

@section('canonical_url', $magazineUrl)

@section('og_type', 'article')
@section('og_url', $magazineUrl)
@section('og_title', $magazine->name . ' | FutureMap Media')
@section('og_description', $magazineDescription)
@section('og_image', $magazineImage)
@section('og_image_secure_url', $magazineImage)
@section('og_image_type', $magazineImageType)
@section('og_image_width', $magazineImageWidth)
@section('og_image_height', $magazineImageHeight)
@section('og_image_alt', $magazine->name . ' magazine cover')

@section('twitter_card', 'summary_large_image')
@section('twitter_url', $magazineUrl)
@section('twitter_title', $magazine->name . ' | FutureMap Media')
@section('twitter_description', $magazineDescription)
@section('twitter_image', $magazineImage)
@section('twitter_image_alt', $magazine->name . ' magazine cover')

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', ['header' => 'Magazine'])

    <div class="content-inner bg-img-fix">
        <div class="min-container">

            <div class="dz-card blog-single sidebar style-1">

                <div class="dz-info text-center">
                    <div class="dz-meta">
                        <ul class="justify-content-center">
                            <li class="post-date">
                                {{ optional($magazine->published_at)->format('d M Y') ?? 'Not Published' }}
                            </li>

                            @if ($magazine->category)
                                <li class="post-user">
                                    {{ $magazine->category->name }}
                                </li>
                            @endif
                        </ul>
                    </div>

                    <h2 class="dz-title">{{ $magazine->name }}</h2>
                </div>

                <div class="row align-items-start m-b40">

                    <div class="col-lg-6">
                        <div class="dz-media magazine-detail-cover">
                            <img src="{{ $magazineImage }}" alt="{{ $magazine->name }}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="dz-info magazine-purchase-box">

                            <h4>About This Magazine</h4>

                            <div class="dz-post-text">
                                {!! $magazine->desc !!}
                            </div>

                            <div>
                                <a href="{{ route('checkout.show', $magazine->slug) }}" class="btn btn-primary btn-icon">
                                    Buy Now - ₦{{ number_format($magazine->price, 2) }}
                                    <i class="fas fa-shopping-cart ms-2"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="dz-info">
                    <div class="dz-share-post">
                        <h5 class="title">Share:</h5>

                        <ul class="dz-social-icon">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($magazineUrl) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"
                                    class="fab fa-facebook-f"></a>
                            </li>

                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($magazineUrl) }}&text={{ urlencode($magazine->name) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Share on X"
                                    class="fab fa-twitter"></a>
                            </li>

                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($magazine->name . ' - ' . $magazineUrl) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp"
                                    class="fab fa-whatsapp"></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            @if ($relatedMagazines->count())
                <div class="row extra-blog style-1">

                    <div class="col-lg-12">
                        <div class="widget-title">
                            <h5 class="title">Related Magazine Issues</h5>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>
                    </div>

                    @foreach ($relatedMagazines as $related)
                        @php
                            $relatedUrl = route('magazine.show', $related->slug);

                            $relatedImage = $related->image
                                ? url('storage/' . ltrim($related->image, '/'))
                                : asset('frontend/images/default-magazine.jpg');
                        @endphp

                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="dz-card blog-grid style-1 m-b30">

                                <div class="dz-media">
                                    <a href="{{ $relatedUrl }}">
                                        <img src="{{ $relatedImage }}" alt="{{ $related->name }}" loading="lazy">
                                    </a>
                                </div>

                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-date">
                                                {{ optional($related->published_at)->format('d M Y') }}
                                            </li>
                                        </ul>
                                    </div>

                                    <h5 class="dz-title">
                                        <a href="{{ $relatedUrl }}">
                                            {{ $related->name }}
                                        </a>
                                    </h5>

                                    <div class="dz-post-text text">
                                        <p>
                                            {{ Str::limit(strip_tags($related->desc ?? ''), 90) }}
                                        </p>
                                    </div>

                                    <a href="{{ $relatedUrl }}" class="btn-link">
                                        Read More
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>
    </div>
@endsection
