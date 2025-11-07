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
                        <div class="info-grid">
                            <p class="mb-2">
                                <strong>Ngày sinh:</strong>
                                {{ $groomInfo['dob']->format('d/m/Y') }} Dương lịch tức ngày
                                {{ $groomInfo['lunar_dob_str'] }} Âm lịch
                            </p>
                            {{-- <p class="mb-2">
                                    <strong>Tuổi:</strong>
                                    {{ $birthdateInfo['can_chi'] ?? '' }}, mệnh: 
                                     {{ $birthdateInfo['hanh'] ?? '' }} ({{ $birthdateInfo['menh'] ?? '' }})
                                </p> --}}
                            <p class="mb-2">
                                <strong>Tuổi âm:</strong>
                                {{ $year - $groomInfo['dob']->year + 1 }} tuổi ({{ $groomInfo['can_chi_nam'] }})
                            </p>
                            <p class="mb-2">
                                <strong>Mệnh:</strong>
                                {{ $groomInfo['menh']['hanh'] }}
                                ({{ $groomInfo['menh']['napAm'] }})
                            </p>
                            <hr>
                            <p class="mb-1 fw-bolder"><span style="color: red">*</span> Chú Rể - Phân tích năm
                                {{ $year }}</p>
                            <p class="mb-0">
                                Kiểm tra xem năm {{ $year }} {{ $yearData['canchi'] }} Chú rể tuổi
                                {{ $groomInfo['can_chi_nam'] }} (
                                {{ $yearData['groom_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                Lâu, Hoang Ốc, Tam Tai không?
                            </p>
                            <ul class="mb-1">
                                <li>{{ $yearData['groom_analysis']['kim_lau']['message'] }}</li>
                                <li>{{ $yearData['groom_analysis']['hoang_oc']['message'] }}</li>
                                <li>{{ $yearData['groom_analysis']['tam_tai']['message'] }}</li>
                            </ul>
                            <p>Kết luận {!! $yearData['groom_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                height="28" class="me-1"> Thông Tin Cô dâu
                        </div>
                        <div class="info-grid">
                            <p class="mb-2">
                                <strong>Ngày sinh:</strong>
                                {{ $brideInfo['dob']->format('d/m/Y') }} Dương lịch tức ngày
                                {{ $brideInfo['lunar_dob_str'] }} Âm lịch
                            </p>

                            <p class="mb-2">
                                <strong>Tuổi âm:</strong>
                                {{ $year - $brideInfo['dob']->year + 1 }} tuổi ({{ $brideInfo['can_chi_nam'] }})
                            </p>
                            <p class="mb-2">
                                <strong>Mệnh:</strong>
                                {{ $brideInfo['menh']['hanh'] }}
                                ({{ $brideInfo['menh']['napAm'] }})
                            </p>
                            <hr>
                            <p class="mb-1 fw-bolder"><span style="color: red">*</span> Cô Dâu - Phân tích năm
                                {{ $year }}</p>
                            <p class="mb-0">
                                Kiểm tra xem năm {{ $year }} {{ $yearData['canchi'] }} Cô Dâu tuổi
                                {{ $brideInfo['can_chi_nam'] }} (
                                {{ $yearData['bride_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                Lâu, Hoang Ốc, Tam Tai không?
                            </p>
                            <ul class="mb-1">
                                <li>{{ $yearData['bride_analysis']['kim_lau']['message'] }}</li>
                                <li>{{ $yearData['bride_analysis']['hoang_oc']['message'] }}</li>
                                <li>{{ $yearData['bride_analysis']['tam_tai']['message'] }}</li>
                            </ul>
                            <p>Kết luận {!! $yearData['bride_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        <div class="betwen-ds mb-3 flex-wrap">
                            <div
                                class="text-primary mb-0 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> Danh Sách Điểm
                                Theo Ngày
                            </div>
                            <select name="sort" class=" form-select-sm sort-select" style="width: auto;"
                                form="totXauForm">
                                <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Điểm
                                    giảm dần</option>
                                <option value="asc" {{ ($sortOrder ?? 'desc') === 'asc' ? 'selected' : '' }}>Điểm
                                    tăng dần</option>
                            </select>
                        </div>

                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100" id="table-{{ $year }}"
                                    style="table-layout: fixed; width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Phạm</th>
                                            <th style=" border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($yearData['days'] as $day)
                                            <tr>
                                                <td>
                                                    <a
                                                        href="">
                                                        <div class="box-dtl-pc">
                                                            <div style="color: #0F172A;font-size: 18px">
                                                                <strong>{{ $day['weekday_name'] ?? '' }},
                                                                    {{ $day['date']->format('d/m/Y') }}</strong>
                                                            </div>
                                                            <div class="text-muted small"
                                                                style="color: #2254AB;font-size: 18px">
                                                                {{ $day['full_lunar_date_str'] ?? '' }} <i
                                                                    class="bi bi-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                        <div class="box-dtl-mb">
                                                            <div class="hv-memorial-date-panel">
                                                                <div class="hv-memorial-month-text">Tháng
                                                                    {{ $day['date']->format('m') }}</div>
                                                                <div class="hv-memorial-day-digit">
                                                                    {{ $day['date']->format('d') }}</div>
                                                                <div class="hv-memorial-lunar-calendar-info">
                                                                    {{ $day['al_name'][0] ?? '' }}/{{ $day['al_name'][1] ?? '' }}
                                                                    ÂL <i class="bi bi-chevron-right"></i></div>
                                                            </div>

                                                        </div>
                                                    </a>
                                                </td>
                                                {{-- <td>
                                                    @php
                                                        $violations = $day['day_score']['pham']['issues'] ?? [];
                                                        if (is_string($violations)) {
                                                            $violations = json_decode($violations, true) ?: [];
                                                        }
                                                        $validViolations = array_filter($violations, function ($v) {
                                                            if (is_array($v)) {
                                                                return !empty(array_filter($v));
                                                            }
                                                            return !empty($v);
                                                        });

                                                        $countViolations = count($validViolations);
                                                    @endphp
                                                    @if (count($validViolations) > 0)
                                                        <div class="text-dark fw-semibold">
                                                            <img src="{{ asset('icons/ping.svg?v=1.0') }}"
                                                                alt="ping" width="24" height="24">
                                                            <span>{{ $countViolations }} phạm</span>
                                                        </div>
                                                    @else
                                                        <span class="text-success">
                                                            <i class="bi bi-check-circle-fill"></i> Không phạm
                                                        </span>
                                                    @endif

                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $score = $day['day_score']['percentage'] ?? 0;
                                                        $bgColor = '#D1FAE5'; // Green
                                                        if ($score < 30) {
                                                            $bgColor = '#FEE2E2'; // Red
                                                            $border = '#DC2626';
                                                            $text_box = '#DC2626';
                                                        } elseif ($score < 50) {
                                                            $bgColor = '#FFE3D5'; // Yellow
                                                            $border = '#FC6803';
                                                            $text_box = '#FC6803';
                                                        } elseif ($score < 70) {
                                                            $bgColor = '#FEF3C7'; // Orange
                                                            $border = '#F59E0B';
                                                            $text_box = '#F59E0B';
                                                        } else {
                                                            $border = '#10B981';
                                                            $text_box = '#10B981';
                                                        }
                                                    @endphp
                                                    <div class=" d-flex justify-content-center align-items-center">
                                                        <div class="battery">
                                                            <div class="battery-body"
                                                                style="border:1px solid {{ $border }}">
                                                                <div class="battery-fill"
                                                                    style="width: {{ round($score) }}%; background-color: {{ $bgColor }}; ">
                                                                </div>
                                                                <div class="battery-label"> {{ round($score) }}%</div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </td> --}}

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-4">
                                Không có ngày nào trong khoảng thời gian đã chọn.
                            </p>
                        @endif
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
