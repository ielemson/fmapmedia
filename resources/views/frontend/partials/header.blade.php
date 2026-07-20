<header class="site-header mo-left header center style-2">
    <!-- Header Top Bar -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="dz-topbar-inner d-flex justify-content-between align-items-center">

                <div class="dz-topbar-left">
                    <ul class="dz-social-icon">

                        @if (setting('facebook_url'))
                            <li>
                                <a class="fab fa-facebook-f" href="{{ setting('facebook_url') }}" target="_blank"
                                    rel="noopener noreferrer"></a>
                            </li>
                        @endif

                        @if (setting('instagram_url'))
                            <li>
                                <a class="fab fa-instagram" href="{{ setting('instagram_url') }}" target="_blank"
                                    rel="noopener noreferrer"></a>
                            </li>
                        @endif

                        @if (setting('twitter_url'))
                            <li>
                                <a class="fab fa-twitter" href="{{ setting('twitter_url') }}" target="_blank"
                                    rel="noopener noreferrer"></a>
                            </li>
                        @endif

                        @if (setting('youtube_url'))
                            <li>
                                <a class="fab fa-youtube" href="{{ setting('youtube_url') }}" target="_blank"
                                    rel="noopener noreferrer"></a>
                            </li>
                        @endif

                    </ul>
                </div>

                <div class="dz-topbar-right">
                    <ul>

                       @if (setting('address'))
    <li>
        <i class="fas fa-map-marker-alt"></i>
        {{ \Illuminate\Support\Str::limit(setting('address'), 45) }}
    </li>
@endif

                        @if (setting('contact_email'))
                            <li>
                                <i class="far fa-envelope"></i>

                                <a href="mailto:{{ setting('contact_email') }}">
                                    {{ setting('contact_email') }}
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix">
            <div class="container-fluid clearfix">

                <div class="logo-header mostion logo-dark">
                    <a href="{{ route('index') }}">
                        <img src="{{ setting_asset(setting('logo'), 'frontend/images/logo-2.png') }}"
                            alt="{{ setting('site_name', 'FutureMap Media') }}">
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Left Extra Contact -->
                <div class="extra-nav-left">
                    <div class="extra-icon-box">
                        <i class="flaticon-phone-call"></i>
                        <span>Call Now</span>
                        <h4 class="title">  {{ setting('phone') }}</h4>
                    </div>
                </div>

                <!-- Extra Nav -->
                <div class="extra-nav">
                    <div class="extra-cell">
                        <a class="search-link" id="quik-search-btn" href="javascript:void(0);">
                            <i class="flaticon-loupe"></i>
                        </a>

                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="btn shadow-primary btn-primary login-btn btn-sm">
                            <span>Subscribe</span>
                        </a>

                        <div class="menu-btn navicon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <!-- Quick Search -->
                <div class="dz-quik-search">
                    <form action="javascript:void(0);" method="GET">
                        <input name="search" type="text" class="form-control"
                            placeholder="Search magazines, news, projects...">
                        <span id="quik-search-remove">
                            <i class="ti-close"></i>
                        </span>
                    </form>
                </div>

                <!-- Navigation -->
                <div class="header-nav navbar-collapse collapse justify-content-center" id="navbarNavDropdown">

                    <div class="logo-header logo-dark">
                        <a href="{{ route('index') }}">
                            <img src="{{ setting_asset(setting('logo'), 'frontend/images/logo-2.png') }}"
                                alt="{{ setting('site_name', 'FutureMap Media') }}">
                        </a>
                    </div>

                    <!-- Left Nav: 3 Items -->
                    <ul class="nav navbar-nav navbar navbar-left">
                        <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                            <a href="{{ route('index') }}">Home</a>
                        </li>

                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}">About Us</a>
                        </li>

                        <li class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
                            <a href="{{ route('frontend.project') }}">Projects</a>
                        </li>

                    </ul>

                    <!-- Right Nav: 3 Items -->
                    <ul class="nav navbar-nav navbar navbar-right">


                        <li class="sub-menu-down {{ request()->routeIs('services.*') ? 'active' : '' }}">
                            <a href="javascript:void(0);">Services</a>

                            <ul class="sub-menu">

                                @foreach ($services as $service)
                                    <li>
                                        <a href="{{ route('services.show', $service->slug) }}">
                                            {{ $service->title }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="{{ request()->routeIs('magazines.*') ? 'active' : '' }}">
                                    <a href="{{ route('magazines.index') }}">
                                        Magazine
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Contact Us</a>
                        </li>
             
                        <li
                            class="sub-menu-down {{ request()->routeIs('login') || request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('vendor.dashboard') || request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            <a href="javascript:void(0);">
                                @auth
                                    User
                                @else
                                    Login
                                @endauth
                            </a>

                            <ul class="sub-menu">
                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('register') }}">Register</a>
                                    </li>
                                @endguest

                                @auth

                                    <li>
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>

                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>

                                @endauth

                            </ul>
                        </li>

                    </ul>

                    <div class="dz-social-icon">
                        <ul>
                            <li><a class="fab fa-facebook-f" href="javascript:void(0);"></a></li>
                            <li><a class="fab fa-twitter" href="javascript:void(0);"></a></li>
                            <li><a class="fab fa-linkedin-in" href="javascript:void(0);"></a></li>
                            <li><a class="fab fa-instagram" href="javascript:void(0);"></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->
</header>
@include("frontend.partials.contact-sidebar")