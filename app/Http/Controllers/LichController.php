<?php

namespace App\Http\Controllers;

use App\Helpers\HuongXuatHanhHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LichKhongMinhHelper;
use App\Helpers\LoadConfigHelper;
use App\Helpers\LunarHelper;
use Illuminate\Http\Request;

class LichController extends Controller
{
    public function nam($nam)
    {
        if (!$nam || $nam < 1800 || $nam > 2300) {
            abort(404);
        }
        $metaTitle = "Lịch âm dương năm {$nam} | Lịch vạn niên, ngày tốt xấu, hoàng đạo";
        $metaDescription = "Xem lịch âm dương năm {$nam} đầy đủ và chính xác: lịch vạn niên, ngày tốt xấu, ngày hoàng đạo, ngày lễ âm lịch và dương lịch. Tra cứu nhanh chóng, dễ sử dụng.";
        $can_chi_nam = KhiVanHelper::canchiNam($nam);
        $metaKeywords = "lịch âm $nam,lich am $nam,lich van nien $nam,âm lịch $nam,am lich $nam,lich am " . mb_strtolower($can_chi_nam);
        $ogImg = url("/image/nam/$nam");
        $sukienduong = LunarHelper::printAllDuongLichEvents($nam);
        $sukienam = LunarHelper::printAllAmLichEvents();
        return view('lich.nam', compact(
            'nam',
            'can_chi_nam',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'ogImg',
            'sukienduong',
            'sukienam'
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
