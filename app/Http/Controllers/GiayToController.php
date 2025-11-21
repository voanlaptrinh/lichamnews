<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class GiayToController extends Controller
{
    /**
     * Hiển thị form xem ngày nhận công việc mới.
     */
    public function showForm()
    {
        // Không cần truyền dateRanges nữa
        $metaTitle = "Xem Ngày Tốt Làm Giấy Tờ | Ngày Đẹp Làm CCCD, Hộ Chiếu";
        $metaDescription = "Xem ngày tốt làm giấy tờ, làm CCCD và hộ chiếu theo tuổi. Chọn ngày đẹp hợp vận khí giúp mọi thủ tục hành chính diễn ra suôn sẻ, nhanh chóng.";
        return view('tools.giay-to.form', compact('metaTitle', 'metaDescription'));
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
        $purpose = 'DANG_KY_GIAY_TO'; // Hoặc 'LAM_NHA', tùy theo bạn định nghĩa trong DataHelper

        foreach ($period as $date) {
            $year = $date->year;
            $birthdateal = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);

            // b. Tính toán điểm số của ngày dựa trên tuổi gia chủ
            $dayScoreDetails = GoodBadDayHelper::calculateDayScore($date, $birthdateal[2], $purpose);

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

        // Sắp xếp kết quả theo điểm số
        $sortOrder = $request->input('sort', 'desc');
        foreach ($resultsByYear as &$yearData) {
            if (isset($yearData['days']) && is_array($yearData['days'])) {
                usort($yearData['days'], function ($a, $b) use ($sortOrder) {
                    $scoreA = $a['day_score']['percentage'] ?? 0;
                    $scoreB = $b['day_score']['percentage'] ?? 0;
                    return $sortOrder === 'asc' ? $scoreA <=> $scoreB : $scoreB <=> $scoreA;
                });
            }
        }
        unset($yearData);

        // 4. Trả kết quả về cho view hoặc AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('tools.giay-to.results', [
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
            ])->render();

            return response()->json([
                'success' => true,
                'resultsByYear' => $resultsByYear,
                'html' => $html,
            ]);
        }

        return view('tools.giay-to.form', [
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'resultsByYear' => $resultsByYear,
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
            ? "Năm {$yearToCheck}, gia chủ phạm phải: <strong>" . implode(', ', $badFactors) . "</strong>  – đây là yếu tố phong thủy cần đặc biệt lưu ý khi ký kết giấy tờ, hợp đồng.
    <ul><li>Nếu việc ký kết không quá cấp bách, nên hoãn lại sang năm khác hoặc chọn ngày đặc biệt tốt để hóa giải.</li><li>Nếu bắt buộc phải ký trong năm này, cần hết sức cẩn trọng kiểm tra kỹ lưỡng các điều khoản, chuẩn bị đầy đủ hồ sơ và có thể nhờ người hợp tuổi đứng ra hỗ trợ để giảm thiểu rủi ro pháp lý hoặc những tranh chấp không mong muốn.</li> </ul>
    "
            : "Năm {$yearToCheck}, gia chủ không phạm Kim Lâu, Hoang Ốc hay Tam Tai – đây là tín hiệu rất tốt trong phong thủy. Bạn hoàn toàn có thể an tâm tiến hành ký kết giấy tờ, hợp đồng, hoặc các giao dịch quan trọng trong năm nay.
    Thời điểm cát lợi, vận khí hanh thông – rất thích hợp để mọi việc diễn ra suôn sẻ, thuận lợi và đạt được thành công.";

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
    private function getPersonBasicInfo(Carbon $dob): array
    {

        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);
        $canChiNam = KhiVanHelper::canchiNam($lunarDob[2]);

        $menh = DataHelper::$napAmTable[$canChiNam]; // Giả sử bạn có DataHelper

        return [
            'dob' => $dob,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'menh' => $menh,
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
        $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'KY_GIAY_TO'); // Changed purpose

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Ngày ký giấy tờ', 'KY_GIAY_TO'); // Changed purpose and title
        // 5. Tính điểm số của ngày - sử dụng năm sinh thay vì Carbon object
        // 6. Trả về view với toàn bộ dữ liệu
        return view('tools.giay-to.day_details', compact( // Changed view
            'commonDayInfo',
            'groomData',
            'tabooResult',
        ));
    }
}
