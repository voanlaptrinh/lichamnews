<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Trang chủ -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Đổi ngày âm dương -->
    <url>
        <loc>{{ url('/doi-ngay-am-duong') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Lịch âm hôm nay -->
    <url>
        <loc>{{ url('/lich-am-hom-nay') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Lịch âm ngày mai -->
    <url>
        <loc>{{ url('/lich-am-ngay-mai') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Cung hoàng đạo -->
    <url>
        <loc>{{ url('/cung-hoang-dao') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    @php
    $signs = ['bach-duong', 'kim-nguu', 'song-tu', 'cu-giai', 'su-tu', 'xu-nu', 'thien-binh', 'bo-cap', 'nhan-ma', 'ma-ket', 'bao-binh', 'song-ngu'];
    $types = ['hom-nay', 'ngay-mai', 'tuan-nay', 'thang-nay','nam-nay'];
    $currentYear = date('Y');
    @endphp

    <!-- Các cung hoàng đạo -->
    @foreach($signs as $sign)
    <url>
        <loc>{{ url('/cung-hoang-dao/' . $sign) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>

    @foreach($types as $type)
    <url>
        <loc>{{ url('/cung-hoang-dao/' . $sign . '/' . $type) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach
    @endforeach

    <!-- Lịch năm (3 năm: trước, hiện tại, sau) -->
    @for($year = $currentYear - 1; $year <= $currentYear + 1; $year++)
    <url>
        <loc>{{ url('/lich-nam-' . $year) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>{{ $year == $currentYear ? '0.7' : '0.6' }}</priority>
    </url>

    @for($month = 1; $month <= 12; $month++)
    <url>
        <loc>{{ url('/lich-nam-' . $year . '/thang-' . $month) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>{{ ($year == $currentYear && $month == date('n')) ? '0.7' : '0.6' }}</priority>
    </url>
    @endfor
    @endfor

    <!-- Các công cụ phong thủy -->
   

    <!-- Các trang chính sách -->
    <url>
        <loc>{{ url('/chinh-sach-bao-mat') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ url('/dieu-khoan-dich-vu') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ url('/lien-he-voi-chung-toi') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>
</urlset>