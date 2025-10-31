@extends('welcome')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.0') }}">
    @endpush



    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="">Tiện ích</a> <i
                class="bi bi-chevron-right"></i> <span>
                Xem ngày tốt xấu</span> <i class="bi bi-chevron-right"></i> <span>
                Chi tiết</span></h6>

        <h1 class="content-title-home-lich">Chi tiết xem ngày tốt xấu</h1>
        <div>
            <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">
                            <div
                                class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> <span>Thông Tin Ngày</span>
                            </div>

                            <div>
                                <span class="" style="font-weight: 600"><span
                                        style="text-transform: capitalize !important;">{{ $commonDayInfo['dayOfWeek'] }}</span>,
                                    {{ $commonDayInfo['dateToCheck']->format('d/m/Y') }}</span> <span
                                    style="color: rgba(34, 84, 171, 1); font-weight: 600;">{{ $commonDayInfo['lunarDateStr'] }}
                                    (AL)</span>
                            </div>
                            <div class="mt-2">
                                @php
                                    $violations = $groomData['score']['checkTabooDays']['issues'] ?? [];
                                    if (is_string($violations)) {
                                        $violations = json_decode($violations, true) ?: [];
                                    }
                                    $validViolations = array_filter($violations);
                                @endphp

                                @if (count($validViolations) > 0)
                                    @foreach ($validViolations as $violation)
                                        <div class="text-dark fw-semibold">
                                            <img src="{{ asset('icons/ping.svg?v=1.0') }}" alt="ping" width="24"
                                                height="24">
                                            <span style="font-weight: 600">Phạm:</span>
                                            {{ $violation['details']['tabooName'] ?? 'Không rõ tên' }}

                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-success">
                                        <i class="bi bi-check-circle-fill"></i> Không phạm
                                    </span>
                                @endif


                            </div>
                            <div class="mt-2 box--house-tot">
                                <div class="d-flex  align-items-center" style="gap: 12px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path
                                            d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                    </svg>
                                    <span style="font-weight: 600"> Giờ tốt:</span>
                                </div>
                                <span>{{ $commonDayInfo['getThongTinNgay']['gio_hoang_dao'] }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">
                            <div
                                class="text-primary mb-2 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                <div>
                                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                        height="28" class="me-1">
                                </div>
                                <div>Các yếu tố</div>
                            </div>
                            <div>
                                <div class="card-body p-0">
                                    <div class="accordion accordion-flush"
                                        id="accordion-{{ Str::slug($groomData['personTitle']) }}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-canchi-{{ Str::slug($groomData['personTitle']) }}">
                                                    Phân tích Can Chi - Vận Khí (Tương tác với tuổi)
                                                </button>
                                            </h2>
                                            <div id="collapse-canchi-{{ Str::slug($groomData['personTitle']) }}"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#accordion-{{ Str::slug($groomData['personTitle']) }}">
                                                <div class="accordion-body">
                                                    <h6><b>* Quan hệ Can chi ngày (nội khí):</b></h6>
                                                    <p>{!! $groomData['noiKhiNgay'] !!}</p>

                                                    <h6><b>* Vận khí ngày & tháng (khí tháng):</b></h6>
                                                    <p>Ngày {{ $groomData['getThongTinCanChiVaIcon']['can_chi_ngay'] }} -
                                                        Tháng
                                                        {{ $groomData['getThongTinCanChiVaIcon']['can_chi_thang'] }}</p>
                                                    {!! $groomData['getVongKhiNgayThang']['analysis'] !!}
                                                    {!! $groomData['getVongKhiNgayThang']['conclusion'] !!}
                                                    <h6><b>Cục khí - hợp xung</b></h6>
                                                    <ul>
                                                        <li>{!! $commonDayInfo['hopxungNgay']['hop'] !!}</li>
                                                        <li>{!! $commonDayInfo['hopxungNgay']['ky'] !!}</li>
                                                    </ul>
                                                    <h6><b>* So sánh ngày với mệnh tuổi của bạn:</b></h6>
                                                    @php $analyze = $groomData['analyzeNgayVoiTuoi']; @endphp
                                                    <ul class="list-unstyled">
                                                        <li><strong>Thiên can:</strong> Can ngày
                                                            <i>{{ $analyze['details']['can']['canNgay'] }}</i>
                                                            và can tuổi <i>{{ $analyze['details']['can']['canTuoi'] }}</i>
                                                            là
                                                            <b>{{ $analyze['details']['can']['relation'] }}</b>
                                                            ({{ $analyze['details']['can']['rating'] }}).
                                                            {{ $analyze['details']['can']['explanation'] }}
                                                        </li>
                                                        <li><strong>Địa chi:</strong> Chi ngày
                                                            <i>{{ $analyze['details']['chi']['chiNgay'] }}</i>
                                                            và chi tuổi <i>{{ $analyze['details']['chi']['chiTuoi'] }}</i>
                                                            là
                                                            <b>{{ $analyze['details']['chi']['relationKey'] }}</b>
                                                            ({{ $analyze['details']['chi']['rating'] }}).
                                                            {{ $analyze['details']['chi']['explanation'] }}
                                                        </li>
                                                        <li><strong>Nạp âm:</strong> Nạp âm ngày
                                                            ({{ $analyze['details']['nap_am']['napAmNgay']['hanh'] }}) và
                                                            nạp âm tuổi
                                                            ({{ $analyze['details']['nap_am']['napAmTuoi']['hanh'] }}) là
                                                            <b>{{ $analyze['details']['nap_am']['relationKey'] }}</b>
                                                            ({{ $analyze['details']['nap_am']['rating'] }}).
                                                            {{ $analyze['details']['nap_am']['explanation'] }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-nhi-thap-bat-tu-{{ Str::slug($groomData['personTitle']) }}">
                                                    Nhị Thập Bát Tú
                                                </button>
                                            </h2>
                                            <div id="collapse-nhi-thap-bat-tu-{{ Str::slug($groomData['personTitle']) }}"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#accordion-{{ Str::slug($groomData['personTitle']) }}">
                                                <div class="accordion-body">
                                                    @php $nhiThapBatTu = $commonDayInfo['nhiThapBatTu']; @endphp
                                                    <p>Ngày này có sao: <b>{{ $nhiThapBatTu['name'] }}
                                                            ({{ $nhiThapBatTu['fullName'] }})</b> -
                                                        Là
                                                        sao <b>{{ $nhiThapBatTu['nature'] }}</b>.</p>
                                                    <p>{{ $nhiThapBatTu['description'] }}</p>
                                                    <p><b>Nên làm:</b> {{ $nhiThapBatTu['guidance']['good'] }}</p>
                                                    @if (!empty($nhiThapBatTu['guidance']['bad']))
                                                        <p><b>Kiêng kỵ:</b> {{ $nhiThapBatTu['guidance']['bad'] }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-thap-nhi-truc-{{ Str::slug($groomData['personTitle']) }}">
                                                    Thập Nhị Trực
                                                </button>
                                            </h2>
                                            <div id="collapse-thap-nhi-truc-{{ Str::slug($groomData['personTitle']) }}"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#accordion-{{ Str::slug($groomData['personTitle']) }}">
                                                <div class="accordion-body">
                                                    @php $getThongTinTruc = $commonDayInfo['getThongTinTruc']; @endphp
                                                    <p><b>Trực ngày: </b>Trực <b>{{ $getThongTinTruc['title'] }}</b> - Là
                                                        trực
                                                        {{ $getThongTinTruc['description']['rating'] }}.</p>
                                                    <p>{{ $getThongTinTruc['description']['description'] }}</p>
                                                    <p><b>Nên làm:</b> {{ $getThongTinTruc['description']['good'] }}</p>
                                                    <p><b>Kiêng kỵ:</b> {{ $getThongTinTruc['description']['bad'] }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-sao-cat-hung-{{ Str::slug($groomData['personTitle']) }}">
                                                    Sao Cát Hung (Ngọc Hạp Thông Thư)
                                                </button>
                                            </h2>
                                            <div id="collapse-sao-cat-hung-{{ Str::slug($groomData['personTitle']) }}"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#accordion-{{ Str::slug($groomData['personTitle']) }}">
                                                <div class="accordion-body">
                                                    @php $getSaoTotXauInfo = $commonDayInfo['getSaoTotXauInfo']; @endphp
                                                    <h6><i class="fas fa-star text-success"></i> Sao tốt:</h6>
                                                    <ul class="list-unstyled ps-3">
                                                        @forelse ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                                            <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}
                                                            </li>
                                                        @empty
                                                            <li>Không có sao tốt nổi bật.</li>
                                                        @endforelse
                                                    </ul>
                                                    <h6 class="mt-3"><i class="fas fa-moon text-danger"></i> Sao xấu:
                                                    </h6>
                                                    <ul class="list-unstyled ps-3">
                                                        @forelse ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                            <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}
                                                            </li>
                                                        @empty
                                                            <li>Không có sao xấu đáng kể.</li>
                                                        @endforelse
                                                    </ul>
                                                    <p class="mt-3 fst-italic">{{ $getSaoTotXauInfo['ket_luan'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
