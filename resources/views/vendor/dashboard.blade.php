@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Partner</span>

        <h1>Welcome, {{ $user->first_name }} {{ $user->last_name }}</h1>

        <p>
            Promote individual FMAP Magazine editions using product-specific referral links,
            track clicks, monitor confirmed sales, and manage your commissions from one dashboard.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="#magazines-to-promote" class="btn btn-primary">
            <i class="bi bi-journal-richtext"></i>
            Promote Magazines
        </a>

        <a href="javascript:;" class="btn btn-light">
            <i class="bi bi-graph-up-arrow"></i>
            View Performance
        </a>
    </div>

    {{-- <div class="dashboard-kpi-grid">

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon primary">
                <i class="bi bi-cursor-fill"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Total Clicks</span>
                <strong>{{ number_format($totalClicks ?? 0) }}</strong>
                <small>
                    <i class="bi bi-calendar-check"></i>
                    Today: {{ number_format($todayClicks ?? 0) }}
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon success">
                <i class="bi bi-bag-check-fill"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Magazine Sales</span>
                <strong>{{ number_format($totalSales ?? 0) }}</strong>
                <small>
                    <i class="bi bi-cash"></i>
                    ₦{{ number_format($totalSalesAmount ?? 0, 2) }}
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon warning">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Total Commission</span>
                <strong>₦{{ number_format($totalCommission ?? 0, 2) }}</strong>
                <small>
                    <i class="bi bi-hourglass-split"></i>
                    Pending: ₦{{ number_format($pendingCommission ?? 0, 2) }}
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon info">
                <i class="bi bi-bank2"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Available Balance</span>
                <strong>₦{{ number_format($availableBalance ?? 0, 2) }}</strong>
                <small>
                    <i class="bi bi-check-circle"></i>
                    Paid: ₦{{ number_format($paidCommission ?? 0, 2) }}
                </small>
            </div>
        </div>

    </div> --}}
</div>
<section class="section">
    <h5 class="section-title mb-3">Performance Overview</h5>

    <div class="row g-4">

        <!-- Total Clicks -->
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cursor-fill fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format($totalClicks ?? 0) }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            <i class="bi bi-calendar-check"></i>
                            Total Clicks
                        </p>

                        <small class="text-muted">
                            Today: {{ number_format($todayClicks ?? 0) }}
                        </small>
                    </div>

                    <span class="badge bg-primary">
                        Clicks
                    </span>
                </div>
            </div>
        </div>

        <!-- Sales -->
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format($totalSales ?? 0) }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            <i class="bi bi-cash"></i>
                            Magazine Sales
                        </p>

                        <small class="text-muted">
                            ₦{{ number_format($totalSalesAmount ?? 0, 2) }}
                        </small>
                    </div>

                    <span class="badge bg-success">
                        Sales
                    </span>
                </div>
            </div>
        </div>

        <!-- Commission -->
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-warning text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($totalCommission ?? 0, 2) }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            <i class="bi bi-wallet2"></i>
                            Total Commission
                        </p>

                        <small class="text-muted">
                            Pending: ₦{{ number_format($pendingCommission ?? 0, 2) }}
                        </small>
                    </div>

                    <span class="badge bg-warning text-dark">
                        Earnings
                    </span>
                </div>
            </div>
        </div>

        <!-- Balance -->
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-info text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank2 fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($availableBalance ?? 0, 2) }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            <i class="bi bi-credit-card"></i>
                            Available Balance
                        </p>

                        <small class="text-muted">
                            Paid: ₦{{ number_format($paidCommission ?? 0, 2) }}
                        </small>
                    </div>

                    <span class="badge bg-info">
                        Balance
                    </span>
                </div>
            </div>
        </div>

    </div>
</section>
<div class="row g-4 mt-2">
    <div class="col-xl-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    Vendor Details
                </h5>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Vendor Code</span>
                    <strong>{{ $vendor->vendor_code ?? 'Pending' }}</strong>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Status</span>

                    <span class="badge bg-success text-capitalize">
                        {{ $vendor->status ?? 'Pending' }}
                    </span>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Commission Type</span>

                    <strong class="text-capitalize">
                        {{ $vendor->commission_type ?? 'Not Set' }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between pt-2">
                    <span class="text-muted">Commission Rate</span>

                    <strong class="text-primary">
                        {{ $vendor->commission_value ?? 0 }}
                        {{ ($vendor->commission_type ?? '') === 'percentage' ? '%' : '' }}
                    </strong>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-megaphone text-success me-2"></i>
                    How Product Referral Works
                </h5>
            </div>

            <div class="card-body">
                <p class="text-muted mb-3">
                    Each magazine below has its own unique referral link attached to your vendor account.
                    Copy or share a specific magazine link to earn commission when a customer buys that edition.
                </p>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 h-100">
                            <i class="bi bi-journal-richtext text-primary fs-4"></i>
                            <h6 class="mt-2 mb-1">Choose Magazine</h6>
                            <small class="text-muted">Select the exact magazine edition you want to promote.</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 h-100">
                            <i class="bi bi-share text-success fs-4"></i>
                            <h6 class="mt-2 mb-1">Share Link</h6>
                            <small class="text-muted">Use WhatsApp, Facebook, X, email, or direct copy.</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 h-100">
                            <i class="bi bi-cash-stack text-warning fs-4"></i>
                            <h6 class="mt-2 mb-1">Earn Commission</h6>
                            <small class="text-muted">Commission is tracked when payment is confirmed.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<section class="section mt-4" id="magazines-to-promote">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="section-title mb-1">Magazines to Promote</h5>
            <p class="text-muted mb-0 small">
                Every magazine has a dedicated referral link attached to your vendor account.
            </p>
        </div>

        <a href="javascript:;" class="btn btn-sm btn-outline-primary">
            View All
        </a>
    </div>

    <div class="row g-4">

        @forelse($magazines as $magazine)

            @php
                $magazineReferralLink = route('referral.product', [
                    'referralSlug' => $vendor->referral_slug,
                    'productSlug' => $magazine->slug,
                ]);

                $shareText = 'Buy ' . $magazine->name . ' on FMAP Media here: ' . $magazineReferralLink;
            @endphp

            <div class="col-xl-4 col-md-6">
                <div class="card h-100 widget-blog-card border-0 shadow-sm">

                    <div class="widget-blog-image">
                        <img src="{{ asset('storage/' . $magazine->image) }}"
                             alt="{{ $magazine->name }}">

                        <span class="widget-blog-read-time">
                            ₦{{ number_format($magazine->price, 2) }}
                        </span>
                    </div>

                    <div class="card-body">

                        <span class="badge badge-soft-primary mb-2">
                            {{ ucfirst($magazine->status) }}
                        </span>

                        <h6 class="widget-blog-title">
                            {{ $magazine->name }}
                        </h6>

                        <p class="text-muted small mb-3">
                            {{ Str::limit(strip_tags($magazine->desc), 80) }}
                        </p>

                        <label class="form-label small text-muted">
                            Product Referral Link
                        </label>

                        <div class="input-group input-group-sm mb-3">
                            <input type="text"
                                   id="magazineReferralLink{{ $magazine->id }}"
                                   class="form-control"
                                   value="{{ $magazineReferralLink }}"
                                   readonly>

                            <button type="button"
                                    class="btn btn-primary"
                                    onclick="copyMagazineReferralLink({{ $magazine->id }})">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="https://wa.me/?text={{ urlencode($shareText) }}"
                               target="_blank"
                               class="btn btn-sm btn-success flex-fill">
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </a>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($magazineReferralLink) }}"
                               target="_blank"
                               class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </a>

                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareText) }}"
                               target="_blank"
                               class="btn btn-sm btn-dark flex-fill">
                                <i class="bi bi-twitter-x"></i>
                                X
                            </a>

                            <a href="mailto:?subject={{ urlencode('FMAP Magazine: ' . $magazine->name) }}&body={{ urlencode($shareText) }}"
                               class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bi bi-envelope"></i>
                                Email
                            </a>

                        </div>

                    </div>

                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>

                        <h5 class="mt-3">No magazine available</h5>

                        <p class="text-muted mb-0">
                            Published magazines will appear here for vendors to promote.
                        </p>
                    </div>
                </div>
            </div>

        @endforelse

    </div>
</section>

<script>
    function showToast(message, className = "bg-success") {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            close: true,
            stopOnFocus: true,
            className: className
        }).showToast();
    }

    function copyMagazineReferralLink(magazineId) {
        const input = document.getElementById('magazineReferralLink' + magazineId);

        if (!input) {
            showToast("Referral link not found.", "bg-danger");
            return;
        }

        navigator.clipboard.writeText(input.value)
            .then(() => {
                showToast("Product referral link copied successfully.");
            })
            .catch(() => {
                showToast("Unable to copy product referral link.", "bg-danger");
            });
    }
</script>

@endsection