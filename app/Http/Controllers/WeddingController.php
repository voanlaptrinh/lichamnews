<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\FengShuiHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GioHoangDaoHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingController extends Controller
{
    /**
     * Hiển thị form nhập liệu.
     */
    public function showForm()
    {
        // Truyền ngày hôm nay vào view để làm giá trị mặc định cho ngày cưới
        return view('wedding.check_form');
    }

    /**
     * Kiểm tra và trả về kết quả theo từng năm.
     */
    public function check(Request $request)
    {
        // 1. Xử lý Input và Validation
        $input = $request->all();
        $originalInputs = $input;

        $dateRange = $request->input('wedding_date_range');
        $dates = $dateRange ? explode(' đến ', $dateRange) : [null, null];
        if (count($dates) === 1) {
            $dates[1] = $dates[0];
        }
        $request->merge([
            'start_date' => $dates[0] ?? null,
            'end_date' => $dates[1] ?? null,
            'groom_dob_formatted' => $input['groom_dob'] ?? null,
            'bride_dob_formatted' => $input['bride_dob'] ?? null,
        ]);

        if (!empty($input['groom_dob']) && Carbon::hasFormat($input['groom_dob'], 'd/m/Y')) {
            $input['groom_dob'] = Carbon::createFromFormat('d/m/Y', $input['groom_dob'])->format('Y-m-d');
        }
        if (!empty($input['bride_dob']) && Carbon::hasFormat($input['bride_dob'], 'd/m/Y')) {
            $input['bride_dob'] = Carbon::createFromFormat('d/m/Y', $input['bride_dob'])->format('Y-m-d');
        }
        $request->merge($input);

        $validator = Validator::make($request->all(), [
            'groom_dob' => 'required|date',
            'bride_dob' => 'required|date',
            'wedding_date_range' => 'required',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], [
            'groom_dob.required' => 'Vui lòng nhập ngày sinh của chú rể.',
            'bride_dob.required' => 'Vui lòng nhập ngày sinh của cô dâu.',
            'wedding_date_range.required' => 'Vui lòng chọn khoảng ngày dự định cưới.',
            'start_date.*' => 'Định dạng ngày bắt đầu không hợp lệ.',
            'end_date.*' => 'Định dạng ngày kết thúc không hợp lệ hoặc trước ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $groomDob = Carbon::parse($validated['groom_dob']);
        $brideDob = Carbon::parse($validated['bride_dob']);
        $startDate = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->endOfDay();

        // 2. Logic mới: Nhóm theo năm
        $period = CarbonPeriod::create($startDate, $endDate);
        $groomInfo = $this->getPersonBasicInfo($groomDob);
        $brideInfo = $this->getPersonBasicInfo($brideDob);

        // Lấy danh sách các năm duy nhất trong khoảng đã chọn
        $uniqueYears = [];
        foreach ($period as $date) {
            $uniqueYears[$date->year] = true;
        }
        $uniqueYears = array_keys($uniqueYears);

        $resultsByYear = [];
        foreach ($uniqueYears as $year) {
            // Với mỗi năm, ta phân tích hạn cho cả cô dâu và chú rể
            // Lưu ý: hạn Tam Tai, Kim Lâu, Hoang Ốc là tính theo NĂM, nên chỉ cần tính 1 lần/năm.
            $groomAnalysis = $this->calculateAstrologyResults($groomDob, $year, 'chú rể');
            $brideAnalysis = $this->calculateAstrologyResults($brideDob, $year, 'cô dâu');

            $canChiNam = KhiVanHelper::canchiNam((int)$year);
            $resultsByYear[$year] = [
                'groom_analysis' => $groomAnalysis,
                'bride_analysis' => $brideAnalysis,
                'canchi' => $canChiNam,
                'good_days' => [], // Mảng để lưu các ngày tốt trong năm này
                'days' => [],
            ];
        }

        // 3. Lọc ra các ngày tốt
        // Lặp lại qua khoảng thời gian để tìm ngày tốt CỤ THỂ
        // Mục đích (purpose) cho việc xem ngày cưới
        $purpose = 'CUOI_HOI';
        foreach ($period as $date) {
            $year = $date->year;

            $groomScoreDetails = GoodBadDayHelper::calculateDayScore($date, $groomDob->year, $purpose);

            // Tính điểm cho cô dâu vào ngày này
            $brideScoreDetails = GoodBadDayHelper::calculateDayScore($date, $brideDob->year, $purpose);
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd); // Kết quả ví dụ: "Ất Tỵ"

            $dayChi = explode(' ', $dayCanChi)[1];
            // 1. Lấy TẤT CẢ các giờ tốt trong ngày
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day');
            // c. Tạo chuỗi ngày Âm lịch đầy đủ để hiển thị
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
            $fullLunarDateStr = sprintf('Ngày %02d/%02d %s', $lunarParts[0], $lunarParts[1], $dayCanChi);
            // Thêm kết quả chi tiết của ngày vào đúng năm của nó
            $resultsByYear[$year]['days'][] = [
                'date' => $date->copy(), // Dùng copy() để đảm bảo đối tượng date không bị thay đổi
                'weekday_name' => $date->isoFormat('dddd'),
                // Dữ liệu mới để hiển thị
                'full_lunar_date_str' => $fullLunarDateStr, // Ví dụ: "Ngày 05/02 Ất Tỵ"
                'good_hours' => $goodHours, // Ví dụ: ['9h - 11h (Tỵ)', '13h - 15h (Sửu)']
                'lunar_date_str' => sprintf('%02d/%02d/%d', ...LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year)),
                'groom_score' => $groomScoreDetails,
                'bride_score' => $brideScoreDetails,
            ];
        }

        // 4. Trả về view với cấu trúc dữ liệu mới
        return view('wedding.check_form', [
            'inputs' => $originalInputs,
            'groomInfo' => $groomInfo,
            'brideInfo' => $brideInfo,
            'resultsByYear' => $resultsByYear,
        ]);
    }


    // Hàm này giữ nguyên
    private function getPersonBasicInfo(Carbon $dob): array
    {
        $birthYear = $dob->year;
        $canChiNam = KhiVanHelper::canchiNam($birthYear);
        $menh = DataHelper::$napAmTable[$canChiNam];
        $zodiac = AstrologyHelper::getZodiacSign($birthYear);
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);

        return [
            'dob' => $dob,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'menh' => $menh,
            'zodiac' => $zodiac,
        ];
    }

    // Cập nhật hàm này để trả về thêm trạng thái tổng quan
    private function calculateAstrologyResults(Carbon $dob, int $yearToCheck, string $genderText): array
    {
        $birthYear = $dob->year;
        $lunarAge = AstrologyHelper::getLunarAge($birthYear, $yearToCheck);
        $kimLau = AstrologyHelper::checkKimLau($lunarAge);
        $hoangOc = AstrologyHelper::checkHoangOc($lunarAge);
        $tamTai = AstrologyHelper::checkTamTai($birthYear, $yearToCheck);

        $badFactors = [];
        $badFactorTitles = [];

        if ($kimLau['is_bad']) {
            $badFactors[] = '<strong>Kim Lâu</strong>';
            $badFactorTitles[] = 'Kim Lâu';
        }
        if ($hoangOc['is_bad']) {
            $badFactors[] = '<strong>Hoang Ốc</strong>';
            $badFactorTitles[] = 'Hoang Ốc';
        }
        if ($tamTai['is_bad']) {
            $badFactors[] = '<strong>Tam Tai</strong>';
            $badFactorTitles[] = 'Tam Tai';
        }

        $message = '';
        if (count($badFactors) === 0) {
            $message = "Năm {$yearToCheck}, {$genderText} không phạm các hạn lớn. Đây là một năm <strong>TỐT</strong> để tiến hành hôn sự.";
        } else {
            $factorsString = implode(', ', $badFactors);
            $titlesString = implode(', ', $badFactorTitles);
            $message = "Năm {$yearToCheck}, {$genderText} phạm {$factorsString}. Đây là một năm <strong>chưa thực sự tốt</strong>. Nếu tiến hành hôn sự cần cân nhắc hoặc tìm cách hóa giải các hạn: {$titlesString}.";
        }

        return [
            'lunar_age' => $lunarAge,
            'kim_lau' => $kimLau,
            'hoang_oc' => $hoangOc,
            'tam_tai' => $tamTai,
            'description' => $message,
            'is_bad_year' => count($badFactors) > 0, // Trạng thái tổng quan
        ];
    }
    /**
     * Hiển thị trang chi tiết điểm của một ngày cụ thể cho một người.
     */
    // public function showDayDetails(Request $request)
    // {
    //     // 1. Validate dữ liệu từ URL query
    //     $validator = Validator::make($request->all(), [
    //         'date' => 'required|date_format:Y-m-d',
    //         'person_type' => 'required|in:groom,bride',
    //         'groom_dob' => 'required|date_format:Y-m-d',
    //         'bride_dob' => 'required|date_format:Y-m-d',
    //     ]);

    //     if ($validator->fails()) {
    //         // Nếu có lỗi, có thể trả về một trang lỗi hoặc quay lại trang trước
    //         return redirect()->back()->withErrors('Dữ liệu không hợp lệ để xem chi tiết.');
    //     }

    //     $validated = $validator->validated();

    //     // 2. Chuẩn bị dữ liệu
    //     $dateToCheck = Carbon::parse($validated['date']);
    //     $groomDob = Carbon::parse($validated['groom_dob']);
    //     $brideDob = Carbon::parse($validated['bride_dob']);

    //     // Xác định thông tin của người cần xem
    //     if ($validated['person_type'] === 'groom') {
    //         $personDob = $groomDob;
    //         $personInfo = $this->getPersonBasicInfo($groomDob);
    //         $personTitle = 'Chú Rể';
    //     } else {
    //         $personDob = $brideDob;
    //         $personInfo = $this->getPersonBasicInfo($brideDob);
    //         $personTitle = 'Cô Dâu';
    //     }

    //     // 3. Tính toán lại điểm số chi tiết
    //     $purpose = 'CUOI_HOI';
    //     $scoreDetails = GoodBadDayHelper::calculateDayScore($dateToCheck, $personDob->year, $purpose);

    //     $badDays = BadDayHelper::checkBadDays($dateToCheck);
    //     // Chuẩn bị dữ liệu ngày tháng để hiển thị
    //     $lunarParts = LunarHelper::convertSolar2Lunar($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
    //     $dayCanChi = LunarHelper::canchiNgayByJD(LunarHelper::jdFromDate($dateToCheck->day, $dateToCheck->month, $dateToCheck->year));
    //     $getThongTinNgay = FunctionHelper::getThongTinNgay($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
    //     $noiKhiNgay =  KhiVanHelper::getDetailedNoiKhiExplanation($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
    //     $nhiThapBatTu = FunctionHelper::nhiThapBatTu($dateToCheck->year, $dateToCheck->month, $dateToCheck->day);
    //     $getThongTinTruc = FunctionHelper::getThongTinTruc($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
    //     $getSaoTotXauInfo = FunctionHelper::getSaoTotXauInfo($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);


    //     $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
    //     $personDobYear = $personDob->year;
    //     $canChiYear = KhiVanHelper::canchiNam($personDobYear);

    //     $chiNgay = explode(' ', $getThongTinCanChiVaIcon['can_chi_ngay'])[1] ?? '';

    //     $getVongKhiNgayThang = KhiVanHelper::getDetailedKhiThangInfo($dateToCheck);
    //     $getCucKhiHopXung = FengShuiHelper::getCucKhiHopXung($chiNgay);


    //     $analyzeNgayVoiTuoi = FengShuiHelper::analyzeNgayVoiTuoi($getThongTinCanChiVaIcon['can_chi_ngay'], $canChiYear);



    //     // 4. Trả về view chi tiết
    //     return view('wedding.day_details', [
    //         'personTitle' => $personTitle,
    //         'personInfo' => $personInfo,
    //         'dateToCheck' => $dateToCheck,
    //         'lunarDateStr' => sprintf('Ngày %s (%02d/%02d)', $dayCanChi, $lunarParts[0], $lunarParts[1]),
    //         'getThongTinNgay' => $getThongTinNgay,
    //         'score' => $scoreDetails,
    //         'badDays' => $badDays,
    //         'noiKhiNgay' => $noiKhiNgay,
    //         'nhiThapBatTu' => $nhiThapBatTu,
    //         'getThongTinTruc' => $getThongTinTruc,
    //         'getSaoTotXauInfo' => $getSaoTotXauInfo,
    //         'al' => $lunarParts,
    //         'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
    //         'getVongKhiNgayThang' => $getVongKhiNgayThang,
    //         'getCucKhiHopXung' => $getCucKhiHopXung,
    //         'analyzeNgayVoiTuoi' => $analyzeNgayVoiTuoi,
    //     ]);
    // }
    /**
     * [ĐÃ SỬA] Hiển thị trang chi tiết ngày cưới cho cả Chú rể và Cô dâu.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showDayDetails(Request $request)
    {
        // 1. Validate dữ liệu - đã loại bỏ 'person_type'
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'groom_dob' => 'required|date_format:Y-m-d',
            'bride_dob' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors('Dữ liệu không hợp lệ để xem chi tiết.');
        }

        $validated = $validator->validated();

        // 2. Chuẩn bị các đối tượng ngày tháng
        $dateToCheck = Carbon::parse($validated['date']);
        $groomDob = Carbon::parse($validated['groom_dob']);
        $brideDob = Carbon::parse($validated['bride_dob']);

        // 3. Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)
        $lunarParts = LunarHelper::convertSolar2Lunar($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $dayCanChi = LunarHelper::canchiNgayByJD(LunarHelper::jdFromDate($dateToCheck->day, $dateToCheck->month, $dateToCheck->year));
  $jd = \App\Helpers\LunarHelper::jdFromDate($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $canChiNgay = \App\Helpers\LunarHelper::canchiNgayByJD($jd);
        list($dayCan, $dayChi) = explode(' ', $canChiNgay);
        $hopxungNgay = FengShuiHelper::getCucKhiHopXung($dayChi);
        $commonDayInfo = [
            'dateToCheck' => $dateToCheck,
            'lunarDateStr' => sprintf('Ngày %s (%02d/%02d)', $dayCanChi, $lunarParts[0], $lunarParts[1]),
            'badDays' => BadDayHelper::checkBadDays($dateToCheck),
            'getThongTinNgay' => FunctionHelper::getThongTinNgay($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'nhiThapBatTu' => FunctionHelper::nhiThapBatTu($dateToCheck->year, $dateToCheck->month, $dateToCheck->day),
            'getThongTinTruc' => FunctionHelper::getThongTinTruc($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'getSaoTotXauInfo' => FunctionHelper::getSaoTotXauInfo($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'al' => $lunarParts, // Giữ lại biến 'al' cho tiện
            'hopxungNgay' => $hopxungNgay,
        ];

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = $this->getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Chú Rể');

        // 5. Lấy thông tin chi tiết cho Cô Dâu
        $brideData = $this->getDetailedAnalysisForPerson($dateToCheck, $brideDob, 'Cô Dâu');

        // 6. Trả về view với toàn bộ dữ liệu
        return view('wedding.day_details', compact(
            'commonDayInfo',
            'groomData',
            'brideData'
        ));
    }
    
    /**
     * [HELPER MỚI] Gom logic tính toán chi tiết cho một người cụ thể.
     * Hàm này sẽ được gọi 2 lần: 1 cho chú rể, 1 cho cô dâu.
     *
     * @param Carbon $dateToCheck Ngày cần xem
     * @param Carbon $personDob Ngày sinh của người đó
     * @param string $personTitle "Chú Rể" hoặc "Cô Dâu"
     * @return array
     */
    private function getDetailedAnalysisForPerson(Carbon $dateToCheck, Carbon $personDob, string $personTitle): array
    {
        $personInfo = $this->getPersonBasicInfo($personDob);
        $getThongTinCanChiVaIcon = FunctionHelper::getThongTinCanChiVaIcon($dateToCheck->day, $dateToCheck->month, $dateToCheck->year);
        $chiNgay = explode(' ', $getThongTinCanChiVaIcon['can_chi_ngay'])[1] ?? '';
        
        return [
            'personTitle' => $personTitle,
            'personInfo' => $personInfo,
            'score' => GoodBadDayHelper::calculateDayScore($dateToCheck, $personDob->year, 'CUOI_HOI'),
            'noiKhiNgay' => KhiVanHelper::getDetailedNoiKhiExplanation($dateToCheck->day, $dateToCheck->month, $dateToCheck->year),
            'getThongTinCanChiVaIcon' => $getThongTinCanChiVaIcon,
            'getVongKhiNgayThang' => KhiVanHelper::getDetailedKhiThangInfo($dateToCheck),
            'getCucKhiHopXung' => FengShuiHelper::getCucKhiHopXung($chiNgay),
            'analyzeNgayVoiTuoi' => FengShuiHelper::analyzeNgayVoiTuoi($getThongTinCanChiVaIcon['can_chi_ngay'], $personInfo['can_chi_nam']),
        ];
    }
}
