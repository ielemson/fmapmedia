<!-- Mobile Header Menu -->
<div class="mobile-header-menu">
    <div class="mobile-header-menu-content">

        <!-- Theme Toggle -->
        <button class="mobile-menu-item theme-toggle" type="button" title="Toggle Theme">
            <i class="bi bi-moon icon-dark"></i>
            <i class="bi bi-sun icon-light"></i>
            <span class="mobile-menu-label">Theme</span>
        </button>

        <!-- Fullscreen -->
        <button class="mobile-menu-item fullscreen-toggle"
                type="button"
                onclick="toggleFullscreen()"
                title="Fullscreen">
            <i class="bi bi-fullscreen icon-enter"></i>
            <i class="bi bi-fullscreen-exit icon-exit"></i>
            <span class="mobile-menu-label">Fullscreen</span>
        </button>

        <!-- Notifications -->
        <a href="#" class="mobile-menu-item">
            <i class="bi bi-bell"></i>
            <span class="badge">0</span>
            <span class="mobile-menu-label">Notifications</span>
        </a>

        {{-- <!-- User Management -->
        <a href="{{ route('admin.users.index') }}" class="mobile-menu-item">
            <i class="bi bi-person"></i>
            <span class="mobile-menu-label">Users</span>
        </a> --}}

        <!-- Settings (Future Module) -->
        <a href="#" class="mobile-menu-item">
            <i class="bi bi-gear"></i>
            <span class="mobile-menu-label">Settings</span>
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf

            <button type="submit" class="mobile-menu-item mobile-menu-item-danger w-100 border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                <span class="mobile-menu-label">Sign Out</span>
            </button>
        </form>

    </div>
</div>