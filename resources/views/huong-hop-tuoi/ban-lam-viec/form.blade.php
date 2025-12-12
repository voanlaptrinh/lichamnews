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
                    <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Hướng hợp
                        tuổi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem hướng bàn làm việc
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem hướng bàn làm việc hợp tuổi</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="backv-doi-lich ">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-8">
                                <div class="">
                                    <div class="form--submit-totxau">
                                        <div class="fw-bold  title-tong-quan-h2-log" style="#192E52">
                                            Thông tin người
                                            xem
                                        </div>
                                        <p class="" style=" font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                            vào
                                            ô dưới
                                            đây để xem ngày tốt xấu</p>

                                        <form id="huongbanlamviecform">
                                            @csrf
                                            <div class="mb-3">
                                                <!-- Date Selects -->
                                                <div for="birthdate" class="fw-bold title-tong-quan-h4-log mb-2">Ngày tháng
                                                    năm sinh</div>
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
                                                <div class="fw-bold title-tong-quan-h4-log">Giới tính</div>
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
                                        style=" background-image: url(../images/form_xem_huongbanlamviec.svg?v=1.0);
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
                            <h2 class="title-tong-quan-h3-log fw-bolder">Vì sao nên xem hướng bàn làm việc theo tuổi?</h2>
                            <p class="mb-2">Bàn làm việc là nơi tạo ra ý tưởng, quyết định, sự tập trung và hiệu quả, vì
                                vậy việc chọn hướng bàn hợp tuổi có thể giúp tăng sự minh mẫn, thu hút tài lộc, thuận lợi
                                trong công việc và giảm bớt áp lực. Khi ngồi đúng hướng tốt theo phong thủy, dòng khí cát
                                lành sẽ hỗ trợ tinh thần, giúp công việc thông suốt và dễ đạt thành tựu hơn.</p>
                            <p class="mb-2">Mỗi người thuộc một cung mệnh, nhóm hướng tốt – xấu theo Bát Trạch đều khác
                                nhau. <br>
                                Chọn hướng bàn làm việc hợp tuổi mang lại nhiều lợi ích thiết thực như:</p>
                            <ul class="mb-2">
                                <li>Tăng khả năng tập trung, đầu óc sáng suốt.</li>
                                <li>Hỗ trợ công việc thuận lợi, dễ thăng tiến, dễ gặp quý nhân.</li>
                                <li>Giảm cảm giác căng thẳng, giúp tinh thần ổn định hơn.</li>
                                <li>Hạn chế ảnh hưởng của các hướng xấu đến năng lượng làm việc.</li>
                            </ul>
                            <p class="mb-3">Ngược lại, ngồi sai hướng dễ khiến tâm trí phân tán, áp lực, dễ mắc lỗi hoặc
                                khó đạt hiệu quả cao trong công việc.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Công cụ xem hướng bàn làm việc hợp tuổi
                                trên Phong Lịch</h3>
                            <p class="mb-2">Tính năng “Xem hướng bàn làm việc hợp tuổi” giúp bạn xác định nhanh các hướng
                                phù hợp nhất theo năm sinh và giới tính. Khi nhập thông tin, hệ thống sẽ:</p>
                            <ul class="mb-2">
                                <li>Hiển thị hướng tốt theo Bát Trạch như Sinh Khí, Thiên Y, Diên Niên, Phục Vị – phù hợp
                                    cho công việc, học tập hoặc kinh doanh.</li>
                                <li>Gợi ý hướng ngồi và cách xoay bàn phù hợp với không gian.</li>
                                <li>Giải thích ý nghĩa từng hướng để người dùng tự hiểu và ứng dụng dễ dàng.</li>
                            </ul>
                            <p class="mb-3">Tất cả được trình bày đơn giản, trực quan để bạn có thể áp dụng ngay.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Cách dùng công cụ xem hướng bàn làm
                                việc</h3>
                            <ul class="mb-2" style="	list-style-type: decimal;">
                                <li>Nhập năm sinh của người sử dụng bàn làm việc.</li>
                                <li>Chọn giới tính của người ngồi.</li>
                                <li>Xem danh sách hướng tốt mà hệ thống gợi ý.</li>
                                <li>Chọn hướng phù hợp với không gian phòng làm việc hoặc văn phòng.</li>
                                <li>Xoay bàn/ghế để mặt ngồi hướng về hướng cát trong danh sách.</li>
                            </ul>
                            <p class="mb-3">Dù không am hiểu phong thủy, bạn vẫn có thể điều chỉnh dễ dàng trong vài
                                phút.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Lưu ý phong thủy khi đặt bàn làm việc
                            </h3>
                            <p class="mb-2">Bên cạnh việc chọn hướng hợp tuổi, bạn nên lưu ý thêm một số nguyên tắc để
                                tối ưu hóa không gian làm việc:</p>
                            <ul class="mb-3">
                                <li>Mặt ngồi nên hướng về Sinh Khí hoặc Thiên Y để tăng tài lộc và tập trung.</li>
                                <li>Lưng ghế nên có điểm tựa vững (tường), tránh quay ra cửa hoặc lối đi.</li>
                                <li>Tránh đặt bàn làm việc ngay dưới xà ngang, đối diện nhà vệ sinh hoặc sát bếp.</li>
                                <li>Giữ bàn làm việc luôn gọn gàng, sáng sủa để tăng dòng khí tốt.</li>
                                <li>Tránh ngồi quay lưng ra cửa chính – dễ phân tán, mất tập trung.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Lợi ích khi chọn đúng hướng bàn làm
                                việc</h3>
                            <ul class="mb-3">
                                <li>Tăng hiệu suất và khả năng tập trung.</li>
                                <li>Gặp nhiều thuận lợi, tự tin trong công việc.</li>
                                <li>Dễ gặp quý nhân hỗ trợ hoặc có cơ hội thăng tiến.</li>
                                <li>Giảm áp lực, tinh thần thoải mái hơn.</li>
                                <li>Không gian làm việc hài hòa, mang lại cảm giác dễ chịu.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Áp dụng linh hoạt cho mọi không gian
                            </h3>
                            <ul class="mb-3">
                                <li>Nhà riêng: dễ xoay bàn theo hướng hợp tuổi.</li>
                                <li>Văn phòng công ty: có thể xoay ghế hoặc điều chỉnh vị trí ngồi trong giới hạn cho phép.
                                </li>
                                <li>Phòng ngủ – phòng làm việc tại nhà: ưu tiên hướng mặt ngồi, vì vị trí bàn có thể cố
                                    định.</li>
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
            const form = document.getElementById('huongbanlamviecform');
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
                        const response = await fetch('{{ route('huong-ban-lam-viec.check') }}', {
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
