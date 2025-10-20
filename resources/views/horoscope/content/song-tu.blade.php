@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a  style="color: #2254AB; text-decoration: underline;"
                href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Song Tử</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu Cung Song Tử
        </h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <h4 class="title-tong-quan-h4">Cung Song Tử là gì?</h4>
                            <p class="mb-0">Cung Song Tử (Gemini) là cung hoàng đạo thứ ba, tượng trưng cho trí tuệ, sự
                                linh hoạt
                                và khả năng giao tiếp tuyệt vời.<br>
                                Những người thuộc cung này sinh từ 21/5 đến 20/6, mang biểu tượng là Cặp Song Sinh (The
                                Twins) – đại
                                diện cho hai mặt đối lập trong một con người: năng động nhưng sâu sắc, thông minh nhưng đôi
                                khi mâu
                                thuẫn.
                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Song Tử thuộc nhóm Khí (Air) – đại diện cho tư duy logic,
                                trí tuệ
                                và khả năng truyền đạt.

                                <br>
                                Hành tinh chủ quản của cung Song Tử là Sao Thủy (Mercury) – hành tinh của ngôn ngữ, học tập
                                và giao
                                tiếp, mang đến cho họ đầu óc nhanh nhạy và khả năng thích ứng phi thường.

                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</h4>
                            <ul class="mb-0">
                                <li>Biểu tượng: Cặp Song Sinh – biểu trưng cho sự song hành và linh hoạt.
                                </li>
                                <li>Nguyên tố: Khí</li>
                                <li>Hành tinh chủ quản: Sao Thủy (Mercury)</li>
                                <li>Màu sắc may mắn: Vàng, xanh lá nhạt, bạc</li>
                                <li>Đá phong thủy hợp mệnh: Thạch anh vàng, ngọc mắt mèo, topaz</li>
                                <li>Con số may mắn: 3, 5, 7</li>
                                <li>Ngày sinh: Từ 21/5 đến 20/6</li>
                            </ul>
                            <p class="mb-0">Chòm sao Gemini gắn liền với truyền thuyết Hy Lạp về hai anh em song sinh
                                Castor và
                                Pollux, tượng trưng cho tình bạn, lòng trung thành và sự gắn bó vĩnh cửu.</p>

                            <h4 class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Song Tử</h4>
                            <p class="mb-0">Người thuộc cung Song Tử là những cá nhân thông minh, nhanh nhạy, hiếu kỳ và
                                cực kỳ
                                hoạt ngôn.
                                <br>
                                Họ yêu thích việc giao tiếp, học hỏi và khám phá điều mới lạ, luôn muốn tìm hiểu mọi thứ
                                xung quanh.

                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</h5>
                            <ul class="mb-0">
                                <li>Linh hoạt, sáng tạo và dễ thích nghi.</li>
                                <li>Trí tuệ sắc bén, giao tiếp thông minh, biết lắng nghe và thuyết phục.</li>
                                <li>Tò mò, ham học hỏi, dễ dàng tiếp thu kiến thức mới.</li>
                                <li>Hài hước, vui vẻ, luôn mang đến năng lượng tích cực cho mọi người.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</h5>
                            <ul class="mb-1">
                                <li>Dễ thay đổi, thiếu kiên định.</li>
                                <li>Hay chán nản khi gặp việc lặp lại hoặc thiếu thử thách.</li>
                                <li>Đôi khi nói quá nhanh, hành động vội vàng.</li>
                                <li>Thiếu chiều sâu trong cảm xúc vì thích lý trí hóa vấn đề.</li>
                            </ul>
                            <p class="mb-0">Song Tử là người “hai mặt” theo nghĩa tích cực – vừa sôi nổi, vừa suy tư; vừa
                                hoạt
                                bát, vừa có chiều sâu – khiến họ trở nên thú vị và khó đoán nhất trong 12 cung hoàng đạo.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</h4>
                            <p class="mb-1">Với khả năng giao tiếp tuyệt vời và đầu óc nhanh nhạy, Song Tử có thể thành
                                công
                                trong các lĩnh vực liên quan đến truyền thông, học thuật, kinh doanh hoặc nghệ thuật. <br>
                                Họ làm việc hiệu quả nhất trong môi trường năng động, có nhiều cơ hội trao đổi và sáng tạo.

                            </p>
                            <p class="fw-bolder mb-0">Nghề nghiệp lý tưởng cho Song Tử:
                            </p>
                            <ul class="mb-1">
                                <li>Nhà báo, biên tập viên, MC, diễn giả
                                </li>
                                <li>Marketing, truyền thông, quan hệ công chúng (PR)</li>
                                <li>Nhân viên bán hàng, tư vấn, môi giới</li>
                                <li>Lập trình viên, nhà phân tích dữ liệu, chuyên viên UX/UI</li>
                                <li>Nghệ sĩ, nhà văn, nhà thiết kế hoặc giáo viên</li>
                            </ul>
                            <p class="mb-0">Song Tử là kiểu người đa tài, có thể cùng lúc làm nhiều việc khác nhau và vẫn
                                đạt hiệu
                                quả tốt. Tuy nhiên, họ cần học cách tập trung vào một mục tiêu cụ thể để đạt thành công bền
                                vững.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</h4>
                            <p class="mb-0">Trong tình yêu, Song Tử là người duyên dáng, lãng mạn và biết cách tạo niềm
                                vui. <br>
                                Họ thích những mối quan hệ mang lại cảm xúc mới mẻ, thú vị và không gò bó.<br>
                                Tuy nhiên, đôi khi sự “thay đổi như gió” khiến họ bị hiểu lầm là thiếu nghiêm túc – trong
                                khi thực
                                chất, họ chỉ đang tìm kiếm sự đồng điệu về trí tuệ và cảm xúc.


                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</h5>
                            <ul class="mb-0">
                                <li>Duyên dáng, thông minh, biết cách khiến người khác yêu thích.
                                </li>
                                <li>Cần sự tự do và không thích ràng buộc quá chặt.</li>
                                <li>Khi yêu thật lòng, họ trở nên chu đáo, tinh tế và cực kỳ sáng tạo.</li>
                                <li>Cần một người bạn đời có thể cùng họ trò chuyện, chia sẻ và đồng hành trong tư duy.</li>

                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</h5>
                            <ul class="mb-0">
                                <li>Thiên Bình: cùng nguyên tố Khí, hiểu nhau sâu sắc.
                                </li>
                                <li>Bảo Bình: cùng trí tuệ, cùng đam mê khám phá.
                                </li>
                                <li>Bạch Dương: năng lượng mạnh mẽ, hợp trong hành động.
                                </li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h5>
                            <ul class="mb-0">
                                <li>Xử Nữ: Song Tử thấy Xử Nữ quá tỉ mỉ, còn Xử Nữ lại thấy Song Tử thiếu nghiêm túc
                                </li>
                                <li>Song Ngư: quá cảm xúc và nhạy cảm, dễ khiến Song Tử mệt mỏi.
                                </li>
                            </ul>
                            <h4 class="title-tong-quan-h4 pt-2">Song Tử trong cuộc sống</h4>
                            <p class="mb-1">Song Tử là “tắc kè hoa” của cuộc sống – họ có thể thích nghi với mọi môi
                                trường và con
                                người. <br>
                                Họ có khả năng kết nối với người khác bằng trí tuệ, sự duyên dáng và hài hước tự nhiên.<br>
                                Dù vậy, đôi khi Song Tử cần học cách tập trung và kiên nhẫn hơn, tránh để sự hiếu kỳ khiến
                                họ mất
                                phương hướng.

                            </p>

                            <h4 class="title-tong-quan-h4 pt-2">Tổng kết</h4>
                            <p class="mb-1">Cung Song Tử (Gemini) là biểu tượng của trí tuệ, sáng tạo và sự linh hoạt
                                không giới
                                hạn.
                                Người thuộc cung này mang đến cho thế giới năng lượng tươi mới, khả năng truyền cảm hứng và
                                kết nối
                                con người bằng ngôn từ và ý tưởng.
                            </p>
                            <p class="mb-0">Nếu bạn là Song Tử – hãy tự hào vì bạn chính là người truyền lửa tri thức và
                                cảm hứng,
                                là cầu nối giữa ý tưởng và hành động, là minh chứng rằng “cuộc sống luôn thú vị nếu ta biết
                                nhìn nó
                                bằng đôi mắt tò mò và một trái tim rộng mở.”

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
