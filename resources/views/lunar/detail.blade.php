@extends('welcome')
@section('content')

    <div class="container-setup">
        <h6 class="content-title-date-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <span>Chi tiết ngày</span>
        </h6>
        <h1 class="content-title-home-lich">LỊCH ÂM DƯƠNG NGÀY {{ $dd }} THÁNG {{ $mm }} NĂM
            {{ $yy }}</h1>
        <div class="box-date-detail">
            <div class="row g-3">
                <div class="col-6">
                    <div class="date-display-card">
                        {{-- Nút Prev Day PC --}}
                        <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn" title="Ngày hôm trước"><i
                                class="bi bi-chevron-left"></i></a>
                        <div class="text-center">
                            <div class="card-title title-amduowngbox"><img src="{{ asset('icons/icon_duong.svg') }}"
                                    alt="icon_duong" width="20px" height="20px"> Dương lịch</div>
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
                            <div class="card-title title-amduowngbox"><img src="{{ asset('icons/icon_am.svg') }}"
                                    alt="icon_am" width="20px" height="20px"> Âm lịch</div>
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

            <div class="tong-quan-date mb-4">


                <div class="card-body  p-lg-4 p-3 position-relative">
                    <!-- Nút "Tổng quan" ở góc trên bên phải -->
                    <div class="mb-3">
                        <h2 class="title-tong-quan-h2">
                            Âm lịch ngày {{ $al[0] }} tháng {{ $al[1] }} năm
                            {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                        </h2>
                        <hr>
                        <div class="ms-lg-3 text-box-tong-quan ">
                            <div class="row g-3 mb-3">
                                <div class="col-lg-7">
                                    <ul>
                                        <li>
                                            Ngày Dương Lịch:
                                            <b>{{ $dd }}/{{ $mm }}/{{ $yy }}</b>
                                            ({{ $weekday }})
                                        </li>
                                        <li>
                                            Ngày Âm Lịch:
                                            <b>{{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}</b>
                                        </li>
                                        <li>
                                            Ngày <b>{{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}</b>
                                            tháng <b>{{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</b>
                                            năm <b>{{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</b>
                                        </li>
                                        @if (!empty($hoangDaoStars))
                                            <li>
                                                Ngày Hoàng Đạo:
                                                <b> @php
                                                    $hoangDaoStarStrings = [];
                                                    foreach ($hoangDaoStars as $starName => $starDescription) {
                                                        $hoangDaoStarStrings[] = $starName;
                                                    }
                                                    echo implode(', ', $hoangDaoStarStrings);
                                                @endphp</b>
                                            </li>
                                        @endif
                                        @if (!empty($hacDaoStars))
                                            <li>
                                                Ngày Hắc Đạo:
                                                <b>
                                                    @php
                                                        $hacDaoStarStrings = [];
                                                        foreach ($hacDaoStars as $starName => $starDescription) {
                                                            $hacDaoStarStrings[] = $starName;
                                                        }
                                                        echo implode(', ', $hacDaoStarStrings);
                                                    @endphp
                                                </b>

                                            </li>
                                        @endif
                                        <li>
                                            Tiết khí: <b>{{ $tietkhi['tiet_khi'] }}</b>
                                        </li>
                                        <li>
                                            Ngũ hành nạp âm: <b>{{ $getThongTinNgay['nap_am']['napAm'] }}</b> (Hành
                                            {{ $getThongTinNgay['nap_am']['napAmHanh'] }})
                                        </li>
                                        <li>
                                            Nhị trực bát tú: sao <b>{{ $nhiThapBatTu['name'] }}</b>
                                            ({{ $nhiThapBatTu['fullName'] }})
                                        </li>
                                        <li>Thập Nhị Trực: Trực <b>{{ $getThongTinTruc['title'] }}</b></li>
                                        <li>
                                            Tuổi xung: <b> {{ $getThongTinNgay['tuoi_xung'] }}</b>
                                        </li>
                                        <li>
                                            Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}
                                        </li>
                                        <li>
                                            Giờ hắc đạo: {{ $getThongTinNgay['gio_hac_dao'] }}
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-lg-5 d-flex justify-content-center align-items-center">
                                    <!-- Mức thuận lợi hôm nay box -->
                                    <div
                                        class="row g-3 p-sm-3 p-2 rounded-3 border custom-light-yellow-bg box-custom_yeloow ms-lg-1">
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
                                </div>
                            </div>

                            <div class="fw-bolder">
                                Đánh giá chung:
                            </div>
                            <p>
                                @if (!empty($getDaySummaryInfo['intro_paragraph']))
                                    {{ $getDaySummaryInfo['intro_paragraph'] }}
                                @else
                                    Đang cập nhật (Nội dung tóm tắt)
                                @endif
                            </p>
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
                                    $goodFactors[] = 'Sao tốt: ' . $saoTotList;
                                }
                            @endphp
                            <div>
                                <div class="fs-5">Các yếu tố tốt:</div>
                                <p>
                                    @if (!empty($goodFactors))
                                        {!! implode('; ', $goodFactors) !!}.
                                    @else
                                        Không có yếu tố tốt nào.
                                    @endif
                                </p>
                            </div>
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
                                    $badFactors[] = 'Sao xấu: ' . $saoXauList;
                                }
                            @endphp
                            <div>
                                <div class="fs-5">Các yếu tố xấu:</div>
                                <p>
                                    @if (!empty($badFactors))
                                        {!! implode('; ', $badFactors) !!}.
                                    @else
                                        Không có yếu tố xấu nào.
                                    @endif
                                </p>

                            </div>
                           

                            
                            <div class="content-section ">
                                <h5 class="fw-bold mb-2">
                                  Việc nên làm
                                </h5>
                                <ul class="mb-0">


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
                                <h5 class="fw-bold mb-2">
                                   Không nên làm
                                </h5>
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


                    </div>




                </div>

            </div>
            <div class="tong-quan-date mt-4">
                <div class="card-body  p-lg-4 p-3 position-relative">
                    <div class="mb-3">
                        <h2 class="title-tong-quan-h2">Luận Giải Các Yếu Tố Trong Ngày</h2>
                        <hr>
                        <div class="ms-lg-3 text-box-tong-quan">

                           
                            <div class="ms-3">
                                <h4 class="title-tong-quan-h4">1. Can chi và ngũ hành</h4>
                                <div class="item-container">
                                    
                                    <div class="text-content">
                                        <h5 class="title-tong-quan-h5 fw-semibold">Quan hệ Can chi ngày (nội khí):</h5>
                                        <p>
                                            {!! $noiKhiNgay !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="item-container pt-2">
                                   
                                    <div class="text-content">
                                        <h5 class="title-tong-quan-h5 fw-semibold">Vận khí ngày & tháng (khí tháng):</h5>
                                        <ul>
                                            {!! $getVongKhiNgayThang['analysis'] !!}
                                        </ul>
                                        <p>{!! $getVongKhiNgayThang['conclusion'] !!}</p>
                                    </div>
                                </div>
                                <div class="item-container pt-2">
                                  
                                    <div class="text-content">
                                        <h5 class="title-tong-quan-h5">Cục khí - hợp xung:</h5>
                                        <ul>
                                            <li> {!! $getCucKhiHopXung['hop'] !!}.</li>
                                            <li> {!! $getCucKhiHopXung['ky'] !!}.</li>
                                        </ul>
                                    </div>
                                </div>
                                <h4 class="title-tong-quan-h4">
                                    2. Nhị thập bát tú
                                </h4>
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

                                    <div class="mt-2 mb-2">
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
                                <h4 class="title-tong-quan-h4">3. Thập Nhị Trực (12 Trực)</h4>
                                <div class="me-sm-2 mb-2">
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
                                <h4 class="title-tong-quan-h4">4. Các sao tốt - xấu theo
                                    Ngọc Hạp Thông Thư</h4>
                                <div class="me-sm-2">
                                    <div class="item-container">
                                       
                                        <div class="text-content">
                                            <h5 class="title-tong-quan-h5" style="color: rgba(240, 93, 7, 1)">Sao Tốt:
                                            </h5>
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
                                       
                                        <div class="text-content">
                                            <h5 class="title-tong-quan-h5">Sao Xấu:</h5>
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
                                <h4 class="title-tong-quan-h4"> 5. Ngày theo Khổng Minh Lục Diệu</h4>
                                <div class="mb-2">
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
                           
                            <div class="ms-2 mb-2">
                                <h4 class="fw-bolder title-tong-quan-h4">6. Giải thích ý nghĩa ngày theo Bành
                                    Tổ Bách Kỵ</h4>
                                <div>
                                    Ngày <b>{{ $canChi }}</b>
                                    <ul>
                                        <li><b>{{ $chiNgay[0] }}: </b>
                                            {{ $banhToCan }}.</li>
                                        <li><b>{{ $chiNgay[1] }}: </b>
                                            {{ $banhToChi }}.</li>
                                    </ul>
                                </div>
                                <h4 class="fw-bolder title-tong-quan-h4">7. Cảnh báo ngày đại Kỵ</h4>
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
                            
                            <div class="ms-2">
                                <div>
                                    <h4 class="fw-bolder title-tong-quan-h4">8. Ngày xuất hành</h4>
                                    <div>
                                        Đây là ngày
                                        <b>{{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['title'] }}
                                            ({{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['rating'] }})</b>:
                                        {{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['description'] }}
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <h4 class="fw-bolder title-tong-quan-h4">9. Hướng xuất hành</h4>
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
                                    <h4 class="fw-bolder title-tong-quan-h4">10. Giờ xuất hành theo Lý Thuần Phong
                                    </h4>
                                    <div>
                                        <div class="fw-bolder text-success">Giờ tốt:</div>
                                        <ul>
                                            @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['good'] as $name => $items)
                                                @foreach ($items as $item)
                                                    <li> {{ $item['name'] }}({{ $item['rating'] }}):
                                                        {{ $item['timeRange'][0] }}
                                                        ({{ $item['chi'][0] }})
                                                        và
                                                        {{ $item['timeRange'][1] }}
                                                        ({{ $item['chi'][1] }}) ->
                                                        {{ $item['description'] }}
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="fw-bolder text-danger">Giờ xấu:</div>
                                        <ul>
                                            @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['bad'] as $name => $items)
                                                @foreach ($items as $item)
                                                    <li> {{ $item['name'] }} ({{ $item['rating'] }}):
                                                        {{ $item['timeRange'][0] }}
                                                        ({{ $item['chi'][0] }})
                                                        và
                                                        {{ $item['timeRange'][1] }}
                                                        ({{ $item['chi'][1] }}) ->
                                                        {{ $item['description'] }}
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        {!! $getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong_description'] !!}
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
