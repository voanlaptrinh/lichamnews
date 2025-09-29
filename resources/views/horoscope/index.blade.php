@extends('welcome')

@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Phong thủy & tử vi <i class="bi bi-chevron-right"></i>
            <span>12 cung hoàng đạo</span>
        </h6>
        <h1 class="content-title-home-lich">12 cung hoàng đạo</h1>
        <div class="row g-4 mb-4  mt-2">
            @foreach ($zodiacs as $sign => $details)
                <div class="col-6 col-md-4 col-lg-2 d-flex justify-content-center">
                    <a href="{{ route('horoscope.show', ['sign' => $sign]) }}" class="zodiac-card">
                        <img src="{{ $details['icon'] }}" alt="{{ $details['name'] }}" class="img-fluid">

                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
