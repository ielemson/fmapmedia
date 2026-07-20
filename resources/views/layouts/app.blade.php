<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
            @yield('title') | {{ setting('site_name', 'FutureMap Media') }}
        @else
            {{ setting('site_name', 'FutureMap Media') }}
        @endif
    </title>

    <meta name="description" content="@yield('meta_description', setting('meta_description'))">

    <meta name="keywords" content="@yield('meta_keywords', setting('meta_keywords'))">

    <meta property="og:title" content="@yield('og_title', setting('site_name', 'FutureMap Media'))">

    <meta property="og:description" content="@yield('og_description', setting('meta_description'))">

    <meta property="og:image" content="@yield('og_image', setting_asset(setting('logo'), 'frontend/assets/images/logo.png'))">

    @if (setting('favicon'))
        <link rel="icon" href="{{ setting_asset(setting('favicon')) }}">
    @endif

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
