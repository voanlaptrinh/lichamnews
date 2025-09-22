@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <span>Chi tiết ngày</span>
        </h6>
        <h1 class="content-title-home-lich">Lịch Âm Hôm Nay - Lịch Vạn Niên Hôm Nay</h1>
        <p class="mb-1">Âm lịch hôm nay là ngày nào?</p>
        <div class="row ">
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="ngay-hom-ngay">
                    Hôm nay, ngày {{ $dd }}/{{ $mm }}/{{ $yy }} dương lịch, tức ngày <span id="luna-date">{{ $al[0] }}</span> <span id="luna-month">Tháng
                        {{ $al[1] }}</span>
                    năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }} (<span id="luna-year">Âm lịch</span>).
                </div>
            </div>
        </div>

            @include('lunar.today_content.content')

        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {




                // Lấy ngày tháng năm hiện tại từ Blade
                const currentYear = {{ $yy }};
                const currentMonth = {{ $mm }}; // Tháng từ PHP (1-12)
                const currentDay = {{ $dd }};

                // Tạo đối tượng Date trong JavaScript
                // Lưu ý: Tháng trong JS là 0-11, nên phải trừ đi 1
                const currentDate = new Date(currentYear, currentMonth - 1, currentDay);

                // Lấy TẤT CẢ các element nút bấm prev
                const prevBtns = document.querySelectorAll('.prev-day-btn');
                // Lấy TẤT CẢ các element nút bấm next
                const nextBtns = document.querySelectorAll('.next-day-btn');

                // --- Xử lý các nút "Ngày trước" ---
                if (prevBtns.length > 0) {
                    const prevDate = new Date(currentDate);
                    prevDate.setDate(currentDate.getDate() - 1);

                    const prevYear = prevDate.getFullYear();
                    const prevMonth = prevDate.getMonth() + 1;
                    const prevDay = prevDate.getDate();

                    const newPrevUrl = `/chi-tiet/${prevYear}/thang/${prevMonth}/ngay/${prevDay}`;

                    // Lặp qua TẤT CẢ các nút "prev" và gán URL mới
                    prevBtns.forEach(btn => {
                        btn.href = newPrevUrl;
                    });
                }

                // --- Xử lý các nút "Ngày sau" ---
                if (nextBtns.length > 0) {
                    const nextDate = new Date(currentDate);
                    nextDate.setDate(currentDate.getDate() + 1);

                    const nextYear = nextDate.getFullYear();
                    const nextMonth = nextDate.getMonth() + 1;
                    const nextDay = nextDate.getDate();

                    const newNextUrl = `/chi-tiet/${nextYear}/thang/${nextMonth}/ngay/${nextDay}`;

                    // Lặp qua TẤT CẢ các nút "next" và gán URL mới
                    nextBtns.forEach(btn => {
                        btn.href = newNextUrl;
                    });
                }

            });
        </script>
    @endpush
