@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <span
                >Đổi ngày âm dương </span></h6>
        <h1 class="content-title-home-lich">Đổi Ngày Dương Sang Âm & Âm Sang Dương</h1>
        <div class="row g-3">
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="row g-0 justify-content-center pt-lg-3 pt-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="backv-doi-lich ">
                            <div class="">
                                <div class="row --pading">
                                    <div class="col-lg-8">
                                        <h6 class="--text-down-convert">Chọn ngày dương hoặc âm bất kỳ:</h6>
                                        <p>Chọn ngày âm lịch hoặc dương lịch mà bạn mong muốn rồi ấn vào nút chuyển đổi.</p>
                                        <form action="{{ route('convert.am.to.duong') }}" method="POST">
                                            @csrf
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
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary btnd-nfay">Chuyển
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
                            <h6 class="--text-down-convert">Kết quả chuyển đổi</h6>
                            <div class="col-lg-12 order-1 order-lg-1 mb-3">
                                <div class="row g-3">
                                    <div class="col-6" id="solar-display-container">
                                        <div class="date-display-card">
                                            <a href="javascript:void(0)"
                                                class="nav-arrow nav-home-date nave-left prev-day-btn"
                                                title="Ngày hôm trước" id="pc-prev-btn"><i
                                                    class="bi bi-chevron-left"></i></a>
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
                                        <div class="date-display-card">
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
                                                <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }})
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

                                            <a href="javascript:void(0)"
                                                class="nav-arrow nav-home-date nave-right next-day-btn"
                                                title="Ngày hôm sau" id="pc-next-btn"> <i
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
                                        <div></div>
                                        <div class="d-flex gap-2">
                                            <div class="div">
                                                <a href="javascript:void(0)"
                                                    class="nav-arrow prev-day-btn-mobie  nave-left prev-day-btn"
                                                    title="Ngày hôm trước" id="mobile-prev-btn"><i
                                                        class="bi bi-chevron-left"></i></a>
                                            </div>
                                            <div class="div">
                                                <a href="javascript:void(0)"
                                                    class="nav-arrow  next-day-btn-mobie nave-right next-day-btn"
                                                    title="Ngày hôm sau" id="mobile-next-btn"> <i
                                                        class="bi bi-chevron-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="mt-lg-4 mt-2 text-box-tong-quan box-white-mobi">
                                    <p>✦ Ngày Dương: <span
                                            class="sonar-date">{{ $dd }}/{{ $mm }}/{{ $yy }}</span>
                                    </p>
                                    <p>✦ Ngày Âm: <span
                                            class="lunar-date ">{{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}</span>
                                    </p>
                                    <p>✦ Là ngày: {{ $weekday }}</p>
                                    <p>✦ Ngũ hành nạp âm: {{ $getThongTinNgay['nap_am']['napAm'] }}</p>
                                    <p>✦ Tiết khí: {{ $tietkhi['tiet_khi'] }}</p>
                                    <p>✦ Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}</p>


                                    <div class="col-lg-12 pt-2 d-flex justify-content-center ">
                                        <a href="{{ route('detai_home', ['nam' => $yy, 'thang' => $mm, 'ngay' => $dd]) }}"
                                            class="btn btn-primary w-100 mt-3 btn0mobie mt-3"> <img
                                                src="{{ asset('/icons/hand_2_white.svg') }}" alt="hand_2"
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
                        <div class="calendar-header-convert calendar-header" >
                            <div class="text-center">
                                <h5 class="mb-0 pt-2">Tháng {{ $mm }} năm {{ $yy }}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <select id="month-select" class="form-select me-2 custom-select-style"  aria-label="Chọn tháng"> 
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $mm ? 'selected' : '' }}>Tháng
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                <select id="year-select" class="form-select custom-select-style" aria-label="Chọn năm">
                                    <option value="{{ $yy }}">Năm {{ $yy }}</option>
                                </select>
                            </div>
                            {{-- <a href="{{ route('detai_home', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                        class="btn-today-home-pc btn-today-home">
                        <i class="bi bi-calendar-plus pe-1-pc-home"></i> Hôm nay
                    </a> --}}
                        </div>
                        <div id="calendar-body-container">
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
                            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>

                        </div>
                    </div>
                </div>
                <div class="search-am-duong-lich">
                    <div class="van-lien-hows">
                        <h2 class="title-tong-quan-h2">Đổi Ngày Dương Sang Âm, Âm Sang Dương Online</h2>
                        <hr>
                        <div class="text-box-tong-quan ">
                            <h4 class="title-tong-quan-h4-log">Đổi Ngày Dương Sang Âm Là Gì?</h4>
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
                            <h4 class="title-tong-quan-h4-log">Sự Khác Biệt Giữa Âm Lịch Và Dương Lịch</h4>
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
                            <h4 class="title-tong-quan-h4-log">Khi Nào Cần Đổi Ngày Âm Sang Dương Và Ngược Lại?</h4>
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
                            <h4 class="title-tong-quan-h4-log">Ý Nghĩa Của Việc Đổi Ngày Trong Văn Hóa Việt Nam</h4>
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
                            <h4 class="title-tong-quan-h4-log">Hướng Dẫn Sử Dụng Công Cụ Đổi Ngày Trên Phong Lịch</h4>
                            <p>Tại <b>phonglich.com</b>, bạn có thể dễ dàng đổi ngày Âm sang Dương hoặc ngược lại chỉ trong
                                vài giây:</p>
                            <ul style="list-style-type: decimal ">
                                <li>Chọn ngày cần đổi (theo Âm lịch hoặc Dương lịch).</li>
                                <li>Hệ thống tự động trả kết quả gồm:</li>
                                <ul>
                                    <li>Ngày Âm/Dương tương ứng.</li>
                                    <li>Thông tin Can Chi, Tiết khí, ngày Hoàng đạo – Hắc đạo.</li>
                                    <li>Gợi ý ngày tốt, giờ tốt cho các công việc quan trọng.</li>
                                </ul>
                                <li>Người dùng có thể tiếp tục tra cứu các công cụ liên quan như xem tử vi, xem phong thủy,
                                    chọn ngày hợp tuổi.</li>
                            </ul>
                            <p>Ưu điểm của công cụ tại Phong Lịch:</p>
                            <ul>
                                <li>Nhanh chóng – chính xác – miễn phí.</li>
                                <li>Giao diện thân thiện, dễ sử dụng trên cả máy tính và điện thoại.</li>
                                <li>Tích hợp nhiều tri thức cổ truyền (Âm lịch, Can Chi, Ngũ hành, Tử vi)</li>
                            </ul>
                            <h4 class="title-tong-quan-h4-log">Kết Luận</h4>
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
                        <h5 class="card-title-right">Sự kiện, ngày lễ sắp tới</h5>



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
                                        <h3 class="hv-memorial-event-title">{{ $event['description'] }}</h3>
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
            <div class="mobile-popup-buttons">
                <button type="button" class="mobile-popup-btn cancel" id="mobileCancelBtn">
                    Hủy
                </button>
                <button type="button" class="mobile-popup-btn choose" id="mobileChooseBtn">
                    Chuyển đổi
                </button>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
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
                padding: 15px 20px;
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
        // Function to change day
        function changeDay(days) {
            console.log('changeDay called with:', days);
            const solarInput = document.getElementById('solar_date');
            let currentDate = solarInput.value;
            console.log('Current solar date:', currentDate);

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
                const apiDate = convertToApiFormat(solarDate);
                const response = await fetch('/api/convert-to-am', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        date: apiDate
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    const lunarDate = data.date;
                    return convertFromApiFormat(lunarDate);
                } else {
                    const errorData = await response.json();
                    console.error('API Error:', errorData.error || 'Unknown error');
                }
            } catch (error) {
                console.error('Error converting solar to lunar:', error);
            }
            return null;
        };

        window.convertLunarToSolar = async function(lunarDate) {
            try {
                const apiDate = convertToApiFormat(lunarDate);
                const response = await fetch('/api/convert-to-duong', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        date: apiDate
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    const solarDate = data.date;
                    return convertFromApiFormat(solarDate);
                } else {
                    const errorData = await response.json();
                    console.error('API Error:', errorData.error || 'Unknown error');
                }
            } catch (error) {
                console.error('Error converting lunar to solar:', error);
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
            const input = document.getElementById(type + '_date');

            if (!container || !input) {
                console.error(`Element ${type}-select-container or ${type}_date not found`);
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
            const currentValue = input.value || formatDate(new Date());
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
            const input = document.getElementById(type + '_date');

            // Set title
            title.textContent = type === 'solar' ? 'Chọn ngày dương lịch' : 'Chọn ngày âm lịch';

            // Get current date value - use a proper default
            let currentValue = input.value;
            if (!currentValue) {
                // If no value, use 01/01/2024 as default
                currentValue = '01/01/2024';
            }

            // Populate mobile selects
            await populateMobileSelects(type, currentValue);

            // Show popup
            popup.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        };

        window.hideMobileDatePopup = function() {
            const popup = document.getElementById('mobileDatePopup');
            popup.style.display = 'none';
            document.body.style.overflow = 'auto';
            currentMobileType = '';
        };

        window.populateMobileSelects = async function(type, dateValue) {
            const parts = dateValue.split('/');
            const currentDay = parseInt(parts[0]) || 1;
            const currentMonth = parseInt(parts[1]) || 1;
            const currentYear = parseInt(parts[2]) || new Date().getFullYear();

            // Populate mobile month select
            const monthSelect = document.getElementById('mobile-month');
            monthSelect.innerHTML = '';
            for (let i = 1; i <= 12; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Tháng ${i}`;
                if (i === currentMonth) option.selected = true;
                monthSelect.appendChild(option);
            }

            // Populate mobile year select
            const yearSelect = document.getElementById('mobile-year');
            yearSelect.innerHTML = '';
            const currentYearFull = new Date().getFullYear();
            for (let i = currentYearFull - 100; i <= currentYearFull + 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                if (i === currentYear) option.selected = true;
                yearSelect.appendChild(option);
            }

            // Populate mobile day select - simplified version
            await populateMobileDays(type, currentMonth, currentYear, currentDay);
        };

        // Simplified function to populate mobile days
        window.populateMobileDays = async function(type, month, year, selectedDay) {
            const daySelect = document.getElementById('mobile-day');
            daySelect.innerHTML = '<option>Đang tải...</option>';

            let maxDay;
            if (type === 'lunar') {
                // For lunar calendar, use simple fallback for now
                maxDay = 30; // Most lunar months have 29-30 days
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

        window.applyDateSelect = function(type) {
            const day = document.getElementById(type + '-day').value;
            const month = document.getElementById(type + '-month').value;
            const year = document.getElementById(type + '-year').value;

            if (day && month && year) {
                const formattedDate = `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;
                const input = document.getElementById(type + '_date');
                input.value = formattedDate;

                // Convert to the other calendar type
                if (type === 'solar') {
                    convertSolarToLunar(formattedDate).then(lunarDate => {
                        if (lunarDate) {
                            document.getElementById('lunar_date').value = lunarDate;
                        }
                    });
                } else {
                    convertLunarToSolar(formattedDate).then(solarDate => {
                        if (solarDate) {
                            document.getElementById('solar_date').value = solarDate;
                        }
                    });
                }

                hideDateSelect(type);
            }
        };

        window.populateSelects = async function(type, dateValue) {
            const parts = dateValue.split('/');
            const currentDay = parseInt(parts[0]) || 1;
            const currentMonth = parseInt(parts[1]) || 1;
            const currentYear = parseInt(parts[2]) || new Date().getFullYear();

            // Populate month select first
            const monthSelect = document.getElementById(type + '-month');
            if (!monthSelect) {
                console.error(`Element ${type}-month not found`);
                return;
            }
            monthSelect.innerHTML = '';
            for (let i = 1; i <= 12; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Tháng ${i}`;
                if (i === currentMonth) option.selected = true;
                monthSelect.appendChild(option);
            }

            // Populate year select
            const yearSelect = document.getElementById(type + '-year');
            if (!yearSelect) {
                console.error(`Element ${type}-year not found`);
                return;
            }
            yearSelect.innerHTML = '';
            const currentYearFull = new Date().getFullYear();
            for (let i = currentYearFull - 100; i <= currentYearFull + 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                if (i === currentYear) option.selected = true;
                yearSelect.appendChild(option);
            }

            // Populate day select based on selected month and year
            await updateDayOptions(type, currentMonth, currentYear, currentDay);

            // Add event listeners to update days when month or year changes
            monthSelect.addEventListener('change', async function() {
                const selectedMonth = parseInt(this.value);
                const selectedYear = parseInt(yearSelect.value);
                const selectedDay = parseInt(document.getElementById(type + '-day').value) || 1;
                await updateDayOptions(type, selectedMonth, selectedYear, selectedDay);
            });

            yearSelect.addEventListener('change', async function() {
                const selectedMonth = parseInt(monthSelect.value);
                const selectedYear = parseInt(this.value);
                const selectedDay = parseInt(document.getElementById(type + '-day').value) || 1;
                await updateDayOptions(type, selectedMonth, selectedYear, selectedDay);
            });
        };

        // Helper function to get the number of days in a month
        window.getDaysInMonth = async function(month, year, isLunar = false) {
            if (isLunar) {
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
                            year: parseInt(year)
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        return data.days || 29;
                    } else {
                        console.error(`API error: ${response.status}`);
                    }
                } catch (error) {
                    console.error('Error getting lunar month days:', error);
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
                console.error(`Element ${type}-day not found`);
                return;
            }
            const isLunar = type === 'lunar';

            // Show loading state
            daySelect.innerHTML = '<option>Đang tải...</option>';

            const maxDay = await getDaysInMonth(month, year, isLunar);

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

            const solarInput = document.getElementById('solar_date');
            const lunarInput = document.getElementById('lunar_date');

            const swapBtn = document.getElementById('swapDatesBtn');
            const solarContainer = document.getElementById('solar-container');
            const lunarContainer = document.getElementById('lunar-container');
            const solarDisplayContainer = document.getElementById('solar-display-container');
            const lunarDisplayContainer = document.getElementById('lunar-display-container');

            // Function to swap content inside result boxes
            const swapContentOnly = (immediate = false) => {
                const inputRow = solarContainer.parentNode;
                const swapIcon = swapBtn.querySelector('img');

                const doTheSwap = () => {
                    // Swap input positions (keep existing logic for inputs)
                    const solarInputFirst = Array.from(inputRow.children).indexOf(solarContainer) < Array
                        .from(inputRow.children).indexOf(lunarContainer);
                    if (solarInputFirst) {
                        inputRow.insertBefore(lunarContainer, solarContainer);
                    } else {
                        inputRow.insertBefore(solarContainer, lunarContainer);
                    }

                    // Swap CONTENT inside display boxes, but keep navigation buttons in place
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
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}/{{ $al[2] }}';

                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;
            @else
                // GET request hoặc tải trang lần đầu - hiển thị ngày hôm nay từ controller
                const solarDateFromController =
                    '{{ sprintf('%02d', $dd) }}/{{ sprintf('%02d', $mm) }}/{{ $yy }}';
                const lunarDateFromController =
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}/{{ $al[2] }}';

                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;
            @endif

            // Add click handlers for inputs to show select dropdowns
            solarInput.addEventListener('click', async function() {
                await showDateSelect('solar');
            });

            lunarInput.addEventListener('click', async function() {
                await showDateSelect('lunar');
            });

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
                mobileChooseBtn.addEventListener('click', function() {
                    const day = document.getElementById('mobile-day').value;
                    const month = document.getElementById('mobile-month').value;
                    const year = document.getElementById('mobile-year').value;

                    if (day && month && year) {
                        const formattedDate =
                            `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;

                        // Clear both inputs first
                        document.getElementById('solar_date').value = '';
                        document.getElementById('lunar_date').value = '';

                        // Set the correct input based on calendar type
                        const input = document.getElementById(currentMobileType + '_date');
                        input.value = formattedDate;

                        // Hide popup
                        hideMobileDatePopup();

                        // Submit form - let server handle conversion based on which input has value
                        const form = document.querySelector('form');
                        if (form) {
                            form.submit();
                        }
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
                    const selectedMonth = parseInt(this.value);
                    const selectedYear = parseInt(mobileYearSelect.value);
                    const selectedDay = parseInt(document.getElementById('mobile-day').value) || 1;
                    await updateMobileDayOptions(currentMobileType, selectedMonth, selectedYear,
                        selectedDay);
                });
            }

            if (mobileYearSelect) {
                mobileYearSelect.addEventListener('change', async function() {
                    const selectedMonth = parseInt(mobileMonthSelect.value);
                    const selectedYear = parseInt(this.value);
                    const selectedDay = parseInt(document.getElementById('mobile-day').value) || 1;
                    await updateMobileDayOptions(currentMobileType, selectedMonth, selectedYear,
                        selectedDay);
                });
            }

            // Add event listeners for PC navigation buttons
            const pcPrevBtn = document.getElementById('pc-prev-btn');
            const pcNextBtn = document.getElementById('pc-next-btn');

            if (pcPrevBtn) {
                console.log('Adding event listeners to PC prev button');
                pcPrevBtn.addEventListener('click', function(e) {
                    console.log('PC prev button clicked');
                    e.preventDefault();
                    changeDay(-1);
                });
            } else {
                console.log('PC prev button not found');
            }

            if (pcNextBtn) {
                console.log('Adding event listeners to PC next button');
                pcNextBtn.addEventListener('click', function(e) {
                    console.log('PC next button clicked');
                    e.preventDefault();
                    changeDay(1);
                });
            } else {
                console.log('PC next button not found');
            }

            // Add event listeners for mobile navigation buttons
            const mobilePrevBtn = document.getElementById('mobile-prev-btn');
            const mobileNextBtn = document.getElementById('mobile-next-btn');

            if (mobilePrevBtn) {
                console.log('Adding event listeners to mobile prev button');
                mobilePrevBtn.addEventListener('click', function(e) {
                    console.log('Mobile prev button clicked');
                    e.preventDefault();
                    changeDay(-1);
                });
                mobilePrevBtn.addEventListener('touchstart', function(e) {
                    console.log('Mobile prev button touched');
                    e.preventDefault();
                    changeDay(-1);
                });
            } else {
                console.log('Mobile prev button not found');
            }

            if (mobileNextBtn) {
                console.log('Adding event listeners to mobile next button');
                mobileNextBtn.addEventListener('click', function(e) {
                    console.log('Mobile next button clicked');
                    e.preventDefault();
                    changeDay(1);
                });
                mobileNextBtn.addEventListener('touchstart', function(e) {
                    console.log('Mobile next button touched');
                    e.preventDefault();
                    changeDay(1);
                });
            } else {
                console.log('Mobile next button not found');
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
                const h5Element = document.querySelector('.calendar-header-convert h5');
                if (h5Element) {
                    h5Element.textContent = `Tháng ${month} năm ${year}`;
                }
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
                            calendarBodyContainer.querySelector('tbody').innerHTML = data.table_html;
                        }
                    })
                    .catch(error => console.error('Error fetching calendar data:', error));
            }

            const debouncedUpdateCalendar = debounce(updateCalendar, 300);

            monthSelect.addEventListener('change', debouncedUpdateCalendar);
            yearSelect.addEventListener('change', debouncedUpdateCalendar);
             const select = document.getElementById('year-select');
            const start = 1900;
            const end = 2100;
            const current = {{ $yy }};
            let loaded = false;

            select.addEventListener('focus', () => {
                if (loaded) return; // chỉ load 1 lần
                loaded = true;
                for (let i = start; i <= end; i++) {
                    if (i === current) continue;
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = `Năm ${i}`;
                    select.appendChild(opt);
                }
            });
        });
    </script>
@endpush
