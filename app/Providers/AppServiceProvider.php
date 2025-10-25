<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\LunarHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('vi');

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Share lunar months data with header view
        View::composer('layout.header', function ($view) {
            $currentYear = date('Y');
            $lunar_months = $this->generateLunarMonthsForYear($currentYear);
            $view->with('header_lunar_months', $lunar_months);
        });
    }

    private function generateLunarMonthsForYear($solar_year)
    {
        $lunar_months = [];

        // Check both previous and current lunar years
        $lunar_years_to_check = [$solar_year - 1, $solar_year];

        foreach ($lunar_years_to_check as $lunar_year) {
            // Check if this lunar year has a leap month
            list($solar_d_11_prev, $solar_m_11_prev, $solar_y_11_prev) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year - 1, 0);
            list($solar_d_11, $solar_m_11, $solar_y_11) = LunarHelper::convertLunar2Solar(1, 11, $lunar_year, 0);

            $has_leap_month = false;
            $leap_month_number = 0;

            if ($solar_d_11_prev > 0 && $solar_d_11 > 0) {
                $days_between = (mktime(0, 0, 0, $solar_m_11, $solar_d_11, $solar_y_11) -
                                mktime(0, 0, 0, $solar_m_11_prev, $solar_d_11_prev, $solar_y_11_prev)) / 86400;

                if ($days_between > 365) {
                    // This lunar year has a leap month, find which one
                    for ($test_month = 1; $test_month <= 12; $test_month++) {
                        list($leap_d, $leap_m, $leap_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 1);

                        if ($leap_d > 0) {
                            list($regular_d, $regular_m, $regular_y) = LunarHelper::convertLunar2Solar(1, $test_month, $lunar_year, 0);

                            if ($regular_d > 0 && !($leap_d == $regular_d && $leap_m == $regular_m && $leap_y == $regular_y)) {
                                $leap_month_number = $test_month;
                                $has_leap_month = true;
                                break;
                            }
                        }
                    }
                }
            }

            // Add regular months that fall within this solar year
            for ($lunar_month = 1; $lunar_month <= 12; $lunar_month++) {
                list($dd, $mm, $yy) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 0);

                if ($dd > 0 && $yy == $solar_year) {
                    $found = false;
                    foreach ($lunar_months as $existing) {
                        if ($existing['lunar_month'] == $lunar_month &&
                            $existing['lunar_year'] == $lunar_year &&
                            !$existing['is_leap']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $lunar_months[] = [
                            'lunar_month' => $lunar_month,
                            'lunar_year' => $lunar_year,
                            'is_leap' => false,
                            'solar_month' => $mm,
                            'solar_year' => $yy
                        ];
                    }
                }

                // Also check for leap month if this is the leap month number
                if ($has_leap_month && $lunar_month == $leap_month_number) {
                    list($dd_leap, $mm_leap, $yy_leap) = LunarHelper::convertLunar2Solar(1, $lunar_month, $lunar_year, 1);

                    if ($dd_leap > 0 && $yy_leap == $solar_year) {
                        $found = false;
                        foreach ($lunar_months as $existing) {
                            if ($existing['lunar_month'] == $lunar_month &&
                                $existing['lunar_year'] == $lunar_year &&
                                $existing['is_leap']) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            $lunar_months[] = [
                                'lunar_month' => $lunar_month,
                                'lunar_year' => $lunar_year,
                                'is_leap' => true,
                                'solar_month' => $mm_leap,
                                'solar_year' => $yy_leap
                            ];
                        }
                    }
                }
            }
        }

        // Sort by solar date appearance
        usort($lunar_months, function($a, $b) {
            list($a_d, $a_m, $a_y) = LunarHelper::convertLunar2Solar(1, $a['lunar_month'], $a['lunar_year'], $a['is_leap'] ? 1 : 0);
            list($b_d, $b_m, $b_y) = LunarHelper::convertLunar2Solar(1, $b['lunar_month'], $b['lunar_year'], $b['is_leap'] ? 1 : 0);

            $a_timestamp = mktime(0, 0, 0, $a_m, $a_d, $a_y);
            $b_timestamp = mktime(0, 0, 0, $b_m, $b_d, $b_y);

            return $a_timestamp - $b_timestamp;
        });

        return $lunar_months;
    }
}
