<?php
require 'vendor/autoload.php';
use App\Helpers\LunarHelper;

echo "=== KIỂM TRA THÁNG 6 NHUẬN NĂM 2025 ===\n\n";

// Kiểm tra tháng 6 thường năm 2025
echo "1. Tháng 6 thường năm 2025:\n";
$result = LunarHelper::convertLunar2Solar(1, 6, 2025, 0);
echo "   Ngày 1/6/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(15, 6, 2025, 0);
echo "   Ngày 15/6/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(29, 6, 2025, 0);
echo "   Ngày 29/6/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(30, 6, 2025, 0);
echo "   Ngày 30/6/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n\n";

// Kiểm tra tháng 6 nhuận năm 2025
echo "2. Tháng 6 nhuận năm 2025:\n";
$result = LunarHelper::convertLunar2Solar(1, 6, 2025, 1);
echo "   Ngày 1/6n/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(15, 6, 2025, 1);
echo "   Ngày 15/6n/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(29, 6, 2025, 1);
echo "   Ngày 29/6n/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";
$result = LunarHelper::convertLunar2Solar(30, 6, 2025, 1);
echo "   Ngày 30/6n/2025 (âm) = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n\n";

// Kiểm tra ngược lại
echo "3. Kiểm tra ngược từ dương sang âm:\n";
for ($d = 1; $d <= 31; $d++) {
    if ($d <= 31 && checkdate(7, $d, 2025)) {
        $result = LunarHelper::convertSolar2Lunar($d, 7, 2025);
        if ($result[1] == 6 && $result[3] == 1) { // tháng 6 nhuận
            echo "   Ngày {$d}/7/2025 (dương) = {$result[0]}/{$result[1]}" . ($result[3] ? 'n' : '') . "/{$result[2]} (âm)\n";
        }
    }
}

echo "\n4. Kiểm tra tháng 6 và 7 dương lịch 2025:\n";
// Tháng 6 dương
echo "   Tháng 6 dương 2025:\n";
for ($d = 1; $d <= 30; $d++) {
    $result = LunarHelper::convertSolar2Lunar($d, 6, 2025);
    if ($result[1] == 6) {
        echo "     {$d}/6/2025 = {$result[0]}/{$result[1]}" . ($result[3] ? 'n' : '') . "/{$result[2]}\n";
    }
}

echo "\n   Tháng 7 dương 2025:\n";
for ($d = 1; $d <= 31; $d++) {
    $result = LunarHelper::convertSolar2Lunar($d, 7, 2025);
    if ($result[1] == 6) {
        echo "     {$d}/7/2025 = {$result[0]}/{$result[1]}" . ($result[3] ? 'n' : '') . "/{$result[2]}\n";
    }
}

echo "\n5. Tổng kết:\n";
$start_leap = LunarHelper::convertLunar2Solar(1, 6, 2025, 1);
$end_leap_30 = LunarHelper::convertLunar2Solar(30, 6, 2025, 1);
$end_leap_29 = LunarHelper::convertLunar2Solar(29, 6, 2025, 1);

if ($start_leap[0] > 0) {
    echo "   Tháng 6 nhuận 2025 BẮT ĐẦU: {$start_leap[0]}/{$start_leap[1]}/{$start_leap[2]}\n";
    if ($end_leap_30[0] > 0) {
        echo "   Tháng 6 nhuận 2025 KẾT THÚC: {$end_leap_30[0]}/{$end_leap_30[1]}/{$end_leap_30[2]} (30 ngày)\n";
    } else if ($end_leap_29[0] > 0) {
        echo "   Tháng 6 nhuận 2025 KẾT THÚC: {$end_leap_29[0]}/{$end_leap_29[1]}/{$end_leap_29[2]} (29 ngày)\n";
    }
}