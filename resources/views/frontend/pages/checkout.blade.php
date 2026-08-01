@extends('layouts.app')

@section('title', 'Home | FutureMap Media')

@section("header")
@include("frontend.partials.page-header")
@endsection

@section('content')

@include("frontend.partials.banner",["header"=>'Checkout - Magazine'])

<section class="content-inner">
    <div class="container">

        <div class="section-head style-2 text-center">
            <h6 class="text-primary sub-title">Secure Checkout</h6>

            <h2 class="title">Complete Your Purchase</h2>

            <p class="text-muted">
                Buy once and get instant access to read or download your digital magazine.
            </p>
        </div>

      <form action="{{ route('checkout.store', $product->slug) }}" method="POST">
    @csrf

    <div class="row g-4 align-items-stretch">

        {{-- Magazine Preview --}}
        <div class="col-lg-6 d-flex">
            <div class="checkout-summary w-100">

                <h4 class="mb-4">Magazine Preview</h4>

                <div class="summary-product-image">
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}">
                </div>

                <div class="mt-4">

                    <h4 class="mb-2">
                        {{ $product->name }}
                    </h4>

                    @if ($product->published_at)
                        <p class="text-muted mb-4">
                            Published:
                            {{ $product->published_at->format('F d, Y') }}
                        </p>
                    @endif

                    <div class="summary-list">

                        <div>
                            <span>Price</span>

                            <strong>
                                ₦{{ number_format($product->price, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Format</span>
                            <strong>Digital Magazine</strong>
                        </div>

                        <div>
                            <span>Access</span>
                            <strong>Unlimited Read & Download</strong>
                        </div>

                    </div>

                    <p class="checkout-note mt-4 mb-0">
                        After successful payment, this magazine will immediately
                        become available in your personal library for online
                        reading and PDF download from any device.
                    </p>

                </div>

            </div>
        </div>

        {{-- Customer Information --}}
        <div class="col-lg-6 d-flex">
            <div class="checkout-box w-100">

                <div class="checkout-box-header mb-4">

                    <h4 class="mb-1">
                        Customer Information
                    </h4>

                    <p class="text-muted mb-3">
                        Enter your details below. If you do not already have an
                        account, one will automatically be created after successful
                        payment using your email address.
                    </p>

                    @guest
                        @php
                            session([
                                'url.intended' => url()->full(),
                            ]);
                        @endphp

                        <div class="alert alert-light border d-flex align-items-start mb-0">

                            <div class="me-3">
                                <i class="fas fa-user-circle text-primary fa-lg"></i>
                            </div>

                            <div>
                                <strong>
                                    Already have an account?
                                </strong>

                                <div class="mt-1">
                                    <a
                                        href="{{ route('login') }}"
                                        class="fw-semibold text-primary">

                                        Log in here

                                    </a>

                                    to automatically fill in your details and access
                                    your previous magazine purchases.
                                </div>
                            </div>

                        </div>
                    @endguest

                </div>

                <div class="row">

                    <div class="col-md-6 m-b20">

                        <label for="first_name" class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name', auth()->user()?->first_name) }}"
                            required>

                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6 m-b20">

                        <label for="last_name" class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name', auth()->user()?->last_name) }}"
                            required>

                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6 m-b20">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', auth()->user()?->email) }}"
                            required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6 m-b20">

                        <label for="phone" class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', auth()->user()?->phone) }}"
                            required>

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Vendor Referral / Vendor Code --}}
<div class="col-12 m-b20">

    @if ($hasActiveReferral && $vendorReferral)

        <div class="alert alert-success d-flex align-items-start mb-3">

            <div class="me-3">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>

            <div>

                <strong>
                    Vendor Referral Applied
                </strong>

                <div class="mt-1">
                    This purchase has been linked to:

                    <span class="fw-semibold">
                        {{ $vendorReferral['vendor_code'] ?? $vendorReferral['vendor_slug'] }}
                    </span>
                </div>

            </div>

        </div>

        {{-- <label for="vendor_code" class="form-label">
            Vendor Code
        </label> --}}

        {{-- <input
            type="text"
            id="vendor_code"
            class="form-control"
            value="{{ $vendorReferral['vendor_code'] ?? $vendorReferral['vendor_slug'] }}"
            readonly> --}}

        <input
            type="hidden"
            name="vendor_id"
            value="{{ $vendorReferral['vendor_id'] }}">

        <input
            type="hidden"
            name="vendor_code"
            value="{{ $vendorReferral['vendor_code'] ?? '' }}">

        <input
            type="hidden"
            name="referral_slug"
            value="{{ $vendorReferral['vendor_slug'] }}">

    @else

        <label for="vendor_code" class="form-label">
            Vendor Code
            <span class="text-muted">(Optional)</span>
        </label>

        <input
            type="text"
            name="vendor_code"
            id="vendor_code"
            class="form-control @error('vendor_code') is-invalid @enderror"
            value="{{ old('vendor_code') }}"
            placeholder="Enter vendor code if you were referred">

        <small class="text-muted">
            If someone referred you to this magazine, enter their vendor code here.
        </small>

        @error('vendor_code')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    @endif

</div>


                    {{-- Active Vendor Referral
                    @if ($hasActiveReferral && $vendorReferral)
                        <div class="col-12 mb-3">

                            <div class="alert alert-success d-flex align-items-start mb-0">

                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>

                                <div>
                                    <strong>
                                        Vendor Referral Applied
                                    </strong>

                                    <div class="mt-1">
                                        Vendor Code:

                                        <span class="fw-semibold">
                                            {{ $vendorReferral['vendor_code']
                                                ?? $vendorReferral['vendor_slug'] }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <input
                                type="hidden"
                                name="vendor_id"
                                value="{{ $vendorReferral['vendor_id'] }}">

                            <input
                                type="hidden"
                                name="vendor_code"
                                value="{{ $vendorReferral['vendor_code'] ?? '' }}">

                            <input
                                type="hidden"
                                name="referral_slug"
                                value="{{ $vendorReferral['vendor_slug'] }}">

                        </div>
                    @endif --}}

                    <div class="col-12">

                        <div class="digital-access-box">

                            <div class="digital-access-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>

                            <div>

                                <h6>
                                    Instant Digital Access
                                </h6>

                                <p class="mb-0">
                                    Immediately after payment, your magazine
                                    will be unlocked in your account and available
                                    for reading online or downloading as a PDF.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 mt-4">

                        <div class="form-check">

                            <input
                                class="form-check-input @error('terms') is-invalid @enderror"
                                type="checkbox"
                                name="terms"
                                id="terms"
                                value="1"
                                {{ old('terms') ? 'checked' : '' }}
                                required>

                            <label
                                class="form-check-label"
                                for="terms">

                                I agree to the

                                <a
                                    href="javascript:void(0);"
                                    class="text-primary">

                                    Terms & Conditions

                                </a>

                                and

                                <a
                                    href="javascript:void(0);"
                                    class="text-primary">

                                    Privacy Policy

                                </a>.

                            </label>

                            @error('terms')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <input
                        type="hidden"
                        name="product_id"
                        value="{{ $product->id }}">

                    <input
                        type="hidden"
                        name="amount"
                        value="{{ $product->price }}">

                    <input
                        type="hidden"
                        name="delivery_method"
                        value="digital">

                    <div class="col-12">

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100 mt-4">

                            <i class="fas fa-lock me-2"></i>

                            Proceed to Secure Payment
                            — ₦{{ number_format($product->price, 2) }}

                        </button>

                    </div>

                </div>

            </div>
        </div>

    </div>

</form>

    </div>
</section>
@endsection

