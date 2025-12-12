<?php

namespace App\Http\Controllers;

use App\Helpers\FengShuiHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class XemHuongNhaController extends Controller
{
    /**
     * Hiển thị form xem hướng nhà.
     */
    public function showForm()
    {
            $metaTitle = "Xem Hướng Nhà Hợp Tuổi Chính Xác | Chọn Hướng Tốt Đón Tài Lộc";
        $metaDescription = "Tra cứu hướng nhà hợp tuổi theo phong thủy Bát Trạch để mang lại may mắn, sức khỏe và tài lộc. Công cụ tính hướng nhà chuẩn, hỗ trợ đầy đủ các tuổi và mệnh.";
        return view('huong-hop-tuoi.huong-nha.form', compact('metaTitle', 'metaDescription'));
    }

    /**
     * Xử lý request, tính toán và trả về kết quả.
     */
    public function check(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'birthdate' => 'required',
            'gioi_tinh' => 'required|in:nam,nữ',
        ], [
            'birthdate.required' => 'Vui lòng nhập năm sinh.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        // $namSinh = (int)$validated['birthdate'];
        $birthDateInput = $validated['birthdate']; // Giữ lại chuỗi 'd/m/Y'
        $birthDateObject = Carbon::createFromFormat('d/m/Y', $birthDateInput);
        $gender = $validated['gioi_tinh'];

        // 2. Gọi Helper để lấy kết quả
        $results = FengShuiHelper::layHuongNha(
            $birthDateObject->year,
            $birthDateObject->month,
            $birthDateObject->day,
            $gender
        );
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('huong-hop-tuoi.huong-nha.results', [
                'results' => $results,
                'birthDate' => $birthDateInput, // Truyền chuỗi ngày sinh đã nhập
                'gender' => $gender,             // Truyền giới tính đã chọn
                'nam_sinh' => $birthDateObject->year,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }
        // 3. Trả về view với đầy đủ dữ liệu
        return view('huong-hop-tuoi.huong-nha.form', [
            'results' => $results,
            'birthDate' => $birthDateInput, // Truyền lại năm sinh đã nhập
            'gender' => $gender, // Truyền lại giới tính đã chọn
            'nam_sinh' => $birthDateObject->year,
        ]);
    }
}
