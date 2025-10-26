<?php

namespace App\Http\Controllers;

use App\Helpers\HuongXuatHanhHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LichKhongMinhHelper;
use App\Helpers\LoadConfigHelper;
use App\Helpers\LunarHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LichController extends Controller
{
    private function generateNamContent($nam, $can_chi_nam, $titleName)
    {
        try {
            // Tính năm âm lịch tương ứng với năm dương lịch
            $lunar_year = $nam;

            // Lấy thông tin ngày đầu năm âm lịch (Tết) = ngày 1/1 âm lịch chuyển sang dương lịch
            $ngay_tet_solar = LunarHelper::convertLunar2Solar(1, 1, $lunar_year, 0);
            $ngay_tet_formatted = sprintf("%02d/%02d/%d", $ngay_tet_solar[0], $ngay_tet_solar[1], $ngay_tet_solar[2]);

            $dateYeartetamtuduong_dau = LunarHelper::convertSolar2Lunar(1, 1, $nam);
            $dateYeartetamtuduong_dau_format = sprintf("%02d/%02d/%d", $dateYeartetamtuduong_dau[0], $dateYeartetamtuduong_dau[1], $dateYeartetamtuduong_dau[2]);
            $dateYeartetamtuduong_cuoi = LunarHelper::convertSolar2Lunar(31, 12, $nam);
            $dateYeartetamtuduong_cuoi_format = sprintf("%02d/%02d/%d", $dateYeartetamtuduong_cuoi[0], $dateYeartetamtuduong_cuoi[1], $dateYeartetamtuduong_cuoi[2]);
            // dd($dateYeartetamtuduong_dau);
            // Lấy thông tin ngày cuối năm âm lịch (ngày 29 hoặc 30 tháng 12 âm lịch)
            // Thử ngày 30 trước, nếu không có thì dùng 29
            $ngay_cuoi_nam_am_solar = LunarHelper::convertLunar2Solar(30, 12, $lunar_year, 0);
            if ($ngay_cuoi_nam_am_solar[0] == 0) {
                $ngay_cuoi_nam_am_solar = LunarHelper::convertLunar2Solar(29, 12, $lunar_year, 0);
            }
            $ngay_cuoi_nam_am_formatted = sprintf("%02d/%02d/%d", $ngay_cuoi_nam_am_solar[0], $ngay_cuoi_nam_am_solar[1], $ngay_cuoi_nam_am_solar[2]);

            // Lấy tên con giáp và mô tả
            $chi_parts = explode(' ', $can_chi_nam);
            $chi_name = isset($chi_parts[1]) ? $chi_parts[1] : '';

            $chi_to_animal = [
                'Tý' => 'Chuột',
                'Sửu' => 'Trâu',
                'Dần' => 'Hổ',
                'Mão' => 'Mèo',
                'Thìn' => 'Rồng',
                'Tỵ' => 'Rắn',
                'Ngọ' => 'Ngựa',
                'Mùi' => 'Dê',
                'Thân' => 'Khỉ',
                'Dậu' => 'Gà',
                'Tuất' => 'Chó',
                'Hợi' => 'Lợn'
            ];

            $con_giap = isset($chi_to_animal[$chi_name]) ? $chi_to_animal[$chi_name] : 'Chuột';
        } catch (\Exception $e) {
            // Nếu có lỗi, dùng thông tin mặc định
            $ngay_tet_formatted = "Tết Nguyên Đán";
            $ngay_cuoi_nam_am_formatted = "cuối năm âm lịch";
            $chi_name = "Tý";
            $con_giap = "Chuột";
        }
        // {{-- <h3 class='title-tong-quan-h3-log'>Lịch Vạn Niên Năm {$nam} – {$can_chi_nam}</h3> --}}
        $content = "
        <div class='nam-content-auto text-box-tong-quan '>
            <h2 class='title-tong-quan-h2-log'>Lịch vạn niên năm {$nam} - {$can_chi_nam}</h2>
            <p>Lịch vạn niên {$nam} tương ứng với tuổi {$chi_name} (con {$con_giap}) trong hệ thống Âm lịch, mang Can Chi {$can_chi_nam}. Năm dương lịch {$nam} bắt đầu từ ngày 01/01/{$nam} và kết thúc vào ngày 31/12/{$nam} (tức là từ ngày {$dateYeartetamtuduong_dau_format} đến ngày {$dateYeartetamtuduong_cuoi_format} Âm lịch). Theo Âm lịch, năm {$can_chi_nam} kéo dài từ ngày {$ngay_tet_formatted} đến {$ngay_cuoi_nam_am_formatted} (Dương lịch).</p>
            <p>{$titleName}</p>
            <p>Khi tra cứu lịch năm {$nam} tại Phong Lịch, bạn sẽ có đầy đủ thông tin:</p>
            <ul>
                <li>Ngày âm – ngày dương chi tiết cho từng tháng trong năm.</li>
                <li>Ngày hoàng đạo – hắc đạo, tiết khí, xem ngày tốt, xem giờ tốt.</li>
                <li>Danh sách các dịp lễ tết, ngày quan trọng theo cả Âm lịch và Dương lịch.</li>
            </ul>
            <p>Sử dụng lịch vạn niên năm {$nam} – {$can_chi_nam} sẽ giúp bạn dễ dàng theo dõi ngày tháng, đồng thời chọn được thời điểm cát lợi cho những việc trọng đại như cưới hỏi, khai trương, động thổ hay xuất hành.</p>
        </div>";

        return $content;
    }
    public function nam($nam)
    {
        if (!$nam || $nam < 1800 || $nam > 2300) {
            abort(404);
        }

        $can_chi_nam = KhiVanHelper::canchiNam($nam);
        $metaKeywords = "lịch âm $nam, lich am $nam, lich van nien $nam, âm lịch $nam, am lich $nam, lich am " . mb_strtolower($can_chi_nam);
        $ogImg = url("/image/nam/$nam");
        $titleName = LoadConfigHelper::$yheaderscanchi[$can_chi_nam];
        $metaTitle = " Lịch Âm năm $nam – Lịch Vạn Niên $nam | Xem Âm Lịch năm $can_chi_nam";
        $metaDescription = "Xem Lịch Vạn Niên, lịch Âm năm $nam - năm $can_chi_nam. Tra cứu ngày âm – dương, ngày hoàng đạo, ngày tốt xấu, lễ tết và các sự kiện trong năm $nam.";
        // Thông tin từng tháng dương lịch và tương ứng âm lịch
        $thang_info = [];
        $mo_ta_thang = [
            1 => "Tháng 1 dương lịch trùng với thời điểm cuối năm của âm lịch nên thường có nhiều hoạt động hội họp cuối năm, tất niên, chuẩn bị cho kỳ nghỉ tết Nguyên Đán " . $nam,
            2 => "Lịch âm dương tháng 2 thường có kỳ nghỉ lễ tết Nguyên Đán và các hoạt động khai xuân, du xuân đầu năm. Hãy tham khảo cùng Phong Lịch để có kế hoạch cho bản thân và gia đình nhé",
            3 => "Tháng 3 trong Lịch âm " . $nam . " có nhiều lễ hội diễn ra trong cả nước, ngoài ra còn có một số ngày lễ quan trọng như Quốc tế Phụ nữ 8/3. Bạn hãy tham khảo để nắm bắt chính xác các mốc thời gian quan trọng của các sự kiện",
            4 => "Tháng 4 trong Lịch vạn niên " . $nam . " có thời tiết ấm áp, thường là thời điểm lý tưởng để khám phá các địa điểm du lịch trong nước, như các điểm du lịch biển, vùng núi, hoặc các di tích lịch sử. Ngoài ra tháng 4 cũng có nhiều ngày tốt để bạn có thể làm những việc đại sự trong đời. Bạn hãy xem chi tiết để chuẩn bị cho các hoạt động sắp diễn ra",
            5 => "Lịch tháng 5 năm " . $nam . " cung cấp nhiều thông tin quan trọng về các sự kiện, ngày lễ sắp diễn ra. Hãy cùng Phong Lịch khám phá và chuẩn bị cho các hoạt động sắp tới.",
            6 => "Tháng 6 năm " . $nam . " thường trùng với kỳ nghỉ hè nên đây là thời gian lý tưởng để đi du lịch, các hoạt động ngoại khóa như dã ngoại, cắm trại hoặc thăm các công viên, khu vực thiên nhiên. Hãy tham khảo lịch âm dương dưới đây để chuẩn bị cho các hoạt động của bạn và gia đình nhé",
            7 => "Tháng 7 thường là thời gian nắng nóng, hãy tận hưởng thời tiết bằng cách đi biển, bơi lội hoặc thực hiện các hoạt động ngoại khóa khác. Ngoài ra, bạn có thể chọn một số ngày tốt trong tháng 7 để thực hiện một số công việc lớn cho bản thân và gia đình trước khi tháng Ngâu đến",
            8 => "Tháng 8 năm " . $nam . " là khoảng thời gian phù hợp để bạn tham gia các hoạt động như du lịch tâm linh, làm từ thiện và các sự kiện công cộng khác. Hãy cùng tham tham khảo để nắm rõ lịch âm dương tháng 8 cho bản thân và gia đình",
            9 => "Tháng 9 thường là thời điểm mùa thu bắt đầu, nên bạn có thể tận hưởng không khí mát mẻ của mùa thu bằng cách đi dạo trong công viên hoặc thực hiện các hoạt động ngoại khóa. Ngoài ra, Tháng 9 cũng là thời điểm tốt để tham gia vào các hoạt động từ thiện và cộng đồng để giúp đỡ những người cần sự giúp đỡ. Xem ngay lịch vạn sự tháng 9 để nắm bắt các sự kiện sắp diễn ra",
            10 => "Tháng 10 thường là thời gian của mùa thu thường là thời điểm diễn ra nhiều sự kiện văn hóa và nghệ thuật như triển lãm nghệ thuật, hội chợ, hay các buổi biểu diễn. Đây cũng là thời điểm lý tưởng để tham gia vào các hoạt động thể thao như chạy bộ, đạp xe, hoặc các lớp thể dục để duy trì sức khỏe. Hãy xem lịch âm dương tháng 10 để sắp xếp các lịch trình cho gia đình và bản thân nhé",
            11 => "Tháng 11 thường là thời gian mà không khí bắt đầu se lạnh, bạn có thể tận hưởng cảm giác này bằng cách đi dạo trong công viên hoặc thực hiện các hoạt động ngoại khóa khác. Ngoài ra, tháng 11 cũng là thời gian tuyệt vời để tổ chức các buổi gặp mặt gia đình và bạn bè, thưởng thức các bữa ăn ngon và chia sẻ những khoảnh khắc đáng nhớ với nhau. Nếu bạn đang băn khoăn về những sự kiện, ngày lễ sẽ diễn ra trong tháng 11 thì hãy cùng Phong Lịch tham khảo và lên kế hoạch cho các sự kiện sắp tới",
            12 => "Tháng 12 thường là thời gian chuẩn bị cho kỳ nghỉ cuối năm, bao gồm việc mua sắm quà tặng, lên kế hoạch cho các bữa tiệc và chuyến du lịch. Tháng 12 cũng là thời gian tuyệt vời để dọn dẹp và sắp xếp lại nhà cửa, chuẩn bị cho năm mới sắp tới. Nếu bạn đang có kế hoạch cho những công việc lớn trong tháng 12 thì hãy tham khảo lịch Lịch âm " . $nam . " để chuẩn bị tốt cho những sự kiện sắp tới nhé. "
        ];

        for ($thang = 1; $thang <= 12; $thang++) {
            // Ngày đầu tháng dương lịch
            $ngay_dau_thang_duong = 1;
            $ngay_cuoi_thang_duong = date('t', mktime(0, 0, 0, $thang, 1, $nam));

            // Chuyển đổi sang âm lịch
            $am_lich_dau_thang = LunarHelper::convertSolar2Lunar($ngay_dau_thang_duong, $thang, $nam);
            $am_lich_cuoi_thang = LunarHelper::convertSolar2Lunar($ngay_cuoi_thang_duong, $thang, $nam);

            $thang_info[$thang] = [
                'duong_lich' => [
                    'tu_ngay' => $ngay_dau_thang_duong,
                    'den_ngay' => $ngay_cuoi_thang_duong,
                    'thang' => $thang,
                    'nam' => $nam
                ],
                'am_lich_dau' => [
                    'ngay' => $am_lich_dau_thang[0],
                    'thang' => $am_lich_dau_thang[1],
                    'nam' => $am_lich_dau_thang[2]
                ],
                'am_lich_cuoi' => [
                    'ngay' => $am_lich_cuoi_thang[0],
                    'thang' => $am_lich_cuoi_thang[1],
                    'nam' => $am_lich_cuoi_thang[2]
                ],
                'mo_ta' => $mo_ta_thang[$thang]
            ];
        }

        $sukienduong = LunarHelper::printAllDuongLichEvents($nam);
        $sukienam = LunarHelper::printAllAmLichEvents();

        // Lấy các sự kiện lịch sử theo tháng
        $sukien_lichsu = LoadConfigHelper::$sukien;

        // Generate content tự động cho năm
        $nam_content_auto = $this->generateNamContent($nam, $can_chi_nam, $titleName);

        // Generate lunar months for the year (same logic as in thang method)
        $lunar_months = $this->generateLunarMonthsForYear($nam);

        return view('lich.nam', compact(
            'nam',
            'can_chi_nam',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'ogImg',
            'sukienduong',
            'sukienam',
            'titleName',
            'thang_info',
            'sukien_lichsu',
            'nam_content_auto',
            'lunar_months'
        ));
    }

    public function thang($nam, $thang, $is_lunar = false)
    {

        if (!$nam || $nam < 1800 || $nam > 2300 || !$thang || $thang > 12) {
            abort(404);
        }

        // NEW DEFAULT: Show lunar month by default
        // If user wants solar month, they need to use a different route or parameter

        // Check if this is a request for solar/dương calendar
        $request_solar_view = request()->get('solar') == '1' || request()->get('duong') == '1';

        if (!$request_solar_view) {
            // Default: show lunar month as main and solar month below
            return $this->showLunarMonth($nam, $thang, false);
        }

        // User explicitly wants solar month - show solar month
        // Dữ liệu lịch âm (giả định bạn đã viết lại hàm tương đương printTable)
        [$table_html, $data_totxau, $data_al] = LunarHelper::printTable($thang, $nam, true, true, true);

        $can_chi_nam = LunarHelper::canchiNam($nam);
        $can_chi_thang = LunarHelper::canchiThang($nam, $thang);


        $metaTitle = "Lịch Âm Tháng $thang Năm $nam – Lịch Vạn Niên $thang/$nam";
        $metaDescription = "Tra cứu lịch âm tháng $thang năm $nam chính xác. Xem ngày âm – dương, ngày hoàng đạo, ngày tốt xấu và các dịp lễ tết quan trọng trong tháng $thang/$nam.";
        $le_lichs = array_filter(LoadConfigHelper::$ledl, function ($le) use ($thang) {
            return $le['mm'] == $thang;
        });
        $su_kiens = LoadConfigHelper::$sukien[$thang];
        $desrtipton_thang = LoadConfigHelper::generateMonthDescription($thang, $nam, $can_chi_nam);

        // Find the primary lunar month
        // Priority 1: The lunar month that STARTS in this solar month
        $primary_lunar_month = null;

        foreach ($data_al as $day) {
            if ($day['day'] == 1) {
                $primary_lunar_month = $day['month'];
                break; // Found it, take the first one
            }
        }

        // Priority 2: Fallback to the month with the most days
        if (!$primary_lunar_month) {
            $lunar_months = array_column($data_al, 'month');
            if ($lunar_months) {
                $lunar_month_counts = array_count_values($lunar_months);
                arsort($lunar_month_counts);
                $primary_lunar_month = key($lunar_month_counts);
            }
        }

        $le_lichs_am = array_filter(LoadConfigHelper::$leal, function ($le) use ($primary_lunar_month) {
            return $le['mm'] == $primary_lunar_month;
        });

        // Generate all lunar months for the year including leap month
        // We'll show lunar months based on the SOLAR year being viewed
        $lunar_months_data = [];

        // Try both the current year and next year to get all lunar months that appear in this solar year
        $years_to_check = [$nam - 1, $nam];

        foreach ($years_to_check as $check_year) {
            $lunar_year = $check_year;

            // Check if this lunar year has a leap month
            $leap_month_number = 0;
            list($solar_d_11_prev, $solar_m_11_prev, $solar_y_11_prev) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year - 1, 0);
            list($solar_d_11, $solar_m_11, $solar_y_11) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year, 0);

            if ($solar_d_11_prev > 0 && $solar_d_11 > 0) {
                $days_between = (mktime(0, 0, 0, $solar_m_11, $solar_d_11, $solar_y_11) -
                                mktime(0, 0, 0, $solar_m_11_prev, $solar_d_11_prev, $solar_y_11_prev)) / 86400;

                if ($days_between > 365) {
                    // Find which month is leap
                    for ($test_month = 1; $test_month <= 12; $test_month++) {
                        list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 1);
                        if ($leap_d > 0) {
                            list($regular_d, $regular_m, $regular_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 0);
                            if ($regular_d > 0 && !($leap_d == $regular_d && $leap_m == $regular_m && $leap_y == $regular_y)) {
                                $leap_month_number = $test_month;
                                break;
                            }
                        }
                    }
                }
            }

            // Add all lunar months from this lunar year that fall in the solar year
            for ($lunar_month = 1; $lunar_month <= 12; $lunar_month++) {
                list($solar_d, $solar_m, $solar_y) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 0);

                // Only add if this lunar month starts in the solar year we're viewing
                if ($solar_y == $nam && $solar_d > 0) {
                    $lunar_months_data[] = [
                        'lunar_month' => $lunar_month,
                        'lunar_year' => $lunar_year,
                        'is_leap' => false,
                        'solar_date' => sprintf("%02d/%02d/%d", $solar_d, $solar_m, $solar_y),
                        'solar_month' => $solar_m,
                        'solar_year' => $solar_y,
                        'solar_day' => $solar_d,
                        'can_chi' => LunarHelper::canchiThang($lunar_year, $lunar_month),
                        'display_name' => "Tháng $lunar_month"
                    ];
                }

                // Add leap month if it exists and falls in this solar year
                if ($leap_month_number == $lunar_month) {
                    list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 1);

                    if ($leap_y == $nam && $leap_d > 0) {
                        $lunar_months_data[] = [
                            'lunar_month' => $lunar_month,
                            'lunar_year' => $lunar_year,
                            'is_leap' => true,
                            'solar_date' => sprintf("%02d/%02d/%d", $leap_d, $leap_m, $leap_y),
                            'solar_month' => $leap_m,
                            'solar_year' => $leap_y,
                            'solar_day' => $leap_d,
                            'can_chi' => LunarHelper::canchiThang($lunar_year, $lunar_month),
                            'display_name' => "Tháng $lunar_month nhuận"
                        ];
                    }
                }
            }
        }

        // Sort by solar date
        usort($lunar_months_data, function($a, $b) {
            $date_a = mktime(0, 0, 0, $a['solar_month'], $a['solar_day'], $a['solar_year']);
            $date_b = mktime(0, 0, 0, $b['solar_month'], $b['solar_day'], $b['solar_year']);
            return $date_a - $date_b;
        });

        // Sau khi lấy $data_al từ LunarHelper
        foreach ($data_al as &$ngay) {
            // Bước 1: Xác định nhóm tháng (group 1, 2, 3)
            $thang_am = $ngay['month'];

            $groupMonth = HuongXuatHanhHelper::getMonthGroup((int)$thang_am);
            // Bước 2: Tính loại ngày xuất hành
            $ten_ngay = HuongXuatHanhHelper::calculateXuatHanhDay($groupMonth, $ngay['day']);

            // Bước 3: Lấy mô tả HTML của ngày đó
            $mo_ta_ngay = LichKhongMinhHelper::ngayToHTML($ten_ngay);

            // Thêm vào mỗi ngày
            $ngay['xuat_hanh_ten'] = $ten_ngay;
            $ngay['xuat_hanh_html'] = $mo_ta_ngay;
        }

        // Find the primary lunar month
        // Priority 1: The lunar month that STARTS in this solar month
        $primary_lunar_month = null;
        $primary_lunar_year = 0;
        $primary_lunar_is_leap = 0;

        foreach ($data_al as $day) {
            if ($day['day'] == 1) {
                $primary_lunar_month = $day['month'];
                $primary_lunar_year = $day['year'];
                $primary_lunar_is_leap = $day['leap'];
                break; // Found it, take the first one
            }
        }

        // Priority 2: Fallback to the month with the most days
        if (!$primary_lunar_month) {
            $lunar_months = array_column($data_al, 'month');
            if ($lunar_months) {
                $lunar_month_counts = array_count_values($lunar_months);
                arsort($lunar_month_counts);
                $primary_lunar_month = key($lunar_month_counts);

                // Find year and leap for the majority month
                foreach ($data_al as $day) {
                    if ($day['month'] == $primary_lunar_month) {
                        $primary_lunar_year = $day['year'];
                        $primary_lunar_is_leap = $day['leap'];
                        break;
                    }
                }
            }
        }

        // Tìm tháng âm CÙNG SỐ với tháng dương gần nhất
        $all_lunar_months = [];

        // Luôn kiểm tra năm hiện tại trước, sau đó là năm trước và năm sau
        $lunar_years_to_check = [$nam, $nam - 1, $nam + 1];

        // Kiểm tra tháng âm cùng số (thường và nhuận) trong các năm
        foreach ($lunar_years_to_check as $lunar_year) {
            // Kiểm tra tháng thường
            list($solar_d, $solar_m, $solar_y) = LunarHelper::convertLunar2Solar(1, $thang, $lunar_year, 0);

            // Nếu tháng âm tồn tại
            if ($solar_d > 0) {
                // Tính khoảng cách với tháng dương hiện tại
                $start_date = mktime(0, 0, 0, $solar_m, $solar_d, $solar_y);
                $current_month_start = mktime(0, 0, 0, $thang, 1, $nam);
                $distance = abs($start_date - $current_month_start);

                $all_lunar_months[] = [
                    'month' => $thang,
                    'is_leap' => 0,
                    'year' => $lunar_year,
                    'distance' => $distance,
                    'solar_start' => "$solar_d/$solar_m/$solar_y"
                ];
            }

            // Kiểm tra tháng nhuận (nếu không phải tháng 1)
            if ($thang != 1) {
                list($solar_d_leap, $solar_m_leap, $solar_y_leap) = LunarHelper::convertLunar2Solar(1, $thang, $lunar_year, 1);

                // QUAN TRỌNG: Kiểm tra xem tháng nhuận có thực sự tồn tại không
                // Hàm convertLunar2Solar có bug trả về ngày sai cho tháng nhuận không tồn tại
                // Cần kiểm tra thêm: nếu ngày trả về giống tháng thường thì không phải tháng nhuận
                list($solar_d_normal, $solar_m_normal, $solar_y_normal) = LunarHelper::convertLunar2Solar(1, $thang, $lunar_year, 0);

                $is_valid_leap = false;
                if ($solar_d_leap > 0 && $solar_d_normal > 0) {
                    // Nếu tháng nhuận trả về ngày khác tháng thường, mới là tháng nhuận thực sự
                    if (!($solar_d_leap == $solar_d_normal && $solar_m_leap == $solar_m_normal && $solar_y_leap == $solar_y_normal)) {
                        $is_valid_leap = true;
                    }
                }

                if ($is_valid_leap) {
                    // Tính khoảng cách với tháng dương hiện tại
                    $start_date = mktime(0, 0, 0, $solar_m_leap, $solar_d_leap, $solar_y_leap);
                    $current_month_start = mktime(0, 0, 0, $thang, 1, $nam);
                    $distance = abs($start_date - $current_month_start);

                    $all_lunar_months[] = [
                        'month' => $thang,
                        'is_leap' => 1,
                        'year' => $lunar_year,
                        'distance' => $distance,
                        'solar_start' => "$solar_d_leap/$solar_m_leap/$solar_y_leap"
                    ];
                }
            }
        }

        // Sắp xếp theo khoảng cách (gần nhất trước)
        usort($all_lunar_months, function($a, $b) {
            return $a['distance'] - $b['distance'];
        });

        // Chỉ lấy tháng âm gần nhất (thường và/hoặc nhuận của cùng năm)
        $final_lunar_months = [];
        if (!empty($all_lunar_months)) {
            $closest = $all_lunar_months[0];
            $final_lunar_months[] = $closest;

            // Nếu có tháng nhuận cùng năm với tháng gần nhất, thêm vào
            foreach ($all_lunar_months as $month) {
                if ($month['year'] == $closest['year'] &&
                    $month['is_leap'] != $closest['is_leap']) {
                    $final_lunar_months[] = $month;
                    break;
                }
            }
        }

        // Sắp xếp lại: thường trước, nhuận sau
        usort($final_lunar_months, function($a, $b) {
            if ($a['year'] != $b['year']) {
                return $a['year'] - $b['year'];
            }
            return $a['is_leap'] - $b['is_leap'];
        });

        $all_lunar_months = $final_lunar_months;


        // Tạo bảng lịch cho từng tháng âm
        $lunar_calendars = [];

        foreach ($all_lunar_months as $lunar_month) {
            $month_num = $lunar_month['month'];
            $is_leap = $lunar_month['is_leap'];
            $lunar_year = $lunar_month['year'];

            // Lấy can chi của tháng
            $can_chi = LunarHelper::canchiThang($lunar_year, $month_num);
            if ($is_leap) {
                $can_chi .= ' (nhuận)';
            }

            // Chuyển đổi ngày 1 của tháng âm sang dương
            list($start_dd, $start_mm, $start_yy) = LunarHelper::convertLunar2Solar(1, $month_num, $lunar_year, $is_leap);

            if ($start_dd > 0) { // Nếu tháng âm tồn tại
                $lunar_month_calendar_data = [];
                $current_date = \Carbon\Carbon::create($start_yy, $start_mm, $start_dd);
                $max_iterations = 31; // Safety limit
                $iteration_count = 0;

                // Generate calendar by adding days until we reach the next lunar month
                while ($iteration_count < $max_iterations) {
                    $solar_day = $current_date->day;
                    $solar_month = $current_date->month;
                    $solar_year = $current_date->year;

                    list($ld, $lm, $ly, $ll) = LunarHelper::convertSolar2Lunar($solar_day, $solar_month, $solar_year);

                    // Stop when we reach a different lunar month, year, or leap status
                    if (($lm != $month_num || $ly != $lunar_year || $ll != $is_leap) && count($lunar_month_calendar_data) > 0) {
                        break;
                    }

                    // Only add days that belong to the expected lunar month, year, and leap status
                    if ($lm == $month_num && $ly == $lunar_year && $ll == $is_leap) {
                        $jd = LunarHelper::jdFromDate($solar_day, $solar_month, $solar_year);
                        $canchi_day = LunarHelper::canchiNgayByJD($jd);

                        $lunar_month_calendar_data[] = [
                            'day' => $ld,
                            'month' => $lm,
                            'year' => $ly,
                            'leap' => $ll,
                            'jd' => $jd,
                            'canchi' => $canchi_day,
                            'solar_day' => $solar_day,
                            'solar_month' => $solar_month,
                            'solar_year' => $solar_year,
                        ];
                    }

                    $current_date->addDay();
                    $iteration_count++;
                }

                $first_day_of_week = (\Carbon\Carbon::create($start_yy, $start_mm, $start_dd)->dayOfWeek + 6) % 7;

                $weeks = [];
                $current_week = [];

                for ($i = 0; $i < $first_day_of_week; $i++) {
                    $current_week[] = null;
                }

                foreach ($lunar_month_calendar_data as $day) {
                    $current_week[] = $day;
                    if (count($current_week) == 7) {
                        $weeks[] = $current_week;
                        $current_week = [];
                    }
                }

                if (count($current_week) > 0) {
                    while (count($current_week) < 7) {
                        $current_week[] = null;
                    }
                    $weeks[] = $current_week;
                }

                // Lưu thông tin lịch âm này
                $lunar_calendars[] = [
                    'month' => $month_num,
                    'is_leap' => $is_leap,
                    'can_chi' => $can_chi,
                    'weeks' => $weeks
                ];
            }
        }



        return view('lich.thang', [
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'yy' => $nam,
            'mm' => $thang,
            'can_chi_nam' => $can_chi_nam,
            'can_chi_thang' => $can_chi_thang,
            'table_html' => $table_html,
            'data_totxau' => $data_totxau,
            'data_al' => $data_al,
            'desrtipton_thang' => $desrtipton_thang,
            'le_lichs' => $le_lichs, //Ngày lễ dương lịch
            'su_kiens' => $su_kiens, //Sự kiện tháng
            'lunar_calendars' => $lunar_calendars, // Mảng chứa tất cả các lịch âm trong tháng dương này
            'primary_lunar_month' => $primary_lunar_month,
            'le_lichs_am' => $le_lichs_am,
            'lunar_months_data' => $lunar_months_data, // All lunar months in the year
        ]);
    }

    private function showLunarMonth($nam, $thang, $is_leap)
    {
        $lunar_year = $nam;
        $lunar_month = $thang;

        // Check if this lunar month exists
        list($solar_d, $solar_m, $solar_y) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, $is_leap ? 1 : 0);

        if ($solar_d <= 0) {
            // Lunar month doesn't exist
            abort(404);
        }

        // Generate calendar data for the lunar month
        $lunar_calendar_data = $this->generateLunarMonthCalendar($lunar_month, $lunar_year, $is_leap);

        // Get metadata
        $can_chi_nam = LunarHelper::canchiNam($lunar_year);
        $can_chi_thang = LunarHelper::canchiThang($lunar_year, $lunar_month);

        $metaTitle = "Lịch Âm Tháng $lunar_month" . ($is_leap ? " Nhuận" : "") . " Năm $lunar_year – Lịch Vạn Niên";
        $metaDescription = "Tra cứu lịch âm tháng $lunar_month" . ($is_leap ? " nhuận" : "") . " năm $lunar_year. Xem ngày âm – dương, ngày hoàng đạo, ngày tốt xấu.";

        // For display, always show the same solar month number as lunar month
        $display_solar_month = $lunar_month;
        $display_solar_year = $nam;

        // Get solar month data for display
        [$table_html, $data_totxau, $data_al] = LunarHelper::printTable($display_solar_month, $display_solar_year, true, true, true);

        // Get events and holidays
        $le_lichs = array_filter(LoadConfigHelper::$ledl, function ($le) use ($display_solar_month) {
            return $le['mm'] == $display_solar_month;
        });

        $le_lichs_am = array_filter(LoadConfigHelper::$leal, function ($le) use ($lunar_month) {
            return $le['mm'] == $lunar_month;
        });

        $su_kiens = LoadConfigHelper::$sukien[$display_solar_month] ?? [];
        // Use lunar month and year for the description to get correct date range
        // Pass the leap month flag to get correct dates
        $desrtipton_thang = LoadConfigHelper::generateMonthDescription($lunar_month, $lunar_year, $can_chi_nam, $is_leap);

        // Generate lunar months data for sidebar
        $lunar_months_data = $this->generateLunarMonthsForYear($lunar_year);

        // Prepare data for ngay xuat hanh
        foreach ($data_al as &$ngay) {
            $thang_am = $ngay['month'];
            $groupMonth = HuongXuatHanhHelper::getMonthGroup((int)$thang_am);
            $ten_ngay = HuongXuatHanhHelper::calculateXuatHanhDay($groupMonth, $ngay['day']);
            $mo_ta_ngay = LichKhongMinhHelper::ngayToHTML($ten_ngay);
            $ngay['xuat_hanh_ten'] = $ten_ngay;
            $ngay['xuat_hanh_html'] = $mo_ta_ngay;
        }

        // Create the main lunar calendar display
        $lunar_calendars = [
            [
                'month' => $lunar_month,
                'is_leap' => $is_leap,
                'can_chi' => $can_chi_thang . ($is_leap ? ' (nhuận)' : ''),
                'weeks' => $lunar_calendar_data['weeks'],
                'year' => $lunar_year
            ]
        ];

        return view('lich.thang', [
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'yy' => $display_solar_year,
            'mm' => $display_solar_month,
            'can_chi_nam' => $can_chi_nam,
            'can_chi_thang' => $can_chi_thang,
            'table_html' => $table_html,
            'data_totxau' => $data_totxau,
            'data_al' => $data_al,
            'desrtipton_thang' => $desrtipton_thang,
            'le_lichs' => $le_lichs,
            'su_kiens' => $su_kiens,
            'lunar_calendars' => $lunar_calendars,
            'primary_lunar_month' => $lunar_month,
            'le_lichs_am' => $le_lichs_am,
            'lunar_months_data' => $lunar_months_data,
            'is_leap_month_view' => $is_leap,
            'lunar_month_num' => $lunar_month,
            'lunar_year' => $lunar_year,
            'is_lunar_view' => true
        ]);
    }

    public function thangAm($nam, $thang)
    {
        if (!$nam || $nam < 1800 || $nam > 2300 || !$thang || $thang > 12) {
            abort(404);
        }

        // Show lunar month as main calendar
        return $this->showLunarMonth($nam, $thang, false);
    }

    public function thangNhuan($nam, $thang)
    {
        if (!$nam || $nam < 1800 || $nam > 2300 || !$thang || $thang > 12) {
            abort(404); 
        }

        // First check if this lunar year has a leap month at all
        $lunar_year = $nam;
        $has_leap_month = false;
        $leap_month_number = 0;

        // Check the 11th month distance to determine if there's any leap month
        list($solar_d_11_prev, $solar_m_11_prev, $solar_y_11_prev) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year - 1, 0);
        list($solar_d_11, $solar_m_11, $solar_y_11) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year, 0);

        if ($solar_d_11_prev > 0 && $solar_d_11 > 0) {
            $days_between = (mktime(0, 0, 0, $solar_m_11, $solar_d_11, $solar_y_11) -
                            mktime(0, 0, 0, $solar_m_11_prev, $solar_d_11_prev, $solar_y_11_prev)) / 86400;

            if ($days_between > 365) {
                // This year has a leap month, now check which month
                for ($test_month = 1; $test_month <= 12; $test_month++) {
                    list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 1);

                    if ($leap_d > 0) {
                        list($regular_d, $regular_m, $regular_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 0);

                        if ($regular_d > 0 && !($leap_d == $regular_d && $leap_m == $regular_m && $leap_y == $regular_y)) {
                            $leap_month_number = $test_month;
                            $has_leap_month = true;
                            break;
                        }
                    }
                }
            }
        }

        // If this year doesn't have a leap month at all, or the requested month is not the leap month
        if (!$has_leap_month || $leap_month_number != $thang) {
            // Redirect to regular month with lunar parameter
            return redirect()->route('lich.thang', ['nam' => $nam, 'thang' => $thang, 'lunar' => 1]);
        }

        // This leap month exists, show it
        return $this->showLunarMonth($nam, $thang, true);
    }

    private function generateLunarMonthCalendar($month_num, $lunar_year, $is_leap)
    {
        list($start_dd, $start_mm, $start_yy) = LunarHelper::convertLunar2Solar(1, $month_num, $lunar_year, $is_leap);

        if ($start_dd <= 0) {
            return ['weeks' => []];
        }

        $lunar_month_calendar_data = [];
        $current_date = \Carbon\Carbon::create($start_yy, $start_mm, $start_dd);
        $max_iterations = 31;
        $iteration_count = 0;

        while ($iteration_count < $max_iterations) {
            $solar_day = $current_date->day;
            $solar_month = $current_date->month;
            $solar_year = $current_date->year;

            list($ld, $lm, $ly, $ll) = LunarHelper::convertSolar2Lunar($solar_day, $solar_month, $solar_year);

            if (($lm != $month_num || $ly != $lunar_year || $ll != $is_leap) && count($lunar_month_calendar_data) > 0) {
                break;
            }

            if ($lm == $month_num && $ly == $lunar_year && $ll == $is_leap) {
                $jd = LunarHelper::jdFromDate($solar_day, $solar_month, $solar_year);
                $canchi_day = LunarHelper::canchiNgayByJD($jd);

                $lunar_month_calendar_data[] = [
                    'day' => $ld,
                    'month' => $lm,
                    'year' => $ly,
                    'leap' => $ll,
                    'jd' => $jd,
                    'canchi' => $canchi_day,
                    'solar_day' => $solar_day,
                    'solar_month' => $solar_month,
                    'solar_year' => $solar_year,
                ];
            }

            $current_date->addDay();
            $iteration_count++;
        }

        $first_day_of_week = (\Carbon\Carbon::create($start_yy, $start_mm, $start_dd)->dayOfWeek + 6) % 7;

        $weeks = [];
        $current_week = [];

        for ($i = 0; $i < $first_day_of_week; $i++) {
            $current_week[] = null;
        }

        foreach ($lunar_month_calendar_data as $day) {
            $current_week[] = $day;
            if (count($current_week) == 7) {
                $weeks[] = $current_week;
                $current_week = [];
            }
        }

        if (count($current_week) > 0) {
            while (count($current_week) < 7) {
                $current_week[] = null;
            }
            $weeks[] = $current_week;
        }

        return ['weeks' => $weeks];
    }

    private function generateLunarMonthsForYear($lunar_year)
    {
        $lunar_months_data = [];

        // Check for leap month
        $leap_month_number = 0;
        list($solar_d_11_prev, $solar_m_11_prev, $solar_y_11_prev) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year - 1, 0);
        list($solar_d_11, $solar_m_11, $solar_y_11) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year, 0);

        if ($solar_d_11_prev > 0 && $solar_d_11 > 0) {
            $days_between = (mktime(0, 0, 0, $solar_m_11, $solar_d_11, $solar_y_11) -
                            mktime(0, 0, 0, $solar_m_11_prev, $solar_d_11_prev, $solar_y_11_prev)) / 86400;

            if ($days_between > 365) {
                for ($test_month = 1; $test_month <= 12; $test_month++) {
                    list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 1);
                    if ($leap_d > 0) {
                        list($regular_d, $regular_m, $regular_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 0);
                        if ($regular_d > 0 && !($leap_d == $regular_d && $leap_m == $regular_m && $leap_y == $regular_y)) {
                            $leap_month_number = $test_month;
                            break;
                        }
                    }
                }
            }
        }

        // Build months array
        for ($lunar_month = 1; $lunar_month <= 12; $lunar_month++) {
            list($solar_d, $solar_m, $solar_y) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 0);

            if ($solar_d > 0) {
                $lunar_months_data[] = [
                    'lunar_month' => $lunar_month,
                    'lunar_year' => $lunar_year,
                    'is_leap' => false,
                    'solar_date' => sprintf("%02d/%02d/%d", $solar_d, $solar_m, $solar_y),
                    'solar_month' => $solar_m,
                    'solar_year' => $solar_y,
                    'solar_day' => $solar_d,
                    'can_chi' => LunarHelper::canchiThang($lunar_year, $lunar_month),
                    'display_name' => "Tháng $lunar_month"
                ];
            }

            if ($leap_month_number == $lunar_month) {
                list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 1);

                if ($leap_d > 0) {
                    $lunar_months_data[] = [
                        'lunar_month' => $lunar_month,
                        'lunar_year' => $lunar_year,
                        'is_leap' => true,
                        'solar_date' => sprintf("%02d/%02d/%d", $leap_d, $leap_m, $leap_y),
                        'solar_month' => $leap_m,
                        'solar_year' => $leap_y,
                        'solar_day' => $leap_d,
                        'can_chi' => LunarHelper::canchiThang($lunar_year, $lunar_month),
                        'display_name' => "Tháng $lunar_month nhuận"
                    ];
                }
            }
        }

        return $lunar_months_data;
    }

    public function getLichThangAjax(Request $request): JsonResponse
    {
        $nam = $request->input('nam');
        $thang = $request->input('thang');

        if (!$nam || $nam < 1900 || $nam > 2100 || !$thang || $thang < 1 || $thang > 12) {
            return response()->json(['error' => 'Invalid date'], 400);
        }

        list($table_html, $data_totxau, $data_al) = LunarHelper::printTable($thang, $nam, true, true, true);

        return response()->json([
            'table_html' => $table_html,
        ]);
    }







    // public function ngay($nam, $thang, $ngay)
    // {
    //     if (!$nam || $nam < 1800 || $nam > 2300 || !$thang || $thang > 12 || !$ngay || $ngay > 31) {
    //         abort(404);
    //     }

    //     $canonical = url()->to(route('lich.ngay', compact('nam', 'thang', 'ngay')));

    //     $al = LunarHelper::convertSolar2Lunar($ngay, $thang, $nam);
    //     $jd = LunarHelper::jdFromDate($ngay, $thang, $nam);

    //     $can_chi_ngay = LunarHelper::canchiNgayByJD($jd);
    //     $can_chi_thang = LunarHelper::canchiThang($al[2], $al[1]);
    //     $can_chi_nam = LunarHelper::canchiNam($al[2]);

    //     $chi_ngay = explode(' ', $can_chi_ngay)[1] ?? null;
    //     $gioHd = LunarHelper::gioHDTrongNgayTXT($chi_ngay);

    //     $data_ngay = LunarHelper::getContentById($ngay . $thang . $nam) ?? LunarHelper::getContentByDMY($ngay, $thang, $nam);

    //     $data = [
    //         'yy' => $nam,
    //         'mm' => $thang,
    //         'dd' => $ngay,
    //         'al' => $al,
    //         'jd' => $jd,
    //         'can_chi_nam' => $can_chi_nam,
    //         'can_chi_thang' => $can_chi_thang,
    //         'can_chi_ngay' => $can_chi_ngay,
    //         'giohd' => $gioHd,
    //         'ngay_content' => $data_ngay['Content'] ?? '',
    //     ];



    //     return view('lich.ngay', compact(
    //         'data',
    //         'canonical'
    //     ));
    // }
}
