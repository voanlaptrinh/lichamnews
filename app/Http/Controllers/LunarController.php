<?php

namespace App\Http\Controllers;

use App\Helpers\CatHungHelper;
use App\Helpers\DataHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GioHoangDaoHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\HuongXuatHanhHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LichKhongMinhHelper;
use App\Helpers\LunarHelper;
use App\Helpers\LyThuanPhongHelper;
use App\Helpers\NhiThapBatTuHelper;
use App\Helpers\NhiTrucHelper;
use App\Helpers\SaoTotXauHelper;
use App\Helpers\TimeConstantHelper;
use App\Helpers\XemNgayTotXauHelper;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Jetfuel\SolarLunar\Solar;
use Jetfuel\SolarLunar\Lunar;
use Jetfuel\SolarLunar\SolarLunar;

class LunarController extends Controller
{
    public function index(Request $request)
    {
        // Mặc định là ngày hiện tại nếu không nhập
        $dd = date('d');
        $mm = date('m');
        $yy = date('Y');

        $cdate = $request->input('cdate');  // Lấy ngày từ form (định dạng Y-m-d từ input[type="date"])
        $birthdate = $request->input('birthdate');  // Lấy ngày từ form (định dạng Y-m-d từ input[type="date"])

        if (FunctionHelper::validateDate($cdate, 'Y-m-d')) {
            // Nếu hợp lệ, phân tách thành dd, mm, yy
            $cdate_info = explode('-', $cdate);
            list($yy, $mm, $dd) = $cdate_info;
        }

        // Chuyển từ Dương lịch sang Âm lịch
        $al = LunarHelper::convertSolar2Lunar((int)$dd, (int)$mm, (int)$yy);

        // Tính Can Chi của ngày
        $jd = LunarHelper::jdFromDate((int)$dd, (int)$mm, (int)$yy);

        $canChi = LunarHelper::canchiNgayByJD($jd);
        $chi_ngay = explode(' ', $canChi);
        $chiNgay = $chi_ngay;

        $chi_ngay = @$chi_ngay[1];
        $gioHd = LunarHelper::gioHDTrongNgayTXT($chi_ngay); // Tính giờ hoàng đạo trong ngày
        $thu = LunarHelper::sw_get_weekday($cdate); // Tính thứ trong tháng

        $ngaySuatHanh = LichKhongMinhHelper::numToNgay((int)$al[1], (int)$al[0]); // Tính ngày xuất hành
        $ngaySuatHanhHTML = LichKhongMinhHelper::ngayToHTML($ngaySuatHanh); // HTML cho ngày xuất hành

        $tietkhi = LunarHelper::tietKhiWithIcon($jd);
        list($table_html, $data_totxau) = LunarHelper::printTable($mm, $yy, true, true);

     

        //Lấy sao tốt xấu theo ngọc Hạp thông thư
        $getSaoTotXauInfo = FunctionHelper::getSaoTotXauInfo($dd, $mm, $yy);
        //end

        //can chi tháng năm
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon((int)$dd, (int)$mm, (int)$yy);
        //end

        //Tổng quan ngày
        $getThongTinNgay = FunctionHelper::getThongTinNgay((int)$dd, (int)$mm, (int)$yy);
        //end


        //Nội khí ngày
        $noiKhiNgay =  KhiVanHelper::getDetailedNoiKhiExplanation((int)$dd, (int)$mm, (int)$yy);
        //end

        //Nhị thập bát tú
        $nhiThapBatTu = FunctionHelper::nhiThapBatTu((int)$yy, (int)$mm, (int)$dd);
        //end nhị thập bát tú

        //THập Nhị Trực 
        $getThongTinTruc = FunctionHelper::getThongTinTruc($dd, $mm, $yy);
        //end tHập nhị trực

        //Khổng minh lục diệu
        $khongMinhLucDieu = LichKhongMinhHelper::getKhongMinhLucDieuDayInfo($dd, $mm, $yy);
        //end khổng minh lục diệu

        //giải thích ngày theo Bành Tổ Bách Kỵ
        $banhToCan = DataHelper::$banhToCanTaboos[$chiNgay[0]];
        $banhToChi = DataHelper::$banhToChiTaboos[$chiNgay[1]];
        //end

        //Hướng xuất hành và giờ xuất hành lý thuần phong
        $getThongTinXuatHanhVaLyThuanPhong = FunctionHelper::getThongTinXuatHanhVaLyThuanPhong($dd, $mm, $yy);
        //------End------//

        //------Giờ hoàng đạo-------//
        $getDetailedGioHoangDao = GioHoangDaoHelper::getDetailedGioHoangDao((int)$dd, (int)$mm, (int)$yy);
        //end giờ hoàng đạo

        $amToday = sprintf('%04d-%02d-%02d', $al[2], $al[1], $al[0]);

        $getDaySummaryInfo = FunctionHelper::getDaySummaryInfo((int)$dd, (int)$mm, (int)$yy, $birthdate);


        return view('lunar.convert', [
            'cdate' => $cdate,
            'dd' => $dd,
            'mm' => $mm,
            'yy' => $yy,
            'al' => $al,
            'canChi' => $canChi,
            'weekday' => $thu, // Thứ trong tháng
            'ngaySuatHanh' => $ngaySuatHanh, // Ngày xuất hành
            'ngaySuatHanhHTML' => $ngaySuatHanhHTML, // HTML cho ngày xuất hành
            'gioHd' => $gioHd, // Giờ hoàng đạo
            'tietkhi' => $tietkhi, // Tiết khí
            'table_html' => $table_html, // HTML cho bảng lịch
            'data_totxau' => $data_totxau, // Dữ liệu tốt xấu
            'noiKhiNgay' => $noiKhiNgay,
            'banhToCan' => $banhToCan, //giải thích ngày theo Bành Tổ Bách Kỵ
            'banhToChi' => $banhToChi, //giải thích ngày theo Bành Tổ Bách Kỵ
            'chiNgay' => $chiNgay,
            'amToday' => $amToday,
            
            'khongMinhLucDieu' => $khongMinhLucDieu, // lịch khổng minh lục diệu
            'getDetailedGioHoangDao' => $getDetailedGioHoangDao,
            'getThongTinXuatHanhVaLyThuanPhong' => $getThongTinXuatHanhVaLyThuanPhong,//Hướng xuất hành và giờ xuất hành lý thuần phong
            'getThongTinTruc' => $getThongTinTruc,
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon, //Lấy thông tin ngày và icon
            'nhiThapBatTu' => $nhiThapBatTu, //THoong tin nhị thập bát tú
            'getSaoTotXauInfo' => $getSaoTotXauInfo, //Ngọc hạp thông thư
            'getThongTinNgay' => $getThongTinNgay, //Tổng quan ngày
            'getDaySummaryInfo' => $getDaySummaryInfo

        ]);
    }

    // Hàm kiểm tra ngày hợp lệ theo định dạng
   
   
}
