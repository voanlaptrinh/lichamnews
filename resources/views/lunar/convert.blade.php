@extends('welcome')
@section('content')
    @php
        $today = \Carbon\Carbon::now();
        $currentDate = \Carbon\Carbon::createFromDate($yy, $mm, $dd);
        $isToday = $today->isSameDay($currentDate);
    @endphp
    <div class="calendar-app-container py-4">
        <div class="row g-0">
            <div class="col-xl-9">

                <div class="d-flex justify-content-between mb-3  ">

                    <h1 class="content-title-home-lich">Lịch Âm - Lịch Vạn Niên</h1>
                    @if (!$isToday)
                        <a href="{{ route('home') }}"
                            class="btn-today-home-pc btn-today-home justify-content-center align-items-center">
                            <img src="{{ asset('icons/icon_lich_svg.svg') }}" alt="icon-lich-svg"
                                class="img-fluid pe-1-pc-home">
                            <div>Hôm nay</div>
                        </a>
                    @endif

                </div>
            </div>
        </div>
        <div class="row g-3">
            <!-- ==== CỘT LỊCH CHÍNH (BÊN TRÁI) ==== -->
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="boxx-col-lg-8">
                    <div class="d-flex flex-column gap-20 box-content-lg-8">

                        <!-- ** KHỐI NGÀY DƯƠNG LỊCH VÀ ÂM LỊCH ** -->
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="date-display-card">
                                    {{-- Nút Prev Day PC --}}
                                    <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn"
                                        title="Ngày hôm trước"><i class="bi bi-chevron-left"></i></a>
                                    <div class="text-center">
                                        <div class="card-title title-amduowngbox"><img
                                                src="{{ asset('icons/icon_duong.svg') }}" alt="icon_duong" width="20px"
                                                height="20px"> Dương lịch</div>
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
                                        <div class="card-title title-amduowngbox"><img
                                                src="{{ asset('icons/icon_am.svg') }}" alt="icon_am" width="20px"
                                                height="20px"> Âm lịch</div>
                                        <div class="date-number am date_number_lich date_number_lich_am">{{ $al[0] }}
                                        </div>
                                        <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                            {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                                        <div class="date-special-event text-dark">Ngày
                                            {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                            -
                                            Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                                        <div class="date-special-event">
                                            @if (!empty($suKienAmLich))
                                                @foreach ($suKienAmLich as $suKien)
                                                    <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    {{-- Nút Next Day PC (Đã sửa và di chuyển vào đây) --}}
                                    <a href="#" class="nav-arrow nav-home-date nave-right next-day-btn"
                                        title="Ngày hôm sau"> <i class="bi bi-chevron-right"></i></a>
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
                            <div class="ring-item1-left item-rings">
                                <div class="item-ring1">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing">
                                </div>
                                <div class="item-ring2">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing">
                                </div>
                            </div>
                            <div class="ring-item2-right item-rings">
                                <div class="item-ring3">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing">
                                </div>
                                <div class="item-ring4">
                                    <img src="{{ asset('icons/cairing.png') }}" alt="cairing">
                                </div>
                            </div>

                            <div class="col-lg-12 btn-mobie-next-prev">
                                <div>
                                    @if (!$isToday)
                                        <a href="{{ route('home') }}"
                                            class="btn-today-home-mob d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('icons/icon_lich_svg.svg') }}" alt="icon-lich-svg"
                                                class="img-fluid pe-1">
                                            <div> Hôm nay</div>
                                        </a>
                                    @endif
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
                        {{-- d-sm-block d-block d-xl-none --}}
                        <div class="info-card ">
                            <div class="coli-row">
                                <div class="col-xl-7 col-lg-6 col-sm-12 col-12 ">
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_tiet_khi.png') }}" alt="icon_tiet_khi"
                                            class="icon_tiet_khi">
                                        <div class="font-detail-ngay">
                                            <strong class="title-font-detail-ngay">Tiết khí:</strong>
                                            <span class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_nap_am.png') }}" alt="icon_nap_am"
                                            class="icon_nap_am">
                                        <div class="font-detail-ngay">
                                            <strong class="title-font-detail-ngay">Ngũ hành nạp âm:</strong>
                                            {{ $getThongTinNgay['nap_am']['napAm'] }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_hoang_dao.png') }}" alt="icon_hoang_dao"
                                            class="icon_hoang_dao">
                                        <div class="font-detail-ngay">
                                            <strong class="title-font-detail-ngay">Giờ Hoàng đạo:</strong>
                                            {{ $getThongTinNgay['gio_hoang_dao'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-6 col-sm-12 col-12">
                                    <!-- BẮT ĐẦU: KHỐI MỨC THUẬN LỢI (ĐÃ CẬP NHẬT) -->
                                    <div
                                        class="convenience-level g-0 d-flex justify-content-between align-items-center row h-100">
                                        <div class="col-6">
                                            <div class="level-label text-lever-label-mobie">
                                                Điểm chỉ số <br>ngày tốt:
                                            </div>
                                        </div>

                                        <div class="col-6 d-flex justify-content-center">
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
                                                        class="dial-status {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? 'text-secondary' }}">
                                                        {{ $getDaySummaryInfo['score']['rating'] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- KẾT THÚC: KHỐI MỨC THUẬN LỢI -->
                                </div>
                            </div>


                            <div class="d-flex justify-content-center">
                                <a href="{{ route('detai_home', ['nam' => $yy, 'thang' => $mm, 'ngay' => $dd]) }}"
                                    class="btn btn-primary w-100 mt-3 btn0mobie"><img
                                        src="{{ asset('icons/hand_2_white.svg') }}" alt="hand_2" class="img-fluid">
                                    Xem
                                    chi tiết ngày</a>
                            </div>
                        </div>
                        <!-- ** LỊCH THÁNG ** -->
                        <div class="calendar-wrapper">

                            <div class="calendar-header-convert calendar-header">
                                <div class="text-center">
                                    <h5 class="mb-0 pt-2">Lịch vạn niên {{ $yy }} - tháng {{ $mm }}
                                    </h5>
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
                                {{--   <a href="{{ route('lich.nam.ngay', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                                    class="btn-today-home-pc btn-today-home">
                                    <i class="bi bi-calendar-plus pe-1-pc-home"></i> Hôm nay
                                </a> --}}
                            </div>
                            <div id="calendar-body-container">
                                <table class="calendar-table">
                                    <thead>
                                        <tr>
                                            <th><span class="title-lich-pc">Thứ hai</span> <span
                                                    class="title-lich-mobie">Th
                                                    2</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ ba</span> <span
                                                    class="title-lich-mobie">Th
                                                    3</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ tư</span> <span
                                                    class="title-lich-mobie">Th
                                                    4</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ năm</span> <span
                                                    class="title-lich-mobie">Th
                                                    5</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ sáu</span> <span
                                                    class="title-lich-mobie">Th
                                                    6</span>
                                            </th>
                                            <th><span class="title-lich-pc">Thứ bảy</span> <span
                                                    class="title-lich-mobie">Th
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

                        </div>
                        <div class="calendar-legend">
                            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>

                        </div>
                    </div>
                </div>
                <section class="popular-utilities">
                    <div class="container bg-section-tienich">
                        <h2 class="section-title">Tiện ích phổ biến</h2>
                        <hr>
                        <div class="utilities-grid pt-2 row">

                            <!-- Tiện ích 1 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4 ">
                                <h4 class="utility-title">Đổi ngày Âm - Dương</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/doi_ngay_am_duong.svg') }}" alt="Đổi ngày Âm - Dương"
                                        class="img-fluid">
                                </div>

                                <p class="utility-description">Chuyển đổi nhanh giữa dương lịch và âm lịch.</p>
                            </a>

                            <!-- Tiện ích 2 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Xem ngày Tốt</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/xem_ngay_tot.svg') }}" alt="Xem ngày Tốt"
                                        class="img-fluid">
                                </div>

                                <p class="utility-description">Tra cứu ngày hoàng đạo để cưới hỏi, khai trương...</p>
                            </a>

                            <!-- Tiện ích 3 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Xem hướng hợp mệnh</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/huong_dep.svg') }}" alt="Xem hướng hợp mệnh"
                                        class="img-fluid">
                                </div>
                                <p class="utility-description">Tìm hướng hợp tuổi để làm nhà, đặt bàn thờ...</p>
                            </a>

                            <!-- Tiện ích 4 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Lá số tử vi</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/la_so_tu_vi.svg') }}" alt="Lá số tử vi" class="img-fluid">
                                </div>

                                <p class="utility-description">Lập lá số chi tiết theo giờ/ngày sinh.</p>
                            </a>

                        </div>
                    </div>
                </section>
                <section class="popular-utilities pt-0">
                    <div class="container bg-section-tienich">
                        <h2 class="section-title">Điểm chỉ số ngày tốt trong 7 ngày sắp tới</h2>
                        <hr>
                        <div class="utilities-grid row g-4 pt-2">
                            <div class="chart-container">

                                <div class="chart-canvas-wrapper">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <div class="van-lien-hows">

                    <h2 class="title-tong-quan-h2">Lịch Vạn Niên Là Gì?</h2>
                    <hr>
                    <p><b>Lịch Vạn Niên</b> là một công cụ tra cứu ngày tháng đặc biệt, kết hợp giữa hai hệ thống lịch phổ
                        biến:
                        <b>Dương lịch</b> (lịch quốc tế, được sử dụng rộng rãi trên toàn thế giới) và <b>Âm lịch</b> (hay
                        còn gọi là Lịch
                        âm – lịch truyền thống phương Đông, gắn liền với đời sống văn hóa của người Việt Nam).
                    </p>
                    <p>Từ hàng nghìn năm trước, Âm lịch đã được ông cha ta sử dụng để xem ngày tốt, lựa chọn ngày lành tháng
                        tốt cho những công việc trọng đại như cưới hỏi, động thổ, khai trương, xuất hành, ma chay hay thờ
                        cúng tổ tiên. Lịch không chỉ phản ánh sự vận động của Mặt trăng và Mặt trời mà còn gắn liền với
                        những yếu tố tâm linh, phong thủy và tử vi trong đời sống hằng ngày.</p>
                    <p>Theo dòng chảy lịch sử, Lịch vạn niên đã phát triển và trở thành kho tàng tri thức cổ truyền, kết hợp
                        tinh hoa của Thiên văn học phương Đông, Ngũ hành, Bát tự, Can Chi, Tử vi lý số. Vì thế, khi nhắc đến
                        Lịch vạn niên, chúng ta không chỉ nghĩ đến việc xem ngày tháng, mà còn nhắc đến một nền văn hóa gắn
                        bó với đời sống tâm linh và tín ngưỡng của người Việt.</p>
                    <h3 class="title-tong-quan-h3-log">Tại Sao Nên Sử Dụng Lịch Vạn Niên Của Phong Lịch?</h3>
                    <h4 class="title-tong-quan-h4-log">1. Tra cứu nhanh chóng và chính xác</h4>
                    <ul>
                        <li>Xem đầy đủ cả Âm lịch và Dương lịch theo từng ngày, tháng, năm.</li>
                        <li>Cập nhật chi tiết: Lịch ngày tốt, ngày Hoàng đạo – Hắc đạo, Tiết khí, sao chiếu mệnh, giờ xuất
                            hành tốt.</li>
                        <li>Giúp bạn dễ dàng trả lời câu hỏi “Hôm nay tốt hay xấu?”, “Ngày mai có giờ tốt không?”</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">2. Xem ngày tốt hợp tuổi</h4>
                    <ul>
                        <li>Chọn ngày cưới hỏi, khai trương, động thổ, xuất hành dựa theo tuổi và Can Chi của gia chủ.</li>
                        <li>Hỗ trợ tránh những ngày phạm Kim Lâu, Hoang Ốc, Tam Tai để công việc được hanh thông.</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">3. Tích hợp kiến thức tử vi – phong thủy</h4>
                    <ul>
                        <li>Lập lá số tử vi chi tiết theo ngày, tháng, năm sinh.</li>
                        <li>Xem vận hạn theo năm, dự đoán cát hung, hướng đi phù hợp.</li>
                        <li>Hướng dẫn lựa chọn hướng nhà, hướng bàn thờ, hướng xuất hành theo phong thủy bát trạch.</li>
                    </ul>
                    <h4 class="title-tong-quan-h4-log">4. Giao diện thân thiện – dễ sử dụng</h4>
                    <ul>
                        <li>Thiết kế hiện đại, đơn giản, tối ưu cho cả máy tính và điện thoại.</li>
                        <li>Thân thiện với mọi đối tượng: từ người cao tuổi muốn tra cứu Lịch âm dương hằng ngày đến giới
                            trẻ quan tâm đến tử vi, phong thủy.</li>
                    </ul>
                    <h3 class="title-tong-quan-h3-log">Lịch Vạn Niên Trong Thời Đại Số</h3>
                    <p>Nếu trước đây, Lịch vạn niên chủ yếu tồn tại dưới dạng sách in dày hàng trăm trang, thì ngày nay, nhờ
                        sự phát triển của công nghệ, Lịch vạn niên đã được số hóa hoàn toàn.</p>
                    <ul>
                        <li>Người dùng có thể tra cứu Lịch âm, Âm lịch, Dương lịch mọi lúc, mọi nơi trên máy tính, điện
                            thoại thông minh.</li>
                        <li>Chỉ với vài thao tác, bạn đã có thể xem chi tiết: ngày tốt xấu, ngày Hoàng đạo, Tiết khí, giờ
                            hoàng đạo, tuổi xung khắc….</li>
                        <li>Sự kết hợp giữa tri thức cổ truyền và công nghệ hiện đại giúp việc xem ngày tốt, xem giờ tốt trở
                            nên tiện lợi, nhanh chóng và chính xác hơn bao giờ hết.</li>
                    </ul>
                    <h3 class="title-tong-quan-h3-log">Phong Lịch – Đồng Hành Cùng Người Việt</h3>
                    <p>Dù bạn là người quan tâm đến tử vi, phong thủy, hay chỉ đơn giản muốn biết hôm nay là ngày gì theo
                        Lịch âm, ngày mai có giờ tốt để xuất hành hay không, Phong Lịch luôn sẵn sàng đồng hành cùng bạn.
                    </p>
                    <p>Với Lịch vạn niên trực tuyến, Phong Lịch không chỉ mang đến trải nghiệm tra cứu thuận tiện mà còn giữ
                        gìn và lan tỏa những giá trị văn hóa truyền thống của dân tộc.</p>
                    <p>Phong Lịch – Tra cứu Lịch Âm, Lịch Vạn Niên, Lịch ngày tốt, Xem ngày Hoàng đạo, Tiết khí, Xem ngày
                        tốt – Xem giờ tốt nhanh chóng, chính xác và miễn phí</p>
                </div>
            </div>

            <!-- ==== CỘT THÔNG TIN (BÊN PHẢI) ==== -->
            <div class="col-xl-3  col-sm-12 col-12">
                <div class="d-flex flex-column gap-4">
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
                                    <a href="{{ route('lich.nam.ngay', $routeParams) }}">
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
        document.addEventListener("DOMContentLoaded", () => {
            let overlay = null;
            // Tạo overlay cho mobile
            function createOverlay() {
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'daterangepicker-overlay';
                    document.body.appendChild(overlay);

                    overlay.addEventListener('click', function() {
                        $('#month-year-picker').data('daterangepicker').hide();
                    });
                }
                return overlay;
            }

            $('#month-year-picker').on('show.daterangepicker', function(ev, picker) {
                if (window.innerWidth <= 768) {
                    const overlay = createOverlay();
                    overlay.style.display = 'block';
                }
            });

            $('#month-year-picker').on('hide.daterangepicker', function(ev, picker) {
                if (overlay) {
                    overlay.style.display = 'none';
                }
            });
            const ctx = document.getElementById('myChart').getContext('2d');
            const labels = @json($labels);
            const dataValues = @json($dataValues);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Điểm ngày',
                        data: dataValues,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return;

                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0,
                                chartArea.top);
                            gradient.addColorStop(0, getComputedStyle(document.documentElement)
                                .getPropertyValue('--bar-bottom-color') || '#4e79a7');
                            gradient.addColorStop(0.6, getComputedStyle(document
                                    .documentElement)
                                .getPropertyValue('--bar-mid-color') || '#59a14f');
                            gradient.addColorStop(1, getComputedStyle(document.documentElement)
                                .getPropertyValue('--bar-top-color') || '#9c755f');
                            return gradient;
                        },
                        borderRadius: {
                            topLeft: 8,
                            topRight: 8
                        },
                        borderSkipped: false,
                        hoverBackgroundColor: getComputedStyle(document.documentElement)
                            .getPropertyValue('--bar-top-color') || '#9c755f',
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '%';
                                }
                            },
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 8,
                            displayColors: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--text-color-light') || '#333',
                                font: {
                                    size: 13,
                                    weight: '500'
                                },
                                padding: 10
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 20,
                                callback: function(value) {
                                    return value + '%';
                                },
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--text-color-light') || '#333',
                                font: {
                                    size: 13,
                                    weight: '500'
                                },
                                padding: 10,
                            },
                            grid: {
                                color: getComputedStyle(document.documentElement).getPropertyValue(
                                    '--grid-line-color') || '#ddd',
                                borderDash: [5, 5],
                                drawBorder: false,
                                drawOnChartArea: true,
                                drawTicks: false
                            }
                        }
                    }
                },
                plugins: [{
                    // Plugin custom để vẽ % trên đầu cột
                    id: 'valueOnTop',
                    afterDatasetsDraw(chart) {
                        const {
                            ctx
                        } = chart;
                        chart.data.datasets.forEach((dataset, i) => {
                            chart.getDatasetMeta(i).data.forEach((bar, index) => {
                                const value = dataset.data[index] + '%';
                                ctx.save();
                                ctx.font = 'bold 12px sans-serif';
                                ctx.fillStyle = getComputedStyle(document
                                    .documentElement).getPropertyValue(
                                    '--text-color-light') || '#333';
                                ctx.textAlign = 'center';
                                ctx.fillText(value, bar.x, bar.y -
                                    6); // 6px phía trên đầu cột
                                ctx.restore();
                            });
                        });
                    }
                }]
            });

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

                const newPrevUrl = `/lich-nam-${prevYear}/thang-${prevMonth}/ngay-${prevDay}`;

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

                const newNextUrl = `/lich-nam-${nextYear}/thang-${nextMonth}/ngay-${nextDay}`;

                // Lặp qua TẤT CẢ các nút "next" và gán URL mới
                nextBtns.forEach(btn => {
                    btn.href = newNextUrl;
                });
            }
        });
        $('#month-year-picker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'MM-YYYY',
                "applyLabel": "Chọn",
                "cancelLabel": "Hủy",
                "fromLabel": "Từ",
                "toLabel": "Đến",
                "customRangeLabel": "Tùy chỉnh",
                "weekLabel": "W",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
                "firstDay": 1
            }
        }, function(start, end, label) {
            const year = start.format('YYYY');
            const month = start.format('M');
            const day = start.format('D');
            const url = `{{ route('lich.nam.ngay', ['nam' => ':nam', 'thang' => ':thang', 'ngay' => ':ngay']) }}`
                .replace(':nam', year).replace(':thang', month).replace(':ngay', day);
            window.location.href = url;
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

                // Cập nhật thẻ h5 với tháng và năm mới
                const h5Element = document.querySelector('.calendar-header-convert h5');
                if (h5Element) {
                    h5Element.textContent = ` Lịch vạn niên ${year} - tháng ${month}`;
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
