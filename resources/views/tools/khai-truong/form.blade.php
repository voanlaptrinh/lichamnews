@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.0') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('totxau.list') }}"  style="color: #2254AB; text-decoration: underline;">Xem ngày tốt</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày khai trương
                </li>
            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem ngày tốt khai trương theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold  title-tong-quan-h2-log" style="color: rgba(25, 46, 82, 1);">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form id="khaiTruongForm">
                                            @csrf

                                            <div class="row">
                                                <!-- Name field -->
                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h4-log" style="color: #192E52; padding-bottom: 12px;">Tên người xem</div>
                                                    <input type="text"
                                                        class="form-control --border-box-form @error('user_name') is-invalid @enderror"
                                                        id="user_name" name="user_name" placeholder="Nhập tên của bạn"
                                                        value="{{ old('user_name', $inputs['user_name'] ?? '') }}"
                                                        style="border-radius: 10px; border: none; padding: 12px 15px; background-color: rgba(255,255,255,0.95);">
                                                    @error('user_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <!-- Date Selects -->
                                                    <div class="fw-bold title-tong-quan-h4-log" style="color: #192E52; padding-bottom: 12px;">Ngày sinh của gia chủ</div>
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
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log" >Dự kiến
                                                        thời gian khai trương</div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control wedding_date_range --border-box-form @error('date_range') is-invalid @enderror"
                                                            id="date_range" name="date_range"
                                                            placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                            value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                            style="border-radius: 10px; border: none; padding: 12px 30px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                      <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 2px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                       <img src="{{ asset('images/date1-icon.svg') }}" alt="icon ngày tháng năm" class="img-fluid">
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_khaitruong.svg);
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

                            <!-- Auto-submit notification (hidden by default) -->
                            <div id="autoSubmitNotification" class="alert alert-info" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>Đang khôi phục dữ liệu từ trang chi tiết...</span>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="manualSubmit()">
                                        Xem kết quả ngay
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Vì sao khai trương cần xem ngày tốt?
                            </h2>
                            <p class="mb-1">
                                Khai trương là thời điểm bắt đầu một hành trình kinh doanh mới: mở cửa hàng, công ty, văn
                                phòng hay một dịch vụ lớn nhỏ. Đây không chỉ là nghi lễ mà còn là lời cầu chúc cho tài lộc
                                hanh thông, khách hàng tấp nập, công việc thuận buồm xuôi gió.
                            </p>
                            <p class="mb-1">
                                Vì vậy, việc xem ngày khai trương mang ý nghĩa:
                            </p>
                            <ul class="mb-3">
                                <li>Tạo khí thế tốt ngay từ đầu, giúp công việc dễ thu hút may mắn.</li>
                                <li>Tránh ngày xấu có thể mang lại cản trở, chậm trễ hoặc khó khăn ban đầu.</li>
                                <li>Tăng sự tự tin và yên tâm cho chủ cửa hàng, doanh nghiệp khi bắt đầu hoạt động.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Lợi ích của việc chọn ngày khai trương hợp tuổi
                            </h2>
                            <p class="mb-1">Không phải ngày nào cũng hợp với tất cả mọi người. Việc chọn ngày hợp tuổi
                                giúp bạn:</p>
                            <ul class="mb-3">
                                <li>Hạn chế xung tuổi, tránh những ảnh hưởng không may trong kinh doanh.</li>
                                <li>Chọn được ngày – giờ mang cát khí, tăng khả năng thu hút tài lộc.</li>
                                <li>Mang lại tâm thế thoải mái, tự tin khi bước vào thị trường.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Khi xem ngày khai trương, cần chú ý điều gì?
                            </h2>
                            <ul style="	list-style-type: upper-alpha;" >
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố cát lành nên ưu tiên</h3>
                                    <ul class="mb-3">
                                        <li>Ngày hoàng đạo, ngày hợp tuổi chủ kinh doanh.</li>
                                        <li>Trực tốt như Trực Khai (mở đầu), Trực Thành (hoàn thành), Trực Mãn.</li>
                                        <li>Giờ tốt hợp tuổi để tiến hành nghi lễ khai trương và mở cửa đón khách.</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố xấu nên tránh</h3>
                                    <ul>
                                        <li>Ngày hắc đạo, ngày xung tuổi hoặc phạm Thái Tuế.</li>
                                        <li>Trực xấu như Trực Bế, Trực Phá gây kém suôn sẻ.</li>
                                        <li>Ngày có bách kỵ, đặc biệt là những ngày kỵ mở cửa kinh doanh.</li>
                                    </ul>
                                </li>
                            </ul>
                             <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                               Cách sử dụng công cụ Xem Ngày Khai Trương trên Phong Lịch
                            </h2>
                            <ul style="	list-style-type: decimal;">
                                <li>Nhập tuổi của bạn (âm hoặc dương lịch).</li>
                                <li>Chọn khoảng thời gian bạn dự định khai trương.</li>
                                <li>
                                    Hệ thống sẽ:
                                    <ul>
                                        <li>Gợi ý những ngày khai trương đẹp nhất,</li>
                                        <li>Hiển thị điểm tốt – xấu,</li>
                                        <li>Liệt kê lý do nên chọn hoặc tránh,</li>
                                        <li>Đưa ra các khung giờ tốt để mở hàng.</li>
                                    </ul>
                                </li>
                                <li>So sánh lịch hoạt động thực tế để chọn ra ngày hợp tuổi – hợp việc – hợp thời điểm.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                              Một ngày khai trương đẹp mang lại điều gì?
                            </h2>
                            <ul>
                                <li>Tinh thần thoải mái, tự tin khi bắt đầu mở cửa.</li>
                                <li>Thuận lợi trong những ngày đầu, dễ “lấy vía” khách hàng.</li>
                                <li>Gia tăng cát khí tài lộc, tạo nền tảng cho việc kinh doanh lâu dài.</li>
                                <li>Hóa giải điều xấu, tránh những trở ngại không đáng có.</li>
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

            // Manual submit function
            function manualSubmit() {
                const form = document.getElementById('khaiTruongForm');
                if (form) {
                    form.requestSubmit();
                    const notification = document.getElementById('autoSubmitNotification');
                    notification?.style?.setProperty('display', 'none');
                }
            }

            // Make function global
            window.manualSubmit = manualSubmit;

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

                if (params.user_name || params.birthdate || params.khoang) {
                    // Show restoration notification
                    const notification = document.getElementById('autoSubmitNotification');
                    if (notification) {
                        notification.style.display = 'block';
                    }
                    let formRestored = false;
                    let userNameSet = false;
                    let birthdateSet = false;
                    let dateRangeSet = false;

                    if (params.user_name) {
                        const userNameInput = document.getElementById('user_name');
                        if (userNameInput) {
                            userNameInput.value = params.user_name;
                        }
                        userNameSet = true;
                    } else {
                        userNameSet = true;
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
                                let day, month, year;

                                // Handle both Y-m-d and d/m/Y formats
                                if (params.birthdate.includes('-') && params.birthdate.split('-').length === 3) {
                                    const ymdParts = params.birthdate.split('-');
                                    year = parseInt(ymdParts[0]);
                                    month = parseInt(ymdParts[1]);
                                    day = parseInt(ymdParts[2]);
                                } else {
                                    const dateParts = params.birthdate.split('/');
                                    if (dateParts.length === 3) {
                                        day = parseInt(dateParts[0]);
                                        month = parseInt(dateParts[1]);
                                        year = parseInt(dateParts[2]);
                                    }
                                }

                                if (day && month && year) {
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
                            const maxAttempts = 8;
                            if (attempts >= maxAttempts) {
                                dateRangeSet = true;
                                checkAndSubmitForm();
                                return;
                            }

                            const khoangInput = document.getElementById('date_range');
                            if (khoangInput) {
                                khoangInput.value = params.khoang;
                                dateRangeSet = true;
                                checkAndSubmitForm();
                            } else {
                                setTimeout(() => trySetDateRange(attempts + 1), 100);
                            }
                        }

                        trySetDateRange();
                    } else {
                        dateRangeSet = true;
                    }

                    // Function to check if all fields are set and submit form
                    function checkAndSubmitForm() {
                        if (userNameSet && birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;

                            // Auto submit form immediately
                            const form = document.getElementById('khaiTruongForm');
                            if (form) {
                                // Try different submission methods
                                try {
                                    form.requestSubmit();
                                    // Hide notification after successful submit
                                    const notification = document.getElementById('autoSubmitNotification');
                                    notification?.style?.setProperty('display', 'none');
                                } catch (e) {
                                    form.dispatchEvent(new Event('submit', {
                                        cancelable: true
                                    }));
                                }
                            }
                        }
                    }
                }
            }

            // Restore form from hash on page load - optimized for faster restoration
            setTimeout(restoreFromHash, 800);

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('khaiTruongForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get user name
                const userNameInput = document.getElementById('user_name');
                const userNameValue = userNameInput?.value?.trim() || '';

                if (!userNameValue) {
                    alert('Vui lòng nhập tên');
                    return;
                }

                // Get birthdate value
                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput?.value || '';

                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm sinh');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput?.value || '';

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian khai trương');
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

                // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                if (calendarType === 'lunar') {
                    const {
                        solarDay,
                        solarMonth,
                        solarYear,
                        lunarLeap
                    } = ngayXemInput.dataset;
                    isLeapMonth = lunarLeap === '1';
                    formattedBirthdate = (solarDay && solarMonth && solarYear) ?
                        `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}` :
                        ngayXemValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
                } else {
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
                    user_name: userNameValue,
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
                    user_name: userNameValue,
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
                fetch('{{ route('khai-truong.check') }}', {
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

                            // Scroll to results with delay to ensure content is rendered
                              setTimeout(() => {
                                const contentBoxSuccess = document.getElementById('content-box-success');
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
                            // }, 100);

                            // Re-initialize Bootstrap tabs if present
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                if (typeof bootstrap !== 'undefined' && bootstrap.Tab) {
                                    new bootstrap.Tab(tab);
                                }
                            });

                            // Khởi tạo taboo filter và pagination với dữ liệu từ response
                            setTimeout(() => {
                                // Sử dụng global initTabooFilter từ component
                                if (typeof window.initTabooFilter === 'function') {
                                    window.initTabooFilter(data.resultsByYear);
                                }
                                initPagination();
                            }, 200);
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

                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    });
            });

            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    console.log('Sort changed to:', event.target.value);

                    // Tìm năm hiện tại từ tab active
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    const currentYear = activeTab ? activeTab.id.replace('year-', '') : null;

                    applySortingToTable(event.target.value, currentYear);
                    setTimeout(() => {
                        const bangChiTiet = activeTab?.querySelector('#bang-chi-tiet');
                        bangChiTiet?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });

            // Function to apply sorting without form submission
            function applySortingToTable(sortValue, year) {
                // Tìm tab hiện tại hoặc sử dụng year parameter
                let activeTab = document.querySelector('.tab-pane.show.active');
                if (!activeTab && year) {
                    activeTab = document.querySelector(`#year-${year}`);
                }
                if (!activeTab) {
                    console.log('No active tab found');
                    return;
                }

                // Tìm table trong tab hiện tại
                const table = activeTab.querySelector('#bang-chi-tiet table tbody');
                if (!table) {
                    console.log('No table found for sorting in active tab');
                    return;
                }

                const rows = Array.from(table.querySelectorAll('tr'));
                console.log(`Found ${rows.length} rows to sort in tab ${activeTab.id}`);

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

                // Clear table and re-append sorted rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));

                // Maintain current pagination - pass year parameter
                const currentYear = activeTab.id.replace('year-', '');
                maintainCurrentPagination(table, currentYear);
            }

            // Helper function to extract score from table row
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
                for (const cell of cells) {
                    const text = cell.textContent?.trim() || '';
                    const match = text.match(/(\d+)/);
                    if (match) {
                        return parseInt(match[1]) || 0;
                    }
                }

                return 0;
            }

            function getDateFromRow(row) {
                // Try different ways to find the date - same as mua-xe

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

                        // Reread attributes every time (might be updated by taboo filter)
                        const currentLoaded = parseInt(btn.getAttribute('data-loaded')) || 10;
                        const total = parseInt(btn.getAttribute('data-total')) || 0;
                        const loadMore = Math.min(10, total - currentLoaded);

                        console.log(
                            `PAGINATION DEBUG: year=${year}, currentLoaded=${currentLoaded}, total=${total}, loadMore=${loadMore}`
                        );

                        // Tìm table trong tab hiện tại của năm đó
                        const targetTab = document.querySelector(`#year-${year}`);
                        const table = targetTab ? targetTab.querySelector('#bang-chi-tiet table tbody') :
                            null;

                        if (table) {
                            const allRows = table.querySelectorAll(`.table-row-${year}`);
                            console.log(
                                `Showing more rows for year ${year}: currentLoaded=${currentLoaded}, total=${total}, allRows=${allRows.length}`
                            );

                            // Show next loadMore rows
                            for (let i = currentLoaded; i < currentLoaded + loadMore; i++) {
                                if (allRows[i]) {
                                    allRows[i].style.display = '';
                                    allRows[i].setAttribute('data-visible', 'true');
                                    console.log(`Showing row ${i}`);
                                }
                            }

                            const newLoaded = currentLoaded + loadMore;
                            btn.setAttribute('data-loaded', newLoaded);

                            // Update button text - total should be correct from taboo filter
                            const remaining = total - newLoaded;
                            const nextLoad = Math.min(10, remaining);

                          

                            if (remaining > 0) {
                                btn.innerHTML =
                                    `Xem thêm`;
                            } else {
                                btn.style.display = 'none';
                            }

                            // Update filter status if active
                            if (typeof window.updateFilterStatusOnPagination === 'function') {
                                window.updateFilterStatusOnPagination(year);
                            }
                        } else {
                            console.error(`Cannot find table for year ${year}`);
                        }
                    }
                });
            }

            function maintainCurrentPagination(table, year) {
                // Kiểm tra xem có đang trong filter state không
                const filterStatus = document.getElementById(`filterStatus-${year || ''}`);
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
                    `DEBUG: Maintaining pagination for year ${year}: currentLoaded=${currentLoaded}, totalFilteredRows=${totalFilteredRows}, allRows=${allRows.length}`
                );

                // Show rows according to current pagination state
                let visibleCount = 0;
                allRows.forEach((row, index) => {
                    if (visibleCount < currentLoaded) {
                        row.style.display = '';
                        row.setAttribute('data-visible', 'true');
                        visibleCount++;
                        console.log(`DEBUG: Showing row ${index}`);
                    } else {
                        row.style.display = 'none';
                        row.setAttribute('data-visible', 'false');
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
