<?php

namespace App\Http\Controllers;

use App\Helpers\AstrologyHelper;
use App\Helpers\BadDayHelper;
use App\Helpers\DataHelper;
use App\Helpers\FengShuiHelper;
use App\Helpers\GoodBadDayHelper;
use App\Helpers\KhiVanHelper;
use App\Helpers\LunarHelper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NhapTrachController extends Controller
{
    /**
     * Hiển thị form nhập liệu.
     */
    public function showForm()
    {
              $metaTitle = "Xem Ngày Tốt Trấn Yểm, Trấn Trạch Theo Tuổi";
        $metaDescription = "Xem ngày tốt trấn yểm, trấn trạch theo tuổi giúp hóa giải sát khí, ổn định phong thủy nhà cửa. Tra cứu ngày hoàng đạo, giờ tốt để trấn trạch an lành, hiệu quả.";
        return view('tools.nhap-trach.form', compact('metaTitle', 'metaDescription'));
    }

    /**
     * Xử lý dữ liệu, phân tích năm, phân tích ngày và trả kết quả.
     */
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
        ]);

        if (!empty($input['birthdate']) && \DateTime::createFromFormat('d/m/Y', $input['birthdate'])) {
            $input['birthdate_formatted'] = Carbon::createFromFormat('d/m/Y', $input['birthdate'])->format('Y-m-d');
        } else {
             $input['birthdate_formatted'] = null;
        }

        $request->merge(['birthdate' => $input['birthdate_formatted']]);


        $validator = Validator::make($request->all(), [
            'birthdate' => 'required|date',
            'gioi_tinh' => 'required|in:nam,nữ', // Sửa 'nu' thành 'nữ' để khớp với helper
            'huong_nha' => 'required|string|in:bac,dong_bac,dong,dong_nam,nam,tay_nam,tay,tay_bac',
            'date_range' => 'required',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], [
            'birthdate.required' => 'Vui lòng nhập ngày sinh của gia chủ.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'huong_nha.required' => 'Vui lòng chọn hướng nhà.',
            'date_range.required' => 'Vui lòng chọn khoảng ngày dự định.',
            'start_date.*' => 'Định dạng ngày bắt đầu không hợp lệ.',
            'end_date.*' => 'Định dạng ngày kết thúc không hợp lệ hoặc trước ngày bắt đầu.',
        ]);


        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput($originalInputs);
        }

        $validated = $validator->validated();

        $birthdate = Carbon::parse($validated['birthdate']);
        $startDate = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        // 2. Lấy thông tin cơ bản VÀ PHONG THỦY của gia chủ
        $birthdateInfo = $this->getPersonBasicInfo($birthdate, $validated['gioi_tinh']);
        
        // 2.1 Phân tích hướng nhà đã chọn
        $huongNhaAnalysis = null;
        if (isset($birthdateInfo['phong_thuy'])) {
           $lunarDob = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
           $lunarBirthYear = $lunarDob[2];
           $huongNhaAnalysis = $this->analyzeHouseDirection(
    $validated['huong_nha'],
    $birthdateInfo['phong_thuy'],
    $birthdate,
    $validated['gioi_tinh']
);
        }

        // 3. Phân tích các năm
        $uniqueYears = [];
        foreach ($period as $date) {
            $uniqueYears[$date->year] = true;
        }
        $uniqueYears = array_keys($uniqueYears);

        $resultsByYear = [];
        foreach ($uniqueYears as $year) {
            $yearAnalysis = $this->calculateYearAnalysis($birthdate, $year);
            $canChiNam = KhiVanHelper::canchiNam((int)$year);

            // Tính tuổi âm cho năm này
            $lunarDob = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
            $lunarBirthYear = $lunarDob[2];
            $lunarAge = AstrologyHelper::getLunarAge($lunarBirthYear, $year);

            $resultsByYear[$year] = [
                'year_analysis' => $yearAnalysis,
                'canchi' => $canChiNam,
                'lunar_age' => $lunarAge, // Thêm tuổi âm
                'days' => [], // Mảng để lưu kết quả chi tiết của từng ngày
            ];
        }

        // 4. Lặp qua từng ngày để tính điểm chi tiết
        $purpose = 'NHAP_TRACH';

        foreach ($period as $date) {
            $year = $date->year;
            // Sử dụng năm âm lịch của ngày sinh thay vì năm dương lịch
            $lunarDob = LunarHelper::convertSolar2Lunar($birthdate->day, $birthdate->month, $birthdate->year);
            $lunarBirthYear = $lunarDob[2];
            $dayScoreDetails = GoodBadDayHelper::calculateDayScore($date, $lunarBirthYear, $purpose);
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
                'al_name' => $lunarParts,
                'good_hours' => $goodHours,
                'day_score' => $dayScoreDetails,
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

        // 5. Trả kết quả về cho view hoặc AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('tools.nhap-trach.results', [
                'inputs' => $originalInputs,
                'birthdateInfo' => $birthdateInfo,
                'huongNhaAnalysis' => $huongNhaAnalysis,
                'resultsByYear' => $resultsByYear,
                'sortOrder' => $sortOrder,
            ])->render();

            return response()->json([
                'success' => true,
                 'resultsByYear' => $resultsByYear,
                'html' => $html,
            ]);
        }

        return view('tools.nhap-trach.form', [
            'inputs' => $originalInputs,
            'birthdateInfo' => $birthdateInfo,
            'huongNhaAnalysis' => $huongNhaAnalysis,
            'resultsByYear' => $resultsByYear,
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
            ? "Năm {$yearToCheck}, gia chủ phạm phải: <strong>" . implode(', ', $badFactors) . "</strong>  - đại kỵ phong thủy khi làm việc trọng đại như động thổ, xây dựng. Vì vậy, không nên khởi công trong năm nay.
Nếu buộc phải thực hiện, gia chủ nên mượn tuổi hợp để hóa giải vận xấu."
            : "Năm {$yearToCheck}, gia chủ không phạm Kim Lâu, Hoang Ốc hay Tam Tai – đây là tín hiệu rất tốt trong phong thủy. Bạn hoàn toàn có thể an tâm tiến hành các công việc trọng đại liên quan đến nhà cửa như mua nhà/đất, xây dựng, hoặc chuyển về nhà mới trong năm nay.
Thời điểm cát lợi, vận khí hanh thông – rất thích hợp để an cư, lập nghiệp.";

        return [
            'is_bad_year' => $isBadYear,
            'lunar_age' => $lunarAge,
            'description' => $message,
            'details' => compact('kimLau', 'hoangOc', 'tamTai'),
        ];
    }


    /**
     * Hàm trợ giúp: Lấy thông tin cơ bản và PHONG THỦY của một người.
     */
    private function getPersonBasicInfo(Carbon $dob, string $gender): array
    {
        // Sử dụng năm âm lịch thay vì năm dương lịch
        $lunarDob = LunarHelper::convertSolar2Lunar($dob->day, $dob->month, $dob->year);
        $lunarBirthYear = $lunarDob[2];

        $canChiNam = KhiVanHelper::canchiNam((int)$lunarBirthYear);
        $menh = DataHelper::$napAmTable[$canChiNam];

        // *** LOGIC MỚI: TÍNH TOÁN PHONG THỦY ***
        // Sử dụng năm âm lịch để tính phong thủy
        $phongThuyInfo = FengShuiHelper::tinhHuongHopTuoi($lunarBirthYear, $gender);

        return [
            'dob' => $dob,
            'gender' => $gender,
            'lunar_dob_str' => sprintf('%02d/%02d/%d', $lunarDob[0], $lunarDob[1], $lunarDob[2]),
            'can_chi_nam' => $canChiNam,
            'lunar_birth_year' => $lunarBirthYear, // Thêm năm âm lịch
            'menh' => $menh,
            'phong_thuy' => $phongThuyInfo, // Thêm thông tin phong thủy vào đây
        ];
    }

     
       /**
     * HÀM HOÀN CHỈNH: Phân tích hướng nhà, lấy Tên Cung và Mô Tả từ DataHelper.
     */
    private function analyzeHouseDirection(string $houseDirectionKey, array $phongThuyInfo, Carbon $dob, string $gender): array
    {
        // 1. Ánh xạ và chuẩn bị dữ liệu
        $directionMap = [
            'bac' => 'Bắc', 'dong_bac' => 'Đông Bắc', 'dong' => 'Đông', 'dong_nam' => 'Đông Nam',
            'nam' => 'Nam', 'tay_nam' => 'Tây Nam', 'tay' => 'Tây', 'tay_bac' => 'Tây Bắc',
        ];
        $houseDirectionName = $directionMap[$houseDirectionKey] ?? '';
        $genderName = ($gender === 'nam') ? 'Nam mệnh' : 'Nữ mệnh';
        
        $result = [
            'direction_name' => $houseDirectionName,
            'is_good' => false,
            'quality_key' => '',
            'quality_name' => 'Không xác định',
            'description' => 'Không tìm thấy thông tin phù hợp.',
            'conclusion' => '',
        ];

        // 3. Tìm hướng nhà trong các cung Tốt
        foreach ($phongThuyInfo['huong_tot'] as $key => $direction) {
            if ($direction === $houseDirectionName) {
                $result['is_good'] = true;
                $result['quality_key'] = $key;
                
                // LẤY TÊN CUNG CÓ DẤU TỪ DATAHELPER
                $result['quality_name'] = DataHelper::$cungBatTrachNames[$key] ?? str_replace('_', ' ', ucwords($key, '_'));
                
                // Lấy mô tả từ DataHelper
                $result['description'] = DataHelper::$cungBatTrachDescriptions[$key] ?? 'Hướng tốt.';
                
                $result['conclusion'] = sprintf(
                    'Hướng nhà <strong>%s</strong> thuộc nhóm <strong>%s</strong>, hoàn toàn hợp tuổi với gia chủ sinh ngày %s (<strong>%s</strong>). Đây là hướng cát (cung %s), hỗ trợ tốt cho tài lộc, sự nghiệp và gia đạo.<br>👉 Gia chủ có thể yên tâm nhập trạch và an cư lâu dài.',
                    $houseDirectionName, $phongThuyInfo['nhom'], $dob->format('d/m/Y'),
                    $genderName, "<strong>" . $result['quality_name'] . "</strong>"
                );
                return $result;
            }
        }
        
        // 4. Nếu không thấy, tìm trong các hướng xấu
        foreach ($phongThuyInfo['huong_xau'] as $key => $direction) {
            if ($direction === $houseDirectionName) {
                $result['is_good'] = false;
                $result['quality_key'] = $key;

                // LẤY TÊN CUNG CÓ DẤU TỪ DATAHELPER
                $result['quality_name'] = DataHelper::$cungBatTrachNames[$key] ?? str_replace('_', ' ', ucwords($key, '_'));
                
                // Lấy mô tả từ DataHelper
                $result['description'] = DataHelper::$cungBatTrachDescriptions[$key] ?? 'Hướng xấu.';

                $result['conclusion'] = sprintf(
                    'Hướng nhà <strong>%s</strong> không thuộc nhóm hướng hợp với tuổi của gia chủ (<strong>%s</strong>). Đây là hướng không hợp mệnh (phạm phải cung %s), có thể ảnh hưởng đến tài lộc và sức khỏe nếu không được hóa giải đúng cách.<br>👉 Nên xem xét các biện pháp hóa giải phong thủy để chuyển hung thành cát.',
                    $houseDirectionName, $phongThuyInfo['nhom'], "<strong>" . $result['quality_name'] . "</strong>"
                );
                return $result;
            }
        }

        return $result;
    }

    public function showDayDetails(Request $request, $date)
    {
        // 1. Validate dữ liệu
         $validated = Validator::make(['date' => $date, 'birthdate' => $request->input('birthdate')], [
            'date' => 'required|date_format:Y-m-d',
            'birthdate' => 'required|date_format:Y-m-d',
        ])->validate();

        // 2. Chuẩn bị các đối tượng ngày tháng
        $dateToCheck = Carbon::parse($validated['date']);
        $groomDob = Carbon::parse($validated['birthdate']);

        // 3. Lấy thông tin chung của ngày (tính 1 lần, vì nó không đổi)
        $commonDayInfo = BadDayHelper::getdetailtable($dateToCheck);
        $tabooResult = GoodBadDayHelper::checkTabooDays($dateToCheck, 'NHAP_TRACH');

        // 4. Lấy thông tin chi tiết cho người xem
        // Sử dụng năm âm lịch để tính toán
        $lunarDob = LunarHelper::convertSolar2Lunar($groomDob->day, $groomDob->month, $groomDob->year);
        $lunarBirthYear = $lunarDob[2];

        // Tạo một Carbon object với năm âm lịch để truyền vào helper
        $lunarDateForAnalysis = Carbon::create($lunarBirthYear, $groomDob->month, $groomDob->day);
        $groomData = BadDayHelper::getDetailedAnalysisForPerson($dateToCheck, $lunarDateForAnalysis, 'Ngày nhập trạch', 'NHAP_TRACH');

        // 5. Trả về view với toàn bộ dữ liệu
        return view('tools.nhap-trach.day_details', compact(
            'commonDayInfo',
            'groomData',
            'tabooResult',
        ));
    }
}