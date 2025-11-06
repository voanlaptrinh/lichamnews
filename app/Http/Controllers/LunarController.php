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
        // Luôn tính từ ngày hiện tại thay vì từ ngày được chọn
        $currentCarbonDate = Carbon::today();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = $currentCarbonDate->copy()->addMonthsNoOverflow($i);
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
        // Luôn bắt đầu từ ngày hôm nay, không phụ thuộc vào ngày đã chọn
        $startDate = Carbon::today();
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
            // Ngày đầu tiên hiển thị "Hôm nay", các ngày khác hiển thị dd/mm
            if ($i === 0) {
                $labels[] = 'Hôm nay';
            } else {
                $labels[] = $date->format('d/m');
            }
            $dataValues[] = round($info['score']['percentage']);
        }
        // Trả về view với đầy đủ dữ liệu
        return view('lunar.convert', [
            'cdate' => $cdate, // Ngày đang xem, định dạng Y-m-d
            'dd' => (int)$dd, // Không thêm số 0 ở đầu
            'mm' => (int)$mm,

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




    public function getDateDataAjax(Request $request)
    {
        $yy = $request->input('yy');
        $mm = $request->input('mm');
        $dd = $request->input('dd');
        $birthdate = null;
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
        // Luôn tính từ ngày hiện tại thay vì từ ngày được chọn
        $currentCarbonDate = Carbon::today();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = $currentCarbonDate->copy()->addMonthsNoOverflow($i);
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
        // Luôn bắt đầu từ ngày hôm nay, không phụ thuộc vào ngày đã chọn
        $startDate = Carbon::today();
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
            // Ngày đầu tiên hiển thị "Hôm nay", các ngày khác hiển thị dd/mm
            if ($i === 0) {
                $labels[] = 'Hôm nay';
            } else {
                $labels[] = $date->format('d/m');
            }
            $dataValues[] = round($info['score']['percentage']);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'cdate' => $cdate,
                'dd' => (int)$dd,
                'mm' => (int)$mm,
                'yy' => $yy,
                'weekday' => $thu,
                'al' => $al,
                'canChi' => $canChi,
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
                'suKienDuongLich' => $suKienDuongLich,
                'suKienAmLich' => $suKienAmLich,
                'tot_xau_result' => $tot_xau_result,
                'labels' => $labels,
                'dataValues' => $dataValues,
            ]
        ]);
    }

    public function convertAmToDuong(Request $request)
    {
        $metaTitle = 'Đổi Ngày Dương Sang Âm, Âm Sang Dương Online Chính Xác';
        $metaDescription = "Công cụ đổi ngày Âm sang Dương và Dương sang Âm chính xác. Tiện lợi cho việc tra cứu ngày âm dương khi cần tính toán ngày giỗ chạp, ngày sinh, hay tổ chức sự kiện.";


        $solar_date = $request->input('solar_date');
        $lunar_date = $request->input('lunar_date');
        $is_leap = $request->input('is_leap', 0); // Check if it's leap month

        // Mặc định sử dụng ngày hôm nay
        $dd = (int)date('d');
        $mm = (int)date('m');
        $yy = (int)date('Y');

        if ($lunar_date) {
            // Xử lý ngày âm lịch - chuyển đổi sang dương lịch
            $parts = explode('/', $lunar_date);
            if (count($parts) === 3) {
                $lunar_dd = (int)$parts[0];
                $lunar_mm = (int)$parts[1];
                $lunar_yy = (int)$parts[2];

                // Convert lunar to solar with leap month consideration
                $solar_result = LunarHelper::convertLunar2Solar($lunar_dd, $lunar_mm, $lunar_yy, (int)$is_leap);
                if ($solar_result && count($solar_result) >= 3) {
                    $dd = $solar_result[0];
                    $mm = $solar_result[1];
                    $yy = $solar_result[2];
                }
            }
        } elseif ($solar_date) {
            // Xử lý ngày dương lịch
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
        // Luôn tính từ ngày hiện tại thay vì từ ngày được chọn
        $currentCarbonDate = Carbon::today();
        $lookAheadMonths = 3; // Số tháng tiếp theo muốn tìm sự kiện

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            $solarDateToCheck = $currentCarbonDate->copy()->addMonthsNoOverflow($i);
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
        // Check if this is a leap month conversion
        $is_leap_month_selected = false;
        if ($lunar_date && (int)$is_leap) {
            $is_leap_month_selected = true;
        }

        return view(
            'lunar.doi-lich',
            [
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'dd' => (int)$dd,
                'mm' => (int)$mm,
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
                'is_leap_month_selected' => $is_leap_month_selected,
                'is_leap' => (int)$is_leap,
            ]
        );
    }
    private static function getUpcomingEvents($yy, $mm, $dd, $lookAheadMonths = 3)
    {
        $upcomingEvents = [];
        // Luôn tính từ ngày hiện tại thay vì từ ngày được chọn
        $currentCarbonDate = Carbon::today();

        for ($i = 0; $i <= $lookAheadMonths; $i++) {
            // Tìm sự kiện từ ngày hiện tại, không phải từ ngày được chọn
            $solarDateToCheck = $currentCarbonDate->copy()->addMonthsNoOverflow($i);
            $solarMonthToCheck = $solarDateToCheck->month;
            $solarYearToCheck = $solarDateToCheck->year;

            // Lấy sự kiện dương lịch
            $eventsSolar = LunarHelper::getVietnamEvent($solarMonthToCheck, $solarYearToCheck);
            foreach ($eventsSolar as $eventDay => $eventDescription) {
                $eventCarbon = Carbon::create($solarYearToCheck, $solarMonthToCheck, $eventDay)->startOfDay();
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

            // Lấy sự kiện âm lịch
            $tempLunar = LunarHelper::convertSolar2Lunar(1, $solarMonthToCheck, $solarYearToCheck);
            $lunarMonthToCheck = $tempLunar[1];
            $lunarYearToCheck = $tempLunar[2];
            $lunarLeap = $tempLunar[3];

            $eventsLunar = LunarHelper::getVietnamLunarEvent2($lunarMonthToCheck, $lunarYearToCheck);
            foreach ($eventsLunar as $lunarEventDay => $eventDescription) {
                $solarEquivalent = LunarHelper::convertLunar2Solar($lunarEventDay, $lunarMonthToCheck, $lunarYearToCheck, $lunarLeap);
                if ($solarEquivalent) {
                    $eventCarbon = Carbon::create($solarEquivalent[2], $solarEquivalent[1], $solarEquivalent[0])->startOfDay();
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

        // Sắp xếp và lọc
        usort($upcomingEvents, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        $upcomingEvents = array_filter($upcomingEvents, function ($event) {
            return $event['days_remaining'] > 0;
        });

        return array_slice($upcomingEvents, 0, 10);
    }
    public static function getDateInfo($dd, $mm, $yy, $birthdate = null, $titletodate = '', $metaTitle = '', $metaDescription = '')
    {
        // Chuẩn hóa input
        $dd = (int)$dd;
        $mm = (int)$mm;
        $yy = (int)$yy;

        // Validate date
        if (!checkdate($mm, $dd, $yy)) {
            throw new \InvalidArgumentException('Invalid date provided');
        }

        $cdate = sprintf('%04d-%02d-%02d', $yy, $mm, $dd);

        // Chuyển từ Dương lịch sang Âm lịch
        $al = LunarHelper::convertSolar2Lunar($dd, $mm, $yy);

        // Tính Can Chi của ngày
        $jd = LunarHelper::jdFromDate($dd, $mm, $yy);
        $canChi = LunarHelper::canchiNgayByJD($jd);
        $chi_ngay = explode(' ', $canChi);
        $chiNgay = $chi_ngay;
        $chi_ngay = @$chi_ngay[1];

        // Các thông tin cơ bản
        $gioHd = LunarHelper::gioHDTrongNgayTXT($chi_ngay);
        $thu = LunarHelper::sw_get_weekday($cdate);
        $tietkhi = LunarHelper::tietKhiWithIcon($jd);

        // Lịch tháng
        list($table_html, $data_totxau) = LunarHelper::printTable($mm, $yy, true, true, false, $dd);

        // Ngày xuất hành
        $ngaySuatHanh = LichKhongMinhHelper::numToNgay($al[1], $al[0]);
        $ngaySuatHanhHTML = LichKhongMinhHelper::ngayToHTML($ngaySuatHanh);

        // Các thông tin chi tiết
        $getSaoTotXauInfo = FunctionHelper::getSaoTotXauInfo($dd, $mm, $yy);

        // Tách sao hoàng đạo và hắc đạo
        $hoangDaoStars = [];
        $hacDaoStars = [];
        foreach ($getSaoTotXauInfo['sao_tot'] as $starName => $starDescription) {
            if (str_contains($starName, 'Hoàng Đạo')) {
                $hoangDaoStars[$starName] = $starDescription;
            }
        }
        foreach ($getSaoTotXauInfo['sao_xau'] as $starName => $starDescription) {
            if (str_contains($starName, 'Hắc Đạo')) {
                $hacDaoStars[$starName] = $starDescription;
            }
        }

        // Thông tin can chi và icons
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dd, $mm, $yy);

        // Tổng quan ngày
        $getThongTinNgay = FunctionHelper::getThongTinNgay($dd, $mm, $yy);

        // Nội khí ngày
        $noiKhiNgay = KhiVanHelper::getDetailedNoiKhiExplanation($dd, $mm, $yy);

        // Nhị thập bát tú
        $nhiThapBatTu = FunctionHelper::nhiThapBatTu($yy, $mm, $dd);

        // Thập nhị trực
        $getThongTinTruc = FunctionHelper::getThongTinTruc($dd, $mm, $yy);

        // Khổng minh lục diệu
        $khongMinhLucDieu = LichKhongMinhHelper::getKhongMinhLucDieuDayInfo($dd, $mm, $yy);

        // Bành tổ bách kỵ
        $banhToCan = DataHelper::$banhToCanTaboos[$chiNgay[0]];
        $banhToChi = DataHelper::$banhToChiTaboos[$chiNgay[1]];

        // Xuất hành và lý thuần phong
        $getThongTinXuatHanhVaLyThuanPhong = FunctionHelper::getThongTinXuatHanhVaLyThuanPhong($dd, $mm, $yy);

        // Giờ hoàng đạo
        $getDetailedGioHoangDao = GioHoangDaoHelper::getDetailedGioHoangDao($dd, $mm, $yy);

        // Thông tin điểm số ngày
        $getDaySummaryInfo = FunctionHelper::getDaySummaryInfo($dd, $mm, $yy, $birthdate);

        // Sự kiện dương lịch và âm lịch
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

        // Kiểm tra tốt xấu
        $tot_xau_result = LunarHelper::checkTotXau($canChi, $al[1]);

        // Vòng khí ngày tháng
        $dateToCheck = Carbon::create($yy, $mm, $dd);
        $getVongKhiNgayThang = KhiVanHelper::getDetailedKhiThangInfo($dateToCheck);
        $getCucKhiHopXung = FengShuiHelper::getCucKhiHopXung($chiNgay[1]);
        $checkBadDays = BadDayHelper::checkBadDays($dateToCheck);

        // Upcoming events
        $upcomingEvents = self::getUpcomingEvents($yy, $mm, $dd);

        return [

            // Dữ liệu cơ bản
            'cdate' => $cdate,
            'dd' => (int)$dd,
            'mm' => (int)$mm,
            'yy' => $yy,
            'weekday' => $thu,
            'al' => $al,
            'jd' => $jd,
            'canChi' => $canChi,
            'chiNgay' => $chiNgay,
            'chi_ngay' => $chi_ngay,

            // Thông tin chi tiết
            'gioHd' => $gioHd,
            'tietkhi' => $tietkhi,
            'table_html' => $table_html,
            'data_totxau' => $data_totxau,
            'ngaySuatHanh' => $ngaySuatHanh,
            'ngaySuatHanhHTML' => $ngaySuatHanhHTML,

            // Sao tốt xấu
            'getSaoTotXauInfo' => $getSaoTotXauInfo,
            'hoangDaoStars' => $hoangDaoStars,
            'hacDaoStars' => $hacDaoStars,

            // Các thông tin phong thủy
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
            'getThongTinNgay' => $getThongTinNgay,
            'noiKhiNgay' => $noiKhiNgay,
            'nhiThapBatTu' => $nhiThapBatTu,
            'getThongTinTruc' => $getThongTinTruc,
            'khongMinhLucDieu' => $khongMinhLucDieu,
            'banhToCan' => $banhToCan,
            'banhToChi' => $banhToChi,
            'getThongTinXuatHanhVaLyThuanPhong' => $getThongTinXuatHanhVaLyThuanPhong,
            'getDetailedGioHoangDao' => $getDetailedGioHoangDao,

            // Điểm số và đánh giá
            'getDaySummaryInfo' => $getDaySummaryInfo,

            // Sự kiện
            'suKienDuongLich' => $suKienDuongLich,
            'suKienAmLich' => $suKienAmLich,
            'suKienHomNay' => $suKienHomNay,

            // Kết quả tốt xấu
            'tot_xau_result' => $tot_xau_result,

            // Thông tin vòng khí
            'getVongKhiNgayThang' => $getVongKhiNgayThang,
            'getCucKhiHopXung' => $getCucKhiHopXung,
            'checkBadDays' => $checkBadDays,

            // Sự kiện sắp tới
            'upcomingEvents' => $upcomingEvents,
            'titletodate' => $titletodate,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription

        ];
    }

    public function detail(Request $request, $yy, $mm, $dd)
    {
        if (!checkdate((int)$mm, (int)$dd, (int)$yy)) {
            abort(404, 'Ngày bạn yêu cầu không tồn tại.');
        }
        $effective_yy = (int)$yy;
        $effective_mm = (int)$mm;
        $effective_dd = (int)$dd;
        $requestCdateInput = $request->input('cdate');
        if (FunctionHelper::validateDate($requestCdateInput, 'Y-m-d')) {
            $cdate_info = explode('-', $requestCdateInput);

            if (checkdate((int)$cdate_info[1], (int)$cdate_info[2], (int)$cdate_info[0])) {
                $effective_yy = (int)$cdate_info[0];
                $effective_mm = (int)$cdate_info[1];
                $effective_dd = (int)$cdate_info[2];
            }
        }

        $yy = $effective_yy;
        $mm = $effective_mm;
        $dd = $effective_dd;
        $metaTitle = 'Lịch Âm Dương Ngày ' . $dd . ' Tháng ' . $mm . ' Năm ' . $yy . ' | Phong Lịch';
        $metaDescription = ' Xem lịch âm dương, lịch vạn niên ngày ' . $dd . ' tháng ' . $mm . ' năm ' . $yy . ' chi tiết và chính xác. Tra cứu ngũ hành can chi, tiết khí, giờ hoàng đạo, sao, trực trong ngày';
        $dateinfodetail = $this->getDateInfo($dd, $mm, $yy, null, '', $metaTitle, $metaDescription);
        return view('lunar.detail', $dateinfodetail);
    }

    /**
     * AJAX endpoint cho trang detail
     */
    public function detailAjax(Request $request)
    {
        try {
            $yy = $request->input('yy');
            $mm = $request->input('mm');
            $dd = $request->input('dd');

            if (!checkdate((int)$mm, (int)$dd, (int)$yy)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ngày không hợp lệ'
                ], 400);
            }
            $metaTitle = 'Lịch Âm Dương Ngày ' . $dd . ' Tháng ' . $mm . ' Năm ' . $yy . ' | Phong Lịch';
            $metaDescription = ' Xem lịch âm dương, lịch vạn niên ngày ' . $dd . ' tháng ' . $mm . ' năm ' . $yy . ' chi tiết và chính xác. Tra cứu ngũ hành can chi, tiết khí, giờ hoàng đạo, sao, trực trong ngày';
            $dateinfodetail = $this->getDateInfo($dd, $mm, $yy, null, '', $metaTitle, $metaDescription);

            // Render HTML content
            $html = view('lunar.today_content.content', $dateinfodetail)->render();

            return response()->json([
                'success' => true,
                'data' => array_merge($dateinfodetail, [
                    'html' => $html
                ])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Hiển thị lịch âm hôm nay với URL đơn giản
     */
    public function todaySimple(Request $request)
    {
        $today = now();
        $dd = $today->day;
        $mm = $today->month;
        $yy = $today->year;
        $titletodate = 'hôm nay';
        $metaTitle = 'Lịch Âm Hôm Nay - Xem Âm Lịch, Lịch Vạn Niên Hôm Nay Chính Xác Nhất';
        $metaDescription = 'Xem lịch âm hôm nay nhanh và chính xác nhất. Tra cứu âm lịch hôm nay, lịch vạn niên hôm nay, biết ngay hôm nay là ngày âm nào, ngày tốt xấu, tiết khí, hoàng đạo.';
        $dateinfodetail = $this->getDateInfo($dd, $mm, $yy, null, $titletodate, $metaTitle, $metaDescription);
        return view('lunar.detailtoday', $dateinfodetail);
    }

    /**
     * Hiển thị lịch âm ngày mai với URL đơn giản
     */
    public function tomorrowSimple(Request $request)
    {
        $tomorrow = now()->addDay();
        $dd = $tomorrow->day;
        $mm = $tomorrow->month;
        $yy = $tomorrow->year;
        $titletodate = 'ngày mai';
         $metaTitle = 'Lịch Âm Ngày Mai - Xem Âm Lịch, Lịch Vạn Niên Ngày Mai Chính Xác Nhất';
        $metaDescription = 'Tra cứu lịch âm ngày mai nhanh và chính xác. Xem âm lịch ngày mai là ngày bao nhiêu, lịch vạn niên ngày mai, cùng tiết khí, và các thông tin tốt – xấu trong ngày.';
        $dateinfodetail = $this->getDateInfo($dd, $mm, $yy, null, $titletodate, $metaTitle, $metaDescription);
        return view('lunar.detailtomorrow', $dateinfodetail);
    }
}
