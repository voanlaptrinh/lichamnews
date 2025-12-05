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
                    Xem ngày lập bàn thờ
                </li>
            </ol>
        </nav>

        <h1 class="content-title-home-lich">Xem ngày tốt lập bàn thờ theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <form id="lapBanThoForm">
                                            @csrf

                                            <div class="row g-1">
                                                <div class="">
                                                    <div class="fw-bold title-tong-quan-h2-log" style="color: #192E52">

                                                        Thông tin gia chủ
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                <div for="birthdate" class="fw-bold title-tong-quan-h4-log mb-2">Ngày
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

                                                @error('birthdate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="input-group mb-4">
                                                <div for="date_range" class="fw-bold title-tong-quan-h4-log"
                                                    style="color: #192E52; padding-bottom: 12px;"> Dự kiến
                                                    thời gian lập bàn thờ</div>
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
                                        style=" background-image: url(../images/form_lapban.svg);
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
                        @if (isset($resultsByYear))
                            @include('tools.lap-ban-tho.results')
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                            </div>
                        @endif
                    </div>


                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Vì sao cần xem ngày tốt để lập bàn thờ?
                            </h2>
                            <p class="mb-1">
                                Lập bàn thờ là nghi thức quan trọng, bởi bàn thờ là nơi kết nối với gia tiên, thần linh
                                và
                                là trung tâm tâm linh của ngôi nhà. Một ngày lập bàn thờ phù hợp giúp việc an vị trở nên
                                trang nghiêm, thuận lợi, mang lại sinh khí tốt cho gia đình.
                            </p>
                            <p class="mb-1">
                                Chọn ngày tốt để lập bàn thờ giúp:
                            </p>
                            <ul class="mb-3">
                                <li>Việc an vị diễn ra trọn vẹn, tránh sai phạm về tâm linh.</li>
                                <li>Tăng cát khí, giúp ngôi nhà ổn định, ấm cúng và linh ứng.</li>
                                <li>Hạn chế ảnh hưởng của các ngày xấu có thể gây bất an hoặc trắc trở.</li>
                                <li>Gia chủ cảm thấy an tâm, thuận lợi trong cuộc sống sau này.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Lợi ích khi chọn ngày lập bàn thờ hợp tuổi
                            </h2>
                            <ul class="mb-1">
                                <li>Không phạm xung tuổi gia chủ, giúp việc an vị hòa hợp và linh ứng.</li>
                                <li>Ngũ hành ngày – tuổi – hướng hợp nhau, tăng cát khí trong không gian thờ tự.</li>
                                <li>Sao tốt, giờ tốt hỗ trợ việc thỉnh thần linh, gia tiên được suôn sẻ.</li>
                                <li>Tránh được ngày bách kỵ dễ gây trục trặc hoặc thiếu may mắn.</li>
                            </ul>
                            <p class="mb-3">Một ngày hợp tuổi sẽ làm nghi thức lập bàn thờ diễn ra trang trọng và
                                vững
                                vàng hơn.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Khi xem ngày lập bàn thờ, cần lưu ý điều gì?
                            </h2>
                            <ul class="mb-3" style="list-style-type: upper-alpha;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố cát lành nên ưu tiên</h3>
                                    <ul style="	list-style-type: decimal;" class="mb-1">
                                        <li>
                                            <p class="mb-1"> Ngày hoàng đạo – trực tốt
                                            </p>
                                            <p class="mb-1">Nên chọn:
                                            </p>
                                            <ul class="mb-1">
                                                <li>Ngày Hoàng đạo như Thanh Long, Minh Đường, Kim Quỹ, Tư Mệnh.</li>
                                                <li>Các trực mang tính ổn định, cát lợi: Trực Khai, Trực Thành, Trực
                                                    Mãn.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1"> Ngày hợp tuổi gia chủ
                                            </p>
                                            <ul class="mb-1">
                                                <li>Ngày không xung – phá – hại theo tuổi Can Chi.</li>
                                                <li>Ưu tiên ngày có ngũ hành tương sinh hoặc tương hỗ với bản mệnh.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1"> Sao cát và giờ tốt
                                            </p>
                                            <p class="mb-1">Các sao nên ưu tiên khi lập bàn thờ:
                                            </p>
                                            <ul class="mb-1">
                                                <li>Thiên Đức, Nguyệt Đức, Thiên Ân, Thiên Phúc.</li>
                                                <li>Chọn giờ Hoàng đạo để tăng sự trang nghiêm và linh khí của nghi lễ.
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố xấu nên tránh</h3>
                                    <ul style="list-style-type: decimal;">
                                        <li>
                                            <p class="mb-1">Ngày xung tuổi hoặc phạm hạn</p>
                                            <ul class="mb-1">
                                                <li>Ngày Lục Xung, Lục Hại.</li>
                                                <li>Ngày phạm Thái Tuế.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày hắc đạo – trực xấu</p>
                                            <ul class="mb-1">
                                                <li>Hắc đạo như Huyền Vũ, Bạch Hổ, Câu Trận.</li>
                                                <li>Trực: Trực Phá, Trực Nguy, Trực Bế.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày bách kỵ bất lợi cho việc lập bàn thờ</p>
                                            <ul class="mb-1">
                                                <li>Tam Nương (3, 7, 13, 18, 22, 27).</li>
                                                <li>Nguyệt Kỵ (5, 14, 23).</li>
                                                <li>Dương Công Kỵ Nhật.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <p class="mb-1">Tránh các ngày này sẽ giúp việc lập bàn thờ ổn định, tránh những
                                        điều
                                        bất an về sau.</p>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn sử dụng công cụ Xem Ngày Lập Bàn Thờ tại Phong Lịch
                            </h2>
                            <ul style="	list-style-type: decimal;" class="mb-3">
                                <li>Nhập tuổi của gia chủ để hệ thống chọn ngày hợp mệnh và tránh xung khắc.</li>
                                <li>Chọn ngày hoặc khoảng thời gian dự định lập bàn thờ.</li>
                                <li>Công cụ sẽ tự động hiển thị:
                                    <ul class="mb-1">
                                        <li>Danh sách ngày lập bàn thờ tốt nhất.</li>
                                        <li>Điểm tốt – xấu của từng ngày.</li>
                                        <li>Sao tốt – sao xấu, trực ngày, hoàng đạo – hắc đạo.</li>
                                        <li>Gợi ý giờ Hoàng đạo để tiến hành nghi lễ.</li>
                                    </ul>
                                </li>
                                <li>Gia chủ chỉ cần chọn ngày phù hợp với lịch trình, ưu tiên ngày có điểm tốt cao nhất.
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Một ngày lập bàn thờ đẹp mang lại lợi ích gì?
                            </h2>
                            <ul class="mb-1">
                                <li>Không gian thờ tự trang trọng, linh khí vững vàng.</li>
                                <li>Thuận lợi trong việc thỉnh thần linh, gia tiên.</li>
                                <li>Gia đình được hỗ trợ tốt về bình an, sức khỏe, tài lộc.</li>
                                <li>Tâm lý an tâm, giúp cuộc sống sau này thuận hòa hơn.</li>
                                <li>Tạo nền tảng tâm linh bền vững cho ngôi nhà.</li>
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
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.8') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const dateRangeInput = document.getElementById('date_range');
            let dateRangePickerInstance = null;
            let dateRangeInitAttempts = 0;
            const maxDateRangeAttempts = 10;

            function initDateRangePicker() {
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    if (dateRangeInput) {
                        dateRangeInput.removeAttribute('readonly');
                        dateRangeInput.placeholder = 'dd/mm/yy - dd/mm/yy';
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

            setTimeout(initDateRangePicker, 100);

            // ========== HASH PARAMETER HANDLING ==========
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

            function setHashParams(params) {
                const hashParts = [];
                for (const [key, value] of Object.entries(params)) {
                    if (value) {
                        hashParts.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
                    }
                }
                window.location.hash = hashParts.join('&');
            }

            function restoreFromHash() {
                const params = parseHashParams();
                if (params.calendar_type) {
                    const solarRadio = document.getElementById('solarCalendar');
                    const lunarRadio = document.getElementById('lunarCalendar');

                    if (params.calendar_type === 'lunar' && lunarRadio) {
                        lunarRadio.checked = true;
                        solarRadio.checked = false;
                        if (dateSelector) {
                            dateSelector.isLunar = true;
                        }
                    } else if (params.calendar_type === 'solar' && solarRadio) {
                        solarRadio.checked = true;
                        lunarRadio.checked = false;
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
                        function tryRestoreBirthdate(attempts = 0) {
                            const maxAttempts = 20;

                            if (attempts >= maxAttempts) {
                                birthdateSet = true;
                                checkAndSubmitForm();
                                return;
                            }

                            if (dateSelector && dateSelector.daySelect && dateSelector.monthSelect && dateSelector
                                .yearSelect &&
                                dateSelector.yearSelect.options.length > 1) {

                                const dateParts = params.birthdate.split('/');
                                if (dateParts.length === 3) {
                                    const day = parseInt(dateParts[0]);
                                    const month = parseInt(dateParts[1]);
                                    const year = parseInt(dateParts[2]);

                                    (async () => {
                                        try {
                                            if (params.calendar_type === 'lunar') {
                                                await dateSelector.setDate(day, month, year, false, false);
                                                try {
                                                    await dateSelector.setDate(day, month, year, false,
                                                        false);
                                                    const lunarRadio = document.getElementById(
                                                        'lunarCalendar');
                                                    const solarRadio = document.getElementById(
                                                        'solarCalendar');
                                                    if (lunarRadio && solarRadio) {
                                                        lunarRadio.checked = true;
                                                        solarRadio.checked = false;
                                                        if (dateSelector && typeof dateSelector
                                                            .handleLunarRadioChange === 'function') {
                                                            await dateSelector.handleLunarRadioChange();
                                                        }
                                                    }
                                                } catch (error) {
                                                    await dateSelector.setDate(day, month, year, true,
                                                        false);
                                                }

                                            } else {
                                                await dateSelector.setDate(day, month, year, false, false);
                                                const lunarRadio = document.getElementById('lunarCalendar');
                                                const solarRadio = document.getElementById('solarCalendar');
                                                if (lunarRadio && solarRadio) {
                                                    solarRadio.checked = true;
                                                    lunarRadio.checked = false;
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
                                setTimeout(() => tryRestoreBirthdate(attempts + 1), 300);
                            }
                        }

                        tryRestoreBirthdate();
                    } else {
                        birthdateSet = true;
                    }

                    if (params.khoang) {
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

                    function checkAndSubmitForm() {
                        if (birthdateSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            setTimeout(() => {
                                const form = document.getElementById('lapBanThoForm');
                                if (form) {
                                    form.requestSubmit();
                                }
                            }, 500);
                        }
                    }
                }
            }

            setTimeout(restoreFromHash, 1000);

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('lapBanThoForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput.value;

                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm sinh của gia chủ');
                    return;
                }

                const dateRangeValue = dateRangeInput.value;
                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian dự kiến');
                    return;
                }

                let formattedBirthdate = '';
                let calendarType = 'solar';
                let isLeapMonth = false;

                const solarRadio = document.getElementById('solarCalendar');
                const lunarRadio = document.getElementById('lunarCalendar');

                if (lunarRadio && lunarRadio.checked) {
                    calendarType = 'lunar';
                } else if (solarRadio && solarRadio.checked) {
                    calendarType = 'solar';
                }

                if (calendarType === 'lunar') {
                    const solarDay = ngayXemInput.dataset.solarDay;
                    const solarMonth = ngayXemInput.dataset.solarMonth;
                    const solarYear = ngayXemInput.dataset.solarYear;
                    isLeapMonth = ngayXemInput.dataset.lunarLeap === '1';

                    if (solarDay && solarMonth && solarYear) {
                        formattedBirthdate =
                            `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}`;
                    } else {
                        formattedBirthdate = ngayXemValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
                        isLeapMonth = ngayXemValue.includes('(ÂL-Nhuận)');
                    }
                } else {
                    formattedBirthdate = ngayXemValue;
                }

                const sortSelect = resultsContainer.querySelector('[name="sort"]');
                const sortValue = sortSelect ? sortSelect.value : 'desc';

                const formData = new FormData(form);
                formData.set('birthdate', formattedBirthdate);
                formData.set('calendar_type', calendarType);
                formData.set('leap_month', isLeapMonth);
                formData.set('sort', sortValue);

                const hashParams = {
                    birthdate: formattedBirthdate,
                    khoang: dateRangeValue,
                    calendar_type: calendarType
                };
                setHashParams(hashParams);


                submitBtn.disabled = true;
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                fetch('{{ route('lap-ban-tho.check') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        btnText.textContent = 'Xem Kết Quả';
                        spinner.classList.add('d-none');

                        if (data.success) {
                            setTimeout(() => {
                                resultsContainer.innerHTML = data.html;

                                // Cập nhật window.resultsByYear cho global access
                                if (data.resultsByYear) {
                                    window.resultsByYear = data.resultsByYear;
                                }

                                setTimeout(() => {
                                    if (data.resultsByYear && typeof window
                                        .initTabooFilter === 'function') {
                                        window.initTabooFilter(data.resultsByYear);
                                    }
                                    initPagination();
                                    setupContainerEventDelegation();
                                }, 200);
                            }, 500);
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
                            // resultsContainer.scrollIntoView({
                            //     behavior: 'smooth',
                            //     block: 'start'
                            // });
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="pill"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });
                        } else if (data.errors) {
                            let errorMessage = 'Vui lòng kiểm tra lại:\\n';
                            for (const field in data.errors) {
                                errorMessage += '- ' + data.errors[field][0] + '\\n';
                            }
                            alert(errorMessage);
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
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
                console.log('Change event detected on:', event.target);
                console.log('Target name:', event.target.name);
                console.log('Target value:', event.target.value);

                if (event.target.name === 'sort') {
                    console.log('Sort dropdown changed to:', event.target.value);
                    event.preventDefault();
                    event.stopPropagation();

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

                    // Scroll to table after sort
                    setTimeout(() => {
                        if (year) {
                            const yearTab = document.querySelector(`#year-${year}`);
                            const bangChiTiet = yearTab?.querySelector('#bang-chi-tiet');
                            bangChiTiet?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        } else {
                            const bangChiTiet = document.querySelector('#bang-chi-tiet');
                            bangChiTiet?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
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

                // Update filter status for this year if taboo filter is active
                if (year && typeof window.updateFilterStatusOnPagination === 'function') {
                    window.updateFilterStatusOnPagination(year);
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
                                    `Xem thêm `;
                            } else {
                                btn.style.display = 'none';
                            }
                        }
                    }
                });
            }

            function maintainCurrentPaginationState(table) {
                const loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                if (!loadMoreBtn) {
                    console.log('No load more button found');
                    return;
                }

                let currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;
                const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');

                // Đếm TOTAL filtered rows TRƯỚC khi thay đổi pagination
                const totalFilteredRows = parseInt(loadMoreBtn.getAttribute('data-total')) || Array.from(allRows)
                    .filter(row => {
                        return row.style.display !== 'none';
                    }).length;

                console.log(
                    `DEBUG: allRows=${allRows.length}, totalFilteredRows=${totalFilteredRows}, currentLoaded=${currentLoaded}`
                );
                console.log(
                    `Maintaining pagination: ${currentLoaded} out of ${totalFilteredRows} filtered rows (${allRows.length} total)`
                );

                // Tìm tất cả rows được filter (không bị ẩn hoàn toàn)
                const filteredRows = Array.from(allRows).filter(row => {
                    return !row.classList.contains('filtered-out');
                });

                // Nếu không có class filter, fallback về logic cũ
                if (filteredRows.length === 0 || filteredRows.length === allRows.length) {
                    // Sử dụng data-total từ button (đã được set khi filter)
                    let visibleCount = 0;
                    Array.from(allRows).forEach((row, index) => {
                        if (index < totalFilteredRows) {
                            if (visibleCount < currentLoaded) {
                                row.style.display = '';
                                row.setAttribute('data-visible', 'true');
                                visibleCount++;
                            } else {
                                row.style.display = 'none';
                                row.setAttribute('data-visible', 'false');
                            }
                        }
                    });
                } else {
                    // Show/hide filtered rows với pagination
                    let visibleCount = 0;
                    filteredRows.forEach((row) => {
                        if (visibleCount < currentLoaded) {
                            row.style.display = '';
                            row.setAttribute('data-visible', 'true');
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                            row.setAttribute('data-visible', 'false');
                        }
                    });
                }

                // Update load more button với total filtered rows
                const remaining = totalFilteredRows - currentLoaded;


                if (remaining > 0) {
                    const nextLoad = Math.min(10, remaining);
                    loadMoreBtn.innerHTML =
                        `Xem thêm`;
                    loadMoreBtn.style.display = '';
                    loadMoreBtn.setAttribute('data-total', totalFilteredRows);

                } else {
                    loadMoreBtn.style.display = 'none';

                }
            }
        });
    </script>
    @include('components.next-year-button-handler')
    @include('components.taboo-filter-script')
@endpush
