@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Lịch tháng & năm <i class="bi bi-chevron-right"></i> Lịch tháng <i class="bi bi-chevron-right"></i> <span>Lịch âm
                âm năm {{ $nam }} </span></h6>

        {{-- Hiển thị thông tin chi tiết tại đây --}}
        <div class="row g-lg-3 g-2 row-btn-date">
            <!-- Ngày tốt tháng 1 (Good day of August) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{asset('/icons/dac-diem2.svg')}}" alt="Ngày lễ dương lịch" class="img-fluid me-2" width="20px">
                    <span>Ngày lễ dương lịch {{ $nam }}</span>
                </button>
            </div>
            <!-- Ngày xấu tháng 1 (Bad day of August) - Cloud with red X -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{asset('/icons/dac-diem3.svg')}}" alt="Ngày lễ âm lịch" class="img-fluid me-2" width="20px">
                    <span>Ngày lễ âm lịch {{ $nam }}</span>
                </button>
            </div>
            <!-- Ngày lễ dương lịch (Solar calendar holiday / Public holiday) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{asset('/icons/dac-diem2.svg')}}" alt="Sự kiện lịch sử" class="img-fluid me-2" width="20px">
                    <span>Sự kiện lịch sử {{ $nam }}</span>
                </button>
            </div>
            <!-- Sự kiện lịch sử (Historical event) -->
            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                    <img src="{{asset('/icons/dac-diem1.svg')}}" alt="Lịch âm năm khác" class="img-fluid me-2" width="20px">
                    <span>Sự kiện lịch sử</span>
                </button>
            </div>


        </div>
        <div class="calendar-legend">
            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
            <span><span class="dot dot-chủ nhật"></span> Ngày chủ nhật</span>
            <span><span class="dot dot-special"></span> Ngày đặc biệt</span>
        </div>
        @php
            use App\Helpers\LunarHelper;
        @endphp

        @for ($i = 1; $i <= 12; $i++)
            <div class="mt-5 ms-lg-5 me-lg-5">
                <div class="calendar-wrapper">
                    <div class="text-center">
                        <h5 class="mb-0 pt-2">Tháng {{ $i }} năm {{ $nam }}</h5>


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
                                <th><span class="title-lich-pc">Thứ sau</span> <span class="title-lich-mobie">Th
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
                            {!! LunarHelper::printTable($i, $nam, false) !!}
                        </tbody>
                    </table>

                </div>
                {{-- <div class="calendar-legend pt-3 pb-2">
                <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
                <span><span class="dot dot-chủ nhật"></span> Ngày chủ nhật</span>
                <span><span class="dot dot-special"></span> Ngày đặc biệt</span>
            </div> --}}
            </div>
        @endfor
        <div class="section-thang-lich">
            <div class="">
                <div class="ngay-tot-thang">
                    Xem lịch âm các năm khác
                </div>
                <div class="row g-lg-3 g-2 row-btn-date">
                    @php($currentYearHeader = date('Y'))
                    @php($startYearHeader = $currentYearHeader - 1)
                    @php($endYearHeader = $currentYearHeader + 10)
                    @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                        <div class="col-xl-2 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                            <a href="{{ route('lich.nam', ['nam' => $year]) }}"
                                class="btn custom-pill-btn-date  d-flex align-items-center justify-content-center">
                                <span>Lịch năm {{ $year }}</span>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
            <div>
                <div class="ngay-tot-thang">
                   Sự kiện ngày dương
                </div>
                {!! $sukienduong !!}
            </div>
            <div>
                <div class="ngay-tot-thang">
                   Sự kiện ngày âm
                </div>
                {!! $sukienam !!}
            </div>
        </div>

      
    </div>
@endsection
