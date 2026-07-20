@extends("vendor.layout.app")

@section("main-header")
      @include("vendor.partials.sus-mainsidebar")
@endsection


@section("main-content")
<div class="dashboard-section">
    <div class="dashboard-panel text-center p-5">
        <div class="mb-3">
            <i class="bi bi-shield-exclamation display-4 text-secondary"></i>
        </div>

        <h3>Vendor Account Suspended</h3>

        <p class="text-muted">
            Hello {{ $user->name ?? $user->first_name }}, your vendor account is currently suspended.
            Please contact support to resolve this issue.
        </p>

        <span class="badge bg-secondary px-4 py-2">
            {{ ucfirst($vendor->status) }}
        </span>
    </div>
</div>
@endsection