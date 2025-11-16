@extends('welcome')
@section('content')
    <div class="container-setup">
          <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  Về chúng tôi
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Liên hệ
                </li>
            </ol>
        </nav>
       
        <h1 class="content-title-home-lich">Liên hệ với chúng tôi</h1>
        <div class="text-box-tong-quan mt-3">
            <p>Cảm ơn bạn đã quan tâm và sử dụng <b>Phong Lịch</b> – nền tảng tra cứu <b>Lịch Âm Dương, Lịch Vạn Niên, xem
                    ngày tốt
                    xấu, tử vi và phong thủy</b> dành cho người Việt.</p>
            <p>📧 <b>Email</b>: <a href="mailto:phonglich.com@gmail.com">phonglich.com@gmail.com</a></p>
            <p>Chúng tôi luôn sẵn sàng lắng nghe và phản hồi trong thời gian sớm nhất.
                Sự đóng góp của bạn sẽ giúp <b>Phong Lịch</b> ngày càng hoàn thiện hơn để mang đến những trải nghiệm tốt
                nhất cho người dùng.
            </p>
            <p>
                Trân trọng, <br>
                Đội ngũ <b>Phong Lịch</b>
            </p>
        </div>

    </div>
@endsection
