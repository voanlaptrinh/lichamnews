<?php
namespace App\Helpers;

use Exception;

class LuckyElementsHelper
{
    // Màu sắc theo ngũ hành
    private static $hanhToColors = [
        'kim' => [
            ['name' => 'Trắng', 'hex' => '#FFFFFF'],
            ['name' => 'Xám Tro', 'hex' => '#A0A0A0'],
            ['name' => 'Vàng Kim', 'hex' => '#FFD700'],
        ],
        'mộc' => [
            ['name' => 'Xanh Lá Cây', 'hex' => '#228B22'],
            ['name' => 'Xanh Lục Nhạt', 'hex' => '#90EE90'],
            ['name' => 'Xanh Ngọc Bích', 'hex' => '#00A99D'],
        ],
        'thủy' => [
            ['name' => 'Đen', 'hex' => '#000000'],
            ['name' => 'Xanh Lam Đậm', 'hex' => '#00008B'],
            ['name' => 'Xanh Nước Biển', 'hex' => '#1E90FF'],
        ],
        'hỏa' => [
            ['name' => 'Đỏ Tươi', 'hex' => '#FF0000'],
            ['name' => 'Hồng Cánh Sen', 'hex' => '#FF69B4'],
            ['name' => 'Tím Đậm', 'hex' => '#800080'],
        ],
        'thổ' => [
            ['name' => 'Vàng Nghệ', 'hex' => '#FFC107'],
            ['name' => 'Nâu Đất', 'hex' => '#8B4513'],
            ['name' => 'Cam Sẫm', 'hex' => '#FF8C00'],
        ],
    ];

    // Mối quan hệ tương sinh, tương khắc giữa các ngũ hành
    private static $hanhRelationships = [
        'tương sinh' => ['kim-thủy', 'thủy-mộc', 'mộc-hỏa', 'hỏa-thổ', 'thổ-kim'],
        'tương khắc' => ['kim-mộc', 'mộc-thổ', 'thổ-thủy', 'thủy-hỏa', 'hỏa-kim'],
    ];

    // Con số may mắn theo ngũ hành Hà Đồ
    private static $hanhToLuckyNumbers = [
        'kim' => [4, 9],
        'mộc' => [3, 8],
        'thủy' => [1, 6],
        'hỏa' => [2, 7],
        'thổ' => [0, 5],
    ];

    // Can - Ngũ hành
    private static $canToHanh = [
        'Giáp' => 'Mộc',
        'Ất' => 'Mộc',
        'Bình' => 'Hỏa',
        'Đinh' => 'Hỏa',
        'Mậu' => 'Thổ',
        'Kỷ' => 'Thổ',
        'Canh' => 'Kim',
        'Tân' => 'Kim',
        'Nhâm' => 'Thủy',
        'Quý' => 'Thủy',
    ];

    // Chi - Ngũ hành
    private static $chiToHanh = [
        'Tý' => 'Thủy',
        'Sửu' => 'Thổ',
        'Dần' => 'Mộc',
        'Mão' => 'Mộc',
        'Thìn' => 'Thổ',
        'Tỵ' => 'Hỏa',
        'Ngọ' => 'Hỏa',
        'Mùi' => 'Thổ',
        'Thân' => 'Kim',
        'Dậu' => 'Kim',
        'Tuất' => 'Thổ',
        'Hợi' => 'Thủy',
    ];

    // Bảng Nạp Âm
    private static $napAmTable = [
        'Giáp Tý' => ['napAm' => 'Hải Trung Kim', 'hanh' => 'kim'],
        'Ất Sửu' => ['napAm' => 'Hải Trung Kim', 'hanh' => 'kim'],
        'Bình Dần' => ['napAm' => 'Lư Trung Hỏa', 'hanh' => 'hỏa'],
        'Đinh Mão' => ['napAm' => 'Lư Trung Hỏa', 'hanh' => 'hỏa'],
        'Mậu Thìn' => ['napAm' => 'Đại Lâm Mộc', 'hanh' => 'mộc'],
        'Kỷ Tỵ' => ['napAm' => 'Đại Lâm Mộc', 'hanh' => 'mộc'],
        'Canh Ngọ' => ['napAm' => 'Lộ Bàng Thổ', 'hanh' => 'thổ'],
        'Tân Mùi' => ['napAm' => 'Lộ Bàng Thổ', 'hanh' => 'thổ'],
        'Nhâm Thân' => ['napAm' => 'Kiếm Phong Kim', 'hanh' => 'kim'],
        'Quý Dậu' => ['napAm' => 'Kiếm Phong Kim', 'hanh' => 'kim'],
        'Giáp Tuất' => ['napAm' => 'Sơn Đầu Hỏa', 'hanh' => 'hỏa'],
        'Ất Hợi' => ['napAm' => 'Sơn Đầu Hỏa', 'hanh' => 'hỏa'],
        'Bình Tý' => ['napAm' => 'Giản Hạ Thủy', 'hanh' => 'thủy'],
        'Đinh Sửu' => ['napAm' => 'Giản Hạ Thủy', 'hanh' => 'thủy'],
        'Mậu Dần' => ['napAm' => 'Thành Đầu Thổ', 'hanh' => 'thổ'],
        'Kỷ Mão' => ['napAm' => 'Thành Đầu Thổ', 'hanh' => 'thổ'],
        'Canh Thìn' => ['napAm' => 'Bạch Lạp Kim', 'hanh' => 'kim'],
        'Tân Tỵ' => ['napAm' => 'Bạch Lạp Kim', 'hanh' => 'kim'],
        'Nhâm Ngọ' => ['napAm' => 'Dương Liễu Mộc', 'hanh' => 'mộc'],
        'Quý Mùi' => ['napAm' => 'Dương Liễu Mộc', 'hanh' => 'mộc'],
        'Giáp Thân' => ['napAm' => 'Tuyền Trung Thủy', 'hanh' => 'thủy'],
        'Ất Dậu' => ['napAm' => 'Tuyền Trung Thủy', 'hanh' => 'thủy'],
        'Bình Tuất' => ['napAm' => 'Ốc Thượng Thổ', 'hanh' => 'thổ'],
        'Đinh Hợi' => ['napAm' => 'Ốc Thượng Thổ', 'hanh' => 'thổ'],
        'Mậu Tý' => ['napAm' => 'Tích Lịch Hỏa', 'hanh' => 'hỏa'],
        'Kỷ Sửu' => ['napAm' => 'Tích Lịch Hỏa', 'hanh' => 'hỏa'],
        'Canh Dần' => ['napAm' => 'Tòng Bách Mộc', 'hanh' => 'mộc'],
        'Tân Mão' => ['napAm' => 'Tòng Bách Mộc', 'hanh' => 'mộc'],
        'Nhâm Thìn' => ['napAm' => 'Trường Lưu Thủy', 'hanh' => 'thủy'],
        'Quý Tỵ' => ['napAm' => 'Trường Lưu Thủy', 'hanh' => 'thủy'],
        'Giáp Ngọ' => ['napAm' => 'Sa Trung Kim', 'hanh' => 'kim'],
        'Ất Mùi' => ['napAm' => 'Sa Trung Kim', 'hanh' => 'kim'],
        'Bình Thân' => ['napAm' => 'Sơn Hạ Hỏa', 'hanh' => 'hỏa'],
        'Đinh Dậu' => ['napAm' => 'Sơn Hạ Hỏa', 'hanh' => 'hỏa'],
        'Mậu Tuất' => ['napAm' => 'Bình Địa Mộc', 'hanh' => 'mộc'],
        'Kỷ Hợi' => ['napAm' => 'Bình Địa Mộc', 'hanh' => 'mộc'],
        'Canh Tý' => ['napAm' => 'Bích Thượng Thổ', 'hanh' => 'thổ'],
        'Tân Sửu' => ['napAm' => 'Bích Thượng Thổ', 'hanh' => 'thổ'],
        'Nhâm Dần' => ['napAm' => 'Kim Bạch Kim', 'hanh' => 'kim'],
        'Quý Mão' => ['napAm' => 'Kim Bạch Kim', 'hanh' => 'kim'],
        'Giáp Thìn' => ['napAm' => 'Phúc Đăng Hỏa', 'hanh' => 'hỏa'],
        'Ất Tỵ' => ['napAm' => 'Phúc Đăng Hỏa', 'hanh' => 'hỏa'],
        'Bình Ngọ' => ['napAm' => 'Thiên Hà Thủy', 'hanh' => 'thủy'],
        'Đinh Mùi' => ['napAm' => 'Thiên Hà Thủy', 'hanh' => 'thủy'],
        'Mậu Thân' => ['napAm' => 'Đại Trạch Thổ', 'hanh' => 'thổ'],
        'Kỷ Dậu' => ['napAm' => 'Đại Trạch Thổ', 'hanh' => 'thổ'],
        'Canh Tuất' => ['napAm' => 'Thoa Xuyến Kim', 'hanh' => 'kim'],
        'Tân Hợi' => ['napAm' => 'Thoa Xuyến Kim', 'hanh' => 'kim'],
        'Nhâm Tý' => ['napAm' => 'Tang Chá Mộc', 'hanh' => 'mộc'],
        'Quý Sửu' => ['napAm' => 'Tang Chá Mộc', 'hanh' => 'mộc'],
        'Giáp Dần' => ['napAm' => 'Đại Khê Thủy', 'hanh' => 'thủy'],
        'Ất Mão' => ['napAm' => 'Đại Khê Thủy', 'hanh' => 'thủy'],
        'Bình Thìn' => ['napAm' => 'Sa Trung Thổ', 'hanh' => 'thổ'],
        'Đinh Tỵ' => ['napAm' => 'Sa Trung Thổ', 'hanh' => 'thổ'],
        'Mậu Ngọ' => ['napAm' => 'Thiên Thượng Hỏa', 'hanh' => 'hỏa'],
        'Kỷ Mùi' => ['napAm' => 'Thiên Thượng Hỏa', 'hanh' => 'hỏa'],
        'Canh Thân' => ['napAm' => 'Thạch Lựu Mộc', 'hanh' => 'mộc'],
        'Tân Dậu' => ['napAm' => 'Thạch Lựu Mộc', 'hanh' => 'mộc'],
        'Nhâm Tuất' => ['napAm' => 'Đại Hải Thủy', 'hanh' => 'thủy'],
        'Quý Hợi' => ['napAm' => 'Đại Hải Thủy', 'hanh' => 'thủy'],
    ];

    // Can chi arrays
    private static $hangCan = ['Giáp', 'Ất', 'Bình', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    private static $hangChi = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

    /**
     * Tính toán màu may mắn dựa trên ngày sinh và ngày hiện tại
     */
    public static function getLuckyColors($birthDate, $selectedDate)
    {
        try {
            $birthYearInfo = self::getHanhInfo($birthDate, true);
            $userHanh = strtolower($birthYearInfo['napAmHanh']);

            $luckyColors = [];

            // 1. Màu Bản Mệnh
            if (isset(self::$hanhToColors[$userHanh])) {
                $luckyColors = array_merge($luckyColors, self::$hanhToColors[$userHanh]);
            }

            // 2. Màu Tương Sinh (Hành sinh ra mình)
            $sinhHanh = null;
            foreach (self::$hanhRelationships['tương sinh'] as $relation) {
                $parts = explode('-', $relation);
                if (count($parts) == 2 && $parts[1] == $userHanh) {
                    $sinhHanh = $parts[0];
                    break;
                }
            }

            if ($sinhHanh && isset(self::$hanhToColors[$sinhHanh])) {
                $luckyColors = array_merge($luckyColors, self::$hanhToColors[$sinhHanh]);
            }

            // Loại bỏ trùng lặp
            $uniqueColors = [];
            $seenNames = [];
            foreach ($luckyColors as $color) {
                if (!in_array($color['name'], $seenNames)) {
                    $seenNames[] = $color['name'];
                    $color['hanh'] = self::findHanhByColor($color['name']);
                    $uniqueColors[] = $color;
                }
            }

            // Shuffle với seed từ ngày được chọn
            $seedValue = $selectedDate['year'] * 10000 + $selectedDate['month'] * 100 + $selectedDate['day'];
            mt_srand($seedValue);
            shuffle($uniqueColors);

            $finalColors = array_slice($uniqueColors, 0, 5);

            // Return với format chuẩn
            return [
                'colors' => $finalColors,
                'user_hanh' => ucfirst($userHanh),
                'sinh_hanh' => $sinhHanh ? ucfirst($sinhHanh) : null,
                'interpretation' => self::getColorInterpretation($userHanh, $sinhHanh),
                'calculation' => "Dựa trên hành bản mệnh ({$birthYearInfo['napAm']}) và hành tương sinh"
            ];

        } catch (Exception $e) {
            return [
                'colors' => [
                    ['name' => 'Xanh Lá', 'hex' => '#00A651', 'hanh' => 'Mộc'],
                    ['name' => 'Vàng', 'hex' => '#FFFF00', 'hanh' => 'Thổ'],
                    ['name' => 'Trắng', 'hex' => '#FFFFFF', 'hanh' => 'Kim'],
                ],
                'user_hanh' => 'Kim',
                'sinh_hanh' => 'Thổ',
                'interpretation' => 'Màu may mắn mặc định',
                'calculation' => 'Tính toán mặc định do lỗi dữ liệu'
            ];
        }
    }

    /**
     * Tìm ngũ hành tương ứng với tên màu
     */
    private static function findHanhByColor($colorName)
    {
        foreach (self::$hanhToColors as $hanh => $colors) {
            foreach ($colors as $color) {
                if ($color['name'] == $colorName) {
                    return ucfirst($hanh);
                }
            }
        }
        return 'Kim';
    }

    /**
     * Tính 3 con số may mắn
     */
    public static function getLuckyNumbers($user, $selectedDate)
    {
        if (!isset($user['birth_date']) || empty($user['birth_date'])) {
            return [
                'numbers' => [3, 7, 9],
                'user_hanh' => 'Kim',
                'life_path' => 3,
                'kua_number' => 7,
                'interpretation' => 'Số may mắn mặc định do thiếu thông tin',
                'calculation' => 'Tính toán mặc định'
            ];
        }

        try {
            $birthDate = $user['birth_date'];
            $gender = $user['gender'] ?? 'male';
            $prioritizedLuckyNumbers = [];

            // Ưu tiên 1: Số theo Hành Nạp Âm (Hà Đồ)
            $birthYearInfo = self::getHanhInfo($birthDate, true);
            $userHanh = strtolower($birthYearInfo['napAmHanh']);

            if (isset(self::$hanhToLuckyNumbers[$userHanh])) {
                $prioritizedLuckyNumbers = array_merge($prioritizedLuckyNumbers, self::$hanhToLuckyNumbers[$userHanh]);
            }

            // Ưu tiên 2: Số Đường Đời (Life Path)
            $lifePath = self::calculateLifePath($birthDate);
            $prioritizedLuckyNumbers[] = $lifePath;

            // Ưu tiên 3: Số Kua (Cần Giới Tính)
            $isMale = (strtolower($gender) == 'male');
            $kuaNumber = self::calculateKuaNumber($birthDate, $isMale);
            $prioritizedLuckyNumbers[] = $kuaNumber;

            // Ưu tiên 4: Số Can/Chi (Nếu chưa đủ 3 số)
            if (count($prioritizedLuckyNumbers) < 3) {
                $dayCan = explode(' ', self::getCanChiDay($selectedDate))[0];
                $canNumber = array_search($dayCan, self::$hangCan) + 1;
                $canNumber = self::reduceSingleDigit($canNumber);
                if ($canNumber > 0) {
                    $prioritizedLuckyNumbers[] = $canNumber;
                }
            }

            if (count($prioritizedLuckyNumbers) < 3) {
                $birthChi = explode(' ', self::getCanChiYear($birthDate))[1];
                $chiNumber = array_search($birthChi, self::$hangChi) + 1;
                $chiNumber = self::reduceSingleDigit($chiNumber);
                if ($chiNumber > 0) {
                    $prioritizedLuckyNumbers[] = $chiNumber;
                }
            }

            // Lọc số từ 0-9
            $result = array_unique(array_filter($prioritizedLuckyNumbers, function($num) {
                return $num >= 0 && $num <= 9;
            }));

            // Bổ sung nếu vẫn thiếu
            $backupNumbers = [1, 6, 2, 7, 3, 8, 4, 9, 5, 0];
            $currentBackupIndex = 0;
            while (count($result) < 3 && $currentBackupIndex < count($backupNumbers)) {
                $numToAdd = $backupNumbers[$currentBackupIndex];
                if (!in_array($numToAdd, $result)) {
                    $result[] = $numToAdd;
                }
                $currentBackupIndex++;
            }

            // Shuffle với seed từ ngày được chọn
            $seedValue = $selectedDate['year'] * 10000 + $selectedDate['month'] * 100 + $selectedDate['day'];
            mt_srand($seedValue);
            shuffle($result);

            $finalNumbers = array_slice(array_values($result), 0, 3);

            // Return với format chuẩn
            return [
                'numbers' => $finalNumbers,
                'user_hanh' => ucfirst($userHanh),
                'life_path' => $lifePath,
                'kua_number' => $kuaNumber,
                'interpretation' => self::getNumberInterpretation($finalNumbers, $userHanh),
                'calculation' => "Dựa trên hành Nạp Âm ({$birthYearInfo['napAm']}), số đường đời ({$lifePath}), và số Kua ({$kuaNumber})"
            ];

        } catch (Exception $e) {
            return [
                'numbers' => [3, 7, 9],
                'user_hanh' => 'Kim',
                'life_path' => 3,
                'kua_number' => 7,
                'interpretation' => 'Số may mắn mặc định do lỗi tính toán',
                'calculation' => 'Tính toán mặc định do lỗi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Tính số KUA dựa trên năm sinh và giới tính (sử dụng âm lịch)
     */
    private static function calculateKuaNumber($birthDate, $isMale)
    {
        // Chuyển đổi sang âm lịch (simplified version)
        $year = is_array($birthDate) ? $birthDate['year'] : date('Y', strtotime($birthDate));

        // Nếu sinh trước Tết Nguyên Đán thì trừ 1 năm
        if (is_array($birthDate)) {
            // Estimate lunar new year (typically between late Jan to mid Feb)
            $month = $birthDate['month'];
            $day = $birthDate['day'];
            if ($month == 1 || ($month == 2 && $day < 15)) {
                $year -= 1;
            }
        }

        // Tính tổng các chữ số của năm
        $sum = 0;
        $tempYear = $year;
        while ($tempYear > 0) {
            $sum += $tempYear % 10;
            $tempYear = intval($tempYear / 10);
        }

        $baseNumber = self::reduceSingleDigit($sum);

        // Công thức tính Kua
        if ($isMale) {
            $kuaNumber = 11 - $baseNumber;
        } else {
            $kuaNumber = $baseNumber + 4;
        }

        $kuaNumber = self::reduceSingleDigit($kuaNumber);

        // Xử lý trường hợp đặc biệt
        if ($kuaNumber == 5) {
            $kuaNumber = $isMale ? 2 : 8;
        }
        if ($kuaNumber == 0) {
            $kuaNumber = 9;
        }

        return $kuaNumber;
    }

    /**
     * Lấy thông tin ngũ hành từ ngày
     */
    private static function getHanhInfo($date, $isYearHanh)
    {
        try {
            if ($isYearHanh) {
                $canChiYear = self::getCanChiYear($date);
                return self::getNapAmFromCanChi($canChiYear);
            } else {
                // Implement cho ngày nếu cần
                return self::getHanhOfDay($date);
            }
        } catch (Exception $e) {
            return [
                'canChi' => $isYearHanh ? self::getCanChiYear($date) : self::getCanChiDay($date),
                'canHanh' => 'Kim',
                'chiHanh' => 'Thủy',
                'napAm' => 'Bích Thượng Thổ',
                'napAmHanh' => 'Thổ'
            ];
        }
    }

    /**
     * Lấy Can Chi của năm
     */
    private static function getCanChiYear($date)
    {
        $year = is_array($date) ? $date['year'] : date('Y', strtotime($date));

        // Năm bắt đầu từ Giáp Tý năm 1924
        $baseYear = 1924;
        $yearDiff = $year - $baseYear;

        $canIndex = $yearDiff % 10;
        $chiIndex = $yearDiff % 12;

        return self::$hangCan[$canIndex] . ' ' . self::$hangChi[$chiIndex];
    }

    /**
     * Lấy Can Chi của ngày (thuật toán đơn giản)
     */
    private static function getCanChiDay($date)
    {
        // Sử dụng thuật toán đơn giản dựa trên timestamp
        if (is_array($date)) {
            $timestamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
        } else {
            $timestamp = strtotime($date);
        }

        // Ngày gốc: 1900-01-01 = Giáp Tý (index 0)
        $baseTimestamp = mktime(0, 0, 0, 1, 31, 1900); // 31/01/1900 = Giáp Tý
        $daysDiff = intval(($timestamp - $baseTimestamp) / (24 * 60 * 60));

        $canIndex = $daysDiff % 10;
        $chiIndex = $daysDiff % 12;

        if ($canIndex < 0) $canIndex += 10;
        if ($chiIndex < 0) $chiIndex += 12;

        return self::$hangCan[$canIndex] . ' ' . self::$hangChi[$chiIndex];
    }

    /**
     * Lấy ngũ hành của ngày
     */
    private static function getHanhOfDay($date)
    {
        $canChiDay = self::getCanChiDay($date);
        return self::getNapAmFromCanChi($canChiDay);
    }

    /**
     * Lấy Nạp Âm và Ngũ Hành từ Can Chi
     */
    private static function getNapAmFromCanChi($canChi)
    {
        $napAmData = self::$napAmTable[$canChi] ?? ['napAm' => 'Bích Thượng Thổ', 'hanh' => 'Thổ'];

        $parts = explode(' ', $canChi);
        if (count($parts) != 2) {
            return [
                'canChi' => $canChi,
                'canHanh' => 'Kim',
                'chiHanh' => 'Thủy',
                'napAm' => $napAmData['napAm'],
                'napAmHanh' => $napAmData['hanh'],
            ];
        }

        $can = $parts[0];
        $chi = $parts[1];

        return [
            'canChi' => $canChi,
            'canHanh' => self::$canToHanh[$can] ?? 'Kim',
            'chiHanh' => self::$chiToHanh[$chi] ?? 'Thủy',
            'napAm' => $napAmData['napAm'],
            'napAmHanh' => $napAmData['hanh'],
        ];
    }

    /**
     * Giảm số xuống thành 1 chữ số (0-9), xử lý số 0 -> 9
     */
    private static function reduceSingleDigit($number)
    {
        if ($number < 0) $number = -$number;
        if ($number == 0) return 9; // Kua số 0 quy về 9

        while ($number > 9) {
            $sum = 0;
            $digits = str_split((string)$number);
            foreach ($digits as $digit) {
                $sum += intval($digit);
            }
            $number = $sum;
        }

        return $number == 0 ? 9 : $number; // Đảm bảo không bao giờ trả về 0
    }

    /**
     * Tính Life Path Number từ ngày sinh
     */
    private static function calculateLifePath($birthDate)
    {
        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
            $year = $birthDate['year'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);
        }

        $reducedDay = self::reduceSingleDigit($day);
        $reducedMonth = self::reduceSingleDigit($month);
        $reducedYear = self::reduceSingleDigit($year);

        $sum = $reducedDay + $reducedMonth + $reducedYear;
        return self::reduceSingleDigit($sum);
    }

    /**
     * Lấy giải thích cho màu may mắn
     */
    private static function getColorInterpretation($userHanh, $sinhHanh)
    {
        $hanhNames = [
            'kim' => 'Kim',
            'mộc' => 'Mộc',
            'thủy' => 'Thủy',
            'hỏa' => 'Hỏa',
            'thổ' => 'Thổ'
        ];

        $interpretations = [
            'kim' => 'Người mệnh Kim nên sử dụng màu trắng, xám, vàng kim để tăng cường năng lượng bản thân và thu hút tài lộc.',
            'mộc' => 'Người mệnh Mộc nên chọn màu xanh lá cây, xanh ngọc để phát triển sự nghiệp và tăng cường sức khỏe.',
            'thủy' => 'Người mệnh Thủy phù hợp với màu đen, xanh dương để tăng cường trí tuệ và may mắn trong công việc.',
            'hỏa' => 'Người mệnh Hỏa nên sử dụng màu đỏ, hồng, tím để tăng cường năng lượng và thành công trong cuộc sống.',
            'thổ' => 'Người mệnh Thổ phù hợp với màu vàng, nâu, cam để tăng cường sự ổn định và thịnh vượng.'
        ];

        $result = "Bạn thuộc mệnh " . $hanhNames[$userHanh] . ". " . ($interpretations[$userHanh] ?? '');

        if ($sinhHanh) {
            $result .= " Hành " . $hanhNames[$sinhHanh] . " tương sinh với bạn, giúp tăng cường vận may và năng lượng tích cực.";
        }

        return $result;
    }

    /**
     * Lấy giải thích cho con số may mắn
     */
    private static function getNumberInterpretation($numbers, $userHanh)
    {
        $hanhNumbers = [
            'kim' => [4, 9],
            'mộc' => [3, 8],
            'thủy' => [1, 6],
            'hỏa' => [2, 7],
            'thổ' => [0, 5]
        ];

        $numberMeanings = [
            0 => 'hoàn thiện, vô cực',
            1 => 'khởi đầu, độc lập',
            2 => 'hợp tác, cân bằng',
            3 => 'sáng tạo, giao tiếp',
            4 => 'ổn định, thực tế',
            5 => 'tự do, phiêu lưu',
            6 => 'trách nhiệm, gia đình',
            7 => 'trí tuệ, tâm linh',
            8 => 'thành công, quyền lực',
            9 => 'nhân đạo, hoàn thành'
        ];

        $result = "Các con số may mắn của bạn: " . implode(', ', $numbers) . ". ";

        $meanings = array_map(function($num) use ($numberMeanings) {
            return $num . " (" . ($numberMeanings[$num] ?? 'đặc biệt') . ")";
        }, $numbers);

        $result .= "Ý nghĩa: " . implode(', ', $meanings) . ". ";

        $hanhNumbersForUser = $hanhNumbers[$userHanh] ?? [];
        $matchingNumbers = array_intersect($numbers, $hanhNumbersForUser);

        if (!empty($matchingNumbers)) {
            $result .= "Số " . implode(', ', $matchingNumbers) . " đặc biệt phù hợp với mệnh của bạn.";
        }

        return $result;
    }

    /**
     * Tính hướng may mắn theo số Kua
     */
    public static function getLuckyDirections($user, $selectedDate)
    {
        $gender = $user['gender'] ?? 'male';
        $birthDate = $user['birth_date'];

        if (!$birthDate) {
            return [
                'kua_number' => 1,
                'lucky_directions' => ['Đông', 'Đông Bắc', 'Nam', 'Bắc'],
                'unlucky_directions' => ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Nam'],
                'interpretation' => 'Hướng may mắn mặc định do thiếu thông tin'
            ];
        }

        $isMale = (strtolower($gender) == 'male');
        $kuaNumber = self::calculateKuaNumber($birthDate, $isMale);

        // Bảng hướng may mắn theo số Kua
        $kuaDirections = [
            1 => ['lucky' => ['Đông', 'Đông Nam', 'Nam', 'Bắc'], 'unlucky' => ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Bắc']],
            2 => ['lucky' => ['Tây Nam', 'Tây Bắc', 'Tây', 'Đông Bắc'], 'unlucky' => ['Đông', 'Đông Nam', 'Nam', 'Bắc']],
            3 => ['lucky' => ['Đông', 'Bắc', 'Nam', 'Đông Nam'], 'unlucky' => ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Bắc']],
            4 => ['lucky' => ['Đông Nam', 'Đông', 'Bắc', 'Nam'], 'unlucky' => ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Bắc']],
            6 => ['lucky' => ['Tây', 'Đông Bắc', 'Tây Nam', 'Tây Bắc'], 'unlucky' => ['Đông', 'Đông Nam', 'Nam', 'Bắc']],
            7 => ['lucky' => ['Tây Bắc', 'Tây', 'Đông Bắc', 'Tây Nam'], 'unlucky' => ['Đông', 'Đông Nam', 'Nam', 'Bắc']],
            8 => ['lucky' => ['Đông Bắc', 'Tây Nam', 'Tây', 'Tây Bắc'], 'unlucky' => ['Đông', 'Đông Nam', 'Nam', 'Bắc']],
            9 => ['lucky' => ['Nam', 'Đông', 'Đông Nam', 'Bắc'], 'unlucky' => ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Bắc']],
        ];

        $directions = $kuaDirections[$kuaNumber] ?? $kuaDirections[1];

        return [
            'kua_number' => $kuaNumber,
            'lucky_directions' => $directions['lucky'],
            'unlucky_directions' => $directions['unlucky'],
            'interpretation' => self::getDirectionInterpretation($kuaNumber, $directions),
            'calculation' => "Dựa trên số Kua {$kuaNumber} được tính từ năm sinh và giới tính"
        ];
    }

    /**
     * Giải thích hướng may mắn
     */
    private static function getDirectionInterpretation($kuaNumber, $directions)
    {
        $interpretation = "Với số Kua {$kuaNumber}, bạn thuộc ";

        // Phân loại nhóm hướng
        if (in_array($kuaNumber, [1, 3, 4, 9])) {
            $interpretation .= "nhóm Đông Tứ Mệnh. ";
        } else {
            $interpretation .= "nhóm Tây Tứ Mệnh. ";
        }

        $interpretation .= "Hướng tốt nhất cho bạn là " . $directions['lucky'][0] .
                          " (hướng sinh khí). Tránh hướng " . $directions['unlucky'][0] .
                          " (hướng tuyệt mệnh) khi bố trí chỗ ngồi, giường ngủ.";

        return $interpretation;
    }

    /**
     * Tính màu may mắn theo từng ngày trong tuần
     */
    public static function getDailyLuckyColor($selectedDate)
    {
        if (is_array($selectedDate)) {
            $dayOfWeek = date('w', mktime(0, 0, 0, $selectedDate['month'], $selectedDate['day'], $selectedDate['year']));
        } else {
            $dayOfWeek = date('w', strtotime($selectedDate));
        }

        // Màu may mắn theo ngày trong tuần
        $dailyColors = [
            0 => ['name' => 'Vàng Kim', 'hex' => '#FFD700', 'hanh' => 'Kim'], // Chủ Nhật
            1 => ['name' => 'Trắng', 'hex' => '#FFFFFF', 'hanh' => 'Kim'], // Thứ 2
            2 => ['name' => 'Đỏ Tươi', 'hex' => '#FF0000', 'hanh' => 'Hỏa'], // Thứ 3
            3 => ['name' => 'Xanh Lá Cây', 'hex' => '#228B22', 'hanh' => 'Mộc'], // Thứ 4
            4 => ['name' => 'Vàng Nghệ', 'hex' => '#FFC107', 'hanh' => 'Thổ'], // Thứ 5
            5 => ['name' => 'Xanh Nước Biển', 'hex' => '#1E90FF', 'hanh' => 'Thủy'], // Thứ 6
            6 => ['name' => 'Tím Đậm', 'hex' => '#800080', 'hanh' => 'Hỏa'], // Thứ 7
        ];

        $dayNames = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];

        return [
            'day_of_week' => $dayNames[$dayOfWeek],
            'color' => $dailyColors[$dayOfWeek],
            'interpretation' => "Màu may mắn cho " . $dayNames[$dayOfWeek] . " là " . $dailyColors[$dayOfWeek]['name'],
            'calculation' => "Dựa trên ngũ hành chi phối từng ngày trong tuần"
        ];
    }
}