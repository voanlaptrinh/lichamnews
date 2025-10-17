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
            URL::to('/sitemap-static.xml'),
            URL::to('/sitemap-tools.xml'),
            // URL::to('/sitemap-posts.xml'),
            URL::to('/sitemap-years.xml'),
            URL::to('/sitemap-months.xml'),
        ];

        // Add day sitemaps (1900 → 2100)
        $startYear = 1900;
        $endYear = 2100;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $sitemaps[] = URL::to("/sitemap-days-{$year}.xml");
            // hoặc nếu có route đặt tên rõ:
            // $sitemaps[] = route('sitemap.days', ['year' => $year]);
        }

        return response()
            ->view('sitemap.index', ['sitemaps' => $sitemaps])
            ->header('Content-Type', 'text/xml');
    }


    public function staticPages()
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('am-lich-hom-nay'), 'priority' => '0.8'],
            ['loc' => route('am-lich-ngay-mai'), 'priority' => '0.8'],
            ['loc' => route('convert.am.to.duong'), 'priority' => '0.8'],
            ['loc' => route('lien-he-voi-chung-toi'), 'priority' => '0.6'],
            ['loc' => route('dieu-khoan'), 'priority' => '0.5'],
            ['loc' => route('chinh-sach'), 'priority' => '0.5'],
        ];

        // Horoscope pages


        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }

    public function tools()
    {
        $toolRoutes = [
            'horoscope.index',
            // 'astrology.form',
            // 'buy-house.form',
            // 'breaking.form',
            // 'nhap-trach.form',
            // 'xuat-hanh.form',
            // 'khai-truong.form',
            // 'ky-hop-dong.form',
            // 'cai-tang.form',
            // 'ban-tho.form',
            // 'lap-ban-tho.form',
            // 'giai-han.form',
            // 'tran-trach.form',
            // 'phong-sinh.form',
            // 'mua-xe.form',
            // 'du-lich.form',
            // 'thi-cu.form',
            // 'cong-viec-moi.form',
            // 'giay-to.form',
            // 'huong-ban-tho.form',
            // 'huong-nha.form',
            // 'huong-bep.form',
            // 'huong-phong-ngu.form',
            // 'huong-ban-lam-viec.form',
        ];

        $urls = [];

        foreach ($toolRoutes as $routeName) {
            if (route($routeName, [], false)) { // kiểm tra route tồn tại
                $urls[] = [
                    'loc' => route($routeName),
                    'priority' => '0.7',
                ];
            }
        }
        $signSlugs = ['bach-duong', 'kim-nguu', 'song-tu', 'cu-giai', 'su_tu', 'xu-nu', 'thien-binh', 'bo-cap', 'nhan-ma', 'ma-ket', 'bao-binh', 'song-ngu'];
        $typeSlugs = ['hom-qua', 'hom-nay', 'ngay-mai', 'tuan-nay', 'thang-nay', 'nam-nay'];

        foreach ($signSlugs as $signSlug) {
            $urls[] = ['loc' => route('horoscope.show', ['signSlug' => $signSlug]), 'priority' => '0.7'];

            foreach ($typeSlugs as $typeSlug) {
                $urls[] = [
                    'loc' => route('horoscope.show.type', compact('signSlug', 'typeSlug')),
                    'priority' => '0.6',
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
            for ($month = 1; $month <= 12; $month++) {
                $urls[] = [
                    'loc' => route('lich.thang', ['nam' => $year, 'thang' => $month]),
                    'priority' => '0.6',
                ];
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
            $sitemaps[] = URL::to("/sitemap-days-{$year}.xml");
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
                'lastmod' => $date->toDateString(),
            ];
        }

        return response()
            ->view('sitemap.urlset', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}
