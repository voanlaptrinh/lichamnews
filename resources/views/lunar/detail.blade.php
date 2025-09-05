@extends('welcome')
@section('content')
    {{-- <div class=" mt-5">
        <div class="row g-5">


            <div class="col-lg-6">
                <h1>Chuyển Đổi Ngày Dương Sang Âm</h1>



                <form method="POST" action="{{ url('/doi-lich') }}" id="convertForm">
                    @csrf
                    <div class="form-group">
                        <label for="duong_date">Chọn Ngày Dương</label>
                        <input type="date" id="duong_date" name="duong_date" class="form-control custom-date-input"
                            value="{{ old('duong_date', $cdate ?? \Carbon\Carbon::now()->format('Y-m-d')) }}">

                        <label for="am_date" class="mt-3">Hoặc chọn Ngày Âm</label>
                        <input type="date" id="am_date" name="am_date" class="form-control custom-date-input"
                            value="{{ old('am_date', $amToday ?? '') }}">
                    </div>

                    <input type="hidden" name="cdate" id="cdate" value="{{ old('duong_date', $cdate) }}">

                    <button type="submit" class="btn btn-primary mt-3">Chuyển đổi</button>
                </form>


                @if (isset($al))
                    <h3 class="mt-5">Kết quả chuyển đổi</h3>
                    <p><strong>Ngày Dương: </strong>{{ $dd }}/{{ $mm }}/{{ $yy }}</p>
                    <p><strong>Ngày Âm: </strong>{{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }} (Tháng
                        {{ $al[3] == 1 ? 'Nhuận' : 'Thường' }})</p>
                    <p><strong>Ngày: </strong>{{ $getThongTinCanChiVaIcon['can_chi_ngay'] }} <strong>Tháng: </strong>
                        {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                        <strong>Năm: </strong> {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                    </p>
                    <p><strong>Ngày trong tuần: </strong>{{ $weekday }}</p>
                    <p>{!! $ngaySuatHanhHTML !!}</p>
                    <p><b>Giờ hoàng đạo</b> {{ $gioHd }}</p>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="calendar-container">

 
                    <div class="header-calendar">

                        <a href="{{ route('lich.thang', ['nam' => $prevYear, 'thang' => $prevMonth]) }}" class="nav-arrow"
                            title="Tháng trước">
                            <i class="bi bi-chevron-left"></i>
                        </a>

                        <span class="header-calendar-title">
                            Tháng {{ $mm }} năm {{ $yy }}
                        </span>

           
                        <a href="{{ route('lich.thang', ['nam' => $nextYear, 'thang' => $nextMonth]) }}" class="nav-arrow"
                            title="Tháng sau">
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    </div>
       

                    <div class="body-calendar">
                        <div class="p-2">
                            <div class="day-calendar">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="#" id="prev-day-btn" class="nav-arrow" title="Ngày hôm trước"><i
                                            class="bi bi-chevron-left"></i></a>
                                    <div class="day-name">
                                        {{ $dd }}
                                    </div>
                                    <a href="#" id="next-day-btn" class="nav-arrow" title="Ngày hôm sau"><i
                                            class="bi bi-chevron-right"></i></a>
                                </div>

                            </div>
                            <div class="weekday-calendar">
                                <div class="weekday-name">{{ $weekday }}</div>

                                @foreach ($suKienHomNay as $suKien)
                                    <div class="text-center">
                                        <div class="su-kien-info">
                                            <strong>{{ $suKien['ten_su_kien'] ?? $suKien }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center am-lich-header">
                                <div class="am-lich-info">
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_nam'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_nam'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span> Năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                                    </div>
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_thang'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_thang'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span>
                                        Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                                    </div>
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_ngay'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_ngay'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span> Ngày {{ $canChi }}
                                    </div>
                                </div>

                                <div class="am-lich-date">
                                    <span class="date-number">{{ $al[0] }}</span>
                                    <div class="date-label">
                                        Âm lịch<br>Tháng {{ $al[1] }} ({{ $al[4] }})
                                    </div>
                                </div>
                            </div>
                            <div class="am-lich-tietkhi">
                                <span>Tiết khí: {!! $tietkhi['icon'] !!} <b
                                        class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</b></span>
                            </div>
                            <div class="pt-3">
                                <div class="gio-lich-info">
                                    <b>Giờ hoàng đạo</b> {{ $gioHd }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-5 g-3 d-flex justify-content-center">
            @php
                function renderStars($rating)
                {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= $i <= $rating ? '★' : '☆';
                    }
                    return $stars;
                }
            @endphp
            @foreach ($getDetailedGioHoangDao as $itemgio)
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $itemgio['name'] }}
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {!! $itemgio['zodiacIcon'] !!}
                                        </h5>
                                        <p class="mb-0 text-center">

                                            {!! $itemgio['canChiMenh'] !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        {!! renderStars($itemgio['rating']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div>
            <div class="col-lg-12">

                <div class="card-body p-0">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd row g-3" role="tablist"
                        style="border: none !important">
                        <li class="nav-item  pa-right w-50" role="presentation">
                            <a class="nav-link btn active  pt-3 pb-3 text-center text-black fw-bold"
                                id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab"
                                aria-controls="pills-home-nobd" aria-selected="true">Tóm tắt </a>
                        </li>
                        <li class="nav-item tba-ks pa-left  w-50" role="presentation">
                            <a class="nav-link  btn pt-3 pb-3 text-center text-black fw-bold" id="pills-profile-tab-nobd"
                                data-bs-toggle="pill" href="#pills-profile-nobd" role="tab"
                                aria-controls="pills-profile-nobd" aria-selected="false">Chi tiết</a>
                        </li>
                    </ul>

                    <div class="tab-content mb-3" id="pills-without-border-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                            aria-labelledby="pills-home-tab-nobd">
                            <p>{{ $getDaySummaryInfo['intro_paragraph'] }}</p>
                         
                            <h5>Đánh giá ngày {{ round($getDaySummaryInfo['score']['percentage']) }} Điểm -
                                {{ $getDaySummaryInfo['score']['rating'] }}</h5>
                        
                            @php
                                $goodFactors = []; 

                              
                                if ($nhiThapBatTu['nature'] == 'Tốt') {
                                    $goodFactors[] =
                                        'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                }

                          
                                if ($getThongTinTruc['description']['rating'] == 'Tốt') {
                                    $goodFactors[] =
                                        'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập nhị trực)';
                                }

                            
                                if (!empty($getSaoTotXauInfo['sao_tot'])) {
                               
                                    $saoTotList = implode(', ', array_keys($getSaoTotXauInfo['sao_tot']));
                                    $goodFactors[] = 'Các sao tốt khác: ' . $saoTotList;
                                }
                            @endphp

                            <p>
                           
                                @if (!empty($goodFactors))
                                
                                    {!! implode('<br>', $goodFactors) !!}
                                @else
                               
                                    Không có yếu tố tốt nào.
                                @endif
                            </p>


                         
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

                            <p>
                                @if (!empty($badFactors))
                                    {!! implode('<br>', $badFactors) !!}
                                @else
                                    Không có yếu tố xấu nào.
                                @endif
                            </p>
                            <div>
                                ♥ Việc nên làm
                                <div>
                                    <ul>
                                        @if (!empty($nhiThapBatTu['guidance']['good']))
                                            <li>{{ $nhiThapBatTu['guidance']['good'] }} (Nhị thập bát tú -
                                                {{ $nhiThapBatTu['name'] }})</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['good']))
                                            <li>
                                                {{ $getThongTinTruc['description']['good'] }} (Thập nhị trực -
                                                {{ $getThongTinTruc['title'] }})
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                ♥ Việc không nên làm
                                <div>
                                    <ul>
                                        @if (!empty($nhiThapBatTu['guidance']['bad']))
                                            <li>{{ $nhiThapBatTu['guidance']['bad'] }} (Nhị thập bát tú - sao
                                                {{ $nhiThapBatTu['name'] }})</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['bad']))
                                            <li>
                                                {{ $getThongTinTruc['description']['bad'] }} (Thập nhị trực -
                                                {{ $getThongTinTruc['title'] }})
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="pills-profile-nobd" role="tabpanel"
                            aria-labelledby="pills-profile-tab-nobd">
                            <div class="border border-top-0 p-2">
                                <h4> Tổng quan ngay {{ $dd }}/{{ $mm }}/{{ $yy }}</h4>
                                <ul>
                                    <li> Ngày dương lịch: {{ $dd }}/{{ $mm }}/{{ $yy }}
                                    </li>
                                    <li> Ngày âm lịch: {{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}
                                    </li>
                                    <li>Nạp âm ngũ hành: {{ $getThongTinNgay['nap_am']['napAm'] }}</li>
                                    <li>Tuổi xung: {{ $getThongTinNgay['tuoi_xung'] }}</li>
                                    <li>Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}</li>
                                    <li>Giờ hắc đạo: {{ $getThongTinNgay['gio_hac_dao'] }}</li>
                                </ul>
                                <h5>Đánh giá ngày {{ round($getDaySummaryInfo['score']['percentage']) }} / 100 Điểm - Ngày
                                    {{ $getDaySummaryInfo['description'] }}
                                </h5>

                                <h3>PHÂN TÍCH NGŨ HÀNH, SAO, TRỰC, LỤC DIỆU</h3>
                                <h4>1. Xem Can Chi - Khí vận & tuổi hợp/Xung trong ngày</h4>
                                <div>
                                    Nội khí ngày (Can Chi ngày): <br>
                                    - {{ $noiKhiNgay }}
                                </div>
                                <h4>2. Nhị thập bát tú</h4>
                                <p>Ngày {{ $al[0] }}-{{ $al[1] }}-{{ $al[2] }} Âm lịch có xuất
                                    hiện sao: <b>{{ $nhiThapBatTu['name'] }}({{ $nhiThapBatTu['fullName'] }})</b></p>
                                <p>Đây là sao <b>{{ $nhiThapBatTu['nature'] }} </b>-
                                    {{ $nhiThapBatTu['description'] }}</p>
                                <li>
                                    Việc nên làm : {{ $nhiThapBatTu['guidance']['good'] }}
                                    @if ($nhiThapBatTu['guidance']['bad'])
                                        Việc không nên làm : {{ $nhiThapBatTu['guidance']['bad'] }}
                                    @endif
                                </li>
                                <h4>3. Thập nhị trực (12 trực)</h4>
                                <p><b>Trực ngày: </b>Trực <b>{{ $getThongTinTruc['title'] }}</b></p>
                                <p>- Đây là trực {{ $getThongTinTruc['description']['rating'] }} -
                                    {{ $getThongTinTruc['description']['description'] }}</p>
                                <ul>
                                    <li>Việc nên làm: {{ $getThongTinTruc['description']['good'] }}</li>
                                    <li>Việc không nên làm: {{ $getThongTinTruc['description']['bad'] }}</li>
                                </ul>
                                <h4>4. Các sao tốt - xấu theo Ngọc Hạp Thông Thư</h4>
                                <div>
                                    <h6>- Sao tốt</h6>
                                   
                                    @if (!empty($getSaoTotXauInfo['sao_tot']))
                                        @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                            <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                        @endforeach
                                    @else
                                        Không có sao tốt trong ngày này
                                    @endif

                                    </ul>
                                    <h6>- Sao xấu</h6>
                                    <ul>
                                        @if (!empty($getSaoTotXauInfo['sao_xau']))
                                            @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                            @endforeach
                                        @else
                                            Không có sao xấu trong ngày này
                                        @endif

                                    </ul>
                                    <p>{{ $getSaoTotXauInfo['ket_luan'] }}</p>
                                </div>
                                <h4>5. Ngày theo Khổng minh lục diệu</h4>
                                <div>
                                    <p>Ngày này là ngày <b>{{ $khongMinhLucDieu['name'] }}</b>
                                        ({{ $khongMinhLucDieu['rating'] }})</p>
                                    <p>-> {{ $khongMinhLucDieu['description'] }}</p>
                                    <p>{!! $khongMinhLucDieu['poem'] !!}</p>
                                </div>
                                <h3>BÁCH KỴ VÀ CẢNH BÁO ĐẠI KỴ</h3>
                                <div>
                                    <h4>1.Giải thích ý nghĩa theo ngày Bành Tổ Bách Kỵ</h4>
                                    Ngày <b>{{ $canChi }}</b>
                                    <ul>
                                        <li><b>{{ $chiNgay[0] }}</b> {{ $banhToCan }}</li>
                                        <li><b>{{ $chiNgay[1] }}</b> {{ $banhToChi }}</li>
                                    </ul>
                                </div>

                                <h3>NGÀY, GIỜ HƯỚNG XUẤT HÀNH</h3>
                                <div>
                                    <h4>1. Ngày xuất hành</h4>
                                    Đây là ngày <b>{{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['title'] }}
                                        ({{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['rating'] }})</b>:
                                    {{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['description'] }}
                                    <h4>2. Hướng xuất hành</h4>
                                    <h5>Hướng xuất hành tốt:</h5>
                                    <p> ĐÓn Hỷ thần:
                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hyThan']['direction'] }}
                                    </p>
                                    <p> ĐÓn Tài thần:
                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['taiThan']['direction'] }}
                                    </p>
                                    @if ($getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] != 'Hạc Thần bận việc trên trời')
                                        <p> Hắc thần:
                                            {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] }}
                                        </p>
                                    @endif
                                    <h4>3.Giờ xuất hành Lý Thuần Phong</h4>
                                    <h5>Giờ tốt:</h5>
                                    @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['good'] as $name => $items)
                                        @foreach ($items as $item)
                                            <p> - {{ $item['name'] }} ({{ $item['rating'] }}):
                                                {{ $item['timeRange'][0] }} ({{ $item['chi'][0] }}) và
                                                {{ $item['timeRange'][1] }} ({{ $item['chi'][1] }}) ->
                                                {{ $item['description'] }}
                                            </p>
                                        @endforeach
                                    @endforeach
                                    <h5>Giờ Xấu:</h5>
                                    @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['bad'] as $name => $items)
                                        @foreach ($items as $item)
                                            <p> - {{ $item['name'] }} ({{ $item['rating'] }}):
                                                {{ $item['timeRange'][0] }} ({{ $item['chi'][0] }}) và
                                                {{ $item['timeRange'][1] }} ({{ $item['chi'][1] }}) ->
                                                {{ $item['description'] }}
                                            </p>
                                        @endforeach
                                    @endforeach
                                    {{ $getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong_description'] }}


                                </div>
                                <h5>KẾT LUẬN CHUNG</h5>
                                <p>{{ $getDaySummaryInfo['intro_paragraph'] }}</p>
                                ☼ Các yếu tố tốt xuất hiện trong ngày
                                <p>
                                    @if ($nhiThapBatTu['nature'] == 'Tốt')
                                        Sao {{ $nhiThapBatTu['name'] }} (Nhị thập bát tú),
                                    @endif
                                    @if ($getThongTinTruc['description']['rating'] == 'Tốt')
                                        Trực {{ $getThongTinTruc['title'] }} (Thập nhị trực),
                                    @endif
                                    @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                        @if ($getSaoTotXauInfo['sao_tot'])
                                            Sao: {{ $loop->first ? '' : ', ' }}{{ $tenSao }}
                                        @endif
                                    @endforeach
                                </p>
                                ☼ Các yếu tố xấu xuất hiện trong ngày
                                <p>
                                    @if ($nhiThapBatTu['nature'] == 'Xấu')
                                        Sao {{ $nhiThapBatTu['name'] }} (Nhị thập bát tú),
                                    @endif

                                    @if ($getThongTinTruc['description']['rating'] == 'Xấu')
                                        Trực {{ $getThongTinTruc['title'] }} (Thập nhị trực),
                                    @endif
                                    Sao: @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                        {{ $loop->first ? '' : ', ' }}{{ $tenSao }}
                                    @endforeach
                                </p>
                                <div>
                                    ♥ Việc nên làm
                                    <div>
                                        <ul>
                                            @if (!empty($nhiThapBatTu['guidance']['good']))
                                                <li>{{ $nhiThapBatTu['guidance']['good'] }} (Nhị thập bát tú -
                                                    {{ $nhiThapBatTu['name'] }})</li>
                                            @endif
                                            @if (!empty($getThongTinTruc['description']['good']))
                                                <li>
                                                    {{ $getThongTinTruc['description']['good'] }} (Thập nhị trực -
                                                    {{ $getThongTinTruc['title'] }})
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    ♥ Việc không nên làm
                                    <div>
                                        <ul>
                                            @if (!empty($nhiThapBatTu['guidance']['bad']))
                                                <li>{{ $nhiThapBatTu['guidance']['bad'] }} (Nhị thập bát tú - sao
                                                    {{ $nhiThapBatTu['name'] }})</li>
                                            @endif
                                            @if (!empty($getThongTinTruc['description']['bad']))
                                                <li>
                                                    {{ $getThongTinTruc['description']['bad'] }} (Thập nhị trực -
                                                    {{ $getThongTinTruc['title'] }})
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="calendar-table">
            <thead>
                <tr>
                    <th><span class="title-lich-pc">Thứ hai</span> <span class="title-lich-mobie">Th 2</span></th>
                    <th><span class="title-lich-pc">Thứ ba</span> <span class="title-lich-mobie">Th 3</span></th>
                    <th><span class="title-lich-pc">Thứ tư</span> <span class="title-lich-mobie">Th 4</span></th>
                    <th><span class="title-lich-pc">Thứ năm</span> <span class="title-lich-mobie">Th 5</span></th>
                    <th><span class="title-lich-pc">Thứ sau</span> <span class="title-lich-mobie">Th 6</span></th>
                    <th><span class="title-lich-pc">Thứ bảy</span> <span class="title-lich-mobie">Th 7</span></th>
                    <th><span class="title-lich-pc">Chủ nhật</span> <span class="title-lich-mobie">CN</span></th>

                </tr>
            </thead>
            <tbody>
                {!! $table_html !!}
            </tbody>
        </table>

    </div> --}}
    <div class="container-setup">
        <h6 class="content-title-date-detail">Trang chủ <i class="bi bi-chevron-right"></i> <span>Chi tiết ngày</span></h6>
        <div class="box-date-detail">
            <div class="row g-3">
                <div class="col-6">
                    <div class="date-display-card">
                        {{-- Nút Prev Day PC --}}
                        <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn" title="Ngày hôm trước"><i
                                class="bi bi-chevron-left"></i></a>
                        <div class="text-center">
                            <div class="card-title"><img src="{{ asset('icons/icon_duong.svg') }}" alt="icon_duong"
                                    width="20px" height="20px"> Dương lịch</div>
                            <div class="date-number duong date_number_lich"> {{ $dd }}</div>
                            <div class="date-weekday">{{ $weekday }}, tháng {{ $mm }} năm
                                {{ $yy }}</div>
                            <div class="date-special-event">
                                @foreach ($suKienHomNay as $suKien)
                                    {{ $suKien['ten_su_kien'] ?? $suKien }}
                                @endforeach
                            </div>
                        </div>
                        {{-- Nút Next Day PC (Đã sửa) --}}
                        {{-- Nút này thường nằm trong phần Âm lịch để căn chỉnh đẹp hơn, tôi sẽ di chuyển nó sang đó. --}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="date-display-card">
                        <div class="text-center">
                            <div class="card-title"><img src="{{ asset('icons/icon_am.svg') }}" alt="icon_am"
                                    width="20px" height="20px"> Âm lịch</div>
                            <div class="date-number am date_number_lich date_number_lich_am">{{ $al[0] }}
                            </div>
                            <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                            <div class="date-special-event">Ngày {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                -
                                Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
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


                <div class="card-body p-4 position-relative">
                    <!-- Nút "Tổng quan" ở góc trên bên phải -->


                    <div class="row"> <!-- Sử dụng row thay vì d-flex flex-column flex-md-row -->
                        <!-- Cột bên trái: Navigation (Tabs) -->
                        <div class="left-sidebar col-12 col-md-auto  border-end-md pb-3 pb-md-0 mb-3 mb-md-0">
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
                                    role="tab" aria-controls="v-pills-auspicious-hours" aria-selected="false">Giờ hoàng
                                    đạo</button>

                                <!-- Tab 4: Điểm ngày đẹp -->
                                <button class="nav-link text-start p-3" id="v-pills-good-day-score-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-good-day-score" type="button"
                                    role="tab" aria-controls="v-pills-good-day-score" aria-selected="false">Điểm ngày
                                    đẹp</button>

                                <!-- Tab 5: Bốc quẻ tò mò -->
                                <button class="nav-link text-start p-3" id="v-pills-curious-hexagram-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-curious-hexagram" type="button"
                                    role="tab" aria-controls="v-pills-curious-hexagram" aria-selected="false">Bốc quẻ
                                    tò
                                    mò</button>
                            </div>
                        </div>

                        <!-- Cột bên phải: Nội dung chính (Tab Content) -->
                        <div class="main-content col pt-3 pt-md-0 tab-content" id="v-pills-tabContent">
                            <!-- Nội dung cho "Thông tin chung" (Tab 1 - active mặc định) -->
                            <div class="tab-pane fade show active" id="v-pills-general-info" role="tabpanel"
                                aria-labelledby="v-pills-general-info-tab" tabindex="0">
                                <p class="mb-2 text-secondary small">
                                    <span class="fw-bold text-dark">Tiết khí:</span> {!! $tietkhi['icon'] !!} <span
                                        class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                                </p>
                                <p class="mb-2 text-secondary small">
                                    <span class="fw-bold text-dark">Ngũ hành nạp âm:</span>
                                    {{ $getThongTinNgay['nap_am']['napAm'] }}
                                </p>
                                <p class="mb-2 text-secondary small">
                                    <span class="fw-bold text-dark">Sao, trực:</span> sao {{ $nhiThapBatTu['name'] }}
                                    ({{ $nhiThapBatTu['fullName'] }}), trực {{ $getThongTinTruc['title'] }}


                                </p>
                                <p class="mb-2 text-secondary small">
                                    <span class="fw-bold text-dark">Tuổi xung:</span> {{ $getThongTinNgay['tuoi_xung'] }}
                                </p>
                                <p class="mb-4 text-secondary small">
                                    <span class="fw-bold text-dark">Giờ hoàng đạo:</span>
                                    {{ $getThongTinNgay['gio_hoang_dao'] }}
                                </p>

                                <!-- Mức thuận lợi hôm nay box -->
                                <div class="row g-3 p-3 rounded-3 border custom-light-yellow-bg">
                                    <div class="col-xl-6 col-sm-6 col-12">
                                        <span class=" fw-bold me-4 text-dark">Mức thuận lợi hôm nay:</span>
                                    </div>
                                    <div
                                        class="col-xl-6 col-sm-6 col-12 p-0 m-0 d-flex justify-content-center align-items-center">
                                        <div class="progress-dial"
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
                                                    class="dial-status pt-2 {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? 'text-secondary' }}">
                                                    {{ $getDaySummaryInfo['score']['rating'] }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
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
                                    <!-- Nút chuyển đổi (Toggle Switch) -->
                                   <div class="d-flex justify-content-end">
                                     <ul class="nav nav-pills mb-3 custom-tab-switch " id="pills-tab" role="tablist">
                                        <li class="nav-item flex-grow-1" role="presentation">
                                            <!-- Thêm flex-grow-1 vào nav-item -->
                                            <button class="btn btn-sm custom-tab-btn active" id="pills-summary-tab"
                                                data-bs-toggle="pill" data-bs-target="#content-tab-summary"
                                                type="button" role="tab" aria-controls="content-tab-summary"
                                                aria-selected="false">Tóm tắt</button>
                                        </li>
                                        <li class="nav-item flex-grow-1" role="presentation">
                                            <!-- Thêm flex-grow-1 vào nav-item -->
                                            <button class="btn btn-sm custom-tab-btn " id="pills-details-tab"
                                                data-bs-toggle="pill" data-bs-target="#content-tab-details"
                                                type="button" role="tab" aria-controls="content-tab-details"
                                                aria-selected="true">Chi tiết</button>
                                        </li>
                                    </ul>

                                   </div>
                                    <!-- Nội dung của các tab sẽ hiển thị ở đây -->
                                    <div class="tab-content" id="myDynamicTabContent">
                                        <!-- Thẻ div thứ nhất (Nội dung tóm tắt) -->
                                        <div class="tab-pane fade  show active" id="content-tab-summary" role="tabpanel"
                                            aria-labelledby="tab-summary-button" tabindex="0">
                                            <h6 class="fw-bold mb-2">
                                                <img src="{{ asset('icons/dac-diem1.svg') }}" alt="Đặc điểm"
                                                    class="img-fluid me-2">Đặc điểm ngày 
                                            </h6>
                                            <p class="text-secondary small">
                                                @if (!empty($getDaySummaryInfo['intro_paragraph']))
                                                    {{ $getDaySummaryInfo['intro_paragraph'] }}
                                                @else
                                                    Đang cập nhật (Nội dung tóm tắt)
                                                @endif
                                            </p>
                                            @if (!empty($nhiThapBatTu['guidance']['good']))
                                                <div class="content-section mb-4">
                                                    <h6 class="fw-bold mb-2">
                                                        <img src="{{ asset('icons/dac-diem2.svg') }}" alt="Đặc điểm"
                                                            class="img-fluid me-2">Việc nên làm
                                                    </h6>
                                                    <ul class="list-unstyled text-secondary small">
                                                        <li>{{ $nhiThapBatTu['guidance']['good'] }}</li>
                                                    </ul>
                                                </div>
                                            @endif

                                            <!-- Không nên -->
                                            @if (!empty($nhiThapBatTu['guidance']['bad']))
                                                <div class="content-section mb-4">
                                                    <h6 class="fw-bold mb-2">
                                                        <img src="{{ asset('icons/dac-diem3.svg') }}" alt="Đặc điểm"
                                                            class="img-fluid me-2">Không nên
                                                    </h6>
                                                    <ul class="list-unstyled text-secondary small">
                                                        <li>{{ $nhiThapBatTu['guidance']['bad'] }}</li>
                                                    </ul>
                                                </div>
                                            @endif

                                           
                                        </div>

                                        <!-- Thẻ div thứ hai (Nội dung chi tiết - Active mặc định) -->
                                        <div class="tab-pane fade" id="content-tab-details" role="tabpanel"
                                            aria-labelledby="tab-details-button" tabindex="0">
                                            <!-- Nội dung chi tiết của bạn ở đây -->
                                            fsdfds (Nội dung chi tiết được hiển thị khi click vào "Chi tiết")
                                            <p class="text-secondary small mt-2">
                                                Đây là nội dung chi tiết đầy đủ hơn về một chủ đề nào đó, có thể bao gồm các
                                                phân tích sâu hơn hoặc các phần bổ sung.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Việc nên làm -->

                            </div>

                            <!-- Nội dung placeholder cho "Giờ hoàng đạo" (Tab 3) -->
                            <div class="tab-pane fade" id="v-pills-auspicious-hours" role="tabpanel"
                                aria-labelledby="v-pills-auspicious-hours-tab" tabindex="0">
                                <h6 class="fw-bold mb-2"><i class="fas fa-clock text-info me-2"></i>Chi tiết Giờ hoàng
                                    đạo
                                </h6>
                                <p class="text-secondary small">Nội dung về các giờ hoàng đạo trong ngày sẽ được hiển
                                    thị ở
                                    đây, giúp bạn lựa chọn thời điểm tốt nhất cho các hoạt động quan trọng.</p>
                                <ul class="list-unstyled text-secondary small">
                                    <li>Giờ Tý (23h-1h): Nên làm gì...</li>
                                    <li>Giờ Sửu (1h-3h): Nên làm gì...</li>
                                    <li>Giờ Dần (3h-5h): Nên làm gì...</li>
                                    <li>...</li>
                                </ul>
                            </div>

                            <!-- Nội dung placeholder cho "Điểm ngày đẹp" (Tab 4) -->
                            <div class="tab-pane fade" id="v-pills-good-day-score" role="tabpanel"
                                aria-labelledby="v-pills-good-day-score-tab" tabindex="0">
                                <h6 class="fw-bold mb-2"><i class="fas fa-star text-warning me-2"></i>Điểm ngày đẹp
                                </h6>
                                <p class="text-secondary small">Thông tin chi tiết về điểm số và đánh giá tổng thể của
                                    ngày dựa trên các yếu tố phong thủy, giúp bạn nắm bắt mức độ thuận lợi của hôm nay.
                                </p>
                                <div class="alert alert-info small mt-3">Ngày hôm nay đạt 85/100 điểm với nhiều sao tốt
                                    chiếu mệnh, hứa hẹn một ngày nhiều may mắn và thành công!</div>
                            </div>

                            <!-- Nội dung placeholder cho "Bốc quẻ tò mò" (Tab 5) -->
                            <div class="tab-pane fade" id="v-pills-curious-hexagram" role="tabpanel"
                                aria-labelledby="v-pills-curious-hexagram-tab" tabindex="0">
                                <h6 class="fw-bold mb-2"><i class="fas fa-question-circle text-muted me-2"></i>Bốc quẻ
                                    tò
                                    mò</h6>
                                <p class="text-secondary small">Hãy nhấp vào đây để bốc một quẻ ngẫu nhiên và nhận lời
                                    khuyên, tiên đoán cho một khía cạnh cụ thể của cuộc sống trong ngày hôm nay.</p>
                                <button class="btn btn-outline-secondary mt-3">Bốc quẻ ngay!</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
