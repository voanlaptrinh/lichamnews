<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class NhiTrucHelper
{
    //Hàm lấy ra thập nhị trực
    /**
     * Lấy Kiến Chi (Nguyệt Kiến) của một tháng âm lịch.
     * Đây là quy tắc cố định.
     * @param int $lunarMonth
     * @return string
     */
    private static function getKienChiByLunarMonth(int $lunarMonth): string
    {
        // Mảng Kiến Chi tương ứng với tháng Âm lịch (tháng 1 => Dần, tháng 2 => Mão...)
        $kienChiMapping = [
            1 => 'Dần', 2 => 'Mão', 3 => 'Thìn', 4 => 'Tỵ', 5 => 'Ngọ', 6 => 'Mùi',
            7 => 'Thân', 8 => 'Dậu', 9 => 'Tuất', 10 => 'Hợi', 11 => 'Tý', 12 => 'Sửu'
        ];
        return $kienChiMapping[$lunarMonth] ?? 'Dần'; // Fallback về Dần cho tháng 1
    }
       /**
     * Lấy Trực của một ngày dương lịch.
     *
     * @param int $dd Ngày dương
     * @param int $mm Tháng dương
     * @param int $yy Năm dương
     * @return string
     */
    public static function getTruc(int $dd, int $mm, int $yy): string
    {
        try {
            // BƯỚC 1: Lấy thông tin cơ bản từ ngày dương lịch
            $lunarDate = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);
            $lunarMonth = (int) $lunarDate[1];

            // Lấy Julian Day trực tiếp từ ngày Dương lịch cho chính xác
            $jd = LunarHelper::jdFromDate($dd, $mm, $yy);

            // BƯỚC 2: Xác định Chi của ngày từ Can Chi
            $canChiNgay = LunarHelper::canchiNgayByJD($jd);
            $parts = explode(' ', $canChiNgay);
            if (count($parts) !== 2) {
                throw new \Exception("Invalid Can Chi format for day: $canChiNgay");
            }
            $chiNgay = $parts[1];

            // BƯỚC 3: Lấy tiết khí và xác định Kiến Chi
            $tietKhi = LunarHelper::tietKhiByJD($jd);
            $kienChi = self::getKienChi($tietKhi, $lunarMonth);

            // BƯỚC 4: Tính toán Trực theo công thức chuẩn
            $trucList = [
                'Kiến', 'Trừ', 'Mãn', 'Bình', 'Định', 'Chấp',
                'Phá', 'Nguy', 'Thành', 'Thu', 'Khai', 'Bế'
            ];

            $chiNgayIndex = self::getChiIndex($chiNgay);
            $kienChiIndex = self::getChiIndex($kienChi);

            if ($chiNgayIndex === -1 || $kienChiIndex === -1) {
                throw new \Exception("Không tìm thấy chỉ số cho Chi ngày ($chiNgay) hoặc Kiến Chi ($kienChi).");
            }

            // Công thức tính chỉ số của Trực (từ Dart implementation)
            $trucIdx = ($chiNgayIndex - $kienChiIndex + 12) % 12;

            return $trucList[$trucIdx];
        } catch (\Exception $e) {
            // Log error nếu có thể
            if (class_exists('\Illuminate\Support\Facades\Log')) {
                try {
                    Log::error("[getTruc] Error: " . $e->getMessage());
                } catch (\Exception $logError) {
                    error_log("[getTruc] Error: " . $e->getMessage());
                }
            }
            return "Kiến"; // fallback nếu có lỗi
        }
    }



    public static function getKienChi(string $tietKhi, int $lunarMonth): string
    {
        // Normalize tiết khí string để tránh lỗi matching
        $tietKhiNormalized = trim($tietKhi);

        // Kiểm tra exact match trước (case insensitive) - theo Dart implementation
        foreach (DataHelper::$tietKhiToKienChi as $key => $value) {
            if (mb_strtolower($tietKhiNormalized, 'UTF-8') === mb_strtolower(trim($key), 'UTF-8')) {
                return $value;
            }
        }

        // Nếu không có exact match, kiểm tra substring (case insensitive)
        foreach (DataHelper::$tietKhiToKienChi as $key => $value) {
            if (stripos($tietKhiNormalized, trim($key)) !== false) {
                return $value;
            }
        }

        // Fallback theo tháng âm lịch - sử dụng mảng chuẩn như Dart
        $kienChiByMonth = [
            'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi',
            'Thân', 'Dậu', 'Tuất', 'Hợi', 'Tý', 'Sửu'
        ];

        return $kienChiByMonth[($lunarMonth - 1) % 12];
    }

    public static function getChiIndex(string $chi): int
    {
        // Mapping chính xác theo Dart implementation
        $chiMapping = [
            'Tý' => 0,
            'Sửu' => 1,
            'Dần' => 2,
            'Mão' => 3,
            'Thìn' => 4,
            'Tỵ' => 5,
            'Ngọ' => 6,
            'Mùi' => 7,
            'Thân' => 8,
            'Dậu' => 9,
            'Tuất' => 10,
            'Hợi' => 11
        ];

        // Normalize chi string
        $normalized = ucfirst(mb_strtolower(trim($chi), 'UTF-8'));

        // Tìm kiếm case-insensitive trong mapping
        foreach ($chiMapping as $chiName => $index) {
            if (mb_strtolower($normalized, 'UTF-8') === mb_strtolower($chiName, 'UTF-8')) {
                return $index;
            }
        }

        // Log lỗi nếu không tìm thấy
        if (class_exists('\Illuminate\Support\Facades\Log')) {
            try {
                Log::error("[getChiIndex] Không tìm thấy chỉ số Chi cho: '$chi' (normalized: '$normalized')");
            } catch (\Exception $e) {
                error_log("[getChiIndex] Không tìm thấy chỉ số Chi cho: '$chi' (normalized: '$normalized')");
            }
        }

        return -1; // Fallback return -1 như Dart implementation
    }
    public static function getTrucRating(string $trucName, string $purpose): float
    {
        if (
            !isset(DataHelper::$TRUC_RATING_BY_PURPOSE[$purpose]) ||
            !isset(DataHelper::$TRUC_RATING_BY_PURPOSE[$purpose][$trucName])
        ) {
            return DataHelper::$TRUC_RATING_BY_PURPOSE['TOT_XAU_CHUNG'][$trucName] ?? 0.0;
        }

        return DataHelper::$TRUC_RATING_BY_PURPOSE[$purpose][$trucName];
    }
    public static function checkTrucIssues(string $trucName, string $purpose): array
    {
        $issues = [];

        if (
            isset(DataHelper::$EXCLUSION_TRUC[$purpose]) &&
            in_array($trucName, DataHelper::$EXCLUSION_TRUC[$purpose])
        ) {
            $issues[] = [
                'level' => 'exclude',
                'source' => '12Truc',
                'reason' => "Thập nhị trực: Trực $trucName",
                'details' => [
                    'trucName' => $trucName,
                    'displayName' => "Trực $trucName",
                    'purpose' => $purpose
                ]
            ];
        }

        return $issues;
    }
}
