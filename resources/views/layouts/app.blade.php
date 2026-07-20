<!DOCTYPE html>
<html lang="en">

<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $siteName = setting('site_name', 'FutureMap Media');
        $pageTitle = trim($__env->yieldContent('title'));
        $title = $pageTitle ? $pageTitle . ' | ' . $siteName : $siteName;

        $description = trim($__env->yieldContent('meta_description', setting('meta_description', 'FutureMap Media provides news, magazines, articles and insightful media content.')));
        $keywords = trim($__env->yieldContent('meta_keywords', setting('meta_keywords', 'FutureMap Media, News, Magazine, Articles')));
        $ogTitle = trim($__env->yieldContent('og_title', $title));
        $ogDescription = trim($__env->yieldContent('og_description', $description));

        $defaultLogo = setting_asset(setting('logo'), 'frontend/assets/images/logo.png');
        $sharedImage = trim($__env->yieldContent('og_image', $defaultLogo));

        if ($sharedImage && !str_starts_with($sharedImage, 'http://') && !str_starts_with($sharedImage, 'https://')) {
            $sharedImage = url($sharedImage);
        }

        $canonicalUrl = url()->current();
    @endphp

    <title>{{ $title }}</title>

    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index,follow">

    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $sharedImage }}">
    <meta property="og:image:secure_url" content="{{ $sharedImage }}">
    <meta property="og:image:type" content="@yield('og_image_type', 'image/png')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="@yield('og_image_alt', $ogTitle)">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $sharedImage }}">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', $ogTitle)">

    @if (setting('favicon'))
        <link rel="icon" type="image/png" href="{{ setting_asset(setting('favicon')) }}">
        <link rel="shortcut icon" href="{{ setting_asset(setting('favicon')) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}">
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
