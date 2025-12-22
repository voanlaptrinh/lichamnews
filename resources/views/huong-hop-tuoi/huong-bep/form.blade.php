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
                    <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Xem hướng hợp
                        tuổi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem hướng bếp
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem hướng bếp hợp tuổi</h1>

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

                                        <form id="huongbepform">
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
                                                <button type="submit"  class="btn fw-bold btnd-nfay" style="background: #115097"
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
                                        style=" background-image: url(../images/form_xem_huongbep.svg?v=1.0);
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
                            <h2 class="title-tong-quan-h3-log fw-bolder">Ý nghĩa của việc xem hướng bếp theo tuổi</h2>
                            <p class="mb-2">
                                Chọn hướng bếp hợp tuổi là bước quan trọng khi bố trí căn bếp, bởi đây được xem là nơi giữ
                                lửa, nuôi dưỡng sức khỏe và tài lộc của cả gia đình. Một hướng bếp đúng phong thủy không chỉ
                                giúp gia chủ an tâm mà còn góp phần cải thiện hòa khí, giảm xung đột và tăng sinh khí cho
                                ngôi nhà.
                            </p>
                            <p class="mb-2">Trong phong thủy, bếp thuộc hành Hỏa – gắn với năng lượng sống, sự ấm áp và
                                nguồn tài lộc. Khi hướng bếp hợp với cung mệnh của gia chủ, dòng khí tốt sẽ được dẫn vào,
                                giúp:</p>
                            <ul class="mb-3">
                                <li>Hạn chế bệnh tật, tăng cường sức khỏe.</li>
                                <li>Hỗ trợ công việc thuận lợi, tài lộc vững vàng.</li>
                                <li>Tạo cảm giác yên ổn, hài hòa trong gia đình.</li>
                                <li> Ngược lại, đặt bếp sai hướng có thể khiến nguồn năng lượng bị xung khắc, gây bất ổn
                                    trong cuộc sống.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Công cụ xem hướng bếp hợp tuổi – chính xác, dễ
                                hiểu
                            </h3>
                            <p class="mb-2">
                                Tính năng “Xem hướng bếp hợp tuổi” của Phong Lịch được xây dựng dựa trên phong thủy Bát
                                Trạch, xác định hướng tốt – xấu theo quẻ mệnh của từng người. Chỉ với vài thông tin cơ bản
                                như năm sinh và giới tính, công cụ sẽ phân tích và đưa ra:
                            </p>
                            <ul class="mb-2">
                                <li>Hướng tốt để đặt bếp hoặc quay miệng bếp.</li>
                                <li>Hướng xấu phù hợp để đặt tọa bếp nhằm trấn áp khí hung.</li>
                                <li>Giải thích cụ thể từng cung như Sinh Khí, Thiên Y, Diên Niên, Phục Vị…</li>
                            </ul>
                            <p class="mb-3">Kết quả dễ hiểu, trực quan, giúp bạn áp dụng ngay trong thực tế khi xây nhà,
                                sửa bếp hoặc bố trí lại không gian bếp trong căn hộ.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Cách sử dụng công cụ </h3>
                            <ul style="	list-style-type: decimal;" class="mb-2">
                                <li>Nhập năm sinh.</li>
                                <li>Chọn giới tính để công cụ xác định quẻ mệnh.</li>
                                <li>Nhận kết quả hướng bếp tốt – xấu và đọc phần luận giải đi kèm.</li>
                            </ul>
                            <p class="mb-3">Mọi bước đều được thiết kế đơn giản để ai cũng dùng được, kể cả người mới tìm
                                hiểu phong thủy.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Những nguyên tắc quan trọng khi đặt hướng bếp</h3>
                            <p class="mb-2">Dù có công cụ hỗ trợ, một số quy tắc căn bản dưới đây vẫn rất quan trọng khi
                                bố trí bếp:</p>
                            <ul class="mb-3">
                                <li>Tọa hung – hướng cát: đặt bếp ở hướng xấu nhưng quay về hướng tốt, giúp hóa giải khí xấu
                                    và thu hút năng lượng lành</li>
                                <li>Tránh đặt bếp đối diện cửa chính, nhà vệ sinh hoặc quá gần chậu rửa (Thủy – Hỏa xung
                                    khắc).</li>
                                <li>Giữ không gian bếp thoáng đãng, nhiều ánh sáng tự nhiên để khí lưu thông.</li>
                                <li>Với căn hộ chung cư, ưu tiên xoay miệng bếp theo hướng tốt nếu không thể thay đổi vị trí
                                    cố định.</li>

                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Lợi ích khi xem hướng bếp hợp tuổi trước khi bố
                                trí</h3>
                            <ul class="mb-3">
                                <li>Giúp gia chủ yên tâm về phong thủy nhà ở.</li>
                                <li>Tiết kiệm thời gian và chi phí sửa chữa sai hướng.</li>
                                <li>Tăng cường tài lộc, ổn định hòa khí gia đình.</li>
                                <li>Phù hợp cho cả nhà mới xây, nhà đang cải tạo hoặc căn hộ chung cư.</li>

                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">Tối ưu phong thủy bếp cho từng kiểu nhà</h3>
                            <ul class="mb-3">
                                <li>Nhà đất đang xây: dễ bố trí đúng từ ban đầu để mở vận khí tốt.</li>
                                <li>Nhà cũ hoặc bếp sai hướng: có thể xoay hướng bếp, đặt vật phẩm phong thủy hoặc thay vị
                                    trí miệng bếp để giảm xung khí.</li>
                                <li>Căn hộ chung cư: tận dụng hướng nhìn bếp hoặc cửa bếp để chọn hướng phù hợp nhất.</li>
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
            const form = document.getElementById('huongbepform');
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
                        const response = await fetch('{{ route('huong-bep.check') }}', {
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
                                        'content-box-succes');
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


            });
        });
    </script>
@endpush
