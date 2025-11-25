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
                    Xem ngày cải táng
                </li>
            </ol>
        </nav>

        <h1 class="content-title-home-lich">Xem ngày tốt cải táng sang cát theo tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">


                                        <form id="caiTangForm">
                                            @csrf

                                            <div class="row g-1">
                                                <!-- Thông tin người đứng lễ -->
                                                <div class="">
                                                    <div class="fw-bold title-tong-quan-h2-log mb-3"
                                                        style="color: rgba(25, 46, 82, 1); border-bottom: 1px solid #ddd; padding-bottom: 8px;">
                                                        Thông tin người đứng lễ
                                                    </div>
                                                    <p class="mb-0" style="color: #000"><span style="color: red">Lưu
                                                            ý:</span> Thông tin người đứng lễ là con trưởng hoặc người đại
                                                        diện</p>
                                                </div>

                                                <div class="mb-3">
                                                    <div for="birthdate" class="fw-bold title-tong-quan-h4-log mb-2">Ngày
                                                        sinh người đứng lễ</div>
                                                    <!-- Date Selects -->
                                                    <div class="row g-1 mb-2">
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

                                                <!-- Thông tin người mất -->
                                                <div class="mb-0">
                                                    <div class="fw-bold title-tong-quan-h2-log"
                                                        style="color: rgba(25, 46, 82, 1); border-bottom: 1px solid #ddd; padding-bottom: 8px;">
                                                        Thông tin người mất
                                                    </div>
                                                </div>


                                                <div class="col-6">
                                                    <div for="birth_mat" class="fw-bold title-tong-quan-h4-log mb-2">Năm
                                                        sinh âm lịch</div>
                                                    <div class="position-relative">
                                                        <select name="birth_mat" id="birth_mat"
                                                            class="form-select pe-5 --border-box-form"
                                                            style="padding: 12px 45px 12px 15px">
                                                            <option value="">Chọn năm sinh</option>
                                                            @php
                                                                $selectedBirthYear = old(
                                                                    'birth_mat',
                                                                    $inputs['birth_mat'] ?? null,
                                                                );
                                                            @endphp
                                                            @for ($year = date('Y'); $year >= 1800; $year--)
                                                                <option value="{{ $year }}"
                                                                    {{ $selectedBirthYear == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        <i class="bi bi-chevron-down position-absolute"
                                                            style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div for="nam_mat" class="fw-bold title-tong-quan-h4-log mb-2">
                                                        Năm mất âm lịch</div>
                                                    <div class="position-relative">
                                                        <select name="nam_mat" id="nam_mat"
                                                            class="form-select pe-5 --border-box-form"
                                                            style="padding: 12px 45px 12px 15px">
                                                            <option value="">Chọn năm mất</option>
                                                            @php
                                                                $selectedDeathYear = old(
                                                                    'nam_mat',
                                                                    $inputs['nam_mat'] ?? null,
                                                                );
                                                            @endphp
                                                            @for ($year = date('Y'); $year >= 1800; $year--)
                                                                <option value="{{ $year }}"
                                                                    {{ $selectedDeathYear == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        <i class="bi bi-chevron-down position-absolute"
                                                            style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                    </div>
                                                </div>


                                                <div class="input-group mb-4">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log">Dự kiến
                                                        thời gian cải táng</div>
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
                        @if (isset($resultsByYear) && count($resultsByYear) > 0)
                            @include('tools.cai-tang.results')
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                            </div>
                        @endif
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Vì sao sang cát – cải mộ cần chọn ngày tốt?
                            </h2>
                            <p class="mb-1">Sang cát (cải táng) là nghi lễ quan trọng trong văn hóa thờ cúng tổ tiên của
                                người Việt. Đây là việc động chạm đến âm phần, liên quan đến sự an ổn của người mất và sự
                                bình yên của con cháu. Vì vậy, chọn ngày tốt có ý nghĩa đặc biệt:
                            </p>
                            <ul class="mb-1">
                                <li>Giúp quá trình bốc mộ, di dời diễn ra thuận lợi, tránh sự cố hoặc điều không may.</li>
                                <li>Tăng cát khí, đảm bảo phần mộ sau khi sang cát được yên ổn, hài hòa long mạch.</li>
                                <li>Tránh phạm các ngày xấu khiến gia đình gặp rối ren, bất an hoặc ảnh hưởng vận khí.</li>
                                <li>Tạo sự yên tâm cho gia đình, đặc biệt là người chủ trì lễ (thường là trưởng nam hoặc
                                    người đại diện trong nội tộc).</li>
                            </ul>
                            <p class="mb-1">Một ngày cải táng đẹp giúp công việc suôn sẻ, phần mộ được an vị tốt, và gia
                                đình cảm thấy nhẹ lòng, an tâm.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích của việc chọn ngày sang cát – cải mộ hợp tuổi
                            </h2>
                            <ul class="mb-1">
                                <li>Không xung tuổi trưởng nam: Tránh lục xung – lục hại, giảm rủi ro, hạn chế việc “động mồ
                                    – động mả”.</li>
                                <li>Ngày hoàng đạo và giờ hoàng đạo: Khí trường nhẹ, tốt cho việc động thổ âm phần.</li>
                                <li>Sao tốt và trực tốt: Giúp long mạch ổn định, việc bốc mộ diễn ra thuận hòa, tránh trục
                                    trặc.</li>
                                <li>Ngũ hành ngày tương sinh: Tạo sự phù hợp giữa âm phần và người chủ lễ, làm tăng cát khí.
                                </li>
                            </ul>
                            <p class="mb-1">Chọn được ngày – giờ hợp tuổi giúp gia đình yên tâm, mọi việc được tiến hành
                                đúng phong tục và mang lại cảm giác an ổn cho cả tâm linh lẫn tinh thần.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi xem ngày sang cát – cải mộ cần lưu ý điều gì?
                            </h2>
                            <ul class="mb-1" style="list-style-type: upper-alpha;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Các yếu tố cát lành nên ưu tiên:</h3>
                                    <ul style="	list-style-type: decimal;" class="mb-1">
                                        <li>
                                            <p class="mb-1">Ngày hoàng đạo và trực tốt</p>
                                            <ul>
                                                <li>Ngày Hoàng Đạo: Thanh Long, Minh Đường, Kim Quỹ, Ngọc Đường, Tư Mệnh.
                                                </li>
                                                <li>Trực tốt: Trực Định (tốt nhất cho sang cát), Trực Thành, Trực Khai, Trực
                                                    Mãn.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày hợp tuổi người chủ trì (người đứng lễ)</p>
                                            <ul>
                                                <li>Ngày không xung can – chi với tuổi người được chọn ngày.</li>
                                                <li>Ngũ hành ngày nên tương sinh hoặc hỗ trợ.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Sao tốt và giờ tốt</p>
                                            <ul>
                                                <li>Sao cát: Thiên Đức, Nguyệt Đức, Thiên Quan, Thiên Phúc, Thiên Hỷ, Tam
                                                    Hợp, Lục Hợp.</li>
                                                <li>Giờ Hoàng Đạo: thích hợp để mở huyệt, bốc mộ, di dời hài cốt.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <p class="mb-1">Ưu tiên các yếu tố này giúp lễ sang cát diễn ra trọn vẹn, phần mộ
                                        được an vị đúng phong thủy.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">Các yếu tố xấu nên tránh:</h3>
                                    <ul style="list-style-type: decimal;">
                                        <li>
                                            <p class="mb-1">Ngày xung tuổi / phạm hạn</p>
                                            <ul>
                                                <li>Xung tuổi trưởng nam hoặc người làm lễ.</li>
                                                <li>Phạm Tam Tai, Thái Tuế</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày hắc đạo và trực xấu</p>
                                            <ul>
                                                <li>Huyền Vũ, Bạch Hổ, Thiên Lao, Xích Khẩu.</li>
                                                <li>Trực Nguy, Trực Phá, Trực Thu, Trực Bế.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày sát âm trạch</p>
                                            <ul>
                                                <li>Thiên Cương, Địa Sát, Sát Chủ, Thổ Phủ, Thổ Ôn, Không Vong.</li>
                                                <li>Ngày Trùng Tang, Trùng Phục.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="mb-1">Ngày bách kỵ đặc biệt</p>
                                            <ul class="mb-1">
                                                <li>Tam Nương (3–7–13–18–22–27).</li>
                                                <li>Nguyệt Kỵ (5–14–23).</li>
                                                <li>Dương Công Kỵ Nhật.</li>
                                                <li>Sát Chủ Âm</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <p class="mb-1">Việc tránh các ngày này giúp hạn chế rủi ro, giảm hung khí và đảm bảo
                                        sự yên ổn cho phần mộ.</p>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Hướng dẫn sử dụng công cụ Xem Ngày Sang Cát – Cải Mộ tại Phong Lịch
                            </h2>
                            <ul class="mb-1" style="list-style-type: decimal;">
                                <li>Nhập tuổi người chủ trì (thường là trưởng nam hoặc người đứng ra lo việc).</li>
                                <li>Nhập thông tin người mất</li>
                                <li>Chọn khoảng thời gian dự định cải táng.</li>
                                <li>Hệ thống sẽ:
                                    <ul>
                                        <li>Gợi ý các ngày sang cát đẹp nhất.</li>
                                        <li>Hiển thị điểm tốt – xấu của từng ngày.</li>
                                        <li>Liệt kê sao tốt, sao xấu, trực, ngày hoàng đạo, ngày cần tránh.</li>
                                        <li>Đề xuất giờ Hoàng đạo phù hợp để mở huyệt – bốc mộ.</li>
                                    </ul>
                                </li>
                                <li>So sánh các ngày và chọn ngày phù hợp nhất, kết hợp cả điều kiện thời tiết, nhân lực và
                                    lịch trình gia đình.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Một ngày sang cát – cải mộ đẹp mang lại lợi ích gì?
                            </h2>
                            <ul>
                                <li>Công việc diễn ra suôn sẻ, không vướng trở ngại.</li>
                                <li>Tránh phạm long mạch, giúp phần âm được an vị, người mất được yên ổn.</li>
                                <li>Gia đạo bớt rủi ro, giảm bất an hoặc biến cố không mong muốn.</li>
                                <li>Tăng cát khí cho gia đình, giúp cuộc sống ổn định, tinh thần nhẹ nhàng.</li>
                                <li>Nghi lễ trọn vẹn, đúng truyền thống, tạo sự an tâm cho tất cả thành viên.</li>

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

                if (params.birthdate || params.birth_mat || params.nam_mat || params.khoang) {
                    let formRestored = false;
                    let birthdateSet = false;
                    let birthMatSet = false;
                    let namMatSet = false;
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

                    // Restore birth_mat
                    if (params.birth_mat) {
                        const birthMatSelect = document.getElementById('birth_mat');
                        if (birthMatSelect) {
                            birthMatSelect.value = params.birth_mat;
                        }
                        birthMatSet = true;
                    } else {
                        birthMatSet = true;
                    }

                    // Restore nam_mat
                    if (params.nam_mat) {
                        const namMatSelect = document.getElementById('nam_mat');
                        if (namMatSelect) {
                            namMatSelect.value = params.nam_mat;
                        }
                        namMatSet = true;
                    } else {
                        namMatSet = true;
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
                        if (birthdateSet && birthMatSet && namMatSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay to ensure everything is set
                            setTimeout(() => {
                                const form = document.getElementById('caiTangForm');
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

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('caiTangForm');
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
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm sinh người đứng lễ');
                    return;
                }

                // Get birth_mat value
                const birthMatSelect = document.getElementById('birth_mat');
                const birthMatValue = birthMatSelect.value;

                if (!birthMatValue) {
                    alert('Vui lòng chọn năm sinh của người mất');
                    return;
                }

                // Get nam_mat value
                const namMatSelect = document.getElementById('nam_mat');
                const namMatValue = namMatSelect.value;

                if (!namMatValue) {
                    alert('Vui lòng chọn năm mất của người mất');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput.value;

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian cải táng');
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

                // Date range is already in correct format from daterangepicker
                // No need to parse, just pass it directly

                // Get sort value if exists
                const sortSelect = resultsContainer.querySelector('[name="sort"]');
                const sortValue = sortSelect ? sortSelect.value : 'desc';

                // Prepare form data
                const formData = {
                    birthdate: formattedBirthdate,
                    calendar_type: calendarType,
                    leap_month: isLeapMonth,
                    birth_mat: birthMatValue,
                    nam_mat: namMatValue,
                    date_range: dateRangeValue,
                    sort: sortValue,
                    _token: '{{ csrf_token() }}'
                };

                // Set hash parameters for URL state
                const hashParams = {
                    birthdate: formattedBirthdate,
                    birth_mat: birthMatValue,
                    nam_mat: namMatValue,
                    khoang: dateRangeValue,
                    calendar_type: calendarType
                };
                setHashParams(hashParams);

                // Show loading state
                submitBtn.disabled = true;
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                // Submit via AJAX
                fetch('{{ route('cai-tang.check') }}', {
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

                            // Store data for taboo filter
                            window.resultsByYear = data.resultsByYear;

                            // Scroll to results with delay to ensure content is rendered
                            setTimeout(() => {
                                resultsContainer.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 500);

                            // Re-initialize Bootstrap tabs if present
                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });

                            setTimeout(() => {
                                resultsContainer.innerHTML = data.html;
                                setTimeout(() => {
                                    if (window.resultsByYear && typeof window
                                        .initTabooFilter === 'function') {
                                        window.initTabooFilter(window.resultsByYear);
                                    }
                                    initPagination();
                                    setupContainerEventDelegation();
                                }, 200);
                            }, 500);
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
    @include('components.taboo-filter-script')
@endpush
