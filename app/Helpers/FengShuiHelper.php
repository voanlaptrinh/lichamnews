<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

//Đánh giá tổng quan ngày trong tổng quan ngày trong chi tiết ngày
class FengShuiHelper //cần xác định xem gia chủ thuộc Tây Tứ Mệnh hay Đông Tứ Mệnh trước
{


    /**
     * Hàm chính: Lấy thông tin chi tiết về hướng đặt bàn thờ cho gia chủ.
     *
     * @param int $namSinh Năm sinh dương lịch (ví dụ: 2000)
     * @param string $thangSinh Tháng sinh dương lịch
     * @param string $ngaySinh Ngày sinh dương lịch
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null Mảng kết quả hoặc null nếu không hợp lệ.
     */
    public static function layHuongBanTho(int $namSinh, int $thangSinh, int $ngaySinh, string $gioiTinh): ?array
    {
        $phongThuyCoBan = self::tinhHuongHopTuoi($namSinh, $gioiTinh);

        if ($phongThuyCoBan === null) {
            return null;
        }
        $today = now();
        $solarDay = (int)$today->format('d');
        $solarMonth = (int)$today->format('m');
        $solarYear = (int)$today->format('Y');

        // Đổi sang âm lịch hiện tại
        $lunarToday = LunarHelper::convertSolar2Lunar($solarDay, $solarMonth, $solarYear);
        $lunarYearNow = $lunarToday[2];  // Năm âm lịch hiện tại
        $cungMenh = $phongThuyCoBan['menh_trach'];
        $huongBanThoTotNhat = self::getBangHuongBanTho()[$cungMenh] ?? [];

        // --- Bổ sung thông tin Âm lịch ---
        // Chuyển đổi ngày sinh Dương sang Âm
        $lunarDob = LunarHelper::convertSolar2Lunar($ngaySinh, $thangSinh, $namSinh);
        $lunarDay = $lunarDob[0];
        $lunarMonth = $lunarDob[1];
        $lunarYear = $lunarDob[2]; // Năm âm lịch
        $tuoiAm = $lunarYearNow - $lunarYear + 1;

        // Lấy Can Chi của năm sinh Âm lịch
        $canChiNamSinh = LunarHelper::canchiNam($lunarYear);

        $ketQua = [
            'basicInfo' => [
                // Thông tin gốc
                'ngaySinhDuongLich' => sprintf('%02d/%02d/%d', $ngaySinh, $thangSinh, $namSinh),
                'gioiTinh' => ucfirst(strtolower($gioiTinh)),
                'menhQuai' => $phongThuyCoBan['menh_trach'] . ' - hành ' . $phongThuyCoBan['ngu_hanh'],
                'thuocNhom' => $phongThuyCoBan['nhom'],
                'ngaySinhAmLich' => sprintf('%02d/%02d/%d (%s)', $lunarDay, $lunarMonth, $lunarYear, $canChiNamSinh),
            ],
            'nguyenTacDatBanTho' => [
                'Bàn thờ nên đặt tại vị trí cát (trong nhà) và quay mặt về hướng cát.',
                'Đặc biệt, hướng nhìn ra (mặt bàn thờ) là yếu tố quan trọng nhất.',
            ],
            'ageInfo' => [
                'tuoiAm' => $tuoiAm,
                'namAmHienTai' => $lunarYearNow,
            ],
            'huongDatBanThoTotNhat' => $huongBanThoTotNhat,

        ];

        return $ketQua;
    }

    /**
     * Hàm lõi: Tính toán hướng hợp tuổi, Mệnh Trạch, và các thông tin phong thủy khác
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
        if (!in_array($gioiTinh, ['nam', 'nữ']) || $namSinh <= 1900 || $namSinh > 2100) {
            return null;
        }

        // --- Bảng tra cứu Quái số ---
        // Bảng này chứa thông tin gốc của Bát Trạch
        $bangTraCuu = [
            1 => ['menh_trach' => 'Khảm', 'nhom' => 'Đông Tứ Mệnh', 'ngu_hanh' => 'Thủy', 'phuong_vi' => 'Bắc', 'huong_tot' => ['sinh_khi' => 'Đông Nam', 'thien_y' => 'Đông', 'phuoc_duc' => 'Nam', 'phuc_vi' => 'Bắc'], 'huong_xau' => ['tuyet_menh' => 'Tây Nam', 'ngu_quy' => 'Đông Bắc', 'luc_sat' => 'Tây Bắc', 'hoa_hai' => 'Tây']],
            2 => ['menh_trach' => 'Khôn', 'nhom' => 'Tây Tứ Mệnh', 'ngu_hanh' => 'Thổ', 'phuong_vi' => 'Tây Nam', 'huong_tot' => ['sinh_khi' => 'Đông Bắc', 'thien_y' => 'Tây', 'phuoc_duc' => 'Tây Bắc', 'phuc_vi' => 'Tây Nam'], 'huong_xau' => ['tuyet_menh' => 'Bắc', 'ngu_quy' => 'Đông Nam', 'luc_sat' => 'Nam', 'hoa_hai' => 'Đông']],
            3 => ['menh_trach' => 'Chấn', 'nhom' => 'Đông Tứ Mệnh', 'ngu_hanh' => 'Mộc', 'phuong_vi' => 'Đông', 'huong_tot' => ['sinh_khi' => 'Nam', 'thien_y' => 'Bắc', 'phuoc_duc' => 'Đông Nam', 'phuc_vi' => 'Đông'], 'huong_xau' => ['tuyet_menh' => 'Tây', 'ngu_quy' => 'Tây Bắc', 'luc_sat' => 'Đông Bắc', 'hoa_hai' => 'Tây Nam']],
            4 => ['menh_trach' => 'Tốn', 'nhom' => 'Đông Tứ Mệnh', 'ngu_hanh' => 'Mộc', 'phuong_vi' => 'Đông Nam', 'huong_tot' => ['sinh_khi' => 'Bắc', 'thien_y' => 'Nam', 'phuoc_duc' => 'Đông', 'phuc_vi' => 'Đông Nam'], 'huong_xau' => ['tuyet_menh' => 'Đông Bắc', 'ngu_quy' => 'Tây Nam', 'luc_sat' => 'Tây', 'hoa_hai' => 'Tây Bắc']],
            6 => ['menh_trach' => 'Càn', 'nhom' => 'Tây Tứ Mệnh', 'ngu_hanh' => 'Kim', 'phuong_vi' => 'Tây Bắc', 'huong_tot' => ['sinh_khi' => 'Tây', 'thien_y' => 'Đông Bắc', 'phuoc_duc' => 'Tây Nam', 'phuc_vi' => 'Tây Bắc'], 'huong_xau' => ['tuyet_menh' => 'Nam', 'ngu_quy' => 'Đông', 'luc_sat' => 'Bắc', 'hoa_hai' => 'Đông Nam']],
            7 => ['menh_trach' => 'Đoài', 'nhom' => 'Tây Tứ Mệnh', 'ngu_hanh' => 'Kim', 'phuong_vi' => 'Tây', 'huong_tot' => ['sinh_khi' => 'Tây Bắc', 'thien_y' => 'Tây Nam', 'phuoc_duc' => 'Đông Bắc', 'phuc_vi' => 'Tây'], 'huong_xau' => ['tuyet_menh' => 'Đông', 'ngu_quy' => 'Nam', 'luc_sat' => 'Đông Nam', 'hoa_hai' => 'Bắc']],
            8 => ['menh_trach' => 'Cấn', 'nhom' => 'Tây Tứ Mệnh', 'ngu_hanh' => 'Thổ', 'phuong_vi' => 'Đông Bắc', 'huong_tot' => ['sinh_khi' => 'Tây Nam', 'thien_y' => 'Tây Bắc', 'phuoc_duc' => 'Tây', 'phuc_vi' => 'Đông Bắc'], 'huong_xau' => ['tuyet_menh' => 'Đông Nam', 'ngu_quy' => 'Bắc', 'luc_sat' => 'Đông', 'hoa_hai' => 'Nam']],
            9 => ['menh_trach' => 'Ly', 'nhom' => 'Đông Tứ Mệnh', 'ngu_hanh' => 'Hỏa', 'phuong_vi' => 'Nam', 'huong_tot' => ['sinh_khi' => 'Đông', 'thien_y' => 'Đông Nam', 'phuoc_duc' => 'Bắc', 'phuc_vi' => 'Nam'], 'huong_xau' => ['tuyet_menh' => 'Tây Bắc', 'ngu_quy' => 'Tây', 'luc_sat' => 'Tây Nam', 'hoa_hai' => 'Đông Bắc']],
        ];

        // --- Bước 2: Tính toán Quái số ---
        $tongSo = array_sum(str_split((string) $namSinh));
        while ($tongSo >= 10) {
            $tongSo = array_sum(str_split((string) $tongSo));
        }

        $quaiSo = 0;
        if ($gioiTinh == 'nam') {
            $quaiSo = 11 - $tongSo;
        } else { // Nữ
            $quaiSo = 4 + $tongSo;
        }

        // Rút gọn quái số nếu lớn hơn 9
        if ($quaiSo > 9) {
            $quaiSo %= 9;
        }
        if ($quaiSo == 0) $quaiSo = 9;

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
        $ketQua['quai_so'] = $quaiSo;
        $ketQua['cung_menh'] = $ketQua['menh_trach'];

        return $ketQua;
    }

    /**
     * Hàm private: Cung cấp dữ liệu các hướng tốt cho bàn thờ.
     * Dữ liệu đã được sắp xếp ưu tiên và gán ý nghĩa phù hợp cho việc thờ cúng.
     *
     * @return array
     */
    private static function getBangHuongBanTho(): array
    {
        return [
            // --- TÂY TỨ MỆNH ---
            'Khôn' => [
                ['huong' => 'Tây Nam (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Tây (Thiên Y)', 'y_nghia' => 'Công việc thuận lợi, hanh thông, cuộc sống tốt đẹp.', 'uu_tien' => 'Ưu tiên 2'], // Tên đã được tùy chỉnh cho giống ảnh
                ['huong' => 'Tây Bắc (Phước Đức)', 'y_nghia' => 'Sức khỏe dồi dào, tránh ốm đau, gặp nhiều may mắn và quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 3'], // Tên đã được tùy chỉnh
                ['huong' => 'Đông Bắc (Sinh Khí)', 'y_nghia' => 'Tình cảm vợ chồng, cha mẹ, con cái trở nên khăng khít và tốt đẹp.', 'uu_tien' => 'Ưu tiên 4'], // Tên đã được tùy chỉnh
            ],
            'Càn' => [
                ['huong' => 'Tây Bắc (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Đông Bắc (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Tây Nam (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Tây (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            'Cấn' => [
                ['huong' => 'Đông Bắc (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Tây (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Tây Bắc (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Tây Nam (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            'Đoài' => [
                ['huong' => 'Tây (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Tây Nam (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Đông Bắc (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Tây Bắc (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            // --- ĐÔNG TỨ MỆNH ---
            'Khảm' => [
                ['huong' => 'Bắc (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Đông (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Nam (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Đông Nam (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            'Ly' => [
                ['huong' => 'Nam (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Đông Nam (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Bắc (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Đông (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            'Chấn' => [
                ['huong' => 'Đông (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Bắc (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Đông Nam (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Nam (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
            'Tốn' => [
                ['huong' => 'Đông Nam (Phục Vị)', 'y_nghia' => 'Được tổ tiên phù trì, vượng khí và tài lộc.', 'uu_tien' => 'Ưu tiên 1'],
                ['huong' => 'Nam (Thiên Y)', 'y_nghia' => 'Sức khỏe dồi dào, gặp nhiều may mắn, quý nhân phù trợ.', 'uu_tien' => 'Ưu tiên 2'],
                ['huong' => 'Đông (Phước Đức)', 'y_nghia' => 'Gia đình hòa thuận, các mối quan hệ tốt đẹp.', 'uu_tien' => 'Ưu tiên 3'],
                ['huong' => 'Bắc (Sinh Khí)', 'y_nghia' => 'Thu hút tài lộc, công danh sự nghiệp phát triển.', 'uu_tien' => 'Ưu tiên 4'],
            ],
        ];
    }

    /**
     * Lấy thông tin về hướng nhà hợp tuổi với cấu trúc dữ liệu mới.
     *
     * @param int $namSinh Năm sinh dương lịch
     * @param int $thangSinh Tháng sinh dương lịch
     * @param int $ngaySinh Ngày sinh dương lịch
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null Trả về mảng kết quả hoặc null nếu không hợp lệ.
     */
    public static function layHuongNha(int $namSinh, int $thangSinh, int $ngaySinh, string $gioiTinh): ?array
    {
        // 1. Lấy thông tin phong thủy Bát Trạch cơ bản
        $phongThuyCoBan = self::tinhHuongHopTuoi($namSinh, $gioiTinh);

        if ($phongThuyCoBan === null) {
            return null;
        }
        $today = now();
        $solarDay = (int)$today->format('d');
        $solarMonth = (int)$today->format('m');
        $solarYear = (int)$today->format('Y');

        // Đổi sang âm lịch hiện tại
        $lunarToday = LunarHelper::convertSolar2Lunar($solarDay, $solarMonth, $solarYear);
        $lunarYearNow = $lunarToday[2];  // Năm âm lịch hiện tại
        // --- Bắt đầu xây dựng cấu trúc dữ liệu mới theo yêu cầu ---

        // 2. Chuẩn bị dữ liệu cho mục "Thông tin cơ bản"
        $lunarDob = LunarHelper::convertSolar2Lunar($ngaySinh, $thangSinh, $namSinh);
        $canChiNamSinh = LunarHelper::canchiNam($lunarDob[2]); // Lấy Can Chi của năm Âm lịch

        $basicInfo = [
            'ngaySinhDuongLich' => sprintf('%02d/%02d/%d', $ngaySinh, $thangSinh, $namSinh),
            'ngaySinhAmLich' => sprintf('%02d/%02d/%d (%s)', $lunarDob[0], $lunarDob[1], $lunarDob[2], $canChiNamSinh),
            'gioiTinh' => ucfirst(strtolower($gioiTinh)),
            'menhQuai' => $phongThuyCoBan['menh_trach'] . ' - hành ' . $phongThuyCoBan['ngu_hanh'],
            'thuocNhom' => $phongThuyCoBan['nhom'],
        ];

        // 3. Chuẩn bị dữ liệu cho mục "Nguyên tắc chọn hướng nhà"
        $nguyenTac = [
            'huongCat' => ['Sinh Khí', 'Thiên Y', 'Phước Đức', 'Phục Vị'], // Tên các loại hướng tốt
            'huongHung' => ['Ngũ Quỷ', 'Lục Sát', 'Họa Hại', 'Tuyệt Mạng'] // Tên các loại hướng xấu
        ];

        // 4. Lấy bảng phân tích chi tiết các hướng tốt/xấu (để sử dụng nếu cần)
        $huongTotGoc = $phongThuyCoBan['huong_tot'];
        $huongNhaTotChiTiet = self::getHuongTot($huongTotGoc);
        $huongNhaXauChiTiet = $phongThuyCoBan['huong_xau'];
        $lunarYear = $lunarDob[2]; // Năm âm lịch
        $tuoiAm = $lunarYearNow - $lunarYear + 1;

        // 5. Kết hợp tất cả lại thành kết quả cuối cùng
        return [
            'basicInfo' => $basicInfo,
            'nguyenTac' => $nguyenTac,
            'huongNhaTotChiTiet' => $huongNhaTotChiTiet, // Bảng chi tiết hướng tốt, rất hữu ích để hiển thị thêm
            'huongNhaXauChiTiet' => $huongNhaXauChiTiet, // Bảng chi tiết hướng xấu
            'ageInfo' => [
                'tuoiAm' => $tuoiAm,
                'namAmHienTai' => $lunarYearNow,
            ],
        ];
    }
    /**
     * Hàm private: Cung cấp ý nghĩa các hướng tốt cho mục đích xây nhà.
     * Sắp xếp theo thứ tự ưu tiên: Sinh Khí > Thiên Y > Diên Niên > Phục Vị.
     *
     * @param array $huongTotGoc Mảng các hướng tốt từ hàm tinhHuongHopTuoi
     * @return array
     */
    private static function getHuongTot(array $huongTotGoc): array
    {
        $yNghia = [
            'sinh_khi' => 'Vượng nhất, hút tiền tài, sự nghiệp phát triển mạnh',
            'thien_y' => 'Cát lợi về sức khỏe, gặp nhiều may mắn.',
            'phuoc_duc' => 'Gia đạo tốt, hôn nhân bền vững, quan hệ tốt.', // phuoc_duc là Diên Niên
            'phuc_vi' => 'Tốt cho tĩnh tại, nội tâm, phù hợp nơi thờ cúng.'
        ];

        return [
            ['huong' => $huongTotGoc['sinh_khi'], 'loai' => 'Sinh Khí', 'y_nghia' => $yNghia['sinh_khi'], 'uu_tien' => 'Ưu tiên 1'],
            ['huong' => $huongTotGoc['thien_y'], 'loai' => 'Thiên Y', 'y_nghia' => $yNghia['thien_y'], 'uu_tien' => 'Ưu tiên 2'],
            ['huong' => $huongTotGoc['phuoc_duc'], 'loai' => 'Diên Niên (Phước Đức)', 'y_nghia' => $yNghia['phuoc_duc'], 'uu_tien' => 'Ưu tiên 3'],
            ['huong' => $huongTotGoc['phuc_vi'], 'loai' => 'Phục Vị', 'y_nghia' => $yNghia['phuc_vi'], 'uu_tien' => 'Ưu tiên 4'],
        ];
    }


    /**
     * HÀM ĐƯỢC VIẾT LẠI: Lấy thông tin về hướng bếp hợp tuổi theo cách tiếp cận đơn giản hơn.
     * Tập trung vào việc chọn "hướng cát" để bếp quay về.
     *
     * @param int $namSinh Năm sinh dương lịch
     * @param int $thangSinh Tháng sinh dương lịch
     * @param int $ngaySinh Ngày sinh dương lịch
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null
     */
    public static function layHuongBep(int $namSinh, int $thangSinh, int $ngaySinh, string $gioiTinh): ?array
    {
        // 1. Tái sử dụng hàm gốc để lấy dữ liệu Bát Trạch
        $phongThuyCoBan = self::tinhHuongHopTuoi($namSinh, $gioiTinh);

        if ($phongThuyCoBan === null) {
            return null;
        }

        // 2. Chuẩn bị dữ liệu cho mục "Thông tin cơ bản"
        $lunarDob = LunarHelper::convertSolar2Lunar($ngaySinh, $thangSinh, $namSinh);
        $canChiNamSinh = LunarHelper::canchiNam($lunarDob[2]);

        $basicInfo = [
            'ngaySinhDuongLich' => sprintf('%02d/%02d/%d', $ngaySinh, $thangSinh, $namSinh),
            'ngaySinhAmLich' => sprintf('%02d/%02d/%d (%s)', $lunarDob[0], $lunarDob[1], $lunarDob[2], $canChiNamSinh),
            'gioiTinh' => ucfirst(strtolower($gioiTinh)),
            'menhQuai' => $phongThuyCoBan['menh_trach'] . ' - hành ' . $phongThuyCoBan['ngu_hanh'],
            'thuocNhom' => $phongThuyCoBan['nhom'],
        ];

        // 3. Chuẩn bị dữ liệu cho mục "Nguyên tắc chọn hướng bếp"
        $nguyenTac = [
            'title' => 'Tọa hung - hướng cát',
            'rules' => [
                'Bếp nên tọa ở vị trí hướng xấu (hung) để trấn áp tà khí',
                'Miệng bếp (hướng lửa) nên quay về hướng tốt (cát) để thu nạp khí lành',
                'Nếu không chọn được tọa hung, thì ít nhất phải quay về hướng tốt là đã đạt 80% phong thủy.',
            ],
            'note' => 'Hướng bếp là hướng ngược với người đứng nấu (tức là hướng lưng của người nấu).'
        ];

        // 4. Lấy bảng các hướng tốt nhất để bếp quay về
        // Tái sử dụng hàm getHuongTot đã có, vì logic ưu tiên (Sinh Khí > Thiên Y...) là giống nhau
        $huongBepTotNhat = self::getHuongTot($phongThuyCoBan['huong_tot']);

        // 5. Kết hợp tất cả lại
        return [
            'basicInfo' => $basicInfo,
            'nguyenTac' => $nguyenTac,
            'huongBepTotNhat' => $huongBepTotNhat,
        ];
    }





    /**
     * HÀM MỚI: Lấy thông tin về hướng phòng ngủ và giường ngủ hợp tuổi.
     *
     * @param int $namSinh Năm sinh dương lịch
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null
     */
    public static function layHuongPhongNgu(int $namSinh, int $thangSinh, int $ngaySinh, string $gioiTinh): ?array
    {
        // 1. Tái sử dụng hàm gốc để lấy dữ liệu Bát Trạch
        $phongThuyCoBan = self::tinhHuongHopTuoi($namSinh, $gioiTinh);

        if ($phongThuyCoBan === null) {
            return null;
        }
        // 2. Chuẩn bị dữ liệu cho mục "Thông tin cơ bản"
        $lunarDob = LunarHelper::convertSolar2Lunar($ngaySinh, $thangSinh, $namSinh);
        $canChiNamSinh = LunarHelper::canchiNam($lunarDob[2]);
        // 2. Lấy danh sách hướng tốt gốc
        $huongTotGoc = $phongThuyCoBan['huong_tot'];

        // 3. Sắp xếp và diễn giải lại các hướng theo mục đích PHÒNG NGỦ
        $huongPhongNguChiTiet = self::getBangHuongPhongNgu($huongTotGoc);

        // 4. Định dạng kết quả trả về
        return [
            'basicInfo' => [
                'ngaySinhDuongLich' => sprintf('%02d/%02d/%d', $ngaySinh, $thangSinh, $namSinh),
                'ngaySinhAmLich' => sprintf('%02d/%02d/%d (%s)', $lunarDob[0], $lunarDob[1], $lunarDob[2], $canChiNamSinh),
                'gioiTinh' => ucfirst(strtolower($gioiTinh)),
                'menhQuai' => $phongThuyCoBan['menh_trach'] . ' - hành ' . $phongThuyCoBan['ngu_hanh'],
                'thuocNhom' => $phongThuyCoBan['nhom'],
            ],
            'huongTotChiTiet' => $huongPhongNguChiTiet,
            'huongXauChiTiet' => $phongThuyCoBan['huong_xau'],
            'nguyenTac' => [
                'Hướng đầu giường (hoặc hướng nhìn ra từ giường) nên quay về các hướng cát: Thiên Y, Phước Đức, Sinh Khí, Phục Vị'
            ]
        ];
    }

    /**
     * Hàm private: Cung cấp ý nghĩa các hướng tốt cho mục đích PHÒNG NGỦ.
     * Ưu tiên hàng đầu là Thiên Y (sức khỏe) và Diên Niên (tình cảm).
     *
     * @param array $huongTotGoc Mảng các hướng tốt từ hàm tinhHuongHopTuoi
     * @return array
     */
    private static function getBangHuongPhongNgu(array $huongTotGoc): array
    {
        $yNghia = [
            'thien_y' => 'Cát lợi về sức khỏe, gặp nhiều may mắn',
            'phuoc_duc' => 'Gia đạo tốt, hôn nhân bền vững, quan hệ tốt', // Diên Niên
            'phuc_vi' => 'Tốt cho tĩnh tại, nội tâm, phù hợp nơi thờ cúng',
            'sinh_khi' => 'Hút tiền tài, sự nghiệp phát triển mạnh'
        ];

        // Sắp xếp lại theo thứ tự ưu tiên cho phòng ngủ
        return [
            ['Huong' => $huongTotGoc['thien_y'], 'Loai' => 'Thiên Y', 'Y_nghia' => $yNghia['thien_y'], 'Uu_tien' => 'Ưu tiên 1'],
            ['Huong' => $huongTotGoc['phuoc_duc'], 'Loai' => 'Diên Niên (Phước Đức)', 'Y_nghia' => $yNghia['phuoc_duc'], 'Uu_tien' => 'Ưu tiên 2'],
            ['Huong' => $huongTotGoc['phuc_vi'], 'Loai' => 'Phục Vị', 'Y_nghia' => $yNghia['phuc_vi'], 'Uu_tien' => 'Ưu tiên 3'],
            ['Huong' => $huongTotGoc['sinh_khi'], 'Loai' => 'Sinh Khí', 'Y_nghia' => $yNghia['sinh_khi'], 'Uu_tien' => 'Ưu tiên 4'],
        ];
    }






    /**
     * HÀM MỚI: Lấy thông tin về hướng bàn làm việc hợp tuổi.
     *
     * @param int $namSinh Năm sinh dương lịch
     * @param string $gioiTinh Giới tính ('nam' hoặc 'nữ')
     * @return array|null
     */
    public static function layHuongBanLamViec(int $namSinh, int $thangSinh, int $ngaySinh, string $gioiTinh): ?array
    {
        // 1. Tái sử dụng hàm gốc để lấy dữ liệu Bát Trạch
        $phongThuyCoBan = self::tinhHuongHopTuoi($namSinh, $gioiTinh);

        if ($phongThuyCoBan === null) {
            return null;
        }

        // 2. Lấy danh sách hướng tốt gốc
        // $huongTotGoc = $phongThuyCoBan['huong_tot'];

        // // 3. Sắp xếp và diễn giải lại các hướng theo mục đích BÀN LÀM VIỆC
        // $huongBanLamViecChiTiet = self::getBangHuongBanLamViec($huongTotGoc);

        // 2. Chuẩn bị dữ liệu cho mục "Thông tin cơ bản"
        $lunarDob = LunarHelper::convertSolar2Lunar($ngaySinh, $thangSinh, $namSinh);
        $canChiNamSinh = LunarHelper::canchiNam($lunarDob[2]);
        // 2. Lấy danh sách hướng tốt gốc
        $huongTotGoc = $phongThuyCoBan['huong_tot'];

        // 3. Sắp xếp và diễn giải lại các hướng theo mục đích PHÒNG NGỦ
        $huongBanLamViecChiTiet = self::getBangHuongBanLamViec($huongTotGoc);

        // 4. Định dạng kết quả trả về
        return [
            'basicInfo' => [
                'ngaySinhDuongLich' => sprintf('%02d/%02d/%d', $ngaySinh, $thangSinh, $namSinh),
                'ngaySinhAmLich' => sprintf('%02d/%02d/%d (%s)', $lunarDob[0], $lunarDob[1], $lunarDob[2], $canChiNamSinh),
                'gioiTinh' => ucfirst(strtolower($gioiTinh)),
                'menhQuai' => $phongThuyCoBan['menh_trach'] . ' - hành ' . $phongThuyCoBan['ngu_hanh'],
                'thuocNhom' => $phongThuyCoBan['nhom'],
            ],
            'huongTotChiTiet' => $huongBanLamViecChiTiet,
            'huongXauChiTiet' => $phongThuyCoBan['huong_xau'],
            'nguyenTac' => [
                '<ul><li>Tọa hung - hướng cát: Quay mặt về hướng tốt (hướng cát) để nạp sinh khí. Lưng ghế tọa hướng xấu (hung)</li><li>Nếu không chọn được tọa hung, thì ít nhất phải quay về hướng tốt là đã đạt 80% phong thủy</li> </ul>'
            ]
        ];
    }

    /**
     * Hàm private: Cung cấp ý nghĩa các hướng tốt cho mục đích đặt BÀN LÀM VIỆC.
     * Ưu tiên hàng đầu là Sinh Khí để thúc đẩy sự nghiệp.
     *
     * @param array $huongTotGoc Mảng các hướng tốt từ hàm tinhHuongHopTuoi
     * @return array
     */
    private static function getBangHuongBanLamViec(array $huongTotGoc): array
    {
        $yNghia = [
            'sinh_khi' => 'Giúp bạn tăng cường năng lượng, thu hút tài lộc, danh tiếng và thăng tiến trong sự nghiệp.',
            'thien_y' => 'Cải thiện sức khỏe để làm việc hiệu quả, được quý nhân (cấp trên, đồng nghiệp) giúp đỡ.',
            'phuoc_duc' => 'Củng cố các mối quan hệ với đồng nghiệp, đối tác, khách hàng, tạo môi trường làm việc hòa thuận.', // phuoc_duc là Diên Niên
            'phuc_vi' => 'Tăng cường sự tập trung, củng cố sức mạnh tinh thần, giúp công việc ổn định, vững chắc.'
        ];

        // Sắp xếp lại theo thứ tự ưu tiên cho công việc
        return [
            ['Huong' => $huongTotGoc['sinh_khi'], 'Loai' => 'Sinh Khí', 'Y_nghia' => $yNghia['sinh_khi'], 'Uu_tien' => 'Ưu tiên 1'],
            ['Huong' => $huongTotGoc['thien_y'], 'Loai' => 'Thiên Y', 'Y_nghia' => $yNghia['thien_y'], 'Uu_tien' => 'Ưu tiên 2'],
            ['Huong' => $huongTotGoc['phuoc_duc'], 'Loai' => 'Diên Niên (Phước Đức)', 'Y_nghia' => $yNghia['phuoc_duc'], 'Uu_tien' => 'Ưu tiên 3'],
            ['Huong' => $huongTotGoc['phuc_vi'], 'Loai' => 'Phục Vị', 'Y_nghia' => $yNghia['phuc_vi'], 'Uu_tien' => 'Ưu tiên 4'],
        ];
    }





    // --- PHẦN 1: VẬN KHÍ NGÀY & THÁNG ---

    /**
     * Phân tích vận khí giữa ngày và tháng.
     * @param string $canChiNgay Ví dụ: "Nhâm Thìn"
     * @param string $canChiThang Ví dụ: "Kỷ Mão"
     * @return array
     */
    public static function getVongKhiNgayThang(string $canChiNgay, string $canChiThang): array
    {
        $canNgay = self::getCan($canChiNgay);
        $chiNgay = self::getChi($canChiNgay);
        $canThang = self::getCan($canChiThang);
        $chiThang = self::getChi($canChiThang);

        // Lấy hành từ DataHelper
        $hanhCanNgay = DataHelper::$canToHanh[$canNgay] ?? 'Không rõ';
        $hanhCanThang = DataHelper::$canToHanh[$canThang] ?? 'Không rõ';
        $hanhChiNgay = DataHelper::$chiToHanh[$chiNgay] ?? 'Không rõ';
        $hanhChiThang = DataHelper::$chiToHanh[$chiThang] ?? 'Không rõ';

        // Tính toán quan hệ
        $canRelation = self::getNguHanhRelationship($hanhCanThang, $hanhCanNgay);
        $chiRelation = self::getNguHanhRelationship($hanhChiThang, $hanhChiNgay);

        $score = ($canRelation['score'] ?? 0) + ($chiRelation['score'] ?? 0);

        // Tạo chuỗi kết luận
        $ketLuan = KhiVanHelper::getKhiThangConclusion($score);


        return [
            'title' => "Vận khí ngày & tháng (khí tháng)",
            'header' => "Ngày {$canChiNgay} tháng {$canChiThang}",
            'phan_tich' => [
                "Can ngày {$canNgay} ({$hanhCanNgay}), can tháng {$canThang} ({$hanhCanThang}) → {$canRelation['description']} ({$canRelation['score']})",
                "Chi ngày {$chiNgay} ({$hanhChiNgay}), chi tháng {$chiThang} ({$hanhChiThang}) → {$chiRelation['description']} ({$chiRelation['score']})",
            ],
            'ket_luan' => "Vận khí ngày - tháng ({$score}) {$ketLuan}",
        ];
    }

    // --- PHẦN 2: CỤC KHÍ - HỢP XUNG ---

    /**
     * Phân tích cục khí Hợp-Xung của một ngày.
     * @param string $chiNgay Ví dụ: "Thìn"
     * @return array
     */
    public static function getCucKhiHopXung(string $chiNgay): array
    {
        // Chuẩn hóa chiNgay với chữ hoa đầu cho các mảng cần
        $chiNgayCapitalized = ucfirst(strtolower($chiNgay));
        $chiNgayLower = strtolower($chiNgay);

        // Sử dụng dữ liệu Hợp-Xung từ các mảng riêng lẻ trong DataHelper
        $tamHop = DataHelper::$TAM_HOP_GROUPS[$chiNgayLower] ?? [];
        $lucHop = DataHelper::$LUC_HOP[$chiNgayLower] ?? '';

        // Format tam hợp với chữ hoa đầu
        $tamHopFormatted = array_map('ucfirst', $tamHop);

        // Tạo text cho hợp
        $hopParts = [];
        if (!empty($tamHopFormatted)) {
            $hopParts[] = implode(' - ', $tamHopFormatted) . ' (Tam hợp)';
        }
        if (!empty($lucHop)) {
            $hopParts[] = ucfirst($lucHop) . ' (Lục hợp)';
        }

        $hopText = !empty($hopParts)
            ? "Ngày này <b>hợp</b> với các tuổi: " . implode(' và ', $hopParts)
            : "Ngày này không có tuổi hợp đặc biệt";

        // Xử lý các tuổi kỵ
        $kyArr = [];
        if (isset(DataHelper::$LUC_XUNG[$chiNgayCapitalized])) {
            $kyArr[] = ucfirst(DataHelper::$LUC_XUNG[$chiNgayCapitalized]) . " (xung)";
        }
        if (isset(DataHelper::$TUONG_HAI[$chiNgayCapitalized])) {
            $kyArr[] = ucfirst(DataHelper::$TUONG_HAI[$chiNgayCapitalized]) . " (hại)";
        }
        if (isset(DataHelper::$TUONG_PHA[$chiNgayCapitalized])) {
            $kyArr[] = ucfirst(DataHelper::$TUONG_PHA[$chiNgayCapitalized]) . " (phá)";
        }
        if (in_array($chiNgayCapitalized, DataHelper::$TU_HINH_CHIS)) {
            $kyArr[] = ucfirst($chiNgayCapitalized) . " (tự hình)";
        }

        $kyText = !empty($kyArr)
            ? "Ngày này <b>kỵ</b> với các tuổi: " . implode(', ', $kyArr)
            : "Ngày này không có tuổi kỵ đặc biệt";

        return [
            'title' => 'Cục khí - hợp xung',
            'hop' => $hopText,
            'ky' => $kyText,
        ];
    }

    // --- PHẦN 3: SO SÁNH NGÀY VỚI MỆNH TUỔI ---

    /**
     * So sánh chi tiết ngày với Mệnh của một người.
     * @param string $canChiNgay Ví dụ: "Canh Ngọ"
     * @param string $canChiTuoi Ví dụ: "Giáp Tý"
     * @return array
     */
    public static function soSanhNgayVoiTuoi(string $canChiNgay, string $canChiTuoi): array
    {
        // 1. Phân tích Thiên Can
        $canNgay = self::getCan($canChiNgay);
        $canTuoi = self::getCan($canChiTuoi);
        $hanhCanNgay = DataHelper::$canToHanh[$canNgay] ?? null;
        $hanhCanTuoi = DataHelper::$canToHanh[$canTuoi] ?? null;
        $canRelation = self::getNguHanhRelationship($hanhCanNgay, $hanhCanTuoi);

        // 2. Phân tích Địa Chi
        $chiNgay = self::getChi($canChiNgay);
        $chiTuoi = self::getChi($canChiTuoi);
        $chiRelationText = self::getChiChiRelationship($chiNgay, $chiTuoi);

        // 3. Phân tích Nạp Âm (Mệnh)
        $napAmNgayInfo = DataHelper::$napAmTable[$canChiNgay] ?? null;
        $napAmTuoiInfo = DataHelper::$napAmTable[$canChiTuoi] ?? null;
        $napAmRelation = self::getNguHanhRelationship($napAmNgayInfo['hanh'] ?? null, $napAmTuoiInfo['hanh'] ?? null);

        return [
            'title' => 'So sánh ngày với mệnh tuổi của bạn (năm_sinh) (trường hợp xem cá nhân hóa)',
            'phan_tich' => [
                "Thiên can ngày - thiên can tuổi: {$canRelation['description']}",
                "Địa chi ngày - địa chi tuổi: {$chiRelationText}",
                "Nạp âm ngày - nạp âm tuổi (tổng hợp): {$napAmRelation['description']}",
            ]
        ];
    }

    // --- CÁC HÀM HELPER NỘI BỘ ---

    public static function getCan(string $canChi): string
    {
        return explode(' ', $canChi)[0] ?? '';
    }
    public static function getChi(string $canChi): string
    {
        return explode(' ', $canChi)[1] ?? '';
    }

    public static function getNguHanhRelationship(?string $element1, ?string $element2): array
    {
        if (!$element1 || !$element2) {
            return ['description' => 'Không rõ', 'score' => 0];
        }

        $sinh = DataHelper::$SINH_RELATIONS;
        $khac = DataHelper::$KHAC_RELATIONS;

        if ($element1 === $element2) {
            return ['description' => "Đồng hành ({$element1})", 'score' => 1.0];
        }
        if (isset($sinh[$element1]) && $sinh[$element1] === $element2) {
            return ['description' => "{$element1} sinh {$element2} (Tốt)", 'score' => 2.0];
        }
        if (isset($sinh[$element2]) && $sinh[$element2] === $element1) {
            return ['description' => "{$element2} sinh {$element1} (Hao tổn)", 'score' => 0.0];
        }
        if (isset($khac[$element1]) && $khac[$element1] === $element2) {
            return ['description' => "{$element1} khắc {$element2} (Xấu)", 'score' => -2.0];
        }
        if (isset($khac[$element2]) && $khac[$element2] === $element1) {
            return ['description' => "{$element2} khắc {$element1} (Xấu nhẹ)", 'score' => -1.0];
        }

        return ['description' => 'Trung tính', 'score' => 0.0];
    }

    public static function getChiChiRelationship(string $chi1, string $chi2): string
    {
        $chi1Lower = strtolower($chi1);

        if ($chi1 === $chi2) {
            if (in_array($chi1, DataHelper::$TU_HINH_CHIS)) return "Tự Hình (Xấu)";
            return "Trùng (Bình thường)";
        }
        if ((DataHelper::$LUC_HOP[$chi1Lower] ?? '') === strtolower($chi2)) return "Lục Hợp (Rất tốt)";
        if (in_array(strtolower($chi2), DataHelper::$TAM_HOP_GROUPS[$chi1Lower] ?? [])) return "Tam Hợp (Tốt)";
        if ((DataHelper::$LUC_XUNG[$chi1] ?? '') === $chi2) return "Lục Xung (Rất xấu)";
        if ((DataHelper::$TUONG_HAI[$chi1] ?? '') === $chi2) return "Tương Hại (Xấu)";
        if ((DataHelper::$TUONG_PHA[$chi1] ?? '') === $chi2) return "Tương Phá (Xấu)";

        // Thêm logic cho bộ ba hình nếu cần
        if (in_array($chi1, DataHelper::$HINH_VO_AN_TRIPLE) && in_array($chi2, DataHelper::$HINH_VO_AN_TRIPLE)) return "Hình Vô Ân (Xấu)";

        return "Bình thường";
    }
    /**
     * HÀM ĐÃ VIẾT LẠI HOÀN TOÀN: Phân tích quan hệ giữa Can ngày và Can tuổi.
     * Xử lý chi tiết các trường hợp Tương sinh, Tương khắc, Tương hợp, và đặc biệt là Hợp Hóa (thật/giả).
     *
     * @param string $canChiNgay Ví dụ: "Canh Ngọ"
     * @param string $canChiTuoi Ví dụ: "Giáp Tý"
     * @return array Kết quả phân tích chi tiết.
     */
    public static function analyzeCanCanRelationship(string $canChiNgay, string $canChiTuoi): array
    {
        try {
            $canNgay = self::getCan($canChiNgay);
            $chiNgay = self::getChi($canChiNgay);
            $canTuoi = self::getCan($canChiTuoi);
            $chiTuoi = self::getChi($canChiTuoi);

            // Truy cập dữ liệu quan hệ Can-Can
            $relationBaseData = DataHelper::$canCanNewRelationships[$canNgay][$canTuoi] ?? null;

            if ($relationBaseData === null) {
                Log::error("FengShuiService: LỖI - Không tìm thấy dữ liệu Can-Can cho {$canNgay} (ngày) - {$canTuoi} (tuổi).");
                return [
                    'score' => 0.0,
                    'rating' => 'Lỗi dữ liệu',
                    'explanation' => "Can ngày là {$canNgay}, Can tuổi là {$canTuoi} → Quan hệ không xác định do thiếu dữ liệu cấu hình.",
                    'relation' => 'LỖI_DỮ_LIỆU_CAN_CAN',
                ];
            }

            // --- Xử lý logic Hợp Hóa ---
            // Kiểm tra xem có phải là trường hợp Hợp Hóa không
            if (str_starts_with($relationBaseData['relation'], 'Hợp Hóa')) {
                $hoaKhi = $relationBaseData['hoaKhi'] ?? null;
                $conditionString = $relationBaseData['condition'] ?? null;
                $fakeScore = $relationBaseData['fakeHợpScore'] ?? null;
                $fakeRating = $relationBaseData['fakeHợpRating'] ?? null;
                $fakeExplanation = $relationBaseData['fakeHợpExplanation'] ?? null;

                // Chỉ xử lý nếu có đủ dữ liệu Hợp Hóa
                if ($hoaKhi && $conditionString) {
                    // Tách các hành điều kiện từ chuỗi "Thủy hoặc Kim"
                    preg_match_all('/(\p{L}+)/u', strtolower($conditionString), $matches);
                    $conditionHanhList = $matches[1] ?? [];

                    $hanhChiNgay = strtolower(DataHelper::$chiToHanh[$chiNgay] ?? '');
                    $hanhChiTuoi = strtolower(DataHelper::$chiToHanh[$chiTuoi] ?? '');

                    $isTrueHoa = false;
                    // Kiểm tra xem Hành của Chi Ngày hoặc Chi Tuổi có nằm trong danh sách điều kiện không
                    if (!empty($hanhChiNgay) && in_array($hanhChiNgay, $conditionHanhList)) {
                        $isTrueHoa = true;
                    }
                    if (!$isTrueHoa && !empty($hanhChiTuoi) && in_array($hanhChiTuoi, $conditionHanhList)) {
                        $isTrueHoa = true;
                    }

                    if ($isTrueHoa) {
                        // Hóa Thật: Dữ liệu gốc đã là của hóa thật
                        return [
                            'score'       => (float)($relationBaseData['baseScore'] ?? 0.0),
                            'explanation' => $relationBaseData['explanation'] ?? 'Không có diễn giải.',
                            'fakeHợpExplanation' => $relationBaseData['fakeHợpExplanation'] ?? 'Không có diễn giải giả.',
                            'rating'      => $relationBaseData['rating'] ?? 'Không rõ đánh giá.',
                            'relation'    => $relationBaseData['relation'] ?? 'Hợp Hóa',
                            'canNgay'    => $canNgay ?? '',
                            'canTuoi'    => $canTuoi ?? '',
                        ];
                    } else {
                        // Hóa Giả
                        return [
                            'score'       => (float)($fakeScore ?? 0.5),
                            'explanation' => $fakeExplanation ?? 'Hợp hóa nhưng không đủ điều kiện.',
                            'fakeHợpExplanation' => $relationBaseData['fakeHợpExplanation'] ?? 'Không có diễn giải giả.',
                            'rating'      => $fakeRating ?? 'Hợp hóa giả',
                            'relation'    => 'Hợp Hóa Giả',
                            'canNgay'    => $canNgay ?? '',
                            'canTuoi'    => $canTuoi ?? '',
                        ];
                    }
                } else {
                    // Dữ liệu Hợp Hóa không đầy đủ, fallback về Bình Hòa
                    Log::warning("FengShuiService: Dữ liệu Hợp Hóa không đầy đủ cho {$canNgay} - {$canTuoi}. Coi như Bình Hòa.");
                    $relationBaseData = DataHelper::$canCanNewRelationships[$canNgay][$canNgay] ?? $relationBaseData;
                }
            }

            // --- Trả về kết quả cho các trường hợp không phải Hợp Hóa ---
            return [
                'score'       => (float)($relationBaseData['baseScore'] ?? 0.0),
                'explanation' => $relationBaseData['explanation'] ?? 'Không có diễn giải.',
                'rating'      => $relationBaseData['rating'] ?? 'Không rõ đánh giá.',
                'relation'    => $relationBaseData['relation'] ?? 'Không rõ',
                'canNgay'    => $canNgay ?? '',
                'canTuoi'    => $canTuoi ?? '',
            ];
        } catch (\Exception $e) {
            Log::error("Lỗi nghiêm trọng khi tính Can-Can: " . $e->getMessage());
            return [
                'score' => 0.0,
                'rating' => 'Lỗi hệ thống',
                'explanation' => 'Lỗi nghiêm trọng trong quá trình tính toán Can-Can.',
                'relation' => 'ERROR_CAN_CAN',
                'canNgay'    => $canNgay ?? '',
                'canTuoi'    => $canTuoi ?? '',
            ];
        }
    }

    /**
     * HÀM ĐÃ VIẾT LẠI: Phân tích quan hệ giữa Chi ngày và Chi tuổi.
     *
     * @param string $canChiNgay
     * @param string $canChiTuoi
     * @return array
     */
    public static function analyzeChiChiRelationship(string $canChiNgay, string $canChiTuoi): array
    {
        try {
            $chiNgay = self::getChi($canChiNgay);
            $chiTuoi = self::getChi($canChiTuoi);

            $relationKey = self::getChiChiRelationshipKey($chiNgay, $chiTuoi);

            $info = DataHelper::$chiChiAgeInfo[$relationKey] ?? null;

            if ($info === null) {
                Log::error("FengShuiService: LỖI - Không tìm thấy dữ liệu Chi-Chi cho key '{$relationKey}' trong DataHelper.");
                return [
                    'score' => 0.0,
                    'rating' => 'Lỗi cấu hình',
                    'explanation' => "Chi ngày là {$chiNgay}, Chi tuổi là {$chiTuoi} → Quan hệ không xác định (Lỗi dữ liệu).",
                    'relationKey' => 'LỖI_DỮ_LIỆU_CHI_CHI',
                    'chiNgay' => $chiNgay ?? 'Không xác định',
                    'chiTuoi' => $chiTuoi ?? 'Không xác định',
                ];
            }

            return [
                'score'       => (float)($info['score'] ?? 0.0),
                'rating'      => $info['rating'] ?? 'Không rõ',
                'explanation' => $info['explanation'] ?? 'Không có diễn giải.',
                'relationKey' => $relationKey,
                'chiNgay' => $chiNgay ?? 'Không xác định',
                'chiTuoi' => $chiTuoi ?? 'Không xác định',
            ];
        } catch (\Exception $e) {
            Log::error("Lỗi nghiêm trọng khi tính Chi-Chi: " . $e->getMessage());
            return [
                'score' => 0.0,
                'rating' => 'Lỗi hệ thống',
                'explanation' => 'Lỗi nghiêm trọng trong quá trình tính toán Chi-Chi.',
                'relationKey' => 'ERROR_CHI_CHI',
                'chiNgay' => $chiNgay ?? 'Không xác định',
                'chiTuoi' => $chiTuoi ?? 'Không xác định',
            ];
        }
    }

    /**
     * HÀM ĐÃ VIẾT LẠI: Phân tích quan hệ giữa Nạp âm ngày và Nạp âm tuổi.
     *
     * @param string $canChiNgay
     * @param string $canChiTuoi
     * @return array
     */
    public static function analyzeNapAmRelationship(string $canChiNgay, string $canChiTuoi): array
    {
        try {
            // dd($canChiNgay, $canChiTuoi);
            $dayNapAmData = DataHelper::$napAmTable[$canChiNgay] ?? ['napAm' => 'Không xác định', 'hanh' => 'Không rõ'];
            $birthNapAmData = DataHelper::$napAmTable[$canChiTuoi] ?? ['napAm' => 'Không xác định', 'hanh' => 'Không rõ'];

            $dayHanh = $dayNapAmData['hanh'];
            $birthHanh = $birthNapAmData['hanh'];

            $relationKey = 'Trung bình (không xung, không hợp)'; // Giá trị mặc định

            if ($dayHanh !== 'Không rõ' && $birthHanh !== 'Không rõ') {
                if ($dayHanh === $birthHanh) {
                    $relationKey = 'Đồng hành';
                } elseif ((DataHelper::$SINH_RELATIONS[$dayHanh] ?? null) === $birthHanh) {
                    $relationKey = 'Ngày sinh Tuổi';
                } elseif ((DataHelper::$SINH_RELATIONS[$birthHanh] ?? null) === $dayHanh) {
                    $relationKey = 'Tuổi sinh Ngày';
                } elseif ((DataHelper::$KHAC_RELATIONS[$dayHanh] ?? null) === $birthHanh) {
                    $relationKey = 'Ngày khắc Tuổi';
                } elseif ((DataHelper::$KHAC_RELATIONS[$birthHanh] ?? null) === $dayHanh) {
                    $relationKey = 'Tuổi khắc Ngày';
                }
            }

            $info = DataHelper::$napAmAgeInfo[$relationKey] ?? null;

            if ($info === null) {
                Log::error("FengShuiService: LỖI - Không tìm thấy dữ liệu Nạp Âm cho key '{$relationKey}' trong DataHelper.");
                return [
                    'score' => 0.0,
                    'rating' => 'Lỗi cấu hình',
                    'explanation' => "Quan hệ Nạp âm không xác định (Lỗi dữ liệu).",
                    'relationKey' => 'LỖI_DỮ_LIỆU_NAP_AM',
                    'canchiNgay' => $canChiNgay ?? 'Không xác định',
                    'canchiTuoi' => $canChiTuoi ?? 'Không xác định',
                    'napAmNgay' => $dayNapAmData ?? 'Không xác định',
                    'napAmTuoi' => $birthNapAmData ?? 'Không xác định',
                ];
            }

            return [
                'score'       => (float)($info['score'] ?? 0.0),
                'rating'      => $info['rating'] ?? 'Không rõ',
                'explanation' => $info['explanation'] ?? 'Không có diễn giải.',
                'relationKey' => $relationKey,
                'canchiNgay' => $canChiNgay ?? 'Không xác định',
                'canchiTuoi' => $canChiTuoi ?? 'Không xác định',
                'napAmNgay' => $dayNapAmData ?? 'Không xác định',
                'napAmTuoi' => $birthNapAmData ?? 'Không xác định',
            ];
        } catch (\Exception $e) {
            Log::error("Lỗi nghiêm trọng khi tính Nạp Âm: " . $e->getMessage());
            return [
                'score' => 0.0,
                'rating' => 'Lỗi hệ thống',
                'explanation' => 'Lỗi nghiêm trọng trong quá trình tính toán Nạp Âm.',
                'relationKey' => 'ERROR_NAP_AM',
                'canchiNgay' => $canChiNgay ?? 'Không xác định',
                'canchiTuoi' => $canChiTuoi ?? 'Không xác định',
                'napAmNgay' => $dayNapAmData ?? 'Không xác định',
                'napAmTuoi' => $birthNapAmData ?? 'Không xác định',
            ];
        }
    }

    /**
     * Helper: Xác định key quan hệ Chi-Chi để tra cứu.
     * (Giữ nguyên từ câu trả lời trước, không cần thay đổi)
     * @return string
     */
    public static function getChiChiRelationshipKey(string $chi1, string $chi2): string
    {
        if ($chi1 === $chi2) {
            return in_array($chi1, DataHelper::$TU_HINH_CHIS ?? []) ? "Tự hình" : "Trùng (Đồng Chi)";
        }
        $chi1Lower = strtolower($chi1);
        $chi2Lower = strtolower($chi2);
        if ((DataHelper::$LUC_XUNG[$chi1] ?? '') === $chi2) return "Lục xung";
        if ((DataHelper::$TUONG_HAI[$chi1] ?? '') === $chi2) return "Tương hại";
        if ((DataHelper::$TUONG_PHA[$chi1] ?? '') === $chi2) return "Tương phá";
        if ((DataHelper::$LUC_HOP[$chi1Lower] ?? '') === $chi2Lower) return "Lục hợp";
        if (in_array($chi2Lower, DataHelper::$TAM_HOP_GROUPS[$chi1Lower] ?? [])) return "Tam hợp";

        if (in_array($chi1, DataHelper::$HINH_VO_AN_TRIPLE ?? []) && in_array($chi2, DataHelper::$HINH_VO_AN_TRIPLE ?? [])) return "Tương hình";
        if (in_array($chi1, DataHelper::$HINH_Y_THE_TRIPLE ?? []) && in_array($chi2, DataHelper::$HINH_Y_THE_TRIPLE ?? [])) return "Tương hình";
        if ((DataHelper::$HINH_VO_LE_PAIR[$chi1] ?? '') === $chi2) return "Tương hình";

        return "Trung bình (không xung, không hợp)";
    }
    public static function analyzeNgayVoiTuoi(string $canChiNgay, string $canChiTuoi): array
    {
        $canResult = self::analyzeCanCanRelationship($canChiNgay, $canChiTuoi);
        $chiResult = self::analyzeChiChiRelationship($canChiNgay, $canChiTuoi);
        $napAmResult = self::analyzeNapAmRelationship($canChiNgay, $canChiTuoi);

        // Lấy thông tin chi tiết để xây dựng chuỗi mô tả
        $canNgay = self::getCan($canChiNgay);
        $canTuoi = self::getCan($canChiTuoi);
        $chiNgay = self::getChi($canChiNgay);
        $chiTuoi = self::getChi($canChiTuoi);

        $dayNapAmData = DataHelper::$napAmTable[$canChiNgay] ?? ['napAm' => 'Không xác định', 'hanh' => 'Không rõ'];
        $birthNapAmData = DataHelper::$napAmTable[$canChiTuoi] ?? ['napAm' => 'Không xác định', 'hanh' => 'Không rõ'];

        return [
            'title' => 'So sánh ngày với mệnh tuổi của bạn (năm_sinh) (trường hợp xem cá nhân hóa)',
            'phan_tich' => [
                'thien_can' => "Thiên can ngày - thiên can tuổi: Can ngày là {$canNgay}, Can tuổi là {$canTuoi} → {$canResult['relation']} ({$canResult['rating']}). {$canResult['explanation']}",
                'dia_chi'   => "Địa chi ngày - địa chi tuổi: Chi ngày là {$chiNgay}, Chi tuổi là {$chiTuoi} → {$chiResult['relationKey']} ({$chiResult['rating']}). {$chiResult['explanation']}",
                'nap_am'    => "Nạp âm ngày - nạp âm tuổi (tổng hợp): Ngày {$canChiNgay} ({$dayNapAmData['hanh']}), tuổi {$canChiTuoi} ({$birthNapAmData['hanh']}) → {$napAmResult['relationKey']} ({$napAmResult['rating']}). {$napAmResult['explanation']}",
            ],
            // Trả về dữ liệu chi tiết để có thể dùng trong view nếu cần
            'details' => [
                'can' => $canResult,
                'chi' => $chiResult,
                'nap_am' => $napAmResult,
            ]
        ];
    }
}
