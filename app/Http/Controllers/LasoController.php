<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LasoController extends Controller
{
    public function create()
    {
        // Lấy dữ liệu từ session nếu có (từ lần submit trước)
        $lastInput = session('laso_last_input', []);
        $metaTitle = "Lá Số Tử Vi Online – Luận Giải Tử Vi 12 Cung, Chính Xác & Miễn Phí";
        $metaDescription = "Xem lá số tử vi online theo ngày tháng năm sinh. Luận giải 12 cung, sao hạn, vận mệnh, tính cách, công danh – đầy đủ, dễ hiểu, miễn phí và chính xác.";

        return view('la-so-tu-vi.form', compact('lastInput', 'metaTitle', 'metaDescription'));
    }
    public function submitToApi(Request $request)
    {
        // --- 1. VALIDATION PHÍA LARAVEL ---
        // Bạn có thể validate sơ bộ ở đây để giảm tải cho API gốc.
        $validatedData = $request->validate([
            'ho_ten'    => 'required|string|max:100',
            'gioi_tinh' => ['required', Rule::in(['Nam', 'Nữ'])],
            'nam_xem'   => 'required|integer|min:1900|max:2200',
            'dl_date_processed' => 'required|string', // Ngày đã được xử lý từ component
            'calendar_type' => ['nullable', Rule::in(['solar', 'lunar'])], // Loại lịch đã chọn
            'dl_gio'    => 'required|integer|min:0|max:23',
            'dl_phut'   => 'required|integer|min:0|max:59',

            'location'  => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    // Tạm thời lấy năm từ date processed để check location
                    $dateProcessed = $request->input('dl_date_processed');
                    if ($dateProcessed) {
                        // Format: DD/MM/YYYY (DL)
                        $parts = explode('/', explode(' ', $dateProcessed)[0]);
                        if (count($parts) >= 3) {
                            $year = (int)$parts[2];
                            return $year >= 1945 && $year <= 1975;
                        }
                    }
                    return false;
                }),
                Rule::in(['north', 'south'])
            ],
        ]);

        // Parse ngày từ dl_date_processed (format: DD/MM/YYYY (DL) hoặc DD/MM/YYYY (ÂL))
        $dateProcessed = $validatedData['dl_date_processed'];
        $dateParts = explode('/', explode(' ', $dateProcessed)[0]);

        if (count($dateParts) !== 3) {
            return back()->withErrors(['dl_date_processed' => 'Định dạng ngày không hợp lệ.'])->withInput();
        }

        $day = (int)$dateParts[0];
        $month = (int)$dateParts[1];
        $year = (int)$dateParts[2];

        // Kiểm tra ngày hợp lệ
        if (!checkdate($month, $day, $year)) {
            return back()->withErrors(['dl_date_processed' => 'Ngày dương lịch không hợp lệ.'])->withInput();
        }

        // Thêm các trường ngày tháng năm vào validatedData để gửi API
        $validatedData['dl_ngay'] = $day;
        $validatedData['dl_thang'] = $month;
        $validatedData['dl_nam'] = $year;
        $validatedData['app_name'] = "phonglich";

        // --- 2. GỌI ĐẾN API PHP THUẦN ---
        $apiUrl = 'http://168.119.14.32/laso_v2/store_laso.php';

        try {
            $response = \Http::post($apiUrl, $validatedData);

            // Kiểm tra xem request có thành công không
            if ($response->failed()) {
                // Lỗi kết nối hoặc API trả về mã 4xx, 5xx
                return back()->withErrors(['msg' => 'Không thể kết nối đến máy chủ tính toán lá số. Vui lòng thử lại sau.'])->withInput();
            }

            $result = $response->json();

            // --- 3. XỬ LÝ KẾT QUẢ TỪ API ---
            if (isset($result['success']) && $result['success']) {
                // Thành công, lấy URL ảnh và hiển thị view kết quả
                $imageUrl = $result['data']['image_url'] ?? null;
                $normalizedData = $result['data']['input_summary'] ?? [];

                if (!$imageUrl) {
                    $error = $result['error_image_generation'] ?? 'API không trả về ảnh.';
                    return back()->withErrors(['msg' => 'Tính toán thành công nhưng không tạo được ảnh: ' . $error])->withInput();
                }

                // Parse thông tin từ dl_date_processed để lưu đầy đủ
                $dateProcessed = $validatedData['dl_date_processed'];
                $calendarType = $validatedData['calendar_type'] ?? 'solar';

                // Nếu là âm lịch, cần lưu cả ngày âm lịch gốc
                $lunarDate = null;
                if ($calendarType === 'lunar' && strpos($dateProcessed, '(ÂL') !== false) {
                    // Extract lunar date từ format "DD/MM/YYYY (ÂL)" hoặc "DD/MM/YYYY (ÂL-Nhuận)"
                    $dateParts = explode('/', explode(' ', $dateProcessed)[0]);
                    if (count($dateParts) === 3) {
                        $lunarDate = [
                            'day' => (int)$dateParts[0],
                            'month' => (int)$dateParts[1],
                            'year' => (int)$dateParts[2],
                            'is_leap' => strpos($dateProcessed, 'Nhuận') !== false
                        ];
                    }
                }

                // Lưu thông tin vào session để có thể chỉnh sửa lại
                session([
                    'laso_last_input' => [
                        'ho_ten' => $validatedData['ho_ten'],
                        'gioi_tinh' => $validatedData['gioi_tinh'],
                        'nam_xem' => $validatedData['nam_xem'],
                        'dl_date_processed' => $validatedData['dl_date_processed'],
                        'calendar_type' => $calendarType,
                        'lunar_date' => $lunarDate, // Lưu thêm ngày âm lịch gốc
                        'dl_gio' => $validatedData['dl_gio'],
                        'dl_phut' => $validatedData['dl_phut'],
                        'location' => $validatedData['location'] ?? null,
                    ]
                ]);
                $metaTitle = "Lá Số Tử Vi Online – Luận Giải Tử Vi 12 Cung, Chính Xác & Miễn Phí";
                $metaDescription = "Xem lá số tử vi online theo ngày tháng năm sinh. Luận giải 12 cung, sao hạn, vận mệnh, tính cách, công danh – đầy đủ, dễ hiểu, miễn phí và chính xác.";
                // Trả về một view mới để hiển thị ảnh
                return view('la-so-tu-vi.display', [
                    'metaTitle' => $metaTitle,
                    'metaDescription' => $metaDescription,
                    'imageUrl' => $imageUrl,
                    'normalizedData' => $normalizedData
                ]);
            } else {
                // API trả về lỗi (ví dụ: validation thất bại bên phía API)
                $errorMessage = $result['message'] ?? 'Có lỗi không xác định từ API.';
                // Nếu có lỗi chi tiết, chúng ta có thể hiển thị chúng
                if (!empty($result['errors'])) {
                    $errorDetails = collect($result['errors'])->flatten()->implode(' ');
                    $errorMessage .= ' Chi tiết: ' . $errorDetails;
                }
                return back()->withErrors(['msg' => $errorMessage])->withInput();
            }
        } catch (\Exception $e) {
            // Bắt các lỗi khác như timeout, lỗi DNS...
            return back()->withErrors(['msg' => 'Đã xảy ra lỗi khi giao tiếp với API: ' . $e->getMessage()])->withInput();
        }
    }
    public function proxyImage(Request $request)
    {
        // BƯỚC 1: XÁC THỰC DỮ LIỆU ĐẦU VÀO
        // Đảm bảo rằng tham số 'url' được cung cấp và là một URL hợp lệ.
        // Đây là bước bảo mật quan trọng để tránh bị lạm dụng.
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response('URL không hợp lệ hoặc bị thiếu.', 400); // 400 Bad Request
        }

        $imageUrl = $validator->validated()['url'];

        // BƯỚC 2: SỬ DỤNG CACHING ĐỂ TỐI ƯU HIỆU NĂNG
        // Tạo một khóa cache duy nhất dựa trên URL của ảnh.
        $cacheKey = 'image_proxy_' . md5($imageUrl);

        // Thời gian cache: 1440 phút = 24 giờ.
        // Lá số tử vi thường không thay đổi, nên có thể cache lâu.
        $cacheDurationInMinutes = 1440;

        // Sử dụng Cache::remember để lấy dữ liệu.
        // Nếu dữ liệu có trong cache, nó sẽ được trả về ngay lập tức.
        // Nếu không, hàm callback sẽ được thực thi để lấy dữ liệu, lưu vào cache, rồi trả về.
        $imageContents = Cache::remember($cacheKey, $cacheDurationInMinutes, function () use ($imageUrl) {
            try {
                // Thực hiện gọi HTTP đến server API để lấy ảnh.
                $response = \Http::timeout(15)->get($imageUrl); // Đặt timeout 15 giây

                // Nếu request thất bại (lỗi 4xx, 5xx), không cache lỗi.
                if ($response->failed()) {
                    return null;
                }

                // Trả về nội dung của ảnh (dạng binary).
                return $response->body();
            } catch (\Exception $e) {
                // Nếu có lỗi kết nối (timeout, DNS error...), không cache lỗi.
                return null;
            }
        });

        // BƯỚC 3: KIỂM TRA KẾT QUẢ VÀ TRẢ VỀ RESPONSE
        // Nếu $imageContents là null, nghĩa là việc lấy ảnh đã thất bại.
        if (!$imageContents) {
            // 502 Bad Gateway là mã lỗi phù hợp, cho biết server proxy không thể
            // lấy được phản hồi hợp lệ từ server gốc.
            return response('Không thể tải ảnh từ nguồn được chỉ định.', 502);
        }

        // Nếu thành công, trả về một HTTP response chứa nội dung ảnh.
        return Response::make($imageContents, 200, [
            // 'image/png': Báo cho trình duyệt biết đây là file ảnh PNG.
            'Content-Type' => 'image/png',

            // 'inline': Báo cho trình duyệt hiển thị ảnh trực tiếp trên trang,
            // thay vì mở hộp thoại tải xuống.
            'Content-Disposition' => 'inline; filename="laso.png"',

            // Thêm header cache phía client để trình duyệt cũng cache lại ảnh.
            'Cache-Control' => 'public, max-age=86400' // Cache 1 ngày
        ]);
    }
    public function downloadImage(Request $request)
    {
        // Validate URL đầu vào để đảm bảo an toàn
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response('URL không hợp lệ.', 400);
        }

        $imageUrl = $validator->validated()['url'];

        try {
            // Lấy nội dung ảnh từ URL
            $response = \Http::get($imageUrl);

            // Nếu không lấy được ảnh, báo lỗi
            if ($response->failed()) {
                return response('Không thể tải ảnh từ nguồn.', 502); // 502 Bad Gateway
            }

            $imageContents = $response->body();

            // Lấy tên người từ request để đặt tên file cho thân thiện
            $hoTen = $request->query('ho_ten', 'Unknown');
            $fileName = 'La-So-Tu-Vi-' . Str::slug($hoTen) . '.png';

            // Trả về response để trình duyệt tự động tải xuống
            return Response::make($imageContents, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        } catch (\Exception $e) {
            return response('Đã xảy ra lỗi khi xử lý yêu cầu tải ảnh.', 500);
        }
    }
}
