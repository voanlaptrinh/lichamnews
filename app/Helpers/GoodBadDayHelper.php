<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;

class GoodBadDayHelper
{
    /**
     * Tính toán điểm và các yếu tố của một ngày dựa trên mục đích.
     * Phiên bản này đã được sửa lại để khớp với logic của code Dart.
     *
     * @param Carbon      $date       Ngày cần tính (nên dùng Carbon).
     * @param string       $birthDate  Ngày sinh của gia chủ (nếu có).
     * @param string      $purpose    Mục đích (ví dụ: 'CuoiHoi').
     * @return array
     */
    public static function calculateDayScore(Carbon $date, $birthDate, string $purpose): array
    {
        $isPersonalized = $birthDate !== null;
        // SỬA 2: Luôn kiểm tra với mảng PERSONALIZED để đảm bảo logic giống Dart
        $targetWeights = $isPersonalized ? DataHelper::$PURPOSE_WEIGHTS_PERSONALIZED : DataHelper::$PURPOSE_WEIGHTS_GENERAL;
        $effectivePurpose = array_key_exists($purpose, $targetWeights)
            ? $purpose
            : 'TOT_XAU_CHUNG';

        $allIssues = [];

        // 1. Check Taboo Days
        $tabooResult = self::checkTabooDays($date, $effectivePurpose);
        $allIssues = array_merge($allIssues, $tabooResult['issues'] ?? []);
        $carbonDate = Carbon::instance($date);
        // 2. Thái Tuế (nếu có ngày sinh)
        if (!empty($isPersonalized)) {

            $jd = LunarHelper::jdFromDate((int)$carbonDate->day, (int)$carbonDate->month, (int)$carbonDate->year);

            $dayCanChi = LunarHelper::canchiNgayByJD($jd);

            $birthCanChi = LunarHelper::canchiNam($birthDate);

            $dayChi = explode(' ', $dayCanChi)[1];
            $birthChi = explode(' ', $birthCanChi)[1];
            $thaiTueResult = ThaiTueHelper::evaluateThaiTueByPurpose($dayChi, $birthChi, $effectivePurpose);
            $allIssues = array_merge($allIssues, $thaiTueResult['issues'] ?? []);
        }

        // 3. Văn Khí
        $vanKhiResult = KhiVanHelper::calculateVanKhi($effectivePurpose, $date, $birthDate);
        $vanKhiNormalized = (float) $vanKhiResult['normalizedScore'];
        $vanKhiWeightedScore = $vanKhiNormalized * self::getWeight($effectivePurpose, 'VanKhi', $isPersonalized);
        $allIssues = array_merge($allIssues, $vanKhiResult['issues'] ?? []);

        // 4. Cát Hung
        $catHungResult = CatHungHelper::evaluateCatHung($date, $effectivePurpose);
        $catHungScoreValue = (float) $catHungResult['score'];
        $catHungWeightedScore = $catHungScoreValue * self::getWeight($effectivePurpose, 'CatHung', $isPersonalized);
        $allIssues = array_merge($allIssues, $catHungResult['issues'] ?? []);

        // 5. 28 Tú
        $starName = NhiThapBatTuHelper::getNhiThapBatTu($date)['name'];
        $starNametitle = NhiThapBatTuHelper::getNhiThapBatTu($date);
        $tuScoreValue = NhiThapBatTuHelper::getStarRating($starName, $effectivePurpose);
        $tuWeightedScore = $tuScoreValue * self::getWeight($effectivePurpose, '28Tu', $isPersonalized);
        $tuIssues = NhiThapBatTuHelper::checkStarIssues($starName, $effectivePurpose);
        $allIssues = array_merge($allIssues, $tuIssues);

        // 6. 12 Trực
        $trucName = NhiTrucHelper::getTruc((int)$carbonDate->day, (int)$carbonDate->month, (int)$carbonDate->year);
        $trucScoreValue = NhiTrucHelper::getTrucRating($trucName, $effectivePurpose);
        $trucWeightedScore = $trucScoreValue * self::getWeight($effectivePurpose, '12Truc', $isPersonalized);
        $trucIssues = NhiTrucHelper::checkTrucIssues($trucName, $effectivePurpose);
        $allIssues = array_merge($allIssues, $trucIssues);

      


        // 7. Tổng hợp điểm có trọng số
        $totalWeights = self::getTotalWeight($effectivePurpose, $isPersonalized);
        $totalWeightedScore = $vanKhiWeightedScore + $catHungWeightedScore + $tuWeightedScore + $trucWeightedScore;

        // 8. Chuẩn hóa điểm cuối cùng về [-2, 2]
        // CẢI TIẾN 3: Rút gọn công thức cho dễ đọc, kết quả không đổi
        $normalizedScore = ($totalWeights == 0) ? 0.0 : ($totalWeightedScore / $totalWeights);


        // Kẹp giá trị trong khoảng [-2.0, 2.0]
        $normalizedScore = max(-2.0, min(2.0, $normalizedScore));

        // 9. Chuyển đổi sang tỷ lệ phần trăm (0% - 100%)
        $percentage = (($normalizedScore + 2.0) / 4.0) * 100.0;
        // Kẹp giá trị trong khoảng [0.0, 100.0]
        $percentage = max(0.0, min(100.0, $percentage));

        // Tạo biến mới để làm tròn percentage
        $roundedPercentage = round($percentage);

        // 10. Xác định đánh giá cuối cùng
        // SỬA 1: Dùng đúng các ngưỡng đánh giá như trong code Dart
        $rating = match (true) {
            $roundedPercentage == 100 => 'Rất tốt',
            $roundedPercentage >= 70 => 'Tốt',
            $roundedPercentage >= 40 => 'Trung bình',
            $roundedPercentage > 0 => 'Xấu',
            default => 'Rất xấu', // Khi percentage là 0
        };

        // CẢI TIẾN 4: Loại bỏ các issues trùng lặp một cách an toàn
        $uniqueIssues = [];
        $tempHashes = [];
        foreach ($allIssues as $issue) {
            $hash = json_encode($issue); // Chuyển mảng thành chuỗi JSON để so sánh
            if (!in_array($hash, $tempHashes)) {
                $tempHashes[] = $hash;
                $uniqueIssues[] = $issue;
            }
        }

        // Tính toán các yếu tố hỗ trợ
        $supportFactors = self::calculateSupportFactors($date, $birthDate);

        // Lấy thông tin tuổi kỵ
        $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
        $dayCanChi = LunarHelper::canchiNgayByJD($jd);
        $dayChiParts = explode(' ', $dayCanChi);
        $dayChi = $dayChiParts[1] ?? '';
        $cucKhiInfo = FengShuiHelper::getCucKhiHopXung($dayChi);

        // 10. Tính phần trăm cho từng thành phần
        // Chuyển đổi điểm từ [-2, 2] sang [0, 100]%
        $vanKhiPercentage = (($vanKhiNormalized + 2.0) / 4.0) * 100.0;
        $vanKhiPercentage = max(0.0, min(100.0, $vanKhiPercentage));

        $catHungPercentage = (($catHungScoreValue + 2.0) / 4.0) * 100.0;
        $catHungPercentage = max(0.0, min(100.0, $catHungPercentage));

        $tuPercentage = (($tuScoreValue + 2.0) / 4.0) * 100.0;
        $tuPercentage = max(0.0, min(100.0, $tuPercentage));

        $trucPercentage = (($trucScoreValue + 2.0) / 4.0) * 100.0;
        $trucPercentage = max(0.0, min(100.0, $trucPercentage));

        // --- Trả về kết quả cuối cùng ---
        return [
            'checkTabooDays' => $tabooResult ?? '',
            'score' => $normalizedScore,
            'percentage' => round($percentage, 2), // Làm tròn phần trăm cho đẹp
            'rating' => $rating,
            'issues' => $uniqueIssues,
            'vanKhi' => [
                'score' => $vanKhiNormalized,
                'weightedScore' => $vanKhiWeightedScore,
                'percentage' => round($vanKhiPercentage, 2),
                'details' => $vanKhiResult['details'] ?? [],
            ],
            'catHung' => [
                'score' => $catHungScoreValue,
                'weightedScore' => $catHungWeightedScore,
                'percentage' => round($catHungPercentage, 2),
                'details' => $catHungResult['details'] ?? [],
            ],
            'tu' => [
                'score' => $tuScoreValue,
                'weightedScore' => $tuWeightedScore,
                'percentage' => round($tuPercentage, 2),
                'details' => [
                    'name' => $starName,
                    'data' => $starNametitle,
                    'tuIssues' => $tuIssues
                ],
            ],
            'truc' => [
                'score' => $trucScoreValue,
                'weightedScore' => $trucWeightedScore,
                'percentage' => round($trucPercentage, 2),
                'details' => ['name' => $trucName],
            ],
            // Thêm các yếu tố hỗ trợ
            'hoangdao' => $supportFactors['hoangdao'],
            'tructot' => $supportFactors['tructot'],
            'hopttuoi' => $supportFactors['hopttuoi'],
            'hopTuoiReason' => $supportFactors['hopTuoiReason'] ?? '',
            'good_stars' => $supportFactors['good_stars'],
            'positive_factors' => $supportFactors['positive_factors'],
         
        ];
    }

    /**
     * Kiểm tra các ngày kỵ cho một ngày cụ thể và mục đích.
     *
     * @param Carbon $date      Ngày cần kiểm tra.
     * @param string $purpose   Mục đích (ví dụ: 'CUOI_HOI').
     * @return array            Trả về một mảng chứa key 'issues'.
     */
    public static function checkTabooDays(Carbon $date, string $purpose): array
    {
        // Lấy danh sách các ngày kỵ áp dụng cho ngày $date

        $tabooDays = self::getApplicableTabooDays($date);
        $issues = [];

        foreach ($tabooDays as $tabooDay) {
            // Đảm bảo $tabooDay là một mảng và có key 'name'
            if (!is_array($tabooDay) || !isset($tabooDay['name'])) {
                continue;
            }

            $tabooName = $tabooDay['name'];
            $description = $tabooDay['description'] ?? ''; // Dùng toán tử ?? cho an toàn
            $severity = 'none'; // Giá trị mặc định

            // 1. Xác định mức độ nghiêm trọng (severity)
            // Ưu tiên tra cứu trong mục đích cụ thể trước
            if (isset(DataHelper::$SEVERITY_BY_PURPOSE[$purpose][$tabooName])) {
                $severity = DataHelper::$SEVERITY_BY_PURPOSE[$purpose][$tabooName];
            }
            // Nếu không có, tra cứu trong mục đích chung 'TOT_XAU_CHUNG'
            elseif (isset(DataHelper::$SEVERITY_BY_PURPOSE['TOT_XAU_CHUNG'][$tabooName])) {
                $severity = DataHelper::$SEVERITY_BY_PURPOSE['TOT_XAU_CHUNG'][$tabooName];
            }

            // 2. Nếu mức độ là 'exclude' hoặc 'warn', tạo issue
            if ($severity === 'exclude' || $severity === 'warn') {
                $reasonText = "$tabooName: $description";

                // Chỉ thêm phần giải thích liên quan đến mục đích nếu không phải là 'TOT_XAU_CHUNG'
                if ($purpose !== 'TOT_XAU_CHUNG') {
                    // Lấy tên hiển thị của mục đích
                    $purposeDisplayName = KhiVanHelper::getPurposeDisplayName($purpose);

                    if ($severity === 'exclude') {
                        $reasonText .= " - Kỵ thực hiện $purposeDisplayName";
                    } else { // severity === 'warn'
                        $reasonText .= " - Thận trọng khi thực hiện $purposeDisplayName";
                    }
                }

                $issues[] = [
                    'level' => $severity,
                    'source' => 'Taboo',
                    'reason' => $reasonText,
                    'details' => ['tabooName' => $tabooName],
                ];
            }
        }

        return ['issues' => $issues];
    }

    public static function getTabooDays(Carbon $date): array
    {

        return [
            "Tam Nương" => self::isTamNuong($date),
            "Nguyệt Kỵ" => self::isNguyetKy($date),
            "Nguyệt Tận" => self::isNguyetTan($date),
            "Dương Công Kỵ Nhật" => self::isDuongCongKyNhat($date),
            "Sát Chủ Âm" => self::isSatChuAm($date),
            "Sát Chủ Dương" => self::isSatChuDuong($date),
            "Kim Thần Thất Sát" => self::isKimThanThatSat($date),
            "Trùng Phục" => self::isTrungPhuc($date),
            "Thụ Tử" => self::isThuTu($date),
        ];
    }

    public static function getApplicableTabooDays(Carbon $date): array
    {
        $tabooDays = self::getTabooDays($date);

        $descriptions = DataHelper::$tabooDayDescriptions ?? [];

        $result = [];

        foreach ($tabooDays as $name => $isTaboo) {
            if ($isTaboo) {
                $result[] = [
                    'name' => $name,
                    'description' => $descriptions[$name] ?? '',
                ];
            }
        }

        return $result;
    }
    public static function isTamNuong(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);

        return in_array((int)$lunar[0], DataHelper::$tamNuongDays);
    }

    public static function isNguyetKy(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        return in_array((int)$lunar[0], DataHelper::$nguyetKyDays);
    }

    public static function isNguyetTan(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        // $lunar = [$lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $isFullMonth]
        $daysInMonth = self::getDaysInLunarMonth($lunar[2], $lunar[1], $lunar[3]);
        return $lunar[0] == $daysInMonth;
    }

    public static function isDuongCongKyNhat(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        $tabooDays = DataHelper::$duongCongKyNhat[$lunar[1]] ?? [];
        return in_array($lunar[0], $tabooDays);
    }

    public static function isSatChuAm(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day,  $month, $year);
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);
        $canchi = LunarHelper::canchiNgayByJD($jd);
        $chi_ngay = explode(' ', $canchi);
        $chi_ngay = $chi_ngay[1];
        return $chi_ngay === DataHelper::$satChuAm[$lunar[1]] ?? '';
    }

    public static function isSatChuDuong(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $lunar = lunarHelper::convertSolar2Lunar($day,  $month, $year);
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);
        $canchi = LunarHelper::canchiNgayByJD($jd);
        $chi_ngay = explode(' ', $canchi);
        $chi_ngay = $chi_ngay[1];
        return $chi_ngay === DataHelper::$satChuDuong[$lunar[1]] ?? '';
    }

    public static function isKimThanThatSat(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        $can = lunarHelper::canchiNam($year);
        $canNam = explode(' ', $can);
        $canNam = $canNam[0]; //Ất
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);
        $canchi = LunarHelper::canchiNgayByJD($jd);
        $chi_ngay = explode(' ', $canchi);
        $chi_ngay  = $chi_ngay[1];

        $forbiddenChis = DataHelper::$kimThanThatSat[$canNam] ?? [];
        return in_array($chi_ngay, $forbiddenChis);
    }

    public static function isTrungPhuc(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        // $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        // $can = lunarHelper::canchiNgay($year, $month, $day);

        // $can_ngay = explode(' ', $can);
        $lunar = lunarHelper::convertSolar2Lunar($day,  $month, $year);
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);

        $can = LunarHelper::canchiNgayByJD($jd);

        $can_ngay = explode(' ', $can);




        $can_ngay = $can_ngay[0];
        return $can_ngay === DataHelper::$trungPhuc[$lunar[1]] ?? '';
    }

    public static function isThuTu(\DateTime $date): bool
    {
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');
        // $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        // $chi = lunarHelper::canchiNgay($year, $month, $day);
        // $chi_ngay = explode(' ', $chi);

        $lunar = lunarHelper::convertSolar2Lunar($day, $month, $year);
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);

        $canChi = LunarHelper::canchiNgayByJD($jd);

        $chi_ngay = explode(' ', $canChi);

        $chi_ngay  = $chi_ngay[1];
        return $chi_ngay === DataHelper::$thuTu[$lunar[1]] ?? '';
    }
    protected static array $lunarMonthDaysCache = [];
    protected static int $maxCacheSize = 100;
    protected static int $MAX_CACHE_SIZE = 5000;

    public static function getDaysInLunarMonth(int $year, int $month, bool $isLeap): int
    {
        $cacheKey = "$year-$month-" . ($isLeap ? '1' : '0');

        if (array_key_exists($cacheKey, self::$lunarMonthDaysCache)) {
            return self::$lunarMonthDaysCache[$cacheKey];
        }

        try {
            // Use the same logic as API controller for consistency
            $days = self::calculateLunarMonthDays($month, $year, $isLeap ? 1 : 0);

            // Caching
            if (count(self::$lunarMonthDaysCache) >= self::$MAX_CACHE_SIZE) {
                array_shift(self::$lunarMonthDaysCache);
            }

            self::$lunarMonthDaysCache[$cacheKey] = $days;

            return $days;
        } catch (\Throwable $e) {
            Log::error("Lỗi tính ngày trong tháng âm lịch: " . $e->getMessage());
            return 29; // Giá trị mặc định an toàn
        }
    }

    /**
     * Calculate actual number of days in a lunar month using the same logic as API
     */
    private static function calculateLunarMonthDays($month, $year, $isLeap = 0)
    {
        try {
            // First check if the month/year/leap combination is valid
            $solarStart = @LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);

            if (!$solarStart || !isset($solarStart[0]) || $solarStart[0] == 0) {
                // Invalid month (probably doesn't have leap version if isLeap=1)
                return 0;
            }

            // Check if leap month actually exists by comparing with normal month
            if ($isLeap == 1) {
                $normalStart = @LunarHelper::convertLunar2Solar(1, $month, $year, 0);
                // If both return same date, there's no actual leap month
                if ($normalStart && $normalStart[0] == $solarStart[0] &&
                    $normalStart[1] == $solarStart[1] &&
                    $normalStart[2] == $solarStart[2]) {
                    return 0; // No leap month exists
                }
            }

            // Calculate days between start of this month and start of next month
            $currentMonthStart = LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);

            // Determine what the next lunar month is
            $nextMonth = $month;
            $nextYear = $year;
            $nextIsLeap = 0;

            if ($isLeap == 0) {
                // Current is normal month, check if leap version exists
                $leapTest = @LunarHelper::convertLunar2Solar(15, $month, $year, 1);
                $normalTest = @LunarHelper::convertLunar2Solar(15, $month, $year, 0);

                if ($leapTest && $normalTest &&
                    !($leapTest[0] == $normalTest[0] &&
                      $leapTest[1] == $normalTest[1] &&
                      $leapTest[2] == $normalTest[2])) {
                    // Leap month exists for this month number
                    $nextIsLeap = 1;
                } else {
                    // No leap month, go to next month number
                    $nextMonth++;
                    if ($nextMonth > 12) {
                        $nextMonth = 1;
                        $nextYear++;
                    }
                }
            } else {
                // Current is leap month, next is always the next regular month
                $nextMonth++;
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
            }

            // Get the first day of next month
            $nextMonthStart = @LunarHelper::convertLunar2Solar(1, $nextMonth, $nextYear, $nextIsLeap);

            if ($currentMonthStart && $nextMonthStart &&
                isset($currentMonthStart[0]) && isset($nextMonthStart[0])) {

                // Calculate the difference in days
                $currentDate = new \DateTime();
                $currentDate->setDate($currentMonthStart[2], $currentMonthStart[1], $currentMonthStart[0]);

                $nextDate = new \DateTime();
                $nextDate->setDate($nextMonthStart[2], $nextMonthStart[1], $nextMonthStart[0]);

                $interval = $currentDate->diff($nextDate);
                $days = $interval->days;

                // Lunar months are always 29 or 30 days
                if ($days == 29 || $days == 30) {
                    return $days;
                }
            }

            // Fallback method: Check if day 30 converts to valid date
            $day30 = @LunarHelper::convertLunar2Solar(30, $month, $year, $isLeap);

            if ($day30 && isset($day30[0]) && $day30[0] > 0) {
                // Check if day 30 is really in this month by comparing with day 29
                $day29 = @LunarHelper::convertLunar2Solar(29, $month, $year, $isLeap);

                if ($day29 && isset($day29[0])) {
                    $date29 = new \DateTime();
                    $date29->setDate($day29[2], $day29[1], $day29[0]);

                    $date30 = new \DateTime();
                    $date30->setDate($day30[2], $day30[1], $day30[0]);

                    $diff = $date29->diff($date30)->days;

                    // If day 30 is exactly 1 day after day 29, month has 30 days
                    if ($diff == 1) {
                        return 30;
                    }
                }
            }

            // Default to 29 days (most common for lunar months)
            return 29;

        } catch (\Exception $e) {
            // If conversion fails completely, return 0 to indicate invalid
            return 0;
        }
    }
    protected static function julianDayFromDate(int $day, int $month, int $year): float
    {
        // Tính Julian Day Number (JDN)
        if ($month <= 2) {
            $month += 12;
            $year -= 1;
        }

        $A = floor($year / 100);
        $B = 2 - $A + floor($A / 4);

        return floor(365.25 * ($year + 4716)) +
            floor(30.6001 * ($month + 1)) +
            $day + $B - 1524.5;
    }
    /**
     * Tính tổng trọng số cho một mục đích cụ thể.
     *
     * @param string $purpose      Mục đích cần tính (ví dụ: 'CuoiHoi', 'XayDung').
     * @param bool   $isPersonalized Cờ xác định có dùng trọng số cá nhân hóa không.
     * @return float               Tổng trọng số.
     */
    public static function getTotalWeight(string $purpose, bool $isPersonalized): float
    {
        // 1. Chọn mảng trọng số phù hợp dựa trên cờ $isPersonalized
        // Toán tử ba ngôi `? :` tương đương với if/else
        $targetWeights = $isPersonalized
            ? DataHelper::$PURPOSE_WEIGHTS_PERSONALIZED
            : DataHelper::$PURPOSE_WEIGHTS_GENERAL;

        // 2. Lấy ra mảng trọng số con cần tính tổng
        // Toán tử `??` (null coalescing) sẽ:
        // - Thử lấy $targetWeights[$purpose].
        // - Nếu key này không tồn tại (isset trả về false), nó sẽ lấy giá trị mặc định là $targetWeights['TOT_XAU_CHUNG'].
        // Đây là cách làm rất gọn gàng cho logic if/else kiểm tra key.
        $weightsToSum = $targetWeights[$purpose] ?? $targetWeights['TOT_XAU_CHUNG'];

        // 3. Tính tổng các giá trị trong mảng đã chọn và trả về
        // Hàm `array_sum()` của PHP tương đương với `values.reduce((a, b) => a + b)` trong Dart.
        return array_sum($weightsToSum);
    }
    public static function getWeight(string $purpose, string $factor, bool $isPersonalized): float
    {
        $targetWeights = $isPersonalized
            ? DataHelper::$PURPOSE_WEIGHTS_PERSONALIZED
            : DataHelper::$PURPOSE_WEIGHTS_GENERAL;

        if (!array_key_exists($purpose, $targetWeights)) {

            return $targetWeights['TOT_XAU_CHUNG'][$factor] ?? 1.0;
        }
        return $targetWeights[$purpose][$factor] ?? 1.0;
    }
    public static function mapRatingToLevelDescription($ratingText)
    {
        $text = mb_strtolower($ratingText); // dùng mb_strtolower để hỗ trợ tiếng Việt

        switch ($text) {
            case 'rất tốt':
                return 'ĐẠI CÁT';
            case 'tốt':
                return 'TIỂU CÁT';
            case 'trung bình':
                return 'TRUNG CÁT';
            case 'kém':
                return 'TIỂU HUNG';
            case 'xấu':
            case 'rất xấu':
                return 'ĐẠI HUNG';
            default:
                return 'KHÔNG XÁC ĐỊNH';
        }
    }
    public static function getIntroParagraph(string $dateStr, float $percentage, $isPersonalized)
    {
        $withUser = $isPersonalized ? ' với bạn' : '';
        $introText = "";

        if ($percentage == 0) {
            $introText = "Ngày $dateStr là một ngày Rất Xấu$withUser. Hầu hết các công việc quan trọng nên tránh triển khai vào hôm nay. Nếu bắt buộc phải thực hiện những việc lớn như khai trương, cưới hỏi, động thổ…, hãy ưu tiên hóa giải các yếu tố bất lợi như sao xấu, ngày đại kỵ để giảm thiểu rủi ro.";
        } elseif ($percentage <= 39) {
            $introText = "Ngày $dateStr là một ngày Xấu$withUser. Không thích hợp để thực hiện các công việc quan trọng. Bạn nên trì hoãn những kế hoạch lớn, chỉ nên giải quyết các việc nhỏ mang tính duy trì. Nếu không thể trì hoãn, hãy cân nhắc chọn giờ tốt và hóa giải ảnh hưởng từ các yếu tố hung tinh.";
        } elseif ($percentage <= 59) {
            $introText = "Ngày $dateStr là một ngày Trung bình$withUser. Có thể thực hiện những công việc nhỏ, lặp lại, hoặc mang tính hỗ trợ. Nếu muốn triển khai việc lớn, hãy đảm bảo xem xét kỹ lưỡng các yếu tố phụ trợ như sao tốt / xấu, ngày kỵ, tuổi xung, trực ngày… để đảm bảo thuận lợi.";
        } elseif ($percentage <= 79) {
            $introText = "Ngày $dateStr là một ngày Tốt$withUser. Thích hợp để triển khai các công việc quan trọng như ký kết, đi xa, làm lễ, khai trương, động thổ… Tuy nhiên, để đạt kết quả tốt nhất, bạn vẫn nên xem lại các yếu tố như ngày kỵ, tuổi xung, sao đại hung, hoặc vận khí ngày/tháng so với tuổi của bạn.";
        } else {
            $introText = "Ngày $dateStr là một ngày Rất tốt$withUser. Đây là thời điểm cực kỳ thuận lợi để thực hiện các việc đại sự, bao gồm cưới hỏi, mở hàng, khởi công, động thổ… Tuy vậy, để đảm bảo trọn vẹn cát lợi, bạn vẫn nên xét kỹ các sao chiếu, giờ hoàng đạo và các mối quan hệ xung tuổi nếu có.";
        }

        return trim($introText);
    }
    /**
     * Danh sách Giờ Hoàng Đạo (giờ tốt) dựa trên Địa Chi của ngày.
     * Khung giờ 24h.
     */
    protected static $HOANG_DAO_HOURS = [
        'Tý'    => ['Tý (23-1)', 'Sửu (1-3)', 'Mão (5-7)', 'Ngọ (11-13)', 'Thân (15-17)', 'Dậu (17-19)'],
        'Sửu'   => ['Dần (3-5)', 'Mão (5-7)', 'Tỵ (9-11)', 'Thân (15-17)', 'Tuất (19-21)', 'Hợi (21-23)'],
        'Dần'   => ['Tý (23-1)', 'Sửu (1-3)', 'Thìn (7-9)', 'Tỵ (9-11)', 'Mùi (13-15)', 'Tuất (19-21)'],
        'Mão'   => ['Tý (23-1)', 'Dần (3-5)', 'Mão (5-7)', 'Ngọ (11-13)', 'Mùi (13-15)', 'Dậu (17-19)'],
        'Thìn'  => ['Dần (3-5)', 'Thìn (7-9)', 'Tỵ (9-11)', 'Thân (15-17)', 'Dậu (17-19)', 'Hợi (21-23)'],
        'Tỵ'    => ['Sửu (1-3)', 'Thìn (7-9)', 'Ngọ (11-13)', 'Mùi (13-15)', 'Tuất (19-21)', 'Hợi (21-23)'],
        'Ngọ'   => ['Tý (23-1)', 'Sửu (1-3)', 'Mão (5-7)', 'Ngọ (11-13)', 'Thân (15-17)', 'Dậu (17-19)'],
        'Mùi'   => ['Dần (3-5)', 'Mão (5-7)', 'Tỵ (9-11)', 'Thân (15-17)', 'Tuất (19-21)', 'Hợi (21-23)'],
        'Thân'  => ['Tý (23-1)', 'Sửu (1-3)', 'Thìn (7-9)', 'Tỵ (9-11)', 'Mùi (13-15)', 'Tuất (19-21)'],
        'Dậu'   => ['Tý (23-1)', 'Dần (3-5)', 'Mão (5-7)', 'Ngọ (11-13)', 'Mùi (13-15)', 'Dậu (17-19)'],
        'Tuất'  => ['Dần (3-5)', 'Thìn (7-9)', 'Tỵ (9-11)', 'Thân (15-17)', 'Dậu (17-19)', 'Hợi (21-23)'],
        'Hợi'   => ['Sửu (1-3)', 'Thìn (7-9)', 'Ngọ (11-13)', 'Mùi (13-15)', 'Tuất (19-21)', 'Hợi (21-23)'],
    ];

    /**
     * Lấy danh sách giờ tốt dựa vào Địa Chi của ngày.
     *
     * @param string $dayChi Địa Chi của ngày (ví dụ: 'Tý', 'Sửu'...)
     * @return array Danh sách các giờ tốt.
     */
    public static function getGoodHoursByDayChi(string $dayChi): array
    {
        return self::$HOANG_DAO_HOURS[$dayChi] ?? [];
    }

    /**
     * Tính toán các yếu tố hỗ trợ cho ngày.
     *
     * @param Carbon $date Ngày cần kiểm tra
     * @param mixed $birthDate Năm sinh (nếu có)
     * @return array
     */
    public static function calculateSupportFactors(Carbon $date, $birthDate): array
    {
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;

        // Lấy thông tin Can Chi của ngày
        $jd = LunarHelper::jdFromDate($day, $month, $year);
        $dayCanChi = LunarHelper::canchiNgayByJD($jd);
        $parts = explode(' ', $dayCanChi);
        $dayCan = $parts[0];
        $dayChi = $parts[1];

        // Lấy thông tin âm lịch
        $lunar = LunarHelper::convertSolar2Lunar($day, $month, $year);
        $lunarDay = $lunar[0];

        // 1. Kiểm tra ngày hoàng đạo
        $hoangdao = self::isHoangDao($date);

        // 2. Kiểm tra trực tốt
        $tructot = self::isTrucTot($date);

        // 3. Kiểm tra hợp tuổi (nếu có năm sinh)
        $hopttuoi = false;
        $hopTuoiReason = '';
        if ($birthDate) {
            $hopttuoi = self::isHopTuoi($date, $birthDate);

            $birthCanChi = KhiVanHelper::canchiNam($birthDate);
            $birthChiParts = explode(' ', $birthCanChi);
            $birthChi = $birthChiParts[1] ?? '';
            if ($hopttuoi) {
                $hopTuoiReason = self::getHopTuoiDetail($date, $birthDate) ?? '';
            } else {
                // Kiểm tra tất cả các mối quan hệ xấu với debug
                $isLucXung = GioHoangDaoHelper::isLucXung($dayChi, $birthChi);
                $isTuongHai = GioHoangDaoHelper::isTuongHai($dayChi, $birthChi);
                $isTuongPha = GioHoangDaoHelper::isTuongPha($dayChi, $birthChi);
                $isTuHinh = ($birthChi === $dayChi);

             

                if ($isLucXung) {
                    $hopTuoiReason = "Lục xung";
                } elseif ($isTuongHai) {
                    $hopTuoiReason = "Tương hại";
                } elseif ($isTuongPha) {
                    $hopTuoiReason = "Tương phá";
                } elseif ($isTuHinh) {
                    $hopTuoiReason = "Tự hình";
                } else {
                    $hopTuoiReason = "Ngày bình thường";
                }
            }
        }

        // 4. Kiểm tra sao tốt
        $good_stars = self::getGoodStars($date);

        // 5. Tính toán các yếu tố tích cực khác
        $positive_factors = [];

        // Giờ hoàng đạo
        $goodHours = self::$HOANG_DAO_HOURS[$dayChi] ?? [];
        if (!empty($goodHours)) {
            $positive_factors[] = ['name' => 'Có giờ hoàng đạo', 'detail' => implode(', ', $goodHours)];
        }

        // Ngày lành thánh
        if (in_array($lunarDay, [1, 8, 14, 15, 18, 23, 24, 28, 29, 30])) {
            $positive_factors[] = ['name' => 'Ngày lành thánh', 'detail' => "Ngày $lunarDay âm lịch"];
        }

        return [
            'hoangdao' => $hoangdao,
            'tructot' => $tructot,
            'hopttuoi' => $hopttuoi,
            'hopTuoiReason' => $hopTuoiReason,
            'good_stars' => $good_stars,
            'positive_factors' => $positive_factors,
        ];
    }

    /**
     * Kiểm tra xem ngày có phải ngày hoàng đạo không.
     */
    private static function isHoangDao(Carbon $date): bool
    {
        $truc = NhiTrucHelper::getTruc($date->day, $date->month, $date->year);

        // Các trực hoàng đạo: Trừ, Nguy, Thành, Khai
        $hoangdaoTruc = ['Trừ', 'Nguy', 'Thành', 'Khai'];

        return in_array($truc, $hoangdaoTruc);
    }

    /**
     * Kiểm tra xem ngày có phải trực tốt không.
     */
    private static function isTrucTot(Carbon $date): bool
    {
        $truc = NhiTrucHelper::getTruc($date->day, $date->month, $date->year);

        // Các trực tốt (khác với hoàng đạo): Định, Chấp, Kiến, Mãn
     $trucTot = ['Thành', 'Định', 'Khai', 'Mãn', 'Thu', 'Trừ', 'Bình','Nguy'];

        return in_array($truc, $trucTot);
    }

    /**
     * Kiểm tra xem ngày có hợp tuổi không và xác định loại hợp.
     */
    private static function isHopTuoi(Carbon $date, $birthYear): bool
    {
        if (!$birthYear) return false;

        try {
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);
            $birthCanChi = KhiVanHelper::canchiNam($birthYear);
            $parts = explode(' ', $dayCanChi);
            $dayChi = $parts[1] ?? '';

            $birthChiParts = explode(' ', $birthCanChi);
            $birthChi = $birthChiParts[1] ?? '';

            // Kiểm tra Lục hợp (6 hợp)
            $lucHop = [
                'Tý' => 'Sửu',
                'Sửu' => 'Tý',
                'Dần' => 'Hợi',
                'Hợi' => 'Dần',
                'Mão' => 'Tuất',
                'Tuất' => 'Mão',
                'Thìn' => 'Dậu',
                'Dậu' => 'Thìn',
                'Tỵ' => 'Thân',
                'Thân' => 'Tỵ',
                'Ngọ' => 'Mùi',
                'Mùi' => 'Ngọ'
            ];

            // Kiểm tra Tam hợp (3 hợp)
            $tamHop = [
                'Thủy' => ['Tý', 'Thìn', 'Thân'],
                'Mộc' => ['Dần', 'Ngọ', 'Tuất'],
                'Kim' => ['Tỵ', 'Dậu', 'Sửu'],
                'Hỏa' => ['Mão', 'Mùi', 'Hợi']
            ];

            // Kiểm tra lục hợp trước
            if (isset($lucHop[$birthChi]) && $lucHop[$birthChi] == $dayChi) {
                return true;
            }

            // Kiểm tra tam hợp
            foreach ($tamHop as $nhom) {
                if (in_array($birthChi, $nhom) && in_array($dayChi, $nhom)) {
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Lấy danh sách sao tốt trong ngày.
     */
    private static function getGoodStars(Carbon $date): array
    {
        // Logic lấy sao tốt dựa trên ngày âm lịch
        $lunar = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
        $lunarDay = $lunar[0];

        $goodStars = [];

        // Một số sao tốt theo ngày âm lịch
        if (in_array($lunarDay, [1, 8, 15])) {
            $goodStars[] = 'Thiên Ân';
        }

        if (in_array($lunarDay, [2, 6, 10, 18, 26])) {
            $goodStars[] = 'Thiên Đức';
        }

        if (in_array($lunarDay, [3, 7, 13, 18, 24, 30])) {
            $goodStars[] = 'Nguyệt Đức';
        }

        if ($lunarDay % 3 == 1) {
            $goodStars[] = 'Thiên Quý';
        }

        return $goodStars;
    }

    /**
     * Lấy thông tin chi tiết về tam hợp/lục hợp.
     */
    public static function getHopTuoiDetail(Carbon $date, $birthYear): ?string
    {
        if (!$birthYear) return null;

        try {
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);
            $birthCanChi = KhiVanHelper::canchiNam($birthYear);

            $parts = explode(' ', $dayCanChi);
            $dayChi = $parts[1] ?? '';

            $birthChiParts = explode(' ', $birthCanChi);
            $birthChi = $birthChiParts[1] ?? '';

            // Kiểm tra Lục hợp trước
            $lucHop = [
                'Tý' => 'Sửu',
                'Sửu' => 'Tý',
                'Dần' => 'Hợi',
                'Hợi' => 'Dần',
                'Mão' => 'Tuất',
                'Tuất' => 'Mão',
                'Thìn' => 'Dậu',
                'Dậu' => 'Thìn',
                'Tỵ' => 'Thân',
                'Thân' => 'Tỵ',
                'Ngọ' => 'Mùi',
                'Mùi' => 'Ngọ'
            ];

            if (isset($lucHop[$birthChi]) && $lucHop[$birthChi] == $dayChi) {
                return 'Lục hợp';
            }

            // Kiểm tra Tam hợp
            $tamHop = [
                'Thủy' => ['Tý', 'Thìn', 'Thân'],
                'Mộc' => ['Dần', 'Ngọ', 'Tuất'],
                'Kim' => ['Tỵ', 'Dậu', 'Sửu'],
                'Hỏa' => ['Mão', 'Mùi', 'Hợi']
            ];

            foreach ($tamHop as $nhom) {
                if (in_array($birthChi, $nhom) && in_array($dayChi, $nhom)) {
                    return 'Tam hợp';
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Lấy tên sao từ trực hoàng đạo.
     */
    public static function getHoangDaoStar(Carbon $date): ?string
    {
        $truc = NhiTrucHelper::getTruc($date->day, $date->month, $date->year);

        $trucToStar = [
            'Trừ' => 'Thanh Long',
            'Nguy' => 'Minh Đường',
            'Thành' => 'Kim Quỹ',
            'Khai' => 'Thiên Đức'
        ];

        return $trucToStar[$truc] ?? null;
    }

  
}
