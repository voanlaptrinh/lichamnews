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
                    Xem hướng bàn thờ
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem hướng bàn thờ hợp tuổi</h1>

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

                                        <form id="huongbanthoform">
                                            @csrf
                                            <div class="mb-3">
                                                <!-- Date Selects -->
                                                 <div for="birthdate" class="fw-bold title-tong-quan-h4-log mb-2">Ngày tháng năm sinh</div>
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
                                        style=" background-image: url(../images/form_xem_huongbantho.svg?v=1.0);
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
                            <h2 class="title-tong-quan-h3-log fw-bolder">Ý nghĩa của việc xem hướng bàn thờ theo tuổi</h2>
                            <p class="mb-2">Hướng bàn thờ luôn được xem là yếu tố quan trọng trong phong thủy nhà ở, bởi
                                đây là không
                                gian linh thiêng, nơi kết nối gia chủ với tổ tiên và gìn giữ sự bình an trong gia đình. Khi
                                bàn thờ được đặt đúng hướng hợp tuổi, sinh khí trong nhà trở nên ổn định, giúp cuộc sống và
                                tinh thần của các thành viên được nâng đỡ tốt hơn.
                            </p>
                            <p class="mb-2">Chọn hướng bàn thờ hợp tuổi không chỉ là yếu tố phong thủy, mà còn tạo cảm
                                giác an tâm cho gia đình. Việc này mang lại những lợi ích như:</p>
                            <ul class="mb-2">
                                <li>Giữ gìn sự tôn nghiêm và hài hòa trong không gian thờ cúng.</li>
                                <li>Tăng thêm may mắn, sức khỏe và sự thuận lợi trong cuộc sống.</li>
                                <li>Giúp gia đình cảm thấy yên ổn, tinh thần nhẹ nhàng hơn trong sinh hoạt hàng ngày.</li>
                            </ul>
                            <p class="mb-3">Ngược lại, nếu đặt bàn thờ lệch hướng hoặc rơi vào cung xấu, dòng khí trong
                                nhà dễ bị ảnh hưởng, khiến gia chủ cảm thấy bất ổn hoặc kém may mắn.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Công cụ xem hướng bàn thờ hợp tuổi</h3>
                            <p class="mb-2">Tính năng “Xem hướng bàn thờ hợp tuổi” giúp bạn nhanh chóng xác định hướng
                                tốt dựa trên năm sinh và giới tính của gia chủ. Khi nhập thông tin, hệ thống sẽ:
                            </p>
                            <ul class="mb-2">
                                <li>Chỉ ra các hướng tốt nên đặt bàn thờ theo Bát Trạch.</li>
                                <li>Giải thích ý nghĩa các cung như Sinh Khí, Thiên Y, Diên Niên, Phục Vị.</li>
                                <li>Lưu ý những điều cần tránh khi đặt bàn thờ</li>
                            </ul>
                            <p class="mb-3">Tất cả thông tin đều được hiển thị rõ ràng để bạn dễ hiểu và áp dụng ngay.
                            </p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Cách sử dụng tính năng</h3>
                            <ul class="mb-2">
                                <li>Nhập năm sinh của gia chủ.</li>
                                <li>Chọn giới tính.</li>
                                <li>Nhận kết quả hướng tốt – xấu kèm phân tích chi tiết.</li>
                            </ul>
                            <p class="mb-3">Công cụ được xây dựng để ai cũng có thể sử dụng, kể cả người không am hiểu
                                phong thủy.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Lưu ý khi đặt hướng bàn thờ</h3>
                            <p class="mb-2">Bên cạnh việc chọn hướng, bạn cũng nên lưu ý một số nguyên tắc cơ bản để việc
                                thờ cúng được trang nghiêm và thuận phong thủy:</p>
                            <ul class="mb-3">
                                <li>Ưu tiên chọn hướng hợp tuổi nằm trong nhóm Phục Vị, Sinh Khí, Thiên Y và Diên Niên (Phúc
                                    Đức).</li>
                                <li>Đặt bàn thờ ở vị trí yên tĩnh, tránh khu vực đi lại nhiều.</li>
                                <li>Không đặt bàn thờ gần bếp, nhà vệ sinh hoặc dưới xà ngang.</li>
                                <li>Với căn hộ chung cư, nên chú ý đến hướng mặt bàn thờ, vì bạn khó thay đổi vị trí tường
                                    đặt bàn thờ.</li>
                                <li>Giữ khu vực thờ tự sạch sẽ và thoáng khí.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Lợi ích khi chọn đúng hướng bàn thờ</h3>
                            <ul class="mb-3">
                                <li>Không gian thờ tự trang nghiêm, đúng phong thủy.</li>
                                <li>Gia đạo yên ổn, hòa thuận hơn.</li>
                                <li>Tăng thêm may mắn và tài lộc cho các thành viên.</li>
                                <li>Giúp việc thờ cúng diễn ra thuận lợi và an tâm.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic fw-bolder">Áp dụng trong các loại nhà khác nhau</h3>
                            <ul class="mb-3">
                                <li>Nhà đang xây: Dễ bố trí hướng bàn thờ chuẩn ngay từ bản vẽ.</li>

                                <li>Nhà đã hoàn thiện: Có thể xoay lại hướng hoặc điều chỉnh bố cục.</li>
                                <li>Chung cư: Tập trung vào hướng quay của bàn thờ để tối ưu phong thủy.</li>
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
            const form = document.getElementById('huongbanthoform');
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
                        const response = await fetch('{{ route('huong-ban-tho.check') }}', {
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
