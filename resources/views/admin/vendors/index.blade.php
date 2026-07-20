@extends("admin.layout.app")

@section("title", "Vendor Management")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Vendor Management</span>

            <h1>Vendors</h1>

            <p>
                Review vendor registrations, approve qualified vendors,
                reject applications, and manage existing vendor accounts.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}"
               class="btn btn-primary">
                <i class="bi bi-hourglass-split"></i>
                Pending Applications

                @if(($statistics['pending'] ?? 0) > 0)
                    <span class="badge bg-light text-dark ms-1">
                        {{ $statistics['pending'] }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    {{-- Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-xl col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted d-block mb-1">Total Vendors</span>
                    <h3 class="mb-0">{{ number_format($statistics['total']) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted d-block mb-1">Pending</span>
                    <h3 class="mb-0 text-warning">
                        {{ number_format($statistics['pending']) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted d-block mb-1">Approved</span>
                    <h3 class="mb-0 text-success">
                        {{ number_format($statistics['approved']) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted d-block mb-1">Rejected</span>
                    <h3 class="mb-0 text-danger">
                        {{ number_format($statistics['rejected']) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted d-block mb-1">Suspended</span>
                    <h3 class="mb-0 text-secondary">
                        {{ number_format($statistics['suspended']) }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">

            <form action="{{ route('admin.vendors.index') }}"
                  method="GET"
                  class="row g-3 align-items-end">

                <div class="col-lg-5">
                    <label for="search" class="form-label">
                        Search Vendor
                    </label>

                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Name, business, email, phone or vendor code">
                </div>

                <div class="col-lg-3">
                    <label for="status" class="form-label">
                        Vendor Status
                    </label>

                    <select name="status"
                            id="status"
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
                        <option value="rejected"
                            @selected(request('status') === 'rejected')>
                            Rejected
                        </option>
                        <option value="suspended"
                            @selected(request('status') === 'suspended')>
                            Suspended
                        </option>
                    </select>
                </div>

                {{-- <div class="col-lg-2">
                    <label for="vendor_type" class="form-label">
                        Vendor Type
                    </label>

                    <select name="vendor_type"
                            id="vendor_type"
                            class="form-select">
                        <option value="">All types</option>

                        @foreach($vendorTypes as $vendorType)
                            <option value="{{ $vendorType }}"
                                @selected(request('vendor_type') === $vendorType)>
                                {{ $vendorType }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-lg-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.vendors.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- Vendor Table --}}
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor</th>
                            <th>Business</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Commission</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th width="280">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vendors as $key => $vendor)
                            <tr>
                                <td>
                                    {{ $vendors->firstItem() + $key }}
                                </td>

                                <td>
                                    <strong class="d-block">
                                        {{ $vendor->user?->first_name }}
                                        {{ $vendor->user?->last_name }}
                                    </strong>

                                    <small class="text-muted d-block">
                                        {{ $vendor->user?->email ?? 'No email' }}
                                    </small>

                                    <small class="text-muted">
                                        {{ $vendor->phone }}
                                    </small>
                                </td>

                                <td>
                                    <strong class="d-block">
                                        {{ $vendor->business_name }}
                                    </strong>

                                    <small class="text-muted">
                                        Code:
                                        {{ $vendor->vendor_code ?? 'Not assigned' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $vendor->vendor_type }}
                                    </span>
                                </td>

                                <td>
                                    {{ $vendor->city }},
                                    {{ $vendor->state }}
                                </td>

                                <td>
                                    @if($vendor->commission_type === 'percentage')
                                        <strong>
                                            {{ number_format($vendor->commission_value, 2) }}%
                                        </strong>
                                    @else
                                        <strong>
                                            ₦{{ number_format($vendor->commission_value, 2) }}
                                        </strong>
                                    @endif

                                    <small class="text-muted d-block">
                                        {{ ucfirst($vendor->commission_type ?? 'Not set') }}
                                    </small>
                                </td>

                                <td>
                                    @switch($vendor->status)
                                        @case('approved')
                                            <span class="badge bg-success">
                                                Approved
                                            </span>
                                            @break

                                        @case('pending')
                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>
                                            @break

                                        @case('rejected')
                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>
                                            @break

                                        @case('suspended')
                                            <span class="badge bg-secondary">
                                                Suspended
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-light text-dark">
                                                Unknown
                                            </span>
                                    @endswitch
                                </td>

                                <td>
                                    {{ $vendor->created_at?->format('d M Y') }}

                                    <small class="text-muted d-block">
                                        {{ $vendor->created_at?->format('h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a href="{{ route('admin.vendors.show', $vendor) }}"
                                           class="btn btn-sm btn-primary"
                                           title="View vendor">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </a>

                                        @if($vendor->status !== 'approved')
                                            <form action="{{ route('admin.vendors.approve', $vendor) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Approve this vendor?')">
                                                    <i class="bi bi-check-circle"></i>
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if($vendor->status === 'pending')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectVendorModal{{ $vendor->id }}">
                                                <i class="bi bi-x-circle"></i>
                                                Reject
                                            </button>
                                        @endif

                                        @if($vendor->status === 'approved')
                                            <form action="{{ route('admin.vendors.suspend', $vendor) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Suspend this vendor?')">
                                                    <i class="bi bi-pause-circle"></i>
                                                    Suspend
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($vendor->status, ['rejected', 'suspended']))
                                            <form action="{{ route('admin.vendors.mark-pending', $vendor) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="return confirm('Return this vendor to pending status?')">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                    Pending
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                            {{-- Reject Modal --}}
                            <div class="modal fade"
                                 id="rejectVendorModal{{ $vendor->id }}"
                                 tabindex="-1"
                                 aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <form action="{{ route('admin.vendors.reject', $vendor) }}"
                                              method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Reject Vendor Application
                                                </h5>

                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <p>
                                                    You are about to reject
                                                    <strong>
                                                        {{ $vendor->business_name }}
                                                    </strong>.
                                                </p>

                                                <div class="mb-3">
                                                    <label for="reason{{ $vendor->id }}"
                                                           class="form-label">
                                                        Rejection Reason
                                                    </label>

                                                    <textarea name="reason"
                                                              id="reason{{ $vendor->id }}"
                                                              rows="4"
                                                              class="form-control"
                                                              maxlength="1000"
                                                              placeholder="Explain why this vendor application is being rejected"></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-light"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit"
                                                        class="btn btn-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                    Reject Vendor
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="9"
                                    class="text-center text-muted py-5">
                                    <i class="bi bi-shop fs-2 d-block mb-2"></i>
                                    No vendors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if($vendors->hasPages())
                <div class="mt-3">
                    {{ $vendors->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection