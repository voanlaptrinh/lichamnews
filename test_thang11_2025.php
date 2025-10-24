<?php
require 'vendor/autoload.php';
use App\Helpers\LunarHelper;

echo "=== KIỂM TRA THÁNG 11/2025 ===\n\n";

// Kiểm tra tháng nhuận năm 2025
echo "1. Kiểm tra tháng nào là tháng nhuận năm 2025:\n";
for ($month = 1; $month <= 12; $month++) {
    $result = LunarHelper::convertLunar2Solar(1, $month, 2025, 1);
    if ($result[0] > 0) {
        echo "   Tháng $month nhuận 2025: CÓ TỒN TẠI - Ngày 1 = {$result[0]}/{$result[1]}/{$result[2]}\n";
    }
}

echo "\n2. Chi tiết tháng 11 âm lịch năm 2025:\n";
// Tháng 11 thường
$result = LunarHelper::convertLunar2Solar(1, 11, 2025, 0);
if ($result[0] > 0) {
    echo "   Tháng 11 thường 2025:\n";
    echo "      Ngày 1/11/2025 = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";

    $result15 = LunarHelper::convertLunar2Solar(15, 11, 2025, 0);
    echo "      Ngày 15/11/2025 = {$result15[0]}/{$result15[1]}/{$result15[2]} (dương)\n";

    $result29 = LunarHelper::convertLunar2Solar(29, 11, 2025, 0);
    echo "      Ngày 29/11/2025 = {$result29[0]}/{$result29[1]}/{$result29[2]} (dương)\n";
} else {
    echo "   Tháng 11 thường 2025: KHÔNG TỒN TẠI\n";
}

// Tháng 11 nhuận
$result = LunarHelper::convertLunar2Solar(1, 11, 2025, 1);
if ($result[0] > 0) {
    echo "   Tháng 11 nhuận 2025:\n";
    echo "      Ngày 1/11n/2025 = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";

    $result15 = LunarHelper::convertLunar2Solar(15, 11, 2025, 1);
    echo "      Ngày 15/11n/2025 = {$result15[0]}/{$result15[1]}/{$result15[2]} (dương)\n";

    $result29 = LunarHelper::convertLunar2Solar(29, 11, 2025, 1);
    echo "      Ngày 29/11n/2025 = {$result29[0]}/{$result29[1]}/{$result29[2]} (dương)\n";
} else {
    echo "   Tháng 11 nhuận 2025: KHÔNG TỒN TẠI\n";
}

echo "\n3. Kiểm tra ngược từ tháng 11 dương 2025:\n";
for ($day = 1; $day <= 30; $day++) {
    $lunar = LunarHelper::convertSolar2Lunar($day, 11, 2025);
    if ($lunar[3] == 1) { // Nếu là tháng nhuận
        echo "   {$day}/11/2025 = {$lunar[0]}/{$lunar[1]}" . ($lunar[3] ? 'n' : '') . "/{$lunar[2]} (âm)\n";
    }
}

echo "\n4. Kết luận:\n";
$thang11_nhuan = LunarHelper::convertLunar2Solar(1, 11, 2025, 1);
if ($thang11_nhuan[0] > 0) {
    echo "   Năm 2025 CÓ tháng 11 nhuận - có lỗi trong dữ liệu\n";
} else {
    echo "   Năm 2025 KHÔNG có tháng 11 nhuận\n";
    echo "   => Nếu hiển thị tháng 11 nhuận là LỖI\n";
}

// Kiểm tra tháng 11 các năm khác
echo "\n5. Tháng 11 nhuận trong các năm lân cận:\n";
for ($year = 2020; $year <= 2030; $year++) {
    $result = LunarHelper::convertLunar2Solar(1, 11, $year, 1);
    if ($result[0] > 0) {
        echo "   Năm $year: CÓ tháng 11 nhuận\n";
    }
}