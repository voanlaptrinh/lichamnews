@extends('welcome')

@section('content')
 



    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.6') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Tiện ích</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thần số học
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Thần số học</h1>
        <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

            <div class="col-xl-9 col-sm-12 col-12 ">
                <div class="backv-doi-lich ">
                    <div class="row g-xl-5 g-lg-3 g-sm-5">
                        <div class="col-lg-8">
                            <div class="">
                                <div class="form--submit-totxau">
                                    <div class="--text-down-convert" style="color: rgba(25, 46, 82, 1);">
                                        Thông tin người
                                        xem
                                    </div>
                                    <p class="mb-2" style=" font-size: 14px; color: #212121;">Vui lòng điền họ tên, ngày
                                        sinh và khoảng thời gian cần xem ngày tốt vào các ô dưới đây.</p>


                                    <form action="{{ route('numerology.calculate') }}" method="POST" id="numerologyForm">
                                        @csrf
                                        <div class="row">
                                            <!-- Name field -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #212121CC">Tên người
                                                    xem</label>

                                                <input type="text" class="form-control --border-box-form @error('full_name') is-invalid @enderror" id="full_name"
                                                    name="full_name" placeholder="Nhập tên của bạn"
                                                    value="{{ old('full_name') }}"
                                                    style="border-radius: 10px; border: none; padding: 12px 15px; background-color: rgba(255,255,255,0.95);">
                                                @error('full_name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>




                                            <div class="mb-3">
                                                <!-- Date Selects -->
                                                <label class="form-label fw-bold" style="color: #212121CC">Ngày tháng
                                                    năm sinh</label>
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
                                                        <input type="radio" class="form-check-input" name="calendar_type"
                                                            id="solarCalendar" value="solar" checked
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="solarCalendar"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Dương lịch
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="calendar_type"
                                                            id="lunarCalendar" value="lunar"
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="lunarCalendar"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Âm lịch
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Leap Month Option (hidden) -->
                                                <div class="form-check mt-2" id="leapMonthContainer" style="display: none;">
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
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
   <div class="mb-3">
                                                 <label class="form-label fw-bold" style="color: #212121CC">Giới tính</label>
                                            
                                                <div class="d-flex gap-4 ps-2">
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            id="maleGender" value="nam" {{ old('gender', 'nam') == 'nam' ? 'checked' : '' }}
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="maleGender"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Nam
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            id="femaleGender" value="nữ" {{ old('gender') == 'nữ' ? 'checked' : '' }}
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="femaleGender"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Nữ
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('gender')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn fw-bold btnd-nfay"
                                                style="background: #115097" id="submitBtn">
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
                                    style=" background-image: url(../images/form_thansohoc.svg);
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
               
                <div class="box--bg-thang mt-3 mb-3">
                    <div class="text-box-tong-quan">
                        <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                            Vì sao khai trương cần xem ngày tốt?
                        </h2>
                        <p class="mb-1">
                            Khai trương là thời điểm bắt đầu một hành trình kinh doanh mới: mở cửa hàng, công ty, văn
                            phòng hay một dịch vụ lớn nhỏ. Đây không chỉ là nghi lễ mà còn là lời cầu chúc cho tài lộc
                            hanh thông, khách hàng tấp nập, công việc thuận buồm xuôi gió.
                        </p>
                        <p class="mb-1">
                            Vì vậy, việc xem ngày khai trương mang ý nghĩa:
                        </p>
                        <ul class="mb-3">
                            <li>Tạo khí thế tốt ngay từ đầu, giúp công việc dễ thu hút may mắn.</li>
                            <li>Tránh ngày xấu có thể mang lại cản trở, chậm trễ hoặc khó khăn ban đầu.</li>
                            <li>Tăng sự tự tin và yên tâm cho chủ cửa hàng, doanh nghiệp khi bắt đầu hoạt động.</li>
                        </ul>
                        <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                            Lợi ích của việc chọn ngày khai trương hợp tuổi
                        </h2>
                        <p class="mb-1">Không phải ngày nào cũng hợp với tất cả mọi người. Việc chọn ngày hợp tuổi
                            giúp bạn:</p>
                        <ul class="mb-3">
                            <li>Hạn chế xung tuổi, tránh những ảnh hưởng không may trong kinh doanh.</li>
                            <li>Chọn được ngày – giờ mang cát khí, tăng khả năng thu hút tài lộc.</li>
                            <li>Mang lại tâm thế thoải mái, tự tin khi bước vào thị trường.</li>
                        </ul>
                        <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                            Khi xem ngày khai trương, cần chú ý điều gì?
                        </h2>
                        <ul style="	list-style-type: upper-alpha;">
                            <li>
                                <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố cát lành nên ưu tiên</h3>
                                <ul class="mb-3">
                                    <li>Ngày hoàng đạo, ngày hợp tuổi chủ kinh doanh.</li>
                                    <li>Trực tốt như Trực Khai (mở đầu), Trực Thành (hoàn thành), Trực Mãn.</li>
                                    <li>Giờ tốt hợp tuổi để tiến hành nghi lễ khai trương và mở cửa đón khách.</li>
                                </ul>
                            </li>
                            <li>
                                <h3 class="title-tong-quan-h4-log fst-italic">Các yếu tố xấu nên tránh</h3>
                                <ul>
                                    <li>Ngày hắc đạo, ngày xung tuổi hoặc phạm Thái Tuế.</li>
                                    <li>Trực xấu như Trực Bế, Trực Phá gây kém suôn sẻ.</li>
                                    <li>Ngày có bách kỵ, đặc biệt là những ngày kỵ mở cửa kinh doanh.</li>
                                </ul>
                            </li>
                        </ul>
                        <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                            Cách sử dụng công cụ Xem Ngày Khai Trương trên Phong Lịch
                        </h2>
                        <ul style="	list-style-type: decimal;">
                            <li>Nhập tuổi của bạn (âm hoặc dương lịch).</li>
                            <li>Chọn khoảng thời gian bạn dự định khai trương.</li>
                            <li>
                                Hệ thống sẽ:
                                <ul>
                                    <li>Gợi ý những ngày khai trương đẹp nhất,</li>
                                    <li>Hiển thị điểm tốt – xấu,</li>
                                    <li>Liệt kê lý do nên chọn hoặc tránh,</li>
                                    <li>Đưa ra các khung giờ tốt để mở hàng.</li>
                                </ul>
                            </li>
                            <li>So sánh lịch hoạt động thực tế để chọn ra ngày hợp tuổi – hợp việc – hợp thời điểm.</li>
                        </ul>
                        <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                            Một ngày khai trương đẹp mang lại điều gì?
                        </h2>
                        <ul>
                            <li>Tinh thần thoải mái, tự tin khi bắt đầu mở cửa.</li>
                            <li>Thuận lợi trong những ngày đầu, dễ “lấy vía” khách hàng.</li>
                            <li>Gia tăng cát khí tài lộc, tạo nền tảng cho việc kinh doanh lâu dài.</li>
                            <li>Hóa giải điều xấu, tránh những trở ngại không đáng có.</li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-xl-3  col-sm-12 col-12 mb-3">
                <div class="d-flex flex-column gap-4 box-siderbar-index mb-3">
                    <!-- ** KHá»I Sá»° KIá»†N Sáº®P Tá»šI ** -->


                    <div class="events-card">
                        <div class="card-title-right title-tong-quan-h5-log content-title-home-lich-right">Tiện ích xem
                            ngày</div>
                        <ul class="list-group list-group-flush events-list">
                            <li class="list-group-item pb-0">
                                <a href="" class="">

                                    <div class="event-details --padding-event-tot">
                                        <div class="event-name" style="font-weight: unset">
                                            Xem ngày tốt xấu
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






    {{-- <div class="container mx-auto px-4 py-8">
       
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                🔮 Thần Số Học
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Khám phá bản chất con người qua các con số. Tìm hiểu số chủ đạo, số tên, biểu đồ ngày sinh và nhiều bí ẩn
                khác về cuộc đời bạn.
            </p>
        </div>

       
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('numerology.calculate') }}" method="POST" id="numerologyForm">
                @csrf

             
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6">
                        <ul class="list-none">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <span class="mr-2">⚠️</span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

               
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="mr-3">👤</span>
                        Thông tin cá nhân
                    </h2>

                 
                    <div class="mb-6">
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Họ và tên đầy đủ *
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Ví dụ: Nguyễn Văn An" required>
                        <p class="text-sm text-gray-500 mt-1">Nhập họ tên tiếng Việt có dấu để kết quả chính xác nhất</p>
                    </div>

                 
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Ngày sinh *
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                           
                            <div>
                                <label for="birth_day" class="block text-xs text-gray-600 mb-1">Ngày</label>
                                <select id="birth_day" name="birth_day"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Chọn ngày</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('birth_day') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                           
                            <div>
                                <label for="birth_month" class="block text-xs text-gray-600 mb-1">Tháng</label>
                                <select id="birth_month" name="birth_month"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Tháng</option>
                                    @php
                                        $months = [
                                            1 => 'Tháng 1',
                                            2 => 'Tháng 2',
                                            3 => 'Tháng 3',
                                            4 => 'Tháng 4',
                                            5 => 'Tháng 5',
                                            6 => 'Tháng 6',
                                            7 => 'Tháng 7',
                                            8 => 'Tháng 8',
                                            9 => 'Tháng 9',
                                            10 => 'Tháng 10',
                                            11 => 'Tháng 11',
                                            12 => 'Tháng 12',
                                        ];
                                    @endphp
                                    @foreach ($months as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('birth_month') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                           
                            <div>
                                <label for="birth_year" class="block text-xs text-gray-600 mb-1">Năm</label>
                                <select id="birth_year" name="birth_year"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Năm</option>
                                    @for ($i = date('Y'); $i >= 1900; $i--)
                                        <option value="{{ $i }}"
                                            {{ old('birth_year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Giới tính *
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="male"
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                    {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">👨 Nam</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="female"
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                    {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">👩 Nữ</span>
                            </label>
                        </div>
                    </div>
                </div>

              
                <div class="text-center">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl text-lg transition duration-300 transform hover:scale-105 shadow-lg"
                        id="submitBtn">
                        <span class="flex items-center justify-center">
                            <span class="mr-2">✨</span>
                            Tính Toán Thần Số Học
                            <span class="ml-2">🔮</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>


    </div> --}}

    {{-- Loading Animation --}}
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-2xl text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Đang tính toán...</h3>
            <p class="text-gray-600">Vui lòng chờ trong giây lát</p>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('numerologyForm');
                const submitBtn = document.getElementById('submitBtn');
                const btnText = submitBtn.querySelector('.btn-text');
                const spinner = submitBtn.querySelector('.spinner-border');

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

                const setLoadingState = (loading = true) => {
                    if (submitBtn) submitBtn.disabled = loading;
                    if (btnText) btnText.textContent = loading ? 'Đang xử lý...' : 'Xem Kết Quả';
                    if (spinner) spinner.classList.toggle('d-none', !loading);
                };

                form?.addEventListener('submit', function(e) {
                    e.preventDefault();
                    setLoadingState(true);
                    document.getElementById('loadingOverlay').classList.remove('hidden');

                    // Get form values
                    const formData = new FormData(form);
                    const ngayXemInput = document.getElementById('ngayXem');

                    // Update birthdate field with formatted date
                    formData.set('birthdate', ngayXemInput.value);

                    // Submit form normally
                    form.submit();
                });
            });
        </script>
    @endpush
@endsection
