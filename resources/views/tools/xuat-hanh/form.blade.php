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
                    Xem ngày xuất hành
                </li>

            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem ngày tốt xuất hành theo tuổi</h1>

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

                                        <form id="xuatHanhForm">
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
                                                        thời gian xuất hành</div>
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
                    <div id="resultsContainer" class="--detail-success">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Vì sao nên xem ngày xuất hành?
                            </h2>
                            <p class="mb-1">Xuất hành là thời điểm bạn rời nhà để đi làm xa, công tác, du lịch, đi lễ
                                chùa hay thực hiện những công việc quan trọng cần di chuyển. Việc chọn đúng ngày – giờ không
                                chỉ mang ý nghĩa tâm linh mà còn giúp:</p>
                            <ul class="mb-1">
                                <li>Đi đường thuận lợi, an toàn, ít gặp trở ngại</li>
                                <li>Tâm lý thoải mái, tự tin</li>
                                <li>Thu hút may mắn khi đi làm ăn, ký kết, gặp đối tác</li>
                                <li>Gặp đúng người – đúng thời điểm, dễ thành công hơn</li>
                            </ul>
                            <p class="mb-1">Vì vậy, nhiều người luôn ưu tiên xem ngày tốt trước khi khởi hành quan trọng.
                            </p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích khi chọn đúng ngày xuất hành
                            </h2>
                            <ul class="mb-1">
                                <li>Tăng cát khí – may mắn cho cả hành trình</li>
                                <li>Hợp tuổi – hợp ngũ hành, dễ gặp thuận lợi</li>
                                <li>Tránh xung khắc, hạn chế mệt mỏi hoặc chuyện bất ngờ</li>
                                <li>Tối ưu cho các chuyến đi cầu tài, giải hạn, công việc</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Cách xem ngày xuất hành: Những yếu tố quan trọng cần biết
                            </h2>
                            <ul style="list-style-type: upper-alpha;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log"> Nên chọn ngày có:</h3>
                                    <ul style="list-style-type: decimal;">
                                        <li>
                                            <p class="mb-1">Ngày Hoàng đạo</p>
                                            <p class="mb-1">Ngày cát lành, phù hợp để khởi đầu mọi hành động tốt.</p>
                                        </li>
                                        <li>
                                            <p class="mb-1">Sao tốt chiếu mệnh</p>
                                            <p class="mb-1"> Các sao phù trợ cho di chuyển – gặp gỡ – cầu tài:</p>
                                            <ul class="mb-1" style="list-style-type: circle;">
                                                <li>Thanh Long: May mắn, thuận lợi.</li>
                                                <li>Thiên Hỷ: Mang đến niềm vui, dễ gặp chuyện tốt đẹp.</li>
                                                <li>Thiên Mã: Rất tốt cho việc đi xa, di chuyển, công tác.</li>
                                                <li>Nguyệt Đức: Có quý nhân giúp đỡ, hành trình thuận buồm xuôi gió.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Hướng xuất hành tốt</p>
                                            <p class="mb-1"> Khi xuất hành, nên đi theo hướng:</p>
                                            <ul class="mb-1" style="list-style-type: circle;">
                                                <li>Hỷ Thần → Mang đến niềm vui, may mắn</li>
                                                <li>Tài Thần → Tốt cho cầu tài, làm ăn, ký kết</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngũ hành hòa hợp với tuổi</p>
                                            <p class="mb-1">Ngày có ngũ hành tương sinh hoặc tương hỗ giúp chuyến đi thêm
                                                thuận lợi, tinh thần nhẹ nhàng.</p>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Tránh các ngày sau:</h3>
                                    <ul style="list-style-type: decimal;">
                                        <li>Ngày đại kỵ:
                                            <ul style="	list-style-type: circle;">
                                                <li>Tam Nương</li>
                                                <li>Sát Chủ, Thổ Phủ</li>
                                                <li>Dương Công Kỵ Nhật</li>
                                                <li>Nguyệt Kỵ (mùng 5 – 14 – 23)</li>
                                                <li>Trùng Tang
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-0">Ngày xung tuổi</p>
                                            <p class="mb-0"> Dễ gặp phiền phức, bất lợi, tâm lý không thoải mái khi xuất
                                                hành.</p>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Hướng dẫn sử dụng công cụ xem ngày xuất hành trên Phong Lịch
                            </h2>
                            <ul style="list-style-type: decimal;">
                                <li>Chọn tuổi (âm lịch hoặc dương lịch).</li>
                                <li>Chọn thời gian bạn muốn xuất hành.</li>
                                <li>Hệ thống sẽ tự động phân tích:
                                    <ul style="list-style-type: circle;">
                                        <li>Hoàng đạo – hắc đạo</li>
                                        <li>Sao tốt – sao xấu</li>
                                        <li>Hướng xuất hành phù hợp</li>
                                        <li>Ngũ hành hợp tuổi</li>
                                        <li>Giờ tốt trong ngày</li>
                                    </ul>
                                </li>
                                <li>Bạn chỉ cần chọn ngày phù hợp nhất với lịch cá nhân để yên tâm lên đường.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Một ngày xuất hành đẹp mang lại điều gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Đi đường bình an, thông suốt</li>
                                <li>Dễ gặp quý nhân, thuận lợi trong công việc</li>
                                <li>Cảm giác tự tin, yên tâm suốt chuyến đi</li>
                                <li>Thu hút may mắn, đặc biệt khi đi mở hàng – gặp đối tác – ký kết</li>
                                <li>Mọi sự khởi đầu tốt đẹp và viên mãn hơn</li>
                            </ul>
                        </div>
                    </div>

                </div>

                @include('tools.siderbarindex')
            </div>


        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/lunar-solar-date-select.js?v=1.3') }}"></script>
        {{-- Date Range Picker JS (vanilla JS version) --}}
        <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.7') }}" defer></script>

        @include('components.taboo-filter-script')


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if we have hash parameters to avoid setting defaults
                const hasHashParams = window.location.hash && window.location.hash.includes('birthdate');

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

                // Optimized date range picker initialization
                function initDateRangePicker() {
                    if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                        // Fallback to manual input
                        if (dateRangeInput) {
                            dateRangeInput.removeAttribute('readonly');
                            dateRangeInput.placeholder = 'DD/MM/YY - DD/MM/YY';
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
                    const hashParts = Object.entries(params)
                        .filter(([key, value]) => key && value)
                        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
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
                                                // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                                                if (params.calendar_type === 'lunar') {
                                                    await dateSelector.setDate(day, month, year, false, false);
                                                    const lunarRadio = document.getElementById('lunarCalendar');
                                                    if (lunarRadio) {
                                                        lunarRadio.checked = true;
                                                        await dateSelector.handleLunarRadioChange();
                                                    }
                                                } else {
                                                    await dateSelector.setDate(day, month, year, false, false);
                                                    const solarRadio = document.getElementById('solarCalendar');
                                                    if (solarRadio) {
                                                        solarRadio.checked = true;
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
                                if (attempts >= maxAttempts) {
                                    dateRangeSet = true;
                                    checkAndSubmitForm();
                                    return;
                                }

                                const dateRangeInput = document.getElementById('date_range');
                                if (dateRangeInput) {
                                    dateRangeInput.value = params.khoang;
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
                                    const form = document.getElementById('xuatHanhForm');
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
                const form = document.getElementById('xuatHanhForm');
                const submitBtn = document.getElementById('submitBtn');
                const resultsContainer = document.getElementById('resultsContainer');
                const btnText = submitBtn.querySelector('.btn-text');
                const spinner = submitBtn.querySelector('.spinner-border');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form values with validation
                    const ngayXemInput = document.getElementById('ngayXem');
                    const ngayXemValue = ngayXemInput?.value;
                    const dateRangeValue = dateRangeInput?.value;

                    if (!ngayXemValue) {
                        alert('Vui lòng chọn đầy đủ ngày, tháng, năm');
                        return;
                    }

                    if (!dateRangeValue) {
                        alert('Vui lòng chọn khoảng thời gian');
                        return;
                    }

                    // Determine calendar type and format birthdate
                    const solarRadio = document.getElementById('solarCalendar');
                    const lunarRadio = document.getElementById('lunarCalendar');
                    const calendarType = lunarRadio?.checked ? 'lunar' : 'solar';
                    let formattedBirthdate = '';
                    let isLeapMonth = false;

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

                    // Parse date range with helper function
                    const parseDatePart = (datePart) => {
                        const parts = datePart.trim().split('/');
                        if (parts.length !== 3) return '';

                        const [day, month, year] = parts;
                        const fullYear = year.length === 2 ? '20' + year : year;
                        return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${fullYear}`;
                    };

                    const dateRangeParts = dateRangeValue.split(' - ');
                    const [startDate, endDate] = dateRangeParts.length === 2 ? [parseDatePart(dateRangeParts[
                        0]), parseDatePart(dateRangeParts[1])] : ['', ''];

                    // Get sort value if exists
                    const sortValue = resultsContainer.querySelector('[name="sort"]')?.value ?? 'desc';

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
                    fetch('{{ route('xuat-hanh.check') }}', {
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
                                    resultsContainer.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }, 100);

                                // Re-initialize Bootstrap tabs if present
                                const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                                tabs.forEach(tab => new bootstrap.Tab(tab));

                                // Initialize taboo filter và pagination với dữ liệu từ response
                                setTimeout(() => {
                                    if (data.resultsByYear) {
                                        if (typeof window.initTabooFilter === 'function') {
                                            window.initTabooFilter(data.resultsByYear);
                                        }
                                    }
                                    initPagination();
                                    setupContainerEventDelegation();
                                }, 200);
                            } else if (data.errors) {
                                // Show validation errors
                                const errorMessages = Object.values(data.errors)
                                    .flat()
                                    .map(msg => `- ${msg}`)
                                    .join('\\n');
                                alert(`Vui lòng kiểm tra lại:\\n${errorMessages}`);
                            } else {
                                alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                            }
                        })
                        .catch(error => {
                            // Reset button state
                            submitBtn.disabled = false;
                            btnText.textContent = 'Xem Kết Quả';
                            spinner.classList.add('d-none');

                            // Silent error handling
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
                    console.log('Change event detected on:', event.target);
                    console.log('Target name:', event.target.name);
                    console.log('Target value:', event.target.value);

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
                                        `<i class="bi bi-plus-circle me-2"></i>Xem thêm ${nextLoad} bảng<span class="text-muted ms-2">(${remaining} còn lại)</span>`;
                                } else {
                                    btn.style.display = 'none';
                                }
                            }
                        }
                    });
                }

                function maintainCurrentPaginationState(table) {
                    // Follow working pattern from other tools - simpler approach
                    const loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                    if (!loadMoreBtn) {
                        console.log('No load more button found');
                        return;
                    }

                    let currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;

                    // Chỉ count visible rows (không bị ẩn bởi filter)
                    const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                    const visibleRows = Array.from(allRows).filter(row => {
                        return row.style.display !== 'none';
                    });

                    console.log(
                        `Maintaining pagination: ${currentLoaded} out of ${visibleRows.length} visible rows (${allRows.length} total)`
                    );

                    // Show rows according to current pagination state cho visible rows only
                    visibleRows.forEach((row, index) => {
                        if (index >= currentLoaded) {
                            row.style.display = 'none';
                            row.setAttribute('data-visible', 'false');
                        } else {
                            row.style.display = '';
                            row.setAttribute('data-visible', 'true');
                        }
                    });

                    // Update load more button dựa trên visible rows
                    const remaining = visibleRows.length - currentLoaded;
                    if (remaining > 0 && visibleRows.length > 10) {
                        const nextLoad = Math.min(10, remaining);
                        loadMoreBtn.innerHTML =
                            `<i class="bi bi-plus-circle me-2"></i>Xem thêm ${nextLoad} bảng<span class="text-muted ms-2">(${remaining} còn lại)</span>`;
                        loadMoreBtn.style.display = '';
                        loadMoreBtn.setAttribute('data-total', visibleRows.length);
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                }

            });
        </script>
    @endpush
@endsection
