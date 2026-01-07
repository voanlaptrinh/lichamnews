@php
    // Tìm tháng hiện tại - lấy ngày hiện tại và chuyển sang âm lịch
    $today = date('j/n/Y');
    $todayParts = explode('/', $today);
    $lunarToday = \App\Helpers\LunarHelper::convertSolar2Lunar($todayParts[0], $todayParts[1], $todayParts[2]);
    $currentLunarMonth = $lunarToday[1];
    $currentLunarYear = $lunarToday[2];

    // Lùi lại 2 tháng từ tháng hiện tại
    $startMonth = $currentLunarMonth - 2;
    $startYear = $currentLunarYear;

    // Xử lý trường hợp lùi về năm trước
    if ($startMonth <= 0) {
        $startMonth = $startMonth + 12; // Chuyển sang tháng của năm trước
        $startYear = $currentLunarYear - 1;
    }

    // Tạo danh sách 12 tháng liên tiếp từ tháng bắt đầu
    $months = collect();
    $month = $startMonth;
    $year = $startYear;

    for ($i = 0; $i < 12; $i++) {
        // Thêm tháng thường
        $months->push([
            'lunar_month' => $month,
            'lunar_year' => $year,
            'is_leap' => false,
        ]);

        // Kiểm tra tháng nhuận cho tháng này
        // Sử dụng dữ liệu có sẵn từ header_lunar_months để kiểm tra tháng nhuận
        if (isset($header_lunar_months)) {
            foreach ($header_lunar_months as $info) {
                if ($info['is_leap'] &&
                    $info['lunar_month'] == $month &&
                    $info['lunar_year'] == $year) {
                    // Thêm tháng nhuận ngay sau tháng thường
                    $months->push([
                        'lunar_month' => $month,
                        'lunar_year' => $year,
                        'is_leap' => true,
                    ]);
                    break;
                }
            }
        }

        // Chuyển sang tháng tiếp theo
        $month++;
        if ($month > 12) {
            $month = 1;
            $year++;
        }
    }
@endphp

@foreach ($months as $month_info)
    <li>
        @if ($month_info['is_leap'])
            <a href="{{ route('lich.thang.nhuan', ['nam' => $month_info['lunar_year'], 'thang' => $month_info['lunar_month']]) }}">
                Tháng {{ $month_info['lunar_month'] }} nhuận năm {{ $month_info['lunar_year'] }}
            </a>
        @else
            <a href="{{ route('lich.thang', ['nam' => $month_info['lunar_year'], 'thang' => $month_info['lunar_month']]) }}">
                Tháng {{ $month_info['lunar_month'] }} năm {{ $month_info['lunar_year'] }}
            </a>
        @endif
    </li>
@endforeach
