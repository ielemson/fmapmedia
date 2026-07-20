<header id="page-topbar">
    <div class="navbar-header">

        <div class="d-flex">

            {{-- Logo --}}
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm-dark.png') }}" alt="FMAP Media" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="FMAP Media" height="22">
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm-light.png') }}" alt="FMAP Media"
                            height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="FMAP Media" height="22">
                    </span>
                </a>
            </div>

            {{-- Sidebar Toggle --}}
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            {{-- Search --}}
            <form class="app-search d-none d-lg-block" action="#" method="GET">
                <div class="position-relative">
                    <input type="text" name="search" class="form-control" placeholder="Search admin panel...">
                    <span class="ri-search-line"></span>
                </div>
            </form>

        </div>

        <div class="d-flex">

            {{-- Mobile Search --}}
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3" action="#" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search admin panel...">

                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- Fullscreen --}}
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            {{-- Notifications --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    <span class="noti-dot"></span>
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">

                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">Notifications</h6>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0);" class="small">View All</a>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        <div class="text-center text-muted py-4">
                            <i class="ri-notification-off-line d-block font-size-24 mb-2"></i>
                            No new notifications
                        </div>
                    </div>

                </div>
            </div>

            {{-- User Profile --}}
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('backend/assets/images/users/default-avatar.png') }}"
                        alt="{{ auth()->user()->first_name ?? 'Admin' }}">

                    <span class="d-none d-xl-inline-block ms-1">
                        {{ auth()->user()->first_name ?? 'Admin' }}
                    </span>

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-line align-middle me-1"></i>
                        Dashboard
                    </a>

                    <a class="dropdown-item" href="#">
                        <i class="ri-user-line align-middle me-1"></i>
                        My Profile
                    </a>

                    <a class="dropdown-item" href="#">
                        <i class="ri-settings-3-line align-middle me-1"></i>
                        Account Settings
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('admin-header-logout-form').submit();">
                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                        Logout
                    </a>

                    <form id="admin-header-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>


<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="ri-dashboard-line me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    {{-- Users --}}
                  <li class="nav-item dropdown {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle arrow-none"
       href="#"
       id="topnav-users"
       role="button">
        <i class="ri-user-settings-line me-2"></i>
        User Management
        <div class="arrow-down"></div>
    </a>

    <div class="dropdown-menu" aria-labelledby="topnav-users">

        <a href="{{ route('admin.users.index') }}"
           class="dropdown-item {{ request()->routeIs('admin.users.index') && !request('role') ? 'active' : '' }}">
            <i class="ri-group-line me-2"></i>
            All Users
        </a>

        <a href="{{ route('admin.users.index', ['role' => 'Admin']) }}"
           class="dropdown-item {{ request('role') == 'Admin' ? 'active' : '' }}">
            <i class="ri-shield-user-line me-2"></i>
            Administrators
        </a>

        <a href="{{ route('admin.users.index', ['role' => 'Vendor']) }}"
           class="dropdown-item {{ request('role') == 'Vendor' ? 'active' : '' }}">
            <i class="ri-store-2-line me-2"></i>
            Vendors
        </a>

        <a href="{{ route('admin.users.index', ['role' => 'Customer']) }}"
           class="dropdown-item {{ request('role') == 'Customer' ? 'active' : '' }}">
            <i class="ri-user-3-line me-2"></i>
            Customers
        </a>

        <div class="dropdown-divider"></div>

        <a href="{{ route('admin.users.create') }}"
           class="dropdown-item">
            <i class="ri-user-add-line me-2"></i>
            Add New User
        </a>

    </div>
</li>

                    {{-- Marketplace --}}
                    <li
                        class="nav-item dropdown
{{ request()->routeIs('admin.products.*') || request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">

                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-products"
                            role="button">

                            <i class="ri-shopping-bag-3-line me-2"></i>
                            Products

                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="topnav-products">

                            <a href="{{ route('admin.products.index') }}"
                                class="dropdown-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                <i class="ri-book-open-line me-2"></i>
                                All Products
                            </a>

                            <a href="{{ route('admin.products.create') }}"
                                class="dropdown-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                <i class="ri-add-circle-line me-2"></i>
                                Add Product
                            </a>
                            <a href="{{ route('admin.product-categories.index') }}"
                                class="dropdown-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                <i class="ri-add-circle-line me-2"></i>
                                Category
                            </a>



                        </div>
                    </li>

                    {{-- Media Services --}}
                    <li
                        class="nav-item dropdown
{{ request()->routeIs('admin.news*') ||
request()->routeIs('admin.news-categories*') ||
request()->routeIs('admin.tags*') ||
request()->routeIs('admin.comments*')
    ? 'active'
    : '' }}">

                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-news"
                            role="button">

                            <i class="ri-newspaper-line me-2"></i>
                            News Management
                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="topnav-news">

                            <a href="{{ route('admin.news.index') }}"
                                class="dropdown-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                                <i class="ri-article-line me-2"></i>
                                All News
                            </a>

                            <a href="{{ route('admin.news.create') }}" class="dropdown-item">
                                <i class="ri-add-circle-line me-2"></i>
                                Add News
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="{{ route('admin.news-categories.index') }}"
                                class="dropdown-item {{ request()->routeIs('admin.news-categories.*') ? 'active' : '' }}">
                                <i class="ri-folder-line me-2"></i>
                                News Categories
                            </a>

                            <a href="#" class="dropdown-item disabled">
                                <i class="ri-price-tag-3-line me-2"></i>
                                Tags
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>

                            <a href="#" class="dropdown-item disabled">
                                <i class="ri-chat-1-line me-2"></i>
                                Comments
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="#" class="dropdown-item disabled">
                                <i class="ri-bar-chart-line me-2"></i>
                                News Analytics
                                <span class="badge bg-info float-end">Soon</span>
                            </a>

                        </div>

                    </li>

                    {{-- Finance --}}
                    <li
                        class="nav-item dropdown {{ request()->routeIs('admin.payments.*') || request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-finance"
                            role="button">
                            <i class="ri-bank-card-line me-2"></i>
                            Finance
                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="topnav-finance">
                            <a href="#" class="dropdown-item">
                                Payments
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>

                            <a href="#" class="dropdown-item">
                                Vendor Payouts
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>

                            <a href="#" class="dropdown-item">
                                Transactions
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>
                        </div>
                    </li>

                    {{-- Settings --}}
                    <li class="nav-item dropdown {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-settings"
                            role="button">
                            <i class="ri-settings-3-line me-2"></i>
                            Settings
                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="topnav-settings">
                            <a href="#" class="dropdown-item">
                                Site Settings
                            </a>

                            <a href="#" class="dropdown-item">
                                Roles & Permissions
                            </a>

                            <a href="#" class="dropdown-item">
                                System Logs
                                <span class="badge bg-warning float-end">Soon</span>
                            </a>
                        </div>
                    </li>

                </ul>
            </div>

        </nav>
    </div>
</div>




