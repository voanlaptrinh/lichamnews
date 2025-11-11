@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.5') }}">

        <style>
           
        </style>
    @endpush


    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="">Tiện ích</a> <i
                class="bi bi-chevron-right"></i> <span>
                Xem ngày tốt xấu</span></h6>

        <h1 class="content-title-home-lich">Xem ngày tốt xấu</h1>

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

                                        <form id="totXauForm">
                                            <div class="mb-3">
                                                <!-- Date Selects -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                        <div class="position-relative">
                                                            <select class="form-select pe-5 --border-box-form" id="ngaySelect" name="day" style="padding: 12px 45px 12px 15px">
                                                                <option value="">Ngày</option>
                                                            </select>
                                                            <i class="bi bi-chevron-down position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                        <div class="position-relative">
                                                            <select class="form-select pe-5 --border-box-form" id="thangSelect" name="month" style="padding: 12px 45px 12px 15px">
                                                                <option value="">Tháng</option>
                                                            </select>
                                                            <i class="bi bi-chevron-down position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-lg-4 col-xl-4">
                                                        <div class="position-relative">
                                                            <select class="form-select pe-5 --border-box-form" id="namSelect" name="year" style="padding: 12px 45px 12px 15px">
                                                                <option value="">Năm</option>
                                                            </select>
                                                            <i class="bi bi-chevron-down position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Radio buttons dạng tròn bên dưới selects -->
                                                <div class="d-flex gap-4 ps-2">
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendar_type" id="solarCalendar" value="solar" checked
                                                               style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="solarCalendar"
                                                               style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Dương lịch
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendar_type" id="lunarCalendar" value="lunar"
                                                               style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="lunarCalendar"
                                                               style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Âm lịch
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Leap Month Option (hidden) -->
                                                <div class="form-check mt-2" id="leapMonthContainer" style="display: none;">
                                                    <input class="form-check-input" type="checkbox" id="leapMonth" name="leap_month">
                                                    <label class="form-check-label" for="leapMonth">
                                                        Tháng nhuận
                                                    </label>
                                                </div>

                                                <!-- Hidden input to store formatted date -->
                                                <input type="hidden" id="ngayXem" name="birthdate" value="{{ old('birthdate', $inputs['birthdate'] ?? '') }}">
                                            </div>

                                            <div class="fw-bold title-tong-quan-h2-log">Khoảng thời gian cần xem
                                            </div>
                                            <div class="mb-4">
                                                <div class="input-group">
                                                    <input type="text"  readonly
                                                        class="form-control wedding_date_range --border-box-form"
                                                        id="khoangNgay" name="date_range" placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                        value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                        style="border-radius: 10px; border: none; padding: 12px 45px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                    <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                        <i class="bi-calendar-date-fill text-muted"></i>
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
                            <div class="col-lg-4 d-none d-lg-block d-flex">
                                <div class="d-flex align-items-end h-100 w-100">
                                    <img src="{{ asset('/icons/datedoilich.svg') }}" alt="ảnh đổi lich" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="--detail-success">
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
    <script src="{{ asset('js/lunar-solar-date-select.js?v=1.2') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.6') }}" defer></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                defaultDay: 1,
                defaultMonth: 1,
                defaultYear: 2000,
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

            // Simple custom date range implementation
            function initDateRangePicker() {
                // Stop after max attempts to prevent infinite loop
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    console.warn('VanillaDateRangePicker could not be loaded after ' + maxDateRangeAttempts + ' attempts');
                    // Allow manual input as fallback
                    if (khoangNgayInput) {
                        khoangNgayInput.removeAttribute('readonly');
                        khoangNgayInput.placeholder = 'DD/MM/YY - DD/MM/YY';
                    }
                    return;
                }

                dateRangeInitAttempts++;

                // Check if vanilla-daterangepicker.js is loaded
                if (typeof window.VanillaDateRangePicker !== 'undefined') {
                    try {
                        // Destroy existing instance if any
                        if (dateRangePickerInstance) {
                            try {
                                dateRangePickerInstance.destroy();
                            } catch(e) {}
                        }

                        dateRangePickerInstance = new window.VanillaDateRangePicker(khoangNgayInput, {
                            autoApply: true, // Auto apply when selecting dates
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
                        });

                        // Remove any blur validation that might have been added
                        const newInput = khoangNgayInput.cloneNode(true);
                        khoangNgayInput.parentNode.replaceChild(newInput, khoangNgayInput);

                        // Re-initialize with the new input element
                        dateRangePickerInstance = new window.VanillaDateRangePicker(newInput, {
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
                        });

                        console.log('Date range picker initialized successfully');
                    } catch (error) {
                        console.error('Error initializing date range picker:', error);
                        // Stop retrying on error
                        dateRangeInitAttempts = maxDateRangeAttempts;
                    }
                } else {
                    // Only log first few attempts to avoid spam
                    if (dateRangeInitAttempts <= 3) {
                        console.log('VanillaDateRangePicker not loaded yet, attempt ' + dateRangeInitAttempts);
                    }
                    // Try again after a delay
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

                if (params.birthdate || params.khoang) {
                    let formRestored = false;
                    let birthdateSet = false;
                    let dateRangeSet = false;

                    if (params.birthdate) {
                        // Set birthdate
                        const ngayXemInput = document.getElementById('ngayXem');
                        ngayXemInput.value = params.birthdate;

                        // Parse birthdate to set individual fields
                        const dateParts = params.birthdate.split('/');
                        if (dateParts.length === 3) {
                            const day = parseInt(dateParts[0]);
                            const month = parseInt(dateParts[1]);
                            const year = parseInt(dateParts[2]);

                            // Set the selects with multiple retries to ensure they're populated
                            function trySetSelects(attempts = 0) {
                                const maxAttempts = 10;
                                const daySelect = document.getElementById('ngaySelect');
                                const monthSelect = document.getElementById('thangSelect');
                                const yearSelect = document.getElementById('namSelect');

                                if (attempts >= maxAttempts) return;

                                if (daySelect.options.length > 1 && monthSelect.options.length > 1 && yearSelect.options.length > 1) {
                                    daySelect.value = day;
                                    monthSelect.value = month;
                                    yearSelect.value = year;

                                    // Trigger change events to update the form
                                    daySelect.dispatchEvent(new Event('change'));
                                    monthSelect.dispatchEvent(new Event('change'));
                                    yearSelect.dispatchEvent(new Event('change'));

                                    birthdateSet = true;
                                    checkAndSubmitForm();
                                } else {
                                    setTimeout(() => trySetSelects(attempts + 1), 200);
                                }
                            }

                            trySetSelects();
                        }
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

            // ========== FORM HANDLING ==========
            const form = document.getElementById('totXauForm');
            const khoangNgay = document.getElementById('khoangNgay');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            // Handle form submission
            form.addEventListener('submit', function(e) {
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

                // Get the date based on calendar type
                let formattedBirthdate = '';
                const calendarType = ngayXemInput.dataset.calendarType || 'solar';
                let isLeapMonth = false;

                if (calendarType === 'lunar') {
                    // If lunar date, use the converted solar date
                    const solarDay = ngayXemInput.dataset.solarDay;
                    const solarMonth = ngayXemInput.dataset.solarMonth;
                    const solarYear = ngayXemInput.dataset.solarYear;
                    isLeapMonth = ngayXemInput.dataset.lunarLeap === '1';

                    if (solarDay && solarMonth && solarYear) {
                        formattedBirthdate = `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}`;
                    } else {
                        // Fallback to parsing lunar date from value
                        formattedBirthdate = ngayXemValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
                    }
                } else {
                    // Solar date can be used directly
                    formattedBirthdate = ngayXemValue;
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

                // Process form data
                const formData = {
                    birthdate: formattedBirthdate,
                    calendar_type: calendarType, // Add calendar type
                    leap_month: isLeapMonth, // Add leap month info
                    date_range: khoangNgay.value,
                    start_date: startDate,
                    end_date: endDate,
                    sort: sortValue, // Add sort value
                    _token: '{{ csrf_token() }}'
                };

                // Set hash parameters for URL state
                const hashParams = {
                    birthdate: formattedBirthdate,
                    khoang: khoangNgay.value
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

                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    });

                // Handle sorting change using event delegation
                const resultContainer = document.querySelector('.--detail-success');
                resultContainer.addEventListener('change', function(event) {
                    if (event.target.matches('[name="sort"]')) {
                        form.requestSubmit();
                    }
                });
            });

            // Note: All calendar switching and initialization is now handled by the DatePicker.CalendarSwitcher module
        });
    </script>
@endpush
