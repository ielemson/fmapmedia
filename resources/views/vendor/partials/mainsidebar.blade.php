<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}" alt="FMAP Media">
            </span>

            <span class="sidebar-logo-text">
                <span class="sidebar-logo-name">FMAP Media</span>
                <span class="sidebar-logo-label">Vendor Portal</span>
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
                <span>Marketing</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard#magazines-to-promote') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}#magazines-to-promote">
                    <i class="bi bi-link-45deg"></i>
                    <span>Product Referral Links</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard#magazines-to-promote') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}#magazines-to-promote">
                    <i class="bi bi-journal-richtext"></i>
                    <span>Magazines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="javascript:;" aria-disabled="true">
                    <i class="bi bi-megaphone"></i>
                    <span>Marketing Materials</span>
                    <small class="ms-auto text-muted">Soon</small>
                </a>
            </li>

            <li class="nav-heading">
                <span>Performance</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor.sales.*') ? 'active' : '' }}"
                    href="{{ route('vendor.sales.index') }}">
                    <i class="bi bi-cart-check"></i>
                    <span>My Sales</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="javascript:;" aria-disabled="true">
                    <i class="bi bi-cursor"></i>
                    <span>Link Clicks</span>
                    <small class="ms-auto text-muted">Soon</small>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor.commissions.*') ? 'active' : '' }}"
                    href="{{ route('vendor.commissions.index') }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Commissions</span>
                </a>
            </li>

            <li class="nav-heading">
                <span>Payments</span>
            </li>

            <li class="nav-heading">
                <span>Payments</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor.withdrawals.*') ? 'active' : '' }}"
                    href="{{ route('vendor.withdrawals.index') }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Payouts</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor.bank-accounts.*') ? 'active' : '' }}"
                    href="{{ route('vendor.bank-accounts.index') }}">
                    <i class="bi bi-bank"></i>
                    <span>Bank Details</span>
                </a>
            </li>

            <li class="nav-heading">
                <span>Account</span>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="javascript:;" aria-disabled="true">
                    <i class="bi bi-person-circle"></i>
                    <span>My Profile</span>
                    <small class="ms-auto text-muted">Soon</small>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor.support.*') ? 'active' : '' }}"
                    href="{{ route('vendor.support.index') }}">

                    <i class="bi bi-headset"></i>

                    <span>Support Center</span>

                    <span class="badge rounded-pill bg-secondary ms-auto">

                        @php
                            $openSupportTickets =
                                auth()
                                    ->user()
                                    ->vendor?->supportTickets()
                                    ->whereNotIn('status', ['resolved', 'closed'])
                                    ->count() ?? 0;
                        @endphp
                        @if ($openSupportTickets > 0)
                            {{ $openSupportTickets }}
                            @else
                            0
                        @endif
                    </span>
                </a>
            </li>

            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
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
