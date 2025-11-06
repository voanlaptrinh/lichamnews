<div class="w-100">
    <!-- Tabs cho các năm -->
    @if (isset($resultsByYear) && count($resultsByYear) > 0)
        <div class="year-tabs mb-3">
            <ul class="nav nav-pills">
                @php $firstYear = true; @endphp
                @foreach ($resultsByYear as $year => $yearData)
                    <li class="nav-item">
                        <a class="nav-link {{ $firstYear ? 'active' : '' }}" data-bs-toggle="pill"
                            href="#year-{{ $year }}"
                            style="border-radius: 20px; margin: 0 5px; padding: 8px 20px;">
                            {{ $year }}
                            @if (isset($yearData['canchi']))
                                ({{ $yearData['canchi'] }})
                            @endif
                        </a>
                    </li>
                    @php $firstYear = false; @endphp
                @endforeach
            </ul>
        </div>
    @endif

    <div class="tab-content">
        @php $firstYear = true; @endphp
        @foreach ($resultsByYear as $year => $yearData)
            <div class="tab-pane fade {{ $firstYear ? 'show active' : '' }}" id="year-{{ $year }}">
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                height="28" class="me-1"> Thông Tin Chú rể
                        </div>
                    </div>
                </div>

            </div>

            @php $firstYear = false; @endphp
        @endforeach
    </div>
</div>


<div class="card mt-4">
    {{-- <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="yearTab" role="tablist">
            @foreach ($resultsByYear as $year => $data)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($loop->first) active @endif"
                        id="tab-{{ $year }}-tab" data-bs-toggle="tab"
                        data-bs-target="#tab-{{ $year }}" type="button" role="tab"
                        aria-controls="tab-{{ $year }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        Năm {{ $year }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div> --}}
    <div class="card-body">
        <div class="tab-content" id="yearTabContent">
            @foreach ($resultsByYear as $year => $data)
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                    id="tab-{{ $year }}" role="tabpanel" aria-labelledby="tab-{{ $year }}-tab">
                    <h4 class="mb-3">Tổng quan năm {{ $year }}</h4>

                    {{-- Thông tin cô dâu và chú rể --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Thông tin Chú Rể</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Ngày sinh dương lịch:</strong> {{ $groomInfo['dob']->format('d/m/Y') }}
                                    </p>
                                    <p><strong>Ngày sinh âm lịch:</strong> {{ $groomInfo['lunar_dob_str'] }}</p>
                                    <p><strong>Tuổi:</strong> {{ $groomInfo['can_chi_nam'] }}</p>
                                    <p><strong>Mệnh:</strong> {{ $groomInfo['menh']['hanh'] }}
                                        ({{ $groomInfo['menh']['napAm'] }})</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Thông tin Cô Dâu</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Ngày sinh dương lịch:</strong> {{ $brideInfo['dob']->format('d/m/Y') }}
                                    </p>
                                    <p><strong>Ngày sinh âm lịch:</strong> {{ $brideInfo['lunar_dob_str'] }}</p>
                                    <p><strong>Tuổi:</strong> {{ $brideInfo['can_chi_nam'] }}</p>
                                    <p><strong>Mệnh:</strong> {{ $brideInfo['menh']['hanh'] }}
                                        ({{ $brideInfo['menh']['napAm'] }})</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Phân tích --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div
                                class="alert {{ $data['groom_analysis']['is_bad_year'] ? 'alert-warning' : 'alert-success' }}">
                                <h5 class="alert-heading">Chú Rể - Phân tích năm {{ $year }}</h5>
                                <p>
                                    Kiểm tra xem năm {{ $year }} {{ $data['canchi'] }} Chú rể tuổi
                                    {{ $groomInfo['can_chi_nam'] }} (Nam
                                    {{ $data['groom_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                    Lâu, Hoang Ốc, Tam Tai không?
                                </p>
                                <ul>
                                    <li>{{ $data['groom_analysis']['kim_lau']['message'] }}</li>
                                    <li>{{ $data['groom_analysis']['hoang_oc']['message'] }}</li>
                                    <li>{{ $data['groom_analysis']['tam_tai']['message'] }}</li>
                                </ul>
                                <p>Kết luận {!! $data['groom_analysis']['description'] !!}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="alert {{ $data['bride_analysis']['is_bad_year'] ? 'alert-warning' : 'alert-success' }}">
                                <h5 class="alert-heading">Cô Dâu - Phân tích năm {{ $year }}</h5>
                                <p>
                                    Kiểm tra xem năm {{ $year }} {{ $data['canchi'] }} Cô Dâu tuổi
                                    {{ $brideInfo['can_chi_nam'] }} (Nữ
                                    {{ $data['bride_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                    Lâu, Hoang Ốc, Tam Tai không?
                                </p>
                                <ul>
                                    <li>{{ $data['bride_analysis']['kim_lau']['message'] }}</li>
                                    <li>{{ $data['bride_analysis']['hoang_oc']['message'] }}</li>
                                    <li>{{ $data['bride_analysis']['tam_tai']['message'] }}</li>
                                </ul>
                                <p>Kết luận {!! $data['bride_analysis']['description'] !!}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bảng kết quả chi tiết các ngày --}}
                    @if (empty($data['days']))
                        <div class="alert alert-info">Không có ngày nào trong khoảng bạn chọn thuộc năm này.
                        </div>
                    @else
                        <h4 class="mb-3">Bảng điểm chi tiết các ngày</h4>

                        <div class="table-responsive" id="bang-chi-tiet">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">Ngày Dương</th>
                                        <th class="align-middle">Ngày Âm</th>
                                        <th class="align-middle">Điểm Chú Rể (%)</th>
                                        <th class="align-middle">Điểm Cô Dâu (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['days'] as $day)
                                        <tr>
                                            <td>
                                                <strong>{{ $day['date']->format('d/m/Y') }}</strong><br>
                                                <small>{{ $day['weekday_name'] }}</small>
                                            </td>
                                            <td>
                                                {{ $day['lunar_date_str'] }}<br>
                                                <small>{{ $day['full_lunar_date_str'] }}</small><br>
                                                <a href="{{ route('wedding.day.details', [
                                                    'date' => $day['date']->format('Y-m-d'),
                                                    'groom_dob' => $groomInfo['dob']->format('Y-m-d'),
                                                    'bride_dob' => $brideInfo['dob']->format('Y-m-d'),
                                                ]) }}"
                                                    class="btn btn-sm btn-outline-primary mt-1" target="_blank">
                                                    Xem chi tiết
                                                </a>
                                                @if (!empty($day['good_hours']))
                                                    <div class="mt-2 text-start">
                                                        <span class="text-success"><i class="far fa-clock"></i>
                                                            <strong>Giờ tốt:</strong></span><br>
                                                        <small>{{ implode('; ', $day['good_hours']) }}</small>
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- Chú rể --}}
                                            <td>
                                                <div class="fw-bold fs-5">
                                                    {{ $day['groom_score']['percentage'] }}
                                                </div>
                                            </td>
                                            {{-- Cô dâu --}}
                                            <td>
                                                <div class="fw-bold fs-5">
                                                    {{ $day['bride_score']['percentage'] }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
