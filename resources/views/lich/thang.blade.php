@extends('welcome')
@section('content')
    @push('styles')
        <style>
            .not-hover:hover {
cursor: default;
            }
        </style>
    @endpush
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="{{ route('lich.nam', ['nam' => $yy]) }}">Lịch
                năm {{ $yy }}</a> <i class="bi bi-chevron-right"></i> <span>
                Tháng {{ $mm }}</span></h6>
        @if (isset($is_leap_month_view) && $is_leap_month_view)
            <h1 class="content-title-home-lich">Lịch Âm Tháng {{ $lunar_month_num }} Nhuận Năm {{ $lunar_year }}</h1>
        @else
            <h1 class="content-title-home-lich">Lịch Âm Tháng {{ $mm }} năm {{ $yy }}</h1>
        @endif

    </div>
    <div class="row mt-2 g-3">

        <div class="col-12 col-lg-9">
            <div class="box--bg-thang">
                {!! $desrtipton_thang !!}
            </div>
            {{-- Hiển thị tất cả các tháng âm có trong tháng dương này --}}
            @if (!empty($lunar_calendars))
                @foreach ($lunar_calendars as $lunar_calendar)
                    <div class="box--bg-thang mt-3">
                        <div class="">
                            <div class="title-tong-quan-h3-log">
                                Âm lịch tháng
                                {{ $lunar_calendar['month'] }}{{ $lunar_calendar['is_leap'] == 1 ? ' (nhuận)' : '' }}
                            </div>
                            <hr class="mb-1">
                            <div>
                             @php
                                 $can_chi_nam_news = \App\Helpers\LunarHelper::canchiNam($lunar_year);
                             @endphp
                                <div class="calendar-wrapper calendar-wrapper-none">
                                       <div class="calendar-header mt-0">
                                    <div class="mb-0 title-tong-quan-h4-log">Tháng {{ $lunar_calendar['month'] }} Năm
                                        {{ $can_chi_nam_news }}</div>
                                </div>
                                    <table class="calendar-table">
                                        <thead>
                                            <tr>
                                                <th><span class="title-lich-pc">Thứ Hai</span> <span
                                                        class="title-lich-mobie">Th
                                                        2</span></th>
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
                                                        5</span></th>
                                                <th><span class="title-lich-pc">Thứ Sáu</span> <span
                                                        class="title-lich-mobie">Th
                                                        6</span></th>
                                                <th><span class="title-lich-pc">Thứ Bảy</span> <span
                                                        class="title-lich-mobie">Th
                                                        7</span></th>
                                                <th><span class="title-lich-pc">Chủ Nhật</span> <span
                                                        class="title-lich-mobie">CN</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lunar_calendar['weeks'] as $week)
                                                <tr>
                                                    @foreach ($week as $day)
                                                        @if ($day)
                                                            @php
                                                                $isCurrent =
                                                                    $day['solar_year'] == date('Y') &&
                                                                    $day['solar_month'] == date('n') &&
                                                                    $day['solar_day'] == date('j');
                                                            @endphp
                                                            <td class="{{ $isCurrent ? 'current' : '' }}">
                                                                <a
                                                                    href="{{ route('detai_home', ['nam' => $day['solar_year'], 'thang' => $day['solar_month'], 'ngay' => $day['solar_day']]) }}">
                                                                    <div class="box-contnet-date">
                                                                        <div class="duong">{{ $day['day'] }}</div>
                                                                    </div>
                                                                    <div class="am am_table">
                                                                        {{ $day['solar_day'] }}/{{ $day['solar_month'] }}
                                                                    </div>
                                                                    <div class="can_chi_text">{{ $day['canchi'] }}</div>
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td class="skip"></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="box--bg-thang mt-3">
                    <div class="alert alert-info">
                        Không có dữ liệu lịch âm cho tháng này
                    </div>
                </div>
            @endif


            {{-- Kiểm tra xem có phải đang xem tháng nhuận không --}}
            @if (isset($is_leap_month_view) && $is_leap_month_view)
                {{-- Nếu là tháng nhuận, hiển thị dương lịch sau --}}
            @endif

            <div class="box--bg-thang mt-3">
                <div class="">
                    <div class="title-tong-quan-h3-log">

                        Dương lịch tháng {{ $mm }}

                    </div>
                    <hr class="mb-1">
                    <div class="calendar-wrapper calendar-wrapper-none">
                        <div class="calendar-header mt-0">

                            <a href="{{ route('lich.thang', ['nam' => $mm == 1 ? $yy - 1 : $yy, 'thang' => $mm == 1 ? 12 : $mm - 1, 'solar' => 1]) }}"
                                class="month-nav" title="Tháng trước">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <div class="mb-0 title-tong-quan-h4-log">Tháng {{ $mm }} năm {{ $yy }}
                            </div>

                            <a href="{{ route('lich.thang', ['nam' => $mm == 12 ? $yy + 1 : $yy, 'thang' => $mm == 12 ? 1 : $mm + 1, 'solar' => 1]) }}"
                                class="month-nav" title="Tháng sau">
                                <i class="bi bi-chevron-right"></i>
                            </a>



                        </div>
                        <table class="calendar-table">
                            <thead>
                                <tr>
                                    <th><span class="title-lich-pc">Thứ hai</span> <span class="title-lich-mobie">Th
                                            2</span>
                                    </th>
                                    <th><span class="title-lich-pc">Thứ ba</span> <span class="title-lich-mobie">Th
                                            3</span>
                                    </th>
                                    <th><span class="title-lich-pc">Thứ tư</span> <span class="title-lich-mobie">Th
                                            4</span>
                                    </th>
                                    <th><span class="title-lich-pc">Thứ năm</span> <span class="title-lich-mobie">Th
                                            5</span>
                                    </th>
                                    <th><span class="title-lich-pc">Thứ sáu</span> <span class="title-lich-mobie">Th
                                            6</span>
                                    </th>
                                    <th><span class="title-lich-pc">Thứ bảy</span> <span class="title-lich-mobie">Th
                                            7</span>
                                    </th>
                                    <th><span class="title-lich-pc">Chủ nhật</span> <span class="title-lich-mobie">CN</span>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                {!! $table_html !!}
                            </tbody>
                        </table>

                    </div>
                    <div class="calendar-legend pt-3 pb-2">
                        <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                        <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
                    </div>

                </div>
            </div>
            <section class="">
                {{-- Box Hoàng Đạo/Hắc Đạo Dương lịch --}}
                <div class="lich-box">


                    <div class="box--bg-thang mt-3 hoangdao-duong-box">
                        <div class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="title-tong-quan-h3-log">
                                    Ngày Hoàng Đạo Dương lịch tháng {{ $mm }}
                                </div>
                                <div class="position-relative ms-2">
                                    <select id="hoangDaoSelect" class="form-select pe-4"
                                        onchange="toggleBox(this, 'hoangdao')"
                                        style="width: auto; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 35px;">
                                        <option value="duong" selected>Dương lịch</option>
                                        <option value="am">Âm lịch</option>
                                    </select>
                                    <i class="bi bi-chevron-down position-absolute"
                                        style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                </div>
                            </div>
                            <hr class="mb-0">

                            <div class="row g-lg-3 g-1 row-btn-date">
                                @forelse ($data_totxau['tot'] as $data_tot)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                        <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                        <a href="{{ route('detai_home', ['nam' => $data_tot['yy'], 'thang' => $data_tot['mm'], 'ngay' => $data_tot['dd']]) }}"
                                            class="btn custom-pill-btn-date">
                                            <span> Ngày {{ $data_tot['dd'] }} Tháng {{ $data_tot['mm'] }} Năm
                                                {{ $data_tot['yy'] }}</span>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-secondary text-center">
                                            Không có ngày tốt trong tháng
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @if (!empty($lunar_calendars))
                        @foreach ($lunar_calendars as $lunar_calendar)
                            @php
                                $lunar_month_num = $lunar_calendar['month'];
                                $lunar_is_leap = $lunar_calendar['is_leap'];
                                $lunar_year = $lunar_calendar['year'] ?? date('Y');

                                // Lấy can chi năm âm lịch
                                $can_chi_nam = \App\Helpers\LunarHelper::canchiNam($lunar_year);

                                // Tính ngày Hoàng Đạo/Hắc Đạo cho tháng âm này
                                $hoangdao_am_list = [];
                                $hacdao_am_list = [];

                                foreach ($lunar_calendar['weeks'] as $week) {
                                    foreach ($week as $day) {
                                        if ($day) {
                                            // Kiểm tra Hoàng Đạo/Hắc Đạo dựa trên can chi và tháng âm
                                            $canchi = $day['canchi'] ?? '';
                                            $lunar_month = $day['month'] ?? $lunar_month_num;

                                            // Sử dụng hàm checkTotXau để xác định chính xác Hoàng Đạo/Hắc Đạo
                                            $tot_xau = \App\Helpers\LunarHelper::checkTotXau($canchi, $lunar_month);

                                            // Thêm can chi năm vào thông tin ngày
                                            $day['can_chi_nam'] = $can_chi_nam;

                                            if ($tot_xau == 'tot') {
                                                $hoangdao_am_list[] = $day;
                                            } elseif ($tot_xau == 'xau') {
                                                $hacdao_am_list[] = $day;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <div class="box--bg-thang mt-3 hoangdao-am-box">
                                <div class="">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title-tong-quan-h3-log">
                                            Ngày Hoàng Đạo Âm lịch tháng
                                            {{ $lunar_month_num }}{{ $lunar_is_leap ? ' (nhuận)' : '' }}
                                        </div>
                                        <div class="position-relative ms-2">
                                            <select id="hoangDaoAmSelect" class="form-select pe-4"
                                                onchange="toggleBox(this, 'hoangdao', {{ $loop->index }})"
                                                style="width: auto; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 35px;">
                                                <option value="duong" selected>Dương lịch</option>
                                                <option value="am">Âm lịch</option>
                                            </select>
                                            <i class="bi bi-chevron-down position-absolute"
                                                style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                        </div>
                                    </div>
                                    <hr class="mb-0">
                                    <div class="row g-lg-3 g-1 row-btn-date">
                                        @forelse ($hoangdao_am_list as $day)
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                <a href="{{ route('detai_home', ['nam' => $day['solar_year'], 'thang' => $day['solar_month'], 'ngay' => $day['solar_day']]) }}"
                                                    class="btn custom-pill-btn-date">
                                                    <span>Ngày {{ $day['day'] }} tháng {{ $lunar_month_num }}
                                                        {{ $lunar_is_leap ? '(nhuận)' : '' }} năm
                                                        {{ $day['can_chi_nam'] }}</span>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-secondary text-center">
                                                    Không có ngày Hoàng Đạo trong tháng âm này
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="box--bg-thang mt-3 hacdao-duong-box">
                        <div class="">

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="title-tong-quan-h3-log">
                                    Ngày Hắc Đạo Dương lịch tháng {{ $mm }}
                                </div>
                                <div class="position-relative ms-2">
                                    <select id="hacDaoSelect" class="form-select pe-4"
                                        onchange="toggleBox(this, 'hacdao')"
                                        style="width: auto; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 35px;">
                                        <option value="duong" selected>Dương lịch</option>
                                        <option value="am">Âm lịch</option>
                                    </select>
                                    <i class="bi bi-chevron-down position-absolute"
                                        style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                </div>
                            </div>
                            <hr class="mb-0">

                            <div class="row g-lg-3 g-1 row-btn-date">
                                @forelse ($data_totxau['xau'] as $data_xau)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                        <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                        <a href="{{ route('detai_home', ['nam' => $data_xau['yy'], 'thang' => $data_xau['mm'], 'ngay' => $data_xau['dd']]) }}"
                                            class="btn custom-pill-btn-date">
                                            <span> Ngày {{ $data_xau['dd'] }} Tháng {{ $data_xau['mm'] }} Năm
                                                {{ $data_xau['yy'] }}</span>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-secondary text-center">
                                            Không có ngày xấu trong tháng
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>


                    @if (!empty($lunar_calendars))
                        @foreach ($lunar_calendars as $lunar_calendar)
                            @php
                                $lunar_month_num = $lunar_calendar['month'];
                                $lunar_is_leap = $lunar_calendar['is_leap'];
                                $lunar_year = $lunar_calendar['year'] ?? date('Y');

                                // Lấy can chi năm âm lịch
                                $can_chi_nam = \App\Helpers\LunarHelper::canchiNam($lunar_year);

                                // Tính ngày Hoàng Đạo/Hắc Đạo cho tháng âm này
                                $hoangdao_am_list = [];
                                $hacdao_am_list = [];

                                foreach ($lunar_calendar['weeks'] as $week) {
                                    foreach ($week as $day) {
                                        if ($day) {
                                            // Kiểm tra Hoàng Đạo/Hắc Đạo dựa trên can chi và tháng âm
                                            $canchi = $day['canchi'] ?? '';
                                            $lunar_month = $day['month'] ?? $lunar_month_num;

                                            // Sử dụng hàm checkTotXau để xác định chính xác Hoàng Đạo/Hắc Đạo
                                            $tot_xau = \App\Helpers\LunarHelper::checkTotXau($canchi, $lunar_month);

                                            // Thêm can chi năm vào thông tin ngày
                                            $day['can_chi_nam'] = $can_chi_nam;

                                            if ($tot_xau == 'tot') {
                                                $hoangdao_am_list[] = $day;
                                            } elseif ($tot_xau == 'xau') {
                                                $hacdao_am_list[] = $day;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <div class="box--bg-thang mt-3 hacdao-am-box">
                                <div class="">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title-tong-quan-h3-log">
                                            Ngày Hắc Đạo Âm lịch tháng
                                            {{ $lunar_month_num }}{{ $lunar_is_leap ? ' (nhuận)' : '' }}
                                        </div>
                                        <div class="position-relative ms-2">
                                            <select id="hacDaoAmSelect" class="form-select pe-4"
                                                onchange="toggleBox(this, 'hacdao', {{ $loop->index }})"
                                                style="width: auto; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 35px;">
                                                <option value="duong" selected>Dương lịch</option>
                                                <option value="am">Âm lịch</option>
                                            </select>
                                            <i class="bi bi-chevron-down position-absolute"
                                                style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                        </div>
                                    </div>
                                    <hr class="mb-0">
                                    <div class="row g-lg-3 g-1 row-btn-date">
                                        @forelse ($hacdao_am_list as $day)
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                <a href="{{ route('detai_home', ['nam' => $day['solar_year'], 'thang' => $day['solar_month'], 'ngay' => $day['solar_day']]) }}"
                                                    class="btn custom-pill-btn-date">
                                                    <span>Ngày {{ $day['day'] }} tháng {{ $lunar_month_num }}
                                                        {{ $lunar_is_leap ? '(nhuận) ' : '' }} năm
                                                        {{ $day['can_chi_nam'] }}</span>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-secondary text-center">
                                                    Không có ngày Hắc Đạo trong tháng âm này
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>



                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày lễ dương lịch tháng {{ $mm }}
                        </div>
                        <hr>
                        <div class="row g-lg-3 g-2">
                            @forelse ($le_lichs as $le_lich)
                                <div class="col-12 mt-1"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                    <div class="btn not-hover w-100 text-start">

                                        <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện"
                                            class="img-fluid me-2" width="28" height="29">
                                        <b>{{ $le_lich['dd'] }}/{{ $le_lich['mm'] }}</b>: {{ $le_lich['name'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 mt-1">
                                    <div class="alert alert-secondary text-center">
                                        Không có ngày lễ dương nào
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày lễ âm lịch tháng {{ $primary_lunar_month }}
                        </div>
                        <hr>

                        <div class="row g-lg-3 g-2">
                            @forelse ($le_lichs_am as $le_lich)
                                <div class="col-12 mt-1">
                                    <div class="btn  not-hover w-100 text-start">
                                        <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện" width="28"
                                            height="29" class="img-fluid me-2">
                                        <b>{{ $le_lich['dd'] }}/{{ $le_lich['mm'] }}</b>: {{ $le_lich['name'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 mt-1">
                                    <div class="alert alert-secondary text-center">
                                        Không có lễ lịch âm nào
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Sự kiện lịch sử tháng {{ $mm }}
                        </div>
                        <hr>

                        <div class="row g-lg-3 g-2">
                            @forelse ($su_kiens as $su_kien)
                                <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                    <div class="btn  not-hover w-100 text-start">

                                        <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện" width="28"
                                            height="29" class="img-fluid me-2">{{ $su_kien }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-secondary text-center">
                                        Không có sự kiện lịch xử
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="box--bg-thang mt-3 mb-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày xuất hành âm lịch
                            </đ>
                            <hr>

                            <div class="row g-lg-2 g-2 ">
                                @foreach ($data_al as $ngay)
                                    <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                        <div class="btn  not-hover w-100 text-start">

                                            <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện" width="28"
                                                height="29"
                                                class="img-fluid me-2">{{ $ngay['day'] }}/{{ $ngay['month'] }}:

                                            @if (!empty($ngay['xuat_hanh_html']))
                                                {!! $ngay['xuat_hanh_html'] !!}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

            </section>

        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="d-flex flex-column gap-4">
                <!-- ** KHá»I Sá»° KIá»†N Sáº®P Tá»šI ** -->
                <div class="events-card">
                    <div class="card-title-right title-tong-quan-h5-log">Lịch âm các tháng năm {{ $yy }}</div>
                    <ul class="list-group list-group-flush events-list">
                        @if (isset($lunar_months_data) && !empty($lunar_months_data))
                            @foreach ($lunar_months_data as $lunar_month_info)
                                <li class="list-group-item event-item pb-0">
                                    @if ($lunar_month_info['is_leap'])
                                        <a
                                            href="{{ route('lich.thang.nhuan', ['nam' => $lunar_month_info['lunar_year'], 'thang' => $lunar_month_info['lunar_month']]) }}">
                                        @else
                                            <a
                                                href="{{ route('lich.thang', ['nam' => $lunar_month_info['lunar_year'], 'thang' => $lunar_month_info['lunar_month']]) }}">
                                    @endif
                                    <div class="event-details">
                                        @php
                                            // Check if current page is viewing this lunar month
                                            $is_active = false;

                                            // Check if we're in lunar view mode
// Now default route shows lunar, so check if NOT explicitly solar
$is_viewing_solar =
    request()->get('solar') == '1' || request()->get('duong') == '1';
$is_viewing_lunar =
    !$is_viewing_solar ||
    isset($is_lunar_view) ||
    request()->routeIs('lich.thang.am') ||
    request()->routeIs('lich.thang.nhuan');

if ($is_viewing_lunar) {
    // We're viewing a lunar month
                                                $current_lunar_month = request()->route('thang'); // Get month from route

                                                if (
                                                    $lunar_month_info['lunar_month'] == $current_lunar_month &&
                                                    $lunar_month_info['lunar_year'] == $yy &&
                                                    $lunar_month_info['is_leap'] ==
                                                        (isset($is_leap_month_view) ? $is_leap_month_view : false)
                                                ) {
                                                    $is_active = true;
                                                }
                                            } else {
                                                // Viewing solar month - check if this lunar month corresponds to current solar month
                                                if (
                                                    $mm == $lunar_month_info['solar_month'] &&
                                                    $yy == $lunar_month_info['solar_year']
                                                ) {
                                                    $is_active = true;
                                                }
                                            }
                                        @endphp
                                        <div class="event-name {{ $is_active ? 'active-date' : '' }}"
                                            style="font-weight: unset">
                                            <img src="{{ asset('/icons/sukienn1.svg') }}" width="28" height="29"
                                                alt="Sự kiện" class="img-fluid me-2">

                                            Lịch âm {{ $lunar_month_info['display_name'] }} năm {{ $yy }}

                                        </div>

                                    </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @for ($i = 1; $i <= 12; $i++)
                                <li class="list-group-item event-item pb-0">
                                    <a href="{{ route('lich.thang', ['nam' => $yy, 'thang' => $i]) }}">

                                        <div class="event-details">
                                            <div class="event-name {{ $mm == $i ? 'active-date' : '' }}"
                                                style="font-weight: unset"> <img src="{{ asset('/icons/sukienn1.svg') }}"
                                                    width="28" height="29" alt="Sự kiện" class="img-fluid me-2">
                                                Lịch âm tháng {{ $i }}
                                                năm {{ $yy }}
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            @endfor
                        @endif
                    </ul>
                </div>


                <div class="events-card">
                    <div class="card-title-right title-tong-quan-h5-log">Lịch Vạn Niên Các Năm</div>
                    <ul class="list-group list-group-flush events-list">
                        @php($currentYearHeader = date('Y'))
                        @php($startYearHeader = $currentYearHeader - 1)
                        @php($endYearHeader = $currentYearHeader + 10)
                        @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                            <li class="list-group-item event-item pb-0">
                                <a href="{{ route('lich.nam', ['nam' => $year]) }}">

                                    <div class="event-details">
                                        <div class="event-name" style="font-weight: unset"> <img
                                                src="{{ asset('/icons/sukienn1.svg') }}" width="28" height="29"
                                                alt="Sự kiện" class="img-fluid me-2">
                                            Lịch vạn niên {{ $year }}
                                        </div>

                                    </div>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        /**
         * Hàm xử lý hiển thị box âm dương lịch
         * @param {HTMLElement} element - Select element được thay đổi
         * @param {string} type - Loại box: 'hoangdao' hoặc 'hacdao'
         * @param {number} index - Index của box âm lịch (optional)
         */
        function toggleBox(element, type, index) {
            const value = element.value; // 'duong' hoặc 'am'

            if (type === 'hoangdao') {
                // Xử lý Hoàng Đạo
                const duongBox = document.querySelector('.hoangdao-duong-box');
                const amBoxes = document.querySelectorAll('.hoangdao-am-box');

                if (value === 'duong') {
                    // Hiện box dương lịch, ẩn tất cả box âm lịch
                    if (duongBox) duongBox.style.display = 'block';
                    amBoxes.forEach(box => box.style.display = 'none');

                    // Đồng bộ tất cả select box Hoàng Đạo về 'duong'
                    const allHoangDaoSelects = document.querySelectorAll('[id^="hoangDao"]');
                    allHoangDaoSelects.forEach(select => {
                        select.value = 'duong';
                    });
                } else {
                    // Ẩn box dương lịch, hiện tất cả box âm lịch
                    if (duongBox) duongBox.style.display = 'none';
                    amBoxes.forEach(box => box.style.display = 'block');

                    // Đồng bộ tất cả select box Hoàng Đạo về 'am'
                    const allHoangDaoSelects = document.querySelectorAll('[id^="hoangDao"]');
                    allHoangDaoSelects.forEach(select => {
                        select.value = 'am';
                    });
                }
            } else if (type === 'hacdao') {
                // Xử lý Hắc Đạo
                const duongBox = document.querySelector('.hacdao-duong-box');
                const amBoxes = document.querySelectorAll('.hacdao-am-box');

                if (value === 'duong') {
                    // Hiện box dương lịch, ẩn tất cả box âm lịch
                    if (duongBox) duongBox.style.display = 'block';
                    amBoxes.forEach(box => box.style.display = 'none');

                    // Đồng bộ tất cả select box Hắc Đạo về 'duong'
                    const allHacDaoSelects = document.querySelectorAll('[id^="hacDao"]');
                    allHacDaoSelects.forEach(select => {
                        select.value = 'duong';
                    });
                } else {
                    // Ẩn box dương lịch, hiện tất cả box âm lịch
                    if (duongBox) duongBox.style.display = 'none';
                    amBoxes.forEach(box => box.style.display = 'block');

                    // Đồng bộ tất cả select box Hắc Đạo về 'am'
                    const allHacDaoSelects = document.querySelectorAll('[id^="hacDao"]');
                    allHacDaoSelects.forEach(select => {
                        select.value = 'am';
                    });
                }
            }
        }

        // Khởi tạo trạng thái ban đầu khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            // Mặc định hiện Dương lịch, ẩn Âm lịch cho cả Hoàng Đạo và Hắc Đạo
            const hoangdaoAmBoxes = document.querySelectorAll('.hoangdao-am-box');
            const hacdaoAmBoxes = document.querySelectorAll('.hacdao-am-box');

            // Ẩn tất cả box âm lịch ban đầu
            hoangdaoAmBoxes.forEach(box => box.style.display = 'none');
            hacdaoAmBoxes.forEach(box => box.style.display = 'none');

            // Hiện box dương lịch
            const hoangdaoDuongBox = document.querySelector('.hoangdao-duong-box');
            const hacdaoDuongBox = document.querySelector('.hacdao-duong-box');

            if (hoangdaoDuongBox) hoangdaoDuongBox.style.display = 'block';
            if (hacdaoDuongBox) hacdaoDuongBox.style.display = 'block';
        });
    </script>
@endpush
