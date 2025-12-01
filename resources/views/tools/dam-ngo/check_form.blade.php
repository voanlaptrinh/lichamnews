@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.8') }}">
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
                    Xem ngày dạm ngõ
                </li>
            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem ngày tốt dạm ngõ theo tuổi</h1>
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
                                        <p class="" style=" font-size: 14px;color: #212121;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form action="{{ route('astrology.check') }}" method="POST">
                                            @csrf

                                            <div class="row">
                                                {{-- Ngày sinh Chú rể --}}
                                                <div class="col-md-12 mb-3">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log"
                                                        style="color: #192E52; padding-bottom: 12px;">Ngày sinh
                                                        Chú rể</div>

                                                    {{-- Date Selects --}}
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="groomDay" name="groom_day"
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
                                                                    id="groomMonth" name="groom_month"
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
                                                                    id="groomYear" name="groom_year"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Năm</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Radio buttons dạng tròn bên dưới selects --}}
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="groom_calendar_type" id="groomSolar" value="solar"
                                                                checked style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="groomSolar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Dương lịch
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="groom_calendar_type" id="groomLunar" value="lunar"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="groomLunar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Âm lịch
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- Leap Month Option (hidden) --}}
                                                    <div class="form-check mt-2" id="groomLeapMonthContainer"
                                                        style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="groomLeapMonth"
                                                            name="groom_leap_month">
                                                        <label class="form-check-label" for="groomLeapMonth">
                                                            Tháng nhuận
                                                        </label>
                                                    </div>

                                                    {{-- Hidden input to store formatted date --}}
                                                    <input type="hidden" id="groomDobHidden" name="groom_dob"
                                                        value="{{ old('groom_dob', $inputs['groom_dob'] ?? '') }}">

                                                    @error('groom_dob')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Ngày sinh Cô dâu --}}
                                                <div class="col-md-12 mb-3">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log"
                                                        style="color: #192E52; padding-bottom: 12px;">Ngày sinh
                                                        Cô dâu</div>

                                                    {{-- Date Selects --}}
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="brideDay" name="bride_day"
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
                                                                    id="brideMonth" name="bride_month"
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
                                                                    id="brideYear" name="bride_year"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Năm</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Radio buttons dạng tròn bên dưới selects --}}
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="bride_calendar_type" id="brideSolar" value="solar"
                                                                checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="brideSolar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Dương lịch
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input"
                                                                name="bride_calendar_type" id="brideLunar" value="lunar"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="brideLunar"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Âm lịch
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- Leap Month Option (hidden) --}}
                                                    <div class="form-check mt-2" id="brideLeapMonthContainer"
                                                        style="display: none;">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="brideLeapMonth" name="bride_leap_month">
                                                        <label class="form-check-label" for="brideLeapMonth">
                                                            Tháng nhuận
                                                        </label>
                                                    </div>

                                                    {{-- Hidden input to store formatted date --}}
                                                    <input type="hidden" id="brideDobHidden" name="bride_dob"
                                                        value="{{ old('bride_dob', $inputs['bride_dob'] ?? '') }}">

                                                    @error('bride_dob')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Khoảng ngày dự định cưới --}}
                                                <div class="col-md-12 mb-3">
                                                    <div for="date_range" class="fw-bold title-tong-quan-h4-log"
                                                        style="color: #192E52; padding-bottom: 12px;">Khoảng
                                                        ngày dự kiến cưới</div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control wedding_date_range --border-box-form @error('wedding_date_range') is-invalid @enderror"
                                                            id="wedding_date_range" name="wedding_date_range" readonly
                                                            placeholder="DD/MM/YY - DD/MM/YY" autocomplete="off"
                                                            value="{{ old('wedding_date_range', $inputs['wedding_date_range'] ?? '') }}"
                                                            style="border-radius: 10px; border: none; padding: 12px 30px 12px 15px; background-color: rgba(255,255,255,0.95); cursor: pointer;">
                                                        <span class="input-group-text bg-transparent border-0"
                                                            style="position: absolute; right: 2px; top: 50%; transform: translateY(-50%); z-index: 5; pointer-events: none;">
                                                            <img src="{{ asset('images/date1-icon.svg') }}"
                                                                alt="icon ngày tháng năm" class="img-fluid">
                                                        </span>
                                                    </div>
                                                    @error('wedding_date_range')
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
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100"
                                        style=" background-image: url(../images/form_damngo.svg);
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

                    {{-- Results Container --}}
                    <div id="resultsContainer" class="--detail-success">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Xem Ngày Dạm Ngõ – Chọn Lựa Khởi Đầu Trọn Vẹn Cho Hôn Nhân
                            </h2>
                            <p class="mb-1">Dạm ngõ là nghi lễ mở đầu cho con đường về chung một nhà. Một ngày đẹp, hợp
                                tuổi và thuận khí không chỉ giúp buổi gặp gỡ hai họ diễn ra suôn sẻ mà còn mang ý nghĩa “đặt
                                nền móng” tốt lành cho chuyện trăm năm phía trước. Vì vậy, việc xem ngày dạm ngõ là điều
                                nhiều gia đình vẫn coi trọng, vừa giữ giá trị truyền thống, vừa mang lại sự an tâm cho đôi
                                trẻ.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Ý Nghĩa Của Việc Xem Ngày Dạm Ngõ
                            </h2>
                            <p class="mb-1">
                                Khác với lễ cưới có phần long trọng, dạm ngõ là bước đầu tiên trong tiến trình hôn nhân. Tuy
                                đơn giản nhưng mang nhiều tầng ý nghĩa:
                            </p>
                            <ul style="	list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Tạo khởi đầu thuận hòa
                                    </h3>
                                    <p class="mb-1">
                                        Ngày giờ đẹp được cho là giúp không khí giữa hai gia đình thêm vui vẻ, ấm cúng,
                                        tránh những
                                        trục trặc không đáng có như muộn giờ, thời tiết xấu hay điều kiêng kỵ theo tuổi.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Giữ gìn truyền thống
                                    </h3>
                                    <p class="mb-1">
                                        Dạm ngõ là nghi lễ thưa chuyện, xin phép, thể hiện sự tôn trọng. Việc chọn ngày cẩn
                                        thận cho
                                        thấy sự chỉn chu, đặc biệt là với gia đình lớn tuổi.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Tâm lý vững vàng cho đôi trẻ
                                    </h3>
                                    <p class="mb-1">
                                        Ngày hợp tuổi và hợp việc giúp các cặp đôi cảm thấy tự tin, bắt đầu hành trình hôn
                                        nhân với
                                        tâm thế nhẹ nhàng, vui tươi.
                                    </p>
                                </li>
                            </ul>




                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Vì Sao Nhiều Gia Đình Vẫn Chọn Ngày Dạm Ngõ?
                            </h2>
                            <p class="mb-1">Không chỉ vì yếu tố phong tục, mà còn bởi:</p>
                            <ul class="mb-1">
                                <li>Tránh ngày xấu theo tuổi hai bạn (ngày xung, ngày sát chủ, ngày thụ tử).</li>
                                <li>Hợp ngũ hành – can chi, tượng trưng cho sự hòa hợp bền vững.</li>
                                <li>Thuận khí theo lịch âm, tránh các trực xấu hoặc ngày có sao chiếu không tốt cho cưới
                                    hỏi.</li>
                                <li>Chọn giờ đẹp giúp mọi việc diễn ra đúng kế hoạch, hạn chế rủi ro</li>
                            </ul>
                            <p class="mb-1">Ngày dạm ngõ đẹp không đảm bảo “mọi thứ đều hoàn hảo”, nhưng giúp bạn giảm
                                bớt lo lắng, tạo đà may mắn ngay từ buổi gặp đầu tiên.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Cách Xem Ngày Dạm Ngõ Đơn Giản, Dễ Hiểu
                            </h2>
                            <p class="mb-1">Bạn có thể tự xem theo các tiêu chí cơ bản hoặc dùng công cụ xem ngày dạm ngõ
                                để tiết kiệm thời gian. Dưới đây là những yếu tố cần chú ý:</p>
                            <ul style="	list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Ưu tiên ngày Hoàng Đạo và trực thuận
                                    </h3>
                                    <p class="mb-1">Ngày Hoàng Đạo, trực Khai – Thành – Mãn – Định thường là những ngày
                                        cát cho
                                        hôn sự.</p>
                                </li>
                                <li>

                                    <h3 class="title-tong-quan-h4-log">
                                        Tránh ngày xung tuổi cô dâu – chú rể
                                    </h3>
                                    <ul class="mb-1">
                                        <li>Tránh ngày lục xung, lục hại theo tuổi.</li>
                                        <li>Nếu một trong hai bạn thuộc tuổi kỵ ngày nào đó, nên loại bỏ luôn.</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Xét ngũ hành ngày – tuổi
                                    </h3>
                                    <p class="mb-1">Ngày hợp tuổi sẽ mang lại sự hòa hợp cho buổi gặp gỡ:</p>
                                    <ul class="mb-1">
                                        <li>Ngũ hành tương sinh</li>
                                        <li>Thiên can – địa chi tương hỗ</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Chọn giờ đẹp
                                    </h3>
                                    <p class="mb-1">Giờ Hoàng Đạo sẽ thuận lợi cho việc xuất hành, trao lễ và trò chuyện
                                        giữa hai
                                        họ.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Hợp lịch của cả hai gia đình
                                    </h3>
                                    <p class="mb-1">Một ngày đẹp về phong thủy nhưng gia đình không tiện tham dự cũng sẽ
                                        mất đi ý
                                        nghĩa. Vì vậy, nên thống nhất lịch trước, sau đó chọn trong các ngày đẹp phù hợp.
                                    </p>
                                </li>
                            </ul>





                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Những Điểm Lợi Khi Chọn Đúng Ngày Dạm Ngõ
                            </h2>
                            <ul class="mb-1">
                                <li>Không khí buổi lễ tự nhiên, vui vẻ, tránh những điều kiêng kỵ theo tuổi.</li>
                                <li>Hai họ nói chuyện thuận lợi, dễ đi đến thống nhất về ngày ăn hỏi – ngày cưới.</li>
                                <li>Tượng trưng cho lời mở đầu suôn sẻ, mang ý nghĩa may mắn cho cả hành trình sau này.</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi Chọn Ngày Dạm Ngõ, Nên Tránh Những Điều Nào?
                            </h2>
                            <ul class="mb-1">
                                <li>Ngày Hắc Đạo, thụ tử, sát chủ</li>
                                <li>Ngày lục xung – lục hại theo tuổi</li>
                                <li>Ngày có sao xấu cho hôn nhân: Nguyệt Hư, Nguyệt Hình, Thiên Cương…</li>
                                <li>Tránh ngày quá sát ngày cưới để không bị “gấp gáp”</li>
                                <li>Tránh ngày gia đình không thuận tiện (đám giỗ, việc kiêng kỵ riêng)</li>
                            </ul>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Sử Dụng Công Cụ Xem Ngày Dạm Ngõ Tại Phong Lịch
                            </h2>
                            <p class="mb-1">Công cụ giúp bạn:</p>
                            <ul class="mb-1">
                                <li>Chọn ngày đẹp theo tuổi cô dâu – chú rể</li>
                                <li>Xem mức độ tốt/xấu của từng ngày</li>
                                <li>Gợi ý giờ đẹp</li>
                                <li>Hiển thị chi tiết Ngọc Hạp, Nhị Thập Bát Tú, Thập Nhị Trực…</li>
                                <li>Lọc ngày theo tháng bạn mong muốn</li>
                            </ul>
                            <p class="mb-1">Bạn chỉ cần chọn tuổi, tháng dự định dạm ngõ, hệ thống sẽ trả về danh sách
                                ngày tốt nhất để bạn và gia đình tham khảo.</p>
                        </div>
                    </div>

                </div>
                @include('tools.siderbarindex')
            </div>
        </div>
    </div>




    {{-- Hiển thị kết quả qua AJAX sẽ xuất hiện trong resultsContainer --}}
@endsection

@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script src="{{ asset('/js/vanilla-daterangepicker.js?v=6.8') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Initialize Groom date picker
            const groomDatePicker = new LunarSolarDateSelect({
                daySelectId: 'groomDay',
                monthSelectId: 'groomMonth',
                yearSelectId: 'groomYear',
                hiddenInputId: 'groomDobHidden',
                solarRadioId: 'groomSolar',
                lunarRadioId: 'groomLunar',
                leapCheckboxId: 'groomLeapMonth',
                leapContainerId: 'groomLeapMonthContainer',
                defaultDay: 1,
                defaultMonth: 1,
                defaultYear: 2000,
                yearRangeStart: 1900,
                yearRangeEnd: new Date().getFullYear(),
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                csrfToken: csrfToken
            });

            // Initialize Bride date picker
            const brideDatePicker = new LunarSolarDateSelect({
                daySelectId: 'brideDay',
                monthSelectId: 'brideMonth',
                yearSelectId: 'brideYear',
                hiddenInputId: 'brideDobHidden',
                solarRadioId: 'brideSolar',
                lunarRadioId: 'brideLunar',
                leapCheckboxId: 'brideLeapMonth',
                leapContainerId: 'brideLeapMonthContainer',
                defaultDay: 1,
                defaultMonth: 1,
                defaultYear: 2000,
                yearRangeStart: 1900,
                yearRangeEnd: new Date().getFullYear(),
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                csrfToken: csrfToken
            });

            // Set initial values if exist
            const groomValue = document.getElementById('groomDobHidden').value;
            if (groomValue) {
                const parts = groomValue.split('/');
                if (parts.length === 3) {
                    groomDatePicker.setDate(parseInt(parts[0]), parseInt(parts[1]), parseInt(parts[2]));
                }
            }

            const brideValue = document.getElementById('brideDobHidden').value;
            if (brideValue) {
                const parts = brideValue.split('/');
                if (parts.length === 3) {
                    brideDatePicker.setDate(parseInt(parts[0]), parseInt(parts[1]), parseInt(parts[2]));
                }
            }

            // ========== DATE RANGE PICKER ==========
            // Initialize vanilla daterangepicker for wedding_date_range
            const dateRangeInput = document.getElementById('wedding_date_range');
            let dateRangePickerInstance = null;
            let dateRangeInitAttempts = 0;
            const maxDateRangeAttempts = 10;

            function initDateRangePicker() {
                if (dateRangeInitAttempts >= maxDateRangeAttempts) {
                    console.warn('VanillaDateRangePicker could not be loaded after ' + maxDateRangeAttempts +
                        ' attempts');
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

                        console.log('Date range picker initialized successfully');
                    } catch (error) {
                        console.error('Error initializing date range picker:', error);
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

                // Restore groom calendar type from hash first
                if (params.groom_calendar_type) {
                    const groomSolarRadio = document.getElementById('groomSolar');
                    const groomLunarRadio = document.getElementById('groomLunar');

                    if (params.groom_calendar_type === 'lunar' && groomLunarRadio) {
                        groomLunarRadio.checked = true;
                        groomSolarRadio.checked = false;
                        if (groomDatePicker) {
                            groomDatePicker.isLunar = true;
                        }
                    } else if (params.groom_calendar_type === 'solar' && groomSolarRadio) {
                        groomSolarRadio.checked = true;
                        groomLunarRadio.checked = false;
                        if (groomDatePicker) {
                            groomDatePicker.isLunar = false;
                        }
                    }
                }

                // Restore bride calendar type from hash first
                if (params.bride_calendar_type) {
                    const brideSolarRadio = document.getElementById('brideSolar');
                    const brideLunarRadio = document.getElementById('brideLunar');

                    if (params.bride_calendar_type === 'lunar' && brideLunarRadio) {
                        brideLunarRadio.checked = true;
                        brideSolarRadio.checked = false;
                        if (brideDatePicker) {
                            brideDatePicker.isLunar = true;
                        }
                    } else if (params.bride_calendar_type === 'solar' && brideSolarRadio) {
                        brideSolarRadio.checked = true;
                        brideLunarRadio.checked = false;
                        if (brideDatePicker) {
                            brideDatePicker.isLunar = false;
                        }
                    }
                }

                if (params.groom || params.bride || params.khoang) {
                    let formRestored = false;
                    let groomSet = false;
                    let brideSet = false;
                    let dateRangeSet = false;

                    if (params.groom) {
                        // Use the dateSelector's method to properly restore and convert the date
                        function tryRestoreGroomBirthdate(attempts = 0) {
                            const maxAttempts = 20;

                            if (attempts >= maxAttempts) {
                                groomSet = true;
                                checkAndSubmitForm();
                                return;
                            }

                            // Check if groomDatePicker is available and fully initialized
                            if (groomDatePicker && groomDatePicker.daySelect && groomDatePicker.monthSelect &&
                                groomDatePicker.yearSelect &&
                                groomDatePicker.yearSelect.options.length > 1) {

                                // Parse birthdate from URL (always in solar format from URL)
                                const dateParts = params.groom.split('/');
                                if (dateParts.length === 3) {
                                    const day = parseInt(dateParts[0]);
                                    const month = parseInt(dateParts[1]);
                                    const year = parseInt(dateParts[2]);

                                    (async () => {
                                        try {
                                            // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                                            if (params.groom_calendar_type === 'lunar') {
                                                await groomDatePicker.setDate(day, month, year, false,
                                                    false);
                                                const lunarRadio = document.getElementById('groomLunar');
                                                if (lunarRadio) {
                                                    lunarRadio.checked = true;
                                                    await groomDatePicker.handleLunarRadioChange();
                                                }
                                            } else {
                                                await groomDatePicker.setDate(day, month, year, false,
                                                    false);
                                                const solarRadio = document.getElementById('groomSolar');
                                                if (solarRadio) {
                                                    solarRadio.checked = true;
                                                    groomDatePicker.isLunar = false;
                                                }
                                            }

                                            await groomDatePicker.updateHiddenInput();
                                            groomSet = true;
                                            checkAndSubmitForm();
                                        } catch (error) {
                                            groomSet = true;
                                            checkAndSubmitForm();
                                        }
                                    })();
                                } else {
                                    groomSet = true;
                                    checkAndSubmitForm();
                                }
                            } else {
                                // DateSelector not ready yet, try again
                                setTimeout(() => tryRestoreGroomBirthdate(attempts + 1), 300);
                            }
                        }

                        tryRestoreGroomBirthdate();
                    } else {
                        groomSet = true;
                    }

                    if (params.bride) {
                        // Use the dateSelector's method to properly restore and convert the date
                        function tryRestoreBrideBirthdate(attempts = 0) {
                            const maxAttempts = 20;

                            if (attempts >= maxAttempts) {
                                brideSet = true;
                                checkAndSubmitForm();
                                return;
                            }

                            // Check if brideDatePicker is available and fully initialized
                            if (brideDatePicker && brideDatePicker.daySelect && brideDatePicker.monthSelect &&
                                brideDatePicker.yearSelect &&
                                brideDatePicker.yearSelect.options.length > 1) {

                                // Parse birthdate from URL (always in solar format from URL)
                                const dateParts = params.bride.split('/');
                                if (dateParts.length === 3) {
                                    const day = parseInt(dateParts[0]);
                                    const month = parseInt(dateParts[1]);
                                    const year = parseInt(dateParts[2]);

                                    (async () => {
                                        try {
                                            // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                                            if (params.bride_calendar_type === 'lunar') {
                                                await brideDatePicker.setDate(day, month, year, false,
                                                    false);
                                                const lunarRadio = document.getElementById('brideLunar');
                                                if (lunarRadio) {
                                                    lunarRadio.checked = true;
                                                    await brideDatePicker.handleLunarRadioChange();
                                                }
                                            } else {
                                                await brideDatePicker.setDate(day, month, year, false,
                                                    false);
                                                const solarRadio = document.getElementById('brideSolar');
                                                if (solarRadio) {
                                                    solarRadio.checked = true;
                                                    brideDatePicker.isLunar = false;
                                                }
                                            }

                                            await brideDatePicker.updateHiddenInput();
                                            brideSet = true;
                                            checkAndSubmitForm();
                                        } catch (error) {
                                            brideSet = true;
                                            checkAndSubmitForm();
                                        }
                                    })();
                                } else {
                                    brideSet = true;
                                    checkAndSubmitForm();
                                }
                            } else {
                                // DateSelector not ready yet, try again
                                setTimeout(() => tryRestoreBrideBirthdate(attempts + 1), 300);
                            }
                        }

                        tryRestoreBrideBirthdate();
                    } else {
                        brideSet = true;
                    }

                    if (params.khoang) {
                        // Set date range
                        setTimeout(() => {
                            const khoangInput = document.getElementById('wedding_date_range');
                            if (khoangInput) {
                                khoangInput.value = params.khoang;
                                dateRangeSet = true;
                                checkAndSubmitForm();
                            }
                        }, 500);
                    } else {
                        dateRangeSet = true;
                    }

                    // Function to check if all fields are set and submit form
                    function checkAndSubmitForm() {
                        if (groomSet && brideSet && dateRangeSet && !formRestored) {
                            formRestored = true;
                            // Auto submit form after a short delay
                            setTimeout(() => {
                                const form = document.querySelector('form');
                                if (form) {
                                    form.requestSubmit();
                                }
                            }, 1000);
                        }
                    }
                }
            }

            // Restore form from hash on page load
            setTimeout(restoreFromHash, 1000);

            // ========== AJAX FORM SUBMISSION ==========
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get groom birthdate value
                const groomDobInput = document.getElementById('groomDobHidden');
                const groomDobValue = groomDobInput.value;

                if (!groomDobValue) {
                    alert('Vui lòng chọn đầy đủ ngày sinh chú rể');
                    return;
                }

                // Get bride birthdate value
                const brideDobInput = document.getElementById('brideDobHidden');
                const brideDobValue = brideDobInput.value;

                if (!brideDobValue) {
                    alert('Vui lòng chọn đầy đủ ngày sinh cô dâu');
                    return;
                }

                // Get date range value
                const dateRangeValue = dateRangeInput.value;

                if (!dateRangeValue) {
                    alert('Vui lòng chọn khoảng thời gian dự định cưới');
                    return;
                }

                // Get the groom date based on calendar type
                let formattedGroomDob = '';
                let urlGroomDob = '';
                let groomCalendarType = 'solar';
                let groomIsLeapMonth = false;

                // Determine groom calendar type from radio buttons
                const groomSolarRadio = document.getElementById('groomSolar');
                const groomLunarRadio = document.getElementById('groomLunar');
                if (groomLunarRadio && groomLunarRadio.checked) {
                    groomCalendarType = 'lunar';
                } else if (groomSolarRadio && groomSolarRadio.checked) {
                    groomCalendarType = 'solar';
                }

                // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                if (groomCalendarType === 'lunar') {
                    const {
                        solarDay,
                        solarMonth,
                        solarYear
                    } = groomDobInput.dataset;
                    const groomMonthSelect = document.getElementById('groomMonth');
                    const selectedOption = groomMonthSelect.options[groomMonthSelect.selectedIndex];
                    groomIsLeapMonth = selectedOption?.dataset.isLeap === '1';

                    formattedGroomDob = groomDobValue;
                    urlGroomDob = (solarDay && solarMonth && solarYear) ?
                        `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}` :
                        groomDobValue;
                } else {
                    formattedGroomDob = groomDobValue;
                    urlGroomDob = groomDobValue;
                }

                // Get the bride date based on calendar type
                let formattedBrideDob = '';
                let urlBrideDob = '';
                let brideCalendarType = 'solar';
                let brideIsLeapMonth = false;

                // Determine bride calendar type from radio buttons
                const brideSolarRadio = document.getElementById('brideSolar');
                const brideLunarRadio = document.getElementById('brideLunar');
                if (brideLunarRadio && brideLunarRadio.checked) {
                    brideCalendarType = 'lunar';
                } else if (brideSolarRadio && brideSolarRadio.checked) {
                    brideCalendarType = 'solar';
                }

                // ========== SOLAR DATE UPDATE IS HANDLED BY LunarSolarDateSelect MODULE ==========
                if (brideCalendarType === 'lunar') {
                    const {
                        solarDay,
                        solarMonth,
                        solarYear
                    } = brideDobInput.dataset;
                    const brideMonthSelect = document.getElementById('brideMonth');
                    const selectedOption = brideMonthSelect.options[brideMonthSelect.selectedIndex];
                    brideIsLeapMonth = selectedOption?.dataset.isLeap === '1';

                    formattedBrideDob = brideDobValue;
                    urlBrideDob = (solarDay && solarMonth && solarYear) ?
                        `${String(solarDay).padStart(2, '0')}/${String(solarMonth).padStart(2, '0')}/${solarYear}` :
                        brideDobValue;
                } else {
                    formattedBrideDob = brideDobValue;
                    urlBrideDob = brideDobValue;
                }

                // Parse date range
                const dateRangeParts = dateRangeValue.split(' - ');
                let startDate = '';
                let endDate = '';

                if (dateRangeParts.length === 2) {
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

                // Prepare form data
                const formData = {
                    groom_dob: formattedGroomDob,
                    bride_dob: formattedBrideDob,
                    wedding_date_range: dateRangeValue,
                    _token: csrfToken
                };

                // Set hash parameters for URL state
                const hashParams = {
                    groom: urlGroomDob, // Use solar date for URL (easier to share)
                    bride: urlBrideDob, // Use solar date for URL (easier to share)
                    khoang: dateRangeValue,
                    groom_calendar_type: groomCalendarType,
                    bride_calendar_type: brideCalendarType
                };
                setHashParams(hashParams);

                // Show loading state
                submitBtn.disabled = true;
                btnText.textContent = 'Đang xử lý...';
                spinner.classList.remove('d-none');

                // Submit via AJAX
                fetch('{{ route('dam-ngo.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
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
                            resultsContainer.style.display = 'block';

                            setTimeout(() => {
                                resultsContainer.innerHTML = data.html;

                                // Cập nhật window.resultsByYear cho global access
                                if (data.resultsByYear) {
                                    window.resultsByYear = data.resultsByYear;
                                }

                                setTimeout(() => {
                                    if (typeof window.initTabooFilter === 'function') {
                                        window.initTabooFilter(data.resultsByYear);
                                    }
                                    initPagination();
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

                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });

                            // Add event listener for sort select change
                            const sortSelects = resultsContainer.querySelectorAll('[name="sort"]');
                            sortSelects.forEach(select => {
                                select.addEventListener('change', function() {
                                    // Create form data with current values and new sort order
                                    const newFormData = {
                                        groom_dob: formattedGroomDob,
                                        bride_dob: formattedBrideDob,
                                        wedding_date_range: dateRangeValue,
                                        sort: this.value,
                                        _token: csrfToken
                                    };

                                    // Submit with new sort order
                                    fetch('{{ route('astrology.check') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken,
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify(newFormData)
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                resultsContainer.innerHTML = data
                                                    .html;

                                                // Cập nhật window.resultsByYear cho global access
                                                if (data.resultsByYear) {
                                                    window.resultsByYear = data
                                                        .resultsByYear;
                                                }

                                                // Re-initialize filter
                                                if (data.resultsByYear &&
                                                    typeof initTabooFilter ===
                                                    'function') {
                                                    setTimeout(() => {
                                                        initTabooFilter(data
                                                            .resultsByYear
                                                        );
                                                    }, 200);
                                                }

                                                // Re-initialize tabs
                                                const newTabs = resultsContainer
                                                    .querySelectorAll(
                                                        '[data-bs-toggle="tab"]');
                                                newTabs.forEach(tab => {
                                                    new bootstrap.Tab(tab);
                                                });

                                                // Re-add sort event listeners recursively
                                                const newSortSelects =
                                                    resultsContainer
                                                    .querySelectorAll(
                                                        '[name="sort"]');
                                                newSortSelects.forEach(
                                                    newSelect => {
                                                        newSelect
                                                            .addEventListener(
                                                                'change',
                                                                arguments.callee
                                                            );
                                                    });
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Sort error:', error);
                                        });
                                });
                            });
                        } else if (data.errors) {
                            let errorMessage = 'Vui lòng kiểm tra lại:\n';
                            for (const field in data.errors) {
                                errorMessage += '- ' + data.errors[field][0] + '\n';
                            }
                            alert(errorMessage);
                        } else if (data.message) {
                            alert(data.message);
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

            // Sort function - follow mua-xe pattern
            function applySortingToTable(sortValue, year) {
                // Tìm tab hiện tại hoặc sử dụng year parameter
                let activeTab = document.querySelector('.tab-pane.show.active');
                if (!activeTab && year) {
                    activeTab = document.querySelector(`#year-${year}`);
                }
                if (!activeTab) {
                    console.log('No active tab found');
                    return;
                }

                // Tìm table trong tab hiện tại
                const table = activeTab.querySelector('#bang-chi-tiet table tbody');
                if (!table) {
                    console.log('No table found for sorting in active tab');
                    return;
                }

                const rows = Array.from(table.querySelectorAll('tr'));
                console.log(`Found ${rows.length} rows to sort in tab ${activeTab.id}`);

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

                // Clear table and re-append sorted rows
                table.innerHTML = '';
                rows.forEach(row => table.appendChild(row));

                // Maintain current pagination - pass year parameter
                const currentYear = activeTab.id.replace('year-', '');
                maintainCurrentPagination(table, currentYear);
            }

            // Event delegation for sorting - follow mua-xe pattern
            const resultContainer = document.querySelector('.--detail-success');
            resultContainer.addEventListener('change', function(event) {
                if (event.target.matches('[name="sort"]')) {
                    console.log('Sort changed to:', event.target.value);

                    // Tìm năm hiện tại từ tab active
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    const currentYear = activeTab ? activeTab.id.replace('year-', '') : null;

                    applySortingToTable(event.target.value, currentYear);
                    setTimeout(() => {
                        const bangChiTiet = activeTab?.querySelector('#bang-chi-tiet');
                        bangChiTiet?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });

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

            function getScoreFromRow(row) {
                // Dam-ngo có 2 battery cho chú rể và cô dâu, lấy tổng điểm
                const batteries = row.querySelectorAll('.battery-label');
                if (batteries.length >= 2) {
                    const groomScore = parseInt(batteries[0].textContent.replace('%', '')) || 0;
                    const brideScore = parseInt(batteries[1].textContent.replace('%', '')) || 0;
                    return groomScore + brideScore;
                }
                return 0;
            }

            function getDateFromRow(row) {
                // Try different ways to find the date - same as mua-xe

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

            function maintainCurrentPagination(table, year) {
                // Follow mua-xe pattern - simpler approach
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
                    // Kiểm tra xem row có bị ẩn bởi filter không (có thể check attribute hoặc class)
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
                console.log(
                    `DEBUG BUTTON: totalFilteredRows=${totalFilteredRows}, currentLoaded=${currentLoaded}, remaining=${remaining}`
                );

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
