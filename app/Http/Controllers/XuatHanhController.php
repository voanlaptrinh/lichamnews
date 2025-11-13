<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class XuatHanhController extends Controller
{
    /**
     * Hiển thị form xem ngày xuất hành.
     */
    public function showForm()
    {
        // Không cần truyền dateRanges nữa
        return view('tools.xuat-hanh.form');
    }

    /**
     * Xử lý dữ liệu, phân tích năm, phân tích ngày và trả kết quả.
     */
    public function checkDays(Request $request)
    {
        // 1. Xử lý Input và Validation (Giữ nguyên code của bạn)
        $input = $request->all();
        $originalInputs = $input;

        $dateRange = $request->input('date_range');
        $dates = $dateRange ? explode(' đến ', $dateRange) : [null, null];
        if (count($dates) === 1) $dates[1] = $dates[0];

        $request->merge([
            'start_date' => $dates[0] ?? null,
            'end_date' => $dates[1] ?? null,
            'birthdate_formatted' => $input['birthdate'] ?? null,
        ]);

        if (!empty($input['birthdate']) && Carbon::hasFormat($input['birthdate'], 'd/m/Y')) {
            $input['birthdate'] = Carbon::createFromFormat('d/m/Y', $input['birthdate'])->format('Y-m-d');
        }
        $request->merge($input);

        $validator = Validator::make($request->all(), [

            'birthdate' => 'required|date',
            'date_range' => 'required',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], [

            'birthdate.required' => 'Vui lòng nhập ngày sinh của gia chủ.',
            'date_range.required' => 'Vui lòng chọn khoảng ngày dự định.',
            'start_date.*' => 'Định dạng ngày bắt đầu không hợp lệ.',
            'end_date.*' => 'Định dạng ngày kết thúc không hợp lệ hoặc trước ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $birthdate = Carbon::parse($validated['birthdate']);
        $startDate = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        // 2. Lấy thông tin cơ bản của gia chủ và phân tích các năm
        $birthdateInfo = $this->getPersonBasicInfo($birthdate);
        $uniqueYears = [];
        foreach ($period as $date) {
            $uniqueYears[$date->year] = true;
        }
        $uniqueYears = array_keys($uniqueYears);

        $resultsByYear = [];
        foreach ($uniqueYears as $year) {
            $yearAnalysis = $this->calculateYearAnalysis($birthdate, $year);
            $canChiNam = KhiVanHelper::canchiNam((int)$year);
            $resultsByYear[$year] = [
                'year_analysis' => $yearAnalysis,
                'canchi' => $canChiNam,
                'days' => [], // Mảng để lưu kết quả chi tiết của từng ngày
            ];
        }

        // ---------------------------------------------------------------------
        // ---- PHẦN LOGIC MỚI: LẶP QUA TỪNG NGÀY ĐỂ TÍNH ĐIỂM CHI TIẾT ----
        // ---------------------------------------------------------------------

        // a. Xác định mục đích (purpose) cho việc xem ngày làm nhà
        $purpose = 'XUAT_HANH'; // Hoặc 'LAM_NHA', tùy theo bạn định nghĩa trong DataHelper

        foreach ($period as $date) {
             $year = $date->year;
            $dayScoreDetails = FunctionHelper::getDaySummaryInfo($date->day, $date->month, $date->year, $birthdate->year, $purpose);
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);
            $dayChi = explode(' ', $dayCanChi)[1];
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day');
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
            $fullLunarDateStr = sprintf('%02d/%02d %s', $lunarParts[0], $lunarParts[1], $dayCanChi);

            // f. Thêm tất cả kết quả vào mảng `days` của năm tương ứng
            $resultsByYear[$year]['days'][] = [

                'date' => $date->copy(),
                'weekday_name' => $date->isoFormat('dddd'),
                'full_lunar_date_str' => $fullLunarDateStr,
                 'al_name' => $lunarParts,
                'good_hours' => $goodHours,
                'day_score' => $dayScoreDetails, // Toàn bộ object điểm số và chi tiết
            ];
        }
        $sortOrder = $request->input('sort', 'desc');
        foreach ($resultsByYear as &$yearData) {
            if (isset($yearData['days']) && is_array($yearData['days'])) {
                usort($yearData['days'], function ($a, $b) use ($sortOrder) {
                    // Cấu trúc có thể là day_score.score.percentage hoặc day_score.percentage
                    $scoreA = $a['day_score']['score']['percentage'] ?? $a['day_score']['percentage'] ?? 0;
                    $scoreB = $b['day_score']['score']['percentage'] ?? $b['day_score']['percentage'] ?? 0;
                    return $sortOrder === 'asc' ? $scoreA <=> $scoreB : $scoreB <=> $scoreA;
                });
            }
        }
        unset($yearData);

        $formattedBirthdateForUrl = $birthdate->format('Y-m-d');

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('tools.xuat-hanh.results', [
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
                'formattedBirthdate' => $formattedBirthdateForUrl,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        return view('tools.xuat-hanh.form', [
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'resultsByYear' => $resultsByYear,
            'sortOrder' => $sortOrder,
            'formattedBirthdate' => $formattedBirthdateForUrl,
        ]);
    }
    /**
     * Hàm trợ giúp: Phân tích các hạn lớn trong một năm cho gia chủ.
     */
    private function calculateYearAnalysis(Carbon $dob, int $yearToCheck): array
    {
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);
        $birthYear = $lunarDob[2];

        $lunarAge = AstrologyHelper::getLunarAge($birthYear, $yearToCheck);

        $kimLau = AstrologyHelper::checkKimLau($lunarAge);
        $hoangOc = AstrologyHelper::checkHoangOc($lunarAge);

        $tamTai = AstrologyHelper::checkTamTai($birthYear, $yearToCheck);

        $badFactors = [];
        if ($kimLau['is_bad']) $badFactors[] = 'Kim Lâu';
        if ($hoangOc['is_bad']) $badFactors[] = 'Hoang Ốc';
        if ($tamTai['is_bad']) $badFactors[] = 'Tam Tai';

        $isBadYear = count($badFactors) > 0;
        $message = $isBadYear
            ? "Năm {$yearToCheck}, gia chủ phạm phải: <strong>" . implode(', ', $badFactors) . "</strong> – đây là dấu hiệu phong thủy không thuận lợi cho việc xuất hành, đi xa hay khai trương. Tuy nhiên, nếu chỉ là các chuyến đi ngắn hạn như du lịch, công tác, lễ chùa thì vẫn có thể thực hiện, miễn là chọn ngày giờ hoàng đạo, hướng xuất hành cát lợi để giảm bớt sát khí. Trường hợp xuất hành cho những việc trọng đại như khai trương, khởi hành lập nghiệp hoặc bắt đầu dự án mới, gia chủ nên cân nhắc kỹ lưỡng, có thể chọn ngày hợp tuổi hoặc làm lễ cầu an để hóa giải vận hạn."
            : "Năm {$yearToCheck}, gia chủ không phạm Kim Lâu, Hoang Ốc hay Tam Tai – đây là tín hiệu cát lành trong phong thủy cho việc xuất hành. Mọi chuyến đi xa, du lịch, công tác hay khai trương đều có thể tiến hành thuận lợi. Vận khí hanh thông, gặp nhiều may mắn và quý nhân phù trợ, rất thích hợp để khởi đầu hành trình mới trong năm nay.";

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'description' => $message,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }


    /**
     * Hàm trợ giúp: Lấy thông tin cơ bản của một người.
     * Cần thêm hàm này vào vì bạn có gọi $this->getPersonBasicInfo($birthdate).
     */
    private function getPersonBasicInfo($birthdate)
    {
        $lunarDate = LunarHelper::convertSolar2Lunar(
            $birthdate->day,
            $birthdate->month,
            $birthdate->year
        );

        $canChiNam = KhiVanHelper::canchiNam((int)$lunarDate[2]);

        $menh = '';
        if (isset(DataHelper::$napAmTable[$canChiNam])) {
            $menhData = DataHelper::$napAmTable[$canChiNam];
            if (is_array($menhData) && isset($menhData['napAm'])) {
                $menh = $menhData['napAm'];
                $hanh = $menhData['hanh'];
            };
        }

        return [
            'dob' => $birthdate, // Thêm đối tượng Carbon gốc
            'solar_date' => $birthdate->format('d/m/Y'),
            'lunar_date' => sprintf('%02d/%02d/%04d', $lunarDate[0], $lunarDate[1], $lunarDate[2]),
            'can_chi' => $canChiNam,
            'menh' => $menh,
            'hanh' => $hanh,
        ];
    }
    
     public function showDayDetails(Request $request, $date)
    {
        // 1. Validate dữ liệu - đã loại bỏ 'person_type'
         $validated = Validator::make(['date' => $date, 'birthdate' => $request->input('birthdate')], [
            'date' => 'required|date_format:Y-m-d',
            'birthdate' => 'required|date_format:Y-m-d',
        ])->validate();

        // 2. Chuẩn bị các đối tượng ngày tháng
        $dateToCheck = Carbon::parse($validated['date']);
        $groomDob = Carbon::parse($validated['birthdate']);

        // 3. Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)

        $commonDayInfo = BadDayHelper::getdetailtable($dateToCheck);
        $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'XUAT_HANH');

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Ngày xuất hành', 'XUAT_HANH');
        // 5. Tính điểm số của ngày - sử dụng năm sinh thay vì Carbon object
        // 6. Trả về view với toàn bộ dữ liệu
        return view('tools.xuat-hanh.day_details', compact(
            'commonDayInfo',
            'groomData',
            'tabooResult',
        ));
    }
}
