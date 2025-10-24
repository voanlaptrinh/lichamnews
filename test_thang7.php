<?php
require 'vendor/autoload.php';
use App\Helpers\LunarHelper;

echo "=== KIỂM TRA THÁNG 7 ===\n\n";

// Kiểm tra tháng 7 âm trong các năm
echo "1. Tìm tháng 7 âm trong các năm:\n";
for ($year = 2023; $year <= 2026; $year++) {
    // Tháng 7 thường
    $result = LunarHelper::convertLunar2Solar(1, 7, $year, 0);
    if ($result[0] > 0) {
        echo "   Tháng 7/$year (âm): 1/7/$year = {$result[0]}/{$result[1]}/{$result[2]} (dương)\n";

        // Kiểm tra ngày 15
        $result15 = LunarHelper::convertLunar2Solar(15, 7, $year, 0);
        echo "                        15/7/$year = {$result15[0]}/{$result15[1]}/{$result15[2]} (dương)\n";

        // Kiểm tra ngày cuối
        $result29 = LunarHelper::convertLunar2Solar(29, 7, $year, 0);
        echo "                        29/7/$year = {$result29[0]}/{$result29[1]}/{$result29[2]} (dương)\n";

        // Kiểm tra xem có ngày nào trong tháng 7 dương không
        $has_july = false;
        if ($result[1] == 7 || $result15[1] == 7 || $result29[1] == 7) {
            $has_july = true;
            echo "                        => CÓ ngày trong tháng 7 dương\n";
        } else {
            echo "                        => KHÔNG có ngày trong tháng 7 dương\n";
        }
    }
}

echo "\n2. Logic hiện tại cho tháng 7/2024:\n";
$thang = 7;
$nam = 2024;
$lunar_years_to_check = [$nam - 1, $nam, $nam + 1];

echo "   Các năm âm sẽ kiểm tra: " . implode(', ', $lunar_years_to_check) . "\n";

foreach ($lunar_years_to_check as $lunar_year) {
    // Kiểm tra tháng thường
    list($solar_d, $solar_m, $solar_y) = LunarHelper::convertLunar2Solar(1, $thang, $lunar_year, 0);

    if ($solar_d > 0) {
        echo "\n   Tháng 7/$lunar_year (âm):\n";
        echo "      Ngày 1: $solar_d/$solar_m/$solar_y\n";

        // Kiểm tra điều kiện
        $has_days = false;
        if ($solar_m == $thang && $solar_y == $nam) {
            echo "      => Ngày 1 THUỘC tháng 7/2024\n";
            $has_days = true;
        } else {
            // Kiểm tra ngày 15
            list($mid_d, $mid_m, $mid_y) = LunarHelper::convertLunar2Solar(15, $thang, $lunar_year, 0);
            echo "      Ngày 15: $mid_d/$mid_m/$mid_y\n";
            if ($mid_m == $thang && $mid_y == $nam) {
                echo "      => Ngày 15 THUỘC tháng 7/2024\n";
                $has_days = true;
            } else {
                // Kiểm tra ngày 29
                list($end_d, $end_m, $end_y) = LunarHelper::convertLunar2Solar(29, $thang, $lunar_year, 0);
                echo "      Ngày 29: $end_d/$end_m/$end_y\n";
                if ($end_m == $thang && $end_y == $nam) {
                    echo "      => Ngày 29 THUỘC tháng 7/2024\n";
                    $has_days = true;
                }
            }
        }

        if (!$has_days) {
            echo "      => KHÔNG có ngày nào thuộc tháng 7/2024\n";
        }
    }
}

echo "\n3. Giải pháp: Luôn hiển thị tháng âm cùng số gần nhất\n";
echo "   Nếu không có ngày nào của tháng 7 âm trong tháng 7 dương,\n";
echo "   vẫn hiển thị tháng 7 âm gần nhất để người dùng tham khảo.\n";