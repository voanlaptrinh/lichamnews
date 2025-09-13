<header class="site-header fbs__net-navbar">
    <div class="container-setup d-flex align-items-center justify-content-between">
        <div class="site-logo d-flex align-items-center">
            <a href="#" class="text-white">
                {{-- <img class="img-logo w-100" src="{{ asset('/users/images/logo-FunHome.svg') }}" alt=""> --}}
                NGUYỆT LỊCH.COM
            </a>
        </div>

        <!-- Menu cho Desktop -->
        <nav class="main-navigation">
            <ul>

                <!-- Bắt đầu: HTML cho Dropdown -->
                <li class="has-dropdown">
                    <a href="#"> Lịch ngày

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @php
                            $todayHref = '/am-lich/nam/' . date('Y') . '/thang/' . date('n') . '/ngay/' . date('j');
                            $tomorrowHref =
                                '/am-lich/nam/' .
                                date('Y', strtotime('+1 day')) .
                                '/thang/' .
                                date('n', strtotime('+1 day')) .
                                '/ngay/' .
                                date('j', strtotime('+1 day'));
                        @endphp
                        <li><a href="{{ $todayHref }}">Lịch âm hôm nay</a></li>
                        <li><a href="{{ $tomorrowHref }}">Lịch âm ngày mai</a></li>

                    </ul>
                </li>
                <li><a href="{{route('convert.am.to.duong')}}">Đổi lịch</a></li>
                <li class="has-dropdown">
                    <a href="#"> Lịch tháng & năm

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="has-submenu"> <!-- << Class mới để xác định mục có menu con -->
                            <a href="#">
                                Lịch Tháng
                                <i class="bi bi-chevron-right "></i> <!-- << Icon mũi tên phải -->
                            </a>
                            <!-- Menu cấp 2 (submenu) -->
                            <ul class="submenu">
                                @php($currentYear = date('Y'))
                                @for ($month = 1; $month <= 12; $month++)
                                    <li>
                                        <a href="{{ route('lich.thang', ['nam' => $currentYear, 'thang' => $month]) }}">Tháng
                                            {{ $month }}</a>
                                    </li>
                                @endfor
                                {{-- <li><a href="/lich-thang/2024/1">Tháng 1, 2024</a></li>
                                <li><a href="/lich-thang/2024/2">Tháng 2, 2024</a></li>
                                <li><a href="/lich-thang/2024/3">Tháng 3, 2024</a></li> --}}
                                <!-- Thêm các tháng khác nếu muốn -->
                            </ul>
                        </li>

                        <li class="has-submenu"> <!-- << Class mới -->
                            <a href="/lich-nam">
                                Lịch Năm
                                <i class="bi bi-chevron-right "></i> <!-- << Icon mũi tên phải -->
                            </a>
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
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#"> Xem ngày tốt

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/dich-vu">Dịch vụ</a></li>
                        <li><a href="">Tìm phòng</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#">Phong thủy & tử vi

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/dich-vu">Dịch vụ</a></li>
                        <li><a href="">Tìm phòng</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#">
                        Tiện ích
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="">Dịch vụ</a></li>
                        <li><a href="">Tìm phòng</a></li>

                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Icon Hamburger cho Mobile -->
        <div class="mobile-menu-toggle" id="mobile-menu-toggle">
            <i class="bi bi-grid"></i>
        </div>
    </div>
</header>
<div id="header-placeholder"></div>

<!-- Menu cho Mobile (ẩn mặc định) -->
<div class="mobile-navigation" id="mobile-navigation">

    <!-- 1. Header của Menu Mobile -->
    <div class="mobile-nav-header">
        <a href="#" class="mobile-nav-logo">
            <!-- Thay bằng logo của bạn -->
            <img src="" alt="Logo" class="img-fluid">
        </a>
        <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Đóng menu">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <!-- 2. Phần thân Menu (các link chính) -->
    <nav class="mobile-nav-main">
        <ul>

            <!-- Bắt đầu: HTML cho Dropdown Mobile -->
            <li class="has-dropdown">
                <a href="#">
                    Lịch ngày
                    <i class="bi bi-chevron-down arrow-icon"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="{{ $todayHref }}">Lịch âm hôm nay</a></li>
                    <li><a href="{{ $tomorrowHref }}">Lịch âm ngày mai</a></li>

                </ul>
            </li>
            <li>
                <a href="{{route('convert.am.to.duong')}}">Đổi lịch</a>
            </li>
            <li class="has-dropdown">
                <a href="#">
                    Lịch tháng & năm
                    <i class="bi bi-chevron-down arrow-icon"></i>
                </a>
                <!-- Menu cấp 1 -->
                <ul class="mobile-submenu">
                    <!-- Menu con "Lịch Tháng" -->
                    <li class="has-dropdown">
                        <a href="#">
                            Lịch Tháng
                            <i class="bi bi-chevron-down arrow-icon"></i>
                        </a>
                        <!-- Menu cấp 2 -->
                        <ul class="mobile-submenu">
                            @php($currentYear = date('Y'))
                            @for ($month = 1; $month <= 12; $month++)
                                <li>
                                    <a href="{{ route('lich.thang', ['nam' => $currentYear, 'thang' => $month]) }}">Tháng
                                        {{ $month }}</a>
                                </li>
                            @endfor
                        </ul>
                    </li>
                    <!-- Menu con "Lịch Năm" -->
                    <li class="has-dropdown">
                        <a href="#">
                            Lịch Năm
                            <i class="bi bi-chevron-down arrow-icon"></i>
                        </a>
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
                </ul>
            </li>

            <!-- Bắt đầu: HTML cho Dropdown Mobile -->
            <li class="has-dropdown">
                <a href="#">
                    HỆ THỐNG
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="">Dịch vụ</a></li>
                    <li><a href="">Tìm phòng</a></li>

                </ul>
            </li>
            <li class="has-dropdown">
                <a href="#">
                    Tiện ích
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="">Dịch vụ</a></li>
                    <li><a href="">Tìm phòng</a></li>

                </ul>
            </li>
            <!-- Kết thúc: HTML cho Dropdown Mobile -->
            <li><a href="">TIN TỨC</a></li>
            <li><a href="">LIÊN HỆ</a></li>
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
            };
            mobileMenuToggle.addEventListener('click', () => toggleMenu(true));
            if (mobileNavClose) mobileNavClose.addEventListener('click', () => toggleMenu(false));
            if (menuOverlay) menuOverlay.addEventListener('click', () => toggleMenu(false));
        }

        // ---------------------------------------------------------------- //
        // --- BẮT ĐẦU: JS ĐÃ SỬA LỖI CHO DROPDOWN ĐA CẤP --- //
        // ---------------------------------------------------------------- //

        const mobileDropdownToggles = document.querySelectorAll('.mobile-nav-main .has-dropdown > a');

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
</script>
