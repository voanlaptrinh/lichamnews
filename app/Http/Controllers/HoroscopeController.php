<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Sử dụng HTTP Client của Laravel
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter; // Dùng để ghi log nếu có lỗi

class HoroscopeController extends Controller
{
    // Mảng dữ liệu cố định cho 12 cung hoàng đạo
    private function getZodiacsData()
    {
        return [
            'aries' => ['name' => 'Bạch Dương', 'icon' => '/icons/bach_duong_tba.svg', 'date' => '21/3 - 19/4'],
            'taurus' => ['name' => 'Kim Ngưu', 'icon' => '/icons/kim_nguu_tba.svg', 'date' => '20/4 - 20/5'],
            'gemini' => ['name' => 'Song Tử', 'icon' => '/icons/song_tu_tba.svg', 'date' => '21/5 - 20/6'],
            'cancer' => ['name' => 'Cự Giải', 'icon' => '/icons/cu_giai_tba.svg', 'date' => '21/6 - 22/7'],
            'leo' => ['name' => 'Sư Tử', 'icon' => '/icons/su_tu_tba.svg', 'date' => '23/7 - 22/8'],
            'virgo' => ['name' => 'Xử Nữ', 'icon' => '/icons/xu_nu_tba.svg', 'date' => '23/8 - 22/9'],
            'libra' => ['name' => 'Thiên Bình', 'icon' => '/icons/thien_binh_tba.svg', 'date' => '23/9 - 22/10'],
            'scorpio' => ['name' => 'Bọ Cạp', 'icon' => '/icons/bo_cap_tba.svg', 'date' => '23/10 - 21/11'],
            'sagittarius' => ['name' => 'Nhân Mã', 'icon' => '/icons/nhan_ma_tba.svg', 'date' => '22/11 - 21/12'],
            'capricorn' => ['name' => 'Ma Kết', 'icon' => '/icons/ma_ket_tba.svg', 'date' => '22/12 - 19/1'],
            'aquarius' => ['name' => 'Bảo Bình', 'icon' => '/icons/bao_binh_tba.svg', 'date' => '20/1 - 18/2'],
            'pisces' => ['name' => 'Song Ngư', 'icon' => '/icons/song_ngu_tba.svg', 'date' => '19/2 - 20/3']
        ];
    }

    // Mapping giữa sign keys và URL slugs
    private function getSignSlugs()
    {
        return [
            'aries' => 'bach-duong',
            'taurus' => 'kim-nguu',
            'gemini' => 'song-tu',
            'cancer' => 'cu-giai',
            'leo' => 'su-tu',
            'virgo' => 'xu-nu',
            'libra' => 'thien-binh',
            'scorpio' => 'bo-cap',
            'sagittarius' => 'nhan-ma',
            'capricorn' => 'ma-ket',
            'aquarius' => 'bao-binh',
            'pisces' => 'song-ngu'
        ];
    }

    // Mapping giữa type keys và URL slugs
    private function getTypeSlugs()
    {
        return [
            'yesterday' => 'hom-qua',
            'today' => 'hom-nay',
            'tomorrow' => 'ngay-mai',
            'weekly' => 'tuan-nay',
            'monthly' => 'thang-nay',
            'yearly' => 'nam-nay'
        ];
    }

    // Chuyển từ slug sang sign key
    private function getSignFromSlug($slug)
    {
        $slugs = $this->getSignSlugs();
        return array_search($slug, $slugs);
    }

    // Chuyển từ slug sang type key
    private function getTypeFromSlug($slug)
    {
        $types = $this->getTypeSlugs();
        return array_search($slug, $types);
    }

    /**
     * Hiển thị trang danh sách 12 cung
     */
    public function index()
    {
        $zodiacs = $this->getZodiacsData();
        $signSlugs = $this->getSignSlugs();
        $metaTitle = " Tử Vi 12 Cung Hoàng Đạo – Tính Cách, Tử Vi, Tình Yêu & Sự Nghiệp";
        $metaDescription = "Khám phá 12 cung hoàng đạo theo ngày sinh: tính cách, tử vi, tình yêu, sự nghiệp và điểm mạnh yếu của từng chòm sao. Tra cứu cung hoàng đạo của bạn ngay hôm nay.";
        return view('horoscope.index', ['zodiacs' => $zodiacs, 'signSlugs' => $signSlugs, 'metaTitle' => $metaTitle, 'metaDescription' => $metaDescription]);
    }

    /**
     * Hiển thị trang chi tiết của một cung (method cũ - giữ để tương thích)
     */
    public function show($sign)
    {
        return $this->showFromSlug($sign, 'today');
    }

    /**
     * Hiển thị trang chi tiết của một cung từ slug (mặc định là hôm nay)
     */
    public function showFromSlug($signSlug, $defaultType = 'today')
    {
        $sign = $this->getSignFromSlug($signSlug);
        if (!$sign) {
            abort(404, 'Cung hoàng đạo không tồn tại');
        }

        return $this->renderZodiacView($sign, $defaultType);
    }

    /**
     * Hiển thị trang chi tiết của một cung với type cụ thể
     */
    public function showWithType($signSlug, $typeSlug)
    {
        $sign = $this->getSignFromSlug($signSlug);
        $type = $this->getTypeFromSlug($typeSlug);

        if (!$sign || !$type) {
            abort(404, 'URL không hợp lệ');
        }

        return $this->renderZodiacView($sign, $type);
    }

    /**
     * Helper method để render view cho cung hoàng đạo
     */
    private function renderZodiacView($sign, $type = 'today')
    {
        $zodiacs = $this->getZodiacsData();
        if (!array_key_exists($sign, $zodiacs)) {
            abort(404);
        }

        // Meta data cho từng cung hoàng đạo
        $metaTitles = [
            'aries' => 'Cung Bạch Dương - Aries (21/3 - 19/4) | Tính cách, Tình yêu, Sự nghiệp',
            'taurus' => 'Cung Kim Ngưu - Taurus (20/4 - 20/5) | Tính cách, Tình yêu, Sự nghiệp',
            'gemini' => 'Cung Song Tử - Gemini (21/5 - 20/6) | Tính cách, Tình yêu, Sự nghiệp',
            'cancer' => 'Cung Cự Giải - Cancer (21/6 - 22/7) | Tính cách, Tình yêu, Sự nghiệp',
            'leo' => 'Cung Sư Tử - Leo (23/7 - 22/8) | Tính cách, Tình yêu, Sự nghiệp',
            'virgo' => 'Cung Xử Nữ - Virgo (23/8 - 22/9) | Tính cách, Tình yêu, Sự nghiệp',
            'libra' => 'Cung Thiên Bình - Libra (23/9 - 22/10) | Tính cách, Tình yêu, Sự nghiệp',
            'scorpio' => 'Cung Bọ Cạp - Scorpio (23/10 - 21/11) | Tính cách, Tình yêu, Sự nghiệp',
            'sagittarius' => 'Cung Nhân Mã - Sagittarius (22/11 - 21/12) | Tính cách, Tình yêu, Sự nghiệp',
            'capricorn' => 'Cung Ma Kết - Capricorn (22/12 - 19/1) | Tính cách, Tình yêu, Sự nghiệp',
            'aquarius' => 'Cung Bảo Bình - Aquarius (20/1 - 18/2) | Tính cách, Tình yêu, Sự nghiệp',
            'pisces' => 'Cung Song Ngư - Pisces (19/2 - 20/3) | Tính cách, Tình yêu, Sự nghiệp'
        ];

        $metaDescriptions = [
            'aries' => 'Cung Bạch Dương (21/3-19/4): Khám phá tính cách mạnh mẽ, nhiệt huyết, tình yêu đam mê và sự nghiệp của người cung Bạch Dương. Tử vi hôm nay, tuần, tháng, năm chi tiết.',
            'taurus' => 'Cung Kim Ngưu (20/4-20/5): Tìm hiểu tính cách kiên nhẫn, thực tế, tình yêu chung thủy và sự nghiệp vững chắc của người cung Kim Ngưu. Tử vi chi tiết hàng ngày.',
            'gemini' => 'Cung Song Tử (21/5-20/6): Khám phá tính cách linh hoạt, thông minh, tình yêu đa dạng và sự nghiệp sáng tạo của người cung Song Tử. Xem tử vi hôm nay miễn phí.',
            'cancer' => 'Cung Cự Giải (21/6-22/7): Tìm hiểu tính cách nhạy cảm, tình cảm sâu sắc, tình yêu chân thành và sự nghiệp của người cung Cự Giải. Tử vi chi tiết và chính xác.',
            'leo' => 'Cung Sư Tử (23/7-22/8): Khám phá tính cách tự tin, quyền lực, tình yêu nồng cháy và sự nghiệp lãnh đạo của người cung Sư Tử. Dự báo tử vi hàng ngày.',
            'virgo' => 'Cung Xử Nữ (23/8-22/9): Tìm hiểu tính cách cầu toàn, tỉ mỉ, tình yêu chân thành và sự nghiệp chuyên nghiệp của người cung Xử Nữ. Tử vi chi tiết nhất.',
            'libra' => 'Cung Thiên Bình (23/9-22/10): Khám phá tính cách công bằng, hài hòa, tình yêu lãng mạn và sự nghiệp nghệ thuật của người cung Thiên Bình. Xem tử vi miễn phí.',
            'scorpio' => 'Cung Bọ Cạp (23/10-21/11): Tìm hiểu tính cách bí ẩn, mạnh mẽ, tình yêu sâu sắc và sự nghiệp quyết đoán của người cung Bọ Cạp. Tử vi chính xác nhất.',
            'sagittarius' => 'Cung Nhân Mã (22/11-21/12): Khám phá tính cách phóng khoáng, yêu tự do, tình yêu phiêu lưu và sự nghiệp của người cung Nhân Mã. Dự báo tử vi chi tiết.',
            'capricorn' => 'Cung Ma Kết (22/12-19/1): Tìm hiểu tính cách tham vọng, kiên định, tình yêu nghiêm túc và sự nghiệp thành công của người cung Ma Kết. Xem tử vi hôm nay.',
            'aquarius' => 'Cung Bảo Bình (20/1-18/2): Khám phá tính cách độc đáo, sáng tạo, tình yêu tự do và sự nghiệp đổi mới của người cung Bảo Bình. Tử vi chi tiết miễn phí.',
            'pisces' => 'Cung Song Ngư (19/2-20/3): Tìm hiểu tính cách mơ mộng, nhân ái, tình yêu lãng mạn và sự nghiệp nghệ thuật của người cung Song Ngư. Dự báo tử vi chính xác.'
        ];

        $zodiac = ['sign' => $sign] + $zodiacs[$sign];
        $metaTitle = $metaTitles[$sign] ?? 'Tử vi 12 cung hoàng đạo';
        $metaDescription = $metaDescriptions[$sign] ?? 'Xem tử vi 12 cung hoàng đạo chi tiết nhất';

        // Thêm thông tin về current type và slug mappings
        $signSlugs = $this->getSignSlugs();
        $typeSlugs = $this->getTypeSlugs();

        return view('horoscope.show', [
            'zodiac' => $zodiac,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'currentType' => $type,
            'signSlugs' => $signSlugs,
            'typeSlugs' => $typeSlugs
        ]);
    }

    /**
     * Lấy dữ liệu từ API bên ngoài và trả về dạng JSON
     */
    public function fetchData($sign, $type)
    {
        $validSigns = array_keys($this->getZodiacsData());
        $validTypes = ['yesterday', 'today', 'tomorrow', 'weekly', 'monthly', 'yearly'];

        if (!in_array($sign, $validSigns) || !in_array($type, $validTypes)) {
            return response()->json(['error' => 'Cung hoặc loại không hợp lệ'], 400);
        }

        $apiUrl = "https://cloudrun-v2.xemlicham.com/horoscopes/{$sign}/{$type}";

        try {
            $response = Http::timeout(10)->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();

                // --- PHẦN CẬP NHẬT CHÍNH ---

                // 1. Kiểm tra xem có dữ liệu hợp lệ không, bằng cách truy cập sâu vào cấu trúc
                if (isset($data['responseObject']) && isset($data['responseObject']['translatedContent'])) {

                    // 2. Lấy chuỗi Markdown trực tiếp
                    $markdownString = $data['responseObject']['translatedContent'];

                    // 3. Khởi tạo converter
                    $converter = new CommonMarkConverter([
                        'html_input' => 'strip',
                        'allow_unsafe_links' => false,
                    ]);

                    // 4. Chuyển đổi Markdown sang HTML
                    $htmlContent = $converter->convert($markdownString)->getContent();

                    // 5. Trả về JSON chứa HTML
                    return response()->json(['html' => $htmlContent]);
                } else {
                    // Nếu cấu trúc JSON không như mong đợi hoặc không có nội dung
                    // Lấy message lỗi từ API nếu có
                    $errorMessage = $data['message'] ?? 'Không có dữ liệu cho mục này.';
                    return response()->json(['html' => "<p style='text-align:center;'>{$errorMessage}</p>"]);
                }
                // --- KẾT THÚC PHẦN CẬP NHẬT ---

            } else {
                // Xử lý khi request đến API thất bại (lỗi 4xx, 5xx)
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Không thể kết nối đến dịch vụ cung hoàng đạo.';
                Log::error("API call failed for {$sign}/{$type}: " . $response->status() . " - " . $errorMessage);
                return response()->json(['error' => $errorMessage], $response->status());
            }
        } catch (\Exception $e) {
            // Xử lý các lỗi kết nối, timeout...
            Log::error("API exception for {$sign}/{$type}: " . $e->getMessage());
            return response()->json(['error' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.'], 500);
        }
    }
}
