<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

//Đánh giá tổng quan ngày trong tổng quan ngày trong chi tiết ngày
class FengShuiHelper //cần xác định xem gia chủ thuộc Tây Tứ Mệnh hay Đông Tứ Mệnh trước
{
  /**
     * Tính toán hướng hợp tuổi, Mệnh Trạch, và các thông tin phong thủy khác
     * dựa trên năm sinh và giới tính theo Bát Trạch.
     *
     * @param int $namSinh Năm sinh (ví dụ: 1987, 2005)
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null Trả về một mảng chứa thông tin chi tiết hoặc null nếu đầu vào không hợp lệ.
     */
    
    public static function tinhHuongHopTuoi(int $namSinh, string $gioiTinh): ?array
    {
        
        // Chuẩn hóa đầu vào
        $gioiTinh = strtolower($gioiTinh);
        if (!in_array($gioiTinh, ['nam', 'nữ']) || $namSinh <= 0) {
            return null;
        }

        // --- Bảng tra cứu Quái số ---
        $bangTraCuu = [
            1 => [
                'menh_trach' => 'Khảm',
                'nhom' => 'Đông Tứ Mệnh',
                'ngu_hanh' => 'Thủy',
                'phuong_vi' => 'Bắc',
                'huong_tot' => [
                    'sinh_khi' => 'Đông Nam',
                    'thien_y' => 'Đông',
                    'phuoc_duc' => 'Nam', // Diên niên
                    'phuc_vi' => 'Bắc',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Tây Nam',
                    'ngu_quy' => 'Đông Bắc',
                    'luc_sat' => 'Tây Bắc',
                    'hoa_hai' => 'Tây',
                ],
            ],
            2 => [
                'menh_trach' => 'Khôn',
                'nhom' => 'Tây Tứ Mệnh',
                'ngu_hanh' => 'Thổ',
                'phuong_vi' => 'Tây Nam',
                'huong_tot' => [
                    'sinh_khi' => 'Đông Bắc',
                    'thien_y' => 'Tây',
                    'phuoc_duc' => 'Tây Bắc', // Diên niên
                    'phuc_vi' => 'Tây Nam',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Bắc',
                    'ngu_quy' => 'Đông Nam',
                    'luc_sat' => 'Nam',
                    'hoa_hai' => 'Đông',
                ],
            ],
            3 => [
                'menh_trach' => 'Chấn',
                'nhom' => 'Đông Tứ Mệnh',
                'ngu_hanh' => 'Mộc',
                'phuong_vi' => 'Đông',
                'huong_tot' => [
                    'sinh_khi' => 'Nam',
                    'thien_y' => 'Bắc',
                    'phuoc_duc' => 'Đông Nam', // Diên niên
                    'phuc_vi' => 'Đông',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Tây',
                    'ngu_quy' => 'Tây Bắc',
                    'luc_sat' => 'Đông Bắc',
                    'hoa_hai' => 'Tây Nam',
                ],
            ],
            4 => [
                'menh_trach' => 'Tốn',
                'nhom' => 'Đông Tứ Mệnh',
                'ngu_hanh' => 'Mộc',
                'phuong_vi' => 'Đông Nam',
                'huong_tot' => [
                    'sinh_khi' => 'Bắc',
                    'thien_y' => 'Nam',
                    'phuoc_duc' => 'Đông', // Diên niên
                    'phuc_vi' => 'Đông Nam',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Đông Bắc',
                    'ngu_quy' => 'Tây Nam',
                    'luc_sat' => 'Tây',
                    'hoa_hai' => 'Tây Bắc',
                ],
            ],
            6 => [
                'menh_trach' => 'Càn',
                'nhom' => 'Tây Tứ Mệnh',
                'ngu_hanh' => 'Kim',
                'phuong_vi' => 'Tây Bắc',
                'huong_tot' => [
                    'sinh_khi' => 'Tây',
                    'thien_y' => 'Đông Bắc',
                    'phuoc_duc' => 'Tây Nam', // Diên niên
                    'phuc_vi' => 'Tây Bắc',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Nam',
                    'ngu_quy' => 'Đông',
                    'luc_sat' => 'Bắc',
                    'hoa_hai' => 'Đông Nam',
                ],
            ],
            7 => [
                'menh_trach' => 'Đoài',
                'nhom' => 'Tây Tứ Mệnh',
                'ngu_hanh' => 'Kim',
                'phuong_vi' => 'Tây',
                'huong_tot' => [
                    'sinh_khi' => 'Tây Bắc',
                    'thien_y' => 'Tây Nam', // Sửa từ bảng gốc để nhất quán (Tây Nam hợp hơn là Tây Bắc)
                    'phuoc_duc' => 'Đông Bắc', // Diên niên
                    'phuc_vi' => 'Tây',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Đông',
                    'ngu_quy' => 'Nam',
                    'luc_sat' => 'Đông Nam',
                    'hoa_hai' => 'Bắc',
                ],
            ],
            8 => [
                'menh_trach' => 'Cấn',
                'nhom' => 'Tây Tứ Mệnh',
                'ngu_hanh' => 'Thổ',
                'phuong_vi' => 'Đông Bắc',
                'huong_tot' => [
                    'sinh_khi' => 'Tây Nam',
                    'thien_y' => 'Tây Bắc',
                    'phuoc_duc' => 'Tây', // Diên niên
                    'phuc_vi' => 'Đông Bắc',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Đông Nam',
                    'ngu_quy' => 'Bắc',
                    'luc_sat' => 'Đông',
                    'hoa_hai' => 'Nam',
                ],
            ],
            9 => [
                'menh_trach' => 'Ly',
                'nhom' => 'Đông Tứ Mệnh',
                'ngu_hanh' => 'Hỏa',
                'phuong_vi' => 'Nam',
                'huong_tot' => [
                    'sinh_khi' => 'Đông',
                    'thien_y' => 'Đông Nam',
                    'phuoc_duc' => 'Bắc', // Diên niên
                    'phuc_vi' => 'Nam',
                ],
                'huong_xau' => [
                    'tuyet_menh' => 'Tây Bắc',
                    'ngu_quy' => 'Tây',
                    'luc_sat' => 'Tây Nam',
                    'hoa_hai' => 'Đông Bắc',
                ],
            ],
        ];

        // --- Bước 2: Tính toán ---

        // Lấy 2 số cuối của năm sinh
        $haiSoCuoi = $namSinh % 100;

        // Cộng 2 chữ số cuối lại với nhau
        $tongSo = floor($haiSoCuoi / 10) + ($haiSoCuoi % 10);

        // Rút gọn tổng số nếu nó có 2 chữ số
        if ($tongSo >= 10) {
            $tongSo = floor($tongSo / 10) + ($tongSo % 10);
        }

        $quaiSo = 0;

        // Áp dụng công thức dựa trên mốc năm 2000
        if ($namSinh < 2000) {
            if ($gioiTinh == 'nam') {
                $quaiSo = 10 - $tongSo;
            } else { // Nữ
                $quaiSo = 5 + $tongSo;
            }
        } else { // Sinh từ năm 2000 trở đi
            if ($gioiTinh == 'nam') {
                $quaiSo = 9 - $tongSo;
            } else { // Nữ
                $quaiSo = 6 + $tongSo;
            }
        }

        // Rút gọn quái số nếu lớn hơn 9
        if ($quaiSo > 9) {
             $quaiSo = $quaiSo % 10; // Có thể rút gọn tiếp nếu cần, nhưng thường chỉ cần 1 lần
             if ($quaiSo > 9) {
                $quaiSo = floor($quaiSo / 10) + ($quaiSo % 10);
             }
        }
        if($quaiSo == 0) $quaiSo = 9; // Trường hợp đặc biệt khi kết quả là 10-1=9, 9-9=0

        // Xử lý trường hợp đặc biệt Quái số = 5
        if ($quaiSo == 5) {
            if ($gioiTinh == 'nam') {
                $quaiSo = 2; // Nam là Khôn
            } else {
                $quaiSo = 8; // Nữ là Cấn
            }
        }

        // --- Bước 3: Tra cứu và trả về kết quả ---
        if (!isset($bangTraCuu[$quaiSo])) {
            return null; // Không tìm thấy quái số hợp lệ
        }

        $ketQua = $bangTraCuu[$quaiSo];
        $ketQua['quai_so'] = $quaiSo; // Thêm quái số vào kết quả
        $ketQua['cung_menh'] = $ketQua['menh_trach']; // Thêm một key phổ biến khác
        
        // Thêm các hướng hợp tuổi chung
        if ($ketQua['nhom'] === 'Đông Tứ Mệnh') {
            $ketQua['cac_huong_hop_tuoi'] = ['Bắc', 'Đông', 'Đông Nam', 'Nam'];
        } else {
            $ketQua['cac_huong_hop_tuoi'] = ['Tây', 'Tây Bắc', 'Tây Nam', 'Đông Bắc'];
        }

        return $ketQua;
    }
}