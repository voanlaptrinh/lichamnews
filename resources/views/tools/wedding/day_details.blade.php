{{-- resources/views/wedding/day_details.blade.php --}}
@extends('welcome')

@section('content')
    {{-- <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="h3 mb-0">Phân Tích Chi Tiết Điểm Ngày Cưới</h1>
            </div>
            <div class="card-body">
            
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Đối tượng: <span class="text-primary">{{ $personTitle }}
                                ({{ $personInfo['can_chi_nam'] }})</span></h5>
                        <p class="mb-1"><strong>Ngày sinh:</strong> {{ $personInfo['dob']->format('d/m/Y') }}</p>
                        <p class="mb-1"><strong>Mệnh:</strong> {{ $personInfo['menh']['hanh'] }}
                            ({{ $personInfo['menh']['napAm'] }})</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Ngày xem: <span class="text-danger">{{ $dateToCheck->format('d/m/Y') }}</span></h5>
                        <p class="mb-1"><strong>Âm lịch:</strong> {{ $lunarDateStr }}</p>
                        <p class="mb-1"><strong>Điểm tổng kết:</strong> <span
                                class="fw-bold fs-4">{{ $score['percentage'] }}%</span></p>
                    </div>

                </div>
             
                <h5 style="color: red">Phạm</h5>
                @if (isset($badDays) && !empty($badDays))
                    <div class="alert alert-warning mb-2">
                        <ul class="mb-0">
                            @foreach ($badDays as $badDay)
                                <li>{{ $badDay }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="alert alert-info mb-2">
                        <strong>Không có ngày xấu nào được xác định cho ngày này.</strong>
                    </div>
                @endif
                <div class="alert alert-info mb-2">Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}</div>
               
                <h4 class="mb-3">Phân tích các yếu tố:</h4>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Can chi vận khí
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="">
                                    <h6><b>* Quan hệ Can chi ngày (nội khí)</b></h6>
                                    <div>
                                        {{ $noiKhiNgay }}
                                    </div>
                                </div>
                                <div class="">
                                    <h6><b>* Vận khí ngày & tháng (khí tháng):</b></h6>
                                    <div>
                                        <p> Ngày {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }} Tháng
                                            {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</p>

                                        <p> {!! $getVongKhiNgayThang['analysis'] !!}</p>
                                        <p> {!! $getVongKhiNgayThang['conclusion'] !!}</p>

                                    </div>
                                </div>
                                <div class="">
                                    <h6><b>* Cục khí - hợp xung:</b></h6>
                                    <div>


                                        <ul>
                                            <li>{{ $getCucKhiHopXung['hop'] ?? 'Không rõ' }}</li>
                                            <li>{{ $getCucKhiHopXung['ky'] ?? 'Không rõ' }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="">
                                    <h6><b>* So sánh ngày với mệnh tuổi của bạn (năm_sinh) (trường hợp xem cá nhân hóa):</b>
                                    </h6>
                                    <div>
                                        <ul>
                                            <li>Thiên can ngày - thiên can tuổi: Can ngày là
                                                {{ $analyzeNgayVoiTuoi['details']['can']['canNgay'] }}, Can tuổi là
                                                {{ $analyzeNgayVoiTuoi['details']['can']['canTuoi'] }} ->
                                                {{ $analyzeNgayVoiTuoi['details']['can']['relation'] }}
                                                ({{ $analyzeNgayVoiTuoi['details']['can']['rating'] }}).
                                                {{ $analyzeNgayVoiTuoi['details']['can']['explanation'] }}
                                            </li>
                                            <li>
                                                Địa chi ngày - địa chi tuổi: Chi ngày là
                                                {{ $analyzeNgayVoiTuoi['details']['chi']['chiNgay'] }}, Chi tuổi là
                                                {{ $analyzeNgayVoiTuoi['details']['chi']['chiTuoi'] }} ->
                                                {{ $analyzeNgayVoiTuoi['details']['chi']['relationKey'] }}
                                                ({{ $analyzeNgayVoiTuoi['details']['chi']['rating'] }}).
                                                {{ $analyzeNgayVoiTuoi['details']['chi']['explanation'] }}
                                            </li>
                                            <li>
                                                Nạp âm ngày - nạp âm tuổi:
                                                Ngày {{ $analyzeNgayVoiTuoi['details']['nap_am']['canchiNgay'] }} nạp âm là
                                                {{ $analyzeNgayVoiTuoi['details']['nap_am']['napAmNgay']['napAm'] }}
                                                ({{ $analyzeNgayVoiTuoi['details']['nap_am']['napAmNgay']['hanh'] }}), tuổi
                                                {{ $analyzeNgayVoiTuoi['details']['nap_am']['canchiTuoi'] }} nạp âm là
                                                {{ $analyzeNgayVoiTuoi['details']['nap_am']['napAmTuoi']['napAm'] }}
                                                ({{ $analyzeNgayVoiTuoi['details']['nap_am']['napAmTuoi']['hanh'] }}) -> {{ $analyzeNgayVoiTuoi['details']['nap_am']['relationKey'] }}
                                                ({{ $analyzeNgayVoiTuoi['details']['nap_am']['rating'] }}).
                                                {{ $analyzeNgayVoiTuoi['details']['nap_am']['explanation'] }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Nhị thập bát tú
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Ngày {{ $al[0] }}-{{ $al[1] }}-{{ $al[2] }} Âm lịch có xuất
                                    hiện sao: <b>{{ $nhiThapBatTu['name'] }}({{ $nhiThapBatTu['fullName'] }})</b></p>
                                <p>Đây là sao <b>{{ $nhiThapBatTu['nature'] }} </b>-
                                    {{ $nhiThapBatTu['description'] }}</p>
                                <li>
                                    Việc nên làm : {{ $nhiThapBatTu['guidance']['good'] }}
                                    @if (!empty($nhiThapBatTu['guidance']['bad']))
                                        Việc không nên làm : {{ $nhiThapBatTu['guidance']['bad'] }}
                                    @endif
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Thập Nhị Trực
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p><b>Trực ngày: </b>Trực <b>{{ $getThongTinTruc['title'] }}</b></p>
                                <p>- Đây là trực {{ $getThongTinTruc['description']['rating'] }} -
                                    {{ $getThongTinTruc['description']['description'] }}</p>
                                <ul>
                                    <li>Việc nên làm: {{ $getThongTinTruc['description']['good'] }}</li>
                                    <li>Việc không nên làm: {{ $getThongTinTruc['description']['bad'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseforSaoCatHung" aria-expanded="false"
                                aria-controls="flush-collapseforSaoCatHung">
                                Sao cát hung theo Ngọc Hạp Thông Thư
                            </button>
                        </h2>
                        <div id="flush-collapseforSaoCatHung" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div>
                                    <h6>- Sao tốt</h6>
                                    @if (!empty($getSaoTotXauInfo['sao_tot']))
                                        @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                            <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                        @endforeach
                                    @else
                                        Không có sao tốt trong ngày này
                                    @endif

                                    </ul>
                                    <h6>- Sao xấu</h6>
                                    <ul>
                                        @if (!empty($getSaoTotXauInfo['sao_xau']))
                                            @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                            @endforeach
                                        @else
                                            Không có sao xấu trong ngày này
                                        @endif

                                    </ul>
                                    <p>{{ $getSaoTotXauInfo['ket_luan'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>







                <div class="mt-4">
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại trang kết quả
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container mt-4 mb-5">
    {{-- PHẦN THÔNG TIN CHUNG CỦA NGÀY --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h1 class="h3 mb-0 text-center">Phân Tích Chi Tiết Ngày Cưới</h1>
        </div>
        <div class="card-body">
            <div class="row text-center mb-3">
                <div class="col-md-6">
                    <h5>Ngày xem: <span class="text-danger">{{ $commonDayInfo['dateToCheck']->format('d/m/Y') }}</span></h5>
                    <p class="mb-1"><strong>Âm lịch:</strong> {{ $commonDayInfo['lunarDateStr'] }}</p>
                </div>
                <div class="col-md-6">
                     {{-- <h5>Ngày: <span class="text-info">{{ $commonDayInfo['getThongTinNgay']['ngay_hoang_dao_info'] }}</span></h5> --}}
                     <p class="mb-1"><strong>Giờ hoàng đạo:</strong> {{ $commonDayInfo['getThongTinNgay']['gio_hoang_dao'] }}</p>
                </div>
            </div>
            
            @if (isset($commonDayInfo['badDays']) && !empty($commonDayInfo['badDays']))
            <div class="alert alert-warning">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Các ngày xấu phạm phải:</h5>
                <ul class="mb-0 ps-4">
                    @foreach ($commonDayInfo['badDays'] as $badDay)
                        <li>{{ $badDay }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    {{-- GIAO DIỆN TAB --}}
    <ul class="nav nav-tabs nav-fill mb-3 h5" id="personTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="groom-tab" data-bs-toggle="tab" data-bs-target="#groom-tab-pane" type="button" role="tab" aria-controls="groom-tab-pane" aria-selected="true">
                <i class="fas fa-male me-2"></i> Luận Giải cho Chú Rể
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bride-tab" data-bs-toggle="tab" data-bs-target="#bride-tab-pane" type="button" role="tab" aria-controls="bride-tab-pane" aria-selected="false">
                 <i class="fas fa-female me-2"></i> Luận Giải cho Cô Dâu
            </button>
        </li>
    </ul>

    <div class="tab-content" id="personTabContent">
        {{-- TAB CỦA CHÚ RỂ --}}
        <div class="tab-pane fade show active" id="groom-tab-pane" role="tabpanel" aria-labelledby="groom-tab" tabindex="0">
            {{-- Gọi partial view và truyền dữ liệu của chú rể --}}
            @include('tools.wedding.person_analysis_accordion', ['personData' => $groomData, 'commonData' => $commonDayInfo])
        </div>

        {{-- TAB CỦA CÔ DÂU --}}
        <div class="tab-pane fade" id="bride-tab-pane" role="tabpanel" aria-labelledby="bride-tab" tabindex="0">
             {{-- Gọi partial view và truyền dữ liệu của cô dâu --}}
             @include('tools.wedding.person_analysis_accordion', ['personData' => $brideData, 'commonData' => $commonDayInfo])
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại trang kết quả
        </a>
    </div>

</div>
@endsection
