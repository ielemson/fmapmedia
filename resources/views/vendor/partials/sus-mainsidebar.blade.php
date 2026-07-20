<aside class="sidebar">

    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}"
                     alt="FMAP Media">
            </span>

            <span class="sidebar-logo-text">
                <span class="sidebar-logo-name">FMAP Media</span>
                <span class="sidebar-logo-label">
                    Suspended Vendor Account
                </span>
            </span>
        </a>

        <button class="sidebar-close" type="button">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Suspension Alert -->
    <div class="px-3 py-3">
        <div class="alert alert-danger mb-0 rounded-4 small">
            <div class="d-flex align-items-start">
                <i class="bi bi-shield-exclamation me-2 fs-5"></i>

                <div>
                    <strong>Account Suspended</strong>

                    <div class="mt-1">
                        Your vendor account has been temporarily suspended.
                        Marketplace activities have been disabled until your
                        account is reactivated.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-menu">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-heading">
                <span>Account</span>
            </li>

            <!-- Status -->
            <li class="nav-item">
                <a class="nav-link active"
                   href="javascript:;">
                    <i class="bi bi-shield-lock"></i>
                    <span>Account Status</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link"
                   href="javascript:;">
                    <i class="bi bi-person-circle"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- Support -->
            <li class="nav-item">
                <a class="nav-link"
                   href="javascript:;">
                    <i class="bi bi-headset"></i>
                    <span>Contact Support</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-4">
                <form method="POST"
                      action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </nav>

</aside>