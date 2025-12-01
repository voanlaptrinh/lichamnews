@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.8') }}">
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
                    Xem ngày trấn trạch
                </li>
            </ol>
        </nav>



        <h1 class="content-title-home-lich">Xem ngày tốt trấn yểm, trấn trạch theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5" >
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

                                        <form id="tranTrachForm">
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
                                                        thời gian trấn trạch</div>
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_trantrach.svg);
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
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                               Vì sao trấn trạch cần chọn ngày tốt?
                            </h2>
                            <p class="mb-1">
                                Trấn trạch là nghi lễ quan trọng giúp ổn định năng lượng của ngôi nhà, hóa giải tà khí, tăng
                                cát khí và mang lại sự bình an cho gia chủ. Đây thường là nghi thức thực hiện khi mới vào
                                nhà, khi nhà gặp vận xấu hoặc khi gia chủ cảm thấy không gian sống chưa hài hòa.
                            </p>
                            <p class="mb-1">
                                Chọn ngày tốt để trấn trạch giúp:
                            </p>
                            <ul class="mb-1">
                                <li>Việc cúng lễ diễn ra suôn sẻ, dễ đạt được ý nguyện.</li>
                                <li>Tăng sinh khí cho căn nhà, cải thiện vận tài lộc - sức khỏe của gia đình.</li>
                                <li>Tránh phạm ngày xấu, hạn chế rủi ro về phong thủy hoặc tâm linh.</li>
                                <li>Tạo cảm giác yên tâm và cân bằng tinh thần cho gia chủ.</li>
                            </ul>
                            <p class="mb-1">Một ngày phù hợp là yếu tố quan trọng để buổi lễ trấn trạch đạt hiệu quả tốt
                                nhất.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích của việc chọn ngày trấn trạch hợp tuổi
                            </h2>
                            <ul class="mb-1">
                                <li>Không phạm ngày xung tuổi gia chủ, giúp lễ cúng hòa hợp, tránh xung khắc.</li>
                                <li>Ngày – giờ hoàng đạo hỗ trợ năng lượng cát lành, thúc đẩy vận nhà.</li>
                                <li>Ngũ hành – Can Chi tương sinh giúp tăng sự hòa hợp giữa gia chủ và mảnh đất.</li>
                                <li>Sao tốt – trực tốt tạo điều kiện để hóa giải khí xấu, nâng cát khí.</li>
                            </ul>
                            <p class="mb-1">Chọn ngày hợp tuổi không chỉ theo phong thủy mà còn giúp gia chủ cảm thấy yên
                                tâm, tự tin khi làm lễ.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi xem ngày trấn trạch cần lưu ý điều gì?
                            </h2>
                            <ul class="mb-1" style="list-style-type: upper-alpha;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Các yếu tố cát lành nên ưu tiên</h3>
                                    <ul style="	list-style-type: decimal;" class="mb-1">
                                        <li>
                                            <p class="mb-1">Ngày hoàng đạo và trực tốt
                                            </p>
                                            <p class="mb-1">Thường ưu tiên:
                                            </p>
                                            <ul class="mb-1">
                                                <li>Hoàng Đạo: Thanh Long, Minh Đường, Kim Quỹ, Ngọc Đường, Tư Mệnh.</li>
                                                <li>Trực tốt: Trực Khai, Trực Thành, Trực Mãn.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1"> Ngày hợp tuổi gia chủ
                                            </p>
                                            <ul class="mb-1">
                                                <li>Không phạm xung khắc theo Can Chi.</li>
                                                <li>Ngũ hành ngày sinh – hỗ trợ bản mệnh của gia chủ.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Sao tốt và giờ tốt
                                            </p>

                                            <ul class="mb-1">
                                                <li>Các sao cát thường dùng: Thiên Đức, Nguyệt Đức, Thiên Quan…</li>
                                                <li>Giờ Hoàng đạo để cúng lễ, hóa giải khí xấu hiệu quả hơn.
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Các yếu tố xấu nên tránh</h3>
                                    <ul style="list-style-type: decimal;">
                                        <li>
                                            <p class="mb-1">Ngày xung tuổi hoặc phạm hạn</p>
                                            <ul class="mb-1">
                                                <li>Ngày xung, hại mệnh theo ngũ hành.</li>
                                                <li>Ngày phạm Thái Tuế
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày hắc đạo – trực xấu</p>
                                            <ul class="mb-1">
                                                <li>Hắc đạo: Huyền Vũ, Bạch Hổ, Thiên Lao, Nguyên Vũ.</li>
                                                <li>Trực xấu: Trực Phá, Trực Nguy, Trực Bế.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày bách kỵ ảnh hưởng đến cúng lễ – cầu an</p>
                                            <ul class="mb-1">
                                                <li>Tam Nương (3, 7, 13, 18, 22, 27).</li>
                                                <li>Nguyệt Kỵ (5, 14, 23).</li>
                                                <li>Dương Công Kỵ Nhật.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <p class="mb-1">Tránh các ngày này sẽ giúp lễ trấn trạch diễn ra thuận lợi, hạn chế
                                        những biến động xấu trong không gian sống.</p>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Hướng dẫn sử dụng công cụ Xem Ngày Trấn Trạch tại Phong Lịch
                            </h2>
                            <ul class="mb-1" style="list-style-type: decimal;">
                                <li>Nhập tuổi gia chủ (âm lịch hoặc dương lịch đều được).</li>
                                <li>Chọn khoảng thời gian dự định làm lễ trấn trạch.</li>
                                <li>
                                    Hệ thống sẽ tự động:
                                    <ul class="mb-1">
                                        <li>Gợi ý những ngày trấn trạch tốt nhất.</li>
                                        <li>Hiển thị điểm tốt – xấu của từng ngày.</li>
                                        <li>Liệt kê sao tốt/xấu, trực tốt, ngày hoàng đạo.</li>
                                        <li>Đề xuất giờ Hoàng đạo để tiến hành lễ.</li>
                                    </ul>
                                </li>
                                <li>So sánh các ngày và lựa chọn ngày phù hợp nhất, dựa theo lịch gia đình và tình trạng
                                    ngôi nhà.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Một ngày trấn trạch đẹp mang lại lợi ích gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Không gian sống hài hòa, giảm tà khí – tăng sinh khí.</li>
                                <li>Gia đình cảm thấy an tâm hơn, tinh thần ổn định.</li>
                                <li>Hỗ trợ tài lộc, sức khỏe và sự thuận hòa giữa các thành viên.</li>
                                <li>Buổi lễ diễn ra trọn vẹn, đúng nghi thức, mang lại hiệu quả cao.</li>
                                <li>Tạo nền tảng phong thủy tốt cho ngôi nhà trong thời gian dài.</li>
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
                                const form = document.getElementById('tranTrachForm');
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
            const form = document.getElementById('tranTrachForm');
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
                fetch('{{ route('tran-trach.check') }}', {
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
                                new bootstrap.Tab(tab);
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

        });

        // Direct test for filter button
        document.addEventListener('click', function(e) {
            console.log('Click detected on:', e.target.id, e.target.className);
            if (e.target.id === 'tabooFilterBtn') {
                console.log('Direct click on filter button detected!');
            }
        });

        // Test function that can be called from console
        window.testTabooFilter = function() {
            const btn = document.getElementById('tabooFilterBtn');
            const modal = document.getElementById('tabooFilterModal');

            if (btn) {
                btn.click();
            }
        };

        // ========== PAGINATION & SORT FUNCTIONS - GIỐNG TOT-XAU ==========
        function initPagination() {
            console.log('initPagination called');

            // Event delegation cho load more button
            const resultsContainer = document.querySelector('.--detail-success');
            resultsContainer.addEventListener('click', function(event) {
                if (event.target.matches('.load-more-btn') || event.target.closest('.load-more-btn')) {
                    const btn = event.target.matches('.load-more-btn') ? event.target : event.target.closest(
                        '.load-more-btn');
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

        // SORT FUNCTIONS - COPY TỪ TOT-XAU
        function getScoreFromRow(row) {
            // For mua-nha: tìm score trong battery-fill style width
            const batteryFill = row.querySelector('.battery-fill');
            if (batteryFill) {
                const style = batteryFill.getAttribute('style');
                const match = style.match(/width:\s*(\d+)%/);
                if (match) {
                    return parseInt(match[1]) || 0;
                }
            }

            // Fallback: Try other score elements
            const scoreElement = row.querySelector('.diem-so, .score, .battery-label');
            if (scoreElement) {
                return parseInt(scoreElement.textContent.replace(/[^\d]/g, '')) || 0;
            }

            return 0;
        }

        function getDateFromRow(row) {
            const dateCell = row.querySelector('td:first-child a');
            if (!dateCell) return new Date(0);

            const dateText = dateCell.textContent;
            const match = dateText.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
            if (match) {
                return new Date(match[3], match[2] - 1, match[1]);
            }
            return new Date(0);
        }
    </script>
    @include('components.taboo-filter-script')
@endpush
