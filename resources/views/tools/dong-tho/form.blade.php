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
                    Xem ngày Động thổ
                </li>
             
            </ol>
        </nav>
  

        <h1 class="content-title-home-lich">Xem ngày tốt động thổ theo tuổi</h1>

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
                                                    <input type="hidden" id="ngayXem" name="birthdate" value="{{ old('birthdate', $inputs['birthdate'] ?? '') }}">

                                                    @error('birthdate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Gender Selection -->
                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h2-log">Giới tính</div>
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="gender" id="maleGender" value="male"
                                                                checked style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="maleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="gender" id="femaleGender" value="female"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="femaleGender"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-4">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h2-log">Dự kiến
                                                        thời gian động thổ</div>
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
                            <div class="mb-4">
                                <img src="{{ asset('/icons/defaild.png?v=1.0') }}" alt="defakd" class="img-fuild">
                            </div>
                            <p class="text-muted" style="font-size: 16px;">
                                Hiện chưa có thông tin, bạn vui lòng nhập thông tin để xem kết quả.
                            </p>
                        </div>
                    </div>
                </div>
                @include('tools.siderbarindex')
            </div>

        </div>
    </div>
        {{-- Results will be displayed here via AJAX --}}
        @if (isset($resultsByYear))
            <div class="results-container mt-5">

                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="yearTab" role="tablist">
                        @foreach ($resultsByYear as $year => $data)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($loop->first) active @endif"
                                    id="tab-{{ $year }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $year }}" type="button" role="tab"
                                    aria-controls="tab-{{ $year }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    Năm {{ $year }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="yearTabContent">
                        @foreach ($resultsByYear as $year => $data)
                            <div class="tab-pane fade @if ($loop->first) show active @endif"
                                id="tab-{{ $year }}" role="tabpanel"
                                aria-labelledby="tab-{{ $year }}-tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card p-4 ">
                                            <h4 class="mb-3">Thông tin gia chủ</h4>
                                            <ul>
                                                <li>Ngày sinh dương lịch:
                                                    <b>{{ $birthdateInfo['dob']->format('d/m/Y') }}</b>
                                                </li>
                                                <li>Ngày sinh âm lịch: <b>{{ $birthdateInfo['lunar_dob_str'] }}</b></li>
                                                <li>Tuổi: <b>{{ $birthdateInfo['can_chi_nam'] }}</b>, Mệnh:
                                                    {{ $birthdateInfo['menh']['hanh'] }}
                                                    ({{ $birthdateInfo['menh']['napAm'] }})
                                                </li>
                                                <li>Tuổi âm: <b>{{ $data['year_analysis']['lunar_age'] }}</b></li>

                                            </ul>

                                        </div>
                                    </div>
                                    {{-- @dd($data) --}}
                                    <div class="col-lg-8">
                                        <div class="card p-4 ">
                                            <h5 class="text-center">
                                                kiểm tra kim lâu - hoang ốc - tam tai
                                            </h5>
                                            <p>
                                                Kiểm tra xem năm {{ $year }} {{ $data['canchi'] }} gia chủ tuổi
                                                {{ $birthdateInfo['can_chi_nam'] }}
                                                ({{ $data['year_analysis']['lunar_age'] }} tuổi) có phạm phải Kim Lâu,
                                                Hoang Ốc, Tam Tai không?
                                            </p>
                                            <ul>
                                                <li>
                                                    {{ $data['year_analysis']['details']['kimLau']['message'] }}
                                                </li>
                                                <li>
                                                    {{ $data['year_analysis']['details']['hoangOc']['message'] }}
                                                </li>
                                                <li>
                                                    {{ $data['year_analysis']['details']['tamTai']['message'] }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- @dd($data) --}}
                                    <p>{!! $data['year_analysis']['description'] !!}</p>
                                </div>


                                @if ($data['year_analysis'])
                                    <h4 class="mt-4 mb-3">Bảng điểm chi tiết các ngày tốt</h4>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Ngày Dương Lịch</th>
                                                    <th>Ngày Âm Lịch</th>
                                                    <th>Điểm</th>
                                                    <th>Đánh giá</th>
                                                    <th>Giờ tốt (Hoàng Đạo)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Lọc và chỉ hiển thị những ngày có điểm TỐT hoặc RẤT TỐT --}}
                                                @php
                                                    $goodDays = array_filter($data['days'], function ($day) {
                                                        $rating = $day['day_score']['rating'];
                                                        return $rating === 'Tốt' || $rating === 'Rất tốt';
                                                    });
                                                @endphp

                                                @forelse($data['days'] as $day)
                                                    @php
                                                        if (!function_exists('getRatingClassBuildHouse')) {
                                                            function getRatingClassBuildHouse(string $rating): string
                                                            {
                                                                return match ($rating) {
                                                                    'Rất tốt' => 'table-success',
                                                                    'Tốt' => 'table-info',
                                                                    'Trung bình' => 'table-warning',
                                                                    default => 'table-danger',
                                                                };
                                                            }
                                                        }
                                                    @endphp
                                                    <tr
                                                        class="{{ getRatingClassBuildHouse($day['day_score']['rating']) }}">
                                                        <td>
                                                            <strong>{{ $day['date']->format('d/m/Y') }}</strong>
                                                            <br>
                                                            <small>{{ $day['weekday_name'] }}</small>
                                                        </td>
                                                        <td>{{ $day['full_lunar_date_str'] }}</td>
                                                        <td class="fw-bold fs-5">{{ $day['day_score']['percentage'] }}%
                                                        </td>
                                                        <td><strong>{{ $day['day_score']['rating'] }}</strong></td>
                                                        <td>
                                                            @if (!empty($day['good_hours']))
                                                                {{ implode('; ', $day['good_hours']) }}
                                                            @else
                                                                <span class="text-muted">Không có</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center p-4">
                                                            <p class="mb-0">Trong khoảng thời gian bạn chọn của năm nay,
                                                                không tìm thấy ngày nào thực sự tốt để tiến hành xây dựng.
                                                            </p>
                                                            <small>Bạn có thể thử mở rộng khoảng thời gian tìm kiếm.</small>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif
    </div>

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
                                            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
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
                            if (dateSelector && dateSelector.daySelect && dateSelector.monthSelect && dateSelector.yearSelect &&
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
                                                        if (dateSelector && typeof dateSelector.handleLunarRadioChange === 'function') {
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
                        formattedBirthdate = displayValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
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
                const finalSolarDate = ngayXemValue; // This is always solar date maintained by the module

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
                                resultsContainer.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 100);

                            // Re-initialize Bootstrap tabs if present
                            resultsContainer.querySelectorAll('[data-bs-toggle="tab"]')
                                .forEach(tab => new bootstrap.Tab(tab));
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

            function applySortingToTable(sortValue) {
                const table = document.querySelector('#bang-chi-tiet table tbody');
                if (!table) return;

                const rows = Array.from(table.querySelectorAll('tr'));

                rows.sort((a, b) => {
                    const scoreA = getScoreFromRow(a);
                    const scoreB = getScoreFromRow(b);
                    return sortValue === 'asc' ? scoreA - scoreB : scoreB - scoreA;
                });

                // Clear and re-append sorted rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));
            }

            // Handle sorting change using event delegation
            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    applySortingToTable(event.target.value);

                    // Scroll to table after sort
                    setTimeout(() => {
                        const bangChiTiet = document.querySelector('#bang-chi-tiet');
                        bangChiTiet?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            });

        });
    </script>
@endpush
