@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Payments</span>
        <h1>Bank Accounts</h1>
        <p>Manage your payout bank details for commission withdrawals.</p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('vendor.bank-accounts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add Bank Account
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<section class="section">
    <div class="row g-4">
        @forelse($accounts as $account)
            <div class="col-xl-6 col-lg-6">
                <div class="card widget-user-card-horizontal h-100">
                    <div class="card-body">
                        <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-bank2 fs-4"></i>
                        </div>

                        <div class="widget-user-info">
                            <h6 class="widget-user-name">{{ $account->bank_name }}</h6>
                            <p class="widget-user-location mb-0">
                                <i class="bi bi-person"></i>
                                {{ $account->account_name }}
                            </p>
                            <small class="text-muted">
                                {{ $account->account_number }}
                            </small>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            @if($account->is_default)
                                <span class="badge bg-success">Default</span>
                            @else
                                <span class="badge bg-light text-dark">Account</span>
                            @endif

                            <div class="d-flex gap-1">
                                <a href="{{ route('vendor.bank-accounts.edit', $account) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('vendor.bank-accounts.destroy', $account) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this bank account?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-bank display-5 text-muted"></i>
                        <h5 class="mt-3">No bank account added</h5>
                        <p class="text-muted">Add your payout account to receive commissions.</p>

                        <a href="{{ route('vendor.bank-accounts.create') }}" class="btn btn-primary">
                            Add Bank Account
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</section>

@endsection