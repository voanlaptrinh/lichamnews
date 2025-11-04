<div class="w-100">
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
                                height="28" class="me-1"> Thông Tin Người Xem
                        </div>
                        @if (isset($birthdateInfo))
                            <div class="info-grid">
                                <p class="mb-2">
                                    <strong>Ngày sinh:</strong>
                                    {{ $birthdateInfo['dob']->format('d/m/Y') }} tức ngày
                                    {{ $birthdateInfo['lunar_dob_str'] }} âm lịch
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi:</strong>
                                    <b>{{ $birthdateInfo['can_chi_nam'] }}</b>, Mệnh:
                                    {{ $birthdateInfo['menh']['hanh'] }}
                                    ({{ $birthdateInfo['menh']['napAm'] }})
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi âm:</strong>
                                    {{ $yearData['year_analysis']['lunar_age'] }} tuổi
                                </p>

                                <p class="mb-2">
                                    <strong>Thời gian xem:</strong>
                                    {{ $inputs['date_range'] ?? '' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                height="28" class="me-1"> Kiểm tra Kim Lâu - Hoang Ốc - Tam Tai
                        </div>
                        <div class="info-grid">
                            <p class="mb-2">
                                Kiểm tra xem năm {{ $year }} {{ $yearData['canchi'] }} gia chủ tuổi
                                {{ $birthdateInfo['can_chi_nam'] }}
                                ({{ $yearData['year_analysis']['lunar_age'] }} tuổi) có phạm phải Kim Lâu,
                                Hoang Ốc, Tam Tai không?
                            </p>
                            <ul>
                                <li>
                                    {{ $yearData['year_analysis']['details']['kimLau']['message'] }}
                                </li>
                                <li>
                                    {{ $yearData['year_analysis']['details']['hoangOc']['message'] }}
                                </li>
                                <li>
                                    {{ $yearData['year_analysis']['details']['tamTai']['message'] }}
                                </li>
                            </ul>
                            <p>{!! $yearData['year_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <div
                                class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> Danh Sách Điểm
                                Theo Ngày
                            </div>
                            <select name="sort" class=" form-select-sm sort-select" style="width: auto;"
                                form="buildHouseForm">
                                <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Điểm
                                    giảm dần</option>
                                <option value="asc" {{ ($sortOrder ?? 'desc') === 'asc' ? 'selected' : '' }}>Điểm
                                    tăng dần</option>
                            </select>
                        </div>

                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <div class="table-responsive w-100">
                                <table class="table table-hover align-middle w-100" id="table-{{ $year }}">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="min-width: 200px;border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="min-width: 150px;">Phạm</th>
                                            <th style="min-width: 120px;" class="score-header">Điểm ngày</th>
                                            <th style="min-width: 120px;border-radius: 0 8px 8px 0">Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($yearData['days'] as $day)
                                            <tr>
                                                <td>
                                                    <div style="color: #0F172A;font-size: 18px">
                                                        <strong>{{ $day['weekday_name'] ?? '' }},
                                                            {{ $day['date']->format('d/m/Y') }}</strong>
                                                    </div>
                                                    <div class="text-muted small"
                                                        style="color: #2254AB;font-size: 18px">
                                                        {{ $day['full_lunar_date_str'] ?? '' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @php
                                                        $badFactors = [];

                                                        // Đếm số phạm từ checkTabooDays
                                                        $checkTabooDaysCount = 0;
                                                        if (isset($day['day_score']['checkTabooDays']['issues']) &&
                                                            is_array($day['day_score']['checkTabooDays']['issues'])) {
                                                            $checkTabooDaysCount = count($day['day_score']['checkTabooDays']['issues']);
                                                        }

                                                        if (
                                                            isset($day['day_score']['issues']) &&
                                                            !empty($day['day_score']['issues'])
                                                        ) {
                                                            foreach ($day['day_score']['issues'] as $issue) {
                                                                $reason = $issue['reason'];

                                                                if (str_starts_with($reason, 'Sao xấu:')) {
                                                                    continue;
                                                                }
                                                                $parts = explode(':', $reason, 2);
                                                                $factorName = trim($parts[0]);
                                                                $badFactors[] = $factorName;
                                                            }
                                                        }
                                                        $badFactors = array_unique($badFactors);
                                                    @endphp
                                                    @if (count($badFactors) > 0 || $checkTabooDaysCount > 0)
                                                        <div class="text-dark fw-semibold">
                                                            <img src="{{ asset('icons/ping.svg?v=1.0') }}"
                                                                alt="ping" width="24" height="24">
                                                            <span>{{ $checkTabooDaysCount }} phạm</span>
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
                                                            $bgColor = '#FEF3C7'; // Yellow
                                                            $border = '#F59E0B';
                                                            $text_box = '#F59E0B';
                                                        } elseif ($score < 70) {
                                                            $bgColor = '#FFE3D5'; // Orange
                                                            $border = '#FC6803';
                                                            $text_box = '#FC6803';
                                                        } else {
                                                            $border = '#10B981';
                                                            $text_box = '#10B981';
                                                        }
                                                    @endphp
                                                    <div class=" d-flex justify-content-center align-items-center">
                                                        <span
                                                            class="badge px-3 py-2 d-flex justify-content-center align-items-center"
                                                            style="background-color: {{ $bgColor }};border:1px solid {{ $border }}; color: {{ $text_box }}; font-size: 18px; border-radius: 8px;width:108px;height:28px;font-weight:600">
                                                            {{ round($score) }}%
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href="{{ route('buy-house.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'birthdate' => $birthdateInfo['dob']->format('Y-m-d'),
                                                        ]) }}"
                                                            class="btn btn-sm-settup" target="_blank">
                                                            Xem <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-eye"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z">
                                                                </path>
                                                                <path
                                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
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
