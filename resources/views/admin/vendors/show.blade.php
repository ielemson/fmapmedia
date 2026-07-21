@extends("admin.layout.app")

@section("title", "Vendor Details")

@section("main-content")

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Vendor Management</span>

            <h1>{{ $vendor->business_name }}</h1>

            <p>
                Review the vendor’s registration information, commission
                configuration, account status, and earnings.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.vendors.index') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Back to Vendors
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header">
                    <strong>Vendor Information</strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered align-middle mb-0">
                            <tbody>

                                <tr>
                                    <th width="240">Vendor Name</th>
                                    <td>
                                        {{ $vendor->user?->first_name }}
                                        {{ $vendor->user?->last_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Business Name</th>
                                    <td>{{ $vendor->business_name }}</td>
                                </tr>

                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $vendor->user?->email }}</td>
                                </tr>

                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $vendor->phone }}</td>
                                </tr>

                                <tr>
                                    <th>Vendor Type</th>
                                    <td>{{ $vendor->vendor_type }}</td>
                                </tr>

                                <tr>
                                    <th>Location</th>
                                    <td>
                                        {{ $vendor->city }},
                                        {{ $vendor->state }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Vendor Code</th>
                                    <td>
                                        <code>
                                            {{ $vendor->vendor_code ?? 'Not assigned' }}
                                        </code>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Referral Slug</th>
                                    <td>
                                        <code>
                                            {{ $vendor->referral_slug ?? 'Not assigned' }}
                                        </code>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Vendor Status</th>
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
                                        @endswitch
                                    </td>
                                </tr>

                                <tr>
                                    <th>User Account Status</th>
                                    <td>
                                        @if($vendor->user?->status === 'active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Suspended
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Approved At</th>
                                    <td>
                                        {{ $vendor->approved_at
                                            ? $vendor->approved_at->format('d M Y, h:i A')
                                            : 'Not approved'
                                        }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Registered At</th>
                                    <td>
                                        {{ $vendor->created_at?->format('d M Y, h:i A') }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Commission and Earnings</strong>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <span class="text-muted d-block">
                                    Commission Type
                                </span>

                                <h5 class="mb-0">
                                    {{ ucfirst($vendor->commission_type ?? 'Not set') }}
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <span class="text-muted d-block">
                                    Commission Value
                                </span>

                                <h5 class="mb-0">
                                    @if($vendor->commission_type === 'percentage')
                                        {{ number_format($vendor->commission_value, 2) }}%
                                    @else
                                        ₦{{ number_format($vendor->commission_value, 2) }}
                                    @endif
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <span class="text-muted d-block">
                                    Total Earned
                                </span>

                                <h5 class="mb-0 text-success">
                                    ₦{{ number_format($vendor->total_earned, 2) }}
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <span class="text-muted d-block">
                                    Total Paid
                                </span>

                                <h5 class="mb-0 text-primary">
                                    ₦{{ number_format($vendor->total_paid, 2) }}
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <span class="text-muted d-block">
                                    Available Balance
                                </span>

                                <h5 class="mb-0">
                                    ₦{{ number_format($vendor->available_balance, 2) }}
                                </h5>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card">
    <div class="card-header">
        <strong>Vendor Actions</strong>
    </div>

    <div class="card-body">

        {{-- Approve --}}
        @if($vendor->status !== 'approved')
            <form action="{{ route('admin.vendors.approve', $vendor) }}"
                  method="POST"
                  class="vendor-action-form mb-3"
                  data-title="Approve Vendor?"
                  data-message="This vendor will gain access to the vendor dashboard, referral system and commission earnings."
                  data-icon="question"
                  data-confirm-text="Approve Vendor"
                  data-confirm-color="#198754">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle me-1"></i>
                    Approve Vendor
                </button>
            </form>
        @endif

        {{-- Reject --}}
        @if($vendor->status === 'pending')
            <button type="button"
                    class="btn btn-danger w-100 mb-3"
                    data-bs-toggle="modal"
                    data-bs-target="#rejectVendorModal">
                <i class="bi bi-x-circle me-1"></i>
                Reject Vendor
            </button>
        @endif

        {{-- Approved Actions --}}
        @if($vendor->status === 'approved')

            {{-- Suspend --}}
            <form action="{{ route('admin.vendors.suspend', $vendor) }}"
                  method="POST"
                  class="vendor-action-form mb-3"
                  data-title="Suspend Vendor?"
                  data-message="The vendor will temporarily lose access to the dashboard, referral links and commission activities."
                  data-icon="warning"
                  data-confirm-text="Suspend Vendor"
                  data-confirm-color="#ffc107">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-warning w-100">
                    <i class="bi bi-pause-circle me-1"></i>
                    Suspend Vendor
                </button>
            </form>

            {{-- Login As Vendor --}}
            @if($vendor->user)
                <form action="{{ route('admin.vendors.login-as', $vendor) }}"
                      method="POST"
                      class="vendor-action-form mb-3"
                      data-title="Login as Vendor?"
                      data-message="You are about to access {{ $vendor->user->name }}'s account. You can inspect the account exactly as the vendor sees it."
                      data-icon="info"
                      data-confirm-text="Login as Vendor"
                      data-confirm-color="#0d6efd">
                    @csrf

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Login as Vendor
                    </button>
                </form>
            @endif

        @endif

        {{-- Return to Pending --}}
        @if(in_array($vendor->status, ['rejected', 'suspended']))
            <form action="{{ route('admin.vendors.mark-pending', $vendor) }}"
                  method="POST"
                  class="vendor-action-form"
                  data-title="Return Vendor to Pending?"
                  data-message="The vendor account will be moved back to the Pending state for further review."
                  data-icon="question"
                  data-confirm-text="Return to Pending"
                  data-confirm-color="#6c757d">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Return to Pending
                </button>
            </form>
        @endif

    </div>
</div>

        </div>

    </div>

    {{-- Reject Vendor Modal --}}
    <div class="modal fade"
         id="rejectVendorModal"
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
                            Provide a reason for rejecting
                            <strong>{{ $vendor->business_name }}</strong>.
                        </p>

                        <textarea name="reason"
                                  rows="5"
                                  class="form-control"
                                  maxlength="1000"
                                  placeholder="Enter rejection reason"></textarea>

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

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.vendor-action-form').forEach(function (form) {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({
                title: form.dataset.title ?? 'Are you sure?',
                text: form.dataset.message ?? 'Please confirm this action.',
                icon: form.dataset.icon ?? 'question',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirmText ?? 'Continue',
                cancelButtonText: 'Cancel',
                confirmButtonColor: form.dataset.confirmColor ?? '#0d6efd',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                allowOutsideClick: false,
                allowEscapeKey: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
</script>
@endpush