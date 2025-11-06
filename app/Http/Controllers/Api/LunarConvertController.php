<?php

namespace App\Http\Controllers\Api;

use App\Helpers\LunarHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LunarConvertController extends Controller
{
   public function convertToAm(Request $request)
    {
        $date = $request->input('date');
        try {
            [$yy, $mm, $dd] = explode('-', $date);
            $al = LunarHelper::convertSolar2Lunar((int)$dd, (int)$mm, (int)$yy);
            $amDate = sprintf('%04d-%02d-%02d', $al[2], $al[1], $al[0]);
            return response()->json(['date' => $amDate]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi chuyển đổi dương -> âm'], 400);
        }
    }

    public function convertToDuong(Request $request)
    {
        $date = $request->input('date');
        try {
            [$yy, $mm, $dd] = explode('-', $date);
            $dl = LunarHelper::convertLunar2Solar((int)$dd, (int)$mm, (int)$yy, 0); // mặc định không nhuận
            $duongDate = sprintf('%04d-%02d-%02d', $dl[2], $dl[1], $dl[0]);
            return response()->json(['date' => $duongDate]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi chuyển đổi âm -> dương'], 400);
        }
    }

    public function convertLunarToSolar(Request $request)
    {
        try {
            $lunarDay = $request->input('lunarDay');
            $lunarMonth = $request->input('lunarMonth');
            $lunarYear = $request->input('lunarYear');
            $isLeap = $request->input('isLeap', 0); // Default to 0 (not leap) if not provided

            // Convert lunar to solar using LunarHelper
            $solarDate = LunarHelper::convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $isLeap);

            return response()->json([
                'success' => true,
                'solarDay' => $solarDate[0],
                'solarMonth' => $solarDate[1],
                'solarYear' => $solarDate[2]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi chuyển đổi âm lịch sang dương lịch'
            ], 400);
        }
    }

    public function convertSolarToLunar(Request $request)
    {
        try {
            $solarDay = $request->input('solarDay');
            $solarMonth = $request->input('solarMonth');
            $solarYear = $request->input('solarYear');

            // Convert solar to lunar using LunarHelper
            $lunarDate = LunarHelper::convertSolar2Lunar($solarDay, $solarMonth, $solarYear);

            return response()->json([
                'success' => true,
                'lunarDay' => $lunarDate[0],
                'lunarMonth' => $lunarDate[1],
                'lunarYear' => $lunarDate[2]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi chuyển đổi dương lịch sang âm lịch'
            ], 400);
        }
    }

    public function getMonthLunarDates(Request $request)
    {
        try {
            $month = $request->input('month');
            $year = $request->input('year');

            // Get number of days in month
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            // Convert all days in the month
            $lunarDates = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $lunarDate = LunarHelper::convertSolar2Lunar($day, $month, $year);
                $lunarDates[$day] = [
                    'lunarDay' => $lunarDate[0],
                    'lunarMonth' => $lunarDate[1],
                    'lunarYear' => $lunarDate[2]
                ];
            }

            return response()->json([
                'success' => true,
                'dates' => $lunarDates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi lấy dữ liệu âm lịch cho tháng'
            ], 400);
        }
    }

    public function getLunarMonthDays(Request $request)
    {
        try {
            $month = $request->input('month');
            $year = $request->input('year');
            $isLeap = $request->input('isLeap', 0);

            // Validate input
            if (!$month || !$year || $month < 1 || $month > 12) {
                return response()->json([
                    'success' => false,
                    'error' => 'Tháng hoặc năm không hợp lệ'
                ], 400);
            }

            // Calculate the actual number of days in the lunar month using helper function
            $days = $this->calculateLunarMonthDays($month, $year, $isLeap);

            return response()->json([
                'success' => true,
                'days' => $days,
                'month' => $month,
                'year' => $year,
                'isLeap' => $isLeap
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi lấy số ngày trong tháng âm lịch'
            ], 400);
        }
    }

    /**
     * Calculate actual number of days in a lunar month using helper functions
     */
    private function calculateLunarMonthDays($month, $year, $isLeap = 0)
    {
        try {
            // First check if the month/year/leap combination is valid
            $solarStart = @LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);

            if (!$solarStart || !isset($solarStart[0]) || $solarStart[0] == 0) {
                // Invalid month (probably doesn't have leap version if isLeap=1)
                return 0;
            }

            // Check if leap month actually exists by comparing with normal month
            if ($isLeap == 1) {
                $normalStart = @LunarHelper::convertLunar2Solar(1, $month, $year, 0);
                // If both return same date, there's no actual leap month
                if ($normalStart && $normalStart[0] == $solarStart[0] &&
                    $normalStart[1] == $solarStart[1] &&
                    $normalStart[2] == $solarStart[2]) {
                    return 0; // No leap month exists
                }
            }

            // NEW METHOD: Calculate days between start of this month and start of next month
            // This is the most accurate way to determine lunar month length

            // Get the first day of the current month in solar calendar
            $currentMonthStart = LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);

            // Determine what the next lunar month is
            $nextMonth = $month;
            $nextYear = $year;
            $nextIsLeap = 0;

            if ($isLeap == 0) {
                // Current is normal month, check if leap version exists
                $leapTest = @LunarHelper::convertLunar2Solar(15, $month, $year, 1);
                $normalTest = @LunarHelper::convertLunar2Solar(15, $month, $year, 0);

                if ($leapTest && $normalTest &&
                    !($leapTest[0] == $normalTest[0] &&
                      $leapTest[1] == $normalTest[1] &&
                      $leapTest[2] == $normalTest[2])) {
                    // Leap month exists for this month number
                    $nextIsLeap = 1;
                } else {
                    // No leap month, go to next month number
                    $nextMonth++;
                    if ($nextMonth > 12) {
                        $nextMonth = 1;
                        $nextYear++;
                    }
                }
            } else {
                // Current is leap month, next is always the next regular month
                $nextMonth++;
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
            }

            // Get the first day of next month
            $nextMonthStart = @LunarHelper::convertLunar2Solar(1, $nextMonth, $nextYear, $nextIsLeap);

            if ($currentMonthStart && $nextMonthStart &&
                isset($currentMonthStart[0]) && isset($nextMonthStart[0])) {

                // Calculate the difference in days
                $currentDate = new \DateTime();
                $currentDate->setDate($currentMonthStart[2], $currentMonthStart[1], $currentMonthStart[0]);

                $nextDate = new \DateTime();
                $nextDate->setDate($nextMonthStart[2], $nextMonthStart[1], $nextMonthStart[0]);

                $interval = $currentDate->diff($nextDate);
                $days = $interval->days;

                // Lunar months are always 29 or 30 days
                if ($days == 29 || $days == 30) {
                    return $days;
                }
            }

            // Fallback method: Check if day 30 converts to valid date
            $day30 = @LunarHelper::convertLunar2Solar(30, $month, $year, $isLeap);

            if ($day30 && isset($day30[0]) && $day30[0] > 0) {
                // Check if day 30 is really in this month by comparing with day 29
                $day29 = @LunarHelper::convertLunar2Solar(29, $month, $year, $isLeap);

                if ($day29 && isset($day29[0])) {
                    $date29 = new \DateTime();
                    $date29->setDate($day29[2], $day29[1], $day29[0]);

                    $date30 = new \DateTime();
                    $date30->setDate($day30[2], $day30[1], $day30[0]);

                    $diff = $date29->diff($date30)->days;

                    // If day 30 is exactly 1 day after day 29, month has 30 days
                    if ($diff == 1) {
                        return 30;
                    }
                }
            }

            // Default to 29 days (most common for lunar months)
            return 29;

        } catch (\Exception $e) {
            // If conversion fails completely, return 0 to indicate invalid
            return 0;
        }
    }

    /**
     * Get complete lunar month calendar with all days and solar date mappings
     */
    public function getLunarMonthCalendar(Request $request)
    {
        try {
            $month = $request->input('month');
            $year = $request->input('year');
            $isLeap = $request->input('isLeap', 0);

            // Validate input
            if (!$month || !$year || $month < 1 || $month > 12) {
                return response()->json([
                    'success' => false,
                    'error' => 'Tháng hoặc năm không hợp lệ'
                ], 400);
            }

            // Check if this month has a leap version
            $hasLeapMonth = false;
            $leapMonthNumber = 0;

            // Check for leap month in this year
            for ($m = 1; $m <= 12; $m++) {
                $leapTest = LunarHelper::convertLunar2Solar(1, $m, $year, 1);
                $regularTest = LunarHelper::convertLunar2Solar(1, $m, $year, 0);

                if ($leapTest[0] > 0 && $regularTest[0] > 0 &&
                    ($leapTest[0] != $regularTest[0] || $leapTest[1] != $regularTest[1])) {
                    $leapMonthNumber = $m;
                    if ($m == $month) {
                        $hasLeapMonth = true;
                    }
                    break;
                }
            }

            // Get number of days in this lunar month
            $daysInMonth = $this->calculateLunarMonthDays($month, $year, $isLeap);

            // Get solar dates for each lunar day
            $days = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $solarDate = LunarHelper::convertLunar2Solar($day, $month, $year, $isLeap);

                if ($solarDate[0] > 0) {
                    $solarDateTime = new \DateTime();
                    $solarDateTime->setDate($solarDate[2], $solarDate[1], $solarDate[0]);

                    $days[] = [
                        'lunarDay' => $day,
                        'solarDay' => $solarDate[0],
                        'solarMonth' => $solarDate[1],
                        'solarYear' => $solarDate[2],
                        'dayOfWeek' => $solarDateTime->format('w'), // 0 = Sunday, 6 = Saturday
                        'dayName' => $this->getDayName($solarDateTime->format('w'))
                    ];
                }
            }

            // Get first day info for calendar alignment
            $firstDaySolar = LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);
            $firstDayDateTime = new \DateTime();
            $firstDayDateTime->setDate($firstDaySolar[2], $firstDaySolar[1], $firstDaySolar[0]);
            $firstDayOfWeek = $firstDayDateTime->format('w');

            return response()->json([
                'success' => true,
                'month' => $month,
                'year' => $year,
                'isLeap' => $isLeap,
                'hasLeapMonth' => $hasLeapMonth,
                'leapMonthNumber' => $leapMonthNumber,
                'daysInMonth' => $daysInMonth,
                'firstDayOfWeek' => (int)$firstDayOfWeek,
                'days' => $days
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi lấy lịch tháng âm: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get Vietnamese day name
     */
    private function getDayName($dayOfWeek)
    {
        $days = [
            0 => 'Chủ Nhật',
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy'
        ];

        return $days[$dayOfWeek] ?? '';
    }

    /**
     * Get all leap months info for a year in one API call
     * Returns: array of leap month numbers with their days count
     */
    public function getYearLeapMonths(Request $request)
    {
        try {
            $year = $request->input('year');

            // Validate input
            if (!$year || $year < 1900 || $year > 2100) {
                return response()->json([
                    'success' => false,
                    'error' => 'Năm không hợp lệ'
                ], 400);
            }

            $leapMonths = [];
            $allMonthsData = [];

            // Check each month to see if it has a leap version
            for ($month = 1; $month <= 12; $month++) {
                try {
                    // Get regular month days
                    $regularDays = $this->calculateLunarMonthDays($month, $year, 0);

                    // Get leap month days
                    $leapDays = $this->calculateLunarMonthDays($month, $year, 1);

                    $allMonthsData[$month] = [
                        'month' => $month,
                        'regularDays' => $regularDays,
                        'hasLeapMonth' => $leapDays > 0,
                        'leapDays' => $leapDays
                    ];

                    // If leap month exists and has valid days
                    if ($leapDays > 0) {
                        $leapMonths[] = $month;
                    }

                } catch (\Exception $e) {
                    // Log error but continue with other months
                    error_log("Error checking month {$month}/{$year}: " . $e->getMessage());

                    $allMonthsData[$month] = [
                        'month' => $month,
                        'regularDays' => 29, // fallback
                        'hasLeapMonth' => false,
                        'leapDays' => 0
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'year' => (int)$year,
                'leapMonths' => $leapMonths,
                'allMonthsData' => $allMonthsData,
                'totalLeapMonths' => count($leapMonths)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi lấy thông tin tháng nhuận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Universal convert method for JS module
     */
    public function convert(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:1900|max:2100',
            'type' => 'required|in:lunar-to-solar,solar-to-lunar',
            'isLeap' => 'boolean'
        ]);

        $day = (int)$validated['day'];
        $month = (int)$validated['month'];
        $year = (int)$validated['year'];
        $type = $validated['type'];
        $isLeap = $validated['isLeap'] ?? false;

        try {
            if ($type === 'lunar-to-solar') {
                // Convert lunar to solar with leap month consideration
                $result = LunarHelper::convertLunar2Solar($day, $month, $year, $isLeap);

                if ($result && $result[0] > 0) {
                    return response()->json([
                        'success' => true,
                        'day' => $result[0],
                        'month' => $result[1],
                        'year' => $result[2],
                        'formatted' => sprintf('%02d/%02d/%04d', $result[0], $result[1], $result[2]),
                        'type' => 'solar',
                        'wasLeap' => $isLeap
                    ]);
                }
            } else {
                // Convert solar to lunar
                $result = LunarHelper::convertSolar2Lunar($day, $month, $year);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'day' => $result[0],
                        'month' => $result[1],
                        'year' => $result[2],
                        'formatted' => sprintf('%02d/%02d/%04d', $result[0], $result[1], $result[2]),
                        'isLeap' => $result[3] ?? false,
                        'type' => 'lunar'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể chuyển đổi ngày tháng'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi chuyển đổi: ' . $e->getMessage()
            ], 500);
        }
    }
}
