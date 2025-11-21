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



class BanThoController extends Controller
{
    public function showForm()
    {
        $metaTitle = "Xem Ngày Tốt Di Dời Bàn Thờ, Hợp Phong Thủy Theo Tuổi";
        $metaDescription = "Xem ngày tốt di dời bàn thờ theo tuổi, chọn ngày đẹp hợp phong thủy để chuyển vị trí an vị gia tiên. Tra cứu ngày hoàng đạo, giờ tốt giúp nghi lễ diễn ra trang nghiêm.";
        return view('tools.ban-tho.form', compact('metaTitle', 'metaDescription'));
    }



    public function checkDays(Request $request)
    {
        // 1. Xử lý Input và Validation
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
                'days' => [],
            ];
        }

        // 3. Lặp qua từng ngày để tính điểm
        $purpose = 'CHUYEN_BAN_THO';

        foreach ($period as $date) {
            $year = $date->year;
            $birthdateal = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
            $dayScoreDetails = GoodBadDayHelper::calculateDayScore($date, $birthdateal[2], $purpose);
            $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
            $dayCanChi = LunarHelper::canchiNgayByJD($jd);
            $dayChi = explode(' ', $dayCanChi)[1];
            $goodHours = LunarHelper::getGoodHours($dayChi, 'day');
            $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
            $fullLunarDateStr = sprintf(
                '%02d/%02d/%04d %s',
                $lunarParts[0],
                $lunarParts[1],
                $lunarParts[2],
                '(ÂL)'
            );


            $resultsByYear[$year]['days'][] = [
                'date' => $date->copy(),
                'weekday_name' => $date->isoFormat('dddd'),
                'full_lunar_date_str' => $fullLunarDateStr,
                'good_hours' => $goodHours,
                'day_score' => $dayScoreDetails,
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

        // 4. Trả kết quả về cho view
        if ($request->wantsJson()) {
            $html = view('tools.ban-tho.results', [
                'date_start_end' => $dates,
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
            ])->render();

            return response()->json([
                'success' => true,
                'resultsByYear' => $resultsByYear, // Thêm data cho JS filter
                'html' => $html
            ]);
        }

        return view('tools.ban-tho.form', [
            'date_start_end' => $dates,
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'resultsByYear' => $resultsByYear,
        ]);
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

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }

    private function getPersonBasicInfo(Carbon $dob): array
    {
        $birthYear = $dob->year;
        $canChiNam = KhiVanHelper::canchiNam((int)$birthYear);
        $menh = DataHelper::$napAmTable[$canChiNam];
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);

        return [
            'dob' => $dob,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'menh' => $menh,
        ];
    }
    public function details(Request $request, $date)
    {
        // 1. Validate dữ liệu - đã loại bỏ 'person_type'
        $validated = Validator::make(
            ['date' => $date, 'birthdate' => $request->input('birthdate')],
            [
                'date' => 'required|date_format:Y-m-d',
                'birthdate' => 'required|date_format:Y-m-d',
            ]
        )->validate();

        // 2. Chuẩn bị các đối tượng ngày tháng
        $dateToCheck = Carbon::parse($validated['date']);
        $groomDob = Carbon::parse($validated['birthdate']);

        // 3. Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)

        $commonDayInfo = BadDayHelper::getdetailtable($dateToCheck);
        $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'CHUYEN_BAN_THO');

        // 4. Lấy thông tin chi tiết cho Chú Rể
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $groomDob, 'Chuyển ban thờ', 'CHUYEN_BAN_THO');
        // 5. Tính điểm số của ngày - sử dụng năm sinh thay vì Carbon object
        // 6. Trả về view với toàn bộ dữ liệu
        return view('tools.ban-tho.day_details', compact(
            'commonDayInfo',
            'groomData',
            'tabooResult',
        ));
    }
    // public function details(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'date' => 'required|date_format:d-m-Y',
    //         'birthdate' => 'required|date_format:Y-m-d',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $validated = $validator->validated();
    //     $date = Carbon::createFromFormat('d-m-Y', $validated['date']);
    //     $birthdate = Carbon::createFromFormat('Y-m-d', $validated['birthdate']);

    //     // Lấy thông tin cơ bản của gia chủ
    //     $birthdateInfo = $this->getPersonBasicInfo($birthdate);

    //     // Phân tích các hạn lớn trong năm
    //     $yearAnalysis = $this->calculateYearAnalysis($birthdate, $date->year);

    //     // Tính điểm chi tiết của ngày
    //     $dayScoreDetails = GoodBadDayHelper::calculateDayScore($date, $birthdate->year, 'CHUYEN_BAN_THO');

    //     // Lấy thông tin Can Chi, giờ hoàng đạo, và ngày Âm lịch
    //     $jd = LunarHelper::jdFromDate($date->day, $date->month, $date->year);
    //     $dayCanChi = LunarHelper::canchiNgayByJD($jd);
    //     $dayChi = explode(' ', $dayCanChi)[1];
    //     $goodHours = LunarHelper::getGoodHours($dayChi, 'day');
    //     $lunarParts = LunarHelper::convertSolar2Lunar($date->day, $date->month, $date->year);
    //     $fullLunarDateStr = sprintf('Ngày %02d/%02d %s', $lunarParts[0], $lunarParts[1], $dayCanChi);

    //     $results = [
    //         'date' => $date->copy(),
    //         'weekday_name' => $date->isoFormat('dddd'),
    //         'full_lunar_date_str' => $fullLunarDateStr,
    //         'good_hours' => $goodHours,
    //         'day_score' => $dayScoreDetails,
    //     ];

    //     return view('tools.ban-tho.day_details', [
    //         'birthdateInfo' => $birthdateInfo,
    //         'yearAnalysis' => $yearAnalysis,
    //         'results' => $results,
    //         'canchiNam' => KhiVanHelper::canchiNam($date->year),
    //     ]);
    // }
}
