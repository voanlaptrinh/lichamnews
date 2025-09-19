@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-date-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Về chúng tôi<i class="bi bi-chevron-right"></i> <span>Chính sách</span>
        </h6>
        <h1 class="content-title-home-lich">Chính sách bảo mật</h1>
        <div class="text-box-tong-quan mt-3">
            <p>Phonglich.com cam kết tôn trọng và bảo vệ quyền riêng tư của người dùng khi truy cập và sử dụng dịch vụ của
                chúng tôi. Chính sách này giải thích cách chúng tôi thu thập, sử dụng và bảo vệ thông tin cá nhân.</p>
            <h5 class="title-tong-quan-h5">
                <b>1. Thông tin chúng tôi thu thập</b>
            </h5>
            <p>Khi sử dụng website, bạn có thể cung cấp cho chúng tôi một số thông tin cá nhân, bao gồm nhưng không giới
                hạn:</p>
            <ul>
                <li>Địa chỉ email (khi liên hệ với chúng tôi).</li>
                <li>Thông tin cơ bản bạn gửi trong quá trình góp ý hoặc phản hồi.</li>
            </ul>
            <p>Ngoài ra, website có thể thu thập dữ liệu không định danh (không liên quan đến cá nhân cụ thể) như:</p>
            <ul>
                <li>Loại trình duyệt, hệ điều hành, thiết bị truy cập.</li>
                <li>Địa chỉ IP, thời gian truy cập, các trang bạn đã xem.</li>
                <li>Cookies hoặc công nghệ tương tự để cải thiện trải nghiệm người dùng.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>2. Mục đích sử dụng thông tin</b>
            </h5>
            <p>Thông tin thu thập được sử dụng nhằm:</p>
            <ul>
                <li>Cung cấp, duy trì và cải thiện dịch vụ.</li>
                <li>Hỗ trợ phản hồi các câu hỏi, góp ý từ người dùng.</li>
                <li>Phân tích hành vi người dùng để tối ưu nội dung và giao diện.</li>
                <li>Gửi thông tin liên quan đến dịch vụ (nếu bạn đồng ý nhận).</li>
            </ul>
            <p>Chúng tôi <b>không bán, trao đổi hay cho thuê</b> thông tin cá nhân của bạn cho bên thứ ba.</p>
            <h5 class="title-tong-quan-h5">
                <b>3. Bảo mật thông tin</b>
            </h5>
            <ul>
                <li>Chúng tôi áp dụng các biện pháp kỹ thuật và tổ chức hợp lý để bảo vệ thông tin khỏi việc truy cập, sử
                    dụng hoặc tiết lộ trái phép.</li>
                <li>Tuy nhiên, không có phương thức truyền tải dữ liệu nào qua Internet là hoàn toàn an toàn. Do đó, chúng
                    tôi không thể đảm bảo tuyệt đối về tính bảo mật, và bạn đồng ý tự chịu rủi ro khi chia sẻ thông tin qua
                    Internet.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>4. Chia sẻ thông tin với bên thứ ba</b>
            </h5>
            <p>Chúng tôi chỉ chia sẻ thông tin cá nhân trong các trường hợp:</p>
            <ul>
                <li>Có sự đồng ý rõ ràng từ bạn.</li>
                <li>Tuân thủ yêu cầu pháp luật, cơ quan nhà nước có thẩm quyền.</li>
                <li>Bảo vệ quyền lợi hợp pháp của Phonglich.com khi có tranh chấp.</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>5. Quyền của người dùng</b>
            </h5>
            <p>Bạn có quyền:</p>
            <ul>
                <li>Yêu cầu truy cập, chỉnh sửa hoặc xóa thông tin cá nhân mà bạn đã cung cấp.</li>
                <li>Từ chối việc nhận email thông tin từ chúng tôi bất kỳ lúc nào.</li>
                <li>Tắt cookies trong trình duyệt nếu không muốn thu thập dữ liệu qua công nghệ này (lưu ý: điều này có thể
                    ảnh hưởng đến trải nghiệm sử dụng website).</li>
            </ul>
            <h5 class="title-tong-quan-h5">
                <b>6. Liên kết bên ngoài</b>
            </h5>
            <p>Phonglich.com có thể chứa liên kết đến website hoặc dịch vụ của bên thứ ba. Chúng tôi không chịu trách nhiệm
                về nội dung hoặc chính sách bảo mật của các website bên ngoài này. Bạn nên tham khảo chính sách riêng của
                từng trang web đó.</p>
            <h5 class="title-tong-quan-h5">
                <b>7. Thay đổi chính sách</b>
            </h5>
            <p>Chúng tôi có thể cập nhật Chính sách bảo mật theo thời gian. Mọi thay đổi sẽ được đăng tải trên trang này và
                có hiệu lực ngay khi công bố.</p>

            <h5 class="title-tong-quan-h5">
                <b>8. Liên hệ</b>
            </h5>
            <p>Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào về <b>Chính sách bảo mật</b>, vui lòng liên hệ qua:</p>
            <p>📧 <b>Email</b>: <a href="mailto:phonglich.com@gmail.com">phonglich.com@gmail.com</a></p>
            <p>Việc bạn tiếp tục sử dụng dịch vụ của Phonglich.com đồng nghĩa với việc bạn đã đọc, hiểu và đồng ý với Chính
                sách bảo mật này.</p>
        </div>

    </div>
@endsection
