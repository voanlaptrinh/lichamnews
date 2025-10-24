<?php
require 'vendor/autoload.php';
use App\Helpers\LunarHelper;

echo "=== KIỂM TRA THÁNG ÂM TRONG THÁNG DƯƠNG ===\n\n";

// Test tháng 7/2025
echo "1. Tháng 7 dương lịch 2025:\n";
for ($day = 1; $day <= 31; $day++) {
    list($lunar_day, $lunar_month, $lunar_year, $lunar_leap) = LunarHelper::convertSolar2Lunar($day, 7, 2025);
    echo "   $day/7/2025 = $lunar_day/$lunar_month" . ($lunar_leap ? 'n' : '') . "/$lunar_year (âm)\n";
}

echo "\n2. Kiểm tra tháng 7 âm có tồn tại không:\n";
// Thử các năm âm có thể
$years_to_check = [2024, 2025, 2026];
foreach ($years_to_check as $year) {
    // Tháng 7 thường
    $result = LunarHelper::convertLunar2Solar(1, 7, $year, 0);
    if ($result[0] > 0) {
        echo "   Tháng 7/$year (âm): Ngày 1/7/$year = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
    }
    // Tháng 7 nhuận
    $result = LunarHelper::convertLunar2Solar(1, 7, $year, 1);
    if ($result[0] > 0) {
        echo "   Tháng 7n/$year (âm): Ngày 1/7n/$year = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
    }
}

echo "\n3. Tháng 6 dương lịch 2025 (kiểm tra tháng 6 nhuận):\n";
$found_leap = false;
for ($day = 1; $day <= 30; $day++) {
    list($lunar_day, $lunar_month, $lunar_year, $lunar_leap) = LunarHelper::convertSolar2Lunar($day, 6, 2025);
    if ($lunar_month == 6) {
        echo "   $day/6/2025 = $lunar_day/$lunar_month" . ($lunar_leap ? 'n' : '') . "/$lunar_year (âm)\n";
        if ($lunar_leap) $found_leap = true;
    }
}
echo "   Có tìm thấy tháng 6 nhuận: " . ($found_leap ? "CÓ" : "KHÔNG") . "\n";

echo "\n4. Kiểm tra logic tìm tháng âm cho tháng 7/2025:\n";
$checked_months = [];
$all_lunar_months = [];
for ($day = 1; $day <= 31; $day++) {
    list($lunar_day, $lunar_month, $lunar_year, $lunar_leap) = LunarHelper::convertSolar2Lunar($day, 7, 2025);

    // CHỈ xét tháng âm có cùng số với tháng dương (7)
    if ($lunar_month == 7) {
        $month_key = $lunar_year . '-' . $lunar_month . '-' . $lunar_leap;

        if (!isset($checked_months[$month_key])) {
            $checked_months[$month_key] = true;
            $all_lunar_months[] = [
                'month' => $lunar_month,
                'is_leap' => $lunar_leap,
                'year' => $lunar_year
            ];
            echo "   Tìm thấy: Tháng $lunar_month" . ($lunar_leap ? ' nhuận' : '') . " năm $lunar_year\n";
        }
    }
}

if (empty($all_lunar_months)) {
    echo "   KHÔNG TÌM THẤY tháng 7 âm nào trong tháng 7/2025!\n";
    echo "   => Cần kiểm tra lại logic hoặc dữ liệu\n";
} else {
    echo "   Tổng cộng tìm thấy: " . count($all_lunar_months) . " tháng âm\n";
}

echo "\n5. Tóm tắt vấn đề:\n";
// Kiểm tra xem trong tháng 7/2025 có ngày nào là tháng 7 âm không
$has_lunar_7 = false;
for ($day = 1; $day <= 31; $day++) {
    list($lunar_day, $lunar_month, $lunar_year, $lunar_leap) = LunarHelper::convertSolar2Lunar($day, 7, 2025);
    if ($lunar_month == 7) {
        $has_lunar_7 = true;
        break;
    }
}

if (!$has_lunar_7) {
    echo "   - Tháng 7 dương 2025 KHÔNG CÓ ngày nào thuộc tháng 7 âm\n";
    echo "   - Nên không hiển thị bảng tháng 7 âm là ĐÚNG\n";
} else {
    echo "   - Tháng 7 dương 2025 CÓ ngày thuộc tháng 7 âm\n";
    echo "   - Cần hiển thị bảng tháng 7 âm\n";
}