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
                    <a href="{{ route('totxau.list') }}" style="color: #2254AB; text-decoration: underline;">Tử vi & Phong
                        thuỷ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem tuổi hợp nhau
                </li>
            </ol>
        </nav>
        <h1 class="content-title-home-lich">Xem tuổi hợp nhau</h1>

        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">

                <div class="col-xl-9 col-sm-12 col-12">
                    <div class="backv-doi-lich">
                        <div class="row g-xl-5 g-lg-3 g-sm-5">
                            <div class="col-lg-12">
                                <div class="form--submit-totxau">
                                    <div class="fw-bold title-tong-quan-h2-log" style="#192E52">
                                        Thông tin hai người
                                    </div>
                                    <p class="" style="font-size: 14px; color: #212121;">Bạn hãy nhập thông tin
                                        vào ô dưới đây để xem tuổi hợp nhau
                                    </p>

                                    <form id="compatibilityForm">
                                        @csrf
                                        <div class="row">
                                            <!-- Người A -->
                                            <div class="col-md-6 border-end border-2 pe-4">
                                                <h5 class="mb-3 fw-bold title-tong-quan-h4-log">Người A</h5>

                                                <div class="mb-3">
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="ngaySelectA" name="dayA"
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
                                                                    id="thangSelectA" name="monthA"
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
                                                                    id="namSelectA" name="yearA"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Năm</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-4 ps-2 mb-3">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="calendar_type_A"
                                                                id="solarCalendarA" value="solar" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="solarCalendarA"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Dương lịch
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="calendar_type_A"
                                                                id="lunarCalendarA" value="lunar"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="lunarCalendarA"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Âm lịch
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-check mt-2" id="leapMonthContainerA" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="leapMonthA"
                                                            name="leap_month_A">
                                                        <label class="form-check-label" for="leapMonthA">
                                                            Tháng nhuận
                                                        </label>
                                                    </div>

                                                    <input type="hidden" id="ngayXemA" name="birthdateA" value="">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h4-log">Giới tính</div>
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="genderA"
                                                                id="maleGenderA" value="nam" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="maleGenderA"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="genderA"
                                                                id="femaleGenderA" value="nữ"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="femaleGenderA"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Người B -->
                                            <div class="col-md-6 ps-4">
                                                <h5 class="mb-3 fw-bold title-tong-quan-h4-log">Người B</h5>

                                                <div class="mb-3">
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6 col-sm-4 col-lg-4 col-xl-4">
                                                            <div class="position-relative">
                                                                <select class="form-select pe-5 --border-box-form"
                                                                    id="ngaySelectB" name="dayB"
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
                                                                    id="thangSelectB" name="monthB"
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
                                                                    id="namSelectB" name="yearB"
                                                                    style="padding: 12px 45px 12px 15px">
                                                                    <option value="">Năm</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down position-absolute"
                                                                    style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-4 ps-2 mb-3">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="calendar_type_B"
                                                                id="solarCalendarB" value="solar" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="solarCalendarB"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Dương lịch
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="calendar_type_B"
                                                                id="lunarCalendarB" value="lunar"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="lunarCalendarB"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Âm lịch
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-check mt-2" id="leapMonthContainerB" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="leapMonthB"
                                                            name="leap_month_B">
                                                        <label class="form-check-label" for="leapMonthB">
                                                            Tháng nhuận
                                                        </label>
                                                    </div>

                                                    <input type="hidden" id="ngayXemB" name="birthdateB" value="">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="fw-bold title-tong-quan-h4-log">Giới tính</div>
                                                    <div class="d-flex gap-4 ps-2">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="genderB"
                                                                id="maleGenderB" value="nam"
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="maleGenderB"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input type="radio" class="form-check-input" name="genderB"
                                                                id="femaleGenderB" value="nữ" checked
                                                                style="width: 24px; height: 24px; cursor: pointer;">
                                                            <label class="form-check-label ms-2" for="femaleGenderB"
                                                                style="cursor: pointer; font-size: 15px; color: #333;">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row align-items-end">
                                            <div class="col-md-8">
                                                <label for="type" class="form-label fw-bold title-tong-quan-h4-log">Mục đích xem</label>
                                                <div class="position-relative">
                                                    <select class="form-select pe-5 --border-box-form" id="type" name="type"
                                                        style="padding: 12px 45px 12px 15px">
                                                        <option value="capdoi">Xem tuổi Vợ Chồng</option>
                                                        <option value="laman">Xem tuổi Làm Ăn</option>
                                                    </select>
                                                    <i class="bi bi-chevron-down position-absolute"
                                                        style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6c757d;"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-light-settup fw-bold w-100"
                                                        id="submitBtn">
                                                        <span class="btn-text">Xem Kết Quả</span>
                                                        <span class="spinner-border spinner-border-sm ms-2 d-none"
                                                            role="status"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="resultsContainer" class="--detail-success ">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/lunar-solar-date-select.js?v=2.6') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('compatibilityForm');
            const submitBtn = document.getElementById('submitBtn');
            const resultsContainer = document.getElementById('resultsContainer');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            const typeSelect = document.getElementById('type');
            const genderARadios = document.querySelectorAll('input[name="genderA"]');
            const genderBRadios = document.querySelectorAll('input[name="genderB"]');

            const hasHashParams = window.location.hash && window.location.hash.includes('birthdate');

            // Initialize date selectors for Person A
            const dateSelectorA = new LunarSolarDateSelect({
                daySelectId: 'ngaySelectA',
                monthSelectId: 'thangSelectA',
                yearSelectId: 'namSelectA',
                hiddenInputId: 'ngayXemA',
                solarRadioId: 'solarCalendarA',
                lunarRadioId: 'lunarCalendarA',
                leapCheckboxId: 'leapMonthA',
                leapContainerId: 'leapMonthContainerA',
                defaultDay: hasHashParams ? null : 1,
                defaultMonth: hasHashParams ? null : 1,
                defaultYear: hasHashParams ? null : 1990,
                yearRangeStart: 1900,
                yearRangeEnd: new Date().getFullYear(),
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                csrfToken: '{{ csrf_token() }}',
            });

            // Initialize date selectors for Person B
            const dateSelectorB = new LunarSolarDateSelect({
                daySelectId: 'ngaySelectB',
                monthSelectId: 'thangSelectB',
                yearSelectId: 'namSelectB',
                hiddenInputId: 'ngayXemB',
                solarRadioId: 'solarCalendarB',
                lunarRadioId: 'lunarCalendarB',
                leapCheckboxId: 'leapMonthB',
                leapContainerId: 'leapMonthContainerB',
                defaultDay: hasHashParams ? null : 1,
                defaultMonth: hasHashParams ? null : 1,
                defaultYear: hasHashParams ? null : 1995,
                yearRangeStart: 1900,
                yearRangeEnd: new Date().getFullYear(),
                lunarApiUrl: '/api/lunar-solar-convert',
                lunarMonthDaysUrl: '/api/get-lunar-month-days',
                csrfToken: '{{ csrf_token() }}',
            });

            const setLoadingState = (loading = true) => {
                if (submitBtn) submitBtn.disabled = loading;
                if (btnText) btnText.textContent = loading ? 'Đang xử lý...' : 'Xem Kết Quả';
                if (spinner) spinner.classList.toggle('d-none', !loading);
            };

            // Gender synchronization logic for couple compatibility
            function syncGenders(sourceGender) {
                if (typeSelect.value !== 'capdoi') return;

                if (sourceGender === 'A') {
                    const selectedValueA = document.querySelector('input[name="genderA"]:checked')?.value;
                    const oppositeValue = selectedValueA === 'nam' ? 'nữ' : 'nam';
                    document.querySelector(`input[name="genderB"][value="${oppositeValue}"]`).checked = true;
                } else if (sourceGender === 'B') {
                    const selectedValueB = document.querySelector('input[name="genderB"]:checked')?.value;
                    const oppositeValue = selectedValueB === 'nam' ? 'nữ' : 'nam';
                    document.querySelector(`input[name="genderA"][value="${oppositeValue}"]`).checked = true;
                }
            }

            function handleTypeChange() {
                if (typeSelect.value === 'capdoi') {
                    const genderA = document.querySelector('input[name="genderA"]:checked')?.value;
                    const genderB = document.querySelector('input[name="genderB"]:checked')?.value;

                    if (genderA === genderB) {
                        const oppositeValue = genderA === 'nam' ? 'nữ' : 'nam';
                        document.querySelector(`input[name="genderB"][value="${oppositeValue}"]`).checked = true;
                    }
                }
            }

            // Add event listeners for gender synchronization
            genderARadios.forEach(radio => {
                radio.addEventListener('change', () => syncGenders('A'));
            });
            genderBRadios.forEach(radio => {
                radio.addEventListener('change', () => syncGenders('B'));
            });
            typeSelect.addEventListener('change', handleTypeChange);

            // Initialize gender state
            handleTypeChange();

            form?.addEventListener('submit', e => {
                e.preventDefault();
                setLoadingState(true);

                // Get form values
                const ngayXemInputA = document.getElementById('ngayXemA');
                const ngayXemInputB = document.getElementById('ngayXemB');
                const genderValueA = document.querySelector('input[name="genderA"]:checked')?.value;
                const genderValueB = document.querySelector('input[name="genderB"]:checked')?.value;
                const typeValue = document.getElementById('type')?.value;

                const formattedBirthdateA = ngayXemInputA.value;
                const formattedBirthdateB = ngayXemInputB.value;

                const formData = {
                    birthdateA: formattedBirthdateA,
                    birthdateB: formattedBirthdateB,
                    genderA: genderValueA,
                    genderB: genderValueB,
                    type: typeValue,
                    _token: '{{ csrf_token() }}'
                };

                const submitForm = async () => {
                    try {
                        const response = await fetch('{{ route('compatibility.calculate') }}', {
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
                        console.log(error.message);
                        
                        alert('Có lỗi xảy ra khi kết nối. Vui lòng thử lại.');
                    }
                };

                submitForm();
            });
        });
    </script>
@endpush