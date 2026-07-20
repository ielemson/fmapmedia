@extends("admin.layout.app")

@section("title", "Withdrawal Details")

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Payments</span>

        <h1>Withdrawal Requests</h1>

        <p>
            Review vendor withdrawal requests, verify bank details,
            approve valid requests and monitor completed payments.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('dashboard') }}"
           class="btn btn-light">
            <i class="bi bi-grid"></i>
            Dashboard
        </a>
    </div>
</div>

<div class="dashboard-kpi-grid">

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon primary">
            <i class="bi bi-wallet2"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Total Requests</span>

            <strong>{{ number_format($totalWithdrawals) }}</strong>

            <small>
                <i class="bi bi-list-check"></i>
                All withdrawal requests
            </small>
        </div>
    </div>

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon warning">
            <i class="bi bi-hourglass-split"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Pending</span>

            <strong>{{ number_format($pendingWithdrawals) }}</strong>

            <small>
                <i class="bi bi-clock-history"></i>
                Awaiting review
            </small>
        </div>
    </div>

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon info">
            <i class="bi bi-check2-square"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Approved</span>

            <strong>{{ number_format($approvedWithdrawals) }}</strong>

            <small>
                <i class="bi bi-bank"></i>
                Awaiting payment
            </small>
        </div>
    </div>

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon success">
            <i class="bi bi-cash-coin"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Paid</span>

            <strong>{{ number_format($paidWithdrawals) }}</strong>

            <small>
                <i class="bi bi-check-circle"></i>
                Completed payments
            </small>
        </div>
    </div>

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon danger">
            <i class="bi bi-x-circle"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Rejected</span>

            <strong>{{ number_format($rejectedWithdrawals) }}</strong>

            <small>
                <i class="bi bi-shield-x"></i>
                Declined requests
            </small>
        </div>
    </div>

    <div class="dashboard-kpi-card">
        <div class="dashboard-kpi-icon success">
            <i class="bi bi-cash-stack"></i>
        </div>

        <div class="dashboard-kpi-content">
            <span>Total Paid</span>

            <strong>
                ₦{{ number_format((float) $totalPaidAmount, 2) }}
            </strong>

            <small>
                <i class="bi bi-currency-exchange"></i>
                Amount paid to vendors
            </small>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

            <div>
                <h5 class="mb-1">
                    <i class="bi bi-wallet2 me-1"></i>
                    Vendor Withdrawal Requests
                </h5>

                <p class="text-muted small mb-0">
                    Search, filter and review withdrawal requests.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('admin.withdrawals.index') }}"
                  class="d-flex flex-column flex-md-row gap-2">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search reference or vendor">

                <select name="status"
                        class="form-select">
                    <option value="">All statuses</option>

                    <option value="pending"
                        @selected(request('status') === 'pending')>
                        Pending
                    </option>

                    <option value="approved"
                        @selected(request('status') === 'approved')>
                        Approved
                    </option>

                    <option value="paid"
                        @selected(request('status') === 'paid')>
                        Paid
                    </option>

                    <option value="rejected"
                        @selected(request('status') === 'rejected')>
                        Rejected
                    </option>
                </select>

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Filter
                </button>

                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.withdrawals.index') }}"
                       class="btn btn-light">
                        Reset
                    </a>
                @endif
            </form>
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
                        <th>Bank Account</th>
                        <th>Amount</th>
                        <th>Requested</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($withdrawals as $withdrawal)
                        <tr>
                            <td>
                                {{ $withdrawals->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $withdrawal->reference ?? 'N/A' }}
                                </strong>
                            </td>

                            <td>
                                @php
                                    $vendorName = trim(
                                        ($withdrawal->vendor?->user?->first_name ?? '') .
                                        ' ' .
                                        ($withdrawal->vendor?->user?->last_name ?? '')
                                    );
                                @endphp

                                <strong>
                                    {{ $withdrawal->vendor?->business_name
                                        ?: ($vendorName ?: 'Unknown Vendor') }}
                                </strong>

                                @if($withdrawal->vendor?->user?->email)
                                    <div class="text-muted small">
                                        {{ $withdrawal->vendor->user->email }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if($withdrawal->bankAccount)
                                    <strong>
                                        {{ $withdrawal->bankAccount->bank_name }}
                                    </strong>

                                    <div class="text-muted small">
                                        {{ $withdrawal->bankAccount->account_name }}
                                    </div>

                                    <div class="text-muted small">
                                        {{ $withdrawal->bankAccount->account_number }}
                                    </div>
                                @else
                                    <span class="text-muted">
                                        Bank account unavailable
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
                                <a href="{{ route(
                                        'admin.withdrawals.show',
                                        $withdrawal
                                    ) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="text-center py-5">

                                <i class="bi bi-wallet2 fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    No withdrawal requests found
                                </h6>

                                <p class="text-muted mb-0">
                                    Withdrawal requests submitted by vendors
                                    will appear here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    @if($withdrawals->hasPages())
        <div class="card-footer bg-white">
            {{ $withdrawals->links() }}
        </div>
    @endif

</div>
@endsection