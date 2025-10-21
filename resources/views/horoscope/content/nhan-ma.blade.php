@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a  style="color: #2254AB; text-decoration: underline;" href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Nhân Mã</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu cung Nhân Mã</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <div class="title-tong-quan-h4">Cung Nhân Mã là gì?</div>
                            <p class="mb-0">Cung Nhân Mã (Sagittarius) là cung hoàng đạo thứ chín, đại diện cho tinh thần
                                tự do,
                                tri thức, khám phá và khát vọng chinh phục thế giới.
                                <br>
                                Những người sinh từ 22/11 đến 21/12 thuộc cung này, mang biểu tượng là Cung Thủ (The Archer)
                                – hình
                                ảnh nửa người nửa ngựa cầm cung tên, tượng trưng cho sự kết hợp giữa trí tuệ con người và
                                bản năng
                                phiêu lưu của tự nhiên.
                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Nhân Mã thuộc nhóm Lửa (Fire) – cùng với Bạch Dương và Sư
                                Tử – mang
                                năng lượng nhiệt huyết, đam mê và tràn đầy sức sống.
                                <br>
                                Hành tinh chủ quản của Nhân Mã là Sao Mộc (Jupiter) – hành tinh của may mắn, sự mở rộng và
                                tri thức,
                                khiến người thuộc cung này luôn có tầm nhìn rộng, lòng bao dung và niềm tin mạnh mẽ vào cuộc
                                sống.

                            </p>
                            <div class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</div>
                            <ul class="mb-0">
                                <li>Biểu tượng: Cung Thủ – tượng trưng cho khát vọng vươn xa và tinh thần mạo hiểm.
                                </li>
                                <li>Nguyên tố: Lửa</li>
                                <li>Hành tinh chủ quản: Sao Mộc (Jupiter)</li>
                                <li>Màu sắc may mắn: Tím, xanh dương, cam, vàng</li>
                                <li>Đá phong thủy hợp mệnh: Ngọc lam (Turquoise), topaz, sapphire xanh</li>
                                <li>Con số may mắn: 3, 9, 12</li>
                                <li>Ngày sinh: Từ ngày 22/11 đến ngày 21/12</li>
                            </ul>
                            <p class="mb-0">Chòm sao Sagittarius trong thần thoại Hy Lạp gắn liền với Chiron – nhân mã
                                hiền triết,
                                người thầy của nhiều anh hùng Hy Lạp. Chiron được xem là biểu tượng của tri thức, lòng bao
                                dung và
                                sự chữa lành. Điều đó lý giải vì sao Nhân Mã luôn yêu tri thức và khát khao truyền cảm hứng
                                cho
                                người khác.</p>

                            <div class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Nhân Mã</div>
                            <p class="mb-0">Người thuộc cung Nhân Mã là những người yêu tự do, lạc quan và tràn đầy năng
                                lượng
                                tích cực. <br>
                                Họ luôn nhìn cuộc sống bằng con mắt tươi sáng, cởi mở và có xu hướng tìm kiếm ý nghĩa sâu xa
                                trong
                                mọi điều.

                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</div>
                            <ul class="mb-0">
                                <li>Tự tin, trung thực và lạc quan.</li>
                                <li>Có tầm nhìn xa, yêu tri thức và khám phá.</li>
                                <li>Hòa đồng, hài hước, dễ gây thiện cảm.</li>
                                <li>Dám nghĩ, dám làm, không sợ thử thách.</li>
                            </ul>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</div>
                            <ul class="mb-1">
                                <li>Thẳng thắn quá mức, đôi khi làm người khác tổn thương.</li>
                                <li>Dễ chán nản, khó kiên trì với những việc lặp lại.
                                </li>
                                <li>Có xu hướng tránh né trách nhiệm khi bị gò bó.</li>
                                <li>Thích tự do, nên đôi khi bị xem là “khó nắm bắt”.</li>
                            </ul>
                            <p class="mb-0">Nhân Mã là người thích sống trọn vẹn từng khoảnh khắc, luôn hướng tới những
                                chân trời
                                mới, cả về thể chất lẫn tinh thần. Họ là nguồn năng lượng tích cực trong mọi nhóm bạn.

                            </p>
                            <div class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</div>
                            <p class="mb-1">Với tinh thần phiêu lưu, yêu tự do và khả năng tư duy rộng mở, Nhân Mã phù hợp
                                với
                                những công việc liên quan đến tri thức, du lịch, sáng tạo và giao tiếp quốc tế.

                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Nghề nghiệp lý tưởng cho Nhân Mã:</div>
                            <ul class="mb-1">
                                <li>Hướng dẫn viên du lịch, phóng viên, nhà báo
                                </li>
                                <li>Nhà triết học, giảng viên, nhà nghiên cứu</li>
                                <li>Doanh nhân, nhà ngoại giao, chuyên viên marketing quốc tế</li>
                                <li>Nhiếp ảnh gia, nhà văn, đạo diễn</li>
                                <li>Huấn luyện viên, diễn giả truyền cảm hứng</li>
                            </ul>
                            <p class="mb-0">Nhân Mã không phù hợp với môi trường làm việc bó buộc hay quá quy củ. Họ cần
                                tự do
                                sáng tạo và không gian phát triển cá nhân, nơi họ có thể được “bay cao và vươn xa”.

                            </p>
                            <div class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</div>
                            <p class="mb-0">Trong tình yêu, Nhân Mã là người chân thành, nhiệt huyết và đầy đam mê, nhưng
                                cũng yêu
                                tự do và ghét sự ràng buộc.
                                Họ cần một người bạn đời có thể cùng họ khám phá thế giới và chia sẻ lý tưởng sống.

                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</div>
                            <ul class="mb-0">
                                <li>Khi yêu thật lòng, Nhân Mã rất chân thành và chung thủy.

                                </li>
                                <li>Thích sự vui vẻ, tự nhiên, ghét kiểm soát.
                                </li>
                                <li>Dễ yêu, dễ say mê, nhưng cũng dễ “vụt tắt” nếu cảm thấy tù túng.</li>
                                <li>Luôn cần không gian riêng để phát triển bản thân.
                                </li>

                            </ul>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</div>
                            <ul class="mb-0">
                                <li>Bạch Dương: cùng năng lượng, cùng khát vọng phiêu lưu.

                                </li>
                                <li>Sư Tử: hòa hợp, cùng đam mê và tỏa sáng rực rỡ.</li>
                                <li>Thiên Bình: lãng mạn, tinh tế, giúp cân bằng cảm xúc cho Nhân Mã.</li>
                            </ul>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</div>
                            <ul class="mb-0">
                                <li>Xử Nữ: quá tỉ mỉ, khiến Nhân Mã cảm thấy bị bó buộc.
                                </li>
                                <li>Cự Giải: thiên về cảm xúc, dễ bị tổn thương trước sự thẳng thắn của Nhân Mã.</li>
                            </ul>
                            <div class="title-tong-quan-h4 pt-2">Nhân Mã trong cuộc sống</div>
                            <p class="mb-1">Nhân Mã là người vui vẻ, cởi mở và luôn lan tỏa năng lượng tích cực. <br>
                                Họ yêu tự do, yêu cuộc sống và luôn tin rằng mọi khó khăn đều có cách vượt qua.<br>
                                Bên cạnh sự hài hước, Nhân Mã còn rất sâu sắc và thích khám phá những điều có ý nghĩa trong
                                cuộc
                                sống – từ tri thức, tôn giáo cho đến triết học.
                            </p>
                            <p class="mb-0">Tuy nhiên, để thành công bền vững, Nhân Mã cần học cách kiên nhẫn hơn và biết
                                lắng
                                nghe người khác. Sự tự tin và tự do là điểm mạnh, nhưng đôi khi cũng khiến họ bỏ lỡ những cơ
                                hội quý
                                giá.
                            </p>
                            <div class="title-tong-quan-h4 pt-2">Tổng kết</div>
                            <p class="mb-0">Cung Nhân Mã (Sagittarius) là biểu tượng của tự do, tri thức và khát vọng
                                chinh
                                phục.<br>
                                Người thuộc cung này sống lạc quan, yêu đời và luôn muốn mở rộng giới hạn của bản thân.

                            </p>
                            <p class="mb-0">Nếu bạn là Nhân Mã – hãy tự hào vì bạn sinh ra để khám phá, truyền cảm hứng và
                                lan tỏa
                                ánh sáng tri thức đến thế giới, bằng chính tinh thần tự do và trái tim chân thành của mình.
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
