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
        return view('huong-hop-tuoi.huong-nha.form');
    }

    /**
     * Xử lý request, tính toán và trả về kết quả.
     */
    public function check(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'nam_sinh' => 'required',
            'gioi_tinh' => 'required|in:nam,nữ',
        ], [
            'nam_sinh.required' => 'Vui lòng nhập năm sinh.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        // $namSinh = (int)$validated['nam_sinh'];
        $birthDateInput = $validated['nam_sinh']; // Giữ lại chuỗi 'd/m/Y'
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
            $html = view('huong-hop-tuoi.huong-ban-tho.results', [
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
            'nam_sinh' => $birthDateObject, // Truyền lại năm sinh đã nhập
            'gender' => $gender, // Truyền lại giới tính đã chọn
            'inputdate' => $birthDateInput,
        ]);
    }
}
