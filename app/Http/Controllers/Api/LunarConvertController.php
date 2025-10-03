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

            // Convert lunar to solar using LunarHelper
            $solarDate = LunarHelper::convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, 0); // 0 = không nhuận

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
    private function calculateLunarMonthDays($month, $year)
    {
        try {
            // Convert lunar month start (day 1) to solar date
            $solarStart = LunarHelper::convertLunar2Solar(1, $month, $year, 0);

            // Try day 30 first, if it doesn't exist, the month has 29 days
            $solarDay30 = LunarHelper::convertLunar2Solar(30, $month, $year, 0);

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
}
