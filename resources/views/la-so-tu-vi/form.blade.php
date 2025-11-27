@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.7') }}">
        <style>
             .main-content-wrapper {
            background-image: url(../images/Quy_Trinh_Bg.png);
            background-repeat: no-repeat;
            background-size: cover;
            align-items: normal;
            background-position: center center;
            overflow: hidden;
        }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('/js/lunar-solar-date-select.js?v=2.0') }}" defer></script>
    @endpush

    <div class="bg-la-so">
        <div class="container-setup">
            <nav aria-label="breadcrumb" class="content-title-detail">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                    </li>

                    <li class="breadcrumb-item">
                        Tử vi & Phong thuỷ
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        Lá số tử vi
                    </li>
                </ol>
            </nav>


             @if (isset($imageUrl) && $imageUrl)
                <div class="mt-2">                       
                        <div class=" text-center">
                            <div class="d-flex justify-content-center">
                                <div class="img-zoom-container" id="img-zoom-container">
                                    <img src="{{ route('laso.image_proxy', ['url' => $imageUrl]) }}" alt="Lá số tử vi"
                                        class="img-fluid laso-image" id="laso-image">
                                    <div class="img-zoom-lens" id="img-zoom-lens"></div>
                                    <div class="img-zoom-result" id="img-zoom-result"></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('laso.download', ['url' => $imageUrl, 'ho_ten' => $normalizedData['ho_ten'] ?? '']) }}"
                                   class="btn btn-success" download>
                                    <i class="fas fa-download"></i> Tải xuống lá số
                                </a>
                                <button type="button" class="btn btn-primary" onclick="scrollToTop()">
                                    <i class="fas fa-edit"></i> Chỉnh sửa lá số
                                </button>
                            </div>
                        </div>
                    
                </div>
            @endif
            <div class="bg-light d-flex align-items-center justify-content-center ">
                <div class="w-100 " style="max-width: 950px;">
                    <div class=" mt-5 mb-5">

                        <div class="card-body p-1">
                            <h1 class="text-center mb-4 title-tong-quan-h1-log fw-bold" style="color: #192E52">Lập Lá Số Tử
                                Vi và Luận Giải Vận
                                Mệnh Miễn Phí</h1>
                            <p class="text-center" style="margin-bottom: 40px">Tra cứu lá số tử vi trọn đời có thể giúp bạn
                                hiểu
                                về
                                bản thân bao gồm những điểm
                                mạnh, điểm yếu. Đồng thời nắm bắt được thời điểm tốt để bắt đầu các sự kiện quan trọng,
                                chẳng
                                hạn
                                như kết hôn, mua nhà, khởi nghiệp,…
                            </p>



                            <form id="lasoForm" action="{{ route('laso.submit') }}" method="POST">
                                @csrf
                                <div class="row gx-4 gx-md-4 gx-sm-1">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ho_ten" class="form-label fw-semibold">Họ và Tên</label>
                                            <input type="text" id="ho_ten" name="ho_ten"
                                                value="{{ old('ho_ten', $lastInput['ho_ten'] ?? '') }}"
                                                class="form-control --border-box-form style-input" required
                                                placeholder="Nhập tên của bạn">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Giờ Sinh</label>
                                            <div class="col-12"> <!-- Sử dụng col-12 để chiếm toàn bộ chiều rộng -->
                                                @php
                                                    // Định nghĩa các khoảng thời gian giờ âm lịch và giờ/phút bắt đầu tương ứng
                                                    // Lưu ý: value của option là "giờ_phút" để JS dễ phân tích
                                                    $zodiacTimeRanges = [
                                                        [
                                                            'name' => 'Tý sớm',
                                                            'start_h' => 0,
                                                            'start_m' => 0,
                                                            'end_h' => 0,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Sửu',
                                                            'start_h' => 1,
                                                            'start_m' => 0,
                                                            'end_h' => 2,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Dần',
                                                            'start_h' => 3,
                                                            'start_m' => 0,
                                                            'end_h' => 4,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Mão',
                                                            'start_h' => 5,
                                                            'start_m' => 0,
                                                            'end_h' => 6,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Thìn',
                                                            'start_h' => 7,
                                                            'start_m' => 0,
                                                            'end_h' => 8,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Tỵ',
                                                            'start_h' => 9,
                                                            'start_m' => 0,
                                                            'end_h' => 10,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Ngọ',
                                                            'start_h' => 11,
                                                            'start_m' => 0,
                                                            'end_h' => 12,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Mùi',
                                                            'start_h' => 13,
                                                            'start_m' => 0,
                                                            'end_h' => 14,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Thân',
                                                            'start_h' => 15,
                                                            'start_m' => 0,
                                                            'end_h' => 16,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Dậu',
                                                            'start_h' => 17,
                                                            'start_m' => 0,
                                                            'end_h' => 18,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Tuất',
                                                            'start_h' => 19,
                                                            'start_m' => 0,
                                                            'end_h' => 20,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Hợi',
                                                            'start_h' => 21,
                                                            'start_m' => 0,
                                                            'end_h' => 22,
                                                            'end_m' => 59,
                                                        ],
                                                        [
                                                            'name' => 'Tý khuya',
                                                            'start_h' => 23,
                                                            'start_m' => 0,
                                                            'end_h' => 23,
                                                            'end_m' => 59,
                                                        ],
                                                    ];

                                                    // Xử lý old value từ form submission hoặc từ session
                                                    $oldGio = old('dl_gio', $lastInput['dl_gio'] ?? null);
                                                    $oldPhut = old('dl_phut', $lastInput['dl_phut'] ?? null);

                                                    $selectedOptionValue = ''; // Biến để lưu giá trị 'start_h_start_m' của option được chọn

                                                    if ($oldGio !== null && $oldPhut !== null) {
                                                        $oldGioInt = (int) $oldGio;
                                                        $oldPhutInt = (int) $oldPhut;
                                                        $inputTimeInMinutes = $oldGioInt * 60 + $oldPhutInt;

                                                        // Tìm khoảng giờ âm lịch mà old('dl_gio') và old('dl_phut') thuộc về
                                                        foreach ($zodiacTimeRanges as $range) {
                                                            $rangeStartInMinutes =
                                                                $range['start_h'] * 60 + $range['start_m'];
                                                            $rangeEndInMinutes = $range['end_h'] * 60 + $range['end_m'];

                                                            // Logic đặc biệt cho Tý khuya (23h) và Tý sớm (00h)
                                                            // Nếu thời gian input nằm trong khoảng này
                                                            if (
                                                                $inputTimeInMinutes >= $rangeStartInMinutes &&
                                                                $inputTimeInMinutes <= $rangeEndInMinutes
                                                            ) {
                                                                $selectedOptionValue =
                                                                    $range['start_h'] . '_' . $range['start_m'];
                                                                break;
                                                            }
                                                        }
                                                    } else {
                                                        // Nếu không có old value, có thể set một giá trị mặc định cho hidden inputs nếu cần.
                                                        // Hoặc để trống nếu muốn người dùng phải chọn.
                                                        // Ví dụ: $oldGio = 12; $oldPhut = 0; $selectedOptionValue = '12_0'; // Để mặc định là giờ Ngọ
                                                    }
                                                @endphp

                                                <select name="dl_zodiac_combined" id="dl_zodiac_combined"
                                                    class="form-control --border-box-form style-input" required>
                                                    <option value="" disabled
                                                        {{ $selectedOptionValue == '' ? 'selected' : '' }}>Chọn giờ
                                                        sinh
                                                    </option>
                                                    @foreach ($zodiacTimeRanges as $range)
                                                        @php
                                                            $displayTime =
                                                                str_pad($range['start_h'], 2, '0', STR_PAD_LEFT) .
                                                                'h - ' .
                                                                str_pad($range['end_h'], 2, '0', STR_PAD_LEFT) .
                                                                'h' .
                                                                str_pad($range['end_m'], 2, '0', STR_PAD_LEFT);
                                                            $optionValue = $range['start_h'] . '_' . $range['start_m']; // Giá trị gửi cho JS

                                                            // Đánh dấu 'selected' cho option nếu khớp với old value
                                                            $isSelected =
                                                                $optionValue == $selectedOptionValue ? 'selected' : '';
                                                        @endphp
                                                        <option value="{{ $optionValue }}" {{ $isSelected }}>
                                                            {{ $range['name'] }} ({{ $displayTime }})
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- Các trường input ẩn để gửi giờ và phút cụ thể đến backend -->
                                                <input type="hidden" name="dl_gio" id="dl_gio_hidden"
                                                    value="{{ $oldGio ?? ($lastInput['dl_gio'] ?? '') }}">
                                                <input type="hidden" name="dl_phut" id="dl_phut_hidden"
                                                    value="{{ $oldPhut ?? ($lastInput['dl_phut'] ?? '') }}">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-xl-3 mb-md-2 mb-sm-1">
                                            <label class="form-label fw-semibold">Giới Tính</label>
                                            <div class="d-flex gap-3 align-items-center" style="height: 50px">


                                                <div class="form-check">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="checkbox-wrapper-31">
                                                            <input type="radio" name="gioi_tinh" value="Nam"
                                                                style="width: 24px; height: 24px; cursor: pointer;"
                                                                id="gt_nam" class="form-check-input"
                                                                {{ old('gioi_tinh', $lastInput['gioi_tinh'] ?? 'Nam') == 'Nam' ? 'checked' : '' }} />

                                                        </div>
                                                        <label for="gt_nam" class="form-check-label">Nam</label>
                                                    </div>

                                                    {{-- <input type="radio" name="gioi_tinh" value="Nam" id="gt_nam"
                                                class="form-check-input"
                                                {{ old('gioi_tinh', 'Nam') == 'Nam' ? 'checked' : '' }}>
                                            <label for="gt_nam" class="form-check-label">Nam</label> --}}
                                                </div>
                                                <div class="form-check">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="checkbox-wrapper-31">
                                                            <input type="radio" name="gioi_tinh" value="Nữ"
                                                                style="width: 24px; height: 24px; cursor: pointer;"
                                                                id="gt_nu" class="form-check-input"
                                                                {{ old('gioi_tinh', $lastInput['gioi_tinh'] ?? 'Nam') == 'Nữ' ? 'checked' : '' }} />

                                                        </div>
                                                        <label for="gt_nu" class="form-check-label">Nữ</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Năm Xem Hạn</label>
                                            <input type="number" id="nam_xem" name="nam_xem"
                                                value="{{ old('nam_xem', $lastInput['nam_xem'] ?? date('Y')) }}"
                                                class="form-control --border-box-form style-input" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Ngày Sinh</label>


                                        <!-- Date selects (chỉ để hiển thị, dữ liệu thực sẽ lưu trong input ẩn) -->
                                        <div class="row g-2 mb-2">
                                            <div class="col-4">
                                                <div class="position-relative">
                                                    <select class="form-select pe-5 style-input --border-box-form"
                                                        id="dl_ngaySelect">
                                                        <option value="">Ngày</option>
                                                    </select>
                                                    <i class="bi bi-chevron-down position-absolute"
                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="position-relative">
                                                    <select class="form-select pe-5 style-input --border-box-form"
                                                        id="dl_thangSelect">
                                                        <option value="">Tháng</option>
                                                    </select>
                                                    <i class="bi bi-chevron-down position-absolute"
                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="position-relative">
                                                    <select class="form-select pe-5 style-input --border-box-form"
                                                        id="dl_namSelect">
                                                        <option value="">Năm</option>
                                                    </select>
                                                    <i class="bi bi-chevron-down position-absolute"
                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Leap month container -->
                                        <div id="leapMonthContainer" class="mt-2" style="display: none;">
                                            <div class="form-check">
                                                <input class="form-check-input --border-box-form" type="checkbox"
                                                    id="leapMonth" name="leap_month">
                                                <label class="form-check-label" for="leapMonth">
                                                    Tháng nhuận
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Hidden input for processed date (always solar) -->
                                        <input type="hidden" id="ngayXem" name="dl_date_processed"
                                            value="{{ old('dl_date_processed', $lastInput['dl_date_processed'] ?? '') }}">
                                        <!-- Radio buttons cho loại lịch -->
                                        <div class="d-flex gap-3 mb-3" style="min-height: 40px; align-items: center;">
                                            <div class="form-check d-flex align-items-center" style="gap: 10px">
                                                <input class="form-check-input" type="radio" name="calendar_type"
                                                    id="solarCalendar" value="solar"
                                                    {{ old('calendar_type', $lastInput['calendar_type'] ?? 'solar') == 'solar' ? 'checked' : '' }}
                                                    style="width: 24px; height: 24px; cursor: pointer;">
                                                <label class="form-check-label" for="solarCalendar">
                                                    Dương lịch
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center justify-content-center"
                                                style="gap: 10px">
                                                <input class="form-check-input" type="radio" name="calendar_type"
                                                    id="lunarCalendar" value="lunar"
                                                    {{ old('calendar_type', $lastInput['calendar_type'] ?? 'solar') == 'lunar' ? 'checked' : '' }}
                                                    style="width: 24px; height: 24px; cursor: pointer;">
                                                <label class="form-check-label" for="lunarCalendar">
                                                    Âm lịch
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-light-settup fw-bold" id="submitBtn" style="width: 350px;">
                                        <span class="btn-text">Xem Kết Quả</span>
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Khu vực hiển thị kết quả bên dưới form -->
           
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const zodiacCombinedSelect = document.getElementById('dl_zodiac_combined');
            const dlGioHidden = document.getElementById('dl_gio_hidden');
            const dlPhutHidden = document.getElementById('dl_phut_hidden');

            // Hàm cập nhật giá trị cho các trường hidden
            function updateHiddenFields() {
                const selectedValue = zodiacCombinedSelect.value; // Ví dụ: "1_0"
                if (selectedValue) {
                    const parts = selectedValue.split('_');
                    dlGioHidden.value = parts[0]; // Giờ
                    dlPhutHidden.value = parts[1]; // Phút
                } else {
                    dlGioHidden.value = '';
                    dlPhutHidden.value = '';
                }
            }

            // Initialize the lunar-solar date selector
            const dateSelector = new LunarSolarDateSelect({
                daySelectId: 'dl_ngaySelect',
                monthSelectId: 'dl_thangSelect',
                yearSelectId: 'dl_namSelect',
                hiddenInputId: 'ngayXem',
                solarRadioId: 'solarCalendar',
                lunarRadioId: 'lunarCalendar',
                leapCheckboxId: 'leapMonth',
                leapContainerId: 'leapMonthContainer',
                @php
                    $savedCalendarType = old('calendar_type', $lastInput['calendar_type'] ?? 'solar');
                    $lunarDate = $lastInput['lunar_date'] ?? null;

                    // Nếu là âm lịch và có lưu ngày âm lịch, sử dụng ngày âm lịch gốc
                    if ($savedCalendarType === 'lunar' && $lunarDate) {
                        echo 'defaultDay: ' . $lunarDate['day'] . ",\n";
                        echo '                defaultMonth: ' . $lunarDate['month'] . ",\n";
                        echo '                defaultYear: ' . $lunarDate['year'] . ",\n";
                        echo '                defaultLeapMonth: ' . ($lunarDate['is_leap'] ? 'true' : 'false') . ",\n";
                    } else {
                        // Sử dụng ngày dương lịch hoặc mặc định
                        $oldDate = old('dl_date_processed', $lastInput['dl_date_processed'] ?? '');
                        if ($oldDate && $savedCalendarType === 'solar') {
                            $dateParts = explode('/', explode(' ', $oldDate)[0]);
                            if (count($dateParts) === 3) {
                                echo 'defaultDay: ' . (int) $dateParts[0] . ",\n";
                                echo '                defaultMonth: ' . (int) $dateParts[1] . ",\n";
                                echo '                defaultYear: ' . (int) $dateParts[2] . ",\n";
                            } else {
                                echo "defaultDay: 1,\n";
                                echo "                defaultMonth: 1,\n";
                                echo "                defaultYear: 2002,\n";
                            }
                        } else {
                            echo "defaultDay: 1,\n";
                            echo "                defaultMonth: 1,\n";
                            echo "                defaultYear: 2002,\n";
                        }
                    }
                @endphp
                yearRangeStart: 1900,
                yearRangeEnd: {{ date('Y') }},
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                csrfToken: '{{ csrf_token() }}',
                onChange: function(data) {
                    // Component tự động cập nhật input ẩn với giá trị dương lịch đã chuyển đổi
                    console.log('Date changed:', data);
                }
            });

            // Đảm bảo loại lịch được set đúng theo session
            const savedCalendarType = '{{ $savedCalendarType }}';
            @if ($savedCalendarType === 'lunar' && isset($lastInput['lunar_date']))
                const savedLunarDate = @json($lastInput['lunar_date']);
            @else
                const savedLunarDate = null;
            @endif

            // Set radio buttons theo loại lịch đã chọn
            if (savedCalendarType === 'lunar') {
                document.getElementById('lunarCalendar').checked = true;
                document.getElementById('solarCalendar').checked = false;

                // Trigger change event để component nhận biết
                setTimeout(() => {
                    const lunarRadio = document.getElementById('lunarCalendar');
                    if (lunarRadio) {
                        lunarRadio.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                }, 50);
            } else {
                document.getElementById('solarCalendar').checked = true;
                document.getElementById('lunarCalendar').checked = false;

                // Trigger change event để component nhận biết
                setTimeout(() => {
                    const solarRadio = document.getElementById('solarCalendar');
                    if (solarRadio) {
                        solarRadio.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                }, 50);
            }

            // Nếu có dữ liệu âm lịch và đang chọn âm lịch, cập nhật component
            if (savedCalendarType === 'lunar' && savedLunarDate) {
                setTimeout(() => {
                    // Force component chuyển sang lunar mode
                    if (dateSelector) {
                        // Set component về lunar mode trước
                        dateSelector.isLunar = true;
                        dateSelector.isLeapMonth = savedLunarDate.is_leap;

                        // Trigger calendar type change để component update UI
                        if (dateSelector.handleCalendarTypeChange) {
                            dateSelector.handleCalendarTypeChange();
                        }

                        // Set ngày âm lịch
                        if (dateSelector.setDate) {
                            dateSelector.setDate(
                                savedLunarDate.day,
                                savedLunarDate.month,
                                savedLunarDate.year,
                                savedLunarDate.is_leap,
                                true // isLunar = true
                            );
                        }

                        // Force update hiển thị
                        if (dateSelector.updateDisplay) {
                            dateSelector.updateDisplay();
                        } else if (dateSelector.updateHiddenInput) {
                            dateSelector.updateHiddenInput();
                        }

                        // Update UI elements manually
                        if (dateSelector.daySelect) dateSelector.daySelect.value = savedLunarDate.day;
                        if (dateSelector.monthSelect) dateSelector.monthSelect.value = savedLunarDate.month;
                        if (dateSelector.yearSelect) dateSelector.yearSelect.value = savedLunarDate.year;

                        // Show/hide leap month container
                        const leapContainer = document.getElementById('leapMonthContainer');
                        const leapCheckbox = document.getElementById('leapMonth');
                        if (leapContainer && leapCheckbox) {
                            leapContainer.style.display = 'block';
                            leapCheckbox.checked = savedLunarDate.is_leap;
                        }

                        // Force populate selects if component has methods
                        if (dateSelector.populateLunarMonthSelect) {
                            dateSelector.populateLunarMonthSelect(savedLunarDate.year);
                        }
                        if (dateSelector.populateDaySelect) {
                            dateSelector.populateDaySelect();
                        }
                    }
                }, 300);
            }

            // Cập nhật giá trị hidden cho giờ sinh
            updateHiddenFields();
            zodiacCombinedSelect.addEventListener('change', updateHiddenFields);

            // Hàm scroll xuống form để chỉnh sửa
            window.scrollToTop = function() {
                const form = document.getElementById('lasoForm');
                if (form) {
                    form.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    // Fallback: scroll về đầu trang
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }

            // Initialize image zoom nếu có ảnh hiển thị
            @if (isset($imageUrl) && $imageUrl)
                initImageZoom();
            @endif

            function initImageZoom() {
                const imgZoomContainer = document.getElementById('img-zoom-container');
                const img = document.getElementById('laso-image');
                const lens = document.getElementById('img-zoom-lens');
                const result = document.getElementById('img-zoom-result');

                if (!imgZoomContainer || !img || !lens || !result) return;

                let zoomRatio = 2.5;

                // Đợi ảnh load xong
                img.onload = function() {
                    setupZoom();
                };

                if (img.complete) {
                    setupZoom();
                }

                function setupZoom() {
                    // Tạo một image mới để đảm bảo crossorigin
                    const bgImg = new Image();
                    bgImg.crossOrigin = "anonymous";

                    bgImg.onload = function() {
                        // Set background image cho zoom result
                        result.style.backgroundImage = `url("${bgImg.src}")`;

                        // Tính toán kích thước background
                        const imgDisplayWidth = img.clientWidth;
                        const imgDisplayHeight = img.clientHeight;

                        result.style.backgroundSize = `${imgDisplayWidth * zoomRatio}px ${imgDisplayHeight * zoomRatio}px`;
                        result.style.backgroundRepeat = 'no-repeat';

                        // Debug: xác nhận ảnh đã load
                        console.log('Zoom background image loaded successfully');
                    };

                    bgImg.onerror = function() {
                        // Fallback: dùng trực tiếp src của img gốc
                        result.style.backgroundImage = `url("${img.src}")`;
                        result.style.backgroundSize = `${img.clientWidth * zoomRatio}px ${img.clientHeight * zoomRatio}px`;
                        result.style.backgroundRepeat = 'no-repeat';

                        // Debug: báo lỗi và dùng fallback
                        console.log('Using fallback image source for zoom');
                    };

                    bgImg.src = img.src;

                    // Mouse events
                    imgZoomContainer.addEventListener('mouseenter', function() {
                        lens.style.display = 'block';
                        result.style.display = 'block';
                    });

                    imgZoomContainer.addEventListener('mouseleave', function() {
                        lens.style.display = 'none';
                        result.style.display = 'none';
                    });

                    imgZoomContainer.addEventListener('mousemove', function(e) {
                        updateZoom(e);
                    });

                    function updateZoom(e) {
                        const imgRect = img.getBoundingClientRect();
                        const x = e.clientX - imgRect.left;
                        const y = e.clientY - imgRect.top;

                        if (x < 0 || y < 0 || x > imgRect.width || y > imgRect.height) {
                            lens.style.display = 'none';
                            result.style.display = 'none';
                            return;
                        }

                        lens.style.display = 'block';
                        result.style.display = 'block';

                        const lensWidth = 150;
                        const lensHeight = 150;

                        let lensX = x - (lensWidth / 2);
                        let lensY = y - (lensHeight / 2);

                        lensX = Math.max(0, Math.min(lensX, imgRect.width - lensWidth));
                        lensY = Math.max(0, Math.min(lensY, imgRect.height - lensHeight));

                        lens.style.left = lensX + 'px';
                        lens.style.top = lensY + 'px';

                        // Position result
                        const resultWidth = 300;
                        const resultHeight = 300;
                        let resultX = imgRect.width + 20;
                        let resultY = y - (resultHeight / 2);

                        // Kiểm tra và điều chỉnh vị trí để không bị đẩy ra ngoài viewport
                        const imgContainerRect = imgZoomContainer.getBoundingClientRect();

                        // Giới hạn resultY trong viewport
                        const minY = -imgContainerRect.top + 20; // Cách top viewport 20px
                        const maxY = window.innerHeight - resultHeight - 20 - imgContainerRect.top; // Cách bottom viewport 20px

                        resultY = Math.max(minY, Math.min(maxY, resultY));

                        // Kiểm tra vị trí X
                        if (resultX + resultWidth > window.innerWidth - 20) {
                            resultX = -resultWidth - 20;
                        }

                        result.style.left = resultX + 'px';
                        result.style.top = resultY + 'px';

                        // Tính toán background position chính xác cho zoom
                        const centerX = lensX + lensWidth/2;
                        const centerY = lensY + lensHeight/2;

                        // Background position phải được tính ngược lại cho zoom effect
                        const bgPosX = -(centerX * zoomRatio - resultWidth/2);
                        const bgPosY = -(centerY * zoomRatio - resultHeight/2);

                        result.style.backgroundPosition = `${bgPosX}px ${bgPosY}px`;
                    }
                }
            }


            // Loading state cho submit button
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                // Disable button và hiển thị loading
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                // Form sẽ submit bình thường (không preventDefault)
                // Controller sẽ xử lý và trả về cùng trang với kết quả
            });
        });
    </script>
@endsection
