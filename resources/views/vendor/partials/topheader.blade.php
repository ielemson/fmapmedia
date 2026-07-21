<!-- Header -->
<header class="header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <span class="header-logo-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}" alt="FMAP Media">
            </span>
            <span>FMAP Media</span>
        </a>

        <button class="sidebar-toggle" type="button" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

        <div class="header-context">
            <span>Workspace</span>
            <strong>Vendor Marketing Center</strong>
        </div>
    </div>

    <div class="header-search">
        <form class="search-form" action="#" method="GET">
            <button type="submit"><i class="bi bi-search"></i></button>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search magazines..." autocomplete="off">
        </form>
    </div>

    <div class="header-right">
        <div class="header-actions-desktop">
            <button class="header-action theme-toggle" type="button" title="Toggle Theme">
                <i class="bi bi-moon icon-dark"></i>
                <i class="bi bi-sun icon-light"></i>
            </button>

            <button class="header-action fullscreen-toggle" type="button" onclick="toggleFullscreen()" title="Fullscreen">
                <i class="bi bi-fullscreen icon-enter"></i>
                <i class="bi bi-fullscreen-exit icon-exit"></i>
            </button>

          <div class="header-action dropdown notification-dropdown">
    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>

        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="badge">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end">
        <div class="notification-header">
            <div>
                <span>
                    {{ auth()->user()->unreadNotifications->count() }} Unread
                </span>
                <h6>Notifications</h6>
            </div>

            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('vendor.notifications.readAll') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-link p-0 text-decoration-none">
                        Mark all read
                    </button>
                </form>
            @endif
        </div>

        <div class="notification-list">
            @forelse(auth()->user()->notifications->take(5) as $notification)

                @php
                    $type = $notification->data['type'] ?? 'info';

                    $icon = match($type) {
                        'success' => 'bi-check-circle',
                        'warning' => 'bi-exclamation-triangle',
                        'danger'  => 'bi-x-circle',
                        default   => 'bi-info-circle',
                    };
                @endphp

                <a href="{{ route('vendor.notifications.show', $notification->id) }}"
                   class="notification-item {{ is_null($notification->read_at) ? 'unread' : '' }}">

                    <div class="notification-icon {{ $type }}">
                        <i class="bi {{ $icon }}"></i>
                    </div>

                    <div class="notification-content">
                        <div class="notification-title">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </div>

                        <div class="notification-text">
                            {{ $notification->data['message'] ?? '' }}
                        </div>

                        <div class="notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>

            @empty
                <div class="notification-item">
                    <div class="notification-icon info">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div class="notification-content">
                        <div class="notification-title">No new notification</div>
                        <div class="notification-text">
                            Sales, commission and withdrawal updates will appear here.
                        </div>
                        <div class="notification-time">Now</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="notification-footer">
            <a href="{{ route('vendor.notifications.index') }}">
                View all notifications
            </a>
        </div>
    </div>
</div>

            <div class="header-action dropdown user-dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('backend/assets/img/profile-img.webp') }}" alt="Vendor" class="avatar">

                    <span class="user-name">
                        <strong>{{ auth()->user()->first_name ?? 'Vendor User' }}</strong>
                        <small>{{ auth()->user()?->getRoleNames()->first() ?? 'Vendor' }}</small>
                    </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">
                        <img src="{{ asset('backend/assets/img/profile-img.webp') }}" alt="Vendor">
                        <h6>{{ auth()->user()->first_name ?? 'Vendor User' }}</h6>
                        <span>{{ auth()->user()?->getRoleNames()->first() ?? 'Vendor' }}</span>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person"></i> My Profile
                        </a>
                    </li>
{{-- 
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-link-45deg"></i> My Referral Link
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-cash-stack"></i> My Commission
                        </a>
                    </li> --}}

                    @if(session()->has('impersonator_id'))

    <li>
        <form action="{{ route('impersonation.leave') }}" method="POST">
            @csrf

            <button type="submit" class="dropdown-item text-warning">
                <i class="bi bi-arrow-return-left"></i>
                Return to Admin
            </button>
        </form>
    </li>

@else

    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="dropdown-item">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>
    </li>

@endif

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-life-preserver"></i> Support
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="header-actions-mobile">
            <button class="header-action search-toggle" type="button" title="Search">
                <i class="bi bi-search"></i>
            </button>

            <button class="header-action mobile-menu-toggle" type="button" title="More">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Search -->
<div class="mobile-search">
    <form class="search-form" action="#" method="GET">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search magazines..." autocomplete="off">
        <button type="submit"><i class="bi bi-search"></i></button>
    </form>
</div>