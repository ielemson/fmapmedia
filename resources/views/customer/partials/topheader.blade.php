<!-- Header -->
<header class="header">
    <div class="header-left">
        <a href="javascript:;" class="header-logo">
            <span class="header-logo-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}" alt="FMAP Media">
            </span>
            <span>FMAP Media</span>
        </a>

        <button class="sidebar-toggle" type="button" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

        <div class="header-context">
            <span>Customer Area</span>
            <strong>Digital Magazine Library</strong>
        </div>
    </div>

    <div class="header-search">
        <form class="search-form" action="javascript:;" method="GET">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>

            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search my magazines..."
                autocomplete="off">
        </form>
    </div>

    <div class="header-right">
        <div class="header-actions-desktop">

            <button class="header-action theme-toggle" type="button" title="Toggle Theme">
                <i class="bi bi-moon icon-dark"></i>
                <i class="bi bi-sun icon-light"></i>
            </button>

            <button class="header-action fullscreen-toggle"
                    type="button"
                    onclick="toggleFullscreen()"
                    title="Fullscreen">
                <i class="bi bi-fullscreen icon-enter"></i>
                <i class="bi bi-fullscreen-exit icon-exit"></i>
            </button>

            <!-- Notifications -->
            <div class="header-action dropdown notification-dropdown">
                <button class="dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <i class="bi bi-bell"></i>
                    <span class="badge">0</span>
                </button>

                <div class="dropdown-menu dropdown-menu-end">

                    <div class="notification-header">
                        <div>
                            <span>Customer</span>
                            <h6>Notifications</h6>
                        </div>

                        <a href="javascript:;">Mark all read</a>
                    </div>

                    <div class="notification-list">

                        <div class="notification-item">
                            <div class="notification-icon info">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <div class="notification-content">
                                <div class="notification-title">
                                    Welcome to FMAP Media
                                </div>

                                <div class="notification-text">
                                    Your magazine purchases, payments and download updates will appear here.
                                </div>

                                <div class="notification-time">
                                    Just now
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="notification-footer">
                        <a href="javascript:;">View all notifications</a>
                    </div>

                </div>
            </div>

            <!-- User -->
            <div class="header-action dropdown user-dropdown">

                <button class="dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <img src="{{ asset('backend/assets/img/profile-img.webp') }}"
                         alt="Customer"
                         class="avatar">

                    <span class="user-name">
                        <strong>{{ auth()->user()->first_name ?? 'Customer' }}</strong>
                        <small>{{ auth()->user()?->getRoleNames()->first() ?? 'Customer' }}</small>
                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li class="dropdown-header">
                        <img src="{{ asset('backend/assets/img/profile-img.webp') }}"
                             alt="Customer">

                        <h6>{{ auth()->user()->first_name ?? 'Customer' }}</h6>

                        <span>{{ auth()->user()?->getRoleNames()->first() ?? 'Customer' }}</span>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-journal-bookmark"></i>
                            My Library
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-bag-check"></i>
                            My Orders
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-credit-card"></i>
                            Payment History
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-person"></i>
                            My Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-key"></i>
                            Change Password
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="bi bi-headset"></i>
                            Help & Support
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i>
                                Sign Out
                            </button>
                        </form>
                    </li>

                </ul>

            </div>

        </div>

        <div class="header-actions-mobile">

            <button class="header-action search-toggle"
                    type="button"
                    title="Search">

                <i class="bi bi-search"></i>
            </button>

            <button class="header-action mobile-menu-toggle"
                    type="button"
                    title="More">

                <i class="bi bi-three-dots-vertical"></i>
            </button>

        </div>

    </div>
</header>

<!-- Mobile Search -->
<div class="mobile-search">
    <form class="search-form" action="javascript:;" method="GET">

        <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search my magazines..."
            autocomplete="off">

        <button type="submit">
            <i class="bi bi-search"></i>
        </button>

    </form>
</div>