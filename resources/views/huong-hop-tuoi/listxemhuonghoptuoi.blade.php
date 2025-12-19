@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.6') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xem hướng hợp tuổi
                </li>
            </ol>
        </nav>


        <h1 class="content-title-home-lich">Xem Hướng Hợp Tuổi </h1>

        <div class="mt-3">
            <div class="row g-0 g-lg-3">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="box--bg-thang ">
                        <p class="mb-0">Khám phá các hướng hợp tuổi theo phong thủy Bát Trạch, giúp bạn chọn hướng nhà,
                            hướng bàn thờ, bếp, phòng ngủ và bàn làm việc sao cho thu hút tài lộc, sức khỏe và bình an.
                        </p>


                        <div class="row g-3 pt-4 pb-4">

                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-nha.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongnha.svg?v=1.0') }}" class="icon" alt="tool xem hướng nhà"
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
                                    <a href="{{ route('huong-ban-tho.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongbantho.svg?v=1.0') }}" class="icon " alt="tool xem hướng bàn thờ"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem Hướng Bàn Thờ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('huong-bep.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/tool_xemhuongbep.svg?v=1.0') }}" class="icon " alt="tool xem hướng bếp"
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
                                            <img src="{{ asset('icons/tool_xemhuongphongngu.svg?v=1.0') }}" class="icon " alt="tool xem hướng phòng ngủ"
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
                                            <img src="{{ asset('icons/tool_xemhuongbanlamviec.svg?v=1.0') }}" class="icon " alt="tool xem hướng bàn làm việc"
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


                            <h2 class="title-tong-quan-h3-log fw-bolder">Giới thiệu Công Cụ Xem Hướng Hợp Tuổi – Chọn Đúng
                                Hướng, Đón Đủ Vượng Khí</h2>


                            <p>Việc lựa chọn hướng phù hợp theo tuổi là một trong những ứng dụng phổ biến nhất của phong
                                thủy Bát Trạch. Dù là xây nhà, bố trí phòng ngủ, đặt bàn thờ hay sắp xếp bàn làm việc, một
                                hướng tốt có thể giúp gia chủ đón được sinh khí, thúc đẩy tài lộc, mang lại sự hanh thông
                                trong công việc và cuộc sống.</p>
                            <p>Tính năng <b>Xem Hướng Hợp Tuổi</b> trên Phong Lịch được xây dựng nhằm hỗ trợ người dùng xác
                                định các hướng tốt – xấu dựa trên tuổi, mệnh trạch và từng mục đích sử dụng cụ thể. Công cụ
                                giúp bạn lựa chọn đúng hướng phong thủy mà không cần phải ghi nhớ công thức hay tự tính toán
                                phức tạp.</p>

                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Vì sao cần xem hướng hợp tuổi?
                            </h3>
                            <p class="mb-2">Hướng là yếu tố quan trọng trong phong thủy vì liên quan trực tiếp đến dòng
                                khí (Khí – Vượng khí – Sát khí) tác động đến môi trường sống.</p>
                            <p class="mb-2">Việc chọn hướng hợp tuổi mang lại nhiều lợi ích:</p>
                            <ul>
                                <li>Giúp nhà cửa, không gian sống và không gian làm việc hài hòa với mệnh trạch của gia chủ.
                                </li>
                                <li>Tăng sinh khí, thúc đẩy tài vận, sự nghiệp và sức khỏe.</li>
                                <li>Giảm thiểu những xung khắc vô hình có thể gây hao tổn năng lượng, dễ gặp rắc rối hoặc
                                    thiếu may mắn.</li>
                                <li>Hỗ trợ tinh thần và cảm giác yên tâm khi sinh hoạt trong ngôi nhà hoặc môi trường phù
                                    hợp phong thủy.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Những yếu tố phong thủy dùng để xác định hướng hợp tuổi
                            </h3>
                            <p class="mb-2">Công cụ của chúng tôi dựa trên các nguyên tắc phong thủy truyền thống:</p>
                            <h4 class="title-tong-quan-h5-log fs-6 fst-italic">
                                1. Bát Trạch: Đông Tứ Mệnh và Tây Tứ Mệnh
                            </h4>
                            <p class="mb-3">Dựa vào năm sinh, người dùng được phân vào nhóm mệnh trạch tương ứng để xác
                                định các hướng hợp – khắc.</p>
                            <h4 class="title-tong-quan-h5-log fs-6 fst-italic">
                                2. Sinh Khí, Thiên Y, Diên Niên, Phục Vị
                            </h4>
                            <p class="mb-3">Đây là bốn hướng cát khí quan trọng, mang lại từng ý nghĩa như tài lộc, sức
                                khỏe, hòa thuận hay bình an.
                            </p>
                            <h4 class="title-tong-quan-h5-log fs-6 fst-italic">
                                3. Tuyệt Mệnh, Ngũ Quỷ, Lục Sát, Họa Hại
                            </h4>
                            <p class="mb-3">Bốn hướng xấu thường được công cụ tự động lọc và cảnh báo để người dùng tránh
                                khi bố trí không gian.
                            </p>
                            <h4 class="title-tong-quan-h5-log fs-6 fst-italic">
                                4. Kết hợp mục đích sử dụng
                            </h4>
                            <p class="mb-2">Tùy loại không gian, hướng phù hợp cũng khác nhau:
                            </p>
                            <ul>
                                <li><b>Hướng nhà:</b> ưu tiên Sinh Khí, Thiên Y.</li>
                                <li><b>Hướng bàn thờ:</b> cần tĩnh, hợp mệnh và tránh hướng xấu.</li>
                                <li><b>Hướng bếp:</b> “tọa hung – hướng cát”.</li>
                                <li><b>Phòng ngủ:</b> hợp cung mệnh, tăng năng lượng phục hồi.</li>
                                <li><b>Bàn làm việc:</b> giúp tập trung, thu hút cơ hội và quý nhân.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Tính năng Xem Hướng Hợp Tuổi trên Phong Lịch hoạt động thế nào?
                            </h3>
                            <p>Bạn chỉ cần:</p>
                            <ul style="	list-style-type: decimal;">
                                <li>Chọn mục đích xem hướng: nhà, phòng ngủ, bàn thờ, bếp, bàn làm việc…</li>
                                <li>Nhập năm sinh (âm hoặc dương lịch đều được), sau đó chọn giới tính.</li>
                                <li>
                                    <p>Hệ thống sẽ tự động:</p>
                                    <ul>
                                        <li>Xác định mệnh trạch (Đông – Tây).</li>
                                        <li>Hiển thị hướng cát – hướng hung theo tuổi.</li>
                                        <li>Gợi ý hướng tốt nhất cho từng nhu cầu cụ thể.</li>
                                        <li>Cung cấp giải thích ý nghĩa từng hướng để bạn dễ hiểu hơn.</li>
                                    </ul>
                                </li>
                            </ul>
                            <p class="mb-3">Công cụ được tối ưu để người dùng chỉ mất vài giây là có kết quả rõ ràng và
                                chính xác.</p>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Ai nên sử dụng công cụ xem hướng hợp tuổi?
                            </h3>
                            <ul class="mb-3">
                                <li>Người chuẩn bị xây nhà, mua nhà mới.</li>
                                <li>Gia chủ muốn bố trí lại bếp, phòng ngủ, bàn thờ theo phong thủy.</li>
                                <li>Người mới chuyển công ty, muốn đặt bàn làm việc hợp tuổi để thuận lợi công việc.</li>
                                <li>Người muốn xem hướng tốt theo tuổi để tăng vượng khí, cải thiện sức khỏe – tài lộc.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Lợi ích khi dùng tính năng Xem Hướng Hợp Tuổi tại Phong Lịch
                            </h3>
                            <ul class="mb-3">
                                <li>Không cần kiến thức phong thủy, hệ thống tự giải thích từng hướng.</li>
                                <li>Kết quả rõ ràng, dễ hiểu, phù hợp cho cả người mới tìm hiểu.</li>
                                <li>Áp dụng cho nhiều mục đích, không chỉ xem hướng nhà.</li>
                                <li>Gợi ý chi tiết và các lưu ý phong thủy thực tế.</li>
                                <li>Công cụ hoàn toàn miễn phí, dùng không giới hạn.</li>
                            </ul>
                            <h3 class="title-tong-quan-h4-log fw-bolder">
                                Kết luận
                            </h3>
                            <p class="mb-3">Chọn hướng hợp tuổi là bước quan trọng giúp cân bằng không gian sống và tăng
                                cát khí cho gia chủ. Với tính năng <b>Xem Hướng Hợp Tuổi</b>, bạn có thể dễ dàng tra cứu hướng tốt
                                – xấu cho nhiều mục đích mà không cần tính toán thủ công hay am hiểu sâu về phong thủy.</p>
                        </div>
                    </div>

                </div>
                @include('tools.siderbardetail')
            </div>
        </div>

    </div>
@endsection
