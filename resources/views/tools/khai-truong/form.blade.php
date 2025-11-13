@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.7') }}">
    @endpush

    <div class="container-setup">
        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="">Tiện ích</a> <i
                class="bi bi-chevron-right"></i> <span>
                Xem ngày khai trương</span></div>

        <h1 class="content-title-home-lich">Xem ngày khai trương</h1>

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

                                        <form id="khaiTruongForm">
                                            @csrf

                                            <div class="row">
                                                <!-- Name field -->
                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h2-log">Tên người xem</div>
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
                                                    <div class="fw-bold title-tong-quan-h2-log">Ngày sinh của gia chủ</div>
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
                                                        thời gian khai trương</div>
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
                </div>
                @include('tools.siderbarindex')
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=1.3') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.7') }}" defer></script>


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
                        if (dateRangePickerInstance) {
                            try {
                                dateRangePickerInstance.destroy();
                            } catch (e) {}
                        }

                        dateRangePickerInstance = new window.VanillaDateRangePicker(dateRangeInput, {
                            autoApply: true,
                            showDropdowns: true,
                            linkedCalendars: false,
                            singleDatePicker: false,
                            locale: {
                                format: 'DD/MM/YY',
                                separator: ' - ',
                                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                                    'Tháng 6',
                                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                                ],
                                firstDay: 1
                            }
                        });
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
                    document.getElementById('autoSubmitNotification').style.display = 'none';
                }
            }

            // Make function global
            window.manualSubmit = manualSubmit;

            // Function to restore form from hash parameters
            function restoreFromHash() {
                const params = parseHashParams();

                // Restore calendar type from hash
                if (params.calendar_type) {
                    const solarRadio = document.getElementById('solarCalendar');
                    const lunarRadio = document.getElementById('lunarCalendar');

                    if (params.calendar_type === 'lunar' && lunarRadio) {
                        lunarRadio.checked = true;
                        solarRadio.checked = false;
                        lunarRadio.dispatchEvent(new Event('change'));
                    } else if (params.calendar_type === 'solar' && solarRadio) {
                        solarRadio.checked = true;
                        lunarRadio.checked = false;
                        solarRadio.dispatchEvent(new Event('change'));
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
                        userNameInput.value = params.user_name;
                        userNameSet = true;
                    } else {
                        userNameSet = true;
                    }

                    if (params.birthdate) {
                        let formattedBirthdate = params.birthdate;
                        let day, month, year;

                        // Check if birthdate is in Y-m-d format (from URL params)
                        if (params.birthdate.includes('-') && params.birthdate.split('-').length === 3) {
                            const ymdParts = params.birthdate.split('-');
                            year = parseInt(ymdParts[0]);
                            month = parseInt(ymdParts[1]);
                            day = parseInt(ymdParts[2]);
                            formattedBirthdate = `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}`;
                        } else {
                            // Parse d/m/Y format
                            const dateParts = params.birthdate.split('/');
                            if (dateParts.length === 3) {
                                day = parseInt(dateParts[0]);
                                month = parseInt(dateParts[1]);
                                year = parseInt(dateParts[2]);
                            }
                        }

                        // Set birthdate in the hidden input
                        const ngayXemInput = document.getElementById('ngayXem');
                        ngayXemInput.value = formattedBirthdate;

                        if (day && month && year) {

                            // Set the selects with multiple retries to ensure they're populated
                            function trySetSelects(attempts = 0) {
                                const maxAttempts = 15;
                                const daySelect = document.getElementById('ngaySelect');
                                const monthSelect = document.getElementById('thangSelect');
                                const yearSelect = document.getElementById('namSelect');

                                console.log(`trySetSelects attempt ${attempts + 1}/${maxAttempts}`, {
                                    dayOptions: daySelect?.options?.length,
                                    monthOptions: monthSelect?.options?.length,
                                    yearOptions: yearSelect?.options?.length
                                });

                                if (attempts >= maxAttempts) {
                                    birthdateSet = true; // Set to true to prevent blocking form submission
                                    checkAndSubmitForm();
                                    return;
                                }

                                if (daySelect && monthSelect && yearSelect &&
                                    daySelect.options.length > 1 &&
                                    monthSelect.options.length > 1 &&
                                    yearSelect.options.length > 1) {

                                    console.log('Setting select values sequentially:', { year, month, day });

                                    // Set year first, trigger change, wait
                                    yearSelect.value = year;
                                    yearSelect.dispatchEvent(new Event('change'));

                                    setTimeout(() => {
                                        // Set month second, trigger change, wait
                                        monthSelect.value = month;
                                        monthSelect.dispatchEvent(new Event('change'));

                                        setTimeout(() => {
                                            // Set day last, trigger change
                                            daySelect.value = day;
                                            daySelect.dispatchEvent(new Event('change'));

                                            birthdateSet = true;
                                            checkAndSubmitForm();
                                        }, 100);
                                    }, 100);
                                } else {
                                    setTimeout(() => trySetSelects(attempts + 1), 300);
                                }
                            }

                            trySetSelects();
                        } else {
                            birthdateSet = true;
                        }
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
                                    if (notification) {
                                        notification.style.display = 'none';
                                    }
                                } catch (e) {
                                    form.dispatchEvent(new Event('submit', { cancelable: true }));
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
                const userNameValue = userNameInput.value;

                if (!userNameValue.trim()) {
                    alert('Vui lòng nhập tên');
                    return;
                }

                // Get birthdate value
                const ngayXemInput = document.getElementById('ngayXem');
                const ngayXemValue = ngayXemInput.value;

                if (!ngayXemValue) {
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm sinh');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput.value;

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian khai trương');
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
                        formattedBirthdate =
                            `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}`;
                    } else {
                        // Fallback to parsing lunar date from value
                        formattedBirthdate = ngayXemValue.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');
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

            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    const sortValue = event.target.value;

                    // Apply sorting directly without form submission
                    applySortingToTable(sortValue);

                    // Scroll to table after sort
                    setTimeout(() => {
                        const target = document.getElementById("bang-chi-tiet");
                        if (target) {
                            console.log('Scrolling to #bang-chi-tiet for filtering');
                            target.scrollIntoView({
                                behavior: "smooth",
                                block: "start"
                            });
                        }
                    }, 100);
                }
            });

            // Function to apply sorting without form submission
            function applySortingToTable(sortValue) {
                const table = document.querySelector('#bang-chi-tiet table tbody');
                if (!table) return;

                const rows = Array.from(table.querySelectorAll('tr'));

                rows.sort((a, b) => {
                    // Get score from battery or score element
                    const scoreA = getScoreFromRow(a);
                    const scoreB = getScoreFromRow(b);

                    if (sortValue === 'asc') {
                        return scoreA - scoreB;
                    } else {
                        return scoreB - scoreA;
                    }
                });

                // Clear and re-append sorted rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));
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
                for (let cell of cells) {
                    const text = cell.textContent.trim();
                    const match = text.match(/(\d+)/);
                    if (match) {
                        return parseInt(match[1]) || 0;
                    }
                }

                return 0;
            }

        });
    </script>
@endpush
