
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor - Dashboard - Future Map Media</title>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@stack('styles')

</head>

<body>
    @include("vendor.partials.topheader")
    @include("vendor.partials.mobileheader")
  
  <!-- Sidebar -->
@yield("main-header")

  <!-- Sidebar Overlay (Mobile) -->
  <div class="sidebar-overlay"></div>

  <!-- Main Content -->
  <main class="main">
    <div class="main-content page-dashboard">
      @yield("main-content")
    </div>

    <!-- Footer -->
    @include("vendor.partials.footer")
  </main>

  <!-- Back to Top -->
  <a href="#" class="back-to-top">
    <i class="bi bi-arrow-up"></i>
  </a>
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
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@stack('scripts')

<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>


</body>

</html>