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

            // Validate input
            if (!$month || !$year || $month < 1 || $month > 12) {
                return response()->json([
                    'success' => false,
                    'error' => 'Tháng hoặc năm không hợp lệ'
                ], 400);
            }

            // Calculate the actual number of days in the lunar month using helper function
            $days = $this->calculateLunarMonthDays($month, $year);

            return response()->json([
                'success' => true,
                'days' => $days,
                'month' => $month,
                'year' => $year
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
            // Convert lunar month start (day 1) to solar date
            $solarStart = LunarHelper::convertLunar2Solar(1, $month, $year, $isLeap);

            // Try day 30 first, if it doesn't exist, the month has 29 days
            $solarDay30 = LunarHelper::convertLunar2Solar(30, $month, $year, $isLeap);

            // If day 30 conversion returns valid result (day != 0), month has 30 days
            if ($solarDay30[0] != 0) {
                return 30;
            } else {
                return 29;
            }
        } catch (\Exception $e) {
            // Fallback to safe default
            return 29;
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
}
