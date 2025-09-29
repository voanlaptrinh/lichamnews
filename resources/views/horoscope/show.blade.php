{{-- Giả sử layout của bạn là 'welcome.blade.php' --}}
@extends('welcome')

@section('content')
@php
    $zodiacIcons = [
        'aries' => '/icons/aries-icons.svg',
        'taurus' => '/icons/taurus-icons.svg',
        'gemini' => '/icons/gemini-icons.svg',
        'cancer' => '/icons/cancer-icons.svg',
        'leo' => '/icons/leo-icons.svg',
        'virgo' => '/icons/virgo-icons.svg',
        'libra' => '/icons/libra-icons.svg',
        'scorpio' => '/icons/scorpio-icons.svg',
        'sagittarius' => '/icons/sagittarius-icons.svg',
        'capricorn' => '/icons/capricorn-icons.svg',
        'aquarius' => '/icons/aquarius-icons.svg',
        'pisces' => '/icons/pisces-icons.svg',
    ];

    $zodiacNames = [
        'aries' => 'Bạch Dương',
        'taurus' => 'Kim Ngưu',
        'gemini' => 'Song Tử',
        'cancer' => 'Cự Giải',
        'leo' => 'Sư Tử',
        'virgo' => 'Xử Nữ',
        'libra' => 'Thiên Bình',
        'scorpio' => 'Thần Nông',
        'sagittarius' => 'Nhân Mã',
        'capricorn' => 'Ma Kết',
        'aquarius' => 'Bảo Bình',
        'pisces' => 'Song Ngư',
    ];

    $zodiacDates = [
        'aries' => '21/3 - 19/4',
        'taurus' => '20/4 - 20/5',
        'gemini' => '21/5 - 20/6',
        'cancer' => '21/6 - 22/7',
        'leo' => '23/7 - 22/8',
        'virgo' => '23/8 - 22/9',
        'libra' => '23/9 - 22/10',
        'scorpio' => '23/10 - 21/11',
        'sagittarius' => '22/11 - 21/12',
        'capricorn' => '22/12 - 19/1',
        'aquarius' => '20/1 - 18/2',
        'pisces' => '19/2 - 20/3',
    ];
@endphp
    <div class="container-setup">
        <h6 class="content-title-date-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Phong thủy & tử vi <i class="bi bi-chevron-right"></i>
            <span>12 cung hoàng đạo</span>
        </h6>
           <h1  class="content-title-home-lich"><span>Cung hoàng đạo</span> - <span id="zodiac-title"> {{ $zodiacNames[$zodiac['sign']] ?? ' Cung hoàng đạo' }}</span></h1>
    </div>

    <!-- Zodiac Header -->


    <div class="bth-cunghoangdao mb-3">
        <div id="tabs" class="tabs">
            <button class="tab-button tab-horoscope btn" data-type="yesterday">Hôm qua</button>
            <button class="tab-button tab-horoscope btn active" data-type="today">Hôm nay</button>
            <button class="tab-button tab-horoscope btn" data-type="tomorrow">Ngày mai</button>
            <button class="tab-button tab-horoscope btn" data-type="weekly">Tuần này</button>
            <button class="tab-button tab-horoscope btn" data-type="monthly">Tháng này</button>
            <button class="tab-button tab-horoscope btn" data-type="yearly">{{ date('Y') }}
            </button>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-3">
            <div class="zodiac-list">
                @foreach ($zodiacNames as $sign => $name)
                    <div class="zodiac-item {{ $sign == $zodiac['sign'] ? 'active' : '' }}" data-sign="{{ $sign }}">
                        <img src="{{ asset($zodiacIcons[$sign]) }}" alt="{{ $name }}" class="zodiac-item-icon">
                        <div class="zodiac-item-info">
                            <div class="zodiac-item-name">{{ $name }}</div>
                            <div class="zodiac-item-date">{{ $zodiacDates[$sign] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-9">
         
            <div class="zodiac-header">
                <div class="zodiac-current">
                    <div class="zodiac-icon" id="zodiac-icon">
                        <img src="{{ asset($zodiacIcons[$zodiac['sign']] ?? '⭐') }}" alt="">
                    </div>
                    <div class="zodiac-info">
                        <h3 id="zodiac-name">{{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }}</h3>
                        <p id="zodiac-date">{{ $zodiacDates[$zodiac['sign']] ?? '' }}</p>
                    </div>
                </div>

            </div>






            <!-- Main Content Card -->

            <div id="horoscope-content" class="horoscope-content">
                {{-- Loader sẽ được thay thế bằng nội dung từ JavaScript --}}
                <div style="text-align: center; padding: 40px; color: #666; font-style: italic;">Đang tải dữ liệu...</div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* CSS cho zodiac list */
        .zodiac-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .zodiac-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .zodiac-item:hover {
            background: #f8f9fa;
            border-color: #007bff;
            transform: translateY(-1px);
        }

        .zodiac-item.active {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .zodiac-item-icon {
            width: 32px;
            height: 32px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .zodiac-item-info {
            flex: 1;
        }

        .zodiac-item-name {
            font-weight: 600;
            font-size: 14px;
        }

        .zodiac-item-date {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 2px;
        }

        /* CSS cho thanh trượt ngang trên mobile */
        @media (max-width: 768px) {
            .zodiac-list {
                flex-direction: row;
                overflow-x: auto;
                gap: 8px;
                padding: 10px 0;
            }

            .zodiac-item {
                min-width: 120px;
                flex-direction: column;
                text-align: center;
                padding: 8px;
            }

            .zodiac-item-icon {
                margin-right: 0;
                margin-bottom: 8px;
            }
        }

        /* CSS cho desktop - giữ nguyên layout hiện tại */
        @media (min-width: 769px) {
            .bth-cunghoangdao .tabs {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .bth-cunghoangdao .tab-button {
                flex: 1;
                min-width: 120px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabsContainer = document.getElementById('tabs');
            const horoscopeContent = document.getElementById('horoscope-content');
            const zodiacList = document.querySelector('.zodiac-list');
            const zodiacIcon = document.getElementById('zodiac-icon');
            const zodiacName = document.getElementById('zodiac-name');
            const zodiacDate = document.getElementById('zodiac-date');
            const zodiacTitle = document.getElementById('zodiac-title');

            let currentSign = '{{ $zodiac['sign'] }}';
            let currentType = '{{ $currentType ?? 'today' }}';

            // Mapping data từ PHP
            const signSlugs = @json($signSlugs ?? []);
            const typeSlugs = @json($typeSlugs ?? []);

            // Dữ liệu cung hoàng đạo
            const zodiacData = {
                'aries': {
                    icon: '/icons/aries-icons.svg',
                    name: 'Bạch Dương',
                    date: '21/3 - 19/4'
                },
                'taurus': {
                    icon: '/icons/taurus-icons.svg',
                    name: 'Kim Ngưu',
                    date: '20/4 - 20/5'
                },
                'gemini': {
                    icon: '/icons/gemini-icons.svg',
                    name: 'Song Tử',
                    date: '21/5 - 20/6'
                },
                'cancer': {
                    icon: '/icons/cancer-icons.svg',
                    name: 'Cự Giải',
                    date: '21/6 - 22/7'
                },
                'leo': {
                    icon: '/icons/leo-icons.svg',
                    name: 'Sư Tử',
                    date: '23/7 - 22/8'
                },
                'virgo': {
                    icon: '/icons/virgo-icons.svg',
                    name: 'Xử Nữ',
                    date: '23/8 - 22/9'
                },
                'libra': {
                    icon: '/icons/libra-icons.svg',
                    name: 'Thiên Bình',
                    date: '23/9 - 22/10'
                },
                'scorpio': {
                    icon: '/icons/scorpio-icons.svg',
                    name: 'Thần Nông',
                    date: '23/10 - 21/11'
                },
                'sagittarius': {
                    icon: '/icons/sagittarius-icons.svg',
                    name: 'Nhân Mã',
                    date: '22/11 - 21/12'
                },
                'capricorn': {
                    icon: '/icons/capricorn-icons.svg',
                    name: 'Ma Kết',
                    date: '22/12 - 19/1'
                },
                'aquarius': {
                    icon: '/icons/aquarius-icons.svg',
                    name: 'Bảo Bình',
                    date: '20/1 - 18/2'
                },
                'pisces': {
                    icon: '/icons/pisces-icons.svg',
                    name: 'Song Ngư',
                    date: '19/2 - 20/3'
                }
            };

            // Hàm cập nhật thông tin cung hoàng đạo
            function updateZodiacInfo(sign) {
                const data = zodiacData[sign];
                if (data) {
                    const iconImg = zodiacIcon.querySelector('img');
                    if (iconImg) {
                        iconImg.src = data.icon;
                    }
                    zodiacName.textContent = data.name;
                    zodiacDate.textContent = data.date;
                    zodiacTitle.textContent = data.name;
                }
            }

            // Hàm này rất gọn gàng vì tất cả logic xử lý đã ở trên server
            async function fetchHoroscope(type) {
                horoscopeContent.innerHTML =
                    '<div style="text-align: center; padding: 40px; color: #666; font-style: italic;">Đang tải dữ liệu...</div>';
                const apiUrl = `{{ url('/api/horoscope-data') }}/${currentSign}/${type}`;

                try {
                    const response = await fetch(apiUrl);
                    const data = await response.json();

                    // Nếu request không thành công, hiển thị lỗi
                    if (!response.ok) {
                        // 'data.error' được trả về từ controller nếu có lỗi
                        throw new Error(data.error || `Lỗi máy chủ: ${response.status}`);
                    }

                    // Dữ liệu trả về là {'html': '...'}
                    // Chỉ cần lấy và hiển thị, không cần xử lý gì thêm
                    if (data.html) {
                        horoscopeContent.innerHTML = data.html;
                    } else {
                        throw new Error('Định dạng dữ liệu trả về không hợp lệ.');
                    }

                } catch (error) {
                    console.error('Không thể lấy dữ liệu:', error);
                    horoscopeContent.innerHTML =
                        `<p style="color: red; text-align: center;">${error.message}</p>`;
                }
            }

            // Xử lý click vào cung hoàng đạo
            zodiacList.addEventListener('click', (event) => {
                const zodiacItem = event.target.closest('.zodiac-item');
                if (!zodiacItem) return;

                const newSign = zodiacItem.dataset.sign;
                currentSign = newSign;

                // Cập nhật active state
                zodiacList.querySelectorAll('.zodiac-item').forEach(item => {
                    item.classList.remove('active');
                });
                zodiacItem.classList.add('active');

                // Cập nhật thông tin hiển thị
                updateZodiacInfo(newSign);

                // Tải lại dữ liệu với cung mới
                const activeTab = tabsContainer.querySelector('.tab-horoscope.active');
                if (activeTab) {
                    fetchHoroscope(activeTab.dataset.type);
                }

                // Cập nhật URL với structure mới
                const signSlug = signSlugs[newSign];
                const typeSlug = typeSlugs[currentType];
                if (signSlug && typeSlug) {
                    const newUrl = `{{ url('/cung-hoang-dao') }}/${signSlug}/${typeSlug}`;
                    window.history.pushState({}, '', newUrl);
                }
            });

            // Phần xử lý click vào tab
            tabsContainer.addEventListener('click', (event) => {
                const selectedTab = event.target.closest('.tab-horoscope');
                if (!selectedTab) return;

                const type = selectedTab.dataset.type;
                currentType = type;

                tabsContainer.querySelector('.active')?.classList.remove('active');
                selectedTab.classList.add('active');

                fetchHoroscope(type);

                // Cập nhật URL khi chuyển tab
                const signSlug = signSlugs[currentSign];
                const typeSlug = typeSlugs[type];
                if (signSlug && typeSlug) {
                    const newUrl = `{{ url('/cung-hoang-dao') }}/${signSlug}/${typeSlug}`;
                    window.history.pushState({}, '', newUrl);
                }
            });

            // Tự động tải dữ liệu cho tab đang active khi trang vừa tải xong
            const initialActiveTab = tabsContainer.querySelector('.tab-horoscope.active');
            if (initialActiveTab) {
                fetchHoroscope(initialActiveTab.dataset.type);
            }
        });
    </script>
@endpush
