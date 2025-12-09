@extends('welcome')
@section('content')
  @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.3') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem ngày tốt
                </li>
            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem Ngày Tốt Theo Tuổi Cho Mọi Công Việc Quan Trọng</h1>

        <div class="mt-3">
            <div class="row g-0 g-lg-3">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="box--bg-thang ">
                        <p class="mb-0">Chọn công việc bạn đang chuẩn bị (cưới hỏi, mua nhà, khai trương, động thổ, nhập
                            trạch, ký hợp đồng…), hệ thống sẽ gợi ý những ngày đẹp nhất dựa theo khoảng thời gian bạn chọn.
                        </p>
                        <p>Mỗi công cụ đều dựa trên tuổi của người xem (âm hoặc dương lịch), tra cứu theo Ngọc Hạp Thông
                            Thư, Nhị Thập Bát Tú, Thập Nhị Trực, Can Chi, Hoàng Đạo… để đưa ra ngày giờ tốt, và các lưu ý
                            chi tiết.</p>
                        <h2 class="title-tong-quan-h3-log mb-0">Phong thuỷ</h2>
                        <div class="row g-3 pt-4 pb-4">
                           
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-nha.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongnha.svg') }}" class="icon "
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Nhà</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('breaking.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongbantho.svg') }}" class="icon "
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Ban Thờ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-bep.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongbep.svg') }}" class="icon "
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Bếp Nấu</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-phong-ngu.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongphongngu.svg') }}" class="icon "
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Phòng Ngủ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-ban-lam-viec.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongbanlamviec.svg') }}" class="icon "
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Bàn Làm Việc</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                         
                        </div>
                        

                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="text-box-tong-quan">


                            <h2 class="title-tong-quan-h3-log fw-bolder">Giới thiệu về tính năng xem ngày tốt theo tuổi cho
                                mọi
                                công việc
                                quan trọng</h2>


                            <p> Trong đời sống Á Đông, việc chọn ngày lành tháng tốt được xem như một cách tăng thêm may
                                mắn,
                                giúp mọi việc diễn ra thuận lợi và hanh thông. Tại Phong Lịch, hệ thống xem ngày tốt theo
                                tuổi
                                được phát triển nhằm mang đến cho bạn một nơi tra cứu ngày giờ chuẩn xác – dễ hiểu – dễ sử
                                dụng,
                                phù hợp cho cả những ai lần đầu tìm hiểu phong thủy.</p>
                            <p>Tất cả công cụ trong danh sách đều dựa vào những nền tảng học thuật uy tín như Ngọc Hạp Thông
                                Thư, Nhị Thập Bát Tú, Thập Nhị Trực, Can Chi, Hoàng Đạo – Hắc Đạo, kết hợp với tuổi của
                                người xem theo âm lịch hoặc dương lịch. Nhờ đó, bạn có thể chọn được ngày giờ tốt nhất cho
                                từng việc: cưới hỏi, xây dựng, khai trương, ký kết, di chuyển, cúng lễ… hoặc đơn giản là xem
                                một ngày bất kỳ có đẹp hay không.</p>

                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Tại sao nên sử dụng hệ thống xem ngày tốt?
                            </h2>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                1. Giúp bạn yên tâm hơn khi thực hiện việc quan trọng
                            </h3>
                            <p class="mb-3">Dù bạn tin phong thủy ở mức độ nào, việc chọn ngày tốt vẫn mang lại cảm giác
                                an tâm. Sự yên
                                tâm giúp tâm lý thoải mái, công việc thuận lợi và tự tin hơn.</p>

                            <h3 class="title-tong-quan-h4-log fst-italic">
                                2. Tránh những ngày có nhiều yếu tố xấu
                            </h3>
                            <p class="mb-3">Nhiều ngày được coi là hung vì phạm phải: ngày xung tuổi, ngày sát chủ, ngày
                                hắc đạo, sao xấu
                                hoặc trực xấu. Công cụ của PhongLich.com giúp bạn tự động lọc bỏ những ngày kỵ, tránh những
                                rủi ro không đáng có.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                3. Lựa chọn ngày đẹp phù hợp với từng mục đích
                            </h3>
                            <p class="mb-2">Mỗi loại công việc lại cần một tiêu chí riêng:</p>
                            <ul class="mb-2">
                                <li>Cưới hỏi ưu tiên ngày cát lành, tránh ngày cô thần, quả tú.</li>
                                <li>Khai trương ưu tiên ngày hoàng đạo, sao tốt về tài lộc.</li>
                                <li>Động thổ – nhập trạch cần hợp ngũ hành, tránh trực phá, trực bế.</li>
                                <li>Ký kết – công việc nên chọn ngày có sao tốt về quý nhân và may mắn.</li>
                            </ul>
                            <p class="mb-3">Việc lọc ngày theo mục đích + theo tuổi giúp bạn chọn được ngày phù hợp nhất.
                            </p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Hướng dẫn cách sử dụng danh sách công cụ xem ngày tốt
                            </h2>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                1. Chọn đúng loại công việc
                            </h3>
                            <p class="mb-2">Trên trang, các công cụ được chia thành 3 nhóm rõ ràng:</p>
                            <ul class="mb-3" style="list-style-type: lower-alpha;">
                                <li>Việc Đại Sự: cưới hỏi, mua nhà, khai trương, làm nhà…</li>
                                <li>Công Việc – Sự Nghiệp: xuất hành, ký hợp đồng, thi cử, phỏng vấn…</li>
                                <li>Nhà Cửa – Tâm Linh: sang cát, trấn trạch, lập bàn thờ, cúng lễ…</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic mb-3">
                                2. Bạn chỉ cần chọn công cụ phù hợp nhất với nhu cầu của mình.
                            </h3>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                3. Nhập tuổi và khoảng thời gian dự kiến
                            </h3>
                            <p class="mb-3">Hệ thống sử dụng tuổi của bạn để đối chiếu Can Chi – Ngũ Hành, giúp chọn đúng
                                ngày hợp mệnh – tránh xung khắc.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                4. Xem danh sách ngày đẹp gợi ý
                            </h3>
                            <p class="mb-2">Mỗi công cụ sẽ trả về:</p>
                            <ul class="mb-3" style="list-style-type: lower-alpha;">
                                <li>Danh sách ngày đẹp nhất trong thời gian bạn chọn</li>
                                <li>Ngày giờ tốt – xấu</li>
                                <li>Lưu ý chi tiết theo từng việc</li>
                                <li>Những điều nên làm/kiêng làm</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                5. Chọn ngày phù hợp thực tế của bạn
                            </h3>
                            <p class="mb-3">Bạn có thể xem thêm các lựa chọn khác trong cùng khoảng thời gian nếu muốn
                                linh hoạt hơn về lịch trình.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Khi chọn một ngày tốt, bạn cần xét những yếu tố có lợi nào?
                            </h2>
                            <p class="mb-1">Dưới đây là các yếu tố cát lợi mà hệ thống ưu tiên khi gợi ý ngày đẹp:</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                1. Ngày hợp tuổi – hợp mệnh
                            </h3>
                            <p class="mb-1">Can Chi tương sinh, Ngũ Hành hòa hợp giúp công việc được thuận lợi và dễ
                                thành công.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                2. Sao tốt và trực tốt
                            </h3>
                            <ul class="mb-1">
                                <li>Sao tốt: Thiên Đức, Nguyệt Đức, Phúc Sinh, Tinh Nhật…</li>
                                <li>Trực tốt tùy việc: trực khai, trực mãn, trực thành, trực bình…</li>
                            </ul>
                            <p class="mb-1">Những yếu tố này giúp tăng cát khí của ngày.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                3. Ngày hoàng đạo – tránh hắc đạo
                            </h3>
                            <p class="mb-1">Hoàng đạo mang năng lượng thuận lợi, thường dùng trong hầu hết công việc lớn.
                            </p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                4. Nhị Thập Bát Tú phù hợp theo từng việc
                            </h3>
                            <p class="mb-3">Một số sao đặc biệt tốt cho xây dựng, hoặc đặc biệt tốt cho cưới hỏi, khai
                                trương…</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder mt-1 mb-3">
                                Những yếu tố bất lợi cần tránh khi chọn ngày
                            </h2>
                            <p class="mb-2">Khi tìm ngày tốt, hệ thống tự động loại bỏ các yếu tố xấu sau:</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                1. Ngày xung tuổi – khắc tuổi
                            </h3>
                            <p class="mb-3">Ngày phạm xung, hình, phá với tuổi gia chủ hoặc người thực hiện.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                2. Sao xấu – trực xấu
                            </h3>
                            <ul class="mb-3">
                                <li>Sao xấu: Thụ Tử, Thiên Cương, Ngũ Quỷ…</li>
                                <li>Trực xấu: trực bế, trực phá, trực thu…</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                3. Ngày sát chủ, tam nương, nguyệt kỵ
                            </h3>
                            <p class="mb-3">Đây là các nhóm ngày được dân gian coi là cực kỳ hung, cần tránh hầu hết
                                những việc trọng đại.</p>
                            <h3 class="title-tong-quan-h4-log fst-italic">
                                4. Ngày hắc đạo – ngày không hợp ngũ hành công việc
                            </h3>
                            <p class="mb-3">Dễ gây trở ngại, trì hoãn hoặc thiếu thuận lợi khi triển khai.</p>
                            <h2 class="title-tong-quan-h3-log fw-bolder">
                                Kết luận
                            </h2>
                            <p class="mb-0">Trang danh sách các công cụ xem ngày tốt trên Phong Lịch giúp bạn dễ dàng tìm
                                đúng công cụ theo mục đích, xem ngày hợp tuổi, tránh ngày xấu và lựa chọn thời điểm đẹp nhất
                                để thực hiện các việc quan trọng trong cuộc sống.</p>
                            <p class="mb-0">Dù bạn xem để chuẩn bị cưới hỏi, xây sửa nhà, khai trương, ký kết hay làm các
                                nghi lễ tâm linh, hệ thống đều cung cấp thông tin rõ ràng – dễ hiểu – chính xác, giúp bạn an
                                tâm và chủ động trong mọi việc.
                            </p>
                        </div>
                    </div>

                </div>
                @include('tools.siderbardetail')
            </div>
        </div>

    </div>
@endsection
