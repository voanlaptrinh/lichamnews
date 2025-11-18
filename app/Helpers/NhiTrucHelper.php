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
            // Hoàn toàn theo Dart implementation
            $lunarDate = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);
            $lunarMonth = (int) $lunarDate[1];

            // Lấy Chi từ Can Chi ngày (giống Dart: getCanChiDay().split(' ')[1])
            $jd = LunarHelper::jdFromDate($dd, $mm, $yy);
            $canChiDay = LunarHelper::canchiNgayByJD($jd);
            $chi = explode(' ', $canChiDay)[1] ?? '';

            // Lấy tên tiết khí (giống Dart: getTietKhiName(date))
            $tietKhi = LunarHelper::tietKhiByJD( $jd);

            // Lấy Kiến Chi (giống Dart: _getKienChi(tietKhi, lunarDate.month))
            $kienChi = self::getKienChi($tietKhi, $lunarMonth);

            // Danh sách Trực cố định (giống Dart)
            $trucList = [
                'Kiến', 'Trừ', 'Mãn', 'Bình', 'Định', 'Chấp',
                'Phá', 'Nguy', 'Thành', 'Thu', 'Khai', 'Bế'
            ];

            // Tính chỉ số Trực (điều chỉnh theo logic app: thêm +1 offset)
            $trucIdx = (self::getChiIndex($chi) - self::getChiIndex($kienChi) + 12) % 12;
            // Debug log giống Dart
            if (class_exists('\Illuminate\Support\Facades\Log')) {
                try {
                    Log::debug("[TRUC] Date: {$dd}/{$mm}/{$yy}, Lunar: {$lunarDate[0]}/{$lunarDate[1]}, Chi: $chi, TietKhi: $tietKhi, Truc: {$trucList[$trucIdx]}");
                } catch (\Exception $logError) {
                    // Silent ignore
                }
            }

            return $trucList[$trucIdx];

        } catch (\Exception $e) {
            if (class_exists('\Illuminate\Support\Facades\Log')) {
                try {
                    Log::error("[TRUC] Error: " . $e->getMessage());
                } catch (\Exception $logError) {
                    error_log("[TRUC] Error: " . $e->getMessage());
                }
            }
            return "Kiến"; // Fallback giống Dart
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
        // Hoàn toàn giống Dart implementation _getChiIndex
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

        // Return index hoặc 0 (giống Dart: ?? 0)
        return $chiMapping[$chi] ?? 0;
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
