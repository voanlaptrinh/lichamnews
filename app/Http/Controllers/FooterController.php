<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function lienHe(){
        $metaTitle = "Liên hệ với chúng tôi - Phong Lịch";
        $metaDescription = "Liên hệ Phong Lịch để được hỗ trợ, đóng góp ý kiến hoặc hợp tác. Chúng tôi luôn sẵn sàng lắng nghe.";
        return view('layout.footercontent.lien-hecontent', ['metaTitle' => $metaTitle, 'metaDescription' => $metaDescription]);
    }
    public function dieuKhoan(){
        $metaTitle = "Điều Khoản Dịch Vụ - Phong Lịch";
        $metaDescription = "Tìm hiểu điều khoản dịch vụ của Phong Lịch – quy định sử dụng, quyền và nghĩa vụ của người dùng khi truy cập, tra cứu lịch âm dương, tử vi, phong thủy trên website.";
        return view('layout.footercontent.dieu-khoan', ['metaTitle' => $metaTitle, 'metaDescription' => $metaDescription]);
    }
    public function chinhSach(){
        $metaTitle = "Chính sách bảo mật - Phong Lịch";
        $metaDescription = "Đọc chính sách bảo mật của Phong Lịch – cam kết bảo vệ thông tin cá nhân, quyền riêng tư và dữ liệu người dùng khi sử dụng các tính năng xem lịch và phong thủy.";
        return view('layout.footercontent.chinh-sach', ['metaTitle' => $metaTitle, 'metaDescription' => $metaDescription]);
    }
}
