@extends('welcome')

@section('content')
    <div class="container-setup">
        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a  style="color: #2254AB; text-decoration: underline;"
                href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Bọ Cạp</span>
        </div>
        <h1 class="content-title-home-lich">Giới thiệu Cung Bọ Cạp</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <h2 class="title-tong-quan-h4">Cung Bọ Cạp là gì?</h2>
                            <p class="mb-0">Cung Bọ Cạp (Scorpio) – hay còn gọi là Cung Thần Nông hoặc Thiên Yết – là cung
                                hoàng
                                đạo thứ tám, đại diện cho năng lượng mạnh mẽ, chiều sâu tâm hồn và khả năng tái sinh phi
                                thường.

                                <br>
                                Những người sinh từ 23/10 đến 21/11 thuộc cung này, mang biểu tượng là Con Bọ Cạp (The
                                Scorpion) –
                                biểu trưng cho sức mạnh, bản năng sinh tồn và ý chí kiên cường.


                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Bọ Cạp thuộc nhóm Nước (Water) – nhóm cảm xúc, sâu sắc
                                và nhạy
                                bén, cùng với Cự Giải và Song Ngư.
                                <br>
                                Hành tinh chủ quản của Bọ Cạp là Sao Diêm Vương (Pluto) – hành tinh của sự biến đổi,
                                quyền lực và
                                tái sinh, kết hợp với Sao Hỏa (Mars) – biểu tượng của năng lượng và đam mê. Vì thế, người
                                cung Thần
                                Nông luôn có sức hút mạnh mẽ và nội tâm mãnh liệt.
                            </p>
                            <h2 class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</h2>
                            <ul class="mb-0">
                                <li>Biểu tượng: Con Bọ Cạp – đại diện cho sự mạnh mẽ, sâu sắc và khả năng vượt qua nỗi đau.
                                </li>
                                <li>Nguyên tố: Nước</li>
                                <li>Hành tinh chủ quản: Sao Diêm Vương (Pluto) & Sao Hỏa (Mars)</li>
                                <li>Màu sắc may mắn: Đỏ đậm, đen, tím sẫm, nâu rượu vang</li>
                                <li>Đá phong thủy hợp mệnh: Hồng ngọc (Ruby), thạch anh tím (Amethyst), đá obsidian</li>
                                <li>Con số may mắn: 8, 11, 18</li>
                                <li>Ngày sinh: Từ ngày 23/10 đến ngày 21/11</li>
                            </ul>
                            <p class="mb-0">Chòm sao Scorpio trong thần thoại Hy Lạp gắn liền với câu chuyện về Orion –
                                thợ săn vĩ
                                đại. Thần Apollo đã gửi một con bọ cạp khổng lồ đến tấn công Orion, và cả hai sau khi qua
                                đời đều
                                được đưa lên trời, trở thành hai chòm sao – tượng trưng cho sức mạnh và sự bất tử.</p>

                            <h2 class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Bọ Cạp</h2>
                            <p class="mb-0">Người thuộc cung Bọ Cạp là những người mạnh mẽ, sâu sắc và đầy nội lực.
                                Họ có cảm xúc mãnh liệt, bản năng nhạy bén và thường che giấu cảm xúc thật sau vẻ ngoài lạnh
                                lùng,
                                khó đoán.
                                <br>Một khi đã đặt mục tiêu, họ sẽ theo đuổi đến cùng – không gì có thể cản bước.
                            </p>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</h3>
                            <ul class="mb-0">
                                <li>Quyết đoán, kiên cường và trung thành.</li>
                                <li>Có trực giác nhạy bén, hiểu rõ người khác.</li>
                                <li>Giỏi giữ bí mật, sống sâu sắc và có trách nhiệm.</li>
                                <li>Có sức hút mạnh mẽ, tinh tế và thông minh.</li>
                            </ul>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</h3>
                            <ul class="mb-1">
                                <li>Dễ ghen tuông, hay kiểm soát trong tình yêu.</li>
                                <li>Có xu hướng thù dai hoặc khó tha thứ.
                                </li>
                                <li>Bí ẩn, khó mở lòng và dễ bị hiểu lầm.</li>
                                <li>Tính cách cực đoan: hoặc yêu hết mình, hoặc lạnh lùng tuyệt đối.</li>
                            </ul>
                            <p class="mb-0">Bọ Cạp là người sống bằng cảm xúc nhưng lý trí mạnh mẽ, họ không bao giờ
                                làm điều
                                gì nửa vời – tình cảm, công việc hay niềm tin đều được dốc hết lòng.

                            </p>
                            <h2 class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</h2>
                            <p class="mb-1">Bọ Cạp có khả năng quan sát sâu sắc, trực giác mạnh và sức tập trung cao
                                độ, vì
                                vậy họ phù hợp với những nghề đòi hỏi tính chiến lược, nghiên cứu hoặc phân tích tâm lý con
                                người
                            </p>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Nghề nghiệp lý tưởng cho Bọ Cạp:</h3>
                            <ul class="mb-1">
                                <li>Nhà nghiên cứu, bác sĩ tâm lý, nhà phân tích dữ liệu
                                </li>
                                <li>Nhà điều tra, thám tử, cảnh sát, chuyên viên an ninh</li>
                                <li>Doanh nhân, nhà đầu tư, chiến lược gia</li>
                                <li>Bác sĩ phẫu thuật, chuyên viên tài chính, cố vấn quản trị</li>
                                <li>Nghề liên quan đến tâm linh, chữa lành hoặc nghệ thuật sáng tạo</li>
                            </ul>
                            <p class="mb-0">Bọ Cạp không thích làm việc hời hợt. Họ cần những dự án có chiều sâu, nơi
                                họ có thể
                                “đi đến tận cùng vấn đề” và chứng minh năng lực thực sự.

                            </p>
                            <h2 class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</h2>
                            <p class="mb-0">Trong tình yêu, Bọ Cạp là người yêu mãnh liệt, sâu sắc và trung thành tuyệt
                                đối.
                                Họ yêu hết mình, nhưng cũng đòi hỏi sự chân thành tuyệt đối từ đối phương.
                                Nếu bị phản bội, họ có thể đau đớn đến cùng cực và rất khó quên.
                            </p>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</h3>
                            <ul class="mb-0">
                                <li>Yêu sâu, ghen mạnh, trung thành tuyệt đối.
                                </li>
                                <li>Luôn muốn bảo vệ người mình yêu khỏi tổn thương.
                                </li>
                                <li>Dễ tổn thương nhưng hiếm khi thể hiện ra bên ngoài.</li>
                                <li>Khi yêu thật lòng, họ sẽ không bao giờ bỏ rơi đối phương.
                                </li>

                            </ul>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</h3>
                            <ul class="mb-0">
                                <li>Cự Giải: cùng nhóm Nước, đồng điệu cảm xúc sâu sắc.
                                </li>
                                <li>Song Ngư: thấu hiểu, bao dung và nhẹ nhàng.</li>
                                <li>Ma Kết: mạnh mẽ, tin cậy và tạo cảm giác an toàn.</li>
                            </ul>
                            <h3 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h3>
                            <ul class="mb-0">
                                <li>Bạch Dương: xung đột quyền lực, dễ va chạm.
                                </li>
                                <li>Sư Tử: cả hai đều thích kiểm soát, dễ đối đầu.</li>
                            </ul>
                            <h2 class="title-tong-quan-h4 pt-2">Bọ Cạp trong cuộc sống</h2>
                            <p class="mb-1">Bọ Cạp là người bí ẩn, sâu sắc và luôn ẩn chứa nhiều suy tư.
                                <br>
                                Họ sống khép kín, không chia sẻ nhiều, nhưng luôn quan sát và hiểu rõ thế giới xung quanh.
                                <br>
                                Khi đã tin tưởng ai đó, họ trở thành người bạn trung thành, người đồng hành đáng tin cậy và
                                người
                                yêu không bao giờ phản bội.
                            </p>
                            <p class="mb-0">Trong cuộc sống, họ cần học cách buông bỏ quá khứ và tha thứ cho bản thân, bởi
                                đôi khi
                                chính sự cực đoan khiến họ tự làm khổ mình. Bọ Cạp mạnh mẽ, nhưng cũng cần học cách để
                                trái tim
                                được bình yên.
                            </p>
                            <h2 class="title-tong-quan-h4 pt-2">Tổng kết</h2>
                            <p class="mb-0">Cung Bọ Cạp (Scorpio) là biểu tượng của năng lượng, chiều sâu và sức mạnh
                                cảm xúc.
                                Người thuộc cung này có khả năng tái sinh mạnh mẽ – dù trải qua khó khăn đến đâu, họ vẫn
                                đứng dậy
                                mạnh mẽ hơn bao giờ hết.
                            </p>
                            <p class="mb-0">Nếu bạn là Bọ Cạp – hãy tự hào vì bạn là cung hoàng đạo của sự kiên định,
                                trung
                                thành và cảm xúc mãnh liệt, mang trong mình khả năng chạm đến những tầng sâu nhất của tâm
                                hồn con
                                người
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
