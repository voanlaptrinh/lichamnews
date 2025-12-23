<div class="w-100" id="content-box-succes">
    <!-- Tabs cho các năm -->
    @if (isset($resultsByYear) && count($resultsByYear) > 0)

        <div class="box-tab-white mb-3">
            <div class="text-primary ms-2 mb-2 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                Khoảng thời gian xem
            </div>
            <div class="year-tabs ">

                <ul class="nav nav-pills">
                    @php $firstYear = true; @endphp
                    @foreach ($resultsByYear as $year => $yearData)
                        <li class="nav-item">
                            <a class="nav-link {{ $firstYear ? 'active' : '' }}" data-bs-toggle="pill"
                                href="#year-{{ $year }}"
                                style="border-radius: 20px; margin: 0 5px; padding: 8px 20px;">
                                <div class="text-center">
                                    <div><strong>{{ $year }}</strong> ({{ $yearData['canchi'] }})</div>
                                    @if (isset($yearData['date_range']))
                                        <small
                                            style="font-size: 0.8em; opacity: 0.8;">{{ $yearData['date_range'] }}</small>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @php $firstYear = false; @endphp
                    @endforeach
                </ul>
            </div>
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
                                <strong>Ngày sinh dương lịch:</strong>
                                {{ $groomInfo['dob']->format('d/m/Y') }}
                            </p>
                            <p class="mb-2">
                                <strong>Ngày sinh âm lịch:</strong>
                                {{ $groomInfo['lunar_dob_str'] }}
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
                            <p class="mb-1 fw-bolder">Kiểm tra hạn năm {{ $year }} của chú Rể
                            </p>
                            <p class="mb-0">
                                Kiểm tra xem năm {{ $year }} {{ $yearData['canchi'] }} Chú rể tuổi
                                {{ $groomInfo['can_chi_nam'] }} (
                                {{ $yearData['groom_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                Lâu, Hoang Ốc, Tam Tai không?
                            </p>
                            <ul class="mb-1">
                                <li>{{ $yearData['groom_analysis']['kim_lau']['is_bad'] ? 'Phạm Kim Lâu' : 'Không phạm Kim Lâu' }}
                                </li>
                                <li> {{ $yearData['groom_analysis']['hoang_oc']['is_bad'] ? 'Phạm Hoang Ốc' : 'Không phạm Hoang Ốc' }}
                                </li>
                                <li>{{ $yearData['groom_analysis']['tam_tai']['is_bad'] ? 'Phạm Tam Tai' : 'Không phạm Tam Tai' }}
                                </li>

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
                                <strong>Ngày sinh dương lịch:</strong>
                                {{ $brideInfo['dob']->format('d/m/Y') }}
                            </p>
                            <p class="mb-2">
                                <strong>Ngày sinh âm lịch:</strong>

                                {{ $brideInfo['lunar_dob_str'] }}
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
                            <p class="mb-1 fw-bolder">Kiểm tra hạn năm {{ $year }} của cô Dâu
                            </p>
                            <p class="mb-0">
                                Kiểm tra xem năm {{ $year }} {{ $yearData['canchi'] }} Cô Dâu tuổi
                                {{ $brideInfo['can_chi_nam'] }} (
                                {{ $yearData['bride_analysis']['lunar_age'] }} tuổi) có phạm phải Kim
                                Lâu, Hoang Ốc, Tam Tai không?
                            </p>
                            <ul class="mb-1">
                                <li>{{ $yearData['bride_analysis']['kim_lau']['is_bad'] ? 'Phạm Kim Lâu' : 'Không phạm Kim Lâu' }}
                                </li>
                                <li> {{ $yearData['bride_analysis']['hoang_oc']['is_bad'] ? 'Phạm Hoang Ốc' : 'Không phạm Hoang Ốc' }}
                                </li>
                                <li>{{ $yearData['bride_analysis']['tam_tai']['is_bad'] ? 'Phạm Tam Tai' : 'Không phạm Tam Tai' }}
                                </li>
                            </ul>
                            <p>Kết luận {!! $yearData['bride_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <!-- Filter and Sort Controls - trực tiếp trên table -->
                            <div class="betwen-ds flex-wrap mb-3">
                                <div class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                    <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem"
                                        width="28" height="28" class="me-1"> Gợi ý ngày tốt cho bạn
                                </div>
                                <div class="d-flex" style="gap: 10px">
                                    <div class="position-relative mb-3">
                                        <button type="button" class="taboo-filter-btn form-select-sm sort-select"
                                            data-year="{{ $year }}">
                                            <span>Lọc ngày kỵ</span>

                                            <i class="bi bi-chevron-down ms-2"></i>
                                        </button>
                                    </div>

                                    <!-- Sắp xếp tích hợp điểm và ngày -->
                                    <div>
                                        <select name="sort" class="form-select-sm sort-select"
                                            style="width: auto; height: 40px;">
                                            <option value="desc" selected>Điểm giảm dần</option>
                                            <option value="date_asc">Ngày tăng dần</option>
                                            <option value="date_desc">Ngày giảm dần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Status for this tab -->
                            <div id="filterStatus-{{ $year }}" class="alert alert-success d-none mb-3"
                                role="alert">
                                <i class="bi bi-funnel"></i>
                                <span id="filterStatusText-{{ $year }}"></span>
                            </div>

                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout"
                                    id="table-{{ $year }}" style=" width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Yếu tố hỗ trợ</th>
                                            <th style=" border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center table-body-{{ $year }}">
                                        @foreach ($yearData['days'] as $index => $day)
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
                                                } elseif ($groomScore < 70) {
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
                                                } elseif ($brideScore < 70) {
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

                                                $tabooTypes = [];
                                                if (
                                                    isset($day['groom_score']['checkTabooDays']['issues']) &&
                                                    is_array($day['groom_score']['checkTabooDays']['issues'])
                                                ) {
                                                    foreach (
                                                        $day['groom_score']['checkTabooDays']['issues']
                                                        as $issue
                                                    ) {
                                                        if (isset($issue['details']['tabooName'])) {
                                                            $tabooTypes[] = $issue['details']['tabooName'];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <tr class="table-row-{{ $year }}" data-index="{{ $index }}"
                                                style="{{ $index >= 10 ? 'display: none;' : '' }}"
                                                data-visible="{{ $index < 10 ? 'true' : 'false' }}"
                                                data-taboo-days="{{ implode(',', $tabooTypes) }}">
                                                <td style="text-align: start">
                                                    <a
                                                        href="{{ route('wedding.day.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'groom_dob' => $groomInfo['dob']->format('Y-m-d'),
                                                            'bride_dob' => $brideInfo['dob']->format('Y-m-d'),
                                                            'calendar_type' => $inputs['calendar_type'] ?? 'solar',
                                                            'khoang' => $inputs['wedding_date_range'] ?? '',
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
                                                                <div class="hv-memorial-lunar-calendar-info d-flex">
                                                                    <span>
                                                                        {{ $day['al_name'][0] ?? '' }}/{{ $day['al_name'][1] ?? '' }}
                                                                        ÂL</span> <i class="bi bi-chevron-right"></i>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </a>
                                                </td>
                                                <td style="text-align: start;position: relative">

                                                    @php
                                                        $supportFactors = [];

                                                        // Kiểm tra violations (phạm) trước
                                                        $violations = $day['groom_score']['pham']['issues'] ?? [];
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

                                                        if (
                                                            $day['groom_score']['tu']['details']['data']['nature'] ==
                                                            'Tốt'
                                                        ) {
                                                            $nameBatTu =
                                                                $day['groom_score']['tu']['details']['data']['name'];
                                                            $supportFactors[] = "Thập nhị bát tú: Sao {$nameBatTu}";
                                                        }

                                                        if (
                                                            $day['groom_score']['hopttuoi'] === true &&
                                                            $day['groom_score']['hopTuoiReason'] != 'Trùng (Đồng Chi)'
                                                        ) {
                                                            $supportFactors[] =
                                                                'Ngày hợp tuổi: ' .
                                                                $day['groom_score']['hopTuoiReason'];
                                                        }

                                                        // Kiểm tra ngày hoàng đạo - sử dụng helper
                                                        if (
                                                            isset($day['groom_score']['hoangdao']) &&
                                                            $day['groom_score']['hoangdao'] === true
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
                                                            isset($day['groom_score']['tructot']) &&
                                                            $day['groom_score']['tructot'] === true
                                                        ) {
                                                            $trucName =
                                                                $day['groom_score']['truc']['details']['name'] ??
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
                                                            $badTypes = [
                                                                'Lục xung',
                                                                'Tương hại',
                                                                'Tương phá',
                                                                'Tự hình',
                                                            ];

                                                            if (
                                                                $hopType &&
                                                                $hopType !== 'Trung bình (không xung, không hợp)' &&
                                                                !in_array($hopType, $badTypes)
                                                            ) {
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
                                                            $badTypes = [
                                                                'Lục xung',
                                                                'Tương hại',
                                                                'Tương phá',
                                                                'Tự hình',
                                                            ];

                                                            if (
                                                                $hopType &&
                                                                $hopType !== 'Trung bình (không xung, không hợp)' &&
                                                                !in_array($hopType, $badTypes)
                                                            ) {
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
                                                            $supportFactors[] = "Sao tốt: {$starNames}";
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
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Không có
                                                            yếu
                                                            tố hỗ trợ
                                                        </span>
                                                    @endif

                                                    <!-- Wedding - Dual Score Circles cho mobile -->
                                                    <div class="score-circles-wedding">
                                                        <div>
                                                            <span>C.Rể</span>
                                                            <div class="score-circle-groom">

                                                                {{ round($day['groom_score']['percentage']) }}%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span>C.Dâu</span>
                                                            <div class="score-circle-bride">
                                                                {{ round($day['bride_score']['percentage']) }}%
                                                            </div>
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

                                <!-- Nút xem thêm -->
                                @if (count($yearData['days']) > 10)
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-outline-primary load-more-btn"
                                            data-year="{{ $year }}" data-loaded="10"
                                            data-total="{{ count($yearData['days']) }}">

                                            Xem thêm
                                        </button>
                                    </div>
                                @endif

                                <!-- Nút xem năm tiếp theo -->
                                @php
                                    $currentYear = (int) $year;
                                    $nextYear = $currentYear + 1;
                                    $hasNextYear = false;
                                    foreach ($resultsByYear as $checkYear => $checkData) {
                                        if ((int) $checkYear === $nextYear) {
                                            $hasNextYear = true;
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($hasNextYear)
                                    <div class="text-center mt-3" id="next-year-container-{{ $year }}"
                                        style="display: none;">
                                        <button type="button" class="btn btn-success next-year-btn"
                                            data-current-year="{{ $year }}"
                                            data-next-year="{{ $nextYear }}">
                                            <i class="fas fa-arrow-right me-2"></i>Xem năm tiếp theo
                                            ({{ $nextYear }})
                                        </button>
                                    </div>
                                @endif
                                <div class="card-body box1-con-year pe-1 ps-1">
                                    <div class="text-primary mb-2  text-dark d-flex align-items-center p-3"
                                        style="border: 1px solid rgb(173, 173, 173);border-radius: 10px">
                                        ⚠️ Chú ý: Đây là các thông tin xem mang tính chất tham khảo, không thay thế cho
                                        các
                                        tư vấn
                                        chuyên môn. Người dùng tự chịu trách nhiệm với mọi quyết định cá nhân dựa trên
                                        thông
                                        tin
                                        tham khảo tại Phong Lịch.
                                    </div>

                                </div>
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

    <!-- Filter Modal/Dropdown - Global -->
    <div id="tabooFilterModal" class="taboo-filter-modal d-none">
        <div class="taboo-filter-header">
            <h6 class="mb-0">
                <i class="bi bi-heart" style="color: #e91e63;"></i>
                Lọc ngày kỵ
            </h6>
            <button type="button" id="closeFilterModal" class="btn-close-filter">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <div class="taboo-filter-body">
            <!-- Categories -->
            <div class="filter-section">
                <!-- Quick Actions -->
                <div class="filter-quick-actions">
                    <button type="button" id="selectCommon" class="btn-quick-action">Phổ biến</button>
                    <button type="button" id="selectAll" class="btn-quick-action">Tất cả</button>

                </div>

                <div class="filter-options">
                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Tam Nương" id="taboo1">
                        <span class="checkmark"></span>
                        <span class="option-text">Tam Nương</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Kỵ" id="taboo2">
                        <span class="checkmark"></span>
                        <span class="option-text">Nguyệt Kỵ</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Tận" id="taboo3">
                        <span class="checkmark"></span>
                        <span class="option-text">Nguyệt Tận</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Dương Công Kỵ Nhật" id="taboo4">
                        <span class="checkmark"></span>
                        <span class="option-text">Dương Công Kỵ Nhật</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Sát Chủ Âm" id="taboo5">
                        <span class="checkmark"></span>
                        <span class="option-text">Sát Chủ Âm</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Sát Chủ Dương" id="taboo6">
                        <span class="checkmark"></span>
                        <span class="option-text">Sát Chủ Dương</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Kim Thần Thất Sát" id="taboo7">
                        <span class="checkmark"></span>
                        <span class="option-text">Kim Thần Thất Sát</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Trùng Phục" id="taboo8">
                        <span class="checkmark"></span>
                        <span class="option-text">Trùng Phục</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Thụ Tử" id="taboo9">
                        <span class="checkmark"></span>
                        <span class="option-text">Thụ Tử</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Lục xung" id="taboo10">
                        <span class="checkmark"></span>
                        <span class="option-text">Lục Xung</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="taboo-filter-footer">
            <button type="button" id="clearTabooFilter" class="btn-cancel">Đặt lại</button>
            <button type="button" id="applyTabooFilter" class="btn-apply">Áp dụng</button>
        </div>
    </div>

    <!-- Backdrop -->
    <div id="tabooFilterBackdrop" class="taboo-filter-backdrop d-none"></div>
</div>

@include('components.taboo-filter-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Expose user's 'chi' to global scope for Luc Xung filter
        window.userChi = '{{ explode(' ', $groomInfo['can_chi_nam'] ?? '')[1] ?? '' }}';

        // Khởi tạo taboo filter với dữ liệu từ backend
        const resultsByYear = @json($resultsByYear ?? []);

        // Khởi tạo filter sau khi DOM loaded
        setTimeout(() => {
            if (typeof initTabooFilter === 'function') {
                initTabooFilter(resultsByYear);
            }
        }, 300);

        // Không cần cập nhật links vì filter đã được lưu trong localStorage
    });
</script>
