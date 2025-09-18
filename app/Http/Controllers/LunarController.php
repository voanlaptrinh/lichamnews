<?php

namespace App\Http\Controllers;

use App\Helpers\BadDayHelper;
use App\Helpers\CatHungHelper;
use App\Helpers\DataHelper;
use App\Helpers\FengShuiHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GioHoangDaoHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LichKhongMinhHelper;

use App\Helpers\LunarHelper;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Jetfuel\SolarLunar\Solar;
use Jetfuel\SolarLunar\Lunar;
use Jetfuel\SolarLunar\SolarLunar;

class LunarController extends Controller
{


    /**
     * Trang chủ, hiển thị thông tin cho ngày hiện tại hoặc ngày được chọn từ form.
     */
    public function index(Request $request)
    {
        // Mặc định là ngày hiện tại nếu không có input
        $yy = date('Y');
        $mm = date('m');
        $dd = date('d');

        $cdate = $request->input('cdate'); // Lấy ngày từ form (định dạng Y-m-d)

        // Nếu người dùng chọn ngày từ form, cập nhật lại ngày tháng năm
        if (FunctionHelper::validateDate($cdate, 'Y-m-d')) {
            list($yy, $mm, $dd) = explode('-', $cdate);
        }

        // Lấy ngày sinh (nếu có) để tính toán bổ sung
        $birthdate = $request->input('birthdate');

        // Gọi phương thức xử lý chung và trả về view
        return $this->processAndRenderLunarData($dd, $mm, $yy, $birthdate);
    }

    /**
     * Hiển thị thông tin cho một ngày cụ thể từ URL.
     * Route: /am-lich/nam/{yy}/thang/{mm}/ngay/{dd}
     */
    public function ngay(Request $request, $yy, $mm, $dd)
    {
        // --- VALIDATION ---
        // Kiểm tra xem ngày, tháng, năm từ URL có hợp lệ không
        if (!checkdate((int)$mm, (int)$dd, (int)$yy)) {
            // Nếu không hợp lệ, trả về lỗi 404 Not Found
            abort(404, 'Ngày bạn yêu cầu không tồn tại.');
        }

        // Lấy ngày sinh (nếu có) từ query string, ví dụ: /am-lich/...?birthdate=...
        $birthdate = $request->input('birthdate');

        // Gọi phương thức xử lý chung và trả về view
        return $this->processAndRenderLunarData($dd, $mm, $yy, $birthdate);
    }

    /**
     * Phương thức private để xử lý logic tính toán và render view.
     * Phương thức này được gọi bởi cả index() và ngay().
     *
     * @param string|int $dd Ngày
     * @param string|int $mm Tháng
     * @param string|int $yy Năm
     * @param string|null $birthdate Ngày sinh (tùy chọn)
     * @return \Illuminate\View\View
     */
    private function processAndRenderLunarData($dd, $mm, $yy, $birthdate = null)
    {
        // Ép kiểu để đảm bảo là số nguyên
        $dd = (int)$dd;
        $mm = (int)$mm;
        $yy = (int)$yy;

        // Tạo chuỗi ngày Y-m-d từ các tham số để truyền cho view
        $cdate = sprintf('%04d-%02d-%02d',  $yy, $mm, $dd);

        // --- Bắt đầu toàn bộ logic tính toán (giữ nguyên từ hàm index cũ) ---

        // Chuyển từ Dương lịch sang Âm lịch
        $al = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);

        // Tính Can Chi của ngày
        $jd = LunarHelper::jdFromDate($dd, $mm, $yy);
        $canChi = LunarHelper::canchiNgayByJD($jd);
        $chiNgay = explode(' ', $canChi);

        $chi_ngay = @$chiNgay[1];
        $gioHd = LunarHelper::gioHDTrongNgayTXT($chi_ngay);
        $thu = LunarHelper::sw_get_weekday($cdate);

        $ngaySuatHanh = LichKhongMinhHelper::numToNgay($al[1], $al[0]);
        $ngaySuatHanhHTML = LichKhongMinhHelper::ngayToHTML($ngaySuatHanh);

        $tietkhi = LunarHelper::tietKhiWithIcon($jd);
        list($table_html, $data_totxau) = LunarHelper::printTable($mm, $yy, true, true, false, $dd);

        // =========================================================
        // ===  LOGIC LỌC VÀ LẤY SỰ KIỆN CHO NGÀY ĐANG XEM  ===
        // =========================================================

        // Khởi tạo các mảng riêng cho sự kiện dương lịch và âm lịch
        $suKienDuongLich = [];
        $suKienAmLich = [];

        // 1. Xử lý sự kiện DƯƠNG LỊCH
        // Lấy tất cả sự kiện DƯƠNG LỊCH trong tháng từ Helper
        $suKienTrongThangDuong = LunarHelper::getVietnamEvent($mm, $yy);

        // Bây giờ, kiểm tra xem ngày DƯƠNG LỊCH hiện tại ($dd) có tồn tại
        // như một key trong danh sách sự kiện của tháng không.
        if (isset($suKienTrongThangDuong[$dd])) {
            // Nếu có, thêm sự kiện của ngày đó vào mảng sự kiện dương lịch
            $suKienDuongLich[] = $suKienTrongThangDuong[$dd];
        }

        // 2. Xử lý sự kiện ÂM LỊCH (tương tự)
        // Lấy tất cả sự kiện ÂM LỊCH trong tháng từ Helper
        // Giả sử $al[0] là ngày âm, $al[1] là tháng âm
        $suKienTrongThangAm = LunarHelper::getVietnamLunarEvent2($al[1], $al[2]);
        // dd($suKienTrongThangAm);
        // Kiểm tra xem ngày ÂM LỊCH hiện tại ($al[0]) có trong danh sách không
        if (isset($suKienTrongThangAm[$al[0]])) {
            // Nếu có, thêm vào mảng sự kiện âm lịch
            $suKienAmLich[] = $suKienTrongThangAm[$al[0]];
        }

        // Tạo mảng tổng hợp (để tương thích với code cũ nếu cần)
        $suKienHomNay = array_merge($suKienDuongLich, $suKienAmLich);

        // =========================================================
        // ===  KẾT THÚC LOGIC LỌC SỰ KIỆN  ===
        // =========================================================

        // Lấy sao tốt xấu theo ngọc Hạp thông thư
        $getSaoTotXauInfo = FunctionHelper::getSaoTotXauInfo($dd, $mm, $yy);

        // Can chi tháng năm
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dd, $mm, $yy);

        // Tổng quan ngày
        $getThongTinNgay = FunctionHelper::getThongTinNgay($dd, $mm, $yy);

        // Nội khí ngày
        $noiKhiNgay =  KhiVanHelper::getDetailedNoiKhiExplanation($dd, $mm, $yy);

        // Nhị thập bát tú
        $nhiThapBatTu = FunctionHelper::nhiThapBatTu($yy, $mm, $dd);

        // THập Nhị Trực 
        $getThongTinTruc = FunctionHelper::getThongTinTruc($dd, $mm, $yy);

        // Khổng minh lục diệu
        $khongMinhLucDieu = LichKhongMinhHelper::getKhongMinhLucDieuDayInfo($dd, $mm, $yy);

        // Giải thích ngày theo Bành Tổ Bách Kỵ
        $banhToCan = DataHelper::$banhToCanTaboos[$chiNgay[0]];
        $banhToChi = DataHelper::$banhToChiTaboos[$chiNgay[1]];

        // Hướng xuất hành và giờ xuất hành lý thuần phong
        $getThongTinXuatHanhVaLyThuanPhong = FunctionHelper::getThongTinXuatHanhVaLyThuanPhong($dd, $mm, $yy);

        // Giờ hoàng đạo
        $getDetailedGioHoangDao = GioHoangDaoHelper::getDetailedGioHoangDao($dd, $mm, $yy);

        $amToday = sprintf('%04d-%02d-%02d', $al[2], $al[1], $al[0]);
        $getDaySummaryInfo = FunctionHelper::getDaySummaryInfo($dd, $mm, $yy, $birthdate);

        $upcomingEvents = [];
        $currentCarbonDate = Carbon::create($yy, $mm, $dd)->startOfDay();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = Carbon::create($yy, $mm, $dd)->addMonthsNoOverflow($i);
            $solarMonthToCheck = $solarDateToCheck->month;
            $solarYearToCheck = $solarDateToCheck->year;

            // Lấy sự kiện dương lịch
            $eventsSolar = LunarHelper::getVietnamEvent($solarMonthToCheck, $solarYearToCheck);
            foreach ($eventsSolar as $eventDay => $eventDescription) {
                $eventCarbon = Carbon::create($solarYearToCheck, $solarMonthToCheck, $eventDay)->startOfDay();
                // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                    $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                    $upcomingEvents[] = [
                        'date' => $eventCarbon->format('Y-m-d'),
                        'description' => $eventDescription . " (Dương lịch)",
                        'days_remaining' => $daysRemaining,
                        'type' => 'solar',
                    ];
                }
            }

            // Chuyển đổi tháng dương lịch hiện tại thành tháng âm lịch tương ứng
            // (Đây là một cách ước tính đơn giản, có thể không hoàn hảo khi có tháng nhuận hoặc thay đổi đầu năm âm lịch)
            $tempLunar = LunarHelper::convertSolar2Lunar(1, $solarMonthToCheck, $solarYearToCheck);
            $lunarMonthToCheck = $tempLunar[1];
            $lunarYearToCheck = $tempLunar[2];
            $lunarLeap = $tempLunar[3];

            // Lấy sự kiện âm lịch
            $eventsLunar = LunarHelper::getVietnamLunarEvent2($lunarMonthToCheck, $lunarYearToCheck);
            foreach ($eventsLunar as $lunarEventDay => $eventDescription) {
                // Chuyển đổi ngày âm lịch sang ngày dương lịch để so sánh
                $solarEquivalent = LunarHelper::convertLunar2Solar($lunarEventDay,  $lunarMonthToCheck, $lunarYearToCheck, $lunarLeap);
                if ($solarEquivalent) {
                    $eventCarbon = Carbon::create($solarEquivalent[2], $solarEquivalent[1], $solarEquivalent[0])->startOfDay();
                    // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                    if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                        $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                        $upcomingEvents[] = [
                            'date' => $eventCarbon->format('Y-m-d'),
                            'description' => $eventDescription['ten_su_kien'] . " (Âm lịch)",
                            'days_remaining' => $daysRemaining,
                            'type' => 'lunar',
                        ];
                    }
                }
            }
        }

        // Lọc bỏ các sự kiện trùng lặp (ví dụ, nếu một sự kiện dương lịch và âm lịch rơi vào cùng một ngày dương lịch và có cùng mô tả)
        // Và sắp xếp các sự kiện theo ngày tăng dần, sau đó lọc các sự kiện có số ngày còn lại > 0
        usort($upcomingEvents, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Lọc các sự kiện có days_remaining = 0 nếu bạn không muốn hiển thị lại sự kiện của chính ngày hôm nay ở mục sắp tới
        $upcomingEvents = array_filter($upcomingEvents, function ($event) {
            return $event['days_remaining'] > 0;
        });

        // Giới hạn số lượng sự kiện sắp tới hiển thị (tùy chọn)
        $upcomingEvents = array_slice($upcomingEvents, 0, 5);

        // =========================================================
        // ===  KẾT THÚC LOGIC LẤY SỰ KIỆN SẮP TỚI  ===
        // =========================================================

        $currentDate = Carbon::create($yy, $mm, 1);
        // Tính toán tháng trước
        $prevDate = $currentDate->copy()->subMonth();
        $prevYear = $prevDate->year;
        $prevMonth = $prevDate->month;

        // Tính toán tháng sau
        $nextDate = $currentDate->copy()->addMonth();
        $nextYear = $nextDate->year;
        $nextMonth = $nextDate->month;
        $tot_xau_result = LunarHelper::checkTotXau($canChi, $al[1]);
        $startDate = Carbon::createFromDate((int)$yy, (int)$mm, (int)$dd);
        $labels = [];
        $dataValues = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $day   = (int)$date->day;
            $month = (int)$date->month;
            $year  = (int)$date->year;

            // gọi hàm lấy điểm
            $info = FunctionHelper::getDaySummaryInfo($day, $month, $year, $birthdate);

            // giả sử trong $info có trường 'score'
            $labels[] = $date->format('d/m');
            $dataValues[] = $info['score']['percentage'];
        }
        // Trả về view với đầy đủ dữ liệu
        return view('lunar.convert', [
            'cdate' => $cdate, // Ngày đang xem, định dạng Y-m-d
            'dd' => sprintf('%02d', $dd), // Thêm số 0 ở đầu nếu cần
            'mm' => sprintf('%02d', $mm),

            // Các biến mới cho việc điều hướng
            'prevYear' => $prevYear,
            'prevMonth' => $prevMonth,
            'nextYear' => $nextYear,
            'nextMonth' => $nextMonth,
            'tot_xau_result' => $tot_xau_result,
            'yy' => $yy,
            'al' => $al,
            'canChi' => $canChi,
            'weekday' => $thu,
            'ngaySuatHanh' => $ngaySuatHanh,
            'ngaySuatHanhHTML' => $ngaySuatHanhHTML,
            'gioHd' => $gioHd,
            'tietkhi' => $tietkhi,
            'table_html' => $table_html,
            'data_totxau' => $data_totxau,
            'noiKhiNgay' => $noiKhiNgay,
            'banhToCan' => $banhToCan,
            'banhToChi' => $banhToChi,
            'chiNgay' => $chiNgay,
            'amToday' => $amToday,
            'khongMinhLucDieu' => $khongMinhLucDieu,
            'getDetailedGioHoangDao' => $getDetailedGioHoangDao,
            'getThongTinXuatHanhVaLyThuanPhong' => $getThongTinXuatHanhVaLyThuanPhong,
            'getThongTinTruc' => $getThongTinTruc,
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
            'nhiThapBatTu' => $nhiThapBatTu,
            'getSaoTotXauInfo' => $getSaoTotXauInfo,
            'getThongTinNgay' => $getThongTinNgay,
            'getDaySummaryInfo' => $getDaySummaryInfo,
            // Thêm birthdate để hiển thị lại trên form nếu có
            'birthdate' => $birthdate,
            'suKienHomNay' => $suKienHomNay,
            'suKienDuongLich' => $suKienDuongLich, // Sự kiện dương lịch riêng
            'suKienAmLich' => $suKienAmLich, // Sự kiện âm lịch riêng
            'upcomingEvents' => $upcomingEvents, // Thêm biến mới này
            'labels' => $labels,
            'dataValues' => $dataValues,
        ]);
    }


    public function detail(Request $request, $yy, $mm, $dd)
    {
        // 1. Validate the date from URL parameters first
        // (Cast to int here to ensure checkdate works correctly)
        if (!checkdate((int)$mm, (int)$dd, (int)$yy)) {
            abort(404, 'Ngày bạn yêu cầu không tồn tại.');
        }

        // 2. Store the original URL date components as integers (good practice)
        $effective_yy = (int)$yy;
        $effective_mm = (int)$mm;
        $effective_dd = (int)$dd;

        // 3. Try to get 'cdate' from the request body/query
        $requestCdateInput = $request->input('cdate');

        // 4. If 'cdate' is provided in the request and is valid, it should override the URL date.
        if (FunctionHelper::validateDate($requestCdateInput, 'Y-m-d')) {
            $cdate_info = explode('-', $requestCdateInput);

            // Re-validate the potentially overwritten date string to ensure it's a real date
            // (e.g., prevent '2023-02-30' from being accepted)
            if (checkdate((int)$cdate_info[1], (int)$cdate_info[2], (int)$cdate_info[0])) {
                $effective_yy = (int)$cdate_info[0];
                $effective_mm = (int)$cdate_info[1];
                $effective_dd = (int)$cdate_info[2];
            }
            // If requestCdateInput was invalid, effective_yy/mm/dd will remain the URL date.
        }
        // If no 'cdate' in request or it's not valid, effective_yy/mm/dd will already be the URL date.

        // 5. Update the main $yy, $mm, $dd variables to the final effective date
        $yy = $effective_yy;
        $mm = $effective_mm;
        $dd = $effective_dd;

        // 6. NOW, construct $cdate from these final $yy, $mm, $dd.
        // This ensures $cdate always holds the string representation of the date being processed.
        $cdate = sprintf('%04d-%02d-%02d', $yy, $mm, $dd);

        // All subsequent calculations will use these final $yy, $mm, $dd (and $cdate)
        $birthdate = $request->input('birthdate'); // birthdate is still taken directly from request


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
        list($table_html, $data_totxau) = LunarHelper::printTable($mm, $yy, true, true, false, $dd);

        //Lấy sao tốt xấu theo ngọc Hạp thông thư
        $getSaoTotXauInfo = FunctionHelper::getSaoTotXauInfo($dd, $mm, $yy);

        $hoangDaoStars = [];
        foreach ($getSaoTotXauInfo['sao_tot'] as $starName => $starDescription) {
            if (str_contains($starName, 'Hoàng Đạo')) {
                $hoangDaoStars[$starName] = $starDescription;
            }
        }

        $hacDaoStars = [];
        foreach ($getSaoTotXauInfo['sao_xau'] as $starName => $starDescription) {
            if (str_contains($starName, 'Hắc Đạo')) {
                $hacDaoStars[$starName] = $starDescription;
            }
        }
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
        $khongMinhLucDieu = LichKhongMinhHelper::getKhongMinhLucDieuDayInfo($dd, $mm, (int)$yy);
        //end khổng minh lục diệu

        //giải thích ngày theo Bành Tổ Bách Kỵ
        $banhToCan = DataHelper::$banhToCanTaboos[$chiNgay[0]];
        $banhToChi = DataHelper::$banhToChiTaboos[$chiNgay[1]];
        //end

        //Hướng xuất hành và giờ xuất hành lý thuần phong
        $getThongTinXuatHanhVaLyThuanPhong = FunctionHelper::getThongTinXuatHanhVaLyThuanPhong($dd, $mm, (int)$yy);
        //------End------//

        //------Giờ hoàng đạo-------//
        $getDetailedGioHoangDao = GioHoangDaoHelper::getDetailedGioHoangDao((int)$dd, (int)$mm, (int)$yy);
        //end giờ hoàng đạo

        $amToday = sprintf('%04d-%02d-%02d', $al[2], $al[1], $al[0]);

        $getDaySummaryInfo = FunctionHelper::getDaySummaryInfo((int)$dd, (int)$mm, (int)$yy, $birthdate);

        $suKienDuongLich = [];
        $suKienAmLich = [];
        $suKienTrongThangDuong = LunarHelper::getVietnamEvent($mm, $yy);
        if (isset($suKienTrongThangDuong[$dd])) {
            $suKienDuongLich[] = $suKienTrongThangDuong[$dd];
        }
        $suKienTrongThangAm = LunarHelper::getVietnamLunarEvent2($al[1], $al[2]);
        if (isset($suKienTrongThangAm[$al[0]])) {
            $suKienAmLich[] = $suKienTrongThangAm[$al[0]];
        }
        $suKienHomNay = array_merge($suKienDuongLich, $suKienAmLich);

        $tot_xau_result = LunarHelper::checkTotXau($canChi, $al[1]);

        $dateToCheck = Carbon::create($yy, $mm, $dd);
        $getVongKhiNgayThang = KhiVanHelper::getDetailedKhiThangInfo($dateToCheck);
        $getCucKhiHopXung = FengShuiHelper::getCucKhiHopXung($chiNgay[1]);
        $checkBadDays = BadDayHelper::checkBadDays($dateToCheck);


        $startDate = Carbon::createFromDate((int)$yy, (int)$mm, (int)$dd);

        // mảng dữ liệu cho chart
        $labels = [];
        $dataValues = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $day   = (int)$date->day;
            $month = (int)$date->month;
            $year  = (int)$date->year;

            // gọi hàm lấy điểm
            $info = FunctionHelper::getDaySummaryInfo($day, $month, $year, $birthdate);

            // giả sử trong $info có trường 'score'
            $labels[] = $date->format('d/m');
            $dataValues[] = $info['score']['percentage'];
        }

         $upcomingEvents = [];
        $currentCarbonDate = Carbon::create($yy, $mm, $dd)->startOfDay();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = Carbon::create($yy, $mm, $dd)->addMonthsNoOverflow($i);
            $solarMonthToCheck = $solarDateToCheck->month;
            $solarYearToCheck = $solarDateToCheck->year;

            // Lấy sự kiện dương lịch
            $eventsSolar = LunarHelper::getVietnamEvent($solarMonthToCheck, $solarYearToCheck);
            foreach ($eventsSolar as $eventDay => $eventDescription) {
                $eventCarbon = Carbon::create($solarYearToCheck, $solarMonthToCheck, $eventDay)->startOfDay();
                // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                    $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                    $upcomingEvents[] = [
                        'date' => $eventCarbon->format('Y-m-d'),
                        'description' => $eventDescription . " (Dương lịch)",
                        'days_remaining' => $daysRemaining,
                        'type' => 'solar',
                    ];
                }
            }

            // Chuyển đổi tháng dương lịch hiện tại thành tháng âm lịch tương ứng
            // (Đây là một cách ước tính đơn giản, có thể không hoàn hảo khi có tháng nhuận hoặc thay đổi đầu năm âm lịch)
            $tempLunar = LunarHelper::convertSolar2Lunar(1, $solarMonthToCheck, $solarYearToCheck);
            $lunarMonthToCheck = $tempLunar[1];
            $lunarYearToCheck = $tempLunar[2];
            $lunarLeap = $tempLunar[3];

            // Lấy sự kiện âm lịch
            $eventsLunar = LunarHelper::getVietnamLunarEvent2($lunarMonthToCheck, $lunarYearToCheck);
            foreach ($eventsLunar as $lunarEventDay => $eventDescription) {
                // Chuyển đổi ngày âm lịch sang ngày dương lịch để so sánh
                $solarEquivalent = LunarHelper::convertLunar2Solar($lunarEventDay,  $lunarMonthToCheck, $lunarYearToCheck, $lunarLeap);
                if ($solarEquivalent) {
                    $eventCarbon = Carbon::create($solarEquivalent[2], $solarEquivalent[1], $solarEquivalent[0])->startOfDay();
                    // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                    if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                        $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                        $upcomingEvents[] = [
                            'date' => $eventCarbon->format('Y-m-d'),
                            'description' => $eventDescription['ten_su_kien'] . " (Âm lịch)",
                            'days_remaining' => $daysRemaining,
                            'type' => 'lunar',
                        ];
                    }
                }
            }
        }

        // Lọc bỏ các sự kiện trùng lặp (ví dụ, nếu một sự kiện dương lịch và âm lịch rơi vào cùng một ngày dương lịch và có cùng mô tả)
        // Và sắp xếp các sự kiện theo ngày tăng dần, sau đó lọc các sự kiện có số ngày còn lại > 0
        usort($upcomingEvents, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Lọc các sự kiện có days_remaining = 0 nếu bạn không muốn hiển thị lại sự kiện của chính ngày hôm nay ở mục sắp tới
        $upcomingEvents = array_filter($upcomingEvents, function ($event) {
            return $event['days_remaining'] > 0;
        });

        // Giới hạn số lượng sự kiện sắp tới hiển thị (tùy chọn)
        $upcomingEvents = array_slice($upcomingEvents, 0, 5);
        // dd($checkBadDays);
        return view('lunar.detail', [
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
            'tot_xau_result' => $tot_xau_result,
            'suKienHomNay' => $suKienHomNay, // Tổng hợp (để tương thích với code cũ)
            'suKienDuongLich' => $suKienDuongLich, // Sự kiện dương lịch riêng
            'suKienAmLich' => $suKienAmLich, // Sự kiện âm lịch riêng
            'khongMinhLucDieu' => $khongMinhLucDieu, // lịch khổng minh lục diệu
            'getDetailedGioHoangDao' => $getDetailedGioHoangDao,
            'getThongTinXuatHanhVaLyThuanPhong' => $getThongTinXuatHanhVaLyThuanPhong, //Hướng xuất hành và giờ xuất hành lý thuần phong
            'getThongTinTruc' => $getThongTinTruc,
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon, //Lấy thông tin ngày và icon
            'nhiThapBatTu' => $nhiThapBatTu, //THoong tin nhị thập bát tú
            'getSaoTotXauInfo' => $getSaoTotXauInfo, //Ngọc hạp thông thư
            'getThongTinNgay' => $getThongTinNgay, //Tổng quan ngày
            'getDaySummaryInfo' => $getDaySummaryInfo,
            'getVongKhiNgayThang' => $getVongKhiNgayThang,
            'getCucKhiHopXung' => $getCucKhiHopXung,
            'checkBadDays' => $checkBadDays,
            'labels' => $labels,
            'dataValues' => $dataValues,
            'hoangDaoStars' => $hoangDaoStars,
            'hacDaoStars' => $hacDaoStars,
            'upcomingEvents' => $upcomingEvents,

        ]);
    }

    public function convertAmToDuong(Request $request)
    {
        $metaTitle = 'Đổi lịch âm dương ' . date('Y') . ' | Chuyển đổi ngày âm sang dương, dương sang âm';
        $metaDescription = "Công cụ đổi lịch âm dương " . date('Y') . " chính xác nhất. Chuyển đổi nhanh ngày âm sang dương, dương sang âm. Xem lịch vạn niên, ngày tốt xấu, ngày hoàng đạo hôm nay.";


        $solar_date = $request->input('solar_date');

        // Mặc định sử dụng ngày hôm nay
        $dd = (int)date('d');
        $mm = (int)date('m');
        $yy = (int)date('Y');

        if ($solar_date) {
            // Tách ngày tháng năm từ format dd/mm/yyyy
            $parts = explode('/', $solar_date);
            if (count($parts) === 3) {
                $dd = (int)$parts[0];
                $mm = (int)$parts[1];
                $yy = (int)$parts[2];

                // Validate ngày tháng năm
                if (!checkdate($mm, $dd, $yy)) {
                    // Nếu không hợp lệ, dùng ngày hôm nay
                    $dd = (int)date('d');
                    $mm = (int)date('m');
                    $yy = (int)date('Y');
                }
            }
        }
         if (!$yy || $yy < 1900 || $yy > 2100 || !$mm || $mm < 1 || $mm > 12) {
            return back()->withErrors(['solar_date' => 'Vui lòng nhập ngày dương lịch hợp lệ.']);
        }
        $al = LunarHelper::convertSolar2Lunar((int)$dd, (int)$mm, (int)$yy);
        $jd = LunarHelper::jdFromDate($dd, $mm, $yy);
        $canChi = LunarHelper::canchiNgayByJD($jd);
        $chiNgay = explode(' ', $canChi);
        $cdate = sprintf('%04d-%02d-%02d',  $yy, $mm, $dd);
        $thu = LunarHelper::sw_get_weekday($cdate);
        $chi_ngay = @$chiNgay[1];
        $gioHd = LunarHelper::gioHDTrongNgayTXT($chi_ngay);


        // $ngaySuatHanh = LichKhongMinhHelper::numToNgay($al[1], $al[0]);
        // $ngaySuatHanhHTML = LichKhongMinhHelper::ngayToHTML($ngaySuatHanh);

        $tietkhi = LunarHelper::tietKhiWithIcon($jd);
        list($table_html, $data_totxau) = LunarHelper::printTable($mm, $yy, true, true, false, $dd);
        $getThongTinNgay = FunctionHelper::getThongTinNgay($dd, $mm, $yy);
        $suKienDuongLich = [];
        $suKienAmLich = [];

        // 1. Xử lý sự kiện DƯƠNG LỊCH
        // Lấy tất cả sự kiện DƯƠNG LỊCH trong tháng từ Helper
        $suKienTrongThangDuong = LunarHelper::getVietnamEvent($mm, $yy);

        // Bây giờ, kiểm tra xem ngày DƯƠNG LỊCH hiện tại ($dd) có tồn tại
        // như một key trong danh sách sự kiện của tháng không.
        if (isset($suKienTrongThangDuong[$dd])) {
            // Nếu có, thêm sự kiện của ngày đó vào mảng sự kiện dương lịch
            $suKienDuongLich[] = $suKienTrongThangDuong[$dd];
        }

        // 2. Xử lý sự kiện ÂM LỊCH (tương tự)
        // Lấy tất cả sự kiện ÂM LỊCH trong tháng từ Helper
        // Giả sử $al[0] là ngày âm, $al[1] là tháng âm
        $suKienTrongThangAm = LunarHelper::getVietnamLunarEvent2($al[1], $al[2]);
        // dd($suKienTrongThangAm);
        // Kiểm tra xem ngày ÂM LỊCH hiện tại ($al[0]) có trong danh sách không
        if (isset($suKienTrongThangAm[$al[0]])) {
            // Nếu có, thêm vào mảng sự kiện âm lịch
            $suKienAmLich[] = $suKienTrongThangAm[$al[0]];
        }
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dd, $mm, $yy);
        $currentDate = Carbon::create($yy, $mm, 1);
        // Tính toán tháng trước
        $prevDate = $currentDate->copy()->subMonth();
        $prevYear = $prevDate->year;
        $prevMonth = $prevDate->month;

        // Tính toán tháng sau
        $nextDate = $currentDate->copy()->addMonth();
        $nextYear = $nextDate->year;
        $nextMonth = $nextDate->month;
        $tot_xau_result = LunarHelper::checkTotXau($canChi, $al[1]);
        $upcomingEvents = [];
        $currentCarbonDate = Carbon::create($yy, $mm, $dd)->startOfDay();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = Carbon::create($yy, $mm, $dd)->addMonthsNoOverflow($i);
            $solarMonthToCheck = $solarDateToCheck->month;
            $solarYearToCheck = $solarDateToCheck->year;

            // Lấy sự kiện dương lịch
            $eventsSolar = LunarHelper::getVietnamEvent($solarMonthToCheck, $solarYearToCheck);
            foreach ($eventsSolar as $eventDay => $eventDescription) {
                $eventCarbon = Carbon::create($solarYearToCheck, $solarMonthToCheck, $eventDay)->startOfDay();
                // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                    $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                    $upcomingEvents[] = [
                        'date' => $eventCarbon->format('Y-m-d'),
                        'description' => $eventDescription . " (Dương lịch)",
                        'days_remaining' => $daysRemaining,
                        'type' => 'solar',
                    ];
                }
            }

            // Chuyển đổi tháng dương lịch hiện tại thành tháng âm lịch tương ứng
            // (Đây là một cách ước tính đơn giản, có thể không hoàn hảo khi có tháng nhuận hoặc thay đổi đầu năm âm lịch)
            $tempLunar = LunarHelper::convertSolar2Lunar(1, $solarMonthToCheck, $solarYearToCheck);
            $lunarMonthToCheck = $tempLunar[1];
            $lunarYearToCheck = $tempLunar[2];
            $lunarLeap = $tempLunar[3];

            // Lấy sự kiện âm lịch
            $eventsLunar = LunarHelper::getVietnamLunarEvent2($lunarMonthToCheck, $lunarYearToCheck);
            foreach ($eventsLunar as $lunarEventDay => $eventDescription) {
                // Chuyển đổi ngày âm lịch sang ngày dương lịch để so sánh
                $solarEquivalent = LunarHelper::convertLunar2Solar($lunarEventDay,  $lunarMonthToCheck, $lunarYearToCheck, $lunarLeap);
                if ($solarEquivalent) {
                    $eventCarbon = Carbon::create($solarEquivalent[2], $solarEquivalent[1], $solarEquivalent[0])->startOfDay();
                    // Chỉ lấy sự kiện từ ngày hiện tại trở đi
                    if ($eventCarbon->greaterThanOrEqualTo($currentCarbonDate)) {
                        $daysRemaining = $eventCarbon->diffInDays($currentCarbonDate);
                        $upcomingEvents[] = [
                            'date' => $eventCarbon->format('Y-m-d'),
                            'description' => $eventDescription['ten_su_kien'] . " (Âm lịch)",
                            'days_remaining' => $daysRemaining,
                            'type' => 'lunar',
                        ];
                    }
                }
            }
        }

        // Lọc bỏ các sự kiện trùng lặp (ví dụ, nếu một sự kiện dương lịch và âm lịch rơi vào cùng một ngày dương lịch và có cùng mô tả)
        // Và sắp xếp các sự kiện theo ngày tăng dần, sau đó lọc các sự kiện có số ngày còn lại > 0
        usort($upcomingEvents, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Lọc các sự kiện có days_remaining = 0 nếu bạn không muốn hiển thị lại sự kiện của chính ngày hôm nay ở mục sắp tới
        $upcomingEvents = array_filter($upcomingEvents, function ($event) {
            return $event['days_remaining'] > 0;
        });

        // Giới hạn số lượng sự kiện sắp tới hiển thị (tùy chọn)
        $upcomingEvents = array_slice($upcomingEvents, 0, 10);
        return view(
            'lunar.doi-lich',
            [
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'dd' => sprintf('%02d', $dd),
                'mm' => sprintf('%02d', $mm),
                'yy' => $yy,
                'weekday' => $thu,
                'al' => $al,
                'tietkhi' => $tietkhi,
                'getThongTinNgay' => $getThongTinNgay,
                'table_html' => $table_html,
                'suKienDuongLich' => $suKienDuongLich,
                'suKienAmLich' => $suKienAmLich,
                'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
                'prevYear' => $prevYear,
                'prevMonth' => $prevMonth,
                'nextYear' => $nextYear,
                'nextMonth' => $nextMonth,
                'tot_xau_result' => $tot_xau_result,
                'upcomingEvents' => $upcomingEvents,

            ]
        );
    }
}
