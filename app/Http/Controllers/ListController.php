<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{
    public function XemNgayTots()
    {
        $metaTitle = "Xem Ngày Tốt Theo Tuổi | Chọn Ngày Đẹp Cho Từng Công Việc";
        $metaDescription = "Xem ngày tốt theo tuổi cho mọi công việc quan trọng: cưới hỏi, động thổ, khai trương, mua nhà, mua xe, ký hợp đồng… Tra cứu nhanh – chính xác – dễ sử dụng.";
        return view('tools.list.list-xem-ngay-totxau', compact('metaTitle', 'metaDescription'));
    }
    public function XemHuongHopTuoi()
    {
        $metaTitle = "Xem Hướng Hợp Tuổi Chuẩn Phong Thủy | Chọn Hướng Tốt Cho Mọi Không Gian";
        $metaDescription = "Công cụ xem hướng hợp tuổi theo phong thủy Bát Trạch – giúp bạn chọn hướng nhà, hướng bếp, phòng ngủ, bàn thờ và bàn làm việc chuẩn nhất. Hỗ trợ mọi tuổi, mọi mệnh.";

        return view('huong-hop-tuoi.listxemhuonghoptuoi', compact('metaTitle', 'metaDescription'));
    }
}
