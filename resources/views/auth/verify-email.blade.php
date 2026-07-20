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
            <img
                src="{{ asset('frontend/images/logo.png') }}"
                alt="FutureMap Media">

            <span>FutureMap Media</span>
        </a>

        <div class="auth-brand-copy">
            <span>Secure workspace</span>

            <h2>
                Building Human Capitals, Creating Market Fields.
            </h2>

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
            <i class="bi bi-envelope-check"></i>

            <div>
                <strong>Verify your email address</strong>

                <span>
                    Email verification helps protect your account and confirms
                    that your registered email belongs to you.
                </span>
            </div>
        </div>

    </aside>

    <main class="auth-main">

        <div class="auth-main-inner">

            <a href="{{ route('index') }}" class="auth-logo auth-logo-mobile">
                <img
                    src="{{ asset('frontend/images/logo.png') }}"
                    alt="FutureMap Media">

                <span>FutureMap Media</span>
            </a>

            <div class="auth-card">

                <div class="auth-card-header">
                    <span class="auth-card-kicker">
                        Email verification
                    </span>

                    <h1 class="auth-title">
                        Check your inbox
                    </h1>

                    <p class="auth-subtitle">
                        We sent a verification link to the email address connected
                        to your FutureMap Media account.
                    </p>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-check-circle me-2"></i>

                        A new verification link has been sent to the email address
                        you provided during registration.
                    </div>
                @endif

                <div class="auth-note-panel">
                    <i class="bi bi-envelope-open"></i>

                    <span>
                        Open the verification email and click the link provided
                        to activate your account and continue.
                    </span>
                </div>

                <div class="auth-verification-steps">

                    <div class="auth-verification-step">
                        <span class="auth-step-number">1</span>

                        <div>
                            <strong>Check your email</strong>

                            <p>
                                Look in your inbox for an email from FutureMap Media.
                            </p>
                        </div>
                    </div>

                    <div class="auth-verification-step">
                        <span class="auth-step-number">2</span>

                        <div>
                            <strong>Open the verification message</strong>

                            <p>
                                Also check your spam or junk folder if you cannot find it.
                            </p>
                        </div>
                    </div>

                    <div class="auth-verification-step">
                        <span class="auth-step-number">3</span>

                        <div>
                            <strong>Click the verification link</strong>

                            <p>
                                You will be redirected back after your email is verified.
                            </p>
                        </div>
                    </div>

                </div>

                <form
                    method="POST"
                    action="{{ route('verification.send') }}"
                    class="auth-form">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-primary btn-block">

                        <i class="bi bi-send"></i>

                        Resend Verification Email
                    </button>

                </form>

                <div class="auth-divider">
                    <span>or</span>
                </div>

                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-secondary btn-block">

                        <i class="bi bi-box-arrow-left"></i>

                        Log Out
                    </button>

                </form>

                <p class="auth-footer-text mt-4">
                    Entered the wrong email address?

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="d-inline">

                        @csrf

                        <button
                            type="submit"
                            class="auth-link border-0 bg-transparent p-0">

                            Log out and register again
                        </button>

                    </form>
                </p>

            </div>

            <footer class="footer-centered">

                <div class="footer-copyright">
                    &copy; {{ date('Y') }}

                    <a href="{{ route('index') }}">
                        FutureMap Media Concepts Limited
                    </a>.

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