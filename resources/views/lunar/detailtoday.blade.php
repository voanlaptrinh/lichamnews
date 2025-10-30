@extends('welcome')
@section('content')
    <div class="container-setup">
        <div class="col-xl-9 col-sm-12 col-12">
            <h6 class="content-title-detail"><a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a> <i class="bi bi-chevron-right"></i>
                <span >Lịch âm hôm nay</span>
            </h6>
            
               <div class="d-flex justify-content-between">
                    <div>
                         <h1 class="content-title-home-lich">Lịch Âm Hôm Nay - Lịch Vạn Niên Hôm Nay</h1>
                        <p class="mb-1">Âm lịch hôm nay là ngày nào?</p>
                    </div>
                    <div>
                        <button
                            class="btn-today-home-pc btn-today-home justify-content-center align-items-center quickPickerBtn">
                            <i class="bi bi-calendar-event pe-2"></i>
                            <div>Xem nhanh theo ngày</div>
                        </button>
                    </div>
                </div>
            <div class="row ">
                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="ngay-hom-ngay mb-3">
                        Hôm nay, ngày {{ $dd }}/{{ $mm }}/{{ $yy }} dương lịch, tức ngày <span
                            id="luna-date">{{ $al[0] }}</span> <span id="luna-month">Tháng
                            {{ $al[1] }}</span>
                        năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }} (<span id="luna-year">Âm lịch</span>).
                    </div>
                </div>
            </div>
          
        </div>

        <div id="detail-content">
            @include('lunar.today_content.content')
        </div>

    </div>
    @include('lunar.quickPickerOverlay')
@endsection


@push('scripts')
    <script defer src="{{ asset('js/base-picker.js?v=3.8') }}"></script>
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
