<!-- Mobile Header Menu -->
<div class="mobile-header-menu">
    <div class="mobile-header-menu-content">

        <button class="mobile-menu-item theme-toggle" type="button" title="Toggle Theme">
            <i class="bi bi-moon icon-dark"></i>
            <i class="bi bi-sun icon-light"></i>
            <span class="mobile-menu-label">Theme</span>
        </button>

        <button class="mobile-menu-item fullscreen-toggle"
                type="button"
                onclick="toggleFullscreen()"
                title="Fullscreen">
            <i class="bi bi-fullscreen icon-enter"></i>
            <i class="bi bi-fullscreen-exit icon-exit"></i>
            <span class="mobile-menu-label">Fullscreen</span>
        </button>

        <a href="javascript:;" class="mobile-menu-item">
            <i class="bi bi-bell"></i>
            <span class="badge">0</span>
            <span class="mobile-menu-label">Notifications</span>
        </a>

        <a href="javascript:;" class="mobile-menu-item">
            <i class="bi bi-journal-bookmark"></i>
            <span class="mobile-menu-label">My Library</span>
        </a>

        <a href="javascript:;" class="mobile-menu-item">
            <i class="bi bi-bag-check"></i>
            <span class="mobile-menu-label">Orders</span>
        </a>

        <a href="javascript:;" class="mobile-menu-item">
            <i class="bi bi-person"></i>
            <span class="mobile-menu-label">Profile</span>
        </a>

        <a href="javascript:;" class="mobile-menu-item">
            <i class="bi bi-headset"></i>
            <span class="mobile-menu-label">Support</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf

            <button type="submit" class="mobile-menu-item mobile-menu-item-danger w-100 border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                <span class="mobile-menu-label">Sign Out</span>
            </button>
        </form>

    </div>
</div>