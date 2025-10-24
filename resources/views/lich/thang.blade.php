@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="{{ route('lich.nam', ['nam' => $yy]) }}">Lịch
                năm {{ $yy }}</a> <i class="bi bi-chevron-right"></i> <span>
                Tháng {{ $mm }}</span></h6>
        <h1 class="content-title-home-lich">Lịch Âm Tháng {{ $mm }} năm {{ date('Y') }}</h1>

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
                                {{ $lunar_calendar['month'] }}{{ $lunar_calendar['is_leap'] == 1 ? ' nhuận' : '' }}
                            </div>
                            <hr>
                            <div>
                                <div class="calendar-header mt-0">
                                    <div class="mb-0 title-tong-quan-h4-log">Tháng {{ $lunar_calendar['month'] }} Năm
                                        {{ $lunar_calendar['can_chi'] }}</div>
                                </div>
                                <div class="calendar-wrapper calendar-wrapper-none">
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


            <div class="box--bg-thang mt-3">
                <div class="">
                    <div class="title-tong-quan-h3-log">
                        Dương lịch tháng {{ $mm }}
                    </div>
                    <hr>
                    <div class="calendar-wrapper calendar-wrapper-none">
                        <div class="calendar-header mt-0">

                            <a href="{{ route('lich.thang', ['nam' => $mm == 1 ? $yy - 1 : $yy, 'thang' => $mm == 1 ? 12 : $mm - 1]) }}"
                                class="month-nav" title="Tháng trước">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <div class="mb-0 title-tong-quan-h4-log">Tháng {{ $mm }} năm {{ $yy }}
                            </div>

                            <a href="{{ route('lich.thang', ['nam' => $mm == 12 ? $yy + 1 : $yy, 'thang' => $mm == 12 ? 1 : $mm + 1]) }}"
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
                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày Hoàng Đạo tháng {{ $mm }}
                        </div>
                        <hr>

                        <div class="row g-lg-3 g-2 row-btn-date">
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
                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày Hắc Đạo tháng {{ $mm }}
                        </div>
                        <hr>

                        <div class="row g-lg-3 g-2 row-btn-date">
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
                <div class="box--bg-thang mt-3">
                    <div class="">
                        <div class="title-tong-quan-h3-log">
                            Ngày lễ dương lịch tháng {{ $mm }}
                        </div>
                        <hr>
                        <div class="row g-lg-3 g-2">
                            @forelse ($le_lichs as $le_lich)
                                <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                    <div class="btn custom-pill-btn-date w-100 text-start">

                                        <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện"
                                            class="img-fluid me-2" width="28" height="29">
                                        <b>{{ $le_lich['dd'] }}/{{ $le_lich['mm'] }}</b>: {{ $le_lich['name'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
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
                                <div class="col-12">
                                    <div class="btn custom-pill-btn-date w-100 text-start">
                                        <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện" width="28"
                                            height="29" class="img-fluid me-2">
                                        <b>{{ $le_lich['dd'] }}/{{ $le_lich['mm'] }}</b>: {{ $le_lich['name'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
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
                                    <div class="btn custom-pill-btn-date w-100 text-start">

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
                                        <div class="btn custom-pill-btn-date w-100 text-start">

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
                                        <div class="event-name"
                                            style="font-weight: unset"> <img src="{{ asset('/icons/sukienn1.svg') }}"
                                                width="28" height="29" alt="Sự kiện" class="img-fluid me-2">
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
