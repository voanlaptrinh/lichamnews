<?php


namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CompatibilityHelper
{
    // --- CÁC DỮ LIỆU CỐ ĐỊNH ---

    private static $thienCan = ['Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    private static $diaChi = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];
    private static $nguHanh = ['Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ'];

    // Bảng tra Ngũ Hành Nạp Âm
    private static $napAmTable = [
        'Giáp Tý' => 'Hải Trung Kim',
        'Ất Sửu' => 'Hải Trung Kim',
        'Bính Dần' => 'Lư Trung Hỏa',
        'Đinh Mão' => 'Lư Trung Hỏa',
        'Mậu Thìn' => 'Đại Lâm Mộc',
        'Kỷ Tỵ' => 'Đại Lâm Mộc',
        'Canh Ngọ' => 'Lộ Bàng Thổ',
        'Tân Mùi' => 'Lộ Bàng Thổ',
        'Nhâm Thân' => 'Kiếm Phong Kim',
        'Quý Dậu' => 'Kiếm Phong Kim',
        'Giáp Tuất' => 'Sơn Đầu Hỏa',
        'Ất Hợi' => 'Sơn Đầu Hỏa',
        'Bính Tý' => 'Giản Hạ Thủy',
        'Đinh Sửu' => 'Giản Hạ Thủy',
        'Mậu Dần' => 'Thành Đầu Thổ',
        'Kỷ Mão' => 'Thành Đầu Thổ',
        'Canh Thìn' => 'Bạch Lạp Kim',
        'Tân Tỵ' => 'Bạch Lạp Kim',
        'Nhâm Ngọ' => 'Dương Liễu Mộc',
        'Quý Mùi' => 'Dương Liễu Mộc',
        'Giáp Thân' => 'Tuyền Trung Thủy',
        'Ất Dậu' => 'Tuyền Trung Thủy',
        'Bính Tuất' => 'Ốc Thượng Thổ',
        'Đinh Hợi' => 'Ốc Thượng Thổ',
        'Mậu Tý' => 'Tích Lịch Hỏa',
        'Kỷ Sửu' => 'Tích Lịch Hỏa',
        'Canh Dần' => 'Tùng Bách Mộc',
        'Tân Mão' => 'Tùng Bách Mộc',
        'Nhâm Thìn' => 'Trường Lưu Thủy',
        'Quý Tỵ' => 'Trường Lưu Thủy',
        'Giáp Ngọ' => 'Sa Trung Kim',
        'Ất Mùi' => 'Sa Trung Kim',
        'Bính Thân' => 'Sơn Hạ Hỏa',
        'Đinh Dậu' => 'Sơn Hạ Hỏa',
        'Mậu Tuất' => 'Bình Địa Mộc',
        'Kỷ Hợi' => 'Bình Địa Mộc',
        'Canh Tý' => 'Bích Thượng Thổ',
        'Tân Sửu' => 'Bích Thượng Thổ',
        'Nhâm Dần' => 'Kim Bạch Kim',
        'Quý Mão' => 'Kim Bạch Kim',
        'Giáp Thìn' => 'Phúc Đăng Hỏa',
        'Ất Tỵ' => 'Phúc Đăng Hỏa',
        'Bính Ngọ' => 'Thiên Hà Thủy',
        'Đinh Mùi' => 'Thiên Hà Thủy',
        'Mậu Thân' => 'Đại Trạch Thổ',
        'Kỷ Dậu' => 'Đại Trạch Thổ',
        'Canh Tuất' => 'Thoa Xuyến Kim',
        'Tân Hợi' => 'Thoa Xuyến Kim',
        'Nhâm Tý' => 'Tang Đố Mộc',
        'Quý Sửu' => 'Tang Đố Mộc',
        'Giáp Dần' => 'Đại Khê Thủy',
        'Ất Mão' => 'Đại Khê Thủy',
        'Bính Thìn' => 'Sa Trung Thổ',
        'Đinh Tỵ' => 'Sa Trung Thổ',
        'Mậu Ngọ' => 'Thiên Thượng Hỏa',
        'Kỷ Mùi' => 'Thiên Thượng Hỏa',
        'Canh Thân' => 'Thạch Lựu Mộc',
        'Tân Dậu' => 'Thạch Lựu Mộc',
        'Nhâm Tuất' => 'Đại Hải Thủy',
        'Quý Hợi' => 'Đại Hải Thủy',
    ];

    // Bảng tra Ngũ Hành của Nạp Âm
    private static $napAmHanh = [
        'Hải Trung Kim' => 'Kim',
        'Kiếm Phong Kim' => 'Kim',
        'Bạch Lạp Kim' => 'Kim',
        'Sa Trung Kim' => 'Kim',
        'Kim Bạch Kim' => 'Kim',
        'Thoa Xuyến Kim' => 'Kim',
        'Lư Trung Hỏa' => 'Hỏa',
        'Sơn Đầu Hỏa' => 'Hỏa',
        'Tích Lịch Hỏa' => 'Hỏa',
        'Sơn Hạ Hỏa' => 'Hỏa',
        'Phúc Đăng Hỏa' => 'Hỏa',
        'Thiên Thượng Hỏa' => 'Hỏa',
        'Đại Lâm Mộc' => 'Mộc',
        'Dương Liễu Mộc' => 'Mộc',
        'Tùng Bách Mộc' => 'Mộc',
        'Bình Địa Mộc' => 'Mộc',
        'Tang Đố Mộc' => 'Mộc',
        'Thạch Lựu Mộc' => 'Mộc',
        'Giản Hạ Thủy' => 'Thủy',
        'Tuyền Trung Thủy' => 'Thủy',
        'Trường Lưu Thủy' => 'Thủy',
        'Thiên Hà Thủy' => 'Thủy',
        'Đại Khê Thủy' => 'Thủy',
        'Đại Hải Thủy' => 'Thủy',
        'Lộ Bàng Thổ' => 'Thổ',
        'Thành Đầu Thổ' => 'Thổ',
        'Ốc Thượng Thổ' => 'Thổ',
        'Bích Thượng Thổ' => 'Thổ',
        'Sa Trung Thổ' => 'Thổ',
        'Đại Trạch Thổ' => 'Thổ',
    ];

    // Bảng tra Cung Phi
    private static $cungPhiList = [1 => 'Khảm', 2 => 'Ly', 3 => 'Cấn', 4 => 'Đoài', 5 => 'Càn', 6 => 'Khôn', 7 => 'Tốn', 8 => 'Chấn', 9 => 'Khôn']; // Nam
    private static $cungPhiListNu = [1 => 'Cấn', 2 => 'Càn', 3 => 'Đoài', 4 => 'Cấn', 5 => 'Ly', 6 => 'Khảm', 7 => 'Khôn', 8 => 'Chấn', 9 => 'Tốn']; // Nữ

    // Bảng Ngũ Hành Cung Phi
    private static $cungPhiHanh = [
        'Khảm' => 'Thủy',
        'Ly' => 'Hỏa',
        'Chấn' => 'Mộc',
        'Tốn' => 'Mộc',
        'Càn' => 'Kim',
        'Đoài' => 'Kim',
        'Cấn' => 'Thổ',
        'Khôn' => 'Thổ'
    ];

    // Bảng quan hệ Cung Phi
    private static $cungPhiRelationMatrix = [
        'Càn' =>  ['Càn' => 'Phục Vị', 'Khôn' => 'Thiên Y', 'Cấn' => 'Sinh Khí', 'Đoài' => 'Phúc Đức', 'Khảm' => 'Lục Sát', 'Ly' => 'Tuyệt Mệnh', 'Chấn' => 'Ngũ Quỷ', 'Tốn' => 'Họa Hại'],
        'Khôn' => ['Càn' => 'Thiên Y', 'Khôn' => 'Phục Vị', 'Cấn' => 'Phúc Đức', 'Đoài' => 'Sinh Khí', 'Khảm' => 'Tuyệt Mệnh', 'Ly' => 'Họa Hại', 'Chấn' => 'Lục Sát', 'Tốn' => 'Ngũ Quỷ'],
        'Cấn' =>  ['Càn' => 'Sinh Khí', 'Khôn' => 'Phúc Đức', 'Cấn' => 'Phục Vị', 'Đoài' => 'Thiên Y', 'Khảm' => 'Họa Hại', 'Ly' => 'Ngũ Quỷ', 'Chấn' => 'Tuyệt Mệnh', 'Tốn' => 'Lục Sát'],
        'Đoài' => ['Càn' => 'Phúc Đức', 'Khôn' => 'Sinh Khí', 'Cấn' => 'Thiên Y', 'Đoài' => 'Phục Vị', 'Khảm' => 'Ngũ Quỷ', 'Ly' => 'Lục Sát', 'Chấn' => 'Họa Hại', 'Tốn' => 'Tuyệt Mệnh'],
        'Khảm' => ['Càn' => 'Lục Sát', 'Khôn' => 'Tuyệt Mệnh', 'Cấn' => 'Họa Hại', 'Đoài' => 'Ngũ Quỷ', 'Khảm' => 'Phục Vị', 'Ly' => 'Sinh Khí', 'Chấn' => 'Thiên Y', 'Tốn' => 'Phúc Đức'],
        'Ly' =>   ['Càn' => 'Tuyệt Mệnh', 'Khôn' => 'Họa Hại', 'Cấn' => 'Ngũ Quỷ', 'Đoài' => 'Lục Sát', 'Khảm' => 'Sinh Khí', 'Ly' => 'Phục Vị', 'Chấn' => 'Phúc Đức', 'Tốn' => 'Thiên Y'],
        'Chấn' => ['Càn' => 'Ngũ Quỷ', 'Khôn' => 'Lục Sát', 'Cấn' => 'Tuyệt Mệnh', 'Đoài' => 'Họa Hại', 'Khảm' => 'Thiên Y', 'Ly' => 'Phúc Đức', 'Chấn' => 'Phục Vị', 'Tốn' => 'Sinh Khí'],
        'Tốn' =>  ['Càn' => 'Họa Hại', 'Khôn' => 'Ngũ Quỷ', 'Cấn' => 'Lục Sát', 'Đoài' => 'Tuyệt Mệnh', 'Khảm' => 'Phúc Đức', 'Ly' => 'Thiên Y', 'Chấn' => 'Sinh Khí', 'Tốn' => 'Phục Vị'],
    ];


    // --- CÁC HÀM TÍNH TOÁN ---

    /**
     * Hàm chính để tính toán độ hợp
     * @param int $year1 Năm sinh người thứ 1
     * @param string $gender1 Giới tính người thứ 1 ('Nam' hoặc 'Nữ')
     * @param int $year2 Năm sinh người thứ 2
     * @param string $gender2 Giới tính người thứ 2 ('Nam' hoặc 'Nữ')
     * @param string $type Loại xem ('capdoi' hoặc 'laman')
     * @return array
     */
    public static function calculate($year1, $gender1, $year2, $gender2, $type = 'capdoi')
    {
        // 1. Lấy thông tin cơ bản
        $person1 = self::getPersonInfo($year1, $gender1);
        $person2 = self::getPersonInfo($year2, $gender2);

        $results = [];
        $totalScore = 0;

        // 2. Tính điểm từng tiêu chí
        // Tiêu chí 1: Ngũ Hành Nạp Âm
        $nguHanhNapAm = self::getNguHanhNapAmScore($person1['nap_am_hanh'], $person2['nap_am_hanh']);
        $results['ngu_hanh_nap_am'] = $nguHanhNapAm;
        $totalScore += $nguHanhNapAm['score'];

        // Tiêu chí 2: Thiên Can
        $thienCan = self::getThienCanScore($person1['thien_can'], $person2['thien_can']);
        $results['thien_can'] = $thienCan;
        $totalScore += $thienCan['score'];

        // Tiêu chí 3: Địa Chi
        $diaChi = self::getDiaChiScore($person1['dia_chi'], $person2['dia_chi']);
        $results['dia_chi'] = $diaChi;
        $totalScore += $diaChi['score'];

        // Tiêu chí 4: Cung Phi
        $cungPhi = self::getCungPhiScore($person1['cung_phi'], $person2['cung_phi']);
        $results['cung_phi'] = $cungPhi;
        $totalScore += $cungPhi['score'];

        // Tiêu chí 5: Ngũ Hành Cung Phi
        $nguHanhCungPhi = self::getNguHanhCungPhiScore($person1['cung_phi_hanh'], $person2['cung_phi_hanh']);
        $results['ngu_hanh_cung_phi'] = $nguHanhCungPhi;
        $totalScore += $nguHanhCungPhi['score'];

        // 3. Kết luận cuối cùng
        $conclusion = self::getConclusion($totalScore, $type);

        return [
            'person1' => $person1,
            'person2' => $person2,
            'details' => $results,
            'total_score' => $totalScore,
            'conclusion' => $conclusion
        ];
    }

    private static function getPersonInfo($year, $gender)
    {
        $canChi = self::getCanChi($year);
        $napAm = self::$napAmTable[$canChi] ?? 'Không rõ';
        $napAmHanh = self::$napAmHanh[$napAm] ?? 'Không rõ';
        $cungPhi = self::getCungPhi($year, $gender);
        $cungPhiHanh = self::$cungPhiHanh[$cungPhi] ?? 'Không rõ';

        return [
            'year' => $year,
            'gender' => $gender,
            'can_chi' => $canChi,
            'thien_can' => substr($canChi, 0, strpos($canChi, ' ')),
            'dia_chi' => substr($canChi, strpos($canChi, ' ') + 1),
            'nap_am' => $napAm,
            'nap_am_hanh' => $napAmHanh,
            'cung_phi' => $cungPhi,
            'cung_phi_hanh' => $cungPhiHanh,
        ];
    }

    private static function getCanChi($year)
    {
        $can = self::$thienCan[($year - 4) % 10];
        $chi = self::$diaChi[($year - 4) % 12];
        return $can . ' ' . $chi;
    }

    private static function getCungPhi($year, $gender)
    {
        $sum = array_sum(str_split($year));
        $remainder = $sum % 9;
        if ($remainder == 0) $remainder = 9;

        if ($gender == 'Nam') {
            return self::$cungPhiList[$remainder];
        } else { // Nữ
            return self::$cungPhiListNu[$remainder];
        }
    }

    // --- CÁC HÀM TÍNH ĐIỂM THEO TIÊU CHÍ ---

    private static function getNguHanhNapAmScore($hanh1, $hanh2)
    {
        $relation = self::getNguHanhRelation($hanh1, $hanh2);
        $score = 0;
        if ($relation === 'Tương sinh') $score = 2;
        if ($relation === 'Tương đồng') $score = 1;
        return ['relation' => $relation, 'score' => $score];
    }

    private static function getThienCanScore($can1, $can2)
    {
        // Tương hợp & Hợp hóa (2 điểm)
        $hopHoa = [['Giáp', 'Kỷ'], ['Ất', 'Canh'], ['Bính', 'Tân'], ['Đinh', 'Nhâm'], ['Mậu', 'Quý']];
        foreach ($hopHoa as $pair) {
            if (in_array($can1, $pair) && in_array($can2, $pair)) {
                // Giả định là Hợp hóa, không xét Hợp hóa giả ở đây cho đơn giản theo bảng điểm
                return ['relation' => 'Hợp hóa', 'score' => 2];
            }
        }

        // Tương khắc (0 điểm)
        $khac = [['Giáp', 'Mậu'], ['Ất', 'Kỷ'], ['Bính', 'Canh'], ['Đinh', 'Tân'], ['Mậu', 'Nhâm'], ['Kỷ', 'Quý'], ['Canh', 'Giáp'], ['Tân', 'Ất'], ['Nhâm', 'Bính'], ['Quý', 'Đinh']];
        foreach ($khac as $pair) {
            if ($pair[0] === $can1 && $pair[1] === $can2) {
                return ['relation' => 'Tương khắc', 'score' => 0];
            }
        }

        // Bình hòa (1 điểm)
        if ($can1 === $can2) {
            return ['relation' => 'Bình hòa', 'score' => 1];
        }

        // Các trường hợp còn lại mặc định là Bình hòa
        return ['relation' => 'Bình hòa', 'score' => 1];
    }

    private static function getDiaChiScore($chi1, $chi2)
    {
        $dias = self::$diaChi;
        $idx1 = array_search($chi1, $dias);
        $idx2 = array_search($chi2, $dias);

        // Tam hợp (2 điểm)
        $tamHop = [['Thân', 'Tý', 'Thìn'], ['Tỵ', 'Dậu', 'Sửu'], ['Dần', 'Ngọ', 'Tuất'], ['Hợi', 'Mão', 'Mùi']];
        foreach ($tamHop as $group) {
            if (in_array($chi1, $group) && in_array($chi2, $group)) {
                return ['relation' => 'Tam hợp', 'score' => 2];
            }
        }

        // Lục hợp (2 điểm)
        if (abs($idx1 + $idx2) == 11 || abs($idx1 - $idx2) == 1) { // Logic Tý-Sửu, Dần-Hợi,...
            $lucHopPairs = [['Tý', 'Sửu'], ['Dần', 'Hợi'], ['Mão', 'Tuất'], ['Thìn', 'Dậu'], ['Tỵ', 'Thân'], ['Ngọ', 'Mùi']];
            foreach ($lucHopPairs as $pair) {
                if (in_array($chi1, $pair) && in_array($chi2, $pair)) {
                    return ['relation' => 'Lục hợp', 'score' => 2];
                }
            }
        }

        // Lục xung (0 điểm)
        if (abs($idx1 - $idx2) == 6) {
            return ['relation' => 'Lục xung', 'score' => 0];
        }

        // Tương hại (0 điểm)
        $tuongHai = [['Tý', 'Mùi'], ['Sửu', 'Ngọ'], ['Dần', 'Tỵ'], ['Mão', 'Thìn'], ['Thân', 'Hợi'], ['Dậu', 'Tuất']];
        foreach ($tuongHai as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair)) {
                return ['relation' => 'Tương hại', 'score' => 0];
            }
        }

        // Tương phá (0 điểm)
        $tuongPha = [['Tý', 'Dậu'], ['Sửu', 'Thìn'], ['Dần', 'Hợi'], ['Mão', 'Ngọ'], ['Tỵ', 'Thân'], ['Mùi', 'Tuất']];
        foreach ($tuongPha as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair)) {
                return ['relation' => 'Tương phá', 'score' => 0];
            }
        }

        // Tự hình (0 điểm) - Thìn-Thìn, Ngọ-Ngọ, Dậu-Dậu, Hợi-Hợi
        if ($chi1 === $chi2 && in_array($chi1, ['Thìn', 'Ngọ', 'Dậu', 'Hợi'])) {
            return ['relation' => 'Tự hình', 'score' => 0];
        }

        // Bình hòa (1 điểm)
        if ($chi1 === $chi2) {
            return ['relation' => 'Bình hòa', 'score' => 1];
        }

        // Các trường hợp không thuộc nhóm nào ở trên cũng là Bình hòa
        return ['relation' => 'Bình hòa', 'score' => 1];
    }

    private static function getCungPhiScore($cung1, $cung2)
    {
        $relation = self::$cungPhiRelationMatrix[$cung1][$cung2] ?? 'Không rõ';
        $score = 0;
        $goodRelations = ['Sinh Khí', 'Thiên Y', 'Phúc Đức', 'Phục Vị'];
        if (in_array($relation, $goodRelations)) {
            $score = 2;
        }
        return ['relation' => $relation, 'score' => $score];
    }

    private static function getNguHanhCungPhiScore($hanh1, $hanh2)
    {
        $relation = self::getNguHanhRelation($hanh1, $hanh2);
        $score = 0;
        if ($relation === 'Tương sinh') $score = 2;
        if ($relation === 'Tương đồng') $score = 1;
        return ['relation' => $relation, 'score' => $score];
    }


    // --- CÁC HÀM TIỆN ÍCH KHÁC ---

    private static function getNguHanhRelation($hanh1, $hanh2)
    {
        if ($hanh1 == $hanh2) return 'Tương đồng';

        $sinh = [
            'Kim' => 'Thủy',
            'Thủy' => 'Mộc',
            'Mộc' => 'Hỏa',
            'Hỏa' => 'Thổ',
            'Thổ' => 'Kim'
        ];

        if (isset($sinh[$hanh1]) && $sinh[$hanh1] == $hanh2) return 'Tương sinh'; // hanh1 sinh hanh2
        if (isset($sinh[$hanh2]) && $sinh[$hanh2] == $hanh1) return 'Tương sinh'; // hanh2 sinh hanh1

        return 'Tương khắc';
    }


    private static function getConclusion($score, $type)
    {
        // --- DIỄN GIẢI CHO XEM TUỔI CẶP ĐÔI (VỢ CHỒNG) ---
        if ($type === 'capdoi') {
            // ... (Phần này giữ nguyên như cũ, không thay đổi)
            if ($score <= 3) {
                $description = "<b>Tổng quan đánh giá</b> </br>
Cặp đôi này có mức độ tương hợp về tử vi – phong thủy khá thấp, chỉ đạt *** điểm trên thang 10. Đây là mức điểm thể hiện sự bất đồng rõ rệt về nhiều mặt, từ ngũ hành, can chi đến cung phi và mệnh khí tổng thể.
 <p><b>Ý nghĩa và tác động:</b></p>
                <ul> 
                <li> Có thể gặp nhiều thử thách trong giao tiếp, đồng thuận và duyên nợ.</li>
                <li>Dễ xảy ra bất đồng quan điểm, khó hòa hợp cảm xúc hoặc định hướng sống.</li>
                <li>Trong trường hợp sống chung hoặc đang yêu, dễ vướng phải trục trặc liên quan đến tài chính, sức khỏe, con cái hoặc các yếu tố ngoại cảnh không thuận.</li>
                </ul>
<p><b>Khuyến nghị ứng xử – hóa giải:</b></p>
<p>Không nên hoảng hốt hoặc bi quan: điểm số chỉ phản ánh khía cạnh mệnh lý, không thay thế hoàn toàn cho tình cảm, đạo đức và sự thấu hiểu.</p>
                   <p>Nếu hai người thực sự yêu thương hoặc có nền tảng gắn bó tốt, hoàn toàn có thể:</p> 
                   <ul>
                   <li>Chọn ngày cưới/phối kết cát nhật để hóa giải.</li>
                   <li>Sinh con hợp tuổi bố mẹ để cân bằng khí cục.</li>
                   <li>Bài trí phong thủy cá nhân hoặc nơi ở theo nguyên lý bù trừ hành khí.</li>
                   <li>Thành tâm hành thiện – tăng phúc đức cũng là cách hóa giải rất mạnh theo quan niệm Á Đông.</li>
                   </ul> 
                   
                   <p><b>Kết luận tổng quan</b> </p
                  <p>Mối quan hệ này không thuận theo mệnh lý, nhưng điều đó không có nghĩa là không có tương lai. Nếu có đủ tình cảm, sự tôn trọng và nỗ lực cùng nhau vượt qua khó khăn, thì hoàn toàn có thể biến trở ngại thành động lực phát triển.</p>
                   ";
                return [
                    'title' => 'KHÔNG HỢP VỀ MỆNH LÝ',
                    'description' =>  $description
                ];
            }
            if ($score <= 5) {
                return [
                    'title' => 'HỢP VỪA PHẢI, CẦN NỖ LỰC HÒA HỢP',
                    'description' => "<b>Tổng quan đánh giá</b> </br>
                Cặp đôi này đạt mức 4 – 5 điểm trong thang tổng hợp 10 điểm, tương đương với mức hợp tuổi trung bình. Mối quan hệ mang tính vừa có duyên vừa có thử thách, với một số yếu tố tương hợp nhưng cũng tồn tại nhiều mâu thuẫn tiềm ẩn về mặt tử vi – phong thủy.</br>
                <p><b>Ý nghĩa và ảnh hưởng</b></p>
                <ul> 
                <li> Có những điểm tương sinh nhẹ hoặc hòa khí trung bình, nhưng đồng thời tồn tại các mặt xung – khắc – đối nghịch trong bản mệnh, cung phi hoặc can chi.</li>
                <li> Mối quan hệ có thể phát triển nếu biết cách dẫn dắt, điều tiết cảm xúc, chấp nhận sự khác biệt.</li>
                <li> Dễ gặp các giai đoạn “lên xuống thất thường”, đặc biệt nếu không có sự sẻ chia hoặc nhường nhịn.</li>
                </ul>

               <p><b> Hướng dẫn hóa giải – củng cố mối quan hệ</b></p>
                   <p>Tận dụng điểm hợp để làm nền, nhưng đồng thời cần chủ động điều chỉnh:</p> 
                   <ul>
                   <li>- Không nên quyết định vội vàng khi có mâu thuẫn – nên lùi lại một bước để nhìn nhận tổng thể </li>
                   <li>- Nếu định tiến tới hôn nhân hoặc làm ăn chung, nên chọn ngày – giờ hợp mệnh, tránh đại kỵ.</li>
                   <li>- Có thể dùng phong thủy cá nhân, màu sắc, hướng hợp mệnh để bổ trợ (ví dụ: trang phục, trang sức, vật phẩm…).</li>
                   <li>- Nên sinh con hợp tuổi bố mẹ để tạo cầu nối vững chắc – đây là phương pháp hóa giải được cổ nhân tin tưởng.</li>
                   </ul> 
                   
                   <p><b>Kết luận tổng thể</b> </p
                  <p>Mối quan hệ ở mức “vừa phải”, không xung phá nghiêm trọng nhưng cũng không phải lý tưởng tuyệt đối. Nếu cả hai có đủ hiểu biết, thiện chí và cùng nhau vun đắp, vẫn hoàn toàn có thể tiến xa và tạo dựng nền tảng bền vững.</p>
                   "
                ];
            }
            if ($score <= 7) {
                return [
                    'title' => 'TƯƠNG HỢP, CÓ NỀN TẢNG VỮNG CHẮC',
                    'description' => "<b>Tổng quan đánh giá</b> </br>
                Với tổng điểm 6 – 7 trên thang 10, đây là mức đánh giá cho thấy cặp đôi có sự hòa hợp khá tốt về mặt mệnh lý – phong thủy. Đây là mức điểm đủ để hình thành một mối quan hệ ổn định, thuận chiều và có khả năng phát triển bền vững.</br>
                <p><b>Ý nghĩa và tác động</b></p>
                <ul> 
                <li>Mối quan hệ có nhiều yếu tố tương sinh – thuận khí, giúp hai người dễ dàng cảm mến, hỗ trợ nhau trong quá trình giao tiếp, sinh hoạt và đồng hành.</li>
                <li>Một vài yếu tố xung nhẹ hoặc không tương trợ hoàn toàn có thể được dung hòa bằng tình cảm, đối thoại và sự tin tưởng.</li>
                <li>Trong mối quan hệ tình cảm hoặc xây dựng gia đình, đây là nền tảng hợp lý để cùng nhau phát triển – tạo dựng thành quả lâu dài.</li>
                </ul>

               <p><b>Hướng dẫn củng cố – phát triển quan hệ</b></p>
                   <p>Có thể tận dụng những yếu tố hợp để:</p> 
                   <ul>
                   <li>Chọn thời điểm cưới hỏi, xây nhà, sinh con... theo hướng cát lợi.</li>
                   <li>Cùng nhau làm những việc thiện, tích đức giúp nâng khí vận cho cả hai.</li>
                   </ul> 
                   <p>Nếu có điểm nào chưa lý tưởng có thể dùng phương pháp “lấy vượng hóa xung” để hóa giải.</p>
                   
                   <p><b>Kết luận tổng thể</b> </p
                  <p>Mối quan hệ này có nhiều điểm tương hợp, là nền móng vững vàng để cùng nhau xây dựng tương lai. Nếu duy trì được sự tin tưởng, sẻ chia và điều chỉnh linh hoạt, hai người hoàn toàn có thể đạt được hạnh phúc dài lâu và phát triển thịnh vượng trong cả đời sống lẫn công việc.</p>
                   "
                ];
            }
            return [
                'title' => 'RẤT HỢP – DUYÊN LÀNH ĐẦY ĐỦ',
                'description' => "<b>Tổng quan đánh giá</b> </br>
           Cặp đôi này đạt mức 8 đến 10 điểm trên thang tổng hợp 10 điểm – một con số rất cao, cho thấy sự hòa hợp sâu sắc cả về mệnh lý, khí cục và nhân duyên. Đây là tổ hợp lý tưởng mà nhiều người mong cầu khi xem tuổi, biểu hiện cho duyên lành – khí thuận – vận cát.</br>
                <p><b>Ý nghĩa và ảnh hưởng</b></p>
                <ul> 
                <li>Hai người có sự tương sinh, hỗ trợ lẫn nhau mạnh mẽ, từ ngũ hành, can chi đến cung mệnh – khí vận.</li>
                <li>Dễ hình thành mối quan hệ bền vững, hòa hợp từ suy nghĩ đến hành động, ít mâu thuẫn sâu, có khả năng thấu hiểu và dìu dắt nhau tiến xa.</li>
                <li>Là cặp đôi có thiên thời – địa lợi – nhân hòa, nếu kết hợp trong tình cảm, hôn nhân hay công việc đều rất có triển vọng thành công.</li>
                </ul>
               <p><b>Hướng phát triển – củng cố thêm vận tốt</b></p>
                   <p>Có thể yên tâm lựa chọn những bước đi quan trọng: kết hôn, sinh con, lập nghiệp, mua nhà, đồng hành dài hạn...</p> 
                   <p>Nên chủ động:</p>
                   <ul>
                   <li>Chọn ngày giờ đại cát để khởi sự, nâng thêm khí vượng.</li>
                   <li>Sinh con trong năm/tháng hợp mệnh để gia đạo càng thêm vượng phát.</li>
                   <li>Tham gia các hoạt động thiện nguyện, phát tâm giúp đời – tích thêm phúc đức, nâng tầm phúc khí chung.</li>
                   </ul> 
                   <p><b>Kết luận tổng thể</b> </p
                  <p>Đây là một cặp đôi có đủ phúc duyên – căn khí để đồng hành lâu dài và thịnh vượng. Nếu nuôi dưỡng được tình cảm và cùng nhau vun bồi đạo đức – trí tuệ – công đức, thì không chỉ cuộc sống viên mãn mà còn lan tỏa cát khí đến thế hệ sau.</p>
            "
            ];
        }

        // --- DIỄN GIẢI CHO XEM TUỔI LÀM ĂN (PHẦN CẦN CẬP NHẬT) ---
        if ($type === 'laman') {
            if ($score <= 3) {
                $description = "
                <b>Tổng quan đánh giá</b> </br>
          Với tổng điểm ***điểm trên thang điểm 10, đây là mức cho thấy hai người chưa có nhiều sự tương hợp về mặt mệnh lý – phong thủy trong việc kết hợp làm ăn. Các yếu tố như ngũ hành, can chi hoặc cung phi có thể chưa tạo ra được sự hỗ trợ rõ nét cho nhau.</br>
                <p><b>Ý nghĩa và tác động</b></p>
                <ul> 
                <li>Có thể tồn tại sự khác biệt trong cách suy nghĩ, hành động hoặc hướng phát triển, khiến quá trình hợp tác đôi khi không liền mạch.</li>
                <li>Một số yếu tố khắc chế nhẹ có thể ảnh hưởng đến sự đồng thuận hoặc tính bền vững của mối quan hệ công việc nếu không được điều chỉnh.</li>
                <li>Tuy nhiên, điều này không có nghĩa là không thể hợp tác, mà cần thêm sự chủ động xây dựng hiểu biết và bổ sung yếu tố hỗ trợ.</li>
                </ul>
               <p><b>Hướng xử lý – hóa giải nhẹ nhàng</b></p>
                   <p>Nếu đã hoặc đang dự định hợp tác, nên:</p> 
          
                   <ul>
                   <li>Phân chia công việc theo sở trường, tránh giẫm chân nhau.</li>
                   <li>Chọn thời điểm bắt đầu công việc hợp cát khí để tăng sinh khí chung.</li>
                   <li>Có thể dùng vật phẩm phong thủy hoặc hướng không gian làm việc phù hợp để điều tiết luồng khí</li>
                   <li>Khuyến khích thực hành chân thành – minh bạch – hỗ trợ lẫn nhau để hóa giải mệnh lý không tương trợ.</li>
                   </ul> 
                   <p><b>Kết luận tổng thể</b> </p
                  <p>Mặc dù chưa đạt mức hợp lý tưởng về tuổi mệnh, nhưng nếu cả hai có sự tin tưởng – phối hợp rõ ràng – hướng tới mục tiêu chung, thì vẫn có thể tạo nên một mối quan hệ làm ăn ổn định. Điều quan trọng là cách vận hành – quản lý – và thiện chí của mỗi người trong quá trình hợp tác.</p>
            ";
                return [
                    'title' => 'CẦN CÂN NHẮC TRONG HỢP TÁC KINH DOANH',
                    'description' => $description
                ];
            }
            if ($score <= 5) {
                $description = "<b>Tổng quan đánh giá</b> </br>
          Tổng điểm 4 - 5 điểm trên thang điểm 10 phản ánh một mức hợp tuổi ở mức trung bình trong quan hệ hợp tác làm ăn. Có những yếu tố mệnh lý hỗ trợ nhẹ, nhưng đồng thời cũng tồn tại một số xung khắc tiềm ẩn, cần lưu ý trong quá trình phối hợp công việc.</br>
                <p><b>Ý nghĩa và tác động</b></p>
                <ul> 
                <li>Hai bạn có thể khác biệt về phong cách làm việc, nhịp độ triển khai hoặc mục tiêu dài hạn, dẫn đến khó tìm được điểm chung nếu không có sự nhẫn nại và tôn trọng.</li>
                <li>Tuy nhiên, vẫn có những điểm hợp giúp tạo dựng nền tảng tương tác ban đầu, chỉ cần biết cách điều chỉnh thì vẫn có thể hợp tác hiệu quả.</li>
                <li>Mối quan hệ dễ bị ảnh hưởng bởi yếu tố ngoại cảnh hoặc người thứ ba, cần sự chủ động giữ kết nối.</li>
                </ul>
               <p><b>Hướng xử lý – củng cố hợp tác</b></p>
                   <ul>
                   <li>Phân vai trò rõ ràng, tránh cùng điều hành một việc hoặc can thiệp quá sâu vào phần việc của nhau.</li>
                   <li>Tìm kiếm một người trung gian hợp cả hai tuổi để cùng tham gia điều phối hoặc cố vấn.</li>
                   <li>Ứng dụng các biện pháp phong thủy cải khí như chọn ngày tốt, bố trí bàn làm việc theo mệnh, dùng biểu tượng chiêu tài – hòa hợp.</li>
                   <li>Đẩy mạnh yếu tố thiện lành: trung thực – minh bạch – cùng hướng thiện, từ đó tạo “nhân tốt” cho “quả lành” trong kinh doanh.</li>
                   </ul> 
                   <p><b>Kết luận tổng thể</b> </p
                  <p>
            Đây là một sự kết hợp chưa hoàn toàn tương trợ, nhưng không quá xung khắc. Nếu cả hai chân thành – có chung tầm nhìn – và biết tận dụng điểm mạnh mỗi người, vẫn có thể cùng nhau tạo ra kết quả tốt đẹp. Điều quan trọng là sự linh hoạt trong ứng xử và thiết lập cơ chế hợp tác hiệu quả.</p>
            ";
                // Tổng điểm là 4 hoặc 5
                return [
                    'title' => 'HỢP VỪA PHẢI, CẦN LƯU Ý TRONG PHỐI HỢP',
                    'description' => $description
                ];
            }
            if ($score <= 7) {
                return [
                    'title' => 'TƯƠNG HỢP TỐT, CÓ THỂ PHÁT TRIỂN LÂU DÀI',
                    'description' => "<b>Tổng quan đánh giá</b> </br>
          Mức điểm 6 – 7 trên thang 10 cho thấy hai người có nền tảng mệnh lý tương đối hài hòa trong việc kết hợp làm ăn. Đây là mức điểm hợp lý để bắt đầu hoặc duy trì một mối quan hệ hợp tác có định hướng, dễ đạt hiệu quả nếu cả hai biết phối hợp và bổ trợ cho nhau đúng cách.</br>
                <p><b>Ý nghĩa và tác động</b></p>
                <ul> 
                <li>Hai người có nhiều điểm thuận lợi về tư duy, năng lượng hành khí hoặc cung mệnh hỗ trợ, giúp việc phối hợp công việc trở nên dễ dàng và rõ ràng.</li>
                <li>Mối quan hệ có xu hướng ổn định, đáng tin cậy, ít xảy ra mâu thuẫn lớn nếu giữ sự tôn trọng và đồng thuận.</li>
                <li>Tuy nhiên, vẫn có thể có vài điểm không tương sinh hoàn toàn (ví dụ: xung nhẹ về ngũ hành hoặc cung phi) – cần chú ý điều hòa để tránh 'trục trặc nhỏ' về lâu dài.</li>
                </ul>
               <p><b>Hướng khai thác và phát triển</b></p>
               <p>Đây là giai đoạn lý tưởng để:</p>
                   <ul>
                   <li>Ký kết – mở rộng – phát triển quy mô kinh doanh nếu có kế hoạch cụ thể.</li>
                   <li>Xây dựng hệ thống quản lý rõ ràng để tận dụng sức mạnh mỗi người.</li>
                   <li>Có thể chọn ngày khởi sự lớn hoặc khai trương dựa trên tuổi cả hai để cộng hưởng sinh khí.</li>
                   <li>Dùng phong thủy ứng dụng nhẹ như chọn hướng làm việc hợp cung, dùng biểu tượng chiêu tài, vật phẩm bảo hộ…</li>
                   </ul> 
                   <p><b>Kết luận tổng thể</b> </p
                  <p> Mối quan hệ này có tiềm năng tốt để trở thành một cặp đôi cộng sự đáng tin cậy. Nếu duy trì được sự cân bằng giữa tình cảm, trách nhiệm và mục tiêu chung, hai người hoàn toàn có thể đồng hành dài hạn và đạt được thành quả đáng kể trong công việc.</p>"
                ];
            }
            // Mặc định 8-10 điểm
            $description = "
          <b>Tổng quan đánh giá</b> </br>
         Tổng điểm 8 điểm phản ánh một mối quan hệ tương hợp mạnh mẽ về mệnh lý, ngũ hành và phong thủy, rất thuận lợi cho việc hợp tác làm ăn. Hai bạn hội tụ nhiều yếu tố “thiên thời – địa lợi – nhân hòa” để xây dựng một quan hệ kinh doanh phát triển bền vững và thịnh vượng.</br>
                <p><b>Ý nghĩa và tác động</b></p>
                <ul> 
                <li>Các yếu tố như ngũ hành sinh trợ, thiên can hòa hợp, địa chi tương phối hoặc cung mệnh tương sinh đều mang lại cảm giác kết nối tự nhiên, dễ phối hợp và nâng đỡ lẫn nhau.</li>
                <li>Mối quan hệ thường ít mâu thuẫn, dễ đạt được đồng thuận, đồng thời có khả năng thúc đẩy nhau cùng phát triển cả về vật chất lẫn uy tín.</li>
                <li>Đây là mô hình hợp tác lý tưởng, dễ sinh tài – dưỡng khí – tăng trưởng bền vững.</li>
                </ul>
               <p><b>Hướng phát triển – củng cố thêm vận tốt</b></p>
               <p>Nên tận dụng thời điểm hợp này để:</p>
                   <ul>
                   <li>Ký kết hợp đồng, mở rộng đầu tư, triển khai kế hoạch lớn.</li>
                   <li>Chọn ngày giờ đại cát để khai trương – ra mắt sản phẩm, nhân đôi cát khí.</li>
                   <li>Áp dụng phong thủy hợp mệnh cả hai để tối ưu hóa không gian làm việc – bàn thờ Thần Tài – hướng đặt biểu tượng tài lộc.</li>
                   <li>Khuyến khích cùng nhau làm thiện – chia sẻ cộng đồng, vừa nâng vận khí, vừa tạo ảnh hưởng tích cực cho thương hiệu.</li>
                   </ul> 
                   <p><b>Kết luận tổng thể</b> </p
                  <p> Đây là một cặp đối tác hợp tác lý tưởng, cộng hưởng mạnh về năng lượng mệnh lý lẫn định hướng phát triển. Nếu kết hợp thêm năng lực thực tế, sự minh bạch và chiến lược rõ ràng, hai người hoàn toàn có thể tạo dựng một hành trình kinh doanh thành công, bền vững và mang lại nhiều giá trị cho cộng đồng.</p>";
            return [
                'title' => 'RẤT HỢP – CỘNG HƯỞNG SINH KHÍ, VƯỢNG TÀI LỘC',
                'description' =>  $description
            ];
        }

        return ['title' => 'Không rõ loại hình xem', 'description' => ''];
    }
}
