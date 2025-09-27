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
        $metaTitle = "Lịch âm dương năm {$nam} | Lịch vạn niên, ngày tốt xấu, hoàng đạo";
        $metaDescription = "Xem lịch âm dương năm {$nam} đầy đủ và chính xác: lịch vạn niên, ngày tốt xấu, ngày hoàng đạo, ngày lễ âm lịch và dương lịch. Tra cứu nhanh chóng, dễ sử dụng.";
        $can_chi_nam = KhiVanHelper::canchiNam($nam);
        $metaKeywords = "lịch âm $nam, lich am $nam, lich van nien $nam, âm lịch $nam, am lich $nam, lich am " . mb_strtolower($can_chi_nam);
        $ogImg = url("/image/nam/$nam");
        $titleName = LoadConfigHelper::$yheaderscanchi[$can_chi_nam];

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
            'nam_content_auto'
        ));
    }

    public function thang($nam, $thang)
    {

        if (!$nam || $nam < 1800 || $nam > 2300 || !$thang || $thang > 12) {
            abort(404);
        }
        $metaTitle = "Lịch âm dương tháng {$thang} Năm {$nam} | Xem ngày tốt xấu, ngày hoàng đạo";
        $metaDescription = "Xem lịch âm dương tháng {$thang} năm {$nam} đầy đủ: ngày tốt xấu, ngày hoàng đạo, ngày lễ âm lịch và dương lịch. Lịch vạn niên chính xác, dễ tra cứu.";
        $desrtipton_thang = LoadConfigHelper::$mheaders[$thang];
        // Dữ liệu lịch âm (giả định bạn đã viết lại hàm tương đương printTable)
        [$table_html, $data_totxau, $data_al] = LunarHelper::printTable($thang, $nam, true, true, true);

        $can_chi_nam = LunarHelper::canchiNam($data_al[0]['year']);
        $can_chi_thang = LunarHelper::canchiThang($data_al[0]['year'], $data_al[0]['month']);

        $le_lichs = array_filter(LoadConfigHelper::$ledl, function ($le) use ($thang) {
            return $le['mm'] == $thang;
        });
        $su_kiens = LoadConfigHelper::$sukien[$thang];

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

        ]);
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
