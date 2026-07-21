<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $siteName = setting('site_name', 'FutureMap Media');

        $pageTitle = trim($__env->yieldContent('title'));
        $title = $pageTitle
            ? $pageTitle . ' | ' . $siteName
            : $siteName;

        $defaultDescription = setting(
            'meta_description',
            'FutureMap Media provides news, magazines, articles and insightful media content.'
        );

        $defaultKeywords = setting(
            'meta_keywords',
            'FutureMap Media, News, Magazine, Articles'
        );

        $description = trim(
            $__env->yieldContent('meta_description', $defaultDescription)
        );

        $keywords = trim(
            $__env->yieldContent('meta_keywords', $defaultKeywords)
        );

        $canonicalUrl = trim(
            $__env->yieldContent('canonical_url', url()->current())
        );

        /*
        |--------------------------------------------------------------------------
        | Open Graph Settings
        |--------------------------------------------------------------------------
        */

        $ogType = trim(
            $__env->yieldContent('og_type', 'website')
        );

        $ogUrl = trim(
            $__env->yieldContent('og_url', $canonicalUrl)
        );

        $ogTitle = trim(
            $__env->yieldContent('og_title', $title)
        );

        $ogDescription = trim(
            $__env->yieldContent('og_description', $description)
        );

        $defaultImage = setting_asset(
            setting('logo'),
            'frontend/assets/images/logo.png'
        );

        $sharedImage = trim(
            $__env->yieldContent('og_image', $defaultImage)
        );

        if (
            $sharedImage &&
            !str_starts_with($sharedImage, 'http://') &&
            !str_starts_with($sharedImage, 'https://')
        ) {
            $sharedImage = url('/' . ltrim($sharedImage, '/'));
        }

        $secureImage = trim(
            $__env->yieldContent('og_image_secure_url', $sharedImage)
        );

        if (
            $secureImage &&
            !str_starts_with($secureImage, 'http://') &&
            !str_starts_with($secureImage, 'https://')
        ) {
            $secureImage = url('/' . ltrim($secureImage, '/'));
        }

        $ogImageAlt = trim(
            $__env->yieldContent('og_image_alt', $ogTitle)
        );

        $ogImageType = trim(
            $__env->yieldContent('og_image_type', 'image/jpeg')
        );

        $ogImageWidth = trim(
            $__env->yieldContent('og_image_width', '1200')
        );

        $ogImageHeight = trim(
            $__env->yieldContent('og_image_height', '630')
        );

        /*
        |--------------------------------------------------------------------------
        | Twitter / X Settings
        |--------------------------------------------------------------------------
        */

        $twitterCard = trim(
            $__env->yieldContent('twitter_card', 'summary_large_image')
        );

        $twitterUrl = trim(
            $__env->yieldContent('twitter_url', $canonicalUrl)
        );

        $twitterTitle = trim(
            $__env->yieldContent('twitter_title', $ogTitle)
        );

        $twitterDescription = trim(
            $__env->yieldContent('twitter_description', $ogDescription)
        );

        $twitterImage = trim(
            $__env->yieldContent('twitter_image', $sharedImage)
        );

        if (
            $twitterImage &&
            !str_starts_with($twitterImage, 'http://') &&
            !str_starts_with($twitterImage, 'https://')
        ) {
            $twitterImage = url('/' . ltrim($twitterImage, '/'));
        }

        $twitterImageAlt = trim(
            $__env->yieldContent('twitter_image_alt', $ogImageAlt)
        );
    @endphp

    <title>{{ $title }}</title>

    <meta name="description" content="{{ $description }}">

    @if($keywords)
        <meta name="keywords" content="{{ $keywords }}">
    @endif

    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large')">

    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:locale" content="@yield('og_locale', 'en_NG')">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $sharedImage }}">

    @if($secureImage && str_starts_with($secureImage, 'https://'))
        <meta property="og:image:secure_url" content="{{ $secureImage }}">
    @endif

    @if($ogImageType)
        <meta property="og:image:type" content="{{ $ogImageType }}">
    @endif

    @if($ogImageWidth)
        <meta property="og:image:width" content="{{ $ogImageWidth }}">
    @endif

    @if($ogImageHeight)
        <meta property="og:image:height" content="{{ $ogImageHeight }}">
    @endif

    <meta property="og:image:alt" content="{{ $ogImageAlt }}">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:url" content="{{ $twitterUrl }}">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage }}">
    <meta name="twitter:image:alt" content="{{ $twitterImageAlt }}">

    {{-- Favicon --}}
    @if(setting('favicon'))
        <link rel="icon" type="image/png" href="{{ setting_asset(setting('favicon')) }}">
        <link rel="shortcut icon" href="{{ setting_asset(setting('favicon')) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset("frontend/images/favicon.png") }}">
    @endif

    @stack('meta')

    @include('frontend.partials.styles')

    @stack('styles')

    {!! setting('header_scripts') !!}
</head>

<body id="bg" class="theme-rounded">

    <div id="loading-area" class="loading-page-1">
        <div class="spinner">
            <div class="ball"></div>
            <p>LOADING</p>
        </div>
    </div>

    <div class="page-wraper">

        @yield('header')

        <div class="page-content bg-white">
            @yield('content')
        </div>

        @include('frontend.partials.footer')

        <button class="scroltop icon-up" type="button">
            <i class="fas fa-arrow-up"></i>
        </button>

    </div>

    @include('frontend.partials.scripts')

</body>

</html>
