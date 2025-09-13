<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Sử dụng HTTP Client của Laravel
use Illuminate\Support\Facades\Log;   
use League\CommonMark\CommonMarkConverter;// Dùng để ghi log nếu có lỗi

class HoroscopeController extends Controller
{
    // Mảng dữ liệu cố định cho 12 cung hoàng đạo
    private function getZodiacsData()
    {
        return [
            'aries' => ['name' => 'Bạch Dương', 'icon' => '/icons/aries.svg'],
            'taurus' => ['name' => 'Kim Ngưu', 'icon' => '/icons/taurus.svg'],
            'gemini' => ['name' => 'Song Tử', 'icon' => '/icons/gemini.svg'],
            'cancer' => ['name' => 'Cự Giải', 'icon' => '/icons/cances.svg'],
            'leo' => ['name' => 'Sư Tử', 'icon' => '/icons/leo.svg'],
            'virgo' => ['name' => 'Xử Nữ', 'icon' => '/icons/virgo.svg'],
            'libra' => ['name' => 'Thiên Bình', 'icon' => '/icons/libra.svg'],
            'scorpio' => ['name' => 'Bọ Cạp', 'icon' => '/icons/scor.svg'],
            'sagittarius' => ['name' => 'Nhân Mã', 'icon' => '/icons/sagi.svg'],
            'capricorn' => ['name' => 'Ma Kết', 'icon' => '/icons/capri.svg'],
            'aquarius' => ['name' => 'Bảo Bình', 'icon' => '/icons/aquarius.svg'],
            'pisces' => ['name' => 'Song Ngư', 'icon' => '/icons/pisces.svg']
        ];
    }

    /**
     * Hiển thị trang danh sách 12 cung
     */
    public function index()
    {
        $zodiacs = $this->getZodiacsData();
        return view('horoscope.index', ['zodiacs' => $zodiacs]);
    }

    /**
     * Hiển thị trang chi tiết của một cung
     */
    public function show($sign)
    {
        $zodiacs = $this->getZodiacsData();
        if (!array_key_exists($sign, $zodiacs)) {
            abort(404); // Nếu sign không hợp lệ, báo lỗi 404
        }
        $zodiac = ['sign' => $sign] + $zodiacs[$sign];
        return view('horoscope.show', ['zodiac' => $zodiac]);
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

        $apiUrl = "https://cloudrun-v2.xemlicham.com/horoscopes/{$sign}?type={$type}";

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
