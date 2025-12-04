@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.0') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('totxau.list') }}" style="color: #2254AB; text-decoration: underline;">Xem ngày
                        tốt</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Xem ngày dạm ngõ
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Chi tiết
                </li>
            </ol>
        </nav>
        <h1 class="content-title-home-lich">Chi tiết xem dạm ngõ</h1>
        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
                <div class="col-xl-9 col-sm-12 col-12 ">

                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">
                            <div class="box-title-goback">
                                <div
                                    class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                        height="28" class="me-1"> <span>Thông Tin Ngày</span>
                                </div>
                                <div class="mb-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm" id="backToListBtn"
                                        onclick="goBackToForm()">
                                        <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách ngày
                                    </a>
                                </div>
                            </div>

                            <div>
                                <table class="table table-detail" style="table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span style="font-weight: 600">Ngày Dương lịch:</span>
                                                {{ $commonDayInfo['dateToCheck']->format('d/m/Y') }}
                                                (<span
                                                    style="text-transform:capitalize;">{{ $commonDayInfo['dayOfWeek'] }}</span>)
                                            </td>
                                            <td>
                                                <span style="font-weight: 600">Ngày Âm lịch:</span>
                                                {{ $commonDayInfo['al'][0] }}/{{ $commonDayInfo['al'][1] }}/{{ $commonDayInfo['al'][2] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="font-weight: 600">Nạp Âm:</span>
                                                {{ $commonDayInfo['getThongTinNgay']['nap_am']['napAm'] ?? '' }} (Hành
                                                {{ $commonDayInfo['getThongTinNgay']['nap_am']['napAmHanh'] ?? '' }})
                                            </td>
                                            <td>
                                                <span style="font-weight: 600">Ngày can chi:</span> Ngày
                                                {{ $commonDayInfo['can_chi_ngay'] }}, tháng
                                                {{ $commonDayInfo['can_chi_thang'] }}, năm
                                                {{ $commonDayInfo['can_chi_nam'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="font-weight: 600">Giờ hoàng đạo:</span>
                                                {{ $commonDayInfo['getThongTinNgay']['gio_hoang_dao'] ?? '' }}
                                            </td>
                                            <td>
                                                <span style="font-weight: 600">Giờ hắc đạo:</span>
                                                {{ $commonDayInfo['getThongTinNgay']['gio_hac_dao'] ?? '' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <ul class="nav nav-tabs nav-fill mb-3 h5" id="personTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="groom-tab" data-bs-toggle="tab"
                                data-bs-target="#groom-tab-pane" type="button" role="tab"
                                aria-controls="groom-tab-pane" aria-selected="true">
                                <i class="fas fa-male me-2"></i> Luận Giải cho Chú Rể
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bride-tab" data-bs-toggle="tab" data-bs-target="#bride-tab-pane"
                                type="button" role="tab" aria-controls="bride-tab-pane" aria-selected="false">
                                <i class="fas fa-female me-2"></i> Luận Giải cho Cô Dâu
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="personTabContent">
                        {{-- TAB CỦA CHÚ RỂ --}}
                        <div class="tab-pane fade show active" id="groom-tab-pane" role="tabpanel"
                            aria-labelledby="groom-tab" tabindex="0">

                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    <div
                                        class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                        <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem"
                                            width="28" height="28" class="me-1"> <span>Thông Tin Chú Rể</span>
                                    </div>

                                    <div>
                                        <div class="row g-0 table rounded overflow-hidden analysis-box">

                                            <!-- Cột 1: Yếu tố hỗ trợ (Tốt) -->
                                            <div class="col-6 d-flex flex-column">
                                                <!-- Header (Màu Xanh) -->
                                                <div class="p-3 header-green">
                                                    <div class="mb-0 fw-bold">
                                                        Các yếu tố tốt hỗ trợ cho ngày
                                                    </div>
                                                </div>
                                                @php
                                                    $hopTuoi = $groomData['score']['hopttuoi'] ?? null;
                                                    $hopTuoiReason = $groomData['score']['hopTuoiReason'] ?? '';

                                                    $tabooIssues = collect($groomData['score']['issues'] ?? [])->filter(
                                                        fn($issue) => ($issue['source'] ?? '') === 'Taboo',
                                                    );
                                                    $names = $tabooIssues
                                                        ->map(fn($issue) => $issue['details']['tabooName'] ?? '')
                                                        ->filter()
                                                        ->implode(', ');
                                                @endphp
                                                <!-- Nội dung (Màu Xanh Nhạt) -->
                                                <div class="p-2 content-green flex-grow-1">
                                                    <ul class="list-unstyled mb-0">
                                                        @if ($hopTuoi)
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Ngày hợp tuổi:
                                                                    {{ $hopTuoiReason }}</span>
                                                            </li>
                                                        @endif
                                                        @if ($groomData['score']['tu']['details']['data']['nature'] == 'Tốt')
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Nhị thập bát tú: Sao
                                                                    {{ $groomData['score']['tu']['details']['data']['name'] }}
                                                                    (Tốt)</span>
                                                            </li>
                                                        @endif
                                                        @if ($groomData['score']['tructot'])
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Thập Nhị Trực
                                                                    {{ $groomData['score']['truc']['details']['name'] }}
                                                                    (Tốt)
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (!empty($groomData['score']['catHung']['details']['catStars']))
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark"> Sao tốt theo Ngọc Hạp Thông Thư:
                                                                    @foreach ($groomData['score']['catHung']['details']['catStars'] as $index => $sao)
                                                                        <span
                                                                            class=" bg-success">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                                    @endforeach
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Cột 2: Yếu tố cản trở (Xấu) -->
                                            <div class="col-6 d-flex flex-column">
                                                <!-- Header (Màu Đỏ) -->
                                                <div class="p-3 header-red border-start">
                                                    <div class="mb-0 fw-bold text-danger">
                                                        Các yếu tố xấu/ cản trở cần xem xét
                                                    </div>
                                                </div>

                                                <!-- Nội dung (Trắng/Đỏ Nhạt) -->
                                                <div class="p-2 content-red flex-grow-1 border-start">
                                                    <ul class="list-unstyled mb-0">
                                                        <!-- Các yếu tố Cảnh báo (Tam Nương, Kim Thần Thất Sát) -->
                                                        @if ($tabooIssues->isNotEmpty())
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->

                                                                <span class="text-dark">
                                                                    {{ $names ? '⚠️ Phạm: ' . $names : '' }}</span>
                                                            </li>
                                                        @endif
                                                        @if (!$groomData['score']['hopttuoi'] && $groomData['score']['hopTuoiReason'] != 'Ngày bình thường')
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->
                                                                ❌ Ngày kỵ tuổi:
                                                                {{ $groomData['score']['hopTuoiReason'] ?? 'Không hợp tuổi' }}
                                                            </li>
                                                        @endif
                                                        @if ($groomData['score']['tu']['details']['data']['nature'] == 'Xấu')
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->
                                                                ❌ Nhị thập bát tú: Sao
                                                                {{ $groomData['score']['tu']['details']['data']['name'] }}
                                                                (Xấu)
                                                            </li>
                                                        @endif
                                                        @if ($groomData['score']['trucxau'])
                                                            <li class="mb-3">
                                                                ❌ Thập Nhị Trực
                                                                {{ $groomData['score']['truc']['details']['name'] }}
                                                                (Xấu)</li>
                                                        @endif
                                                        @if (!empty($groomData['score']['catHung']['details']['hungStars']))
                                                            <li class="mb-3">
                                                                ❌ Sao xấu theo Ngọc Hạp Thông Thư:
                                                                @foreach ($groomData['score']['catHung']['details']['hungStars'] as $sao)
                                                                    <span
                                                                        class=" bg-danger">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                                @endforeach
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    <div
                                        class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                        <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem"
                                            width="28" height="28" class="me-1"> <span>Đánh giá điểm các yếu tố
                                            ngày cho tuổi
                                            {{ $groomData['personInfo']['can_chi_nam'] }}
                                            ({{ $groomData['personInfo']['dob']->format('d-m-Y') }}) chú rể:
                                            {{ round($groomData['score']['percentage']) }}/100
                                            ({{ round($groomData['score']['percentage']) }}%)</span>
                                    </div>
                                    <div>

                                        <table class="table table-detail" style="table-layout: fixed;">
                                            <tbody>
                                                <tr style="font-weight: 600">
                                                    <td>Yếu tố đánh giá</td>

                                                    <td>Điểm đánh giá</td>
                                                    <td>Trọng số</td>
                                                </tr>
                                                @php
                                                    $weights =
                                                        \App\Helpers\DataHelper::$PURPOSE_WEIGHTS_PERSONALIZED[
                                                            'CUOI_HOI'
                                                        ];
                                                    $totalWeight = array_sum($weights);
                                                @endphp
                                                <tr>
                                                    <td>Can chi - vận khí ngày so với tuổi</td>
                                                    <td>{{ round($groomData['score']['vanKhi']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['VanKhi'] ?? 0) / $totalWeight) * 100) }}%
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Nhị Thập Bát Tú</td>
                                                    <td>{{ round($groomData['score']['tu']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['28Tu'] ?? 0) / $totalWeight) * 100) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>Thập Nhị Trực</td>
                                                    <td>{{ round($groomData['score']['truc']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['12Truc'] ?? 0) / $totalWeight) * 100) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>Sao Cát Hung - Ngọc Hạp Thông Thư</td>
                                                    <td>{{ round($groomData['score']['catHung']['percentage'] ?? 0) }}%
                                                    </td>
                                                    <td>
                                                        {{ round((($weights['CatHung'] ?? 0) / $totalWeight) * 100) }}%
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    @include('tools.dam-ngo.person_analysis_accordion', [
                                        'personData' => $groomData,
                                        'commonData' => $commonDayInfo,
                                    ])

                                </div>
                            </div>
                        </div>

                        {{-- TAB CỦA CÔ DÂU --}}
                        <div class="tab-pane fade" id="bride-tab-pane" role="tabpanel" aria-labelledby="bride-tab"
                            tabindex="0">

                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    <div
                                        class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                        <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem"
                                            width="28" height="28" class="me-1"> <span>Thông Tin Cô Dâu</span>
                                    </div>

                                    <div>
                                        <div class="row g-0 table rounded overflow-hidden analysis-box">

                                            <!-- Cột 1: Yếu tố hỗ trợ (Tốt) -->
                                            <div class="col-6 d-flex flex-column">
                                                <!-- Header (Màu Xanh) -->
                                                <div class="p-3 header-green">
                                                    <div class="mb-0 fw-bold">
                                                        Các yếu tố tốt hỗ trợ cho ngày
                                                    </div>
                                                </div>
                                                @php
                                                    $hopTuoi = $brideData['score']['hopttuoi'] ?? null;
                                                    $hopTuoiReason = $brideData['score']['hopTuoiReason'] ?? '';

                                                    $tabooIssues = collect($brideData['score']['issues'] ?? [])->filter(
                                                        fn($issue) => ($issue['source'] ?? '') === 'Taboo',
                                                    );
                                                    $names = $tabooIssues
                                                        ->map(fn($issue) => $issue['details']['tabooName'] ?? '')
                                                        ->filter()
                                                        ->implode(', ');
                                                @endphp
                                                <!-- Nội dung (Màu Xanh Nhạt) -->
                                                <div class="p-2 content-green flex-grow-1">
                                                    <ul class="list-unstyled mb-0">
                                                        @if ($hopTuoi)
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Ngày hợp tuổi:
                                                                    {{ $hopTuoiReason }}</span>
                                                            </li>
                                                        @endif
                                                        @if ($brideData['score']['tu']['details']['data']['nature'] == 'Tốt')
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Nhị thập bát tú: Sao
                                                                    {{ $brideData['score']['tu']['details']['data']['name'] }}
                                                                    (Tốt)</span>
                                                            </li>
                                                        @endif
                                                        @if ($brideData['score']['tructot'])
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark">Thập Nhị Trực
                                                                    {{ $brideData['score']['truc']['details']['name'] }}
                                                                    (Tốt)
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if (!empty($brideData['score']['catHung']['details']['catStars']))
                                                            <li class="mb-3">
                                                                <span class="text-success fw-bold list-icon">✓</span>
                                                                <span class="text-dark"> Sao tốt theo Ngọc Hạp Thông Thư:
                                                                    @foreach ($brideData['score']['catHung']['details']['catStars'] as $index => $sao)
                                                                        <span
                                                                            class=" bg-success">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                                    @endforeach
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Cột 2: Yếu tố cản trở (Xấu) -->
                                            <div class="col-6 d-flex flex-column">
                                                <!-- Header (Màu Đỏ) -->
                                                <div class="p-3 header-red border-start">
                                                    <div class="mb-0 fw-bold text-danger">
                                                        Các yếu tố xấu/ cản trở cần xem xét
                                                    </div>
                                                </div>

                                                <!-- Nội dung (Trắng/Đỏ Nhạt) -->
                                                <div class="p-2 content-red flex-grow-1 border-start">
                                                    <ul class="list-unstyled mb-0">
                                                        <!-- Các yếu tố Cảnh báo (Tam Nương, Kim Thần Thất Sát) -->
                                                        @if ($tabooIssues->isNotEmpty())
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->

                                                                <span class="text-dark">
                                                                    {{ $names ? '⚠️ Phạm: ' . $names : '' }}</span>
                                                            </li>
                                                        @endif
                                                        @if (!$brideData['score']['hopttuoi'] && $brideData['score']['hopTuoiReason'] != 'Ngày bình thường')
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->
                                                                ❌ Ngày kỵ tuổi:
                                                                {{ $brideData['score']['hopTuoiReason'] ?? 'Không hợp tuổi' }}
                                                            </li>
                                                        @endif
                                                        @if ($brideData['score']['tu']['details']['data']['nature'] == 'Xấu')
                                                            <li class="mb-3">
                                                                <!-- Dùng icon tam giác cảnh báo màu cam -->
                                                                ❌ Nhị thập bát tú: Sao
                                                                {{ $brideData['score']['tu']['details']['data']['name'] }}
                                                                (Xấu)
                                                            </li>
                                                        @endif
                                                        @if ($brideData['score']['trucxau'])
                                                            <li class="mb-3">
                                                                ❌ Thập Nhị Trực
                                                                {{ $brideData['score']['truc']['details']['name'] }}
                                                                (Xấu)</li>
                                                        @endif
                                                        @if (!empty($brideData['score']['catHung']['details']['hungStars']))
                                                            <li class="mb-3">
                                                                ❌ Sao xấu theo Ngọc Hạp Thông Thư:
                                                                @foreach ($brideData['score']['catHung']['details']['hungStars'] as $sao)
                                                                    <span
                                                                        class=" bg-danger">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                                @endforeach
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    <div
                                        class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                        <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem"
                                            width="28" height="28" class="me-1"> <span>Đánh giá điểm các yếu tố
                                            ngày cho tuổi
                                            {{ $brideData['personInfo']['can_chi_nam'] }}
                                            ({{ $brideData['personInfo']['dob']->format('d-m-Y') }}) cô dâu:
                                            {{ round($brideData['score']['percentage']) }}/100
                                            ({{ round($brideData['score']['percentage']) }}%)</span>
                                    </div>
                                    <div>
                                        <table class="table table-detail" style="table-layout: fixed;">
                                            <tbody>
                                                <tr style="font-weight: 600">
                                                    <td>Yếu tố đánh giá</td>

                                                    <td>Điểm đánh giá</td>
                                                    <td>Trọng số</td>
                                                </tr>

                                                <tr>
                                                    <td>Nhị thập bát tú</td>
                                                    <td>{{ round($brideData['score']['tu']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['28Tu'] ?? 0) / $totalWeight) * 100) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>Thập Nhị Trực</td>
                                                    <td>{{ round($brideData['score']['truc']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['12Truc'] ?? 0) / $totalWeight) * 100) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>Cát Hung (Sao tốt xấu)</td>
                                                    <td>{{ round($brideData['score']['catHung']['percentage'] ?? 0) }}%
                                                    </td>
                                                    <td>
                                                        {{ round((($weights['CatHung'] ?? 0) / $totalWeight) * 100) }}%
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Văn Khí (Can Chi vận khí)</td>
                                                    <td>{{ round($brideData['score']['vanKhi']['percentage'] ?? 0) }}%</td>
                                                    <td>
                                                        {{ round((($weights['VanKhi'] ?? 0) / $totalWeight) * 100) }}%
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 mb-3 w-100 box-detial-year">
                                <div class="card-body box1-con-year">
                                    @include('tools.dam-ngo.person_analysis_accordion', [
                                        'personData' => $brideData,
                                        'commonData' => $commonDayInfo,
                                    ])

                                </div>
                            </div>
                        </div>
                        <div class="card border-0 mb-3 w-100 box-detial-year">
                            <div class="card-body box1-con-year">
                                <div class="text-primary mb-2  text-dark d-flex align-items-center">
                                    ⚠️ Chú ý: Đây là các thông tin xem mang tính chất tham khảo, không thay thế cho các tư vấn
                                    chuyên môn. Người dùng tự chịu trách nhiệm với mọi quyết định cá nhân dựa trên thông tin
                                    tham khảo tại Phong Lịch.
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                @include('tools.siderbardetail')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function goBackToForm() {
            // Get current URL parameters to extract groom, bride and date range info
            const urlParams = new URLSearchParams(window.location.search);
            const groomDob = urlParams.get('groom_dob');
            const brideDob = urlParams.get('bride_dob');
            const dateRange = urlParams.get('khoang');

            // Build the target URL with hash parameters
            let targetUrl = '{{ route('astrology.form') }}';
            const hashParams = [];

            // Add groom to hash if available
            if (groomDob) {
                // Convert Y-m-d format to d/m/Y format for the form
                const dateParts = groomDob.split('-');
                if (dateParts.length === 3) {
                    const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                    hashParams.push(`groom=${encodeURIComponent(formattedDate)}`);
                }
            }

            // Add bride to hash if available
            if (brideDob) {
                // Convert Y-m-d format to d/m/Y format for the form
                const dateParts = brideDob.split('-');
                if (dateParts.length === 3) {
                    const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                    hashParams.push(`bride=${encodeURIComponent(formattedDate)}`);
                }
            }

            // Add date range to hash if available
            if (dateRange) {
                hashParams.push(`khoang=${encodeURIComponent(dateRange)}`);
            }

            // Add calendar_type to hash if available
            const calendarType = urlParams.get('calendar_type');
            if (calendarType) {
                hashParams.push(`calendar_type=${encodeURIComponent(calendarType)}`);
            }

            // Build final URL with hash
            if (hashParams.length > 0) {
                targetUrl += `#${hashParams.join('&')}`;
            }

            // Redirect to the form page
            window.location.href = targetUrl;
        }
    </script>
@endpush
