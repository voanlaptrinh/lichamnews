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
                    <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Hướng hợp
                        tuổi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem hướng nhà
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem hướng nhà hợp tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="--text-down-convert" style="#192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Vui lòng nhập thông tin ngày sinh và giới tính vào các ô dưới đây để xem hướng hợp tuổi.</p>

                                        <form id="huongnhaform">
                                            @csrf
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
                                            </div>

                                            <div class="mb-3">
                                                 <label class="form-label fw-bold" style="color: #212121CC">Giới tính</label>
                                            
                                                <div class="d-flex gap-4 ps-2">
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            id="maleGender" value="nam" checked
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="maleGender"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Nam
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            id="femaleGender" value="nữ"
                                                            style="width: 24px; height: 24px; cursor: pointer;">
                                                        <label class="form-check-label ms-2" for="femaleGender"
                                                            style="cursor: pointer; font-size: 15px; color: #333;">
                                                            Nữ
                                                        </label>
                                                    </div>
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
                                        style=" background-image: url(../images/form_xem_huongnha.svg?v=1.0);
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

                    </div>

                    <div class="box--bg-thang mt-3 mb-3" id="none-content">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h3-log fw-bolder">Khám Phá Hướng Nhà Hợp Tuổi – Bí Quyết Mang Lại
                                May Mắn & Thịnh Vượng</h2>
                            <p class="mb-2">Trong phong thủy, hướng nhà là yếu tố có ảnh hưởng mạnh nhất đến trường khí
                                của nơi ở. Ngôi nhà hợp tuổi gia chủ thường giúp:
                            </p>
                            <ul class="mb-2">
                                <li>Đón được sinh khí, mang lại tài lộc, sức khỏe và sự ổn định.</li>
                                <li>Hạn chế xung khí, giảm rủi ro, tránh điều không may.</li>
                                <li>Tạo cảm giác an tâm khi xây dựng hoặc chọn mua nhà mới.</li>
                                <li>Hỗ trợ sự hòa thuận trong gia đình và công việc của gia chủ.</li>
                            </ul>
                            <p class="mb-3">Hướng nhà phù hợp không chỉ mang ý nghĩa phong thủy mà còn giúp gia chủ cảm
                                nhận được sự hài hòa về tinh thần, nhận được thêm nguồn năng lượng tốt trong cuộc sống hàng
                                ngày.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Các nguyên tắc chọn hướng nhà hợp tuổi
                            </h3>
                            <p class="mb-2">Tính năng Xem Hướng Nhà Hợp Tuổi trên Phong Lịch áp dụng đầy đủ các nguyên
                                tắc phong thủy Bát Trạch:</p>
                            <ul style="	list-style-type: decimal;">
                                <li>
                                    <h4 class="fs-6 fst-italic">Xác định mệnh trạch (Đông Tứ Mệnh – Tây Tứ Mệnh)</h4>
                                    <p class="mb-2">Dựa vào năm sinh, gia chủ được chia thành hai nhóm lớn:</p>
                                    <ul class="mb-2">
                                        <li><b>Đông Tứ Mệnh:</b> hợp các hướng Đông, Đông Nam, Bắc, Nam</li>
                                        <li><b>Tây Tứ Mệnh:</b> hợp các hướng Tây, Tây Bắc, Tây Nam, Đông Bắc</li>
                                    </ul>
                                    <p class="mb-3">Đây là bước giúp xác định nhóm hướng cát/hung phù hợp nhất với tuổi.
                                    </p>
                                </li>
                                <li>
                                    <h4 class="fs-6 fst-italic">Ưu tiên 4 hướng cát theo Bát Trạch</h4>
                                    <ul class="mb-2">
                                        <li>Sinh Khí: vượng tài, phát lộc</li>
                                        <li>Thiên Y: tốt cho sức khỏe</li>
                                        <li>Diên Niên: hòa thuận, ổn định</li>
                                        <li>Phục Vị: bình an, thích hợp cho gia đạo</li>
                                    </ul>
                                    <p class="mb-3">Những người chuẩn bị xây nhà mới hoặc mua nhà thường ưu tiên chọn nhà
                                        theo 2 hướng mạnh nhất: <b>Sinh Khí</b> và <b>Thiên Y</b>.</p>
                                </li>
                                <li>
                                    <h4 class="fs-6 fst-italic"> Tránh 4 hướng hung</h4>
                                    <ul class="mb-2">
                                        <li>Tuyệt Mệnh</li>
                                        <li>Lục Sát</li>
                                        <li>Ngũ Quỷ</li>
                                        <li>Hoạ Hại</li>
                                    </ul>
                                    <p class="mb-3">Nếu lỡ hướng nhà không hợp tuổi, đừng lo, bạn hoàn toàn có thể tìm
                                        các cách hóa giải sát khí và tăng vượng khí.</p>
                                </li>
                                <li>
                                    <h4 class="fs-6 fst-italic">Cân nhắc môi trường thực tế</h4>
                                    <p class="mb-2">Phong thủy hướng nhà cần kết hợp với:</p>
                                    <ul class="mb-2">
                                        <li>Vị trí đường đi</li>
                                        <li>Hình thế xung quanh</li>
                                        <li>Ánh sáng – gió – không gian thực tế</li>
                                    </ul>
                                    <p class="mb-3"> Công cụ trên Phong Lịch giúp bạn biết họ hợp hướng nào, còn thực tế
                                        sẽ được xem xét thêm khi lựa chọn vị trí nhà.</p>
                                </li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Cách sử dụng công cụ Xem Hướng Nhà Hợp
                                Tuổi
                            </h3>
                            <p class="mb-2">Bạn chỉ cần thực hiện 2 bước đơn giản:</p>
                            <ul style="	list-style-type: decimal;" class="mb-2">
                                <li>Nhập năm sinh (âm lịch hoặc dương lịch).</li>
                                <li>Chọn giới tính</li>
                            </ul>
                            <p class="mb-2">Hệ thống sẽ tự động:
                            </p>
                            <ul class="mb-2">
                                <li>Xác định mệnh trạch hợp tuổi.</li>
                                <li>Hiển thị 4 hướng tốt và 4 hướng xấu.</li>
                                <li>Gợi ý hướng nhà đẹp nhất cho tuổi của người dùng.</li>
                                <li>Giải thích ý nghĩa từng hướng để dễ dàng lựa chọn.</li>
                            </ul>
                            <p class="mb-3">Kết quả được trình bày rõ ràng, dễ hiểu và không yêu cầu bất kỳ kiến thức
                                phong thủy phức tạp nào.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Ai nên xem hướng nhà hợp tuổi?
                            </h3>
                            <ul class="mb-3">
                                <li>Người chuẩn bị xây nhà hoặc thiết kế lại mặt tiền.</li>
                                <li>Gia chủ đang cân nhắc mua nhà, mua đất.</li>
                                <li>Người muốn hiểu hướng hợp tuổi để chọn chung cư, nhà phố, biệt thự…</li>
                                <li>Những ai muốn xem lại hướng đang ở để biết tốt – xấu và tìm cách cải thiện phong thủy.
                                </li>

                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Lợi ích khi sử dụng công cụ trên
                                website của chúng tôi
                            </h3>
                            <ul class="mb-3">
                                <li>Kết quả chính xác dựa trên phong thủy Bát Trạch.</li>
                                <li>Hiển thị rõ ràng hướng tốt, hướng xấu, giúp người dùng dễ lựa chọn.</li>
                                <li>Có giải thích trực quan giúp người mới cũng hiểu được.</li>
                                <li>Hoàn toàn miễn phí và tra cứu nhanh trong vài giây.</li>
                                <li>Phù hợp với mọi loại hình nhà ở: chung cư, nhà đất, nhà cải tạo…</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Kết luận
                            </h3>
                            <p class="mb-2">Xem hướng nhà hợp tuổi là bước quan trọng khi xây nhà, mua nhà hoặc chọn nơi
                                an cư lâu dài. Tính năng Xem Hướng Nhà Hợp Tuổi trên Phong Lịch giúp gia chủ xác định hướng
                                tốt – xấu một cách nhanh chóng, dễ hiểu và đáng tin cậy.</p>
                            <p>Hãy nhập tuổi của bạn để xem đâu là hướng nhà hợp tuổi, mang lại may mắn, tài lộc và bình an
                                cho cả gia đình.</p>
                        </div>
                    </div>


                </div>
 @include('huong-hop-tuoi.sliderbarhoptuoi')

            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
    {{-- Date Range Picker JS (vanilla JS version) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('huongnhaform');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
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
            form?.addEventListener('submit', e => {
                e.preventDefault();

                setLoadingState(true);
                // Get form values
                const ngayXemInput = document.getElementById('ngayXem');
                const genderValue = document.querySelector('input[name="gender"]:checked')?.value;
                const formattedBirthdate = ngayXemInput.value;

                // For the API, check if the selected calendar is lunar and if the month is leap
                const lunarRadio = document.getElementById('lunarCalendar');
                const isLunar = lunarRadio?.checked;
                const isLeapMonth = isLunar && dateSelector.isLeapMonth;

                const formData = {
                    birthdate: formattedBirthdate,
                    gioi_tinh: genderValue,
                    _token: '{{ csrf_token() }}'
                };

                const submitForm = async () => {
                    try {
                        const response = await fetch('{{ route('huong-nha.check') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const data = await response.json();


                        if (data.success) {
                            // Show results using modern approach
                              const contentcontent = document.getElementById(
                                        'none-content');
                                         contentcontent.style.display = 'none';
                            if (resultsContainer) {
                                resultsContainer.style.display = 'block';
                                resultsContainer.innerHTML = data.html;
                                setTimeout(() => {
                                    const contentBoxSuccess = document.getElementById(
                                        'content-box-success');
                                    setLoadingState(false);
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

                            }
                        } else if (data.errors) {
                            // Show validation errors using modern string formatting
                            const errorMessages = Object.values(data.errors)
                                .map(errors => errors[0])
                                .join('\n- ');
                            alert(`Vui lòng kiểm tra lại:\n- ${errorMessages}`);
                            setLoadingState(false);
                        } else {
                            setLoadingState(false);
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    } catch (error) {

                        setLoadingState(false);
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    }
                };

                submitForm();

            });
        });
    </script>
@endpush
