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
            // SỬA ĐỔI: Validation cho ngày sinh thay vì năm sinh
            'dob1' => "required|date_format:$dateFormat",
            'gender1' => 'required|in:Nam,Nữ',
            'dob2' => "required|date_format:$dateFormat",
            'gender2' => 'required|in:Nam,Nữ',
            'type' => 'required|in:capdoi,laman',
        ], [
            'required' => 'Thông tin :attribute là bắt buộc.',
            'date_format' => 'Ngày sinh không đúng định dạng (dd-mm-yyyy).',
            'in' => 'Giá trị của :attribute không hợp lệ.',
        ], [
            // SỬA ĐỔI: Đặt lại tên cho thân thiện hơn
            'dob1' => 'ngày sinh người thứ nhất',
            'dob2' => 'ngày sinh người thứ hai',
        ]);

        // Thêm quy tắc validation tùy chỉnh
        $validator->after(function ($validator) use ($request, $dateFormat, $minYear, $maxYear) {
            // Kiểm tra giới tính khi xem tuổi vợ chồng
            if ($request->input('type') === 'capdoi' && $request->input('gender1') === $request->input('gender2')) {
                $validator->errors()->add(
                    'gender2',
                    'Khi xem tuổi Vợ Chồng, giới tính của hai người phải khác nhau.'
                );
            }

            // SỬA ĐỔI: Kiểm tra khoảng năm sinh sau khi định dạng ngày đã hợp lệ
            if ($request->filled('dob1') && !$validator->errors()->has('dob1')) {
                $year1 = Carbon::createFromFormat($dateFormat, $request->input('dob1'))->year;
                if ($year1 < $minYear || $year1 > $maxYear) {
                    $validator->errors()->add('dob1', "Năm sinh phải trong khoảng từ $minYear đến $maxYear.");
                }
            }

            if ($request->filled('dob2') && !$validator->errors()->has('dob2')) {
                $year2 = Carbon::createFromFormat($dateFormat, $request->input('dob2'))->year;
                if ($year2 < $minYear || $year2 > $maxYear) {
                    $validator->errors()->add('dob2', "Năm sinh phải trong khoảng từ $minYear đến $maxYear.");
                }
            }
        });


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput(); // withInput() sẽ lưu tất cả input vào session để hàm old() có thể lấy ra
        }

        $validated = $validator->validated();

        // SỬA ĐỔI: Lấy năm từ ngày sinh đã được validate
        $year1 = Carbon::createFromFormat($dateFormat, $validated['dob1'])->year;

    //Ngày tháng năm sinh âm dương người 1
        $birthdate1 =  Carbon::createFromFormat($dateFormat, $validated['dob1']); //ngày tháng năm sinh dương
        $birthdateal1 =  LunarHelper::convertSolar2Lunar($birthdate1->day, $birthdate1->month, $birthdate1->year); //ngày tháng năm sinh dương
    //end
    //Ngày tháng năm sinh âm dương người 2
        $birthdate2 =  Carbon::createFromFormat($dateFormat, $validated['dob2']); //ngày tháng năm sinh dương
        $birthdateal2 =  LunarHelper::convertSolar2Lunar($birthdate2->day, $birthdate2->month, $birthdate2->year); //ngày tháng năm sinh dương
    //end


        $year2 = Carbon::createFromFormat($dateFormat, $validated['dob2'])->year;
        // 2. Gọi Helper để tính toán
        $result = CompatibilityHelper::calculate(
            $year1, // Truyền năm đã được trích xuất
            $validated['gender1'],
            $year2, // Truyền năm đã được trích xuất
            $validated['gender2'],
            $validated['type']
        );

        // 3. Trả về view với dữ liệu kết quả và dữ liệu đầu vào
        return view('xem-tuoi-codau-chure.index')->with([
            'result' => $result,
            'input' => $validated, // Truyền lại toàn bộ dữ liệu đã nhập để fill lại form
            'birthdate1' => $birthdate1,
            'birthdateal1' => $birthdateal1,
            'birthdate2' => $birthdate2,
            'birthdateal2' => $birthdateal2,
        ]);
    }
}