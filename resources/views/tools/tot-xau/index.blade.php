@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.0') }}">
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
                                            <!-- Radio buttons để chọn loại lịch -->
                                            <div class="mb-3">
                                                <div class="btn-group w-100" role="group" aria-label="Chọn loại lịch">
                                                    <input type="radio" class="btn-check" name="calendarType" id="solarCalendar" value="solar" checked>
                                                    <label class="btn btn-outline-primary" for="solarCalendar">
                                                        <i class="bi bi-sun"></i> Dương lịch
                                                    </label>

                                                    <input type="radio" class="btn-check" name="calendarType" id="lunarCalendar" value="lunar">
                                                    <label class="btn btn-outline-primary" for="lunarCalendar">
                                                        <i class="bi bi-moon"></i> Âm lịch
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control --border-box-form"
                                                        id="ngayXem" placeholder="Chọn ngày" readonly
                                                        style="border-radius: 10px; border: none; padding: 12px 45px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                    <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 5;">
                                                        <i class="bi-calendar-date-fill text-muted"></i>
                                                    </span>
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

                <div class="col-xl-3  col-sm-12 col-12 mb-3">
                    <div class="d-flex flex-column gap-4">
                        <!-- ** KHá»I Sá»° KIá»†N Sáº®P Tá»šI ** -->


                        <div class="events-card">
                            <div class="card-title-right title-tong-quan-h5-log">Tiện ích xem ngày</div>
                            <ul class="list-group list-group-flush events-list">
                                <li class="list-group-item pb-0">
                                    <a href="https://phonglich.com/lich-nam-2024">

                                        <div class="event-details --padding-event-tot">
                                            <div class="event-name" style="font-weight: unset">
                                                Xem ngày tốt xấu
                                            </div>

                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item  pb-0">
                                    <a href="https://phonglich.com/lich-nam-2024">
                                        <div class="event-details  --padding-event-tot">
                                            <div class="event-name" style="font-weight: unset">
                                                Xem ngày kết hôn
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.0') }}" defer></script>
    <script src="{{ asset('/js/custom-calendar.js?v=1.0') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== INITIALIZE CALENDARS ==========
            // Custom calendar cho Ngày Xem
            // Comment out the default calendar initialization
            // We'll handle it manually based on calendar type selection
            // const ngayXemCalendar = new CustomCalendar({
            //     inputId: 'ngayXem',
            //     calendarId: 'customCalendar',
            //     defaultToToday: true
            // });

            // Global calendar (nếu cần cho inputs khác)
            const globalCal = new GlobalCalendar('globalCalendar');

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

            // Handle calendar type switching
            const solarRadio = document.getElementById('solarCalendar');
            const lunarRadio = document.getElementById('lunarCalendar');
            const solarCalendarElem = document.getElementById('customCalendar');
            const lunarCalendarElem = document.getElementById('lunarCustomCalendar');
            let ngayXemInput = document.getElementById('ngayXem');

            let solarCalendarInstance = null;

            // Function to switch calendar type
            function switchCalendarType() {
                // Get fresh reference to input
                let currentInput = document.getElementById('ngayXem');

                if (solarRadio.checked) {
                    // Clear the input value when switching
                    currentInput.value = '';
                    currentInput.placeholder = 'Chọn ngày Dương lịch';
                    currentInput.dataset.calendarType = 'solar';

                    // Clear any previous click listeners by replacing the input
                    const newInput = currentInput.cloneNode(true);
                    currentInput.parentNode.replaceChild(newInput, currentInput);
                    ngayXemInput = newInput;

                    // Hide lunar calendar if visible
                    lunarCalendarElem.style.display = 'none';

                    // Initialize solar calendar
                    solarCalendarInstance = new CustomCalendar({
                        inputId: 'ngayXem',
                        calendarId: 'customCalendar',
                        defaultToToday: false
                    });
                } else if (lunarRadio.checked) {
                    // Clear the input value when switching
                    currentInput.value = '';
                    currentInput.placeholder = 'Chọn ngày Âm lịch';
                    currentInput.dataset.calendarType = 'lunar';

                    // Hide solar calendar if visible
                    solarCalendarElem.style.display = 'none';

                    // Clear any previous click listeners by replacing the input
                    const newInput = currentInput.cloneNode(true);
                    currentInput.parentNode.replaceChild(newInput, currentInput);
                    ngayXemInput = newInput;
                    solarCalendarInstance = null;

                    // Add lunar calendar click listener
                    ngayXemInput.addEventListener('click', showLunarCalendar);

                    // Initialize lunar calendar if not already done
                    if (!window.lunarCalendarInitialized) {
                        initializeLunarCalendar();
                        window.lunarCalendarInitialized = true;
                    }
                }
            }

            // Create overlay for lunar calendar
            let lunarOverlay = null;

            function createLunarOverlay() {
                if (!lunarOverlay) {
                    lunarOverlay = document.createElement('div');
                    lunarOverlay.className = 'lunar-calendar-overlay';
                    lunarOverlay.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0, 0, 0, 0.5);
                        z-index: 9998;
                        display: none;
                        backdrop-filter: blur(2px);
                        -webkit-backdrop-filter: blur(2px);
                    `;
                    document.body.appendChild(lunarOverlay);

                    // Add click handler to close calendar when clicking overlay
                    lunarOverlay.addEventListener('click', function() {
                        hideLunarCalendar();
                    });
                }
            }

            // Function to show lunar calendar
            function showLunarCalendar(e) {
                e.stopPropagation();
                e.preventDefault();

                // Hide solar calendar if open
                solarCalendarElem.style.display = 'none';

                // Create overlay if not exists
                createLunarOverlay();

                // Show overlay
                lunarOverlay.style.display = 'block';

                // Show lunar calendar centered
                lunarCalendarElem.style.display = 'block';
                lunarCalendarElem.style.position = 'fixed';
                lunarCalendarElem.style.top = '50%';
                lunarCalendarElem.style.left = '50%';
                lunarCalendarElem.style.transform = 'translate(-50%, -50%)';
                lunarCalendarElem.style.zIndex = '9999';
                lunarCalendarElem.style.backgroundColor = 'white';
                lunarCalendarElem.style.borderRadius = '12px';
                lunarCalendarElem.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.3)';
                lunarCalendarElem.style.maxWidth = '400px';
                lunarCalendarElem.style.width = '90%';

                // Initialize lunar calendar if not already done
                if (!window.lunarCalendarInitialized) {
                    initializeLunarCalendar();
                    window.lunarCalendarInitialized = true;
                }
            }

            // Function to hide lunar calendar
            function hideLunarCalendar() {
                lunarCalendarElem.style.display = 'none';
                if (lunarOverlay) {
                    lunarOverlay.style.display = 'none';
                }
            }

            // Add event listeners to radio buttons
            solarRadio.addEventListener('change', switchCalendarType);
            lunarRadio.addEventListener('change', switchCalendarType);

            // Initialize lunar calendar
            function initializeLunarCalendar() {
                const lunarMonthYear = document.getElementById('lunarMonthYear');
                const lunarCalendarDays = document.getElementById('lunarCalendarDays');
                const lunarPrevMonth = document.getElementById('lunarPrevMonth');
                const lunarNextMonth = document.getElementById('lunarNextMonth');
                const lunarClearDate = document.getElementById('lunarClearDate');
                const lunarTodayDate = document.getElementById('lunarTodayDate');
                const leapMonthSelector = document.getElementById('leapMonthSelector');

                let currentLunarMonth = 1;
                let currentLunarYear = 2025;
                let isLeapMonth = false;
                let hasLeapMonth = false;
                let leapMonthNumber = 0;

                // Get today's date and convert to lunar
                const today = new Date();

                // Convert today's solar date to lunar date to set initial month/year
                fetch('/api/convert-solar-to-lunar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        solarDay: today.getDate(),
                        solarMonth: today.getMonth() + 1,
                        solarYear: today.getFullYear()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentLunarMonth = data.lunarMonth;
                        currentLunarYear = data.lunarYear;
                        generateLunarCalendar(currentLunarMonth, currentLunarYear);
                    } else {
                        // Default to current year's first month
                        generateLunarCalendar(1, today.getFullYear());
                    }
                })
                .catch(error => {
                    console.error('Error converting date:', error);
                    // Default to current year's first month
                    generateLunarCalendar(1, today.getFullYear());
                });


                // Function to generate lunar calendar days
                async function generateLunarCalendar(month, year, forceLeap = false) {
                    // Set fixed height to prevent layout shift
                    const currentHeight = lunarCalendarDays.offsetHeight;
                    if (currentHeight > 0) {
                        lunarCalendarDays.style.height = currentHeight + 'px';
                    }

                    // Show loading with same height
                    lunarCalendarDays.innerHTML = '<div class="text-center p-3">Đang tải...</div>';

                    // Use the actual leap month state
                    const actualIsLeap = forceLeap || isLeapMonth;

                    try {
                        // Debug logging
                        console.log('Fetching lunar calendar for:', { month, year, isLeap: actualIsLeap });

                        // Use the new comprehensive API
                        const response = await fetch('/api/get-lunar-month-calendar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                month: month,
                                year: year,
                                isLeap: actualIsLeap ? 1 : 0
                            })
                        });

                        console.log('Response status:', response.status);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            // Update leap month info from API response
                            if (data.hasLeapMonth && data.leapMonthNumber === month) {
                                leapMonthSelector.style.display = 'block';
                                hasLeapMonth = true;
                                leapMonthNumber = data.leapMonthNumber;

                                // Add event listeners for radio buttons
                                const monthTypeRadios = document.querySelectorAll('input[name="monthType"]');
                                monthTypeRadios.forEach(radio => {
                                    radio.onchange = function() {
                                        isLeapMonth = (this.value === 'leap');
                                        generateLunarCalendar(month, year, isLeapMonth);
                                    };
                                });
                            } else {
                                leapMonthSelector.style.display = 'none';
                                hasLeapMonth = false;
                                if (month !== leapMonthNumber) {
                                    isLeapMonth = false;
                                }
                            }

                            // Update header
                            const leapText = actualIsLeap ? ' (nhuận)' : '';
                            lunarMonthYear.textContent = `Tháng ${month}${leapText} Âm lịch ${year}`;

                            // Clear calendar
                            lunarCalendarDays.innerHTML = '';

                            // Add empty cells for days before month starts
                            for (let i = 0; i < data.firstDayOfWeek; i++) {
                                const emptyDiv = document.createElement('div');
                                emptyDiv.className = 'calendar-day empty';
                                lunarCalendarDays.appendChild(emptyDiv);
                            }

                            // Generate day cells with solar date info
                            data.days.forEach(dayInfo => {
                                const dayDiv = document.createElement('div');
                                dayDiv.className = 'calendar-day';

                                // Create inner HTML with lunar day and small solar date
                                dayDiv.innerHTML = `
                                    <div style="font-size: 18px; font-weight: bold;">${dayInfo.lunarDay}</div>
                                    <div style="font-size: 10px; color: #666;">${dayInfo.solarDay}/${dayInfo.solarMonth}</div>
                                `;

                                dayDiv.onclick = function() {
                                    selectLunarDate(dayInfo.lunarDay, month, year, actualIsLeap);
                                };

                                // Highlight weekend days (convert string to number)
                                const dayOfWeekNum = parseInt(dayInfo.dayOfWeek);
                                if (dayOfWeekNum === 0 || dayOfWeekNum === 6) {
                                    dayDiv.style.color = '#dc3545';
                                }

                                lunarCalendarDays.appendChild(dayDiv);
                            });

                            // Reset height to auto after content is loaded
                            lunarCalendarDays.style.height = 'auto';
                        } else {
                            console.error('API returned error:', data.error);
                            // Show error message
                            lunarCalendarDays.innerHTML = `<div class="text-center p-3 text-danger">Lỗi: ${data.error || 'Không thể tải lịch'}</div>`;
                        }
                    } catch (error) {
                        console.error('Error fetching lunar month calendar:', error);
                        // Show error message
                        lunarCalendarDays.innerHTML = '<div class="text-center p-3 text-danger">Lỗi kết nối. Vui lòng thử lại.</div>';
                    } finally {
                        // Always reset height
                        setTimeout(() => {
                            lunarCalendarDays.style.height = 'auto';
                        }, 100);
                    }
                }

                // Function to select a lunar date and convert to solar
                async function selectLunarDate(day, month, year, isLeap = false) {
                    const input = document.getElementById('ngayXem');

                    try {
                        // Convert lunar to solar date
                        const response = await fetch('/api/convert-lunar-to-solar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                lunarDay: day,
                                lunarMonth: month,
                                lunarYear: year,
                                isLeap: isLeap ? 1 : 0
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            // Format the date for display and storage
                            const leapText = isLeap ? ' nhuận' : '';
                            const solarDate = `${String(data.solarDay).padStart(2, '0')}/${String(data.solarMonth).padStart(2, '0')}/${data.solarYear}`;
                            const lunarDisplay = `${day}/${month}${leapText}/${year} ÂL`;

                            // Display lunar date with solar equivalent
                            input.value = `${solarDate} (${lunarDisplay})`;

                            // Store both lunar and solar date information
                            input.dataset.date = solarDate;
                            input.dataset.lunarDay = day;
                            input.dataset.lunarMonth = month;
                            input.dataset.lunarYear = year;
                            input.dataset.lunarLeap = isLeap ? '1' : '0';
                            input.dataset.solarDay = data.solarDay;
                            input.dataset.solarMonth = data.solarMonth;
                            input.dataset.solarYear = data.solarYear;
                        }
                    } catch (error) {
                        console.error('Error converting lunar to solar:', error);
                        // Fallback: just display lunar date
                        const leapText = isLeap ? ' nhuận' : '';
                        input.value = `${day}/${month}${leapText}/${year} (Âm lịch)`;
                        input.dataset.lunarDay = day;
                        input.dataset.lunarMonth = month;
                        input.dataset.lunarYear = year;
                        input.dataset.lunarLeap = isLeap ? '1' : '0';
                    }

                    hideLunarCalendar();
                }

                // Event listeners for lunar calendar
                lunarPrevMonth.addEventListener('click', function() {
                    // Reset leap month state when changing months
                    isLeapMonth = false;
                    const normalRadio = document.querySelector('input[name="monthType"][value="normal"]');
                    if (normalRadio) normalRadio.checked = true;

                    currentLunarMonth--;
                    if (currentLunarMonth < 1) {
                        currentLunarMonth = 12;
                        currentLunarYear--;
                        leapMonthNumber = 0; // Reset leap month check for new year
                    }
                    generateLunarCalendar(currentLunarMonth, currentLunarYear);
                });

                lunarNextMonth.addEventListener('click', function() {
                    // Reset leap month state when changing months
                    isLeapMonth = false;
                    const normalRadio = document.querySelector('input[name="monthType"][value="normal"]');
                    if (normalRadio) normalRadio.checked = true;

                    currentLunarMonth++;
                    if (currentLunarMonth > 12) {
                        currentLunarMonth = 1;
                        currentLunarYear++;
                        leapMonthNumber = 0; // Reset leap month check for new year
                    }
                    generateLunarCalendar(currentLunarMonth, currentLunarYear);
                });

                lunarClearDate.addEventListener('click', function() {
                    const input = document.getElementById('ngayXem');
                    input.value = '';
                    delete input.dataset.lunarDay;
                    delete input.dataset.lunarMonth;
                    delete input.dataset.lunarYear;
                    hideLunarCalendar();
                });

                lunarTodayDate.addEventListener('click', async function() {
                    // Convert today's solar date to lunar
                    const today = new Date();
                    try {
                        const response = await fetch('/api/convert-solar-to-lunar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                solarDay: today.getDate(),
                                solarMonth: today.getMonth() + 1,
                                solarYear: today.getFullYear()
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            selectLunarDate(data.lunarDay, data.lunarMonth, data.lunarYear);
                        }
                    } catch (error) {
                        console.error('Error converting today to lunar:', error);
                    }
                });

                // Generate initial calendar
                generateLunarCalendar(currentLunarMonth, currentLunarYear);
            }

            // Note: Lunar calendar will be closed by clicking on overlay, no need for document click handler

            // Initialize calendar type on page load
            // Solar radio is checked by default, so initialize solar calendar
            if (solarRadio.checked) {
                ngayXemInput.placeholder = 'Chọn ngày Dương lịch';
                ngayXemInput.dataset.calendarType = 'solar';

                solarCalendarInstance = new CustomCalendar({
                    inputId: 'ngayXem',
                    calendarId: 'customCalendar',
                    defaultToToday: true
                });
            }
        });
    </script>
@endpush
