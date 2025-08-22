{{-- File này nhận vào 2 biến: $personData và $commonData --}}
<div class="card border-primary">
    <div class="card-header bg-primary-subtle">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary-emphasis">
                {{ $personData['personTitle'] }} - {{ $personData['personInfo']['can_chi_nam'] }} (Mệnh
                {{ $personData['personInfo']['menh']['hanh'] }})
            </h5>
            <span class="fw-bold fs-4">Điểm: {{ $personData['score']['percentage'] }}%</span>
        </div>
    </div>
    <div class="card-body">
        <div class="accordion accordion-flush" id="accordion-{{ Str::slug($personData['personTitle']) }}">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-canchi-{{ Str::slug($personData['personTitle']) }}">
                        Phân tích Can Chi - Vận Khí (Tương tác với tuổi)
                    </button>
                </h2>
                <div id="collapse-canchi-{{ Str::slug($personData['personTitle']) }}"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordion-{{ Str::slug($personData['personTitle']) }}">
                    <div class="accordion-body">
                        <h6><b>* Quan hệ Can chi ngày (nội khí):</b></h6>
                        <p>{{ $personData['noiKhiNgay'] }}</p>

                        <h6><b>* Vận khí ngày & tháng (khí tháng):</b></h6>
                        <p>Ngày {{ $personData['getThongTinCanChiVaIcon']['can_chi_ngay'] }} - Tháng
                            {{ $personData['getThongTinCanChiVaIcon']['can_chi_thang'] }}</p>
                        {!! $personData['getVongKhiNgayThang']['analysis'] !!}
                        {!! $personData['getVongKhiNgayThang']['conclusion'] !!}
                        <h6><b>Cục khí - hợp xung</b></h6>
                        <ul>
                            <li>{{ $commonData['hopxungNgay']['hop'] }}</li>
                            <li>{{ $commonData['hopxungNgay']['ky'] }}</li>
                        </ul>
                        <h6><b>* So sánh ngày với mệnh tuổi của bạn:</b></h6>
                        @php $analyze = $personData['analyzeNgayVoiTuoi']; @endphp
                        <ul class="list-unstyled">
                            <li><strong>Thiên can:</strong> Can ngày <i>{{ $analyze['details']['can']['canNgay'] }}</i>
                                và can tuổi <i>{{ $analyze['details']['can']['canTuoi'] }}</i> là
                                <b>{{ $analyze['details']['can']['relation'] }}</b>
                                ({{ $analyze['details']['can']['rating'] }}).
                                {{ $analyze['details']['can']['explanation'] }}</li>
                            <li><strong>Địa chi:</strong> Chi ngày <i>{{ $analyze['details']['chi']['chiNgay'] }}</i>
                                và chi tuổi <i>{{ $analyze['details']['chi']['chiTuoi'] }}</i> là
                                <b>{{ $analyze['details']['chi']['relationKey'] }}</b>
                                ({{ $analyze['details']['chi']['rating'] }}).
                                {{ $analyze['details']['chi']['explanation'] }}</li>
                            <li><strong>Nạp âm:</strong> Nạp âm ngày
                                ({{ $analyze['details']['nap_am']['napAmNgay']['hanh'] }}) và nạp âm tuổi
                                ({{ $analyze['details']['nap_am']['napAmTuoi']['hanh'] }}) là
                                <b>{{ $analyze['details']['nap_am']['relationKey'] }}</b>
                                ({{ $analyze['details']['nap_am']['rating'] }}).
                                {{ $analyze['details']['nap_am']['explanation'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-nhi-thap-bat-tu-{{ Str::slug($personData['personTitle']) }}">
                        Nhị Thập Bát Tú
                    </button>
                </h2>
                <div id="collapse-nhi-thap-bat-tu-{{ Str::slug($personData['personTitle']) }}"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordion-{{ Str::slug($personData['personTitle']) }}">
                    <div class="accordion-body">
                        @php $nhiThapBatTu = $commonData['nhiThapBatTu']; @endphp
                        <p>Ngày này có sao: <b>{{ $nhiThapBatTu['name'] }} ({{ $nhiThapBatTu['fullName'] }})</b> - Là
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-thap-nhi-truc-{{ Str::slug($personData['personTitle']) }}">
                        Thập Nhị Trực
                    </button>
                </h2>
                <div id="collapse-thap-nhi-truc-{{ Str::slug($personData['personTitle']) }}"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordion-{{ Str::slug($personData['personTitle']) }}">
                    <div class="accordion-body">
                        @php $getThongTinTruc = $commonData['getThongTinTruc']; @endphp
                        <p><b>Trực ngày: </b>Trực <b>{{ $getThongTinTruc['title'] }}</b> - Là trực
                            {{ $getThongTinTruc['description']['rating'] }}.</p>
                        <p>{{ $getThongTinTruc['description']['description'] }}</p>
                        <p><b>Nên làm:</b> {{ $getThongTinTruc['description']['good'] }}</p>
                        <p><b>Kiêng kỵ:</b> {{ $getThongTinTruc['description']['bad'] }}</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-sao-cat-hung-{{ Str::slug($personData['personTitle']) }}">
                        Sao Cát Hung (Ngọc Hạp Thông Thư)
                    </button>
                </h2>
                <div id="collapse-sao-cat-hung-{{ Str::slug($personData['personTitle']) }}"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordion-{{ Str::slug($personData['personTitle']) }}">
                    <div class="accordion-body">
                        @php $getSaoTotXauInfo = $commonData['getSaoTotXauInfo']; @endphp
                        <h6><i class="fas fa-star text-success"></i> Sao tốt:</h6>
                        <ul class="list-unstyled ps-3">
                            @forelse ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                            @empty
                                <li>Không có sao tốt nổi bật.</li>
                            @endforelse
                        </ul>
                        <h6 class="mt-3"><i class="fas fa-moon text-danger"></i> Sao xấu:</h6>
                        <ul class="list-unstyled ps-3">
                            @forelse ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
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
