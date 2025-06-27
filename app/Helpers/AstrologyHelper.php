<?php


namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AstrologyHelper
{
    /**
     * Tính tuổi mụ (tuổi âm lịch).
     *
     * @param int $birthYear Năm sinh.
     * @param int|null $checkYear Năm cần xem, nếu null thì lấy năm hiện tại.
     * @return int
     */
    public static function getLunarAge(int $birthYear, ?int $checkYear = null): int
    {
        $checkYear = $checkYear ?? (int)date('Y');
        return $checkYear - $birthYear + 1;
    }

    /**
     * Lấy con giáp từ năm sinh.
     *
     * @param int $year
     * @return string
     */

    public static function getZodiacSign(int $year): string
    {
        // Mảng con giáp đã được sắp xếp lại theo đúng thứ tự, với Tý là gốc 0.
        $zodiacs = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

        // Công thức tính toán dựa trên năm gốc là 1900 (Canh Tý).
        // (2002 - 1900) % 12 = 102 % 12 = 6.
        // Index 6 trong mảng mới là 'Ngọ'. Chính xác.
        $index = ($year - 1900) % 12;

        // Xử lý trường hợp số âm cho các năm trước 1900
        if ($index < 0) {
            $index += 12;
        }

        return $zodiacs[$index];
    }

    /**
     * ======================================================
     * KIỂM TRA KIM LÂU
     * ======================================================
     * @param int $lunarAge Tuổi mụ.
     * @return array
     */
    public static function checkKimLau(int $lunarAge): array
    {
        $remainder = $lunarAge % 9;

        switch ($remainder) {
            case 1:
                return ['is_bad' => true, 'message' => "Phạm Kim Lâu Thân (Hại bản thân)"];
            case 3:
                return ['is_bad' => true, 'message' => "Phạm Kim Lâu Thê (Hại vợ/chồng)"];
            case 6:
                return ['is_bad' => true, 'message' => "Phạm Kim Lâu Tử (Hại con cái)"];
            case 8:
                return ['is_bad' => true, 'message' => "Phạm Kim Lâu Lục Súc (Hại vật nuôi, làm ăn)"];
            default:
                return ['is_bad' => false, 'message' => "Không phạm Kim Lâu"];
        }
    }

    /**
     * ======================================================
     * KIỂM TRA HOANG ỐC
     * ======================================================
     * @param int $lunarAge Tuổi mụ.
     * @return array
     */
    public static function checkHoangOc(int $lunarAge): array
    {
        $cung = [
            1 => ['name' => 'Nhất Cát (Kiết)', 'is_bad' => false, 'meaning' => 'Làm nhà sẽ có chốn an cư, mọi việc hanh thông.'],
            2 => ['name' => 'Nhì Nghi', 'is_bad' => false, 'meaning' => 'Làm nhà sẽ thịnh vượng, giàu có.'],
            3 => ['name' => 'Tam Địa Sát', 'is_bad' => true, 'meaning' => 'Làm nhà sẽ phạm, gia chủ dễ mắc bệnh tật.'],
            4 => ['name' => 'Tứ Tấn Tài', 'is_bad' => false, 'meaning' => 'Làm nhà phúc lộc sẽ tới, làm ăn phát đạt.'],
            5 => ['name' => 'Ngũ Thọ Tử', 'is_bad' => true, 'meaning' => 'Phạm, trong nhà chia rẽ, lâm vào cảnh tử biệt sinh ly.'],
            6 => ['name' => 'Lục Hoang Ốc', 'is_bad' => true, 'meaning' => 'Phạm, khó mà thành đạt được.'],
        ];

        $age = $lunarAge;
        if ($age < 10) {
            // Thường không tính cho tuổi quá nhỏ, nhưng để logic chặt chẽ
            return ['is_bad' => false, 'message' => 'Tuổi quá nhỏ để xét Hoang Ốc'];
        }

        // Công thức tính: Lấy số hàng chục + số hàng đơn vị, chia cho 6 và lấy số dư.
        // Nếu dư 0 thì kết quả là 6.
        $hang_chuc = floor($age / 10);
        $hang_don_vi = $age % 10;

        $index = ($hang_chuc + $hang_don_vi) % 6;
        if ($index == 0) {
            $index = 6;
        }

        $result = $cung[$index];
        $message = "{$result['name']}: {$result['meaning']}";
        return ['is_bad' => $result['is_bad'], 'message' => $message];
    }

    /**
     * ======================================================
     * KIỂM TRA TAM TAI
     * ======================================================
     * @param int $birthYear Năm sinh của người cần xem.
     * @param int|null $checkYear Năm cần xem.
     * @return array
     */
    public static function checkTamTai(int $birthYear, ?int $checkYear = null): array
    {
        $checkYear = $checkYear ?? (int)date('Y');

        $personZodiac = self::getZodiacSign($birthYear);
        $checkYearZodiac = self::getZodiacSign($checkYear);

        // Các nhóm tam hợp và các năm tam tai tương ứng
        $tamTaiMap = [
            'Thân' => ['Dần', 'Mão', 'Thìn'],
            'Tý'   => ['Dần', 'Mão', 'Thìn'],
            'Thìn' => ['Dần', 'Mão', 'Thìn'],

            'Dần'  => ['Thân', 'Dậu', 'Tuất'],
            'Ngọ'  => ['Thân', 'Dậu', 'Tuất'],
            'Tuất' => ['Thân', 'Dậu', 'Tuất'],

            'Hợi'  => ['Tỵ', 'Ngọ', 'Mùi'],
            'Mão'  => ['Tỵ', 'Ngọ', 'Mùi'],
            'Mùi'  => ['Tỵ', 'Ngọ', 'Mùi'],

            'Tỵ'   => ['Hợi', 'Tý', 'Sửu'],
            'Dậu'  => ['Hợi', 'Tý', 'Sửu'],
            'Sửu'  => ['Hợi', 'Tý', 'Sửu'],
        ];

        $tamTaiMeanings = [
            1 => 'Năm thứ nhất: Được xem là năm "khởi sự xấu". Đây là năm không nên bắt đầu công việc lớn như xây nhà, khởi nghiệp, kết hôn, hoặc đầu tư lớn.
Tuy nhiên, mức độ xui xẻo thường chưa nghiêm trọng nhất.',
            2 => 'Năm thứ hai (nặng nhất): Là năm nặng nhất trong chu kỳ tam tai.
Các vấn đề trong công việc, gia đình, sức khỏe hoặc tài chính có thể trở nên rõ ràng và nghiêm trọng hơn.
Không nên thay đổi công việc, xuất hành xa hoặc làm việc lớn trong năm này.',
            3 => 'Năm thứ ba (nhẹ nhất): Là năm "kết thúc". Dù vẫn còn khó khăn nhưng tình hình sẽ nhẹ nhàng hơn so với năm thứ hai.
Đây là thời điểm để giải quyết và kết thúc các vấn đề còn tồn đọng, tránh để kéo dài sang các năm tiếp theo.',
        ];

        if (!isset($tamTaiMap[$personZodiac])) {
            return ['is_bad' => false, 'message' => 'Không phạm Tam Tai.'];
        }

        $tamTaiYears = $tamTaiMap[$personZodiac];

        // Tìm xem năm kiểm tra có nằm trong danh sách năm tam tai không
        $key = array_search($checkYearZodiac, $tamTaiYears);

        if ($key !== false) {
            $tamTaiYearNumber = $key + 1;
            return [
                'is_bad' => true,
                'message' => "Phạm Tam Tai năm {$checkYearZodiac}. Đây là năm Tam Tai thứ {$tamTaiYearNumber}.",
                'details' => $tamTaiMeanings[$tamTaiYearNumber],
            ];
        }

        return ['is_bad' => false, 'message' => "Không phạm Tam Tai trong năm {$checkYearZodiac}."];
    }
     /**
     * Phân tích một năm cụ thể có phạm Thái Tuế, Tuế Phá với tuổi người mất không.
     *
     * @param int $deceasedBirthYearLunar (Năm sinh ÂM LỊCH của người mất)
     * @param int $yearToCheck (Năm dự kiến thực hiện)
     * @return array
     */
    public static function analyzeYearForDeceased(int $deceasedBirthYearLunar, int $yearToCheck): array
    {
        // 1. Lấy thông tin Can Chi
        $chiNguoiMat = KhiVanHelper::getChiFromYear($deceasedBirthYearLunar);
        $canChiNguoiMat = KhiVanHelper::canchiNam($deceasedBirthYearLunar);

        $chiNamKiemTra = KhiVanHelper::getChiFromYear($yearToCheck);
        $canChiNamKiemTra = KhiVanHelper::canchiNam($yearToCheck);

        // 2. Kiểm tra các yếu tố
        // Phạm Thái Tuế: Năm cần xem có Địa Chi TRÙNG với Địa Chi năm sinh người mất.
        $isThaiTue = ($chiNamKiemTra === $chiNguoiMat);

        // Phạm Tuế Phá: Năm cần xem có Địa Chi XUNG với Địa Chi năm sinh người mất.
        $lucXungMap = [
            'Tý' => 'Ngọ', 'Ngọ' => 'Tý', 'Sửu' => 'Mùi', 'Mùi' => 'Sửu',
            'Dần' => 'Thân', 'Thân' => 'Dần', 'Mão' => 'Dậu', 'Dậu' => 'Mão',
            'Thìn' => 'Tuất', 'Tuất' => 'Thìn', 'Tị' => 'Hợi', 'Hợi' => 'Tị',
        ];
        $isTuePha = (isset($lucXungMap[$chiNguoiMat]) && $lucXungMap[$chiNguoiMat] === $chiNamKiemTra);

        // 3. Tạo kết luận
        $isBad = $isThaiTue || $isTuePha;
        $conclusion = '';

        if (!$isBad) {
            $conclusion = sprintf(
                'Năm <strong>%s (%d)</strong> không xung khắc với tuổi của người mất, không phạm Thái Tuế hay Tuế Phá. Đây là năm phù hợp để tiến hành các nghi lễ như động mộ, cải táng hoặc sang cát.',
                $canChiNamKiemTra,
                $yearToCheck
            );
        } else {
            $phamGi = $isThaiTue ? 'Thái Tuế' : 'Tuế Phá';
            $conclusion = sprintf(
                'Năm <strong>%s (%d)</strong> có xung tuổi với người mất, phạm vào <strong>%s</strong> – đây là dấu hiệu không tốt trong phong thủy âm phần.<br>
                <span class="d-block mt-2">👉 Nên cân nhắc chuyển sang năm khác để thực hiện việc động mộ, cải táng hoặc sang cát.</span>
                <span class="d-block mt-1">👉 Nếu vẫn cần tiến hành trong năm nay, nên chọn ngày giờ thật tốt và thực hiện lễ hóa giải đầy đủ để giảm rủi ro.</span>',
                $canChiNamKiemTra,
                $yearToCheck,
                $phamGi
            );
        }

        // 4. Trả về kết quả có cấu trúc
        return [
            'is_bad' => $isBad,
            'is_thai_tue' => $isThaiTue,
            'is_tue_pha' => $isTuePha,
            'deceased_birth_year' => $deceasedBirthYearLunar,
            'deceased_can_chi' => $canChiNguoiMat,
            'check_year' => $yearToCheck,
            'check_year_can_chi' => $canChiNamKiemTra,
            'conclusion' => $conclusion,
        ];
    }
}
