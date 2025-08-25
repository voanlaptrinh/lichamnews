@extends('welcome')
@section('content')
    <div class="calendar-app-container py-4">
        <div class="row g-3">
            <!-- ==== CỘT LỊCH CHÍNH (BÊN TRÁI) ==== -->
            <div class="col-xl-9 col-sm-12 col-12">
                <div class="boxx-col-lg-8">
                    <div class="d-flex flex-column gap-3 box-content-lg-8">

                        <!-- ** KHỐI NGÀY DƯƠNG LỊCH VÀ ÂM LỊCH ** -->
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="date-display-card">

                                    <a href="#" class="nav-arrow nav-home-date nave-left prev-day-btn"
                                        title="Ngày hôm trước"><i class="bi bi-chevron-left"></i></a>
                                    <div class="text-center">
                                        <div class="card-title"><img src="{{ asset('icons/icon_duong.svg') }}"
                                                alt="icon_duong" width="20px" height="20px"> Dương lịch</div>
                                        <div class="date-number duong date_number_lich"> {{ $dd }}</div>
                                        <div class="date-weekday">{{ $weekday }}, tháng {{ $mm }} năm
                                            {{ $yy }}</div>
                                        <div class="date-special-event">
                                            @foreach ($suKienHomNay as $suKien)
                                                {{ $suKien['ten_su_kien'] ?? $suKien }}
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="#" class=""></a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="date-display-card">

                                    <div class="text-center">
                                        <div class="card-title"><img src="{{ asset('icons/icon_am.svg') }}" alt="icon_am"
                                                width="20px" height="20px"> Âm lịch</div>
                                        <div class="date-number am date_number_lich">{{ $al[0] }}</div>
                                        <div class="date-weekday">Tháng {{ $al[1] }} ({{ $al[4] }}) năm
                                            {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}</div>
                                        <div class="date-special-event">Ngày {{ $getThongTinCanChiVaIcon['can_chi_ngay'] }}
                                            -
                                            Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}</div>
                                    </div>
                                    <a href="#" class="nav-arrow nav-home-date nave-right next-day-btn"
                                        title="Ngày hôm sau"> <i class="bi bi-chevron-right"></i></a>
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
                                <div>
                                    <a href="{{ route('lich.nam.ngay', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }} "
                                        class="btn-today-home-mob">
                                        <i class="bi bi-calendar-plus pe-1"></i> Hôm nay
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="div">
                                        <a href="#" class="nav-arrow prev-day-btn-mobie  nave-left prev-day-btn"
                                            title="Ngày hôm trước"><i class="bi bi-chevron-left"></i></a>
                                    </div>
                                    <div class="div">
                                        <a href="#" class="nav-arrow  next-day-btn-mobie nave-right next-day-btn"
                                            title="Ngày hôm sau"> <i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-card d-sm-block d-block d-xl-none">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_tiet_khi.png') }}" alt="icon_tiet_khi"
                                            class="icon_tiet_khi">
                                        <div class="font-detail-ngay">
                                            <strong>Tiết khí:</strong> {!! $tietkhi['icon'] !!} <span
                                                class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_nap_am.png') }}" alt="icon_nap_am"
                                            class="icon_nap_am">
                                        <div class="font-detail-ngay">
                                            <strong>Ngũ hành nạp âm:</strong> {{ $getThongTinNgay['nap_am']['napAm'] }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <img src="{{ asset('icons/icon_hoang_dao.png') }}" alt="icon_hoang_dao"
                                            class="icon_hoang_dao">
                                        <div class="font-detail-ngay">
                                            <strong>Giờ Hoàng đạo:</strong> {{ $getThongTinNgay['gio_hac_dao'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- BẮT ĐẦU: KHỐI MỨC THUẬN LỢI (ĐÃ CẬP NHẬT) -->
                                    <div
                                        class="convenience-level d-flex justify-content-between align-items-center row h-100">
                                        <div class="col-6">
                                            <div class="level-label text-lever-label-mobie">
                                                Mức thuận lợi<br>hôm nay:
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="progress-dial"
                                                style="--value: {{ round($getDaySummaryInfo['score']['percentage']) }};">
                                                <div class="dial-text">
                                                    <span
                                                        class="dial-percent">{{ round($getDaySummaryInfo['score']['percentage']) }}%</span>
                                                    @php
                                                        $ratingColors = [
                                                            'Tốt' => 'text-success',
                                                            'Xấu' => 'text-danger',
                                                            'Trung bình' => 'text-warning-tb',
                                                        ];
                                                    @endphp

                                                    <small
                                                        class="dial-status {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? 'text-secondary' }}">
                                                        {{ $getDaySummaryInfo['score']['rating'] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- KẾT THÚC: KHỐI MỨC THUẬN LỢI -->
                                </div>
                            </div>


                            <a href="#" class="btn btn-primary w-100 mt-3 btn0mobie"><img
                                    src="{{ asset('icons/hand_2_white.svg') }}" alt="hand_2" class="img-fluid"> Xem
                                chi
                                tiết ngày</a>
                        </div>
                        <!-- ** LỊCH THÁNG ** -->
                        <div class="calendar-wrapper">
                            <div class="calendar-header">
                                {{-- Nút Quay lại tháng trước --}}
                                <a href="{{ route('lich.thang', ['nam' => $prevYear, 'thang' => $prevMonth]) }}"
                                    class="month-nav">
                                    <i class="bi bi-chevron-left"></i>
                                </a>

                                {{-- Tiêu đề Tháng/Năm --}}
                                <h5 class="mb-0">Tháng {{ $mm }} năm {{ $yy }}</h5>

                                {{-- Nút Tới tháng sau --}}
                                <a href="{{ route('lich.thang', ['nam' => $nextYear, 'thang' => $nextMonth]) }}"
                                    class="month-nav">
                                    <i class="bi bi-chevron-right"></i>
                                </a>

                                {{-- ============================================= --}}
                                {{-- BẮT ĐẦU: THÊM NÚT "HÔM NAY" VÀO ĐÂY --}}
                                {{-- ============================================= --}}
                                <a href="{{ route('lich.nam.ngay', ['nam' => date('Y'), 'thang' => date('n'), 'ngay' => date('d')]) }}"
                                    class="btn-today-home-pc btn-today-home">
                                    <i class="bi bi-calendar-plus pe-1"></i> Hôm nay
                                </a>
                                {{-- ============================================= --}}
                                {{-- KẾT THÚC: NÚT "HÔM NAY" --}}
                                {{-- ============================================= --}}
                            </div>
                            <table class="calendar-table">

                                <tbody>
                                    {!! $table_html !!}
                                </tbody>
                            </table>

                        </div>
                        <div class="calendar-legend">
                            <span><span class="dot dot-hoangdao"></span> Ngày hoàng đạo</span>
                            <span><span class="dot dot-hacdao"></span> Ngày hắc đạo</span>
                            <span><span class="dot dot-chủ nhật"></span> Ngày chủ nhật</span>
                            <span><span class="dot dot-special"></span> Ngày đặc biệt</span>
                        </div>
                    </div>
                </div>
                <section class="popular-utilities">
                    <div class="container">
                        <h2 class="section-title">Tiện ích phổ biến</h2>
                        <hr>
                        <div class="utilities-grid row g-4 pt-2">

                            <!-- Tiện ích 1 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4 ">
                                <h4 class="utility-title">Đổi ngày Âm - Dương</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/doi_ngay_am_duong.svg') }}" alt="Đổi ngày Âm - Dương"
                                        class="img-fluid">
                                </div>

                                <p class="utility-description">Chuyển đổi nhanh giữa dương lịch và âm lịch.</p>
                            </a>

                            <!-- Tiện ích 2 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Xem ngày Tốt</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/xem_ngay_tot.svg') }}" alt="Xem ngày Tốt"
                                        class="img-fluid">
                                </div>

                                <p class="utility-description">Tra cứu ngày hoàng đạo để cưới hỏi, khai trương...</p>
                            </a>

                            <!-- Tiện ích 3 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Xem hướng hợp mệnh</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/huong_dep.svg') }}" alt="Xem hướng hợp mệnh"
                                        class="img-fluid">
                                </div>
                                <p class="utility-description">Tìm hướng hợp tuổi để làm nhà, đặt bàn thờ...</p>
                            </a>

                            <!-- Tiện ích 4 -->
                            <a href="#" class="utility-item col-6 col-md-6 col-lg-3 mb-4">
                                <h4 class="utility-title">Lá số tử vi</h4>
                                <div class="icon-wrapper">
                                    <img src="{{ asset('icons/la_so_tu_vi.svg') }}" alt="Lá số tử vi" class="img-fluid">
                                </div>

                                <p class="utility-description">Lập lá số chi tiết theo giờ/ngày sinh.</p>
                            </a>

                        </div>
                    </div>
                </section>
                <div class="van-lien-hows">
                    <h2>Lịch Vạn Niên Là Gì?</h2>
                    <hr>
                    <ul>
                        <li>Lịch Vạn Niên là công cụ tra cứu ngày tháng theo cả hai hệ thống lịch: Dương lịch (lịch phương
                            Tây) và Âm lịch (lịch truyền thống phương Đông). Từ xa xưa, ông cha ta đã sử dụng lịch âm dương
                            để xác định ngày lành tháng tốt cho các công việc trọng đại như cưới hỏi, làm nhà, xuất hành,
                            khai trương, và nhiều hoạt động mang tính tâm linh, phong thủy khác.</li>
                        <li>
                            Trải qua hàng nghìn năm hình thành và phát triển, Lịch Vạn Niên không chỉ là cuốn lịch đơn
                            thuần, mà còn là kho tàng tri thức cổ truyền – nơi hội tụ những tinh hoa của Thiên văn học
                            phương Đông, Ngũ hành, Bát tự, Can Chi, và Tử vi lý số.</li>
                    </ul>

                    <h3>
                        <span>👉 Tại Sao Nên Sử Dụng Lịch Vạn Niên Của Nguyệt Lịch?</span>
                    </h3>
                    <ol>
                        <li>
                            <strong>Tra cứu nhanh chóng và chính xác:</strong>
                            <p>Dễ dàng xem ngày âm - dương, ngày hoàng đạo, tiết khí, sao chiếu, và các yếu tố phong thủy.
                            </p>
                        </li>
                        <li>
                            <strong>Chọn ngày tốt hợp tuổi:</strong>
                            <p>Lên kế hoạch cho các việc trọng đại như cưới hỏi, khởi công, động thổ, xuất hành... dựa trên
                                tuổi và can chi của gia chủ.</p>
                        </li>
                        <li>
                            <strong>Tích hợp kiến thức tử vi – phong thủy:</strong>
                            <p>Lập lá số tử vi, xem vận hạn theo năm, tra cứu hướng tốt, hóa giải Tam Tai – Hoang Ốc – Kim
                                Lâu.</p>
                        </li>
                        <li>
                            <strong>Giao diện thân thiện – dễ sử dụng:</strong>
                            <p>Thiết kế đơn giản, hiện đại, phù hợp mọi đối tượng sử dụng: từ người cao tuổi đến thế hệ trẻ.
                            </p>
                        </li>
                    </ol>

                    <h3>

                        <span>👉 Lịch Vạn Niên Trong Thời Đại Số</span>
                    </h3>
                    <ul>
                        <li>Trong kỷ nguyên công nghệ, Lịch Vạn Niên không còn chỉ nằm trong những cuốn sách cổ mà đã được
                            số hóa hoàn toàn, giúp người dùng tra cứu mọi lúc, mọi nơi – trên máy tính, điện thoại và cả các
                            thiết bị thông minh khác. Việc kết hợp giữa tri thức cổ truyền và công nghệ hiện đại mang lại
                            trải nghiệm tiện lợi, chính xác và đầy tin cậy.</li>
                        <li>Dù bạn là người quan tâm đến tử vi, phong thủy, hay chỉ đơn giản muốn biết hôm nay là ngày gì,
                            tốt hay xấu, Nguyệt Lịch luôn sẵn sàng đồng hành cùng bạn trên mỗi hành trình.</li>
                    </ul>
                </div>
            </div>

            <!-- ==== CỘT THÔNG TIN (BÊN PHẢI) ==== -->
            <div class="col-xl-3  col-sm-12 col-12">
                <div class="d-flex flex-column gap-4">

                    <!-- ** KHỐI THÔNG TIN CHI TIẾT ** -->
                    <div class="info-card d-sm-none d-none d-xl-block">
                        <div class="info-item">
                            <img src="{{ asset('icons/icon_tiet_khi.png') }}" alt="icon_tiet_khi" class="icon_tiet_khi">
                            <div>
                                <strong>Tiết khí:</strong> {!! $tietkhi['icon'] !!} <span
                                    class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <img src="{{ asset('icons/icon_nap_am.png') }}" alt="icon_nap_am" class="icon_nap_am">
                            <div>
                                <strong>Ngũ hành nạp âm:</strong> {{ $getThongTinNgay['nap_am']['napAm'] }}
                            </div>
                        </div>
                        <div class="info-item">
                            <img src="{{ asset('icons/icon_hoang_dao.png') }}" alt="icon_hoang_dao"
                                class="icon_hoang_dao">
                            <div>
                                <strong>Giờ Hoàng đạo:</strong> {{ $getThongTinNgay['gio_hac_dao'] }}
                            </div>
                        </div>
                        <!-- BẮT ĐẦU: KHỐI MỨC THUẬN LỢI (ĐÃ CẬP NHẬT) -->
                        <div class="convenience-level d-flex justify-content-between align-items-centerrow h-100">
                            <div class="col-lg-6">
                                <div class="level-label">
                                    Mức thuận lợi<br>hôm nay:
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="progress-dial"
                                    style="--value: {{ round($getDaySummaryInfo['score']['percentage']) }};">
                                    <div class="dial-text">
                                        <span
                                            class="dial-percent">{{ round($getDaySummaryInfo['score']['percentage']) }}%</span>
                                        <small
                                            class="dial-status {{ $ratingColors[$getDaySummaryInfo['score']['rating']] ?? 'text-secondary' }}">
                                            {{ $getDaySummaryInfo['score']['rating'] }}</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- KẾT THÚC: KHỐI MỨC THUẬN LỢI -->
                        <a href="#"
                            class="btn w-100 text-detail-date-hand-pc pt-3 text-start text-decoration-underline"><img
                                src="{{ asset('icons/hand_2.svg') }}" alt="hand_2" class="img-fluid">
                            Xem chi tiết ngày</a>
                    </div>

                    <!-- ** KHỐI SỰ KIỆN SẮP TỚI ** -->
                    <div class="events-card">
                        <h5 class="card-title-right">Sự kiện, ngày lễ sắp tới</h5>
                        <ul class="list-group list-group-flush events-list">
                            <li class="list-group-item event-item">
                                <div class="event-date">Ngày 10/3</div>
                                <div class="event-icon">🗓️</div>
                                <div class="event-details">
                                    <div class="event-name">Giỗ Tổ Hùng Vương</div>
                                    <div class="event-countdown">còn 9 ngày nữa <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item event-item">
                                <div class="event-date"></div>
                                <div class="event-icon">🧧</div>
                                <div class="event-details">
                                    <div class="event-name">Tết Dương Lịch (1/1)</div>
                                    <div class="event-countdown">46 ngày nữa <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item event-item">
                                <div class="event-date"></div>
                                <div class="event-icon">🇻🇳</div>
                                <div class="event-details">
                                    <div class="event-name">Ngày Giải phóng Côn Đảo (4/5)</div>
                                    <div class="event-countdown">2 ngày nữa <i class="bi bi-chevron-right"></i></div>
                                </div>
                            </li>
                            <li class="list-group-item event-item">
                                <div class="event-date"></div>
                                <div class="event-icon">🎉</div>
                                <div class="event-details">
                                    <div class="event-name">Ngày Giải phóng miền Nam, thống nhất đất nước (30/4)</div>
                                    <div class="event-countdown">13 ngày nữa <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>




























    {{-- <div class=" mt-5">
        <div class="row g-5">


            <div class="col-lg-6">
                <h1>Chuyển Đổi Ngày Dương Sang Âm</h1>



                <form method="POST" action="{{ url('/doi-lich') }}" id="convertForm">
                    @csrf
                    <div class="form-group">
                        <label for="duong_date">Chọn Ngày Dương</label>
                        <input type="date" id="duong_date" name="duong_date" class="form-control custom-date-input"
                            value="{{ old('duong_date', $cdate ?? \Carbon\Carbon::now()->format('Y-m-d')) }}">

                        <label for="am_date" class="mt-3">Hoặc chọn Ngày Âm</label>
                        <input type="date" id="am_date" name="am_date" class="form-control custom-date-input"
                            value="{{ old('am_date', $amToday ?? '') }}">
                    </div>

                    <input type="hidden" name="cdate" id="cdate" value="{{ old('duong_date', $cdate) }}">

                    <button type="submit" class="btn btn-primary mt-3">Chuyển đổi</button>
                </form>


                @if (isset($al))
                    <h3 class="mt-5">Kết quả chuyển đổi</h3>
                    <p><strong>Ngày Dương: </strong>{{ $dd }}/{{ $mm }}/{{ $yy }}</p>
                    <p><strong>Ngày Âm: </strong>{{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }} (Tháng
                        {{ $al[3] == 1 ? 'Nhuận' : 'Thường' }})</p>
                    <p><strong>Ngày: </strong>{{ $getThongTinCanChiVaIcon['can_chi_ngay'] }} <strong>Tháng: </strong>
                        {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                        <strong>Năm: </strong> {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                    </p>
                    <p><strong>Ngày trong tuần: </strong>{{ $weekday }}</p>
                    <p>{!! $ngaySuatHanhHTML !!}</p>
                    <p><b>Giờ hoàng đạo</b> {{ $gioHd }}</p>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="calendar-container">

 
                    <div class="header-calendar">

                        <a href="{{ route('lich.thang', ['nam' => $prevYear, 'thang' => $prevMonth]) }}" class="nav-arrow"
                            title="Tháng trước">
                            <i class="bi bi-chevron-left"></i>
                        </a>

                        <span class="header-calendar-title">
                            Tháng {{ $mm }} năm {{ $yy }}
                        </span>

           
                        <a href="{{ route('lich.thang', ['nam' => $nextYear, 'thang' => $nextMonth]) }}" class="nav-arrow"
                            title="Tháng sau">
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    </div>
       

                    <div class="body-calendar">
                        <div class="p-2">
                            <div class="day-calendar">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="#" id="prev-day-btn" class="nav-arrow" title="Ngày hôm trước"><i
                                            class="bi bi-chevron-left"></i></a>
                                    <div class="day-name">
                                        {{ $dd }}
                                    </div>
                                    <a href="#" id="next-day-btn" class="nav-arrow" title="Ngày hôm sau"><i
                                            class="bi bi-chevron-right"></i></a>
                                </div>

                            </div>
                            <div class="weekday-calendar">
                                <div class="weekday-name">{{ $weekday }}</div>

                                @foreach ($suKienHomNay as $suKien)
                                    <div class="text-center">
                                        <div class="su-kien-info">
                                            <strong>{{ $suKien['ten_su_kien'] ?? $suKien }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center am-lich-header">
                                <div class="am-lich-info">
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_nam'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_nam'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span> Năm {{ $getThongTinCanChiVaIcon['can_chi_nam'] }}
                                    </div>
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_thang'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_thang'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span>
                                        Tháng {{ $getThongTinCanChiVaIcon['can_chi_thang'] }}
                                    </div>
                                    <div class="am-lich-item">
                                        <span class="icon">
                                            @if ($getThongTinCanChiVaIcon['icon_ngay'])
                                                <img src="{{ $getThongTinCanChiVaIcon['icon_ngay'] }}" alt="Chi Icon"
                                                    width="40" height="23">
                                            @else
                                                <p>Không tìm thấy icon.</p>
                                            @endif
                                        </span> Ngày {{ $canChi }}
                                    </div>
                                </div>

                                <div class="am-lich-date">
                                    <span class="date-number">{{ $al[0] }}</span>
                                    <div class="date-label">
                                        Âm lịch<br>Tháng {{ $al[1] }} ({{ $al[4] }})
                                    </div>
                                </div>
                            </div>
                            <div class="am-lich-tietkhi">
                                <span>Tiết khí: {!! $tietkhi['icon'] !!} <b
                                        class="text-uppercase">{{ $tietkhi['tiet_khi'] }}</b></span>
                            </div>
                            <div class="pt-3">
                                <div class="gio-lich-info">
                                    <b>Giờ hoàng đạo</b> {{ $gioHd }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-5 g-3 d-flex justify-content-center">
            @php
                function renderStars($rating)
                {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= $i <= $rating ? '★' : '☆';
                    }
                    return $stars;
                }
            @endphp
            @foreach ($getDetailedGioHoangDao as $itemgio)
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $itemgio['name'] }}
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {!! $itemgio['zodiacIcon'] !!}
                                        </h5>
                                        <p class="mb-0 text-center">

                                            {!! $itemgio['canChiMenh'] !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        {!! renderStars($itemgio['rating']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div>
            <div class="col-lg-12">

                <div class="card-body p-0">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd row g-3" role="tablist"
                        style="border: none !important">
                        <li class="nav-item  pa-right w-50" role="presentation">
                            <a class="nav-link btn active  pt-3 pb-3 text-center text-black fw-bold"
                                id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab"
                                aria-controls="pills-home-nobd" aria-selected="true">Tóm tắt </a>
                        </li>
                        <li class="nav-item tba-ks pa-left  w-50" role="presentation">
                            <a class="nav-link  btn pt-3 pb-3 text-center text-black fw-bold" id="pills-profile-tab-nobd"
                                data-bs-toggle="pill" href="#pills-profile-nobd" role="tab"
                                aria-controls="pills-profile-nobd" aria-selected="false">Chi tiết</a>
                        </li>
                    </ul>

                    <div class="tab-content mb-3" id="pills-without-border-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                            aria-labelledby="pills-home-tab-nobd">
                            <p>{{ $getDaySummaryInfo['intro_paragraph'] }}</p>
                         
                            <h5>Đánh giá ngày {{ round($getDaySummaryInfo['score']['percentage']) }} Điểm -
                                {{ $getDaySummaryInfo['score']['rating'] }}</h5>
                        
                            @php
                                $goodFactors = []; 

                              
                                if ($nhiThapBatTu['nature'] == 'Tốt') {
                                    $goodFactors[] =
                                        'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                }

                          
                                if ($getThongTinTruc['description']['rating'] == 'Tốt') {
                                    $goodFactors[] =
                                        'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập nhị trực)';
                                }

                            
                                if (!empty($getSaoTotXauInfo['sao_tot'])) {
                               
                                    $saoTotList = implode(', ', array_keys($getSaoTotXauInfo['sao_tot']));
                                    $goodFactors[] = 'Các sao tốt khác: ' . $saoTotList;
                                }
                            @endphp

                            <p>
                           
                                @if (!empty($goodFactors))
                                
                                    {!! implode('<br>', $goodFactors) !!}
                                @else
                               
                                    Không có yếu tố tốt nào.
                                @endif
                            </p>


                         
                            @php
                                $badFactors = []; 

                              
                                if ($nhiThapBatTu['nature'] == 'Xấu') {
                                    $badFactors[] =
                                        'Sao <strong>' . $nhiThapBatTu['name'] . '</strong> (Nhị thập bát tú)';
                                }

                              
                                if ($getThongTinTruc['description']['rating'] == 'Xấu') {
                                    $badFactors[] =
                                        'Trực <strong>' . $getThongTinTruc['title'] . '</strong> (Thập nhị trực)';
                                }

                              
                                if (!empty($getSaoTotXauInfo['sao_xau'])) {
                                 
                                    $saoXauList = implode(', ', array_keys($getSaoTotXauInfo['sao_xau']));
                                    $badFactors[] = 'Các sao xấu khác: ' . $saoXauList;
                                }
                            @endphp

                            <p>
                                @if (!empty($badFactors))
                                    {!! implode('<br>', $badFactors) !!}
                                @else
                                    Không có yếu tố xấu nào.
                                @endif
                            </p>
                            <div>
                                ♥ Việc nên làm
                                <div>
                                    <ul>
                                        @if (!empty($nhiThapBatTu['guidance']['good']))
                                            <li>{{ $nhiThapBatTu['guidance']['good'] }} (Nhị thập bát tú -
                                                {{ $nhiThapBatTu['name'] }})</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['good']))
                                            <li>
                                                {{ $getThongTinTruc['description']['good'] }} (Thập nhị trực -
                                                {{ $getThongTinTruc['title'] }})
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                ♥ Việc không nên làm
                                <div>
                                    <ul>
                                        @if (!empty($nhiThapBatTu['guidance']['bad']))
                                            <li>{{ $nhiThapBatTu['guidance']['bad'] }} (Nhị thập bát tú - sao
                                                {{ $nhiThapBatTu['name'] }})</li>
                                        @endif
                                        @if (!empty($getThongTinTruc['description']['bad']))
                                            <li>
                                                {{ $getThongTinTruc['description']['bad'] }} (Thập nhị trực -
                                                {{ $getThongTinTruc['title'] }})
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="pills-profile-nobd" role="tabpanel"
                            aria-labelledby="pills-profile-tab-nobd">
                            <div class="border border-top-0 p-2">
                                <h4> Tổng quan ngay {{ $dd }}/{{ $mm }}/{{ $yy }}</h4>
                                <ul>
                                    <li> Ngày dương lịch: {{ $dd }}/{{ $mm }}/{{ $yy }}
                                    </li>
                                    <li> Ngày âm lịch: {{ $al[0] }}/{{ $al[1] }}/{{ $al[2] }}
                                    </li>
                                    <li>Nạp âm ngũ hành: {{ $getThongTinNgay['nap_am']['napAm'] }}</li>
                                    <li>Tuổi xung: {{ $getThongTinNgay['tuoi_xung'] }}</li>
                                    <li>Giờ hoàng đạo: {{ $getThongTinNgay['gio_hoang_dao'] }}</li>
                                    <li>Giờ hắc đạo: {{ $getThongTinNgay['gio_hac_dao'] }}</li>
                                </ul>
                                <h5>Đánh giá ngày {{ round($getDaySummaryInfo['score']['percentage']) }} / 100 Điểm - Ngày
                                    {{ $getDaySummaryInfo['description'] }}
                                </h5>

                                <h3>PHÂN TÍCH NGŨ HÀNH, SAO, TRỰC, LỤC DIỆU</h3>
                                <h4>1. Xem Can Chi - Khí vận & tuổi hợp/Xung trong ngày</h4>
                                <div>
                                    Nội khí ngày (Can Chi ngày): <br>
                                    - {{ $noiKhiNgay }}
                                </div>
                                <h4>2. Nhị thập bát tú</h4>
                                <p>Ngày {{ $al[0] }}-{{ $al[1] }}-{{ $al[2] }} Âm lịch có xuất
                                    hiện sao: <b>{{ $nhiThapBatTu['name'] }}({{ $nhiThapBatTu['fullName'] }})</b></p>
                                <p>Đây là sao <b>{{ $nhiThapBatTu['nature'] }} </b>-
                                    {{ $nhiThapBatTu['description'] }}</p>
                                <li>
                                    Việc nên làm : {{ $nhiThapBatTu['guidance']['good'] }}
                                    @if ($nhiThapBatTu['guidance']['bad'])
                                        Việc không nên làm : {{ $nhiThapBatTu['guidance']['bad'] }}
                                    @endif
                                </li>
                                <h4>3. Thập nhị trực (12 trực)</h4>
                                <p><b>Trực ngày: </b>Trực <b>{{ $getThongTinTruc['title'] }}</b></p>
                                <p>- Đây là trực {{ $getThongTinTruc['description']['rating'] }} -
                                    {{ $getThongTinTruc['description']['description'] }}</p>
                                <ul>
                                    <li>Việc nên làm: {{ $getThongTinTruc['description']['good'] }}</li>
                                    <li>Việc không nên làm: {{ $getThongTinTruc['description']['bad'] }}</li>
                                </ul>
                                <h4>4. Các sao tốt - xấu theo Ngọc Hạp Thông Thư</h4>
                                <div>
                                    <h6>- Sao tốt</h6>
                                   
                                    @if (!empty($getSaoTotXauInfo['sao_tot']))
                                        @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                            <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                        @endforeach
                                    @else
                                        Không có sao tốt trong ngày này
                                    @endif

                                    </ul>
                                    <h6>- Sao xấu</h6>
                                    <ul>
                                        @if (!empty($getSaoTotXauInfo['sao_xau']))
                                            @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                                <li><strong>{{ $tenSao }}:</strong> {{ $yNghia }}</li>
                                            @endforeach
                                        @else
                                            Không có sao xấu trong ngày này
                                        @endif

                                    </ul>
                                    <p>{{ $getSaoTotXauInfo['ket_luan'] }}</p>
                                </div>
                                <h4>5. Ngày theo Khổng minh lục diệu</h4>
                                <div>
                                    <p>Ngày này là ngày <b>{{ $khongMinhLucDieu['name'] }}</b>
                                        ({{ $khongMinhLucDieu['rating'] }})</p>
                                    <p>-> {{ $khongMinhLucDieu['description'] }}</p>
                                    <p>{!! $khongMinhLucDieu['poem'] !!}</p>
                                </div>
                                <h3>BÁCH KỴ VÀ CẢNH BÁO ĐẠI KỴ</h3>
                                <div>
                                    <h4>1.Giải thích ý nghĩa theo ngày Bành Tổ Bách Kỵ</h4>
                                    Ngày <b>{{ $canChi }}</b>
                                    <ul>
                                        <li><b>{{ $chiNgay[0] }}</b> {{ $banhToCan }}</li>
                                        <li><b>{{ $chiNgay[1] }}</b> {{ $banhToChi }}</li>
                                    </ul>
                                </div>

                                <h3>NGÀY, GIỜ HƯỚNG XUẤT HÀNH</h3>
                                <div>
                                    <h4>1. Ngày xuất hành</h4>
                                    Đây là ngày <b>{{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['title'] }}
                                        ({{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['rating'] }})</b>:
                                    {{ $getThongTinXuatHanhVaLyThuanPhong['xuat_hanh_info']['description'] }}
                                    <h4>2. Hướng xuất hành</h4>
                                    <h5>Hướng xuất hành tốt:</h5>
                                    <p> ĐÓn Hỷ thần:
                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hyThan']['direction'] }}
                                    </p>
                                    <p> ĐÓn Tài thần:
                                        {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['taiThan']['direction'] }}
                                    </p>
                                    @if ($getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] != 'Hạc Thần bận việc trên trời')
                                        <p> Hắc thần:
                                            {{ $getThongTinXuatHanhVaLyThuanPhong['huong_xuat_hanh']['hacThan']['direction'] }}
                                        </p>
                                    @endif
                                    <h4>3.Giờ xuất hành Lý Thuần Phong</h4>
                                    <h5>Giờ tốt:</h5>
                                    @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['good'] as $name => $items)
                                        @foreach ($items as $item)
                                            <p> - {{ $item['name'] }} ({{ $item['rating'] }}):
                                                {{ $item['timeRange'][0] }} ({{ $item['chi'][0] }}) và
                                                {{ $item['timeRange'][1] }} ({{ $item['chi'][1] }}) ->
                                                {{ $item['description'] }}
                                            </p>
                                        @endforeach
                                    @endforeach
                                    <h5>Giờ Xấu:</h5>
                                    @foreach ($getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong']['bad'] as $name => $items)
                                        @foreach ($items as $item)
                                            <p> - {{ $item['name'] }} ({{ $item['rating'] }}):
                                                {{ $item['timeRange'][0] }} ({{ $item['chi'][0] }}) và
                                                {{ $item['timeRange'][1] }} ({{ $item['chi'][1] }}) ->
                                                {{ $item['description'] }}
                                            </p>
                                        @endforeach
                                    @endforeach
                                    {{ $getThongTinXuatHanhVaLyThuanPhong['ly_thuan_phong_description'] }}


                                </div>
                                <h5>KẾT LUẬN CHUNG</h5>
                                <p>{{ $getDaySummaryInfo['intro_paragraph'] }}</p>
                                ☼ Các yếu tố tốt xuất hiện trong ngày
                                <p>
                                    @if ($nhiThapBatTu['nature'] == 'Tốt')
                                        Sao {{ $nhiThapBatTu['name'] }} (Nhị thập bát tú),
                                    @endif
                                    @if ($getThongTinTruc['description']['rating'] == 'Tốt')
                                        Trực {{ $getThongTinTruc['title'] }} (Thập nhị trực),
                                    @endif
                                    @foreach ($getSaoTotXauInfo['sao_tot'] as $tenSao => $yNghia)
                                        @if ($getSaoTotXauInfo['sao_tot'])
                                            Sao: {{ $loop->first ? '' : ', ' }}{{ $tenSao }}
                                        @endif
                                    @endforeach
                                </p>
                                ☼ Các yếu tố xấu xuất hiện trong ngày
                                <p>
                                    @if ($nhiThapBatTu['nature'] == 'Xấu')
                                        Sao {{ $nhiThapBatTu['name'] }} (Nhị thập bát tú),
                                    @endif

                                    @if ($getThongTinTruc['description']['rating'] == 'Xấu')
                                        Trực {{ $getThongTinTruc['title'] }} (Thập nhị trực),
                                    @endif
                                    Sao: @foreach ($getSaoTotXauInfo['sao_xau'] as $tenSao => $yNghia)
                                        {{ $loop->first ? '' : ', ' }}{{ $tenSao }}
                                    @endforeach
                                </p>
                                <div>
                                    ♥ Việc nên làm
                                    <div>
                                        <ul>
                                            @if (!empty($nhiThapBatTu['guidance']['good']))
                                                <li>{{ $nhiThapBatTu['guidance']['good'] }} (Nhị thập bát tú -
                                                    {{ $nhiThapBatTu['name'] }})</li>
                                            @endif
                                            @if (!empty($getThongTinTruc['description']['good']))
                                                <li>
                                                    {{ $getThongTinTruc['description']['good'] }} (Thập nhị trực -
                                                    {{ $getThongTinTruc['title'] }})
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    ♥ Việc không nên làm
                                    <div>
                                        <ul>
                                            @if (!empty($nhiThapBatTu['guidance']['bad']))
                                                <li>{{ $nhiThapBatTu['guidance']['bad'] }} (Nhị thập bát tú - sao
                                                    {{ $nhiThapBatTu['name'] }})</li>
                                            @endif
                                            @if (!empty($getThongTinTruc['description']['bad']))
                                                <li>
                                                    {{ $getThongTinTruc['description']['bad'] }} (Thập nhị trực -
                                                    {{ $getThongTinTruc['title'] }})
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="calendar-table">
            <thead>
                <tr>
                    <th><span class="title-lich-pc">Thứ hai</span> <span class="title-lich-mobie">Th 2</span></th>
                    <th><span class="title-lich-pc">Thứ ba</span> <span class="title-lich-mobie">Th 3</span></th>
                    <th><span class="title-lich-pc">Thứ tư</span> <span class="title-lich-mobie">Th 4</span></th>
                    <th><span class="title-lich-pc">Thứ năm</span> <span class="title-lich-mobie">Th 5</span></th>
                    <th><span class="title-lich-pc">Thứ sau</span> <span class="title-lich-mobie">Th 6</span></th>
                    <th><span class="title-lich-pc">Thứ bảy</span> <span class="title-lich-mobie">Th 7</span></th>
                    <th><span class="title-lich-pc">Chủ nhật</span> <span class="title-lich-mobie">CN</span></th>

                </tr>
            </thead>
            <tbody>
                {!! $table_html !!}
            </tbody>
        </table>

    </div> --}}
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Lấy ngày tháng năm hiện tại từ Blade
                const currentYear = {{ $yy }};
                const currentMonth = {{ $mm }}; // Tháng từ PHP (1-12)
                const currentDay = {{ $dd }};

                // Tạo đối tượng Date trong JavaScript
                // Lưu ý: Tháng trong JS là 0-11, nên phải trừ đi 1
                const currentDate = new Date(currentYear, currentMonth - 1, currentDay);

                // Lấy TẤT CẢ các element nút bấm
                const prevBtns = document.querySelectorAll('.prev-day-btn'); // <-- SỬA Ở ĐÂY
                const nextBtns = document.querySelectorAll('.next-day-btn'); // <-- SỬA Ở ĐÂY

                // --- Xử lý các nút "Ngày trước" ---
                // Chỉ thực hiện nếu tìm thấy bất kỳ nút nào
                if (prevBtns.length > 0) { // <-- SỬA Ở ĐÂY
                    const prevDate = new Date(currentDate);
                    prevDate.setDate(currentDate.getDate() - 1);

                    const prevYear = prevDate.getFullYear();
                    const prevMonth = prevDate.getMonth() + 1;
                    const prevDay = prevDate.getDate();

                    const newPrevUrl = `/am-lich/nam/${prevYear}/thang/${prevMonth}/ngay/${prevDay}`;

                    // Lặp qua TẤT CẢ các nút "prev" và gán URL mới
                    prevBtns.forEach(btn => { // <-- SỬA Ở ĐÂY
                        btn.href = newPrevUrl;
                    });
                }

                // --- Xử lý các nút "Ngày sau" ---
                // Chỉ thực hiện nếu tìm thấy bất kỳ nút nào
                if (nextBtns.length > 0) { // <-- SỬA Ở ĐÂY
                    const nextDate = new Date(currentDate);
                    nextDate.setDate(currentDate.getDate() + 1);

                    const nextYear = nextDate.getFullYear();
                    const nextMonth = nextDate.getMonth() + 1;
                    const nextDay = nextDate.getDate();

                    const newNextUrl = `/am-lich/nam/${nextYear}/thang/${nextMonth}/ngay/${nextDay}`;

                    // Lặp qua TẤT CẢ các nút "next" và gán URL mới
                    nextBtns.forEach(btn => { // <-- SỬA Ở ĐÂY
                        btn.href = newNextUrl;
                    });
                }
            });
        </script>
    @endpush
@endsection
