<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml file';

    public function handle()
    {
        $baseUrl = 'https://phonglich.com';
        $today = date('Y-m-d');
        $currentYear = date('Y');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Trang chủ
        $sitemap .= $this->addUrl($baseUrl . '/', $today, 'daily', '1.0');

        // Đổi ngày âm dương
        $sitemap .= $this->addUrl($baseUrl . '/doi-ngay-am-duong', $today, 'weekly', '0.9');

        // Lịch âm hôm nay và ngày mai
        $sitemap .= $this->addUrl($baseUrl . '/lich-am-hom-nay', $today, 'daily', '0.8');
        $sitemap .= $this->addUrl($baseUrl . '/lich-am-ngay-mai', $today, 'daily', '0.8');

        // Cung hoàng đạo
        $sitemap .= $this->addUrl($baseUrl . '/cung-hoang-dao', $today, 'weekly', '0.7');

        $signs = ['bach-duong', 'kim-nguu', 'song-tu', 'cu-giai', 'su-tu', 'xu-nu',
                 'thien-binh', 'bo-cap', 'nhan-ma', 'ma-ket', 'bao-binh', 'song-ngu'];

        foreach ($signs as $sign) {
            $sitemap .= $this->addUrl($baseUrl . '/cung-hoang-dao/' . $sign, $today, 'weekly', '0.6');

            // Thêm các loại horoscope cho mỗi cung
            $types = ['tinh-yeu', 'cong-viec', 'tai-chinh', 'suc-khoe'];
            foreach ($types as $type) {
                $sitemap .= $this->addUrl($baseUrl . '/cung-hoang-dao/' . $sign . '/' . $type, $today, 'weekly', '0.5');
            }
        }

        // Lịch năm (3 năm: trước, hiện tại, sau)
        for ($year = $currentYear - 1; $year <= $currentYear + 1; $year++) {
            $priority = $year == $currentYear ? '0.7' : '0.6';
            $sitemap .= $this->addUrl($baseUrl . '/lich-nam-' . $year, $today, 'monthly', $priority);

            // Lịch tháng cho mỗi năm
            for ($month = 1; $month <= 12; $month++) {
                $monthPriority = ($year == $currentYear && $month == date('n')) ? '0.7' : '0.6';
                $sitemap .= $this->addUrl($baseUrl . '/lich-nam-' . $year . '/thang-' . $month, $today, 'monthly', $monthPriority);
            }
        }

        // Các công cụ phong thủy
        // $tools = [
        //     'xem-tuoi' => '0.5',
        //     'xem-tuoi-cuoi-hoi' => '0.5',
        //     'xem-ngay-xuat-hanh' => '0.5',
        //     'xem-ngay-khai-truong' => '0.5',
        //     'xem-ngay-mua-nha' => '0.5',
        //     'xem-ngay-mua-xe-nhan-xe' => '0.5',
        //     'xem-huong-ban-lam-viec' => '0.5',
        //     'xem-huong-ban-tho' => '0.5',
        //     'xem-huong-bep' => '0.5',
        //     'xem-huong-nha' => '0.5',
        //     'xem-huong-phong-ngu' => '0.5',
        //     'xem-ngay-cai-tang' => '0.4',
        //     'xem-ngay-cau-an-lam-phuc-phong-sinh' => '0.4',
        //     'xem-ngay-cung-sao-giai-han' => '0.4',
        //     'xem-ngay-doi-ban-tho' => '0.4',
        //     'xem-ngay-dong-tho' => '0.4',
        //     'xem-ngay-ky-hop-dong' => '0.4',
        //     'xem-ngay-lam-giay-to' => '0.4',
        //     'xem-ngay-lap-ban-tho' => '0.4',
        //     'xem-ngay-nhan-cong-viec-moi' => '0.4',
        //     'xem-ngay-nhap-trach' => '0.4',
        //     'xem-ngay-thi-cu-phong-van' => '0.4',
        //     'xem-ngay-xuat-hanh-du-lich-cong-tac' => '0.4',
        //     'xem-ngay-yem-tran-tran-trach' => '0.4'
        // ];

        // foreach ($tools as $tool => $priority) {
        //     $sitemap .= $this->addUrl($baseUrl . '/' . $tool, $today, 'weekly', $priority);
        // }

        // // Các trang khác
        // $sitemap .= $this->addUrl($baseUrl . '/thuoc-lo-ban', $today, 'weekly', '0.5');
        // $sitemap .= $this->addUrl($baseUrl . '/van-khan', $today, 'weekly', '0.5');

        // Các trang chính sách
        $sitemap .= $this->addUrl($baseUrl . '/chinh-sach-bao-mat', $today, 'yearly', '0.3');
        $sitemap .= $this->addUrl($baseUrl . '/dieu-khoan-dich-vu', $today, 'yearly', '0.3');
        $sitemap .= $this->addUrl($baseUrl . '/lien-he-voi-chung-toi', $today, 'monthly', '0.4');

        $sitemap .= '</urlset>';

        // Lưu file sitemap
        $path = public_path('sitemap.xml');
        File::put($path, $sitemap);

        $this->info('Sitemap generated successfully at: ' . $path);
        $this->info('Total URLs: ' . substr_count($sitemap, '<url>'));

        return 0;
    }

    private function addUrl($url, $lastmod, $changefreq, $priority)
    {
        return "    <url>" . PHP_EOL .
               "        <loc>{$url}</loc>" . PHP_EOL .
               "        <lastmod>{$lastmod}</lastmod>" . PHP_EOL .
               "        <changefreq>{$changefreq}</changefreq>" . PHP_EOL .
               "        <priority>{$priority}</priority>" . PHP_EOL .
               "    </url>" . PHP_EOL;
    }
}