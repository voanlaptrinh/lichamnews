@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i><a style="color: #2254AB; text-decoration: underline;" href="{{ route('horoscope.index') }}">Cung
                Hoàng Đạo</a><i class="bi bi-chevron-right"></i><span>Kim Ngưu</span>
        </h6>
        <h1 class="content-title-home-lich">Giới thiệu cung Kim Ngưu</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="tong-quan-date mt-2 mb-3">
                    <div class="card-body  p-lg-4 p-3 position-relative" style="border-radius: 24px">
                        <div class="text-box-tong-quan">
                            <div class="title-tong-quan-h4">Cung Kim Ngưu là gì?</div>
                            <p class="mb-0">Cung Kim Ngưu (Taurus) là cung hoàng đạo thứ hai trong vòng tròn hoàng đạo,
                                tượng
                                trưng cho sự bền bỉ, ổn định và yêu thích những giá trị vật chất lẫn tinh thần. <br>
                                Những người thuộc cung này sinh từ 20/4 đến 20/5, mang biểu tượng là Con Bò Đực (Bull) – đại
                                diện
                                cho sức mạnh, lòng kiên trì và bản năng vững vàng.



                            </p>
                            <p class="mb-0">
                                Trong chiêm tinh học phương Tây, Kim Ngưu thuộc nhóm Đất (Earth) – nhóm người thực tế, ổn
                                định và có
                                khả năng xây dựng nền tảng vững chắc. <br>
                                Hành tinh chủ quản của Kim Ngưu là Sao Kim (Venus) – biểu trưng cho tình yêu, nghệ thuật và
                                cái đẹp.
                                Vì thế, người cung này thường có gu thẩm mỹ cao và yêu thích những điều tinh tế trong cuộc
                                sống.
                            </p>
                            <div class="title-tong-quan-h4 pt-2">Biểu tượng và chòm sao gắn liền</div>
                            <ul class="mb-0">
                                <li>Biểu tượng: Con Bò Đực – kiên định, mạnh mẽ và đáng tin cậy.
                                </li>
                                <li>Nguyên tố: Đất</li>
                                <li>Hành tinh chủ quản: Sao Kim (Venus)</li>
                                <li>Màu sắc may mắn: Xanh lục, hồng pastel, be</li>
                                <li>Đá phong thủy hợp mệnh: Emerald (Ngọc lục bảo), Thạch anh hồng, Sapphire</li>
                                <li>Con số may mắn: 2, 6, 8</li>
                                <li>Ngày sinh: Từ 20/4 đến 20/5</li>
                            </ul>
                            <p class="mb-0">Chòm sao Taurus trên bầu trời đêm là một trong những chòm sao sáng và nổi bật
                                nhất,
                                với cụm sao Pleiades (Thất Nữ) mang ý nghĩa về sự thịnh vượng và vẻ đẹp tự nhiên.</p>

                            <div class="title-tong-quan-h4 pt-2">Tính cách đặc trưng của Kim Ngưu</div>
                            <p class="mb-0">Người cung Kim Ngưu nổi tiếng là những người thực tế, kiên nhẫn và đáng tin
                                cậy nhất
                                trong 12 cung hoàng đạo. <br>
                                Họ không thích thay đổi đột ngột mà luôn hướng đến sự ổn định và an toàn trong cuộc sống.
                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Ưu điểm:</div>
                            <ul class="mb-0">
                                <li>Kiên định, trung thành, bền bỉ và có trách nhiệm.
                                </li>
                                <li>Sống thực tế, biết cách quản lý tài chính và lập kế hoạch.</li>
                                <li>Yêu cái đẹp, có gu thẩm mỹ tinh tế.</li>
                                <li>Bình tĩnh, điềm đạm, tạo cảm giác an toàn cho người khác.</li>
                            </ul>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Nhược điểm:</div>
                            <ul class="mb-1">
                                <li>Cứng đầu, đôi khi bảo thủ và khó thay đổi quan điểm.
                                </li>
                                <li>Hay chậm rãi, không thích bị thúc ép.
                                </li>
                                <li>Có xu hướng yêu thích sự thoải mái nên dễ bị “lười” khi không có động lực.</li>

                            </ul>
                            <p class="mb-0">Kim Ngưu luôn muốn cuộc sống của mình ổn định, đủ đầy và có trật tự, không ưa
                                sự xáo
                                trộn. Tuy nhiên, đằng sau vẻ ngoài trầm lặng là một trái tim ấm áp và tình cảm sâu sắc.
                            </p>
                            <div class="title-tong-quan-h4 pt-2">Sự nghiệp và nghề nghiệp phù hợp</div>
                            <p class="mb-1">Với bản chất kiên định, cẩn trọng và thực tế, Kim Ngưu thích hợp với các công
                                việc
                                liên quan đến tài chính, nghệ thuật, quản lý hoặc sáng tạo.
                                <br> Họ có khả năng duy trì sự ổn định và phát triển lâu dài trong bất kỳ lĩnh vực nào.

                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Nghề nghiệp lý tưởng cho Kim Ngưu:</div>
                            <ul class="mb-1">
                                <li>Ngân hàng, kế toán, đầu tư tài chính
                                </li>
                                <li>Thiết kế, kiến trúc, thời trang, nghệ thuật
                                </li>
                                <li>Bất động sản, quản lý dự án, quản lý nhân sự</li>
                                <li>Ẩm thực, nông nghiệp, làm đẹp, spa</li>
                                <li>Ẩm thực, nông nghiệp, làm đẹp, spa
                                    Ca sĩ, nhạc sĩ hoặc công việc liên quan đến thẩm mỹ
                                </li>
                            </ul>
                            <p class="mb-0">Kim Ngưu không thích rủi ro và thường chọn con đường an toàn, nhưng khi đã xác
                                định
                                mục tiêu, họ làm việc chăm chỉ và rất có năng lực để đạt được thành công.

                            </p>
                            <div class="title-tong-quan-h4 pt-2">Tình yêu và các mối quan hệ</div>
                            <p class="mb-0">Trong tình yêu, Kim Ngưu là người chân thành, sâu sắc và cực kỳ chung thủy. Họ
                                yêu
                                bằng cả trái tim, luôn muốn mang đến sự an toàn và chăm sóc cho đối phương.
                                <br> Tuy nhiên, một khi bị phản bội, họ rất khó tha thứ và có thể khép lòng trong thời gian
                                dài.

                            </p>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Đặc điểm tình cảm:</div>
                            <ul class="mb-0">
                                <li>Thích sự lãng mạn nhẹ nhàng, ổn định và lâu dài.

                                </li>
                                <li>Không vội vàng trong tình yêu, cần thời gian để tin tưởng.
                                </li>
                                <li>Rất gắn bó và tận tâm khi đã yêu thật lòng.
                                </li>
                                <li>Cự Giải: tình cảm, biết quan tâm và khiến Kim Ngưu cảm thấy an toàn.
                                </li>

                            </ul>
                            <div class="title-tong-quan-h5 pt-2 mb-0">Hợp với các cung:</div>
                            <ul class="mb-0">
                                <li>Xử Nữ: cùng nguyên tố Đất, hiểu nhau và bền vững.

                                </li>
                                <li>Ma Kết: cùng quan điểm sống thực tế, đáng tin cậy.
                                </li>
                                <li>Cự Giải: tình cảm, biết quan tâm và khiến Kim Ngưu cảm thấy an toàn.</li>
                            </ul>
                            <h5 class="title-tong-quan-h5 pt-2 mb-0">Không hợp lắm với:</h5>
                            <ul class="mb-0">
                                <li>Bảo Bình – khác biệt trong tư duy và nhịp sống.

                                </li>
                                <li>Sư Tử – dễ mâu thuẫn vì cái tôi lớn và tính chiếm hữu.</li>
                            </ul>
                            <div class="title-tong-quan-h4 pt-2">Kim Ngưu trong cuộc sống</div>
                            <p class="mb-1">Kim Ngưu yêu thích những điều giản dị nhưng chất lượng, như một bữa ăn ngon,
                                bản nhạc
                                nhẹ hay không gian sống ấm cúng. <br>
                                Họ thích cảm giác an toàn, ghét thay đổi và luôn nỗ lực để tạo ra một cuộc sống ổn định cả
                                về vật
                                chất lẫn tinh thần.<br>
                                Trong công việc và cuộc sống, Kim Ngưu là người bạn trung thành, là “chỗ dựa” đáng tin cậy
                                của mọi
                                người xung quanh.

                            </p>

                            <div class="title-tong-quan-h4 pt-2">Tổng kết</div>
                            <p class="mb-0">Cung Kim Ngưu (Taurus) là biểu tượng của sự kiên nhẫn, bền bỉ và yêu thích cái
                                đẹp.
                                Người thuộc cung này mang lại cảm giác an toàn, ổn định và đáng tin – dù trong công việc hay
                                tình
                                yêu.

                            </p>
                            <p class="mb-0">Nếu bạn là một Kim Ngưu, hãy tự hào vì bạn sở hữu sức mạnh thầm lặng của Đất –
                                vững
                                vàng, bền bỉ và luôn biết cách tận hưởng cuộc sống theo cách riêng của mình.
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
