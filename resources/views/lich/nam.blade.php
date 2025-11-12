@extends('welcome')
@section('content')
    <div class="container-setup">
        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i>
            <span>Lịch năm {{ $nam }} </span>
        </div>
        @php
            use App\Helpers\LunarHelper;
        @endphp
        <h1 class="content-title-home-lich">Lịch Âm {{ $nam }} - Lịch Vạn Niên {{ $nam }}</h1>



        <div class="row mt-2 g-3">
            <div class="col-12 col-lg-9">
                <div class="box--bg-thang">
                    <div class="text-box-tong-quan">
                        {!! $nam_content_auto !!}
                    </div>
                </div>

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
                                    <div class="mb-0 pt-2 title-tong-quan-h4-log">Tháng {{ $i }} năm
                                        {{ $nam }}</div>


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



            <div class="col-12 col-lg-3">
                <div class="d-flex flex-column gap-4">
                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <div class="card-title-right title-tong-quan-h4-log">Lịch Vạn Niên Các Năm Khác</div>
                        <ul class="list-group list-group-flush events-list">
                            @php($currentYearHeader = date('Y'))
                            @php($startYearHeader = $currentYearHeader - 1)
                            @php($endYearHeader = $currentYearHeader + 10)
                            @for ($year = $startYearHeader; $year <= $endYearHeader; $year++)
                                <li class="list-group-item event-item pb-0">
                                    <a href="{{ route('lich.nam', ['nam' => $year]) }}">

                                        <div class="event-details">
                                            <div class="event-name {{ $year == $nam ? 'active-date' : '' }}"
                                                style="font-weight: unset">
                                                <img src="{{ asset('/icons/sukienn1.svg') }}" alt="Sự kiện"
                                                    class="img-fluid me-2" width="28" height="29">
                                                Lịch vạn niên {{ $year }}
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <div class="events-card">
                    <div class="card-title-right title-tong-quan-h5-log">Lịch âm các tháng năm {{ $nam }}</div>
                    <ul class="list-group list-group-flush events-list">
                        @if(isset($lunar_months))
                            @foreach($lunar_months as $lunar_month_info)
                                <li class="list-group-item event-item pb-0">
                                    @if($lunar_month_info['is_leap'])
                                        <a href="{{ route('lich.thang.nhuan', ['nam' => $lunar_month_info['lunar_year'], 'thang' => $lunar_month_info['lunar_month']]) }}">
                                    @else
                                        <a href="{{ route('lich.thang', ['nam' => $lunar_month_info['lunar_year'], 'thang' => $lunar_month_info['lunar_month']]) }}">
                                    @endif

                                        <div class="event-details">
                                            <div class="event-name"
                                                style="font-weight: unset"> <img src="{{ asset('/icons/sukienn1.svg') }}"
                                                    width="28" height="29" alt="Sự kiện" class="img-fluid me-2">
                                                Lịch âm tháng {{ $lunar_month_info['lunar_month'] }}{{ $lunar_month_info['is_leap'] ? ' nhuận' : '' }}
                                                năm {{ $lunar_month_info['lunar_year'] }}
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @for ($i = 1; $i <= 12; $i++)
                                <li class="list-group-item event-item pb-0">
                                    <a href="{{ route('lich.thang', ['nam' => $nam, 'thang' => $i]) }}">

                                        <div class="event-details">
                                            <div class="event-name"
                                                style="font-weight: unset"> <img src="{{ asset('/icons/sukienn1.svg') }}"
                                                    width="28" height="29" alt="Sự kiện" class="img-fluid me-2">
                                                Lịch âm tháng {{ $i }}
                                                năm {{ $nam }}
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            @endfor
                        @endif
                    </ul>
                </div>
                </div>
            </div>
           
        </div>

    </div>
@endsection
