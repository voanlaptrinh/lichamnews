@extends('welcome')
@section('content')
    <div class="container-setup">
        <div class="col-xl-9 col-sm-12 col-12">

            <div>
                <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a><i class="bi bi-chevron-right"></i>
                    <span style="color: #2254AB">Lịch âm ngày mai</span>
                </h6>
               

                <div class="d-flex justify-content-between">
                    <div>
                         <h1 class="content-title-home-lich">Lịch Âm Ngày mai - Lịch Vạn Niên Ngày mai</h1>
                        <p class="mb-1">Âm lịch Ngày mai là ngày nào?</p>
                    </div>
                    <div>
                        <button
                            class="btn-today-home-pc btn-today-home justify-content-center align-items-center quickPickerBtn">
                            <i class="bi bi-calendar-event pe-2"></i>
                            <div>Xem nhanh theo ngày</div>
                        </button>
                    </div>
                </div>

            </div>


            <div class="row ">
                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="ngay-hom-ngay mb-3">
                        Ngày mai, ngày {{ $dd }}/{{ $mm }}/{{ $yy }} dương lịch, tức ngày
                        <span id="luna-date">{{ $al[0] }}</span> <span id="luna-month">Tháng
                            {{ $al[1] }}</span>
                        năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }} (<span id="luna-year">Âm lịch</span>).
                    </div>
                </div>
            </div>

        </div>

        @include('lunar.today_content.content')

    </div>
    @include('lunar.quickPickerOverlay')
@endsection


@push('scripts')
    <script src="{{ asset('js/today-tomorrow-picker.js?v=1.4') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Khởi tạo ứng dụng quick picker cho trang ngày mai
            const todayTomorrowPicker = new TodayTomorrowPicker({
                currentYear: {{ $yy }},
                currentMonth: {{ $mm }},
                currentDay: {{ $dd }}
            });

            todayTomorrowPicker.init();
        });
    </script>
@endpush
