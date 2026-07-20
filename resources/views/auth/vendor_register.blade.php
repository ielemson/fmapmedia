@extends('layouts.auth')

@section('title', 'Join the Vendor Programme')

@section('meta_description', 'Register for the FutureMap Media Vendor Programme, promote digital magazines with
    product-specific referral links and earn commissions from confirmed sales.')

@section('meta_keywords', 'FutureMap Media vendor registration, magazine affiliate Nigeria, digital magazine vendor,
    referral marketing, earn magazine commission')

@section('canonical_url', route('vendor.register'))

@section('og_title', 'Join the FutureMap Media Vendor Programme')

@section('og_description', 'Become a FutureMap Media vendor, promote digital magazines and earn commissions from
    successful sales.')

@section('og_url', route('vendor.register'))

@section('twitter_title', 'FutureMap Media Vendor Registration')

@section('twitter_description', 'Register as a FutureMap Media vendor and earn commissions by promoting digital
    magazines.')

@section('robots', 'noindex, nofollow')

@section('auth-content')
    <aside class="auth-brand-panel">
        <a href="{{ route('index') }}" class="auth-logo">
            <img src="{{ asset('frontend/images/logo-trans.png') }}" alt="FutureMap Media">
            <span>FutureMap Media</span>
        </a>

        <div class="auth-brand-copy">
            <span>Vendor Programme</span>
            <h2>Earn by promoting FutureMap magazines.</h2>
            <p>
                Join our vendor network, share your referral link, and earn commission
                on every successful magazine sale.
            </p>
        </div>

       <div class="auth-signal-grid">

    <div>
        <i class="bi bi-upc-scan"></i>
        <strong>Code</strong>
        <span>Vendor ID</span>
    </div>

    <div>
        <i class="bi bi-link-45deg"></i>
        <strong>Link</strong>
        <span>Referral Sales</span>
    </div>

    <div>
        <i class="bi bi-cash-coin"></i>
        <strong>Earn</strong>
        <span>Commission</span>
    </div>

    <div>
        <i class="bi bi-graph-up-arrow"></i>
        <strong>Grow</strong>
        <span>Your Business</span>
    </div>

</div>

        <div class="auth-brand-card">
            <i class="bi bi-megaphone"></i>
            <div>
                <strong>How it works</strong>
                <span>
                    Apply, get approved, receive your vendor code, then start promoting FMAP Magazine.
                </span>
            </div>
        </div>
    </aside>

    <main class="auth-main">
        <div class="auth-main-inner">

            <a href="{{ route('index') }}" class="auth-logo auth-logo-mobile">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="FutureMap Media">
                <span>FutureMap Media</span>
            </a>

            <div class="auth-card">
                <div class="auth-card-header">
                    <span class="auth-card-kicker">Vendor application</span>
                    <h1 class="auth-title">Create vendor account</h1>
                    <p class="auth-subtitle">
                        Register and earn commissions by promoting FutureMap magazines.
                    </p>
                </div>

                <div class="auth-note-panel">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        Your application will be reviewed before your vendor code is issued.
                    </span>
                </div>

                <form method="POST" action="{{ route('vendor.register.store') }}" class="auth-form">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                class="form-control @error('first_name') is-invalid @enderror" placeholder="First name"
                                required autofocus>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                class="form-control @error('last_name') is-invalid @enderror" placeholder="Last name"
                                required autofocus>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="business_name" class="form-label">Business / Brand</label>
                            <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}"
                                class="form-control @error('business_name') is-invalid @enderror"
                                placeholder="Business or brand name" required>
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="08012345678"
                                required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="vendor_type" class="form-label">Vendor type</label>
                            <select name="vendor_type" id="vendor_type"
                                class="form-control @error('vendor_type') is-invalid @enderror" required>
                                <option value="">Select vendor type</option>
                                <option value="Individual" {{ old('vendor_type') == 'Individual' ? 'selected' : '' }}>
                                    Individual</option>
                                <option value="Business" {{ old('vendor_type') == 'Business' ? 'selected' : '' }}>Business
                                </option>
                                <option value="Organization" {{ old('vendor_type') == 'Organization' ? 'selected' : '' }}>
                                    Organization</option>
                                <option value="Institution" {{ old('vendor_type') == 'Institution' ? 'selected' : '' }}>
                                    Institution</option>
                                <option value="Student Ambassador"
                                    {{ old('vendor_type') == 'Student Ambassador' ? 'selected' : '' }}>Student Ambassador
                                </option>
                            </select>
                            @error('vendor_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" name="state" id="state" value="{{ old('state') }}"
                                class="form-control @error('state') is-invalid @enderror" placeholder="State" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}"
                                class="form-control @error('city') is-invalid @enderror" placeholder="City" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" data-toggle-password>
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Confirm password" required>
                                <button class="btn btn-outline-secondary" type="button" data-toggle-password>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="captcha" class="form-label">
                                Security check: <strong>{{ $a }} + {{ $b }}</strong>
                            </label>
                            <input type="number" name="captcha" id="captcha"
                                class="form-control @error('captcha') is-invalid @enderror" placeholder="Answer" required>
                            @error('captcha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the Vendor Terms and approval process.
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-4">
                        <i class="bi bi-person-check"></i>
                        Submit Vendor Application
                    </button>
                </form>

                <p class="auth-footer-text">
                    Already have an account?
                    <a href="{{ route('login') }}" class="auth-link">Sign in</a>
                </p>
            </div>

            <footer class="footer-centered">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }}
                    <a href="{{ route('index') }}">FutureMap Media Concepts Limited</a>.
                    All Rights Reserved.
                </div>

                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Help</a>
                </div>
            </footer>

        </div>
    </main>
@endsection
