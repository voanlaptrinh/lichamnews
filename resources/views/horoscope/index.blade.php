@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Phong thủy & tử vi <i class="bi bi-chevron-right"></i>
            <span>12 cung hoàng đạo</span>
        </h6>
        <h1 class="content-title-home-lich">Tử Vi 12 Cung Hoàng Đạo</h1>
        <div class="row g-3 mb-4 mt-2">
            @foreach ($zodiacs as $sign => $details)
                <div class="col-lg-3 col-xl-2 col-md-4 col-6">
                    <a href="{{ route('horoscope.show.type', ['signSlug' => $signSlugs[$sign], 'typeSlug' => 'hom-nay']) }}"
                        class="card p-3 h-100 text-decoration-none text-dark zodiac-card text-center shadow-sm zodiac-card-new">

                        <img src="{{ asset($details['icon']) }}?v=1.0" alt="{{ $details['name'] }}" class="icon">
                        <h6 class="card-title mb-0 fw-bold name text-uppercase">{{ $details['name'] }}</h6>
                        <div class="date">
                            {{ $details['date'] }}
                        </div>
                        <div class="read-more-link">
                            Xem thêm
                            <span class="arrow-circle">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </div>

                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
