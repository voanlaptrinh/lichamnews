@extends('welcome')
@section('content')

    <div class="container-setup">
        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <span>Đổi
                ngày âm dương </span></div>
        <h1 class="content-title-home-lich">Đổi Ngày Dương Sang Âm & Âm Sang Dương</h1>
        <div class="row g-3">
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="row g-0 justify-content-center pt-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="backv-doi-lich ">
                            <div class="">
                                <div class="row --pading">
                                    <div class="col-lg-8">
                                        <div class="--text-down-convert">Chọn ngày dương hoặc âm bất kỳ:</div>
                                        <p>Chọn ngày âm lịch hoặc dương lịch mà bạn mong muốn rồi ấn vào nút chuyển đổi.</p>
                                        <form action="{{ route('convert.am.to.duong') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="is_leap" value="0" id="form-is-leap">
                                            <div class="row position-relative">
                                                <div class="col-lg-6" id="solar-container">
                                                    <label class="form-label fw-bold" style="color: #212121CC">Ngày Dương
                                                        Lịch</label>
                                                    <div class="date-input-wrapper position-relative">
                                                        <input type="text" value="" name="solar_date"
                                                            id="solar_date" class="form-control date-input"
                                                            placeholder="dd/mm/yyyy" inputmode="text" autocomplete="off"
                                                            data-type="solar" readonly>
                                                        <span class="date-icon-custom">
                                                            <i class="bi bi-calendar-date-fill"></i>
                                                        </span>
                                                        <div id="solar-select-container" class="date-select-container"
                                                            style="display: none;">
                                                            <div class="row g-2">
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Ngày</label>
                                                                    <select id="solar-day"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Tháng</label>
                                                                    <select id="solar-month"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Năm</label>
                                                                    <select id="solar-year"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 text-end">
                                                                <button type="button" class="btn btn-sm btn-secondary me-1"
                                                                    onclick="hideDateSelect('solar')">Hủy</button>
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    onclick="applyDateSelect('solar')">Chọn</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="lunar-container">
                                                    <label class="form-label fw-bold" style="color: #212121CC">Ngày Âm
                                                        Lịch</label>
                                                    <div class="date-input-wrapper position-relative">
                                                        <input type="text" value="" name="lunar_date"
                                                            id="lunar_date" class="form-control date-input"
                                                            placeholder="dd/mm/yyyy" inputmode="text" autocomplete="off"
                                                            data-type="lunar" readonly>
                                                        <span class="date-icon-custom">
                                                            <i class="bi bi-calendar-date-fill"></i>
                                                        </span>
                                                        <div id="lunar-select-container" class="date-select-container"
                                                            style="display: none;">
                                                            <div class="row g-2">
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Ngày</label>
                                                                    <select id="lunar-day"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Tháng</label>
                                                                    <select id="lunar-month"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label-sm">Năm</label>
                                                                    <select id="lunar-year"
                                                                        class="form-select form-select-sm">
                                                                        <!-- Options will be populated by JS -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2" id="lunar-leap-container" style="display: none !important;">
                                                                <div class="col-12">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="lunar-leap-check">
                                                                        <label class="form-check-label" for="lunar-leap-check">
                                                                            <small>Tháng nhuận</small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 text-end">
                                                                <button type="button" class="btn btn-sm btn-secondary me-1"
                                                                    onclick="hideDateSelect('lunar')">Hủy</button>
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    onclick="applyDateSelect('lunar')">Chọn</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Icon chuyển đổi floating ở giữa -->
                                                <button type="button" id="swapDatesBtn"
                                                    class="btn btn-primary rounded-circle swap-btn-floating"
                                                    title="Hoán đổi vị trí">
                                                    <img src="{{ asset('icons/icon-doi-am-duong.svg') }}" alt=""
                                                        class="img-fluid">
                                                </button>
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-center" >
                                                        <button type="submit" style="background: #115097" class="btn btn-primary btnd-nfay">Chuyển
                                                            đổi</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <img src="{{ asset('icons/datedoilich.svg') }}" alt="ảnh đổi lich"
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 g-3">


                    <div class="col-lg-12 order-2 order-lg-2">
                        <div class="box-date-detail bg-white-setting">
                            <div class="--text-down-convert">Kết quả chuyển đổi</div>
                            <div class="col-lg-12 order-1 order-lg-1 mb-3">
                                <div class="row g-0">
                                    <div class="col-6" id="solar-display-container">
                                        <div class="date-display-card date-display-card-right-none">
                                            <button type="button" class="nav-arrow nav-home-date nave-left prev-day-btn"
                                                title="Ngày hôm trước" id="pc-prev-btn"><i
                                                    class="bi bi-chevron-left"></i></button>
                                            <div class="text-center">
                                                <div
                                                    class="card-title title-amduowngbox d-flex align-items-center justify-content-center g-2">
                                                    <img src="{{ asset('/icons/icon_duong.svg') }}" alt="icon_duong"
                                                        width="20px" height="20px" class="me-1">
                                                    <div> Dương lịch</div>
                                                </div>
                                                <div class="date-number duong date_number_lich"> {{ $dd }}</div>
                                                <div class="date-weekday">{{ $weekday }}</div>
                                                <div class="date-special-event text-dark">Tháng {{ $mm }} năm
                                                    {{ $yy }}</div>
                                                <div class="date-special-event">
                                                    @if (!empty($suKienDuongLich))
                                                        @foreach ($suKienDuongLich as $suKien)
                                                            <div class="su-kien-duong">
                                                                {{ $suKien['ten_su_kien'] ?? $suKien }}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-6" id="lunar-display-container">
                                        <div class="date-display-card date-display-card-left-none">
                                            <div class="text-center">
                                                <div
                                                    class="card-title title-amduowngbox d-flex align-items-center justify-content-center">
                                                    <img src="/icons/icon_am.svg" alt="icon_am" width="20px"
                                                        height="20px" class="me-1">
                                                    <div>Âm lịch</div>
                                                </div>
                                                <div class="date-number am date_number_lich date_number_lich_am">
                                                    {{ $al[0] }}
                                                </div>
                                                <div class="date-weekday">Tháng {{ $al[1] }}
                                                  
                                                    ({{ $al[4] }})
                                                    năm
                                                    {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                                                <div class="date-special-event text-dark">Ngày
                                                    {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                                    -
                                                    Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                                                <div class="date-special-event">
                                                    @if (!empty($suKienAmLich))
                                                        @foreach ($suKienAmLich as $suKien)
                                                            <div class="su-kien-duong">
                                                                {{ $suKien['ten_su_kien'] ?? $suKien }}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <button type="button" class="nav-arrow nav-home-date nave-right next-day-btn"
                                                title="Ngày hôm sau" id="pc-next-btn"> <i
                                                    class="bi bi-chevron-right"></i></button>
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


                                    <div class="col-lg-12 mt-2 btn-mobie-next-prev">
                                        <div></div>
                                        <div class="d-flex gap-2">
                                            <div class="div">
                                                <button type="button"
                                                    class="nav-arrow prev-day-btn-mobie  nave-left prev-day-btn"
                                                    title="Ngày hôm trước" id="mobile-prev-btn"><i
                                                        class="bi bi-chevron-left"></i></button>
                                            </div>
                                            <div class="div">
                                                <button type="button" 
                                                    class="nav-arrow  next-day-btn-mobie nave-right next-day-btn"
                                                    title="Ngày hôm sau" id="mobile-next-btn"> <i
                                                        class="bi bi-chevron-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="mt-lg-4 mt-2 text-box-tong-quan box-white-mobi">
                                    <p>✦ Ngày Dương: <span
                                            class="sonar-date">{{ $dd }}/{{ $mm }}/{{ $yy }}</span>
                                    </p>
                                    <p>✦ Ngày Âm: <span
                                            class="lunar-date " style="color: #744F0C !important">{{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}
                                            @if($is_leap_month_selected)
                                                <span style="color: #d83131;"> (nhuận)</span>
                                            @endif
                                        </span>
                                    </p>
                                    <p>✦ Là ngày: {{ $weekday }}</p>
                                    <p>✦ Ngũ hành nạp âm: {{ $getThongTinNgay['nap_am']['napAm'] }}</p>
                                    <p>✦ Tiết khí: {{ $tietkhi['tiet_khi'] }}</p>
                                    <p>✦ Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}</p>


                                    <div class="col-lg-12 pt-2 d-flex justify-content-center ">
                                        <a href="{{ route('detai_home', ['nam' => $yy, 'thang' => $mm, 'ngay' => $dd]) }}"
                                            class="btn btn-primary w-100 mt-3 btn0mobie mt-3"> <img
                                                src="{{ asset('/icons/hand_2_white.svg') }}" alt="hand_2" width="28" height="29"
                                                class="img-fluid">
                                            Xem chi
                                            tiết</a>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

                <div class="mt-3">
                    <div class="calendar-wrapper">
                        <div class="calendar-header-convert calendar-header">
                             <div class="text-center">
                                    <div class="mb-0 pt-2 lich-van--nien">Lịch vạn niên {{ $yy }} - tháng
                                        {{ $mm }}
                                    </div>
                                </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <select id="month-select" class="form-select me-2 custom-select-style"
                                    aria-label="Chọn tháng">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $mm ? 'selected' : '' }}>Tháng
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                <select id="year-select" class="form-select custom-select-style" aria-label="Chọn năm">
                                    @php
                                        $currentYear = $yy;
                                        $startYear = max(1900, $currentYear - 10);
                                        $endYear = min(2100, $currentYear + 10);
                                    @endphp
                                    @for ($i = $endYear; $i >= $startYear; $i--)
                                        <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                                            Năm {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                          
                        </div>
                        <div id="calendar-body-container" class="mb-3">
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
                                    {!! $table_html !!}
                                </tbody>
                            </table>
                        </div>
                        <div class="calendar-legend">
                           <span class="box-title--hoangdao"><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                        <span class="box-title--hacdao"><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
                        </div>
                    </div>
                </div>
                <div class="search-am-duong-lich">
                    <div class="van-lien-hows">
                        <h2 class="title-tong-quan-h2">Đổi Ngày Dương Sang Âm, Âm Sang Dương Online</h2>
                        <hr>
                        <div class="text-box-tong-quan ">
                            <div class="title-tong-quan-h4-log">Đổi Ngày Dương Sang Âm Là Gì?</div>
                            <p><b>Đổi ngày Dương sang Âm</b> (hoặc đổi ngày Âm sang Dương) là việc chuyển đổi giữa hai hệ
                                thống lịch khác nhau:</p>
                            <ul>
                                <li><b>Dương lịch</b>: hay còn gọi là lịch Gregory, sử dụng phổ biến trong hành chính, công
                                    việc, học tập và giao tiếp quốc tế.</li>
                                <li><b>Âm lịch</b> (Lịch âm): dựa vào chu kỳ vận hành của Mặt trăng, gắn liền với các ngày
                                    mồng Một, ngày Rằm, lễ Tết, cúng giỗ và nhiều phong tục truyền thống.</li>
                            </ul>
                            <p>Người Việt Nam hiện nay song song sử dụng cả hai hệ thống này. Vì vậy, việc đổi ngày qua lại
                                giữa lịch Dương và lịch Âm là rất cần thiết để vừa đảm bảo công việc hằng ngày, vừa giữ gìn
                                đời sống văn hóa – tâm linh.</p>
                            <div class="title-tong-quan-h4-log">Sự Khác Biệt Giữa Âm Lịch Và Dương Lịch</div>
                            <ul>
                                <li><b>Dương lịch</b> tính theo chu kỳ quay của Trái Đất quanh Mặt Trời, một năm có 365 hoặc
                                    366 ngày. Đây là loại lịch chính thức trên toàn thế giới.</li>
                                <li><b>Âm lịch</b> lại dựa theo sự vận động của Mặt Trăng. Một tháng Âm lịch thường có 29
                                    hoặc 30 ngày. Để cân bằng với Dương lịch, Âm lịch có thêm tháng nhuận.</li>
                            </ul>
                            <p>Ở Việt Nam, các sự kiện hành chính, quốc gia dùng Dương lịch; còn các hoạt động truyền thống,
                                tín ngưỡng như Tết Nguyên Đán, ngày giỗ tổ tiên, lễ hội, cưới hỏi, động thổ, khai trương…
                                thường dựa theo Âm lịch.</p>
                            <p>Chính vì thế, công cụ đổi ngày Âm sang Dương và ngược lại ra đời để giúp người dùng thuận
                                tiện hơn trong việc xác định ngày tháng theo cả hai hệ thống.</p>
                            <div class="title-tong-quan-h4-log">Khi Nào Cần Đổi Ngày Âm Sang Dương Và Ngược Lại?</div>
                            <p>Trong đời sống hằng ngày, nhu cầu đổi ngày Âm – Dương rất phổ biến, ví dụ:</p>
                            <ul>
                                <li>Ghi nhớ ngày giỗ, lễ Tết: Muốn biết ngày giỗ (theo Âm lịch) rơi vào ngày nào theo Dương
                                    lịch để sắp xếp công việc.</li>
                                <li>Chọn ngày lành tháng tốt: Tra cứu Lịch ngày tốt, ngày Hoàng đạo, giờ tốt cho việc cưới
                                    hỏi, khai trương, động thổ.</li>
                                <li>Kế hoạch công việc và sự kiện quốc tế: Người Việt thường phải đổi ngày Âm sang Dương để
                                    tiện sắp xếp lịch trình chính xác.</li>
                                <li>Xem vận mệnh, tử vi: Nhiều công cụ tử vi, phong thủy cần nhập dữ liệu theo Âm lịch và
                                    Can Chi, trong khi giấy tờ cá nhân lại theo Dương lịch.</li>
                            </ul>
                            <div class="title-tong-quan-h4-log">Ý Nghĩa Của Việc Đổi Ngày Trong Văn Hóa Việt Nam</div>
                            <p>Đổi ngày Âm – Dương không chỉ mang tính tiện ích mà còn gắn liền với nhiều giá trị văn hóa:
                            </p>
                            <ul>
                                <li>Xem ngày tốt – xấu: Dựa vào Can Chi, Ngũ hành, Tiết khí, người xưa xác định được ngày
                                    hoàng đạo để thực hiện việc trọng đại.</li>
                                <li>Xem giờ tốt: Ngoài chọn ngày, việc chọn giờ Hoàng đạo cũng quan trọng, nhất là khi xuất
                                    hành hoặc khai trương.</li>
                                <li>Ứng dụng trong phong thủy – tử vi: Đổi ngày giúp xác định tuổi hợp, hướng tốt, cũng như
                                    lập lá số tử vi chính xác.
                                </li>
                            </ul>
                            <p>Có thể nói, đổi ngày Âm sang Dương là nhịp cầu nối giữa truyền thống và hiện đại, giữa văn
                                hóa phương Đông và hành chính phương Tây.</p>
                            <div class="title-tong-quan-h4-log">Hướng Dẫn Sử Dụng Công Cụ Đổi Ngày Trên Phong Lịch</div>
                            <p>Tại <b>phonglich.com</b>, bạn có thể dễ dàng đổi ngày Âm sang Dương hoặc ngược lại chỉ trong
                                vài giây:</p>
                            <ul style="list-style-type: decimal">
                                <li>Chọn ngày cần đổi (theo Âm lịch hoặc Dương lịch).</li>
                                <li>
                                    Hệ thống tự động trả kết quả gồm:
                                    <ul style="list-style-type: disc;">
                                        <li>Ngày Âm/Dương tương ứng.</li>
                                        <li>Thông tin Can Chi, Tiết khí, ngày Hoàng đạo – Hắc đạo.</li>
                                        <li>Gợi ý ngày tốt, giờ tốt cho các công việc quan trọng.</li>
                                    </ul>
                                </li>
                                <li>Người dùng có thể tiếp tục tra cứu các công cụ liên quan như xem tử vi, xem phong thủy,
                                    chọn ngày hợp tuổi.</li>
                            </ul>

                            <p>Ưu điểm của công cụ tại Phong Lịch:</p>
                            <ul>
                                <li>Nhanh chóng – chính xác – miễn phí.</li>
                                <li>Giao diện thân thiện, dễ sử dụng trên cả máy tính và điện thoại.</li>
                                <li>Tích hợp nhiều tri thức cổ truyền (Âm lịch, Can Chi, Ngũ hành, Tử vi)</li>
                            </ul>
                            <div class="title-tong-quan-h4-log">Kết Luận</div>
                            <p>Trong đời sống hiện đại, việc đổi ngày Âm sang Dương và đổi ngày Dương sang Âm không chỉ giúp
                                chúng ta thuận tiện trong công việc mà còn giữ gìn bản sắc văn hóa truyền thống.</p>

                            <p>Với công cụ chuyển đổi lịch Âm Dương tại Phong Lịch, bạn có thể dễ dàng:</p>
                            <ul>
                                <li>Tra cứu Lịch Âm – Dương hằng ngày.</li>
                                <li>Biết được ngày Hoàng đạo, giờ tốt, Tiết khí.</li>
                                <li>Lên kế hoạch chính xác cho những sự kiện quan trọng trong đời.</li>
                            </ul>
                            <p>Trải nghiệm ngay công cụ Đổi ngày Âm – Dương trực tuyến tại Phonglich.com – nhanh chóng,
                                chính xác và miễn phí cho mọi người Việt.</p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3  col-sm-12 col-12 mb-3">
                <div class="d-flex flex-column gap-4 pt-2">



                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <div class="card-title-right">Sự kiện, ngày lễ sắp tới</div>



                        <div class="boxx--sukiensaptoi">
                            @foreach ($upcomingEvents as $event)
                                @php
                                    // Phân tích cú pháp ngày sự kiện một lần để lấy các phần tử năm, tháng, ngày
                                    $eventCarbonDate = Carbon\Carbon::parse($event['date']);
                                    $routeParams = [
                                        'nam' => $eventCarbonDate->year,
                                        'thang' => $eventCarbonDate->month,
                                        'ngay' => $eventCarbonDate->day,
                                    ];

                                    // Chuyển đổi sang âm lịch
                                    $lunarDate = App\Helpers\LunarHelper::convertSolar2Lunar(
                                        $eventCarbonDate->day,
                                        $eventCarbonDate->month,
                                        $eventCarbonDate->year,
                                    );
                                @endphp
                                <a class="hv-memorial-widget-root mt-3" href="{{ route('detai_home', $routeParams) }}">
                                    <div class="hv-memorial-date-panel">
                                        <div class="hv-memorial-month-text">Tháng
                                            {{ Carbon\Carbon::parse($event['date'])->format('n') }}</div>
                                        <div class="hv-memorial-day-digit">
                                            {{ Carbon\Carbon::parse($event['date'])->format('d') }}</div>
                                        <div class="hv-memorial-lunar-calendar-info">
                                            {{ $lunarDate[0] }}/{{ $lunarDate[1] }} ÂL</div>
                                    </div>
                                    <div class="hv-memorial-event-summary">
                                        <div class="hv-memorial-event-title">{{ $event['description'] }}</div>
                                        <div class="hv-memorial-countdown-display">
                                            @if ($event['days_remaining'] === 0)
                                                Hôm nay
                                            @elseif ($event['days_remaining'] === 1)
                                                Còn 1 ngày
                                            @else
                                                Còn {{ $event['days_remaining'] }} ngày
                                            @endif
                                            <!-- Sử dụng SVG cho mũi tên để có độ chính xác cao nhất về hình dáng -->
                                            <svg class="hv-memorial-countdown-arrow" viewBox="0 0 24 24" width="16"
                                                height="16" fill="currentColor">
                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
                                            </svg>
                                        </div>
                                    </div>

                                </a>
                            @endforeach



                        </div>






                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Mobile Date Popup -->
    <div id="mobileDatePopup" class="mobile-date-popup">
        <div class="mobile-popup-content">
            <div class="mobile-popup-header" id="mobilePopupTitle">
                Chọn ngày
            </div>
            <div class="row g-2" id="mobileSelectContainer">
                <div class="col-4">
                    <label class="form-label-sm">Ngày</label>
                    <select id="mobile-day" class="form-select form-select-sm">
                        <!-- Options will be populated by JS -->
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label-sm">Tháng</label>
                    <select id="mobile-month" class="form-select form-select-sm">
                        <!-- Options will be populated by JS -->
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label-sm">Năm</label>
                    <select id="mobile-year" class="form-select form-select-sm">
                        <!-- Options will be populated by JS -->
                    </select>
                </div>
            </div>
            <div class="row g-2 mt-2" id="mobile-lunar-leap-container" style="display: none !important;">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="mobile-lunar-leap-check">
                        <label class="form-check-label" for="mobile-lunar-leap-check">
                            Tháng nhuận
                        </label>
                    </div>
                </div>
            </div>
            <div class="mobile-popup-buttons">
                <button type="button" class="mobile-popup-btn cancel" id="mobileCancelBtn">
                    Hủy
                </button>
                <button type="button" class="mobile-popup-btn choose" id="mobileChooseBtn">
                    Chọn
                </button>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
         .form-select-sm{
        padding-right: 0 !important;
    }
        .date-input-wrapper .date-icon-custom {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #46494E;
        }

        .date-input {
            cursor: pointer;
            padding-right: 40px;
        }

        .date-select-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            z-index: 1050;
            padding: 15px;
            margin-top: 5px;
        }

        .form-label-sm {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .date-select-container {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                max-width: 400px;
            }

            /* Mobile popup styles */
            .mobile-date-popup {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9999;
                justify-content: center;
                align-items: center;
            }

            .mobile-popup-content {
                background: white;
                border-radius: 15px;
                padding: 25px 20px;
                width: 90%;
                max-width: 400px;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }

            .mobile-popup-header {
                text-align: center;
                margin-bottom: 20px;
                font-weight: 600;
                font-size: 18px;
                color: #2254AB;
            }

            .mobile-popup-buttons {
                display: flex;
                gap: 15px;
                margin-top: 25px;
            }

            .mobile-popup-btn {
                flex: 1;
                padding: 15px 10px;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .mobile-popup-btn.choose {
                background: #2254AB;
                color: white;
            }

            .mobile-popup-btn.choose:hover {
                background: #1e4a96;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(34, 84, 171, 0.3);
            }

            .mobile-popup-btn.cancel {
                background: #f8f9fa;
                color: #46494E;
                border: 2px solid #dee2e6;
            }

            .mobile-popup-btn.cancel:hover {
                background: #e9ecef;
                border-color: #adb5bd;
            }

            /* Hide default selects on mobile and show popup instead */
            @media (max-width: 768px) {
                .date-select-container {
                    display: none !important;
                }
            }
        }

    </style>
@endpush

@push('scripts')
    <script>
        // Utility function for debouncing
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Function to change day
        function changeDay(days) {
            const solarInput = document.getElementById('solar_date');
            let currentDate = solarInput.value;

            // If no current date, use today as fallback
            if (!currentDate) {
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                currentDate = `${dd}/${mm}/${yyyy}`;
            }

            const parts = currentDate.split('/');
            if (parts.length === 3) {
                const day = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1;
                const year = parseInt(parts[2], 10);
                const date = new Date(year, month, day);

                // Add/subtract days
                date.setDate(date.getDate() + days);

                // Format the new date
                const newDay = String(date.getDate()).padStart(2, '0');
                const newMonth = String(date.getMonth() + 1).padStart(2, '0');
                const newYear = date.getFullYear();
                const newDateStr = `${newDay}/${newMonth}/${newYear}`;

                // Create a form and submit to /doi-ngay-am-duong
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/doi-ngay-am-duong';

                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Add solar date input - chỉ gửi solar_date
                const solarDateInput = document.createElement('input');
                solarDateInput.type = 'hidden';
                solarDateInput.name = 'solar_date';
                solarDateInput.value = newDateStr;
                form.appendChild(solarDateInput);

                // Append to body and submit
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Global conversion functions
        window.convertSolarToLunar = async function(solarDate) {
            try {
                // Parse the date format (dd/mm/yyyy)
                const parts = solarDate.split('/');

                if (parts.length !== 3) {
                    return null;
                }

                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);

                const response = await fetch('/api/convert-solar-to-lunar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        solarDay: day,
                        solarMonth: month,
                        solarYear: year
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.success) {
                        let result = `${String(data.lunarDay).padStart(2, '0')}/${String(data.lunarMonth).padStart(2, '0')}/${data.lunarYear}`;

                        // Check if this is a leap month (if API provides this info)
                        if (data.isLeap) {
                            const parts = result.split('/');
                            result = `${parts[0]}/${parts[1]}(nhuận)/${parts[2]}`;
                        }

                        return result;
                    }
                } else {
                    const errorData = await response.json();
                }
            } catch (error) {
            }
            return null;
        };

        window.convertLunarToSolar = async function(lunarDate, isLeap = false) {
            try {
                // Parse the date format (dd/mm/yyyy or dd/mm(nhuận)/yyyy)
                const cleanDate = lunarDate.replace('(nhuận)', '');
                const parts = cleanDate.split('/');

                if (parts.length !== 3) {
                    return null;
                }

                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);

                const response = await fetch('/api/convert-lunar-to-solar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        lunarDay: day,
                        lunarMonth: month,
                        lunarYear: year,
                        isLeap: isLeap ? 1 : 0
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.success) {
                        return `${String(data.solarDay).padStart(2, '0')}/${String(data.solarMonth).padStart(2, '0')}/${data.solarYear}`;
                    }
                } else {
                    const errorData = await response.json();
                }
            } catch (error) {
            }
            return null;
        };

        // Helper functions
        window.convertToApiFormat = function(dateStr) {
            const parts = dateStr.split('/');
            if (parts.length === 3) {
                const [day, month, year] = parts;
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            }
            return dateStr;
        };

        window.convertFromApiFormat = function(dateStr) {
            const parts = dateStr.split('-');
            if (parts.length === 3) {
                const [year, month, day] = parts;
                return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
            }
            return dateStr;
        };

        window.formatDate = function(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        };

        // Global functions for date select operations
        window.showDateSelect = async function(type) {

            // Check if mobile
            if (window.innerWidth <= 768) {
                showMobileDatePopup(type);
                return;
            }


            const container = document.getElementById(type + '-select-container');
            const dateField = document.getElementById(type + '_date');

            if (!container || !dateField) {
                return;
            }

            // Hide other open selects
            const allContainers = document.querySelectorAll('.date-select-container');
            allContainers.forEach(c => {
                if (c.id !== type + '-select-container') {
                    c.style.display = 'none';
                }
            });

            // Show current select
            container.style.display = 'block';

            // Populate select options based on current input value or today
            const currentValue = dateField.value || formatDate(new Date());
            await populateSelects(type, currentValue);
        };

        window.hideDateSelect = function(type) {
            const container = document.getElementById(type + '-select-container');
            container.style.display = 'none';
        };

        // Mobile popup functions
        let currentMobileType = '';

        window.showMobileDatePopup = async function(type) {

            currentMobileType = type;

            const popup = document.getElementById('mobileDatePopup');
            const title = document.getElementById('mobilePopupTitle');
            const mobileInput = document.getElementById(type + '_date');


            // Set title
            title.textContent = type === 'solar' ? 'Chọn ngày dương lịch' : 'Chọn ngày âm lịch';

            // Get current date value - use a proper default
            let currentValue = mobileInput ? mobileInput.value : '';
            if (!currentValue) {
                // If no value, use today as default
                const today = new Date();
                currentValue = `${String(today.getDate()).padStart(2, '0')}/${String(today.getMonth() + 1).padStart(2, '0')}/${today.getFullYear()}`;
            }


            // Populate mobile selects
            await populateMobileSelects(type, currentValue);

            // Show popup
            popup.style.display = 'flex';
            document.body.classList.add('menu-open');
            document.body.style.overflow = 'hidden'; // Prevent background scroll

        };

        window.hideMobileDatePopup = function() {
            const popup = document.getElementById('mobileDatePopup');
            popup.style.display = 'none';
            document.body.classList.remove('menu-open');
            document.body.style.overflow = 'auto';
            currentMobileType = '';
        };

        window.populateMobileSelects = async function(type, dateValue) {
            // Check if this is a leap month first
            const isCurrentlyLeap = dateValue.includes('(nhuận)');

            // Clean the date value for parsing
            const cleanDateValue = dateValue.replace('(nhuận)', '');
            const parts = cleanDateValue.split('/');
            const currentDay = parseInt(parts[0]) || 1;
            const currentMonth = parseInt(parts[1]) || 1;
            const currentYear = parseInt(parts[2]) || new Date().getFullYear();

            // Populate mobile month select
            const monthSelect = document.getElementById('mobile-month');

            // Hiển thị loading ngay khi bắt đầu populate
            monthSelect.innerHTML = '<option>Đang tải...</option>';

            // For lunar calendar, add leap months if they exist in the year
            if (type === 'lunar') {
                const leapMonths = await getLeapMonthsInYear(currentYear);

                // Clear loading và rebuild
                monthSelect.innerHTML = '';

                for (let i = 1; i <= 12; i++) {
                    // Add regular month
                    const option = document.createElement('option');
                    option.value = i;
                    option.dataset.isLeap = '0';
                    option.textContent = `${i}`;
                    if (i === currentMonth && !isCurrentlyLeap) option.selected = true;
                    monthSelect.appendChild(option);

                    // Add leap month if it exists
                    if (leapMonths.includes(i)) {
                        const leapOption = document.createElement('option');
                        leapOption.value = i;
                        leapOption.dataset.isLeap = '1';
                        leapOption.textContent = `${i} nhuận`;
                        leapOption.style.color = '#d83131';
                        if (i === currentMonth && isCurrentlyLeap) leapOption.selected = true;
                        monthSelect.appendChild(leapOption);
                    }
                }
            } else {
                // For solar calendar, just add regular months
                // Clear loading và rebuild
                monthSelect.innerHTML = '';

                for (let i = 1; i <= 12; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `${i}`;
                    if (i === currentMonth) option.selected = true;
                    monthSelect.appendChild(option);
                }
            }

            // Populate mobile year select - chỉ hiển thị năm hiện tại ban đầu
            const yearSelect = document.getElementById('mobile-year');
            yearSelect.innerHTML = '';

            // Chỉ thêm năm hiện tại ban đầu
            const option = document.createElement('option');
            option.value = currentYear;
            option.textContent = currentYear;
            option.selected = true;
            yearSelect.appendChild(option);

            // Thêm event listener để tải thêm năm khi click
            let mobileYearsLoaded = false;
            yearSelect.addEventListener('focus', function() {
                if (mobileYearsLoaded) return;
                mobileYearsLoaded = true;

                // Hiển thị đang tải
                this.innerHTML = '<option>Đang tải...</option>';

                // Tải đầy đủ sau một chút delay để user thấy loading
                setTimeout(() => {
                    this.innerHTML = '';
                    const currentYearFull = new Date().getFullYear();
                    for (let i = 1900; i <= 2100; i++) {
                        const opt = document.createElement('option');
                        opt.value = i;
                        opt.textContent = i;
                        if (i === currentYear) opt.selected = true;
                        this.appendChild(opt);
                    }
                }, 100);
            });

            // Checkbox is always hidden - no need for leap month checkbox logic

            // Populate mobile day select - simplified version
            await populateMobileDays(type, currentMonth, currentYear, currentDay);
        };

        // Mobile checkbox is always hidden - this function is no longer needed

        // Simplified function to populate mobile days
        window.populateMobileDays = async function(type, month, year, selectedDay) {
            const daySelect = document.getElementById('mobile-day');
            daySelect.innerHTML = '<option>Đang tải...</option>';

            let maxDay;
            if (type === 'lunar') {
                // Check if leap month is selected
                let isLeap = false;

                // First check if current month select option has leap data
                const mobileMonthSelect = document.getElementById('mobile-month');
                if (mobileMonthSelect && mobileMonthSelect.selectedIndex >= 0) {
                    const selectedOption = mobileMonthSelect.options[mobileMonthSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.isLeap === '1') {
                        isLeap = true;
                    }
                }

                // Fallback to checkbox
                if (!isLeap) {
                    const mobileLeapCheckbox = document.getElementById('mobile-lunar-leap-check');
                    isLeap = mobileLeapCheckbox && mobileLeapCheckbox.checked;
                }

                // Use API to get accurate lunar month days
                maxDay = await getDaysInMonth(month, year, true, isLeap);
            } else {
                // For solar calendar
                maxDay = new Date(year, month, 0).getDate();
            }

            // Clear and populate days
            daySelect.innerHTML = '';
            for (let i = 1; i <= maxDay; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                if (i === selectedDay) option.selected = true;
                daySelect.appendChild(option);
            }
        };

        window.updateMobileDayOptions = async function(type, month, year, selectedDay) {
            await populateMobileDays(type, month, year, selectedDay);
        };

        // Function cập nhật input và auto-convert sang lịch khác
        window.applyDateSelect = async function(type) {
            const day = document.getElementById(type + '-day').value;
            const monthSelect = document.getElementById(type + '-month');
            const month = monthSelect.value;
            const year = document.getElementById(type + '-year').value;

            if (day && month && year) {
                // Check for leap month if this is lunar calendar
                let isLeap = false;
                if (type === 'lunar') {
                    // Check if selected month option has leap data
                    const selectedOption = monthSelect.options[monthSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.isLeap === '1') {
                        isLeap = true;
                    } else {
                        // Fallback to checkbox
                        const leapCheckbox = document.getElementById('lunar-leap-check');
                        isLeap = leapCheckbox && leapCheckbox.checked;
                    }
                }

                const formattedDate = `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;
                const dateInput = document.getElementById(type + '_date');

                // Add leap indication to the display
                if (type === 'lunar' && isLeap) {
                    // Format: dd/mm(nhuận)/yyyy
                    const parts = formattedDate.split('/');
                    dateInput.value = `${parts[0]}/${parts[1]}(nhuận)/${parts[2]}`;
                } else {
                    dateInput.value = formattedDate;
                }

                // Set leap flag in hidden form field
                const formLeapInput = document.getElementById('form-is-leap');
                if (formLeapInput) {
                    formLeapInput.value = isLeap ? '1' : '0';
                }

                // Hide the select container
                hideDateSelect(type);

                // Auto-convert to opposite calendar
                try {
                    let convertedDate = null;

                    if (type === 'lunar') {
                        // Convert lunar to solar
                        convertedDate = await convertLunarToSolar(formattedDate, isLeap);

                        if (convertedDate) {
                            const solarInput = document.getElementById('solar_date');
                            if (solarInput) {
                                solarInput.value = convertedDate;
                            }
                        }
                    } else {
                        // Convert solar to lunar
                        convertedDate = await convertSolarToLunar(formattedDate);

                        if (convertedDate) {
                            const lunarInput = document.getElementById('lunar_date');
                            if (lunarInput) {
                                lunarInput.value = convertedDate;
                            }
                        }
                    }
                } catch (error) {
                }

            }
        };

        window.populateSelects = async function(type, dateValue) {
            // Check if this is a leap month first
            const isCurrentlyLeap = dateValue.includes('(nhuận)');

            // Clean the date value for parsing
            const cleanDateValue = dateValue.replace('(nhuận)', '');
            const parts = cleanDateValue.split('/');
            const currentDay = parseInt(parts[0]) || 1;
            const currentMonth = parseInt(parts[1]) || 1;
            const currentYear = parseInt(parts[2]) || new Date().getFullYear();

            // Populate month select first
            const monthSelect = document.getElementById(type + '-month');
            if (!monthSelect) {
                return;
            }

            // Hiển thị loading ngay khi bắt đầu populate
            monthSelect.innerHTML = '<option>Đang tải...</option>';

            // For lunar calendar, add leap months if they exist in the year
            if (type === 'lunar') {
                const leapMonths = await getLeapMonthsInYear(currentYear);

                // Clear loading và rebuild
                monthSelect.innerHTML = '';

                for (let i = 1; i <= 12; i++) {
                    // Add regular month
                    const option = document.createElement('option');
                    option.value = i;
                    option.dataset.isLeap = '0';
                    option.textContent = `${i}`;
                    if (i === currentMonth && !isCurrentlyLeap) option.selected = true;
                    monthSelect.appendChild(option);

                    // Add leap month if it exists
                    if (leapMonths.includes(i)) {
                        const leapOption = document.createElement('option');
                        leapOption.value = i;
                        leapOption.dataset.isLeap = '1';
                        leapOption.textContent = `${i} nhuận`;
                        leapOption.style.color = '#d83131';
                        if (i === currentMonth && isCurrentlyLeap) leapOption.selected = true;
                        monthSelect.appendChild(leapOption);
                    }
                }
            } else {
                // For solar calendar, just add regular months
                // Clear loading và rebuild
                monthSelect.innerHTML = '';

                for (let i = 1; i <= 12; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `${i}`;
                    if (i === currentMonth) option.selected = true;
                    monthSelect.appendChild(option);
                }
            }

            // Populate year select - chỉ hiển thị năm hiện tại ban đầu
            const yearSelect = document.getElementById(type + '-year');
            if (!yearSelect) {
                return;
            }
            // Không cần loading cho year vì chỉ 1 option
         

            // Chỉ thêm năm hiện tại ban đầu
            const option = document.createElement('option');
            option.value = currentYear;
            option.textContent = currentYear;
            option.selected = true;
            yearSelect.appendChild(option);

            // Thêm event listener để tải thêm năm khi click
            let yearsLoaded = false;
            yearSelect.addEventListener('focus', function() {
                if (yearsLoaded) return;
                yearsLoaded = true;

                // Hiển thị đang tải
                this.innerHTML = '<option>Đang tải...</option>';

                // Tải đầy đủ sau một chút delay để user thấy loading
                setTimeout(() => {
                    this.innerHTML = '';
                    const currentYearFull = new Date().getFullYear();
                    for (let i = currentYearFull - 100; i <= currentYearFull + 10; i++) {
                        const opt = document.createElement('option');
                        opt.value = i;
                        opt.textContent = i;
                        if (i === currentYear) opt.selected = true;
                        this.appendChild(opt);
                    }
                }, 100);
            });

            // Checkbox is always hidden - no need for leap month checkbox logic

            // Populate day select based on selected month and year
            await updateDayOptions(type, currentMonth, currentYear, currentDay);

            // Add event listeners to update days when month or year changes
            monthSelect.addEventListener('change', async function() {
                const selectedOption = this.options[this.selectedIndex];
                const selectedMonth = parseInt(this.value);
                const selectedYear = parseInt(yearSelect.value);
                const selectedDay = parseInt(document.getElementById(type + '-day').value) || 1;

                // For lunar calendar, handle leap month selection
                if (type === 'lunar') {
                    const isLeap = selectedOption.dataset.isLeap === '1';

                    // Update leap checkbox to match selection
                    const leapCheckbox = document.getElementById('lunar-leap-check');
                    const leapContainer = document.getElementById('lunar-leap-container');

                    if (leapCheckbox) {
                        leapCheckbox.checked = isLeap;
                    }

                    // Checkbox is always hidden - no need to show/hide
                }

                await updateDayOptions(type, selectedMonth, selectedYear, selectedDay);
            });

            yearSelect.addEventListener('change', async function() {
                const selectedMonth = parseInt(monthSelect.value);
                const selectedYear = parseInt(this.value);
                const selectedDay = parseInt(document.getElementById(type + '-day').value) || 1;

                // For lunar calendar, rebuild month select with new year's leap months
                if (type === 'lunar') {
                    // Hiển thị loading
                    monthSelect.innerHTML = '<option>Đang tải...</option>';

                    const leapMonths = await getLeapMonthsInYear(selectedYear);

                    // Clear and rebuild month select
                    monthSelect.innerHTML = '';
                    for (let i = 1; i <= 12; i++) {
                        // Add regular month
                        const option = document.createElement('option');
                        option.value = i;
                        option.dataset.isLeap = '0';
                        option.textContent = `Tháng ${i}`;
                        if (i === selectedMonth) option.selected = true;
                        monthSelect.appendChild(option);

                        // Add leap month if it exists
                        if (leapMonths.includes(i)) {
                            const leapOption = document.createElement('option');
                            leapOption.value = i;
                            leapOption.dataset.isLeap = '1';
                            leapOption.textContent = `Tháng ${i} nhuận`;
                            leapOption.style.color = '#d83131';
                            monthSelect.appendChild(leapOption);
                        }
                    }

                }

                await updateDayOptions(type, selectedMonth, selectedYear, selectedDay);
            });
        };

        // Cache for leap months by year
        window.leapMonthsCache = {};

        // Function to get leap months for a given year - New optimized version
        window.getLeapMonthsInYear = async function(year) {
            // Check cache first
            if (window.leapMonthsCache[year]) {
                return window.leapMonthsCache[year];
            }

            try {

                // Use new optimized API that gets all months in one call
                const response = await fetch('/api/get-year-leap-months', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        year: year
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.success) {
                        // Cache both leap months array and full data for potential future use
                        window.leapMonthsCache[year] = data.leapMonths;

                        // Also cache the full month data for getDaysInMonth optimization
                        if (!window.yearMonthDataCache) window.yearMonthDataCache = {};
                        window.yearMonthDataCache[year] = data.allMonthsData;

                        return data.leapMonths;
                    }
                } else {
                }
            } catch (error) {
            }

            // Fallback: return empty array if API fails
            window.leapMonthsCache[year] = [];
            return [];
        };

        // Checkbox is always hidden - this function is no longer needed

        // Helper function to get the number of days in a month
        window.getDaysInMonth = async function(month, year, isLunar = false, isLeap = false) {
            

            if (isLunar) {
                // Check if we have cached data from getYearLeapMonths API
                if (window.yearMonthDataCache && window.yearMonthDataCache[year] && window.yearMonthDataCache[year][month]) {
                    const cachedData = window.yearMonthDataCache[year][month];
                   

                    if (isLeap) {
                        const days = cachedData.leapDays > 0 ? cachedData.leapDays : cachedData.regularDays;
                      
                        return days;
                    } else {
                      
                        return cachedData.regularDays;
                    }
                }

                // Use API to get accurate lunar month days calculation
                try {
                    const response = await fetch('/api/get-lunar-month-days', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            month: parseInt(month),
                            year: parseInt(year),
                            isLeap: isLeap ? 1 : 0
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        return data.days || 29;
                    } else {
                    }
                } catch (error) {
                }

                // Fallback to 29 if API fails
                return 29;
            }

            // Solar calendar days per month
            return new Date(year, month, 0).getDate();
        };

        // Helper function to update day options based on selected month and year
        window.updateDayOptions = async function(type, month, year, selectedDay) {
            const daySelect = document.getElementById(type + '-day');
            if (!daySelect) {
                return;
            }
            const isLunar = type === 'lunar';

            // Check if leap month is selected
            let isLeap = false;
            if (isLunar) {
                // First check if current month select option has leap data
                const monthSelect = document.getElementById(type + '-month');
                if (monthSelect && monthSelect.selectedIndex >= 0) {
                    const selectedOption = monthSelect.options[monthSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.isLeap === '1') {
                        isLeap = true;
                    }
                }

                // Fallback to checkbox
                if (!isLeap) {
                    const leapCheckbox = document.getElementById('lunar-leap-check');
                    isLeap = leapCheckbox && leapCheckbox.checked;
                }
            }

            // Show loading state
            daySelect.innerHTML = '<option>Đang tải...</option>';

            const maxDay = await getDaysInMonth(month, year, isLunar, isLeap);

            // Clear existing options
            daySelect.innerHTML = '';

            // Add day options
            for (let i = 1; i <= maxDay; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;

                // Select the current day if it's valid, otherwise select the last valid day
                if (i === selectedDay && selectedDay <= maxDay) {
                    option.selected = true;
                } else if (selectedDay > maxDay && i === maxDay) {
                    option.selected = true;
                }

                daySelect.appendChild(option);
            }
        };


        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            let isUpdating = false; // Prevent infinite loops

            // Cache DOM elements to avoid repeated queries
            const domCache = {
                solarInput: document.getElementById('solar_date'),
                lunarInput: document.getElementById('lunar_date'),
                swapBtn: document.getElementById('swapDatesBtn'),
                solarContainer: document.getElementById('solar-container'),
                lunarContainer: document.getElementById('lunar-container'),
                solarDisplayContainer: document.getElementById('solar-display-container'),
                lunarDisplayContainer: document.getElementById('lunar-display-container')
            };

            const {solarInput, lunarInput, swapBtn, solarContainer, lunarContainer, solarDisplayContainer, lunarDisplayContainer} = domCache;

            // Function to swap content inside result boxes
            const swapContentOnly = (immediate = false) => {
                const inputRow = solarContainer.parentNode;
                const swapIcon = swapBtn.querySelector('img');

                const doTheSwap = () => {
                    // Use DocumentFragment to minimize reflows during DOM manipulations
                    const fragment = document.createDocumentFragment();

                    // Batch DOM operations to prevent forced reflows
                    requestAnimationFrame(() => {
                        // Swap input positions (keep existing logic for inputs)
                        const solarInputFirst = Array.from(inputRow.children).indexOf(solarContainer) < Array
                            .from(inputRow.children).indexOf(lunarContainer);
                        if (solarInputFirst) {
                            inputRow.insertBefore(lunarContainer, solarContainer);
                        } else {
                            inputRow.insertBefore(solarContainer, lunarContainer);
                        }

                        // Cache display box queries
                        const solarBox = solarDisplayContainer.querySelector('.date-display-card');
                        const lunarBox = lunarDisplayContainer.querySelector('.date-display-card');

                        if (solarBox && lunarBox) {
                            // Get the center content only (exclude navigation buttons and status)
                            const solarCenter = solarBox.querySelector('.text-center');
                            const lunarCenter = lunarBox.querySelector('.text-center');

                            if (solarCenter && lunarCenter) {
                                // Get current center content
                                const solarCenterContent = solarCenter.innerHTML;
                                const lunarCenterContent = lunarCenter.innerHTML;

                                // Swap only the center content
                                solarCenter.innerHTML = lunarCenterContent;
                                lunarCenter.innerHTML = solarCenterContent;
                            }
                        }
                    });
                };

                if (immediate) {
                    doTheSwap();
                } else {
                    if (swapIcon) swapIcon.style.transform = 'rotate(180deg)';
                    setTimeout(() => {
                        doTheSwap();
                        if (swapIcon) swapIcon.style.transform = 'rotate(0deg)';
                    }, 200);
                }
            };

            // On swap button click
            swapBtn.addEventListener('click', function() {
                let currentState = localStorage.getItem('converterSwapState') || 'solar-first';
                let newState = (currentState === 'solar-first') ? 'lunar-first' : 'solar-first';
                localStorage.setItem('converterSwapState', newState);
                swapContentOnly();
            });

            // On page load, check and apply saved state
            const savedState = localStorage.getItem('converterSwapState');
            if (savedState === 'lunar-first') {
                // The default is solar-first, so we need to swap if the saved state is lunar-first
                swapContentOnly(true); // immediate swap
            }


            // Set default value cho inputs
            @if (request()->isMethod('post') && (request()->has('solar_date') || request()->has('lunar_date')))
                // Có request từ form submit - hiển thị ngày được chọn
                const solarDateFromController = '{{ $dd }}/{{ $mm }}/{{ $yy }}';
                const lunarDateFromController =
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}@if($is_leap_month_selected)(nhuận)@endif/{{ $al[2] }}';

                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;
            @else
                // GET request hoặc tải trang lần đầu - hiển thị ngày hôm nay từ controller
                const solarDateFromController =
                    '{{ sprintf('%02d', $dd) }}/{{ sprintf('%02d', $mm) }}/{{ $yy }}';
                const lunarDateFromController =
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}@if($is_leap_month_selected)(nhuận)@endif/{{ $al[2] }}';

                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;
            @endif

            // Function to check if device is mobile
            function isMobile() {
                return window.innerWidth <= 768;
            }

            // Add click handlers for inputs - click-only behavior for both mobile and desktop
            solarInput.addEventListener('click', async function(e) {
                e.preventDefault();
                await showDateSelect('solar');
            });

            lunarInput.addEventListener('click', async function(e) {
                e.preventDefault();
                await showDateSelect('lunar');
            });

            // Remove touchstart handlers as they're redundant with click

            // Hide select containers when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.date-input-wrapper')) {
                    document.querySelectorAll('.date-select-container').forEach(container => {
                        container.style.display = 'none';
                    });
                }
            });

            // Mobile popup event listeners
            const mobileCancelBtn = document.getElementById('mobileCancelBtn');
            const mobileChooseBtn = document.getElementById('mobileChooseBtn');

            if (mobileCancelBtn) {
                mobileCancelBtn.addEventListener('click', function() {
                    hideMobileDatePopup();
                });
            }

            if (mobileChooseBtn) {
                mobileChooseBtn.addEventListener('click', async function() {
                    const day = document.getElementById('mobile-day').value;
                    const monthSelect = document.getElementById('mobile-month');
                    const month = monthSelect.value;
                    const year = document.getElementById('mobile-year').value;

                    if (day && month && year && currentMobileType) {
                        // Check for leap month if this is lunar calendar
                        let isLeap = false;
                        if (currentMobileType === 'lunar') {
                            // Check if selected month option has leap data
                            const selectedOption = monthSelect.options[monthSelect.selectedIndex];
                            if (selectedOption && selectedOption.dataset.isLeap === '1') {
                                isLeap = true;
                            } else {
                                // Fallback to checkbox
                                const mobileLeapCheckbox = document.getElementById('mobile-lunar-leap-check');
                                isLeap = mobileLeapCheckbox && mobileLeapCheckbox.checked;
                            }
                        }

                        const formattedDate =
                            `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;

                        // Set value in input field BEFORE hiding popup
                        const targetInputId = currentMobileType + '_date';
                        const targetInput = document.getElementById(targetInputId);

                        if (targetInput) {
                            let finalValue;
                            if (currentMobileType === 'lunar' && isLeap) {
                                // Format: dd/mm(nhuận)/yyyy
                                const parts = formattedDate.split('/');
                                finalValue = `${parts[0]}/${parts[1]}(nhuận)/${parts[2]}`;
                            } else {
                                finalValue = formattedDate;
                            }

                            // Force update input value using multiple methods
                            targetInput.value = finalValue;
                            targetInput.setAttribute('value', finalValue);

                            // Trigger multiple events to ensure update
                            targetInput.dispatchEvent(new Event('input', { bubbles: true }));
                            targetInput.dispatchEvent(new Event('change', { bubbles: true }));
                            targetInput.dispatchEvent(new Event('keyup', { bubbles: true }));

                            // Visual feedback
                        

                            // Force DOM update
                            targetInput.focus();
                            targetInput.blur();

                        }

                        // Set leap flag in hidden form field
                        const formLeapInput = document.getElementById('form-is-leap');
                        if (formLeapInput) {
                            formLeapInput.value = isLeap ? '1' : '0';
                        }

                        // Preserve the type before hiding popup (since hideMobileDatePopup clears currentMobileType)
                        const selectedType = currentMobileType;

                        // Hide popup first
                        hideMobileDatePopup();

                        // Wait a bit for popup to close completely, then auto-convert
                        setTimeout(async () => {
                            try {
                                let convertedDate = null;

                                if (selectedType === 'lunar') {
                                    // User selected lunar date, convert to solar
                                    const lunarDateForConversion = isLeap ? `${day}/${month}(nhuận)/${year}` : formattedDate;
                                    convertedDate = await convertLunarToSolar(lunarDateForConversion, isLeap);

                                    if (convertedDate) {
                                        const solarInput = document.getElementById('solar_date');
                                        if (solarInput) {
                                            solarInput.value = convertedDate;
                                            solarInput.setAttribute('value', convertedDate);

                                           
                                        }
                                    }
                                } else {
                                    // User selected solar date, convert to lunar
                                    convertedDate = await convertSolarToLunar(formattedDate);

                                    if (convertedDate) {
                                        const lunarInput = document.getElementById('lunar_date');
                                        if (lunarInput) {
                                            lunarInput.value = convertedDate;
                                            lunarInput.setAttribute('value', convertedDate);

                                        }
                                    }
                                }

                            } catch (error) {
                                // Handle error silently
                            }
                        }, 100);
                    }
                });
            }

            // Close popup when clicking outside
            const mobilePopup = document.getElementById('mobileDatePopup');
            if (mobilePopup) {
                mobilePopup.addEventListener('click', function(e) {
                    if (e.target === mobilePopup) {
                        hideMobileDatePopup();
                    }
                });
            }

            // Add event listeners for mobile selects
            const mobileMonthSelect = document.getElementById('mobile-month');
            const mobileYearSelect = document.getElementById('mobile-year');

            if (mobileMonthSelect) {
                mobileMonthSelect.addEventListener('change', async function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const selectedMonth = parseInt(this.value);
                    const selectedYear = parseInt(mobileYearSelect.value);
                    const selectedDay = parseInt(document.getElementById('mobile-day').value) || 1;

                    // For lunar calendar, handle leap month selection
                    if (currentMobileType === 'lunar') {
                        const isLeap = selectedOption.dataset.isLeap === '1';

                        // Update mobile leap checkbox to match selection
                        const mobileLeapCheckbox = document.getElementById('mobile-lunar-leap-check');
                        const mobileLeapContainer = document.getElementById('mobile-lunar-leap-container');

                        if (mobileLeapCheckbox) {
                            mobileLeapCheckbox.checked = isLeap;
                        }

                        // Checkbox is always hidden - no need to show/hide
                    }

                    await updateMobileDayOptions(currentMobileType, selectedMonth, selectedYear,
                        selectedDay);
                });
            }

            if (mobileYearSelect) {
                mobileYearSelect.addEventListener('change', async function() {
                    const selectedMonth = parseInt(mobileMonthSelect.value);
                    const selectedYear = parseInt(this.value);
                    const selectedDay = parseInt(document.getElementById('mobile-day').value) || 1;

                    // For lunar calendar, rebuild month select with new year's leap months
                    if (currentMobileType === 'lunar') {
                        // Hiển thị loading
                        mobileMonthSelect.innerHTML = '<option>Đang tải...</option>';

                        const leapMonths = await getLeapMonthsInYear(selectedYear);

                        // Clear and rebuild month select
                        mobileMonthSelect.innerHTML = '';
                        for (let i = 1; i <= 12; i++) {
                            // Add regular month
                            const option = document.createElement('option');
                            option.value = i;
                            option.dataset.isLeap = '0';
                            option.textContent = `${i}`;
                            if (i === selectedMonth) option.selected = true;
                            mobileMonthSelect.appendChild(option);

                            // Add leap month if it exists
                            if (leapMonths.includes(i)) {
                                const leapOption = document.createElement('option');
                                leapOption.value = i;
                                leapOption.dataset.isLeap = '1';
                                leapOption.textContent = `${i} nhuận`;
                                leapOption.style.color = '#d83131';
                                mobileMonthSelect.appendChild(leapOption);
                            }
                        }

                    }

                    await updateMobileDayOptions(currentMobileType, selectedMonth, selectedYear,
                        selectedDay);
                });
            }

            // Add event listener for leap month checkbox to update days
            const lunarLeapCheckbox = document.getElementById('lunar-leap-check');
            const mobileLeapCheckbox = document.getElementById('mobile-lunar-leap-check');

            if (lunarLeapCheckbox) {
                lunarLeapCheckbox.addEventListener('change', async function() {
                    const monthSelect = document.getElementById('lunar-month');
                    const yearSelect = document.getElementById('lunar-year');
                    const daySelect = document.getElementById('lunar-day');

                    if (monthSelect && yearSelect && daySelect) {
                        const selectedMonth = parseInt(monthSelect.value);
                        const selectedYear = parseInt(yearSelect.value);
                        const selectedDay = parseInt(daySelect.value) || 1;

                        await updateDayOptions('lunar', selectedMonth, selectedYear, selectedDay);
                    }
                });
            }

            if (mobileLeapCheckbox) {
                mobileLeapCheckbox.addEventListener('change', async function() {
                    if (currentMobileType === 'lunar') {
                        const monthSelect = document.getElementById('mobile-month');
                        const yearSelect = document.getElementById('mobile-year');
                        const daySelect = document.getElementById('mobile-day');

                        if (monthSelect && yearSelect && daySelect) {
                            const selectedMonth = parseInt(monthSelect.value);
                            const selectedYear = parseInt(yearSelect.value);
                            const selectedDay = parseInt(daySelect.value) || 1;

                            await updateMobileDayOptions('lunar', selectedMonth, selectedYear, selectedDay);
                        }
                    }
                });
            }

            // Add event listeners for PC navigation buttons - use cached elements
            const pcPrevBtn = document.getElementById('pc-prev-btn');
            const pcNextBtn = document.getElementById('pc-next-btn');

            if (pcPrevBtn) {
                pcPrevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    changeDay(-1);
                });
            }

            if (pcNextBtn) {
                pcNextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    changeDay(1);
                });
            }

            // Add event listeners for mobile navigation buttons - use cached elements
            const mobilePrevBtn = document.getElementById('mobile-prev-btn');
            const mobileNextBtn = document.getElementById('mobile-next-btn');

            if (mobilePrevBtn) {
                // Use passive event listeners and debouncing for mobile
                const debouncedPrev = debounce(() => changeDay(-1), 100);
                mobilePrevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    debouncedPrev();
                }, {passive: false});
            }

            if (mobileNextBtn) {
                // Use passive event listeners and debouncing for mobile
                const debouncedNext = debounce(() => changeDay(1), 100);
                mobileNextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    debouncedNext();
                }, {passive: false});
            }

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthSelect = document.getElementById('month-select');
            const yearSelect = document.getElementById('year-select');
            const calendarBodyContainer = document.getElementById('calendar-body-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), delay);
                };
            }

            function updateCalendar() {
                const month = monthSelect.value;
                const year = yearSelect.value;
                const calendarTable = document.querySelector('.calendar-wrapper .calendar-table');

                // Disable calendar table during loading
                if (calendarTable) calendarTable.style.pointerEvents = 'none';

                // No need to update title here as it's handled in event listeners

                fetch('{{ route('lich.thang.ajax') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            nam: year,
                            thang: month
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.table_html) {
                            // Use requestAnimationFrame for DOM updates to prevent forced reflows
                            requestAnimationFrame(() => {
                                const tbody = calendarBodyContainer.querySelector('tbody');
                                if (tbody) {
                                    tbody.innerHTML = data.table_html;
                                }
                            });
                        }
                    })
                    .catch(error => {})
                    .finally(() => {
                        // Re-enable calendar table after loading complete
                        if (calendarTable) calendarTable.style.pointerEvents = 'auto';
                    });
            }

            const debouncedUpdateCalendar = debounce(updateCalendar, 300);

            // Function to update title only
            function updateTitle(month, year) {
                const titleElement = document.querySelector('.calendar-header-convert .lich-van--nien');
                if (titleElement) {
                    titleElement.textContent = `Lịch vạn niên ${year} - tháng ${month}`;
                }
            }

            // Combined event handlers for month/year changes
            monthSelect.addEventListener('change', () => {
                updateTitle(monthSelect.value, yearSelect.value);
                debouncedUpdateCalendar();
            });
            yearSelect.addEventListener('change', () => {
                updateTitle(monthSelect.value, yearSelect.value);
                debouncedUpdateCalendar();
            });
            const select = document.getElementById('year-select');
            const start = 1900;
            const end = 2100;
            const current = {{ $yy }};
            let fullyLoaded = false;

            select.addEventListener('focus', () => {
                if (fullyLoaded) return; // chỉ load đầy đủ 1 lần
                fullyLoaded = true;

                // Lưu vị trí scroll hiện tại
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

                // Xóa tất cả options hiện tại
                select.innerHTML = '';

                // Use DocumentFragment để tối ưu performance
                const fragment = document.createDocumentFragment();

                // Lặp từ năm mới nhất → năm cũ nhất
                for (let i = end; i >= start; i--) {
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = `Năm ${i}`;
                    if (i === current) {
                        opt.selected = true;
                    }
                    fragment.appendChild(opt);
                }

                // Append tất cả options cùng lúc
                select.appendChild(fragment);

                // Khôi phục vị trí scroll
                window.scrollTo(scrollLeft, scrollTop);
            });
        });
    </script>
@endpush
