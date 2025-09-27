@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a><i class="bi bi-chevron-right"></i> <span
                style="color: #2254AB">Đổi ngày âm dương </span></h6>
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
                                                    <div class="date-input-wrapper">
                                                        <input type="text" value="" name="solar_date"
                                                            id="solar_date" class="form-control dateuse2r"
                                                            placeholder="dd/mm/yyyy" inputmode="text" autocomplete="off"
                                                            data-type="solar">
                                                        {{-- <span class="date-icon-custom">
                                                            <i class="bi bi-calendar-date-fill"></i>
                                                        </span> --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="lunar-container">
                                                    <label class="form-label fw-bold" style="color: #212121CC">Ngày Âm
                                                        Lịch</label>
                                                    <div class="date-input-wrapper">
                                                        <input type="text" value="" name="lunar_date"
                                                            id="lunar_date" class="form-control dateuse2r"
                                                            placeholder="dd/mm/yyyy" inputmode="text" autocomplete="off"
                                                            data-type="lunar">
                                                        {{-- <span class="date-icon-custom">
                                                            <i class="bi bi-calendar-date-fill"></i>
                                                        </span> --}}
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
                                                title="Ngày hôm trước" onclick="changeDay(-1)"><i
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
                                                title="Ngày hôm sau" onclick="changeDay(1)"> <i
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
                                                    title="Ngày hôm trước" onclick="changeDay(-1)"><i
                                                        class="bi bi-chevron-left"></i></a>
                                            </div>
                                            <div class="div">
                                                <a href="javascript:void(0)"
                                                    class="nav-arrow  next-day-btn-mobie nave-right next-day-btn"
                                                    title="Ngày hôm sau" onclick="changeDay(1)"> <i
                                                        class="bi bi-chevron-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="mt-lg-4 mt-2 text-box-tong-quan">
                                    <p>✦ Ngày Dương Lịch: <span
                                            class="sonar-date">{{ $dd }}/{{ $mm }}/{{ $yy }}</span>
                                    </p>
                                    <p>✦ Ngày Âm Lịch: <span
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

                <div class="mt-5">
                    <div class="calendar-wrapper">
                        <div class="calendar-header-convert calendar-header">
                            <div class="text-center">
                                <h5 class="mb-0 pt-2">Tháng {{ $mm }} năm {{ $yy }}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <select id="month-select" class="form-select me-2 custom-select-style">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $mm ? 'selected' : '' }}>Tháng
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                <select id="year-select" class="form-select custom-select-style">
                                    @for ($i = 1900; $i <= 2100; $i++)
                                        <option value="{{ $i }}" {{ $i == $yy ? 'selected' : '' }}>Năm
                                            {{ $i }}</option>
                                    @endfor
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

            <div class="col-xl-3  col-sm-12 col-12">
                <div class="d-flex flex-column gap-4 pt-2">



                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <h5 class="card-title-right">Sự kiện, ngày lễ sắp tới</h5>
                        <ul class="list-group list-group-flush events-list">
                            @foreach ($upcomingEvents as $event)
                                @php
                                    // Phân tích cú pháp ngày sự kiện một lần để lấy các phần tử năm, tháng, ngày
                                    $eventCarbonDate = Carbon\Carbon::parse($event['date']);
                                    $routeParams = [
                                        'nam' => $eventCarbonDate->year,
                                        'thang' => $eventCarbonDate->month,
                                        'ngay' => $eventCarbonDate->day,
                                    ];
                                @endphp
                                <li class="list-group-item event-item">
                                    <a href="{{ route('detai_home', $routeParams) }}">
                                        <div class="event-date">Ngày
                                            {{ Carbon\Carbon::parse($event['date'])->format('d/m') }}</div>
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

    </div>
@endsection


@push('scripts')
    <script>
        // Function to change day
        function changeDay(days) {
            const solarInput = document.getElementById('solar_date');
            const currentDate = solarInput.value;

            if (currentDate) {
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

                    // Create a form and submit to /am-sang-duong
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('convert.am.to.duong') }}';

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Add solar date input
                    const solarDateInput = document.createElement('input');
                    solarDateInput.type = 'hidden';
                    solarDateInput.name = 'solar_date';
                    solarDateInput.value = newDateStr;
                    form.appendChild(solarDateInput);

                    // Add lunar date input (current value)
                    const lunarInput = document.getElementById('lunar_date');
                    const lunarDateInput = document.createElement('input');
                    lunarDateInput.type = 'hidden';
                    lunarDateInput.name = 'lunar_date';
                    lunarDateInput.value = lunarInput.value;
                    form.appendChild(lunarDateInput);

                    // Append to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }


        document.addEventListener('DOMContentLoaded', function() {


            // Double-check jQuery and daterangepicker
            if (typeof $ === 'undefined') {
                console.error('$ (jQuery) is not available!');
                return;
            }

            const today = new Date();
            const maxDate = new Date(today.getFullYear() + 5, 11, 31);
            let overlay = null;
            let isUpdating = false; // Prevent infinite loops

            const solarInput = document.getElementById('solar_date');
            const lunarInput = document.getElementById('lunar_date');


            const swapBtn = document.getElementById('swapDatesBtn');
            const solarContainer = document.getElementById('solar-container');
            const lunarContainer = document.getElementById('lunar-container');
            const solarDisplayContainer = document.getElementById('solar-display-container');
            const lunarDisplayContainer = document.getElementById('lunar-display-container');

            // Function to swap elements
            const swapElements = (immediate = false) => {
                const inputRow = solarContainer.parentNode;
                const displayRow = solarDisplayContainer.parentNode;
                const swapIcon = swapBtn.querySelector('img');

                const doTheSwap = () => {
                    // Determine current order and swap
                    const solarInputFirst = Array.from(inputRow.children).indexOf(solarContainer) < Array
                        .from(inputRow.children).indexOf(lunarContainer);
                    if (solarInputFirst) {
                        inputRow.insertBefore(lunarContainer, solarContainer);
                    } else {
                        inputRow.insertBefore(solarContainer, lunarContainer);
                    }

                    const solarDisplayFirst = Array.from(displayRow.children).indexOf(
                        solarDisplayContainer) < Array.from(displayRow.children).indexOf(
                        lunarDisplayContainer);
                    if (solarDisplayFirst) {
                        displayRow.insertBefore(lunarDisplayContainer, solarDisplayContainer);
                    } else {
                        displayRow.insertBefore(solarDisplayContainer, lunarDisplayContainer);
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
                swapElements();
            });

            // On page load, check and apply saved state
            const savedState = localStorage.getItem('converterSwapState');
            if (savedState === 'lunar-first') {
                // The default is solar-first, so we need to swap if the saved state is lunar-first
                swapElements(true); // immediate swap
            }




            // Tạo overlay cho mobile
            function createOverlay() {
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'daterangepicker-overlay';
                    document.body.appendChild(overlay);

                    overlay.addEventListener('click', function() {
                        document.querySelectorAll('.dateuse2r').forEach(input => {
                            if ($(input).data('daterangepicker')) {
                                $(input).data('daterangepicker').hide();
                            }
                        });
                    });
                }
                return overlay;
            }

            // Format date to d/m/Y
            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // Parse date from d/m/Y format
            function parseDate(dateStr) {
                const parts = dateStr.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    return new Date(year, month, day);
                }
                return null;
            }

            // Convert date from dd/mm/yyyy to yyyy-mm-dd for API
            function convertToApiFormat(dateStr) {
                const parts = dateStr.split('/');
                if (parts.length === 3) {
                    const [day, month, year] = parts;
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }
                return dateStr;
            }

            // Convert date from yyyy-mm-dd to dd/mm/yyyy for display
            function convertFromApiFormat(dateStr) {
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const [year, month, day] = parts;
                    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
                }
                return dateStr;
            }

            // API call to convert solar to lunar
            async function convertSolarToLunar(solarDate) {
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
            }

            // API call to convert lunar to solar
            async function convertLunarToSolar(lunarDate) {
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
            }

            // Set default value for inputs từ controller hoặc ngày hôm nay
            @if (isset($dd) && isset($mm) && isset($yy) && isset($al))
                // Có dữ liệu từ controller - đưa trực tiếp vào input
                const solarDateFromController = '{{ $dd }}/{{ $mm }}/{{ $yy }}';
                const lunarDateFromController =
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}/{{ $al[2] }}';

                // Đưa trực tiếp vào input không qua API
                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;
            @else
                // Không có dữ liệu từ controller - dùng ngày hôm nay
                const todayFormatted = formatDate(today);
                solarInput.value = todayFormatted;

                // Convert today to lunar via API
                convertSolarToLunar(todayFormatted).then(lunarDate => {
                    if (lunarDate) {
                        lunarInput.value = lunarDate;
                    }
                });
            @endif

            // Xử lý khi người dùng nhập tay vào input
            solarInput.addEventListener('blur', async function() {
                const value = this.value.trim();
                if (value && value.match(/^\d{1,2}\/\d{1,2}\/\d{4}$/)) {
                    // Validate ngày tháng
                    const parts = value.split('/');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10);
                    const year = parseInt(parts[2], 10);

                    if (day >= 1 && day <= 31 && month >= 1 && month <= 12 && year >= 1900 && year <=
                        2100) {
                        // Format lại với padding
                        this.value =
                            `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;

                        // Convert sang âm lịch
                        if (!isUpdating) {
                            isUpdating = true;
                            const lunarDate = await convertSolarToLunar(this.value);
                            if (lunarDate && lunarInput) {
                                lunarInput.value = lunarDate;
                            }
                            isUpdating = false;
                        }

                        // Update daterangepicker
                        const picker = $(this).data('daterangepicker');
                        if (picker) {
                            const date = parseDate(this.value);
                            if (date) {
                                picker.setStartDate(date);
                                picker.setEndDate(date);
                            }
                        }
                    }
                }
            });

            lunarInput.addEventListener('blur', async function() {
                const value = this.value.trim();
                if (value && value.match(/^\d{1,2}\/\d{1,2}\/\d{4}$/)) {
                    // Validate ngày tháng
                    const parts = value.split('/');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10);
                    const year = parseInt(parts[2], 10);

                    if (day >= 1 && day <= 30 && month >= 1 && month <= 12 && year >= 1900 && year <=
                        2100) {
                        // Format lại với padding
                        this.value =
                            `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;

                        // Convert sang dương lịch
                        if (!isUpdating) {
                            isUpdating = true;
                            const solarDate = await convertLunarToSolar(this.value);
                            if (solarDate && solarInput) {
                                solarInput.value = solarDate;
                            }
                            isUpdating = false;
                        }

                        // Update daterangepicker
                        const picker = $(this).data('daterangepicker');
                        if (picker) {
                            const date = parseDate(this.value);
                            if (date) {
                                picker.setStartDate(date);
                                picker.setEndDate(date);
                            }
                        }
                    }
                }
            });

            // Xử lý khi người dùng nhấn Enter
            solarInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.blur();
                }
            });

            lunarInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.blur();
                }
            });

            // Initialize daterangepicker cho từng input (chỉ single date)

            if (typeof $.fn.daterangepicker === 'undefined') {
                console.error('DateRangePicker plugin not loaded! Please check if the library is included.');
                return;
            }

            document.querySelectorAll('.dateuse2r').forEach(function(input) {




                try {
                    // Lấy startDate từ giá trị hiện tại của input hoặc today
                    let startDate = today;
                    if (input.value) {
                        const inputDate = parseDate(input.value);
                        if (inputDate) {
                            startDate = inputDate;
                        }
                    }

                    $(input).daterangepicker({
                        singleDatePicker: true,
                        autoApply: true, // Tự động áp dụng khi chọn ngày, không cần nhấn nút Apply
                        autoUpdateInput: true, // Tự động cập nhật input
                        showDropdowns: true,
                        minYear: 1900,
                        maxYear: maxDate.getFullYear(),
                        maxDate: maxDate,
                        startDate: startDate,
                        showCustomRangeLabel: false,
                        alwaysShowCalendars: true,
                        locale: {
                            format: 'DD/MM/YYYY',
                            applyLabel: 'Chọn',
                            cancelLabel: 'Hủy',
                            weekLabel: 'T',
                            daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                                'Tháng 6',
                                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11',
                                'Tháng 12'
                            ],
                            firstDay: 1
                        },
                        opens: 'center',
                        drops: 'down'
                    });

                    // Events
                    $(input).on('show.daterangepicker', function(ev, picker) {
                        setTimeout(function() {
                            // Ensure ranges div is hidden on show as well
                            $('.daterangepicker .ranges').hide();
                            // Also, ensure the calendar takes full width if there's only one
                            $('.daterangepicker .drp-calendar').css({
                                'width': '100%',
                                'border-right': 'none'
                            });
                        }, 1);

                        if (window.innerWidth <= 768) {
                            const overlay = createOverlay();
                            overlay.style.display = 'block';
                        }

                        const inputType = input.getAttribute('data-type');
                        if (inputType === 'lunar') {
                            picker.container.addClass('lunar-mode');
                        } else {
                            picker.container.removeClass('lunar-mode');
                        }
                    });

                    $(input).on('hide.daterangepicker', function(ev, picker) {
                        if (overlay) {
                            overlay.style.display = 'none';
                        }
                    });

                    // Xử lý khi chọn ngày - sử dụng event 'apply' cho single date picker với autoApply
                    $(input).on('apply.daterangepicker', async function(ev, picker) {
                        const selectedDate = picker.startDate.format('DD/MM/YYYY');
                        input.value = selectedDate;

                        if (overlay) {
                            overlay.style.display = 'none';
                        }

                        // Prevent infinite loops
                        if (isUpdating) return;
                        isUpdating = true;

                        const isLunarMode = picker.container.hasClass('lunar-mode');

                        if (isLunarMode) {
                            // User selected a LUNAR date from the picker
                            const solarDate = await convertLunarToSolar(selectedDate);
                            if (solarDate && solarInput) {
                                solarInput.value = solarDate;
                            }
                            // lunarInput.value is already set to selectedDate
                        } else {
                            // User selected a SOLAR date from the picker
                            const lunarDate = await convertSolarToLunar(selectedDate);
                            if (lunarDate && lunarInput) {
                                lunarInput.value = lunarDate;
                            }
                        }

                        isUpdating = false;
                    });

                    // Thêm event khi daterangepicker thay đổi giá trị (cho autoApply)
                    $(input).on('change.daterangepicker', async function(ev, picker) {
                        if (!picker) return; // Không phải từ picker

                        const selectedDate = picker.startDate.format('DD/MM/YYYY');
                        input.value = selectedDate;

                        if (overlay) {
                            overlay.style.display = 'none';
                        }

                        // Prevent infinite loops
                        if (isUpdating) return;
                        isUpdating = true;

                        const inputType = input.getAttribute('data-type');

                        if (inputType === 'solar') {
                            const lunarDate = await convertSolarToLunar(selectedDate);
                            if (lunarDate && lunarInput) {
                                lunarInput.value = lunarDate;
                            }
                        } else if (inputType === 'lunar') {
                            const solarDate = await convertLunarToSolar(selectedDate);
                            if (solarDate && solarInput) {
                                solarInput.value = solarDate;
                            }
                        }

                        isUpdating = false;
                    });

                    // Handle icon click
                    const icon = input.parentNode.querySelector('.date-icon-custom');
                    if (icon) {
                        icon.addEventListener('click', function(e) {
                            e.preventDefault();
                            $(input).data('daterangepicker').show();
                        });
                    }
                } catch (error) {
                    console.error('Error initializing daterangepicker for', input.id, ':', error);
                }
            });
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
        });
    </script>
@endpush
