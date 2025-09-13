@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Tiện ích <i class="bi bi-chevron-right"></i> <span style="color: #2254AB">Đổi ngày âm dương </span></h6>


        <div class="row g-0 justify-content-center pt-lg-5 pt-4">
            <div class="col-xl-10 col-lg-12 col-md-12 col-12">
                <div class="backv-doi-lich ">
                    <div class="">
                        <div class="row g-3 --pading">
                            <div class="col-lg-8">
                                <h6 class="title-chon-lich">Chọn ngày dương lịch bất kỳ:</h6>
                                <p>Chọn ngày dương lịch bất kỳ ngày dương lịch bất kỳ ngày dương lịch bất kỳ.</p>
                                <form action="{{ route('convert.am.to.duong') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold" style="color: #212121CC">Ngày Dương
                                                Lịch</label>
                                            <div class="date-input-wrapper">
                                                <input type="text" value="" name="solar_date" id="solar_date"
                                                    class="form-control dateuse2r" placeholder="dd/mm/yyyy" inputmode="text"
                                                    autocomplete="off" readonly data-type="solar">
                                                <span class="date-icon-custom">
                                                    <i class="bi bi-calendar-date-fill"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold" style="color: #212121CC">Ngày Âm Lịch</label>
                                            <div class="date-input-wrapper">
                                                <input type="text" value="" name="lunar_date" id="lunar_date"
                                                    class="form-control dateuse2r" placeholder="dd/mm/yyyy" inputmode="text"
                                                    autocomplete="off" readonly data-type="lunar">
                                                <span class="date-icon-custom">
                                                    <i class="bi bi-calendar-date-fill"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary btnd-nfay">Chuyển đổi</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block">
                                <img src="{{ asset('icons/datedoilich.svg') }}" alt="ảnh đổi lich" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-lg-3 order-2 order-lg-1">
                <h6 class="--text-down-convert">Kết quả chuyển đổi</h6>
                <div class="info-item">
                    <img src="{{ asset('icons/icon_tiet_khi.png') }}" alt="icon_tiet_khi" class="icon_tiet_khi">
                    <div class="font-detail-ngay">
                        <strong class="title-font-detail-ngay">Tiết khí:</strong>
                        {!! $tietkhi['icon'] !!} <span class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <img src="{{ asset('icons/icon_nap_am.png') }}" alt="icon_nap_am" class="icon_nap_am">
                    <div class="font-detail-ngay">
                        <strong class="title-font-detail-ngay">Ngũ hành nạp âm:</strong>
                        {{ $getThongTinNgay['nap_am']['napAm'] }}
                    </div>
                </div>
                <div class="info-item">
                    <img src="{{ asset('icons/icon_hoang_dao.png') }}" alt="icon_hoang_dao" class="icon_hoang_dao">
                    <div class="font-detail-ngay">
                        <strong class="title-font-detail-ngay">Giờ Hoàng đạo:</strong>
                        {{ $getThongTinNgay['gio_hoang_dao'] }}
                    </div>
                </div>
                <div class="col-lg-12 pt-2 d-flex justify-content-center ">
                    <a href="{{ route('detai_home', ['nam' => $yy, 'thang' => $mm, 'ngay' => $dd]) }}" class="btn btn-primary w-100 mt-3" > <img src="/icons/hand_2_white.svg" alt="hand_2" class="img-fluid"> Xem chi tiết</a>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="box-date-detail">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="date-display-card">
                                <a href="javascript:void(0)" class="nav-arrow nav-home-date nave-left prev-day-btn"
                                    title="Ngày hôm trước" onclick="changeDay(-1)"><i class="bi bi-chevron-left"></i></a>
                                <div class="text-center">
                                    <div class="card-title title-amduowngbox"><img src="/icons/icon_duong.svg"
                                            alt="icon_duong" width="20px" height="20px"> Dương lịch</div>
                                    <div class="date-number duong date_number_lich"> {{ $dd }}</div>
                                    <div class="date-weekday">{{ $weekday }}</div>
                                    <div class="date-special-event text-dark">Tháng {{ $mm }} năm
                                        {{ $yy }}</div>
                                    <div class="date-special-event">
                                        @if (!empty($suKienDuongLich))
                                            @foreach ($suKienDuongLich as $suKien)
                                                <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-6">
                            <div class="date-display-card">
                                <div class="text-center">
                                    <div class="card-title title-amduowngbox"><img src="/icons/icon_am.svg"
                                            alt="icon_am" width="20px" height="20px"> Âm lịch</div>
                                    <div class="date-number am date_number_lich date_number_lich_am">{{ $al[0] }}
                                    </div>
                                    <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                        {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                                    <div class="date-special-event text-dark">Ngày
                                        {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                        -
                                        Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                                    <div class="date-special-event">
                                        @if (!empty($suKienAmLich))
                                            @foreach ($suKienAmLich as $suKien)
                                                <div class="su-kien-duong">{{ $suKien['ten_su_kien'] ?? $suKien }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <a href="javascript:void(0)" class="nav-arrow nav-home-date nave-right next-day-btn"
                                    title="Ngày hôm sau" onclick="changeDay(1)"> <i class="bi bi-chevron-right"></i></a>
                                @if ($tot_xau_result == 'tot')
                                    <div class="day-status hoang-dao">
                                        <span class="status-dot"></span>
                                        <span class="title-status-dot"> Hoàng đạo</span>
                                    </div>
                                @elseif($tot_xau_result == 'xau')
                                    <div class="day-status hac-dao">
                                        <span class="status-dot"></span>
                                        <span class="title-status-dot"> Hắc đạo</span>
                                    </div>
                                @else
                                    <div class="day-status ">

                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="col-lg-12 btn-mobie-next-prev">
                            <div></div>
                            <div class="d-flex gap-2">
                                <div class="div">
                                    <a href="javascript:void(0)"
                                        class="nav-arrow prev-day-btn-mobie  nave-left prev-day-btn"
                                        title="Ngày hôm trước" onclick="changeDay(-1)"><i
                                            class="bi bi-chevron-left"></i></a>
                                </div>
                                <div class="div">
                                    <a href="javascript:void(0)"
                                        class="nav-arrow  next-day-btn-mobie nave-right next-day-btn" title="Ngày hôm sau"
                                        onclick="changeDay(1)"> <i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="calendar-legend mt-3">
                            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
                         
                        </div>
                </div>
                
            </div>
        </div>

        <div class="mt-5">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    {{-- Nút Quay lại tháng trước --}}
                    <a href="{{ route('lich.thang', ['nam' => $prevYear, 'thang' => $prevMonth]) }}" class="month-nav">
                        <i class="bi bi-chevron-left"></i>
                    </a>

                    {{-- Tiêu đề Tháng/Năm --}}
                    <h5 class="mb-0">Tháng {{ $mm }} năm {{ $yy }}</h5>

                    {{-- Nút Tới tháng sau --}}
                    <a href="{{ route('lich.thang', ['nam' => $nextYear, 'thang' => $nextMonth]) }}" class="month-nav">
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    {{-- ============================================= --}}
                    {{-- BẮT ĐẦU: THÊM NÚT "HÔM NAY" VÀO ĐÂY --}}
                    {{-- ============================================= --}}
                    <a href="{{ route('lich.nam.ngay', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                        class="btn-today-home-pc btn-today-home">
                        <i class="bi bi-calendar-plus pe-1-pc-home"></i> Hôm nay
                    </a>
                    {{-- ============================================= --}}
                    {{-- KẾT THÚC: NÚT "HÔM NAY" --}}
                    {{-- ============================================= --}}
                </div>
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th><span class="title-lich-pc">Thứ hai</span> <span class="title-lich-mobie">Th
                                    2</span>
                            </th>
                            <th><span class="title-lich-pc">Thứ ba</span> <span class="title-lich-mobie">Th
                                    3</span>
                            </th>
                            <th><span class="title-lich-pc">Thứ tư</span> <span class="title-lich-mobie">Th
                                    4</span>
                            </th>
                            <th><span class="title-lich-pc">Thứ năm</span> <span class="title-lich-mobie">Th
                                    5</span>
                            </th>
                            <th><span class="title-lich-pc">Thứ sau</span> <span class="title-lich-mobie">Th
                                    6</span>
                            </th>
                            <th><span class="title-lich-pc">Thứ bảy</span> <span class="title-lich-mobie">Th
                                    7</span>
                            </th>
                            <th><span class="title-lich-pc">Chủ nhật</span> <span class="title-lich-mobie">CN</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        {!! $table_html !!}
                    </tbody>
                </table>

            </div>

        </div>
        <div class="search-am-duong-lich">
            <div class="van-lien-hows">
                <h2>Tìm hiểu thêm về âm lịch</h2>
                <hr>
                <div>
                    <ul>
                        <li><b>Âm lịch</b> là loại lịch được tính theo chu kỳ tròn khuyết của mặt trăng, tức là khoảng thời
                            gian hai lần liên tiếp trăng tròn hoặc không tròn. Bình quân cứ 29,53 ngày là một lần mặt trăng
                            tròn khuyết tuy nhiên để thuận lợi cho việc tính toán người xưa tính chẵn một đủ có 30 ngày,
                            tháng thiếu có 29 ngày.</li>
                        <li>
                            Từ thời xa xưa, khi con người chưa biết đến những thành tựu của khoa học công nghệ thì việc
                            trồng trọt, chăn nuôi hoàn toàn phụ thuộc vào việc “trông trời, trông đất, trông mây”.<b> Nhờ có
                                Âm
                                lịch</b> mà dân ta đã biết tính toán ngày sản xuất bắt đầu mùa vụ, ngày thủy triều lên xuống
                            hay
                            việc tự mình dự đoán thời tiết để làm nông nghiệp..
                        </li>
                        <li>
                            Ngày nay, âm lịch của Việt Nam thực chất là âm dương lịch, nghĩa là thời gian được tính theo <b>
                                chu
                                kỳ của Mặt Trăng</b> nhưng các tháng nhuận lại được điều chỉnh theo quy luật để ăn khớp với
                            năm
                            dương lịch. Trong một năm có 12 ngày tiết khí và 12 ngày trung khí được gọi là 24 ngày tiết, tên
                            ngày tiết được đặt tên theo khí hậu như xuân phân, hạ chí, đại hàn…việc sản xuất nông nghiệp,
                            chăn nuôi, trồng trọt cũng dựa theo các ngày tiết này.
                        </li>
                        <li>

                            Ngoài những ngày lễ dương lịch, người dân Việt Nam còn sử dụng cả âm lịch trong các ngày <b>lễ
                                truyền thống</b> quan trọng như tết Nguyên Đán, ngày giỗ tổ Hùng Vương, tết Đoan Ngọ, rằm
                            Trung Thu,
                            tết Ông Táo..cho đến những ngày lễ tâm linh, mang ý nghĩa thiêng liêng như Thượng Nguyên, Trung
                            Nguyên, Hạ Nguyên, Trùng Thập, Trùng Cửu và cả ngày giỗ của ông bà tổ tiên trong gia đình.</li>
                        <li>
                            Có thể thấy rằng âm lịch có <b>vai trò quan trọng</b> đối với đời sống sinh hoạt, sản xuất của
                            người
                            dân Việt Nam từ xa xưa cho đến tận ngày nay.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        // Function to change day
        function changeDay(days) {
            const solarInput = document.getElementById('solar_date');
            const currentDate = solarInput.value;

            if (currentDate) {
                const parts = currentDate.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    const date = new Date(year, month, day);

                    // Add/subtract days
                    date.setDate(date.getDate() + days);

                    // Format the new date
                    const newDay = String(date.getDate()).padStart(2, '0');
                    const newMonth = String(date.getMonth() + 1).padStart(2, '0');
                    const newYear = date.getFullYear();
                    const newDateStr = `${newDay}/${newMonth}/${newYear}`;

                    // Create a form and submit to /am-sang-duong
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/am-sang-duong';

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Add solar date input
                    const solarDateInput = document.createElement('input');
                    solarDateInput.type = 'hidden';
                    solarDateInput.name = 'solar_date';
                    solarDateInput.value = newDateStr;
                    form.appendChild(solarDateInput);

                    // Add lunar date input (current value)
                    const lunarInput = document.getElementById('lunar_date');
                    const lunarDateInput = document.createElement('input');
                    lunarDateInput.type = 'hidden';
                    lunarDateInput.name = 'lunar_date';
                    lunarDateInput.value = lunarInput.value;
                    form.appendChild(lunarDateInput);

                    // Append to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const maxDate = new Date(today.getFullYear() + 5, 11, 31);
            let overlay = null;
            let isUpdating = false; // Prevent infinite loops

            const solarInput = document.getElementById('solar_date');
            const lunarInput = document.getElementById('lunar_date');

            // Debug log
            console.log('Solar input:', solarInput);
            console.log('Lunar input:', lunarInput);

            // Tạo overlay cho mobile
            function createOverlay() {
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'daterangepicker-overlay';
                    document.body.appendChild(overlay);

                    overlay.addEventListener('click', function() {
                        document.querySelectorAll('.dateuse2r').forEach(input => {
                            if ($(input).data('daterangepicker')) {
                                $(input).data('daterangepicker').hide();
                            }
                        });
                    });
                }
                return overlay;
            }

            // Format date to d/m/Y
            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // Parse date from d/m/Y format
            function parseDate(dateStr) {
                const parts = dateStr.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    return new Date(year, month, day);
                }
                return null;
            }

            // Convert date from dd/mm/yyyy to yyyy-mm-dd for API
            function convertToApiFormat(dateStr) {
                const parts = dateStr.split('/');
                if (parts.length === 3) {
                    const [day, month, year] = parts;
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }
                return dateStr;
            }

            // Convert date from yyyy-mm-dd to dd/mm/yyyy for display
            function convertFromApiFormat(dateStr) {
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const [year, month, day] = parts;
                    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
                }
                return dateStr;
            }

            // API call to convert solar to lunar
            async function convertSolarToLunar(solarDate) {
                try {
                    const apiDate = convertToApiFormat(solarDate);
                    const response = await fetch('/api/convert-to-am', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            date: apiDate
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        const lunarDate = data.date;
                        return convertFromApiFormat(lunarDate);
                    } else {
                        const errorData = await response.json();
                        console.error('API Error:', errorData.error || 'Unknown error');
                    }
                } catch (error) {
                    console.error('Error converting solar to lunar:', error);
                }
                return null;
            }

            // API call to convert lunar to solar
            async function convertLunarToSolar(lunarDate) {
                try {
                    const apiDate = convertToApiFormat(lunarDate);
                    const response = await fetch('/api/convert-to-duong', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            date: apiDate
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        const solarDate = data.date;
                        return convertFromApiFormat(solarDate);
                    } else {
                        const errorData = await response.json();
                        console.error('API Error:', errorData.error || 'Unknown error');
                    }
                } catch (error) {
                    console.error('Error converting lunar to solar:', error);
                }
                return null;
            }

            // Set default value for inputs từ controller hoặc ngày hôm nay
            @if (isset($dd) && isset($mm) && isset($yy) && isset($al))
                // Có dữ liệu từ controller - đưa trực tiếp vào input
                const solarDateFromController = '{{ $dd }}/{{ $mm }}/{{ $yy }}';
                const lunarDateFromController =
                    '{{ sprintf('%02d', $al[0]) }}/{{ sprintf('%02d', $al[1]) }}/{{ $al[2] }}';

                // Đưa trực tiếp vào input không qua API
                solarInput.value = solarDateFromController;
                lunarInput.value = lunarDateFromController;

                console.log('Set from controller - Solar:', solarDateFromController, 'Lunar:',
                    lunarDateFromController);
            @else
                // Không có dữ liệu từ controller - dùng ngày hôm nay
                const todayFormatted = formatDate(today);
                solarInput.value = todayFormatted;

                // Convert today to lunar via API
                convertSolarToLunar(todayFormatted).then(lunarDate => {
                    if (lunarDate) {
                        lunarInput.value = lunarDate;
                    }
                });

                console.log('Using today:', todayFormatted);
            @endif

            // Initialize daterangepicker cho từng input (chỉ single date)
            document.querySelectorAll('.dateuse2r').forEach(function(input) {
                // Lấy startDate từ giá trị hiện tại của input hoặc today
                let startDate = today;
                if (input.value) {
                    const inputDate = parseDate(input.value);
                    if (inputDate) {
                        startDate = inputDate;
                    }
                }

                $(input).daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 1900,
                    maxYear: maxDate.getFullYear(),
                    maxDate: maxDate,
                    startDate: startDate,
                    showCustomRangeLabel: false,
                    alwaysShowCalendars: true,
                    locale: {
                        format: 'DD/MM/YYYY',
                        applyLabel: 'Chọn',
                        cancelLabel: 'Hủy',
                        weekLabel: 'T',
                        daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                        monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                            'Tháng 6',
                            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                        ],
                        firstDay: 1
                    },
                    opens: 'center',
                    drops: 'down'
                }, function(start, end, label) {
                    setTimeout(function() {
                        // The ranges div might still be there visually, hide it
                        $('.daterangepicker .ranges').hide();
                    }, 10);
                });

                // Events
                $(input).on('show.daterangepicker', function(ev, picker) {
                    setTimeout(function() {
                        // Ensure ranges div is hidden on show as well
                        $('.daterangepicker .ranges').hide();
                        // Also, ensure the calendar takes full width if there's only one
                        $('.daterangepicker .drp-calendar').css({
                            'width': '100%',
                            'border-right': 'none'
                        });
                    }, 1);

                    if (window.innerWidth <= 768) {
                        const overlay = createOverlay();
                        overlay.style.display = 'block';
                    }
                });

                $(input).on('hide.daterangepicker', function(ev, picker) {
                    if (overlay) {
                        overlay.style.display = 'none';
                    }
                });

                $(input).on('apply.daterangepicker', async function(ev, picker) {
                    const selectedDate = picker.startDate.format('DD/MM/YYYY');
                    input.value = selectedDate;

                    if (overlay) {
                        overlay.style.display = 'none';
                    }

                    // Prevent infinite loops
                    if (isUpdating) return;
                    isUpdating = true;

                    // Convert and update the other input
                    const inputType = input.getAttribute('data-type');

                    if (inputType === 'solar') {
                        // Converting solar to lunar
                        const lunarDate = await convertSolarToLunar(selectedDate);
                        if (lunarDate && lunarInput) {
                            lunarInput.value = lunarDate;
                        }
                    } else if (inputType === 'lunar') {
                        // Converting lunar to solar
                        const solarDate = await convertLunarToSolar(selectedDate);
                        if (solarDate && solarInput) {
                            solarInput.value = solarDate;
                        }
                    }

                    isUpdating = false;
                });

                // Handle icon click
                const icon = input.parentNode.querySelector('.date-icon-custom');
                if (icon) {
                    icon.addEventListener('click', function(e) {
                        e.preventDefault();
                        $(input).data('daterangepicker').show();
                    });
                }
            });
        });
    </script>
@endpush
