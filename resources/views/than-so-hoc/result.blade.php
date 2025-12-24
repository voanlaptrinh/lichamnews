@extends('welcome')

@section('content')
    {{-- @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/thansohoc.css?v=11.5') }}">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#1e40af',
                            secondary: '#7c3aed'
                        }
                    }
                }
            }
        </script>
    @endpush --}}
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.6') }}">
        <style>
            .tt--giaima::before {
                content: '';
                display: inline-block;
                width: 7px;
                height: 28px;
                background-color: #4299e1;
                border-radius: 999px;
                margin-right: 12px;
            }

            .tt--giaima {
                display: flex;
                font-size: 20px;
                font-weight: 700;
                color: #2254AB;
            }

            .box-chi-so {
                background: #2268D3;
                border: 1px solid #FFFAED4D;
                border-radius: 22px;

            }

            .sochudao {
                background-image: url(../images/vong_sochudao.svg);
                background-repeat: no-repeat;
                background-size: cover;
                align-items: normal;
                background-position: center center;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 48px;
                height: 140px;
                color: #FFFFFF;

            }

            /* New Numerology Grid Styles */
            .numerology-grid {
                width: 100%;
            }

            .numerology-card {
                background: #4285F4;
                border-radius: 20px;
                padding: 24px 16px;
                text-align: center;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
                min-height: 160px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .numerology-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .numerology-card.master-number {
                background: #4285F4;
            }

            .number-circle {
                width: 90px;
                height: 90px;
                background-image: url('{{ asset('images/vong_sochudaonone.svg') }}');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center center;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 12px;
                position: relative;
            }

            .master-circle {
                background-image: url('{{ asset('images/vong_sochudao.svg') }}');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center center;
            }

            .number-text {
                color: #FFFFFF;
                font-size: 36px;
                font-weight: 700;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .card-label {
                color: #FFFFFF;
                font-size: 14px;
                font-weight: 600;
                text-align: center;
                line-height: 1.2;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .number-circle {
                    width: 70px;
                    height: 70px;
                }

                .number-text {
                    font-size: 28px;
                }

                .card-label {
                    font-size: 12px;
                }

                .numerology-card {
                    padding: 20px 12px;
                    min-height: 140px;
                }
            }

            @media (max-width: 576px) {
                .number-circle {
                    width: 60px;
                    height: 60px;
                }

                .number-text {
                    font-size: 24px;
                }

                .numerology-card {
                    padding: 16px 8px;
                    min-height: 120px;
                }
            }
        </style>
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
                <div class="box--bg-thang" style="border: unset">
                    <div class="text-box-tong-quan">
                        <div class="tt--giaima">
                            Giải mã các chỉ số
                        </div>

                        {{-- New Grid Layout --}}
                        <div class="numerology-grid mt-4">
                            {{-- Top Row --}}
                            <div class="row g-3 mb-3">
                                {{-- Số Chủ Đạo --}}
                                <div class="col-lg col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card master-number">
                                        <div class="number-circle master-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['life_path']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Số Chủ Đạo</div>
                                    </div>
                                </div>

                                {{-- Số Linh Hồn --}}
                                <div class="col-lg col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['soul_urge']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Số Linh Hồn</div>
                                    </div>
                                </div>

                                {{-- Số Tên --}}
                                <div class="col-lg col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['expression']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Số Tên</div>
                                    </div>
                                </div>

                                {{-- Số Tính Cách --}}
                                <div class="col-lg col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['personality']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Số Tính Cách</div>
                                    </div>
                                </div>

                                {{-- Năm Cá Nhân --}}
                                <div class="col-lg col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['cycles_and_pinnacles']['personal_year']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Năm Cá Nhân</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bottom Row --}}
                            <div class="row g-3">
                                {{-- Thái Độ --}}
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['attitude']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Thái Độ</div>
                                    </div>
                                </div>

                                {{-- Tiềm Năng (Birth Day) --}}
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['birth_day']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Tiềm Năng</div>
                                    </div>
                                </div>

                                {{-- Trưởng Thành --}}
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="numerology-card">
                                        <div class="number-circle">
                                            <span class="number-text">{{ $profile['basic_numbers']['maturity']['number'] }}</span>
                                        </div>
                                        <div class="card-label">Trưởng Thành</div>
                                    </div>
                                </div>
                            </div>
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
                                                {{ str_replace(['arrow_of_', 'missing_arrow_of_', '_'], ['Mui tên ', 'Thiếu mui tên ', ' '], $arrow['name']) }}
                                            </h4>
                                            <span
                                                class="text-sm {{ $textColor }} font-mono">{{ implode('-', $arrow['numbers']) }}</span>
                                        </div>
                                        <p class="text-sm {{ $textColor }}">{{ $arrow['interpretation'] }}</p>
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
                        $missingFromName = $profile['charts_and_patterns']['missing_numbers_from_name'] ?? null;
                    @endphp

                    {{-- Missing Numbers From Name --}}
                    @if ($missingFromName)
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">🔤</span>
                                Số Thiếu Hụt Từ Tên
                            </h3>

                            @if (!empty($missingFromName['missing_numbers']))
                                <div class="mb-6">
                                    <h4 class="font-semibold text-orange-600 mb-3">Các số không có trong tên:</h4>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($missingFromName['missing_numbers'] as $num)
                                            <span
                                                class="bg-orange-500 text-white px-3 py-1 rounded-full font-bold">{{ $num }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($missingFromName['hidden_passions']))
                                <div class="mb-4">
                                    <h4 class="font-semibold text-green-600 mb-3">Số tiềm ẩn trong tên:</h4>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($missingFromName['hidden_passions'] as $num)
                                            <span
                                                class="bg-green-500 text-white px-3 py-1 rounded-full font-bold">{{ $num }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="bg-orange-50 p-4 rounded-lg">
                                <p class="text-sm text-orange-800">
                                    {{ $missingFromName['interpretation'] ?? 'Phân tích các số thiếu hụt và tiềm ẩn từ chữ cái trong tên bạn.' }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- Karmic Lessons --}}
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">📚</span>
                                Bài Học Cần Học
                            </h3>

                            @if (!empty($karmicLessons['missing_numbers']))
                                <div class="mb-6">
                                    <h4 class="font-semibold text-yellow-600 mb-3">Số thiếu hụt trong tên:</h4>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($karmicLessons['missing_numbers'] as $num)
                                            <span
                                                class="bg-yellow-500 text-white px-3 py-1 rounded-full font-bold">{{ $num }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    @foreach ($karmicLessons['karmic_lessons'] as $lesson)
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                            <h5 class="font-bold text-yellow-800 mb-2">{{ $lesson['title'] }}</h5>
                                            <p class="text-yellow-700 text-sm leading-relaxed">{{ $lesson['meaning'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="text-6xl mb-4">✅</div>
                                    <p class="text-green-600 font-semibold">Bạn không có số thiếu hụt nào!</p>
                                    <p class="text-gray-600 text-sm">Điều này cho thấy bạn đã có đầy đủ kinh nghiệm từ các
                                        kiếp trước.</p>
                                </div>
                            @endif

                            @if (!empty($karmicLessons['hidden_passions']))
                                <div class="mt-6 pt-6 border-t">
                                    <h4 class="font-semibold text-green-600 mb-3">Số tiềm năng ẩn:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($karmicLessons['hidden_passions'] as $num)
                                            <span
                                                class="bg-green-500 text-white px-3 py-1 rounded-full font-bold">{{ $num }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Karmic Debt --}}
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-3">⚖️</span>
                                Nghiệp Quả
                            </h3>

                            @if ($karmicDebt['has_karmic_debt'])
                                @foreach ($karmicDebt['karmic_debts'] as $debt)
                                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded mb-4">
                                        <h4 class="text-xl font-bold text-red-800 mb-2">
                                            Số {{ $debt['number'] }}
                                        </h4>
                                        <p class="text-red-700 mb-2">
                                            <strong>Nguồn:</strong> {{ $debt['source'] }}
                                        </p>
                                        <p class="text-red-700">{{ $debt['interpretation'] }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <div class="text-6xl mb-4">✨</div>
                                    <p class="text-green-600 font-semibold text-lg">{{ $karmicDebt['interpretation'] }}
                                    </p>
                                </div>
                            @endif
                        </div>
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

    @push('styles')
        <style>
            .tab-btn {
                @apply px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 whitespace-nowrap;
                @apply text-gray-600 hover:text-blue-600 hover:bg-blue-50;
            }

            .tab-btn.active {
                @apply bg-blue-500 text-white shadow-lg transform scale-105;
            }

            .tab-content {
                @apply transition-all duration-300;
            }

            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                }

                .no-print {
                    display: none !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function showTab(tabName) {
                // Hide all content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active class from all buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Show selected content
                document.getElementById(tabName + '-content').classList.remove('hidden');
                document.getElementById(tabName + '-tab').classList.add('active');
            }

            function shareResults() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Kết quả Thần Số Học - {{ $fullName }}',
                        text: 'Xem kết quả thần số học của tôi',
                        url: window.location.href
                    });
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Đã sao chép liên kết vào clipboard!');
                    });
                }
            }

            // Initialize first tab
            document.addEventListener('DOMContentLoaded', function() {
                showTab('basic');
            });
        </script>
    @endpush
@endsection
