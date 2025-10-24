<?php
require 'vendor/autoload.php';
use App\Helpers\LunarHelper;

echo "=== DEBUG THÁNG NHUẬN 2025 ===\n\n";

// Lấy thông tin năm 2025
$a11_2024 = LunarHelper::getLunarMonth11(2024, 7.0);
$a11_2025 = LunarHelper::getLunarMonth11(2025, 7.0);
$b11_2025 = LunarHelper::getLunarMonth11(2026, 7.0);

echo "1. Thông tin tháng 11 âm lịch:\n";
echo "   Tháng 11 âm 2024 (a11_2024): JD = $a11_2024\n";
echo "   Tháng 11 âm 2025 (a11_2025): JD = $a11_2025\n";
echo "   Tháng 11 âm 2026 (b11_2025): JD = $b11_2025\n";

$diff = $a11_2025 - $a11_2024;
echo "   Khoảng cách a11_2025 - a11_2024 = $diff ngày\n";
if ($diff > 365) {
    echo "   => Năm 2025 CÓ tháng nhuận\n";

    $leapOff = LunarHelper::getLeapMonthOffset($a11_2024, 7.0);
    $leapMonth = $leapOff - 2;
    if ($leapMonth < 0) {
        $leapMonth += 12;
    }
    echo "   LeapOffset = $leapOff\n";
    echo "   Tháng nhuận = $leapMonth\n";
} else {
    echo "   => Năm 2025 KHÔNG có tháng nhuận\n";
}

echo "\n2. Test convertLunar2Solar với tháng 11:\n";

// Test tháng 11 thường
echo "   Tháng 11 thường:\n";
$a11 = LunarHelper::getLunarMonth11(2025, 7.0);
$b11 = LunarHelper::getLunarMonth11(2026, 7.0);
echo "      a11 = $a11, b11 = $b11\n";
echo "      b11 - a11 = " . ($b11 - $a11) . "\n";

if ($b11 - $a11 > 365) {
    $leapOff = LunarHelper::getLeapMonthOffset($a11, 7.0);
    $leapMonth = $leapOff - 2;
    if ($leapMonth < 0) {
        $leapMonth += 12;
    }
    echo "      Có tháng nhuận: tháng $leapMonth\n";

    // Check điều kiện cho tháng 11 nhuận
    $lunarLeap = 1; // Muốn tháng nhuận
    $lunarMonth = 11;
    if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
        echo "      Tháng 11 nhuận KHÔNG hợp lệ (tháng nhuận thực sự là tháng $leapMonth)\n";
    } else {
        echo "      Tháng 11 nhuận hợp lệ\n";
    }
}

echo "\n3. Test thực tế:\n";
// Kiểm tra tháng 6 nhuận (hợp lệ)
$test6 = LunarHelper::convertLunar2Solar(1, 6, 2025, 1);
echo "   Tháng 6 nhuận 2025: {$test6[0]}/{$test6[1]}/{$test6[2]}\n";

// Kiểm tra tháng 11 nhuận (không hợp lệ?)
$test11 = LunarHelper::convertLunar2Solar(1, 11, 2025, 1);
echo "   Tháng 11 nhuận 2025: {$test11[0]}/{$test11[1]}/{$test11[2]}\n";
if ($test11[0] == 0) {
    echo "   => Hàm trả về (0,0,0) - tháng không hợp lệ\n";
} else {
    echo "   => BUG: Hàm trả về ngày hợp lệ cho tháng nhuận không tồn tại!\n";
}