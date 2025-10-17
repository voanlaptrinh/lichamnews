<div class="col-lg-3">
    <div class="events-card">
        <h5 class="card-title-right">Giới thiệu cung hoàng đạo</h5>
        <div class="zodiac-list row g-2">
            @php
                $zodiacs = [
                    ['slug' => 'bach-duong', 'name' => 'Bạch Dương', 'date' => '21/3 - 19/4', 'icon' => 'aries'],
                    ['slug' => 'kim-nguu', 'name' => 'Kim Ngưu', 'date' => '20/4 - 20/5', 'icon' => 'taurus'],
                    ['slug' => 'song-tu', 'name' => 'Song Tử', 'date' => '21/5 - 20/6', 'icon' => 'gemini'],
                    ['slug' => 'cu-giai', 'name' => 'Cự Giải', 'date' => '21/6 - 22/7', 'icon' => 'cancer'],
                    ['slug' => 'su_tu', 'name' => 'Sư Tử', 'date' => '23/7 - 22/8', 'icon' => 'leo'],
                    ['slug' => 'xu-nu', 'name' => 'Xử Nữ', 'date' => '23/8 - 22/9', 'icon' => 'virgo'],
                    ['slug' => 'thien-binh', 'name' => 'Thiên Bình', 'date' => '23/9 - 22/10', 'icon' => 'libra'],
                    ['slug' => 'bo-cap', 'name' => 'Bọ Cạp', 'date' => '23/10 - 21/11', 'icon' => 'scorpio'],
                    ['slug' => 'nhan-ma', 'name' => 'Nhân Mã', 'date' => '22/11 - 21/12', 'icon' => 'sagittarius'],
                    ['slug' => 'ma-ket', 'name' => 'Ma Kết', 'date' => '22/12 - 19/1', 'icon' => 'capricorn'],
                    ['slug' => 'bao-binh', 'name' => 'Bảo Bình', 'date' => '20/1 - 18/2', 'icon' => 'aquarius'],
                    ['slug' => 'song-ngu', 'name' => 'Song Ngư', 'date' => '19/2 - 20/3', 'icon' => 'pisces'],
                ];
                $current = request()->route('signSlug');
            @endphp

            @foreach ($zodiacs as $zodiac)
                <div class="col-6 col-md-4 col-lg-12">
                    <a class="zodiac-item {{request()->routeIs('horoscope.show') &&  $current === $zodiac['slug'] ? 'active' : '' }}"
                       href="{{ route('horoscope.show', ['signSlug' => $zodiac['slug']]) }}"
                       data-sign="{{ $zodiac['icon'] }}">
                        <img src="{{ asset('/icons/' . $zodiac['icon'] . '-icons.svg') }}"
                             alt="{{ $zodiac['name'] }}" class="zodiac-item-icon">
                        <div class="zodiac-item-info">
                            <div class="zodiac-item-name">{{ $zodiac['name'] }}</div>
                            <div class="zodiac-item-date">{{ $zodiac['date'] }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
