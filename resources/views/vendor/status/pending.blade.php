@extends("vendor.layout.app")

@section("main-header")
      @include("vendor.partials.sus-mainsidebar")
@endsection


@section("main-content")
<div class="dashboard-section">
    <div class="dashboard-panel text-center p-5">
        <div class="mb-3">
            <i class="bi bi-hourglass-split display-4 text-warning"></i>
        </div>

        <h3>Vendor Account Pending Approval</h3>

        <p class="text-muted">
            Hello {{ $user->name ?? $user->first_name }}, your vendor account is currently under review.
            You will be able to access your full vendor dashboard once your account is approved.
        </p>

        <span class="badge bg-warning text-dark px-4 py-2">
            {{ ucfirst($vendor->status) }}
        </span>
    </div>
</div>
@endsection