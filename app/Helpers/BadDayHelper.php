<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Class BadDayHelper
 * Helper để kiểm tra các ngày kỵ trong tháng Âm lịch.
 * 
 * CÁCH DÙNG:
 * $date = Carbon::create(2025, 3, 4); // Ngày Dương lịch
 * $badDays = BadDayHelper::checkBadDays($date);
 * if (!empty($badDays)) {
 *     echo "Ngày này phạm các ngày kỵ sau:\n";
 *     foreach ($badDays as $name => $reason) {
 *         echo "- $name: $reason\n";
 *     }
 * } else {
 *     echo "Ngày này không phạm ngày kỵ nào trong danh sách.";
 * }
 */
class BadDayHelper
{
    // --- DỮ LIỆU NGÀY KỴ ---

    private static $tamNguongDays = [3, 7, 13, 18, 22, 27];
    private static $nguyetKyDays = [5, 14, 23];

    private static $duongCongKyDays = [
        1 => [13],
        2 => [11],
        3 => [9],
        4 => [7],
        5 => [5],
        6 => [3],
        7 => [8, 29],
        8 => [27],
        9 => [25],
        10 => [23],
        11 => [21],
        12 => [19],
    ];

    private static $satChuAm = [
        1 => 'Tỵ',
        2 => 'Tý',
        3 => 'Sửu',
        4 => 'Mão',
        5 => 'Thân',
        6 => 'Tuất',
        7 => 'Hợi',
        8 => 'Sửu',
        9 => 'Ngọ',
        10 => 'Dậu',
        11 => 'Dần',
        12 => 'Thìn'
    ];

    private static $satChuDuong = [
        'Tý' => [1],
        'Sửu' => [2, 3, 7, 9],
        'Thìn' => [5, 6, 8, 10, 12],
        'Mùi' => [11],
        'Tuất' => [4],
    ];

    private static $kimThanThatSat = [
        'Giáp' => ['Ngọ', 'Mùi', 'Thân', 'Dậu'],
        'Kỷ'   => ['Ngọ', 'Mùi', 'Thân', 'Dậu'],
        'Ất'   => ['Thìn', 'Tỵ'],
        'Canh' => ['Thìn', 'Tỵ'],
        'Bính' => ['Dần', 'Mão', 'Ngọ', 'Mùi'],
        'Tân'  => ['Dần', 'Mão', 'Ngọ', 'Mùi'],
        'Đinh' => ['Dần', 'Mão', 'Tuất', 'Hợi'],
        'Nhâm' => ['Dần', 'Mão', 'Tuất', 'Hợi'],
        'Mậu'  => ['Thân', 'Dậu', 'Tý', 'Sửu'],
        'Quý'  => ['Thân', 'Dậu', 'Tý', 'Sửu'],
    ];

    private static $trungPhuc = [
        1 => 'Canh',
        2 => 'Tân',
        3 => 'Kỷ',
        4 => 'Nhâm',
        5 => 'Quý',
        6 => 'Mậu',
        7 => 'Giáp',
        8 => 'Ất',
        9 => 'Kỷ',
        10 => 'Nhâm',
        11 => 'Quý',
        12 => 'Kỷ'
    ];

    private static $thoTu = [
        1 => 'Tuất',
        2 => 'Thìn',
        3 => 'Hợi',
        4 => 'Tỵ',
        5 => 'Tý',
        6 => 'Ngọ',
        7 => 'Sửu',
        8 => 'Mùi',
        9 => 'Dần',
        10 => 'Thân',
        11 => 'Mão',
        12 => 'Dậu'
    ];

    // --- GIẢI THÍCH Ý NGHĨA ---

    private static $badDayMeanings = [
        'TAM_NUONG' => "Ngày Tam Nương (mùng 3, 7, 13, 18, 22, 27 âm lịch) là ngày mang nhiều âm khí, dễ gây bất ổn, thất bại. Trong ngày này, nên tránh khai trương, cưới hỏi, động thổ, ký hợp đồng lớn để hạn chế rủi ro.",
        'NGUYET_KY' => "Ngày Nguyệt Kỵ (mùng 5, 14, 23 âm lịch) là ngày khí vận bất ổn, dễ gặp xui rủi. Dân gian gọi là \"nửa đời, nửa đoạn\", nên tránh xuất hành, khai trương, cưới hỏi hay khởi công lớn để tránh đứt gánh giữa đường.",
        'NGUYET_TAN' => "Ngày Nguyệt Tận là ngày cuối cùng của tháng âm lịch, khi âm khí vượng, dương khí suy kiệt. Ngày này dễ mang vận xui, thất bại, hao tổn nên cần tránh khai trương, cưới hỏi, động thổ hay khởi sự việc trọng đại.",
        'DUONG_CONG_KY_NHAT' => "Ngày Dương Công Kỵ Nhật là những ngày đặc biệt xấu được ghi chép trong lịch pháp cổ. Ngày này dễ gây hao tài, hỏng việc, tổn hại phúc khí nên tuyệt đối kiêng khai trương, cưới hỏi, động thổ hay nhập trạch.",
        'SAT_CHU_AM' => "Ngày Sát Chủ Âm là ngày kiêng kỵ những việc làm thuộc về tâm linh như xây mộ, chôn cất, cúng tế... Nếu tiến hành có thể khiến gia chủ gặp bất lợi nặng nề, thậm chí là tai hoạ.",
        'SAT_CHU_DUONG' => "Ngày Sát Chủ Dương là ngày kiêng kỵ làm những việc trọng đại liên quan đến người sống như xây dựng nhà cửa, cưới xin, mua xe, nhậm chức…",
        'KIM_THAN_THAT_SAT' => "Ngày Kim Thần Thất Sát mang hành Kim quá độ, gây ra luồng khí lạnh lẽo và tính sát phạt. Ảnh hưởng đến sức khỏe và tạo ra xung đột. Nên tránh các việc quan trọng như cưới gả, xây nhà, giao dịch lớn.",
        'TRUNG_PHUC' => "Ngày Trùng Phục là ngày âm khí trùng điệp, dễ sinh tang tóc, chia ly, vận rủi nối tiếp. Kiêng tuyệt đối việc cưới hỏi, động thổ, khai trương và an táng để tránh hậu hoạ kéo dài.",
        'THO_TU' => "Ngày Thọ Tử (Thụ Tử) là ngày đại hung, mang vận khí sinh ly, tang tóc. Ngày này tuyệt đối kiêng cưới hỏi, khai trương, nhập trạch và an táng để tránh hậu họa kéo dài, tổn thọ phúc phần."
    ];

    /**
     * Hàm chính để kiểm tra một ngày Dương lịch có phạm phải các ngày kỵ không.
     *
     * @param Carbon $date Đối tượng Carbon của ngày cần kiểm tra.
     * @return array Mảng chứa các ngày kỵ mà ngày đó phạm phải. Key là tên ngày, value là giải thích.
     */
    public static function checkBadDays(Carbon $date): array
    {
        // --- PHẦN LẤY DỮ LIỆU ÂM LỊCH (ĐÃ SỬA) ---
        // Gọi hàm của bạn và nhận đủ 5 phần tử
        list($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $monthLengthStr) = \App\Helpers\LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);

        $jd = \App\Helpers\LunarHelper::jdFromDate($date->day, $date->month, $date->year);
        $canChiNgay = \App\Helpers\LunarHelper::canchiNgayByJD($jd);
        list($dayCan, $dayChi) = explode(' ', $canChiNgay);


        // Lưu ý: hàm canchiNam của bạn không có trong file, nên tôi sẽ tạm thời comment nó lại
        // hoặc bạn có thể thay bằng hàm có sẵn nếu có.
        // Giả sử KhiVanHelper tồn tại và có hàm canchiNam
        $canChiNam = \App\Helpers\KhiVanHelper::canchiNam($date->year);
        list($yearCan, $yearChi) = explode(' ', $canChiNam);

        $results = [];

        // 1. Kiểm tra Tam Nương
        if (in_array($lunarDay, self::$tamNguongDays)) {
            $results['Tam Nương'] = self::$badDayMeanings['TAM_NUONG'];
        }

        // 2. Kiểm tra Nguyệt Kỵ
        if (in_array($lunarDay, self::$nguyetKyDays)) {
            $results['Nguyệt Kỵ'] = self::$badDayMeanings['NGUYET_KY'];
        }

        // --- PHẦN KIỂM TRA NGÀY NGUYỆT TẬN (ĐÃ SỬA) ---
        // 3. Kiểm tra Nguyệt Tận
        // Chuyển chuỗi 'Đủ'/'Thiếu' thành số ngày
        $daysInMonth = ($monthLengthStr === 'Đủ') ? 30 : 29;
        if ($lunarDay === $daysInMonth) {
            $results['Nguyệt Tận'] = self::$badDayMeanings['NGUYET_TAN'];
        }
        // --- KẾT THÚC SỬA PHẦN NGÀY NGUYỆT TẬN ---

        // 4. Kiểm tra Dương Công Kỵ Nhật
        if (isset(self::$duongCongKyDays[$lunarMonth]) && in_array($lunarDay, self::$duongCongKyDays[$lunarMonth])) {
            $results['Dương Công Kỵ Nhật'] = self::$badDayMeanings['DUONG_CONG_KY_NHAT'];
        }

        // 5. Kiểm tra Sát Chủ Âm
        // Chuyển chi thành chữ thường để khớp với dữ liệu
        $dayChiLower = mb_strtolower($dayChi, 'UTF-8');
        if (isset(self::$satChuAm[$lunarMonth]) && self::$satChuAm[$lunarMonth] === $dayChiLower) {
            $results['Sát Chủ Âm'] = self::$badDayMeanings['SAT_CHU_AM'];
        }

        // 6. Kiểm tra Sát Chủ Dương
        if (isset(self::$satChuDuong[$dayChiLower]) && in_array($lunarMonth, self::$satChuDuong[$dayChiLower])) {
            $results['Sát Chủ Dương'] = self::$badDayMeanings['SAT_CHU_DUONG'];
        }

        // 7. Kiểm tra Kim Thần Thất Sát
        // Chuyển can năm thành chữ thường
        $yearCanLower = mb_strtolower($yearCan, 'UTF-8');
        if (isset(self::$kimThanThatSat[$yearCanLower]) && in_array($dayChiLower, self::$kimThanThatSat[$yearCanLower])) {
            $results['Kim Thần Thất Sát'] = self::$badDayMeanings['KIM_THAN_THAT_SAT'];
        }

        // 8. Kiểm tra Trùng Phục
        // Chuyển can ngày thành chữ thường
        $dayCanLower = mb_strtolower($dayCan, 'UTF-8');
        if (isset(self::$trungPhuc[$lunarMonth]) && self::$trungPhuc[$lunarMonth] === $dayCanLower) {
            $results['Trùng Phục'] = self::$badDayMeanings['TRUNG_PHUC'];
        }

        // 9. Kiểm tra Thọ Tử
        if (isset(self::$thoTu[$lunarMonth]) && self::$thoTu[$lunarMonth] === $dayChiLower) {
            $results['Thọ Tử (Thụ Tử)'] = self::$badDayMeanings['THO_TU'];
        }

        return $results;
    }


    public static function getPersonBasicInfo(Carbon $dob): array
    {
        $birthYear = $dob->year;
        $canChiNam = KhiVanHelper::canchiNam($birthYear);
        $menh = DataHelper::$napAmTable[$canChiNam];
        $zodiac = AstrologyHelper::getZodiacSign($birthYear);
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);

        return [
            'dob' => $dob,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'menh' => $menh,
            'zodiac' => $zodiac,
        ];
    }

    public static function getDetailedAnalysisForPerson(Carbon $dateToCheck, Carbon $personDob, string $personTitle, $purpose = ''): array
    {
        $personInfo = self::getPersonBasicInfo($personDob);
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $chiNgay = explode(' ', $getThongTinCanChiVaIcon['can_chi_ngay'])[1] ?? '';

        return [
            'personTitle' => $personTitle,
            'personInfo' => $personInfo,
            'score' => GoodBadDayHelper::calculateDayScore($dateToCheck, $personDob->year, $purpose),
            'noiKhiNgay' => KhiVanHelper::getDetailedNoiKhiExplanation($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
            'getVongKhiNgayThang' => KhiVanHelper::getDetailedKhiThangInfo($dateToCheck),
            'getCucKhiHopXung' => FengShuiHelper::getCucKhiHopXung($chiNgay),
            'analyzeNgayVoiTuoi' => FengShuiHelper::analyzeNgayVoiTuoi($getThongTinCanChiVaIcon['can_chi_ngay'], $personInfo['can_chi_nam']),
        ];
    }



    public static function getdetailtable(Carbon $dateToCheck)
    {
        $lunarParts = LunarHelper::convertSolar2Lunar($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $dayCanChi = LunarHelper::canchiNgayByJD(LunarHelper::jdFromDate($dateToCheck->day, $dateToCheck->month, $dateToCheck->year));
        $jd = \App\Helpers\LunarHelper::jdFromDate($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $canChiNgay = \App\Helpers\LunarHelper::canchiNgayByJD($jd);
        list($dayCan, $dayChi) = explode(' ', $canChiNgay);
        $hopxungNgay = FengShuiHelper::getCucKhiHopXung($dayChi);
        $canChiThang = KhiVanHelper::canchiThang($dateToCheck->year, $dateToCheck->month);
        $canChiNam = KhiVanHelper::canchiNam($dateToCheck->year);
        // Lấy thứ trong tuần
        $dayOfWeek = $dateToCheck->locale('vi')->dayName;

        return [
            'can_chi_ngay' => $canChiNgay,
            'can_chi_thang' => $canChiThang,
            'can_chi_nam' => $canChiNam,
            'dateToCheck' => $dateToCheck,
            'day' => $dateToCheck->day,
            'month' => $dateToCheck->month,
            'year' => $dateToCheck->year,
            'dayOfWeek' => $dayOfWeek,
            'lunarDateStr' => sprintf('Ngày %s (%02d/%02d)', $dayCanChi, $lunarParts[0], $lunarParts[1]),
            'badDays' => BadDayHelper::checkBadDays($dateToCheck),
            'getThongTinNgay' => FunctionHelper::getThongTinNgay($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'nhiThapBatTu' => FunctionHelper::nhiThapBatTu($dateToCheck->year, $dateToCheck->month, $dateToCheck->day),
            'getThongTinTruc' => FunctionHelper::getThongTinTruc($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'getSaoTotXauInfo' => FunctionHelper::getSaoTotXauInfo($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'al' => $lunarParts, // Giữ lại biến 'al' cho tiện
            'hopxungNgay' => $hopxungNgay,
        ];
    }
}
