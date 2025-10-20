@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a href="{{ route('horoscope.index') }}"  style="color: #2254AB; text-decoration: underline;">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Bạch Dương</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu cung Bạch Dương</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <h4 class="title-tong-quan-h4">Cung Bạch Dương là gì?</h4>
                            <p class="mb-0">Cung Bạch Dương (Aries) là cung hoàng đạo đầu tiên trong 12 cung, đại diện cho
                                sự khởi
                                đầu, năng
                                lượng và lòng dũng cảm. <br>
                                Bạch Dương sinh trong khoảng thời gian từ 21/3 đến 19/4, mang biểu tượng là con cừu đực
                                (Ram) –
                                tượng trưng cho sức mạnh tiên phong, ý chí kiên định và tinh thần không ngại thử thách.
                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Bạch Dương thuộc nhóm Lửa (Fire) cùng với Sư Tử và Nhân Mã,
                                mang
                                đến nguồn năng lượng mạnh mẽ, đam mê và nhiệt huyết.
                                Hành tinh chủ quản của cung này là Sao Hỏa (Mars) – hành tinh của hành động, chiến đấu và
                                khát vọng
                                chinh phục.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</h4>
                            <ul class="mb-0">
                                <li>Biểu tượng: ♈ Con Cừu Đực – tượng trưng cho sức mạnh, dám đương đầu.</li>
                                <li>Nguyên tố: Lửa </li>
                                <li>Hành tinh chủ quản: Sao Hỏa (Mars)</li>
                                <li>Màu sắc may mắn: Đỏ, cam, vàng</li>
                                <li>Đá phong thủy hợp mệnh: Ruby, Garnet, Kim cương</li>
                                <li>Con số may mắn: 1, 9</li>
                                <li>Ngày sinh: Từ 21/3 đến 19/4</li>
                            </ul>
                            <p class="mb-0">Chòm sao Aries trên bầu trời đêm là một trong những chòm sao cổ xưa nhất, từng
                                được
                                người Babylon và
                                Hy Lạp cổ đại ghi nhận. Trong thần thoại Hy Lạp, Aries gắn liền với câu chuyện về con cừu
                                vàng
                                (Golden Ram) – biểu tượng của sự hi sinh, lòng dũng cảm và sức mạnh bảo vệ.</p>

                            <h4 class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Bạch Dương</h4>
                            <p class="mb-0">Những người thuộc cung Bạch Dương là những nhà tiên phong bẩm sinh. Họ mang
                                trong mình
                                ngọn lửa của sự đam mê, tinh thần lãnh đạo và lòng nhiệt huyết.
                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</h5>
                            <ul class="mb-0">
                                <li>Năng động, hoạt bát, đầy năng lượng.</li>
                                <li>Thẳng thắn, trung thực và luôn nói điều mình nghĩ.</li>
                                <li>Quyết đoán, dám nghĩ dám làm, thích thử thách và mạo hiểm.</li>
                                <li>Có khả năng truyền cảm hứng và dẫn dắt người khác.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</h5>
                            <ul class="mb-1">
                                <li>Hơi nóng vội, dễ nổi giận.</li>
                                <li>Thiếu kiên nhẫn, dễ bỏ dở giữa chừng.</li>
                                <li>Thích được khen ngợi, đôi khi hơi “cái tôi” cao</li>
                            </ul>
                            <p class="mb-0">Tổng thể, Bạch Dương là những người luôn hướng về phía trước, yêu tự do, ghét
                                bị ràng
                                buộc và luôn
                                muốn khẳng định bản thân bằng hành động thực tế.</p>
                            <h4 class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</h4>
                            <p class="mb-1">Với bản tính năng động và ham thử thách, Bạch Dương rất hợp với những công
                                việc yêu
                                cầu tốc độ, tinh
                                thần cạnh tranh hoặc vị trí lãnh đạo.</p>
                            <p class="fw-bolder mb-0">Nghề nghiệp lý tưởng cho Bạch Dương:</p>
                            <ul class="mb-1">
                                <li>Doanh nhân, nhà sáng lập khởi nghiệp</li>
                                <li>Quản lý, giám đốc dự án</li>
                                <li>Cảnh sát, quân nhân, vận động viên</li>
                                <li>Phóng viên, MC, hướng dẫn viên du lịch</li>
                                <li>Ngành kỹ thuật, công nghệ hoặc truyền thông</li>
                            </ul>
                            <p class="mb-0">Họ thường không phù hợp với những công việc mang tính lặp lại hoặc đòi hỏi sự
                                tỉ mỉ
                                quá mức – vì họ
                                thích hành động hơn là suy nghĩ quá lâu.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</h4>
                            <p class="mb-0">Trong tình yêu, Bạch Dương là người nồng nhiệt, chân thành và có phần bốc
                                đồng. Họ yêu
                                hết mình, dốc
                                hết trái tim cho người mình thương. <br>
                                Tuy nhiên, vì chịu ảnh hưởng của Sao Hỏa, họ cũng dễ ghen và đôi khi hơi áp đảo đối phương.
                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</h5>
                            <ul class="mb-0">
                                <li>Chủ động trong tình yêu, thích chinh phục.</li>
                                <li>Luôn tạo cảm giác mới mẻ, lãng mạn và cuốn hút.</li>
                                <li>Đôi khi hơi “trẻ con” và cần người yêu thấu hiểu.</li>
                                <li>Khi yêu thật lòng, họ trung thành tuyệt đối.</li>

                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</h5>
                            <ul class="mb-0">
                                <li>Sư Tử: cùng nguyên tố Lửa, đam mê và ăn ý mạnh mẽ.</li>
                                <li>Nhân Mã: cùng khát vọng tự do, phiêu lưu.</li>
                                <li>Song Tử: linh hoạt, năng động, dễ đồng điệu.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h5>
                            <ul class="mb-0">
                                <li>Cự Giải: vì quá nhạy cảm, Bạch Dương dễ khiến họ tổn thương.</li>
                                <li>Ma Kết: khác biệt trong cách sống và nhịp điệu cuộc đời.</li>
                            </ul>
                            <h4 class="title-tong-quan-h4 pt-2">Bạch Dương trong cuộc sống</h4>
                            <p class="mb-0">Bạch Dương là người thích hành động, ghét sự trì hoãn. Họ sống hướng ngoại,
                                thích cạnh
                                tranh và luôn muốn trở thành người dẫn đầu. <br>
                                Trong cuộc sống hàng ngày, họ lan tỏa năng lượng tích cực, truyền cảm hứng cho bạn bè và
                                đồng
                                nghiệp. Tuy nhiên, họ cần học cách kiềm chế cảm xúc và lắng nghe người khác nhiều hơn để đạt
                                được
                                thành công bền vững.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tổng kết</h4>
                            <p class="mb-0">Cung Bạch Dương (Aries) là biểu tượng của sự khởi đầu, lòng dũng cảm và khát
                                khao
                                chinh phục.<br>
                                Người thuộc cung này luôn sẵn sàng tiến bước dù phía trước có thử thách, thất bại hay nguy
                                hiểm.
                            </p>
                            <p class="mb-0">Nếu bạn là một Bạch Dương – hãy tự hào vì bạn mang trong mình ngọn lửa tiên
                                phong của
                                12 cung hoàng đạo: mạnh mẽ, thẳng thắn, đầy nhiệt huyết và luôn là người dẫn đầu mọi hành
                                trình.
                            </p>
                        </div>
                    </div>

                </div>

                @include('horoscope.list-cung')
            </div>
            @include('horoscope.box-right')
        </div>

    </div>
@endsection
