@extends("layouts.auth")

@section('title', 'Login to Your Account')

@section(
    'meta_description',
    'Login to your FutureMap Media account to access purchased digital magazines, manage orders, track referrals and manage your vendor activities.'
)

@section(
    'meta_keywords',
    'FutureMap Media login, customer login, vendor login, digital magazine account, FutureMap account'
)

@section('canonical_url', route('login'))

@section('og_title', 'Login to FutureMap Media')

@section(
    'og_description',
    'Securely access your customer or vendor account on the FutureMap Media platform.'
)

@section('og_url', route('login'))

@section('twitter_title', 'Login to FutureMap Media')

@section(
    'twitter_description',
    'Access your FutureMap Media customer or vendor account.'
)

@section('robots', 'noindex, nofollow')

@section("auth-content")
      <aside class="auth-brand-panel">
                <a href="{{ route('index') }}" class="auth-logo">
                    <img src="{{ asset("frontend/images/logo-trans.png") }}" alt="FutureMap Media">
                    <span>FutureMap Media</span>
                </a>
                <div class="auth-brand-copy">
                    <span>Secure workspace</span>
                    <h2>Building Human Capitals, Creating Market Fields.</h2>
                    <p>
                        Access your FutureMap account to manage magazines, vendor activities,
                        news, publications and business opportunities.
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
                        <strong>Secure account access</strong>
                        <span>Protected login for Administrators, Vendors and Customers.</span>
                    </div>
                </div>
            </aside>
            <main class="auth-main">
                <div class="auth-main-inner">
                    @if(session('info'))
                    <div class="mb-4 font-medium text-sm text-blue-600">
                    {{ session('info') }}
                    </div>
                    @endif
                    <a href="{{ route('index') }}" class="auth-logo auth-logo-mobile">
                        <img src="{{ asset("frontend/images/logo.png") }}" alt="FutureMap Media">
                        <span>FutureMap Media</span>
                    </a>
                    <div class="auth-card">
                        <div class="auth-card-header">
                            <span class="auth-card-kicker">Secure sign in</span>
                            <h1 class="auth-title">Welcome back</h1>
                            <p class="auth-subtitle">
                                Enter your credentials to access your FutureMap Media account.
                            </p>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="auth-note-panel">
                            <i class="bi bi-shield-check"></i>
                            <span>
                                Protected access for administrators, vendors and customers.
                            </span>
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="auth-form">
                            @csrf
                               @if(request('checkout'))
                                    <input type="hidden" name="checkout" value="{{ request('checkout') }}">
                                @endif
                                <div class="form-group">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" :value="old('email', request('email'))"
                                    placeholder="name@example.com" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="auth-helper-row">
                                    <label for="password" class="form-label">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="auth-link small">
                                            Forgot password?
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Enter your password" required>
                                    <button class="btn btn-outline-secondary" type="button" data-toggle-password
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Keep this device trusted
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Sign in
                            </button>
                        </form>
                        <p class="auth-footer-text">
                            New customer?
                            <a href="{{ route('register') }}" class="auth-link">
                                Create an account
                            </a>
                        </p>
                        <p class="auth-footer-text mt-2">
                            Want to sell magazines?
                            <a href="{{ route('vendor.register') }}" class="auth-link">
                                Register as Vendor
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