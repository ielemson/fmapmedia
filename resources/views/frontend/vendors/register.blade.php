
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - AppDashboard</title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="AppDashboard - Bootstrap Admin Dashboard Template">
  <meta name="keywords" content="admin, dashboard, bootstrap">

{{-- Favicons --}}
<link href="{{ asset('backend/assets/img/favicon.png') }}" rel="icon">
<link href="{{ asset('backend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500;600&display=swap" rel="stylesheet">
{{-- Vendor CSS Files --}}
<link href="{{ asset('backend/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/phosphor-icons/phosphor-icons.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/lucide-icons/lucide.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/simple-datatables/style.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/choices.js/choices.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
{{-- Template Main CSS File --}}
<link href="{{ asset('backend/assets/css/main.css') }}" rel="stylesheet">
@stack('styles')

</head>

<body>

    <div class="auth-layout">
    <div class="auth-shell">

        <aside class="auth-brand-panel">
            <a href="{{ route('home') }}" class="auth-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="FutureMap Media">
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
                    <strong>Code</strong>
                    <span>Vendor ID</span>
                </div>
                <div>
                    <strong>Link</strong>
                    <span>Referral Sales</span>
                </div>
                <div>
                    <strong>Earn</strong>
                    <span>Commission</span>
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

                <a href="{{ route('home') }}" class="auth-logo auth-logo-mobile">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="FutureMap Media">
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
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name"
                                       value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Full name" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="business_name" class="form-label">Business / Brand</label>
                                <input type="text" name="business_name" id="business_name"
                                       value="{{ old('business_name') }}"
                                       class="form-control @error('business_name') is-invalid @enderror"
                                       placeholder="Business or brand name" required>
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" id="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="name@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone number</label>
                                <input type="text" name="phone" id="phone"
                                       value="{{ old('phone') }}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="08012345678" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="vendor_type" class="form-label">Vendor type</label>
                                <select name="vendor_type" id="vendor_type"
                                        class="form-control @error('vendor_type') is-invalid @enderror" required>
                                    <option value="">Select vendor type</option>
                                    <option value="Individual" {{ old('vendor_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="Business" {{ old('vendor_type') == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Organization" {{ old('vendor_type') == 'Organization' ? 'selected' : '' }}>Organization</option>
                                    <option value="Institution" {{ old('vendor_type') == 'Institution' ? 'selected' : '' }}>Institution</option>
                                    <option value="Student Ambassador" {{ old('vendor_type') == 'Student Ambassador' ? 'selected' : '' }}>Student Ambassador</option>
                                </select>
                                @error('vendor_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state"
                                       value="{{ old('state') }}"
                                       class="form-control @error('state') is-invalid @enderror"
                                       placeholder="State" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city"
                                       value="{{ old('city') }}"
                                       class="form-control @error('city') is-invalid @enderror"
                                       placeholder="City" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password" required>
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
                                           class="form-control"
                                           placeholder="Confirm password" required>
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
                                       class="form-control @error('captcha') is-invalid @enderror"
                                       placeholder="Answer" required>
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
                        <a href="{{ route('home') }}">FutureMap Media Concepts Limited</a>.
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

    </div>
</div>
 

{{-- Vendor JS Files --}}
<script src="{{ asset('backend/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- Charts --}}
<script src="{{ asset('backend/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('backend/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('backend/vendors/echarts/echarts.min.js') }}"></script>
{{-- UI Components --}}
<script src="{{ asset('backend/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('backend/vendors/quill/quill.js') }}"></script>
<script src="{{ asset('backend/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('backend/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('backend/vendors/flatpickr/flatpickr.min.js') }}"></script>
{{-- Forms --}}
<script src="{{ asset('backend/vendors/php-email-form/validate.js') }}"></script>
{{-- Theme Scripts --}}
<script src="{{ asset('backend/assets/js/theme.js') }}"></script>
<script src="{{ asset('backend/assets/js/main.js') }}"></script>
{{-- Sidebar --}}
<script src="{{ asset('backend/assets/js/apps-sidebar-toggle.js') }}"></script>

</body>

</html>