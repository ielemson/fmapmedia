@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Payouts</span>

        <h1>Withdrawals</h1>

        <p>
            Request payout of your available commission balance to your registered bank account.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('vendor.bank-accounts.index') }}" class="btn btn-primary">
            <i class="bi bi-bank"></i>
            Bank Accounts
        </a>

        <a href="{{ route('vendor.commissions.index') }}" class="btn btn-light">
            <i class="bi bi-cash-stack"></i>
            Commissions
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<section class="section">
    <h5 class="section-title mb-3">Payout Overview</h5>

    <div class="row g-4">

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($totalCommission ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">Total Commission</p>
                    </div>

                    <span class="badge bg-success">Earned</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-warning text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($pendingWithdrawals ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">Pending Payout</p>
                    </div>

                    <span class="badge bg-warning text-dark">Pending</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-info text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank2 fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($paidWithdrawals ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">Paid Out</p>
                    </div>

                    <span class="badge bg-info">Paid</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            ₦{{ number_format($availableBalance ?? 0, 2) }}
                        </h6>
                        <p class="widget-user-location mb-0">Available Balance</p>
                    </div>

                    <span class="badge bg-primary">Balance</span>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="section mt-4">
    <div class="row g-4">

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-send text-primary me-2"></i>
                        Request Withdrawal
                    </h5>
                </div>

                <div class="card-body">

                    @if($bankAccounts->count())

                        <form method="POST" action="{{ route('vendor.withdrawals.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Bank Account</label>

                                <select name="vendor_bank_account_id"
                                        class="form-select @error('vendor_bank_account_id') is-invalid @enderror">
                                    <option value="">Select Bank Account</option>

                                    @foreach($bankAccounts as $account)
                                        <option value="{{ $account->id }}"
                                            @selected(old('vendor_bank_account_id') == $account->id || $account->is_default)>
                                            {{ $account->bank_name }} - {{ $account->account_number }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('vendor_bank_account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <div class="mb-3">
    <label class="form-label">
        Withdrawal Amount
    </label>

    <input type="number"
           name="amount"
           step="0.01"
           min="1000"
           @if(($availableBalance ?? 0) >= 1000)
               max="{{ $availableBalance }}"
           @endif
           value="{{ old('amount') }}"
           class="form-control @error('amount') is-invalid @enderror"
           placeholder="Minimum withdrawal is ₦1,000">

    @error('amount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    <div class="mt-2">
        <small class="text-muted d-block">
            Available Balance:
            <strong class="text-success">
                ₦{{ number_format($availableBalance ?? 0, 2) }}
            </strong>
        </small>

        <small class="text-muted d-block">
            Minimum Withdrawal:
            <strong>₦1,000.00</strong>
        </small>

        @if(($availableBalance ?? 0) < 1000)
            <small class="text-danger d-block mt-2">
                <i class="bi bi-exclamation-circle me-1"></i>
                Your available balance is below the minimum withdrawal amount.
            </small>
        @endif
    </div>
</div>

<button type="submit"
        class="btn btn-primary w-100"
        @disabled(($availableBalance ?? 0) < 1000)>
    <i class="bi bi-send me-1"></i>

    @if(($availableBalance ?? 0) < 1000)
        Insufficient Balance
    @else
        Submit Request
    @endif
</button>
                        </form>

                    @else

                        <div class="text-center py-4">
                            <i class="bi bi-bank display-5 text-muted"></i>
                            <h6 class="mt-3">No bank account found</h6>
                            <p class="text-muted small">
                                Add your bank account before requesting withdrawal.
                            </p>

                            <a href="{{ route('vendor.bank-accounts.create') }}" class="btn btn-primary">
                                Add Bank Account
                            </a>
                        </div>

                    @endif

                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history text-success me-2"></i>
                        Withdrawal History
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Bank</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td>
                                            <strong>{{ $withdrawal->reference }}</strong>
                                        </td>

                                        <td>
                                            <strong>{{ $withdrawal->bankAccount?->bank_name ?? 'N/A' }}</strong>
                                            <small class="d-block text-muted">
                                                {{ $withdrawal->bankAccount?->account_number }}
                                            </small>
                                        </td>

                                        <td>
                                            ₦{{ number_format($withdrawal->amount, 2) }}
                                        </td>

                                        <td>
                                            @if($withdrawal->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($withdrawal->status === 'approved')
                                                <span class="badge bg-primary">Approved</span>
                                            @elseif($withdrawal->status === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $withdrawal->created_at->format('d M, Y h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bi bi-wallet-x display-5 d-block mb-2"></i>
                                            No withdrawal request yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $withdrawals->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection