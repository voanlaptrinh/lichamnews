<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Xem Lịch Âm' }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">

    <!-- Resource hints để giảm TTFB -->
    <link rel="preconnect" href="{{ url('/') }}">
    <link rel="dns-prefetch" href="{{ url('/') }}">

    <!-- Critical CSS inline để giảm render delay LCP -->
    <style>
        /* Reset and base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body với font mặc định */
        html {
            height: 100%;
        }

        html,
        body {
            overflow-x: hidden;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #EDF0F3;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


        /* ULTRA Critical LCP Elements */

        .title-tong-quan-h2,
        .font-detail-ngay,
        #gio-hoang-dao-content {
            font-family: Arial, Helvetica, sans-serif !important;
            line-height: 1.5 !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            will-change: auto !important;
            contain: none !important;
            position: static !important;
            z-index: auto !important;
            background: transparent !important;
            border: none !important;
            animation: none !important;
            transition: none !important;
            -webkit-font-smoothing: auto !important;
            text-rendering: optimizeSpeed !important;
            font-display: block !important;
            transform: translateZ(0) !important;
            backface-visibility: hidden !important;
        }

        /* Force h2 to render immediately without changing font-size */
        h2.title-tong-quan-h2 {
            contain-intrinsic-size: auto !important;
            content-visibility: visible !important;
        }

        /* Force immediate paint */
        .tong-quan-date .card-body {
            background: white !important;
            min-height: 100px !important;
        }

        /* Critical container styles */
        .mb-3 {
            margin-bottom: 1rem !important;
        }

        /* Optimize container render */
        .info-card {
            contain: layout;
            content-visibility: auto;
            transform: translateZ(0);
        }

        /* Speed up paint */
        .info-item {
            contain: layout style;
            will-change: auto;
        }

        /* Disable animations initially */
        * {
            animation-duration: 0s !important;
            animation-delay: 0s !important;
            transition-duration: 0s !important;
            transition-delay: 0s !important;
        }
    </style>

    <!-- Preload CSS resources -->
    <link rel="preload" href="{{ asset('/css/bootstrap.min.css?v=5.97') }}" as="style">
    <link rel="preload" href="{{ asset('/css/style-date.css?v=5.97') }}" as="style">

    <!-- Load critical CSS -->
    <link href="{{ asset('/css/bootstrap.min.css?v=5.97') }}" rel="stylesheet">
    <link href="{{ asset('/css/style-date.css?v=5.97') }}" rel="stylesheet">

    <!-- Defer non-critical CSS -->
    <link rel="preload" href="{{ asset('/css/bootstrap-icons.min.css?v=5.97') }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.min.css?v=5.97') }}">
    </noscript>
    <link rel="preload" href="{{ asset('/css/repont.css?v=5.97') }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('/css/repont.css?v=5.97') }}">
    </noscript>

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/daterangepicker.css') }}" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/meta/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/meta/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/meta/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('/meta/android-chrome-144x144.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/meta/android-chrome-192x192.png') }}">

    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/meta/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/meta/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/meta/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/meta/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/meta/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/meta/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/meta/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="73x73" href="{{ asset('/meta/apple-touch-icon-73x73.png') }}">
    <link rel="apple-touch-icon" sizes="8x8" href="{{ asset('/meta/apple-touch-icon-8x8.png') }}">
    <link rel="apple-touch-startup-image" href="{{ asset('/meta/apple-touch-icon-180x180.png') }}" />
    <meta property="og:image" content="{{ asset('/meta/512x512.png') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle ?? 'Xem Lịch Âm' }}">
    <meta property="og:description" content="{{ $metaDescription ?? '' }}">
    <meta name="google-site-verification" content="7vbSgMqtIVgd4WDBamHC2YavkSAVwGpQO8U2pFpVA6U" />

    @stack('critical-css')
    @stack('styles')

    {{-- Vanilla Date Range Picker CSS - Available for all views --}}
    {{-- <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.0') }}"> --}}

</head>

<body>
    <!-- Critical inline script để fix LCP ngay lập tức -->
    <script>
        // Optimize LCP - Giờ Hoàng đạo
        (function() {
            // 1. Inject critical styles immediately
            var style = document.createElement('style');
            style.textContent = `
                .font-detail-ngay,
                #gio-hoang-dao-content {
                    visibility: visible !important;
                    opacity: 1 !important;
                    display: block !important;
                    font-size: 16px !important;
                    transform: none !important;
                    animation: none !important;
                    transition: none !important;
                }
                .info-card {
                    min-height: auto !important;
                    will-change: auto !important;
                }
            `;
            document.head.appendChild(style);

            // 2. Prerender trigger
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    var lcp = document.getElementById('gio-hoang-dao-content');
                    if (lcp) {
                        lcp.style.cssText = 'visibility: visible !important; opacity: 1 !important;';
                        // Force layout
                        void lcp.offsetHeight;
                    }
                });
            }
        })();
    </script>
    <div class="main-content-wrapper">
        @include('layout.header')
        <main id="main-content">
            <div class="container-setup">

                @yield('content')
            </div>
        </main>
    </div>

    @include('layout.footer')

    <!-- Nút gieo quẻ sticky, đặt ở đây cho dễ nhìn -->

    <!-- Đảm bảo file gieo-que.blade.php chứa các modal popup -->
    {{-- @include('gieo-que') --}}
    @if (request()->routeIs('home'))
        {{-- Sử dụng Simple Chart thay vì Chart.js 201KB --}}
        <script src="{{ asset('/js/simple-chart.js?v=5.97') }}" defer></script>
    @endif
    {{-- <script src="{{ asset('/js/jquery-3.7.1.min.js?v=5.67') }}" defer></script> --}}
    <script src="{{ asset('/js/bootstrap.bundle.min.js?v=5.7') }}" defer></script>
    @stack('scripts')

    {{-- Vanilla Date Range Picker JS - Auto-initialize for all .wedding_date_range inputs --}}
    {{-- <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.0') }}" defer></script> --}}

    <!-- IMMEDIATE LCP optimization -->
    <script>
        // Run before DOM ready for maximum speed
        (function() {
            var optimizeLCP = function() {
                // Target date number LCP element
                var dateNumber = document.querySelector('.date-number.am');
                if (dateNumber) {
                    dateNumber.style.cssText =
                        'visibility: visible !important; opacity: 1 !important; display: block !important; transform: none !important;';
                    void dateNumber.offsetHeight;
                }

                // Target H2 LCP element
                var h2 = document.querySelector('.title-tong-quan-h2');
                if (h2) {
                    h2.style.cssText =
                        'visibility: visible !important; opacity: 1 !important; display: block !important; transform: none !important;';
                    void h2.offsetHeight;
                }

                // Also handle span LCP
                var span = document.getElementById('gio-hoang-dao-content');
                if (span) {
                    span.style.cssText =
                        'visibility: visible !important; opacity: 1 !important; display: inline !important;';
                    void span.offsetHeight;
                }
            };

            // Execute as early as possible
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', optimizeLCP);
                // Also try during parsing
                var checkAndOptimize = function() {
                    optimizeLCP();
                    if (!document.querySelector('.date-number.am') && !document.querySelector(
                            '.title-tong-quan-h2')) {
                        requestAnimationFrame(checkAndOptimize);
                    }
                };
                requestAnimationFrame(checkAndOptimize);
            } else {
                optimizeLCP();
            }
            
            try {
                const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                if (tz) {
                    const current = document.cookie.split('; ').find(row => row.startsWith('user_tz='));
                    if (!current || current.split('=')[1] !== encodeURIComponent(tz)) {
                        document.cookie = 'user_tz=' + encodeURIComponent(tz) + '; path=/; max-age=' + (60 * 60 * 24 *
                            365);
                    }
                }
            } catch (e) {
                console.warn('Không thể xác định múi giờ:', e);
            }
        })();
    </script>

    <!-- Google Analytics - defer -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KVKGWDRXSC"></script>
    <script defer>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-KVKGWDRXSC');
    </script>


</body>

</html>
