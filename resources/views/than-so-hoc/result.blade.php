@extends('welcome')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/thansohoc.css?v=11.6') }}">
    @endpush

    <div class="container-setup">
        <nav aria-label="breadcrumb" class="content-title-detail">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('hoptuoi.list') }}" style="color: #2254AB; text-decoration: underline;">Tiện ích</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thần số học
                </li>

            </ol>
        </nav>
        <h1 class="content-title-home-lich">Kết quả thần số học</h1>
        <div class="row g-lg-3 g-2 pt-lg-3 pt-2">
            <div class="col-xl-9 col-sm-12 col-12 ">
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="d-flex gap-2" style="align-items: center;">
                            <div>
                                <img src="{{ asset('images/avt_defund.svg') }}" alt="avt_defund" class="img-avt-defund">
                            </div>
                            <div style="font-weight: 700">
                                <p class="mb-1"> {{ $fullName }}</p>
                                <p class="mb-1"> Ngày sinh:
                                    {{ $birthDate['day'] }}/{{ $birthDate['month'] }}/{{ $birthDate['year'] }}</p>

                            </div>

                        </div>
                        <hr>
                        <p class="pb-0" style="font-style: italic;">“Cuộc sống vốn dĩ không công bằng, bạn phải học cách
                            quen dần
                            với điều đó”</p>
                    </div>
                </div>
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            Giải mã các chỉ số
                        </div>

                        {{-- New Grid Layout --}}
                        <div class="numerology-grid mt-4">
                            {{-- Top Row --}}
                            <div class="row g-3 mb-3">
                                {{-- Số Chủ Đạo --}}
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <div class="numerology-card master-number" style="cursor: pointer;">
                                        <div class="number-circle master-circle">
                                            <span
                                                class="number-text">{{ $profile['basic_numbers']['life_path']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Số Chủ Đạo</div>
                                    </div>
                                </div>

                                {{-- Số Linh Hồn --}}
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.soul_urge.detail', $profile['basic_numbers']['soul_urge']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['soul_urge']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Số Linh Hồn</div>
                                        </div>
                                    </a>
                                </div>

                                {{-- Số Tên --}}
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.expression.detail', $profile['basic_numbers']['expression']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['expression']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Số Tên</div>
                                        </div>
                                    </a>
                                </div>

                                {{-- Số Tính Cách --}}
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.personality.detail', $profile['basic_numbers']['personality']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['personality']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Số Tính Cách</div>
                                        </div>
                                    </a>
                                </div>

                                {{-- Năm Cá Nhân --}}
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.personal_year.detail', $profile['cycles_and_pinnacles']['personal_year']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['cycles_and_pinnacles']['personal_year']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Năm Cá Nhân</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.birth_day.detail', $profile['basic_numbers']['birth_day']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['birth_day']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Số Ngày Sinh</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.attitude.detail', $profile['basic_numbers']['attitude']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['attitude']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Thái Độ</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.birth_day.detail', $profile['basic_numbers']['birth_day']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['birth_day']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Tiềm năng</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                                    <a href="{{ route('numerology.maturity.detail', $profile['basic_numbers']['maturity']['number']) }}"
                                        class="text-decoration-none">
                                        <div class="numerology-card" style="cursor: pointer;">
                                            <div class="number-circle">
                                                <span
                                                    class="number-text">{{ $profile['basic_numbers']['maturity']['number'] }}</span>
                                            </div>
                                            <div class="card-label">Trưởng Thành</div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            Biểu đồ ngày sinh
                        </div>

                        {{-- Birth Date Chart Grid using existing logic --}}
                        <div class="birth-chart-container mt-4 d-flex justify-content-center">
                            @php
                                $birthChart = $profile['charts_and_patterns']['birth_chart'] ?? null;
                            @endphp

                            @if ($birthChart)
                                <div class="birth-chart-grid">


                                    {{-- 3x3 Grid --}}
                                    <div class="chart-grid mb-3">
                                        @if (isset($birthChart['chart_grid']) && is_array($birthChart['chart_grid']))
                                            @php
                                                // Rearrange grid to match screenshot: [3,6,9], [2,5,8], [1,4,7]
                                                // This represents bottom-to-top, left-to-right by column
                                                $rearrangedGrid = [];
                                                if (count($birthChart['chart_grid']) >= 3) {
                                                    // Row 0: 3, 6, 9 (top row in display)
                                                    $rearrangedGrid[0] = [
                                                        $birthChart['chart_grid'][0][2], // 3
                                                        $birthChart['chart_grid'][1][2], // 6
                                                        $birthChart['chart_grid'][2][2], // 9
                                                    ];
                                                    // Row 1: 2, 5, 8 (middle row in display)
                                                    $rearrangedGrid[1] = [
                                                        $birthChart['chart_grid'][0][1], // 2
                                                        $birthChart['chart_grid'][1][1], // 5
                                                        $birthChart['chart_grid'][2][1], // 8
                                                    ];
                                                    // Row 2: 1, 4, 7 (bottom row in display)
                                                    $rearrangedGrid[2] = [
                                                        $birthChart['chart_grid'][0][0], // 1
                                                        $birthChart['chart_grid'][1][0], // 4
                                                        $birthChart['chart_grid'][2][0], // 7
                                                    ];
                                                }
                                            @endphp
                                            @foreach ($rearrangedGrid as $rowIndex => $row)
                                                <div class="chart-row d-flex justify-content-center gap-1 mb-1">
                                                    @foreach ($row as $cell)
                                                        @php
                                                            $freq = $cell['frequency'] ?? 0;
                                                            $number = $cell['number'] ?? '';
                                                            $hasCount = $freq > 0;
                                                        @endphp
                                                        <div class="chart-cell {{ $hasCount ? 'has-number' : 'empty' }}">
                                                            @if ($hasCount)
                                                                <div class="numbers-container">
                                                                    @for ($i = 0; $i < $freq; $i++)
                                                                        <span
                                                                            class="number-item">{{ $number }}</span>
                                                                    @endfor
                                                                </div>
                                                            @else
                                                                <span class="empty-number">{{ $number }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    {{-- View Details Button --}}
                                    <div class="chart-actions text-center">
                                        <button class="btn btn-primary btn-detail" onclick="openBirthChartModal()">
                                            XEM CHI TIẾT
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Mũi Tên Cá Tính Box --}}
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            Mũi tên cá tính
                        </div>

                        {{-- Arrows Chart Grid using existing logic --}}
                        <div class="arrows-chart-container mt-4 d-flex justify-content-center">
                            @if (isset($profile['charts_and_patterns']['arrows']) && !empty($profile['charts_and_patterns']['arrows']))
                                @php
                                    $birthChart = $profile['charts_and_patterns']['birth_chart'] ?? null;
                                    $arrows = $profile['charts_and_patterns']['arrows'];
                                @endphp

                                <div class="arrows-chart-grid">
                                    {{-- 3x3 Grid using birth chart data --}}
                                    <div class="arrows-grid-visual mb-3">
                                        @if (isset($birthChart['chart_grid']) && is_array($birthChart['chart_grid']))
                                            @php
                                                // Same rearrangement as birth chart
                                                $rearrangedGrid = [];
                                                if (count($birthChart['chart_grid']) >= 3) {
                                                    // Row 0: 3, 6, 9 (top row in display)
                                                    $rearrangedGrid[0] = [
                                                        $birthChart['chart_grid'][0][2], // 3
                                                        $birthChart['chart_grid'][1][2], // 6
                                                        $birthChart['chart_grid'][2][2], // 9
                                                    ];
                                                    // Row 1: 2, 5, 8 (middle row in display)
                                                    $rearrangedGrid[1] = [
                                                        $birthChart['chart_grid'][0][1], // 2
                                                        $birthChart['chart_grid'][1][1], // 5
                                                        $birthChart['chart_grid'][2][1], // 8
                                                    ];
                                                    // Row 2: 1, 4, 7 (bottom row in display)
                                                    $rearrangedGrid[2] = [
                                                        $birthChart['chart_grid'][0][0], // 1
                                                        $birthChart['chart_grid'][1][0], // 4
                                                        $birthChart['chart_grid'][2][0], // 7
                                                    ];
                                                }
                                            @endphp
                                            @foreach ($rearrangedGrid as $rowIndex => $row)
                                                <div class="arrows-row d-flex justify-content-center gap-1 mb-1">
                                                    @foreach ($row as $cell)
                                                        @php
                                                            $freq = $cell['frequency'] ?? 0;
                                                            $number = $cell['number'] ?? '';
                                                            $hasCount = $freq > 0;
                                                        @endphp
                                                        <div class="arrows-cell {{ $hasCount ? 'has-number' : 'empty' }}"
                                                            data-number="{{ $number }}">
                                                            @if ($hasCount)
                                                                <div class="arrows-numbers-container">
                                                                    @for ($i = 0; $i < $freq; $i++)
                                                                        <span
                                                                            class="arrows-number-item">{{ $number }}</span>
                                                                    @endfor
                                                                </div>
                                                            @else
                                                                <span
                                                                    class="arrows-empty-number">{{ $number }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach

                                            {{-- Arrow Overlays --}}
                                            <div class="arrows-overlay">
                                                @php
                                                    $arrowConfigs = [
                                                        // Diagonals
                                                        [
                                                            'numbers' => [1, 5, 9],
                                                            'class' => 'diagonal',
                                                            'style' =>
                                                                'top: 50%; left: 50%; width: 141%; transform: translate(-50%, -50%) rotate(-45deg);',
                                                            'name' => 'Mũi tên Quyết tâm',
                                                        ],
                                                        [
                                                            'numbers' => [3, 5, 7],
                                                            'class' => 'diagonal-reverse',
                                                            'style' =>
                                                                'top: 50%; left: 50%; width: 141%; transform: translate(-50%, -50%) rotate(45deg);',
                                                            'name' => 'Mũi tên Nhạy bén Tâm linh',
                                                        ],
                                                        // Verticals (based on displayed grid columns)
                                                        [
                                                            'numbers' => [1, 2, 3],
                                                            'class' => 'vertical',
                                                            'style' => 'left: 51px; top: 141px; width: 100%;',
                                                            'name' => 'Mũi tên Kế hoạch',
                                                        ],
                                                        [
                                                            'numbers' => [4, 5, 6],
                                                            'class' => 'vertical',
                                                            'style' =>
                                                                'left: 50%; top: 0; height: 100%; width: 100%;transform: rotate(270deg);',
                                                            'name' => 'Mũi tên Ý chí',
                                                        ],
                                                        [
                                                            'numbers' => [7, 8, 9],
                                                            'class' => 'vertical',
                                                            'style' =>
                                                                'right: 16.66%; top: 0; height: 100%; width: 5px;',
                                                            'name' => 'Mũi tên Hoạt động',
                                                        ],
                                                        // Horizontals (based on displayed grid rows)
                                                        [
                                                            'numbers' => [3, 6, 9],
                                                            'class' => 'horizontal',
                                                            'style' => 'top: 16.66%; width: 100%; height: 5px;',
                                                            'name' => 'Mũi tên Trí tuệ',
                                                        ],
                                                        [
                                                            'numbers' => [2, 5, 8],
                                                            'class' => 'horizontal',
                                                            'style' =>
                                                                'top: 50%; left: 0; width: 100%; height: 5px; transform: translateY(-50%);',
                                                            'name' => 'Mũi tên Cảm xúc',
                                                        ],
                                                        [
                                                            'numbers' => [1, 4, 7],
                                                            'class' => 'horizontal',
                                                            'style' =>
                                                                'right: 0; left: 32%; width: 100%; transform: translateY(270deg);',
                                                            'name' => 'Mũi tên Thực tế',
                                                        ],
                                                    ];

                                                    // Map server data to the correct arrow definitions
                                                    $presentArrows = [];
                                                    foreach ($arrows['arrows'] as $arrowFromServer) {
                                                        if (($arrowFromServer['type'] ?? '') === 'present') {
                                                            $presentArrows[] = $arrowFromServer['numbers'] ?? [];
                                                        }
                                                    }
                                                @endphp

                                                @foreach ($arrowConfigs as $config)
                                                    @php
                                                        $isPresent = false;
                                                        foreach ($presentArrows as $presentArrow) {
                                                            if (
                                                                count(
                                                                    array_intersect($config['numbers'], $presentArrow),
                                                                ) === 3
                                                            ) {
                                                                $isPresent = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($isPresent)
                                                        <div class="arrow-overlay {{ $config['class'] }}"
                                                            data-arrow="{{ $config['name'] }}"
                                                            style="position: absolute; {{ $config['style'] }}">
                                                            <div class="arrow-visual-line active"></div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>



                                    {{-- View Details Button --}}
                                    <div class="arrows-actions text-center">
                                        @php
                                            $hasPresentArrows = false;
                                            foreach ($arrows['arrows'] as $arrowFromServer) {
                                                if (($arrowFromServer['type'] ?? '') === 'present') {
                                                    $hasPresentArrows = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <button
                                            class="btn btn-primary btn-detail {{ !$hasPresentArrows ? 'disabled' : '' }}"
                                            onclick="{{ $hasPresentArrows ? 'openArrowsModal()' : '' }}"
                                            {{ !$hasPresentArrows ? 'disabled' : '' }}>
                                            XEM CHI TIẾT
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="no-arrows text-center py-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <span>Chưa có dữ liệu mũi tên cá tính</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            4 giai đoạn đỉnh cao cuộc đời
                        </div>



                        {{-- New Grid Layout --}}
                        <div class="numerology-grid mt-4 d-flex justify-content-center">
                            @php
                                // Khởi tạo biến mặc định
                                $pinnacleNumbers = [1, 2, 3, 4]; // fallback
                                $pinnacleRanges = ['0-35 tuổi', '36-44 tuổi', '45-53 tuổi', '54+ tuổi']; // fallback

                                // Lấy dữ liệu từ backend
                                $pinnacles = $profile['cycles_and_pinnacles']['life_pinnacles'] ?? null;

                                if ($pinnacles && isset($pinnacles['pinnacles'])) {
                                    $pinnacleList = array_values($pinnacles['pinnacles']);

                                    // Đảm bảo có đủ 4 phần tử
                                    for ($i = 0; $i < 4; $i++) {
                                        if (isset($pinnacleList[$i]['number'])) {
                                            $pinnacleNumbers[$i] = $pinnacleList[$i]['number'];
                                        }
                                        if (isset($pinnacleList[$i]['age_range'])) {
                                            $pinnacleRanges[$i] = $pinnacleList[$i]['age_range'];
                                        }
                                    }
                                }

                                // Tính đáy kim tự tháp
                                $birthMonth = $birthDate['month'] ?? 1;
                                $birthDay = $birthDate['day'] ?? 1;
                                $birthYear = $birthDate['year'] ?? 2000;

                                // Rút gọn đơn giản
                                $monthSum = array_sum(str_split((string) $birthMonth));
                                $daySum = array_sum(str_split((string) $birthDay));
                                $yearSum = array_sum(str_split((string) $birthYear));

                                while ($yearSum > 9) {
                                    $yearSum = array_sum(str_split((string) $yearSum));
                                }

                                $baseComponents = [$monthSum, $daySum, $yearSum];
                            @endphp

                            <div class="chart-container">
                                <!-- Đường nối -->
                                <svg class="lines-svg">
                                    <!-- Khung lớn bên ngoài -->
                                    <line x1="10%" y1="78%" x2="50%" y2="18%" />
                                    <!-- Trái lên đỉnh -->
                                    <line x1="90%" y1="78%" x2="50%" y2="18%" />
                                    <!-- Phải lên đỉnh -->

                                    <!-- Các khối kim tự tháp nhỏ -->
                                    <line x1="10%" y1="78%" x2="35%" y2="56%" />
                                    <!-- Base L -> I -->
                                    <line x1="50%" y1="78%" x2="35%" y2="56%" />
                                    <!-- Base M -> I -->
                                    <line x1="50%" y1="78%" x2="65%" y2="56%" />
                                    <!-- Base M -> II -->
                                    <line x1="90%" y1="78%" x2="65%" y2="56%" />
                                    <!-- Base R -> II -->

                                    <line x1="35%" y1="56%" x2="50%" y2="38%" />
                                    <!-- I -> III -->
                                    <line x1="65%" y1="56%" x2="50%" y2="38%" />
                                    <!-- II -> III -->

                                    <line x1="50%" y1="38%" x2="50%" y2="18%" />
                                    <!-- III -> IV -->
                                </svg>

                                <!-- Đỉnh IV -->
                                <div class="node n-iv">
                                    <div class="roman">IV</div>{{ $pinnacleNumbers[3] }}
                                </div>
                                <div class="date-label d-2056">{{ $pinnacleRanges[3] }}</div>

                                <!-- Tầng III -->
                                <div class="node n-iii">
                                    <div class="roman">III</div>{{ $pinnacleNumbers[2] }}
                                </div>
                                <div class="date-label d-2047">{{ $pinnacleRanges[2] }}</div>

                                <!-- Tầng I & II -->
                                <div class="node n-i">
                                    <div class="roman">I</div>{{ $pinnacleNumbers[0] }}
                                </div>
                                <div class="date-label d-2002">{{ $pinnacleRanges[0] }}</div>

                                <div class="node n-ii">
                                    <div class="roman">II</div>{{ $pinnacleNumbers[1] }}
                                </div>
                                <div class="date-label d-2038">{{ $pinnacleRanges[1] }}</div>

                                <!-- Hàng Đáy -->
                                <div class="node n-base-l">
                                    {{ $baseComponents[0] }} <div class="label">Tháng
                                        {{ str_pad($birthMonth, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                <div class="node n-base-m">
                                    {{ $baseComponents[1] }} <div class="label">Ngày
                                        {{ str_pad($birthDay, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                <div class="node n-base-r">
                                    {{ $baseComponents[2] }} <div class="label">{{ $birthYear }}</div>
                                </div>
                            </div>

                        </div>


                        <div class="pinnacle-overview-btn" style="display: flex; justify-content: center;">
                            <a href="{{ route('numerology.pinnacle.overview', ['day' => $birthDate['day'], 'month' => $birthDate['month'], 'year' => $birthDate['year']]) }}"
                                class="btn btn-primary btn-detail">
                                XEM CHI TIẾT
                            </a>
                        </div>


                    </div>
                </div>

                {{-- Chu kì 9 năm Box --}}
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            @php
                                $cycle = $profile['cycles_and_pinnacles']['nine_year_cycle'] ?? null;
                                $currentYear = date('Y');
                                $personalYear = $profile['cycles_and_pinnacles']['personal_year']['number'] ?? 1;
                            @endphp
                            @if ($cycle)
                                Chu kì 9 năm ({{ $cycle['start_year'] }} - {{ $cycle['end_year'] }})
                            @else
                                Chu kì 9 năm
                            @endif
                        </div>

                        <div class="personal-year-highlight">
                            Năm cá nhân hiện tại của bạn là: <strong>{{ $personalYear }}</strong>
                        </div>

                        <div class="nine-year-wrapper mt-4">
                            @if ($cycle && isset($cycle['cycles']))
                                @foreach ($cycle['cycles'] as $yearData)
                                    @php
                                        $isCurrent = $yearData['year'] == $currentYear;
                                    @endphp
                                    <div class="nine-year-card {{ $isCurrent ? 'current' : '' }}"
                                        onclick="window.location.href='{{ route('numerology.personal_year.detail', $yearData['personal_year']) }}'">
                                        <div class="year-label">{{ $yearData['year'] }}</div>
                                        <div class="personal-year-number">{{ $yearData['personal_year'] }}</div>
                                        <div class="year-phase">{{ $yearData['phase'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="cycle-actions text-center mt-4">
                            {{-- <a href="{{ route('numerology.personal_year.overview', ['day' => $birthDate['day'], 'month' => $birthDate['month'], 'year' => $birthDate['year']]) }}"
                                class="btn btn-primary btn-detail">
                                XEM CHI TIẾT
                            </a> --}}
                        </div>
                    </div>
                </div>

                {{-- Nghiệp quả Box --}}
                <div class="box--bg-thang mb-3" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            Nghiệp quả
                        </div>

                        @php
                            $karmicDebt = $profile['karmic_influences']['karmic_debt'] ?? null;
                        @endphp

                        {{-- Karmic Debt Section --}}
                        @if ($karmicDebt)
                            @if ($karmicDebt['has_karmic_debt'])
                                <div class="karmic-debt-detailed">
                                    @foreach ($karmicDebt['karmic_debts'] as $debt)
                                        <div class="personal-year-highlight">
                                            Bạn có nghiệp quả:
                                            <strong>{{ $debt['number_nghiep'] ?? 'Nghiệp Quả ' }}</strong>
                                        </div>
                                        <div class="karmic-debt-full-card">
                                            <div class="debt-header">

                                                <div class="debt-title">
                                                    {{ $debt['title'] ?? 'Nghiệp Quả ' . $debt['number'] }}</div>

                                            </div>


                                            <div class="debt-content">
                                                <div class="debt-interpretation">

                                                    <p>{{ $debt['prominentCharacteristics'] }}</p>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-karmic-debt">
                                    <div class="personal-year-highlight">
                                        Bạn Không Có Số Nghiệp Quả
                                    </div>
                                    <div class="karmic-debt-full-card mt-3">
                                        <div class="debt-content">
                                            <div class="debt-interpretation">
                                                <p>{{ $karmicDebt['interpretation'] ?? 'Điều này có nghĩa là bạn đã hoàn thành tốt các bài học từ những kiếp trước và không mang theo những nghiệp quả nặng nề cần giải quyết trong kiếp này.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif

                        @endif



                        {{-- View Details Button --}}
                        <div class="karmic-actions text-center mt-4">
                            <button class="btn btn-primary btn-detail" onclick="openKarmicModal()">
                                XEM CHI TIẾT
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>











    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
        <div class="container mx-auto px-4 py-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">🔮 Kết Quả Thần Số Học</h1>
                <div class="bg-white rounded-2xl shadow-lg p-6 inline-block">
                    <h2 class="text-2xl font-bold text-blue-600 mb-2">{{ $fullName }}</h2>
                    <p class="text-gray-600">
                        Ngày sinh: {{ $birthDate['day'] }}/{{ $birthDate['month'] }}/{{ $birthDate['year'] }}
                        • {{ $request->gender == 'male' ? 'Nam' : 'Nữ' }}
                    </p>
                </div>
            </div>

            {{-- Navigation Tabs --}}
            <div class="mb-8">
                <div class="flex flex-wrap justify-center gap-2 bg-white rounded-xl p-2 shadow-lg max-w-4xl mx-auto">
                    <button onclick="showTab('basic')" class="tab-btn active" id="basic-tab">📊 Các Số Cơ Bản</button>
                    <button onclick="showTab('cycles')" class="tab-btn" id="cycles-tab">⏰ Chu Kỳ & Đỉnh Cao</button>
                    <button onclick="showTab('charts')" class="tab-btn" id="charts-tab">📈 Biểu Đồ & Mui Tên</button>
                    <button onclick="showTab('karmic')" class="tab-btn" id="karmic-tab">🎭 Nghiệp Quả</button>
                    <button onclick="showTab('abilities')" class="tab-btn" id="abilities-tab">🎯 Năng Lực</button>
                    <button onclick="showTab('lucky')" class="tab-btn" id="lucky-tab">🍀 May Mắn</button>
                </div>
            </div>

            {{-- Tab Content --}}
            <div class="max-w-7xl mx-auto">
                {{-- 1. CÁC SỐ CƠ BẢN --}}
                <div id="basic-content" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($profile['basic_numbers'] as $type => $data)
                            @php
                                $titles = [
                                    'life_path' => ['title' => 'Số Chủ Đạo', 'icon' => '🌟', 'color' => 'blue'],
                                    'birth_day' => ['title' => 'Số Ngày Sinh', 'icon' => '📅', 'color' => 'green'],
                                    'expression' => ['title' => 'Số Tên', 'icon' => '💭', 'color' => 'purple'],
                                    'soul_urge' => ['title' => 'Số Linh Hồn', 'icon' => '❤️', 'color' => 'red'],
                                    'personality' => ['title' => 'Số Tính Cách', 'icon' => '🎭', 'color' => 'yellow'],
                                    'attitude' => ['title' => 'Số Thái Độ', 'icon' => '😊', 'color' => 'indigo'],
                                    'maturity' => ['title' => 'Số Trưởng Thành', 'icon' => '🌱', 'color' => 'pink'],
                                ];
                                $config = $titles[$type];
                            @endphp

                            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                                <div class="flex items-center mb-4">
                                    <span class="text-3xl mr-3">{{ $config['icon'] }}</span>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">{{ $config['title'] }}</h3>
                                        <div class="flex items-center">
                                            <span
                                                class="bg-{{ $config['color'] }}-500 text-white text-2xl font-bold px-4 py-2 rounded-full mr-3">
                                                {{ $data['number'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">Cách tính:</h4>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $data['calculation'] }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">Ý nghĩa:</h4>
                                    <p class="text-gray-700 line-clamp-3">{{ Str::limit($data['interpretation'], 150) }}
                                    </p>
                                </div>

                                <div class="text-center">
                                    @php
                                        $routeNames = [
                                            'life_path' => null, // Life path doesn't have separate detail page yet
    'birth_day' => 'numerology.birth_day.detail',
    'expression' => 'numerology.expression.detail',
    'soul_urge' => 'numerology.soul_urge.detail',
    'personality' => 'numerology.personality.detail',
    'attitude' => 'numerology.attitude.detail',
    'maturity' => 'numerology.maturity.detail',
                                        ];
                                    @endphp
                                    @if (isset($routeNames[$type]) && $routeNames[$type])
                                        <a href="{{ route($routeNames[$type], $data['number']) }}"
                                            class="bg-{{ $config['color'] }}-500 hover:bg-{{ $config['color'] }}-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                            📖 Xem chi tiết
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. CHU KỲ VÀ ĐỈNH CAO --}}
                <div id="cycles-content" class="tab-content hidden">
                    {{-- Personal Year --}}
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="mr-3">📆</span>
                            Năm Cá Nhân {{ $profile['cycles_and_pinnacles']['personal_year']['year'] }}
                        </h3>
                        <div class="flex items-center mb-4">
                            <span class="bg-blue-500 text-white text-4xl font-bold px-6 py-3 rounded-full mr-6">
                                {{ $profile['cycles_and_pinnacles']['personal_year']['number'] }}
                            </span>
                            <div>
                                <p class="text-gray-700 text-lg">
                                    {{ $profile['cycles_and_pinnacles']['personal_year']['interpretation'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Life Pinnacles --}}
                    @php $pinnacles = $profile['cycles_and_pinnacles']['life_pinnacles']; @endphp
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="mr-3">🏔️</span>
                            4 Đỉnh Cao Cuộc Đời
                        </h3>

                        <div class="mb-6 text-center">
                            <p class="text-lg text-gray-700">
                                <strong>Tuổi hiện tại:</strong> {{ $pinnacles['current_age'] }}
                                (Đang ở <strong class="text-blue-600">Đỉnh cao
                                    {{ $pinnacles['current_pinnacle'] }}</strong>)
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($pinnacles['pinnacles'] as $i => $pinnacle)
                                @php $isActive = ($i == $pinnacles['current_pinnacle']); @endphp
                                <div
                                    class="text-center p-6 rounded-xl {{ $isActive ? 'bg-gradient-to-br from-green-500 to-green-600 text-white' : 'bg-gray-100' }}">
                                    <h4 class="text-lg font-bold mb-2">Đỉnh {{ $i }}</h4>
                                    <div class="text-4xl font-bold mb-2">{{ $pinnacle['number'] }}</div>
                                    <p class="text-sm mb-2">{{ $pinnacle['age_range'] }} tuổi</p>
                                    <p class="text-xs {{ $isActive ? 'text-green-100' : 'text-gray-600' }}">
                                        {{ $pinnacle['phase'] }}</p>
                                    @if ($isActive)
                                        <div class="mt-3 bg-green-400 bg-opacity-30 p-2 rounded">
                                            <p class="text-xs">Hiện tại</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Nine Year Cycle --}}
                    @php $cycle = $profile['cycles_and_pinnacles']['nine_year_cycle']; @endphp
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="mr-3">🔄</span>
                            Chu Kỳ 9 Năm ({{ $cycle['start_year'] }} - {{ $cycle['end_year'] }})
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-9 gap-3">
                            @foreach ($cycle['cycles'] as $yearData)
                                @php $isCurrent = ($yearData['year'] == date('Y')); @endphp
                                <a href="{{ route('numerology.personal_year.detail', $yearData['personal_year']) }}"
                                    class="block text-center p-4 rounded-lg transition-all duration-200 hover:scale-105 hover:shadow-md {{ $isCurrent ? 'bg-gradient-to-br from-yellow-400 to-yellow-500 text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                                    <div class="font-bold text-lg">{{ $yearData['year'] }}</div>
                                    <div class="text-3xl font-bold my-2">{{ $yearData['personal_year'] }}</div>
                                    <div class="text-xs">{{ $yearData['phase'] }}</div>
                                    @if ($isCurrent)
                                        <div class="mt-2 bg-yellow-300 bg-opacity-50 px-2 py-1 rounded text-xs">
                                            Hiện tại
                                        </div>
                                    @endif
                                    <div class="mt-2 text-xs {{ $isCurrent ? 'text-yellow-100' : 'text-gray-500' }}">
                                        👆 Xem chi tiết
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 3. BIỂU ĐỒ VÀ MUI TÊN --}}
                <div id="charts-content" class="tab-content hidden">
                    @php
                        $birthChart = $profile['charts_and_patterns']['birth_chart'];
                        $arrows = $profile['charts_and_patterns']['arrows'];
                    @endphp

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- Birth Chart --}}
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">📊</span>
                                Biểu Đồ Ngày Sinh
                            </h3>

                            <div class="text-center mb-6">
                                <p class="text-gray-600">Chuỗi ngày sinh:
                                    <strong>{{ $birthChart['birth_date_string'] }}</strong>
                                </p>
                            </div>

                            {{-- 3x3 Grid --}}
                            <div class="grid grid-cols-3 gap-2 max-w-xs mx-auto mb-6">
                                @foreach ($birthChart['chart_grid'] as $row)
                                    @foreach ($row as $cell)
                                        @php
                                            $freq = $cell['frequency'];
                                            $bgColor =
                                                $freq == 0
                                                    ? 'bg-red-100 text-red-600'
                                                    : ($freq >= 3
                                                        ? 'bg-green-100 text-green-600'
                                                        : 'bg-gray-100 text-gray-700');
                                        @endphp
                                        <div
                                            class="w-20 h-20 border-2 border-gray-300 flex flex-col items-center justify-center {{ $bgColor }}">
                                            <div class="text-2xl font-bold">{{ $cell['number'] }}</div>
                                            <div class="text-sm">({{ $freq }})</div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>

                            {{-- Frequency Interpretations --}}
                            @if (!empty($birthChart['frequency_interpretations']))
                                @php
                                    $nonZeroInterpretations = array_filter(
                                        $birthChart['frequency_interpretations'],
                                        function ($interpretation) {
                                            return $interpretation['frequency'] > 0;
                                        },
                                    );
                                @endphp
                                @if (!empty($nonZeroInterpretations))
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-blue-600 mb-3">Diễn giải theo tần suất:</h4>
                                        <div class="space-y-3 max-h-80 overflow-y-auto">
                                            @foreach ($nonZeroInterpretations as $interpretation)
                                                <div class="bg-gray-50 border-l-4 border-blue-400 p-3 rounded">
                                                    <h5 class="font-bold text-gray-800 mb-1">
                                                        {{ $interpretation['interpretation']['summary'] }}</h5>
                                                    <p class="text-sm text-gray-700 leading-relaxed">
                                                        {{ $interpretation['interpretation']['meaning'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            {{-- Dominant Numbers --}}
                            @if (!empty($birthChart['dominant_numbers']))
                                <div>
                                    <h4 class="font-semibold text-green-600 mb-2">Số tiềm năng:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($birthChart['dominant_numbers'] as $data)
                                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                {{ $data['number'] }} ({{ $data['frequency'] }})
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Arrows --}}
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">🏹</span>
                                Mui Tên Cá Tính
                            </h3>

                            <div class="space-y-4">
                                @foreach ($arrows['arrows'] as $arrow)
                                    @php
                                        $isPresent = $arrow['type'] == 'present';
                                        $bgColor = $isPresent
                                            ? 'bg-green-50 border-green-200'
                                            : 'bg-red-50 border-red-200';
                                        $textColor = $isPresent ? 'text-green-800' : 'text-red-800';
                                        $icon = $isPresent ? '✅' : '⚠️';
                                    @endphp
                                    <div class="p-4 rounded-lg border-2 {{ $bgColor }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold {{ $textColor }}">
                                                {{ $icon }}
                                                {{ $arrow['interpretation']['title'] ?? 'Mũi tên không xác định' }}
                                            </h4>
                                            <span
                                                class="text-sm {{ $textColor }} font-mono">{{ implode('-', $arrow['numbers']) }}</span>
                                        </div>
                                        <div class="space-y-3">
                                            <p class="text-sm {{ $textColor }}">
                                                {{ $arrow['interpretation']['description'] ?? '' }}</p>

                                            @if (isset($arrow['interpretation']['strengths']) && !empty($arrow['interpretation']['strengths']))
                                                <div class="text-sm">
                                                    <span class="font-semibold {{ $textColor }}">✨ Điểm mạnh:</span>
                                                    <span
                                                        class="{{ $textColor }}">{{ implode(', ', $arrow['interpretation']['strengths']) }}</span>
                                                </div>
                                            @endif

                                            @if (isset($arrow['interpretation']['challenges']) && !empty($arrow['interpretation']['challenges']))
                                                <div class="text-sm">
                                                    <span class="font-semibold {{ $textColor }}">⚡ Thách thức:</span>
                                                    <span
                                                        class="{{ $textColor }}">{{ implode(', ', $arrow['interpretation']['challenges']) }}</span>
                                                </div>
                                            @endif

                                            @if (isset($arrow['interpretation']['advice']) && !empty($arrow['interpretation']['advice']))
                                                <div class="text-sm">
                                                    <span class="font-semibold {{ $textColor }}">💡 Lời khuyên:</span>
                                                    <span
                                                        class="{{ $textColor }}">{{ $arrow['interpretation']['advice'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. NGHIỆP QUẢ --}}
                <div id="karmic-content" class="tab-content hidden">
                    @php
                        $karmicLessons = $profile['karmic_influences']['karmic_lessons'];
                        $karmicDebt = $profile['karmic_influences']['karmic_debt'];
                    @endphp

                    {{-- BÀI HỌC CẦN HỌC --}}
                    <div class="karmic-section">
                        <div class="karmic-header">
                            <span class="karmic-icon">📚</span>
                            <h3>Bài Học Cần Học (Số Thiếu Hụt)</h3>
                        </div>

                        @if (!empty($karmicLessons['missing_numbers']))
                            <div class="karmic-numbers-container">
                                <p>Các số bạn thiếu hụt trong tên, đại diện cho những bài học bạn cần tập trung trong
                                    cuộc đời này:</p>
                                <div class="numbers-grid">
                                    @foreach ($karmicLessons['missing_numbers'] as $num)
                                        <div class="karmic-number-card lesson">
                                            <span class="number">{{ $num }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="interpretations-list">
                                @foreach ($karmicLessons['karmic_lessons'] as $lesson)
                                    <div class="interpretation-card lesson-interp">
                                        <h4 class="interp-title">{{ $lesson['title'] }}</h4>
                                        <p class="interp-meaning">{{ $lesson['meaning'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-karmic-data">
                                <span class="icon">✅</span>
                                <p class="title">Bạn không có số thiếu hụt nào!</p>
                                <p class="description">Điều này cho thấy bạn đã có đầy đủ kinh nghiệm từ các kiếp trước
                                    và không có bài học nghiệp quả lớn nào cần phải giải quyết thông qua các con số bị
                                    thiếu.</p>
                            </div>
                        @endif
                    </div>

                    {{-- NGHIỆP QUẢ --}}
                    <div class="karmic-section">
                        <div class="karmic-header">
                            <span class="karmic-icon">⚖️</span>
                            <h3>Nghiệp Quả (Nợ Nghiệp)</h3>
                        </div>

                        {{-- @if ($karmicDebt['has_karmic_debt'])
                            <div class="karmic-numbers-container">
                                <p>Các số nợ nghiệp của bạn, cho thấy những thách thức cụ thể bạn cần vượt qua do những
                                    hành động trong quá khứ:</p>
                                <div class="numbers-grid">
                                    @foreach ($karmicDebt['karmic_debts'] as $debt)
                                        <div class="karmic-number-card debt">
                                            <span class="number">{{ $debt['number'] }}</span>
                                            <span class="source">Từ: {{ $debt['source'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="interpretations-list">
                                @foreach ($karmicDebt['karmic_debts'] as $debt)
                                    <div class="interpretation-card debt-interp">
                                        <h4 class="interp-title">Diễn giải cho Nợ Nghiệp {{ $debt['number'] }}</h4>
                                        <p class="interp-meaning">{{ $debt['interpretation'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-karmic-data">
                                <span class="icon">✨</span>
                                <p class="title">{{ $karmicDebt['interpretation'] }}</p>
                                <p class="description">Bạn không mang theo gánh nặng của các con số nợ nghiệp lớn.
                                    Điều này cho phép bạn tiến về phía trước với ít trở ngại nghiệp quả hơn.</p>
                            </div>
                        @endif --}}
                    </div>
                </div>

                {{-- 5. NĂNG LỰC BẨM SINH --}}
                <div id="abilities-content" class="tab-content hidden">

                    @if (isset($profile['abilities']) && isset($profile['abilities']['innate_abilities']))
                        @php $abilities = $profile['abilities']['innate_abilities']; @endphp

                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">🎯</span>
                                4 Năng Lực Bẩm Sinh
                            </h3>

                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    4 năng lực bẩm sinh được tính dựa trên các chữ cái trong tên của bạn, phản ánh những khả
                                    năng tự nhiên mà bạn sở hữu từ khi sinh ra.
                                </p>
                            </div>

                            @php
                                $abilityNames = [
                                    'physical' => 'Thể chất',
                                    'emotional' => 'Cảm xúc',
                                    'intellectual' => 'Trí tuệ',
                                    'spiritual' => 'Tinh thần',
                                ];
                                $abilityIcons = [
                                    'physical' => '💪',
                                    'emotional' => '❤️',
                                    'intellectual' => '🧠',
                                    'spiritual' => '✨',
                                ];
                                $abilityColors = [
                                    'physical' => 'red',
                                    'emotional' => 'pink',
                                    'intellectual' => 'blue',
                                    'spiritual' => 'purple',
                                ];
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach (['physical', 'emotional', 'intellectual', 'spiritual'] as $type)
                                    @if (isset($abilities[$type]))
                                        @php
                                            $data = $abilities[$type];
                                            $maxCount = max(array_column($abilities, 'count'));
                                            $percentage = $maxCount > 0 ? ($data['count'] / $maxCount) * 100 : 0;
                                        @endphp
                                        <div
                                            class="p-6 border-2 border-{{ $abilityColors[$type] }}-100 rounded-xl bg-{{ $abilityColors[$type] }}-50">
                                            <div class="flex items-center mb-4">
                                                <span class="text-3xl mr-3">{{ $abilityIcons[$type] }}</span>
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-bold text-{{ $abilityColors[$type] }}-800">
                                                        {{ $abilityNames[$type] }}</h4>
                                                    <p class="text-{{ $abilityColors[$type] }}-600 font-semibold">
                                                        {{ $data['title'] }}</p>
                                                    <p class="text-sm text-{{ $abilityColors[$type] }}-500">
                                                        {{ $data['count'] }} chữ cái:
                                                        {{ implode(', ', $data['letters']) }}</p>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="bg-gray-200 rounded-full h-3">
                                                    <div class="bg-{{ $abilityColors[$type] }}-500 h-3 rounded-full transition-all duration-500"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <p class="text-xs text-{{ $abilityColors[$type] }}-600 mt-1">Mức độ:
                                                    {{ $data['level'] }}</p>
                                            </div>

                                            <p class="text-{{ $abilityColors[$type] }}-700 text-sm leading-relaxed">
                                                {{ $data['description'] }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                            <p class="text-gray-500">Chưa có dữ liệu năng lực bẩm sinh</p>
                        </div>
                    @endif
                </div>

                {{-- 6. MAY MẮN --}}
                <div id="lucky-content" class="tab-content hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- Lucky Colors --}}
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">🎨</span>
                                Màu May Mắn
                            </h3>

                            <div class="mb-6">
                                <p class="text-gray-700 mb-2">
                                    <strong>Hành mệnh:</strong> {{ $luckyColors['user_hanh'] }}
                                </p>
                                @if ($luckyColors['sinh_hanh'])
                                    <p class="text-gray-700">
                                        <strong>Hành tương sinh:</strong> {{ $luckyColors['sinh_hanh'] }}
                                    </p>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                                @foreach ($luckyColors['colors'] as $color)
                                    <div class="text-center">
                                        <div class="w-20 h-20 mx-auto mb-2 border-4 border-gray-300 rounded-full"
                                            style="background-color: {{ $color['hex'] }}"></div>
                                        <h5 class="font-semibold text-sm">{{ $color['name'] }}</h5>
                                        <p class="text-xs text-gray-600">{{ $color['hex'] }}</p>
                                        <p class="text-xs text-gray-500">Hành {{ $color['hanh'] }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-800">{{ $luckyColors['interpretation'] }}</p>
                            </div>
                        </div>

                        {{-- Lucky Numbers & Directions --}}
                        <div class="space-y-8">
                            {{-- Numbers --}}
                            <div class="bg-white rounded-xl shadow-lg p-8">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                    <span class="mr-3">🔢</span>
                                    Số May Mắn
                                </h3>

                                <div class="flex justify-center gap-4 mb-6">
                                    @foreach ($luckyNumbers['numbers'] as $number)
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                                            {{ $number }}
                                        </div>
                                    @endforeach
                                </div>

                                <div class="space-y-2 text-sm text-gray-700 mb-4">
                                    <p><strong>Số đường đời:</strong> {{ $luckyNumbers['life_path'] }}</p>
                                    <p><strong>Số Kua:</strong> {{ $luckyNumbers['kua_number'] }}</p>
                                    <p><strong>Hành mệnh:</strong> {{ $luckyNumbers['user_hanh'] }}</p>
                                </div>

                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <p class="text-sm text-purple-800">{{ $luckyNumbers['interpretation'] }}</p>
                                </div>
                            </div>

                            {{-- Directions --}}
                            <div class="bg-white rounded-xl shadow-lg p-8">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                    <span class="mr-3">🧭</span>
                                    Hướng May Mắn
                                </h3>

                                <div class="mb-6">
                                    <p class="text-gray-700 text-center">
                                        <strong>Số Kua:</strong> {{ $luckyDirections['kua_number'] }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-bold text-green-600 mb-3 flex items-center">
                                            <span class="mr-2">🌟</span>
                                            Hướng May Mắn
                                        </h4>
                                        <div class="space-y-2">
                                            @foreach ($luckyDirections['lucky_directions'] as $direction)
                                                <div class="bg-green-100 text-green-800 px-3 py-1 rounded text-center">
                                                    {{ $direction }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-red-600 mb-3 flex items-center">
                                            <span class="mr-2">⚠️</span>
                                            Hướng Nên Tránh
                                        </h4>
                                        <div class="space-y-2">
                                            @foreach ($luckyDirections['unlucky_directions'] as $direction)
                                                <div class="bg-red-100 text-red-800 px-3 py-1 rounded text-center">
                                                    {{ $direction }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-indigo-50 p-4 rounded-lg">
                                    <p class="text-sm text-indigo-800">{{ $luckyDirections['interpretation'] }}</p>
                                </div>
                            </div>

                            {{-- Daily Color --}}
                            <div class="bg-white rounded-xl shadow-lg p-8">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                    <span class="mr-3">📅</span>
                                    Màu May Mắn Hôm Nay
                                </h3>

                                <div class="text-center">
                                    <h4 class="text-xl font-bold text-gray-800 mb-4">{{ $dailyColor['day_of_week'] }}
                                    </h4>
                                    <div class="w-24 h-24 mx-auto mb-4 border-4 border-gray-300 rounded-full"
                                        style="background-color: {{ $dailyColor['color']['hex'] }}"></div>
                                    <h5 class="text-lg font-bold text-gray-800">{{ $dailyColor['color']['name'] }}</h5>
                                    <p class="text-sm text-gray-600 mb-2">{{ $dailyColor['color']['hex'] }} • Hành
                                        {{ $dailyColor['color']['hanh'] }}</p>
                                    <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">
                                        {{ $dailyColor['interpretation'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-12 text-center">
                <div class="bg-white rounded-xl shadow-lg p-6 inline-block">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Chia sẻ kết quả</h3>
                    <div class="flex gap-4">
                        <button onclick="window.print()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
                            🖨️ In kết quả
                        </button>
                        <a href="{{ route('numerology.index') }}"
                            class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg transition">
                            🔄 Tính toán lại
                        </a>
                        <button onclick="shareResults()"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition">
                            📤 Chia sẻ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Birth Chart Modal --}}
    <div id="birthChartModal" class="custom-modal" style="display: none;">
        <div class="custom-modal-overlay" onclick="closeBirthChartModal()"></div>
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h3 class="custom-modal-title">
                    <i class="bi bi-chat-text me-2"></i>Diễn Giải Biểu Đồ Ngày Sinh
                </h3>
                <button type="button" class="custom-modal-close" onclick="closeBirthChartModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="custom-modal-body">
                @if (isset($profile['charts_and_patterns']['birth_chart']))
                    @php $birthChart = $profile['charts_and_patterns']['birth_chart']; @endphp

                    {{-- Interpretations --}}
                    @if (isset($birthChart['frequency_interpretations']) && !empty($birthChart['frequency_interpretations']))
                        <div class="modal-section">
                            <h5 class="section-title">
                                <i class="bi bi-lightbulb me-2"></i>Phân Tích Tần Suất Các Số:
                            </h5>
                            @php
                                $nonZeroInterpretations = array_filter(
                                    $birthChart['frequency_interpretations'],
                                    function ($interpretation) {
                                        return ($interpretation['frequency'] ?? 0) > 0;
                                    },
                                );
                            @endphp
                            @if (!empty($nonZeroInterpretations))
                                @foreach ($nonZeroInterpretations as $interpretation)
                                    <div class="interpretation-card">
                                        <div class="interpretation-header">
                                            <h6>{{ $interpretation['interpretation']['summary'] ?? '' }}</h6>
                                        </div>
                                        <div class="interpretation-content">
                                            <p>{{ $interpretation['interpretation']['meaning'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-data">
                                    <i class="bi bi-info-circle me-2"></i>Không có phân tích chi tiết cho biểu đồ này.
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Dominant Numbers --}}
                    @if (isset($birthChart['dominant_numbers']) && !empty($birthChart['dominant_numbers']))
                        <div class="modal-section">
                            <h5 class="section-title success">
                                <i class="bi bi-star-fill me-2"></i>Số Có Tiềm Năng Đặc Biệt:
                            </h5>
                            <div class="dominant-numbers-grid">
                                @foreach ($birthChart['dominant_numbers'] as $data)
                                    <div class="dominant-number-item">
                                        <strong>Số {{ $data['number'] ?? '' }}</strong> - Xuất hiện
                                        {{ $data['frequency'] ?? 0 }} lần
                                    </div>
                                @endforeach
                            </div>
                            <div class="info-note success">
                                <i class="bi bi-info-circle me-1"></i>Các số xuất hiện nhiều lần thể hiện năng lực nổi bật
                                và tiềm năng cần phát triển.
                            </div>
                        </div>
                    @endif

                    {{-- Missing Numbers --}}
                    @if (isset($birthChart['chart_grid']) && is_array($birthChart['chart_grid']))
                        @php
                            $missingNumbers = [];
                            for ($i = 1; $i <= 9; $i++) {
                                $found = false;
                                foreach ($birthChart['chart_grid'] as $row) {
                                    foreach ($row as $cell) {
                                        if (($cell['number'] ?? 0) == $i && ($cell['frequency'] ?? 0) > 0) {
                                            $found = true;
                                            break 2;
                                        }
                                    }
                                }
                                if (!$found) {
                                    $missingNumbers[] = $i;
                                }
                            }
                        @endphp
                    @endif
                @endif
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeBirthChartModal()">
                    <i class="bi bi-x-lg me-1"></i>Đóng
                </button>
                <button type="button" class="btn btn-primary" onclick="showTabFromModal()">
                    <i class="bi bi-arrow-right me-1"></i>Xem biểu đồ đầy đủ
                </button>
            </div>
        </div>
    </div>

    {{-- Custom Karmic Modal --}}
    <div id="karmicModal" class="custom-modal" style="display: none;">
        <div class="custom-modal-overlay" onclick="closeKarmicModal()"></div>
        <div class="custom-modal-content karmic-modal-content">
            <div class="custom-modal-header">
                <h3 class="custom-modal-title">
                    <i class="bi bi-yin-yang me-2"></i>Chi Tiết Nghiệp Quả
                </h3>
                <button type="button" class="custom-modal-close" onclick="closeKarmicModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="custom-modal-body karmic-modal-body">
                @if ($karmicDebt)
                    @if ($karmicDebt['has_karmic_debt'])
                        {{-- Each karmic debt detail --}}
                        @foreach ($karmicDebt['karmic_debts'] as $index => $debt)
                            <div class="karmic-debt-modal-card mb-4">


                                <div class="debt-modal-content">
                                    @if (isset($debt['commonSigns']))
                                        <div class="debt-section lesson">
                                            <div style="font-weight: 700">Những dấu hiệu phổ biến</div>
                                            <p>{!! $debt['commonSigns'] !!}</p>
                                        </div>
                                    @endif
                                    @if (isset($debt['mainLesson']))
                                        <div class="debt-section lesson">
                                            <div style="font-weight: 700">Bài học chính</div>
                                            <p>{!! $debt['mainLesson'] !!}</p>
                                        </div>
                                    @endif
                                    @if (isset($debt['rewards']))
                                        <div class="debt-section lesson">
                                            <div style="font-weight: 700">Phần thưởng khi vượt qua</div>
                                            <p>{!! $debt['rewards'] !!}</p>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="debt-separator">
                            @endif
                        @endforeach
                    @else
                        {{-- No karmic debt content --}}
                        <div class="no-debt-modal">
                            <div class="no-debt-icon-large">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="no-debt-title-modal">Bạn Không Có Số Nghiệp Quả</h4>
                            <div class="no-debt-content">
                                <p class="no-debt-meaning">{{ $karmicDebt['interpretation'] }}</p>

                                <div class="positive-attributes-modal">
                                    <h5>✨ Những điều tích cực này thể hiện:</h5>
                                    <ul class="positive-list">
                                        <li><strong>Tâm hồn thanh tịnh:</strong> Bạn có bản tính trong sáng, ít mang những
                                            tiêu cực từ quá khứ</li>
                                        <li><strong>Khởi đầu mới:</strong> Cuộc đời này là cơ hội để bạn tự do phát triển và
                                            sáng tạo</li>
                                        <li><strong>Năng lượng tích cực:</strong> Bạn dễ thu hút may mắn và những điều tốt
                                            đẹp</li>
                                        <li><strong>Tự do lựa chọn:</strong> Ít bị ràng buộc bởi những nghiệp quả, có thể tự
                                            quyết định con đường đi</li>
                                        <li><strong>Khả năng giúp đỡ:</strong> Bạn có thể trở thành người hỗ trợ những người
                                            khác vượt qua khó khăn</li>
                                    </ul>
                                </div>

                                <div class="advice-modal">
                                    <h5>💡 Lời khuyên cho bạn:</h5>
                                    <p>Hãy trân trọng món quà này và sử dụng năng lượng tích cực để làm những việc có ý
                                        nghĩa, giúp đỡ người khác và tạo ra những giá trị tốt đẹp cho cộng đồng.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeKarmicModal()">
                    <i class="bi bi-x-lg me-1"></i>Đóng
                </button>
            </div>
        </div>
    </div>

    {{-- Custom Arrows Modal --}}
    <div id="arrowsModal" class="custom-modal" style="display: none;">
        <div class="custom-modal-overlay" onclick="closeArrowsModal()"></div>
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h3 class="custom-modal-title">
                    <i class="bi bi-chat-text me-2"></i>Diễn Giải Mũi Tên Cá Tính
                </h3>
                <button type="button" class="custom-modal-close" onclick="closeArrowsModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="custom-modal-body">
                @if (isset($profile['charts_and_patterns']['arrows']) && !empty($profile['charts_and_patterns']['arrows']['arrows']))
                    @php $arrowsData = $profile['charts_and_patterns']['arrows']; @endphp

                    {{-- Present Arrows --}}
                    @php
                        $presentArrows = array_filter($arrowsData['arrows'], function ($arrow) {
                            return $arrow['type'] == 'present';
                        });
                    @endphp
                    @if (count($presentArrows) > 0)
                        <div class="modal-section">
                            <h5 class="section-title success">
                                <i class="bi bi-check-circle-fill me-2"></i>Mũi Tên Có Mặt (Điểm mạnh)
                            </h5>
                            @foreach ($presentArrows as $arrow)
                                <div class="interpretation-card present">
                                    <div class="interpretation-header">
                                        <h6>{{ $arrow['interpretation']['title'] ?? '' }}
                                            ({{ implode('-', $arrow['numbers']) }})
                                        </h6>
                                    </div>
                                    <div class="interpretation-content">
                                        <p><strong>Ý nghĩa:</strong>
                                            {{ $arrow['interpretation']['description'] ?? 'Chưa có diễn giải.' }}</p>
                                        @if (!empty($arrow['interpretation']['strengths']))
                                            <p><strong>Điểm mạnh:</strong>
                                                {{ implode(', ', $arrow['interpretation']['strengths']) }}</p>
                                        @endif
                                        @if (!empty($arrow['interpretation']['challenges']))
                                            <p><strong>Thách thức:</strong>
                                                {{ implode(', ', $arrow['interpretation']['challenges']) }}</p>
                                        @endif
                                        @if (!empty($arrow['interpretation']['advice']))
                                            <p><strong>Lời khuyên:</strong> {{ $arrow['interpretation']['advice'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    {{-- Absent Arrows --}}
                    @php
                        $absentArrows = array_filter($arrowsData['arrows'], function ($arrow) {
                            return $arrow['type'] == 'absent';
                        });
                    @endphp
                    @if (count($absentArrows) > 0)
                        <div class="modal-section">
                            <h5 class="section-title danger">
                                <i class="bi bi-x-circle-fill me-2"></i>Mũi Tên Trống (Điểm yếu cần cải thiện)
                            </h5>
                            @foreach ($absentArrows as $arrow)
                                <div class="interpretation-card absent">
                                    <div class="interpretation-header">
                                        <h6>{{ $arrow['interpretation']['title'] ?? '' }}
                                            ({{ implode('-', $arrow['numbers']) }})
                                        </h6>
                                    </div>
                                    <div class="interpretation-content">
                                        <p><strong>Ý nghĩa:</strong>
                                            {{ $arrow['interpretation']['description'] ?? 'Chưa có diễn giải.' }}</p>
                                        @if (!empty($arrow['interpretation']['advice']))
                                            <p><strong>Lời khuyên để cải thiện:</strong>
                                                {{ $arrow['interpretation']['advice'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="no-data text-center py-5">
                        <i class="bi bi-info-circle fs-3"></i>
                        <p class="mt-2">Không có dữ liệu diễn giải cho các mũi tên.</p>
                    </div>
                @endif
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeArrowsModal()">
                    <i class="bi bi-x-lg me-1"></i>Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab content
            const targetContent = document.getElementById(tabName + '-content');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }

            // Add active class to selected tab button
            const targetButton = document.getElementById(tabName + '-tab');
            if (targetButton) {
                targetButton.classList.add('active');
            }

            // Scroll to tab content
            setTimeout(() => {
                const targetContent = document.getElementById(tabName + '-content');
                if (targetContent) {
                    targetContent.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
        }

        // Custom Modal JavaScript
        let originalScrollPosition = 0;

        function openBirthChartModal() {
            const modal = document.getElementById('birthChartModal');
            if (!modal) return;

            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('modal-show'), 10);
            document.documentElement.classList.add('modal-open');
        }

        function closeBirthChartModal() {
            const modal = document.getElementById('birthChartModal');
            if (!modal) return;

            modal.classList.remove('modal-show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.documentElement.classList.remove('modal-open');
            }, 300);
        }

        function openArrowsModal() {
            const modal = document.getElementById('arrowsModal');
            if (!modal) return;

            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('modal-show'), 10);
            document.documentElement.classList.add('modal-open');
        }

        function closeArrowsModal() {
            const modal = document.getElementById('arrowsModal');
            if (!modal) return;

            modal.classList.remove('modal-show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.documentElement.classList.remove('modal-open');
            }, 300);
        }

        function openNineYearCycleModal() {
            // For now, just show an alert. You can implement a proper modal later
            alert('Chức năng xem chi tiết chu kì 9 năm sẽ được phát triển trong tương lai.');
        }

        function openKarmicModal() {
            const modal = document.getElementById('karmicModal');
            if (!modal) return;

            modal.style.display = 'flex';
            document.documentElement.classList.add('modal-open');
            setTimeout(() => modal.classList.add('modal-show'), 10);
        }

        function closeKarmicModal() {
            const modal = document.getElementById('karmicModal');
            if (!modal) return;

            modal.classList.remove('modal-show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.documentElement.classList.remove('modal-open');
            }, 300);
        }

        function showTabFromModal() {
            closeBirthChartModal();
            setTimeout(() => {
                showTab('charts');
            }, 350);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (document.getElementById('birthChartModal')?.style.display === 'flex') {
                        closeBirthChartModal();
                    }
                    if (document.getElementById('arrowsModal')?.style.display === 'flex') {
                        closeArrowsModal();
                    }
                    if (document.getElementById('karmicModal')?.style.display === 'flex') {
                        closeKarmicModal();
                    }
                }
            });
        });
    </script>

@endsection
