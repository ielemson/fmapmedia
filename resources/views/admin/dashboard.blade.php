@extends("admin.layout.app")

@section("main-content")
    
<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Super Administrator</span>

        <h1>Welcome back, {{ $user->name }}</h1>

        <p>
            Manage users, vendors, customers and oversee every aspect of the FMAP Media platform
            from one centralized administration dashboard.
        </p>
    </div>

    <div class="dashboard-hero-actions">
      <div class="dashboard-hero-actions">
    <a href="{{ route('index') }}" class="btn btn-outline-primary">
        <i class="bi bi-house-door"></i>
        Home
    </a>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i>
        Add User
    </a>

    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        <i class="bi bi-people"></i>
        Manage Users
    </a>
</div>
    </div>

    <div class="dashboard-kpi-grid">

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon primary">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Total Users</span>

                <strong>{{ number_format($totalUsers) }}</strong>

                <small>
                    <i class="bi bi-person"></i>
                    Registered accounts
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon success">
                <i class="bi bi-shield-check"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Administrators</span>

                <strong>{{ number_format($totalAdmins) }}</strong>

                <small>
                    <i class="bi bi-person-badge"></i>
                    System administrators
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon warning">
                <i class="bi bi-shop"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Vendors</span>

                <strong>{{ number_format($totalVendors) }}</strong>

                <small>
                    <i class="bi bi-link-45deg"></i>
                    Referral partners
                </small>
            </div>
        </div>

        <div class="dashboard-kpi-card">
            <div class="dashboard-kpi-icon info">
                <i class="bi bi-person-heart"></i>
            </div>

            <div class="dashboard-kpi-content">
                <span>Customers</span>

                <strong>{{ number_format($totalCustomers) }}</strong>

                <small>
                    <i class="bi bi-cart-check"></i>
                    Registered customers
                </small>
            </div>
        </div>

    </div>
    
    <div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon primary">
        <i class="bi bi-journal-richtext"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Total Magazines</span>

        <strong>{{ number_format($totalProducts) }}</strong>

        <small>
            <i class="bi bi-book"></i>
            Published and draft magazines
        </small>
    </div>
</div>

<div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon success">
        <i class="bi bi-bag-check"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Total Orders</span>

        <strong>{{ number_format($totalOrders) }}</strong>

        <small>
            <i class="bi bi-receipt"></i>
            All customer orders
        </small>
    </div>
</div>

<div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon info">
        <i class="bi bi-credit-card"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Paid Orders</span>

        <strong>{{ number_format($paidOrders) }}</strong>

        <small>
            <i class="bi bi-check-circle"></i>
            Successfully paid orders
        </small>
    </div>
</div>

<div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon warning">
        <i class="bi bi-hourglass-split"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Pending Orders</span>

        <strong>{{ number_format($pendingOrders) }}</strong>

        <small>
            <i class="bi bi-clock"></i>
            Awaiting payment
        </small>
    </div>
</div>

<div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon success">
        <i class="bi bi-cash-stack"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Total Sales</span>

        <strong>₦{{ number_format($totalSales, 2) }}</strong>

        <small>
            <i class="bi bi-graph-up-arrow"></i>
            Revenue from paid orders
        </small>
    </div>
</div>

<div class="dashboard-kpi-card">
    <div class="dashboard-kpi-icon warning">
        <i class="bi bi-wallet2"></i>
    </div>

    <div class="dashboard-kpi-content">
        <span>Total Commission</span>

        <strong>₦{{ number_format($totalCommission, 2) }}</strong>

        <small>
            <i class="bi bi-shop"></i>
            Vendor commission earned
        </small>
    </div>
</div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">

            <div>
                <h5 class="mb-1">
                    <i class="bi bi-wallet2 me-1"></i>
                    Recent Withdrawal Requests
                </h5>

                <p class="text-muted small mb-0">
                    Review and manage vendor withdrawal requests.
                </p>
            </div>

            <a href="{{ route('admin.withdrawals.index') }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-list-ul me-1"></i>
                View All Withdrawals
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Vendor</th>
                        <th>Bank Details</th>
                        <th>Amount</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($withdrawals as $key => $withdrawal)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                <strong>
                                    {{ $withdrawal->reference ?? 'N/A' }}
                                </strong>
                            </td>

                            <td>
                                <div>
                                    <strong>
                                        {{ $withdrawal->vendor?->business_name
                                            ?? $withdrawal->vendor?->user?->name
                                            ?? 'Unknown Vendor' }}
                                    </strong>

                                    @if($withdrawal->vendor?->user?->email)
                                        <div class="text-muted small">
                                            {{ $withdrawal->vendor->user->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($withdrawal->bankAccount)
                                    <div>
                                        <strong>
                                            {{ $withdrawal->bankAccount->bank_name }}
                                        </strong>

                                        <div class="text-muted small">
                                            {{ $withdrawal->bankAccount->account_name }}
                                        </div>

                                        <div class="text-muted small">
                                            {{ $withdrawal->bankAccount->account_number }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">
                                        No bank account
                                    </span>
                                @endif
                            </td>

                            <td>
                                <strong>
                                    ₦{{ number_format((float) $withdrawal->amount, 2) }}
                                </strong>
                            </td>

                            <td>
                                {{ $withdrawal->created_at?->format('M d, Y') }}

                                <div class="text-muted small">
                                    {{ $withdrawal->created_at?->format('h:i A') }}
                                </div>
                            </td>

                            <td>
                                @switch($withdrawal->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                        @break

                                    @case('approved')
                                        <span class="badge bg-info text-dark">
                                            Approved
                                        </span>
                                        @break

                                    @case('paid')
                                        <span class="badge bg-success">
                                            Paid
                                        </span>
                                        @break

                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>
                                        @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                @endswitch
                            </td>

                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        Actions
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.withdrawals.show', $withdrawal) }}">
                                                <i class="bi bi-eye me-2"></i>
                                                View Details
                                            </a>
                                        </li>

                                        @if($withdrawal->status === 'pending')
                                            <li>
                                                <a class="dropdown-item text-success"
                                                   href="{{ route('admin.withdrawals.show', $withdrawal) }}#approve-withdrawal">
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    Review and Approve
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item text-danger"
                                                   href="{{ route('admin.withdrawals.show', $withdrawal) }}#reject-withdrawal">
                                                    <i class="bi bi-x-circle me-2"></i>
                                                    Review and Reject
                                                </a>
                                            </li>
                                        @endif

                                        @if($withdrawal->status === 'approved')
                                            <li>
                                                <a class="dropdown-item text-primary"
                                                   href="{{ route('admin.withdrawals.show', $withdrawal) }}#mark-paid">
                                                    <i class="bi bi-cash-stack me-2"></i>
                                                    Process Payment
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="text-center py-5">

                                <i class="bi bi-wallet2 fs-1 text-muted"></i>

                                <h6 class="mt-3 mb-1">
                                    No withdrawal requests
                                </h6>

                                <p class="text-muted mb-0">
                                    Vendor withdrawal requests will appear here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($withdrawals->isNotEmpty())
        <div class="card-footer bg-white border-top text-end">
            <a href="{{ route('admin.withdrawals.index') }}"
               class="btn btn-outline-primary btn-sm">
                View All Withdrawal Requests
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    @endif
</div>
@endsection