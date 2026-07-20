<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}" alt="FMAP Media">
            </span>

            <span class="sidebar-logo-text">
                <span class="sidebar-logo-name">FMAP Media</span>
                <span class="sidebar-logo-label">Admin Suite</span>
            </span>
        </a>

        <button class="sidebar-close" type="button">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-menu">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-heading">
                <span>Content Management</span>
            </li>

            <li class="nav-item has-submenu {{ request()->routeIs('admin.news.*') ? 'open' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="#"
                    aria-expanded="{{ request()->routeIs('admin.news.*') ? 'true' : 'false' }}">
                    <i class="bi bi-newspaper"></i>
                    <span>News</span>
                    <i class="bi bi-chevron-down nav-arrow"></i>
                </a>

                <ul class="nav-submenu {{ request()->routeIs('admin.news.*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.news.index') ? 'active' : '' }}"
                            href="{{ route('admin.news.index') }}">
                            All News
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.news.create') ? 'active' : '' }}"
                            href="{{ route('admin.news.create') }}">
                            Add News
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu {{ request()->routeIs('admin.news-categories.*') ? 'open' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.news-categories.*') ? 'active' : '' }}" href="#"
                    aria-expanded="{{ request()->routeIs('admin.news-categories.*') ? 'true' : 'false' }}">
                    <i class="bi bi-tags"></i>
                    <span>News Categories</span>
                    <i class="bi bi-chevron-down nav-arrow"></i>
                </a>

                <ul class="nav-submenu {{ request()->routeIs('admin.news-categories.*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.news-categories.index') ? 'active' : '' }}"
                            href="{{ route('admin.news-categories.index') }}">
                            All Categories
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.news-categories.create') ? 'active' : '' }}"
                            href="{{ route('admin.news-categories.create') }}">
                            Add Category
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-heading">
                <span>Marketplace</span>
            </li>

            <li class="nav-item has-submenu {{ request()->routeIs('admin.products.*') ? 'open' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="#"
                    aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
                    <i class="bi bi-bag"></i>
                    <span>Products</span>
                    <i class="bi bi-chevron-down nav-arrow"></i>
                </a>

                <ul class="nav-submenu {{ request()->routeIs('admin.products.*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">
                            All Products
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                            href="{{ route('admin.products.create') }}">
                            Add Product
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu {{ request()->routeIs('admin.product-categories.*') ? 'open' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}"
                    href="#"
                    aria-expanded="{{ request()->routeIs('admin.product-categories.*') ? 'true' : 'false' }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>Product Categories</span>
                    <i class="bi bi-chevron-down nav-arrow"></i>
                </a>

                <ul class="nav-submenu {{ request()->routeIs('admin.product-categories.*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.product-categories.index') ? 'active' : '' }}"
                            href="{{ route('admin.product-categories.index') }}">
                            All Categories
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.product-categories.create') ? 'active' : '' }}"
                            href="{{ route('admin.product-categories.create') }}">
                            Add Category
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-heading">
                <span>User Management</span>
            </li>

            <li class="nav-item has-submenu {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#"
                    aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                    <i class="bi bi-chevron-down nav-arrow"></i>
                </a>

                <ul class="nav-submenu {{ request()->routeIs('admin.users.*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            All Users
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                            href="{{ route('admin.users.create') }}">
                            Add User
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-heading">
                <span>Future Modules</span>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}"
                    href="{{ route('admin.vendors.index') }}">

                    <i class="bi bi-shop me-2"></i>

                    <span>Vendors</span>

                    @php
                        $pendingVendors = \App\Models\Vendor::where('status', 'pending')->count();
                    @endphp

                    @if ($pendingVendors > 0)
                        <span class="badge bg-warning text-dark ms-auto">
                            {{ $pendingVendors }}
                        </span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-cart-check"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}"
                    href="{{ route('admin.team-members.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Team Members</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                    href="{{ route('admin.services.index') }}">
                    <i class="bi bi-briefcase"></i>
                    <span>Services</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}"
                    href="{{ route('admin.support.index') }}">

                    <i class="bi bi-headset"></i>

                    <span>Support Tickets</span>
                </a>
            </li>

            <li class="nav-heading">
                <span>System</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}"
                    href="{{ route('admin.settings.general') }}">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                    {{-- <small class="ms-auto">Soon</small> --}}
                </a>
            </li>

        </ul>
    </nav>
</aside>
