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
                    Tiện ích
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày cầu an
                </li>
            </ol>
        </nav>



        <h1 class="content-title-home-lich">Xem ngày tốt cầu an - làm phúc theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row">
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

                                        <form id="phongSinhForm">
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
                                                    <div for="date_range" class="fw-bold title-tong-quan-h2-log">Dự kiến
                                                        thời gian cầu an</div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control wedding_date_range --border-box-form @error('date_range') is-invalid @enderror"
                                                            id="date_range" name="date_range"
                                                            placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                            value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                            style="border-radius: 10px; border: none; padding: 12px 45px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                        <span class="input-group-text bg-transparent border-0"
                                                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                            <i class="bi-calendar-date-fill text-muted"></i>
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
                            <div class="col-lg-4 d-none d-lg-block d-flex">
                                <div class="d-flex align-items-end h-100 w-100">
                                    <img src="{{ asset('/icons/datedoilich.svg') }}" alt="ảnh đổi lich"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="resultsContainer" class="results-container --detail-success">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Gợi ý chọn thời điểm phù hợp cho việc cầu an – làm phúc
                            </h2>
                            <p class="mb-1">Cầu an và làm phúc là những việc thiện lành, mang ý nghĩa nuôi dưỡng tâm hồn
                                và tạo thêm phúc báo cho gia đình. Thực tế, bạn có thể làm việc tốt vào bất kỳ ngày nào
                                trong năm, chỉ cần có tấm lòng là được.</p>
                            <p class="mb-1">Tuy nhiên, nhiều người vẫn chọn những ngày đẹp, ngày hợp tuổi hoặc ngày có
                                khí cát lành để thực hiện lễ cầu an, bố thí, cúng chùa… nhằm giúp tâm được an hơn, nghi lễ
                                được trọn vẹn hơn và tăng thêm sinh khí may mắn cho cả nhà.</p>
                            <p class="mb-1">Vì thế, xem ngày cho việc cầu an – làm phúc không phải là bắt buộc, mà đơn
                                giản là một cách lựa chọn thời điểm hài hòa, để mọi điều thiện lành được khởi đầu trong năng
                                lượng tốt nhất.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích khi chọn ngày tốt để cầu an – làm phúc
                            </h2>
                            <ul class="mb-1">
                                <li>Tâm an hơn: Khi biết mình chọn ngày đẹp, gia chủ sẽ cảm thấy nhẹ nhàng, yên tâm trước
                                    khi làm lễ hoặc thực hiện các việc thiện.</li>
                                <li>Nghi thức thuận lợi: Lễ cầu an, phóng sinh, cúng chùa, bố thí… diễn ra trôi chảy, không
                                    trở ngại.</li>
                                <li>Tăng sinh khí: Ngày hợp tuổi hoặc có sao cát giúp năng lượng cát tường mạnh mẽ hơn.</li>
                                <li>Thêm may mắn – hóa giải lo âu: Việc thiện lành kết hợp với thời điểm tốt giúp gia đạo
                                    bình an, tinh thần vững vàng.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi xem ngày cầu an – làm phúc nên ưu tiên điều gì?
                            </h2>
                            <ul class="mb-1" style="list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Ngày Hoàng đạo – trực tốt</h3>
                                    <p class="mb-0">Những ngày Hoàng Đạo như Minh Đường, Kim Quỹ, Ngọc Đường… thường mang
                                        năng lượng nhẹ nhàng, thích hợp cho các nghi lễ cầu an.</p>
                                    <p class="mb-0">Các trực dễ hòa hợp: Trực Khai, Trực Thành, Trực Mãn.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Ngày hợp tuổi – ngũ hành hài hòa</h3>
                                    <p class="mb-1">Chọn ngày có ngũ hành tương sinh với bản mệnh hoặc ít nhất là bình
                                        hòa, giúp năng lượng dễ lan tỏa và tâm lý gia chủ ổn định.</p>

                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Sao cát</h3>
                                    <p class="mb-1">Một số sao mang ý nghĩa an lành như:</p>
                                    <ul class="mb-1">
                                        <li>Thiên Đức, Nguyệt Đức: Hóa giải tai ương, tăng phúc.</li>
                                        <li>Thiên Quan, Thiên Phúc: Mang năng lượng che chở, độ trì.</li>
                                    </ul>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                               Hướng dẫn sử dụng công cụ Xem Ngày Cầu An – Làm Phúc tại Phong Lịch
                            </h2>
                            <ul class="mb-1" style="list-style-type: decimal;">
                                <li>Nhập tuổi hoặc năm sinh của bạn.</li>
                                <li>Chọn khoảng thời gian bạn muốn thực hiện lễ cầu an, làm phúc hoặc cúng chùa.</li>
                                <li>Hệ thống sẽ tự động:
                                    <ul class="mb-1">
                                        <li>Gợi ý các ngày tốt nhất.</li>
                                        <li>Hiển thị điểm tốt – xấu của từng ngày.</li>
                                        <li>Liệt kê Hoàng đạo – Hắc đạo, sao tốt/xấu.</li>
                                        <li>Gợi ý giờ thuận lợi để làm lễ hoặc bắt đầu việc thiện.</li>
                                    </ul>
                                </li>
                                <li>Bạn chỉ cần chọn ngày phù hợp với lịch trình thực tế, không nhất thiết phải quá cầu kỳ</li>
                            </ul>
                             <h2 class="title-tong-quan-h3-log fw-bolder">
                            Một ngày tốt để cầu an – làm phúc mang lại điều gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Giúp tâm gia chủ nhẹ nhàng, hướng thiện.</li>
                                <li>Năng lượng của ngày đẹp giúp việc thiện trở nên viên mãn, trọn vẹn hơn.</li>
                                <li>Gia đạo yên ổn, tinh thần thư thái.</li>
                                <li>Tạo khởi đầu tốt cho những dự định trong năm.</li>
                                <li>Tăng thêm phúc khí cho bản thân và gia đình.</li>
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
                        if (birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('phongSinhForm');
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

            // ========== AJAX FORM SUBMISSION ========== 
            const form = document.getElementById('phongSinhForm');
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
                fetch('{{ route('phong-sinh.check') }}', {
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
                                        console.log(
                                            'Phong Sinh Form: Initializing taboo filter with data:',
                                            data.resultsByYear);
                                        console.log(
                                            'Phong Sinh Form: Available sort dropdowns:',
                                            document.querySelectorAll(
                                                '[name="sort"]').length);

                                        // Debug sort dropdown content
                                        const sortDropdowns = document.querySelectorAll(
                                            '[name="sort"]');
                                        sortDropdowns.forEach((dropdown, index) => {
                                            console.log(
                                                `Sort dropdown ${index + 1}:`, {
                                                    value: dropdown.value,
                                                    options: Array.from(
                                                        dropdown.options
                                                    ).map(opt => opt
                                                        .value),
                                                    hasDateOptions: Array
                                                        .from(dropdown
                                                            .options).some(
                                                            opt => opt.value
                                                            .includes(
                                                                'date'))
                                                });
                                        });

                                        initTabooFilter(data.resultsByYear);
                                        console.log(
                                            'Phong Sinh Form: Taboo filter initialized successfully'
                                        );

                                        // Check legacy system detection after init
                                        setTimeout(() => {
                                            const hasLegacy = document
                                                .querySelector(
                                                    '.--detail-success');
                                            console.log(
                                                'Phong Sinh Form: Legacy system detected?',
                                                !!hasLegacy);

                                            const sortElements = document
                                                .querySelectorAll(
                                                    '[name="sort"]');
                                            sortElements.forEach((el, idx) => {
                                                console.log(
                                                    `Sort element ${idx + 1} has event listeners:`, {
                                                        hasTabooHandler:
                                                            !!el
                                                            ._tabooSortHandler,
                                                        parentTab: el
                                                            .closest(
                                                                '.tab-pane'
                                                            )
                                                            ?.id
                                                    });
                                            });
                                        }, 100);

                                        // Test sort functionality after init
                                        setTimeout(() => {
                                            const firstSortDropdown = document
                                                .querySelector('[name="sort"]');
                                            if (firstSortDropdown) {
                                                console.log(
                                                    'Phong Sinh Form: Testing sort functionality...'
                                                );
                                                const originalValue =
                                                    firstSortDropdown.value;

                                                // Test by programmatically changing dropdown
                                                firstSortDropdown.value =
                                                    'date_asc';
                                                const changeEvent = new Event(
                                                    'change', {
                                                        bubbles: true
                                                    });
                                                firstSortDropdown.dispatchEvent(
                                                    changeEvent);

                                                // Restore original value after test
                                                setTimeout(() => {
                                                    firstSortDropdown
                                                        .value =
                                                        originalValue;
                                                    firstSortDropdown
                                                        .dispatchEvent(
                                                            changeEvent
                                                        );
                                                    console.log(
                                                        'Phong Sinh Form: Sort test completed'
                                                    );
                                                }, 1000);
                                            }
                                        }, 500);
                                    } else {
                                        console.error(
                                            'Phong Sinh Form: initTabooFilter not available or no data', {
                                                hasFunction: typeof initTabooFilter ===
                                                    'function',
                                                hasData: !!data.resultsByYear
                                            });
                                    }
                                }, 200);
                            }, 300);

                            // Scroll to results with delay to ensure content is rendered
                            setTimeout(() => {
                                resultsContainer.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 100);

                            // Re-initialize Bootstrap tabs if present
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });
                        } else if (data.errors) {
                            // Show validation errors
                            let errorMessage = 'Vui lòng kiểm tra lại:\n';
                            for (const field in data.errors) {
                                errorMessage += '- ' + data.errors[field][0] + '\n';
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

            // getDateFromRow and applySortingToTable functions are now handled
            // by taboo-filter-script component to avoid conflicts

            // Sorting is now handled by taboo-filter-script component
            // Do not add duplicate sort handlers here to avoid conflicts

        });
    </script>

    @include('components.taboo-filter-script')
@endpush
