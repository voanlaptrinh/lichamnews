<?php

namespace App\Http\Controllers;

use App\Helpers\CompatibilityHelper;
use App\Helpers\LunarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CompatibilityController extends Controller
{
    /**
     * Hiển thị form xem tuổi hợp
     */
    public function showForm()
    {
        $input = [
            'birthdateA' => '',
            'genderA' => 'nam',
            'birthdateB' => '',
            'genderB' => 'nữ',
            'type' => 'capdoi'
        ];

        return view('xem-tuoi-codau-chure.index')->with('input', $input);
    }

    /**
     * Xử lý tính toán xem tuổi hợp
     */
    public function calculate(Request $request)
    {
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

        $birthdateal1 = LunarHelper::convertSolar2Lunar($birthdate1->day, $birthdate1->month, $birthdate1->year);
        $birthdateal2 = LunarHelper::convertSolar2Lunar($birthdate2->day, $birthdate2->month, $birthdate2->year);

        $result = CompatibilityHelper::calculate(
            $birthdateal1[2],
            $validated['genderA'],
            $birthdateal2[2],
            $validated['genderB'],
            $validated['type'],
            $birthdate1,
            $birthdate2,
            $birthdateal1,
            $birthdateal2
        );

        $viewData = [
            'results' => $result,
            'input' => $validated,
            'birthdate1' => $birthdate1,
            'birthdateal1' => $birthdateal1,
            'birthdate2' => $birthdate2,
            'birthdateal2' => $birthdateal2,
            'type' => $validated['type']
        ];

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('xem-tuoi-codau-chure.results', $viewData)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return view('xem-tuoi-codau-chure.index', $viewData);
    }
}
