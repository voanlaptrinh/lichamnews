@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-date-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Về chúng tôi<i class="bi bi-chevron-right"></i> <span>Điều khoản</span>
        </h6>
        <h1 class="content-title-home-lich">Điều Khoản Dịch Vụ </h1>
        <div class="text-box-tong-quan mt-3">
            <p>Cảm ơn bạn đã truy cập và sử dụng <b>Phonglich.com</b> – website cung cấp thông tin về <b>Lịch Âm Dương, Lịch
                    Vạn Niên,
                    xem ngày tốt xấu, tử vi, phong thủy và các tiện ích văn hóa truyền thống</b>.</p>
            <p>Khi truy cập và sử dụng dịch vụ của chúng tôi, bạn được xem như đã đọc, hiểu và đồng ý tuân thủ các <b>Điều
                    khoản dịch vụ</b> sau đây. Nếu bạn không đồng ý với bất kỳ nội dung nào, vui lòng ngừng sử dụng website.
            </p>
            <h5 class="title-tong-quan-h5"><b>1. Phạm vi cung cấp dịch vụ
                </b>
            </h5>
            <p>Phonglich.com cung cấp các thông tin và tiện ích sau:</p>
            <ul>
                <li>Tra cứu <b>Lịch Âm – Dương</b>, Lịch Vạn Niên trực tuyến.</li>
                <li>Xem ngày tốt xấu, ngày hoàng đạo – hắc đạo, tiết khí.</li>
                <li>Công cụ đổi ngày âm – dương.</li>
                <li>Tra cứu tử vi, phong thủy, hợp tuổi, hướng hợp mệnh.</li>
                <li>Thông tin sự kiện, ngày lễ, ngày kỷ niệm.</li>
                <li>Các công cụ về tử vi và phong thủy khác</li>
            </ul>
            <p>Dữ liệu và nội dung trên Phonglich.com nhằm mục đích <b>tham khảo, giải trí và tra cứu văn hóa truyền
                    thống</b>,
                không thay thế cho tư vấn chuyên môn (pháp luật, tài chính, y tế…).</p>
            <h5 class="title-tong-quan-h5">
                <b>2. Quyền và trách nhiệm của người dùng</b>
            </h5>
            <ul>
                <li>Người dùng được quyền truy cập và sử dụng các dịch vụ miễn phí trên website.</li>
                <li>Người dùng cam kết không thực hiện các hành vi:</li>
                <ul>
                    <li>Phát tán, sao chép, chỉnh sửa hoặc sử dụng nội dung trên website cho mục đích thương mại khi chưa
                        được cho phép.</li>
                    <li>Lợi dụng website để đăng tải hoặc truyền bá thông tin trái pháp luật, sai lệch, hoặc gây hại cho
                        cộng đồng.</li>
                    <li>Can thiệp trái phép vào hệ thống, gây ảnh hưởng đến hoạt động của website.
                    </li>
                </ul>
                <li>Người dùng tự chịu trách nhiệm với mọi quyết định cá nhân dựa trên thông tin tham khảo tại
                    Phonglich.com.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>3. Quyền và trách nhiệm của Phonglich.com</b>
            </h5>
            <ul>
                <li>Chúng tôi nỗ lực cung cấp thông tin <b>chính xác, đầy đủ và cập nhật</b>, tuy nhiên không đảm bảo tuyệt
                    đối về độ chính xác trong mọi trường hợp.</li>
                <li>Chúng tôi có quyền thay đổi, tạm ngừng hoặc chấm dứt một phần hay toàn bộ dịch vụ mà không cần thông báo
                    trước.</li>
                <li>Chúng tôi không chịu trách nhiệm đối với bất kỳ thiệt hại trực tiếp, gián tiếp hoặc hậu quả nào phát
                    sinh từ việc bạn sử dụng thông tin trên website.</li>
                <li>Chúng tôi có quyền chỉnh sửa, cập nhật <b>Điều khoản dịch vụ</b> khi cần thiết. Phiên bản cập nhật sẽ có
                    hiệu lực ngay khi được đăng tải.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>4. Quyền sở hữu trí tuệ</b>
            </h5>
            <ul>
                <li>Toàn bộ nội dung, giao diện, dữ liệu, hình ảnh, biểu tượng, thiết kế trên Phonglich.com thuộc quyền sở
                    hữu của chúng tôi.</li>
                <li>Mọi hành vi sao chép, sử dụng lại cho mục đích thương mại hoặc phát tán dưới bất kỳ hình thức nào đều
                    cần có sự đồng ý bằng văn bản.
                </li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>5. Bảo mật và quyền riêng tư</b>
            </h5>
            <ul>
                <li>Phonglich.com cam kết tôn trọng và bảo mật thông tin cá nhân của người dùng.</li>
                <li>Chúng tôi không thu thập thông tin cá nhân trừ khi người dùng chủ động cung cấp (ví dụ: khi liên hệ qua
                    email).</li>
                <li>Để biết thêm chi tiết, vui lòng tham khảo <b>Chính sách bảo mật</b> (sẽ được đăng tải riêng).</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>6. Miễn trừ trách nhiệm</b>
            </h5>
            <ul>
                <li>Nội dung trên website chỉ mang tính <b>tham khảo và giải trí</b>. Người dùng nên cân nhắc kỹ trước khi
                    đưa ra quyết định quan trọng dựa trên thông tin tại đây.</li>
                <li>Phonglich.com không chịu trách nhiệm cho mọi quyết định cá nhân, tổn thất hay thiệt hại phát sinh từ
                    việc sử dụng thông tin trên website.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>7. Liên hệ</b>
            </h5>
            <p>Nếu bạn có bất kỳ câu hỏi, góp ý hoặc phản hồi nào về <b>Điều khoản dịch vụ</b>, vui lòng liên hệ với chúng
                tôi qua:</p>
            <p>📧 <b>Email</b>: <a href="mailto:phonglich.com@gmail.com">phonglich.com@gmail.com</a></p>
            <p>Chúng tôi luôn sẵn sàng lắng nghe để cải thiện dịch vụ tốt hơn cho cộng đồng người dùng.</p>
        </div>

    </div>
@endsection
