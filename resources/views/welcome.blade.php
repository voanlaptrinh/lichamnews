<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Xem Lịch Âm' }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <!-- Các link CSS nếu cần, ví dụ: Bootstrap hoặc custom CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/airbnb.css') }}"> {{-- hoặc dark, material_red --}}
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styledemo.css?v=3.0') }}">
    <link rel="stylesheet" href="{{ asset('/css/repont.css?v=3.0') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/daterangepicker.css') }}" />
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


    @stack('styles')
    <script src="{{ asset('/js/chart.umd.min.js') }}"></script>

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
    <script src="{{ asset('/js/jquery-3.7.1.min.js?v') }}"></script>
    <script src="{{ asset('/js/moment.min.js') }}"></script>
    <script src="{{ asset('/js/daterangepicker.min.js') }}"></script>

    <!-- JS của Bootstrap (nếu sử dụng Bootstrap) -->
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('/js/flatpickr.js') }}"></script>
    <script src="{{ asset('/js/vn.js') }}"></script> --}}

    @stack('scripts')

    <script>
        // --- Helper functions for cookie management ---
        function getTodayDateString() {
            const today = new Date();
            return today.getFullYear() + '-' +
                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                String(today.getDate()).padStart(2, '0');
        }

        // Function to set fortune cookie with fortune index
        // Cookie expires at the end of the current day
        function setFortuneCookie(fortuneIndex) {
            const today = getTodayDateString();
            const endOfDay = new Date();
            endOfDay.setHours(23, 59, 59, 999); // Set to end of day
            const cookieValue = JSON.stringify({
                date: today,
                fortuneIndex: fortuneIndex
            });
            document.cookie =
                `lastFortuneDraw=${encodeURIComponent(cookieValue)}; expires=${endOfDay.toUTCString()}; path=/`;
        }

        // Function to get fortune cookie
        function getFortuneCookie() {
            const nameEQ = "lastFortuneDraw=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) {
                    try {
                        return JSON.parse(decodeURIComponent(c.substring(nameEQ.length, c.length)));
                    } catch (e) {
                        console.error("Error parsing fortune cookie:", e);
                        // Clear invalid cookie
                        document.cookie = "lastFortuneDraw=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        return null;
                    }
                }
            }
            return null;
        }

        // document.addEventListener("DOMContentLoaded", async () => {
            
        //     const maxDate = new Date(new Date().getFullYear(), 11, 31);

        //     function rangeShortcutPlugin() {
        //         const shortcuts = [{
        //             label: "7 ngày tới",
        //             days: 7
        //         }, {
        //             label: "15 ngày tới",
        //             days: 15
        //         }, {
        //             label: "30 ngày tới",
        //             days: 30
        //         }, ];
        //         return function(fp) {
        //             return {
        //                 onReady: function() {
        //                     const container = document.createElement("div");
        //                     container.className =
        //                         "d-flex justify-content-center flex-wrap gap-2 p-2 border-top";
        //                     shortcuts.forEach(shortcut => {
        //                         const btn = document.createElement("button");
        //                         btn.className = "btn btn-sm btn-outline-primary";
        //                         btn.type = "button";
        //                         btn.textContent = shortcut.label;
        //                         btn.addEventListener("click", () => {
        //                             const startDate = new Date();
        //                             const endDate = new Date();
        //                             endDate.setDate(startDate.getDate() + shortcut
        //                                 .days -
        //                                 1);
        //                             fp.setDate([startDate, endDate], false);
        //                             fp.altInput.value = fp.formatDate(startDate,
        //                                     "d/m/Y") +
        //                                 " - " + fp.formatDate(endDate, "d/m/Y");
        //                             fp.close();
        //                         });
        //                         container.appendChild(btn);
        //                     });
        //                     fp.calendarContainer.appendChild(container);
        //                 }
        //             };
        //         };
        //     }
        //     flatpickr("input[name='groom_dob']", {
        //         dateFormat: "d/m/Y",
        //         maxDate: maxDate,
        //         locale: "vn",
        //     });
        //     flatpickr("input[name='bride_dob']", {
        //         dateFormat: "d/m/Y",
        //         maxDate: maxDate,
        //         locale: "vn",
        //     });
        //     flatpickr(".dateuser", {
        //         dateFormat: "d/m/Y",
        //         maxDate: maxDate,
        //         locale: "vn",
        //     });
        //     flatpickr(".datehome", {
        //         altFormat: "d/m/Y",
        //         dateFormat: "d/m/Y",
        //         maxDate: maxDate,
        //         locale: "vn",
        //     });
        //     const overallMinDate = new Date(new Date().getFullYear() - 10, 0, 1);
        //     const overallMaxDate = new Date(new Date().getFullYear() + 10, 11, 31);
        //     flatpickr('.wedding_date_range', {
        //         mode: "range",
        //         dateFormat: "d/m/Y",
        //         locale: "vn",
        //         minDate: overallMinDate,
        //         maxDate: overallMaxDate,
        //         onChange: function(selectedDates, dateStr, instance) {
        //             if (selectedDates.length === 1) {
        //                 const startDate = selectedDates[0];
        //                 const newMaxDate = new Date(startDate);
        //                 newMaxDate.setMonth(startDate.getMonth() + 13, 0);
        //                 instance.set('minDate', startDate);
        //                 instance.set('maxDate', newMaxDate);
        //             }
        //             if (selectedDates.length === 0) {
        //                 instance.set('minDate', overallMinDate);
        //                 instance.set('maxDate', overallMaxDate);
        //             }
        //         },
        //         onOpen: function(selectedDates, dateStr, instance) {
        //             if (selectedDates.length === 2) {
        //                 instance.set('minDate', overallMinDate);
        //                 instance.set('maxDate', overallMaxDate);
        //             }
        //         },
        //         plugins: [rangeShortcutPlugin()]
        //     });

   
        // });
    </script>


</body>

</html>
