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
            'aries' => ['name' => 'Bạch Dương', 'english_name' => 'Aries', 'icon' => '/icons/bach_duong_tba.svg', 'date' => '21/3 - 19/4'],
            'taurus' => ['name' => 'Kim Ngưu', 'english_name' => 'Taurus', 'icon' => '/icons/kim_nguu_tba.svg', 'date' => '20/4 - 20/5'],
            'gemini' => ['name' => 'Song Tử', 'english_name' => 'Gemini', 'icon' => '/icons/song_tu_tba.svg', 'date' => '21/5 - 20/6'],
            'cancer' => ['name' => 'Cự Giải', 'english_name' => 'Cancer', 'icon' => '/icons/cu_giai_tba.svg', 'date' => '21/6 - 22/7'],
            'leo' => ['name' => 'Sư Tử', 'english_name' => 'Leo', 'icon' => '/icons/su_tu_tba.svg', 'date' => '23/7 - 22/8'],
            'virgo' => ['name' => 'Xử Nữ', 'english_name' => 'Virgo', 'icon' => '/icons/xu_nu_tba.svg', 'date' => '23/8 - 22/9'],
            'libra' => ['name' => 'Thiên Bình', 'english_name' => 'Libra', 'icon' => '/icons/thien_binh_tba.svg', 'date' => '23/9 - 22/10'],
            'scorpio' => ['name' => 'Bọ Cạp', 'english_name' => 'Scorpio', 'icon' => '/icons/bo_cap_tba.svg', 'date' => '23/10 - 21/11'],
            'sagittarius' => ['name' => 'Nhân Mã', 'english_name' => 'Sagittarius', 'icon' => '/icons/nhan_ma_tba.svg', 'date' => '22/11 - 21/12'],
            'capricorn' => ['name' => 'Ma Kết', 'english_name' => 'Capricorn', 'icon' => '/icons/ma_ket_tba.svg', 'date' => '22/12 - 19/1'],
            'aquarius' => ['name' => 'Bảo Bình', 'english_name' => 'Aquarius', 'icon' => '/icons/bao_binh_tba.svg', 'date' => '20/1 - 18/2'],
            'pisces' => ['name' => 'Song Ngư', 'english_name' => 'Pisces', 'icon' => '/icons/song_ngu_tba.svg', 'date' => '19/2 - 20/3']
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

    // --- BẮT ĐẦU PHẦN CẬP NHẬT ---

    // 1. Mảng chứa tên Tiếng Việt của các cung hoàng đạo
    $zodiacNames = [
        'aries'       => 'Bạch Dương',
        'taurus'      => 'Kim Ngưu',
        'gemini'      => 'Song Tử',
        'cancer'      => 'Cự Giải',
        'leo'         => 'Sư Tử',
        'virgo'       => 'Xử Nữ',
        'libra'       => 'Thiên Bình',
        'scorpio'     => 'Bọ Cạp',
        'sagittarius' => 'Nhân Mã',
        'capricorn'   => 'Ma Kết',
        'aquarius'    => 'Bảo Bình',
        'pisces'      => 'Song Ngư',
    ];

    // Lấy tên của cung hoàng đạo hiện tại
    $currentZodiacName = $zodiacNames[$sign] ?? 'Hoàng Đạo';

    // 2. Mảng chứa các mẫu (template) cho Meta Title
    // Sử dụng placeholder {zodiacName} để thay thế
    $metaTitleTemplates = [
        'today'    => 'Tử Vi Cung {zodiacName} Hôm Nay – Tình Yêu, Sự Nghiệp & Tài Chính',
        'tomorrow' => 'Tử Vi Cung {zodiacName} Ngày Mai – Tình Yêu, Công Việc & Tài Chính',
        'weekly'   => 'Tử Vi Cung {zodiacName} Tuần Này – Tình Yêu, Công Việc & Tài Lộc',
        'monthly'  => 'Tử Vi Cung {zodiacName} Tháng Này – Tình Yêu, Sự Nghiệp & Tài Chính',
        'yearly'   => 'Tử Vi Cung {zodiacName} Năm Nay – Tình Yêu, Sự Nghiệp & Vận Mệnh',
        'default'  => 'Cung {zodiacName} - {englishName} | Tính cách, Tình yêu, Sự nghiệp',
    ];

    // 3. Mảng chứa các mẫu (template) cho Meta Description
    $metaDescriptionTemplates = [
        'today'    => 'Xem tử vi cung {zodiacName} hôm nay: tình yêu, sự nghiệp, tài chính và sức khỏe. Dự đoán giúp {zodiacName} định hướng và lựa chọn tốt hơn trong ngày.',
        'tomorrow' => 'Xem tử vi cung {zodiacName} ngày mai với dự đoán về tình yêu, công việc, tài chính và sức khỏe. Gợi ý giúp {zodiacName} chuẩn bị tốt hơn cho ngày mới.',
        'weekly'   => 'Xem tử vi cung {zodiacName} tuần này với dự đoán chi tiết về tình yêu, công việc, tài chính và sức khỏe. Giúp {zodiacName} lên kế hoạch tuần hiệu quả.',
        'monthly'  => 'Xem tử vi cung {zodiacName} tháng này với dự đoán về tình yêu, công việc, tài chính và sức khỏe. Giúp {zodiacName} định hướng và vượt qua thử thách trong tháng.',
        'yearly'   => 'Xem tử vi cung {zodiacName} năm nay với dự đoán về tình yêu, công việc, tài chính, sức khỏe. Giúp {zodiacName} định hướng kế hoạch và tránh rủi ro trong năm.',
        'default'  => 'Khám phá toàn bộ về cung {zodiacName} ({dateRange}): tính cách đặc trưng, quan điểm về tình yêu, con đường sự nghiệp và các mối quan hệ.',
    ];

    // 4. Lấy template dựa trên $type, nếu không có thì dùng 'default'
    $titleTemplate = $metaTitleTemplates[$type] ?? $metaTitleTemplates['default'];
    $descriptionTemplate = $metaDescriptionTemplates[$type] ?? $metaDescriptionTemplates['default'];

    // 5. Tạo ra Meta Title và Meta Description cuối cùng
    // Thay thế các placeholder bằng giá trị thực
    $metaTitle = str_replace('{zodiacName}', $currentZodiacName, $titleTemplate);
    $metaDescription = str_replace('{zodiacName}', $currentZodiacName, $descriptionTemplate);
    
    // Bổ sung các placeholder khác nếu cần (ví dụ cho template 'default')
    if ($type === 'default' || !isset($metaTitleTemplates[$type])) {
        $zodiacDetails = $zodiacs[$sign];
        $metaTitle = str_replace('{englishName}', $zodiacDetails['english_name'], $metaTitle);
        $metaDescription = str_replace('{dateRange}', $zodiacDetails['date'], $metaDescription);
    }
    
    // --- KẾT THÚC PHẦN CẬP NHẬT ---

    $zodiac = ['sign' => $sign] + $zodiacs[$sign];

    // Thêm thông tin về current type và slug mappings
    $signSlugs = $this->getSignSlugs();
    $typeSlugs = $this->getTypeSlugs();

    return view('horoscope.show', [
        'zodiac' => $zodiac,
        'metaTitle' => $metaTitle,
        'metaDescription' => $metaDescription,
        'currentType' => $type, // $type đã có sẵn từ tham số hàm
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
