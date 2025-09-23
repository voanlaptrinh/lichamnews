@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a><i class="bi bi-chevron-right"></i> Lịch năm {{$yy}} <i class="bi bi-chevron-right"></i> <span style="color: #2254AB">
                Tháng {{ $mm }}</span></h6>
        <h1 class="content-title-home-lich">Lịch Âm Tháng {{ $mm }}</h1>

    </div>
    <div class="row">
        <div class="row g-lg-3 g-2 mt-0 mb-4">
            <!-- Ngày tốt tháng {{ $mm }} (Good day of August) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Ngày tốt tháng {{ $mm }}</span>
                </button>
            </div>
            <!-- Ngày xấu tháng {{ $mm }} (Bad day of August) - Cloud with red X -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem3.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Ngày xấu tháng {{ $mm }}</span>
                </button>
            </div>
            <!-- Ngày lễ dương lịch (Solar calendar holiday / Public holiday) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Ngày lễ dương lịch</span>
                </button>
            </div>
            <!-- Sự kiện lịch sử (Historical event) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Sự kiện lịch sử</span>
                </button>
            </div>
            <!-- Ngày xuất hành âm lịch (Lunar calendar travel day) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Ngày xuất hành âm lịch</span>
                </button>
            </div>
            <!-- Lịch âm tháng khác (Other lunar months calendar) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="Đặc điểm" class="img-fluid me-2" width="20px">
                    <span>Lịch âm tháng khác</span>
                </button>
            </div>

        </div>
        <div class="col-lg-9">
            <div class="boxx-col-lg-8">
                <div class="box-content-lg-8">
                    <div class="calendar-wrapper">
                        <div class="calendar-header">

                            <a href="{{ route('lich.thang', ['nam' => $mm == 1 ? $yy - 1 : $yy, 'thang' => $mm == 1 ? 12 : $mm - 1]) }}"
                                class="month-nav">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <h5 class="mb-0">Tháng {{ $mm }} năm {{ $yy }}</h5>

                            <a href="{{ route('lich.thang', ['nam' => $mm == 12 ? $yy + 1 : $yy, 'thang' => $mm == 12 ? 1 : $mm + 1]) }}"
                                class="month-nav">
                                <i class="bi bi-chevron-right"></i>
                            </a>

                            {{-- <a href="{{ route('lich.nam.ngay', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                        class="btn-today-home-pc btn-today-home">
                        <i class="bi bi-calendar-plus pe-1-pc-home"></i> Hôm nay
                    </a> --}}

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

        </div>
        <div class="col-lg-3">
            <div class="box--bg-thang">

                <div class="row g-3">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                            <a href="{{ route('lich.thang', ['nam' => $yy, 'thang' => $i]) }}" class="">
                                <div
                                    class="btn custom-pill-btn-date w-100 text-center {{ $mm == $i ? 'active-date' : '' }}">

                                   <img src="{{asset('/icons/sukienn1.svg')}}" alt="Sự kiện" class="img-fluid me-2"> Lịch âm tháng {{ $i }} năm {{ $yy }}
                                </div>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <section class="section-thang-lich">
        <div class="">
            <div class="ngay-tot-thang">
                Ngày tốt tháng {{ $mm }} ( Hoàng Đạo )
            </div>
            <div class="row g-lg-3 g-2 row-btn-date">
                @foreach ($data_totxau['tot'] as $data_tot)
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <a href="{{ route('lich.nam.ngay', ['nam' => $data_tot['yy'], 'thang' => $data_tot['mm'], 'ngay' => $data_tot['dd']]) }}"
                            class="btn custom-pill-btn-date  d-flex align-items-center justify-content-center">
                            <span> Ngày {{ $data_tot['dd'] }} Tháng {{ $data_tot['mm'] }} Năm
                                {{ $data_tot['yy'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="ngay-tot-thang">
                Ngày tốt tháng {{ $mm }} ( Hắc Đạo )
            </div>
            <div class="row g-lg-3 g-2 row-btn-date">
                @foreach ($data_totxau['xau'] as $data_xau)
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <a href="{{ route('lich.nam.ngay', ['nam' => $data_xau['yy'], 'thang' => $data_xau['mm'], 'ngay' => $data_xau['dd']]) }}"
                            class="btn custom-pill-btn-date  d-flex align-items-center justify-content-center">
                            <span> Ngày {{ $data_xau['dd'] }} Tháng {{ $data_xau['mm'] }} Năm
                                {{ $data_xau['yy'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="ngay-tot-thang">
                Ngày lễ dương lịch tháng {{ $mm }}
            </div>
            <div class="row g-lg-3 g-2 row-btn-date">
                @foreach ($le_lichs as $le_lich)
                    <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <div class="btn custom-pill-btn-date w-100 text-start">

                            <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện" class="img-fluid me-2">
                            <b>{{ $le_lich['dd'] }}/{{ $le_lich['mm'] }}</b>: {{ $le_lich['name'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="ngay-tot-thang">
                Sự kiện lịch sử tháng {{ $mm }}
            </div>
            <div class="row g-lg-3 g-2 row-btn-date">
                @foreach ($su_kiens as $su_kien)
                    <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <div class="btn custom-pill-btn-date w-100 text-start">

                            <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện"
                                class="img-fluid me-2">{{ $su_kien }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="ngay-tot-thang">
                Ngày xuất hành âm lịch
            </div>
            <div class="row g-lg-2 g-2 row-btn-date">
                @foreach ($data_al as $ngay)
                    <div class=" col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <div class="btn custom-pill-btn-date w-100 text-start">

                            <img src="{{ asset('icons/sukienn1.svg') }}" alt="Sự kiện"
                                class="img-fluid me-2">{{ $ngay['day'] }}/{{ $ngay['month'] }}:

                            @if (!empty($ngay['xuat_hanh_html']))
                                {!! $ngay['xuat_hanh_html'] !!}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
@endsection
