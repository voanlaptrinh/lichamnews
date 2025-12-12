<?php

namespace App\Http\Controllers;

use App\Helpers\FengShuiHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class XemHuongBepController extends Controller
{
    public function showForm()
    {
        // Khi vào form lần đầu, không có dữ liệu gì cả
         $metaTitle = "Xem Hướng Bếp Hợp Tuổi Chuẩn Phong Thủy | Đúng Tốt – Tránh Xấu";
        $metaDescription = "Xác định hướng bếp hợp tuổi để kích hoạt tài lộc, giữ hòa khí gia đình và tránh các hướng xấu. Công cụ xem hướng bếp theo Bát Trạch đơn giản, chính xác.";
        return view('huong-hop-tuoi.huong-bep.form', compact('metaTitle', 'metaDescription'));
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

        // 2. Xử lý dữ liệu đầu vào
        $birthDateInput = $validated['birthdate']; // Giữ lại chuỗi 'd/m/Y'
        $birthDateObject = Carbon::createFromFormat('d/m/Y', $birthDateInput);
        $gender = $validated['gioi_tinh'];

        // 3. Gọi Helper để lấy kết quả
        $results = FengShuiHelper::layHuongBep(
            $birthDateObject->year,
            $birthDateObject->month,
            $birthDateObject->day,
            $gender
        );

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('huong-hop-tuoi.huong-bep.results', [
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

        // 4. Trả về view với đầy đủ dữ liệu
        return view('huong-hop-tuoi.huong-bep.form', [
            'results' => $results,
            'birthDate' => $birthDateInput, // Truyền chuỗi ngày sinh đã nhập
            'gender' => $gender,             // Truyền giới tính đã chọn
            'nam_sinh' => $birthDateObject->year,
        ]);
    }
}