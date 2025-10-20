@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Mã Kết</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu cung Ma Kết</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <h4 class="title-tong-quan-h4">Cung Ma Kết là gì?</h4>
                            <p class="mb-0">Cung Ma Kết (Capricorn) là cung hoàng đạo thứ 10, tượng trưng cho sự kiên
                                định, tham
                                vọng và khả năng lãnh đạo bẩm sinh. <br>
                                Những người sinh từ 22/12 đến 19/1 thuộc cung Ma Kết, mang biểu tượng là Con Dê Núi (The Sea
                                Goat) –
                                nửa dê, nửa cá, thể hiện khả năng vượt qua mọi khó khăn để leo lên đỉnh cao thành công.
                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Ma Kết thuộc nhóm Đất (Earth) – cùng với Kim Ngưu và Xử Nữ
                                – đại
                                diện cho tính thực tế, kiên nhẫn và nguyên tắc. <br>
                                Hành tinh chủ quản của cung Ma Kết là Sao Thổ (Saturn) – hành tinh của thời gian, kỷ luật và
                                trách
                                nhiệm, giúp họ trở thành những người đáng tin cậy, chăm chỉ và có định hướng rõ ràng trong
                                cuộc
                                sống.g lượng và đam mê. Vì thế, người cung Thần
                                Nông luôn có sức hút mạnh mẽ và nội tâm mãnh liệt.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</h4>
                            <ul class="mb-0">
                                <li>Biểu tượng: Con Dê Núi – đại diện cho sự kiên cường, nỗ lực và bền bỉ.

                                </li>
                                <li>Nguyên tố: Đất</li>
                                <li>Hành tinh chủ quản: Sao Thổ</li>
                                <li>Màu sắc may mắn: Nâu, đen, xám, xanh rêu</li>
                                <li>Đá phong thủy hợp mệnh: Hắc ngọc, mã não đen, thạch anh khói, onyx</li>
                                <li>Con số may mắn: 4, 8, 22</li>
                                <li>Ngày sinh: Từ ngày 22/12 đến ngày 19/1</li>
                            </ul>
                            <p class="mb-0">Chòm sao Capricornus được cho là hình ảnh của vị thần biển cả Pan – người đã
                                hóa thân
                                thành sinh vật nửa dê, nửa cá để trốn thoát quái vật Typhon. <br>
                                Câu chuyện thể hiện sự linh hoạt và khả năng thích nghi của Ma Kết – những người có thể đi
                                đến đỉnh
                                vinh quang bằng sự khôn ngoan và kiên định.</p>

                            <h4 class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Ma Kết</h4>
                            <p class="mb-0">Người thuộc cung Ma Kết thường điềm tĩnh, chín chắn và có định hướng rõ ràng
                                trong
                                cuộc sống. <br>
                                Họ đề cao kỷ luật, trách nhiệm và rất nghiêm túc trong mọi việc – từ công việc, tình yêu đến
                                các mối
                                quan hệ xã hội.

                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</h5>
                            <ul class="mb-0">
                                <li>Kiên nhẫn, có trách nhiệm, đáng tin cậy.</li>
                                <li>Tư duy logic, có khả năng tổ chức và lãnh đạo tốt.</li>
                                <li>Thực tế, biết đặt mục tiêu và nỗ lực không ngừng.</li>
                                <li>Rất trung thành và tận tâm với gia đình, bạn bè.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</h5>
                            <ul class="mb-1">
                                <li>Đôi khi quá nghiêm khắc, thiếu linh hoạt.</li>
                                <li>Dễ bị ám ảnh bởi công việc và thành công.
                                </li>
                                <li>Ít thể hiện cảm xúc, đôi khi khiến người khác thấy “lạnh lùng”.</li>
                                <li>Có xu hướng bi quan nếu thất bại hoặc bị chỉ trích.</li>
                            </ul>
                            <p class="mb-0">Ma Kết là hình mẫu của người trưởng thành sớm – họ không thích mơ mộng mà luôn
                                tập
                                trung vào hiện thực và kết quả.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</h4>
                            <p class="mb-1">Ma Kết là cung hoàng đạo của sự nghiệp và danh vọng. Họ có khả năng làm việc
                                bền bỉ,
                                kiên trì và luôn hướng đến vị trí cao nhất trong lĩnh vực của mình. <br>
                                Nhờ tính kỷ luật và tư duy logic, Ma Kết thường thành công ở những nghề nghiệp cần sự quản
                                lý, chiến
                                lược hoặc tài chính.

                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Nghề nghiệp lý tưởng cho Ma Kết:</h5>
                            <ul class="mb-1">
                                <li>Doanh nhân, giám đốc điều hành, quản lý dự án
                                </li>
                                <li>Kế toán, kiểm toán, tài chính, ngân hàng</li>
                                <li>Kiến trúc sư, kỹ sư, luật sư</li>
                                <li>Chính trị gia, nhà quản trị, giáo viên</li>
                                <li>Nhà nghiên cứu, chuyên viên hoạch định chiến lược</li>
                            </ul>
                            <p class="mb-0">Ma Kết không ngại khó khăn và có thể làm việc trong môi trường áp lực cao.
                                Họ là kiểu người “làm ít, nói ít, nhưng kết quả luôn nhiều”.
                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</h4>
                            <p class="mb-0">Trong tình yêu, Ma Kết là người chân thành, trung thủy và coi trọng sự bền
                                vững.
                                Họ không thích các mối quan hệ hời hợt, thay vào đó muốn xây dựng một tình yêu lâu dài,
                                nghiêm túc
                                và an toàn.
                            </p>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</h5>
                            <ul class="mb-0">
                                <li>Ban đầu có vẻ lạnh lùng, nhưng khi yêu thì vô cùng sâu sắc.
                                </li>
                                <li>Rất trung thành, tận tụy và sẵn sàng hi sinh vì đối phương.
                                </li>
                                <li>Thực tế và bảo vệ người mình yêu bằng hành động hơn là lời nói.</li>
                                <li>Đôi khi thiếu lãng mạn, khiến đối phương cần nhiều kiên nhẫn.
                                </li>

                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</h5>
                            <ul class="mb-0">
                                <li>Kim Ngưu: cùng nguyên tố Đất, bền vững và hiểu nhau.

                                </li>
                                <li>Xử Nữ: đồng điệu trong tư duy, chung lý tưởng sống.</li>
                                <li>Bọ Cạp: sâu sắc, mạnh mẽ, bổ sung cảm xúc cho Ma Kết.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h5>
                            <ul class="mb-0">
                                <li>Bạch Dương: quá bốc đồng, dễ xung đột.
                                </li>
                                <li>Nhân Mã: thiếu ổn định, không hợp với tính nghiêm túc của Ma Kết.
                                </li>
                            </ul>
                            <h4 class="title-tong-quan-h4 pt-2">Ma Kết trong cuộc sống</h4>
                            <p class="mb-1">Ma Kết là người trách nhiệm, trung thực và đáng tin cậy. <br>
                                Họ sống nguyên tắc, ít nói nhưng làm nhiều, và thường là “trụ cột” trong công việc hoặc gia
                                đình.<br>
                                Dù bên ngoài có vẻ khô khan, nhưng bên trong là một tâm hồn ấm áp, giàu lòng trắc ẩn.
                            </p>
                            <p class="mb-0">Trong cuộc sống, Ma Kết cần học cách thư giãn và tận hưởng hiện tại, thay vì
                                luôn đặt
                                mình trong guồng quay của mục tiêu và kỳ vọng.<br>
                                Khi biết cân bằng giữa “nỗ lực” và “niềm vui”, họ sẽ trở thành hình mẫu thành công và hạnh
                                phúc thật
                                sự.

                            </p>
                            <h4 class="title-tong-quan-h4 pt-2">Tổng kết</h4>
                            <p class="mb-0">Cung Ma Kết (Capricorn) là biểu tượng của sự kiên trì, trách nhiệm và khát
                                vọng vươn
                                tới đỉnh cao.<br>
                                Người thuộc cung này là những chiến binh thầm lặng – không ồn ào, không phô trương, nhưng
                                luôn đạt
                                được những gì họ đặt ra bằng chính năng lực và ý chí của mình.

                            </p>
                            <p class="mb-0">Nếu bạn là Ma Kết – hãy tự hào vì bạn là “đá tảng” vững chắc của 12 cung hoàng
                                đạo,
                                người truyền cảm hứng về sự nỗ lực, kiên định và trưởng thành.

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
