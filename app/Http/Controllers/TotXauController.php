<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\DataHelper;
use App\Helpers\FunctionHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TotXauController extends Controller
{
    public function showForm()
    {
        // Không cần truyền dateRanges nữa
        return view('tools.tot-xau.index');
    }
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
            // Nếu là AJAX request, trả về JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            // Nếu không phải AJAX, redirect như cũ
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
        $purpose = 'TOT_XAU_CHUNG'; // Hoặc 'LAM_NHA', tùy theo bạn định nghĩa trong DataHelper

        foreach ($period as $date) {
            $year = $date->year;

            // b. Tính toán điểm số của ngày dựa trên tuổi gia chủ
            $dayScoreDetails = FunctionHelper::getDaySummaryInfo($date->day, $date->month, $date->year, $birthdate->year, $purpose);
            // c. Lấy thông tin Can Chi của ngày
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);

            // d. Lấy Giờ Hoàng Đạo (chỉ giờ ban ngày)
            $dayChi = explode(' ', $dayCanChi)[1];
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day'); // 'day' để chỉ lấy giờ ban ngày

            // e. Tạo chuỗi ngày Âm lịch đầy đủ để hiển thị
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
            $fullLunarDateStr = sprintf('%02d/%02d %s', $lunarParts[0], $lunarParts[1], $dayCanChi);

            // f. Lấy chi tiết các yếu tố từ day_score
            $details = [];
            // FunctionHelper trả về score object chứa toàn bộ thông tin từ GoodBadDayHelper
            if (isset($dayScoreDetails['score']['issues']) && is_array($dayScoreDetails['score']['issues'])) {
                foreach ($dayScoreDetails['score']['issues'] as $issue) {
                    // Lấy message hoặc reason từ issue
                    if (isset($issue['reason'])) {
                        $details[] = $issue['reason'];
                    } elseif (isset($issue['message'])) {
                        $details[] = $issue['message'];
                    }
                }
            }
            // g. Thêm tất cả kết quả vào mảng `days` của năm tương ứng
            $resultsByYear[$year]['days'][] = [
                'date' => $date->copy(),
                'weekday_name' => $date->isoFormat('dddd'),
                'full_lunar_date_str' => $fullLunarDateStr,
                'good_hours' => $goodHours,
                'day_score' => [
                    'percentage' => $dayScoreDetails['score']['percentage'] ?? 0,
                    'rating' => $dayScoreDetails['score']['rating'] ?? '',
                    'pham' => is_array($dayScoreDetails['score']['checkTabooDays'] ?? null)
                        ? $dayScoreDetails['score']['checkTabooDays']
                        : [],

                    'details' => $details,
                ],
            ];
        }

        // 4. Trả kết quả về cho view hoặc JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Render partial view for AJAX
            $html = view('tools.tot-xau.results', [
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'data' => [
                    'birthdateInfo' => $birthdateInfo,
                    'resultsByYear' => $resultsByYear,
                ]
            ]);
        }

        // Return normal view for non-AJAX requests
        return view('build-house.form', [
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'resultsByYear' => $resultsByYear,
        ]);
    }

    /**
     * Lấy thông tin cơ bản của người dùng dựa trên ngày sinh
     */
    private function getPersonBasicInfo($birthdate)
    {
        $lunarDate = LunarHelper::convertSolar2Lunar(
            $birthdate->day,
            $birthdate->month,
            $birthdate->year
        );

        $canChiNam = KhiVanHelper::canchiNam($birthdate->year);

        // Lấy mệnh (napAm) từ DataHelper
        $menh = '';
        if (isset(DataHelper::$napAmTable[$canChiNam])) {
            $menhData = DataHelper::$napAmTable[$canChiNam];
            if (is_array($menhData) && isset($menhData['napAm'])) {
                $menh = $menhData['napAm'];
            }
        }

        return [
            'solar_date' => $birthdate->format('d/m/Y'),
            'lunar_date' => sprintf('%02d/%02d/%04d', $lunarDate[0], $lunarDate[1], $lunarDate[2]),
            'can_chi' => $canChiNam,
            'menh' => $menh,
        ];
    }

    /**
     * Phân tích năm dựa trên tuổi người dùng
     */
    private function calculateYearAnalysis(Carbon $dob, int $yearToCheck): array
    {
        $birthYear = $dob->year;
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
            ? "Năm {$yearToCheck}, gia chủ phạm phải: <strong>" . implode(', ', $badFactors) . "</strong>  – đây là yếu tố phong thủy cần đặc biệt lưu ý khi thực hiện các việc trọng đại liên quan đến nhà cửa.
<ul><li>Nếu mục đích mua nhà/đất chỉ để đầu tư hoặc chưa có kế hoạch vào ở ngay: vẫn có thể tiến hành giao dịch trong năm nay, miễn là chọn đúng ngày giờ tốt hợp tuổi, có thể hóa giải phần nào sát khí.</li><li>Ngược lại, nếu gia chủ dự định mua xong là dọn vào ở ngay, hoặc tiến hành xây dựng: nên cân nhắc kỹ lưỡng. Trường hợp vẫn muốn thực hiện trong năm, cần áp dụng các biện pháp hóa giải vận hạn phù hợp hoặc chờ sang năm thuận lợi hơn để đảm bảo an cư lạc nghiệp lâu dài, tránh vận rủi không đáng có.</li> </ul>
"
            : "Năm {$yearToCheck}, gia chủ không phạm Kim Lâu, Hoang Ốc hay Tam Tai – đây là tín hiệu rất tốt trong phong thủy. Bạn hoàn toàn có thể an tâm tiến hành các công việc trọng đại liên quan đến nhà cửa như mua nhà/đất, xây dựng, hoặc chuyển về nhà mới trong năm nay.
Thời điểm cát lợi, vận khí hanh thông – rất thích hợp để an cư, lập nghiệp";

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'description' => $message,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }
}
