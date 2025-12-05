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
                    <a href="{{ route('totxau.list') }}" style="color: #2254AB; text-decoration: underline;">Xem ngày
                        tốt</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày nhập trạch
                </li>

            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem ngày tốt nhập trạch theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold  title-tong-quan-h2-log" style="color: #192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form id="buildHouseForm">
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

                                                <!-- Gender Selection -->
                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h4-log fst-italic">Giới tính</div>
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="gender"
                                                                id="maleGender" value="nam" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="maleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="gender"
                                                                id="femaleGender" value="nữ"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="femaleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- House Direction Selection -->
                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h4-log fst-italic">Hướng nhà dự kiến</div>
                                                    <div class="position-relative">
                                                        <select class="form-select pe-5 --border-box-form"
                                                            id="houseDirectionSelect" name="house_direction"
                                                            style="padding: 12px 45px 12px 15px">

                                                            <option value="bac">Bắc</option>
                                                            <option value="dong_bac">Đông Bắc</option>
                                                            <option value="dong">Đông</option>
                                                            <option value="dong_nam">Đông Nam</option>
                                                            <option value="nam">Nam</option>
                                                            <option value="tay_nam">Tây Nam</option>
                                                            <option value="tay">Tây</option>
                                                            <option value="tay_bac">Tây Bắc</option>
                                                        </select>
                                                        <i class="bi bi-chevron-down position-absolute"
                                                            style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-4">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log fst-italic">Dự kiến
                                                        thời gian nhập trạch</div>
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
                                        style=" background-image: url(../images/form_nhaptrach.svg);
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
                                Vì sao nhập trạch cần chọn ngày tốt?
                            </h2>
                            <p class="mb-2">Nhập trạch là nghi lễ quan trọng đánh dấu việc chuyển vào nhà mới, nơi gắn
                                liền với cuộc sống
                                gia đình và năng lượng phong thủy của căn nhà. Một ngày tốt giúp:</p>
                            <ul class="mb-2">
                                <li>Gia đình yên tâm và thuận lợi trong việc dọn về nhà mới.</li>
                                <li>Tăng cát khí, mang lại may mắn, sức khỏe và tài lộc cho các thành viên.</li>
                                <li>Tránh xung khắc, hạn chế rủi ro về phong thủy hoặc tâm lý khi chuyển nhà.</li>
                            </ul>
                            <p class="mb-3">Ngày nhập trạch đẹp còn giúp lễ cúng đầy đủ, nghi thức trọn vẹn, tạo không
                                gian hài hòa cho gia chủ.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Lợi ích của việc chọn ngày nhập trạch hợp tuổi
                            </h2>
                            <ul class="mb-2">
                                <li>Ngày hợp tuổi gia chủ: Tránh xung khắc tuổi, giúp gia đình yên tâm, thuận hòa.</li>
                                <li>Ngày hoàng đạo và giờ hoàng đạo: Thuận lợi cho các nghi lễ, đi lại, vận chuyển đồ đạc.
                                </li>
                                <li>Sao tốt và trực tốt: Tăng cát khí, hạn chế những điều xui rủi trong ngày đầu về nhà mới.
                                </li>
                            </ul>
                            <p class="mb-3">Chọn đúng ngày nhập trạch không chỉ mang ý nghĩa phong thủy mà còn giúp gia
                                chủ cảm thấy tâm lý an toàn, tự tin khi bước vào ngôi nhà mới.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Khi xem ngày nhập trạch cần lưu ý điều gì?
                            </h2>
                            <ul style="	list-style-type: upper-alpha;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố cát lành nên ưu tiên</h3>
                                    <ul style="	list-style-type: decimal;" class="mb-2">
                                        <li>
                                            <p class="mb-0">Ngày hoàng đạo và trực tốt</p>
                                            <p class="mb-0">Ngày Hoàng Đạo, Trực Khai, Trực Thành, Trực Mãn thường được
                                                ưu tiên cho nhập trạch.</p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Ngày hợp tuổi gia chủ</p>
                                            <p class="mb-0">Ngũ hành và Can Chi của ngày nên tương sinh hoặc hỗ trợ tuổi
                                                gia chủ.</p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Sao tốt và giờ tốt</p>
                                            <ul style="	list-style-type: circle;">
                                                <li>Sao Thiên Đức, Phúc Sinh, Hỷ Thần… rất thuận cho gia đạo.</li>
                                                <li>Giờ hoàng đạo giúp nghi lễ và vận chuyển đồ đạc diễn ra suôn sẻ.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố xấu nên tránh</h3>
                                    <ul class="mb-2">
                                        <li>Ngày xung tuổi, phạm Thái Tuế.</li>
                                        <li>Ngày hắc đạo, trực xấu như Trực Phá, Trực Bế.</li>
                                        <li>Sao xấu như Bại, Hao, Thiên Cương.</li>
                                        <li>Ngày bách kỵ liên quan đến chuyển nhà hoặc xây dựng.</li>
                                    </ul>
                                </li>
                            </ul>
                            <p class="mb-3"> Việc tránh những ngày này giúp lễ nhập trạch diễn ra thuận lợi, gia đình ổn
                                định nhanh chóng, hạn chế phiền toái.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn sử dụng công cụ Xem Ngày Nhập Trạch tại Phong Lịch
                            </h2>
                            <ul style="list-style-type: decimal;">
                                <li>Nhập tuổi gia chủ (âm lịch hoặc dương lịch).</li>
                                <li>Chọn khoảng thời gian dự định chuyển vào nhà mới.</li>
                                <li>Hệ thống sẽ:
                                    <ul>
                                        <li>Gợi ý những ngày nhập trạch đẹp nhất,</li>
                                        <li>Hiển thị điểm tốt – xấu của từng ngày,</li>
                                        <li>Liệt kê sao tốt/xấu, trực, giờ hoàng đạo,</li>
                                        <li>Đưa ra lưu ý chi tiết cho gia chủ.</li>
                                    </ul>
                                </li>
                                <li>Chọn ngày phù hợp dựa trên lịch trình thực tế và sự thuận tiện của gia đình.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Một ngày nhập trạch đẹp mang lại lợi ích gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Gia đình yên tâm, mọi việc thuận lợi từ ngày đầu tiên.</li>
                                <li>Hóa giải xung khắc, hạn chế những trục trặc về phong thủy hoặc tâm lý.</li>
                                <li>Tăng cát khí cho ngôi nhà, giúp cuộc sống ổn định, tài lộc và sức khỏe tốt.</li>
                                <li>Nghi lễ trọn vẹn, đúng truyền thống, tạo cảm giác hạnh phúc, hài hòa cho mọi thành viên.
                                </li>
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
            const hasHashParams = window.location.hash?.includes('birthdate');

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
            const dateRangeInput = document.getElementById('date_range');
            let dateRangePickerInstance = null;
            const maxDateRangeAttempts = 10;
            let dateRangeInitAttempts = 0;

            const initDateRangePicker = () => {
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    dateRangeInput?.removeAttribute('readonly');
                    if (dateRangeInput) dateRangeInput.placeholder = 'DD/MM/YY - DD/MM/YY';
                    return;
                }

                dateRangeInitAttempts++;

                if (window.VanillaDateRangePicker) {
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
            };

            // Initialize after a short delay to ensure library is loaded
            setTimeout(initDateRangePicker, 100);

            // ========== HASH PARAMETER HANDLING ==========

            // Function to parse hash parameters
            const parseHashParams = () => {
                const hash = window.location.hash.substring(1);
                const params = {};
                if (hash) {
                    hash.split('&').forEach(pair => {
                        const [key, value] = pair.split('=');
                        if (key && value) {
                            params[decodeURIComponent(key)] = decodeURIComponent(value);
                        }
                    });
                }
                return params;
            };

            // Function to set hash parameters
            const setHashParams = params => {
                const hashParts = Object.entries(params)
                    .filter(([_, value]) => value)
                    .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
                window.location.hash = hashParts.join('&');
            };

            // Function to restore form from hash parameters
            const restoreFromHash = () => {
                const params = parseHashParams();
                console.log('🔄 Restoring from hash:', params);

                // Restore calendar type from hash first
                if (params.calendar_type) {
                    const {
                        solarRadio,
                        lunarRadio
                    } = {
                        solarRadio: document.getElementById('solarCalendar'),
                        lunarRadio: document.getElementById('lunarCalendar')
                    };

                    const isLunar = params.calendar_type === 'lunar';
                    if (isLunar && lunarRadio) {
                        lunarRadio.checked = true;
                        solarRadio.checked = false;
                        dateSelector && (dateSelector.isLunar = true);
                    } else if (!isLunar && solarRadio) {
                        solarRadio.checked = true;
                        lunarRadio.checked = false;
                        dateSelector && (dateSelector.isLunar = false);
                    }
                }

                // Restore gender from hash
                if (params.gender) {
                    const genderRadio = document.querySelector(
                        `input[name="gender"][value="${params.gender}"]`);
                    if (genderRadio) {
                        genderRadio.checked = true;
                        console.log('✅ Restored gender:', params.gender);
                    }
                }

                // Restore house direction from hash
                if (params.house_direction) {
                    const houseDirectionSelect = document.getElementById('houseDirectionSelect');
                    if (houseDirectionSelect) houseDirectionSelect.value = params.house_direction;
                }

                restoreOtherFields(params);
            };

            // Function to restore other fields after calendar type is set
            const restoreOtherFields = params => {
                if (!params.birthdate && !params.khoang) return;

                let formRestored = false;
                let birthdateSet = false;
                let dateRangeSet = false;

                const checkAndSubmitForm = () => {
                    if (birthdateSet && dateRangeSet && !formRestored) {
                        formRestored = true;
                        setTimeout(() => document.getElementById('buildHouseForm')?.requestSubmit(), 500);
                    }
                };

                if (params.birthdate) {
                    const tryRestoreBirthdate = async (attempts = 0) => {
                        const maxAttempts = 20;

                        if (attempts >= maxAttempts) {
                            birthdateSet = true;
                            checkAndSubmitForm();
                            return;
                        }

                        const {
                            daySelect,
                            monthSelect,
                            yearSelect
                        } = dateSelector || {};
                        if (!dateSelector || !daySelect || !monthSelect || !yearSelect || yearSelect
                            .options.length <= 1) {
                            setTimeout(() => tryRestoreBirthdate(attempts + 1), 300);
                            return;
                        }

                        const dateParts = params.birthdate.split('/');
                        if (dateParts.length !== 3) {
                            birthdateSet = true;
                            checkAndSubmitForm();
                            return;
                        }

                        const [day, month, year] = dateParts.map(Number);
                        const isLunar = params.calendar_type === 'lunar';

                        try {
                            // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                            if (isLunar) {
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
                    };

                    tryRestoreBirthdate();
                } else {
                    birthdateSet = true;
                }

                if (params.khoang) {
                    const trySetDateRange = (attempts = 0) => {
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
                    };

                    trySetDateRange();
                } else {
                    dateRangeSet = true;
                }
            };

            // Restore form from hash on page load
            setTimeout(restoreFromHash, 1000);

            // ========== AJAX FORM SUBMISSION ==========
            const formElements = {
                form: document.getElementById('buildHouseForm'),
                submitBtn: document.getElementById('submitBtn'),
                resultsContainer: document.getElementById('resultsContainer'),
                btnText: document.querySelector('#submitBtn .btn-text'),
                spinner: document.querySelector('#submitBtn .spinner-border')
            };

            const {
                form,
                submitBtn,
                resultsContainer,
                btnText,
                spinner
            } = formElements;

            form?.addEventListener('submit', e => {
                e.preventDefault();

                // Get form values using modern destructuring and optional chaining
                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput?.value;
                const dateRangeValue = dateRangeInput?.value;
                const genderValue = document.querySelector('input[name="gender"]:checked')?.value;
                const houseDirectionValue = document.getElementById('houseDirectionSelect')?.value;

                // Validate required fields
                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm');
                    return;
                }

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian');
                    return;
                }

                if (!houseDirectionValue) {
                    alert('Vui lòng chọn hướng nhà');
                    return;
                }

                // Get date and calendar type using modern destructuring
                const {
                    solarRadio,
                    lunarRadio
                } = {
                    solarRadio: document.getElementById('solarCalendar'),
                    lunarRadio: document.getElementById('lunarCalendar')
                };

                const calendarType = lunarRadio?.checked ? 'lunar' : 'solar';
                let isLeapMonth = false;
                let formattedBirthdate = '';

                // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                if (calendarType === 'lunar') {
                    const {
                        solarDay,
                        solarMonth,
                        solarYear,
                        lunarLeap
                    } = ngayXemInput?.dataset || {};
                    isLeapMonth = lunarLeap === '1';
                    formattedBirthdate = (solarDay && solarMonth && solarYear) ?
                        `${solarDay.padStart(2, '0')}/${solarMonth.padStart(2, '0')}/${solarYear}` :
                        ngayXemValue.replace(/ \(ÂL(?:-Nhuận)?\)/g, '');
                } else {
                    formattedBirthdate = ngayXemValue;
                }

                // Parse date range with improved logic
                const dateRangeParts = dateRangeValue.split(' - ');
                const parseDate = datePart => {
                    const parts = datePart.trim().split('/');
                    if (parts.length !== 3) return '';

                    const [day, month, year] = parts;
                    const fullYear = year.length === 2 ? `20${year}` : year;
                    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${fullYear}`;
                };

                const [startDate, endDate] = dateRangeParts.length === 2 ? [parseDate(dateRangeParts[0]),
                    parseDate(dateRangeParts[1])
                ] : ['', ''];

                // Get sort value using optional chaining
                const sortValue = resultsContainer?.querySelector('[name="sort"]')?.value ?? 'desc';

                // Prepare form data using object shorthand
                const formData = {
                    birthdate: formattedBirthdate,
                    gioi_tinh: genderValue,
                    huong_nha: houseDirectionValue,
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
                    gender: genderValue,
                    house_direction: houseDirectionValue,
                    calendar_type: calendarType
                };
                setHashParams(hashParams);

                // Show loading state using modern approach
                const setLoadingState = (loading = true) => {
                    if (submitBtn) submitBtn.disabled = loading;
                    if (btnText) btnText.textContent = loading ? 'Đang xử lý...' : 'Xem Kết Quả';
                    if (spinner) spinner.classList.toggle('d-none', !loading);
                };

                setLoadingState(true);

                // Submit via AJAX with modern async/await approach
                const submitForm = async () => {
                    try {
                        const response = await fetch('{{ route('nhap-trach.check') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const data = await response.json();
                        setLoadingState(false);

                        if (data.success) {
                            // Show results using modern approach
                            if (resultsContainer) {
                                resultsContainer.style.display = 'block';
                                resultsContainer.innerHTML = data.html;
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
                                // Smooth scroll to results
                                // setTimeout(() => {
                                //     resultsContainer.scrollIntoView({
                                //         behavior: 'smooth',
                                //         block: 'start'
                                //     });
                                // }, 100);

                                // Re-initialize Bootstrap tabs using modern approach
                                resultsContainer.querySelectorAll('[data-bs-toggle="tab"]')
                                    .forEach(tab => new bootstrap.Tab(tab));

                                // Khởi tạo taboo filter và pagination với dữ liệu từ response
                                setTimeout(() => {
                                    if (data.resultsByYear) {
                                        if (typeof window.initTabooFilter === 'function') {
                                            window.initTabooFilter(data.resultsByYear);
                                        }
                                    }
                                    initPagination();
                                    setupContainerEventDelegation();
                                }, 200);
                            }
                        } else if (data.errors) {
                            // Show validation errors using modern string formatting
                            const errorMessages = Object.values(data.errors)
                                .map(errors => errors[0])
                                .join('\n- ');
                            alert(`Vui lòng kiểm tra lại:\n- ${errorMessages}`);
                        } else {
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    } catch (error) {
                        setLoadingState(false);
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    }
                };

                submitForm();
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

                const rows = Array.from(table.querySelectorAll('tr'));
                console.log(`Found ${rows.length} rows to sort`);

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
    @include('components.next-year-button-handler')
    @include('components.taboo-filter-script')
@endpush
