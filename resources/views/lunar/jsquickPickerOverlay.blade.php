<script src="{{ asset('js/home.js?v=1.4') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Khởi tạo ứng dụng lịch âm
        const lunarApp = new LunarCalendarApp({
            currentYear: {{ $yy }},
            currentMonth: {{ $mm }},
            currentDay: {{ $dd }},
            ajaxUrl: '{{ route('lunar.detail.ajax') }}'
        });

        lunarApp.init();
    });

    $('#month-year-picker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'MM-YYYY',
            "applyLabel": "Chọn",
            "cancelLabel": "Hủy",
            "fromLabel": "Từ",
            "toLabel": "Đến",
            "customRangeLabel": "Tùy chỉnh",
            "weekLabel": "W",
            "daysOfWeek": [
                "CN",
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7"
            ],
            "monthNames": [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12"
            ],
            "firstDay": 1
        }
    }, function(start, end, label) {
        const year = start.format('YYYY');
        const month = start.format('M');
        const day = start.format('D');
        const url = `{{ route('detai_home', ['nam' => ':nam', 'thang' => ':thang', 'ngay' => ':ngay']) }}`
            .replace(':nam', year).replace(':thang', month).replace(':ngay', day);
        window.location.href = url;
    });
</script>
