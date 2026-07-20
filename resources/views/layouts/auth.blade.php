<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Account') | FutureMap Media
    </title>
    {{-- Primary Meta Information --}}
    <meta name="description" content="@yield('meta_description','Access your FutureMap Media account, purchase digital magazines, manage orders and participate in the vendor programme.')">
    <meta name="keywords"content="@yield( 'meta_keywords','FutureMap Media, digital magazines Nigeria, customer account, vendor programme, media platform Nigeria')">
    <meta name="author" content="The FutureMap Media Concepts Limited">
    <meta name="application-name" content="FutureMap Media">
    <meta name="robots"content="@yield('robots', 'noindex, nofollow')">
    {{-- Canonical URL --}}
    <link rel="canonical"href="@yield('canonical_url', url()->current())">
    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FutureMap Media">
    <meta property="og:locale" content="en_NG">
    <meta property="og:title" content="@yield('og_title', 'FutureMap Media Account')">
    <meta property="og:description" content="@yield('og_description','Access your FutureMap Media account and explore digital publications, media services and vendor opportunities.')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image',asset('frontend/assets/images/logo.png'))">
    <meta property="og:image:alt" content="FutureMap Media">
    {{-- Twitter/X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'FutureMap Media Account')">
    <meta name="twitter:description" content="@yield('twitter_description','Access your FutureMap Media customer or vendor account.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/assets/images/logo.png'))">
    <meta name="theme-color" content="#ffffff">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset("frontend/images/favicon.png") }}">
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

    {{-- Page-specific Styles --}}
    @stack('styles')

</head>

<body>

    <div class="auth-layout">
        <div class="auth-shell">
         @yield("auth-content")
        </div>
    </div>

   

    <script>
        $(document).ready(function () {

            /**
             * Initialise Parsley validation on all authentication forms.
             */
            $('.auth-form').parsley({
                errorClass: 'is-invalid',
                successClass: 'is-valid',
                errorsWrapper: '<div class="invalid-feedback"></div>',
                errorTemplate: '<span></span>'
            });

            /**
             * Toggle password visibility.
             */
            $(document).on('click', '.password-toggle', function () {

                const targetSelector = $(this).data('target');
                const input = $(targetSelector);
                const icon = $(this).find('i');

                if (!input.length) {
                    return;
                }

                const isPassword = input.attr('type') === 'password';

                input.attr('type', isPassword ? 'text' : 'password');

                icon.toggleClass('fa-eye', !isPassword);
                icon.toggleClass('fa-eye-slash', isPassword);
            });

        });
        
         document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            const targetSelector = button.getAttribute('data-password-target');
            const passwordInput = targetSelector
                ? document.querySelector(targetSelector)
                : button.previousElementSibling;

            if (!passwordInput) {
                return;
            }

            const icon = button.querySelector('i');
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            if (icon) {
                icon.classList.toggle('bi-eye', !isPassword);
                icon.classList.toggle('bi-eye-slash', isPassword);
            }

            button.setAttribute(
                'title',
                isPassword ? 'Hide password' : 'Show password'
            );

            button.setAttribute(
                'aria-label',
                isPassword ? 'Hide password' : 'Show password'
            );
        });
    });
    </script>


 

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

    {{-- Page-specific Scripts --}}
    @stack('scripts')

</body>

</html>