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
                    Xem hướng phòng ngủ
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem hướng phòng ngủ hợp tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                         <div class="--text-down-convert" >
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Vui lòng nhập thông tin ngày sinh và giới tính vào các ô dưới đây để xem hướng hợp tuổi.</p>

                                        <form id="huongphongnguform">
                                            @csrf
                                            <div class="mb-3">
                                                <!-- Date Selects -->
                                                 <label class="form-label fw-bold" style="color: #212121CC">Ngày tháng năm sinh</label>
                                    
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
                                        style=" background-image: url(../images/form_xem_huongphongngu.svg?v=1.0);
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
                            <h2 class="title-tong-quan-h3-log fw-bolder">Vì sao nên xem hướng phòng ngủ theo tuổi?</h2>
                            <p class="mb-2">
                                Phòng ngủ là nơi nạp lại năng lượng và tái tạo sức khỏe, vì vậy hướng đặt phòng ngủ và
                                giường ngủ có ảnh hưởng rất lớn đến giấc ngủ, tinh thần và sức khỏe của gia chủ. Khi chọn
                                được hướng hợp tuổi, không gian nghỉ ngơi trở nên hài hòa hơn, giúp tinh thần thư thái và
                                chất lượng giấc ngủ được cải thiện rõ rệt.
                            </p>
                            <p class="mb-2">Mỗi người có một cung mệnh khác nhau, vì vậy hướng tốt – xấu trong phong thủy
                                cũng không giống nhau. Việc xem hướng phòng ngủ hợp tuổi đem lại nhiều giá trị thiết thực
                                như:</p>
                            <ul class="mb-2">
                                <li>Tăng chất lượng giấc ngủ, tinh thần ổn định hơn.</li>
                                <li>Hỗ trợ sức khỏe, giảm các trạng thái mệt mỏi hoặc ngủ không ngon.</li>
                                <li>Tăng cát khí trong không gian sống, mang lại sự bình an cho gia đình.</li>
                            </ul>
                            <p class="mb-3">Ngược lại, ngủ sai hướng hoặc đặt giường vào cung xấu dễ gây cảm giác bất an,
                                khó ngủ, tinh thần kém minh mẫn hoặc hay gặp mệt mỏi.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Công cụ xem hướng phòng ngủ hợp tuổi</h3>
                            <p class="mb-2">Tính năng “Xem hướng phòng ngủ hợp tuổi” giúp bạn nhanh chóng xác định hướng
                                tốt để bố trí phòng ngủ và giường ngủ. Chỉ cần nhập năm sinh và giới tính, hệ thống sẽ:</p>
                            <ul class="mb-2">
                                <li>Hiển thị các hướng tốt theo Bát Trạch như Sinh Khí, Thiên Y, Diên Niên, Phục Vị</li>
                                <li>Gợi ý hướng đặt giường ngủ sao cho hợp tuổi theo các mức độ ưu tiên</li>
                                <li>Giải thích ý nghĩa từng cung để bạn dễ hiểu và tự điều chỉnh nếu cần</li>
                                <li>Hiển thị những điều cần tránh khi kê giường ngủ.</li>
                            </ul>
                            <p class="mb-3">Tất cả đều được trình bày rõ ràng, dễ áp dụng cho mọi loại nhà.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Cách sử dụng tính năng</h3>
                            <ul style="	list-style-type: decimal;" class="mb-2">
                                <li>Nhập năm sinh gia chủ hoặc người ngủ trong phòng</li>
                                <li>Chọn giới tính</li>
                                <li>Nhận kết quả hướng phù hợp kèm phân tích chi tiết.</li>
                            </ul>
                            <p class="mb-3">Công cụ hoạt động tự động, dễ dùng ngay cả với người không am hiểu phong
                                thủy.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Lưu ý khi đặt hướng phòng ngủ và giường ngủ</h3>
                            <p class="mb-2">Ngoài việc xác định hướng hợp tuổi, bạn nên chú ý thêm một số nguyên tắc
                                phong thủy cơ bản:</p>
                            <ul class="mb-3">
                                <li>Giường nên quay về hướng tốt thuộc nhóm Sinh Khí, Thiên Y, Diên Niên hoặc Phục Vị.</li>
                                <li>Tránh đặt giường đối diện gương, cửa ra vào hoặc cạnh nhà vệ sinh.</li>
                                <li>Đầu giường cần có điểm tựa chắc chắn (tường kín).</li>
                                <li>Tránh đặt giường dưới xà ngang hoặc vị trí có nhiều đường đi qua.</li>
                                <li>Phòng ngủ nên yên tĩnh, thoáng khí và ánh sáng vừa phải.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Lợi ích khi chọn đúng hướng phòng ngủ</h3>
                            <ul class="mb-3">
                                <li>Giấc ngủ sâu và chất lượng hơn.</li>
                                <li>Tăng cát khí cho sức khỏe và tinh thần.</li>
                                <li>Giảm căng thẳng, giúp người ngủ dễ hồi phục năng lượng.</li>
                                <li>Hài hòa phong thủy tổng thể của ngôi nhà.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Áp dụng cho nhiều kiểu nhà</h3>
                            <ul class="mb-3">
                                <li>Với nhà phố: phòng ngủ thường có vị trí cố định, bạn có thể xoay giường theo hướng tốt.
                                </li>
                                <li>Với căn hộ chung cư: ưu tiên hướng đầu giường vì hướng phòng thường khó thay đổi.</li>
                                <li>Với nhà nhiều tầng: mỗi tầng có thể xem theo tuổi người sử dụng phòng.</li>

                            </ul>
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
            const form = document.getElementById('huongphongnguform');
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
                        const response = await fetch('{{ route('huong-phong-ngu.check') }}', {
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
                            setLoadingState(false);
                            alert(`Vui lòng kiểm tra lại:\n- ${errorMessages}`);
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

                console.log('Formatted Birthdate:', genderValue);
                // AJAX call will go here
            });
        });
    </script>
@endpush
