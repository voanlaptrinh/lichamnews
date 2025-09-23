@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <span> Lịch ngày {{ $dd }}/{{ $mm }}/{{ $yy }}</span>
        </h6>
        <h1 class="content-title-home-lich">LỊCH ÂM DƯƠNG NGÀY {{ $dd }} THÁNG {{ $mm }} NĂM
            {{ $yy }}
        </h1>


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

                const newPrevUrl = `/lich-nam-${prevYear}/thang-${prevMonth}/ngay-${prevDay}/chi-tiet`;

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

                const newNextUrl = `/lich-nam-${nextYear}/thang-${nextMonth}/ngay-${nextDay}/chi-tiet`;

                // Lặp qua TẤT CẢ các nút "next" và gán URL mới
                nextBtns.forEach(btn => {
                    btn.href = newNextUrl;
                });
            }

        });
    </script>
@endpush
