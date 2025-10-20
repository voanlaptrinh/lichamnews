@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a  style="color: #2254AB; text-decoration: underline;" href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Thiên Bình</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu Cung Thiên Bình</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <h4 class="title-tong-quan-h4">Cung Thiên Bình là gì?</h4>
                            <p class="mb-0">Cung Thiên Bình (Libra) là cung hoàng đạo thứ 7, đại diện cho sự cân bằng,
                                công bằng
                                và mối quan hệ hài hòa.
                                <br>
                                Những người sinh từ 23/9 đến 22/10 thuộc cung này, mang biểu tượng là Cán Cân (The Scales) –
                                tượng
                                trưng cho công lý, sự khách quan và khả năng nhìn nhận vấn đề đa chiều.

                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Thiên Bình thuộc nhóm Khí (Air) – nhóm cung trí tuệ và giao
                                tiếp,
                                cùng với Song Tử và Bảo Bình. <br>
                                Hành tinh chủ quản của Thiên Bình là Sao Kim (Venus) – hành tinh của tình yêu, nghệ thuật và
                                vẻ đẹp,
                                nên những người thuộc cung này thường có gu thẩm mỹ tinh tế, dễ mến và luôn hướng đến sự hài
                                hòa
                                trong cuộc sống.

                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</h4>
                            <ul class="mb-0">
                                <li>Biểu tượng: Cán Cân – đại diện cho công lý, sự công bằng và cân bằng nội tâm.</li>
                                <li>Nguyên tố: Khí </li>
                                <li>Hành tinh chủ quản: Sao Kim</li>
                                <li>Màu sắc may mắn: Hồng pastel, xanh dương nhạt, kem, bạc</li>
                                <li>Đá phong thủy hợp mệnh: Đá ngọc lam, thạch anh hồng, ngọc bích</li>
                                <li>Con số may mắn: 6, 9, 15</li>
                                <li>Ngày sinh: 23/9 – 22/10</li>
                            </ul>
                            <p class="mb-0">Chòm sao Libra là chòm sao duy nhất trong 12 cung hoàng đạo có biểu tượng
                                không phải
                                là người hay động vật, mà là một vật thể – cán cân. Điều đó thể hiện tính cách khách quan,
                                lý trí và
                                luôn tìm kiếm sự công bằng trong mọi việc.</p>

                            <h4 class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Thiên Bình</h4>
                            <p class="mb-0">Người thuộc cung Thiên Bình là những người tinh tế, duyên dáng và có khả năng
                                ngoại
                                giao bẩm sinh.
                                <br> Họ yêu hòa bình, ghét xung đột và luôn cố gắng dung hòa mọi mối quan hệ xung quanh.
                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</h5>
                            <ul class="mb-0">
                                <li>Duyên dáng, thân thiện, dễ tạo thiện cảm.</li>
                                <li>Sống công bằng, biết lắng nghe và thấu hiểu người khác.</li>
                                <li>Có gu thẩm mỹ cao, yêu nghệ thuật và cái đẹp.</li>
                                <li>Giỏi giao tiếp, biết cách cân bằng trong mối quan hệ.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</h5>
                            <ul class="mb-1">
                                <li>Do dự, khó đưa ra quyết định khi có nhiều lựa chọn.</li>
                                <li>Dễ bị ảnh hưởng bởi ý kiến người khác.</li>
                                <li>Tránh né xung đột, đôi khi thiếu quyết đoán.</li>
                                <li>Thích được yêu thích, nên đôi khi quá chiều lòng người khác.</li>
                            </ul>
                            <p class="mb-0">Thiên Bình là người luôn hướng đến sự hài hòa và công bằng, cả trong hành động
                                lẫn cảm
                                xúc. Họ là những “người kiến tạo hòa bình” trong mọi tập thể.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</h4>
                            <p class="mb-1">Với khả năng giao tiếp khéo léo, tư duy logic và gu thẩm mỹ tinh tế, Thiên
                                Bình thích
                                hợp với các công việc đòi hỏi sự sáng tạo, thương lượng hoặc đối nhân xử thế khéo léo.
                            </p>
                            <p class="fw-bolder mb-0">Nghề nghiệp lý tưởng cho Thiên Bình:</p>
                            <ul class="mb-1">
                                <li>Luật sư, nhà ngoại giao, chuyên viên tư vấn</li>
                                <li>Nhà thiết kế thời trang, kiến trúc sư, nghệ sĩ</li>
                                <li>PR, truyền thông, quan hệ công chúng</li>
                                <li>Chuyên viên nhân sự, marketing, tâm lý học</li>
                                <li>Nghề nghiệp liên quan đến nghệ thuật, làm đẹp, thiết kế đồ họa</li>
                            </ul>
                            <p class="mb-0">Thiên Bình làm việc tốt nhất khi họ ở trong môi trường cởi mở, thân thiện và
                                đề cao sự
                                sáng tạo. Họ ghét sự áp đặt và cần có không gian tự do để phát huy năng lực của mình.

                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</h4>
                            <p class="mb-0">Thiên Bình là cung hoàng đạo của tình yêu và mối quan hệ. <br>
                                Họ lãng mạn, tinh tế và luôn muốn mọi thứ trở nên hài hòa, êm đẹp.<br>
                                Trong tình yêu, họ thích được quan tâm nhẹ nhàng và cùng nhau chia sẻ mọi điều trong cuộc
                                sống.
                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</h5>
                            <ul class="mb-0">
                                <li>Lãng mạn, khéo léo, biết cách duy trì cảm xúc.</li>
                                <li>Không thích mâu thuẫn, luôn tìm cách làm hòa.</li>
                                <li>Dễ xiêu lòng vì lời ngọt ngào, nhưng cũng dễ bị tổn thương.</li>
                                <li>Khi yêu thật lòng, Thiên Bình rất chung thủy và tận tâm.</li>

                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</h5>
                            <ul class="mb-0">
                                <li>Song Tử: cùng nhóm Khí, dễ hiểu nhau và nói chuyện ăn ý.</li>
                                <li>Bảo Bình: cùng chí hướng, cùng yêu tự do và sáng tạo.</li>
                                <li>Sư Tử: năng lượng mạnh mẽ của Sư Tử bổ sung cho sự mềm mại của Thiên Bình.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h5>
                            <ul class="mb-0">
                                <li>Ma Kết: quá nguyên tắc, dễ khiến Thiên Bình cảm thấy gò bó.</li>
                                <li>Cự Giải: khác biệt trong cách biểu đạt cảm xúc.</li>
                            </ul>
                            <h4 class="title-tong-quan-h4 pt-2">Thiên Bình trong cuộc sống</h4>
                            <p class="mb-1">Thiên Bình là người yêu cái đẹp, ghét xung đột và luôn tìm kiếm sự cân bằng.
                                Họ là những người bạn đáng tin cậy, người đồng nghiệp thân thiện và là người yêu đầy tinh
                                tế.
                                <br>
                                Thiên Bình có khả năng nhìn nhận mọi chuyện từ nhiều góc độ, nhờ đó họ thường được mọi người
                                tin
                                tưởng giao phó vai trò “người hòa giải”.
                            </p>
                            <p class="mb-0">Tuy nhiên, họ cũng cần học cách quyết đoán hơn. Việc do dự quá lâu hoặc sợ mất
                                lòng
                                đôi bên đôi khi khiến Thiên Bình đánh mất cơ hội quý giá.</p>
                            <h4 class="title-tong-quan-h4 pt-2">Tổng kết</h4>
                            <p class="mb-0">Cung Thiên Bình (Libra) là biểu tượng của công bằng, tình yêu và vẻ đẹp hài
                                hòa.
                                Người thuộc cung này sống tinh tế, thông minh và luôn cố gắng tạo nên hòa khí trong mọi mối
                                quan hệ.

                            </p>
                            <p class="mb-0">Nếu bạn là Thiên Bình – hãy tự hào vì bạn chính là người mang lại sự cân bằng
                                và vẻ
                                đẹp cho thế giới này, với trái tim nhân hậu và tâm hồn nghệ sĩ.
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
