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
    public static function calculate($year1, $gender1, $year2, $gender2, $type = 'capdoi', $dategenderA, $dategenderB, $lunarA, $lunarB)
    {
        // 1. Lấy thông tin cơ bản
        $person1 = self::getPersonInfo($year1, $gender1, $dategenderA, $lunarA);
        $person2 = self::getPersonInfo($year2, $gender2, $dategenderB, $lunarB);

        $result = [
            'person1' => $person1,
            'person2' => $person2,
            'type' => $type
        ];

        if ($type === 'capdoi') {
            // Cặp đôi: Tính 2 chiều
            $result['direction1'] = self::calculateDirection($person1, $person2, 'Bạn', 'Người ấy');
            $result['direction2'] = self::calculateDirection($person2, $person1, 'Người ấy', 'Bạn');

            // Kết luận dựa trên điểm cao hơn hoặc trung bình
            $avgScore = $result['direction1']['total_score'];
        
            $result['conclusion'] = self::getConclusion($avgScore, $type);
        } else {
            // Đối tác: Chỉ tính 1 chiều (đối tác so với bạn)
            $result['direction1'] = self::calculateDirection($person2, $person1, 'Đối tác', 'Bạn');
            $result['conclusion'] = self::getConclusion($result['direction1']['total_score'], $type);
        }

        return $result;
    }

    private static function calculateDirection($fromPerson, $toPerson, $fromLabel, $toLabel)
    {
        $results = [];
        $totalScore = 0;

        // Tính điểm từng tiêu chí
        $nguHanhNapAm = self::getNguHanhNapAmScore($fromPerson['nap_am_hanh'], $toPerson['nap_am_hanh']);
        $results['ngu_hanh_nap_am'] = $nguHanhNapAm;
        $totalScore += $nguHanhNapAm['score'];

        $thienCan = self::getThienCanScore($fromPerson['thien_can'], $toPerson['thien_can'], $fromPerson['dia_chi'], $toPerson['dia_chi']);
        $results['thien_can'] = $thienCan;
        $totalScore += $thienCan['score'];

        $diaChi = self::getDiaChiScore($fromPerson['dia_chi'], $toPerson['dia_chi']);
        $results['dia_chi'] = $diaChi;
        $totalScore += $diaChi['score'];

        $cungPhi = self::getCungPhiScore($fromPerson['cung_phi'], $toPerson['cung_phi']);
        $results['cung_phi'] = $cungPhi;
        $totalScore += $cungPhi['score'];

        $nguHanhCungPhi = self::getNguHanhCungPhiScore($fromPerson['cung_phi_hanh'], $toPerson['cung_phi_hanh']);
        $results['ngu_hanh_cung_phi'] = $nguHanhCungPhi;
        $totalScore += $nguHanhCungPhi['score'];

        return [
            'from_label' => $fromLabel,
            'to_label' => $toLabel,
            'details' => $results,
            'total_score' => $totalScore
        ];
    }

    private static function getPersonInfo($year, $gender, $ngaySinhDuongLich, $ngaySinhAmLich)
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
            'ngaySinhDuongLich' => $ngaySinhDuongLich,
            'ngaySinhAmLich' => $ngaySinhAmLich
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

        if ($gender == 'nam') {
            return self::$cungPhiList[$remainder];
        } else { // Nữ
            return self::$cungPhiListNu[$remainder];
        }
    }

    // --- CÁC HÀM TÍNH ĐIỂM THEO TIÊU CHÍ ---

    private static function getNguHanhNapAmScore($hanh1, $hanh2)
    {
        $relation = self::getNguHanhRelation($hanh1, $hanh2);
        $score = self::getDiaChiScoreFromRelationship($relation);
        return ['relation' => $relation, 'score' => $score];
    }

    private static function getThienCanScore($can1, $can2, $chi1 = null, $chi2 = null)
    {
        $relationship = self::getThienCanRelationship($can1, $can2, $chi1, $chi2);
        $score = self::getDiaChiScoreFromRelationship($relationship);
        return ['relation' => $relationship, 'score' => $score];
    }

    private static function getThienCanRelationship($can1, $can2, $chi1 = null, $chi2 = null)
    {
        // Cần có bảng quan hệ TimeConstant, tạm thời sử dụng bảng cơ bản
        $canCanRelationships = [
            'Giáp' => [
                'Giáp' => ['relation' => 'Bình hòa'],
                'Ất' => ['relation' => 'Tương hợp'],
                'Bính' => ['relation' => 'Tương Sinh'],
                'Đinh' => ['relation' => 'Tương Sinh'],
                'Mậu' => ['relation' => 'Tương khắc'],
                'Kỷ' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Thổ'],
                'Canh' => ['relation' => 'Tương khắc'],
                'Tân' => ['relation' => 'Bình hòa'],
                'Nhâm' => ['relation' => 'Tương sinh'],
                'Quý' => ['relation' => 'Tương sinh']
            ],
            'Ất' => [
                'Giáp' => ['relation' => 'Tương hợp'],
                'Ất' => ['relation' => 'Bình hòa'],
                'Bính' => ['relation' => 'Tương Sinh'],
                'Đinh' => ['relation' => 'Tương Sinh'],
                'Mậu' => ['relation' => 'Bình hòa'],
                'Kỷ' => ['relation' => 'Tương khắc'],
                'Canh' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Kim'],
                'Tân' => ['relation' => 'Tương khắc'],
                'Nhâm' => ['relation' => 'Tương sinh'],
                'Quý' => ['relation' => 'Tương sinh']
            ],
            'Bính' => [
                'Giáp' => ['relation' => 'Tương sinh'],
                'Ất' => ['relation' => 'Tương sinh'],
                'Bính' => ['relation' => 'Bình hòa'],
                'Đinh' => ['relation' => 'Tương hợp'],
                'Mậu' => ['relation' => 'Tương Sinh'],
                'Kỷ' => ['relation' => 'Tương Sinh'],
                'Canh' => ['relation' => 'Tương khắc'],
                'Tân' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Thủy'],
                'Nhâm' => ['relation' => 'Tương khắc'],
                'Quý' => ['relation' => 'Bình hòa']
            ],
            'Đinh' => [
                'Giáp' => ['relation' => 'Tương sinh'],
                'Ất' => ['relation' => 'Tương sinh'],
                'Bính' => ['relation' => 'Tương hợp'],
                'Đinh' => ['relation' => 'Bình hòa'],
                'Mậu' => ['relation' => 'Tương Sinh'],
                'Kỷ' => ['relation' => 'Tương Sinh'],
                'Canh' => ['relation' => 'Bình hòa'],
                'Tân' => ['relation' => 'Tương khắc'],
                'Nhâm' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Mộc'],
                'Quý' => ['relation' => 'Tương khắc']
            ],
            'Mậu' => [
                'Giáp' => ['relation' => 'Tương khắc'],
                'Ất' => ['relation' => 'Bình hòa'],
                'Bính' => ['relation' => 'Tương sinh'],
                'Đinh' => ['relation' => 'Tương sinh'],
                'Mậu' => ['relation' => 'Bình hòa'],
                'Kỷ' => ['relation' => 'Tương hợp'],
                'Canh' => ['relation' => 'Tương Sinh'],
                'Tân' => ['relation' => 'Tương Sinh'],
                'Nhâm' => ['relation' => 'Tương khắc'],
                'Quý' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Hỏa']
            ],
            'Kỷ' => [
                'Giáp' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Thổ'],
                'Ất' => ['relation' => 'Tương khắc'],
                'Bính' => ['relation' => 'Tương sinh'],
                'Đinh' => ['relation' => 'Tương sinh'],
                'Mậu' => ['relation' => 'Tương hợp'],
                'Kỷ' => ['relation' => 'Bình hòa'],
                'Canh' => ['relation' => 'Tương Sinh'],
                'Tân' => ['relation' => 'Tương Sinh'],
                'Nhâm' => ['relation' => 'Tương khắc'],
                'Quý' => ['relation' => 'Tương khắc']
            ],
            'Canh' => [
                'Giáp' => ['relation' => 'Tương khắc'],
                'Ất' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Kim'],
                'Bính' => ['relation' => 'Tương khắc'],
                'Đinh' => ['relation' => 'Bình hòa'],
                'Mậu' => ['relation' => 'Tương sinh'],
                'Kỷ' => ['relation' => 'Tương sinh'],
                'Canh' => ['relation' => 'Bình hòa'],
                'Tân' => ['relation' => 'Tương hợp'],
                'Nhâm' => ['relation' => 'Tương Sinh'],
                'Quý' => ['relation' => 'Tương Sinh']
            ],
            'Tân' => [
                'Giáp' => ['relation' => 'Bình hòa'],
                'Ất' => ['relation' => 'Tương khắc'],
                'Bính' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Thủy'],
                'Đinh' => ['relation' => 'Tương khắc'],
                'Mậu' => ['relation' => 'Tương sinh'],
                'Kỷ' => ['relation' => 'Tương sinh'],
                'Canh' => ['relation' => 'Tương hợp'],
                'Tân' => ['relation' => 'Bình hòa'],
                'Nhâm' => ['relation' => 'Tương Sinh'],
                'Quý' => ['relation' => 'Tương Sinh']
            ],
            'Nhâm' => [
                'Giáp' => ['relation' => 'Tương Sinh'],
                'Ất' => ['relation' => 'Tương Sinh'],
                'Bính' => ['relation' => 'Tương khắc'],
                'Đinh' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Mộc'],
                'Mậu' => ['relation' => 'Tương khắc'],
                'Kỷ' => ['relation' => 'Bình hòa'],
                'Canh' => ['relation' => 'Tương sinh'],
                'Tân' => ['relation' => 'Tương sinh'],
                'Nhâm' => ['relation' => 'Bình hòa'],
                'Quý' => ['relation' => 'Tương hợp']
            ],
            'Quý' => [
                'Giáp' => ['relation' => 'Tương Sinh'],
                'Ất' => ['relation' => 'Tương Sinh'],
                'Bính' => ['relation' => 'Bình hòa'],
                'Đinh' => ['relation' => 'Tương khắc'],
                'Mậu' => ['relation' => 'Hợp Hóa', 'hoaKhi' => 'Hỏa'],
                'Kỷ' => ['relation' => 'Tương khắc'],
                'Canh' => ['relation' => 'Tương sinh'],
                'Tân' => ['relation' => 'Tương sinh'],
                'Nhâm' => ['relation' => 'Tương hợp'],
                'Quý' => ['relation' => 'Bình hòa']
            ]
        ];

        $relationshipData = $canCanRelationships[$can1][$can2] ?? null;

        if ($relationshipData === null) {
            return 'Bình hòa';
        }

        $relationType = $relationshipData['relation'];

        if (strpos($relationType, 'Hợp Hóa') === 0) {
            $hoaKhiString = $relationshipData['hoaKhi'];

            // Map hoá khí sang DiaChi để kiểm tra điều kiện
            $hoaKhiConditions = [
                'Thổ' => ['Thìn', 'Tuất', 'Sửu', 'Mùi'],
                'Kim' => ['Tỵ', 'Dậu'],
                'Thủy' => ['Thân', 'Tý'],
                'Mộc' => ['Hợi', 'Mão'],
                'Hỏa' => ['Dần', 'Ngọ']
            ];

            // Nếu có chi1 và chi2, kiểm tra điều kiện hóa khí
            if ($chi1 !== null && $chi2 !== null) {
                if (isset($hoaKhiConditions[$hoaKhiString]) &&
                    (in_array($chi1, $hoaKhiConditions[$hoaKhiString]) ||
                     in_array($chi2, $hoaKhiConditions[$hoaKhiString]))) {
                    return 'Tương hợp'; // Hợp hóa thành công
                } else {
                    return 'Hợp hóa (Hợp hóa giả)'; // Hợp hóa nhưng không đủ điều kiện
                }
            } else {
                // Nếu không có thông tin chi, trả về hợp hóa với loại ngũ hành
                return 'Hợp Hóa (' . $hoaKhiString . ')';
            }
        } else {
            return $relationType;
        }
    }

    private static function getThienCanScoreFromRelationship($relationship)
    {
        switch ($relationship) {
            case 'Tương hợp':
            case 'Tương sinh':
            case 'Hợp Hóa (Thổ)':
            case 'Hợp Hóa (Kim)':
            case 'Hợp Hóa (Thủy)':
            case 'Hợp Hóa (Mộc)':
            case 'Hợp Hóa (Hỏa)':
                return 2.0;
            case 'Hợp hóa (Hợp hóa giả)':
            case 'Bình hòa':
            case 'Tương đồng':

                return 1.0;
            case 'Tương khắc':
                return 0.0;
            default:
                return 0.0;
        }
    }

    private static function getDiaChiScore($chi1, $chi2)
    {
        $relationship = self::getDiaChiRelationship($chi1, $chi2);
        $score = self::getDiaChiScoreFromRelationship($relationship);
        return ['relation' => $relationship, 'score' => $score];
    }

    private static function getDiaChiRelationship($chi1, $chi2)
    {
        // Tam hợp (2 điểm)
        $tamHop = [
            ['Thân', 'Tý', 'Thìn'], // Thủy cục
            ['Tỵ', 'Dậu', 'Sửu'],   // Kim cục
            ['Dần', 'Ngọ', 'Tuất'], // Hỏa cục
            ['Hợi', 'Mão', 'Mùi']   // Mộc cục
        ];
        foreach ($tamHop as $group) {
            if (in_array($chi1, $group) && in_array($chi2, $group) && $chi1 !== $chi2) {
                return 'Tam hợp';
            }
        }

        // Lục hợp (2 điểm)
        $lucHopPairs = [
            ['Tý', 'Sửu'], ['Dần', 'Hợi'], ['Mão', 'Tuất'],
            ['Thìn', 'Dậu'], ['Tỵ', 'Thân'], ['Ngọ', 'Mùi']
        ];
        foreach ($lucHopPairs as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair) && $chi1 !== $chi2) {
                return 'Lục hợp';
            }
        }

        // Lục xung (0 điểm) - đối diện nhau trong 12 chi
        $lucXungPairs = [
            ['Tý', 'Ngọ'], ['Sửu', 'Mùi'], ['Dần', 'Thân'],
            ['Mão', 'Dậu'], ['Thìn', 'Tuất'], ['Tỵ', 'Hợi']
        ];
        foreach ($lucXungPairs as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair) && $chi1 !== $chi2) {
                return 'Lục xung';
            }
        }

        // Tương hại (0 điểm)
        $tuongHai = [
            ['Tý', 'Mùi'], ['Sửu', 'Ngọ'], ['Dần', 'Tỵ'],
            ['Mão', 'Thìn'], ['Thân', 'Hợi'], ['Dậu', 'Tuất']
        ];
        foreach ($tuongHai as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair) && $chi1 !== $chi2) {
                return 'Tương hại';
            }
        }

        // Tương phá (0 điểm)
        $tuongPha = [
            ['Tý', 'Dậu'], ['Sửu', 'Thìn'], ['Dần', 'Hợi'],
            ['Mão', 'Ngọ'], ['Tỵ', 'Thân'], ['Mùi', 'Tuất']
        ];
        foreach ($tuongPha as $pair) {
            if (in_array($chi1, $pair) && in_array($chi2, $pair) && $chi1 !== $chi2) {
                return 'Tương phá';
            }
        }

        // Tự hình (0 điểm) - cùng chi và là chi hình
        if ($chi1 === $chi2 && in_array($chi1, ['Thìn', 'Ngọ', 'Dậu', 'Hợi'])) {
            return 'Tự hình';
        }

        // Bình hòa (1 điểm) - cùng chi không phải hình
        if ($chi1 === $chi2) {
            return 'Bình hòa';
        }

        // Các trường hợp khác
        return 'Bình hòa';
    }

    private static function getDiaChiScoreFromRelationship($relationship)
    {
        switch ($relationship) {
            case 'Tam hợp':
            case 'Lục hợp':
            case 'Tương sinh':
                return 2.0;
            case 'Bình hòa':
            case 'Tương đồng':
                return 1.0;
            case 'Lục xung':
            case 'Tương hại':
            case 'Tương phá':
            case 'Tương khắc':
            case 'Tự hình':
                return 0.0;
            default:
                return 1.0; // Mặc định Bình hòa
        }
    }

    private static function getCungPhiScore($cung1, $cung2)
    {
        $relation = self::$cungPhiRelationMatrix[$cung1][$cung2] ?? 'Không rõ';
        $score = self::getCungPhiScoreFromRelation($relation);
        return ['relation' => $relation, 'score' => $score];
    }

    private static function getCungPhiScoreFromRelation($relation)
    {
        switch ($relation) {
            case 'Sinh Khí':     // Quan hệ tốt nhất
            case 'Thiên Y':      // Quan hệ tốt
            case 'Phúc Đức':     // Quan hệ tốt
                return 2.0;
            case 'Phục Vị':      // Quan hệ trung bình
                return 1.0;
            case 'Lục Sát':      // Quan hệ xấu
            case 'Họa Hại':      // Quan hệ xấu
            case 'Ngũ Quỷ':      // Quan hệ xấu
            case 'Tuyệt Mệnh':   // Quan hệ xấu nhất
                return 0.0;
            default:
                return 0.0;      // Không rõ quan hệ
        }
    }

    private static function getNguHanhCungPhiScore($hanh1, $hanh2)
    {
        $relation = self::getNguHanhRelation($hanh1, $hanh2);
        $score = self::getDiaChiScoreFromRelationship($relation);
        return ['relation' => $relation, 'score' => $score];
    }


    // --- CÁC HÀM TIỆN ÍCH KHÁC ---

    private static function getConclusionFromJson($score, $type)
    {
        $data = self::getConclusionData($type);
        $dataKey = $type === 'laman' ? 'ket_luan_xem_tuoi_lam_an' : 'ket_luan_xem_tuoi';

        foreach ($data[$dataKey] as $level) {
            $range = explode('-', $level['diem']);
            $min = (int)$range[0];
            $max = isset($range[1]) ? (int)$range[1] : 10;

            if ($score >= $min && $score <= $max) {
                return [
                    'score' => $score,
                    'title' => $level['danh_gia'],
                    'description' => self::buildDescriptionFromJson($level, $type)
                ];
            }
        }

        // Default fallback - use first item if no range matches
        $defaultLevel = $data[$dataKey][0];
        return [
            'score' => $score,
            'title' => $defaultLevel['danh_gia'],
            'description' => self::buildDescriptionFromJson($defaultLevel, $type)
        ];
    }

    private static function getConclusionData($type = 'capdoi')
    {
        if ($type === 'laman') {
            return [
                'ket_luan_xem_tuoi_lam_an' => [
                    [
                        'diem' => '0-3',
                        'danh_gia' => 'CẦN CÂN NHẮC TRONG HỢP TÁC KINH DOANH',
                        'title_tong_diem' => 'TỔNG ĐIỂM: ',
                        'title_tong_quan' => 'Tổng quan đánh giá',
                        'title_y_nghia' => 'Ý nghĩa và tác động',
                        'title_huong_dan' => 'Hướng xử lý – hóa giải nhẹ nhàng',
                        'title_ket_luan' => 'Kết luận tổng thể',
                        'tong_quan' => 'Với tổng điểm 0-3 điểm trên thang điểm 10, đây là mức cho thấy hai người chưa có nhiều sự tương hợp về mặt mệnh lý – phong thủy trong việc kết hợp làm ăn. Các yếu tố như ngũ hành, can chi hoặc cung phi có thể chưa tạo ra được sự hỗ trợ rõ nét cho nhau.',
                        'y_nghia_va_tac_dong' => [
                            'Có thể tồn tại sự khác biệt trong cách suy nghĩ, hành động hoặc hướng phát triển, khiến quá trình hợp tác đôi khi không liền mạch.',
                            'Một số yếu tố khắc chế nhẹ có thể ảnh hưởng đến sự đồng thuận hoặc tính bền vững của mối quan hệ công việc nếu không được điều chỉnh.',
                            'Tuy nhiên, điều này không có nghĩa là không thể hợp tác, mà cần thêm sự chủ động xây dựng hiểu biết và bổ sung yếu tố hỗ trợ.'
                        ],
                        'huong_dan' => [
                            'tieu_de' => 'Hướng xử lý – hóa giải nhẹ nhàng',
                            'noi_dung' => 'Nếu đã hoặc đang dự định hợp tác, nên:',
                            'giai_phap' => [
                                'Phân chia công việc theo sở trường, tránh giẫm chân nhau.',
                                'Chọn thời điểm bắt đầu công việc hợp cát khí để tăng sinh khí chung.',
                                'Có thể dùng vật phẩm phong thủy hoặc hướng không gian làm việc phù hợp để điều tiết luồng khí.',
                                'Khuyến khích thực hành chân thành – minh bạch – hỗ trợ lẫn nhau để hóa giải mệnh lý không tương trợ.'
                            ]
                        ],
                        'ket_luan_tong_the' => 'Mặc dù chưa đạt mức hợp lý tưởng về tuổi mệnh, nhưng nếu cả hai có sự tin tưởng – phối hợp rõ ràng – hướng tới mục tiêu chung, thì vẫn có thể tạo nên một mối quan hệ làm ăn ổn định. Điều quan trọng là cách vận hành – quản lý – và thiện chí của mỗi người trong quá trình hợp tác.'
                    ],
                    [
                        'diem' => '4-5',
                        'danh_gia' => 'HỢP VỪA PHẢI, CẦN LƯU Ý TRONG PHỐI HỢP',
                        'title_tong_diem' => 'TỔNG ĐIỂM: ',
                        'title_tong_quan' => 'Tổng quan đánh giá',
                        'title_y_nghia' => 'Ý nghĩa và tác động',
                        'title_huong_dan' => 'Hướng xử lý – củng cố hợp tác',
                        'title_ket_luan' => 'Kết luận tổng thể',
                        'tong_quan' => 'Tổng điểm 4-5 điểm trên thang điểm 10 phản ánh một mức hợp tuổi ở mức trung bình trong quan hệ hợp tác làm ăn. Có những yếu tố mệnh lý hỗ trợ nhẹ, nhưng đồng thời cũng tồn tại một số xung khắc tiềm ẩn, cần lưu ý trong quá trình phối hợp công việc.',
                        'y_nghia_va_tac_dong' => [
                            'Hai bạn có thể khác biệt về phong cách làm việc, nhịp độ triển khai hoặc mục tiêu dài hạn, dẫn đến khó tìm được điểm chung nếu không có sự nhẫn nại và tôn trọng.',
                            'Tuy nhiên, vẫn có những điểm hợp giúp tạo dựng nền tảng tương tác ban đầu, chỉ cần biết cách điều chỉnh thì vẫn có thể hợp tác hiệu quả.',
                            'Mối quan hệ dễ bị ảnh hưởng bởi yếu tố ngoại cảnh hoặc người thứ ba, cần sự chủ động giữ kết nối.'
                        ],
                        'huong_dan' => [
                            'tieu_de' => 'Hướng xử lý – củng cố hợp tác',
                            'noi_dung' => null,
                            'giai_phap' => [
                                'Phân vai trò rõ ràng, tránh cùng điều hành một việc hoặc can thiệp quá sâu vào phần việc của nhau.',
                                'Tìm kiếm một người trung gian hợp cả hai tuổi để cùng tham gia điều phối hoặc cố vấn.',
                                'Ứng dụng các biện pháp phong thủy cải khí như chọn ngày tốt, bố trí bàn làm việc theo mệnh, dùng biểu tượng chiêu tài – hòa hợp.',
                                'Đẩy mạnh yếu tố thiện lành: trung thực – minh bạch – cùng hướng thiện, từ đó tạo "nhân tốt" cho "quả lành" trong kinh doanh.'
                            ]
                        ],
                        'ket_luan_tong_the' => 'Đây là một sự kết hợp chưa hoàn toàn tương trợ, nhưng không quá xung khắc. Nếu cả hai chân thành – có chung tầm nhìn – và biết tận dụng điểm mạnh mỗi người, vẫn có thể cùng nhau tạo ra kết quả tốt đẹp. Điều quan trọng là sự linh hoạt trong ứng xử và thiết lập cơ chế hợp tác hiệu quả.'
                    ],
                    [
                        'diem' => '6-7',
                        'danh_gia' => 'TƯƠNG HỢP TỐT, CÓ THỂ PHÁT TRIỂN LÂU DÀI',
                        'title_tong_diem' => 'TỔNG ĐIỂM: ',
                        'title_tong_quan' => 'Tổng quan đánh giá',
                        'title_y_nghia' => 'Ý nghĩa và tác động',
                        'title_huong_dan' => 'Hướng khai thác và phát triển',
                        'title_ket_luan' => 'Kết luận tổng thể',
                        'tong_quan' => 'Mức điểm 6–7 trên thang 10 cho thấy hai người có nền tảng mệnh lý tương đối hài hòa trong việc kết hợp làm ăn. Đây là mức điểm hợp lý để bắt đầu hoặc duy trì một mối quan hệ hợp tác có định hướng, dễ đạt hiệu quả nếu cả hai biết phối hợp và bổ trợ cho nhau đúng cách.',
                        'y_nghia_va_tac_dong' => [
                            'Hai người có nhiều điểm thuận lợi về tư duy, năng lượng hành khí hoặc cung mệnh hỗ trợ, giúp việc phối hợp công việc trở nên dễ dàng và rõ ràng.',
                            'Mối quan hệ có xu hướng ổn định, đáng tin cậy, ít xảy ra mâu thuẫn lớn nếu giữ sự tôn trọng và đồng thuận.',
                            'Tuy nhiên, vẫn có thể có vài điểm không tương sinh hoàn toàn (ví dụ: xung nhẹ về ngũ hành hoặc cung phi) – cần chú ý điều hòa để tránh "trục trặc nhỏ" về lâu dài.'
                        ],
                        'huong_dan' => [
                            'tieu_de' => 'Hướng khai thác và phát triển',
                            'noi_dung' => 'Đây là giai đoạn lý tưởng để:',
                            'giai_phap' => [
                                'Ký kết – mở rộng – phát triển quy mô kinh doanh nếu có kế hoạch cụ thể.',
                                'Xây dựng hệ thống quản lý rõ ràng để tận dụng sức mạnh mỗi người.',
                                'Có thể chọn ngày khởi sự lớn hoặc khai trương dựa trên tuổi cả hai để cộng hưởng sinh khí.',
                                'Dùng phong thủy ứng dụng nhẹ như chọn hướng làm việc hợp cung, dùng biểu tượng chiêu tài, vật phẩm bảo hộ...'
                            ]
                        ],
                        'ket_luan_tong_the' => 'Mối quan hệ này có tiềm năng tốt để trở thành một cặp đôi cộng sự đáng tin cậy. Nếu duy trì được sự cân bằng giữa tình cảm, trách nhiệm và mục tiêu chung, hai người hoàn toàn có thể đồng hành dài hạn và đạt được thành quả đáng kể trong công việc.'
                    ],
                    [
                        'diem' => '8-10',
                        'danh_gia' => 'RẤT HỢP – CỘNG HƯỞNG SINH KHÍ, VƯỢNG TÀI LỘC',
                        'title_tong_diem' => 'TỔNG ĐIỂM: ',
                        'title_tong_quan' => 'Tổng quan đánh giá',
                        'title_y_nghia' => 'Ý nghĩa và tác động',
                        'title_huong_dan' => 'Hướng phát triển – củng cố thêm vận tốt',
                        'title_ket_luan' => 'Kết luận tổng thể',
                        'tong_quan' => 'Tổng điểm 8-10 điểm phản ánh một mối quan hệ tương hợp mạnh mẽ về mệnh lý, ngũ hành và phong thủy, rất thuận lợi cho việc hợp tác làm ăn. Hai bạn hội tụ nhiều yếu tố "thiên thời – địa lợi – nhân hòa" để xây dựng một quan hệ kinh doanh phát triển bền vững và thịnh vượng.',
                        'y_nghia_va_tac_dong' => [
                            'Các yếu tố như ngũ hành sinh trợ, thiên can hòa hợp, địa chi tương phối hoặc cung mệnh tương sinh đều mang lại cảm giác kết nối tự nhiên, dễ phối hợp và nâng đỡ lẫn nhau.',
                            'Mối quan hệ thường ít mâu thuẫn, dễ đạt được đồng thuận, đồng thời có khả năng thúc đẩy nhau cùng phát triển cả về vật chất lẫn uy tín.',
                            'Đây là mô hình hợp tác lý tưởng, dễ sinh tài – dưỡng khí – tăng trưởng bền vững.'
                        ],
                        'huong_dan' => [
                            'tieu_de' => 'Hướng phát triển – củng cố thêm vận tốt',
                            'noi_dung' => 'Nên tận dụng thời điểm hợp này để:',
                            'giai_phap' => [
                                'Ký kết hợp đồng, mở rộng đầu tư, triển khai kế hoạch lớn.',
                                'Chọn ngày giờ đại cát để khai trương – ra mắt sản phẩm, nhân đôi cát khí.',
                                'Áp dụng phong thủy hợp mệnh cả hai để tối ưu hóa không gian làm việc – bàn thờ Thần Tài – hướng đặt biểu tượng tài lộc.',
                                'Khuyến khích cùng nhau làm thiện – chia sẻ cộng đồng, vừa nâng vận khí, vừa tạo ảnh hưởng tích cực cho thương hiệu.'
                            ]
                        ],
                        'ket_luan_tong_the' => 'Đây là một cặp đôi hợp tác lý tưởng, cộng hưởng mạnh về năng lượng mệnh lý lẫn định hướng phát triển. Nếu kết hợp thêm năng lực thực tế, sự minh bạch và chiến lược rõ ràng, hai người hoàn toàn có thể tạo dựng một hành trình kinh doanh thành công, bền vững và mang lại nhiều giá trị cho cộng đồng.'
                    ]
                ]
            ];
        }

        return [
            'ket_luan_xem_tuoi' => [
                [
                    'diem' => '0-3',
                    'danh_gia' => 'KHÔNG HỢP VỀ MỆNH LÝ',
                    'title_tong_quan' => 'Tổng quan đánh giá',
                    'title_y_nghia' => 'Ý nghĩa và tác động',
                    'title_khuyen_nghi' => 'Khuyến nghị ứng xử – hóa giải',
                    'title_ket_luan' => 'Kết luận tổng thể',
                    'tong_quan' => 'Cặp đôi này có mức độ tương hợp về tử vi – phong thủy khá thấp, thể hiện sự bất đồng rõ rệt về nhiều mặt, từ ngũ hành, can chi đến cung phi và mệnh khí tổng thể.',
                    'y_nghia_va_tac_dong' => [
                        'Có thể gặp nhiều thử thách trong giao tiếp, đồng thuận và duyên nợ.',
                        'Dễ xảy ra bất đồng quan điểm, khó hòa hợp cảm xúc hoặc định hướng sống.',
                        'Trong trường hợp sống chung hoặc đang yêu, dễ vướng phải trục trặc liên quan đến tài chính, sức khỏe, con cái hoặc các yếu tố ngoại cảnh không thuận.'
                    ],
                    'khuyen_nghi' => [
                        'noi_dung' => 'Không nên hoảng hốt hoặc bi quan: điểm số chỉ phản ánh khía cạnh mệnh lý, không thay thế hoàn toàn cho tình cảm, đạo đức và sự thấu hiểu. Nếu hai người thực sự yêu thương hoặc có nền tảng gắn bó tốt, hoàn toàn có thể:',
                        'giai_phap' => [
                            'Chọn ngày cưới/phối kết cát nhật để hóa giải.',
                            'Sinh con hợp tuổi bố mẹ để cân bằng khí cục.',
                            'Bài trí phong thủy cá nhân hoặc nơi ở theo nguyên lý bù trừ hành khí.',
                            'Thành tâm hành thiện – tăng phúc đức cũng là cách hóa giải rất mạnh theo quan niệm Á Đông.'
                        ]
                    ],
                    'ket_luan_tong_quan' => 'Mối quan hệ này không thuận theo mệnh lý, nhưng điều đó không có nghĩa là không có tương lai. Nếu có đủ tình cảm, sự tôn trọng và nỗ lực cùng nhau vượt qua khó khăn, thì hoàn toàn có thể biến trở ngại thành động lực phát triển.'
                ],
                [
                    'diem' => '4-5',
                    'danh_gia' => 'HỢP VỪA PHẢI, CẦN NỖ LỰC HÒA HỢP',
                    'title_tong_quan' => 'Tổng quan đánh giá',
                    'title_y_nghia' => 'Ý nghĩa và ảnh hưởng',
                    'title_khuyen_nghi' => 'Hướng dẫn hóa giải – củng cố mối quan hệ',
                    'title_ket_luan' => 'Kết luận tổng thể',
                    'tong_quan' => 'Cặp đôi này có mức hợp tuổi trung bình, mối quan hệ vừa có duyên vừa kèm theo thử thách, tồn tại một số yếu tố tương hợp nhưng cũng ẩn chứa nhiều mâu thuẫn về mặt tử vi – phong thủy.',
                    'y_nghia_va_anh_huong' => [
                        'Có những điểm tương sinh nhẹ hoặc hòa khí trung bình, nhưng đồng thời tồn tại các mặt xung – khắc – đối nghịch trong bản mệnh, cung phi hoặc can chi.',
                        'Mối quan hệ có thể phát triển nếu biết cách dẫn dắt, điều tiết cảm xúc, chấp nhận sự khác biệt.',
                        'Dễ gặp các giai đoạn "lên xuống thất thường", đặc biệt nếu không có sự sẻ chia hoặc nhường nhịn.'
                    ],
                    'huong_dan' => [
                        'noi_dung' => 'Tận dụng điểm hợp để làm nền, nhưng đồng thời cần chủ động điều chỉnh:',
                        'giai_phap' => [
                            'Không nên quyết định vội vàng khi có mâu thuẫn – nên lùi lại một bước để nhìn nhận tổng thể.',
                            'Nếu định tiến tới hôn nhân hoặc làm ăn chung, nên chọn ngày – giờ hợp mệnh, tránh đại kỵ.',
                            'Có thể dùng phong thủy cá nhân, màu sắc, hướng hợp mệnh để bổ trợ (ví dụ: trang phục, trang sức, vật phẩm...).',
                            'Nên sinh con hợp tuổi bố mẹ để tạo cầu nối vững chắc – đây là phương pháp hóa giải được cổ nhân tin tưởng.'
                        ]
                    ],
                    'ket_luan_tong_quan' => 'Mối quan hệ ở mức "vừa phải", không xung phá nghiêm trọng nhưng cũng không phải lý tưởng tuyệt đối. Nếu cả hai có đủ hiểu biết, thiện chí và cùng nhau vun đắp, vẫn hoàn toàn có thể tiến xa và tạo dựng nền tảng bền vững.'
                ],
                [
                    'diem' => '6-7',
                    'danh_gia' => 'TƯƠNG HỢP, CÓ NỀN TẢNG VỮNG CHẮC',
                    'title_tong_quan' => 'Tổng quan đánh giá',
                    'title_y_nghia' => 'Ý nghĩa và tác động',
                    'title_khuyen_nghi' => 'Hướng dẫn củng cố – phát triển quan hệ',
                    'title_ket_luan' => 'Kết luận tổng thể',
                    'tong_quan' => 'Cặp đôi này có sự hòa hợp khá tốt về mặt mệnh lý – phong thủy, đủ nền tảng để xây dựng một mối quan hệ ổn định, thuận chiều và có khả năng phát triển bền vững.',
                    'y_nghia_va_tac_dong' => [
                        'Mối quan hệ có nhiều yếu tố tương sinh – thuận khí, giúp hai người dễ dàng cảm mến, hỗ trợ nhau trong quá trình giao tiếp, sinh hoạt và đồng hành.',
                        'Một vài yếu tố xung nhẹ hoặc không tương trợ hoàn toàn có thể được dung hòa bằng tình cảm, đối thoại và sự tin tưởng.',
                        'Trong mối quan hệ tình cảm hoặc xây dựng gia đình, đây là nền tảng hợp lý để cùng nhau phát triển – tạo dựng thành quả lâu dài.'
                    ],
                    'huong_dan' => [
                        'noi_dung' => 'Có thể tận dụng những yếu tố hợp để:',
                        'giai_phap' => [
                            'Chọn thời điểm cưới hỏi, xây nhà, sinh con... theo hướng cát lợi.',
                            'Cùng nhau làm những việc thiện, tích đức giúp nâng khí vận cho cả hai.',
                            'Nếu có điểm nào chưa lý tưởng có thể dùng phương pháp "lấy vượng hóa xung" để hóa giải.'
                        ]
                    ],
                    'ket_luan_tong_quan' => 'Mối quan hệ này có nhiều điểm tương hợp, là nền móng vững vàng để cùng nhau xây dựng tương lai. Nếu duy trì được sự tin tưởng, sẻ chia và điều chỉnh linh hoạt, hai người hoàn toàn có thể đạt được hạnh phúc dài lâu và phát triển thịnh vượng trong cả đời sống lẫn công việc.'
                ],
                [
                    'diem' => '8-10',
                    'danh_gia' => 'RẤT HỢP – DUYÊN LÀNH ĐẦY ĐỦ',
                    'title_tong_quan' => 'Tổng quan đánh giá',
                    'title_y_nghia' => 'Ý nghĩa và ảnh hưởng',
                    'title_khuyen_nghi' => 'Hướng phát triển – củng cố thêm vận tốt',
                    'title_ket_luan' => 'Kết luận tổng thể',
                    'tong_quan' => 'Cặp đôi này có sự hòa hợp sâu sắc cả về mệnh lý, khí cục và nhân duyên, được xem là tổ hợp lý tưởng mà nhiều người mong cầu khi xem tuổi, biểu hiện cho duyên lành – khí thuận – vận cát.',
                    'y_nghia_va_anh_huong' => [
                        'Hai người có sự tương sinh, hỗ trợ lẫn nhau mạnh mẽ, từ ngũ hành, can chi đến cung mệnh – khí vận.',
                        'Dễ hình thành mối quan hệ bền vững, hòa hợp từ suy nghĩ đến hành động, ít mâu thuẫn sâu, có khả năng thấu hiểu và dìu dắt nhau tiến xa.',
                        'Là cặp đôi có thiên thời – địa lợi – nhân hòa, nếu kết hợp trong tình cảm, hôn nhân hay công việc đều rất có triển vọng thành công.'
                    ],
                    'huong_dan' => [
                        'noi_dung' => 'Có thể yên tâm lựa chọn những bước đi quan trọng: kết hôn, sinh con, lập nghiệp, mua nhà, đồng hành dài hạn...',
                        'giai_phap' => [
                            'Chọn ngày giờ đại cát để khởi sự, nâng thêm khí vượng.',
                            'Sinh con trong năm/tháng hợp mệnh để gia đạo càng thêm vượng phát.',
                            'Tham gia các hoạt động thiện nguyện, phát tâm giúp đời – tích thêm phúc đức, nâng tầm phúc khí chung.'
                        ]
                    ],
                    'ket_luan_tong_quan' => 'Đây là một cặp đôi có đủ phúc duyên – căn khí để đồng hành lâu dài và thịnh vượng. Nếu nuôi dưỡng được tình cảm và cùng nhau vun bồi đạo đức – trí tuệ – công đức, thì không chỉ cuộc sống viên mãn mà còn lan tỏa cát khí đến thế hệ sau.'
                ]
            ]
        ];
    }

    private static function buildDescriptionFromJson($level, $type = 'capdoi')
    {
        $description = "<p>{$level['tong_quan']}</p>";

        // Ý nghĩa và tác động
        if (isset($level['y_nghia_va_tac_dong'])) {
            $description .= "<h5>{$level['title_y_nghia']}</h5>";
            $description .= "<ul>";
            foreach ($level['y_nghia_va_tac_dong'] as $item) {
                $description .= "<li>{$item}</li>";
            }
            $description .= "</ul>";
        }

        // Ý nghĩa và ảnh hưởng (cho mức 4-5 điểm)
        if (isset($level['y_nghia_va_anh_huong'])) {
            $description .= "<h5>{$level['title_y_nghia']}</h5>";
            $description .= "<ul>";
            foreach ($level['y_nghia_va_anh_huong'] as $item) {
                $description .= "<li>{$item}</li>";
            }
            $description .= "</ul>";
        }

        // Khuyến nghị (cho mức 0-3 điểm)
        if (isset($level['khuyen_nghi'])) {
            $description .= "<h5>{$level['title_khuyen_nghi']}</h5>";
            if (isset($level['khuyen_nghi']['noi_dung']) && $level['khuyen_nghi']['noi_dung']) {
                $description .= "<p>{$level['khuyen_nghi']['noi_dung']}</p>";
            }
            if (isset($level['khuyen_nghi']['giai_phap'])) {
                $description .= "<ul>";
                foreach ($level['khuyen_nghi']['giai_phap'] as $item) {
                    $description .= "<li>{$item}</li>";
                }
                $description .= "</ul>";
            }
        }

        // Hướng dẫn (cho mức 4-5 và 6-7 điểm)
        if (isset($level['huong_dan'])) {
            $titleKey = $type === 'laman' ? 'title_huong_dan' : 'title_khuyen_nghi';
            $description .= "<h5>{$level[$titleKey]}</h5>";
            if (isset($level['huong_dan']['noi_dung']) && $level['huong_dan']['noi_dung']) {
                $description .= "<p>{$level['huong_dan']['noi_dung']}</p>";
            }
            if (isset($level['huong_dan']['giai_phap'])) {
                $description .= "<ul>";
                foreach ($level['huong_dan']['giai_phap'] as $item) {
                    $description .= "<li>{$item}</li>";
                }
                $description .= "</ul>";
            }
        }

        // Kết luận
        $description .= "<h5>{$level['title_ket_luan']}</h5>";
        $ketLuanKey = $type === 'laman' ? 'ket_luan_tong_the' : 'ket_luan_tong_quan';
        $description .= "<p>{$level[$ketLuanKey]}</p>";

        return $description;
    }


    private static function getNguHanhRelation($hanh1, $hanh2)
    {
        // Kiểm tra Tương sinh (chỉ một chiều)
        if (($hanh1 === 'Kim' && $hanh2 === 'Thủy') ||
            ($hanh1 === 'Thủy' && $hanh2 === 'Mộc') ||
            ($hanh1 === 'Mộc' && $hanh2 === 'Hỏa') ||
            ($hanh1 === 'Hỏa' && $hanh2 === 'Thổ') ||
            ($hanh1 === 'Thổ' && $hanh2 === 'Kim')) {
            return 'Tương sinh';
        }

        // Kiểm tra Tương đồng
        if ($hanh1 === $hanh2) {
            return 'Tương đồng';
        }

        // Kiểm tra Tương khắc (chỉ một chiều)
        if (($hanh1 === 'Thổ' && $hanh2 === 'Thủy') ||
            ($hanh1 === 'Kim' && $hanh2 === 'Mộc') ||
            ($hanh1 === 'Thủy' && $hanh2 === 'Hỏa') ||
            ($hanh1 === 'Mộc' && $hanh2 === 'Thổ') ||
            ($hanh1 === 'Hỏa' && $hanh2 === 'Kim')) {
            return 'Tương khắc';
        }

        // Các trường hợp khác
        return 'Bình hòa';
    }


    private static function getConclusion($score, $type)
    {
        // --- DIỄN GIẢI CHO XEM TUỔI CẶP ĐÔI (VỢ CHỒNG) ---
        if ($type === 'capdoi') {
            return self::getConclusionFromJson($score, 'capdoi');
        }

        // --- DIỄN GIẢI CHO XEM TUỔI LÀM ĂN ---
        if ($type === 'laman') {
            return self::getConclusionFromJson($score, 'laman');
        }

        return ['title' => 'Không rõ loại hình xem', 'description' => ''];
    }
}
