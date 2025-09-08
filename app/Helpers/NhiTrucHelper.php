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
            // BƯỚC 1: Lấy thông tin cơ bản
            // Chuyển đổi sang Âm lịch chỉ để lấy tháng âm
            $lunarDate = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);
            $lunarMonth = (int) $lunarDate[1];

            // Lấy Julian Day trực tiếp từ ngày Dương lịch cho chính xác
            $jd = LunarHelper::jdFromDate($dd, $mm, $yy);

            // BƯỚC 2: Xác định Chi của ngày
            $canChiNgay = LunarHelper::canchiNgayByJD($jd);
            $chiNgay = explode(' ', $canChiNgay)[1] ?? null;

            if (!$chiNgay) {
                throw new \Exception("Không xác định được Chi của ngày.");
            }

            // BƯỚC 3: Xác định Kiến Chi của tháng (đã sửa lại theo đúng quy tắc)
            $tietKhi = LunarHelper::tietKhiByJD($jd);
            $kienChi = self::getKienChi($tietKhi, $lunarMonth);

            // BƯỚC 4: Tính toán Trực
            $trucList = [
                'Kiến', 'Trừ', 'Mãn', 'Bình', 'Định', 'Chấp',
                'Phá', 'Nguy', 'Thành', 'Thu', 'Khai', 'Bế'
            ];

            $chiNgayIndex = self::getChiIndex($chiNgay);
            $kienChiIndex = self::getChiIndex($kienChi);

            if ($chiNgayIndex === -1 || $kienChiIndex === -1) {
                throw new \Exception("Không tìm thấy chỉ số cho Chi ngày ($chiNgay) hoặc Kiến Chi ($kienChi).");
            }
            
            // Công thức tính chỉ số của Trực
            $trucIdx = ($chiNgayIndex - $kienChiIndex + 12) % 12;

            return $trucList[$trucIdx];
        } catch (\Exception $e) {
            // Log::error("[TRUC] Error: " . $e->getMessage());
            // echo "[TRUC] Error: " . $e->getMessage();
            return "Kiến"; // fallback nếu có lỗi
        }
    }


    public static function getKienChi(string $tietKhi, int $lunarMonth): string
    {

        foreach (DataHelper::$tietKhiToKienChi as $key => $value) {
            if (stripos($tietKhi, $key) !== false) {
                return $value;
            }
        }

        // Fallback theo tháng âm
        $kienChiTheoThang = [
            1 => 'Dần',
            2 => 'Mão',
            3 => 'Thìn',
            4 => 'Tỵ',
            5 => 'Ngọ',
            6 => 'Mùi',
            7 => 'Thân',
            8 => 'Dậu',
            9 => 'Tuất',
            10 => 'Hợi',
            11 => 'Tý',
            12 => 'Sửu',
        ];

        return $kienChiTheoThang[$lunarMonth] ?? 'Dần';
    }

    public static function getChiIndex(string $chi): int
    {
        $chiList = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];
        $normalized = ucfirst(mb_strtolower(trim($chi), 'UTF-8'));
        $index = array_search($normalized, $chiList);

        if ($index === false) {
            Log::error("[getChiIndex] Không tìm thấy chỉ số Chi cho: '$chi' (normalized: '$normalized')");
            return -1;
        }

        return $index;
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
