@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.7') }}">
    @endpush


    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('totxau.list') }}"  style="color: #2254AB; text-decoration: underline;">Xem ngày tốt</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày tốt xấu
                </li>
            </ol>
        </nav>



        <h1 class="content-title-home-lich">Xem Ngày Tốt – Kiểm Tra Ngày Đẹp, Ngày Xấu Chính Xác</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold  title-tong-quan-h2-log" style="#192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form id="totXauForm">
                                            <div class="mb-3">
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
                                                        <input type="radio" class="form-check-input" name="calendar_type"
                                                            id="solarCalendar" value="solar" checked
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="solarCalendar"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Dương lịch
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendar_type"
                                                            id="lunarCalendar" value="lunar"
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="lunarCalendar"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Âm lịch
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Leap Month Option (hidden) -->
                                                <div class="form-check mt-2" id="leapMonthContainer" style="display: none;">
                                                    <input class="form-check-input" type="checkbox" id="leapMonth"
                                                        name="leap_month">
                                                    <label class="form-check-label" for="leapMonth">
                                                        Tháng nhuận
                                                    </label>
                                                </div>

                                                <!-- Hidden input to store formatted date -->
                                                <input type="hidden" id="ngayXem" name="birthdate"
                                                    value="{{ old('birthdate', $inputs['birthdate'] ?? '') }}">
                                            </div>

                                            <div class="fw-bold title-tong-quan-h4-log" style="color: #192E52; padding-bottom: 12px;">Khoảng thời gian cần xem
                                            </div>
                                            <div class="mb-4">
                                                <div class="input-group">
                                                    <input type="text" readonly
                                                        class="form-control wedding_date_range --border-box-form"
                                                        id="khoangNgay" name="date_range" placeholder="DD/MM/YY - DD/MM/YY"
                                                        autocomplete="off"
                                                        value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                        style="border-radius: 10px; border: none; padding: 12px 30px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                    <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 2px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                       <img src="{{ asset('images/date1-icon.svg') }}" alt="icon ngày tháng năm" class="img-fluid">
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-light-settup fw-bold w-100">
                                                    Xem Ngày Tốt
                                                </button>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-4 d-none d-lg-flex">
                                <div class="d-flex align-items-center justify-content-center h-100 w-100"
                                    style="padding: 32px 32px 32px 0px;">
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_totxau.svg);
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




                    <div class="--detail-success">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Vì sao nên xem ngày tốt – xấu trước khi bắt đầu một việc quan trọng?
                            </h2>
                            <p class="mb-1">Trong đời sống hàng ngày, có nhiều việc không nằm trong các nhóm công việc
                                quen thuộc như
                                cưới hỏi, nhập trạch, khai trương… Người dùng đôi khi chỉ muốn biết ngày hôm đó tốt hay xấu,
                                hoặc đang cân nhắc trong một khoảng thời gian để chọn ra ngày đẹp nhất cho kế hoạch của
                                mình.</p>
                            <p class="mb-1">Một ngày tốt mang lại sự an tâm, tinh thần thoải mái và cảm giác “thuận trời
                                – thuận thời
                                điểm”. Ngược lại, những ngày có nhiều yếu tố xấu có thể khiến bạn do dự, hoặc muốn tránh để
                                mọi việc diễn ra suôn sẻ hơn.</p>
                            <p class="mb-1">Vì vậy, một công cụ xem ngày tốt – xấu chung giúp bạn linh hoạt lựa chọn thời
                                điểm phù hợp
                                cho bất kỳ công việc, dự định hoặc hành động nào trong cuộc sống.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích khi xem ngày tốt – xấu cho các việc khác nhau
                            </h2>
                            <ul class="mb-1">
                                <li>
                                    <p class="mb-0"> Chủ động chọn thời điểm thuận lợi</p>
                                    <p class="mb-0">Dù là đi xa, bắt đầu dự án, sửa nhà, mở sổ tiết kiệm hay chỉ đơn giản
                                        là muốn tìm ngày với năng lượng tốt bạn đều có thể xem trước để sắp xếp hợp lý.</p>
                                </li>
                                <li>
                                    <p class="mb-0"> Giảm rủi ro – tăng an tâm
                                    </p>
                                    <p class="mb-0">Một ngày đẹp thường ít phạm các sao xấu, không trùng với các ngày
                                        kiêng kỵ trong dân gian, giúp tâm lý vững vàng hơn.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Hỗ trợ phong thủy cá nhân
                                    </p>
                                    <p class="mb-0">Ngày hợp tuổi, ngũ hành hài hòa giúp công việc dễ hanh thông và giảm
                                        xung khắc.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Phù hợp cho nhiều nhu cầu linh hoạt
                                    </p>
                                    <p class="mb-0">Không cần phải có mục đích cụ thể, chỉ cần muốn biết ngày nào tốt,
                                        ngày nào nên hạn chế làm việc quan trọng.
                                    </p>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi xem ngày tốt – xấu cần chú ý những yếu tố nào?
                            </h2>
                            <h3 class="title-tong-quan-h4-log mb-1 mt-1">1. Ngày Hoàng đạo – Hắc đạo</h3>
                            <p class="mb-1">Ngày Hoàng đạo thường mang năng lượng cát lành, phù hợp cho mọi việc. <br>
                                Ngày Hắc đạo nên cân nhắc nếu bạn có việc quan trọng.
                            </p>
                            <h3 class="title-tong-quan-h4-log mb-1 mt-1">2. Trực của ngày</h3>
                            <ul class="mb-1">
                                <li>Trực tốt: Trực Khai, Thành, Mãn, Định → thuận lợi, dễ làm việc mới.</li>
                                <li>Trực xấu: Trực Phá, Nguy, Bế, Thu → nên hạn chế làm việc lớn.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log mb-1 mt-1">3. Sao tốt – sao xấu trong ngày</h3>
                            <ul class="mb-1">
                                <li>Nhiều sao cát bổ trợ năng lượng như: Thiên Đức, Nguyệt Đức, Thiên Hỷ, Phúc Hỷ, Tam Hợp,
                                    Lục Hợp.</li>
                                <li>
                                    Những sao xấu nên tránh: Thiên Cương, Không Vong, Cô Thần – Quả Tú, Nguyệt Hình…
                                </li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log mb-1 mt-1">4. Ngày xung tuổi – hợp tuổi</h3>
                            <p class="mb-1">Ngày hợp tuổi giúp công việc thuận lợi. Ngược lại, ngày xung tuổi nên tránh
                                nếu bạn định làm việc quan trọng.
                            </p>
                            <h3 class="title-tong-quan-h4-log mb-1 mt-1">5. Ngày kiêng kỵ trong dân gian</h3>
                            <p class="mb-1">Nên chú ý các ngày: Tam Nương, Nguyệt Kỵ, Dương Công Kỵ Nhật. Đây là những
                                ngày thường được coi là ít may mắn.
                            </p>
                            <h2 class="title-tong-quan-h3-log mb-1 mt-1 fw-bolder">
                                Hướng dẫn sử dụng công cụ Xem Ngày Tốt – Xấu tại Phong Lịch
                            </h2>
                            <ul style="list-style-type: decimal;" class="mb-1">
                                <li>
                                    Nhập ngày hoặc khoảng thời gian bạn muốn xem.
                                </li>
                                <li>
                                    Chọn tuổi (nếu bạn muốn xem chi tiết theo hợp – xung).
                                </li>
                                <li>
                                    Hệ thống sẽ tự động phân tích và hiển thị:
                                    <ul>
                                        <li>Điểm tốt – xấu của ngày.</li>
                                        <li>Ngày Hoàng đạo – Hắc đạo.</li>
                                        <li>Sao tốt/xấu và trực của ngày.</li>
                                        <li>Ngũ hành ngày và sự hợp – xung với tuổi của bạn.</li>
                                        <li>Gợi ý nên hay không nên làm việc quan trọng trong ngày.</li>
                                    </ul>
                                </li>
                                <li>Chọn ngày phù hợp nhất theo đánh giá của công cụ và lịch trình cá nhân của bạn.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log mb-1 mt-1 fw-bolder">
                                Một ngày đẹp giúp ích như thế nào?
                            </h2>
                            <ul>
                                <li>Tạo cảm giác yên tâm, tinh thần thoải mái.</li>
                                <li>Tăng khả năng thuận lợi khi bắt đầu việc quan trọng.</li>
                                <li>Hạn chế rủi ro và xung khắc.</li>
                                <li>Mang lại sự hài hòa giữa thời điểm – tuổi – ngũ hành.</li>
                            </ul>
                            <p>Dù bạn dùng công cụ để xem cho bất kỳ việc gì, lớn hay nhỏ. Một ngày tốt luôn là nền tảng
                                giúp mọi việc dễ dàng và thuận lợi hơn.</p>
                        </div>
                    </div>

                </div>

                @include('tools.siderbarindex')
            </div>
        </div>
    </div>

    <!-- Global Calendar Popup for all date inputs -->
    <div class="global-calendar" id="globalCalendar" style="display: none;">
        <div class="calendar-header">
            <button type="button" class="btn-nav" id="globalPrevMonth">&lt;</button>
            <span class="month-year" id="globalMonthYear">Tháng 10 2025</span>
            <button type="button" class="btn-nav" id="globalNextMonth">&gt;</button>
        </div>
        <div class="calendar-weekdays">
            <div class="weekday">CN</div>
            <div class="weekday">T2</div>
            <div class="weekday">T3</div>
            <div class="weekday">T4</div>
            <div class="weekday">T5</div>
            <div class="weekday">T6</div>
            <div class="weekday">T7</div>
        </div>
        <div class="calendar-days" id="globalCalendarDays">
            <!-- Days will be generated by JavaScript -->
        </div>
        <div class="calendar-footer">
            <button type="button" class="btn-calendar btn-clear" id="globalClearDate">Xóa</button>
            <button type="button" class="btn-calendar btn-today" id="globalTodayDate">Hôm nay</button>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- Load the lunar-solar date select module --}}
    <script src="{{ asset('js/lunar-solar-date-select.js?v=1.3') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.7') }}" defer></script>


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

            // ========== DATE SELECTOR POPUP FOR NGAYXEM ==========

            // ========== DATE RANGE PICKER ==========
            // Initialize vanilla daterangepicker for Khoảng Ngày
            const khoangNgayInput = document.getElementById('khoangNgay');
            let dateRangePickerInstance = null;
            let dateRangeInitAttempts = 0;
            const maxDateRangeAttempts = 10;

            // Optimized date range picker initialization
            function initDateRangePicker() {
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    // Fallback to manual input
                    if (khoangNgayInput) {
                        khoangNgayInput.removeAttribute('readonly');
                        khoangNgayInput.placeholder = 'DD/MM/YY - DD/MM/YY';
                    }
                    return;
                }

                dateRangeInitAttempts++;

                if (typeof window.VanillaDateRangePicker !== 'undefined') {
                    try {
                        // Destroy existing instance
                        dateRangePickerInstance?.destroy?.();

                        // Common configuration
                        const config = {
                            autoApply: true,
                            showDropdowns: true,
                            linkedCalendars: false,
                            singleDatePicker: false,
                            locale: {
                                format: 'DD/MM/YY',
                                separator: ' - ',
                                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                                ],
                                firstDay: 1
                            }
                        };

                        dateRangePickerInstance = new window.VanillaDateRangePicker(khoangNgayInput, config);
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

                if (params.birthdate || params.khoang) {
                    let formRestored = false;
                    let birthdateSet = false;
                    let dateRangeSet = false;

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
                                                    // Conversion error, using fallback
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

                            const khoangInput = document.getElementById('khoangNgay');
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
                        if (birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('totXauForm');
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

            // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
            // No need for additional logic here as the module handles all conversions automatically

            // ========== SỬ DỤNG TABOO FILTER COMPONENT ==========
            // Không cần định nghĩa lại function, sử dụng component đã include

            // ========== FORM HANDLING ==========
            const form = document.getElementById('totXauForm');
            const khoangNgay = document.getElementById('khoangNgay');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            // Handle form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput.value;

                // Validate Ngày Xem
                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm');
                    return;
                }

                // Validate Date Range
                if (!khoangNgay.value) {
                    alert('Vui lòng chọn khoảng ngày cần xem');
                    return;
                }

                // Get the date and calendar type based on current selection
                let formattedBirthdate = ''; // For form data (backend)
                let urlBirthdate = ''; // For URL hash (sharing)
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

                // Form submission processing

                if (calendarType === 'lunar') {
                    // For lunar calendar:
                    // - ngayXemValue is already SOLAR date (from hidden input .value)
                    // - data-display-value contains the lunar display format

                    const daySelect = document.getElementById('ngaySelect');
                    const monthSelect = document.getElementById('thangSelect');
                    const yearSelect = document.getElementById('namSelect');

                    // Processing lunar mode

                    // Get lunar date from selects (what user actually selected)
                    if (daySelect.value && monthSelect.value && yearSelect.value) {
                        const lunarDay = String(daySelect.value).padStart(2, '0');
                        const lunarMonth = String(monthSelect.value).padStart(2, '0');
                        const lunarYear = yearSelect.value;

                        // Use dateSelector's leap month state instead of manual detection
                        isLeapMonth = dateSelector.isLeapMonth;

                        formattedBirthdate = `${lunarDay}/${lunarMonth}/${lunarYear}`;
                    } else {
                        // Fallback: extract lunar from display value
                        const displayValue = ngayXemInput.dataset.displayValue || '';
                        formattedBirthdate = displayValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)',
                            '');
                        isLeapMonth = displayValue.includes('(ÂL-Nhuận)');
                    }

                    // For URL: use solar date from hidden input .value
                    urlBirthdate = ngayXemValue; // This is already solar!
                } else {
                    // Solar date can be used directly for both
                    formattedBirthdate = ngayXemValue;
                    urlBirthdate = ngayXemValue;
                }

                // The LunarSolarDateSelect module automatically maintains solar date in hidden input
                // No need for additional conversion here - just use the value that's already there
                const finalSolarDate =
                    ngayXemValue; // This is always solar date maintained by the module

                // URL birthdate is the same as final solar date
                if (calendarType === 'lunar') {
                    urlBirthdate = finalSolarDate; // Use solar date for URL sharing
                }


                // Parse date range to get start and end dates
                // Date range format: "28/10/25 - 30/10/25"
                const dateRangeParts = khoangNgay.value.split(' - ');
                let startDate = '';
                let endDate = '';

                if (dateRangeParts.length === 2) {
                    // Parse start date (format: dd/mm/yy)
                    const startParts = dateRangeParts[0].trim().split('/');
                    if (startParts.length === 3) {
                        const day = startParts[0].padStart(2, '0');
                        const month = startParts[1].padStart(2, '0');
                        let year = startParts[2];
                        // Convert 2-digit year to 4-digit
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        startDate = `${day}/${month}/${year}`;
                    }

                    // Parse end date (format: dd/mm/yy)
                    const endParts = dateRangeParts[1].trim().split('/');
                    if (endParts.length === 3) {
                        const day = endParts[0].padStart(2, '0');
                        const month = endParts[1].padStart(2, '0');
                        let year = endParts[2];
                        // Convert 2-digit year to 4-digit
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        endDate = `${day}/${month}/${year}`;
                    }
                } else if (dateRangeParts.length === 1) {
                    // Single date, use it for both start and end
                    const dateParts = dateRangeParts[0].trim().split('/');
                    if (dateParts.length === 3) {
                        const day = dateParts[0].padStart(2, '0');
                        const month = dateParts[1].padStart(2, '0');
                        let year = dateParts[2];
                        // Convert 2-digit year to 4-digit
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        startDate = endDate = `${day}/${month}/${year}`;
                    }
                }

                const sortSelect = document.querySelector('[name="sort"]');
                const sortValue = sortSelect ? sortSelect.value : 'desc';

                // Process form data - birthdate is ALWAYS solar date for backend processing
                let formData = {};

                if (calendarType === 'lunar') {
                    // For lunar: send solar date as birthdate, lunar date as additional info
                    formData = {
                        birthdate: urlBirthdate, // ALWAYS solar date for backend
                        calendar_type: 'lunar',
                        leap_month: isLeapMonth,
                        lunar_date: formattedBirthdate, // Additional info: what user selected in lunar
                        date_range: khoangNgay.value,
                        start_date: startDate,
                        end_date: endDate,
                        sort: sortValue,
                        _token: '{{ csrf_token() }}'
                    };

                } else {
                    // For solar: send solar date as birthdate
                    formData = {
                        birthdate: urlBirthdate, // Solar date (same as what user selected)
                        calendar_type: 'solar',
                        leap_month: false,
                        date_range: khoangNgay.value,
                        start_date: startDate,
                        end_date: endDate,
                        sort: sortValue,
                        _token: '{{ csrf_token() }}'
                    };
                    // Sending solar calendar data
                }

                // Set hash parameters for URL state - preserve original calendar type
                const hashParams = {
                    birthdate: urlBirthdate, // Use solar date for URL (easier to share)
                    khoang: khoangNgay.value,
                    calendar_type: calendarType // This will be 'lunar' or 'solar' based on radio selection
                };
                setHashParams(hashParams);

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

                // Submit to backend using AJAX
                fetch('{{ route('totxau.checkDays') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        if (data.success) {
                            // Update UI with results
                            const resultContainer = document.querySelector('.--detail-success');
                            resultContainer.innerHTML = data.html;

                            // Initialize taboo filter and pagination after results are loaded
                            setTimeout(() => {
                                // Sử dụng global initTabooFilter từ component
                                if (typeof window.initTabooFilter === 'function') {
                                    window.initTabooFilter(data.resultsByYear);
                                }
                                initPagination();
                            }, 200);

                            // Scroll to results with delay to ensure content is rendered
                            setTimeout(() => {
                                // Normal form submission - scroll to general results
                                resultContainer.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 100);
                        } else if (data.errors) {
                            // Show validation errors
                            let errorMessage = 'Vui lòng kiểm tra lại:\n';
                            for (const field in data.errors) {
                                errorMessage += '- ' + data.errors[field][0] + '\n';
                            }
                            alert(errorMessage);
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    });

                // Handle sorting change using event delegation
                // This is already properly optimized with event delegation

                // Move sorting functions to be defined before use
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

                function applySortingToTable(sortValue) {
                    // Tìm tab hiện tại đang active
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    if (!activeTab) {
                        // Fallback cho single table (không có tabs)
                        const table = document.querySelector('#bang-chi-tiet table tbody');
                        if (table) {
                            applySortToSingleTable(table, sortValue);
                        }
                        return;
                    }

                    // Multi-tab case: Lấy năm từ active tab
                    const activeYear = activeTab.id.replace('year-', '');
                    console.log('Sorting for active year:', activeYear);

                    // Tìm table trong active tab
                    const table = activeTab.querySelector('table tbody') ||
                        activeTab.querySelector('.table-body-' + activeYear) ||
                        activeTab.querySelector('#table-' + activeYear + ' tbody');

                    if (!table) {
                        console.log('No table found in active tab for year:', activeYear);
                        return;
                    }

                    applySortToSingleTable(table, sortValue);
                }

                function applySortToSingleTable(table, sortValue) {
                    const rows = Array.from(table.querySelectorAll('tr'));

                    rows.sort((a, b) => {
                        if (sortValue === 'date_asc' || sortValue === 'date_desc') {
                            // Sắp xếp theo ngày
                            const dateA = getDateFromRow(a);
                            const dateB = getDateFromRow(b);
                            return sortValue === 'date_asc' ? dateA - dateB : dateB - dateA;
                        } else {
                            // Sắp xếp theo điểm
                            const scoreA = getScoreFromRow(a);
                            const scoreB = getScoreFromRow(b);
                            return sortValue === 'asc' ? scoreA - scoreB : scoreB - scoreA;
                        }
                    });

                    // Clear và append lại rows đã sắp xếp
                    table.innerHTML = '';
                    rows.forEach(row => table.appendChild(row));

                    // Giữ nguyên số lượng đang hiển thị thay vì reset về 10
                    maintainCurrentPagination(table);
                }

                // Handle sorting change using event delegation
                const resultContainer = document.querySelector('.--detail-success');
                resultContainer.addEventListener('change', function(event) {
                    if (event.target.matches('[name="sort"]')) {
                        const sortValue = event.target.value;

                        // Đồng bộ tất cả dropdown sort về cùng giá trị
                        const allSortSelects = document.querySelectorAll('select[name="sort"]');
                        allSortSelects.forEach(select => {
                            if (select !== event.target) {
                                select.value = sortValue;
                            }
                        });

                        applySortingToTable(sortValue);

                        // Scroll to table after sort
                        setTimeout(() => {
                            // Tìm tab hiện tại và scroll đến table của tab đó
                            const activeTab = document.querySelector(
                                '.tab-pane.show.active');
                            if (activeTab) {
                                const activeYear = activeTab.id.replace('year-', '');
                                const tableContainer = activeTab.querySelector(
                                        `#table-${activeYear}`) ||
                                    activeTab.querySelector('.table-responsive') ||
                                    activeTab.querySelector('#bang-chi-tiet');
                                if (tableContainer) {
                                    tableContainer.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                    return;
                                }
                            }

                            // Fallback cho single table
                            const bangChiTiet = document.querySelector(
                                '#bang-chi-tiet');
                            bangChiTiet?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }, 100);
                    }
                });

                // ========== PHÂN TRANG CHO BẢNG ==========
                function initPagination() {
                    // Sử dụng event delegation để handle động
                    document.addEventListener('click', function(event) {
                        if (event.target.matches('.load-more-btn') || event.target.closest(
                                '.load-more-btn')) {
                            const btn = event.target.matches('.load-more-btn') ? event.target :
                                event.target.closest('.load-more-btn');
                            const year = btn.dataset.year;
                            const loaded = parseInt(btn.dataset.loaded);
                            const total = parseInt(btn.dataset.total);
                            const tbody = document.querySelector(`.table-body-${year}`);

                            if (!tbody) return;

                            const rows = tbody.querySelectorAll('tr');
                            let newLoaded = loaded;

                            // Hiển thị thêm 10 rows tiếp theo
                            for (let i = loaded; i < Math.min(loaded + 10, total); i++) {
                                if (rows[i]) {
                                    rows[i].style.display = '';
                                    rows[i].dataset.visible = 'true';
                                    newLoaded++;
                                }
                            }

                            // Cập nhật dataset và text
                            btn.dataset.loaded = newLoaded;
                            const remaining = total - newLoaded;

                            if (remaining > 0) {
                                btn.innerHTML = `
                                    Xem thêm 
                                `;
                            } else {
                                btn.style.display = 'none';
                            }
                        }
                    });
                }

                // ========== HELPER FUNCTIONS ==========
                function resetPagination(table) {
                    const rows = table.querySelectorAll('tr');

                    // Hiển thị 10 đầu tiên, ẩn phần còn lại
                    rows.forEach((row, index) => {
                        if (index >= 10) {
                            row.style.display = 'none';
                            row.dataset.visible = 'false';
                        } else {
                            row.style.display = '';
                            row.dataset.visible = 'true';
                        }
                    });

                    // Reset load more button
                    const loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                    if (loadMoreBtn && rows.length > 10) {
                        loadMoreBtn.dataset.loaded = '10';
                        loadMoreBtn.style.display = '';
                        const remaining = rows.length - 10;
                        loadMoreBtn.innerHTML = `
                            Xem thêm 
                        `;
                    }
                }

                function maintainCurrentPagination(table) {
                    // Kiểm tra filter active cho tab năm cụ thể và global
                    let isFilterActive = false;

                    // Kiểm tra global filter status
                    const globalFilterStatus = document.getElementById('filterStatus');
                    if (globalFilterStatus && !globalFilterStatus.classList.contains('d-none')) {
                        isFilterActive = true;
                    }

                    // Kiểm tra filter status cho tab năm cụ thể nếu có
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    if (activeTab) {
                        const activeYear = activeTab.id.replace('year-', '');
                        const yearFilterStatus = document.getElementById(`filterStatus-${activeYear}`);
                        if (yearFilterStatus && !yearFilterStatus.classList.contains('d-none')) {
                            isFilterActive = true;
                        }
                    }

                    // Nếu filter đang active, không can thiệp vào pagination
                    // Vì taboo component đã quản lý rồi
                    if (isFilterActive) {
                        return;
                    }

                    const loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                    let currentLoaded = 10; // Default nếu không có button

                    // Lấy số lượng hiện tại đang hiển thị
                    if (loadMoreBtn) {
                        currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;
                    }

                    // Đếm TOTAL filtered rows TRƯỚC khi thay đổi pagination
                    const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                    const totalFilteredRows = parseInt(loadMoreBtn?.getAttribute('data-total')) || Array
                        .from(allRows).filter(row => {
                            return row.style.display !== 'none';
                        }).length;

                    // Hiển thị theo số lượng hiện tại, ẩn phần còn lại
                    allRows.forEach((row, index) => {
                        if (index >= currentLoaded) {
                            row.style.display = 'none';
                            row.dataset.visible = 'false';
                        } else {
                            row.style.display = '';
                            row.dataset.visible = 'true';
                        }
                    });

                    // Cập nhật load more button với total filtered rows
                    if (loadMoreBtn) {
                        loadMoreBtn.dataset.loaded = currentLoaded.toString();
                        loadMoreBtn.dataset.total = totalFilteredRows.toString();
                        const remaining = totalFilteredRows - currentLoaded;



                        if (remaining > 0) {
                            loadMoreBtn.style.display = '';
                            loadMoreBtn.innerHTML = `
                                Xem thêm
                            `;
                        } else {
                            loadMoreBtn.style.display = 'none';
                        }
                    }
                }

                // Hàm helper lấy ngày từ row
                function getDateFromRow(row) {
                    const dateCell = row.querySelector('td:first-child a');
                    if (dateCell) {
                        const href = dateCell.getAttribute('href');
                        const dateMatch = href.match(/\/(\d{4}-\d{2}-\d{2})/);
                        if (dateMatch) {
                            return new Date(dateMatch[1]);
                        }
                    }
                    return new Date();
                }

            });


        });

        // ========== INCLUDE TABOO FILTER COMPONENT ==========
        // Component sẽ định nghĩa initTabooFilter function
    </script>

    @include('components.taboo-filter-script')
@endpush
