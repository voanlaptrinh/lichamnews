<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ho_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date',
            'gio_sinh' => 'nullable|',
            'gioi_tinh' => 'required|in:nam,nu',
            'nam_xem' => 'required|integer|digits:4',
            'so_dien_thoai' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'trang_thai_xu_ly' => 'nullable|in:cho_xu_ly,dang_xu_ly,hoan_thanh,huy_bo',
            'trang_thai_thu_tien' => 'nullable|in:chua_thanh_toan,da_thanh_toan,hoan_tien',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customerId = DB::connection('secondary')->table('customer_info')->insertGetId([
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gio_sinh' => $request->gio_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'nam_xem' => $request->nam_xem,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'trang_thai_xu_ly' => $request->trang_thai_xu_ly ?? 'cho_xu_ly',
                'trang_thai_thu_tien' => $request->trang_thai_thu_tien ?? 'chua_thanh_toan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thông tin khách hàng đã được lưu thành công',
                'customer_id' => $customerId
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save customer info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu thông tin khách hàng'
            ], 500);
        }
    }
}