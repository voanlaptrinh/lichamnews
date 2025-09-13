@extends('welcome')
@section('content')

    <div class="container-setup">
        <h6 class="content-title-date-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <span>Chi tiết ngày</span>
        </h6>
        <div class="box-date-detail">
            <div class="row g-3">
                <div class="col-6">
                    <div class="date-display-card">
                        {{-- Nút Prev Day PC --}}
                        <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn" title="Ngày hôm trước"><i
                                class="bi bi-chevron-left"></i></a>
                        <div class="text-center">
                            <div class="card-title title-amduowngbox"><img src="{{ asset('icons/icon_duong.svg') }}" alt="icon_duong"
                                    width="20px" height="20px"> Dương lịch</div>
                            <div class="date-number duong date_number_lich"> {{ $dd }}</div>
                            <div class="date-weekday">{{ $weekday }}</div>
                            <div class="date-special-event text-dark">Tháng {{ $mm }} năm
                                {{ $yy }}</div>
                            <div class="date-special-event">
                                @if (!empty($suKienDuongLich))
                                    @foreach ($suKienDuongLich as $suKien)
                                        <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}</div>
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
                            <div class="card-title title-amduowngbox"><img src="{{ asset('icons/icon_am.svg') }}" alt="icon_am"
                                    width="20px" height="20px"> Âm lịch</div>
                            <div class="date-number am date_number_lich date_number_lich_am">{{ $al[0] }}
                            </div>
                            <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                            <div class="date-special-event text-dark">Ngày {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                -
                                Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                            <div class="date-special-event">
                                @if (!empty($suKienAmLich))
                                    @foreach ($suKienAmLich as $suKien)
                                        <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}</div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        {{-- Nút Next Day PC (Đã sửa và di chuyển vào đây) --}}
                        <a href="#" class="nav-arrow nav-home-date nave-right next-day-btn" title="Ngày hôm sau"> <i
                                class="bi bi-chevron-right"></i></a>
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
        </div>


        <div class="mt-lg-5 mt-3 mb-5">

            <div class="tong-quan-date">


                <div class="card-body  p-4 position-relative">
                    <!-- Nút "Tổng quan" ở góc trên bên phải -->


                    <div class="row"> <!-- Sử dụng row thay vì d-flex flex-column flex-md-row -->
                        <!-- Cột bên trái: Navigation (Tabs) -->
                        <div class="left-sidebar col-12 col-md-auto  border-end-md pb-3 pb-md-0 mb-md-0">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <!-- Tab 1: Thông tin chung (Active mặc định) -->
                                <button
                                    class="nav-link text-start p-3 active d-flex justify-content-between align-items-center"
                                    id="v-pills-general-info-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-general-info" type="button" role="tab"
                                    aria-controls="v-pills-general-info" aria-selected="true">
                                    <span>Thông tin chung</span>
                                </button>

                                <!-- Tab 2: Luận giải ngày -->
                                <button class="nav-link text-start p-3 d-flex justify-content-between align-items-center"
                                    id="v-pills-daily-analysis-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-daily-analysis" type="button" role="tab"
                                    aria-controls="v-pills-daily-analysis" aria-selected="false">
                                    <span>Luận giải ngày</span>
                                    <i class="fas fa-chevron-down ms-2"></i>
                                </button>

                                <!-- Tab 3: Giờ hoàng đạo -->
                                <button class="nav-link text-start p-3" id="v-pills-auspicious-hours-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-auspicious-hours" type="button"
                                    role="tab" aria-controls="v-pills-auspicious-hours" aria-selected="false">Giờ
                                    hoàng
                                    đạo</button>

                                <!-- Tab 4: Điểm ngày đẹp -->
                                <button class="nav-link text-start p-3" id="v-pills-good-day-score-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-good-day-score" type="button"
                                    role="tab" aria-controls="v-pills-good-day-score" aria-selected="false">Điểm ngày
                                    đẹp</button>
                            </div>
                        </div>

                        <!-- Cột bên phải: Nội dung chính (Tab Content) -->
                        <div class="main-content content-lunar-detail col pt-3 pt-md-0 tab-content"
                            id="v-pills-tabContent">
                            <!-- Nội dung cho "Thông tin chung" (Tab 1 - active mặc định) -->
                            <div class="tab-pane fade show active" id="v-pills-general-info" role="tabpanel"
                                aria-labelledby="v-pills-general-info-tab" tabindex="0">
                               
                                <p class="mb-2 ">
                                    <span class="fw-bold text-dark">Tiết khí:</span> {!! $tietkhi['icon'] !!} <span
                                        class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                                </p>
                                <p class="mb-2 ">
                                    <span class="fw-bold text-dark">Ngũ hành nạp âm:</span>
                                    {{ $getThongTinNgay['nap_am']['napAm'] }}
                                </p>
                                <p class="mb-2 ">
                                    <span class="fw-bold text-dark">Sao, trực:</span> sao {{ $nhiThapBatTu['name'] }}
                                    ({{ $nhiThapBatTu['fullName'] }}), trực {{ $getThongTinTruc['title'] }}


                                </p>
                                <p class="mb-2 ">
                                    <span class="fw-bold text-dark">Tuổi xung:</span> {{ $getThongTinNgay['tuoi_xung'] }}
                                </p>
                                <p class="mb-4 ">
                                    <span class="fw-bold text-dark">Giờ hoàng đạo:</span>
                                    {{ $getThongTinNgay['gio_hoang_dao'] }}
                                </p>


                                <!-- Mức thuận lợi hôm nay box -->
                                <div class="row g-3 p-sm-3 p-2 rounded-3 border custom-light-yellow-bg box-custom_yeloow ms-lg-1">
                                    <div class="col-xl-6 col-sm-6 col-12">
                                        <span class=" fw-bold me-4 text-dark pb-2">Mức thuận lợi hôm nay:</span>
                                    </div>
                                    <div
                                        class="col-xl-6 col-sm-6 col-12 p-0 m-0 d-flex justify-content-center align-items-center">
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
                                                    class="dial-status pt-2 {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? '' }}">
                                                    {{ $getDaySummaryInfo['score']['rating'] }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <h6 class="fw-bold mb-2 pt-3">
                                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="Đặc điểm"
                                        class="img-fluid me-2">Đặc điểm ngày
                                </h6>
                                <p class="">
                                    @if (!empty($getDaySummaryInfo['intro_paragraph']))
                                        {{ $getDaySummaryInfo['intro_paragraph'] }}
                                    @else
                                        Đang cập nhật (Nội dung tóm tắt)
                                    @endif
                                </p>
                                <div class="pb-3">
                                    @php
                                        $goodFactors = [];

                                        if ($nhiThapBatTu['nature'] == 'Tốt') {
                                            $goodFactors[] =
                                                'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                        }

                                        if ($getThongTinTruc['description']['rating'] == 'Tốt') {
                                            $goodFactors[] =
                                                'Trực <strong>' .
                                                $getThongTinTruc['title'] .
                                                '</strong> (Thập nhị trực)';
                                        }

                                        if (!empty($getSaoTotXauInfo['sao_tot'])) {
                                            $saoTotList = implode(', ', array_keys($getSaoTotXauInfo['sao_tot']));
                                            $goodFactors[] = 'Sao tốt: ' . $saoTotList;
                                        }
                                    @endphp
                                    <div class="pb-2">
                                        <div class="star-wrapper d-flex">
                                            <span class="star-icon"><img
                                                    src="{{ asset('icons/fluent-color_star-16.svg') }}"
                                                    alt="Can chi start" class="img-fluid"></span>
                                            <div class="fs-6">Các yếu tố tốt:</div>
                                            <!-- Sử dụng ký tự unicode cho ngôi sao -->
                                        </div>
                                        <div class="text-content">
                                            <div>
                                                @if (!empty($goodFactors))
                                                    {!! implode('; ', $goodFactors) !!}.
                                                @else
                                                    Không có yếu tố tốt nào.
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $badFactors = [];

                                        if ($nhiThapBatTu['nature'] == 'Xấu') {
                                            $badFactors[] =
                                                'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                        }

                                        if ($getThongTinTruc['description']['rating'] == 'Xấu') {
                                            $badFactors[] =
                                                'Trực <strong>' .
                                                $getThongTinTruc['title'] .
                                                '</strong> (Thập nhị trực)';
                                        }

                                        if (!empty($getSaoTotXauInfo['sao_xau'])) {
                                            $saoXauList = implode(', ', array_keys($getSaoTotXauInfo['sao_xau']));
                                            $badFactors[] = 'Sao xấu: ' . $saoXauList;
                                        }
                                    @endphp
                                    <div class="star-wrapper d-flex">
                                        <span class="star-icon"><img
                                                src="{{ asset('icons/fluent-color_star-16-defu.svg') }}"
                                                alt="Can chi start" class="img-fluid"></span>
                                        <div class="fs-6">Các yếu tố xấu:</div>
                                        <!-- Sử dụng ký tự unicode cho ngôi sao -->
                                    </div>
                                    <div class="text-content">
                                        <div>
                                            @if (!empty($badFactors))
                                                {!! implode('; ', $badFactors) !!}.
                                            @else
                                                Không có yếu tố xấu nào.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="content-section mb-3">
                                    <h6 class="fw-bold mb-2">
                                        <img src="{{ asset('icons/dac-diem2.svg') }}" alt="Đặc điểm"
                                            class="img-fluid me-2">Việc nên làm
                                    </h6>
                                    <ul class=" ">


                                        @if (!empty($nhiThapBatTu['guidance']['good']))
                                            <li>{{ $nhiThapBatTu['guidance']['good'] }} (Nhị thập bát tú -
                                                {{ $nhiThapBatTu['name'] }}).</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['good']))
                                            <li>
                                                {{ $getThongTinTruc['description']['good'] }} (Thập nhị
                                                trực -
                                                {{ $getThongTinTruc['title'] }}).
                                            </li>
                                        @endif
                                        {{-- <li>{{ $nhiThapBatTu['guidance']['good'] }}</li> --}}
                                    </ul>
                                </div>
                                <!-- Không nên -->
                                <div class="content-section mb-3">
                                    <h6 class="fw-bold mb-2">
                                        <img src="{{ asset('icons/dac-diem3.svg') }}" alt="Đặc điểm"
                                            class="img-fluid me-2">Không nên làm
                                    </h6>
                                    <ul class=" ">
                                        @if (!empty($nhiThapBatTu['guidance']['bad']))
                                            <li>{{ $nhiThapBatTu['guidance']['bad'] }} (Nhị thập bát tú -
                                                sao
                                                {{ $nhiThapBatTu['name'] }}).</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['bad']))
                                            <li>
                                                {{ $getThongTinTruc['description']['bad'] }} (Thập nhị trực
                                                -
                                                {{ $getThongTinTruc['title'] }}).
                                            </li>
                                        @endif
                                        {{-- <li>{{ $nhiThapBatTu['guidance']['bad'] }}</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <!-- Nội dung cho "Luận giải ngày" (Tab 2 - Nội dung chi tiết ban đầu) -->
                            <div class="tab-pane fade" id="v-pills-daily-analysis" role="tabpanel"
                                aria-labelledby="v-pills-daily-analysis-tab" tabindex="0">
                                @php
                                    $badFactors = [];

                                    if ($nhiThapBatTu['nature'] == 'Xấu') {
                                        $badFactors[] =
                                            'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                    }

                                    if ($getThongTinTruc['description']['rating'] == 'Xấu') {
                                        $badFactors[] =
                                            'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập nhị trực)';
                                    }

                                    if (!empty($getSaoTotXauInfo['sao_xau'])) {
                                        $saoXauList = implode(', ', array_keys($getSaoTotXauInfo['sao_xau']));
                                        $badFactors[] = 'Các sao xấu khác: ' . $saoXauList;
                                    }
                                @endphp

                                <!-- Đặc điểm ngày -->
                                <div class="content-section mb-4">

                                    <div class="accordion" id="accordionRental">
                                        <div class="accordion-item mb-1">
                                            <h5 class="accordion-header" id="headingOne">
                                                <button
                                                    class="accordion-button  border-bottom font-weight-bold size-20 weight-500 collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="false"
                                                    aria-controls="collapseOne">
                                                    <img src="{{ asset('icons/dac-diem1.svg') }}"
                                                        alt="PHÂN TÍCH NGŨ HÀNH, SAO, TRỰC, LỤC DIỆU" class="img-fluid">
                                                    PHÂN TÍCH NGŨ HÀNH, SAO, TRỰC, LỤC DIỆU
                                                </button>
                                            </h5>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionRental">
                                                <div
                                                    class="accordion-body text-sm opacity-8 size-18 backgroud-whil pe-0 ps-0">
                                                    <div>
                                                        <h5 class="fw-bolder y-nguhanh">1. Can chi và ngũ hành</h5>
                                                        <div class="item-container">
                                                            <div class="star-wrapper">
                                                                <span class="star-icon"><img
                                                                        src="{{ asset('icons/fluent-color_star-16.svg') }}"
                                                                        alt="Can chi start" class="img-fluid"></span>
                                                                <!-- Sử dụng ký tự unicode cho ngôi sao -->
                                                            </div>
                                                            <div class="text-content">
                                                                <h6>Quan hệ Can chi ngày (nội khí):</h6>
                                                                <p>
                                                                    {!! $noiKhiNgay !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="item-container pt-2">
                                                            <div class="star-wrapper">
                                                                <span class="star-icon"><img
                                                                        src="{{ asset('icons/fluent-color_star-16.svg') }}"
                                                                        alt="Can chi start" class="img-fluid"></span>

                                                            </div>
                                                            <div class="text-content">
                                                                <h6>Vận khí ngày & tháng (khí tháng):</h6>
                                                                <ul>
                                                                    {!! $getVongKhiNgayThang['analysis'] !!}
                                                                </ul>
                                                                <p>{{ $getVongKhiNgayThang['conclusion'] }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="item-container pt-2">
                                                            <div class="star-wrapper">
                                                                <span class="star-icon"><img
                                                                        src="{{ asset('icons/fluent-color_star-16.svg') }}"
                                                                        alt="Can chi start" class="img-fluid"></span>

                                                            </div>
                                                            <div class="text-content">
                                                                <h6>Cục khí - hợp xung:</h6>
                                                                <ul>
                                                                    <li> {{ $getCucKhiHopXung['hop'] }}.</li>
                                                                    <li> {{ $getCucKhiHopXung['ky'] }}.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h5 class="fw-bolder y-nguhanh">2. Nhị Thập Bát Tú (28 Sao)
                                                        </h5>
                                                        <div class="me-sm-2">
                                                            <div>Ngày
                                                                {{ $al[0] }}-{{ $al[1] }}-{{ $al[2] }}
                                                                Âm lịch có xuất
                                                                hiện sao:
                                                                <b>{{ $nhiThapBatTu['name'] }}
                                                                    ({{ $nhiThapBatTu['fullName'] }})</b>
                                                                <div> <i class="bi bi-arrow-right-short"></i> Đây
                                                                    là sao
                                                                    <b>{{ $nhiThapBatTu['nature'] }} </b>-
                                                                    {{ $nhiThapBatTu['description'] }}
                                                                </div>
                                                            </div>

                                                            <div class="mt-2">
                                                                <div>
                                                                    @if ($nhiThapBatTu['guidance']['good'])
                                                                        <span class="fw-bolder">
                                                                            Việc nên làm:
                                                                        </span>
                                                                        {{ $nhiThapBatTu['guidance']['good'] }}.
                                                                    @endif
                                                                </div>

                                                                <div>
                                                                    @if ($nhiThapBatTu['guidance']['bad'])
                                                                        <span class="fw-bolder"> Việc không nên
                                                                            làm: </span>
                                                                        {{ $nhiThapBatTu['guidance']['bad'] }}.
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2">
                                                        <h5 class="fw-bolder y-nguhanh">3. Thập Nhị Trực (12 Trực)
                                                        </h5>
                                                        <div class="me-sm-2">
                                                            <div>
                                                                Trực ngày: Trực
                                                                <b>{{ $getThongTinTruc['title'] }}</b>
                                                                <div>
                                                                    <i class="bi bi-arrow-right-short"></i> Đây
                                                                    là trực
                                                                    <b>
                                                                        {{ $getThongTinTruc['description']['rating'] }}</b>
                                                                    -
                                                                    {{ $getThongTinTruc['description']['description'] }}
                                                                </div>

                                                            </div>
                                                            <div class="mt-2">
                                                                <div>
                                                                    @if ($getThongTinTruc['description']['good'])
                                                                        <span class="fw-bolder">
                                                                            Việc nên làm:
                                                                        </span>
                                                                        {{ $getThongTinTruc['description']['good'] }}
                                                                    @endif
                                                                </div>

                                                                <div>
                                                                    @if ($getThongTinTruc['description']['bad'])
                                                                        <span class="fw-bolder"> Việc không nên
                                                                            làm: </span>
                                                                        {{ $getThongTinTruc['description']['bad'] }}
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2">
                                                        <h5 class="fw-bolder y-nguhanh">4. Các sao tốt - xấu theo
                                                            Ngọc Hạp Thông Thư
                                                        </h5>
                                                        <div class="item-container">
                                                            <div class="star-wrapper">
                                                                <span class="star-icon"><img
                                                                        src="{{ asset('icons/fluent-color_star-16.svg') }}"
                                                                        alt="Can chi start" class="img-fluid"></span>
                                                                <!-- Sử dụng ký tự unicode cho ngôi sao -->
                                                            </div>
                                                            <div class="text-content">
                                                                <h6 style="color: rgba(240, 93, 7, 1)">Sao Tốt:
                                                                </h6>
                                                                <ul>
                                                                    @if (!empty($getSaoTotXauInfo['sao_tot']))
                                                                        @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                                                            <li><strong>{{ $tenSao }}:</strong>
                                                                                {{ $yNghia }}</li>
                                                                        @endforeach
                                                                    @else
                                                                        Không có sao tốt trong ngày này
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="item-container">
                                                            <div class="star-wrapper">
                                                                <span class="star-icon"><img
                                                                        src="{{ asset('icons/fluent-color_star-16-defu.svg') }}"
                                                                        alt="Can chi start" class="img-fluid"></span>
                                                                <!-- Sử dụng ký tự unicode cho ngôi sao -->
                                                            </div>
                                                            <div class="text-content">
                                                                <h6>Sao Xấu:</h6>
                                                                <ul>
                                                                    @if (!empty($getSaoTotXauInfo['sao_xau']))
                                                                        @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                                            <li><strong>{{ $tenSao }}:</strong>
                                                                                {{ $yNghia }}</li>
                                                                        @endforeach
                                                                    @else
                                                                        Không có sao xấu trong ngày này
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <p>{{ $getSaoTotXauInfo['ket_luan'] }}</p>
                                                    </div>
                                                    <div class="pt-2">
                                                        <h5 class="fw-bolder y-nguhanh">5. Ngày theo Khổng Minh Lục
                                                            Diệu</h5>
                                                        <div>
                                                            <div>
                                                                <div>Ngày này là ngày
                                                                    <b>{{ $khongMinhLucDieu['name'] }}</b>
                                                                    ({{ $khongMinhLucDieu['rating'] }})
                                                                </div>
                                                                <div>-> {{ $khongMinhLucDieu['description'] }}
                                                                </div>
                                                                <div class="pt-2 text-center fst-italic">
                                                                    "{!! $khongMinhLucDieu['poem'] !!}"
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-1">
                                            <h5 class="accordion-header" id="headingTwo">
                                                <button
                                                    class="accordion-button border-bottom font-weight-bold size-20 weight-500 collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    <img src="{{ asset('icons/dac-diem1.svg') }}"
                                                        alt="BÁCH KỴ VÀ CẢNH BÁO ĐẠI KỴ" class="img-fluid"> BÁCH
                                                    KỴ VÀ CẢNH BÁO ĐẠI KỴ
                                                </button>
                                            </h5>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionRental">
                                                <div
                                                    class="accordion-body text-sm  size-18 backgroud-whil ps-lg-4 pe-lg-4 p-0 pt-4">
                                                    <div>
                                                        <h6 class="fw-bolder">1. Giải thích ý nghĩa ngày theo Bành
                                                            Tổ Bách Kỵ</h6>
                                                        <div>
                                                            Ngày <b>{{ $canChi }}</b>
                                                            <ul>
                                                                <li><b>{{ $chiNgay[0] }}: </b>
                                                                    {{ $banhToCan }}.</li>
                                                                <li><b>{{ $chiNgay[1] }}: </b>
                                                                    {{ $banhToChi }}.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bolder">2. Cảnh báo ngày đại Kỵ</h6>
                                                        <div>
                                                            @if (!empty($checkBadDays))
                                                                Ngày này phạm phải ngày:
                                                                @foreach ($checkBadDays as $name => $description)
                                                                    <div>
                                                                        <strong>{{ $name }}:</strong>
                                                                        {{ $description }}
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div>Không phạm ngày đại kỵ nào!</div>
                                                            @endif


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-1">
                                            <h5 class="accordion-header" id="headingThree">
                                                <button
                                                    class="accordion-button border-bottom font-weight-bold size-20 weight-500 collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    <img src="{{ asset('icons/dac-diem1.svg') }}"
                                                        alt="NGÀY, GIỜ VÀ HƯỚNG XUẤT HÀNH" class="img-fluid">
                                                    NGÀY, GIỜ VÀ HƯỚNG XUẤT HÀNH
                                                </button>
                                            </h5>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionRental">
                                                <div
                                                    class="accordion-body text-sm  size-18 backgroud-whil ps-lg-4 pe-lg-4 p-0 pt-4">
                                                    <div>
                                                        <h6 class="fw-bolder">1. Ngày xuất hành</h6>
                                                        <div>
                                                            Đây là ngày
                                                            <b>{{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['title'] }}
                                                                ({{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['rating'] }})</b>:
                                                            {{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['description'] }}
                                                        </div>
                                                    </div>
                                                    <div class="pt-2">
                                                        <h6 class="fw-bolder">2. Hướng xuất hành</h6>
                                                        <div>
                                                            <div>
                                                                <div class="fw-semibold">Hướng xuất hành tốt:</div>
                                                                <ul>
                                                                    <li>Đón Hỷ thần:
                                                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hyThan']['direction'] }}
                                                                    </li>
                                                                    <li>Đón Tài thần:
                                                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['taiThan']['direction'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            @if ($getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] != 'Hạc Thần bận việc trên trời')
                                                                <div>
                                                                    <div class="fw-semibold">Hướng xuất hành xấu:
                                                                    </div>
                                                                    <ul>
                                                                        <li>Gặp hạc thần:
                                                                            {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] }}
                                                                        </li>
                                                                    </ul>

                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="pt-2">
                                                        <h6 class="fw-bolder">3. Giờ xuất hành theo Lý Thuần Phong
                                                        </h6>
                                                        <div>
                                                            <div class="fw-bolder">Giờ tốt:</div>
                                                            <ul>
                                                                @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['good'] as $name => $items)
                                                                    @foreach ($items as $item)
                                                                        <li> {{ $item['name'] }}
                                                                            ({{ $item['rating'] }})
                                                                            :{{ $item['timeRange'][0] }}
                                                                            ({{ $item['chi'][0] }}) và
                                                                            {{ $item['timeRange'][1] }}
                                                                            ({{ $item['chi'][1] }}) ->
                                                                            {{ $item['description'] }}
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bolder">Giờ xấu:</div>
                                                            <ul>
                                                                @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['bad'] as $name => $items)
                                                                    @foreach ($items as $item)
                                                                        <li> {{ $item['name'] }}
                                                                            ({{ $item['rating'] }})
                                                                            : {{ $item['timeRange'][0] }}
                                                                            ({{ $item['chi'][0] }}) và
                                                                            {{ $item['timeRange'][1] }}
                                                                            ({{ $item['chi'][1] }}) ->
                                                                            {{ $item['description'] }}
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div>
                                                            {{ $getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong_description'] }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <!-- Việc nên làm -->

                            </div>

                            <!-- Nội dung placeholder cho "Giờ hoàng đạo" (Tab 3) -->
                            <div class="tab-pane fade" id="v-pills-auspicious-hours" role="tabpanel"
                                aria-labelledby="v-pills-auspicious-hours-tab" tabindex="0">
                                <div class="row g-3">
                                    @php
                                        function renderStars($rating)
                                        {
                                            $stars = '';
                                            for ($i = 1; $i <= 5; $i++) {
                                                $stars .=
                                                    $i <= $rating
                                                        ? '<i class="bi bi-star-fill text-warning" style="margin-right: 5px;"></i>'
                                                        : '<i class="bi bi-star text-warning" style="margin-right: 5px;"></i>';
                                            }
                                            return $stars;
                                        }
                                    @endphp
                                    @foreach ($getDetailedGioHoangDao as $index => $itemgio)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div
                                                class="position-relative boxgetGioHoangDao colorgiogoangdao-{{ $index + 1 }}">
                                                <div>
                                                    {{ $itemgio['standardRangeMini'] }}
                                                </div>

                                                <div style="color: #0F172A; font-weight: 600; font-size: 20px; max-width: 85%">
                                                    {!! $itemgio['canChiMenh'] !!}
                                                </div>
                                                <div>
                                                    {!! renderStars($itemgio['rating']) !!}
                                                </div>
                                                <div style="position: absolute;right: 10px;bottom: 0;">
                                                    <img src="{!! $itemgio['zodiacIcon'] !!}" alt="icon zodiacicon"
                                                        class="img-fluid" style="width: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <!-- Nội dung placeholder cho "Điểm ngày đẹp" (Tab 4) -->
                            <div class="tab-pane fade" id="v-pills-good-day-score" role="tabpanel"
                                aria-labelledby="v-pills-good-day-score-tab" tabindex="0">


                                <div class="chart-container">

                                    <div class="chart-canvas-wrapper">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            const labels = @json($labels);
            const dataValues = @json($dataValues);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Điểm ngày',
                        data: dataValues,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return;

                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0,
                                chartArea.top);
                            gradient.addColorStop(0, getComputedStyle(document.documentElement)
                                .getPropertyValue('--bar-bottom-color') || '#4e79a7');
                            gradient.addColorStop(0.6, getComputedStyle(document
                                    .documentElement).getPropertyValue('--bar-mid-color') ||
                                '#59a14f');
                            gradient.addColorStop(1, getComputedStyle(document.documentElement)
                                .getPropertyValue('--bar-top-color') || '#9c755f');
                            return gradient;
                        },
                        borderRadius: {
                            topLeft: 8,
                            topRight: 8
                        },
                        borderSkipped: false,
                        hoverBackgroundColor: getComputedStyle(document.documentElement)
                            .getPropertyValue('--bar-top-color') || '#9c755f',
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '%';
                                }
                            },
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 8,
                            displayColors: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--text-color-light') || '#333',
                                font: {
                                    size: 13,
                                    weight: '500'
                                },
                                padding: 10
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 20,
                                callback: function(value) {
                                    return value + '%';
                                },
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--text-color-light') || '#333',
                                font: {
                                    size: 13,
                                    weight: '500'
                                },
                                padding: 10,

                            },
                            grid: {
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--grid-line-color') || '#ddd',
                                borderDash: [5, 5],
                                drawBorder: false,
                                drawOnChartArea: true,
                                drawTicks: false
                            }
                        }
                    }
                },

            });


            // Lấy ngày tháng năm hiện tại từ Blade
            const currentYear = {{ $yy }};
            const currentMonth = {{ $mm }}; // Tháng từ PHP (1-12)
            const currentDay = {{ $dd }};

            // Tạo đối tượng Date trong JavaScript
            // Lưu ý: Tháng trong JS là 0-11, nên phải trừ đi 1
            const currentDate = new Date(currentYear, currentMonth - 1, currentDay);

            // Lấy TẤT CẢ các element nút bấm prev
            const prevBtns = document.querySelectorAll('.prev-day-btn');
            // Lấy TẤT CẢ các element nút bấm next
            const nextBtns = document.querySelectorAll('.next-day-btn');

            // --- Xử lý các nút "Ngày trước" ---
            if (prevBtns.length > 0) {
                const prevDate = new Date(currentDate);
                prevDate.setDate(currentDate.getDate() - 1);

                const prevYear = prevDate.getFullYear();
                const prevMonth = prevDate.getMonth() + 1;
                const prevDay = prevDate.getDate();

                const newPrevUrl = `/chi-tiet/${prevYear}/thang/${prevMonth}/ngay/${prevDay}`;

                // Lặp qua TẤT CẢ các nút "prev" và gán URL mới
                prevBtns.forEach(btn => {
                    btn.href = newPrevUrl;
                });
            }

            // --- Xử lý các nút "Ngày sau" ---
            if (nextBtns.length > 0) {
                const nextDate = new Date(currentDate);
                nextDate.setDate(currentDate.getDate() + 1);

                const nextYear = nextDate.getFullYear();
                const nextMonth = nextDate.getMonth() + 1;
                const nextDay = nextDate.getDate();

                const newNextUrl = `/chi-tiet/${nextYear}/thang/${nextMonth}/ngay/${nextDay}`;

                // Lặp qua TẤT CẢ các nút "next" và gán URL mới
                nextBtns.forEach(btn => {
                    btn.href = newNextUrl;
                });
            }

        });
    </script>
@endpush
