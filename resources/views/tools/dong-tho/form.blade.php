@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.6') }}">
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
                    Xem ngày Động thổ
                </li>

            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem ngày tốt động thổ theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="--text-down-convert"  style="color: #192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="mb-2" style=" font-size: 14px; color: #212121;">Vui lòng điền ngày sinh, giới tính và khoảng thời gian cần xem ngày tốt vào các ô dưới đây.</p>

                                        <form id="buildHouseForm">
                                            @csrf

                                            <div class="row ">
                                                <div class="mb-3">
                                                     <label class="form-label fw-bold" style="color: #212121CC">Ngày tháng năm sinh</label>
                                                    
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

                                                <!-- Gender Selection -->
                                                <div class="mb-3">
                                                     <label class="form-label fw-bold" style="color: #212121CC">Giới tính</label>
                                                  
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="gender"
                                                                id="maleGender" value="male" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="maleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="gender"
                                                                id="femaleGender" value="female"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="femaleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-4">
                                                     <label class="form-label fw-bold" style="color: #212121CC">Thời gian dự kiến động thổ</label>
                                                   
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
                                                <button type="submit"class="btn fw-bold btnd-nfay" style="background: #115097"
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_dongtho.svg);
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
                                Vì sao động thổ cần chọn ngày tốt?
                            </h2>
                            <p class="mb-1">Động thổ là nghi lễ quan trọng mở đầu cho việc xây dựng hoặc sửa chữa công
                                trình: nhà ở, văn phòng, công ty hay dự án lớn. Đây là bước khởi đầu mang tính quyết định,
                                vì người xưa tin rằng chọn ngày tốt sẽ giúp:</p>
                            <ul class="mb-1">
                                <li>Công trình thi công thuận lợi, tránh trắc trở, chậm tiến độ.</li>
                                <li>Tăng năng lượng may mắn, giảm rủi ro, tai ương trong quá trình thi công.</li>
                                <li>Tâm lý chủ đầu tư và gia đình yên tâm, tự tin thực hiện kế hoạch.</li>
                            </ul>
                            <p class="mb-3">Nếu ngày động thổ không phù hợp, theo phong thủy truyền thống, có thể gặp các
                                bất lợi như trì trệ, hao tốn chi phí hoặc ảnh hưởng đến phong thủy nhà cửa.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Lợi ích của việc chọn ngày động thổ hợp tuổi
                            </h2>
                            <p class="mb-2">Chọn ngày động thổ phù hợp mang lại những lợi ích cụ thể:</p>
                            <ul class="mb-3">
                                <li>Hạn chế xung khắc tuổi gia chủ với ngày, tránh các yếu tố phong thủy không thuận.</li>
                                <li>Chọn ngày hoàng đạo, giờ hoàng đạo, giúp công trình khởi công trôi chảy.</li>
                                <li>Tạo nền tảng vững chắc về tâm lý và phong thủy, từ ngày đầu thi công cho tới hoàn thiện.
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Khi xem ngày động thổ, cần chú ý điều gì?
                            </h2>
                            <ul style="list-style-type: upper-alpha;" class="mb-3">
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố có lợi cần ưu tiên</h3>
                                    <ul style="list-style-type: decimal;" class="mb-3">
                                        <li>
                                            <p class="mb-0">Ngày hoàng đạo, trực tốt</p>
                                            <p class="mb-0">Ngày Hoàng đạo và các trực như: Trực Khai, Trực Thành, Trực
                                                Mãn thường được dùng cho động thổ vì mang ý nghĩa mở đầu thuận lợi.</p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Ngày hợp tuổi gia chủ</p>
                                            <p class="mb-0">Ngũ hành và Can Chi của ngày nên tương sinh hoặc tương hỗ với
                                                tuổi chủ công trình.</p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Sao tốt và giờ tốt</p>
                                            <p class="mb-0">Lựa chọn ngày có sao cát lợi về xây dựng, như Thiên Đức, Phúc
                                                Sinh…</p>
                                            <p class="mb-0">Chọn khung giờ hoàng đạo để làm lễ động thổ, xuất hành vật
                                                liệu hoặc làm nghi thức khai sàng.</p>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố cần tránh</h3>
                                    <ul class="mb-1">
                                        <li>Ngày xung tuổi hoặc phạm Thái Tuế của gia chủ.</li>
                                        <li>Ngày hắc đạo hoặc trực xấu, ví dụ Trực Bế, Trực Phá, Trực Nguy.</li>
                                        <li>Sao xấu, như sao Đại Hao, Thiên Cương…</li>
                                        <li>Ngày có bách kỵ liên quan đến xây dựng, khởi công: Thọ Tử, Sát Chủ Dương…</li>
                                    </ul>
                                </li>
                            </ul>
                            <p class="mb-3">Tránh những ngày này giúp buổi động thổ diễn ra suôn sẻ, giảm rủi ro và khó
                                khăn cho công trình.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn sử dụng công cụ Xem Ngày Động Thổ trên Phong Lịch
                            </h2>
                            <ul class="mb-3" style="list-style-type: decimal;">
                                <li>Nhập tuổi gia chủ (âm lịch hoặc dương lịch).</li>
                                <li>Chọn khoảng thời gian dự định khởi công.</li>
                                <li>Hệ thống sẽ:
                                    <ul>
                                        <li>Gợi ý những ngày động thổ tốt nhất,</li>
                                        <li>Hiển thị điểm tốt – xấu của từng ngày,</li>
                                        <li>Liệt kê sao tốt/xấu, trực, giờ hoàng đạo,</li>
                                        <li>Đưa ra các lưu ý quan trọng.</li>
                                    </ul>
                                </li>
                                <li>Chọn ngày phù hợp thực tế dựa trên lịch trình và tiện ích của gia chủ.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Một ngày động thổ đẹp mang lại lợi ích gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Công trình thi công thuận lợi, khởi đầu suôn sẻ.</li>
                                <li>Tránh rủi ro và hao tổn không đáng có từ những yếu tố xấu trong phong thủy.</li>
                                <li>Tạo tâm lý an tâm cho gia chủ và đội thi công, mọi việc tiến triển suôn sẻ hơn.</li>
                                <li>Đặt nền móng may mắn cho toàn bộ quá trình xây dựng, từ động thổ đến hoàn thiện.</li>
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

                // Restore gender from hash
                if (params.gender) {
                    const maleRadio = document.getElementById('maleGender');
                    const femaleRadio = document.getElementById('femaleGender');

                    if (params.gender === 'female' && femaleRadio) {
                        femaleRadio.checked = true;
                        maleRadio.checked = false;
                    } else if (params.gender === 'male' && maleRadio) {
                        maleRadio.checked = true;
                        femaleRadio.checked = false;
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
                        if (birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('buildHouseForm');
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

            // ========== FORM HANDLING ==========
            const form = document.getElementById('buildHouseForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');
            const originalBtnText = btnText.innerHTML;

            // Handle form submission
            form.addEventListener('submit', async function(e) {
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

                // Get gender value
                const genderValue = document.querySelector('input[name="gender"]:checked').value;

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

                if (calendarType === 'lunar') {
                    // For lunar calendar:
                    // - ngayXemValue is already SOLAR date (from hidden input .value)
                    // - data-display-value contains the lunar display format

                    const daySelect = document.getElementById('ngaySelect');
                    const monthSelect = document.getElementById('thangSelect');
                    const yearSelect = document.getElementById('namSelect');

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

                // The LunarSolarDateSelect module automatically maintains solar date in hidden input
                // No need for additional conversion here - just use the value that's already there
                const finalSolarDate =
                    ngayXemValue; // This is always solar date maintained by the module

                // URL birthdate is the same as final solar date
                if (calendarType === 'lunar') {
                    urlBirthdate = finalSolarDate; // Use solar date for URL sharing
                }

                // Process form data - birthdate is ALWAYS solar date for backend processing
                let formData = {};

                if (calendarType === 'lunar') {
                    // For lunar: send solar date as birthdate, lunar date as additional info
                    formData = {
                        birthdate: urlBirthdate, // ALWAYS solar date for backend
                        gender: genderValue,
                        calendar_type: 'lunar',
                        leap_month: isLeapMonth,
                        lunar_date: formattedBirthdate, // Additional info: what user selected in lunar
                        date_range: dateRangeValue,
                        start_date: startDate,
                        end_date: endDate,
                        sort: sortValue,
                        _token: '{{ csrf_token() }}'
                    };
                } else {
                    // For solar: send solar date as birthdate
                    formData = {
                        birthdate: urlBirthdate, // Solar date (same as what user selected)
                        gender: genderValue,
                        calendar_type: 'solar',
                        leap_month: false,
                        date_range: dateRangeValue,
                        start_date: startDate,
                        end_date: endDate,
                        sort: sortValue,
                        _token: '{{ csrf_token() }}'
                    };
                }

                // Set hash parameters for URL state - preserve original calendar type
                const hashParams = {
                    birthdate: urlBirthdate, // Use solar date for URL (easier to share)
                    khoang: dateRangeValue,
                    gender: genderValue,
                    calendar_type: calendarType // This will be 'lunar' or 'solar' based on radio selection
                };
                setHashParams(hashParams);

                // Show loading state
                submitBtn.disabled = true;
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                // Submit via AJAX
                fetch('{{ route('breaking.check') }}', {
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
                        btnText.innerHTML = originalBtnText;
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

                            // Re-initialize Bootstrap tabs if present
                            resultsContainer.querySelectorAll('[data-bs-toggle="tab"]')
                                .forEach(tab => new bootstrap.Tab(tab));

                            // Khởi tạo taboo filter và pagination với dữ liệu từ response
                            setTimeout(() => {
                                // Sử dụng global initTabooFilter từ component
                                if (typeof window.initTabooFilter === 'function') {
                                    window.initTabooFilter(data.resultsByYear);
                                }
                                initPagination();
                                setupContainerEventDelegation();
                            }, 200);
                        } else if (data.errors) {
                            // Show validation errors
                            const errorMessages = Object.entries(data.errors)
                                .map(([field, errors]) => `- ${errors[0]}`)
                                .join('\\n');
                            alert(`Vui lòng kiểm tra lại:\\n${errorMessages}`);
                        } else {
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        // Reset button state
                        submitBtn.disabled = false;
                        btnText.innerHTML = originalBtnText;
                        spinner.classList.add('d-none');

                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    });
            });

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

            function applySortingToTable(sortValue, year) {

                // Tìm tab hiện tại hoặc sử dụng year parameter
                let activeTab = document.querySelector('.tab-pane.show.active');
                if (!activeTab && year) {
                    activeTab = document.querySelector(`#year-${year}`);
                }
                if (!activeTab) {
                    return;
                }

                // Tìm table trong tab hiện tại
                const table = activeTab.querySelector('#bang-chi-tiet table tbody');
                if (!table) {
                    return;
                }

                const rows = Array.from(table.querySelectorAll('tr'));

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

                // Clear table and re-append sorted rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));

                // Maintain current pagination - pass year parameter
                const currentYear = activeTab.id.replace('year-', '');
                maintainCurrentPagination(table, currentYear);
            }

            // Setup container-level event delegation like mua-xe
            function setupContainerEventDelegation() {

                const resultContainer = document.querySelector('.--detail-success');
                if (resultContainer) {

                    // Remove any existing listeners first
                    resultContainer.removeEventListener('change', handleContainerChange);

                    // Add new listener
                    resultContainer.addEventListener('change', handleContainerChange);
                } else {
                }
            }

            function handleContainerChange(event) {

                if (event.target.name === 'sort') {
                    event.preventDefault();
                    event.stopPropagation();

                    // Tìm năm hiện tại từ tab active
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    const currentYear = activeTab ? activeTab.id.replace('year-', '') : null;

                    applySortingToTable(event.target.value, currentYear);

                    // Scroll to table after sort
                    setTimeout(() => {
                        const bangChiTiet = activeTab?.querySelector('#bang-chi-tiet');
                        bangChiTiet?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            }

            function getDateFromRow(row) {
                // Try different ways to find the date - same as mua-xe

                // Method 1: Look for link with details
                let dateText = row.querySelector('a[href*="details"] strong');
                if (dateText) {
                    const text = dateText.textContent;
                    const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                    if (match) {
                        const dateStr = match[1];
                        const parts = dateStr.split('/');
                        const date = new Date(parts[2], parts[1] - 1, parts[0]);
                        return date;
                    }
                }

                // Method 2: Look for any strong element with date pattern
                const allStrong = row.querySelectorAll('strong');
                for (let strong of allStrong) {
                    const text = strong.textContent;
                    const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                    if (match) {
                        const dateStr = match[1];
                        const parts = dateStr.split('/');
                        const date = new Date(parts[2], parts[1] - 1, parts[0]);
                        return date;
                    }
                }

                // Method 3: Look for any text with date pattern
                const allText = row.textContent;
                const match = allText.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
                if (match) {
                    const dateStr = match[1];
                    const parts = dateStr.split('/');
                    const date = new Date(parts[2], parts[1] - 1, parts[0]);
                    return date;
                }

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
                    return;
                }

                let currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;

                // Đếm TOTAL filtered rows TRƯỚC khi thay đổi pagination
                const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                const totalFilteredRows = parseInt(loadMoreBtn.getAttribute('data-total')) || Array.from(allRows)
                    .filter(row => {
                        return row.style.display !== 'none';
                    }).length;

                 
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
    @include('components.next-year-button-handler')
    @include('components.taboo-filter-script')
@endpush
