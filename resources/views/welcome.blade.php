<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Xem Lịch Âm' }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <!-- Các link CSS nếu cần, ví dụ: Bootstrap hoặc custom CSS -->
    <link href="{{ asset('/css/bootstrap.min.css?v=4.91') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.min.css?v=4.92') }}">
    <link rel="stylesheet" href="{{ asset('/css/style-date.css?v=4.92') }}">
    <link rel="stylesheet" href="{{ asset('/css/repont.css?v=4.92') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/daterangepicker.css') }}" /> --}}
    <!-- ĐẢM BẢO CÓ DÒNG NÀY ĐỂ CSRF TOKEN HOẠT ĐỘNG! -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/meta/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/meta/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/meta/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="144x144"
        href="{{ asset('/meta/android-chrome-144x144.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('/meta/android-chrome-192x192.png') }}">

    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('/meta/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('/meta/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('/meta/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('/meta/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/meta/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/meta/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/meta/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/meta/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/meta/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-startup-image" href="{{ asset('/meta/apple-touch-icon-180x180.png') }}" />
    <meta property="og:image" content="{{ asset('/meta/512x512.png') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle ?? 'Xem Lịch Âm' }}">
    <meta property="og:description" content="{{ $metaDescription ?? '' }}">
<meta name="google-site-verification" content="7vbSgMqtIVgd4WDBamHC2YavkSAVwGpQO8U2pFpVA6U" />

    @stack('styles')
    @if (request()->routeIs('home'))
    <script src="{{ asset('/js/chart.umd.min.js') }}" defer></script>
    @endif
</head>

<body>
    <div class="main-content-wrapper">
        @include('layout.header')

        <div class=" container-setup">

            @yield('content')
        </div>
    </div>

    @include('layout.footer')

    <!-- Nút gieo quẻ sticky, đặt ở đây cho dễ nhìn -->
    
    <!-- Đảm bảo file gieo-que.blade.php chứa các modal popup -->
    {{-- @include('gieo-que') --}}
    <script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/moment.min.js') }}"></script>
    {{-- <script src="{{ asset('/js/daterangepicker.min.js') }}"></script> --}}

    <!-- JS của Bootstrap (nếu sử dụng Bootstrap) -->
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('/js/flatpickr.js') }}"></script>
    <script src="{{ asset('/js/vn.js') }}"></script> --}}

    @stack('scripts')
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KVKGWDRXSC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KVKGWDRXSC');
</script>
  

</body>

</html>
