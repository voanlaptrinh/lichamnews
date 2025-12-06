@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.3') }}">
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
                    Xem ngày thi cử - phỏng vấn
                </li>
            </ol>
        </nav>



        <h1 class="content-title-home-lich">Xem ngày tốt thi cử - phỏng vấn theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold  title-tong-quan-h2-log"  style="color: #192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class=""  style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form id="examInterviewForm">
                                            @csrf

                                            <div class="row">
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
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log"  style="color: #192E52; padding-bottom: 12px;">Dự kiến
                                                        thời gian thi cử - phỏng vấn</div>
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_thicu.svg);
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
                                Vì sao nên xem ngày thi cử, phỏng vấn?
                            </h2>
                            <p class="mb-1">
                                Ngày thi hay phỏng vấn là bước quan trọng, ảnh hưởng trực tiếp đến kết quả học tập, công
                                việc và cơ hội thăng tiến. Chọn ngày tốt giúp:
                            </p>
                            <ul class="mb-3">
                                <li>Tâm lý tự tin, bình tĩnh khi tham gia</li>
                                <li>Tránh xung khắc tuổi, giảm áp lực, stress</li>
                                <li>Thu hút may mắn, thuận lợi trong quá trình thi hoặc phỏng vấn</li>
                                <li>Tăng khả năng đạt kết quả tốt và để lại ấn tượng tích cực</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Lợi ích khi chọn ngày tốt
                            </h2>
                            <ul class="mb-3">
                                <li>Tăng tâm lý vững vàng, giảm lo lắng</li>
                                <li>Kết quả thi hoặc phỏng vấn khả quan hơn</li>
                                <li>Thuận lợi về phong thủy, năng lượng tích cực hỗ trợ học tập, làm việc</li>
                                <li>Tránh xung đột, trục trặc không cần thiết</li>
                                <li>Tạo nền tảng may mắn cho các bước tiếp theo trong học tập và sự nghiệp</li>
                            </ul>
                              <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                               Cách chọn ngày thi cử, phỏng vấn
                            </h2>
                            <p class="mb-1">Những ngày có yếu tố cát lành nên chọn:</p>
                            <ul class="mb-3">
                                <li>Hoàng đạo → Ngày thuận lợi, tăng cát khí</li>
                                <li>Trực tốt: Kiến – Khai – Thành – Mãn → Hỗ trợ bắt đầu công việc mới hoặc thi cử thuận lợi</li>
                                <li>Ngũ hành hợp tuổi/mệnh → Tăng may mắn, giảm xung khắc</li>
                                <li>Sao cát: Thiên Đức, Nguyệt Đức, Thiên Quan, Thiên Phúc, Lộc Tồn → Hỗ trợ thi cử, giao tiếp tốt</li>
                                <li>Giờ Hoàng đạo → Thời điểm làm bài hay phỏng vấn thuận lợi</li>
                                <li>Ngày không xung tuổi</li>
                            </ul>
                            <p class="mb-1">Những ngày có yếu tố xấu cần tránh:</p>
                            <ul class="mb-3">
                                <li>Ngày Hắc đạo: Câu Trận, Bạch Hổ, Thiên Lao, Nguyên Vũ</li>
                                <li>Trực xấu: Phá – Nguy – Thu – Bế → Gây trục trặc, căng thẳng</li>
                                <li>Ngày xung tuổi</li>
                                <li>Ngày đại kỵ: Tam Nương, Nguyệt Kỵ, Dương Công Kỵ Nhật</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn sử dụng công cụ Phong Lịch
                            </h2>
                            <ul class="mb-3" style="list-style-type: decimal;">
                                <li>Nhập tuổi của thí sinh hoặc người phỏng vấn</li>
                                <li>Chọn khoảng thời gian dự kiến thi hoặc phỏng vấn</li>
                                <li>Hệ thống phân tích:
                                    <ul class="mb-1">
                                        <li>Hoàng đạo – hắc đạo</li>
                                        <li>Trực tốt – xấu</li>
                                        <li>Sao cát – sao hung</li>
                                        <li>Ngũ hành hợp tuổi</li>
                                        <li>Giờ tốt – giờ xung tuổi</li>
                                    </ul>
                                </li>
                                <li>Công cụ gợi ý ngày tốt nhất, kèm điểm tốt – xấu và lưu ý chi tiết</li>
                            </ul>
                             <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                              Lợi ích khi chọn đúng ngày thi cử, phỏng vấn
                            </h2>
                            <ul class="mb-1">
                                <li>Tâm lý tự tin, giảm áp lực</li>
                                <li>Hiệu suất tối ưu, kết quả khả quan</li>
                                <li>Tránh rủi ro, trục trặc không đáng có</li>
                                <li>Thu hút may mắn và thuận lợi cho các bước tiếp theo</li>
                                <li>Tạo ấn tượng tích cực trong mắt giáo viên, giám khảo hoặc nhà tuyển dụng</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @include('tools.siderbarindex')
            </div>

        </div>
    </div>

    <!-- Mobile Date Range Quick Options Popup -->
@endsection

@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=7.0') }}" defer></script>


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

                // Only restore if we have valid complete parameters (both birthdate and date range)
                if (!params.birthdate || !params.khoang) {
                    return; // Don't restore if incomplete parameters
                }

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

                let formRestored = false;
                let birthdateSet = false;
                let dateRangeSet = false;
                let autoSubmitEnabled = true; // Flag to control auto-submission

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
                                            await dateSelector.setDate(day, month, year, false, false);

                                            // Then switch to lunar mode - this will trigger automatic conversion
                                            const lunarRadio = document.getElementById('lunarCalendar');
                                            const solarRadio = document.getElementById('solarCalendar');
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
                                            await dateSelector.setDate(day, month, year, true, false);
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
                                    console.warn('Error restoring birthdate:', error);
                                    birthdateSet = true;
                                    autoSubmitEnabled = false; // Disable auto-submit on error
                                    checkAndSubmitForm();
                                }
                            })();
                        } else {
                            birthdateSet = true;
                            autoSubmitEnabled = false; // Invalid date format
                            checkAndSubmitForm();
                        }
                    } else {
                        // DateSelector not ready yet, try again
                        setTimeout(() => tryRestoreBirthdate(attempts + 1), 300);
                    }
                }

                // Set date range with retry
                function trySetDateRange(attempts = 0) {
                    const maxAttempts = 5;
                    if (attempts >= maxAttempts) {
                        dateRangeSet = true;
                        autoSubmitEnabled = false; // Disable auto-submit if failed to set range
                        checkAndSubmitForm();
                        return;
                    }

                    const khoangInput = document.getElementById('date_range');
                    if (khoangInput) {
                        khoangInput.value = params.khoang;
                        dateRangeSet = true;
                        checkAndSubmitForm();
                    } else {
                        setTimeout(() => trySetDateRange(attempts + 1), 200);
                    }
                }

                // Function to check if all fields are set and submit form
                function checkAndSubmitForm() {
                    if (birthdateSet && dateRangeSet && !formRestored && autoSubmitEnabled) {
                        formRestored = true;

                        // Additional validation before auto-submit
                        const ngayXemInput = document.getElementById('ngayXem');
                        const dateRangeInput = document.getElementById('date_range');

                        if (ngayXemInput && dateRangeInput &&
                            ngayXemInput.value.trim() !== '' &&
                            dateRangeInput.value.trim() !== '') {

                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('examInterviewForm');
                                if (form) {
                                    console.log('Auto-submitting form from URL parameters');
                                    form.requestSubmit();
                                }
                            }, 500);
                        }
                    }
                }

                // Start restoration process
                tryRestoreBirthdate();
                trySetDateRange();
            }

            // Restore form from hash on page load
            setTimeout(restoreFromHash, 1000);

            // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
            // No need for additional logic here as the module handles all conversions automatically

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('examInterviewForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

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
                fetch('{{ route('thi-cu.check') }}', {
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

                            setTimeout(() => {
                                resultsContainer.innerHTML = data.html;

                                // Cập nhật window.resultsByYear cho global access
                                if (data.resultsByYear) {
                                    window.resultsByYear = data.resultsByYear;
                                }

                                setTimeout(() => {
                                    if (data.resultsByYear && typeof initTabooFilter ===
                                        'function') {
                                        initTabooFilter(data.resultsByYear);
                                    }
                                }, 200);
                            }, 300);
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
                            // Scroll to results with delay to ensure content is rendered
                            // setTimeout(() => {
                            //     resultsContainer.scrollIntoView({
                            //         behavior: 'smooth',
                            //         block: 'start'
                            //     });
                            // }, 100);

                            // Re-initialize Bootstrap tabs if present and prevent hash change
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="pill"]');
                            tabs.forEach(tab => {
                                // Initialize Bootstrap tab
                                new bootstrap.Tab(tab);

                                // Prevent hash change on tab click
                                tab.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const bsTab = new bootstrap.Tab(this);
                                    bsTab.show();
                                });
                            });
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

            // Optimized sorting functions
            function getScoreFromRow(row) {
                const battery = row.querySelector('.battery-label');
                if (battery) {
                    return parseInt(battery.textContent.replace('%', '')) || 0;
                }

                const scoreElement = row.querySelector('.diem-so, .score');
                if (scoreElement) {
                    return parseInt(scoreElement.textContent.replace(/[^\d]/g, '')) || 0;
                }

                const cells = row.querySelectorAll('td');
                for (let cell of cells) {
                    const match = cell.textContent.trim().match(/(\d+)/);
                    if (match) {
                        return parseInt(match[1]) || 0;
                    }
                }
                return 0;
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

            function applySortingToTable(sortValue, year = null) {
                console.log('applySortingToTable called with:', sortValue, 'year:', year);

                // If no year specified, try to get active tab year
                if (!year) {
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    if (activeTab) {
                        year = activeTab.id.replace('year-', '');
                    }
                }

                console.log('Using year for sorting:', year);

                // Find table for specific year first
                let table = null;

                if (year) {
                    // Year-specific table search
                    const activeTabPane = document.querySelector(`#year-${year}`);
                    if (activeTabPane) {
                        table = activeTabPane.querySelector(`#table-${year} tbody`) ||
                            activeTabPane.querySelector('.table tbody') ||
                            activeTabPane.querySelector('tbody');
                    }

                    // Fallback: global search for year-specific table
                    if (!table) {
                        table = document.querySelector(`#table-${year} tbody`);
                    }
                }

                // Fallback: general search
                if (!table) {
                    table = document.querySelector('#bang-chi-tiet table tbody');
                }

                if (!table) {
                    const resultsContainer = document.querySelector('.--detail-success');
                    if (resultsContainer) {
                        table = resultsContainer.querySelector('table tbody');
                    }
                }

                if (!table) {
                    console.log('No table found for sorting');
                    return;
                }

                console.log('Table found for sorting:', table);

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

                // Update filter status for this year if taboo filter is active
                if (year && typeof window.updateFilterStatusOnPagination === 'function') {
                    window.updateFilterStatusOnPagination(year);
                }
            }

            // Event delegation for sorting
            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    console.log('Sort dropdown changed to:', event.target.value);

                    // Find the year from the parent tab
                    const parentTabPane = event.target.closest('.tab-pane');
                    const year = parentTabPane ? parentTabPane.id.replace('year-', '') : null;

                    console.log('Sorting for year:', year);

                    // Sync all sort dropdowns to same value
                    const allSortSelects = document.querySelectorAll('[name="sort"]');
                    allSortSelects.forEach(select => {
                        if (select !== event.target) {
                            select.value = event.target.value;
                        }
                    });

                    applySortingToTable(event.target.value, year);

                    setTimeout(() => {
                        if (year) {
                            const yearTab = document.querySelector(`#year-${year}`);
                            const bangChiTiet = yearTab?.querySelector('#bang-chi-tiet');
                            bangChiTiet?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        } else {
                            document.getElementById('bang-chi-tiet')?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }, 100);
                }
            });

            // Load more functionality
            resultsContainer.addEventListener('click', function(event) {
                if (event.target.closest('.load-more-btn')) {
                    const btn = event.target.closest('.load-more-btn');
                    const year = btn.dataset.year;
                    const currentLoaded = parseInt(btn.dataset.loaded) || 10;
                    const total = parseInt(btn.dataset.total) || 0;
                    const loadAmount = 10;

                    console.log(
                        `Load more for year ${year}: showing ${currentLoaded + loadAmount} out of ${total}`
                    );

                    // Show more rows for this specific year
                    const yearTab = document.querySelector(`#year-${year}`);
                    if (yearTab) {
                        const rows = yearTab.querySelectorAll(`.table-row-${year}`);

                        for (let i = currentLoaded; i < Math.min(currentLoaded + loadAmount, total); i++) {
                            if (rows[i]) {
                                rows[i].style.display = '';
                                rows[i].dataset.visible = 'true';
                            }
                        }

                        // Update button
                        const newLoaded = Math.min(currentLoaded + loadAmount, total);
                        btn.dataset.loaded = newLoaded;
                        const remaining = total - newLoaded;

                        if (remaining > 0) {
                            btn.innerHTML = `
                                Xem thêm 
                            `;
                        } else {
                            btn.style.display = 'none';
                        }

                        console.log(`Updated: loaded=${newLoaded}, remaining=${remaining}`);
                    }
                }
            });

        });
    </script>

    @include('components.next-year-button-handler')
    @include('components.taboo-filter-script')
@endpush
