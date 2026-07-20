{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends("layouts.auth")

@section('title', 'Reset Your Password')

@section(
    'meta_description',
    'Reset your FutureMap Media password to regain access to your account.'
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
                src="{{ asset('frontend/images/logo-trans.png') }}"
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
            <i class="bi bi-key"></i>

            <div>
                <strong>Create a new password</strong>

                <span>
                    Choose a strong password to restore secure access to your account.
                </span>
            </div>
        </div>

    </aside>

    <main class="auth-main">

        <div class="auth-main-inner">

            @if (session('info'))
                <div class="alert alert-info mb-4">
                    {{ session('info') }}
                </div>
            @endif

            <a href="{{ route('index') }}" class="auth-logo auth-logo-mobile">
                <img
                    src="{{ asset('frontend/images/logo.png') }}"
                    alt="FutureMap Media">

                <span>FutureMap Media</span>
            </a>

            <div class="auth-card">

                <div class="auth-card-header">
                    <span class="auth-card-kicker">
                        Password recovery
                    </span>

                    <h1 class="auth-title">
                        Reset your password
                    </h1>

                    <p class="auth-subtitle">
                        Enter your registered email address and create a new secure
                        password for your FutureMap Media account.
                    </p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <div class="auth-note-panel">
                    <i class="bi bi-shield-check"></i>

                    <span>
                        Use at least eight characters and combine letters, numbers
                        and symbols for stronger account protection.
                    </span>
                </div>

                <form
                    method="POST"
                    action="{{ route('password.store') }}"
                    class="auth-form">

                    @csrf

                    {{-- Password reset token --}}
                    <input
                        type="hidden"
                        name="token"
                        value="{{ $request->route('token') }}">

                    {{-- Email Address --}}
                    <div class="form-group">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $request->email) }}"
                                placeholder="name@example.com"
                                autocomplete="username"
                                required
                                autofocus>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- New Password --}}
                    <div class="form-group">

                        <label for="password" class="form-label">
                            New Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter a new password"
                                autocomplete="new-password"
                                required>

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                data-toggle-password
                                data-password-target="#password"
                                title="Show password"
                                aria-label="Show password">

                                <i class="bi bi-eye"></i>
                            </button>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">

                        <label for="password_confirmation" class="form-label">
                            Confirm New Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Re-enter the new password"
                                autocomplete="new-password"
                                required>

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                data-toggle-password
                                data-password-target="#password_confirmation"
                                title="Show password"
                                aria-label="Show password">

                                <i class="bi bi-eye"></i>
                            </button>

                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-block">

                        <i class="bi bi-arrow-repeat"></i>

                        Reset Password
                    </button>

                </form>

                <p class="auth-footer-text">
                    Remember your password?

                    <a
                        href="{{ route('login') }}"
                        class="auth-link">

                        Return to Sign In
                    </a>
                </p>

                <p class="auth-footer-text mt-2">
                    Return to the website?

                    <a
                        href="{{ route('index') }}"
                        class="auth-link">

                        Visit Homepage
                    </a>
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