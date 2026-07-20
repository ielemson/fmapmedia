@extends('vendor.layout.app')

@section('main-header')
    @include('vendor.partials.mainsidebar')
@endsection

@section('main-content')

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Support Center</span>

        <h1>Create Support Ticket</h1>

        <p>
            Describe the issue you are experiencing and provide enough information
            to help the FMAP Media support team resolve it quickly.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('vendor.support.index') }}"
           class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back to Tickets
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<section class="section">
    <div class="row g-4">

        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-ticket-perforated text-primary me-2"></i>
                        Ticket Information
                    </h5>
                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('vendor.support.store') }}"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                Subject
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   id="subject"
                                   name="subject"
                                   value="{{ old('subject') }}"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="Briefly describe your issue"
                                   maxlength="255"
                                   required>

                            @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="category" class="form-label">
                                    Category
                                    <span class="text-danger">*</span>
                                </label>

                                <select id="category"
                                        name="category"
                                        class="form-select @error('category') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Select issue category
                                    </option>

                                    <option value="account"
                                        @selected(old('category') === 'account')>
                                        Account
                                    </option>

                                    <option value="commission"
                                        @selected(old('category') === 'commission')>
                                        Commission
                                    </option>

                                    <option value="withdrawal"
                                        @selected(old('category') === 'withdrawal')>
                                        Withdrawal
                                    </option>

                                    <option value="payment"
                                        @selected(old('category') === 'payment')>
                                        Payment
                                    </option>

                                    <option value="referral"
                                        @selected(old('category') === 'referral')>
                                        Referral
                                    </option>

                                    <option value="technical"
                                        @selected(old('category') === 'technical')>
                                        Technical Issue
                                    </option>

                                    <option value="magazine"
                                        @selected(old('category') === 'magazine')>
                                        Magazine
                                    </option>

                                    <option value="other"
                                        @selected(old('category') === 'other')>
                                        Other
                                    </option>
                                </select>

                                @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="form-label">
                                    Priority
                                    <span class="text-danger">*</span>
                                </label>

                                <select id="priority"
                                        name="priority"
                                        class="form-select @error('priority') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Select priority
                                    </option>

                                    <option value="low"
                                        @selected(old('priority') === 'low')>
                                        Low
                                    </option>

                                    <option value="medium"
                                        @selected(old('priority', 'medium') === 'medium')>
                                        Medium
                                    </option>

                                    <option value="high"
                                        @selected(old('priority') === 'high')>
                                        High
                                    </option>

                                    <option value="urgent"
                                        @selected(old('priority') === 'urgent')>
                                        Urgent
                                    </option>
                                </select>

                                @error('priority')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-3 mb-3">
                            <label for="message" class="form-label">
                                Describe Your Issue
                                <span class="text-danger">*</span>
                            </label>

                            <textarea id="message"
                                      name="message"
                                      rows="8"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Explain the issue, when it started, and any steps you have already taken..."
                                      required>{{ old('message') }}</textarea>

                            @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                Please provide clear and complete information to help us assist you faster.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="attachment" class="form-label">
                                Attachment
                                <span class="text-muted">(Optional)</span>
                            </label>

                            <input type="file"
                                   id="attachment"
                                   name="attachment"
                                   class="form-control @error('attachment') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx">

                            @error('attachment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                Accepted files: JPG, PNG, WEBP, PDF, DOC and DOCX. Maximum size: 5MB.
                            </small>
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Submit Ticket
                            </button>

                            <a href="{{ route('vendor.support.index') }}"
                               class="btn btn-light">
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-xl-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Before Submitting
                    </h5>
                </div>

                <div class="card-body">

                    <div class="d-flex gap-3 mb-3">
                        <div class="text-primary">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>

                        <div>
                            <h6 class="mb-1">Use a clear subject</h6>
                            <p class="text-muted small mb-0">
                                Summarize the main issue in a few words.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="text-primary">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>

                        <div>
                            <h6 class="mb-1">Provide important details</h6>
                            <p class="text-muted small mb-0">
                                Include references, dates, amounts or error messages where applicable.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="text-primary">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>

                        <div>
                            <h6 class="mb-1">Attach supporting evidence</h6>
                            <p class="text-muted small mb-0">
                                Screenshots and documents can help the support team understand the issue.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-user-avatar bg-info text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-headset fs-4"></i>
                        </div>

                        <div>
                            <h6 class="mb-1">Support Assistance</h6>
                            <p class="text-muted small mb-0">
                                Your ticket will be reviewed by the FMAP Media support team.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

@endsection