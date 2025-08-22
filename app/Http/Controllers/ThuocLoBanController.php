<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThuocLoBanController extends Controller
{
    public function index(Request $request)
    {
        // Chúng ta không cần tính toán kết quả ở đây nữa
        // vì JS sẽ làm việc đó.
        // Nhưng chúng ta cần toàn bộ cấu trúc thước để JS vẽ.

        // Lấy toàn bộ dữ liệu cấu trúc từ helper/config
        // Giả sử bạn đang dùng helper có chứa dữ liệu
        // (Cách này tốt vì dữ liệu thước không thay đổi)
        $rulersData = $this->getRulerStructureWithDetails();

        return view('thuoc-lo-ban.interactive', [
            'rulersData' => $rulersData,
        ]);
    }

    /**
     * Một hàm riêng để lấy cấu trúc thước,
     * giúp controller gọn gàng hơn.
     */
    /**
     * Cung cấp cấu trúc dữ liệu thước Lỗ Ban chi tiết, bao gồm cả giải nghĩa.
     */
    private function getRulerStructureWithDetails(): array
    {
        // Dữ liệu này có thể được tách ra một file config hoặc helper riêng nếu muốn.
        return [
            'thong_thuy' => [
                'name' => 'Thước Lỗ Ban 52.2cm: Khoảng thông thủy (cửa, cửa sổ...)',
                'title_short' => 'Thước Lỗ Ban 52.2cm',
                'description_title' => 'Khoảng không thông thủy (cửa, cửa sổ...)',
                'total_length' => 52.2,
                'khoang' => [
                    ['name' => 'Quý nhân', 'type' => 'good', 'cung' => [
                        ['name' => 'Quyền lộc', 'desc' => 'May mắn về tài lộc, chức vụ, gia đình thịnh vượng.'],
                        ['name' => 'Trung tín', 'desc' => 'Gia chủ trung thực, được mọi người tín nhiệm.'],
                        ['name' => 'Tác quan', 'desc' => 'Có đường công danh, sự nghiệp rộng mở.'],
                        ['name' => 'Phát đạt', 'desc' => 'Làm ăn phát đạt, kinh doanh thuận lợi.'],
                        ['name' => 'Thông minh', 'desc' => 'Con cái thông minh, học giỏi, thành tài.'],
                    ]],
                    ['name' => 'Hiểm họa', 'type' => 'bad', 'cung' => [
                        ['name' => 'Án thành', 'desc' => 'Dễ vướng vào kiện tụng, tranh chấp.'],
                        ['name' => 'Hỗn nhân', 'desc' => 'Gia đình bất hòa, tình cảm vợ chồng rạn nứt.'],
                        ['name' => 'Thất hiếu', 'desc' => 'Con cái ngỗ nghịch, không vâng lời cha mẹ.'],
                        ['name' => 'Tai họa', 'desc' => 'Gặp phải những tai ương bất ngờ, khó lường.'],
                        ['name' => 'Trường bệnh', 'desc' => 'Sức khỏe suy yếu, bệnh tật kéo dài.'],
                    ]],
                    ['name' => 'Thiên tai', 'type' => 'bad', 'cung' => [
                        ['name' => 'Hoàn tử', 'desc' => 'Nguy cơ mất người, tuyệt tự.'],
                        ['name' => 'Quan tài', 'desc' => 'Gặp chuyện xui xẻo, tang tóc.'],
                        ['name' => 'Thân tàn', 'desc' => 'Bản thân có thể gặp tai nạn, thương tật.'],
                        ['name' => 'Thất tài', 'desc' => 'Hao tốn tiền của, tài sản tiêu tán.'],
                        ['name' => 'Hệ quả', 'desc' => 'Gánh chịu hậu quả xấu từ những việc đã làm.'],
                    ]],
                    ['name' => 'Thiên tài', 'type' => 'good', 'cung' => [
                        ['name' => 'Thi thơ', 'desc' => 'Gia chủ có tài năng về nghệ thuật, văn chương.'],
                        ['name' => 'Văn học', 'desc' => 'Đường học vấn, thi cử thuận lợi.'],
                        ['name' => 'Thanh quý', 'desc' => 'Được mọi người kính trọng, có danh tiếng tốt.'],
                        ['name' => 'Tác lộc', 'desc' => 'Được hưởng phúc lộc trời ban, may mắn về tiền bạc.'],
                        ['name' => 'Thiên lộc', 'desc' => 'Tài lộc bất ngờ, có của ăn của để.'],
                    ]],
                    ['name' => 'Nhân lộc', 'type' => 'good', 'cung' => [
                        ['name' => 'Trí tồn', 'desc' => 'Gia chủ luôn gặp sung túc, phúc lộc, nghề nghiệp luôn pháy triển, năng tài đắc lợi, con cái thông minh, hiếu thảo'],
                        ['name' => 'Phú quý',  'desc' => 'Khoảng này chủ nhà luôn gặp sung túc, phúc lộc, nghề nghiệp luôn pháy triển, năng tài đắc lợi, con cái thông minh, hiếu thảo'],
                        ['name' => 'Tiên bửu', 'desc' => 'Tại khoảng này chủ nhà luôn gặp sung túc, phúc lộc, nghề nghiệp luôn phát triển, năng tài đắc lợi, con cái thông minh, hiếu thảo'],
                        ['name' => 'Thập thiện', 'desc' => 'Tại khoảng này chủ nhà luôn gặp sung túc, phúc lộc, nghề nghiệp luôn phát triển, năng tài đắc lợi, con cái thông minh, hiếu thảo'],
                        ['name' => 'Văn chương', 'desc' => 'Tại khoảng này chủ nhà luôn gặp sung túc, phúc lộc, nghề nghiệp luôn phát triển, năng tài đắc lợi, con cái thông minh, hiếu thảo'],
                    ]],
                    ['name' => 'Cô bộc', 'type' => 'bad', 'cung' => [
                        ['name' => 'Bạc Nghịch', 'desc' => 'Khoảng này gia chủ hao người, hao của, biệt ly, con cái ngỗ nghịch, tửu sắc vô độ đến chết'],
                        ['name' => 'Vô Vọng',  'desc' => 'Khoảng này gia chủ hao người, hao của, biệt ly, con cái ngỗ nghịch, tửu sắc vô độ đến chết'],
                        ['name' => 'Ly Tán', 'desc' => 'Khoảng này gia chủ hao người, hao của, biệt ly, con cái ngỗ nghịch, tửu sắc vô độ đến chết'],
                        ['name' => 'Tửu Thục', 'desc' => 'Khoảng này gia chủ hao người, hao của, biệt ly, con cái ngỗ nghịch, tửu sắc vô độ đến chết'],
                        ['name' => 'Dâm Dục', 'desc' => 'Khoảng này gia chủ hao người, hao của, biệt ly, con cái ngỗ nghịch, tửu sắc vô độ đến chết'],
                    ]],
                    ['name' => 'Thiên tặc', 'type' => 'bad', 'cung' => [
                        ['name' => 'Phong Bệnh', 'desc' => 'Gặp khoảng THIÊN TẶC phải coi chừng bệnh đến bất ngờ, hay bị tai bay vạ gió, kiện tụng, tù ngục, chết chóc'],
                        ['name' => 'Chiêu Ôn',  'desc' => 'Gặp khoảng THIÊN TẶC phải coi chừng bệnh đến bất ngờ, hay bị tai bay vạ gió, kiện tụng, tù ngục, chết chóc'],
                        ['name' => 'Ồn Tài', 'desc' => 'Gặp khoảng THIÊN TẶC phải coi chừng bệnh đến bất ngờ, hay bị tai bay vạ gió, kiện tụng, tù ngục, chết chóc'],
                        ['name' => 'Ngục Tù', 'desc' => 'Gặp khoảng THIÊN TẶC phải coi chừng bệnh đến bất ngờ, hay bị tai bay vạ gió, kiện tụng, tù ngục, chết chóc'],
                        ['name' => 'Quang Tài', 'desc' => 'Gặp khoảng THIÊN TẶC phải coi chừng bệnh đến bất ngờ, hay bị tai bay vạ gió, kiện tụng, tù ngục, chết chóc'],
                    ]],
                    ['name' => 'Tể tướng', 'type' => 'bad', 'cung' => [
                        ['name' => 'Đại Tài', 'desc' => 'Khoảng TỂ TƯỚNG tạo cho gia chủ hanh thông mọi mặt, con cái tấn tài danh, sinh con quý tử, chủ nhà luôn may mắn bất ngờ'],
                        ['name' => 'Thi Thơ',  'desc' => 'Khoảng TỂ TƯỚNG tạo cho gia chủ hanh thông mọi mặt, con cái tấn tài danh, sinh con quý tử, chủ nhà luôn may mắn bất ngờ'],
                        ['name' => 'Hoạch Tài', 'desc' => 'Khoảng TỂ TƯỚNG tạo cho gia chủ hanh thông mọi mặt, con cái tấn tài danh, sinh con quý tử, chủ nhà luôn may mắn bất ngờ'],
                        ['name' => 'Hiểu Tử', 'desc' => 'Khoảng TỂ TƯỚNG tạo cho gia chủ hanh thông mọi mặt, con cái tấn tài danh, sinh con quý tử, chủ nhà luôn may mắn bất ngờ'],
                        ['name' => 'Quý Nhân', 'desc' => 'Khoảng TỂ TƯỚNG tạo cho gia chủ hanh thông mọi mặt, con cái tấn tài danh, sinh con quý tử, chủ nhà luôn may mắn bất ngờ'],
                    ]]

                ]

            ],
            'duong_trach' => [
                'name' => 'Thước Lỗ Ban 42.9cm (Dương trạch): Khối xây dựng (bếp, bệ, bậc...)',
                'title_short' => 'Thước Lỗ Ban 42.9cm (Dương trạch)',
                'description_title' => 'Khối xây dựng (bếp, bệ, bậc...)',
                'total_length' => 42.9,
                'khoang' => [
                    ['name' => 'Tài', 'type' => 'good', 'cung' => [
                        ['name' => 'Tài đức', 'desc' => 'Có tài và có đức, được phúc lộc.'],
                        ['name' => 'Bảo khố', 'desc' => 'Có kho báu, làm ăn tích lũy được nhiều của cải.'],
                        ['name' => 'Lục hợp', 'desc' => 'Gặp nhiều may mắn, quan hệ thuận hòa.'],
                        ['name' => 'Nghênh phúc', 'desc' => 'Đón nhận phúc lộc, những điều tốt lành.'],
                    ]],
                    ['name' => 'Bệnh', 'type' => 'bad', 'cung' => [
                        ['name' => 'Thoát tài', 'desc' => 'Mất mát tiền của, không giữ được tài sản.'],
                        ['name' => 'Công sự', 'desc' => 'Dễ gặp rắc rối liên quan đến pháp luật, kiện tụng.'],
                        ['name' => 'Lao chấp', 'desc' => 'Vướng vào vòng lao lý, tù tội.'],
                        ['name' => 'Cô quả', 'desc' => 'Cuộc sống cô đơn, lẻ loi.'],
                    ]],
                    ['name' => 'Ly', 'type' => 'bad', 'cung' => [
                        ['name' => 'Trường bệnh', 'desc' => 'Bệnh tật triền miên, sức khỏe kém.'],
                        ['name' => 'Kiếp tài', 'desc' => 'Bị cướp đoạt tài sản, tiền bạc.'],
                        ['name' => 'Quan quỷ', 'desc' => 'Gặp chuyện không may liên quan đến chính quyền.'],
                        ['name' => 'Thất thoát', 'desc' => 'Mất mát, thất lạc tài sản, đồ đạc.'],
                    ]],
                    ['name' => 'Nghĩa', 'type' => 'good', 'cung' => [
                        ['name' => 'Thêm đinh', 'desc' => 'Gia đình có thêm con trai, người nối dõi.'],
                        ['name' => 'Ích lợi', 'desc' => 'Làm việc gì cũng có lợi, thu được kết quả tốt.'],
                        ['name' => 'Quý tử', 'desc' => 'Sinh được con trai quý, thông minh, hiếu thảo.'],
                        ['name' => 'Đại cát', 'desc' => 'Rất may mắn, mọi sự hanh thông.'],
                    ]],
                    ['name' => 'Quan', 'type' => 'good', 'cung' => [
                        ['name' => 'Thuận khoa', 'desc' => 'Thi cử, học hành đỗ đạt, con cái thành danh, sự nghiệp hanh thông.'],
                        ['name' => 'Hoạch tài', 'desc' => 'Tài lộc đến bất ngờ, dễ trúng thưởng, làm ăn phát đạt.'],
                        ['name' => 'Tấn đức', 'desc' => 'Gieo nhân lành gặt quả tốt, tích đức cho đời, được quý nhân phù trợ.'],
                        ['name' => 'Phú quý', 'desc' => 'Gia đình thịnh vượng, cuộc sống sung túc, con cháu đủ đầy, phát triển.'],

                    ]],
                    ['name' => 'Kiếp', 'type' => 'bad', 'cung' => [
                        ['name' => 'Tử biệt', 'desc' => 'Sinh ly tử biệt, tang tóc, mất mát người thân.'],
                        ['name' => 'Khoái khẩu', 'desc' => 'Dễ gặp khẩu thiệt, thị phi, tranh cãi, kiện tụng không đáng có.'],
                        ['name' => 'Ly hương', 'desc' => 'Phải rời xa quê hương, cuộc sống tha phương, không ổn định.'],
                        ['name' => 'Tấn tài', 'desc' => 'Tưởng được tài lộc nhưng là họa ngầm, dễ mất trắng hoặc bị lừa gạt.'],

                    ]],
                    ['name' => 'Hại', 'type' => 'bad', 'cung' => [
                        ['name' => 'Tai chi', 'desc' => 'Mang đến điều xui xẻo, hao tài.'],
                        ['name' => 'Tử Tuyệt', 'desc' => 'Biểu tượng cho sự kết thúc, xấu cho mọi việc.'],
                        ['name' => 'Bệnh Lâm', 'desc' => 'Dễ sinh bệnh tật, đau ốm.'],
                        ['name' => 'Khẩu Thiệt', 'desc' => 'Gây tranh cãi, thị phi, khẩu thiệt.'],
                    ]],
                    ['name' => 'Bản', 'type' => 'good', 'cung' => [
                        ['name' => 'Tai chi', 'desc' => 'Tượng trưng cho sự cân bằng, cát lợi.'],
                        ['name' => 'Đăng Khoa', 'desc' => 'Tốt cho học hành, thi cử, danh vọng.'],
                        ['name' => 'Tiến Bảo', 'desc' => 'Mang lại tài lộc, của cải, lợi ích.'],
                        ['name' => 'Hưng Vượng', 'desc' => 'Mang lại sự thịnh vượng, phát triển.'],
                    ]],
                ]
            ],
            'am_trach' => [
                'name' => 'Thước Lỗ Ban 38.8cm (Âm phần): Đồ nội thất (bàn thờ, tủ...)',
                'title_short' => 'Thước Lỗ Ban 38.8cm (Âm phần)',
                'description_title' => 'Đồ nội thất (bàn thờ, tủ...)',
                'total_length' => 38.8,
                'khoang' => [
                    ['name' => 'Đinh', 'type' => 'good', 'cung' => [
                        ['name' => 'Phúc Tinh', 'desc' => 'Sao phúc chiếu, mang lại may mắn, bình an.'],
                        ['name' => 'Cập đệ', 'desc' => 'Thi cử đỗ đạt, công danh thăng tiến.'], // Cập nhật tên cung
                        ['name' => 'Tài Vượng', 'desc' => 'Tài lộc dồi dào, tiền bạc thịnh vượng.'],
                        ['name' => 'Đăng Khoa', 'desc' => 'Đỗ đạt cao, có tên trên bảng vàng.'],
                    ]],
                    ['name' => 'Hại', 'type' => 'bad', 'cung' => [
                        ['name' => 'Khẩu thiệt', 'desc' => 'Gặp chuyện thị phi, tai tiếng, tranh cãi.'],
                        ['name' => 'Lâm bệnh', 'desc' => 'Mắc bệnh tật, sức khỏe suy yếu.'],
                        ['name' => 'Tử tuyệt', 'desc' => 'Đoạn tuyệt đường con cái, không có người nối dõi.'],
                        ['name' => 'Tai chí', 'desc' => 'Tai họa bất ngờ ập đến.'],
                    ]],
                    ['name' => 'Vượng', 'type' => 'good', 'cung' => [
                        ['name' => 'Thiên đức', 'desc' => 'Được trời đất che chở, có đức độ.'],
                        ['name' => 'Hỷ sự', 'desc' => 'Trong nhà có chuyện vui, hỷ tín.'],
                        ['name' => 'Tiến bảo', 'desc' => 'Có của cải, tài lộc đến nhà.'],
                        ['name' => 'Nạp phúc', 'desc' => 'Đón nhận phúc đức, may mắn.'],
                    ]],
                    ['name' => 'Khổ', 'type' => 'bad', 'cung' => [
                        ['name' => 'Thất thoát', 'desc' => 'Mất mát tiền bạc, tài sản tiêu tan, hao hụt không rõ lý do.'],
                        ['name' => 'Quan quỷ', 'desc' => 'Gặp chuyện kiện tụng, pháp luật, rắc rối với chính quyền hoặc tiểu nhân hãm hại.'],
                        ['name' => 'Kiếp tài', 'desc' => 'Tiền của bị chiếm đoạt, thất bại trong đầu tư, bị lừa đảo.'],
                        ['name' => 'Vô tự', 'desc' => 'Không có con nối dõi, gia đình hiếm muộn hoặc con cái không gần gũi.'],
                    ]],
                    ['name' => 'Nghĩa', 'type' => 'good', 'cung' => [
                        ['name' => 'Đại cát', 'desc' => 'Cát lành lớn, vạn sự hanh thông, thuận lợi đủ đường.'],
                        ['name' => 'Tài vượng', 'desc' => 'Tài chính thịnh vượng, công việc suôn sẻ.'],
                        ['name' => 'Ích lợi', 'desc' => 'Gặt hái được nhiều thành quả, có lợi về mọi mặt.'],
                        ['name' => 'Thiên khổ', 'desc' => 'Vượt qua gian nan để thành công, hưởng phúc về sau.'],
                    ]],
                    ['name' => 'Quan', 'type' => 'good', 'cung' => [
                        ['name' => 'Phú quý', 'desc' => 'Giàu sang, thịnh vượng, có danh vọng và địa vị.'],
                        ['name' => 'Tiến bảo', 'desc' => 'Tài sản tăng lên, có của cải tích lũy.'],
                        ['name' => 'Hoạch tài', 'desc' => 'Bất ngờ gặp may mắn về tiền bạc, tài chính đột biến.'],
                        ['name' => 'Thuận khoa', 'desc' => 'Học hành, thi cử thuận lợi, đỗ đạt cao.'],
                    ]],
                    ['name' => 'Tử', 'type' => 'bad', 'cung' => [
                        ['name' => 'Ly hương', 'desc' => 'Phải xa quê, xa nhà, cuộc sống bấp bênh.'],
                        ['name' => 'Tử biệt', 'desc' => 'Chia ly, mất mát người thân yêu.'],
                        ['name' => 'Thoát đinh', 'desc' => 'Mất người trong gia đình, dòng họ suy yếu.'],
                        ['name' => 'Thất tài', 'desc' => 'Tiền bạc tiêu tan, thất thoát không kiểm soát.'],

                    ]],
                    ['name' => 'Hưng', 'type' => 'good', 'cung' => [
                        ['name' => 'Đông khoa', 'desc' => 'Thi cử đỗ đạt, thành công từ con đường học vấn.'],
                        ['name' => 'Quý tử', 'desc' => 'Sinh con quý, thông minh, mang lại phúc đức cho gia đình.'],
                        ['name' => 'Thêm đinh', 'desc' => 'Gia đình có thêm con trai, đông con cháu.'],
                        ['name' => 'Hưng vượng', 'desc' => 'Gia đạo thịnh vượng, phát đạt toàn diện.'],
                    ]],
                    ['name' => 'Thất', 'type' => 'bad', 'cung' => [
                        ['name' => 'Cô quả', 'desc' => 'Cuộc sống cô đơn, lẻ loi, không người thân thích.'],
                        ['name' => 'Lao chấp', 'desc' => 'Dễ vướng vào pháp luật, tù tội, cản trở sự nghiệp.'],
                        ['name' => 'Công sự', 'desc' => 'Mâu thuẫn trong công việc, bị chơi xấu.'],
                        ['name' => 'Thoát tài', 'desc' => 'Mất tiền của do sơ suất hoặc bị lừa gạt.'],
                    ]],
                    ['name' => 'Tài', 'type' => 'good', 'cung' => [
                        ['name' => 'Nghênh phúc', 'desc' => 'Đón nhận phúc khí, may mắn bất ngờ đến.'],
                        ['name' => 'Lục hợp', 'desc' => 'Gặp quý nhân giúp đỡ, thuận lợi trong mọi việc.'],
                        ['name' => 'Tiến bảo', 'desc' => 'Tài sản gia tăng, phúc khí dồi dào.'],
                        ['name' => 'Tài đức', 'desc' => 'Vừa có tài năng vừa có đức độ, được trọng dụng.'],
                    ]],
                ]
            ]
        ];
    }
}
