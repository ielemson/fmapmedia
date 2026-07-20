@extends("vendor.layout.app")

@section("main-header")
      @include("vendor.partials.sus-mainsidebar")
@endsection

@section("main-content")
<div class="dashboard-section">
    <div class="dashboard-panel text-center p-5">
        <div class="mb-3">
            <i class="bi bi-x-circle display-4 text-danger"></i>
        </div>

        <h3>Vendor Application Rejected</h3>

        <p class="text-muted">
            Hello {{ $user->name ?? $user->first_name }}, your vendor application was not approved.
            Please contact support for further clarification.
        </p>

        <span class="badge bg-danger px-4 py-2">
            {{ ucfirst($vendor->status) }}
        </span>
    </div>
</div>
@endsection