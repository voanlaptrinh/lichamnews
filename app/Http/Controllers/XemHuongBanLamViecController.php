<?php

namespace App\Http\Controllers;

use App\Helpers\FengShuiHelper;
use App\Helpers\LunarHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class XemHuongBanLamViecController extends Controller
{
    public function showForm()
    {
        // Khi vào form lần đầu, không có dữ liệu gì cả
        return view('huong-hop-tuoi.ban-lam-viec.form');
    }

    public function check(Request $request) // Đổi tên hàm thành check cho đúng chuẩn REST
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'birthdate' => 'required|date_format:d/m/Y',
            'gioi_tinh' => 'required|in:nam,nữ',
        ], [
            'birthdate.required' => 'Vui lòng nhập ngày sinh của bạn.',
            'birthdate.date_format' => 'Định dạng ngày sinh phải là dd/mm/yyyy.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'gioi_tinh.in' => 'Giới tính không hợp lệ.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            // 2. Xử lý dữ liệu đầu vào
            $birthDateInput = $validated['birthdate']; // Giữ lại chuỗi 'd/m/Y'
            $birthDateObject = Carbon::createFromFormat('d/m/Y', $birthDateInput);
            $gender = $validated['gioi_tinh'];

            // 3. Gọi Helper để lấy kết quả
            $results = FengShuiHelper::layHuongBanLamViec(
                $birthDateObject->year,
                $birthDateObject->month,
                $birthDateObject->day,
                $gender
            );

            // 4. Tính tuổi âm lịch (vì helper function không bao gồm ageInfo)
            if ($results) {
                // Lấy năm âm lịch hiện tại
                $solarDay = date('d');
                $solarMonth = date('m');
                $solarYear = date('Y');
                $lunarToday = LunarHelper::convertSolar2Lunar($solarDay, $solarMonth, $solarYear);
                $lunarYearNow = $lunarToday[2];  // Năm âm lịch hiện tại

                // Chuyển đổi ngày sinh sang âm lịch
                $lunarDob = LunarHelper::convertSolar2Lunar(
                    $birthDateObject->day,
                    $birthDateObject->month,
                    $birthDateObject->year
                );
                $lunarYear = $lunarDob[2]; // Năm âm lịch sinh
                $tuoiAm = $lunarYearNow - $lunarYear + 1;

                // Thêm thông tin tuổi vào kết quả
                $results['ageInfo'] = [
                    'tuoiAm' => $tuoiAm,
                    'namAmHienTai' => $lunarYearNow,
                ];
            }

            if (!$results) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể tính toán được kết quả. Vui lòng thử lại.'
                    ], 500);
                }
                return redirect()->back()
                    ->withErrors(['general' => 'Không thể tính toán được kết quả. Vui lòng thử lại.'])
                    ->withInput();
            }

            if ($request->ajax() || $request->wantsJson()) {
                $html = view('huong-hop-tuoi.ban-lam-viec.results', [
                    'results' => $results,
                    'birthDate' => $birthDateInput, // Truyền chuỗi ngày sinh đã nhập
                    'gender' => $gender,             // Truyền giới tính đã chọn
                    'nam_sinh' => $birthDateObject->year,
                ])->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }

            // 4. Trả về view với đầy đủ dữ liệu
            return view('huong-hop-tuoi.ban-lam-viec.form', [
                'results' => $results,
                'birthDate' => $birthDateInput, // Truyền chuỗi ngày sinh đã nhập
                'gender' => $gender,             // Truyền giới tính đã chọn
                'nam_sinh' => $birthDateObject->year,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in XemHuongBanLamViecController: ' . $e->getMessage(), [
                'birthdate' => $validated['birthdate'] ?? null,
                'gender' => $validated['gioi_tinh'] ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xử lý dữ liệu. Vui lòng thử lại.'
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['general' => 'Có lỗi xảy ra khi xử lý dữ liệu. Vui lòng thử lại.'])
                ->withInput();
        }
    }
}
