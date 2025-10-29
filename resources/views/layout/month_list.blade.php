@php
    $currentYear = $header_lunar_months[0]['lunar_year'] ?? date('Y');

    // Tạo danh sách 12 tháng cơ bản
    $months = collect(range(1, 12))->map(function ($m) use ($currentYear) {
        return [
            'lunar_month' => $m,
            'lunar_year' => $currentYear,
            'is_leap' => false,
        ];
    });

    // Nếu có dữ liệu tháng âm (có thể có nhuận), chèn tháng nhuận đúng vị trí
    if (isset($header_lunar_months) && count($header_lunar_months) > 0) {
        foreach ($header_lunar_months as $info) {
            if ($info['is_leap']) {
                // Chèn sau tháng thường cùng số
                $months->splice($info['lunar_month'], 0, [$info]);
            }
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
