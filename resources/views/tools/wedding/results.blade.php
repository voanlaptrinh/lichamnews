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
                                 <li>{{ $yearData['groom_analysis']['kim_lau']['is_bad']? $yearData['groom_analysis']['kim_lau']['message'] : 'Không phạm Kim Lâu'  }}</li>
                               <li> {{ $yearData['groom_analysis']['hoang_oc']['is_bad'] ? $yearData['groom_analysis']['hoang_oc']['message'] : 'Không phạm Hoang Ốc' }}</li>
                                <li>{{ $yearData['groom_analysis']['tam_tai']['is_bad']? $yearData['groom_analysis']['tam_tai']['message'] : 'Không phạm Tam Tai'  }}</li>
                              
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
                                <li>{{ $yearData['bride_analysis']['kim_lau']['is_bad']? $yearData['bride_analysis']['kim_lau']['message'] : 'Không phạm Kim Lâu'  }}</li>
                               <li> {{ $yearData['bride_analysis']['hoang_oc']['is_bad'] ? $yearData['bride_analysis']['hoang_oc']['message'] : 'Không phạm Hoang Ốc' }}</li>
                                <li>{{ $yearData['bride_analysis']['tam_tai']['is_bad']? $yearData['bride_analysis']['tam_tai']['message'] : 'Không phạm Tam Tai'  }}</li>
                            </ul>
                            <p>Kết luận {!! $yearData['bride_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        <div class="betwen-ds mb-3 flex-wrap">
                            <div
                                class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> Danh Sách Điểm
                                Theo Ngày
                            </div>
                            <select name="sort" class=" form-select-sm sort-select" style="width: auto;"
                                form="weddingForm">
                                <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Tổng
                                    điểm giảm dần</option>
                                <option value="asc" {{ ($sortOrder ?? 'desc') === 'asc' ? 'selected' : '' }}>Tổng
                                    điểm tăng dần</option>
                            </select>
                        </div>

                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout" id="table-{{ $year }}"
                                    style=" width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Yếu tố hỗ trợ</th>
                                            <th style=" border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($yearData['days'] as $day)
                                         @php
                                                        $groomScore = $day['groom_score']['percentage'] ?? 0;
                                                        $brideScore = $day['bride_score']['percentage'] ?? 0;
                                                        $groomScore = round($groomScore);
                                                        $brideScore = round($brideScore);

                                                        // Xác định màu cho chú rể
                                                        if ($groomScore <= 30) {
                                                            $groomColor = [
                                                                'bg' => '#FEE2E2',
                                                                'border' => '#DC2626',
                                                                'text' => '#DC2626',
                                                            ];
                                                        } elseif ($groomScore <= 50) {
                                                            $groomColor = [
                                                                'bg' => '#FFE3D5',
                                                                'border' => '#FC6803',
                                                                'text' => '#FC6803',
                                                            ];
                                                        } elseif ($groomScore <= 70) {
                                                            $groomColor = [
                                                                'bg' => '#FEF3C7',
                                                                'border' => '#F59E0B',
                                                                'text' => '#F59E0B',
                                                            ];
                                                        } else {
                                                            $groomColor = [
                                                                'bg' => '#D1FAE5',
                                                                'border' => '#10B981',
                                                                'text' => '#10B981',
                                                            ];
                                                        }

                                                        // Xác định màu cho cô dâu
                                                        if ($brideScore <= 30) {
                                                            $brideColor = [
                                                                'bg' => '#FEE2E2',
                                                                'border' => '#DC2626',
                                                                'text' => '#DC2626',
                                                            ];
                                                        } elseif ($brideScore <= 50) {
                                                            $brideColor = [
                                                                'bg' => '#FFE3D5',
                                                                'border' => '#FC6803',
                                                                'text' => '#FC6803',
                                                            ];
                                                        } elseif ($brideScore <= 70) {
                                                            $brideColor = [
                                                                'bg' => '#FEF3C7',
                                                                'border' => '#F59E0B',
                                                                'text' => '#F59E0B',
                                                            ];
                                                        } else {
                                                            $brideColor = [
                                                                'bg' => '#D1FAE5',
                                                                'border' => '#10B981',
                                                                'text' => '#10B981',
                                                            ];
                                                        }
                                                    @endphp
                                            <tr>
                                                <td>
                                                    <a
                                                        href="{{ route('wedding.day.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'groom_dob' => $groomInfo['dob']->format('Y-m-d'),
                                                            'bride_dob' => $brideInfo['dob']->format('Y-m-d'),
                                                            'calendar_type' => $inputs['calendar_type'] ?? 'solar'
                                                        ]) }}">
                                                        <div class="box-dtl-pc">
                                                            <div style="color: #0F172A;font-size: 18px">
                                                                <strong
                                                                    style="text-transform:capitalize;">{{ $day['weekday_name'] ?? '' }},
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
                                                <td style="text-align: start">
                                                    @php
                                                        $supportFactors = [];

                                                        // Kiểm tra violations (phạm) trước
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

                                                        if (count($validViolations) > 0) {
                                                            $supportFactors[] =
                                                                'Phạm: ' . count($validViolations) . ' vấn đề';
                                                        }

                                                        // Kiểm tra ngày hoàng đạo - sử dụng helper
                                                        if (
                                                            isset($day['day_score']['hoangdao']) &&
                                                            $day['day_score']['hoangdao'] === true
                                                        ) {
                                                            $starName = \App\Helpers\GoodBadDayHelper::getHoangDaoStar(
                                                                $day['date'],
                                                            );
                                                            if ($starName) {
                                                                $supportFactors[] = "Ngày hoàng đạo: Sao {$starName}";
                                                            }
                                                        }

                                                        // Kiểm tra trực tốt
                                                        if (
                                                            isset($day['day_score']['tructot']) &&
                                                            $day['day_score']['tructot'] === true
                                                        ) {
                                                            $trucName =
                                                                $day['day_score']['truc']['details']['name'] ??
                                                                'Không xác định';
                                                            $supportFactors[] = "Trực tốt: Trực {$trucName}";
                                                        }

                                                        // Kiểm tra hợp tuổi chú rể
                                                        if (
                                                            isset($day['groom_score']['hopttuoi']) &&
                                                            $day['groom_score']['hopttuoi'] === true
                                                        ) {
                                                            $hopType = \App\Helpers\GoodBadDayHelper::getHopTuoiDetail(
                                                                $day['date'],
                                                                $groomInfo['dob']->year,
                                                            );
                                                            if ($hopType) {
                                                                $supportFactors[] = "Hợp tuổi chú rể: {$hopType}";
                                                            }
                                                        }

                                                        // Kiểm tra hợp tuổi cô dâu
                                                        if (
                                                            isset($day['bride_score']['hopttuoi']) &&
                                                            $day['bride_score']['hopttuoi'] === true
                                                        ) {
                                                            $hopType = \App\Helpers\GoodBadDayHelper::getHopTuoiDetail(
                                                                $day['date'],
                                                                $brideInfo['dob']->year,
                                                            );
                                                            if ($hopType) {
                                                                $supportFactors[] = "Hợp tuổi cô dâu: {$hopType}";
                                                            }
                                                        }

                                                        // Kiểm tra sao tốt chú rể
                                                        if (
                                                            isset($day['groom_score']['good_stars']) &&
                                                            !empty($day['groom_score']['good_stars'])
                                                        ) {
                                                            $starNames = implode(
                                                                ', ',
                                                                $day['groom_score']['good_stars'],
                                                            );
                                                            $supportFactors[] = "Sao tốt chú rể: {$starNames}";
                                                        }

                                                        // Kiểm tra sao tốt cô dâu
                                                        if (
                                                            isset($day['bride_score']['good_stars']) &&
                                                            !empty($day['bride_score']['good_stars'])
                                                        ) {
                                                            $starNames = implode(
                                                                ', ',
                                                                $day['bride_score']['good_stars'],
                                                            );
                                                            $supportFactors[] = "Sao tốt cô dâu: {$starNames}";
                                                        }

                                                        // Chỉ lấy tối đa 5 yếu tố
                                                        $supportFactors = array_slice(
                                                            array_unique($supportFactors),
                                                            0,
                                                            5,
                                                        );
                                                        $supportCount = count($supportFactors);
                                                    @endphp
                                                    @if ($supportCount > 0)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($supportFactors as $factor)
                                                                <li class="d-flex align-items-center mb-1">
                                                                    <span class="small">{{ $factor }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-warning small"
                                                            style="color: #2254AB !important">
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Không có yếu
                                                            tố hỗ trợ
                                                        </span>
                                                    @endif
                                                    
                                                    <!-- Wedding - Dual Score Circles cho mobile -->
                                                    <div class="score-circles-wedding">
                                                        <div class="score-circle-groom">
                                                            {{ round($day['groom_score']['percentage']) }}%
                                                        </div>
                                                        <div class="score-circle-bride">
                                                            {{ round($day['bride_score']['percentage']) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center score-battery-pc">
                                                   

                                                    <div class=" d-flex justify-content-center align-items-center">
                                                        <div class="battery">
                                                            <div>
                                                                <span>Điểm Chú rể</span>
                                                                <div class="battery-body"
                                                                    style="border:1px solid {{ $groomColor['border'] }}">
                                                                    <div class="battery-fill"
                                                                        style="width: {{ round($day['groom_score']['percentage']) }}%; background-color: {{ $groomColor['bg'] }}; ">
                                                                    </div>
                                                                    <div class="battery-label">
                                                                        {{ round($day['groom_score']['percentage']) }}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class=" d-flex justify-content-center align-items-center">
                                                        <div class="battery">
                                                            <div>
                                                                <span>Điểm Cô dâu</span>
                                                                <div class="battery-body"
                                                                    style="border:1px solid  {{ $brideColor['border'] }}">
                                                                    <div class="battery-fill"
                                                                        style="width: {{ round($day['bride_score']['percentage']) }}%; background-color: {{ $brideColor['bg'] }}; ">
                                                                    </div>
                                                                    <div class="battery-label">
                                                                        {{ round($day['bride_score']['percentage']) }}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
