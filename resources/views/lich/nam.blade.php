@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a><i class="bi bi-chevron-right"></i>
            <span style="color: #2254AB">Lịch năm {{ $nam }} </span>
        </h6>
        @php
            use App\Helpers\LunarHelper;
        @endphp
        <h1 class="content-title-home-lich">Lịch Âm {{ $nam }} - Lịch Vạn Niên {{ $nam }}</h1>



        <div class="row mt-2 g-3">
            <div class="col-lg-9">
                <div class="box--bg-thang">


                    <div class="text-box-tong-quan">
                        {!! $nam_content_auto !!}
                    </div>
                </div>
                {{-- Hiển thị thông tin chi tiết tại đây --}}
                {{-- <div class="row g-2 pt-2 pb-2">
                    <!-- Ngày tốt tháng 1 (Good day of August) -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                        <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                            <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Ngày lễ dương lịch" class="img-fluid me-2"
                                width="20px">
                            <span>Ngày lễ dương lịch {{ $nam }}</span>
                        </button>
                    </div>
                    <!-- Ngày xấu tháng 1 (Bad day of August) - Cloud with red X -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                            <img src="{{ asset('/icons/dac-diem3.svg') }}" alt="Ngày lễ âm lịch" class="img-fluid me-2"
                                width="20px">
                            <span>Ngày lễ âm lịch {{ $nam }}</span>
                        </button>
                    </div>
                    <!-- Ngày lễ dương lịch (Solar calendar holiday / Public holiday) -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                            <img src="{{ asset('/icons/dac-diem2.svg') }}" alt="Sự kiện lịch sử" class="img-fluid me-2"
                                width="20px">
                            <span>Sự kiện lịch sử {{ $nam }}</span>
                        </button>
                    </div>
                    <!-- Sự kiện lịch sử (Historical event) -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <button type="button" class="btn custom-pill-btn rounded-pill d-flex align-items-center">
                            <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="Lịch âm năm khác" class="img-fluid me-2"
                                width="20px">
                            <span>Sự kiện lịch sử</span>
                        </button>
                    </div>


                </div> --}}


                <div class="box--bg-thang mt-3">
                    <h2 class="title-tong-quan-h2-log">Lịch âm dương đầy đủ, chính xác, chi tiết của 12 tháng trong năm
                        {{ $nam }}</h2>
                    <div class="text-box-tong-quan ">
                        <p>Chắc hẳn bạn đang quan tâm đến Tết Nguyên Đán, ngày nghỉ lễ, các sự kiện quan trọng trong năm
                            {{ $nam }} - Năm {{ $can_chi_nam }} sẽ diễn ra vào thời gian cụ thể nào phải không?
                            Hãy
                            cùng với
                            chúng tôi xem ngay Lịch Âm dương {{ $nam }} từ
                            tháng 1 đến hết tháng 12 để nắm bắt các sự kiện, ngày lễ quan trọng của năm {{ $nam }}
                            nhé.</p>
                    </div>
                </div>
                {{-- <h3 class="title-tong-quan-h3-log">
                    1. XEM LỊCH ÂM DƯƠNG NĂM {{ $nam }}
                </h3>
                <div class="text-box-tong-quan ">
                    <p>Thông tin chính xác và chi tiết về lịch âm 2024 mà bạn có thể xem ngay dưới đây</p>
                </div> --}}
                @for ($i = 1; $i <= 12; $i++)
                    <div class="box--bg-thang mt-3">


                        @if (isset($thang_info[$i]))
                            <div class="">
                                <h3 class="title-tong-quan-h3-log">
                                    Lịch Âm Dương tháng {{ $i }} năm {{ $nam }}
                                </h3>
                                <hr>
                                <div class="text-box-tong-quan">
                                    <p> {{ $thang_info[$i]['mo_ta'] }}</p>
                                    <ul>
                                        <li>Dương lịch: {{ $thang_info[$i]['duong_lich']['tu_ngay'] }}/{{ $i }}
                                            đến
                                            {{ $thang_info[$i]['duong_lich']['den_ngay'] }}/{{ $i }} năm
                                            {{ $nam }}</li>
                                        <li>Âm lịch:
                                            {{ $thang_info[$i]['am_lich_dau']['ngay'] }}/{{ $thang_info[$i]['am_lich_dau']['thang'] }}/{{ $thang_info[$i]['am_lich_dau']['nam'] }}
                                            đến
                                            {{ $thang_info[$i]['am_lich_cuoi']['ngay'] }}/{{ $thang_info[$i]['am_lich_cuoi']['thang'] }}
                                            năm {{ $thang_info[$i]['am_lich_cuoi']['nam'] }}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        @endif

                        <div class="">
                            <div class="calendar-wrapper calendar-wrapper-none">
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
                                            <th><span class="title-lich-pc">Thứ sáu</span> <span class="title-lich-mobie">Th
                                                    6</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ bảy</span> <span class="title-lich-mobie">Th
                                                    7</span>
                                            </th>
                                            <th><span class="title-lich-pc">Chủ nhật</span> <span
                                                    class="title-lich-mobie">CN</span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! LunarHelper::printTable($i, $nam, false) !!}
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                @endfor


                <div class="section-thang-lich mt-3 mb-3">

                    <div class=" box--bg-thang">
                        <h3 class="title-tong-quan-h3-log">
                            Ngày lễ dương lịch {{ $nam }}
                        </h3>
                        <hr>
                        {!! $sukienduong !!}
                    </div>
                    <div class=" box--bg-thang mt-3">
                        <h3 class="title-tong-quan-h3-log">
                            Sự kiện ngày âm lịch {{ $nam }}
                        </h3>
                        <hr>

                        {!! $sukienam !!}
                    </div>

                    <div class=" box--bg-thang  mt-3">
                        <h3 class="title-tong-quan-h3-log">
                            Các sự kiện lịch sử Việt Nam
                        </h3>
                        <hr>

                        <div class="text-box-tong-quan">
                            <p>Các sự kiện lịch sử quan trọng của dân tộc Việt Nam theo từng tháng trong năm:</p>
                        </div>

                        @if (isset($sukien_lichsu))
                            @foreach ($sukien_lichsu as $thang => $cac_su_kien)
                                <div class="mt-3" style="font-size: 13.5px;">
                                    <div class="text-primary">Tháng {{ $thang }}</div>
                                    <ul class="list-unstyled">
                                        @foreach ($cac_su_kien as $su_kien)
                                            <li class="mb-2">
                                                <i class="bi bi-calendar-event text-warning me-2"></i>
                                                <span class="text-dark">{{ $su_kien }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>




            </div>



            <div class="col-xl-3">
                <div class="d-flex flex-column gap-4">
                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <h5 class="card-title-right">Lịch Vạn Niên Các Năm Khác</h5>
                        <ul class="list-group list-group-flush events-list">
                              @php($currentYearHeader = date('Y'))
                        @php($startYearHeader = $currentYearHeader - 1)
                        @php($endYearHeader = $currentYearHeader + 10)
                        @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                            <li class="list-group-item event-item pb-0">
                                <a href="{{ route('lich.nam', ['nam' => $year]) }}">
                                  
                                    <div class="event-details">
                                        <div class="event-name {{ $year == $nam ? 'active-date' : '' }}" style="font-weight: unset"> <img src="{{ asset('/icons/sukienn1.svg') }}" alt="Sự kiện" class="img-fluid me-2"> Lịch vạn niên {{ $year }} </div>
                                        
                                    </div>
                                </a>
                            </li>
                             @endfor
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3">
                <div class="box--bg-thang mb-3">
                    <h4 class="title-tong-quan-h4-log text-center">Lịch Vạn Niên Các Năm</h4>
                    <div class="row g-2">
                        @php($currentYearHeader = date('Y'))
                        @php($startYearHeader = $currentYearHeader - 1)
                        @php($endYearHeader = $currentYearHeader + 10)
                        @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                            <div class="col-12"> <!--  để cột chỉ chiếm chiều rộng cần thiết -->
                                <a href="{{ route('lich.nam', ['nam' => $year]) }}"
                                    class="btn custom-pill-btn-date {{ $year == $nam ? 'active-date' : '' }} d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('/icons/sukienn1.svg') }}" alt="Sự kiện" class="img-fluid me-2">
                                    <span>Lịch năm {{ $year }}</span>
                                </a>
                            </div>
                        @endfor
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
@endsection
