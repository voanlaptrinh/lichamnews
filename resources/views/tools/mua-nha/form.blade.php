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
                    Xem ngày mua Nhà
                </li>
            </ol>
        </nav>



        <h1 class="content-title-home-lich">Xem ngày tốt mua nhà theo tuổi</h1>

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
                                        <p class="" style="font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
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


                                                <div class="input-group mb-4">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log" style="color: #192E52; padding-bottom: 12px;">Dự kiến
                                                        thời gian mua</div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control wedding_date_range --border-box-form @error('date_range') is-invalid @enderror"
                                                            id="date_range" name="date_range"
                                                            placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                            value="{{ old('date_range', $inputs['date_range'] ?? '') }}"
                                                            style="border-radius: 10px; border: none; padding: 12px 30px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                      <span class="input-group-text bg-transparent border-0"
                                                        style="position: absolute; right: 2px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                       <img src="{{ asset('images/date1-icon.svg') }}" alt="icon ngày tháng năm" class="img-fluid">
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100" style=" background-image: url(../images/form_muanha.svg);
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
                                Tại sao việc chọn ngày mua nhà lại quan trọng?
                            </h2>
                            <p class="mb-1">Mua nhà không chỉ là một giao dịch tài chính lớn mà còn là bước ngoặt quan
                                trọng trong cuộc sống gia đình. Một ngày tốt khi nhận nhà không chỉ giúp mọi việc suôn sẻ mà
                                còn mang theo:</p>
                            <ul class="mb-1">
                                <li>May mắn và cát khí, giúp gia đình an cư, lạc nghiệp.</li>
                                <li>Hài hòa về phong thủy, tạo nền tảng thuận lợi cho sức khỏe, tài lộc và các mối quan hệ
                                    trong gia đình.</li>
                                <li>Tâm lý an tâm cho gia chủ, giúp quá trình chuyển nhà, dọn đồ và ổn định cuộc sống mới
                                    diễn ra thuận lợi, nhẹ nhàng.</li>
                            </ul>
                            <p class="mb-1">Ngày mua nhà được coi là “khai vận” cho ngôi nhà mới. Việc chọn ngày hợp
                                tuổi, hợp phong thủy sẽ tạo ra sự thuận lợi và trấn an tâm lý, giảm những trục trặc phát
                                sinh trong quá trình nhận nhà.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích của việc chọn ngày mua nhà hợp tuổi
                            </h2>
                            <p class="mb-1">Khi chọn được ngày đẹp để mua nhà, gia chủ sẽ nhận được nhiều lợi ích thực
                                tế:</p>
                            <ul class="mb-1">
                                <li>Tránh xung tuổi và hạn chế tai họa phong thủy: Ngày phù hợp giúp gia chủ và các thành
                                    viên tránh xung khắc với tuổi, hạn chế những điều không may trong quá trình sinh sống.
                                </li>
                                <li>
                                    Khởi đầu thuận lợi: Ngày hợp tuổi và hoàng đạo sẽ giúp quá trình dọn nhà diễn ra suôn
                                    sẻ, mọi việc trôi chảy từ lễ nhập trạch đến việc ổn định sinh hoạt.
                                </li>
                                <li>
                                    Thu hút cát khí: Hướng, giờ xuất hành và ngày hợp tuổi sẽ hỗ trợ tài lộc, sức khỏe, hòa
                                    khí và mối quan hệ giữa các thành viên trong gia đình.
                                </li>
                                <li>
                                    Tâm lý an tâm và tự tin: Khi biết ngày đã được lựa chọn cẩn thận, gia chủ cảm thấy vững
                                    tâm, chủ động trong việc chuẩn bị đồ đạc, bố trí nội thất, lễ nhập trạch.
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Các yếu tố cần lưu ý khi xem ngày mua nhà
                            </h2>
                            <ul style="list-style-type: upper-alpha;">
                                <li>Các yếu tố nên ưu tiên
                                    <ul style="	list-style-type: decimal;">
                                        <li>
                                            Ngày hoàng đạo và trực tốt <br>
                                            Ưu tiên ngày Hoàng đạo và các trực như Trực Khai, Trực Thành, Trực Mãn… mang ý
                                            nghĩa mở đầu thuận lợi, phù hợp cho việc nhận nhà và bắt đầu cuộc sống mới.
                                        </li>
                                        <li>
                                            Ngày hợp tuổi gia chủ<br>
                                            Ngày có ngũ hành tương sinh, tương hỗ với tuổi chủ nhà giúp tăng cát khí, hạn
                                            chế xung khắc.
                                        </li>
                                        <li>
                                            Sao tốt cần chọn <br>
                                            Khi xem ngày mua nhà, nên ưu tiên các sao mang ý nghĩa may mắn, hanh thông và
                                            cát lành, gồm:
                                            <ul style="list-style-type: circle;">
                                                <li>
                                                    Thiên Đức – Nguyệt Đức: Mang lại sự may mắn, quý nhân giúp đỡ.
                                                </li>
                                                <li>
                                                    Thiên Hỷ: Tốt cho việc vui mừng, khởi đầu mới, dễ mang tin vui vào nhà.
                                                </li>
                                                <li>
                                                    Sinh Khí: Rất tốt cho sức khỏe, tài lộc và phong thủy nhà ở.
                                                </li>
                                                <li>
                                                    Thiên Mã: Tốt cho giao dịch, ký kết, thuận lợi cho việc nhận bàn giao
                                                    nhà.
                                                </li>
                                                <li>
                                                    Tam Hợp: Tăng cát khí, sự hòa thuận và hanh thông.
                                                </li>
                                                <li>
                                                    Thiên Quan – Thiên Phúc: Giúp mọi việc suôn sẻ, có thần linh che chở.
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            Chọn giờ hoàng đạo<br>
                                            Giờ nhận nhà, làm lễ hoặc chuyển đồ cũng nên chọn giờ tốt hợp tuổi để tăng thêm
                                            may mắn.
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    Các yếu tố cần tránh
                                    <ul style="list-style-type: decimal;">
                                        <li>
                                            Sao xấu cần tránh <br>
                                            Tránh những ngày xuất hiện các sao mang năng lượng xấu, dễ gây trở ngại trong
                                            việc chuyển nhà:
                                            <ul style="	list-style-type: circle;">
                                                <li>Thiên Ôn, Thiên Cương: Dễ mang đến bất lợi, không tốt cho mua bán – giao
                                                    dịch.</li>
                                                <li>Cô Thần, Quả Tú: Mang tính cô đơn, lẻ loi, không tốt cho hòa khí gia
                                                    đình.</li>
                                                <li>Không Vong: Ngày rỗng, dễ sinh chuyện không như ý.</li>
                                            </ul>
                                        </li>
                                        <li>
                                            Các ngày đại kỵ nhất định phải tránh <br>
                                            Đây là nhóm ngày cực xấu trong dân gian, không nên dùng cho việc lớn như mua
                                            nhà, nhập trạch:
                                            <ul style="	list-style-type: circle;">
                                                <li>
                                                    Nguyệt Kỵ, Nguyệt Tận
                                                </li>
                                                <li>
                                                    Tam Nương
                                                </li>
                                                <li>
                                                    Sát Chủ Dương
                                                </li>
                                                <li>
                                                    Dương Công Kỵ Nhật
                                                </li>
                                                <li>
                                                    Thọ Tử
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            Ngày xung tuổi, trực xấu <br>
                                            Tránh Trực Bế, Trực Phá, Trực Nguy… để giảm rủi ro và bất tiện trong quá trình
                                            chuyển về nhà mới.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Hướng dẫn sử dụng công cụ Xem Ngày Mua Nhà tại Phong Lịch
                            </h2>
                            <ul style="list-style-type: decimal;">
                                <li>Nhập tuổi gia chủ (âm lịch hoặc dương lịch).</li>
                                <li>Chọn khoảng thời gian dự định mua hoặc nhận nhà.</li>
                                <li>Hệ thống tự động phân tích và gợi ý:
                                    <ul style="	list-style-type: circle;">
                                        <li>Những ngày mua nhà đẹp nhất trong khoảng thời gian đã chọn.</li>
                                        <li>Điểm tốt – xấu, sao tốt/xấu, trực ngày và giờ hoàng đạo.</li>
                                        <li>Lưu ý chi tiết về các yếu tố phong thủy quan trọng.</li>
                                    </ul>
                                </li>
                                <li>So sánh các ngày phù hợp với lịch trình thực tế để lựa chọn ngày tối ưu nhất.</li>
                            </ul>
                            <p>Công cụ này giúp gia chủ tiết kiệm thời gian, dễ dàng so sánh và chọn lựa ngày đẹp, đồng thời
                                hiểu rõ lý do vì sao ngày được đánh giá tốt hoặc xấu.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Lợi ích thực tế của một ngày mua nhà đẹp
                            </h2>
                            <ul>
                                <li>Gia đình thuận hòa: Mọi thành viên cảm thấy hài lòng, tâm lý an tâm khi chuyển về nhà
                                    mới.</li>
                                <li>Công việc dọn về nhà trôi chảy: Không xảy ra trục trặc hay sự cố không đáng có</li>
                                <li>Thu hút may mắn và tài lộc: Ngôi nhà được nhận vào ngày tốt sẽ tăng cát khí, thuận lợi
                                    cho sức khỏe, công việc, học tập của các thành viên.
                                </li>
                                <li>
                                    Nghi lễ nhập trạch trọn vẹn: Buổi lễ diễn ra suôn sẻ, đúng truyền thống, mang ý nghĩa
                                    khởi đầu tốt đẹp cho cuộc sống tại ngôi nhà mới.
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                @include('tools.siderbarindex')
            </div>

        </div>
    </div>

    <!-- Mobile Date Range Quick Options Popup -->
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

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.getElementById('buildHouseForm');
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
                    alert('Vui lòng chọn đầy đủ ngày, tháng, năm');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput.value;

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian');
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
                fetch('{{ route('buy-house.check') }}', {
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

                            // Khởi tạo taboo filter và pagination với dữ liệu từ response
                            setTimeout(() => {
                                // Sử dụng global initTabooFilter từ component
                                if (typeof window.initTabooFilter === 'function') {
                                    window.initTabooFilter(data.resultsByYear);
                                }
                                initPagination();
                            }, 200);
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

            // Optimized sorting functions
            function getScoreFromRow(row) {
                const battery = row.querySelector('.battery-label');
                if (battery) {
                    return parseInt(battery.textContent.replace('%', '')) || 0;
                }

                const scoreElement = row.querySelector('.diem-so, .score');
                if (scoreElement) {
                    return parseInt(scoreElement.textContent.replace(/[^\d]/g, '')) || 0;
                }

                const cells = row.querySelectorAll('td');
                for (let cell of cells) {
                    const match = cell.textContent.trim().match(/(\d+)/);
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

                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));
            }

            // Event delegation for sorting
            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    applySortingToTable(event.target.value);
                    setTimeout(() => {
                        document.getElementById('bang-chi-tiet')?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });

        });

        // Direct test for filter button
        document.addEventListener('click', function(e) {
            console.log('Click detected on:', e.target.id, e.target.className);
            if (e.target.id === 'tabooFilterBtn') {
                console.log('Direct click on filter button detected!');
            }
        });

        // Test function that can be called from console
        window.testTabooFilter = function() {
            const btn = document.getElementById('tabooFilterBtn');
            const modal = document.getElementById('tabooFilterModal');

            if (btn) {
                btn.click();
            }
        };

        // ========== PAGINATION & SORT FUNCTIONS - GIỐNG TOT-XAU ==========
        function initPagination() {
            console.log('initPagination called');

            // Event delegation cho load more button
            const resultsContainer = document.querySelector('.--detail-success');
            resultsContainer.addEventListener('click', function(event) {
                if (event.target.matches('.load-more-btn') || event.target.closest('.load-more-btn')) {
                    const btn = event.target.matches('.load-more-btn') ? event.target : event.target.closest(
                        '.load-more-btn');
                    const year = btn.dataset.year;
                    const loaded = parseInt(btn.dataset.loaded);
                    const total = parseInt(btn.dataset.total);

                    // Check if taboo filter is active
                    const selectedTaboos = document.querySelectorAll('.taboo-checkbox:checked');
                    if (selectedTaboos.length > 0) {
                        console.log('Taboo filter is active, updating filter status after pagination');
                        // Let taboo filter component handle the pagination update
                        if (typeof window.updateFilterStatusOnPagination === 'function') {
                            window.updateFilterStatusOnPagination(year);
                        }
                        return; // Let the taboo filter handle this
                    }

                    // Original pagination logic for when no taboo filter is active
                    const tbody = document.querySelector(`.table-body-${year}`);

                    if (!tbody) return;

                    const rows = tbody.querySelectorAll('tr');
                    let newLoaded = loaded;

                    // Hiển thị thêm 10 rows tiếp theo
                    for (let i = loaded; i < Math.min(loaded + 10, total); i++) {
                        if (rows[i]) {
                            rows[i].style.display = '';
                            rows[i].dataset.visible = 'true';
                            newLoaded++;
                        }
                    }

                    // Cập nhật dataset và text
                    btn.dataset.loaded = newLoaded;
                    const remaining = total - newLoaded;

                    if (remaining > 0) {
                        btn.innerHTML = `
                            Xem thêm
                        `;
                    } else {
                        btn.style.display = 'none';
                    }
                }
            });

            // Event delegation cho sort select
            resultsContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]') || event.target.matches('.sort-select')) {
                    const sortValue = event.target.value;
                    console.log('Sort changed to:', sortValue);
                    applySortingToTable(sortValue);
                }
            });
        }

        // SORT FUNCTIONS - COPY TỪ TOT-XAU
        function getScoreFromRow(row) {
            // For mua-nha: tìm score trong battery-fill style width
            const batteryFill = row.querySelector('.battery-fill');
            if (batteryFill) {
                const style = batteryFill.getAttribute('style');
                const match = style.match(/width:\s*(\d+)%/);
                if (match) {
                    return parseInt(match[1]) || 0;
                }
            }

            // Fallback: Try other score elements
            const scoreElement = row.querySelector('.diem-so, .score, .battery-label');
            if (scoreElement) {
                return parseInt(scoreElement.textContent.replace(/[^\d]/g, '')) || 0;
            }

            return 0;
        }

        function getDateFromRow(row) {
            const dateCell = row.querySelector('td:first-child a');
            if (!dateCell) return new Date(0);

            const dateText = dateCell.textContent;
            const match = dateText.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
            if (match) {
                return new Date(match[3], match[2] - 1, match[1]);
            }
            return new Date(0);
        }

        function applySortingToTable(sortValue) {
            console.log('applySortingToTable called with:', sortValue);

            // Check if taboo filter is active - if so, let taboo filter handle sorting
            const selectedTaboos = document.querySelectorAll('.taboo-checkbox:checked');
            if (selectedTaboos.length > 0 && typeof window.applySortToYear === 'function') {
                console.log('Taboo filter is active, delegating sort to taboo filter component');

                // Find active year tabs and apply sort to each
                const activeTabPanes = document.querySelectorAll('.tab-pane');
                activeTabPanes.forEach(tabPane => {
                    const year = tabPane.id.replace('year-', '');
                    if (year && window.applySortToYear) {
                        window.applySortToYear(year, sortValue, false);
                    }
                });
                return;
            }

            // If no taboo filter, use regular sorting
            const tables = document.querySelectorAll('tbody');
            console.log('Found tables:', tables.length);

            if (tables.length === 0) return;

            tables.forEach(table => {
                const rows = Array.from(table.querySelectorAll('tr'));
                console.log(`Sorting ${rows.length} rows`);

                if (rows.length === 0) return;

                rows.sort((a, b) => {
                    if (sortValue === 'date_asc' || sortValue === 'date_desc') {
                        // Sắp xếp theo ngày
                        const dateA = getDateFromRow(a);
                        const dateB = getDateFromRow(b);
                        return sortValue === 'date_asc' ? dateA - dateB : dateB - dateA;
                    } else {
                        // Sắp xếp theo điểm (desc only)
                        const scoreA = getScoreFromRow(a);
                        const scoreB = getScoreFromRow(b);
                        return scoreB - scoreA; // Luôn giảm dần
                    }
                });

                // Clear và append lại rows đã sắp xếp
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));

                // Giữ pagination state
                maintainCurrentPagination(table);
            });
        }

        function maintainCurrentPagination(table) {
            // Kiểm tra xem có filter active không
            const filterStatus = document.getElementById('filterStatus');
            const isFilterActive = filterStatus && !filterStatus.classList.contains('d-none');

            if (isFilterActive) return; // Để taboo component quản lý

            const loadMoreBtn = table.closest('.card-body')?.querySelector('.load-more-btn');
            let currentLoaded = 10;

            if (loadMoreBtn) {
                currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;
            }

            const rows = table.querySelectorAll('tr');

            rows.forEach((row, index) => {
                if (index >= currentLoaded) {
                    row.style.display = 'none';
                    row.dataset.visible = 'false';
                } else {
                    row.style.display = '';
                    row.dataset.visible = 'true';
                }
            });

            // Cập nhật load more button
            if (loadMoreBtn) {
                loadMoreBtn.dataset.loaded = currentLoaded.toString();
                loadMoreBtn.dataset.total = rows.length.toString();
                const remaining = rows.length - currentLoaded;

                if (remaining > 0) {
                    loadMoreBtn.style.display = '';
                    loadMoreBtn.innerHTML = `
                        Xem thêm
                    `;
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }
        }
    </script>
    @include('components.taboo-filter-script')
@endpush
