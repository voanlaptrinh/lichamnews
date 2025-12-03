@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.9') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('totxau.list') }}" style="color: #2254AB; text-decoration: underline;">Xem ngày
                        tốt</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày ký hợp đồng
                </li>
            </ol>
        </nav>

        <h1 class="content-title-home-lich">Xem ngày tốt ký hợp đồng theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold title-tong-quan-h2-log" style="color: #192E52">
                                            Thông tin người ký hợp đồng
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                            vào ô dưới đây để
                                            xem ngày tốt ký hợp đồng</p>

                                        <form id="contractSigningForm">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                    <div for="person_name" class="fw-bold title-tong-quan-h4-log "
                                                        style="color: #192E52; padding-bottom: 12px;">Tên
                                                        người ký hợp đồng</div>
                                                    <input type="text"
                                                        class="form-control --border-box-form @error('person_name') is-invalid @enderror"
                                                        id="person_name" name="person_name"
                                                        placeholder="Nhập tên người ký hợp đồng"
                                                        value="{{ old('person_name', $inputs['person_name'] ?? '') }}"
                                                        style="padding: 12px 15px; border-radius: 10px; border: none; background-color: rgba(255,255,255,0.95);">
                                                    @error('person_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <div for="birthdate" class="fw-bold title-tong-quan-h4-log"
                                                        style="color: #192E52; padding-bottom: 12px;">Ngày
                                                        sinh</div>
                                                    <!-- Date Selects -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="ngaySelect" name="day"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Ngày</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="thangSelect" name="month"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Tháng</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="namSelect" name="year"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Năm</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Radio buttons dạng tròn bên dưới selects -->
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="calendar_type" id="solarCalendar" value="solar"
                                                                checked style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="solarCalendar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Dương lịch
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="calendar_type" id="lunarCalendar" value="lunar"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="lunarCalendar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Âm lịch
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!-- Leap Month Option (hidden) -->
                                                    <div class="form-check mt-2" id="leapMonthContainer"
                                                        style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="leapMonth"
                                                            name="leap_month">
                                                        <label class="form-check-label" for="leapMonth">
                                                            Tháng nhuận
                                                        </label>
                                                    </div>

                                                    <!-- Hidden input to store formatted date -->
                                                    <input type="hidden" id="ngayXem" name="birthdate"
                                                        value="{{ old('birthdate', $inputs['birthdate'] ?? '') }}">

                                                    @error('birthdate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="input-group mb-4">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log"
                                                        style="color: #192E52; padding-bottom: 12px;">Dự kiến
                                                        thời gian ký hợp đồng</div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control wedding_date_range --border-box-form @error('date_range') is-invalid @enderror"
                                                            id="date_range" name="date_range"
                                                            placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                            value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                            style="border-radius: 10px; border: none; padding: 12px 30px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                        <span class="input-group-text bg-transparent border-0"
                                                            style="position: absolute; right: 2px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                            <img src="{{ asset('images/date1-icon.svg') }}"
                                                                alt="icon ngày tháng năm" class="img-fluid">
                                                        </span>
                                                    </div>
                                                    @error('date_range')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-light-settup fw-bold w-100"
                                                    id="submitBtn">
                                                    <span class="btn-text">Xem Kết Quả</span>
                                                    <span class="spinner-border spinner-border-sm ms-2 d-none"
                                                        role="status"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-none d-lg-flex">
                                <div class="d-flex align-items-center justify-content-center h-100 w-100"
                                    style="padding: 32px 32px 32px 0px;">
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100"
                                        style=" background-image: url(../images/form_kyhopdong.svg);
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    align-items: normal;
                                    background-position: center center;
                                    overflow: hidden;
                                    border-radius: 12px">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="resultsContainer" class="--detail-success">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Vì sao nên xem ngày trước khi ký hợp đồng?
                            </h2>
                            <p class="mb-3">Ký hợp đồng là bước quan trọng trong kinh doanh, mua bán, đầu tư hoặc hợp tác
                                giữa hai bên. Một hợp đồng được ký trong ngày – giờ tốt, hợp tuổi, hợp ngũ hành sẽ giúp:</p>
                            <ul class="mb-3">
                                <li>Tạo không khí thuận hòa, dễ đạt thỏa thuận</li>
                                <li>Hạn chế tranh cãi, bất đồng quan điểm</li>
                                <li>Giao dịch diễn ra nhanh, rõ ràng, ít phát sinh rủi ro</li>
                                <li>Mang lại vận khí tốt cho tài chính và công việc về lâu dài</li>
                                <li>Giúp tâm lý hai bên nhẹ nhàng, tự tin và thoải mái hơn</li>
                            </ul>
                            <p class="mb-3">Chính vì vậy, xem ngày ký hợp đồng đã trở thành một thói quen phổ biến, mang
                                tính “chuẩn bị tinh thần” và hỗ trợ phong thủy thực tế.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Khi nào bạn nên xem ngày ký hợp đồng?
                            </h2>
                            <ul class="mb-2">
                                <li>Ký hợp đồng mua bán nhà – đất</li>
                                <li>Ký hợp đồng lao động</li>
                                <li>Ký hợp đồng kinh doanh – thương mại</li>
                                <li>Ký hợp đồng đầu tư – góp vốn</li>
                                <li>Ký hợp đồng mua xe, mua tài sản lớn</li>
                                <li>Ký văn bản quan trọng giữa hai tổ chức</li>
                            </ul>
                            <p class="mb-3">Với các hợp đồng có giá trị lớn hoặc ảnh hưởng dài lâu, việc xem ngày chuẩn
                                xác lại càng cần thiết.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Cách xem ngày ký hợp đồng: Những yếu tố quan trọng nhất
                            </h2>
                            <ul class="mb-3" style="list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Ưu tiên ngày Hoàng đạo</h3>
                                    <p class="mb-2">Ngày Hoàng đạo mang năng lượng cát lành, giúp:</p>
                                    <ul class="mb-3">
                                        <li>Đối tác dễ đồng thuận</li>
                                        <li>Buổi làm việc diễn ra nhẹ nhàng, vui vẻ</li>
                                        <li>Ký kết nhanh gọn, hợp tác bền lâu</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Chọn ngày có Trực tốt</h3>
                                    <p class="mb-2">Các Trực dưới đây đặc biệt phù hợp cho ký hợp đồng:</p>
                                    <ul class="mb-2">
                                        <li>Trực Mãn → Sự việc đầy đủ, trọn vẹn, thích hợp giao dịch</li>
                                        <li>Trực Thành → Thành tựu, đại cát cho việc chốt hợp đồng</li>
                                        <li>Trực Khai → Mở đầu tốt, thuận lợi đạt thỏa thuận</li>
                                        <li>Trực Kiến → Thích hợp ký kết giấy tờ, khởi đầu mới</li>
                                    </ul>
                                    <p class="mb-3">Với hợp đồng quan trọng, hãy ưu tiên Trực Thành hoặc Trực Khai.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Chọn ngày hợp tuổi, ngũ hành sinh cho bản mệnh</h3>
                                    <p class="mb-2">Ngày hợp tuổi giúp giảm xung khắc, tăng sự hòa hợp và dễ đạt thỏa
                                        thuận.</p>
                                    <ul class="mb-2">
                                        <li>Mệnh Mộc → chọn ngày Thủy hoặc Mộc</li>
                                        <li>Mệnh Hỏa → ngày Mộc hoặc Hỏa</li>
                                        <li>Mệnh Thổ → ngày Hỏa hoặc Thổ</li>
                                        <li>Mệnh Kim → ngày Thổ hoặc Kim</li>
                                        <li>Mệnh Thủy → ngày Kim hoặc Thủy</li>
                                    </ul>
                                    <p class="mb-3">Sự tương sinh, tương hỗ này giúp tăng vận khí, hạn chế tranh chấp và
                                        sai sót.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Chọn ngày có sao cát</h3>
                                    <p class="mb-2">Một số sao cát rất tốt cho ký kết – làm ăn – giao dịch:</p>
                                    <ul class="mb-3">
                                        <li>Thiên Đức, Nguyệt Đức → Quý nhân phù trợ, đàm phán thuận lợi</li>
                                        <li>Thiên Hỷ → Không khí vui vẻ, dễ đồng thuận</li>
                                        <li>Thiên Quan – Thiên Phúc → Hóa giải xung đột, giảm tranh chấp</li>
                                        <li>Lộc Tồn, Hóa Lộc → Tài lộc, hợp đồng mang lại lợi ích kinh tế</li>
                                        <li>Tam Hợp, Lục Hợp → Tăng hòa khí giữa hai bên</li>
                                        <li>Thiên Mã → Tốt cho giao thương, ký kết hợp đồng làm ăn</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Chọn giờ tốt</h3>
                                    <p class="mb-2">Nếu có thể lựa chọn thời gian ký:</p>
                                    <ul class="mb-2">
                                        <li>Ưu tiên giờ Hoàng đạo</li>
                                        <li>Tránh giờ xung tuổi (ví dụ: tuổi Mão tránh giờ Dậu, tuổi Tý tránh giờ Ngọ…)</li>

                                    </ul>
                                    <p class="mb-3">Giờ đẹp giúp buổi ký kết diễn ra thuận lợi, tinh thần đôi bên cũng
                                        thoải mái hơn.
                                    </p>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Những ngày KHÔNG nên ký hợp đồng
                            </h2>
                            <ul class="mb-3" style="list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">
                                        Ngày Hắc đạo
                                    </h3>

                                    <ul class="mb-1">
                                        <li>Câu Trận</li>
                                        <li>Bạch Hổ</li>
                                        <li>Thiên Lao</li>
                                        <li>Nguyên Vũ</li>
                                    </ul>
                                    <p class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-arrow-right"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg> Đây là nhóm ngày xấu dễ gây thị phi, tranh chấp, kiện tụng.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">
                                        Trực xấu
                                    </h3>
                                    <ul class="mb-1">
                                        <li>Trực Phá → Hỏng việc</li>
                                        <li>Trực Nguy → Bất ổn, tiềm ẩn rủi ro</li>
                                        <li>Trực Thu → Hao hụt, thất thoát</li>
                                        <li>Trực Bế → Bế tắc, dễ xảy ra tranh cãi</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">
                                        Ngày xung tuổi
                                    </h3>
                                    <p class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-arrow-right"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg> Hai bên dễ bất đồng, ký kết không thuận lợi.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">
                                        Tránh ngày kỵ
                                    </h3>
                                    <ul class="mb-1">
                                        <li>Tam Nương: 3 – 7 – 13 – 18 – 22 – 27</li>
                                        <li>Nguyệt Kỵ: 5 – 14 – 23</li>
                                        <li>Dương Công Kỵ Nhật:</li>
                                    </ul>
                                    <p class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-arrow-right"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg> Đây là những ngày đại kỵ ký kết, dễ gặp cản trở hoặc phát sinh kiện tụng về
                                        sau.</p>
                                </li>
                            </ul>





                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn sử dụng công cụ xem ngày ký hợp đồng trên Phong Lịch
                            </h2>
                            <ul style="	list-style-type: decimal;" class="mb-1">
                                <li>Chọn tuổi người ký</li>
                                <li>Chọn khoảng thời gian dự kiến ký kết</li>
                                <li>Hệ thống tự động phân tích:
                                    <ul>
                                        <li>Hoàng đạo – hắc đạo</li>
                                        <li>Trực tốt – xấu</li>
                                        <li>Sao cát – sao hung</li>
                                        <li>Ngũ hành hợp tuổi</li>
                                        <li>Giờ tốt – giờ xung tuổi</li>
                                    </ul>
                                </li>
                                <li>Công cụ gợi ý những ngày đẹp nhất, kèm điểm tốt – xấu và lưu ý chi tiết.</li>
                            </ul>
                            <p class="mb-3 mt-2">Bạn chỉ cần chọn ngày phù hợp nhất với kế hoạch làm việc của hai bên.
                            </p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Chọn đúng ngày ký hợp đồng mang lại gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Giao dịch suôn sẻ – rõ ràng</li>
                                <li>Đối tác dễ đồng thuận, tinh thần thoải mái</li>
                                <li>Hạn chế sai sót, tranh chấp, đứt đoạn thỏa thuận</li>
                                <li>Thu hút tài lộc, lợi ích lâu dài</li>
                                <li>Tạo nền tảng cho hợp tác bền vững giữa hai bên</li>
                            </ul>
                        </div>
                    </div>




                </div>
                @include('tools.siderbarindex')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.8') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we have hash parameters to avoid setting defaults
            const hasHashParams = window.location.hash && window.location.hash.includes('birthdate');

            // Initialize the lunar-solar date selector
            const dateSelector = new LunarSolarDateSelect({
                daySelectId: 'ngaySelect',
                monthSelectId: 'thangSelect',
                yearSelectId: 'namSelect',
                hiddenInputId: 'ngayXem',
                solarRadioId: 'solarCalendar',
                lunarRadioId: 'lunarCalendar',
                leapCheckboxId: 'leapMonth',
                leapContainerId: 'leapMonthContainer',
                defaultDay: hasHashParams ? null : 1,
                defaultMonth: hasHashParams ? null : 1,
                defaultYear: hasHashParams ? null : 2000,
                yearRangeStart: 1900,
                yearRangeEnd: new Date().getFullYear(),
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                monthInfoContainerId: 'monthInfoContainer',
                csrfToken: '{{ csrf_token() }}',
            });

            // ========== DATE RANGE PICKER ==========
            // Initialize vanilla daterangepicker for date_range
            const dateRangeInput = document.getElementById('date_range');
            let dateRangePickerInstance = null;
            let dateRangeInitAttempts = 0;
            const maxDateRangeAttempts = 10;

            function initDateRangePicker() {
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    if (dateRangeInput) {
                        dateRangeInput.removeAttribute('readonly');
                        dateRangeInput.placeholder = 'DD/MM/YY - DD/MM/YY';
                    }
                    return;
                }

                dateRangeInitAttempts++;

                if (typeof window.VanillaDateRangePicker !== 'undefined') {
                    try {
                        dateRangePickerInstance?.destroy?.();

                        const config = {
                            autoApply: true,
                            showDropdowns: true,
                            linkedCalendars: false,
                            singleDatePicker: false,
                            locale: {
                                format: 'DD/MM/YY',
                                separator: ' - ',
                                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                                    'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11',
                                    'Tháng 12'
                                ],
                                firstDay: 1
                            }
                        };

                        dateRangePickerInstance = new window.VanillaDateRangePicker(dateRangeInput, config);
                    } catch (error) {
                        dateRangeInitAttempts = maxDateRangeAttempts;
                    }
                } else {
                    setTimeout(initDateRangePicker, 500);
                }
            }

            // Initialize after a short delay to ensure library is loaded
            setTimeout(initDateRangePicker, 100);

            // ========== HASH PARAMETER HANDLING ==========

            // Function to parse hash parameters
            function parseHashParams() {
                const hash = window.location.hash.substring(1);
                const params = {};
                if (hash) {
                    const pairs = hash.split('&');
                    for (const pair of pairs) {
                        const [key, value] = pair.split('=');
                        if (key && value) {
                            params[decodeURIComponent(key)] = decodeURIComponent(value);
                        }
                    }
                }
                return params;
            }

            // Function to set hash parameters
            function setHashParams(params) {
                const hashParts = [];
                for (const [key, value] of Object.entries(params)) {
                    if (value) {
                        hashParts.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
                    }
                }
                window.location.hash = hashParts.join('&');
            }

            // Function to restore form from hash parameters
            function restoreFromHash() {
                const params = parseHashParams();

                // Restore calendar type from hash first
                if (params.calendar_type) {
                    const solarRadio = document.getElementById('solarCalendar');
                    const lunarRadio = document.getElementById('lunarCalendar');

                    if (params.calendar_type === 'lunar' && lunarRadio) {
                        lunarRadio.checked = true;
                        solarRadio.checked = false;
                        // Update the dateSelector instance state
                        if (dateSelector) {
                            dateSelector.isLunar = true;
                        }
                    } else if (params.calendar_type === 'solar' && solarRadio) {
                        solarRadio.checked = true;
                        lunarRadio.checked = false;
                        // Update the dateSelector instance state
                        if (dateSelector) {
                            dateSelector.isLunar = false;
                        }
                    }
                }

                if (params.name || params.birthdate || params.khoang) {
                    let formRestored = false;
                    let nameSet = false;
                    let birthdateSet = false;
                    let dateRangeSet = false;

                    // Restore name if exists
                    if (params.name) {
                        const nameInput = document.getElementById('person_name');
                        if (nameInput) {
                            nameInput.value = params.name;
                        }
                        nameSet = true;
                    } else {
                        nameSet = true;
                    }

                    if (params.birthdate) {
                        // Use the dateSelector's method to properly restore and convert the date
                        function tryRestoreBirthdate(attempts = 0) {
                            const maxAttempts = 20;

                            if (attempts >= maxAttempts) {
                                birthdateSet = true;
                                checkAndSubmitForm();
                                return;
                            }

                            // Check if dateSelector is available and fully initialized
                            if (dateSelector && dateSelector.daySelect && dateSelector.monthSelect && dateSelector
                                .yearSelect &&
                                dateSelector.yearSelect.options.length > 1) {

                                // Parse birthdate from URL (always in solar format from URL)
                                const dateParts = params.birthdate.split('/');
                                if (dateParts.length === 3) {
                                    const day = parseInt(dateParts[0]);
                                    const month = parseInt(dateParts[1]);
                                    const year = parseInt(dateParts[2]);

                                    (async () => {
                                        try {
                                            if (params.calendar_type === 'lunar') {
                                                // Date from URL is solar date, need to convert to lunar using API
                                                // First set as solar date in selects
                                                await dateSelector.setDate(day, month, year, false, false);

                                                // Use LunarSolarDateSelect's handleLunarRadioChange method for conversion
                                                try {
                                                    // First set solar date in selects
                                                    await dateSelector.setDate(day, month, year, false,
                                                        false);

                                                    // Then switch to lunar mode - this will trigger automatic conversion
                                                    const lunarRadio = document.getElementById(
                                                        'lunarCalendar');
                                                    const solarRadio = document.getElementById(
                                                        'solarCalendar');
                                                    if (lunarRadio && solarRadio) {
                                                        lunarRadio.checked = true;
                                                        solarRadio.checked = false;

                                                        // Trigger the built-in conversion method
                                                        if (dateSelector && typeof dateSelector
                                                            .handleLunarRadioChange === 'function') {
                                                            await dateSelector.handleLunarRadioChange();
                                                        }
                                                    }
                                                } catch (error) {
                                                    // Fallback: just set as lunar without conversion
                                                    await dateSelector.setDate(day, month, year, true,
                                                        false);
                                                }

                                            } else {
                                                // Use solar date directly
                                                await dateSelector.setDate(day, month, year, false, false);

                                                // Ensure radio button stays checked and update instance state
                                                const lunarRadio = document.getElementById('lunarCalendar');
                                                const solarRadio = document.getElementById('solarCalendar');
                                                if (lunarRadio && solarRadio) {
                                                    solarRadio.checked = true;
                                                    lunarRadio.checked = false;
                                                    // Update dateSelector instance state to solar
                                                    dateSelector.isLunar = false;
                                                }
                                            }

                                            await dateSelector.updateHiddenInput();
                                            birthdateSet = true;
                                            checkAndSubmitForm();
                                        } catch (error) {
                                            birthdateSet = true;
                                            checkAndSubmitForm();
                                        }
                                    })();
                                } else {
                                    birthdateSet = true;
                                    checkAndSubmitForm();
                                }
                            } else {
                                // DateSelector not ready yet, try again
                                setTimeout(() => tryRestoreBirthdate(attempts + 1), 300);
                            }
                        }

                        tryRestoreBirthdate();
                    } else {
                        birthdateSet = true;
                    }

                    if (params.khoang) {
                        // Set date range with retry
                        function trySetDateRange(attempts = 0) {
                            const maxAttempts = 5;
                            if (attempts >= maxAttempts) return;

                            const khoangInput = document.getElementById('date_range');
                            if (khoangInput) {
                                khoangInput.value = params.khoang;
                                dateRangeSet = true;
                                checkAndSubmitForm();
                            } else {
                                setTimeout(() => trySetDateRange(attempts + 1), 200);
                            }
                        }

                        trySetDateRange();
                    } else {
                        dateRangeSet = true;
                    }

                    // Function to check if all fields are set and submit form
                    function checkAndSubmitForm() {
                        if (nameSet && birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('contractSigningForm');
                                if (form) {
                                    form.requestSubmit();
                                }
                            }, 500);
                        }
                    }
                }
            }

            // Restore form from hash on page load
            setTimeout(restoreFromHash, 1000);

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('contractSigningForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get person name value
                const personNameInput = document.getElementById('person_name');
                const personNameValue = personNameInput.value.trim();

                if (!personNameValue) {
                    alert('Vui lòng nhập tên người ký hợp đồng');
                    return;
                }

                // Get birthdate value
                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput.value;

                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput.value;

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian');
                    return;
                }

                // Get the date and calendar type based on current selection
                let formattedBirthdate = '';
                let calendarType = 'solar'; // default
                let isLeapMonth = false;

                // Determine calendar type from radio buttons
                const solarRadio = document.getElementById('solarCalendar');
                const lunarRadio = document.getElementById('lunarCalendar');

                if (lunarRadio && lunarRadio.checked) {
                    calendarType = 'lunar';
                } else if (solarRadio && solarRadio.checked) {
                    calendarType = 'solar';
                }

                if (calendarType === 'lunar') {
                    // For lunar date, use the converted solar date for URL (easier to read/share)
                    const solarDay = ngayXemInput.dataset.solarDay;
                    const solarMonth = ngayXemInput.dataset.solarMonth;
                    const solarYear = ngayXemInput.dataset.solarYear;
                    isLeapMonth = ngayXemInput.dataset.lunarLeap === '1';

                    if (solarDay && solarMonth && solarYear) {
                        formattedBirthdate =
                            `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}`;
                    } else {
                        // Fallback to parsing lunar date from value
                        formattedBirthdate = ngayXemValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
                        isLeapMonth = ngayXemValue.includes('(ÂL-Nhuận)');
                    }
                } else {
                    // Solar date can be used directly
                    formattedBirthdate = ngayXemValue;
                }

                // Parse date range
                const dateRangeParts = dateRangeValue.split(' - ');
                let startDate = '';
                let endDate = '';

                if (dateRangeParts.length === 2) {
                    // Parse start date (format: dd/mm/yy)
                    const startParts = dateRangeParts[0].trim().split('/');
                    if (startParts.length === 3) {
                        const day = startParts[0].padStart(2, '0');
                        const month = startParts[1].padStart(2, '0');
                        let year = startParts[2];
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        startDate = `${day}/${month}/${year}`;
                    }

                    // Parse end date
                    const endParts = dateRangeParts[1].trim().split('/');
                    if (endParts.length === 3) {
                        const day = endParts[0].padStart(2, '0');
                        const month = endParts[1].padStart(2, '0');
                        let year = endParts[2];
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        endDate = `${day}/${month}/${year}`;
                    }
                }

                // Get sort value if exists
                const sortSelect = resultsContainer.querySelector('[name="sort"]');
                const sortValue = sortSelect ? sortSelect.value : 'desc';

                // Prepare form data
                const formData = {
                    person_name: personNameValue,
                    birthdate: formattedBirthdate,
                    calendar_type: calendarType,
                    leap_month: isLeapMonth,
                    date_range: dateRangeValue,
                    start_date: startDate,
                    end_date: endDate,
                    sort: sortValue,
                    _token: '{{ csrf_token() }}'
                };

                // Set hash parameters for URL state
                const hashParams = {
                    name: personNameValue,
                    birthdate: formattedBirthdate,
                    khoang: dateRangeValue,
                    calendar_type: calendarType
                };
                setHashParams(hashParams);

                // Show loading state
                submitBtn.disabled = true;
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                // Submit via AJAX
                fetch('{{ route('ky-hop-dong.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Reset button state
                        submitBtn.disabled = false;
                        btnText.textContent = 'Xem Kết Quả';
                        spinner.classList.add('d-none');

                        if (data.success) {
                            // Show results container
                            resultsContainer.style.display = 'block';
                            resultsContainer.innerHTML = data.html;

                            // Store data for taboo filter
                            window.resultsByYear = data.resultsByYear;

                            // Scroll to results with delay to ensure content is rendered
                            setTimeout(() => {
                                const contentBoxSuccess = document.getElementById(
                                    'content-box-success');
                                if (contentBoxSuccess) {
                                    contentBoxSuccess.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                } else {
                                    resultsContainer.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }
                            }, 600);
                            // setTimeout(() => {
                            //     resultsContainer.scrollIntoView({
                            //         behavior: 'smooth',
                            //         block: 'start'
                            //     });


                            // }, 500);

                            // Re-initialize Bootstrap tabs if present
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });
                            setTimeout(() => {

                                resultsContainer.innerHTML = data.html;
                                setTimeout(() => {
                                    if (typeof window.initTabooFilter === 'function') {
                                        window.initTabooFilter(data.resultsByYear);
                                    }
                                    initPagination();
                                    setupContainerEventDelegation();
                                }, 200);
                            }, 500);
                        } else if (data.errors) {
                            // Show validation errors
                            let errorMessage = 'Vui lòng kiểm tra lại:\\n';
                            for (const field in data.errors) {
                                errorMessage += '- ' + data.errors[field][0] + '\\n';
                            }
                            alert(errorMessage);
                        } else if (data.message) {
                            alert(data.message);
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        // Reset button state
                        submitBtn.disabled = false;
                        btnText.textContent = 'Xem Kết Quả';
                        spinner.classList.add('d-none');

                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    });
            });

            // Setup container-level event delegation like other working tools
            function setupContainerEventDelegation() {
                console.log('Setting up container event delegation');

                const resultContainer = document.querySelector('.--detail-success');
                if (resultContainer) {
                    console.log('Result container found, setting up event delegation');

                    // Remove any existing listeners first
                    resultContainer.removeEventListener('change', handleContainerChange);

                    // Add new listener
                    resultContainer.addEventListener('change', handleContainerChange);
                    console.log('Container event delegation setup complete');
                } else {
                    console.log('Result container not found');
                }
            }

            function handleContainerChange(event) {


                if (event.target.name === 'sort') {
                    console.log('Sort dropdown changed to:', event.target.value);
                    event.preventDefault();
                    event.stopPropagation();

                    // Find the current active year for multi-year support
                    const activeTab = document.querySelector('.tab-pane.active');
                    if (activeTab) {
                        const yearMatch = activeTab.id.match(/year-(\d+)/);
                        if (yearMatch) {
                            const currentYear = yearMatch[1];
                            console.log('Applying sort to year:', currentYear);
                            applySortingToTable(event.target.value, currentYear);
                        } else {
                            applySortingToTable(event.target.value);
                        }
                    } else {
                        applySortingToTable(event.target.value);
                    }

                    // Scroll to table after sort
                    setTimeout(() => {
                        const bangChiTiet = document.querySelector('#bang-chi-tiet');
                        bangChiTiet?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            }

            function getScoreFromRow(row) {
                // Try to find score in battery element
                const battery = row.querySelector('.battery-label');
                if (battery) {
                    return parseInt(battery.textContent.replace('%', '')) || 0;
                }

                // Try to find score in other score elements
                const scoreElement = row.querySelector('.diem-so, .score');
                if (scoreElement) {
                    return parseInt(scoreElement.textContent.replace(/[^\d]/g, '')) || 0;
                }

                // Try to find score in any cell containing numbers
                const cells = row.querySelectorAll('td');
                for (let cell of cells) {
                    const text = cell.textContent.trim();
                    const match = text.match(/(\d+)/);
                    if (match) {
                        return parseInt(match[1]) || 0;
                    }
                }

                return 0;
            }

            function applySortingToTable(sortValue, year = null, maintainCurrentPagination = true) {
                console.log('applySortingToTable called with:', sortValue, 'year:', year);

                // Try multiple ways to find the table like other working tools
                let table = null;

                // If year is provided, target specific year table
                if (year) {
                    table = document.querySelector(`#table-${year} tbody`);
                    console.log('Looking for year-specific table:', `#table-${year} tbody`);
                }

                // Method 1: Direct search if no year or year-specific table not found
                if (!table) {
                    table = document.querySelector('#bang-chi-tiet table tbody');
                }

                // Method 2: Any table in results container
                if (!table) {
                    const resultsContainer = document.querySelector('.--detail-success');
                    if (resultsContainer) {
                        table = resultsContainer.querySelector('table tbody');
                    }
                }

                // Method 3: Try to find table in active tab if still not found
                if (!table) {
                    const activeTab = document.querySelector('.tab-pane.active');
                    if (activeTab) {
                        table = activeTab.querySelector('table tbody');
                    }
                }

                if (!table) {
                    console.log('No table found for sorting');
                    return;
                }

                // Chỉ lấy các rows đang visible (không bị ẩn bởi taboo filter)
                const rows = Array.from(table.querySelectorAll('tr')).filter(row => {
                    return row.style.display !== 'none' && !row.classList.contains('empty-filter-row');
                });
                console.log(`Found ${rows.length} visible rows to sort`);

                rows.sort((a, b) => {
                    if (sortValue === 'date_asc' || sortValue === 'date_desc') {
                        const dateA = getDateFromRow(a);
                        const dateB = getDateFromRow(b);
                        const result = sortValue === 'date_asc' ? dateA - dateB : dateB - dateA;
                        console.log(`Sorting ${dateA} vs ${dateB} = ${result}`);
                        return result;
                    } else {
                        const scoreA = getScoreFromRow(a);
                        const scoreB = getScoreFromRow(b);
                        return sortValue === 'asc' ? scoreA - scoreB : scoreB - scoreA;
                    }
                });

                // Lưu tất cả rows (bao gồm hidden) trước khi sort
                const allRows = Array.from(table.querySelectorAll('tr'));
                const hiddenRows = allRows.filter(row => {
                    return row.style.display === 'none' || row.classList.contains('empty-filter-row');
                });

                // Clear table và append lại: sorted visible rows + hidden rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));
                hiddenRows.forEach(row => table.appendChild(row));

                // Maintain current pagination if specified
                if (maintainCurrentPagination) {
                    maintainCurrentPaginationState(table);
                }
            }

            function getDateFromRow(row) {
                // Try different ways to find the date - same as other working tools

                // Method 1: Look for link with details
                let dateText = row.querySelector('a[href*="details"] strong');
                if (dateText) {
                    const text = dateText.textContent;
                    console.log('Method 1 - Date text found:', text);
                    const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                    if (match) {
                        const dateStr = match[1];
                        const parts = dateStr.split('/');
                        const date = new Date(parts[2], parts[1] - 1, parts[0]);
                        console.log('Parsed date:', dateStr, '->', date);
                        return date;
                    }
                }

                // Method 2: Look for any strong element with date pattern
                const allStrong = row.querySelectorAll('strong');
                for (let strong of allStrong) {
                    const text = strong.textContent;
                    const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                    if (match) {
                        console.log('Method 2 - Date text found:', text);
                        const dateStr = match[1];
                        const parts = dateStr.split('/');
                        const date = new Date(parts[2], parts[1] - 1, parts[0]);
                        console.log('Parsed date:', dateStr, '->', date);
                        return date;
                    }
                }

                // Method 3: Look for any text with date pattern
                const allText = row.textContent;
                const match = allText.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                if (match) {
                    console.log('Method 3 - Date found in row text:', match[1]);
                    const dateStr = match[1];
                    const parts = dateStr.split('/');
                    const date = new Date(parts[2], parts[1] - 1, parts[0]);
                    console.log('Parsed date:', dateStr, '->', date);
                    return date;
                }

                console.log('No date found in row:', row.innerHTML.substring(0, 200));
                return new Date();
            }

            // Pagination functions
            function initPagination() {
                const resultsContainer = document.querySelector('.--detail-success');
                resultsContainer.addEventListener('click', function(event) {
                    if (event.target.matches('.load-more-btn') || event.target.closest('.load-more-btn')) {
                        const btn = event.target.matches('.load-more-btn') ? event.target : event.target
                            .closest('.load-more-btn');
                        const year = btn.getAttribute('data-year');
                        const currentLoaded = parseInt(btn.getAttribute('data-loaded'));
                        const total = parseInt(btn.getAttribute('data-total'));
                        const loadMore = Math.min(10, total - currentLoaded);

                        // Show next 10 items
                        const table = document.querySelector(`#table-${year} tbody`);
                        if (table) {
                            const allRows = table.querySelectorAll('.table-row-' + year);
                            for (let i = currentLoaded; i < currentLoaded + loadMore; i++) {
                                if (allRows[i]) {
                                    allRows[i].style.display = '';
                                    allRows[i].setAttribute('data-visible', 'true');
                                }
                            }

                            const newLoaded = currentLoaded + loadMore;
                            btn.setAttribute('data-loaded', newLoaded);

                            // Update button text
                            const remaining = total - newLoaded;
                            if (remaining > 0) {
                                const nextLoad = Math.min(10, remaining);
                                btn.innerHTML =
                                    `Xem thêm`;
                            } else {
                                btn.style.display = 'none';
                            }
                        }
                    }
                });
            }

            function maintainCurrentPaginationState(table) {
                // Kiểm tra xem có đang trong filter state không cho tab hiện tại
                const activeTab = document.querySelector('.tab-pane.active');
                let filterStatus = document.getElementById('filterStatus');

                // Nếu có multi-year tabs, check filter status cho year hiện tại
                if (activeTab) {
                    const yearMatch = activeTab.id.match(/year-(\d+)/);
                    if (yearMatch) {
                        const currentYear = yearMatch[1];
                        filterStatus = document.getElementById(`filterStatus-${currentYear}`) || filterStatus;
                    }
                }

                const isFilterActive = filterStatus && !filterStatus.classList.contains('d-none');

                // Nếu filter đang active, không can thiệp vào pagination
                // Vì taboo component đã quản lý rồi
                if (isFilterActive) {
                    return;
                }

                const loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                if (!loadMoreBtn) {
                    console.log('No load more button found');
                    return;
                }

                let currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;

                // Đếm TOTAL filtered rows TRƯỚC khi thay đổi pagination
                const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                const totalFilteredRows = parseInt(loadMoreBtn.getAttribute('data-total')) || Array.from(allRows)
                    .filter(row => {
                        return row.style.display !== 'none';
                    }).length;

                console.log(
                    `Maintaining pagination: ${currentLoaded} out of ${totalFilteredRows} filtered rows (${allRows.length} total)`
                );

                // Show rows according to current pagination state
                allRows.forEach((row, index) => {
                    if (index >= currentLoaded) {
                        row.style.display = 'none';
                        row.setAttribute('data-visible', 'false');
                    } else {
                        row.style.display = '';
                        row.setAttribute('data-visible', 'true');
                    }
                });

                // Update load more button với total filtered rows
                const remaining = totalFilteredRows - currentLoaded;
                if (remaining > 0) {
                    const nextLoad = Math.min(10, remaining);
                    loadMoreBtn.innerHTML =
                        `Xem thêm`;
                    loadMoreBtn.style.display = '';
                    loadMoreBtn.setAttribute('data-total', totalFilteredRows.toString());
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }
        });
    </script>
    @include('components.taboo-filter-script')
@endpush
