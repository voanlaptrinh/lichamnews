@extends('welcome')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=10.7') }}">
    @endpush



    <div class="container-setup">

        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="color: #2254AB; text-decoration: underline;" href="">Tiện ích</a> <i
                class="bi bi-chevron-right"></i> <span>
                Xem ngày động thổ</span> <i class="bi bi-chevron-right"></i> <span>
                Chi tiết</span></div>

        <h1 class="content-title-home-lich">Chi tiết xem ngày động thổ</h1>

        <!-- Nút quay lại -->


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
                        {{-- @dd($groomData) --}}
                    </div>
                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">

                            <div>
                                <table class="table table-detail" style="table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600">
                                                Các yếu tố tốt hỗ trợ cho ngày
                                            </td>
                                            <td style="font-weight: 600">
                                                Các yếu tố xấu/ cản trở cần xem xét
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                                $hopTuoi = $groomData['score']['hopttuoi'] ?? null;
                                                $hopTuoiReason = $groomData['score']['hopTuoiReason'] ?? '';
                                                $tabooIssues = collect($tabooResult['issues'] ?? [])
                                                    ->filter()
                                                    ->map(
                                                        fn($day) => 'Phạm Ngày ' . ($day['details']['tabooName'] ?? ''),
                                                    )
                                                    ->implode(', ');
                                            @endphp

                                            @if ($hopTuoi || $tabooIssues)
                                        <tr>
                                            <td>
                                                @if ($hopTuoi)
                                                    ✓ Ngày hợp tuổi: {{ $hopTuoiReason }}
                                                @endif
                                            </td>
                                            <td>

                                                @if ($tabooIssues)
                                                    {{ $tabooIssues }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif


                                        </tr>
                                        @if (!$groomData['score']['hopttuoi'])
                                            <tr>
                                                <td></td>
                                                <td>
                                                    ❌ Ngày kỵ tuổi:
                                                    {{ $groomData['score']['hopTuoiReason'] ?? 'Không hợp tuổi' }}
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>
                                                @if ($groomData['score']['tu']['details']['data']['nature'] == 'Tốt')
                                                    Nhị thập bát tú: Sao
                                                    {{ $groomData['score']['tu']['details']['data']['name'] }} (Tốt)
                                                @endif
                                            </td>
                                            <td>
                                                @if ($groomData['score']['tu']['details']['data']['nature'] == 'Xấu')
                                                    Nhị thập bát tú: Sao
                                                    {{ $groomData['score']['tu']['details']['data']['name'] }} (Xấu)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if ($groomData['score']['tructot'])
                                                    Thập Nhị Trực {{ $groomData['score']['truc']['details']['name'] }}
                                                    (Tốt)
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$groomData['score']['tructot'])
                                                    Thập Nhị Trực {{ $groomData['score']['truc']['details']['name'] }}
                                                    (Xấu)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (!empty($groomData['score']['catHung']['details']['catStars']))
                                                    <strong>Sao tốt theo Ngọc Hạp Thông Thư:</strong>
                                                    @foreach ($groomData['score']['catHung']['details']['catStars'] as $index => $sao)
                                                        <span
                                                            class=" bg-success ">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($groomData['score']['catHung']['details']['hungStars']))
                                                    <strong>Sao xấu theo Ngọc Hạp Thông Thư:</strong>
                                                    @foreach ($groomData['score']['catHung']['details']['hungStars'] as $sao)
                                                        <span
                                                            class=" bg-danger">{{ $sao['name'] }}</span>{{ $loop->last ? '' : ',' }}
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>




                        </div>

                    </div>

                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">
                            <div
                                class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> <span>Đánh giá cho điểm các yếu tố ngày cho tuổi
                                    {{ $groomData['personInfo']['can_chi_nam'] }}
                                    ({{ $groomData['personInfo']['dob']->format('d-m-Y') }}) động thổ:
                                    {{ round($groomData['score']['percentage']) }}/100
                                    ({{ round($groomData['score']['percentage']) }}%)</span>
                            </div>
                            <div>
                                <table class="table table-detail" style="table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Yếu tố đánh giá
                                            </td>
                                            <td>
                                                Điểm đánh giá
                                            </td>
                                            <td>
                                                Trọng số
                                            </td>
                                        </tr>
                                        @php
                                            $weights =
                                                \App\Helpers\DataHelper::$PURPOSE_WEIGHTS_PERSONALIZED['DONG_THO'];
                                            $totalWeight = array_sum($weights);
                                        @endphp
                                        <tr>
                                            <td>Can chi - vận khí ngày so với tuổi</td>
                                            <td>{{ round($groomData['score']['vanKhi']['percentage']) }}/100
                                            </td>
                                            <td>{{ round(($weights['VanKhi'] / $totalWeight) * 100, 1) }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Nhị Thập Bát Tú</td>
                                            <td>{{ round($groomData['score']['tu']['percentage']) }}/100
                                            </td>
                                            <td>{{ round(($weights['28Tu'] / $totalWeight) * 100, 1) }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Thập Nhị Trực</td>
                                            <td>{{ round($groomData['score']['truc']['percentage']) }}/100
                                            </td>
                                            <td>{{ round(($weights['12Truc'] / $totalWeight) * 100, 1) }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Sao Cát Hung - Ngọc Hạp Thông Thư</td>
                                            <td>{{ round($groomData['score']['catHung']['percentage']) }}/100
                                            </td>
                                            <td>{{ round(($weights['CatHung'] / $totalWeight) * 100, 1) }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                                    Xem Can Chi - Khí vận & tuổi hợp/xung trong ngày
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
                                                    <ul class="mb-0 mt-0">
                                                        {!! $groomData['getVongKhiNgayThang']['analysis'] !!}
                                                    </ul>
                                                    <p> {!! $groomData['getVongKhiNgayThang']['conclusion'] !!}</p>
                                                    <h6><b>* Cục khí - hợp xung</b></h6>
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
                                                            @if (!empty($analyze['details']['can']['fakeHợpExplanation']))
                                                                {{ $analyze['details']['can']['fakeHợpExplanation'] }}
                                                            @else
                                                            {{ $analyze['details']['can']['explanation'] }}
                                                            
                                                            @endif
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
                                                    @if (!empty($nhiThapBatTu['guidance']['good']))
                                                        <p><b>Nên làm:</b> {{ $nhiThapBatTu['guidance']['good'] }}</p>
                                                    @endif
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
                                                    <p class="mb-1"><b>Trực ngày: </b>Trực
                                                        <b>{{ $getThongTinTruc['title'] }}</b> - Là
                                                        trực
                                                        {{ $getThongTinTruc['description']['rating'] }}.
                                                    </p>
                                                    <p class="mb-1">{{ $getThongTinTruc['description']['description'] }}
                                                    </p>
                                                    <div class="ps-3">
                                                        @if (!empty($getThongTinTruc['description']['good']))
                                                            <p class="mb-0"><b>Nên làm:</b>
                                                                {{ $getThongTinTruc['description']['good'] }}</p>
                                                        @endif
                                                        @if (!empty($getThongTinTruc['description']['bad']))
                                                            <p><b>Kiêng kỵ:</b>
                                                                {{ $getThongTinTruc['description']['bad'] }}
                                                            </p>
                                                        @endif
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
                                                                <li><strong>{{ $tenSao }}:</strong>
                                                                    {{ $yNghia }}
                                                                </li>
                                                            @empty
                                                                <li>Không có sao tốt nổi bật.</li>
                                                            @endforelse
                                                        </ul>
                                                        <h6 class="mt-3"><i class="fas fa-moon text-danger"></i> Sao
                                                            xấu:
                                                        </h6>
                                                        <ul class="list-unstyled ps-3">
                                                            @forelse ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                                <li><strong>{{ $tenSao }}:</strong>
                                                                    {{ $yNghia }}
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

                    <div class="card border-0 mb-3 w-100 box-detial-year">
                        <div class="card-body box1-con-year">
                            <div class="text-primary mb-2  text-dark d-flex align-items-center fw-bolder">
                                Chú ý: Đây là các thông tin xem mang tính chất tham khảo, không thay thế cho các tư vấn
                                chuyên môn. Người dùng tự chịu trách nhiệm với mọi quyết định cá nhân dựa trên thông tin
                                tham khảo tại Phong Lịch.
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
            // Get current URL parameters to extract birthdate and date range info
            const urlParams = new URLSearchParams(window.location.search);
            const birthdate = urlParams.get('birthdate');
            const dateRange = urlParams.get('date_range');
            const gender = urlParams.get('gender');

            // Build the target URL with hash parameters
            let targetUrl = '{{ route('breaking.form') }}';
            const hashParams = [];

            // Add birthdate to hash if available
            if (birthdate) {
                // Convert Y-m-d format to d/m/Y format for the form
                const dateParts = birthdate.split('-');
                if (dateParts.length === 3) {
                    const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                    hashParams.push(`birthdate=${encodeURIComponent(formattedDate)}`);
                }
            }

            // Add date range to hash if available
            if (dateRange) {
                hashParams.push(`khoang=${encodeURIComponent(dateRange)}`);
            }

            // Add gender to hash if available
            if (gender) {
                hashParams.push(`gender=${encodeURIComponent(gender)}`);
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
