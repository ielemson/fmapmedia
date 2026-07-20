@extends('layouts.auth')

@section('title', 'Create a Customer Account')

@section(
    'meta_description',
    'Create a FutureMap Media customer account to purchase digital magazines, manage your orders and access your purchased publications.'
)

@section(
    'meta_keywords',
    'FutureMap Media registration, customer registration, create media account, buy digital magazines Nigeria'
)

@section('canonical_url', route('register'))

@section('og_title', 'Create Your FutureMap Media Account')

@section(
    'og_description',
    'Register as a customer to purchase and access digital magazines from FutureMap Media.'
)

@section('og_url', route('register'))

@section('twitter_title', 'Create a FutureMap Media Account')

@section(
    'twitter_description',
    'Register to purchase digital magazines and manage your FutureMap Media orders.'
)

@section('robots', 'noindex, nofollow')

@section("auth-content")
       <aside class="auth-brand-panel">
            <a href="{{ route('index') }}" class="auth-logo">
                <img src="{{ asset('frontend/images/logo-trans.png') }}" alt="FutureMap Media">
                <span>FutureMap Media</span>
            </a>

            <div class="auth-brand-copy">
                <span>Create account</span>
                <h2>Building Human Capitals, Creating Market Fields.</h2>
                <p>
                    Join FutureMap Media to access magazines, publications,
                    business opportunities and customer services.
                </p>
            </div>

           <div class="auth-signal-grid">

    <div>
        <i class="bi bi-journal-richtext"></i>
        <strong>Media</strong>
        <span>Digital Magazines</span>
    </div>

    <div>
        <i class="bi bi-people-fill"></i>
        <strong>Vendor</strong>
        <span>Referral Sales</span>
    </div>

    <div>
        <i class="bi bi-newspaper"></i>
        <strong>News</strong>
        <span>Latest Updates</span>
    </div>

    <div>
        <i class="bi bi-shield-lock-fill"></i>
        <strong>Secure</strong>
        <span>Protected Access</span>
    </div>

</div>

            <div class="auth-brand-card">
                <i class="bi bi-shield-lock"></i>
                <div>
                    <strong>Secure customer registration</strong>
                    <span>Create your account safely and access FutureMap Media services.</span>
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
                        <span class="auth-card-kicker">Customer account</span>
                        <h1 class="auth-title">Create your account</h1>
                        <p class="auth-subtitle">
                            Register to access FutureMap Media magazines, updates and customer services.
                        </p>
                    </div>

                    <div class="auth-note-panel">
                        <i class="bi bi-shield-check"></i>
                        <span>
                            Your account is protected with encrypted sessions and secure access control.
                        </span>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label>

                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name"
                                           name="first_name"
                                           value="{{ old('first_name') }}"
                                           placeholder="John"
                                           required
                                           autofocus>

                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label>

                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name"
                                           name="last_name"
                                           value="{{ old('last_name') }}"
                                           placeholder="Doe"
                                           required
                                           autofocus>

                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone number</label>

                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="08012345678">

                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                   <div class="form-group">
                            <label for="email" class="form-label">Email address</label>

                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="name@example.com"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                            </div>
                        </div>

                     

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>

                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Password"
                                               required>

                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                data-toggle-password
                                                title="Show password">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm password</label>

                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Confirm Password"
                                               required>

                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                data-toggle-password
                                                title="Show password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="terms"
                                   required>

                            <label class="form-check-label" for="terms">
                                I agree to the
                                <a href="#" class="auth-link">Terms &amp; Conditions</a>
                                and
                                <a href="#" class="auth-link">Privacy Policy</a>.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="bi bi-person-plus"></i>
                            Create Account
                        </button>
                    </form>

                    <p class="auth-footer-text">
                        Already have an account?
                        <a href="{{ route('login') }}" class="auth-link">
                            Sign in
                        </a>
                    </p>

                    <p class="auth-footer-text mt-2">
                        Want to earn by promoting FutureMap magazines?
                        <a href="{{ route('vendor.register') }}" class="auth-link">
                           <br> Become a Vendor
                        </a>
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