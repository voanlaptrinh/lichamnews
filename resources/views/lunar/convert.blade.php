@extends('welcome')

@push('critical-css')
<style>
    /* Ultra-critical LCP optimization - no font-size changes */
    .date-number.duong,
    .date-number.am {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transform: none !important;
        will-change: auto !important;
        animation: none !important;
        transition: none !important;
        position: static !important;
        z-index: auto !important;
        filter: none !important;
        backdrop-filter: none !important;
        mask: none !important;
        clip-path: none !important;
        contain: none !important;
        content-visibility: visible !important;
        -webkit-transform: none !important;
        -webkit-font-smoothing: auto !important;
        text-rendering: optimizeSpeed !important;
    }

    /* Optimize parent containers */
    .date-display-card {
        background: white !important;
        contain: none !important;
        content-visibility: visible !important;
        will-change: auto !important;
        transform: translateZ(0) !important;
    }

    .col-6 {
        position: static !important;
        transform: none !important;
        will-change: auto !important;
    }

    /* Remove all animations on critical path */
    .row, .col-6, .text-center {
        animation: none !important;
        transition: none !important;
    }

    /* Force browser to prioritize these elements */
    #lcp-duong, #lcp-am {
        contain-intrinsic-size: auto !important;
        font-display: block !important;
    }

    /* Preload system fonts */
    @font-face {
        font-family: 'Arial';
        font-display: block;
        src: local('Arial');
    }
</style>
@endpush

@section('content')
    @php
        $today = \Carbon\Carbon::now();
        $currentDate = \Carbon\Carbon::createFromDate($yy, $mm, $dd);
        $isToday = $today->isSameDay($currentDate);
    @endphp

    <div class="calendar-app-container py-4">
        <script>
            // Ultra-fast LCP optimization
            (function() {
                'use strict';
                var lcpDuong = document.getElementById('lcp-duong');
                var lcpAm = document.getElementById('lcp-am');
                if(lcpDuong) {
                    lcpDuong.style.visibility = 'visible';
                    lcpDuong.style.opacity = '1';
                    void lcpDuong.offsetHeight;
                }
                if(lcpAm) {
                    lcpAm.style.visibility = 'visible';
                    lcpAm.style.opacity = '1';
                    void lcpAm.offsetHeight;
                }
            })();
        </script>
        <div class="row g-0">
            <div class="col-xl-9">

                <div class="d-flex justify-content-between mb-3  ">

                    <h1 class="content-title-home-lich">Lịch Âm - Lịch Vạn Niên</h1>
                    <div class="d-flex gap-2">
                        <button
                            class=" btn-today-home-pc btn-today-home justify-content-center align-items-center quickPickerBtn">
                            <i class="bi bi-calendar-event pe-2"></i>
                            <div>Xem nhanh theo ngày</div>
                        </button>

                    </div>

                </div>
            </div>
        </div>
        <div class="row g-3">
            <!-- ==== CỘT LỊCH CHÍNH (BÊN TRÁI) ==== -->
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="boxx-col-lg-8">
                    <div class="d-flex flex-column gap-20 box-content-lg-8">

                        <!-- ** KHỐI NGÀY DƯƠNG LỊCH VÀ ÂM LỊCH ** -->
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="date-display-card">
                                    {{-- Nút Prev Day PC --}}
                                    <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn"
                                        title="Ngày hôm trước"><i class="bi bi-chevron-left"></i></a>
                                    <div class="text-center">
                                        <div class="card-title title-amduowngbox"><img
                                                src="{{ asset('icons/icon_duong.svg') }}" alt="icon_duong" width="20"
                                                height="20" loading="eager"> Dương lịch</div>
                                        <div class="date-number duong date_number_lich" id="lcp-duong" style="visibility: visible !important; opacity: 1 !important;">{{ $dd }}</div>
                                        <div class="date-weekday">{{ $weekday }}</div>
                                        <div class="date-special-event text-dark">Tháng {{ $mm }} năm
                                            {{ $yy }}</div>

                                        <div class="date-special-event date-special-event-duong">
                                            @if (!empty($suKienDuongLich))
                                                @foreach ($suKienDuongLich as $suKien)
                                                    <div class="su-kien-duong"> {{ $suKien['ten_su_kien'] ?? $suKien }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Nút Next Day PC (Đã sửa) --}}
                                    {{-- Nút này thường nằm trong phần Âm lịch để căn chỉnh đẹp hơn, tôi sẽ di chuyển nó sang đó. --}}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="date-display-card">
                                    <div class="text-center">
                                        <div class="card-title title-amduowngbox"><img
                                                src="{{ asset('icons/icon_am.svg') }}" alt="icon_am" width="20"
                                                height="20" loading="eager"> Âm lịch</div>
                                        <div class="date-number am date_number_lich date_number_lich_am" id="lcp-am" style="visibility: visible !important; opacity: 1 !important;">{{ $al[0] }}</div>
                                        <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                            {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                                        <div class="date-special-event text-dark">Ngày
                                            {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                            -
                                            Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                                        </div>
                                        <div class="date-special-event date-special-event-duong">
                                            @if (!empty($suKienAmLich))
                                                @foreach ($suKienAmLich as $suKien)
                                                    <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    {{-- Nút Next Day PC (Đã sửa và di chuyển vào đây) --}}
                                    <a href="#" class="nav-arrow nav-home-date nave-right next-day-btn"
                                        title="Ngày hôm sau"> <i class="bi bi-chevron-right"></i></a>
                                    @if ($tot_xau_result == 'tot')
                                        <div class="day-status hoang-dao">
                                            <span class="status-dot"></span>
                                            <span class="title-status-dot"> Hoàng đạo</span>
                                        </div>
                                    @elseif($tot_xau_result == 'xau')
                                        <div class="day-status hac-dao">
                                            <span class="status-dot"></span>
                                            <span class="title-status-dot"> Hắc đạo</span>
                                        </div>
                                    @else
                                        <div class="day-status ">

                                        </div>
                                    @endif

                                </div>
                            </div>
                          

                            <div class="col-lg-12 btn-mobie-next-prev">
                                <div>
                                    <button
                                        class="btn-today-home-mob d-flex justify-content-center align-items-center quickPickerBtn">
                                        <i class="bi bi-calendar-event pe-2"></i>
                                        <div>Xem nhanh</div>
                                    </button>



                                </div>
                                <div class="d-flex gap-2">
                                    <div class="div">
                                        {{-- Nút Prev Day Mobile --}}
                                        <a href="#" class="nav-arrow prev-day-btn-mobie  nave-left prev-day-btn"
                                            title="Ngày hôm trước"><i class="bi bi-chevron-left"></i></a>
                                    </div>
                                    <div class="div">
                                        {{-- Nút Next Day Mobile --}}
                                        <a href="#" class="nav-arrow  next-day-btn-mobie nave-right next-day-btn"
                                            title="Ngày hôm sau"> <i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="ring-item1-left item-rings">
                                <div class="item-ring1">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing" width="13"
                                        height="55" loading="lazy" decoding="async">
                                </div>
                                <div class="item-ring2">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing" width="13"
                                        height="55" loading="lazy" decoding="async">
                                </div>
                            </div>
                            <div class="ring-item2-right item-rings">
                                <div class="item-ring3">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing" width="13"
                                        height="55" loading="lazy" decoding="async">
                                </div>
                                <div class="item-ring4">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing" width="13"
                                        height="55" loading="lazy" decoding="async">
                                </div>
                            </div>
                        {{-- d-sm-block d-block d-xl-none --}}
                        <div class="position-relative bix-title-thangnam">

                            <div class="info-card ">
                                <div class="d-flex justify-content-center justify-content-md-start pb-2">
                                    <div class=" --posyon-ngay">
                                        <div class="ngay-hom-ngay --homnay-home">
                                            Âm lịch Ngày <span id="luna-date">{{ $al[0] }}</span> <span
                                                id="luna-month">Tháng {{ $al[1] }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="coli-row">
                                    <div class="col-xl-7 col-lg-6 col-sm-12 col-12 ">
                                        <div class="info-item">
                                            <img src="{{ asset('icons/icon_tiet_khi.svg') }}" alt="icon_tiet_khi"
                                                class="icon_tiet_khi" width="24" height="24" loading="eager">
                                            <div class="font-detail-ngay">
                                                <strong class="title-font-detail-ngay">Tiết khí:</strong>
                                                <span class="">{{ $tietkhi['tiet_khi'] }}</span>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <img src="{{ asset('icons/icon_nap_am.svg') }}" alt="icon_nap_am"
                                                class="icon_nap_am" width="24" height="24" loading="eager">
                                            <div class="font-detail-ngay">
                                                <strong class="title-font-detail-ngay">Ngũ hành nạp âm:</strong>
                                                {{ $getThongTinNgay['nap_am']['napAm'] }}
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <img src="{{ asset('icons/icon_hoang_dao.svg') }}" alt="icon_hoang_dao"
                                                class="icon_hoang_dao" width="24" height="24" loading="eager">

                                            <div class="font-detail-ngay" style="visibility: visible !important; opacity: 1 !important; will-change: auto; transform: translateZ(0);">
                                                <strong class="title-font-detail-ngay">Giờ Hoàng đạo:</strong>
                                                <span id="gio-hoang-dao-content" style="display: inline-block; visibility: visible !important; opacity: 1 !important;">{{ $getThongTinNgay['gio_hoang_dao'] ?? 'Đang tính...' }}</span>
                                            </div>
                                            <script>
                                                // Force immediate paint for LCP element
                                                document.getElementById('gio-hoang-dao-content').style.visibility = 'visible';
                                            </script>

                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6 col-sm-12 col-12">
                                        <!-- BẮT ĐẦU: KHỐI MỨC THUẬN LỢI (ĐÃ CẬP NHẬT) -->
                                        <div
                                            class="convenience-level g-0 d-flex justify-content-between align-items-center h-100">
                                            <div class="level-label text-lever-label-mobie">
                                                Điểm chỉ số <br>ngày tốt:
                                            </div>
                                            <div class="progress-dial mt-2"
                                                style="--value: {{ round($getDaySummaryInfo['score']['percentage']) }};">
                                                <div class="dial-text">
                                                    <span
                                                        class="dial-percent">{{ round($getDaySummaryInfo['score']['percentage']) }}%</span>
                                                    @php
                                                        $ratingColors = [
                                                            'Tốt' => 'text-success',
                                                            'Xấu' => 'text-danger',
                                                            'Trung bình' => 'text-warning-tb',
                                                        ];
                                                    @endphp

                                                    <small
                                                        class="dial-status {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? 'text-secondary' }}">
                                                        {{ $getDaySummaryInfo['score']['rating'] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- KẾT THÚC: KHỐI MỨC THUẬN LỢI -->
                                    </div>
                                </div>


                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('detai_home', ['nam' => $yy, 'thang' => $mm, 'ngay' => $dd]) }}"
                                        class="btn btn-primary w-100 mt-3 btn0mobie"><img
                                            src="{{ asset('icons/hand_2_white.svg') }}" alt="hand_2" width="28"
                                            height="28" class="img-fluid" loading="lazy">
                                        Xem
                                        chi tiết ngày</a>
                                </div>
                            </div>
                        </div>

                        <!-- ** LỊCH THÁNG ** -->
                        <div class="calendar-wrapper">

                            <div class="calendar-header-convert calendar-header pe-lg-2">
                                <div class="text-center">
                                    <div class="mb-0 pt-2 lich-van--nien">Lịch vạn niên {{ $yy }} - tháng
                                        {{ $mm }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2 select-with-icon">

                                        <div class="select-wrapper">

                                            <select id="month-select" class="form-select custom-select-style "
                                                aria-label="Chọn tháng">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $mm ? 'selected' : '' }}>
                                                        Tháng {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="select-with-icon">

                                        <div class="select-wrapper">

                                            <select id="year-select" class="form-select custom-select-style"
                                                aria-label="Chọn năm">
                                                <option value="{{ $yy }}">Năm {{ $yy }}</option>
                                            </select>



                                        </div>
                                    </div>
                                </div>
                                {{--   <a href="{{ route('detai_home', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                                    class="btn-today-home-pc btn-today-home">
                                    <i class="bi bi-calendar-plus pe-1-pc-home"></i> Hôm nay
                                </a> --}}
                            </div>
                            <div id="calendar-body-container">
                                <table class="calendar-table">
                                    <thead>
                                        <tr>
                                            <th><span class="title-lich-pc">Thứ Hai</span> <span
                                                    class="title-lich-mobie">Th
                                                    2</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ Ba</span> <span
                                                    class="title-lich-mobie">Th
                                                    3</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ Tư</span> <span
                                                    class="title-lich-mobie">Th
                                                    4</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ Năm</span> <span
                                                    class="title-lich-mobie">Th
                                                    5</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ Sáu</span> <span
                                                    class="title-lich-mobie">Th
                                                    6</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ Bảy</span> <span
                                                    class="title-lich-mobie">Th
                                                    7</span>
                                            </th>
                                            <th><span class="title-lich-pc">Chủ Nhật</span> <span
                                                    class="title-lich-mobie">CN</span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $table_html !!}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="calendar-legend">
                            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>

                        </div>
                    </div>
                </div>
                <section class="popular-utilities d-xl-none pt-0 pb-0 mt-4">
                    <div class="container bg-section-tienich">
                        <h2 class="section-title">Sự kiện, ngày lễ sắp tới</h2>
                        <hr>
                        @foreach (array_slice($upcomingEvents, 0, 3) as $event)
                            @php
                                $eventCarbonDate = Carbon\Carbon::parse($event['date']);
                                $routeParams = [
                                    'nam' => $eventCarbonDate->year,
                                    'thang' => $eventCarbonDate->month,
                                    'ngay' => $eventCarbonDate->day,
                                ];

                                // Chuyển đổi sang âm lịch
                                $lunarDate = App\Helpers\LunarHelper::convertSolar2Lunar(
                                    $eventCarbonDate->day,
                                    $eventCarbonDate->month,
                                    $eventCarbonDate->year,
                                );
                            @endphp
                            <a class="hv-memorial-widget-root mt-3" href="{{ route('detai_home', $routeParams) }}">
                                <div class="hv-memorial-date-panel">
                                    <div class="hv-memorial-month-text">Tháng
                                        {{ Carbon\Carbon::parse($event['date'])->format('n') }}</div>
                                    <div class="hv-memorial-day-digit">
                                        {{ Carbon\Carbon::parse($event['date'])->format('d') }}</div>
                                    <div class="hv-memorial-lunar-calendar-info">
                                        {{ $lunarDate[0] }}/{{ $lunarDate[1] }} ÂL</div>
                                </div>
                                <div class="hv-memorial-event-summary">
                                    <h3 class="hv-memorial-event-title">{{ $event['description'] }}</h3>
                                    <div class="hv-memorial-countdown-display">
                                        @if ($event['days_remaining'] === 0)
                                            Hôm nay
                                        @elseif ($event['days_remaining'] === 1)
                                            Còn 1 ngày
                                        @else
                                            Còn {{ $event['days_remaining'] }} ngày
                                        @endif
                                        <!-- Sử dụng SVG cho mũi tên để có độ chính xác cao nhất về hình dáng -->
                                        <svg class="hv-memorial-countdown-arrow" viewBox="0 0 24 24" width="16"
                                            height="16" fill="currentColor">
                                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
                                        </svg>
                                    </div>
                                </div>

                            </a>
                        @endforeach


                    </div>
                </section>
                <section class="popular-utilities">
                    <div class="container bg-section-tienich">
                        <h2 class="section-title">Tiện ích phổ biến</h2>
                        <hr>
                        <div class="utilities-grid pt-2 row">

                            <!-- Tiện ích 1 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4 ">
                                <div class="utility-title">Đổi ngày Âm - Dương</div>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/doi_ngay_am_duong.webp?v=2.0') }}" alt="Đổi ngày Âm - Dương"
                                        width="77" height="76" class="img-fluid" loading="lazy">
                                </div>

                                <p class="utility-description">Chuyển đổi nhanh giữa dương lịch và âm lịch.</p>
                            </a>

                            <!-- Tiện ích 2 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <div class="utility-title">Xem ngày Tốt</div>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/xem_ngay_tot.webp?v=2.0') }}" alt="Xem ngày Tốt" width="77"
                                        height="76" class="img-fluid" loading="lazy">
                                </div>

                                <p class="utility-description">Tra cứu ngày hoàng đạo để cưới hỏi, khai trương...</p>
                            </a>

                            <!-- Tiện ích 3 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <div class="utility-title">Xem hướng hợp mệnh</div>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/huong_dep.webp?v=2.0') }}" alt="Xem hướng hợp mệnh"
                                        width="77" height="76" class="img-fluid" loading="lazy">
                                </div>
                                <p class="utility-description">Tìm hướng hợp tuổi để làm nhà, đặt bàn thờ...</p>
                            </a>

                            <!-- Tiện ích 4 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <div class="utility-title">Lá số tử vi</div>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/la_so_tu_vi.webp?v=2.0') }}" alt="Lá số tử vi" class="img-fluid"
                                        width="77" height="76" loading="lazy">
                                </div>

                                <p class="utility-description">Lập lá số chi tiết theo giờ/ngày sinh.</p>
                            </a>

                        </div>
                    </div>
                </section>
                <section class="popular-utilities pt-0">
                    <div class="container bg-section-tienich">
                        <h2 class="section-title">Điểm chỉ số ngày tốt trong 7 ngày sắp tới</h2>
                        <hr>
                        <div class="utilities-grid row g-4 pt-2">
                            <div class="chart-container">
                                <div id="html-chart-container" class="html-chart-wrapper">
                                    <!-- Chart will be rendered here with HTML/CSS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==== KHỐI SỰ KIỆN CHO MOBILE/TABLET - CHỈ HIỆN 3 SỰ KIỆN ==== -->

                <div class="van-lien-hows">

                    <h2 class="title-tong-quan-h2">Lịch Vạn Niên Là Gì?</h2>
                    <hr>
                    <p><b>Lịch Vạn Niên</b> là một công cụ tra cứu ngày tháng đặc biệt, kết hợp giữa hai hệ thống lịch
                        phổ
                        biến:
                        <b>Dương lịch</b> (lịch quốc tế, được sử dụng rộng rãi trên toàn thế giới) và <b>Âm lịch</b>
                        (hay
                        còn gọi là Lịch
                        âm – lịch truyền thống phương Đông, gắn liền với đời sống văn hóa của người Việt Nam).
                    </p>
                    <p>Từ hàng nghìn năm trước, Âm lịch đã được ông cha ta sử dụng để xem ngày tốt, lựa chọn ngày lành
                        tháng
                        tốt cho những công việc trọng đại như cưới hỏi, động thổ, khai trương, xuất hành, ma chay hay
                        thờ
                        cúng tổ tiên. Lịch không chỉ phản ánh sự vận động của Mặt trăng và Mặt trời mà còn gắn liền với
                        những yếu tố tâm linh, phong thủy và tử vi trong đời sống hằng ngày.</p>
                    <p>Theo dòng chảy lịch sử, Lịch vạn niên đã phát triển và trở thành kho tàng tri thức cổ truyền, kết
                        hợp
                        tinh hoa của Thiên văn học phương Đông, Ngũ hành, Bát tự, Can Chi, Tử vi lý số. Vì thế, khi nhắc
                        đến
                        Lịch vạn niên, chúng ta không chỉ nghĩ đến việc xem ngày tháng, mà còn nhắc đến một nền văn hóa
                        gắn
                        bó với đời sống tâm linh và tín ngưỡng của người Việt.</p>
                    <h3 class="title-tong-quan-h3-log">Tại Sao Nên Sử Dụng Lịch Vạn Niên Của Phong Lịch?</h3>
                    <h4 class="title-tong-quan-h4-log">1. Tra cứu nhanh chóng và chính xác</h4>
                    <ul>
                        <li>Xem đầy đủ cả Âm lịch và Dương lịch theo từng ngày, tháng, năm.</li>
                        <li>Cập nhật chi tiết: Lịch ngày tốt, ngày Hoàng đạo – Hắc đạo, Tiết khí, sao chiếu mệnh, giờ
                            xuất
                            hành tốt.</li>
                        <li>Giúp bạn dễ dàng trả lời câu hỏi “Hôm nay tốt hay xấu?”, “Ngày mai có giờ tốt không?”</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">2. Xem ngày tốt hợp tuổi</h4>
                    <ul>
                        <li>Chọn ngày cưới hỏi, khai trương, động thổ, xuất hành dựa theo tuổi và Can Chi của gia chủ.
                        </li>
                        <li>Hỗ trợ tránh những ngày phạm Kim Lâu, Hoang Ốc, Tam Tai để công việc được hanh thông.</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">3. Tích hợp kiến thức tử vi – phong thủy</h4>
                    <ul>
                        <li>Lập lá số tử vi chi tiết theo ngày, tháng, năm sinh.</li>
                        <li>Xem vận hạn theo năm, dự đoán cát hung, hướng đi phù hợp.</li>
                        <li>Hướng dẫn lựa chọn hướng nhà, hướng bàn thờ, hướng xuất hành theo phong thủy bát trạch.</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">4. Giao diện thân thiện – dễ sử dụng</h4>
                    <ul>
                        <li>Thiết kế hiện đại, đơn giản, tối ưu cho cả máy tính và điện thoại.</li>
                        <li>Thân thiện với mọi đối tượng: từ người cao tuổi muốn tra cứu Lịch âm dương hằng ngày đến
                            giới
                            trẻ quan tâm đến tử vi, phong thủy.</li>
                    </ul>
                    <h3 class="title-tong-quan-h3-log">Lịch Vạn Niên Trong Thời Đại Số</h3>
                    <p>Nếu trước đây, Lịch vạn niên chủ yếu tồn tại dưới dạng sách in dày hàng trăm trang, thì ngày nay,
                        nhờ
                        sự phát triển của công nghệ, Lịch vạn niên đã được số hóa hoàn toàn.</p>
                    <ul>
                        <li>Người dùng có thể tra cứu Lịch âm, Âm lịch, Dương lịch mọi lúc, mọi nơi trên máy tính, điện
                            thoại thông minh.</li>
                        <li>Chỉ với vài thao tác, bạn đã có thể xem chi tiết: ngày tốt xấu, ngày Hoàng đạo, Tiết khí,
                            giờ
                            hoàng đạo, tuổi xung khắc….</li>
                        <li>Sự kết hợp giữa tri thức cổ truyền và công nghệ hiện đại giúp việc xem ngày tốt, xem giờ tốt
                            trở
                            nên tiện lợi, nhanh chóng và chính xác hơn bao giờ hết.</li>
                    </ul>
                    <h3 class="title-tong-quan-h3-log">Phong Lịch – Đồng Hành Cùng Người Việt</h3>
                    <p>Dù bạn là người quan tâm đến tử vi, phong thủy, hay chỉ đơn giản muốn biết hôm nay là ngày gì
                        theo
                        Lịch âm, ngày mai có giờ tốt để xuất hành hay không, Phong Lịch luôn sẵn sàng đồng hành cùng
                        bạn.
                    </p>
                    <p>Với Lịch vạn niên trực tuyến, Phong Lịch không chỉ mang đến trải nghiệm tra cứu thuận tiện mà còn
                        giữ
                        gìn và lan tỏa những giá trị văn hóa truyền thống của dân tộc.</p>
                    <p>Phong Lịch – Tra cứu Lịch Âm, Lịch Vạn Niên, Lịch ngày tốt, Xem ngày Hoàng đạo, Tiết khí, Xem
                        ngày
                        tốt – Xem giờ tốt nhanh chóng, chính xác và miễn phí</p>
                </div>
            </div>
            <style>



            </style>
            <!-- ==== CỘT THÔNG TIN (BÊN PHẢI) - CHỈ HIỆN TRÊN DESKTOP ==== -->
            <div class="col-xl-3 d-none d-xl-block">
                <div class="d-flex flex-column gap-4">
                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <div class="card-title-right">Sự kiện, ngày lễ sắp tới</div>
                        <div class="boxx--sukiensaptoi">
                            @foreach ($upcomingEvents as $event)
                                @php
                                    // Phân tích cú pháp ngày sự kiện một lần để lấy các phần tử năm, tháng, ngày
                                    $eventCarbonDate = Carbon\Carbon::parse($event['date']);
                                    $routeParams = [
                                        'nam' => $eventCarbonDate->year,
                                        'thang' => $eventCarbonDate->month,
                                        'ngay' => $eventCarbonDate->day,
                                    ];

                                    // Chuyển đổi sang âm lịch
                                    $lunarDate = App\Helpers\LunarHelper::convertSolar2Lunar(
                                        $eventCarbonDate->day,
                                        $eventCarbonDate->month,
                                        $eventCarbonDate->year,
                                    );
                                @endphp
                                <a class="hv-memorial-widget-root mt-3" href="{{ route('detai_home', $routeParams) }}">
                                    <div class="hv-memorial-date-panel">
                                        <div class="hv-memorial-month-text">Tháng
                                            {{ Carbon\Carbon::parse($event['date'])->format('n') }}</div>
                                        <div class="hv-memorial-day-digit">
                                            {{ Carbon\Carbon::parse($event['date'])->format('d') }}</div>
                                        <div class="hv-memorial-lunar-calendar-info">
                                            {{ $lunarDate[0] }}/{{ $lunarDate[1] }} ÂL</div>
                                    </div>
                                    <div class="hv-memorial-event-summary">
                                        <h3 class="hv-memorial-event-title">{{ $event['description'] }}</h3>
                                        <div class="hv-memorial-countdown-display">
                                            @if ($event['days_remaining'] === 0)
                                                Hôm nay
                                            @elseif ($event['days_remaining'] === 1)
                                                Còn 1 ngày
                                            @else
                                                Còn {{ $event['days_remaining'] }} ngày
                                            @endif
                                            <!-- Sử dụng SVG cho mũi tên để có độ chính xác cao nhất về hình dáng -->
                                            <svg class="hv-memorial-countdown-arrow" viewBox="0 0 24 24" width="16"
                                                height="16" fill="currentColor">
                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
                                            </svg>
                                        </div>
                                    </div>

                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==== POPUP CHỌN NHANH LỊCH ==== -->
    <div class="quick-picker-overlay" id="quickPickerOverlay">
        <div class="quick-picker-modal">
            <button class="close-btn-popup" id="closeQuickPicker"><i class="bi bi-x"></i></button>
            <div class="quick-picker-header">
                <h4 class="quick-picker-title">THÁNG <span id="popupMonth">{{ $mm }}</span> - <span
                        id="popupYear">{{ $yy }}</span></h4>
                <div class="quick-picker-nav">
                    <button class="nav-btn" id="prevMonthBtn"><i class="bi bi-chevron-left"></i></button>
                    <button class="nav-btn" id="nextMonthBtn"><i class="bi bi-chevron-right"></i></button>
                </div>

            </div>

            <div class="quick-picker-calendar">
                <div class="weekdays">
                    <div class="weekday-popup">Th 2</div>
                    <div class="weekday-popup">Th 3</div>
                    <div class="weekday-popup">Th 4</div>
                    <div class="weekday-popup">Th 5</div>
                    <div class="weekday-popup">Th 6</div>
                    <div class="weekday-popup">Th 7</div>
                    <div class="weekday-popup">CN</div>
                </div>
                <div class="calendar-days" id="popupCalendarDays">
                    <!-- Days will be populated by JavaScript -->
                </div>
            </div>

            <div class="quick-picker-forms">
                <div class="form-section-popup">
                    <div class="form-header-popup">
                        <i class="bi bi-brightness-high"></i>
                        <span>Dương Lịch</span>
                    </div>
                    <div class="form-row">
                        <select id="solarDay" class="form-select form-select-config">
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ $i == $dd ? 'selected' : '' }}>Ngày
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="solarMonth" class="form-select form-select-config">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == $mm ? 'selected' : '' }}>Tháng
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="solarYear" class="form-select form-select-config">
                            @for ($i = 1900; $i <= 2100; $i++)
                                <option value="{{ $i }}" {{ $i == $yy ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-section-popup">
                    <div class="form-header-popup">
                        <i class="bi bi-moon"></i>
                        <span>Âm Lịch</span>
                    </div>
                    <div class="form-row">
                        <select id="lunarDay" class="form-select form-select-config">
                            @for ($i = 1; $i <= 30; $i++)
                                <option value="{{ $i }}" {{ $i == ($al[0] ?? 1) ? 'selected' : '' }}>Ngày
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="lunarMonth" class="form-select form-select-config">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == ($al[1] ?? 1) ? 'selected' : '' }}>Tháng
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="lunarYear" class="form-select form-select-config">
                            @for ($i = 1900; $i <= 2100; $i++)
                                <option value="{{ $i }}" {{ $i == $yy ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="quick-picker-footer">
                <button class="btn-view" id="viewDateBtn">XEM</button>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/html-chart.css?v=3.1') }}">
    <style>
        .event-date .solar-date {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 2px;
        }

        .event-date .lunar-date {
            font-size: 12px;
            color: #46494E;
            font-style: italic;
        }

        .event-date {
            text-align: center;
            line-height: 1.2;
        }

        .select-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .select-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            color: #6c757d;
            pointer-events: none;
            font-size: 14px;
        }

        .select-with-icon-input {
            padding-left: 35px !important;
            position: relative;
            z-index: 2;
            background: transparent;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/base-picker.js?v=3.1') }}"></script>
    <script src="{{ asset('js/homepage-picker.js?v=3.1') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Khởi tạo ứng dụng lịch âm cho trang chủ (không thay đổi URL)
            const homepageApp = new HomepagePicker({
                currentYear: {{ $yy }},
                currentMonth: {{ $mm }},
                currentDay: {{ $dd }},
                labels: @json($labels),
                dataValues: @json($dataValues),
                ajaxUrl: '{{ route('lunar.getDateDataAjax') }}',
                calendarAjaxUrl: '{{ route('lich.thang.ajax') }}'
            });

            homepageApp.init();
            const select = document.getElementById('year-select');
            const start = 1900;
            const end = 2100;
            const current = {{ $yy }};
            let loaded = false;

            select.addEventListener('focus', () => {
                if (loaded) return; // chỉ load 1 lần
                loaded = true;
                for (let i = start; i <= end; i++) {
                    if (i === current) continue;
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = `Năm ${i}`;
                    select.appendChild(opt);
                }
            });
        });
    </script>
@endpush
