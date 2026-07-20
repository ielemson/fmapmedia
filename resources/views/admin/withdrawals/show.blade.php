@extends("admin.layout.app")

@section("title", "Withdrawal Details")

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">
            Withdrawal Request
        </span>

        <h1>{{ $withdrawal->reference }}</h1>

        <p>
            Review vendor withdrawal details and payment information.
        </p>
    </div>

    <div class="dashboard-hero-actions">

        <a href="{{ route('admin.withdrawals.index') }}"
           class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>
</div>

@include('frontend.partials.alert')

<div class="card mt-4">

    <div class="card-header">
        Administrative Actions
    </div>

    <div class="card-body">

        {{-- Pending Withdrawal --}}
        @if($withdrawal->status === 'pending')

            <div class="alert alert-warning">
                This withdrawal request is awaiting administrative review.
            </div>

            {{-- Approve --}}
            <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}"
                  method="POST"
                  class="mb-4">

                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">
                        Approval Note
                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control"
                              placeholder="Optional internal note"></textarea>
                </div>

                <button class="btn btn-success w-100"
                        onclick="return confirm('Approve this withdrawal request?')">
                    <i class="bi bi-check-circle"></i>
                    Approve Withdrawal
                </button>
            </form>

            <hr>

            {{-- Reject --}}
            <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">
                        Reason for Rejection
                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control"
                              required
                              placeholder="Provide a reason for rejecting this request"></textarea>
                </div>

                <button class="btn btn-danger w-100"
                        onclick="return confirm('Reject this withdrawal request?')">
                    <i class="bi bi-x-circle"></i>
                    Reject Withdrawal
                </button>

            </form>

        {{-- Approved Withdrawal --}}
        @elseif($withdrawal->status === 'approved')

            <div class="alert alert-info">
                This request has been approved and is awaiting payment.
            </div>

            <form action="{{ route('admin.withdrawals.mark-paid', $withdrawal) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">
                        Payment Reference
                    </label>

                    <input type="text"
                           name="payment_reference"
                           class="form-control"
                           placeholder="Bank transfer reference"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Payment Note
                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control"
                              placeholder="Optional payment note"></textarea>
                </div>

                <button class="btn btn-primary w-100"
                        onclick="return confirm('Mark this withdrawal as paid?')">
                    <i class="bi bi-cash-stack"></i>
                    Mark As Paid
                </button>

            </form>

        {{-- Paid Withdrawal --}}
        @elseif($withdrawal->status === 'paid')

            <div class="alert alert-success mb-0">
                <i class="bi bi-check-circle-fill"></i>
                This withdrawal has already been paid.

                @if($withdrawal->paid_at)
                    <hr>

                    <strong>Paid On:</strong>
                    {{ $withdrawal->paid_at->format('d M Y h:i A') }}
                @endif
            </div>

        {{-- Rejected Withdrawal --}}
        @elseif($withdrawal->status === 'rejected')

            <div class="alert alert-danger mb-0">
                <i class="bi bi-x-circle-fill"></i>
                This withdrawal request was rejected.

                @if($withdrawal->remarks)
                    <hr>

                    <strong>Reason:</strong><br>
                    {{ $withdrawal->remarks }}
                @endif
            </div>

        @endif

    </div>

</div>
@endsection