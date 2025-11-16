@extends('welcome')

@section('content')
    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Cung hoàng đạo
                </li>
            </ol>
        </nav>

        <h1 class="content-title-home-lich">Tử Vi 12 Cung Hoàng Đạo</h1>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="box-cart-index-cung box-caro-cung-mb">
                    <div>
                        <h2 class="title-tong-quan-h2-log">Danh sách 12 cung Hoàng Đạo và ngày sinh tương ứng</h2>
                        <p>Khám phá tử vi 12 cung Hoàng đạo với những dự đoán chi tiết về tình yêu, công việc, tài lộc và
                            sức khỏe.
                            Hãy
                            chọn cung Hoàng đạo của bạn để xem chi tiết ngay hôm nay!</p>
                    </div>
                    <div class="row g-3 mb-4 mt-2">
                        @foreach ($zodiacs as $sign => $details)
                            <div class="col-lg-4 col-xl-3 col-md-4 col-6">
                                <a href="{{ route('horoscope.show.type', ['signSlug' => $signSlugs[$sign], 'typeSlug' => 'hom-nay']) }}"
                                    class="card p-3 h-100 text-decoration-none text-dark zodiac-card text-center shadow-sm zodiac-card-new">

                                    <img src="{{ asset($details['icon']) }}?v=1.0" alt="{{ $details['name'] }}"
                                        class="icon">
                                    <div class="fs-6 card-title mb-0 fw-bold name text-uppercase">{{ $details['name'] }}
                                    </div>
                                    <div class="date">
                                        {{ $details['date'] }}
                                    </div>
                                    <div class="read-more-link">
                                        Hôm nay
                                        <span class="arrow-circle">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-box-tong-quan box-cart-index-cung">
                    <h2 class="title-tong-quan-h3">Ý nghĩa và giá trị của 12 cung Hoàng đạo trong cuộc sống hiện đại</h2>
                    <div>
                        12 cung Hoàng đạo hay còn gọi là 12 chòm sao, vốn xuất phát từ chiêm tinh học phương Tây, nhưng ngày
                        nay đã
                        trở nên quen thuộc và được nhiều người trên thế giới, trong đó có Việt Nam, quan tâm và tìm hiểu.
                        Mỗi cung
                        Hoàng đạo tương ứng với một khoảng thời gian trong năm, gắn liền với một biểu tượng riêng, một hành
                        tinh
                        chiếu mệnh và một nguyên tố (Lửa, Nước, Đất, Khí). Chính vì vậy, các cung Hoàng đạo được cho là phản
                        ánh
                        phần nào tính cách, xu hướng hành động và vận mệnh của mỗi người.

                    </div>
                    <div class="mt-3">
                        <h3 class="title-tong-quan-h4" style="font-weight: unset">12 cung Hoàng đạo và tính cách đặc trưng
                        </h3>
                        <ul>
                            <li><b>Bạch Dương:</b> Mạnh mẽ, quyết đoán, thích tiên phong.</li>
                            <li><b>Kim Ngưu:</b> Ổn định, kiên định và thực tế.</li>
                            <li><b>Song Tử:</b> Linh hoạt, thông minh, dễ thay đổi.</li>
                            <li><b>Cự Giải:</b> Tình cảm, nhạy cảm, sống thiên về gia đình.</li>
                            <li><b>Sư Tử:</b> Tự tin, hào phóng, thích nổi bật.</li>
                            <li><b>Xử Nữ:</b> Tỉ mỉ, cầu toàn, giàu lý trí.</li>
                            <li><b>Thiên Bình:</b> Công bằng, giỏi ngoại giao, yêu cái đẹp.</li>
                            <li><b>Bọ Cạp:</b> Bí ẩn, quyết liệt, có trực giác mạnh mẽ.</li>
                            <li><b>Nhân Mã:</b> Tự do, phóng khoáng, yêu phiêu lưu.</li>
                            <li><b>Ma Kết:</b> Nghiêm túc, kỷ luật, tham vọng.</li>
                            <li><b>Bảo Bình:</b> Sáng tạo, độc lập, khác biệt.</li>
                            <li><b>Song Ngư:</b> Lãng mạn, giàu trí tưởng tượng, giàu lòng nhân ái.</li>
                        </ul>
                    </div>
                    <div class="mt-3">
                        <h3 class="title-tong-quan-h4" style="font-weight: unset">Xem tử vi 12 cung Hoàng đạo để làm gì?
                        </h3>
                        <div>
                            Không chỉ đơn thuần là sự tò mò, tử vi 12 cung Hoàng đạo mang lại cho bạn nhiều góc nhìn hữu
                            ích:
                        </div>
                        <ul>
                            <li>Nắm bắt vận trình <b>tình duyên, công việc, tài chính, sức khỏe</b> theo từng ngày, từng
                                tuần, từng
                                tháng hoặc cả năm.</li>
                            <li>Biết cách lựa chọn thời điểm thuận lợi để tiến hành những việc quan trọng như khởi sự kinh
                                doanh,
                                thay đổi công việc hay bắt đầu mối quan hệ mới.</li>
                            <li>Tự nhận thức rõ điểm mạnh, điểm yếu của bản thân để định hướng phát triển cá nhân.</li>
                            <li>Hiểu thêm về bạn bè, người thân hoặc đối tác thông qua cung Hoàng đạo của họ, từ đó dễ dàng
                                xây dựng
                                các mối quan hệ bền vững.</li>
                        </ul>
                    </div>
                    <div class="mt-3">
                        <h3 class="title-tong-quan-h4" style="font-weight: unset">Ứng dụng của cung Hoàng đạo trong đời sống
                        </h3>
                        <div>
                            Trong xã hội hiện đại, nhiều người trẻ sử dụng tử vi 12 cung Hoàng đạo như một công cụ tham khảo
                            để:
                        </div>
                        <ul>
                            <li>Chọn ngày phù hợp cho hẹn hò, gặp gỡ bạn bè hoặc đối tác.
                            </li>
                            <li>Đọc dự đoán công việc, sự nghiệp để có thêm động lực hoặc định hướng mới.
                            </li>
                            <li>Tham khảo lời khuyên về tài chính để quản lý chi tiêu và đầu tư hợp lý hơn.
                            </li>
                            <li>Tìm hiểu sự tương hợp giữa các cung Hoàng đạo để duy trì và phát triển tình yêu, tình bạn.
                            </li>
                        </ul>
                    </div>
                    <div class="mt-3 mb-3">
                        <h3 class="title-tong-quan-h4" style="font-weight: unset">Tại sao nên theo dõi tử vi 12 cung Hoàng
                            đạo tại
                            Phong Lịch?
                        </h3>
                        <div>
                            Phong Lịch mang đến nội dung tử vi được cập nhật hàng ngày, hàng tuần, hàng tháng và cả năm cho
                            12 cung
                            Hoàng đạo. Các thông tin được trình bày rõ ràng, dễ hiểu, vừa mang tính tham khảo, vừa có giá
                            trị định
                            hướng cho bạn trong cuộc sống.

                        </div>

                    </div>
                </div>
            </div>
            @include('horoscope.box-right')
        </div>

    </div>
@endsection
