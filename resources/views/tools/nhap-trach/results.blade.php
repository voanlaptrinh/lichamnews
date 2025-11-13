<div class="w-100">
    @if (isset($resultsByYear) && count($resultsByYear) > 0)
        <!-- Feng Shui Analysis Section -->
        <div class="card border-0 mb-3 w-100 box-detial-year">
            <div class="card-body box1-con-year">
                <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                        class="me-1"> Thông Tin Phong Thủy Nhà
                </div>
                @if (isset($birthdateInfo) && isset($huongNhaAnalysis))
                    <div class="row">
                        <div class="col-md-6">
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
                                    <strong>Giới tính:</strong>
                                    {{ $inputs['gioi_tinh'] === 'nam' ? 'Nam' : 'Nữ' }}
                                </p>
                                <p class="mb-2">
                                    <strong>Năm sinh âm lịch:</strong>
                                    {{ $birthdateInfo['lunar_birth_year'] }}
                                </p>
                                @php
                                    $currentYear = date('Y');
                                    $currentLunarAge = \App\Helpers\AstrologyHelper::getLunarAge(
                                        $birthdateInfo['lunar_birth_year'],
                                        $currentYear,
                                    );
                                @endphp
                                <p class="mb-2">
                                    <strong>Tuổi âm hiện tại:</strong>
                                    {{ $currentLunarAge }} tuổi (năm {{ $currentYear }})
                                </p>
                                <p class="mb-2">
                                    <strong>Cung mệnh:</strong>
                                    {{ $birthdateInfo['phong_thuy']['cung_menh'] }}
                                    ({{ $birthdateInfo['phong_thuy']['nhom'] }})
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="@if ($huongNhaAnalysis['is_good']) text-success @else text-danger @endif">
                                <h6>
                                    <strong>Hướng nhà: {{ $huongNhaAnalysis['direction_name'] }}</strong>
                                    @if ($huongNhaAnalysis['is_good'])
                                        <span class="badge bg-success ms-2">HỢP TUỔI</span>
                                    @else
                                        <span class="badge bg-danger ms-2">KHÔNG HỢP</span>
                                    @endif
                                </h6>
                                <p class="small">{{ $huongNhaAnalysis['description'] }}</p>

                                @if (!$huongNhaAnalysis['is_good'])
                                    <div class="mt-2">
                                        <small class="text-success">
                                            <strong>Hướng hợp tuổi:</strong>
                                            {{ collect($birthdateInfo['phong_thuy']['huong_tot'])->values()->implode(', ') }}
                                        </small>
                                    </div>
                                @endif
                                @if (!$huongNhaAnalysis['is_good'])
                                    <div class="card mt-2" style="background: #fffce1;">
                                        <div class="card-body pt-1 pb-1 " style="color: #d2941e;">
                                            Hướng nhà không thuộc nhóm hướng hợp mệnh của gia chủ. Nếu có điều kiện, gia
                                            chủ nên cân nhắc chọn các hướng khác trong nhóm phù hợp để mang lại nhiều
                                            may mắn và lợi nhuận hơn cho gia đình.
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
                            class="text-primary mb-1 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                height="28" class="me-1"> Kiểm tra Kim Lâu - Hoang Ốc - Tam Tai
                        </div>
                        <div class="info-grid">
                            <p class="mb-2">
                                Kiểm tra ngày tốt xấu và các yếu tố hỗ trợ cho việc nhập trạch năm {{ $year }}
                                {{ $yearData['canchi'] }}
                                của gia chủ tuổi {{ $birthdateInfo['can_chi_nam'] }}
                                ({{ $yearData['lunar_age'] }} tuổi âm).
                            </p>
                            <ul>
                                <li>{{ $yearData['year_analysis']['details']['kimLau']['is_bad'] ? 'Phạm Kim Lâu' : 'Không phạm Kim Lâu' }}
                                </li>
                                <li> {{ $yearData['year_analysis']['details']['hoangOc']['is_bad'] ? 'Phạm Hoang Ốc' : 'Không phạm Hoang Ốc' }}
                                </li>
                                <li>{{ $yearData['year_analysis']['details']['tamTai']['is_bad'] ? 'Phạm Tam Tai' : 'Không phạm Tam Tai' }}
                                </li>


                            </ul>
                            <p>{!! $yearData['year_analysis']['description'] !!}</p>

                            @if (isset($huongNhaAnalysis))
                                <div class="mt-3">
                                    <h6 class="text-primary text-dark" style="font-weight: 600">Kết luận phong thủy nhà:</h6>
                                    <p class="mb-0">{!! $huongNhaAnalysis['conclusion'] !!}</p>

                                    @if (!$huongNhaAnalysis['is_good'])
                                        <div class="mt-2">
                                            <small class="text-success">
                                                <strong>Hướng hợp tuổi:</strong>
                                                {{ collect($birthdateInfo['phong_thuy']['huong_tot'])->values()->implode(', ') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        <div class="betwen-ds mb-3 flex-wrap">
                            <div
                                class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> Danh Sách Điểm Theo Ngày
                            
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
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout"
                                    id="table-{{ $year }}" style=" width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Yếu tố hỗ trợ</th>
                                            <th style="border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($yearData['days'] as $day)
                                            @php
                                                $score = $day['day_score']['percentage'] ?? 0;
                                                $bgColor = '#D1FAE5'; // Green
                                                $score = round($score);
                                                if ($score <= 30) {
                                                    $bgColor = '#FEE2E2'; // Red
                                                    $border = '#DC2626';
                                                    $text_box = '#DC2626';
                                                } elseif ($score <= 50) {
                                                    $bgColor = '#FFE3D5'; // Yellow
                                                    $border = '#FC6803';
                                                    $text_box = '#FC6803';
                                                } elseif ($score <= 70) {
                                                    $bgColor = '#FEF3C7'; // Orange
                                                    $border = '#F59E0B';
                                                    $text_box = '#F59E0B';
                                                } else {
                                                    $border = '#10B981';
                                                    $text_box = '#10B981';
                                                }
                                            @endphp
                                            <tr>
                                                <td style="text-align: start">
                                                    <a
                                                        href="{{ route('nhap-trach.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'birthdate' => $birthdateInfo['dob']->format('Y-m-d'),
                                                            'date_range' => $inputs['date_range'] ?? '',
                                                            'gioi_tinh' => $inputs['gioi_tinh'] ?? 'nam',
                                                            'huong_nha' => $inputs['huong_nha'] ?? '',
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

                                                        // Kiểm tra ngày hoàng đạo
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

                                                        // Kiểm tra hợp tuổi
                                                        if (
                                                            isset($day['day_score']['hopttuoi']) &&
                                                            $day['day_score']['hopttuoi'] === true
                                                        ) {
                                                            $hopType = \App\Helpers\GoodBadDayHelper::getHopTuoiDetail(
                                                                $day['date'],
                                                                $birthdateInfo['dob']->year,
                                                            );
                                                            if ($hopType) {
                                                                $supportFactors[] = "Ngày hợp tuổi: {$hopType}";
                                                            }
                                                        }

                                                        // Kiểm tra sao tốt
                                                        if (
                                                            isset($day['day_score']['good_stars']) &&
                                                            !empty($day['day_score']['good_stars'])
                                                        ) {
                                                            $starNames = implode(', ', $day['day_score']['good_stars']);
                                                            $supportFactors[] = "Sao tốt: {$starNames}";
                                                        }

                                                        $supportFactors = array_slice(
                                                            array_unique($supportFactors),
                                                            0,
                                                            4,
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
                                                    <!-- Score hiển thị tròn cho mobile -->
                                                    <div class="score-circle-mobile"
                                                        style="background-color: white; border: 1px solid #2254AB">
                                                        {{ round($score) }}%
                                                    </div>
                                                </td>
                                                <td class="text-center score-battery-pc">

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
