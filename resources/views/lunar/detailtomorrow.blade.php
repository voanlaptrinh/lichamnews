@extends('welcome')
@section('content')
    <div class="container-setup">
        <div class="col-xl-9 col-sm-12 col-12">

            <div>
                 <nav aria-label="breadcrumb" class="content-title-detail">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                    </li>


                    <li class="breadcrumb-item active" aria-current="page">
                        Lịch âm ngày mai
                    </li>
                </ol>
            </nav>

            
               

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
    <script defer src="{{ asset('js/base-picker.js?v=3.9') }}"></script>
    <script defer src="{{ asset('js/today-tomorrow-picker.js?v=3.8') }}"></script>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            // Wait for deferred scripts
            if (typeof TodayTomorrowPicker !== 'undefined') {
                const todayTomorrowPicker = new TodayTomorrowPicker({
                    currentYear: {{ $yy }},
                    currentMonth: {{ $mm }},
                    currentDay: {{ $dd }}
                });
                todayTomorrowPicker.init();
            } else {
                setTimeout(() => {
                    if (typeof TodayTomorrowPicker !== 'undefined') {
                        const todayTomorrowPicker = new TodayTomorrowPicker({
                            currentYear: {{ $yy }},
                            currentMonth: {{ $mm }},
                            currentDay: {{ $dd }}
                        });
                        todayTomorrowPicker.init();
                    }
                }, 100);
            }
        });
    </script>
@endpush
