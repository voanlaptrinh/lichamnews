 <div class="row g-lg-3 g-2">
     <div class="col-xl-9 col-sm-12 col-12">
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
                             <div class="date-special-event  date-special-event-duong">
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
                             <div class="date-special-event text-dark">Ngày
                                 {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                 -
                                 Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                             <div class="date-special-event  date-special-event-am">
                                 @if (!empty($suKienAmLich))
                                     @foreach ($suKienAmLich as $suKien)
                                         <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}</div>
                                     @endforeach
                                 @endif

                             </div>
                         </div>
                         {{-- Nút Next Day PC (Đã sửa và di chuyển vào đây) --}}
                         <a href="#" class="nav-arrow nav-home-date nave-right next-day-btn" title="Ngày hôm sau">
                             <i class="bi bi-chevron-right"></i></a>
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
         </div>


         <div class="mt-lg-5 mt-3 mb-5">

             <div class="tong-quan-date mb-4">


                 <div class="card-body  p-lg-4 p-3 position-relative">
                     <!-- Nút "Tổng quan" ở góc trên bên phải -->
                     <div class="mb-3">
                         <h2 class="title-tong-quan-h2">
                             Âm lịch {{ $titletodate ?? '' }} ngày {{ $al[0] }} tháng {{ $al[1] }} năm
                             {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                         </h2>
                         <hr>
                         <style>
                             .vncal-detail .custom-table {
                                 width: 100%;
                                 border-collapse: collapse;
                                 /* gộp viền lại */
                                 table-layout: fixed;
                                 /* chia đều cột */
                             }

                             .vncal-detail .custom-table td {
                                 width: 50%;
                                 border: 1px solid #ccc;
                                 /* kẻ bảng */
                                 padding: 8px;
                             }
                         </style>
                         <div class="ms-lg-3 text-box-tong-quan ">
                             <div class="row g-3 mb-3">
                                 <div class="col-lg-12 vncal-detail">
                                     <table class="custom-table">
                                         <tbody>
                                             <tr>
                                                 <td> <b>Ngày Dương Lịch:</b>
                                                     {{ $dd }}/{{ $mm }}/{{ $yy }}
                                                     ({{ $weekday }})
                                                 </td>
                                                 <td> <b>Ngày Âm Lịch:</b>
                                                     {{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="text-capitalize"><b> Tiết khí:</b>
                                                     {{ $tietkhi['tiet_khi'] }}</td>
                                                 <td class=""> <b>Ngày can chi:</b>
                                                     {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                                     tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                                                     năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</td>
                                             </tr>
                                             <tr>
                                                 <td> <b>Nạp âm:</b> {{ $getThongTinNgay['nap_am']['napAm'] }} (Hành
                                                     {{ $getThongTinNgay['nap_am']['napAmHanh'] }})
                                                 </td>
                                                 <td> <b>Tuổi xung:</b> {{ $getThongTinNgay['tuoi_xung'] }}</td>
                                             </tr>
                                             <tr>
                                                 <td> <b>Giờ hoàng đạo:</b> {{ $getThongTinNgay['gio_hoang_dao'] }}
                                                 </td>
                                                 <td> <b>Giờ hắc đạo:</b> {{ $getThongTinNgay['gio_hac_dao'] }}</td>
                                             </tr>
                                             <tr>
                                                 <td>
                                                     @if (!empty($hacDaoStars))
                                                         <div>
                                                             <b>Ngày hắc đạo:</b>
                                                             @php
                                                                 $hacDaoStarStrings = [];
                                                                 foreach (
                                                                     $hacDaoStars
                                                                     as $starName => $starDescription
                                                                 ) {
                                                                     $hacDaoStarStrings[] = $starName;
                                                                 }
                                                                 echo implode(', ', $hacDaoStarStrings);
                                                             @endphp
                                                         </div>
                                                     @endif

                                                     <div>
                                                         <b>Nhị trực bát tú:</b> sao {{ $nhiThapBatTu['name'] }}
                                                         ({{ $nhiThapBatTu['fullName'] }})
                                                     </div>
                                                     <div> <b>Thập Nhị Trực:</b> Trực {{ $getThongTinTruc['title'] }}
                                                     </div>


                                                 </td>
                                                 <td>
                                                     <div class="box-chi-so-ngaytot">
                                                         <div>
                                                             <b> Chỉ số ngày tốt</b>
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
                                                                     class="dial-status pt-2 {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? '' }}">
                                                                     {{ $getDaySummaryInfo['score']['rating'] }}
                                                                 </small>
                                                             </div>
                                                         </div>
                                                     </div>


                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>

                             </div>

                             <div class=" fs-5">
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
                                         'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị Thập Bát Tú)';
                                 }

                                 if ($getThongTinTruc['description']['rating'] == 'Tốt') {
                                     $goodFactors[] =
                                         'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập Nhị Trực)';
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
                                     $badFactors[] = 'Sao ' . $nhiThapBatTu['name'] . ' (Nhị Thập Bát Tú)';
                                 }

                                 if ($getThongTinTruc['description']['rating'] == 'Xấu') {
                                     $badFactors[] =
                                         'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập Nhị Trực)';
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
                                 <h5 class=" mb-2">
                                     Việc nên làm
                                 </h5>
                                 <ul class="mb-0">


                                     @if (!empty($nhiThapBatTu['guidance']['good']))
                                         <li>{{ $nhiThapBatTu['guidance']['good'] }} (theo Nhị Thập Bát Tú - sao
                                             {{ $nhiThapBatTu['name'] }}).</li>
                                     @endif
                                     @if (!empty($getThongTinTruc['description']['good']))
                                         <li>
                                             {{ $getThongTinTruc['description']['good'] }} (theo Thập Nhị
                                             Trực - trực {{ $getThongTinTruc['title'] }}).
                                         </li>
                                     @endif
                                     {{-- <li>{{ $nhiThapBatTu['guidance']['good'] }}</li> --}}
                                 </ul>
                             </div>
                             <!-- Không nên -->
                             <div class="content-section mb-3">
                                 <h5 class=" mb-2 mt-2">
                                     Việc không nên làm
                                 </h5>
                                 <ul class=" ">
                                     @if (!empty($nhiThapBatTu['guidance']['bad']))
                                         <li>{{ $nhiThapBatTu['guidance']['bad'] }} (theo Nhị Thập Bát Tú -
                                             sao
                                             {{ $nhiThapBatTu['name'] }}).</li>
                                     @endif
                                     @if (!empty($getThongTinTruc['description']['bad']))
                                         <li>
                                             {{ $getThongTinTruc['description']['bad'] }} (theo Thập Nhị Trực
                                             -
                                             trực {{ $getThongTinTruc['title'] }}).
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
                                         <h5 class="title-tong-quan-h5 fw-semibold">Quan hệ Can chi ngày (nội khí):
                                         </h5>
                                         <p>
                                             {!! $noiKhiNgay !!}
                                         </p>
                                     </div>
                                 </div>
                                 <div class="item-container pt-2">

                                     <div class="text-content">
                                         <h5 class="title-tong-quan-h5 fw-semibold">Vận khí ngày & tháng (khí
                                             tháng):</h5>
                                         <ul class="mb-1">
                                             {!! $getVongKhiNgayThang['analysis'] !!}
                                         </ul>
                                         <p>{!! $getVongKhiNgayThang['conclusion'] !!}</p>
                                     </div>
                                 </div>
                                 <div class="item-container pt-2">

                                     <div class="text-content">
                                         <h5 class="title-tong-quan-h5">Cục khí - hợp xung:</h5>
                                         <ul class="mb-2">
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
                                         <div class="mt-2"> <i class="bi bi-arrow-right-short"></i> Đây
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
                                         <div class="mt-2">
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
                                             <h5 class="title-tong-quan-h5">Sao
                                                 Tốt:
                                             </h5>
                                             <ul class="mb-2">
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
                                             <ul class="mb-2">
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
                                     <div class="">
                                         <div>Ngày này là ngày
                                             <b>{{ $khongMinhLucDieu['name'] }}</b>
                                             ({{ $khongMinhLucDieu['rating'] }})
                                         </div>
                                         <div class="mt-2"><i class="bi bi-arrow-right-short"></i>
                                             {{ $khongMinhLucDieu['description'] }}
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
                                     <ul class="mb-2">
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
                                             <ul class="mb-0">
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
                                                 <ul class="mb-0">
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
                                         <h5 class="title-tong-quan-h5">Giờ tốt:</h5>
                                         <ul>
                                             @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['good'] as $name => $items)
                                                 @foreach ($items as $item)
                                                     <li> {{ $item['name'] }} ({{ $item['rating'] }}):
                                                         {{ $item['timeRange'][0] }}
                                                         ({{ $item['chi'][0] }})
                                                         và
                                                         {{ $item['timeRange'][1] }}
                                                         ({{ $item['chi'][1] }}) <i
                                                             class="bi bi-arrow-right-short"></i>
                                                         {{ $item['description'] }}
                                                     </li>
                                                 @endforeach
                                             @endforeach
                                         </ul>
                                     </div>
                                     <div>
                                         <h5 class="title-tong-quan-h5">Giờ Xấu:</h5>
                                         <ul>
                                             @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['bad'] as $name => $items)
                                                 @foreach ($items as $item)
                                                     <li> {{ $item['name'] }} ({{ $item['rating'] }}):
                                                         {{ $item['timeRange'][0] }}
                                                         ({{ $item['chi'][0] }})
                                                         và
                                                         {{ $item['timeRange'][1] }}
                                                         ({{ $item['chi'][1] }}) <i
                                                             class="bi bi-arrow-right-short"></i>
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


     <div class="col-xl-3  col-sm-12 col-12 mb-3">
         <div class="d-flex flex-column gap-4">



             <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
             <div class="events-card">
                 <h5 class="card-title-right">Sự kiện, ngày lễ sắp tới</h5>
                 <ul class="list-group list-group-flush events-list-box">
                     @foreach ($upcomingEvents as $event)
                         @php
                             // Phân tích cú pháp ngày sự kiện một lần để lấy các phần tử năm, tháng, ngày
                             $eventCarbonDate = Carbon\Carbon::parse($event['date']);
                             $routeParams = [
                                 'nam' => $eventCarbonDate->year,
                                 'thang' => $eventCarbonDate->month,
                                 'ngay' => $eventCarbonDate->day,
                             ];
                             $lunarDate = App\Helpers\LunarHelper::convertSolar2Lunar(
                                 $eventCarbonDate->day,
                                 $eventCarbonDate->month,
                                 $eventCarbonDate->year,
                             );
                         @endphp
                         <li class="list-group-item event-item">
                             <a href="{{ route('detai_home', $routeParams) }}">
                                 <div class="event-date">Ngày
                                     {{ Carbon\Carbon::parse($event['date'])->format('d/m') }} <span
                                         style="font-size: 12px;color: #6c757d;font-style: italic;">({{ $lunarDate[0] }}/{{ $lunarDate[1] }} ÂL)
                                     </span>

                                 </div>
                                 <div class="event-icon">🗓️</div>
                                 <div class="event-details">
                                     <div class="event-name">{{ $event['description'] }}</div>
                                     <div class="event-countdown">
                                         @if ($event['days_remaining'] === 0)
                                             Hôm nay
                                         @elseif ($event['days_remaining'] === 1)
                                             Còn 1 ngày
                                         @else
                                             Còn {{ $event['days_remaining'] }} ngày
                                         @endif

                                         <i class="bi bi-chevron-right"></i>
                                     </div>
                                 </div>
                             </a>
                         </li>
                     @endforeach
                 </ul>
             </div>
         </div>
     </div>
 </div>
