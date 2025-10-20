@extends('welcome')

@section('content')
    @php
        // This data is now used for the select dropdown
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
        $zodiacNames_acc = [
            'aries' => 'bach-duong',
            'taurus' => 'kim-nguu',
            'gemini' => 'song-tu',
            'cancer' => 'cu-giai',
            'leo' => 'su_tu',
            'virgo' => 'xu-nu',
            'libra' => 'thien-binh',
            'scorpio' => 'than-nong',
            'sagittarius' => 'nhan-ma',
            'capricorn' => 'ma-ket',
            'aquarius' => 'bao-binh',
            'pisces' => 'song-ngu',
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
        <h6 class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            <a style="color: #2254AB; text-decoration: underline;" href="{{ route('horoscope.index') }}">Cung hoàng đạo</a> <i
                class="bi bi-chevron-right"></i><a style="color: #2254AB; text-decoration: underline;"
                href="{{ route('horoscope.show', ['signSlug' => $zodiacNames_acc[$zodiac['sign']]]) }}"
                id="breadcrumb-zodiac">{{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }}</a> <i
                class="bi bi-chevron-right"></i><span id="breadcrumb-time">Hôm nay</span>
        </h6>
        <h1 class="content-title-home-lich" id="main-title">Tử Vi Cung {{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }} Hôm nay</h1>
    </div>

    <!-- Zodiac Header -->
    <div class="row mt-3">
        {{-- Changed col-lg-9 to col-lg-12 --}}
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
                {{-- Modified zodiac-header to include the select dropdown --}}
                <div class="zodiac-header">

                    <div class="zodiac-current" style="display: flex; align-items: center;">
                        <div class="zodiac-icon" id="zodiac-icon">
                            <img src="{{ asset($zodiacIcons[$zodiac['sign']] ?? '⭐') }}" alt="">
                        </div>
                        <div class="zodiac-info">
                            <h3 id="zodiac-name">{{ $zodiacNames[$zodiac['sign']] ?? 'Cung hoàng đạo' }}</h3>
                            <p id="zodiac-date">{{ $zodiacDates[$zodiac['sign']] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="zodiac-selector-form">
                        <select id="zodiac-select" class="form-select custom-select-style" style="min-width: 200px;">
                            @foreach ($zodiacNames as $sign => $name)
                                <option value="{{ $sign }}" {{ $sign == $zodiac['sign'] ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <!-- Main Content Card -->
            <div id="horoscope-content" class="horoscope-content">
                <div style="text-align: center; padding: 40px; color: #666; font-style: italic;">Đang tải dữ liệu...</div>
            </div>
        </div>

        @include('horoscope.box-right')
        {{-- Removed the right sidebar (col-lg-3) --}}
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabsContainer = document.getElementById('tabs');
            const horoscopeContent = document.getElementById('horoscope-content');
            // const zodiacList = document.querySelector('.zodiac-list'); // REMOVED
            const zodiacSelect = document.getElementById('zodiac-select'); // ADDED
            const zodiacIcon = document.getElementById('zodiac-icon');
            const zodiacName = document.getElementById('zodiac-name');
            const zodiacDate = document.getElementById('zodiac-date');
            const zodiacTitle = document.getElementById('zodiac-title');
            const breadcrumbZodiac = document.getElementById('breadcrumb-zodiac');
            const breadcrumbTime = document.getElementById('breadcrumb-time');
            const timePeriod = document.getElementById('time-period');

            let currentSign = '{{ $zodiac['sign'] }}';
            let currentType = '{{ $currentType ?? 'today' }}';

            const signSlugs = @json($signSlugs ?? []);
            const typeSlugs = @json($typeSlugs ?? []);

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

            const zodiacData = {
                'aries': {
                    icon: '{{ asset('/icons/aries-icons.svg') }}',
                    name: 'Bạch Dương',
                    date: '21/3 - 19/4',
                    engName: 'Aries'
                },
                'taurus': {
                    icon: '{{ asset('/icons/taurus-icons.svg') }}',
                    name: 'Kim Ngưu',
                    date: '20/4 - 20/5',
                    engName: 'Taurus'
                },
                'gemini': {
                    icon: '{{ asset('/icons/gemini-icons.svg') }}',
                    name: 'Song Tử',
                    date: '21/5 - 20/6',
                    engName: 'Gemini'
                },
                'cancer': {
                    icon: '{{ asset('/icons/cancer-icons.svg') }}',
                    name: 'Cự Giải',
                    date: '21/6 - 22/7',
                    engName: 'Cancer'
                },
                'leo': {
                    icon: '{{ asset('/icons/leo-icons.svg') }}',
                    name: 'Sư Tử',
                    date: '23/7 - 22/8',
                    engName: 'Leo'
                },
                'virgo': {
                    icon: '{{ asset('/icons/virgo-icons.svg') }}',
                    name: 'Xử Nữ',
                    date: '23/8 - 22/9',
                    engName: 'Virgo'
                },
                'libra': {
                    icon: '{{ asset('/icons/libra-icons.svg') }}',
                    name: 'Thiên Bình',
                    date: '23/9 - 22/10',
                    engName: 'Libra'
                },
                'scorpio': {
                    icon: '{{ asset('/icons/scorpio-icons.svg') }}',
                    name: 'Thần Nông',
                    date: '23/10 - 21/11',
                    engName: 'Scorpio'
                },
                'sagittarius': {
                    icon: '{{ asset('/icons/sagittarius-icons.svg') }}',
                    name: 'Nhân Mã',
                    date: '22/11 - 21/12',
                    engName: 'Sagittarius'
                },
                'capricorn': {
                    icon: '{{ asset('/icons/capricorn-icons.svg') }}',
                    name: 'Ma Kết',
                    date: '22/12 - 19/1',
                    engName: 'Capricorn'
                },
                'aquarius': {
                    icon: '{{ asset('/icons/aquarius-icons.svg') }}',
                    name: 'Bảo Bình',
                    date: '20/1 - 18/2',
                    engName: 'Aquarius'
                },
                'pisces': {
                    icon: '{{ asset('/icons/pisces-icons.svg') }}',
                    name: 'Song Ngư',
                    date: '19/2 - 20/3',
                    engName: 'Pisces'
                }
            };

            function updateMetaTags(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];
                if (zodiac && typeMeta) {
                    document.title =
                        `Cung ${zodiac.name} - ${zodiac.engName} (${zodiac.date}) ${typeMeta.suffix} | Tính cách, Tình yêu, Sự nghiệp`;
                    let metaDesc = document.querySelector('meta[name="description"]');
                    if (metaDesc) {
                        metaDesc.setAttribute('content',
                            `Xem tử vi cung ${zodiac.name} ${typeMeta.descSuffix}: Khám phá tính cách, tình yêu, sự nghiệp và vận mệnh chi tiết. Dự báo chính xác cho người sinh ${zodiac.date}.`
                        );
                    }
                }
            }

            function updateBreadcrumbs(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];
                if (zodiac && breadcrumbZodiac) breadcrumbZodiac.textContent = zodiac.name;
                if (typeMeta && breadcrumbTime) breadcrumbTime.textContent = typeMeta.breadcrumb;
            }

            function updateMainTitle(sign, type) {
                const zodiac = zodiacData[sign];
                const typeMeta = typeMetaData[type];
                if (zodiac && typeMeta && document.getElementById('main-title')) {
                    document.getElementById('main-title').textContent = `Tử Vi Cung ${zodiac.name} ${typeMeta.suffix}`;
                }
            }

            function updateZodiacInfo(sign) {
                const data = zodiacData[sign];
                if (data) {
                    const iconImg = zodiacIcon.querySelector('img');
                    if (iconImg) iconImg.src = data.icon;
                    zodiacName.textContent = data.name;
                    zodiacDate.textContent = data.date;
                }
            }

            async function fetchHoroscope(type) {
                horoscopeContent.innerHTML =
                    '<div style="text-align: center; padding: 40px; color: #666; font-style: italic;">Đang tải dữ liệu...</div>';
                const apiUrl = `{{ url('/api/horoscope-data') }}/${currentSign}/${type}`;
                try {
                    const response = await fetch(apiUrl);
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.error || `Lỗi máy chủ: ${response.status}`);
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

            // NEW: Event listener for the select dropdown
            zodiacSelect.addEventListener('change', (event) => {
                const newSign = event.target.value;
                handleSignChange(newSign);
            });

            // REFACTORED: Common function to handle sign change
            function handleSignChange(newSign) {
                currentSign = newSign;
                updateZodiacInfo(newSign);
                updateBreadcrumbs(newSign, currentType);
                updateMainTitle(newSign, currentType);
                updateMetaTags(newSign, currentType);
                const activeTab = tabsContainer.querySelector('.tab-horoscope.active');
                if (activeTab) {
                    fetchHoroscope(activeTab.dataset.type);
                }
                const signSlug = signSlugs[newSign];
                const typeSlug = typeSlugs[currentType];
                if (signSlug && typeSlug) {
                    const newUrl = `{{ url('/cung-hoang-dao') }}/${signSlug}/${typeSlug}`;
                    window.history.pushState({
                        sign: newSign,
                        type: currentType
                    }, '', newUrl);
                }
            }

            // REMOVED: Old event listener for zodiacList

            tabsContainer.addEventListener('click', (event) => {
                const selectedTab = event.target.closest('.tab-horoscope');
                if (!selectedTab) return;
                const type = selectedTab.dataset.type;
                currentType = type;
                tabsContainer.querySelector('.active')?.classList.remove('active');
                selectedTab.classList.add('active');
                updateBreadcrumbs(currentSign, type);
                updateMainTitle(currentSign, type);
                updateMetaTags(currentSign, type);
                fetchHoroscope(type);
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

            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.sign && event.state.type) {
                    currentSign = event.state.sign;
                    currentType = event.state.type;

                    // Update select dropdown
                    zodiacSelect.value = currentSign;

                    tabsContainer.querySelectorAll('.tab-horoscope').forEach(tab => {
                        tab.classList.remove('active');
                        if (tab.dataset.type === currentType) tab.classList.add('active');
                    });
                    updateZodiacInfo(currentSign);
                    updateBreadcrumbs(currentSign, currentType);
                    updateMainTitle(currentSign, currentType);
                    updateMetaTags(currentSign, currentType);
                    fetchHoroscope(currentType);
                }
            });

            tabsContainer.querySelectorAll('.tab-horoscope').forEach(tab => {
                tab.classList.remove('active');
                if (tab.dataset.type === currentType) tab.classList.add('active');
            });

            updateBreadcrumbs(currentSign, currentType);
            updateMainTitle(currentSign, currentType);
            updateMetaTags(currentSign, currentType);
            window.history.replaceState({
                sign: currentSign,
                type: currentType
            }, '', window.location.href);
            const initialActiveTab = tabsContainer.querySelector('.tab-horoscope.active');
            if (initialActiveTab) {
                fetchHoroscope(initialActiveTab.dataset.type);
            }
        });
    </script>
@endpush
