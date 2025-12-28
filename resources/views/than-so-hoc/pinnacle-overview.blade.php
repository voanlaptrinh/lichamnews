@extends('welcome')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/css/thansohoc.css?v=11.6') }}">
@endpush

<div class="container-setup">
    <nav aria-label="breadcrumb" class="content-title-detail">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Tiện ích</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $title }}
            </li>
        </ol>
    </nav>

    <h1 class="content-title-home-lich">{{ $title }}</h1>

    <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
        <div class="col-xl-9 col-sm-12 col-12">
            {{-- User Info Box --}}
            <div class="box--bg-thang mb-3" style="border: unset">
                <div class="text-box-tong-quan">
                    <div class="d-flex gap-2" style="align-items: center;">
                        <div>
                            <img src="{{ asset('images/avt_defund.svg') }}" alt="avt_defund" class="img-avt-defund">
                        </div>
                        <div style="font-weight: 700">
                            <p class="mb-1">Ngày sinh: {{ $birthDate['day'] }}/{{ $birthDate['month'] }}/{{ $birthDate['year'] }}</p>
                            <p class="mb-1">
                                <strong>Tuổi hiện tại:</strong> {{ $data['current_age'] }} tuổi |
                                <strong>Đỉnh cao hiện tại:</strong> Đỉnh cao {{ $data['current_pinnacle'] }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <p class="pb-0" style="font-style: italic;">📊 <strong>Cách tính:</strong> {{ $data['calculation'] }}</p>
                </div>
            </div>

            {{-- All 4 Pinnacles --}}
            <div class="box--bg-thang mb-3" style="border: unset">
                <div class="text-box-tong-quan">
                    <div class="tt--giaima">
                        4 Đỉnh Cao Cuộc Đời
                    </div>

                    <div class="row g-3 mt-3">
                        {{-- @dd($data['pinnacles']) --}}
                        @foreach($data['pinnacles'] as $index => $pinnacle)
                            @php
                                $isActive = $data['current_pinnacle'] == ($index + 1);
                                $cardClass = $isActive ? 'pinnacle-card active-pinnacle' : 'pinnacle-card';
                            @endphp

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="{{ $cardClass }}">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="number-circle me-3"
                                             style="background: {{ $isActive ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #6f42c1, #e83e8c)' }}">
                                            <span class="number-text text-white">{{ $pinnacle['number'] }}</span>
                                        </div>
                                        <div>
                                            <h4 class="mb-1"><strong>Đỉnh Cao {{ $index + 1 }}</strong></h4>
                                            <p class="mb-0 text-muted">{{ $pinnacle['phase'] }}</p>
                                        </div>
                                        @if($isActive)
                                            <span class="badge bg-success ms-auto">Hiện tại</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark">
                                            🎂 {{ $pinnacle['age_range'] }}
                                        </span>
                                    </div>

                                    @if(isset($pinnacle['interpretation']))
                                        <div class="interpretation-content">
                                            <div class="mb-3">
                                                <h6 class="fw-bold text-primary">{{ $pinnacle['interpretation']['subtitle'] ?? $pinnacle['interpretation']['title'] }}</h6>
                                            </div>

                                            <div class="mb-2">
                                                <p class="small text-muted" style="text-align: justify; line-height: 1.6;">
                                                    {{ $pinnacle['interpretation']['content'] ?? 'Thông tin đang được cập nhật' }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="small text-muted fst-italic">
                                            Thông tin chi tiết cho số {{ $pinnacle['number'] }} đang được cập nhật...
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Life Journey Timeline --}}
            <div class="box--bg-thang mb-3" style="border: unset">
                <div class="text-box-tong-quan">
                    <div class="tt--giaima">
                        🌟 Hành Trình Cuộc Đời
                    </div>

                    <div class="row g-3 mt-3 text-center">
                        @foreach($data['pinnacles'] as $index => $pinnacle)
                            @php $isActive = $data['current_pinnacle'] == ($index + 1); @endphp
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="journey-step {{ $isActive ? 'active-step' : '' }}">
                                    <div class="journey-circle {{ $isActive ? 'active-circle' : '' }}">
                                        {{ $pinnacle['number'] }}
                                    </div>
                                    <h6 class="mt-2">{{ $pinnacle['phase'] }}</h6>
                                    <p class="small text-muted">{{ $pinnacle['age_range'] }}</p>
                                    @if($isActive)
                                        <p class="small text-success fw-bold">● Giai đoạn hiện tại</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Current Focus --}}
            @php $currentPinnacleData = $data['pinnacles'][$data['current_pinnacle'] - 1] @endphp
            <div class="box--bg-thang mb-3" style="border: unset; border-left: 4px solid #28a745 !important;">
                <div class="text-box-tong-quan">
                    <div class="tt--giaima text-success">
                        🎯 Tập Trung Hiện Tại - Đỉnh Cao {{ $data['current_pinnacle'] }}
                    </div>

                    <div class="d-flex align-items-start mt-3">
                        <div class="current-pinnacle-circle me-3">
                            {{ $currentPinnacleData['number'] }}
                        </div>
                        <div>
                            <h4 class="text-success">{{ $currentPinnacleData['phase'] }}</h4>
                            <p class="mb-2"><strong>Độ tuổi:</strong> {{ $currentPinnacleData['age_range'] }}</p>
                            @if(isset($currentPinnacleData['interpretation']['subtitle']))
                                <h6 class="text-success fw-bold mb-2">{{ $currentPinnacleData['interpretation']['subtitle'] }}</h6>
                            @endif
                            @if(isset($currentPinnacleData['interpretation']['content']))
                                <p class="text-success small" style="text-align: justify; line-height: 1.5;">
                                    {{ Str::limit($currentPinnacleData['interpretation']['content'], 300) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="box--bg-thang mb-3" style="border: unset">
                <div class="text-box-tong-quan text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                        ← Quay lại
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        🖨️ In kết quả
                    </button>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-xl-3 col-sm-12 col-12">
            <div class="box--bg-thang">
                <div class="text-box-tong-quan">
                    <div class="tt--giaima">
                        Thông tin thêm
                    </div>
                    <div class="mt-3">
                        <p class="small">Đỉnh cao cuộc đời thể hiện những giai đoạn quan trọng trong hành trình phát triển của bạn.</p>
                        <p class="small">Mỗi đỉnh cao mang những đặc điểm, cơ hội và thách thức riêng biệt.</p>
                        <p class="small">Hiểu rõ đỉnh cao hiện tại sẽ giúp bạn tận dụng tối đa tiềm năng của mình.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pinnacle-card {
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #fff;
    transition: all 0.3s ease;
}

.pinnacle-card.active-pinnacle {
    border-color: #28a745;
    background: #f8fff9;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
}

.journey-step {
    padding: 15px;
}

.journey-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6c757d, #adb5bd);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.journey-circle.active-circle {
    background: linear-gradient(135deg, #28a745, #20c997);
    ring: 4px solid #28a74520;
    transform: scale(1.1);
}

.current-pinnacle-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
    flex-shrink: 0;
}

.interpretation-content {
    max-height: 300px;
    overflow-y: auto;
}

@media print {
    .no-print { display: none !important; }
    body { font-size: 12px; }
    .container-setup { max-width: 100% !important; padding: 0 !important; }
}
</style>

@endsection