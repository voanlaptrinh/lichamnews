<?php

namespace App\Http\Controllers;

use App\Helpers\CompatibilityHelper;
use App\Helpers\LunarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // SỬA ĐỔI: Thêm thư viện Carbon để xử lý ngày tháng

class CompatibilityController extends Controller
{
    /**
     * SỬA ĐỔI: showForm() để phù hợp với view mới
     * Trả về view với các giá trị mặc định cho mảng $input
     */
    public function showForm()
    {
        // View mới dùng biến $input, nên chúng ta sẽ khởi tạo nó với các giá trị mặc định
        $input = [
            'dob1' => '',
            'gender1' => 'Nam',
            'dob2' => '',
            'gender2' => 'Nữ',
            'type' => 'capdoi'
        ];

        return view('xem-tuoi-codau-chure.index')->with('input', $input);
    }

    /**
     * SỬA ĐỔI: calculate() để xử lý ngày sinh thay vì năm sinh
     * Xử lý form, tính toán và hiển thị kết quả.
     */
    public function calculate(Request $request)
    {
        // 1. Validate đầu vào
        $dateFormat = 'd-m-Y'; // Định dạng ngày tháng mà flatpickr gửi lên
        $minYear = 1920;
        $maxYear = date('Y');

        $validator = Validator::make($request->all(), [
            'birthdateA' => 'required|date_format:d/m/Y',
            'birthdateB' => 'required|date_format:d/m/Y',
            'genderA' => 'required|in:nam,nữ',
            'genderB' => 'required|in:nam,nữ',
            'type' => 'required|in:capdoi,laman',
        ], [
            'required' => 'Thông tin :attribute là bắt buộc.',
            'date_format' => 'Định dạng ngày tháng không đúng.',
            'in' => 'Giá trị :attribute không hợp lệ.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $birthdate1 = Carbon::createFromFormat('d/m/Y', $validated['birthdateA']);
        $birthdate2 = Carbon::createFromFormat('d/m/Y', $validated['birthdateB']);


        // SỬA ĐỔI: Lấy năm từ ngày sinh đã được validate
        //  Carbon::createFromFormat($dateFormat, $validated['genderA'])->year;

        //Ngày tháng năm sinh âm dương người 1

        $birthdateal1 =  LunarHelper::convertSolar2Lunar($birthdate1->day, $birthdate1->month, $birthdate1->year); //ngày tháng năm sinh dương
        //end
        //Ngày tháng năm sinh âm dương người 2

        $birthdateal2 =  LunarHelper::convertSolar2Lunar($birthdate2->day, $birthdate2->month, $birthdate2->year); //ngày tháng năm sinh dương
        //end

        $year1 = $birthdate1->year;
        $year2 = $birthdate2->year;

        // 2. Gọi Helper để tính toán
        $result = CompatibilityHelper::calculate(
            $year1, // Truyền năm đã được trích xuất
            $validated['genderA'],
            $year2, // Truyền năm đã được trích xuất
            $validated['genderB'],
            $validated['type'],
            $birthdate1,
            $birthdate2,
            $birthdateal1,
            $birthdateal2
        );
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('xem-tuoi-codau-chure.results', [
                'results' => $result,
                'input' => $validated, // Truyền lại toàn bộ dữ liệu đã nhập để fill lại form
                'birthdate1' => $birthdate1,
                'birthdateal1' => $birthdateal1,
                'birthdate2' => $birthdate2,
                'birthdateal2' => $birthdateal2,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
        // 3. Trả về view với dữ liệu kết quả và dữ liệu đầu vào
        return view('xem-tuoi-codau-chure.index')->with([
            'results' => $result,
            'input' => $validated, // Truyền lại toàn bộ dữ liệu đã nhập để fill lại form
            'birthdate1' => $birthdate1,
            'birthdateal1' => $birthdateal1,
            'birthdate2' => $birthdate2,
            'birthdateal2' => $birthdateal2,
        ]);
    }
}
