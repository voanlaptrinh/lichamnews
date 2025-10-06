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
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <span>12 cung hoàng đạo</span> <i class="bi bi-chevron-right"></i><span id="breadcrumb-zodiac">{{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }}</span> <i class="bi bi-chevron-right"></i><span id="breadcrumb-time">Hôm nay</span>
        </h6>
        <h1 class="content-title-home-lich" id="main-title">Tử Vi Cung&nbsp;<span id="zodiac-title">{{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }}</span>&nbsp;<span id="time-period">Hôm nay</span></h1>
    </div>

    <!-- Zodiac Header -->
    <div class="row mt-3">
        <div class="col-lg-9">
            <div class="--duv-cunghoangdao">
                <div class="bth-cunghoangdao mb-3">
                    <div id="tabs" class="tabs">
                        <button class="tab-button tab-horoscope btn active" data-type="today">Hôm nay</button>
                        <button class="tab-button tab-horoscope btn" data-type="tomorrow">Ngày mai</button>
                        <button class="tab-button tab-horoscope btn" data-type="weekly">Tuần này</button>
                        <button class="tab-button tab-horoscope btn" data-type="monthly">Tháng này</button>
                        <button class="tab-button tab-horoscope btn" data-type="yearly">{{ date('Y') }}
                        </button>
                    </div>
                </div>
                <hr>
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

            </div>

            <!-- Main Content Card -->

            <div id="horoscope-content" class="horoscope-content">
                {{-- Loader sẽ được thay thế bằng nội dung từ JavaScript --}}
                <div style="text-align: center; padding: 40px; color: #666; font-style: italic;">Đang tải dữ liệu...</div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="events-card">
                <h5 class="card-title-right">Cung hoàng đạo khác</h5>
                <div class="zodiac-list ">
                    @foreach ($zodiacNames as $sign => $name)
                        <div class="zodiac-item {{ $sign == $zodiac['sign'] ? 'active' : '' }}"
                            data-sign="{{ $sign }}">
                            <img src="{{ asset($zodiacIcons[$sign]) }}" alt="{{ $name }}" class="zodiac-item-icon">
                            <div class="zodiac-item-info">
                                <div class="zodiac-item-name">{{ $name }}</div>
                                <div class="zodiac-item-date">{{ $zodiacDates[$sign] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


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
            const breadcrumbZodiac = document.getElementById('breadcrumb-zodiac');
            const breadcrumbTime = document.getElementById('breadcrumb-time');
            const timePeriod = document.getElementById('time-period');

            let currentSign = '{{ $zodiac['sign'] }}';
            let currentType = '{{ $currentType ?? 'today' }}';

            // Mapping data từ PHP
            const signSlugs = @json($signSlugs ?? []);
            const typeSlugs = @json($typeSlugs ?? []);

            // Meta data cho từng type
            const typeMetaData = {
                'yesterday': {
                    suffix: 'Hôm qua',
                    descSuffix: 'hôm qua',
                    breadcrumb: 'Hôm qua'
                },
                'today': {
                    suffix: 'Hôm nay',
                    descSuffix: 'hôm nay',
                    breadcrumb: 'Hôm nay'
                },
                'tomorrow': {
                    suffix: 'Ngày mai',
                    descSuffix: 'ngày mai',
                    breadcrumb: 'Ngày mai'
                },
                'weekly': {
                    suffix: 'Tuần này',
                    descSuffix: 'tuần này',
                    breadcrumb: 'Tuần này'
                },
                'monthly': {
                    suffix: 'Tháng này',
                    descSuffix: 'tháng này',
                    breadcrumb: 'Tháng này'
                },
                'yearly': {
                    suffix: 'Năm ' + new Date().getFullYear(),
                    descSuffix: 'năm ' + new Date().getFullYear(),
                    breadcrumb: 'Năm ' + new Date().getFullYear()
                }
            };

            // Dữ liệu cung hoàng đạo
            const zodiacData = {
                'aries': {
                    icon: '/icons/aries-icons.svg',
                    name: 'Bạch Dương',
                    date: '21/3 - 19/4',
                    engName: 'Aries'
                },
                'taurus': {
                    icon: '/icons/taurus-icons.svg',
                    name: 'Kim Ngưu',
                    date: '20/4 - 20/5',
                    engName: 'Taurus'
                },
                'gemini': {
                    icon: '/icons/gemini-icons.svg',
                    name: 'Song Tử',
                    date: '21/5 - 20/6',
                    engName: 'Gemini'
                },
                'cancer': {
                    icon: '/icons/cancer-icons.svg',
                    name: 'Cự Giải',
                    date: '21/6 - 22/7',
                    engName: 'Cancer'
                },
                'leo': {
                    icon: '/icons/leo-icons.svg',
                    name: 'Sư Tử',
                    date: '23/7 - 22/8',
                    engName: 'Leo'
                },
                'virgo': {
                    icon: '/icons/virgo-icons.svg',
                    name: 'Xử Nữ',
                    date: '23/8 - 22/9',
                    engName: 'Virgo'
                },
                'libra': {
                    icon: '/icons/libra-icons.svg',
                    name: 'Thiên Bình',
                    date: '23/9 - 22/10',
                    engName: 'Libra'
                },
                'scorpio': {
                    icon: '/icons/scorpio-icons.svg',
                    name: 'Thần Nông',
                    date: '23/10 - 21/11',
                    engName: 'Scorpio'
                },
                'sagittarius': {
                    icon: '/icons/sagittarius-icons.svg',
                    name: 'Nhân Mã',
                    date: '22/11 - 21/12',
                    engName: 'Sagittarius'
                },
                'capricorn': {
                    icon: '/icons/capricorn-icons.svg',
                    name: 'Ma Kết',
                    date: '22/12 - 19/1',
                    engName: 'Capricorn'
                },
                'aquarius': {
                    icon: '/icons/aquarius-icons.svg',
                    name: 'Bảo Bình',
                    date: '20/1 - 18/2',
                    engName: 'Aquarius'
                },
                'pisces': {
                    icon: '/icons/pisces-icons.svg',
                    name: 'Song Ngư',
                    date: '19/2 - 20/3',
                    engName: 'Pisces'
                }
            };

            // Hàm cập nhật meta tags
            function updateMetaTags(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];

                if (zodiac && typeMeta) {
                    // Cập nhật title
                    const newTitle =
                        `Cung ${zodiac.name} - ${zodiac.engName} (${zodiac.date}) ${typeMeta.suffix} | Tính cách, Tình yêu, Sự nghiệp`;
                    document.title = newTitle;

                    // Cập nhật meta description
                    const newDescription =
                        `Xem tử vi cung ${zodiac.name} ${typeMeta.descSuffix}: Khám phá tính cách, tình yêu, sự nghiệp và vận mệnh chi tiết. Dự báo chính xác cho người sinh ${zodiac.date}.`;

                    // Tìm và cập nhật meta description tag
                    let metaDesc = document.querySelector('meta[name="description"]');
                    if (metaDesc) {
                        metaDesc.setAttribute('content', newDescription);
                    } else {
                        // Tạo meta description nếu chưa có
                        metaDesc = document.createElement('meta');
                        metaDesc.setAttribute('name', 'description');
                        metaDesc.setAttribute('content', newDescription);
                        document.head.appendChild(metaDesc);
                    }
                }
            }

            // Hàm cập nhật breadcrumbs
            function updateBreadcrumbs(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];

                if (zodiac && breadcrumbZodiac) {
                    breadcrumbZodiac.textContent = zodiac.name;
                }

                if (typeMeta && breadcrumbTime) {
                    breadcrumbTime.textContent = typeMeta.breadcrumb;
                }
            }

            // Hàm cập nhật H1 title
            function updateMainTitle(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];
                const mainTitle = document.getElementById('main-title');

                if (zodiac && typeMeta && mainTitle) {
                    mainTitle.innerHTML = `Tử Vi Cung&nbsp;<span id="zodiac-title">${zodiac.name}</span>&nbsp;<span id="time-period">${typeMeta.suffix}</span>`;
                }
            }

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
                    // zodiacTitle will be updated by updateMainTitle function
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

                // Cập nhật breadcrumbs
                updateBreadcrumbs(newSign, currentType);

                // Cập nhật H1 title
                updateMainTitle(newSign, currentType);

                // Cập nhật meta tags
                updateMetaTags(newSign, currentType);

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
                    window.history.pushState({
                        sign: newSign,
                        type: currentType
                    }, '', newUrl);
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

                // Cập nhật breadcrumbs
                updateBreadcrumbs(currentSign, type);

                // Cập nhật H1 title
                updateMainTitle(currentSign, type);

                // Cập nhật meta tags
                updateMetaTags(currentSign, type);

                fetchHoroscope(type);

                // Cập nhật URL khi chuyển tab
                const signSlug = signSlugs[currentSign];
                const typeSlug = typeSlugs[type];
                if (signSlug && typeSlug) {
                    const newUrl = `{{ url('/cung-hoang-dao') }}/${signSlug}/${typeSlug}`;
                    window.history.pushState({
                        sign: currentSign,
                        type: type
                    }, '', newUrl);
                }
            });

            // Xử lý browser back/forward navigation
            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.sign && event.state.type) {
                    // Cập nhật currentSign và currentType từ state
                    currentSign = event.state.sign;
                    currentType = event.state.type;

                    // Cập nhật active zodiac item
                    zodiacList.querySelectorAll('.zodiac-item').forEach(item => {
                        item.classList.remove('active');
                        if (item.dataset.sign === currentSign) {
                            item.classList.add('active');
                        }
                    });

                    // Cập nhật active tab
                    tabsContainer.querySelectorAll('.tab-horoscope').forEach(tab => {
                        tab.classList.remove('active');
                        if (tab.dataset.type === currentType) {
                            tab.classList.add('active');
                        }
                    });

                    // Cập nhật thông tin cung hoàng đạo
                    updateZodiacInfo(currentSign);

                    // Cập nhật breadcrumbs
                    updateBreadcrumbs(currentSign, currentType);

                    // Cập nhật H1 title
                    updateMainTitle(currentSign, currentType);

                    // Cập nhật meta tags
                    updateMetaTags(currentSign, currentType);

                    // Tải lại dữ liệu
                    fetchHoroscope(currentType);
                }
            });

            // Cập nhật active tab dựa trên currentType
            tabsContainer.querySelectorAll('.tab-horoscope').forEach(tab => {
                tab.classList.remove('active');
                if (tab.dataset.type === currentType) {
                    tab.classList.add('active');
                }
            });

            // Cập nhật breadcrumbs ban đầu
            updateBreadcrumbs(currentSign, currentType);

            // Cập nhật H1 title ban đầu
            updateMainTitle(currentSign, currentType);

            // Cập nhật meta tags ban đầu
            updateMetaTags(currentSign, currentType);

            // Đặt initial state cho current page
            window.history.replaceState({
                sign: currentSign,
                type: currentType
            }, '', window.location.href);

            // Tự động tải dữ liệu cho tab đang active khi trang vừa tải xong
            const initialActiveTab = tabsContainer.querySelector('.tab-horoscope.active');
            if (initialActiveTab) {
                fetchHoroscope(initialActiveTab.dataset.type);
            }
        });
    </script>
@endpush
