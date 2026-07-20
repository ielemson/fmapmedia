@extends("admin.layout.app")

@section("title", "General Settings")

@section("main-content")

<div class="dashboard-hero">
<div class="row g-4">

    <div class="col-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

            <div>
                <h4 class="mb-1">General Settings</h4>

                <p class="text-muted mb-0">
                    Manage the website branding, SEO information,
                    contact details and general platform configuration.
                </p>
            </div>

        </div>
    </div>

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>
                    Please correct the following errors:
                </strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-12">

        <form method="POST"
              action="{{ route('admin.settings.general.update') }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Branding --}}
                <div class="col-lg-8">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-palette me-2"></i>
                                Brand Identity
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Site Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="site_name"
                                           value="{{ old('site_name', $setting->site_name) }}"
                                           class="form-control @error('site_name') is-invalid @enderror"
                                           placeholder="FMAP Media">

                                    @error('site_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Site Tagline
                                    </label>

                                    <input type="text"
                                           name="site_tagline"
                                           value="{{ old('site_tagline', $setting->site_tagline) }}"
                                           class="form-control @error('site_tagline') is-invalid @enderror"
                                           placeholder="Informing minds, shaping the future">

                                    @error('site_tagline')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        Main Logo
                                    </label>

                                    <input type="file"
                                           name="logo"
                                           accept=".jpg,.jpeg,.png,.webp"
                                           class="form-control @error('logo') is-invalid @enderror">

                                    @error('logo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted">
                                        Recommended: transparent PNG or WebP.
                                    </small>

                                    @if($setting->logo)
                                        <div class="mt-3 border rounded p-3 text-center">
                                            <img src="{{ asset('storage/' . $setting->logo) }}"
                                                 alt="Site Logo"
                                                 style="max-width: 180px; max-height: 80px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        Footer Logo
                                    </label>

                                    <input type="file"
                                           name="footer_logo"
                                           accept=".jpg,.jpeg,.png,.webp"
                                           class="form-control @error('footer_logo') is-invalid @enderror">

                                    @error('footer_logo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted">
                                        A light logo is recommended for dark footers.
                                    </small>

                                    @if($setting->footer_logo)
                                        <div class="mt-3 border rounded p-3 text-center bg-dark">
                                            <img src="{{ asset('storage/' . $setting->footer_logo) }}"
                                                 alt="Footer Logo"
                                                 style="max-width: 180px; max-height: 80px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        Favicon
                                    </label>

                                    <input type="file"
                                           name="favicon"
                                           accept=".ico,.png,.jpg,.jpeg,.webp"
                                           class="form-control @error('favicon') is-invalid @enderror">

                                    @error('favicon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted">
                                        Recommended size: 32 × 32 or 64 × 64 pixels.
                                    </small>

                                    @if($setting->favicon)
                                        <div class="mt-3 border rounded p-3 text-center">
                                            <img src="{{ asset('storage/' . $setting->favicon) }}"
                                                 alt="Favicon"
                                                 width="48"
                                                 height="48"
                                                 style="object-fit: contain;">
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Platform --}}
                <div class="col-lg-4">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-gear me-2"></i>
                                Platform Settings
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    Currency Code
                                </label>

                                <input type="text"
                                       name="currency_code"
                                       value="{{ old('currency_code', $setting->currency_code) }}"
                                       class="form-control @error('currency_code') is-invalid @enderror"
                                       placeholder="NGN">

                                @error('currency_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Currency Symbol
                                </label>

                                <input type="text"
                                       name="currency_symbol"
                                       value="{{ old('currency_symbol', $setting->currency_symbol) }}"
                                       class="form-control @error('currency_symbol') is-invalid @enderror"
                                       placeholder="₦">

                                @error('currency_symbol')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox"
                                       name="maintenance_mode"
                                       value="1"
                                       class="form-check-input"
                                       id="maintenanceMode"
                                       @checked(old(
                                           'maintenance_mode',
                                           $setting->maintenance_mode
                                       ))>

                                <label class="form-check-label"
                                       for="maintenanceMode">
                                    Enable maintenance mode
                                </label>
                            </div>

                            <div>
                                <label class="form-label">
                                    Maintenance Message
                                </label>

                                <textarea name="maintenance_message"
                                          rows="5"
                                          class="form-control @error('maintenance_message') is-invalid @enderror"
                                          placeholder="The website is undergoing scheduled maintenance.">{{ old('maintenance_message', $setting->maintenance_message) }}</textarea>

                                @error('maintenance_message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                </div>

                {{-- SEO --}}
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-search me-2"></i>
                                SEO and Meta Tags
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    Default Meta Title
                                </label>

                                <input type="text"
                                       name="meta_title"
                                       value="{{ old('meta_title', $setting->meta_title) }}"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       placeholder="FMAP Media | Digital Magazine Platform">

                                @error('meta_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Meta Description
                                </label>

                                <textarea name="meta_description"
                                          rows="4"
                                          class="form-control @error('meta_description') is-invalid @enderror"
                                          placeholder="Enter the default website description.">{{ old('meta_description', $setting->meta_description) }}</textarea>

                                @error('meta_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">
                                    Meta Keywords
                                </label>

                                <textarea name="meta_keywords"
                                          rows="3"
                                          class="form-control @error('meta_keywords') is-invalid @enderror"
                                          placeholder="FMAP Media, digital magazine, African media">{{ old('meta_keywords', $setting->meta_keywords) }}</textarea>

                                @error('meta_keywords')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small class="text-muted">
                                    Separate keywords with commas.
                                </small>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Contact --}}
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-envelope me-2"></i>
                                Contact Information
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Contact Email
                                    </label>

                                    <input type="email"
                                           name="contact_email"
                                           value="{{ old('contact_email', $setting->contact_email) }}"
                                           class="form-control @error('contact_email') is-invalid @enderror"
                                           placeholder="info@example.com">

                                    @error('contact_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Support Email
                                    </label>

                                    <input type="email"
                                           name="support_email"
                                           value="{{ old('support_email', $setting->support_email) }}"
                                           class="form-control @error('support_email') is-invalid @enderror"
                                           placeholder="support@example.com">

                                    @error('support_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        Phone Number
                                    </label>

                                    <input type="text"
                                           name="phone"
                                           value="{{ old('phone', $setting->phone) }}"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="+234 800 000 0000">

                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        Office Address
                                    </label>

                                    <textarea name="address"
                                              rows="4"
                                              class="form-control @error('address') is-invalid @enderror"
                                              placeholder="Enter the official office address.">{{ old('address', $setting->address) }}</textarea>

                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Social Media --}}
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-share me-2"></i>
                                Social Media Links
                            </h5>
                        </div>

                        <div class="card-body">

                            @php
                                $socialFields = [
                                    'facebook_url' => [
                                        'label' => 'Facebook URL',
                                        'icon' => 'bi-facebook',
                                    ],
                                    'instagram_url' => [
                                        'label' => 'Instagram URL',
                                        'icon' => 'bi-instagram',
                                    ],
                                    'twitter_url' => [
                                        'label' => 'X / Twitter URL',
                                        'icon' => 'bi-twitter-x',
                                    ],
                                    'linkedin_url' => [
                                        'label' => 'LinkedIn URL',
                                        'icon' => 'bi-linkedin',
                                    ],
                                    'youtube_url' => [
                                        'label' => 'YouTube URL',
                                        'icon' => 'bi-youtube',
                                    ],
                                ];
                            @endphp

                            <div class="row g-3">

                                @foreach($socialFields as $field => $social)
                                    <div class="col-12">
                                        <label class="form-label">
                                            {{ $social['label'] }}
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi {{ $social['icon'] }}"></i>
                                            </span>

                                            <input type="url"
                                                   name="{{ $field }}"
                                                   value="{{ old($field, $setting->{$field}) }}"
                                                   class="form-control @error($field) is-invalid @enderror"
                                                   placeholder="https://">
                                        </div>

                                        @error($field)
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-layout-text-window-reverse me-2"></i>
                                Footer Settings
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    Footer About Text
                                </label>

                                <textarea name="footer_about"
                                          rows="6"
                                          class="form-control @error('footer_about') is-invalid @enderror"
                                          placeholder="Write a short description of FMAP Media.">{{ old('footer_about', $setting->footer_about) }}</textarea>

                                @error('footer_about')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">
                                    Copyright Text
                                </label>

                                <input type="text"
                                       name="copyright_text"
                                       value="{{ old('copyright_text', $setting->copyright_text) }}"
                                       class="form-control @error('copyright_text') is-invalid @enderror"
                                       placeholder="© 2026 FMAP Media. All rights reserved.">

                                @error('copyright_text')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-12">
                    <div class="card">

                        <div class="card-body d-flex justify-content-end gap-2">

                            <a href="{{ route('dashboard') }}"
                               class="btn btn-light">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>
                                Save General Settings
                            </button>

                        </div>

                    </div>
                </div>

            </div>

        </form>

    </div>

</div>
</div>

@endsection