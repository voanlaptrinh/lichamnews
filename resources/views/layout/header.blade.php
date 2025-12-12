<header class="site-header fbs__net-navbar">
    <div class="container-setup d-flex align-items-center justify-content-between">
        <div class="site-logo d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-white">
                <img class="img-fluid me-2" src="{{ asset('/icons/logo_header.svg') }}" alt="logo Phong lịch" width="40"
                    height="40">
                PHONG LỊCH
            </a>
        </div>

        <!-- Menu cho Desktop -->
        <nav class="main-navigation">
            <ul class="main-navigation-list">

                <!-- Bắt đầu: HTML cho Dropdown -->
                {{-- <li class="has-dropdown">
                    <a class="text-white"> Lịch ngày

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                     
                        <li><a href="{{ route('am-lich-hom-nay') }}">Lịch âm hôm nay</a></li>
                        <li><a href="{{ route('am-lich-ngay-mai') }}">Lịch âm ngày mai</a></li>

                    </ul>
                </li> --}}
                <li class="has-dropdown">
                    <span class="text-white"> Lịch & sự kiện

                        <i class="bi bi-chevron-down"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <li class="has-submenu"> <!-- << Class mới để xác định mục có menu con -->
                            <span class="text-white">
                                Lịch tháng
                                <i class="bi bi-chevron-right "></i> <!-- << Icon mũi tên phải -->
                            </span>
                            <!-- Menu cấp 2 (submenu) -->
                            <ul class="submenu">
                                @include('layout.month_list', [
                                    'header_lunar_months' => $header_lunar_months ?? [],
                                ])
                            </ul>
                        </li>

                        <li class="has-submenu"> <!-- << Class mới -->
                            <span class="text-white">
                                Lịch năm
                                <i class="bi bi-chevron-right "></i> <!-- << Icon mũi tên phải -->
                            </span>
                            <!-- Menu cấp 2 (submenu) -->
                            <ul class="submenu">
                                @php($currentYearHeader = date('Y'))
                                @php($startYearHeader = $currentYearHeader - 1)
                                @php($endYearHeader = $currentYearHeader + 10)

                                @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                                    <li>
                                        <a href="{{ route('lich.nam', ['nam' => $year]) }}">
                                            Lịch năm {{ $year }}
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </li>
                        <li class="has-submenu"> <!-- << Class mới -->
                            <span class="text-white">
                                Lịch ngày
                                <i class="bi bi-chevron-right "></i> <!-- << Icon mũi tên phải -->
                            </span>
                            <!-- Menu cấp 2 (submenu) -->
                            <ul class="submenu">
                                <li><a href="{{ route('am-lich-hom-nay') }}">Lịch âm hôm nay</a></li>
                                <li><a href="{{ route('am-lich-ngay-mai') }}">Lịch âm ngày mai</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li><a href="{{ route('convert.am.to.duong') }}">Đổi ngày</a></li>
                <li><a href="{{ route('totxau.list') }}">Xem ngày tốt</a></li>

                <li class="has-dropdown">
                    <span class="text-white">Tử vi & Phong thủy

                        <i class="bi bi-chevron-down"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('laso.create') }}">Lá số tử vi</a></li>
                        <li><a href="{{ route('hoptuoi.list') }}">Xem hướng hợp tuổi</a></li>

                        {{-- <li><a href="{{ route('numerology.index') }}">Thần số học</a></li> --}}
                    </ul>
                </li>
                <li class="has-dropdown">
                    <span class="text-white">Chiêm tinh & Huyền học

                        <i class="bi bi-chevron-down"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('horoscope.index') }}">Cung hoàng đạo</a></li>


                    </ul>
                </li>
                {{-- <li class="has-dropdown">
                    <span class="text-white">Tiện ích khác

                        <i class="bi bi-chevron-down"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('horoscope.index') }}">Cung hoàng đạo</a></li>

                    </ul>
                </li> --}}
            </ul>
        </nav>

        <!-- Icon Hamburger cho Mobile -->
        <div class="mobile-menu-toggle" id="mobile-menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>

        </div>
    </div>
</header>
<div id="header-placeholder"></div>

<!-- Menu cho Mobile (ẩn mặc định) -->
<div class="mobile-navigation" id="mobile-navigation">

    <!-- 1. Header của Menu Mobile -->
    <div class="mobile-nav-header">
        <span class="mobile-nav-logo">
            <!-- Thay bằng logo của bạn -->
            <img src="{{ asset('/icons/logo_header.svg') }}" alt="Logo Phong Lịch mobie" class="img-fluid"
                width="40" height="40">
        </span>
        <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Đóng menu">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <!-- 2. Phần thân Menu (các link chính) -->
    <nav class="mobile-nav-main">
        <ul>

            <li class="has-dropdown">
                <span class="text-white">
                    Lịch & sự kiện
                    <i class="bi bi-chevron-down arrow-icon"></i>
                </span>
                <!-- Menu cấp 1 -->
                <ul class="mobile-submenu">
                    <!-- Menu con "Lịch Tháng" -->
                    <li class="has-dropdown">
                        <span class="text-white">
                            Lịch tháng
                            <i class="bi bi-chevron-down arrow-icon"></i>
                        </span>
                        <!-- Menu cấp 2 -->
                        <ul class="mobile-submenu">
                            @include('layout.month_list', [
                                'header_lunar_months' => $header_lunar_months ?? [],
                            ])
                        </ul>
                    </li>
                    <!-- Menu con "Lịch Năm" -->
                    <li class="has-dropdown">
                        <span class="text-white">
                            Lịch năm
                            <i class="bi bi-chevron-down arrow-icon"></i>
                        </span>
                        <!-- Menu cấp 2 -->
                        <ul class="mobile-submenu">
                            @php($currentYearHeader = date('Y'))
                            @php($startYearHeader = $currentYearHeader - 1)
                            @php($endYearHeader = $currentYearHeader + 10)
                            @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                                <li>
                                    <a href="{{ route('lich.nam', ['nam' => $year]) }}">
                                        Lịch năm {{ $year }}
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <span class="text-white">
                            Lịch ngày
                            <i class="bi bi-chevron-down arrow-icon"></i>
                        </span>
                        <!-- Menu cấp 2 -->
                        <ul class="mobile-submenu">
                            <li><a class="text-white" href="{{ route('am-lich-hom-nay') }}">Lịch âm hôm nay</a></li>
                            <li><a class="text-white" href="{{ route('am-lich-ngay-mai') }}">Lịch âm ngày mai</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('convert.am.to.duong') }}">Đổi ngày</a>
            </li>
            <li>
                <a href="{{ route('totxau.list') }}">Xem ngày tốt</a>
            </li>

            <li class="has-dropdown">
                <span class="text-white">
                   Tử vi & Phong thuỷ
                    <i class="bi bi-chevron-down arrow-icon"></i>
                </span>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('laso.create') }}">Lá số tử vi</a></li>
                        <li><a href="{{ route('hoptuoi.list') }}">Xem hướng hợp tuổi</a></li>

                    {{-- <li><a href="{{ route('numerology.index') }}">Thần số học</a></li> --}}

                </ul>
            </li>
            <li class="has-dropdown">
                <span class="text-white">
                    Chiêm tinh & Huyền học
                    <i class="bi bi-chevron-down arrow-icon"></i>
                </span>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('horoscope.index') }}">Cung hoàng đạo</a></li>


                </ul>
            </li>

        </ul>
    </nav>
</div>

<!-- Lớp phủ nền (ẩn mặc định) -->
<div class="menu-overlay" id="menu-overlay"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Phần code mở/đóng menu chính giữ nguyên)
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileNavigation = document.getElementById('mobile-navigation');
        const mobileNavClose = document.getElementById('mobile-nav-close');
        const menuOverlay = document.getElementById('menu-overlay');

        if (mobileMenuToggle && mobileNavigation) {
            const toggleMenu = (isOpen) => {
                mobileNavigation.classList.toggle('is-open', isOpen);
                if (menuOverlay) menuOverlay.classList.toggle('is-open', isOpen);
                // Ngăn scroll khi menu mở
                document.body.classList.toggle('menu-open', isOpen);
            };
            mobileMenuToggle.addEventListener('click', () => toggleMenu(true));
            if (mobileNavClose) mobileNavClose.addEventListener('click', () => toggleMenu(false));
            if (menuOverlay) menuOverlay.addEventListener('click', () => toggleMenu(false));
        }

        // ---------------------------------------------------------------- //
        // --- BẮT ĐẦU: JS ĐÃ SỬA LỖI CHO DROPDOWN ĐA CẤP --- //
        // ---------------------------------------------------------------- //

        const mobileDropdownToggles = document.querySelectorAll(
            '.mobile-nav-main .has-dropdown > a, .mobile-nav-main .has-dropdown > span');

        mobileDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(event) {
                // Ngăn chặn hành vi mặc định (chỉ áp dụng nếu thẻ a không có href hợp lệ)
                // Nếu bạn muốn link cấp 1 vẫn hoạt động, có thể thêm điều kiện ở đây.
                event.preventDefault();

                const parentLi = this.parentElement;
                const submenu = this.nextElementSibling;

                if (!submenu) return; // Không làm gì nếu không có submenu

                parentLi.classList.toggle('submenu-open');

                // Nếu submenu đang mở, đóng nó và các submenu cha
                if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
                    const heightToClose = submenu.scrollHeight;
                    submenu.style.maxHeight = '0px';

                    // Đi ngược lên và trừ chiều cao khỏi các menu cha
                    updateParentMaxHeight(submenu, -heightToClose);

                } else { // Nếu submenu đang đóng, mở nó và cập nhật các submenu cha
                    const heightToOpen = submenu.scrollHeight;
                    submenu.style.maxHeight = heightToOpen + "px";

                    // Đi ngược lên và cộng chiều cao vào các menu cha
                    updateParentMaxHeight(submenu, heightToOpen);
                }
            });
        });

        /**
         * Hàm đệ quy để cập nhật max-height của các menu cha.
         * @param {HTMLElement} element - Phần tử con vừa thay đổi chiều cao.
         * @param {number} heightChange - Sự thay đổi chiều cao (dương khi mở, âm khi đóng).
         */
        function updateParentMaxHeight(element, heightChange) {
            // Tìm thẻ li cha gần nhất
            const parentLi = element.closest('li.has-dropdown');
            if (!parentLi) return;

            // Tìm menu cha (ul.mobile-submenu) của thẻ li đó
            const parentSubmenu = parentLi.closest('.mobile-submenu');
            if (!parentSubmenu) return;

            // Cập nhật max-height của menu cha
            const currentMaxHeight = parseInt(parentSubmenu.style.maxHeight, 10) || 0;
            const newMaxHeight = currentMaxHeight + heightChange;

            // Đảm bảo không có giá trị âm
            parentSubmenu.style.maxHeight = (newMaxHeight > 0 ? newMaxHeight : 0) + 'px';

            // Tiếp tục đi ngược lên cho đến khi hết menu cha
            updateParentMaxHeight(parentSubmenu, heightChange);
        }

        // Đặt lại max-height về null khi đóng menu chính để tính toán lại cho đúng
        if (mobileNavClose) {
            mobileNavClose.addEventListener('click', () => {
                document.querySelectorAll('.mobile-submenu').forEach(submenu => {
                    submenu.style.maxHeight = null;
                    submenu.parentElement.classList.remove('submenu-open');
                });
            });
        }

    });

    window.addEventListener('popstate', function(event) {
        const mobileNavigation = document.getElementById('mobile-navigation');
        if (mobileNavigation && mobileNavigation.classList.contains('is-open')) {
            mobileNavigation.classList.remove('is-open');
            const menuOverlay = document.getElementById('menu-overlay');
            if (menuOverlay) {
                menuOverlay.classList.remove('is-open');
            }
            document.body.classList.remove('menu-open');
        }
    });

    window.addEventListener('pageshow', function(event) {
        // On pageshow, close the menu if it's open. This handles cases where the page is loaded from cache.
        const mobileNavigation = document.getElementById('mobile-navigation');
        if (mobileNavigation && mobileNavigation.classList.contains('is-open')) {
            mobileNavigation.classList.remove('is-open');
            const menuOverlay = document.getElementById('menu-overlay');
            if (menuOverlay) {
                menuOverlay.classList.remove('is-open');
            }
            document.body.classList.remove('menu-open');
        }
    });
</script>
