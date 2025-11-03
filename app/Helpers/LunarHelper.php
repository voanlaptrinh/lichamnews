<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LunarHelper
{



    static public function kiemtraNgayXau($dd, $mm, $yy)
    {
        $data = array();
        list($lunarDay, $lunarMonth, $lunarYear, $lunarLeap) = self::convertSolar2Lunar($dd, $mm, $yy);
        $jd = self::jdFromDate($dd, $mm, $yy);
        $can_chi_ngay = self::canchiNgayByJD($jd);
        list($can_ngay, $chi_ngay) = explode(' ', strtolower($can_chi_ngay));
        $can_chi_nam = self::canchiNam($lunarYear);
        list($can_nam, $chi_nam) = explode(' ', strtolower($can_chi_nam));

        if (in_array($lunarDay, array(3, 7, 13, 18, 22, 27))) {
            $data[] = 'tam nương';
        }
        if (in_array($lunarDay, array(5, 14, 23))) {
            $data[] = 'nguyệt kỵ';
        }
        /*kiểm tra ngày sát chủ*/
        if (($chi_ngay == 'tý' && in_array($lunarMonth, array(1)))
            || ($chi_ngay == 'sửu' && in_array($lunarMonth, array(2, 3, 7, 9)))
            || ($chi_ngay == 'tuất' && in_array($lunarMonth, array(4)))
            || ($chi_ngay == 'thìn' && in_array($lunarMonth, array(5, 6, 8, 10, 12)))
            || ($chi_ngay == 'mùi' && in_array($lunarMonth, array(11)))
        ) {
            $data[] = 'sát chủ dương';
        }
        if (($chi_ngay == 'tỵ' && $lunarMonth == 1) || ($chi_ngay == 'tý' && $lunarMonth == 2) || ($chi_ngay == 'mùi' && $lunarMonth == 3)
            || ($chi_ngay == 'mão' && $lunarMonth == 4) || ($chi_ngay == 'thân' && $lunarMonth == 5) || ($chi_ngay == 'tuất' && $lunarMonth == 6)
            || ($chi_ngay == 'sửu' && $lunarMonth == 7) || ($chi_ngay == 'hợi' && $lunarMonth == 8) || ($chi_ngay == 'ngọ' && $lunarMonth == 9)
            || ($chi_ngay == 'dậu' && $lunarMonth == 10) || ($chi_ngay == 'dần' && $lunarMonth == 11) || ($chi_ngay == 'thìn' && $lunarMonth == 12)
        ) {
            $data[] = 'sát chủ âm';
        }
        /*ngày trùng*/
        if (($can_ngay == 'canh' && $lunarMonth == 1) || ($can_ngay == 'tân' && $lunarMonth == 2) || ($can_ngay == 'kỷ' && $lunarMonth == 3)
            || ($can_ngay == 'nhâm' && $lunarMonth == 4) || ($can_ngay == 'quý' && $lunarMonth == 5) || ($can_ngay == 'mậu' && $lunarMonth == 6)
            || ($can_ngay == 'giáp' && $lunarMonth == 7) || ($can_ngay == 'ất' && $lunarMonth == 8) || ($can_ngay == 'kỷ' && $lunarMonth == 9)
            || ($can_ngay == 'nhâm' && $lunarMonth == 10) || ($can_ngay == 'quý' && $lunarMonth == 11) || ($can_ngay == 'kỷ' && $lunarMonth == 12)
        ) {
            $data[] = 'trùng phục';
        }
        /*kim thần thất sát*/
        if ((in_array($can_nam, array('giáp', 'kỷ')) && in_array($chi_ngay, array('ngọ', 'mùi')))
            || (in_array($can_nam, array('ất', 'canh')) && in_array($chi_ngay, array('thìn', 'tỵ')))
            || (in_array($can_nam, array('bính', 'tân')) && in_array($chi_ngay, array('dần', 'mão')))
            || (in_array($can_nam, array('đinh', 'nhâm')) && in_array($chi_ngay, array('tuất', 'hợi')))
            || (in_array($can_nam, array('mậu', 'quý')) && in_array($chi_ngay, array('thân', 'dậu')))
        ) {
            $data[] = 'kim thần thất sát';
        }
        /*thụ tử*/
        if (($chi_ngay == 'tuất' && $lunarMonth == 1) || ($chi_ngay == 'thìn' && $lunarMonth == 2) || ($chi_ngay == 'hợi' && $lunarMonth == 3)
            || ($chi_ngay == 'tỵ' && $lunarMonth == 4) || ($chi_ngay == 'tý' && $lunarMonth == 5) || ($chi_ngay == 'ngọ' && $lunarMonth == 6)
            || ($chi_ngay == 'sửu' && $lunarMonth == 7) || ($chi_ngay == 'mùi' && $lunarMonth == 8) || ($chi_ngay == 'dần' && $lunarMonth == 9)
            || ($chi_ngay == 'thân' && $lunarMonth == 10) || ($chi_ngay == 'mão' && $lunarMonth == 11) || ($chi_ngay == 'dậu' && $lunarMonth == 12)
        ) {
            $data[] = 'thụ tử';
        }

        /*dương công kỵ*/
        if (($lunarMonth === 1 && $lunarDay === 13)
            || ($lunarMonth === 2 && $lunarDay === 12)
            || ($lunarMonth === 3 && $lunarDay === 9)
            || ($lunarMonth === 4 && $lunarDay === 7)
            || ($lunarMonth === 5 && $lunarDay === 5)
            || ($lunarMonth === 6 && $lunarDay === 3)
            || ($lunarMonth === 7 && in_array($lunarDay, array(8, 29)))
            || ($lunarMonth === 8 && $lunarDay === 27)
            || ($lunarMonth === 9 && $lunarDay === 25)
            || ($lunarMonth === 10 && $lunarDay === 23)
            || ($lunarMonth === 11 && $lunarDay === 21)
            || ($lunarMonth === 12 && $lunarDay === 19)
        ) {
            $data[] = 'dương công kỵ';
        }

        return $data;
    }

    static function gioHoangDaoByNgay($chi_ngay)
    {
        switch ($chi_ngay) {
            case 'dần':
            case 'thân':
                return array('tý', 'sửu',  'thìn', 'tỵ',  'mùi', 'tuất');
            case 'mão':
            case 'dậu':
                return array('tý', 'dần', 'mão', 'ngọ', 'mùi', 'dậu');
            case 'thìn':
            case 'tuất':
                return array('dần', 'thìn', 'tỵ', 'thân', 'dậu', 'hợi');
            case 'tỵ':
            case 'hợi':
                return array('sửu', 'thìn', 'ngọ', 'mùi', 'tuất', 'hợi');
            case 'tý':
            case 'ngọ':
                return array('tý', 'sửu', 'mão', 'ngọ', 'thân', 'dậu');
            case 'sửu':
            case 'mùi':
                return array('dần', 'mão', 'tỵ', 'thân', 'tuất', 'hợi');

            default:
                return array();
        }
    }
    static function gioHacDaoByNgay($chi_ngay)
    {
        switch ($chi_ngay) {
            case 'dần':
            case 'thân':
                return array('dần', 'mão', 'ngọ', 'thân', 'dậu', 'hợi');
            case 'mão':
            case 'dậu':
                return array('sửu', 'thìn', 'tỵ', 'thân', 'tuất', 'hợi');
            case 'thìn':
            case 'tuất':
                return array('tý', 'sửu', 'mão', 'ngọ', 'mùi', 'tuất');
            case 'tỵ':
            case 'hợi':
                return array('tý', 'dần', 'mão', 'tỵ', 'thân', 'dậu');
            case 'tý':
            case 'ngọ':
                return array('dần', 'thìn', 'tỵ', 'mùi', 'tuất', 'hợi');
            case 'sửu':
            case 'mùi':
                return array('tý', 'sửu', 'thìn', 'ngọ', 'mùi', 'dậu');

            default:
                return array();
        }
    }


    static function tietKhiByJD($jd)
    {
        // Trả về tên tiết khí
        return DataHelper::$TIETKHI[self::getSunLongitudeKinh($jd + 1)];
    }

    static function tietKhiWithIcon($jd): array
    {
        $tietKhi = self::tietKhiByJD($jd);

        // Viết hoa đúng định dạng để map với $tietKhiIcons
        $tietKhiFormatted = implode(' ', array_map('ucfirst', explode(' ', mb_strtolower($tietKhi, 'UTF-8'))));

        $icon = DataHelper::$tietKhiIcons[$tietKhiFormatted] ?? '';

        return [
            'tiet_khi' => $tietKhiFormatted,
            'icon' => $icon
        ];
    }
    static function sw_get_weekday($yymmdd = '')
    {
        $timetocheck = $yymmdd ? strtotime($yymmdd) : time();
        $weekday = date("l", $timetocheck);
        $weekday = strtolower($weekday);
        switch ($weekday) {
            case 'monday':
                $weekday = 'Thứ Hai';
                break;
            case 'tuesday':
                $weekday = 'Thứ Ba';
                break;
            case 'wednesday':
                $weekday = 'Thứ Tư';
                break;
            case 'thursday':
                $weekday = 'Thứ Năm';
                break;
            case 'friday':
                $weekday = 'Thứ Sáu';
                break;
            case 'saturday':
                $weekday = 'Thứ Bảy';
                break;
            default:
                $weekday = 'Chủ Nhật';
                break;
        }
        return $weekday;
    }
    static function decodeLunarYear($yy, $k)
    {
        $ly = array();
        $monthLengths = array(29, 30);
        $regularMonths = array(12);
        $offsetOfTet = $k >> 17;
        $leapMonth = $k & 0xf;
        $leapMonthLength = $monthLengths[$k >> 16 & 0x1];
        $solarNY = self::jdFromDate(1, 1, $yy);
        $currentJD = $solarNY + $offsetOfTet;
        $j = $k >> 4;
        for ($i = 0; $i < 12; $i++) {
            $regularMonths[12 - $i - 1] = $monthLengths[$j & 0x1];
            $j >>= 1;
        }
        if ($leapMonth == 0) {
            for ($mm = 1; $mm <= 12; $mm++) {
                $ly[] = array(
                    'day' => 1,
                    'month' => $mm,
                    'year' => $yy,
                    'leap' => 0,
                    'jd' => $currentJD,
                );
                $currentJD += $regularMonths[$mm - 1];
            }
        } else {
            for ($mm = 1; $mm <= $leapMonth; $mm++) {
                $ly[] = array(
                    'day' => 1,
                    'month' => $mm,
                    'year' => $yy,
                    'leap' => 0,
                    'jd' => $currentJD,
                );
                $currentJD += $regularMonths[$mm - 1];
            }
            $ly[] = array(
                'day' => 1,
                'month' => $leapMonth,
                'year' => $yy,
                'leap' => 1,
                'jd' => $currentJD,
            );

            $currentJD += $leapMonthLength;
            for ($mm = $leapMonth + 1; $mm <= 12; $mm++) {
                $ly[] = array(
                    'day' => 1,
                    'month' => $mm,
                    'year' => $yy,
                    'leap' => 0,
                    'jd' => $currentJD,
                );
                $currentJD += $regularMonths[$mm - 1];
            }
        }
        return $ly;
    }

    static function getYearInfo($yyyy)
    {
        if ($yyyy < 1900) {
            $yearCode = DataHelper::$TK19[$yyyy - 1800];
        } else if ($yyyy < 2000) {
            $yearCode = DataHelper::$TK20[$yyyy - 1900];
        } else if ($yyyy < 2100) {
            $yearCode = DataHelper::$TK21[$yyyy - 2000];
        } else {
            $yearCode = DataHelper::$TK22[$yyyy - 2100];
        }
        return self::decodeLunarYear($yyyy, $yearCode);
    }
    static $FIRST_DAY; // Tet am lich 1800
    static $LAST_DAY;

    static function findLunarDate($jd, $ly)
    {
        self::$FIRST_DAY = self::jdFromDate(25, 1, 1800);
        self::$LAST_DAY  = self::jdFromDate(31, 12, 2199);

        if ($jd > self::$LAST_DAY || $jd < self::$FIRST_DAY || $ly[0]['jd'] > $jd) {
            return array(
                'day' => 0,
                'month' => 0,
                'year' => 0,
                'leap' => 0,
                'jd' => $jd,
            );
        }
        $i = count($ly) - 1;
        while ($jd < $ly[$i]['jd']) {
            $i--;
        }
        $off = $jd - $ly[$i]['jd'];
        return array(
            'day' => $ly[$i]['day'] + $off,
            'month' => $ly[$i]['month'],
            'year' => $ly[$i]['year'],
            'leap' => $ly[$i]['leap'],
            'jd' => $jd,
        );
    }
    static function getMonth($mm, $yy)
    {
        if ($mm < 12) {
            $mm1 = $mm + 1;
            $yy1 = $yy;
        } else {
            $mm1 = 1;
            $yy1 = $yy + 1;
        }
        $jd1 = self::jdFromDate(1, $mm, $yy);
        $jd2 = self::jdFromDate(1, $mm1, $yy1);
        $ly1 = self::getYearInfo($yy);
        $tet1 = $ly1[0]['jd'];
        $result = array();
        if ($tet1 <= $jd1) {
            for ($i = $jd1; $i < $jd2; $i++) {
                $result[] = self::findLunarDate($i, $ly1);
            }
        } else if ($jd1 < $tet1 && $jd2 < $tet1) {
            $ly1 = self::getYearInfo($yy - 1);
            for ($i = $jd1; $i < $jd2; $i++) {
                $result[] = self::findLunarDate($i, $ly1);
            }
        } else if ($jd1 < $tet1 && $tet1 <= $jd2) {
            $ly2 = self::getYearInfo($yy - 1);
            for ($i = $jd1; $i < $tet1; $i++) {
                $result[] = self::findLunarDate($i, $ly2);
            }
            for ($i = $tet1; $i < $jd2; $i++) {
                $result[] = self::findLunarDate($i, $ly1);
            }
        }
        return $result;
    }

    static function printTable($mm, $yy, $show_canchi = true, $rturn_totxau = false, $rturn_al = false, $dd = 0)
    {
        $currentMonth = self::getMonth($mm, $yy);
        if (!$currentMonth) return '';

        // Lấy ngày đầu tiên của tháng hiện tại
        $ld1 = $currentMonth[0];
        $firstDayOfWeek = ($ld1['jd'] + 1) % 7; // 0 = Chủ nhật, 1 = Thứ 2, ...

        // Tính số ngày cần hiển thị từ tháng trước
        $daysFromPrevMonth = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;

        // Lấy thông tin tháng trước
        $prevMonth = $mm - 1;
        $prevYear = $yy;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear = $yy - 1;
        }

        // Lấy thông tin tháng sau
        $nextMonth = $mm + 1;
        $nextYear = $yy;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear = $yy + 1;
        }

        // Lấy dữ liệu tháng trước và tháng sau
        $prevMonthData = self::getMonth($prevMonth, $prevYear);
        $nextMonthData = self::getMonth($nextMonth, $nextYear);

        // Thêm can chi cho tất cả các ngày
        foreach ($currentMonth as &$item) {
            $item['canchi'] = self::canchiNgayByJD($item['jd']);
        }
        if ($prevMonthData) {
            foreach ($prevMonthData as &$item) {
                $item['canchi'] = self::canchiNgayByJD($item['jd']);
            }
        }
        if ($nextMonthData) {
            foreach ($nextMonthData as &$item) {
                $item['canchi'] = self::canchiNgayByJD($item['jd']);
            }
        }

        $res = "";
        $data_totxau = array();
        $selected_date = $dd ? getdate(strtotime($yy . '-' . $mm . '-' . $dd)) : '';
        $date_array = getdate();

        // Sự kiện trong tháng
        $events_duong = self::getVietnamEvent($mm, $yy);
        $events_am = self::getVietnamLunarEvent($mm, $yy);

        // Sự kiện tháng trước và sau (cho việc hiển thị)
        $events_duong_prev = self::getVietnamEvent($prevMonth, $prevYear);
        $events_am_prev = self::getVietnamLunarEvent($prevMonth, $prevYear);
        $events_duong_next = self::getVietnamEvent($nextMonth, $nextYear);
        $events_am_next = self::getVietnamLunarEvent($nextMonth, $nextYear);

        // Tính số hàng cần thiết để hiển thị đầy đủ tháng
        $currentMonthDays = count($currentMonth);
        $totalCellsNeeded = $daysFromPrevMonth + $currentMonthDays;
        $numRows = ceil($totalCellsNeeded / 7);

        // Tính tổng số ô sẽ hiển thị (bao gồm cả ngày tháng sau nếu cần)
        $totalCells = $numRows * 7;

        $cellIndex = 0;

        for ($i = 0; $i < $numRows; $i++) { // Hiển thị số hàng cần thiết
            $res .= ("<tr>");
            for ($j = 0; $j < 7; $j++) {
                if ($cellIndex < $daysFromPrevMonth) {
                    // Hiển thị ngày từ tháng trước
                    // if ($prevMonthData) {
                    //     $prevDayIndex = count($prevMonthData) - $daysFromPrevMonth + $cellIndex;
                    //     $prevDay = $prevMonthData[$prevDayIndex];
                    //     $solarDate = $prevDayIndex + 1;

                    //     if ($rturn_totxau) {
                    //         list($html, $totxau) = self::printCell($prevDay, $solarDate, $prevMonth, $prevYear, $show_canchi, $rturn_totxau, $date_array, $selected_date, $events_duong_prev, $events_am_prev, 'other-month');
                    //         $res .= $html;
                    //     } else {
                    //         $res .= self::printCell($prevDay, $solarDate, $prevMonth, $prevYear, $show_canchi, $rturn_totxau, $date_array, $selected_date, $events_duong_prev, $events_am_prev, 'other-month');
                    //     }
                    // } else {
                        $res .= '<td class="skip"></td>';
                    // }
                } elseif ($cellIndex < $daysFromPrevMonth + $currentMonthDays) {
                    // Hiển thị ngày của tháng hiện tại
                    $currentDayIndex = $cellIndex - $daysFromPrevMonth;
                    $solar = $currentDayIndex + 1;
                    $ld1 = $currentMonth[$currentDayIndex];

                    if ($rturn_totxau) {
                        list($html, $totxau) = self::printCell($ld1, $solar, $mm, $yy, $show_canchi, $rturn_totxau, $date_array, $selected_date, $events_duong, $events_am);
                        $res .= $html;
                        if ($totxau) $data_totxau[$totxau][] = array('yy' => $yy, 'mm' => $mm, 'dd' => $solar);
                    } else {
                        $res .= self::printCell($ld1, $solar, $mm, $yy, $show_canchi, $rturn_totxau, $date_array, $selected_date, $events_duong, $events_am);
                    }
                } else {
                    // Ẩn ngày từ tháng sau - chỉ hiển thị ô trống
                    $res .= '<td class="skip"></td>';
                }
                $cellIndex++;
            }
            $res .= ("</tr>");
        }

        if (!$rturn_al && !$rturn_totxau) return $res;
        $data = array($res);
        if ($rturn_totxau) $data[] = $data_totxau;
        if ($rturn_al) $data[] = $currentMonth;
        return $data;
    }

    static function checkTotXau($canChi, $thang)
    {
        $chi = explode(' ', $canChi);
        $chi = mb_strtolower(@$chi[1]);
        switch ($thang) {
            case 1:
            case 7:
                if (in_array($chi, array('tý', 'sửu', 'tỵ', 'mùi'))) return 'tot';
                elseif (in_array($chi, array('ngọ', 'mão', 'hợi', 'dậu'))) return 'xau';
                break;
            case 2:
            case 8:
                if (in_array($chi, array('dần', 'mão', 'mùi', 'dậu'))) return 'tot';
                elseif (in_array($chi, array('thân', 'tỵ', 'sửu', 'hợi'))) return 'xau';
                break;
            case 3:
            case 9:
                if (in_array($chi, array('thìn', 'tỵ', 'dậu', 'hợi'))) return 'tot';
                elseif (in_array($chi, array('tuất', 'mùi', 'sửu', 'ngọ'))) return 'xau';
                break;
            case 4:
            case 10:
                if (in_array($chi, array('ngọ', 'mùi', 'sửu', 'hợi'))) return 'tot';
                elseif (in_array($chi, array('tý', 'dậu', 'tỵ', 'mão'))) return 'xau';
                break;
            case 5:
            case 11:
                if (in_array($chi, array('thân', 'dậu', 'sửu', 'mão'))) return 'tot';
                elseif (in_array($chi, array('dần', 'hợi', 'mùi', 'tỵ'))) return 'xau';
                break;
            case 6:
            case 12:
                if (in_array($chi, array('tuất', 'hợi', 'mão', 'tỵ'))) return 'tot';
                elseif (in_array($chi, array('thìn', 'sửu', 'dậu', 'mùi'))) return 'xau';
                break;
        }
        return '';
    }
    static function getVietnamLunarEvent($mm, $yy)
    {
        // Các sự kiện cố định theo ngày âm
        return [
            '1-1' => '🌸 Tết Nguyên Đán',
            '1-2' => 'Mồng 2 Tết',
            '1-3' => 'Mồng 3 Tết',
            '1-10' => 'Vía Thần Tài',
            '1-15' => '🌕 Rằm tháng Giêng',
            '2-1' => 'Mồng 1 tháng Hai',
            '2-15' => 'Rằm tháng Hai',
          
            '3-1' => '🌸 Mồng 1 tháng Ba',
            '3-3' => 'Tết Hàn Thực',
            '3-10' => 'Giỗ tổ Hùng Vương',
            '3-15' => '🌕 Rằm tháng Ba',
            '4-1' => '🌸 Mồng 1 tháng Tư',
            '4-15' => '🌕 Rằm tháng Tư',
            '5-1' => '🌸 Mồng 1 tháng Năm',
            '5-5' => 'Tết Đoan Ngọ',
            '5-15' => '🌕 Rằm tháng Năm',
            '6-1' => '🌸 Mồng 1 tháng Sáu',
            '6-15' => '🌕 Rằm tháng Sáu',
          
            '7-1' => '🌸 Mồng 1 tháng Bảy',
            '7-7' => 'Thất Tịch',
            '7-15' => '🌕 Lễ Vu Lan',
            '7-30' => 'Ngày địa tạng',
            '8-15' => '🌕 Tết Trung Thu',
            '9-1' => '🌸 Mồng 1 tháng Chín',
            '9-9' => 'Tết Trùng Cửu',
            '9-15' => '🌕 Rằm tháng Chín',
           
            '10-1' => '🌸 Mồng 1 tháng Mười',
            '10-10' => 'Tết Thường Tân',
            '10-15' => '🌕 Tết Hạ Nguyên',
            '11-1' => '🌸 Mồng 1 tháng Mười một',
            '11-15' => '🌕 Rằm tháng Mười một',
            '11-23' => 'Ngày Thầy thuốc Việt Nam',
            '12-1' => '🌸 Mồng 1 tháng Chạp',
            '12-15' => '🌕 Rằm tháng Chạp',
            '12-23' => 'Ông Công Ông Táo',
            '12-29' => 'Tất niên (29 tháng Chạp)',
            '12-30' => 'Tất niên (30 tháng Chạp)',
        ];
    }

   static function printCell($lunarDate, $solarDate, $solarMonth, $solarYear, $show_canchi, $rturn_totxau, $date_array, $selected_date, $events = [], $events_am = [], $additionalClass = '')
{
    $dd = $date_array['mday'];
    $mm = $date_array['mon'];
    $yy = $date_array['year'];

    $selected_dd = $selected_date ? $selected_date['mday'] : 0;
    $selected_mm = $selected_date ? $selected_date['mon'] : 0;
    $selected_yy = $selected_date ? $selected_date['year'] : 0;

    $dow = ($lunarDate['jd'] + 1) % 7;
    $canChi = @$lunarDate['canchi'];
    $tot_xau = self::checkTotXau($canChi, $lunarDate['month']);
    $classCell = [];

    // Thêm class cho ngày của tháng khác
    if ($additionalClass) {
        $classCell[] = $additionalClass;
    }
    if ($lunarDate['month'] == 1 && $lunarDate['day'] <= 10) $classCell[] = 'tet';
    if ($solarYear == $yy && $solarMonth == $mm && $solarDate == $dd) $classCell[] = 'current';
    if ($solarYear == $selected_yy && $solarMonth == $selected_mm && $solarDate == $selected_dd) {
        $classCell[] = 'hovered';
        $classCell[] = 'viewing-day'; // Thêm class rõ ràng cho ngày đang xem
    }

    // ✅ Sự kiện ngày dương
    $event_text_duong = @$events[$solarDate];

    // ✅ Sự kiện ngày âm
    $am_key = $lunarDate['month'] . '-' . $lunarDate['day'];
    $event_text_am = @$events_am[$am_key];

    // ✅ Ưu tiên hiện cả 2 nếu có
    if ($event_text_duong && $event_text_am) {
        $event_text = $event_text_duong . ' - ' . $event_text_am;
    } elseif ($event_text_duong) {
        $event_text = $event_text_duong;
    } elseif ($event_text_am) {
        $event_text = $event_text_am;
    } else {
        $event_text = '';
    }
    
    // Thêm class has-event nếu có sự kiện
    if ($event_text) {
        $classCell[] = 'has-event';
    }
    
    // Thêm class cho ngày mồng 1 âm lịch
    if ($lunarDate['day'] == 1) {
        $classCell[] = 'lunar-first-day';
    }
    
    // Thêm class cho ngày rằm (15 âm lịch)
    if ($lunarDate['day'] == 15) {
        $classCell[] = 'lunar-full-moon';
    }

    $classCellHTML = $classCell ? ' class="' . implode(' ', $classCell) . '"' : '';

    // Phần ngày âm
    if ($lunarDate['day'] == 1) {
        $am_html = '<span style="color: #990000">' . $lunarDate['day'] . '/' . $lunarDate['month'] . ($lunarDate['leap'] ? ' <span class="nhuan-khong">(nhuận)</span>' : '') . '</span>';
    } elseif ($solarDate == 1) {
        $am_html = $lunarDate['day'] . '/' . $lunarDate['month'] . ($lunarDate['leap'] ? ' <span class="nhuan-khong">(nhuận)</span>' : '');
    } else {
        $am_html = $lunarDate['day'];
    }

    // ✅ Hiển thị sự kiện hoặc can chi ngày
    if ($event_text) {
        $can_chi_html = '<span class="hidden-xs" style="color:#8A1E31; font-weight:bold">' . $event_text . '</span>';
    } elseif ($lunarDate['day'] == 15) {
        $can_chi_html = '<span class="hidden-xs" style="color: #BE0000; font-weight: bold;">🌕 Ngày Rằm</span>';
    } else {
        // Luôn hiển thị can chi ngày khi không có sự kiện
        $can_chi_html = '<span class="hidden-xs">' . $canChi . '</span>';
    }

    $base = rtrim(config('app.url'), '/');
    $url = $base . "/lich-nam-$solarYear/thang-$solarMonth/ngay-$solarDate";

    $html = '<td' . $classCellHTML . '><a href="' . $url . '">
        <div class="box-contnet-date">
            <div class="duong-lich' . ($dow == 0 ? ' sun' : ($dow == 6 ? ' sat' : '')) . '">' . $solarDate . '</div>
            <div class="dao' . ($tot_xau ? ' ' . $tot_xau : '') . '">' . ($tot_xau ? '●' : '&nbsp;') . '</div>
        </div>
        <div class="am am_table">' . $am_html . '</div>
        <div class="can_chi_text" title="' . htmlspecialchars(strip_tags($can_chi_html)) . '">' . $can_chi_html . '</div>
    </a></td>';

    return $rturn_totxau ? array($html, $tot_xau) : $html;
}

    static function gioHDTrongNgayTXT($chi_ngay, $type = 'mini')
    {
        $chi_ngay = mb_strtolower($chi_ngay);
        $data_gio_hd = array();
        foreach (self::gioHoangDaoByNgay($chi_ngay) as $chi_gio) {
            if ($type == 'mini')
                $data_gio_hd[] = DataHelper::$khungGioMini[$chi_gio];
            else
                $data_gio_hd[] = DataHelper::$khungGio[$chi_gio];
        }

        return implode(', ', $data_gio_hd);
    }

    static function canchiNgayByJD($jd)
    {
        //Cho N là số ngày Julius của ngày dd/mm/yyyy. Ta chia N+9 cho 10. Số dư 0 là Giáp, 1 là Ất v.v. Để tìm Chi, chia N+1 cho 12; số dư 0 là Tý, 1 là Sửu v.v.
        return DataHelper::$hang_can[($jd + 9) % 10] . ' ' . DataHelper::$hang_chi[($jd + 1) % 12];
    }
    static function canchiNgay($yy, $mm, $dd)
    {
        $dl = self::convertLunar2Solar($dd, $mm, $yy, 0);
        $jd = self::jdFromDate($dl[0], $dl[1], $dl[2]);
        return DataHelper::$hang_can[($jd + 9) % 10] . ' ' . DataHelper::$hang_chi[($jd + 1) % 12];
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

    public static function getInt($param, $defaultValue = 0)
    {
        return isset($_GET[$param]) ? intval($_GET[$param]) : $defaultValue;
    }
    public static function getString($param, $defaultValue = "")
    {
        return isset($_GET[$param]) ? self::cleanQuery($_GET[$param]) : $defaultValue;
    }
    public static function getIntPOST($param, $defaultValue = 0)
    {
        return isset($_POST[$param]) ? intval($_POST[$param]) : $defaultValue;
    }
    public static function getStringPOST($param, $defaultValue = "")
    {
        return isset($_POST[$param]) ? self::cleanQuery($_POST[$param]) : $defaultValue;
    }
    static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if (strpos($ip, ',') !== false) {
            $ip = explode(',', $ip);
            $ip = @$ip[0];
        }
        return $ip;
    }
    static function change($text)
    {
        $chars = array("a", "A", "e", "E", "o", "O", "u", "U", "i", "I", "d", "D", "y", "Y");
        $uni[0] = array("á", "à", "ạ", "ả", "ã", "â", "ấ", "ầ", "ậ", "ẩ", "ẫ", "ă", "ắ", "ằ", "ặ", "ẵ", "ẳ", "� �");
        $uni[1] = array("Á", "À", "Ạ", "Ả", "Ã", "Â", "Ấ", "Ầ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ắ", "Ằ", "Ặ", "Ẵ", "Ẳ", "� �");
        $uni[2] = array("é", "è", "ẹ", "ẻ", "ẽ", "ê", "ế", "ề", "ệ", "ể", "ễ");
        $uni[3] = array("É", "È", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ế", "Ề", "Ệ", "Ể", "Ễ");
        $uni[4] = array("ó", "ò", "ọ", "ỏ", "õ", "ô", "ố", "ồ", "ộ", "ổ", "ỗ", "ơ", "ớ", "ờ", "ợ", "ỡ", "ở", "� �");
        $uni[5] = array("Ó", "Ò", "Ọ", "Ỏ", "Õ", "Ô", "Ố", "Ồ", "Ộ", "Ổ", "Ỗ", "Ơ", "Ớ", "Ờ", "Ợ", "Ỡ", "Ở", "� �");
        $uni[6] = array("ú", "ù", "ụ", "ủ", "ũ", "ư", "ứ", "ừ", "ự", "ử", "ữ");
        $uni[7] = array("Ú", "Ù", "Ụ", "Ủ", "Ũ", "Ư", "Ứ", "Ừ", "Ự", "Ử", "Ữ");
        $uni[8] = array("í", "ì", "ị", "ỉ", "ĩ");
        $uni[9] = array("Í", "Ì", "Ị", "Ỉ", "Ĩ");
        $uni[10] = array("đ");
        $uni[11] = array("Đ");
        $uni[12] = array("ý", "ỳ", "ỵ", "ỷ", "ỹ");
        $uni[13] = array("Ý", "Ỳ", "Ỵ", "Ỷ", "Ỹ");

        for ($i = 0; $i <= 13; $i++) {
            $text = str_replace($uni[$i], $chars[$i], $text);
        }
        return $text;
    }
    static function generate_slug($string)
    {
        $string = self::change($string);
        $string = preg_replace("/(^|&\S+;)|(<[^>]*>)/U", "", $string);
        $string = strtolower(preg_replace('/[\s\-]+/', '-', trim(preg_replace('/[^\w\s\-]/', '', $string))));
        $slug = preg_replace("/[^A-Za-z0-9\-]/", "", $string);
        return $slug;
    }
    public static function removeSign($str)
    {
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", "ê", "ù", "à");

        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "e", "u", "a");
        return str_replace($coDau, $khongDau, $str);
    }
    static function cleanQuery($string)
    {
        if (empty($string)) return $string;
        $string = trim($string);

        $badWords = array(
            "/Select(.*)From/i",
            "/Union(.*)Select/i",
            "/Update(.*)Set/i",
            "/Delete(.*)From/i",
            "/Drop(.*)Table/i",
            "/Insert(.*)Into/i"
        );

        $string = preg_replace($badWords, "", $string);
        return $string;
    }

    static function jdFromDate($dd, $mm, $yy)
    {
        // Xác định xem tháng có nhỏ hơn hoặc bằng 2 hay không.
        // Nếu tháng <= 2, thì dịch tháng về cuối năm trước (tháng 13, 14)
        // Điều này giúp việc tính toán chính xác hơn khi xử lý ngày trong năm nhuận.
        $a = floor((14 - $mm) / 12);

        // Điều chỉnh năm theo cách tính của lịch Julian & Gregorian.
        // Nếu tháng < 3, thì coi như thuộc về năm trước.
        $y = $yy + 4800 - $a;

        // Điều chỉnh tháng (chuyển tháng 1 & 2 thành tháng 13 & 14 của năm trước)
        $m = $mm + 12 * $a - 3;

        // Công thức tính số ngày Julian (JD) dựa trên lịch Gregory
        $jd = $dd
            + floor((153 * $m + 2) / 5)  // Tính số ngày đã trôi qua trong năm dựa trên số tháng
            + 365 * $y                   // Cộng số ngày của tất cả các năm đã qua
            + floor($y / 4)              // Thêm ngày nhuận (cứ 4 năm thêm 1 ngày)
            - floor($y / 100)            // Trừ đi năm không nhuận (cứ 100 năm không nhuận 1 lần)
            + floor($y / 400)            // Cộng lại những năm nhuận bị loại trừ ở bước trên (cứ 400 năm có 1 năm nhuận)
            - 32045;                     // Điều chỉnh để phù hợp với hệ Julian Date

        // Nếu ngày cần tính là trước 15/10/1582 (trước khi lịch Gregory được áp dụng)
        // thì sử dụng công thức Julian cũ (không có điều chỉnh năm nhuận đặc biệt)
        if ($jd < 2299161) {
            $jd = $dd
                + floor((153 * $m + 2) / 5)
                + 365 * $y
                + floor($y / 4)  // Chỉ áp dụng quy tắc năm nhuận Julian (cứ 4 năm là năm nhuận)
                - 32083;         // Điều chỉnh cho hệ thống Julian Date cũ
        }

        return $jd;  // Trả về kết quả là Julian Day tương ứng với ngày đã nhập
    }


    static function jdToDate($jd)
    {
        if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
            $a = $jd + 32044;
            $b = floor((4 * $a + 3) / 146097);
            $c = $a - floor(($b * 146097) / 4);
        } else {
            $b = 0;
            $c = $jd + 32082;
        }
        $d = floor((4 * $c + 3) / 1461);
        $e = $c - floor((1461 * $d) / 4);
        $m = floor((5 * $e + 2) / 153);
        $day = $e - floor((153 * $m + 2) / 5) + 1;
        $month = $m + 3 - 12 * floor($m / 10);
        $year = $b * 100 + $d - 4800 + floor($m / 10);
        //echo "day = $day, month = $month, year = $year\n";
        return array($day, $month, $year);
    }

    static function getNewMoonDay($k, $timeZone = 7.0)
    {
        $T = $k / 1236.85; // Time in Julian centuries from 1900 January 0.5
        $T2 = $T * $T;
        $T3 = $T2 * $T;
        $dr = M_PI / 180;
        $Jd1 = 2415020.75933 + 29.53058868 * $k + 0.0001178 * $T2 - 0.000000155 * $T3;
        $Jd1 = $Jd1 + 0.00033 * sin((166.56 + 132.87 * $T - 0.009173 * $T2) * $dr); // Mean new moon
        $M = 359.2242 + 29.10535608 * $k - 0.0000333 * $T2 - 0.00000347 * $T3; // Sun's mean anomaly
        $Mpr = 306.0253 + 385.81691806 * $k + 0.0107306 * $T2 + 0.00001236 * $T3; // Moon's mean anomaly
        $F = 21.2964 + 390.67050646 * $k - 0.0016528 * $T2 - 0.00000239 * $T3; // Moon's argument of latitude
        $C1 = (0.1734 - 0.000393 * $T) * sin($M * $dr) + 0.0021 * sin(2 * $dr * $M);
        $C1 = $C1 - 0.4068 * sin($Mpr * $dr) + 0.0161 * sin($dr * 2 * $Mpr);
        $C1 = $C1 - 0.0004 * sin($dr * 3 * $Mpr);
        $C1 = $C1 + 0.0104 * sin($dr * 2 * $F) - 0.0051 * sin($dr * ($M + $Mpr));
        $C1 = $C1 - 0.0074 * sin($dr * ($M - $Mpr)) + 0.0004 * sin($dr * (2 * $F + $M));
        $C1 = $C1 - 0.0004 * sin($dr * (2 * $F - $M)) - 0.0006 * sin($dr * (2 * $F + $Mpr));
        $C1 = $C1 + 0.0010 * sin($dr * (2 * $F - $Mpr)) + 0.0005 * sin($dr * (2 * $Mpr + $M));
        if ($T < -11) {
            $deltat = 0.001 + 0.000839 * $T + 0.0002261 * $T2 - 0.00000845 * $T3 - 0.000000081 * $T * $T3;
        } else {
            $deltat = -0.000278 + 0.000265 * $T + 0.000262 * $T2;
        };
        $JdNew = $Jd1 + $C1 - $deltat;
        //echo "JdNew = $JdNew\n";
        return floor($JdNew + 0.5 + $timeZone / 24);
    }

    static function getSunLongitude($jdn, $timeZone = 7.0)
    {
        $T = ($jdn - 2451545.5 - $timeZone / 24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
        $T2 = $T * $T;
        $dr = M_PI / 180; // degree to radian
        $M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2; // mean anomaly, degree
        $L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2; // mean longitude, degree
        $DL = (1.914600 - 0.004817 * $T - 0.000014 * $T2) * sin($dr * $M);
        $DL = $DL + (0.019993 - 0.000101 * $T) * sin($dr * 2 * $M) + 0.000290 * sin($dr * 3 * $M);
        $L = $L0 + $DL; // true longitude, degree
        //echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
        // obtain apparent longitude by correcting for nutation and aberration
        $omega = 125.04 - 1934.136 * $T;
        $L = $L - 0.00569 - 0.00478 * sin($omega * $dr);
        $L = $L * $dr;
        $L = $L - M_PI * 2 * (floor($L / (M_PI * 2))); // Normalize to (0, 2*PI)
        return floor($L / M_PI * 6);
    }

    static function SunLongitude($jdn)
    {
        $T = ($jdn - 2451545.0) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
        $T2 = $T * $T;
        $dr = M_PI / 180; // degree to radian
        $M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2; // mean anomaly, degree
        $L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2; // mean longitude, degree
        $DL = (1.914600 - 0.004817 * $T - 0.000014 * $T2) * sin($dr * $M);
        $DL = $DL + (0.019993 - 0.000101 * $T) * sin($dr * 2 * $M) + 0.000290 * sin($dr * 3 * $M);
        $L = $L0 + $DL; // true longitude, degree
        $L = $L * $dr;
        $L = $L - M_PI * 2 * (floor($L / (M_PI * 2))); // Normalize to (0, 2*M_PI)
        return $L;
    }

    static function getSunLongitudeKinh($dayNumber, $timeZone = 7.0)
    {
        return floor(self::SunLongitude($dayNumber - 0.5 - $timeZone / 24.0) / M_PI * 12);
    }

    static function getLunarMonth11($yy, $timeZone = 7.0)
    {
        $off = self::jdFromDate(31, 12, $yy) - 2415021;
        $k = floor($off / 29.530588853);
        $nm = self::getNewMoonDay($k, $timeZone);
        $sunLong = self::getSunLongitude($nm, $timeZone); // sun longitude at local midnight
        if ($sunLong >= 9) {
            $nm = self::getNewMoonDay($k - 1, $timeZone);
        }
        return $nm;
    }

    static function getLeapMonthOffset($a11, $timeZone = 7.0)
    {
        $k = floor(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
        $last = 0;
        $i = 1; // We start with the month following lunar month 11
        $arc = self::getSunLongitude(self::getNewMoonDay($k + $i, $timeZone), $timeZone);
        do {
            $last = $arc;
            $i = $i + 1;
            $arc = self::getSunLongitude(self::getNewMoonDay($k + $i, $timeZone), $timeZone);
        } while ($arc != $last && $i < 14);
        return $i - 1;
    }
static function convertSolar2Lunar($dd, $mm, $yy, $timeZone = 7.0)
{
    // --- Phần đầu của hàm giữ nguyên, nó tính toán ngày/tháng/năm Âm lịch chính xác ---
    $dayNumber = self::jdFromDate($dd, $mm, $yy);
    $k = floor(($dayNumber - 2415021.076998695) / 29.530588853);
    $monthStart = self::getNewMoonDay($k + 1, $timeZone);
    if ($monthStart > $dayNumber) {
        $monthStart = self::getNewMoonDay($k, $timeZone);
    }
    $a11 = self::getLunarMonth11($yy, $timeZone);
    $b11 = $a11;
    if ($a11 >= $monthStart) {
        $lunarYear = $yy;
        $a11 = self::getLunarMonth11($yy - 1, $timeZone);
    } else {
        $lunarYear = $yy + 1;
        $b11 = self::getLunarMonth11($yy + 1, $timeZone);
    }
    $lunarDay = $dayNumber - $monthStart + 1;
    $diff = floor(($monthStart - $a11) / 29);
    $lunarLeap = 0;
    $lunarMonth = $diff + 11;
    if ($b11 - $a11 > 365) {
        $leapMonthDiff = self::getLeapMonthOffset($a11, $timeZone);
        if ($diff >= $leapMonthDiff) {
            $lunarMonth = $diff + 10;
            if ($diff == $leapMonthDiff) {
                $lunarLeap = 1;
            }
        }
    }
    if ($lunarMonth > 12) {
        $lunarMonth = $lunarMonth - 12;
    }
    if ($lunarMonth >= 11 && $diff < 4) {
        $lunarYear -= 1;
    }
    
    // =========================================================================
    // BẮT ĐẦU PHẦN SỬA LỖI TÍNH THÁNG ĐỦ/THIẾU
    // =========================================================================

    // Thay vì dùng $k+1, chúng ta sẽ tìm ngày Sóc của tháng kế tiếp một cách chính xác
    // dựa trên tháng/năm Âm lịch mà chúng ta vừa tính được.
    
    $isLeap = ($b11 - $a11 > 365);
    $leapMonthOffset = $isLeap ? self::getLeapMonthOffset($a11, $timeZone) : 0;
    
    // Tính toán 'diff' của tháng kế tiếp
    $nextDiff = $diff + 1;

    // Điều chỉnh nextDiff cho các trường hợp tháng nhuận
    if ($isLeap) {
        // Nếu tháng hiện tại đang TRƯỚC tháng nhuận (diff < leapMonthOffset)
        // và tháng kế tiếp là tháng nhuận: không cần tăng nextDiff
        if ($diff + 1 == $leapMonthOffset && $lunarLeap == 0) {
            // Tháng hiện tại là tháng chính trước tháng nhuận
            // Tháng kế tiếp sẽ là tháng nhuận (có cùng số tháng với tháng hiện tại)
            // Do đó nextDiff vẫn giữ nguyên = diff + 1
        }
        // Nếu tháng hiện tại LÀ tháng nhuận
        else if ($diff == $leapMonthOffset && $lunarLeap == 1) {
            // Tháng kế tiếp là tháng chính sau tháng nhuận
            // Cần tăng nextDiff thêm 1 để bỏ qua tháng nhuận
            $nextDiff = $diff + 1;
        }
        // Nếu tháng hiện tại đã qua tháng nhuận
        else if ($diff >= $leapMonthOffset) {
            // Cần điều chỉnh nextDiff
            $nextDiff = $diff + 1;
        }
    }

    // Tính toán ngày Sóc của tháng sau dựa trên `nextDiff` đã điều chỉnh
    $nextMonth_k_estimate = floor(($a11 - 2415021.076998695) / 29.530588853 + 0.5) + $nextDiff;
    $nextMonthStart = self::getNewMoonDay($nextMonth_k_estimate, $timeZone);

    // Đôi khi ước lượng bị lệch 1 chu kỳ, cần kiểm tra và điều chỉnh
    if($nextMonthStart <= $monthStart) {
        $nextMonthStart = self::getNewMoonDay($nextMonth_k_estimate + 1, $timeZone);
    }
    if($nextMonthStart <= $monthStart) { // Kiểm tra lại một lần nữa
         $nextMonthStart = self::getNewMoonDay($nextMonth_k_estimate + 2, $timeZone);
    }
    
    $monthLength = $nextMonthStart - $monthStart;
    
    // Một tháng âm lịch chỉ có thể có 29 hoặc 30 ngày.
    // Nếu kết quả khác, có thể do lỗi tính toán ngày sóc.
    // Ta làm tròn kết quả để đảm bảo an toàn.
    if ($monthLength > 29.5) {
        $isFullMonth = 'Đủ'; // 30 ngày
    } else {
        $isFullMonth = 'Thiếu'; // 29 ngày
    }

    // =========================================================================
    // KẾT THÚC PHẦN SỬA LỖI
    // =========================================================================
    
    return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $isFullMonth);
}
    // static function convertSolar2Lunar($dd, $mm, $yy, $timeZone = 7.0)
    // {
    //     $dayNumber = self::jdFromDate($dd, $mm, $yy);
    //     $k = floor(($dayNumber - 2415021.076998695) / 29.530588853);
    //     $monthStart = self::getNewMoonDay($k + 1, $timeZone);
    //     if ($monthStart > $dayNumber) {
    //         $monthStart = self::getNewMoonDay($k, $timeZone);
    //     }
    //     $a11 = self::getLunarMonth11($yy, $timeZone);
    //     $b11 = $a11;
    //     if ($a11 >= $monthStart) {
    //         $lunarYear = $yy;
    //         $a11 = self::getLunarMonth11($yy - 1, $timeZone);
    //     } else {
    //         $lunarYear = $yy + 1;
    //         $b11 = self::getLunarMonth11($yy + 1, $timeZone);
    //     }
    //     $lunarDay = $dayNumber - $monthStart + 1;
    //     $diff = floor(($monthStart - $a11) / 29);
    //     $lunarLeap = 0;
    //     $lunarMonth = $diff + 11;
    //     if ($b11 - $a11 > 365) {
    //         $leapMonthDiff = self::getLeapMonthOffset($a11, $timeZone);
    //         if ($diff >= $leapMonthDiff) {
    //             $lunarMonth = $diff + 10;
    //             if ($diff == $leapMonthDiff) {
    //                 $lunarLeap = 1;
    //             }
    //         }
    //     }
    //     if ($lunarMonth > 12) {
    //         $lunarMonth = $lunarMonth - 12;
    //     }
    //     if ($lunarMonth >= 11 && $diff < 4) {
    //         $lunarYear -= 1;
    //     }
    //     $nextMonthStart = self::getNewMoonDay($k + 1, $timeZone);
    //     $monthLength = $nextMonthStart - $monthStart;
    //     $isFullMonth = $monthLength == 30 ? 'Đủ' : 'Thiếu';
    //     return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $isFullMonth);
    // }

    static function convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $timeZone = 7.0)
    {
        if ($lunarMonth < 11) {
            $a11 = self::getLunarMonth11($lunarYear - 1, $timeZone);
            $b11 = self::getLunarMonth11($lunarYear, $timeZone);
        } else {
            $a11 = self::getLunarMonth11($lunarYear, $timeZone);
            $b11 = self::getLunarMonth11($lunarYear + 1, $timeZone);
        }
        $k = floor(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
        $off = $lunarMonth - 11;
        if ($off < 0) {
            $off += 12;
        }
        if ($b11 - $a11 > 365) {
            $leapOff = self::getLeapMonthOffset($a11, $timeZone);
            $leapMonth = $leapOff - 2;
            if ($leapMonth < 0) {
                $leapMonth += 12;
            }
            if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
                return array(0, 0, 0);
            } else if ($lunarLeap != 0 || $off >= $leapOff) {
                $off += 1;
            }
        }
        $monthStart = self::getNewMoonDay($k + $off, $timeZone);
        return self::jdToDate($monthStart + $lunarDay - 1);
    }

    static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini === false) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    static function getVietnamEvent($mm, $yy)
    {
        // Danh sách các sự kiện Dương lịch cố định theo định dạng 'mm-dd'
        $events = [
            // THÁNG 1
            '1-1' => 'Tết Dương Lịch',

            // THÁNG 2
            '2-3' => 'Ngày thành lập Đảng Cộng sản Việt Nam',
            '2-14' => 'Lễ tình nhân (Valentine)',
            '2-27' => 'Ngày Thầy thuốc Việt Nam',

            // THÁNG 3
            '3-8' => 'Ngày Quốc tế Phụ nữ',
            '3-10' => 'Ngày thành lập Hội Liên hiệp Phụ nữ Việt Nam',
            '3-20' => 'Ngày Quốc tế Hạnh phúc',
            '3-24' => 'Ngày Thế giới chống lao',
            '3-26' => 'Ngày thành lập Đoàn TNCS Hồ Chí Minh',

            // THÁNG 4
            '4-1' => 'Ngày Cá tháng Tư',
            '4-22' => 'Ngày Trái Đất',
            '4-30' => 'Ngày giải phóng miền Nam',

            // THÁNG 5
            '5-1' => 'Ngày Quốc tế Lao động',
            '5-7' => 'Ngày chiến thắng Điện Biên Phủ',
            // '5-8' => 'Ngày chiến thắng phát xít',
            '5-19' => 'Ngày sinh Chủ tịch Hồ Chí Minh',

            // THÁNG 6
            '6-1' => 'Ngày Quốc tế Thiếu nhi',
            '6-5' => 'Ngày Môi trường Thế giới',
            '6-21' => 'Ngày Báo chí cách mạng Việt Nam',
            '6-28' => 'Ngày Gia đình Việt Nam',
            '6-17' => 'Ngày của Cha',

            // THÁNG 7
            '7-2' => 'Thành lập nước Cộng hoà XHCN Việt Nam',
            '7-11' => 'Ngày Dân số Thế giới',
            '7-27' => 'Ngày Thương binh Liệt sĩ',
            '7-28' => 'Ngày thành lập Công đoàn Việt Nam',

            // THÁNG 8
            '8-10' => 'Ngày vì Nạn nhân Chất độc Da cam',
            '8-15' => 'Ngày Độc lập',
            '8-19' => 'Ngày Tổng Khởi nghĩa',

            // THÁNG 9
            '9-2' => 'Ngày Quốc khánh',
            '9-10' => 'Ngày thành lập Mặt trận Tổ quốc Việt Nam',
            '9-15' => 'Ngày Trẻ em Việt Nam',

            // THÁNG 10
            '10-1' => 'Ngày Quốc tế Người cao tuổi',
            '10-10' => 'Ngày Giải phóng Thủ đô',
            '10-13' => 'Ngày Doanh nhân Việt Nam',
            '10-15' => 'Ngày truyền thống Hội LHTN Việt Nam',
            '10-20' => 'Ngày Phụ nữ Việt Nam',
            '10-31' => '🎃 Ngày Halloween',

            // THÁNG 11
            '11-9' => 'Ngày Pháp luật Việt Nam',
            '11-17' => 'Ngày truyền thống Mặt trận Tổ quốc Việt Nam',
            '11-20' => 'Ngày Nhà giáo Việt Nam',
            '11-23' => 'Ngày thành lập Hội Chữ thập đỏ Việt Nam',

            // THÁNG 12
            '12-1' => 'Ngày Thế giới phòng chống AIDS',
            '12-19' => 'Ngày Toàn quốc kháng chiến',
            '12-22' => 'Ngày thành lập Quân đội Nhân dân Việt Nam',
            '12-24' => 'Đêm Giáng sinh',
            '12-25' => 'Lễ Giáng sinh',
        ];

        $result = [];
        foreach ($events as $key => $title) {
            list($em, $ed) = explode('-', $key);
            if ((int)$em == (int)$mm) {
                $result[(int)$ed] = $title;
            }
        }
        return $result;
    }
    static function jdFromLunarDate($lunarDay, $lunarMonth, $lunarYear, $lunarLeap)
    {
        $a11 = self::getLunarMonth11($lunarYear);
        $b11 = self::getLunarMonth11($lunarYear + 1);

        $off = $lunarMonth - 11;
        if ($off < 0) {
            $b11 = $a11;
            $a11 = self::getLunarMonth11($lunarYear - 1);
            $off = $lunarMonth + 12 - 11;
        }

        if ($lunarLeap != 0) {
            $leapMonth = self::getLeapMonthOffset($a11);
            if ($leapMonth != $lunarMonth) {
                // Không đúng tháng nhuận
                return 0;
            }
            $off++;
        }

        $k = self::getNewMoonIndex($a11);
        $monthStart = self::getNewMoonDay($k + $off);

        return $monthStart + $lunarDay - 1;
    }
    static function getNewMoonIndex($jd)
    {
        // Mốc thời gian là ngày Sóc (new moon) gần ngày 1/1/1900
        $T0 = 2415021.076998695;
        $synodicMonth = 29.530588853; // Độ dài trung bình của 1 chu kỳ trăng (synodic month)

        // Tính chỉ số sóc gần ngày $jd nhất
        return floor(($jd - $T0) / $synodicMonth);
    }

    static function printAllDuongLichEvents($year)
    {
        $allEvents = [];
        for ($month = 1; $month <= 12; $month++) {
            $events = self::getVietnamEvent($month, $year);
            foreach ($events as $day => $title) {
                $formatted = str_pad($day, 2, '0', STR_PAD_LEFT) . '/' . str_pad($month, 2, '0', STR_PAD_LEFT);
                $allEvents[$formatted] = $title;
            }
        }

        // Sắp xếp key dạng dd/mm theo tháng rồi ngày
        uksort($allEvents, function ($a, $b) {
            list($dayA, $monthA) = explode('/', $a);
            list($dayB, $monthB) = explode('/', $b);

            if ($monthA == $monthB) {
                return (int)$dayA - (int)$dayB;
            }
            return (int)$monthA - (int)$monthB;
        });

        $html = '<div class="row">';
        foreach ($allEvents as $date => $title) {
            $html .= "
           <div class='col-12'> <div class='btn custom-pill-btn-date w-100 text-start'>
            <img src='/icons/sukienn1.svg' alt='Sự kiện' width='28' height='29'
                                class='img-fluid me-2'> $date: $title
            </div> </div>
            ";
        }
        $html .= '</div>';
        return $html;
    }

    static function printAllAmLichEvents()
    {
        $events = self::getVietnamLunarEvent(null, null);

        // Sắp xếp theo tháng rồi ngày
        uksort($events, function ($a, $b) {
            list($monthA, $dayA) = explode('-', $a);
            list($monthB, $dayB) = explode('-', $b);

            if ((int)$monthA === (int)$monthB) {
                return (int)$dayA - (int)$dayB;
            }
            return (int)$monthA - (int)$monthB;
        });

        $html = '<div class="row">';
        foreach ($events as $md => $title) {
            list($mm, $dd) = explode('-', $md);
            $dateDisplay = $dd . '/' . $mm; // in ra dd/mm âm lịch
            $html .= "
             <div class='col-12'> <div class='btn custom-pill-btn-date w-100 text-start'>
            <img src='/icons/sukienn1.svg' alt='Sự kiện'  width='28' height='29'
                                class='img-fluid me-2'> $dateDisplay (Âm lịch): $title
            </div> </div>";
        }
        $html .= '</div>';

        return $html;
    }
   /**
     * Lấy Giờ Hoàng Đạo dựa trên loại (tất cả, ngày, đêm).
     * Hàm này được thiết kế để hoạt động với đầu ra là CHUỖI từ hàm gioHDTrongNgayTXT.
     *
     * @param string $dayChi Địa chi của ngày
     * @param string $type Loại giờ muốn lấy: 'all', 'day', hoặc 'night'
     * @return array
     */
     public static function getGoodHours(string $dayChi, string $type = 'day'): array
    {
        // 1. Lấy chuỗi giờ tốt từ hàm gốc của bạn
        $hoursString = self::gioHDTrongNgayTXT($dayChi);

        // 2. KIỂM TRA và CHUYỂN ĐỔI chuỗi thành mảng
        // Nếu chuỗi rỗng hoặc không phải là chuỗi, trả về mảng rỗng
        if (empty($hoursString) || !is_string($hoursString)) {
            return [];
        }
        // Tách chuỗi thành mảng, delimiter là ", " (dấu phẩy và dấu cách)
        $allHoursArray = explode(', ', $hoursString);


        // 3. LỌC MẢNG (logic này giữ nguyên như trước)
        // Nếu không cần lọc, trả về tất cả
        if ($type === 'all') {
            return $allHoursArray;
        }

        $filteredHours = array_filter($allHoursArray, function ($hourString) use ($type) {
            preg_match('/\((\d{1,2})/', $hourString, $matches);

            if (isset($matches[1])) {
                $startHour = (int)$matches[1];
                // Ban ngày là từ 6h đến < 18h
                $isDaytime = ($startHour >= 6 && $startHour < 18);

                if ($type === 'day') {
                    return $isDaytime;
                }
                if ($type === 'night') {
                    return !$isDaytime;
                }
            }
            return false;
        });
        
        // Sắp xếp lại chỉ số mảng
        return array_values($filteredHours);
    }




     /**
     * Lấy danh sách các sự kiện/ngày lễ lớn của Việt Nam theo LỊCH ÂM.
     * Trả về một mảng các sự kiện cho tháng âm lịch được chỉ định.
     *
     * @param int $lunarMonth Tháng âm lịch (1-12)
     * @param int $lunarYear Năm âm lịch
     * @return array Mảng sự kiện, key là ngày âm, value là thông tin sự kiện
     */
    static function getVietnamLunarEvent2($lunarMonth, $lunarYear)
    {
        // Danh sách các sự kiện Âm lịch cố định trong năm
        $events = [
            // key là "ngày-tháng" âm lịch

            // THÁNG GIÊNG (Tháng 1)
            '1-1'   => ['ten_su_kien' => '🌸 Mồng 1 Tết Nguyên Đán', 'loai_su_kien' => 'le_lon', 'mo_ta' => 'Ngày đầu tiên của năm mới âm lịch, ngày lễ quan trọng nhất của Việt Nam.'],
            '2-1'   => ['ten_su_kien' => 'Mồng 2 Tết Nguyên Đán', 'loai_su_kien' => 'le_lon', 'mo_ta' => 'Ngày thứ hai của Tết, thường dành để thăm hỏi bạn bè, họ hàng.'],
            '3-1'   => ['ten_su_kien' => 'Mồng 3 Tết Nguyên Đán', 'loai_su_kien' => 'le_lon', 'mo_ta' => 'Ngày cuối cùng trong kỳ nghỉ Tết chính thức, hóa vàng và tiễn tổ tiên.'],
            '4-1'   => ['ten_su_kien' => 'Mồng 4 Tết - Ngày Mở Hàng', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày mở lại hoạt động kinh doanh sau kỳ nghỉ Tết.'],
            // '7-1'   => ['ten_su_kien' => 'Ngày Nhân Thắng', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày của con người, theo quan niệm cổ truyền.'],
            '9-1'   => ['ten_su_kien' => 'Ngày Ngọc Hoàng', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Ngọc Hoàng Thượng Đế.'],
            '15-1'  => ['ten_su_kien' => '🌕 Tết Nguyên tiêu (Rằm tháng Giêng)', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đêm rằm đầu tiên của năm mới, còn được gọi là Lễ Thượng Nguyên.'],

            // THÁNG HAI (Tháng 2)
                '1-2'   => ['ten_su_kien' => '🌸 Mồng 2 tháng Hai', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng Hai âm lịch.'],
            '15-2'  => ['ten_su_kien' => '🌕 Rằm tháng Hai', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng tổ tiên và thần linh.'],

            // THÁNG BA (Tháng 3)
            '1-3'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Ba', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng ba âm lịch, ngày cúng tổ tiên.'],
            '3-3'   => ['ten_su_kien' => 'Tết Hàn thực', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Người Việt thường làm bánh trôi, bánh chay để dâng lên tổ tiên.'],
            '10-3'  => ['ten_su_kien' => 'Giỗ Tổ Hùng Vương', 'loai_su_kien' => 'le_lon', 'mo_ta' => 'Tưởng nhớ công lao dựng nước của các Vua Hùng. Là ngày nghỉ lễ toàn quốc.'],
            '15-3'  => ['ten_su_kien' => '🌕 Rằm tháng Ba', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Quan Âm Bồ Tát.'],
            '23-3'  => ['ten_su_kien' => 'Lễ Thanh minh', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày tảo mộ, dọn dẹp mồ mả tổ tiên.'],

            // THÁNG TƯ (Tháng 4)
            '1-4'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Tư', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng tư âm lịch, ngày cúng tổ tiên.'],
            // '8-4'   => ['ten_su_kien' => 'Lễ Phật Đản (Phật Thích Ca)', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày sinh của Đức Phật Thích Ca (theo một số địa phương).'],
            '15-4'  => ['ten_su_kien' => '🌕 Lễ Phật Đản', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Kỷ niệm ngày sinh của Đức Phật Thích Ca Mâu Ni.'],

            // THÁNG NĂM (Tháng 5)
            '1-5'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Năm', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng năm âm lịch, ngày cúng tổ tiên.'],
            '5-5'   => ['ten_su_kien' => 'Tết Đoan ngọ', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Còn gọi là Tết diệt sâu bọ, diễn ra vào giữa năm.'],
            '13-5'  => ['ten_su_kien' => 'Lễ Đức Ông', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày lễ thần Nông, thần của nông nghiệp.'],
            '15-5'  => ['ten_su_kien' => '🌕 Rằm tháng Năm', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Phật và tổ tiên.'],

            // THÁNG SÁU (Tháng 6)
            '1-6'   => ['ten_su_kien' => '🌸 Lễ Đức Thánh Trần', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày giỗ Đức Thánh Trần Hưng Đạo.'],
            '15-6'  => ['ten_su_kien' => '🌕 Rằm tháng Sáu', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Quan Âm và tổ tiên.'],

            // THÁNG BẢY (Tháng 7)
            '1-7'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Bảy', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng bảy âm lịch - Tháng cô hồn, ngày cúng tổ tiên.'],
            '7-7'   => ['ten_su_kien' => 'Lễ Thất Tịch', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày Ngưu Lang Chức Nữ gặp nhau, lễ tình yêu của người Việt.'],
            '15-7'  => ['ten_su_kien' => '🌕 Lễ Vu Lan', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày lễ báo hiếu cha mẹ, một trong những ngày lễ chính của Phật giáo.'],
            '30-7'  => ['ten_su_kien' => 'Ngày Địa Tạng', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Địa Tạng Bồ Tát.'],

            // THÁNG TÁM (Tháng 8)
            '1-8'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Tám', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng tám âm lịch, ngày cúng tổ tiên.'],
            '15-8'  => ['ten_su_kien' => '🌕 Tết Trung thu', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Còn gọi là Tết trông Trăng hay Tết Đoàn viên, dành cho thiếu nhi.'],

            // THÁNG CHÍN (Tháng 9)
            '1-9'   => ['ten_su_kien' => '🌸 Mồng 1 tháng Chín', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng chín âm lịch, ngày cúng tổ tiên.'],
            '9-9'   => ['ten_su_kien' => 'Tết Trùng Cửu', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày lễ trùng dương, cúng tổ tiên và cầu sức khỏe.'],
            '15-9'  => ['ten_su_kien' => '🌕 Rằm tháng Chín', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng Quan Âm và tổ tiên.'],

            // THÁNG MƯỜI (Tháng 10)
            '1-10'  => ['ten_su_kien' => '🌸 Mồng 1 tháng Mười', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày lễ thần linh cao cả.'],
            '10-10' => ['ten_su_kien' => 'Tết Thường Tân', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng tế cuối thu.'],
            '15-10' => ['ten_su_kien' => '🌕 Tết Hạ Nguyên', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày lễ Thủy Quan Đại Đế, cầu xin giải ách.'],

            // THÁNG MƯỜI MỘT (Tháng 11)
            '1-11'  => ['ten_su_kien' => '🌸 Mồng 1 tháng Mười một', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng mười một âm lịch, ngày cúng tổ tiên.'],
            '15-11' => ['ten_su_kien' => '🌕 Rằm tháng Mười một', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày cúng tổ tiên và Phật.'],

            // THÁNG CHẠP (Tháng 12)
            '1-12'  => ['ten_su_kien' => '🌸 Mồng 1 tháng Chạp', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Đầu tháng chạp âm lịch, bắt đầu chuẩn bị Tết.'],
            '8-12'  => ['ten_su_kien' => 'Lễ Phật Thành đạo', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày Đức Phật thành đạo dưới cây Bồ Đề.'],
            '15-12' => ['ten_su_kien' => '🌕 Rằm tháng Chạp', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Rằm cuối năm, cúng tổ tiên.'],
            '23-12' => ['ten_su_kien' => 'Ông Công, Ông Táo', 'loai_su_kien' => 'truyen_thong', 'mo_ta' => 'Ngày các vị thần Bếp lên chầu trời để báo cáo mọi việc trong năm.'],
            '30-12' => ['ten_su_kien' => 'Giao thừa', 'loai_su_kien' => 'le_lon', 'mo_ta' => 'Đêm giao thừa, đón năm mới âm lịch.'],
        ];

        $result = [];
        
        // Lấy các sự kiện cố định cho tháng được yêu cầu
        foreach ($events as $key => $eventData) {
            list($ed, $em) = explode('-', $key);
            if ((int)$em == (int)$lunarMonth) {
                $result[(int)$ed] = $eventData;
            }
        }
        // Sắp xếp lại mảng kết quả theo key (ngày) để đảm bảo thứ tự
        ksort($result);

        return $result;
    }

    
}
