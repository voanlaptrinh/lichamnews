<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class KyHopDongController extends Controller
{
    /**
     * Hiển thị form xem ngày ký hợp đồng.
     */
    public function showForm()
    {
                      $metaTitle = "Xem Ngày Tốt Ký Hợp Đồng | Chọn Ngày Đẹp Ký Giấy Tờ Theo Tuổi";
        $metaDescription = "Xem ngày tốt ký hợp đồng theo tuổi, chọn ngày đẹp hợp phong thủy giúp giao dịch thuận lợi. Tra cứu ngày hoàng đạo, giờ tốt để ký kết hanh thông, suôn sẻ.";
        return view('tools.ky-hop-dong.form', compact('metaTitle', 'metaDescription'));
    }

    /**
     * Xử lý dữ liệu AJAX, phân tích năm, phân tích ngày và trả kết quả JSON.
     */
    public function check(Request $request)
    {
        // 1. Xử lý Input và Validation theo pattern chuẩn
        $input = $request->all();
        $originalInputs = $input;

        // Xử lý date_range theo pattern BuyHouseController
        $dateRange = $request->input('date_range');
        $dates = $dateRange ? explode(' - ', $dateRange) : [null, null];
        if (count($dates) === 1) $dates[1] = $dates[0];

        $request->merge([
            'start_date' => $dates[0] ?? null,
            'end_date' => $dates[1] ?? null,
            'birthdate_formatted' => $input['birthdate'] ?? null,
        ]);

        // Chuyển đổi format birthdate nếu cần
        if (!empty($input['birthdate']) && Carbon::hasFormat($input['birthdate'], 'd/m/Y')) {
            $input['birthdate'] = Carbon::createFromFormat('d/m/Y', $input['birthdate'])->format('Y-m-d');
        }
        $request->merge($input);

        // Validation chuẩn
        $validator = Validator::make($request->all(), [
            'person_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'date_range' => 'required',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], [
            'person_name.required' => 'Vui lòng nhập tên người ký hợp đồng.',
            'person_name.string' => 'Tên phải là chuỗi ký tự.',
            'person_name.max' => 'Tên không được quá 255 ký tự.',
            'birthdate.required' => 'Vui lòng nhập ngày sinh của người ký hợp đồng.',
            'date_range.required' => 'Vui lòng chọn khoảng ngày dự định.',
            'start_date.*' => 'Định dạng ngày bắt đầu không hợp lệ.',
            'end_date.*' => 'Định dạng ngày kết thúc không hợp lệ hoặc trước ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validated = $validator->validated();
            $birthdate = Carbon::parse($validated['birthdate']);
            $startDate = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->endOfDay();
            $period = CarbonPeriod::create($startDate, $endDate);

            // 2. Lấy thông tin cơ bản của người ký hợp đồng và phân tích các năm
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

            // 3. Phần logic chính: Lặp qua từng ngày để tính điểm chi tiết
            $purpose = 'KY_HOP_DONG'; // Mục đích cho việc ký hợp đồng

            foreach ($period as $date) {
                $year = $date->year;

                // Tính toán điểm số của ngày dựa trên tuổi người ký hợp đồng
                $birthdateal = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
                $dayScoreDetails = GoodBadDayHelper::calculateDayScore($date, $birthdateal[2], $purpose);

                // Lấy thông tin Can Chi của ngày
                $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
                $dayCanChi = LunarHelper::canchiNgayByJD($jd);

                // Lấy Giờ Hoàng Đạo (chỉ giờ ban ngày)
                $dayChi = explode(' ', $dayCanChi)[1];
                $goodHours = LunarHelper::getGoodHours($dayChi, 'day');

                // Tạo chuỗi ngày Âm lịch đầy đủ để hiển thị
                $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
               $fullLunarDateStr = sprintf(
                '%02d/%02d/%04d %s',
                $lunarParts[0],
                $lunarParts[1],
                $lunarParts[2],
                '(ÂL)'
            );


                // Thêm tất cả kết quả vào mảng `days` của năm tương ứng
                $resultsByYear[$year]['days'][] = [
                    'date' => $date->copy(),
                    'weekday_name' => $this->getVietnameseWeekday($date),
                    'full_lunar_date_str' => $fullLunarDateStr,
                    'al_name' => $lunarParts,
                    'good_hours' => $goodHours,
                    'day_score' => $dayScoreDetails, // Toàn bộ object điểm số và chi tiết
                ];
            }

            // 4. Sắp xếp kết quả theo điểm số
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

            // 5. Trả kết quả JSON với HTML được render
            $html = view('tools.ky-hop-dong.results', [
                'inputs' => $originalInputs,
                'personName' => $validated['person_name'],
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị chi tiết ngày ký hợp đồng
     */
    public function details(Request $request, $date)
    {
        $validated = Validator::make([
            'date' => $date,
            'birthdate' => $request->input('birthdate'),
            'person_name' => $request->input('person_name')
        ], [
            'date' => 'required|date_format:Y-m-d',
            'birthdate' => 'required|date_format:Y-m-d',
            'person_name' => 'nullable|string|max:255',
        ])->validate();

        try {
            $dateToCheck = Carbon::parse($validated['date']);
            $groomDob = Carbon::parse($validated['birthdate']);

            // Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)
            $commonDayInfo = BadDayHelper::getdetailtable($dateToCheck);
            $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'KY_HOP_DONG');

            // Lấy thông tin chi tiết cho người ký hợp đồng
            $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Ngày ký hợp đồng', 'KY_HOP_DONG');

            return view('tools.ky-hop-dong.day_details', compact(
                'commonDayInfo',
                'groomData',
                'tabooResult'
            ))->with('personName', $validated['person_name'] ?? null);

        } catch (\Exception $e) {
            return redirect()->route('ky-hop-dong.form')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Legacy method - keeping for compatibility but updating description
     */
    public function checkDays(Request $request)
    {
        // Redirect to new check method
        return $this->check($request);
    }
    /**
     * Hàm trợ giúp: Phân tích các hạn lớn trong một năm cho người ký hợp đồng.
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
            ? "Năm {$yearToCheck}, bạn phạm phải: <strong>" . implode(', ', $badFactors) . "</strong> – đây là yếu tố phong thủy cần đặc biệt lưu ý khi thực hiện các giao dịch trọng đại và ký kết hợp đồng.
<ul><li>Nếu việc ký hợp đồng không quá cấp bách và có thể hoãn lại: nên cân nhắc chờ sang năm thuận lợi hơn để đảm bảo giao dịch thành công, tránh rủi ro pháp lý không đáng có.</li><li>Trường hợp vẫn muốn ký trong năm nay: cần chọn đúng ngày giờ tốt hợp tuổi, đồng thời áp dụng các biện pháp hóa giải vận hạn phù hợp để giảm thiểu tác động xấu, đảm bảo hợp đồng được thực hiện suôn sẻ.</li></ul>"
            : "Năm {$yearToCheck}, bạn không phạm Kim Lâu, Hoang Ốc hay Tam Tai – đây là tín hiệu rất tốt trong phong thủy. Bạn hoàn toàn có thể an tâm tiến hành ký kết hợp đồng, thực hiện các giao dịch quan trọng trong năm nay.
Thời điểm cát lợi, vận khí hanh thông – rất thích hợp để ký kết các hợp đồng kinh doanh, mua bán, đầu tư và các cam kết lâu dài khác.";

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'description' => $message,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }


    /**
     * Hàm trợ giúp: Lấy thông tin cơ bản của người ký hợp đồng.
     */
    private function getPersonBasicInfo(Carbon $dob): array
    {
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);
        $canChiNam = KhiVanHelper::canchiNam($lunarDob[2]);

        $menh = DataHelper::$napAmTable[$canChiNam];

        return [
            'dob' => $dob,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'menh' => $menh,
        ];
    }

    /**
     * Hàm trợ giúp: Lấy tên thứ trong tuần bằng tiếng Việt
     */
    private function getVietnameseWeekday(Carbon $date): string
    {
        return $date->isoFormat('dddd');
    }
}
