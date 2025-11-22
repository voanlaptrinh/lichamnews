<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class GiaiHanController extends Controller
{
    /**
     * Hiển thị form xem ngày giải hạn.
     */
    public function showForm()
    {
        // Không cần truyền dateRanges nữa
        $metaTitle = "Xem Ngày Cúng Sao Giải Hạn Theo Tuổi | Chọn Ngày Tốt Hợp Tuổi Cúng Giải Hạn";
        $metaDescription = "Xem ngày tốt cúng sao giải hạn theo tuổi, chọn ngày đẹp hợp phong thủy để hóa giải vận hạn. Tra cứu ngày hoàng đạo, giờ tốt giúp nghi lễ diễn ra an lành, hiệu nghiệm.";
        return view('tools.giai-han.form', ['inputs' => [], 'metaTitle' => $metaTitle, 'metaDescription' => $metaDescription]);
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
        $dates = $dateRange ? explode(' - ', $dateRange) : [null, null];
        if (count($dates) === 1) $dates[1] = $dates[0];

        $request->merge([
            'start_date' => $dates[0] ?? null,
            'end_date' => $dates[1] ?? null,
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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $birthdate = Carbon::parse($validated['birthdate']);

 
        $startDate = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        // 2. Lấy thông tin cơ bản của gia chủ và phân tích các năm
        $birthdateInfo = BadDayHelper::getPersonBasicInfo($birthdate);
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

        $purpose = 'CUNG_SAO_GIAI_HAN';

        foreach ($period as $date) {
            $year = $date->year;
            $birthdateal = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
            $dayScoreDetails = FunctionHelper::getDaySummaryInfo($date->day, $date->month, $date->year, $birthdateal[2], $purpose);

            // Thêm thông tin taboo days
            $tabooResult = GoodBadDayHelper::checkTabooDays($date, $purpose);
            if ($tabooResult && isset($tabooResult['issues'])) {
                $dayScoreDetails['checkTabooDays'] = $tabooResult;
            }

            // c. Lấy thông tin Can Chi của ngày
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);

            // d. Lấy Giờ Hoàng Đạo (chỉ giờ ban ngày)
            $dayChi = explode(' ', $dayCanChi)[1];
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day'); // 'day' để chỉ lấy giờ ban ngày

            // e. Tạo chuỗi ngày Âm lịch đầy đủ để hiển thị
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
         $fullLunarDateStr = sprintf(
                '%02d/%02d/%04d %s',
                $lunarParts[0],
                $lunarParts[1],
                $lunarParts[2],
                '(ÂL)'
            );


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

        // 4. Trả kết quả về cho view hoặc AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('tools.giai-han.results', [
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
                'formattedBirthdate' => $formattedBirthdateForUrl,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'resultsByYear' => $resultsByYear,
            ]);
        }

        return view('tools.giai-han.index', [
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'resultsByYear' => $resultsByYear,
            'sortOrder' => $sortOrder,
            'formattedBirthdate' => $formattedBirthdateForUrl,
        ]);
    }
  

    public function showDayDetails(Request $request, $date)
    {
        $validated = Validator::make(['date' => $date, 'birthdate' => $request->input('birthdate')], [
            'date' => 'required|date_format:Y-m-d',
            'birthdate' => 'required|date_format:Y-m-d',
        ])->validate();


        $dateToCheck = Carbon::parse($validated['date']);
        $groomDob = Carbon::parse($validated['birthdate']);

        // 3. Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)

        $commonDayInfo = BadDayHelper::getdetailtable($dateToCheck);
        $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'CUNG_SAO_GIAI_HAN');

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Xem Ngày Giải Hạn', 'CUNG_SAO_GIAI_HAN');
        return view('tools.giai-han.details', [
            'commonDayInfo' => $commonDayInfo,
            'groomData' => $groomData,
            'tabooResult' => $tabooResult,
        ]);
    }
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
            ? "Năm {$yearToCheck}, gia chủ phạm phải: <strong>" . implode(', ', $badFactors) . "</strong>..."
            : "Năm {$yearToCheck}, gia chủ không phạm Kim Lâu, Hoang Ốc hay Tam Tai...";

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'description' => $message,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }
}
