<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemaps = [
            [
                'loc' => URL::to('/sitemap-static.xml'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly'
            ],
            [
                'loc' => URL::to('/sitemap-tools.xml'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly'
            ],
            [
                'loc' => URL::to('/sitemap-years.xml'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly'
            ],
            [
                'loc' => URL::to('/sitemap-months.xml'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly'
            ],
        ];

        // Add day sitemaps (1900 → 2100)
        $startYear = 1900;
        $endYear = 2100;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $sitemaps[] = [
                'loc' => URL::to("/sitemap-days-{$year}.xml"),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly'
            ];
        }

        return response()
            ->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'text/xml');
    }



    public function staticPages()
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('am-lich-hom-nay'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('am-lich-ngay-mai'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('convert.am.to.duong'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('lien-he-voi-chung-toi'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['loc' => route('dieu-khoan'), 'priority' => '0.5', 'changefreq' => 'weekly'],
            ['loc' => route('chinh-sach'), 'priority' => '0.5', 'changefreq' => 'weekly'],
        ];

        foreach ($urls as &$url) {
            $url['lastmod'] = now()->toAtomString();
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }


    public function tools()
    {
        $toolRoutes = [
            'horoscope.index',
            // ... các route khác nếu bật
        ];

        $urls = [];

        foreach ($toolRoutes as $routeName) {
            if (route($routeName, [], false)) {
                $urls[] = [
                    'loc' => route($routeName),
                    'priority' => '0.7',
                    'changefreq' => 'weekly',
                    'lastmod' => now()->toAtomString(),
                ];
            }
        }

        $signSlugs = ['bach-duong', 'kim-nguu', 'song-tu', 'cu-giai', 'su_tu', 'xu-nu', 'thien-binh', 'bo-cap', 'nhan-ma', 'ma-ket', 'bao-binh', 'song-ngu'];
        $typeSlugs = ['hom-qua', 'hom-nay', 'ngay-mai', 'tuan-nay', 'thang-nay', 'nam-nay'];

        foreach ($signSlugs as $signSlug) {
            $urls[] = [
                'loc' => route('horoscope.show', ['signSlug' => $signSlug]),
                'priority' => '0.7',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString(),
            ];

            foreach ($typeSlugs as $typeSlug) {
                $urls[] = [
                    'loc' => route('horoscope.show.type', compact('signSlug', 'typeSlug')),
                    'priority' => '0.6',
                    'changefreq' => 'daily',
                    'lastmod' => now()->toAtomString(),
                ];
            }
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Sitemap theo năm (1900 → 2100)
     */
    public function years()
    {
        $urls = [];
        for ($year = 1900; $year <= 2100; $year++) {
            $urls[] = [
                'loc' => route('lich.nam', ['nam' => $year]),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => now()->toAtomString(),
            ];
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }


    /**
     * Sitemap theo tháng (1900 → 2100)
     */
    public function months()
    {
        $urls = [];

        for ($year = 1900; $year <= 2100; $year++) {
            // Thêm 12 tháng dương lịch
            for ($month = 1; $month <= 12; $month++) {
                $urls[] = [
                    'loc' => route('lich.thang', ['nam' => $year, 'thang' => $month]),
                    'priority' => '0.6',
                    'changefreq' => 'weekly',
                    'lastmod' => now()->toAtomString(),
                ];
            }

            // Kiểm tra và thêm tháng nhuận nếu có
            $yearInfo = \App\Helpers\LunarHelper::getYearInfo($year);
            if (!empty($yearInfo)) {
                // Tìm tháng nhuận trong năm
                foreach ($yearInfo as $monthInfo) {
                    if (isset($monthInfo['leap']) && $monthInfo['leap'] == 1) {
                        $leapMonth = $monthInfo['month'];
                        $urls[] = [
                            'loc' => route('lich.thang.nhuan', ['nam' => $year, 'thang' => $leapMonth]),
                            'priority' => '0.6',
                            'changefreq' => 'weekly',
                            'lastmod' => now()->toAtomString(),
                        ];
                        break; // Mỗi năm chỉ có tối đa 1 tháng nhuận
                    }
                }
            }
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }



    /**
     * Sitemap index cho ngày — chứa link tới từng sitemap theo năm
     */
    public function daysIndex()
    {
        $sitemaps = [];
        for ($year = 1900; $year <= 2100; $year++) {
            $sitemaps[] = [
                'loc' => URL::to("/sitemap-days-{$year}.xml"),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
            ];
        }

        return response()
            ->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'text/xml');
    }


    /**
     * Sitemap các ngày trong 1 năm cụ thể
     */
    public function daysByYear($year)
    {
        $urls = [];
        $startDate = Carbon::create($year, 1, 1);
        $endDate = Carbon::create($year, 12, 31);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $urls[] = [
                'loc' => route('detai_home', [
                    'nam'   => $date->year,
                    'thang' => $date->month,
                    'ngay'  => $date->day,
                ]),
                'priority' => '0.5',
                'changefreq' => 'never',
                'lastmod' => $date->toAtomString(),
            ];
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}
