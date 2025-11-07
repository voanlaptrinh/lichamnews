<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\FengShuiHelper;
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
        return view('tools.tot-xau.index');
    }

    public function checkDays(Request $request)
    {
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
                'days' => [],
            ];
        }

        $purpose = 'TOT_XAU_CHUNG';

        foreach ($period as $date) {
            $year = $date->year;
            $dayScoreDetails = FunctionHelper::getDaySummaryInfo($date->day, $date->month, $date->year, $birthdate->year, $purpose);
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);
            $dayChi = explode(' ', $dayCanChi)[1];
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day');
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
            $fullLunarDateStr = sprintf('%02d/%02d %s', $lunarParts[0], $lunarParts[1], $dayCanChi);

            $details = [];
            if (isset($dayScoreDetails['score']['issues']) && is_array($dayScoreDetails['score']['issues'])) {
                foreach ($dayScoreDetails['score']['issues'] as $issue) {
                    if (isset($issue['reason'])) {
                        $details[] = $issue['reason'];
                    } elseif (isset($issue['message'])) {
                        $details[] = $issue['message'];
                    }
                }
            }

            $resultsByYear[$year]['days'][] = [
                'date' => $date->copy(),
                'weekday_name' => $date->isoFormat('dddd'),
                'full_lunar_date_str' => $fullLunarDateStr,
                 'al_name' => $lunarParts,
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

        $formattedBirthdateForUrl = $birthdate->format('Y-m-d');

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('tools.tot-xau.results', [
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

        return view('build-house.form', [
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

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Xem Ngày Tốt Xấu', 'TOT_XAU_CHUNG');
        return view('tools.tot-xau.details', [
            //   'personInfo' => $personInfo,
            'commonDayInfo' => $commonDayInfo,
            'groomData' => $groomData
            // 'analyzeNgayVoiTuoi' => FengShuiHelper::analyzeNgayVoiTuoi($getThongTinCanChiVaIcon['can_chi_ngay'], $personInfo['can_chi_nam']),
        ]);
    }

    private function getPersonBasicInfo($birthdate)
    {
        $lunarDate = LunarHelper::convertSolar2Lunar(
            $birthdate->day,
            $birthdate->month,
            $birthdate->year
        );

        $canChiNam = KhiVanHelper::canchiNam($birthdate->year);

        $menh = '';
        if (isset(DataHelper::$napAmTable[$canChiNam])) {
            $menhData = DataHelper::$napAmTable[$canChiNam];
            if (is_array($menhData) && isset($menhData['napAm'])) {
                $menh = $menhData['napAm'];
                $hanh = $menhData['hanh'];
            };

           
        }

        return [
            'solar_date' => $birthdate->format('d/m/Y'),
            'lunar_date' => sprintf('%02d/%02d/%04d', $lunarDate[0], $lunarDate[1], $lunarDate[2]),
            'can_chi' => $canChiNam,
            'menh' => $menh,
            'hanh' => $hanh,
        ];
    }

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
