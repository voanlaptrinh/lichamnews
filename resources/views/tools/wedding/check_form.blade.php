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
                    Xem ngày kết hôn
                </li>
            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem ngày tốt cưới hỏi, kết hôn theo tuổi</h1>
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
                                        style=" background-image: url(../images/form_kethon.svg);
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
                                Vì sao trong cưới hỏi cần xem ngày tốt?
                            </h2>
                            <p class="mb-1">Trong văn hóa Á Đông, cưới hỏi không chỉ là việc trọng đại của hai người mà
                                còn là sự hòa hợp giữa hai gia đình, là bước khởi đầu cho một cuộc sống mới. Vì vậy, việc
                                chọn một ngày tốt cho lễ cưới, ăn hỏi, dạm ngõ… được xem là cách để cầu mong hạnh phúc viên
                                mãn, cuộc sống vợ chồng hòa thuận, làm ăn thuận lợi và gia đạo bình an.
                            </p>
                            <p class="mb-1">Không ít người nghĩ xem ngày cưới hỏi chỉ mang tính phong tục, nhưng thực tế
                                nó còn mang lại 3 giá trị quan trọng:</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                1. Tạo sự yên tâm cho hai bên gia đình
                            </h3>
                            <p class="mb-1">Khi ngày cưới đã được chọn kỹ lưỡng, mọi người đều cảm thấy an lòng. Sự đồng
                                thuận và tinh thần thoải mái giúp không khí chuẩn bị đám cưới trở nên vui vẻ, tránh được bất
                                đồng hay lo lắng.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                2. Tạo khởi đầu thuận lợi cho đôi trẻ
                            </h3>
                            <p class="mb-1">Một ngày đẹp mang năng lượng tốt lành, tượng trưng cho sự cát tường. Nó giống
                                như một lời chúc phúc để đôi vợ chồng trẻ bắt đầu cuộc sống hôn nhân một cách thuận lợi và
                                tràn đầy niềm vui.
                            </p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                3. Tránh các ngày xung – kỵ không tốt cho hôn nhân
                            </h3>
                            <p class="mb-1">Một số ngày phạm phải sao xấu, ngày xung tuổi, ngày cô thần – quả tú… thường
                                được dân gian khuyên tránh vì có thể mang tính chất không may mắn. Việc xem ngày giúp bạn
                                loại bỏ những ngày này để mọi nghi lễ được suôn sẻ.
                            </p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Ý nghĩa phong tục xem ngày cưới hỏi
                            </h2>
                            <p class="mb-1">Xem ngày cưới hỏi dựa trên những yếu tố phong thủy truyền thống như:
                            </p>
                            <ul class="mb-1">
                                <li>
                                    Ngũ hành – Can Chi giữa tuổi cô dâu chú rể
                                </li>
                                <li>
                                    Sao tốt – sao xấu trong ngày
                                </li>
                                <li>
                                    Hoàng đạo – hắc đạo
                                </li>
                                <li>
                                    Nhị Thập Bát Tú liên quan đến hôn sự
                                </li>
                                <li>
                                    Trực ngày hợp với cưới gả
                                </li>
                                <li>
                                    Tránh các ngày xấu: Tam nương, Nguyệt kỵ, Không phòng, Sát chủ, v.v.
                                </li>
                            </ul>
                            <p class="mb-1">
                                Những yếu tố này được dùng không phải vì mê tín, mà bởi chúng là sự tổng hợp kinh nghiệm từ
                                hàng trăm năm, thể hiện mong muốn điều tốt lành, tránh điều không may.
                            </p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi xem ngày cưới hỏi cần xét những yếu tố có lợi
                            </h2>
                            <p class="mb-1">
                                Dưới đây là các yếu tố cát (tốt) mà ngày cưới hỏi nên có:
                            </p>
                            <ul style="	list-style-type: decimal;">
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Ngày hoàng đạo
                                    </h3>
                                    <p class="mb-1">
                                        Hoàng đạo là ngày được coi là có năng lượng tốt, rất thích hợp cho việc vui mừng và
                                        lễ nghi
                                        gia đình.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Ngày hợp tuổi cô dâu – chú rể
                                    </h3>
                                    <p class="mb-1">
                                        Ngày có Can Chi – Ngũ Hành tương sinh với tuổi hai người sẽ mang ý nghĩa hòa hợp,
                                        thuận lợi
                                        cho hôn nhân.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Sao tốt liên quan đến hôn sự
                                    </h3>
                                    <p class="mb-1">
                                        Một số sao cát đặc biệt tốt cho cưới hỏi, ví dụ như:
                                    </p>
                                    <ul class="mb-1">
                                        <li>
                                            Sao Thiên Đức, Nguyệt Đức
                                        </li>
                                        <li>
                                            Sao Thiên Hỷ
                                        </li>
                                        <li>
                                            Sao Thiên Quan, Thiên Phúc
                                        </li>
                                        <li>
                                            Sao Tam Hợp
                                        </li>
                                    </ul>
                                    <p class="mb-1">Những sao này tượng trưng cho hỷ khí, hạnh phúc và sự viên mãn.</p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Trực ngày phù hợp
                                    </h3>
                                    <p class="mb-1">
                                        Trong Thập Nhị Trực, những trực cát cho cưới hỏi gồm:
                                    </p>
                                    <ul class="mb-1">
                                        <li>
                                            Trực Thành
                                        </li>
                                        <li>
                                            Trực Khai
                                        </li>
                                        <li>
                                            Trực Mãn
                                        </li>
                                    </ul>
                                </li>
                            </ul>


                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Những yếu tố bất lợi cần tránh khi chọn ngày cưới hỏi
                            </h2>
                            <p class="mb-1">Để lễ cưới diễn ra suôn sẻ, bạn cũng nên tránh những yếu tố hung:</p>
                            <ul style="	list-style-type: decimal;">
                                <li>

                                    <h3 class="title-tong-quan-h4-log">
                                        Ngày xung tuổi cô dâu – chú rể
                                    </h3>
                                    <p class="mb-1">Ngày phạm hình – xung – phá – hại với tuổi hai người thường được coi
                                        là kỵ.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Ngày Tam Nương – Nguyệt Kỵ
                                    </h3>
                                    <p class="mb-1">Dân gian xem đây là những ngày mang năng lượng xấu, không phù hợp để
                                        tiến
                                        hành việc vui.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Sao xấu liên quan đến hôn nhân
                                    </h3>
                                    <p class="mb-1">Ví dụ: Cô Thần, Quả Tú, Không Vong, Thiên Cương, v.v.
                                    </p>
                                </li>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Trực xấu hoặc ngày hắc đạo
                                    </h3>
                                    <p class="mb-1">Những ngày này mang ý nghĩa không thuận, nên hạn chế.
                                    </p>
                                </li>
                            </ul>




                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Cách sử dụng công cụ Xem Ngày Cưới Hỏi tại Phong Lịch
                            </h2>
                            <p class="mb-1">Công cụ được thiết kế đơn giản để ai cũng có thể tự xem:</p>
                            <ul>
                                <li>
                                    <h3 class="title-tong-quan-h4-log">
                                        Bước 1: Nhập tuổi cô dâu – chú rể
                                    </h3>
                                    <p class="mb-1">Hệ thống tự động đối chiếu tuổi theo âm lịch hoặc dương lịch, phân
                                        tích Can
                                        Chi và ngũ hành để tìm ngày hợp nhất.
                                    </p>
                                </li>
                                <li>

                            <h3 class="title-tong-quan-h4-log">
                                Bước 2: Chọn khoảng thời gian dự định tổ chức
                            </h3>
                            <p class="mb-1">Bạn chỉ cần chọn tháng hoặc thời gian mong muốn, hệ thống sẽ lọc ra những
                                ngày đẹp nhất.
                            </p>
                                </li>
                                <li>
 <h3 class="title-tong-quan-h4-log">
                                Bước 3: Nhận danh sách ngày tốt kèm phân tích chi tiết
                            </h3>
                            <p class="mb-1">Mỗi ngày đều có:
                            </p>
                            <ul class="mb-1">
                                <li>Đánh giá mức độ đẹp</li>
                                <li>Các sao tốt – xấu</li>
                                <li>Trực ngày</li>
                                <li>Giờ hoàng đạo</li>
                                <li>Những lưu ý quan trọng</li>
                                <li>Gợi ý linh hoạt nếu muốn dời ngày</li>
                            </ul>
                                </li>
                                <li>

                            <h3 class="title-tong-quan-h4-log">
                                Bước 4: Chọn ngày phù hợp nhất cho hai gia đình
                            </h3>
                            <p class="mb-1">Bạn có thể so sánh nhiều ngày để chọn thời điểm vừa đẹp vừa phù hợp với lịch
                                trình tổ chức.
                            </p>
                                </li>
                            </ul>


                           
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Kết luận
                            </h2>
                            <p class="mb-1">Chọn ngày cưới hỏi không chỉ là một nghi thức truyền thống, mà còn là cách
                                tạo sự an tâm và khởi đầu tốt đẹp cho đôi vợ chồng trẻ. Khi hiểu rõ ý nghĩa của việc xem
                                ngày và biết cách chọn, bạn sẽ cảm thấy tự tin hơn trong quá trình chuẩn bị lễ cưới.
                            </p>
                            <p class="mb-1">
                                Tính năng Xem Ngày Cưới Hỏi của Phong Lịch giúp bạn dễ dàng:
                            </p>
                            <ul class="mb-1">
                                <li>Chọn ngày đẹp hợp tuổi</li>
                                <li>Tránh ngày xấu</li>
                                <li>Hiểu vì sao một ngày phù hợp hoặc không</li>
                                <li>Chuẩn bị lễ cưới trọn vẹn và thuận lợi nhất</li>
                            </ul>
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
                fetch('{{ route('astrology.check') }}', {
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
                            // resultsContainer.scrollIntoView({
                            //     behavior: 'smooth',
                            //     block: 'start'
                            // });

                            const tabs = resultsContainer.querySelectorAll('[data-bs-toggle="tab"]');
                            tabs.forEach(tab => {
                                new bootstrap.Tab(tab);
                            });

                            // Add event listener for sort select change - follow mua-xe pattern
                            const resultContainer = document.querySelector('.--detail-success');
                            resultContainer.addEventListener('change', function(event) {
                                if (event.target.matches('[name="sort"]')) {
                                    console.log('Sort changed to:', event.target.value);
                                    applySortingToTable(event.target.value);
                                    setTimeout(() => {
                                        const bangChiTiet = document.querySelector(
                                            '#bang-chi-tiet');
                                        bangChiTiet?.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                    }, 100);
                                }
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
            function applySortingToTable(sortValue) {
                // Get active tab first to determine which table to sort
                const activeTabPane = document.querySelector('.tab-pane.show.active');
                if (!activeTabPane) {
                    console.log('No active tab found');
                    return;
                }

                const activeYear = activeTabPane.id.replace('year-', '');
                console.log(`Sorting table for active year: ${activeYear}`);

                // Find table within the active tab pane
                let table = activeTabPane.querySelector('#bang-chi-tiet table tbody');
                if (!table) {
                    table = activeTabPane.querySelector(`#table-${activeYear} tbody`);
                }
                if (!table) {
                    table = activeTabPane.querySelector('.table tbody');
                }

                if (!table) {
                    console.log(`No table found for sorting in year ${activeYear}`);
                    return;
                }

                console.log(`Found table for year ${activeYear}:`, table);

                const rows = Array.from(table.querySelectorAll('tr'));
                console.log(`Found ${rows.length} rows to sort`);

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

                // Maintain current pagination - pass table parameter and year for specificity
                maintainCurrentPagination(table, activeYear);
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

            function getScoreFromRow(row) {
                // Wedding có 2 battery cho chú rể và cô dâu, lấy tổng điểm
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

            function maintainCurrentPagination(table, activeYear = null) {
                // Follow mua-xe pattern - simpler approach
                console.log(`Maintaining pagination for year: ${activeYear || 'unknown'}`);

                // Find load more button specific to the year if available
                let loadMoreBtn = null;
                if (activeYear) {
                    const tabPane = document.querySelector(`#year-${activeYear}`);
                    if (tabPane) {
                        loadMoreBtn = tabPane.querySelector('.load-more-btn');
                    }
                }

                // Fallback to table's closest load more button
                if (!loadMoreBtn) {
                    loadMoreBtn = table.closest('.card-body').querySelector('.load-more-btn');
                }
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
                    console.log(`DEBUG BUTTON: Hiding button - no remaining items`);
                }
            }

        });
    </script>
    @include('components.taboo-filter-script')
@endpush
