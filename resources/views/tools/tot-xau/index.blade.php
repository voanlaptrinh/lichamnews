@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.0') }}">

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
                                                <!-- Input với icon calendar -->
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control --border-box-form"
                                                        id="ngayXem" placeholder="Chọn ngày" readonly
                                                        style="border-radius: 10px; border: none; padding: 12px 45px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                    <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 5;">
                                                        <i class="bi-calendar-date-fill text-muted"></i>
                                                    </span>
                                                </div>

                                                <!-- Radio buttons dạng tròn bên dưới input -->
                                                <div class="d-flex gap-4 ps-2" style="margin-top: 15px;">
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendarType" id="solarCalendar" value="solar" checked
                                                               style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="solarCalendar"
                                                               style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Dương lịch
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendarType" id="lunarCalendar" value="lunar"
                                                               style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="lunarCalendar"
                                                               style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Âm lịch
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Custom Calendar Popup -->
                                                <div class="custom-calendar" id="customCalendar" style="display: none;">
                                                    <div class="calendar-header-date">
                                                        <button type="button" class="btn-nav" id="prevMonth"><i
                                                                class="bi bi-chevron-left"></i></button>
                                                        <span class="month-year" id="monthYear">October 2025</span>
                                                        <button type="button" class="btn-nav" id="nextMonth"><i
                                                                class="bi bi-chevron-right"></i></button>
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
                                                    <div class="calendar-days" id="calendarDays">
                                                        <!-- Days will be generated by JavaScript -->
                                                    </div>
                                                    <div class="calendar-footer">
                                                        <button type="button" class="btn-calendar btn-clear"
                                                            id="clearDate">Xóa</button>
                                                        <button type="button" class="btn-calendar btn-today"
                                                            id="todayDate">Hôm
                                                            nay</button>
                                                    </div>
                                                    <!-- Month/Year Picker -->
                                                    <div class="calendar-picker" id="monthYearPicker"
                                                        style="display: none;">
                                                        <div class="picker-header">
                                                            <button type="button" class="btn-nav" id="pickerPrevYear"><i
                                                                    class="bi bi-chevron-left"></i></button>
                                                            <span class="picker-year" id="pickerYear"></span>
                                                            <button type="button" class="btn-nav" id="pickerNextYear"><i
                                                                    class="bi bi-chevron-right"></i></button>
                                                        </div>
                                                        <div class="month-grid" id="monthGrid"></div>
                                                    </div>
                                                </div>

                                                <!-- Lunar Calendar Popup -->
                                                <div class="custom-calendar" id="lunarCustomCalendar" style="display: none;">
                                                    <div class="calendar-header-date">
                                                        <button type="button" class="btn-nav" id="lunarPrevMonth"><i
                                                                class="bi bi-chevron-left"></i></button>
                                                        <span class="month-year" id="lunarMonthYear">Tháng 1 Âm lịch 2025</span>
                                                        <button type="button" class="btn-nav" id="lunarNextMonth"><i
                                                                class="bi bi-chevron-right"></i></button>
                                                    </div>
                                                    <!-- Leap month selector -->
                                                    <div id="leapMonthSelector" style="display: none; padding: 10px; text-align: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="radio" name="monthType" value="normal" checked>
                                                            <span>Tháng thường</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="monthType" value="leap">
                                                            <span>Tháng nhuận</span>
                                                        </label>
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
                                                    <div class="calendar-days" id="lunarCalendarDays" style="min-height: 240px;">
                                                        <!-- Lunar days will be generated by JavaScript -->
                                                    </div>
                                                    <div class="calendar-footer">
                                                        <button type="button" class="btn-calendar btn-clear"
                                                            id="lunarClearDate">Xóa</button>
                                                        <button type="button" class="btn-calendar btn-today"
                                                            id="lunarTodayDate">Hôm nay</button>
                                                    </div>
                                                    <!-- Lunar Month/Year Picker -->
                                                    <div class="calendar-picker" id="lunarMonthYearPicker"
                                                        style="display: none;">
                                                        <div class="picker-header">
                                                            <button type="button" class="btn-nav" id="lunarPickerPrevYear"><i
                                                                    class="bi bi-chevron-left"></i></button>
                                                            <span class="picker-year" id="lunarPickerYear"></span>
                                                            <button type="button" class="btn-nav" id="lunarPickerNextYear"><i
                                                                    class="bi bi-chevron-right"></i></button>
                                                        </div>
                                                        <div class="month-grid" id="lunarMonthGrid"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="fw-bold title-tong-quan-h2-log">Khoảng thời gian cần xem
                                            </div>
                                            <div class="mb-4">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control wedding_date_range --border-box-form"
                                                        id="khoangNgay" placeholder="Chọn khoảng ngày" autocomplete="off"
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
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.0') }}" defer></script>

    {{-- Legacy custom calendar (for compatibility) --}}
    <script src="{{ asset('/js/custom-calendar.js?v=1.0') }}"></script>

    {{-- New Date Picker Module --}}
    <script src="{{ asset('/js/date-picker-module.js?v=1.6') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== INITIALIZE USING NEW MODULE ==========

            // Global calendar (for compatibility with existing code)
            const globalCal = new GlobalCalendar('globalCalendar');

            // Calendar type switcher - using new module
            let calendarSwitcher = null;

            // ========== INITIALIZE CALENDAR SWITCHER ==========
            // This will handle switching between Solar and Lunar calendars
            calendarSwitcher = new DatePicker.CalendarSwitcher({
                solarRadioId: 'solarCalendar',
                lunarRadioId: 'lunarCalendar',
                inputId: 'ngayXem',
                onChange: function(data, displayValue) {
                    console.log('Date selected:', displayValue);
                }
            });

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
                    alert('Vui lòng chọn ngày xem');
                    return;
                }

                // Validate Date Range
                if (!DateUtils.validateDateRange(khoangNgay.value)) {
                    return;
                }

                // Get the solar date (either directly or from converted lunar date)
                let formattedBirthdate = '';

                if (ngayXemInput.dataset.solarDay) {
                    // If lunar date was selected and converted to solar
                    const day = String(ngayXemInput.dataset.solarDay).padStart(2, '0');
                    const month = String(ngayXemInput.dataset.solarMonth).padStart(2, '0');
                    const year = ngayXemInput.dataset.solarYear;
                    formattedBirthdate = `${day}/${month}/${year}`;
                } else if (ngayXemInput.dataset.date) {
                    // If solar date was stored in dataset
                    formattedBirthdate = ngayXemInput.dataset.date;
                } else {
                    // Fallback: parse from value
                    const ngayXemDate = DateUtils.parseVietnameseDate(ngayXemValue);
                    if (ngayXemDate) {
                        const day = String(ngayXemDate.getDate()).padStart(2, '0');
                        const month = String(ngayXemDate.getMonth() + 1).padStart(2, '0');
                        const year = ngayXemDate.getFullYear();
                        formattedBirthdate = `${day}/${month}/${year}`;
                    }
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
                    date_range: khoangNgay.value,
                    start_date: startDate,
                    end_date: endDate,
                    sort: sortValue, // Add sort value
                    _token: '{{ csrf_token() }}'
                };

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
