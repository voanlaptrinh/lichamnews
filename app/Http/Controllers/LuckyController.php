<?php

namespace App\Http\Controllers;

use App\Helpers\LuckyElementsHelper;
use App\Helpers\NumerologyHelper;
use Illuminate\Http\Request;
use Exception;
class LuckyController extends Controller
{
    /**
     * Hiển thị trang chính thần số học
     */
    public function index()
    {
        return view('than-so-hoc.index');
    }

    /**
     * Tính toán thần số học đầy đủ
     */
    public function calculate(Request $request)
    {
     
        try {
            // Validate input
            $request->validate([
                'full_name' => 'required|string|min:2|max:100',
                'birthdate' => 'required|string',
                'gender' => 'required|in:nam,nữ,male,female'
            ], [
                'full_name.required' => 'Vui lòng nhập họ tên đầy đủ',
                'full_name.min' => 'Tên phải có ít nhất 2 ký tự',
                'birthdate.required' => 'Vui lòng chọn ngày sinh',
                'gender.required' => 'Vui lòng chọn giới tính'
            ]);

            // Parse birthdate (format: MM/DD/YYYY or YYYY-MM-DD)
            $birthDateParts = [];
            if (strpos($request->birthdate, '/') !== false) {
                // Format: MM/DD/YYYY
                $birthDateParts = explode('/', $request->birthdate);
                if (count($birthDateParts) === 3) {
                    $month = (int) $birthDateParts[0];
                    $day = (int) $birthDateParts[1];
                    $year = (int) $birthDateParts[2];
                }
            } else {
                // Format: YYYY-MM-DD
                $birthDateParts = explode('-', $request->birthdate);
                if (count($birthDateParts) === 3) {
                    $year = (int) $birthDateParts[0];
                    $month = (int) $birthDateParts[1];
                    $day = (int) $birthDateParts[2];
                }
            }

            if (count($birthDateParts) !== 3) {
                return back()->withErrors(['birthdate' => 'Ngày sinh không đúng định dạng'])->withInput();
            }

            // Validate birth date
            if (!checkdate($month, $day, $year)) {
                return back()->withErrors(['birthdate' => 'Ngày sinh không hợp lệ'])->withInput();
            }

            // Prepare data
            $birthDate = [
                'day' => $day,
                'month' => $month,
                'year' => $year
            ];

            // Convert gender to English format for internal processing
            $gender = $request->gender;
            if ($gender === 'nam') {
                $gender = 'male';
            } elseif ($gender === 'nữ') {
                $gender = 'female';
            }

            $fullName = trim($request->full_name);

            // Calculate complete numerology profile
            $profile = NumerologyHelper::getCompleteNumerologyProfile($birthDate, $fullName);

            // Calculate lucky elements
            $user = [
                'birth_date' => $birthDate,
                'gender' => $gender
            ];
            $selectedDate = [
                'year' => date('Y'),
                'month' => date('n'),
                'day' => date('j')
            ];

            $luckyColors = LuckyElementsHelper::getLuckyColors($birthDate, $selectedDate);
            $luckyNumbers = LuckyElementsHelper::getLuckyNumbers($user, $selectedDate);
            $luckyDirections = LuckyElementsHelper::getLuckyDirections($user, $selectedDate);
            $dailyColor = LuckyElementsHelper::getDailyLuckyColor($selectedDate);

            return view('than-so-hoc.result', compact(
                'profile',
                'luckyColors',
                'luckyNumbers',
                'luckyDirections',
                'dailyColor',
                'birthDate',
                'fullName',
                'request'
            ));

        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * API để tính toán từng phần riêng biệt
     */
    public function calculateBasic(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required|string',
                'birth_day' => 'required|integer|min:1|max:31',
                'birth_month' => 'required|integer|min:1|max:12',
                'birth_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            ]);

            $birthDate = [
                'day' => $request->birth_day,
                'month' => $request->birth_month,
                'year' => $request->birth_year
            ];

            $basic = [
                'life_path' => NumerologyHelper::calculateLifePath($birthDate),
                'birth_day' => NumerologyHelper::calculateBirthDayNumber($birthDate),
                'expression' => NumerologyHelper::calculateExpressionNumber($request->full_name),
                'soul_urge' => NumerologyHelper::calculateSoulUrge($request->full_name),
                'personality' => NumerologyHelper::calculatePersonalityNumber($request->full_name),
            ];

            return response()->json([
                'success' => true,
                'data' => $basic
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * API cho chu kỳ và đỉnh cao
     */
    public function calculateCycles(Request $request)
    {
        try {
            $request->validate([
                'birth_day' => 'required|integer',
                'birth_month' => 'required|integer',
                'birth_year' => 'required|integer',
            ]);

            $birthDate = [
                'day' => $request->birth_day,
                'month' => $request->birth_month,
                'year' => $request->birth_year
            ];

            $cycles = [
                'personal_year' => NumerologyHelper::calculatePersonalYear($birthDate),
                'nine_year_cycle' => NumerologyHelper::calculateNineYearCycle($birthDate),
                'life_pinnacles' => NumerologyHelper::calculateLifePinnacles($birthDate),
            ];

            return response()->json([
                'success' => true,
                'data' => $cycles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * API cho biểu đồ và mui tên
     */
    public function calculateCharts(Request $request)
    {
        try {
            $birthDate = [
                'day' => $request->birth_day,
                'month' => $request->birth_month,
                'year' => $request->birth_year
            ];

            $birthChart = NumerologyHelper::calculateBirthChart($birthDate);
            $arrows = NumerologyHelper::calculateArrows($birthChart);

            return response()->json([
                'success' => true,
                'data' => [
                    'birth_chart' => $birthChart,
                    'arrows' => $arrows
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * API cho lucky elements
     */
    public function calculateLucky(Request $request)
    {
        try {
            $birthDate = [
                'day' => $request->birth_day,
                'month' => $request->birth_month,
                'year' => $request->birth_year
            ];

            $user = [
                'birth_date' => $birthDate,
                'gender' => $request->gender ?? 'male'
            ];

            $selectedDate = [
                'year' => date('Y'),
                'month' => date('n'),
                'day' => date('j')
            ];

            $lucky = [
                'colors' => LuckyElementsHelper::getLuckyColors($birthDate, $selectedDate),
                'numbers' => LuckyElementsHelper::getLuckyNumbers($user, $selectedDate),
                'directions' => LuckyElementsHelper::getLuckyDirections($user, $selectedDate),
                'daily_color' => LuckyElementsHelper::getDailyLuckyColor($selectedDate)
            ];

            return response()->json([
                'success' => true,
                'data' => $lucky
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Tính toán năng lực bẩm sinh
     */
    public function calculateAbilities(Request $request)
    {
        try {
            $abilities = NumerologyHelper::calculateInnateAbilities($request->full_name);

            // Add interpretations for each ability
            $abilitiesWithInterpretations = [];
            foreach ($abilities as $abilityName => $abilityData) {
                $interpretation = NumerologyHelper::getInnateAbilitiesInterpretation($abilityName, $abilityData['count']);
                $abilitiesWithInterpretations[$abilityName] = [
                    'count' => $abilityData['count'],
                    'letters' => $abilityData['letters'],
                    'title' => $interpretation['title'],
                    'level' => $interpretation['level'],
                    'description' => $interpretation['description']
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $abilitiesWithInterpretations
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Tính toán nghiệp quả
     */
    public function calculateKarmic(Request $request)
    {
        try {
            $birthDate = [
                'day' => $request->birth_day,
                'month' => $request->birth_month,
                'year' => $request->birth_year
            ];

            $karmic = [
                'lessons' => NumerologyHelper::calculateKarmicLessons($request->full_name),
                'debt' => NumerologyHelper::calculateKarmicDebt($birthDate, $request->full_name)
            ];

            return response()->json([
                'success' => true,
                'data' => $karmic
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Export PDF (tùy chọn)
     */
    public function exportPdf(Request $request)
    {
        // Implementation for PDF export if needed
        return response()->json(['message' => 'PDF export feature coming soon']);
    }

    /**
     * Chi tiết ý nghĩa ngày sinh
     */
    public function birthDayDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11,22])) {
            abort(404);
        }

        $data = NumerologyHelper::calculateBirthDayNumber(['day' => $number]);

        return view('than-so-hoc.number-detail', [
            'type' => 'birth_day',
            'number' => $number,
            'title' => 'Ý Nghĩa Ngày Sinh ' . $number,
            'data' => $data,
            'pageTitle' => 'Ý Nghĩa Ngày Sinh ' . $number . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa số tên
     */
    public function expressionDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11,22])) {
            abort(404);
        }

        $data = [
            'number' => $number,
            'calculation' => "Tính từ tổng giá trị các chữ cái trong họ tên đầy đủ",
            'interpretation' => NumerologyHelper::getExpressionInterpretationsData()[$number]['fullText'] ?? "Chưa có diễn giải chi tiết cho số tên {$number}.",
            'sections' => [
                [
                    'title' => 'Lời khuyên',
                    'content' => isset(NumerologyHelper::getExpressionInterpretationsData()[$number]['advice']) ?
                        implode(' ', NumerologyHelper::getExpressionInterpretationsData()[$number]['advice']) : ''
                ]
            ]
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'expression',
            'number' => $number,
            'title' => 'Ý Nghĩa Số Tên ' . $number,
            'data' => $data,
            'pageTitle' => 'Ý Nghĩa Số Tên ' . $number . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa số linh hồn
     */
    public function soulUrgeDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11,22])) {
            abort(404);
        }

        $interpretationsData = NumerologyHelper::getSoulUrgeInterpretationsData();
        $numberData = $interpretationsData[$number] ?? null;

        if (!$numberData) {
            abort(404);
        }

        $data = [
            'number' => $number,
            'title' => $numberData['title'],
            'calculation' => $numberData['calculation'],
            'interpretation' => $numberData['fullText'],
            'sections' => [
                [
                    'title' => 'Điểm mạnh nổi bật',
                    'content' => !empty($numberData['strengths']) ? implode('; ', $numberData['strengths']) : ''
                ],
                [
                    'title' => 'Thách Thức cần lưu ý',
                    'content' => !empty($numberData['challenges']) ? implode('; ', $numberData['challenges']) : ''
                ],
                [
                    'title' => 'Sự nghiệp Phù Hợp',
                    'content' => !empty($numberData['careerFit']) ? implode('; ', $numberData['careerFit']) : ''
                ],
                [
                    'title' => 'Tình Yêu & Mối Quan Hệ',
                    'content' => !empty($numberData['loveGuidance']) ? implode(' ', $numberData['loveGuidance']) : ''
                ],
                [
                    'title' => 'Lời nhắn từ vũ trụ dành cho bạn',
                    'content' => !empty($numberData['advice']) ? implode(' ', $numberData['advice']) : ''
                ],
                
            ]
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'soul_urge',
            'number' => $number,
            'title' => 'Ý Nghĩa Số Linh Hồn ' . $number,
            'data' => $data,
            'pageTitle' => 'Ý Nghĩa Số Linh Hồn ' . $number . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa số tính cách
     */
    public function personalityDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11,22])) {
            abort(404);
        }

        $interpretationsData = NumerologyHelper::getPersonalityInterpretationsData();
        $numberData = $interpretationsData[$number] ?? null;

        if (!$numberData) {
            abort(404);
        }

        $data = [
            'number' => $number,
            'title' => $numberData['title'],
            'calculation' => $numberData['calculation'],
            'interpretation' => $numberData['characteristics'],
            'sections' => [
                [
                    'title' => 'Đặc điểm chính',
                    'content' => $numberData['characteristics']
                ],
                [
                    'title' => 'Nghề nghiệp phù hợp',
                    'content' => $numberData['career']
                ],
                [
                    'title' => 'Tình yêu & Mối quan hệ',
                    'content' => $numberData['relationships']
                ],
                [
                    'title' => 'Thách thức cần lưu ý',
                    'content' => !empty($numberData['challenges']) ? implode('; ', $numberData['challenges']) : ''
                ],
                [
                    'title' => 'Lời khuyên từ vũ trụ',
                    'content' => !empty($numberData['advice']) ? implode('; ', $numberData['advice']) : ''
                ]
            ]
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'personality',
            'number' => $number,
            'title' => 'Ý Nghĩa Số Tính Cách ' . $number,
            'data' => $data,
            'pageTitle' => 'Ý Nghĩa Số Tính Cách ' . $number . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa số thái độ
     */
    public function attitudeDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11])) {
            abort(404);
        }

        $interpretationsData = NumerologyHelper::getAttitudeNumberInterpretationsData();
        $numberData = $interpretationsData[$number] ?? null;

        if (!$numberData) {
            abort(404);
        }

        $data = [
            'number' => $number,
            'title' => $numberData['title'],
            'calculation' => $numberData['calculation'],
            'interpretation' => $numberData['prominentCharacteristics'],
            'sections' => [
                [
                    'title' => 'Ấn tượng đầu tiên',
                    'content' => $numberData['firstImpression']
                ],
                [
                    'title' => 'Phản ứng tự nhiên',
                    'content' => $numberData['naturalReaction']
                ],
                [
                    'title' => 'Mặt tối tiềm ẩn',
                    'content' => $numberData['darkSide']
                ],
                [
                    'title' => 'Ứng dụng thực tiễn',
                    'content' => $numberData['practicalApplication']
                ]
            ]
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'attitude',
            'number' => $number,
            'title' => 'Ý Nghĩa Số Thái Độ ' . $number,
            'data' => $data,
            'pageTitle' => 'Ý Nghĩa Số Thái Độ ' . $number . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa số trưởng thành
     */
    public function maturityDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9,11,22,33])) {
            abort(404);
        }

        $interpretationsData = NumerologyHelper::getMaturityNumberInterpretationsData();

        if (!isset($interpretationsData[$number])) {
            abort(404);
        }

        $numberData = $interpretationsData[$number];

        $data = [
            'title' => $numberData['title'],
            'calculation' => $numberData['calculation'],
            'interpretation' => $numberData['interpretation'],
            'sections' => $numberData['sections']
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'maturity',
            'number' => $number,
            'title' => $numberData['title'],
            'data' => $data,
            'pageTitle' => $numberData['title'] . ' | Thần Số Học'
        ]);
    }

    /**
     * Chi tiết ý nghĩa năm cá nhân
     */
    public function personalYearDetail($number)
    {
        if (!is_numeric($number) || !in_array($number, [1,2,3,4,5,6,7,8,9])) {
            abort(404);
        }

        $interpretationsData = NumerologyHelper::getPersonalYearInterpretationsData();

        if (!isset($interpretationsData[$number])) {
            abort(404);
        }

        $numberData = $interpretationsData[$number];

        // Organize data into sections for the template
        $data = [
            'title' => $numberData['title'],
            'calculation' => 'Tính từ ngày, tháng sinh và năm hiện tại',
            'interpretation' => $numberData['overview'],
            'sections' => [
                [
                    'title' => '💼 Sự nghiệp',
                    'content' => $numberData['career']
                ],
                [
                    'title' => '💰 Tài chính',
                    'content' => $numberData['financial']
                ],
                [
                    'title' => '❤️ Tình cảm',
                    'content' => $numberData['love']
                ],
                [
                    'title' => '🌱 Phát triển cá nhân',
                    'content' => $numberData['personalDevelopment']
                ],
                [
                    'title' => '🌟 Cơ hội',
                    'content' => implode('. ', $numberData['opportunities']) . '.'
                ],
                [
                    'title' => '⚠️ Thách thức',
                    'content' => implode('. ', $numberData['challenges']) . '.'
                ],
                [
                    'title' => '🌌 Thông điệp từ vũ trụ',
                    'content' => $numberData['universeMessage']
                ]
            ]
        ];

        return view('than-so-hoc.number-detail', [
            'type' => 'personal_year',
            'number' => $number,
            'title' => $numberData['title'],
            'data' => $data,
            'pageTitle' => $numberData['title'] . ' | Thần Số Học'
        ]);
    }
}
