@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.8') }}">
        <style>
            .main-content-wrapper {
                background-image: url(../images/Quy_Trinh_Bg.png);
                background-repeat: no-repeat;
                background-position: top center;
                background-size: 100% auto;
                /* Ảnh full-width, giữ đúng tỉ lệ */
                background-color: #ffffff;
                /* Màu nền phía dưới */
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
            <h1 class="content-title-home-lich " style="color: #192E52">
                Lập Lá Số Tử Vi và Luận Giải Vận Mệnh Miễn Phí
            </h1>
            <div class="mt-3">
                <div class="row g-0 g-lg-3">
                    <div class="col-xl-9 col-sm-12 col-12 ">

                        <div class="backv-doi-lich">
                            <div class="row g-xl-5 g-lg-3 g-sm-5">
                                <div class="col-lg-8">
                                    <div class="">
                                        <div class="form--submit-totxau">
                                            <div class="fw-bold  title-tong-quan-h2-log" style="#192E52">
                                                Thông tin người
                                                xem
                                            </div>
                                            <p class="" style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông
                                                tin
                                                vào
                                                ô dưới
                                                đây để xem lá số tử vi</p>

                                            <form id="lasoForm" action="{{ route('laso.submit') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <span>Họ tên</span>

                                                    <div>
                                                        <input type="text" id="ho_ten" name="ho_ten"
                                                            value="{{ old('ho_ten', $lastInput['ho_ten'] ?? '') }}"
                                                            class="form-control --border-box-form style-input" required
                                                            placeholder="Nhập tên của bạn"
                                                            style="padding: 12px 45px 12px 15px">

                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="mb-xl-1 mb-md-1 mb-sm-1">
                                                        <label class=" fw-semibold">Giới Tính</label>
                                                        <div class="d-flex gap-3 align-items-center" style="height: 50px">


                                                            <div class="form-check">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="checkbox-wrapper-31">
                                                                        <input type="radio" name="gioi_tinh"
                                                                            value="Nam"
                                                                            style="width: 24px; height: 24px; cursor: pointer;"
                                                                            id="gt_nam" class="form-check-input"
                                                                            {{ old('gioi_tinh', $lastInput['gioi_tinh'] ?? 'Nam') == 'Nam' ? 'checked' : '' }} />

                                                                    </div>
                                                                    <label for="gt_nam"
                                                                        class="form-check-label">Nam</label>
                                                                </div>


                                                            </div>
                                                            <div class="form-check">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="checkbox-wrapper-31">
                                                                        <input type="radio" name="gioi_tinh"
                                                                            value="Nữ"
                                                                            style="width: 24px; height: 24px; cursor: pointer;"
                                                                            id="gt_nu" class="form-check-input"
                                                                            {{ old('gioi_tinh', $lastInput['gioi_tinh'] ?? 'Nam') == 'Nữ' ? 'checked' : '' }} />

                                                                    </div>
                                                                    <label for="gt_nu"
                                                                        class="form-check-label">Nữ</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="fw-semibold">Giờ Sinh</label>
                                                            <div class="col-12">
                                                                <!-- Sử dụng col-12 để chiếm toàn bộ chiều rộng -->
                                                                @php
                                                                    // Định nghĩa các khoảng thời gian giờ âm lịch và giờ/phút bắt đầu tương ứng
                                                                    // Lưu ý: value của option là "giờ_phút" để JS dễ phân tích
                                                                    $zodiacTimeRanges = [
                                                                        [
                                                                            'name' => 'Tý Khuya',
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
                                                                            'name' => 'Tý sớm',
                                                                            'start_h' => 23,
                                                                            'start_m' => 0,
                                                                            'end_h' => 23,
                                                                            'end_m' => 59,
                                                                        ],
                                                                    ];

                                                                    // Xử lý old value từ form submission hoặc từ session
                                                                    $oldGio = old(
                                                                        'dl_gio',
                                                                        $lastInput['dl_gio'] ?? null,
                                                                    );
                                                                    $oldPhut = old(
                                                                        'dl_phut',
                                                                        $lastInput['dl_phut'] ?? null,
                                                                    );

                                                                    $selectedOptionValue = ''; // Biến để lưu giá trị 'start_h_start_m' của option được chọn

                                                                    if ($oldGio !== null && $oldPhut !== null) {
                                                                        $oldGioInt = (int) $oldGio;
                                                                        $oldPhutInt = (int) $oldPhut;
                                                                        $inputTimeInMinutes =
                                                                            $oldGioInt * 60 + $oldPhutInt;

                                                                        // Tìm khoảng giờ âm lịch mà old('dl_gio') và old('dl_phut') thuộc về
                                                                        foreach ($zodiacTimeRanges as $range) {
                                                                            $rangeStartInMinutes =
                                                                                $range['start_h'] * 60 +
                                                                                $range['start_m'];
                                                                            $rangeEndInMinutes =
                                                                                $range['end_h'] * 60 + $range['end_m'];

                                                                            // Logic đặc biệt cho Tý khuya (23h) và Tý sớm (00h)
                                                                            // Nếu thời gian input nằm trong khoảng này
                                                                            if (
                                                                                $inputTimeInMinutes >=
                                                                                    $rangeStartInMinutes &&
                                                                                $inputTimeInMinutes <=
                                                                                    $rangeEndInMinutes
                                                                            ) {
                                                                                $selectedOptionValue =
                                                                                    $range['start_h'] .
                                                                                    '_' .
                                                                                    $range['start_m'];
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
                                                                    class="form-control --border-box-form style-input"
                                                                    required>
                                                                    <option value="" disabled
                                                                        {{ $selectedOptionValue == '' ? 'selected' : '' }}>
                                                                        Chọn
                                                                        giờ
                                                                        sinh
                                                                    </option>
                                                                    @foreach ($zodiacTimeRanges as $range)
                                                                        @php
                                                                            $displayTime =
                                                                                str_pad(
                                                                                    $range['start_h'],
                                                                                    2,
                                                                                    '0',
                                                                                    STR_PAD_LEFT,
                                                                                ) .
                                                                                'h - ' .
                                                                                str_pad(
                                                                                    $range['end_h'],
                                                                                    2,
                                                                                    '0',
                                                                                    STR_PAD_LEFT,
                                                                                ) .
                                                                                'h' .
                                                                                str_pad(
                                                                                    $range['end_m'],
                                                                                    2,
                                                                                    '0',
                                                                                    STR_PAD_LEFT,
                                                                                );
                                                                            $optionValue =
                                                                                $range['start_h'] .
                                                                                '_' .
                                                                                $range['start_m']; // Giá trị gửi cho JS

                                                                            // Đánh dấu 'selected' cho option nếu khớp với old value
                                                                            $isSelected =
                                                                                $optionValue == $selectedOptionValue
                                                                                    ? 'selected'
                                                                                    : '';
                                                                        @endphp
                                                                        <option value="{{ $optionValue }}"
                                                                            {{ $isSelected }}>
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
                                                        <div class="col-6">
                                                            <label class="fw-semibold">Năm Xem</label>
                                                            <input type="number" id="nam_xem" name="nam_xem"
                                                                value="{{ old('nam_xem', $lastInput['nam_xem'] ?? date('Y')) }}"
                                                                class="form-control --border-box-form style-input" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class=" fw-semibold">Ngày Sinh</label>



                                                        <div class="row g-2 mb-2">
                                                            <div class="col-4">
                                                                <div class="position-relative">
                                                                    <select
                                                                        class="form-select pe-5 style-input --border-box-form"
                                                                        id="dl_ngaySelect">
                                                                        <option value="">Ngày</option>
                                                                    </select>
                                                                    <i class="bi bi-chevron-down position-absolute"
                                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="position-relative">
                                                                    <select
                                                                        class="form-select pe-5 style-input --border-box-form"
                                                                        id="dl_thangSelect">
                                                                        <option value="">Tháng</option>
                                                                    </select>
                                                                    <i class="bi bi-chevron-down position-absolute"
                                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="position-relative">
                                                                    <select
                                                                        class="form-select pe-5 style-input --border-box-form"
                                                                        id="dl_namSelect">
                                                                        <option value="">Năm</option>
                                                                    </select>
                                                                    <i class="bi bi-chevron-down position-absolute"
                                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="leapMonthContainer" class="mt-2"
                                                            style="display: none;">
                                                            <div class="form-check">
                                                                <input class="form-check-input --border-box-form"
                                                                    type="checkbox" id="leapMonth" name="leap_month">
                                                                <label class="form-check-label" for="leapMonth">
                                                                    Tháng nhuận
                                                                </label>
                                                            </div>
                                                        </div>


                                                        <input type="hidden" id="ngayXem" name="dl_date_processed"
                                                            value="{{ old('dl_date_processed', $lastInput['dl_date_processed'] ?? '') }}">

                                                        <div class="d-flex gap-3 mb-3"
                                                            style="min-height: 40px; align-items: center;">
                                                            <div class="form-check d-flex align-items-center"
                                                                style="gap: 10px">
                                                                <input class="form-check-input" type="radio"
                                                                    name="calendar_type" id="solarCalendar"
                                                                    value="solar"
                                                                    {{ old('calendar_type', $lastInput['calendar_type'] ?? 'solar') == 'solar' ? 'checked' : '' }}
                                                                    style="width: 24px; height: 24px; cursor: pointer;">
                                                                <label class="form-check-label" for="solarCalendar">
                                                                    Dương lịch
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center justify-content-center"
                                                                style="gap: 10px">
                                                                <input class="form-check-input" type="radio"
                                                                    name="calendar_type" id="lunarCalendar"
                                                                    value="lunar"
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
                                                    <button type="submit" class="btn btn-light-settup fw-bold w-100">
                                                        Lập lá số tử vi
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
                                            style=" background-image: url(../images/form_laso.svg);
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
                        @include('la-so-tu-vi.content')

                    </div>
                    @include('tools.siderbardetail')
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
