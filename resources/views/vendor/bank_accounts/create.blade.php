@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Payments</span>
        <h1>Add Bank Account</h1>
        <p>Provide your payout account details.</p>
    </div>
</div>

@include('vendor.bank_accounts.form', [
    'action' => route('vendor.bank-accounts.store'),
    'method' => 'POST',
    'buttonText' => 'Save Bank Account'
])

@endsection