<?php

namespace App\Helpers;

use Carbon\Carbon;
use Faker\Calculator\Luhn;
use Illuminate\Support\Facades\Log;

class KhiVanHelper
{
    public static function getDetailedNoiKhiExplanation($dd, $mm, $yy)
    {
        //  $al = LunarHelper::convertSolar2Lunar((int)$dd, (int)$mm, (int)$yy);
        //    $jdNgayAm = LunarHelper::jdFromLunarDate((int)$al[0], (int)$al[1], (int)$al[2], (int)$al[3]);
        // $canChiNgayAm = LunarHelper::canchiNgayByJD($jdNgayAm);
        $jday = LunarHelper::jdFromDate((int)$dd, (int)$mm, (int)$yy);
        $canChiNgayAm = LunarHelper::canchiNgayByJD($jday);
        // $parts = explode(' ', $dayCanChi);
        $noiKhiExplanations = DataHelper::$noiKhiExplanations;

        return $noiKhiExplanations[$canChiNgayAm]['explanation'] ?? 'Không có giải thích chi tiết.';
    }
    static function canchiThang($yy, $mm)
    {
        //Trong một năm âm lịch, tháng 11 là tháng Tý, tháng 12 là Sửu, tháng Giêng là tháng Dần v.v. Can của tháng M năm Y âm lịch được tính theo công thức sau: chia Y*12+M+3 cho 10. Số dư 0 là Giáp, 1 là Ất v.v.
        $thang = $mm < 11 ? $mm + 1 : $mm - 11;
        return DataHelper::$hang_can[($yy * 12 + $mm + 3) % 10] . ' ' . DataHelper::$hang_chi[$thang];
    }

    static function canchiNam($yy)
    {
        //Để tính Can của năm Y, tìm số dư của Y+6 chia cho 10. Số dư 0 là Giáp, 1 là Ất v.v. Để tính Chi của năm, chia Y+8 cho 12. Số dư 0 là Tý, 1 là Sửu, 2 là Dần v.v.
        return DataHelper::$hang_can[($yy + 6) % 10] . ' ' . DataHelper::$hang_chi[($yy + 8) % 12];
    }
    public static function getChiSvg($chi)
    {
        $map = [
            'ty'   => 'ty.png',
            'suu'  => 'suu.png',
            'dan'  => 'dan.png',
            'mao'  => 'mao.png',
            'thin' => 'thin.png',
            'ty_'   => 'ty_.png', // khác với "Tý"
            'ngo'  => 'ngo.png',
            'mui'  => 'mui.png',
            'than' => 'than.png',
            'dau'  => 'dau.png',
            'tuat' => 'tuat.png',
            'hoi'  => 'hoi.png',
        ];
        $chiPart = $parts[1] ?? $chi;
        $key = mb_strtolower(self::convertVietnamese($chi));
        if ($key === 'ty' && $chiPart === 'Tỵ') {
            $key = 'ty_';
        }
        if (array_key_exists($key, $map)) {
            return asset('icons/' . $map[$key]);
        }

        return null;
    }

    protected static function convertVietnamese($str)
    {
        return str_replace(
            ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'đ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'],
            ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', 'y'],
            mb_strtolower($str)
        );
    }
    public static function extractChi($canChi)
    {
        return explode(' ', $canChi)[1] ?? null;
    }

    public static function calculateVanKhi(string $purpose, Carbon $date, $birthDate = null): array
    {
        $isPersonalized = $birthDate !== null;

        // --- BƯỚC 1: LẤY KẾT QUẢ VÀ ĐIỂM THÔ TỪ CÁC SERVICE ---
        $noiKhiResult = self::calculateNoiKhi($date); // Giả sử có self
        $khiThangFullResult = self::getDetailedKhiThangInfo($date); // Giả sử có self
        $canCanResult = $isPersonalized ? self::calculateCanCan($date, $birthDate) : null;
        $chiChiResult = $isPersonalized ? self::calculateChiChi($date, $birthDate) : null;
        $napAmResult = $isPersonalized ? self::calculateNapAm($date, $birthDate) : null;

        // Lấy điểm số thô
        $noiKhiScore = (float)($noiKhiResult['score'] ?? 0.0);
        $khiThangScoreData = self::calculateKhiThang($date);
        $khiThangScore = (float)($khiThangScoreData['score'] ?? 0.0);

        $canCanScore = $isPersonalized ? (float)($canCanResult['score'] ?? 0.0) : 0.0;
        $chiChiScore = $isPersonalized ? (float)($chiChiResult['score'] ?? 0.0) : 0.0;
        $napAmScore = $isPersonalized ? (float)($napAmResult['score'] ?? 0.0) : 0.0;

        // --- BƯỚC 2: CHUYỂN ĐỔI TỪNG ĐIỂM SANG PHẦN TRĂM (0-100) ---
        $noiKhiPercent = DataHelper::$noiKhiScoreToPercentage[number_format($noiKhiScore, 1)] ?? self::defaultScoreToPercentage($noiKhiScore);
        $khiThangPercent = DataHelper::$khiThangScoreToPercentage[number_format($khiThangScore, 1)] ?? self::defaultScoreToPercentage($khiThangScore, -3.0, 3.0);

        $canCanPercent = $isPersonalized ? (DataHelper::$canCanAgeScoreToPercentage[number_format($canCanScore, 1)] ?? self::defaultScoreToPercentage($canCanScore, -2.0, 2.0)) : 0.0;
        $chiChiPercent = $isPersonalized ? (DataHelper::$chiChiAgeScoreToPercentage[number_format($chiChiScore, 1)] ?? self::defaultScoreToPercentage($chiChiScore)) : 0.0;
        $napAmPercent = $isPersonalized ? (DataHelper::$napAmAgeScoreToPercentage[number_format($napAmScore, 1)] ?? self::defaultScoreToPercentage($napAmScore)) : 0.0;

        // --- BƯỚC 3: TÍNH TỔNG PHẦN TRĂM CÓ TRỌNG SỐ ---
        $componentWeights = $isPersonalized ? DataHelper::$vanKhiComponentWeightsFractionPersonalized : DataHelper::$vanKhiComponentWeightsFractionGeneral;

        $totalVanKhiPercentage = 0.0;
        $totalVanKhiPercentage += $noiKhiPercent * $componentWeights['NoiKhi'];
        $totalVanKhiPercentage += $khiThangPercent * $componentWeights['KhiThang'];
        if ($isPersonalized) {
            $totalVanKhiPercentage += $canCanPercent * $componentWeights['CanCan'];
            $totalVanKhiPercentage += $chiChiPercent * $componentWeights['ChiChi'];
            $totalVanKhiPercentage += $napAmPercent * $componentWeights['NapAm'];
        }
        $totalVanKhiPercentage = max(0.0, min(100.0, $totalVanKhiPercentage));

        // --- BƯỚC 4: CHUYỂN ĐỔI TỔNG PHẦN TRĂM VỀ ĐIỂM CHUẨN HÓA [-2, 2] ---
        $finalNormalizedVanKhiScore = ($totalVanKhiPercentage / 100.0 * 4.0) - 2.0;

        // --- BƯỚC 5: XỬ LÝ CÁC VẤN ĐỀ (ISSUES) ---
        $issues = [];
        if ($isPersonalized) {
            // Xử lý Chi Chi
            $chiChiRelationKey = $chiChiResult['relationKey'] ?? null;
            $badChiChiRelationsForRules = ['Tương phá', 'Tương hại', 'Lục xung'];
            if ($chiChiRelationKey && in_array($chiChiRelationKey, $badChiChiRelationsForRules)) {
                $ruleLevel = self::getRule('CHI_CHI', $chiChiRelationKey, $purpose);
                if (in_array($ruleLevel, ['exclude', 'warn'])) {
                    $reasonText = self::getChiChiWarningName($chiChiRelationKey) . " với tuổi ({$chiChiResult['dayChi']}-{$chiChiResult['birthChi']}).";
                    if ($purpose !== 'TOT_XAU_CHUNG') {
                        $purposeDisplayName = self::getPurposeDisplayName($purpose);
                        $reasonText .= ($ruleLevel === 'exclude') ? " Kỵ thực hiện $purposeDisplayName." : " Thận trọng khi $purposeDisplayName.";
                    }
                    $issues[] = [
                        'level' => $ruleLevel,
                        'source' => 'VanKhi',
                        'reason' => "$reasonText ({$chiChiResult['dayChi']}-{$chiChiResult['birthChi']}) - Cần cân nhắc cho mục đích này.",
                        'details' => [
                            'type' => 'ChiChi',
                            'key' => $chiChiRelationKey,
                            'dayChi' => $chiChiResult['dayChi'],
                            'birthChi' => $chiChiResult['birthChi']
                        ]
                    ];
                }
            }

            // Xử lý Nạp Âm
            $napAmRelationKey = $napAmResult['relationKey'] ?? null;
            $badNapAmRelationsForRules = ['Ngày khắc Tuổi', 'Tuổi khắc Ngày'];
            if ($napAmRelationKey && in_array($napAmRelationKey, $badNapAmRelationsForRules)) {
                $ruleLevel = self::getRule('NAP_AM', $napAmRelationKey, $purpose);
                if (in_array($ruleLevel, ['exclude', 'warn'])) {
                    $purposeDisplayName = self::getNapAmWarningName($napAmRelationKey);
                    if ($purpose !== 'NGAY_KHAC_TUOI') {
                        $purposeDisplayName = self::getPurposeDisplayName($purpose);
                        $reasonText .= ($ruleLevel === 'exclude') ? " Kỵ thực hiện $purposeDisplayName." : " Thận trọng khi $purposeDisplayName.";
                    }
                    $issues[] = [
                        'level' => $ruleLevel,
                        'source' => 'VanKhi',
                        'reason' => "$reasonText ({$napAmResult['dayNapAm']}-{$napAmResult['birthNapAm']}) - Cần cân nhắc cho mục đích này.",
                        'details' => [
                            'type' => 'NapAm',
                            'key' => $napAmRelationKey,
                            'dayNapAm' => $napAmResult['dayNapAm'],
                            'birthNapAm' => $napAmResult['birthNapAm']
                        ]
                    ];
                }
            }
        }
        // Loại bỏ các issue trùng lặp
        $issues = array_values(array_unique($issues, SORT_REGULAR));

        // --- BƯỚC 6: PHÂN LOẠI KẾT QUẢ ---
        if ($finalNormalizedVanKhiScore >= 1.5) $type = 'Rất tốt';
        else if ($finalNormalizedVanKhiScore >= 0.5) $type = 'Tốt';
        else if ($finalNormalizedVanKhiScore > -0.5) $type = 'Trung bình';
        else if ($finalNormalizedVanKhiScore >= -1.5) $type = 'Kém';
        else $type = 'Rất xấu';

        // --- BƯỚC 7: TRẢ VỀ KẾT QUẢ ---
        return [
            'normalizedScore' => max(-2.0, min(2.0, $finalNormalizedVanKhiScore)),
            'type' => $type,
            'issues' => $issues,
            'details' => [
                'noiKhi' => ['score' => $noiKhiScore, 'percentage' => $noiKhiPercent, 'description' => $noiKhiResult['description']],
                'khiThang' => ['score' => $khiThangScore, 'percentage' => $khiThangPercent, 'description' => $khiThangFullResult['analysis'], 'conclusion' => $khiThangFullResult['conclusion']],
                'canCan' => $isPersonalized ? ['score' => $canCanScore, 'percentage' => $canCanPercent, 'description' => $canCanResult['description']] : null,
                'chiChi' => $isPersonalized ? ['score' => $chiChiScore, 'percentage' => $chiChiPercent, 'description' => $chiChiResult['description']] : null,
                'napAm' => $isPersonalized ? ['score' => $napAmScore, 'percentage' => $napAmPercent, 'description' => $napAmResult['description']] : null,
                'totalVanKhiPercentage' => $totalVanKhiPercentage,
                'isPersonalizedCalculation' => $isPersonalized,
            ]
        ];
    }





    private static function calculateNoiKhi(Carbon $date): array
    {
        $carbonDate = Carbon::instance($date);
        $day = $carbonDate->day;
        $month = $carbonDate->month;
        $year = $carbonDate->year;
        $jd = LunarHelper::jdFromDate((int)$day, (int)$month, (int)$year);

        $canChi = LunarHelper::canchiNgayByJD($jd);

        $parts = explode(' ', $canChi);

        if (count($parts) !== 2) {
            return [
                'score' => 0.0,
                'description' => 'Không xác định',
                'type' => 'Trung bình',
            ];
        }

        [$can, $chi] = $parts;

        $canHanh = DataHelper::$canToHanh[$can] ?? 'Kim';
        $chiHanh = DataHelper::$chiToHanh[$chi] ?? 'Thủy';


        if ($canHanh === $chiHanh) {
            return [
                'score' => 2.0,
                'description' => "Nội khí: Đồng hành ($can $chi)",
                'type' => 'Rất tốt',
            ];
        } elseif (NguHanhRelationHelper::isSinh($canHanh, $chiHanh)) {
            return [
                'score' => 2.0,
                'description' => "Nội khí: Can sinh Chi ($can $chi)",
                'type' => 'Rất tốt',
            ];
        } elseif (NguHanhRelationHelper::isSinh($chiHanh, $canHanh)) {
            return [
                'score' => 1.0,
                'description' => "Nội khí: Chi sinh Can ($can $chi)",
                'type' => 'Tốt',
            ];
        } elseif (NguHanhRelationHelper::isKhac($chiHanh, $canHanh)) {
            return [
                'score' => -1.0,
                'description' => "Nội khí: Chi khắc Can ($can $chi)",
                'type' => 'Kém',
            ];
        } else {
            return [
                'score' => -2.0,
                'description' => "Nội khí: Can khắc Chi ($can $chi)",
                'type' => 'Rất xấu',
            ];
        }
    }



    public static function calculateKhiThang(Carbon $date): array
    {
        // --- PHẦN 1: LẤY DỮ LIỆU CAN CHI (Giữ nguyên) ---
        $carbonDate = Carbon::instance($date);
        $al = LunarHelper::convertSolar2Lunar($carbonDate->day,  $carbonDate->month, $carbonDate->year, 7.0);
        $jdNgayAm = LunarHelper::jdFromLunarDate((int)$al[0], (int)$al[1], (int)$al[2], (int)$al[3]);

        $canChiDay = LunarHelper::canchiNgayByJD($jdNgayAm);
        $jday = LunarHelper::jdFromDate((int)$carbonDate->day, (int)$carbonDate->month, (int)$carbonDate->year);
        $dayCanChi = LunarHelper::canchiNgayByJD($jday);
        $canChiMonth = LunarHelper::canchiThang((int)$al[2], (int)$al[1]);

        $dayParts = explode(' ', $dayCanChi);
        $monthParts = explode(' ', $canChiMonth);

        if (count($dayParts) != 2 || count($monthParts) != 2) {
            return ['score' => 0.0, 'description' => 'Không xác định', 'type' => 'Trung bình'];
        }

        $dayCan = $dayParts[0];
        $dayChi = $dayParts[1];
        $monthCan = $monthParts[0];
        $monthChi = $monthParts[1];

        $dayCanHanh = DataHelper::$canToHanh[$dayCan] ?? null;
        $monthCanHanh = DataHelper::$canToHanh[$monthCan] ?? null;
        $dayChiHanh = DataHelper::$chiToHanh[$dayChi] ?? null;
        $monthChiHanh = DataHelper::$chiToHanh[$monthChi] ?? null;

        if (!$dayCanHanh || !$monthCanHanh || !$dayChiHanh || !$monthChiHanh) {
            return ['score' => 0.0, 'description' => 'Lỗi dữ liệu hành', 'type' => 'Trung bình'];
        }

        // --- PHẦN 2: XÁC ĐỊNH QUAN HỆ VÀ LẤY ĐIỂM (Phần được refactor) ---

        // 2.1. Xác định quan hệ giữa Can Tháng và Can Ngày
        $canRelationKey = 'Trung tính';
        if (NguHanhRelationHelper::isSinh($monthCanHanh, $dayCanHanh)) {
            $canRelationKey = 'Tháng sinh Ngày';
        } elseif ($monthCanHanh === $dayCanHanh) {
            $canRelationKey = 'Đồng hành';
        } elseif (NguHanhRelationHelper::isSinh($dayCanHanh, $monthCanHanh)) {
            $canRelationKey = 'Ngày sinh Tháng';
        } elseif (NguHanhRelationHelper::isKhac($monthCanHanh, $dayCanHanh)) {
            $canRelationKey = 'Tháng khắc Ngày';
        } elseif (NguHanhRelationHelper::isKhac($dayCanHanh, $monthCanHanh)) {
            $canRelationKey = 'Ngày khắc Tháng';
        }

        // 2.2. Xác định quan hệ giữa Chi Tháng và Chi Ngày
        $chiRelationKey = 'Trung tính';
        if (NguHanhRelationHelper::isSinh($monthChiHanh, $dayChiHanh)) {
            $chiRelationKey = 'Tháng sinh Ngày';
        } elseif ($monthChiHanh === $dayChiHanh) {
            $chiRelationKey = 'Đồng hành';
        } elseif (NguHanhRelationHelper::isSinh($dayChiHanh, $monthChiHanh)) {
            $chiRelationKey = 'Ngày sinh Tháng';
        } elseif (NguHanhRelationHelper::isKhac($monthChiHanh, $dayChiHanh)) {
            $chiRelationKey = 'Tháng khắc Ngày';
        } elseif (NguHanhRelationHelper::isKhac($dayChiHanh, $monthChiHanh)) {
            $chiRelationKey = 'Ngày khắc Tháng';
        }

        // 2.3. Tra cứu điểm từ bảng hằng số và tính tổng
        $canScore = DataHelper::$khiThangCanCanScores[$canRelationKey] ?? 0.0;
        $chiScore = DataHelper::$khiThangChiChiScores[$chiRelationKey] ?? 0.0;
        $totalScore = $canScore + $chiScore;

        // --- PHẦN 3: TẠO MÔ TẢ VÀ KẾT LUẬN (Sử dụng các key đã xác định) ---

        $descriptionParts = [];
        if ($canRelationKey !== 'Trung tính') {
            $descriptionParts[] = "Can ($canRelationKey)";
        }
        if ($chiRelationKey !== 'Trung tính') {
            $descriptionParts[] = "Chi ($chiRelationKey)";
        }
        $description = "Ngày $canChiDay, Tháng $canChiMonth. " . implode(', ', $descriptionParts);

        // Phân loại kết quả dựa trên tổng điểm
        if ($totalScore >= 2) {
            $type = 'Tốt';
        } elseif ($totalScore >= 0) {
            $type = 'Bình';
        } else {
            $type = 'Xấu';
        }

        return [
            'score' => $totalScore,
            'description' => $description,
            'type' => $type,
            // Thêm các chi tiết để debug nếu cần
            'details' => [
                'can_relation' => $canRelationKey,
                'can_score' => $canScore,
                'chi_relation' => $chiRelationKey,
                'chi_score' => $chiScore,
            ]
        ];
    }

    public static function calculateCanCan(Carbon $date, $birthDate = null): array
    {
        $carbonDate = Carbon::instance($date);
        $day = $carbonDate->day;
        $month = $carbonDate->month;
        $year = $carbonDate->year;

        $al = LunarHelper::convertSolar2Lunar((int)$day, (int)$month, (int)$year);
        $jdNgayAm = LunarHelper::jdFromLunarDate((int)$al[0], (int)$al[1], (int)$al[2], (int)$al[3]);
        $canChiDay = LunarHelper::canchiNgayByJD($jdNgayAm);
        $dayCan = explode(' ', $canChiDay)[0] ?? null;



        if ($birthDate === null) {
            $birthCan = ''; // Mặc định nếu không có ngày sinh
        } else {
            $birthCan = LunarHelper::canchiNam($birthDate);
        }
        if ($dayCan === $birthCan) {
            return [
                'score' => -0.5,
                'description' => 'Trùng Can',
                'type' => 'Hơi xấu',
            ];
        }

        $canHopPairs = [
            'Giáp,Kỷ' => 'Thổ',
            'Ất,Canh' => 'Kim',
            'Bính,Tân' => 'Thủy',
            'Đinh,Nhâm' => 'Mộc',
            'Mậu,Quý' => 'Hỏa',
        ];

        foreach ($canHopPairs as $pair => $element) {
            [$can1, $can2] = explode(',', $pair);
            if (
                ($dayCan === $can1 && $birthCan === $can2) ||
                ($dayCan === $can2 && $birthCan === $can1)
            ) {
                return [
                    'score' => 2.0,
                    'description' => "Hợp hóa $element",
                    'type' => 'Tốt',
                ];
            }
        }

        $canXungPairs = [
            'Giáp,Canh',
            'Canh,Giáp',
            'Ất,Tân',
            'Tân,Ất',
            'Bính,Nhâm',
            'Nhâm,Bính',
            'Đinh,Quý',
            'Quý,Đinh',
        ];

        if (in_array("$dayCan,$birthCan", $canXungPairs)) {
            return [
                'score' => -2.0,
                'description' => 'Can xung',
                'type' => 'Xấu',
            ];
        }

        $dayCanHanh = DataHelper::$canToHanh[$dayCan] ?? 'Kim';
        $birthCanHanh = DataHelper::$canToHanh[$birthCan] ?? ' ';

        if (NguHanhRelationHelper::isSinh($birthCanHanh, $dayCanHanh)) {
            return [
                'score' => 1.0,
                'description' => 'Can tuổi sinh Can ngày',
                'type' => 'Tốt',
            ];
        }

        if (NguHanhRelationHelper::isSinh($dayCanHanh, $birthCanHanh)) {
            return [
                'score' => 0.5,
                'description' => 'Can ngày sinh Can tuổi',
                'type' => 'Khá',
            ];
        }

        if (NguHanhRelationHelper::isKhac($birthCanHanh, $dayCanHanh)) {
            return [
                'score' => -1.0,
                'description' => 'Can tuổi khắc Can ngày',
                'type' => 'Xấu',
            ];
        }

        if (NguHanhRelationHelper::isKhac($dayCanHanh, $birthCanHanh)) {
            return [
                'score' => -1.0,
                'description' => 'Can ngày khắc Can tuổi',
                'type' => 'Xấu',
            ];
        }

        return [
            'score' => 0.0,
            'description' => 'Can bình thường',
            'type' => 'Bình',
        ];
    }



    public static function calculateChiChi(Carbon $date, $birthDate = null): array
    {
        $carbonDate = Carbon::instance($date);
        $day = $carbonDate->day;
        $month = $carbonDate->month;
        $year = $carbonDate->year;

        $al = LunarHelper::convertSolar2Lunar((int)$day, (int)$month, (int)$year);
        $jdNgayAm = LunarHelper::jdFromLunarDate((int)$al[0], (int)$al[1], (int)$al[2], (int)$al[3]);
        $dayCanChi = LunarHelper::canchiNgayByJD($jdNgayAm);
        // $dayCanChi = LunarHelper::canchiNgay($date->year, $date->month, $date->day);


        $dayChi = explode(' ', $dayCanChi)[1];

        if ($birthDate === null) {
            $birthChi = ''; // Mặc định nếu không có ngày sinh
        } else {
            $birthCanChi = LunarHelper::canchiNam($birthDate);
            $birthChi = explode(' ', $birthCanChi)[1];
        }

        $relationKey = '';

        if ($dayChi === $birthChi) {
            $relationKey = GioHoangDaoHelper::isTuHinh($dayChi)
                ? 'Tự hình'
                : 'Trùng (Đồng Chi)';
        } elseif (GioHoangDaoHelper::isTamHop($dayChi, $birthChi)) {
            $relationKey = 'Tam hợp';
        } elseif (GioHoangDaoHelper::isLucHop($dayChi, $birthChi)) {
            $relationKey = 'Lục hợp';
        } elseif (GioHoangDaoHelper::isLucXung($dayChi, $birthChi)) {
            $relationKey = 'Lục xung';
        } elseif (GioHoangDaoHelper::isTuongHai($dayChi, $birthChi)) {
            $relationKey = 'Tương hại';
        } elseif (GioHoangDaoHelper::isTuongHinh($dayChi, $birthChi)) {
            $relationKey = 'Tương hình';
        } elseif (GioHoangDaoHelper::isTuongPha($dayChi, $birthChi)) {
            $relationKey = 'Tương phá';
        } else {
            $relationKey = 'Trung bình (không xung, không hợp)';
        }

        $info = DataHelper::$chiChiAgeInfo[$relationKey] ?? null;

        if ($info === null) {

            return [
                'score' => 0.0,
                'description' => "Chi ngày là $dayChi, Chi tuổi là $birthChi → Quan hệ không xác định (Lỗi dữ liệu).",
                'type' => 'Lỗi cấu hình',
                'relationKey' => 'LỖI_DỮ_LIỆU_CHI_CHI',
                'dayChi' => $dayChi,
                'birthChi' => $birthChi,
            ];
        }

        $rating = $info['rating'] ?? 'Không rõ';
        $explanation = $info['explanation'] ?? '';
        $score = (float)($info['score'] ?? 0);

        $finalDescription = "Chi ngày là $dayChi, Chi tuổi là $birthChi → $relationKey ($rating). $explanation";
        return [
            'score' => $score,
            'description' => $finalDescription,
            'type' => $rating,
            'relationKey' => $relationKey,
            'dayChi' => $dayChi,
            'birthChi' => $birthChi,
        ];
    }


    public static function calculateNapAm(Carbon $date, ?String $birthDate): array
    {
        $dayCanChi = LunarHelper::canchiNgayByJD(
            LunarHelper::jdFromLunarDate(...LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year))
        );
        $birthCanChi = LunarHelper::canchiNam($birthDate);
        $dayNapAmData = DataHelper::$napAmTable[$dayCanChi] ?? [
            'napAm' => 'Không xác định',
            'hanh' => 'Kim'
        ];
        $birthNapAmData = DataHelper::$napAmTable[$birthCanChi] ?? ['napAm' => 'Không xác định', 'hanh' => 'Kim'];
        $dayNapAmName = $dayNapAmData['napAm'];
        $birthNapAmName = $birthNapAmData['napAm'];
        $dayHanh = $dayNapAmData['hanh'];
        $birthHanh = $birthNapAmData['hanh'];
        if ($birthDate === null) {
            $birthHanh = ''; // Mặc định nếu không có ngày sinh
        }
        $score = 0.0;
        $description = '';
        $type = 'Bình';
        $relationKey = 'NONE';

        if ($dayHanh === $birthHanh) {
            $score = 2.0;
            $description = "Đồng hành Nạp Âm ($dayNapAmName)";
            $type = 'Tốt';
            $relationKey = 'DONG_HANH';
        } elseif (NguHanhRelationHelper::isSinh($dayHanh, $birthHanh)) {
            $score = 1.0;
            $description = 'Nạp Âm ngày sinh Nạp Âm tuổi';
            $type = 'Tốt';
            $relationKey = 'NGAY_SINH_TUOI';
        } elseif (NguHanhRelationHelper::isSinh($birthHanh, $dayHanh)) {
            $score = 2.0;
            $description = 'Nạp Âm tuổi sinh Nạp Âm ngày';
            $type = 'Tốt';
            $relationKey = 'TUOI_SINH_NGAY';
        } elseif (NguHanhRelationHelper::isKhac($dayHanh, $birthHanh)) {
            $score = -2.0;
            $description = 'Nạp Âm ngày khắc Nạp Âm tuổi';
            $type = 'Rất xấu';
            $relationKey = 'NGAY_KHAC_TUOI';
        } elseif (NguHanhRelationHelper::isKhac($birthHanh, $dayHanh)) {
            $score = -1.0;
            $description = 'Nạp Âm tuổi khắc Nạp Âm ngày';
            $type = 'Xấu';
            $relationKey = 'TUOI_KHAC_NGAY';
        } else {
            $score = 0.0;
            $description = 'Nạp Âm bình thường';
            $type = 'Bình';
            $relationKey = 'NONE';
        }

        return [
            'score' => $score,
            'description' => $description,
            'type' => $type,
            'relationKey' => $relationKey,
            'dayNapAm' => $dayNapAmName,
            'birthNapAm' => $birthNapAmName,
        ];
    }

    public static function getRule(string $relationType, string $relationKey, string $purpose): string
    {
        $rules = null;
        if ($relationType === 'CHI_CHI') {
            $rules = DataHelper::$chiChiRules; // or from a service
        } elseif ($relationType === 'NAP_AM') {
            $rules = DataHelper::$napAmRules;
        }

        $effectivePurpose = array_key_exists($purpose, DataHelper::$PURPOSE_WEIGHTS)
            ? $purpose
            : 'TOT_XAU_CHUNG';

        if ($rules !== null && array_key_exists($relationKey, $rules)) {
            return $rules[$relationKey][$effectivePurpose] ?? 'none';
        }

        return 'none';
    }

    public static function defaultScoreToPercentage(float $score, float $minScore = -2.0, float $maxScore = 2.0): float
    {
        if ($maxScore <= $minScore) {
            return 50.0; // Tránh chia cho 0
        }
        $percentage = (($score - $minScore) / ($maxScore - $minScore)) * 100.0;
        return max(0.0, min(100.0, $percentage)); // Clamp a.k.a kẹp giá trị
    }

    public static function getNapAmWarningName(string $relationKey): string
    {
        return "Nạp Âm: {$relationKey}";
    }
    public static function getChiChiWarningName(string $relationKey): string
    {
        return match ($relationKey) {
            'LUC_XUNG' => 'Lục Xung',
            'TUONG_HAI' => 'Tương Hại',
            'TUONG_PHA' => 'Tương Phá',
            default => $relationKey,
        };
    }



    /**
     * Tạo phân tích chi tiết và kết luận cho Khí Tháng.
     * Tương đương hàm getDetailedKhiThangInfo trong Dart.
     *
     * @param Carbon $date
     * @return array ['analysis' => string, 'conclusion' => string]
     */
    public static function getDetailedKhiThangInfo(Carbon $date): array
    {
        try {
            // --- PHẦN 1: LẤY DỮ LIỆU CAN CHI (Tương tự hàm trước) ---
            $carbonDate = Carbon::instance($date);
            $al = LunarHelper::convertSolar2Lunar($carbonDate->day, $carbonDate->month, $carbonDate->year, 7.0);
            // $jdNgayAm = LunarHelper::jdFromLunarDate((int)$al[0], (int)$al[1], (int)$al[2], (int)$al[3]);

            // $canChiDay = LunarHelper::canchiNgayByJD($jdNgayAm);
            $jd = LunarHelper::jdFromDate((int)$carbonDate->day, (int)$carbonDate->month, (int)$carbonDate->year);

            $canChiDay = LunarHelper::canchiNgayByJD($jd);
            $canChiMonth = LunarHelper::canchiThang((int)$al[2], (int)$al[1]);

            $dayParts = explode(' ', $canChiDay);
            $monthParts = explode(' ', $canChiMonth);

            if (count($dayParts) != 2 || count($monthParts) != 2) {
                return ['analysis' => 'Lỗi xác định Can Chi ngày/tháng.', 'conclusion' => 'Lỗi'];
            }

            $dayCan = $dayParts[0];
            $dayChi = $dayParts[1];
            $monthCan = $monthParts[0];
            $monthChi = $monthParts[1];

            $dayCanHanh = DataHelper::$canToHanh[$dayCan] ?? 'N/A';
            $monthCanHanh = DataHelper::$canToHanh[$monthCan] ?? 'N/A';
            $dayChiHanh = DataHelper::$chiToHanh[$dayChi] ?? 'N/A';
            $monthChiHanh = DataHelper::$chiToHanh[$monthChi] ?? 'N/A';

            // --- PHẦN 2: PHÂN TÍCH VÀ TÍNH ĐIỂM ---
            $analysisParts = [];
            $totalScore = 0.0;

            // 2.1. Phân tích Can - Can
            $canRelationKey = 'Trung tính'; // Mặc định
            if ($dayCanHanh !== 'N/A' && $monthCanHanh !== 'N/A') {
                if (NguHanhRelationHelper::isSinh($monthCanHanh, $dayCanHanh)) $canRelationKey = 'Tháng sinh Ngày';
                elseif ($monthCanHanh === $dayCanHanh) $canRelationKey = 'Đồng hành';
                elseif (NguHanhRelationHelper::isSinh($dayCanHanh, $monthCanHanh)) $canRelationKey = 'Ngày sinh Tháng';
                elseif (NguHanhRelationHelper::isKhac($monthCanHanh, $dayCanHanh)) $canRelationKey = 'Tháng khắc Ngày';
                elseif (NguHanhRelationHelper::isKhac($dayCanHanh, $monthCanHanh)) $canRelationKey = 'Ngày khắc Tháng';
            }
            // Lấy mô tả từ DataHelper
            $canDescription = DataHelper::$khiThangRelationDescriptions['can'][$canRelationKey] ?? 'Lỗi mô tả Can.';
            $analysisParts[] = "<li>Can ngày $dayCan ($dayCanHanh), Can tháng $monthCan ($monthCanHanh) → $canDescription</li>";
            // Lấy điểm và cộng vào tổng
            $totalScore += DataHelper::$khiThangCanCanScores[$canRelationKey] ?? 0.0;

            // 2.2. Phân tích Chi - Chi
            $chiRelationKey = 'Trung tính'; // Mặc định
            if ($dayChiHanh !== 'N/A' && $monthChiHanh !== 'N/A') {
                if (NguHanhRelationHelper::isSinh($monthChiHanh, $dayChiHanh)) $chiRelationKey = 'Tháng sinh Ngày';
                elseif ($monthChiHanh === $dayChiHanh) $chiRelationKey = 'Đồng hành';
                elseif (NguHanhRelationHelper::isSinh($dayChiHanh, $monthChiHanh)) $chiRelationKey = 'Ngày sinh Tháng';
                elseif (NguHanhRelationHelper::isKhac($monthChiHanh, $dayChiHanh)) $chiRelationKey = 'Tháng khắc Ngày';
                elseif (NguHanhRelationHelper::isKhac($dayChiHanh, $monthChiHanh)) $chiRelationKey = 'Ngày khắc Tháng';
            }
            // Lấy mô tả từ DataHelper
            $chiDescription = DataHelper::$khiThangRelationDescriptions['chi'][$chiRelationKey] ?? 'Lỗi mô tả Chi.';
            $analysisParts[] = "<li>Chi ngày $dayChi ($dayChiHanh), Chi tháng $monthChi ($monthChiHanh) → $chiDescription</li>";
            // Lấy điểm và cộng vào tổng
            $totalScore += DataHelper::$khiThangChiChiScores[$chiRelationKey] ?? 0.0;

            // --- PHẦN 3: TỔNG HỢP KẾT QUẢ ---
            $finalAnalysis = implode("", $analysisParts);
            $finalConclusion = self::getKhiThangConclusion($totalScore);

            return [
                'analysis' => $finalAnalysis,
                'conclusion' => $finalConclusion,
            ];
        } catch (\Throwable $e) {
            Log::error("Lỗi tính Khí Tháng chi tiết: " . $e->getMessage());
            return ['analysis' => 'Lỗi tính toán Khí Tháng.', 'conclusion' => 'Lỗi'];
        }
    }
    //  * Tạo xếp hạng và kết luận chi tiết cho Khí Tháng chỉ từ tổng điểm.
    //      * Đây là phiên bản cải tiến, tự suy ra 'rating' bên trong.
    //      *
    //      * @param float $totalScore Tổng điểm của Khí Tháng.
    //      * @return string Chuỗi kết luận cuối cùng.
    //      */
    public static function getKhiThangConclusion(float $totalScore): string
    {
        // Bước 1: Xác định xếp hạng (rating) dựa trên điểm số
        if ($totalScore >= 3.0) {
            $rating = "<b>Rất Tốt</b>";
        } elseif ($totalScore >= 2.0) {
            $rating = "<b>Tốt</b>";
        } elseif ($totalScore >= 1.0) {
            $rating = "<b>Khá</b>"; // Thêm "Khá" cho phù hợp hơn
        } elseif ($totalScore > -1.0) { // Điểm từ -0.5 đến 0.5
            $rating = "<b>Trung bình</b>";
        } elseif ($totalScore >= -2.0) {
            $rating = "<b>Kém</b>";
        } else {
            $rating = "<b>Rất Xấu</b>";
        }

        // Bước 2: Xác định mô tả chi tiết (description) dựa trên điểm số
        $description = '';
        if ($totalScore >= 3.0) {
            $description = ' (Can – Chi ngày đều được khí tháng nâng đỡ)';
        } elseif ($totalScore >= 2.0) {
            $description = ' (Một phần vượng khí, khí trường ổn định)';
        } elseif ($totalScore >= 1.0) {
            $description = ' (Có hỗ trợ nhẹ từ khí tháng)';
        } elseif (abs($totalScore) < 0.001) { // So sánh số thực với 0 một cách an toàn
            $description = ' (Khí trung tính – không tốt, không xấu)';
        } elseif ($totalScore >= -1.0) {
            $description = ' (Có nghịch khí nhẹ từ tháng âm)';
        } elseif ($totalScore >= -2.0) {
            $description = ' (Tháng khắc ngày – khí bị áp chế rõ)';
        } else { // Điểm < -2.0
            $description = ' (Cực kỳ nghịch khí – nên tránh làm việc lớn)';
        }

        // Bước 3: Kết hợp lại thành chuỗi kết luận cuối cùng
        return "Tổng khí ngày – tháng: $rating$description";
    }
    public static function getKhiThangRating(float $totalScore): string
    {
        if ($totalScore >= 3) {
            return 'Rất tốt';
        }

        if ($totalScore >= 2) {
            return 'Tốt';
        }

        if ($totalScore >= 1) {
            return 'Khá';
        }

        if ($totalScore == 0) {
            return 'Trung bình';
        }

        if ($totalScore >= -1) {
            return 'Kém';
        }

        if ($totalScore >= -2) {
            return 'Xấu';
        }

        return 'Rất xấu';
    }

    public static function getPurposeDisplayName(String $shortName)
    {
        return DataHelper::$purposeShortNameToDisplayName[$shortName] ??
            $shortName; // Trả về tên ngắn nếu không tìm thấy
    }
    private static $diaChi = [
        'Thân',
        'Dậu',
        'Tuất',
        'Hợi',
        'Tý',
        'Sửu',
        'Dần',
        'Mão',
        'Thìn',
        'Tị',
        'Ngọ',
        'Mùi'
    ];

    /**
     * Lấy Địa Chi của một năm dương lịch.
     * Ví dụ: getChiFromYear(1990) sẽ trả về 'Ngọ'.
     *
     * @param int $year Năm dương lịch cần tra cứu.
     * @return string Địa Chi tương ứng.
     */
    public static function getChiFromYear(int $year): string
    {
        // Phép toán modulo (%) 12 sẽ cho ra một số từ 0 đến 11.
        // Số này chính là chỉ số (index) của Địa Chi trong mảng $diaChi.
        // Ví dụ: 1990 % 12 = 10. Phần tử thứ 10 trong mảng là 'Ngọ'.
        //        2024 % 12 = 8. Phần tử thứ 8 trong mảng là 'Thìn'.
        $index = $year % 12;

        return self::$diaChi[$index];
    }
}
