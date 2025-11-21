<div class="w-100">
    @if (isset($resultsByYear) && count($resultsByYear) > 0)
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
                            class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28"
                                height="28" class="me-1"> Thông Tin Người Xem
                        </div>
                        @if (isset($birthdateInfo))
                            <div class="info-grid">
                                <p class="mb-2">
                                    <strong>Ngày sinh:</strong>
                                    {{ $birthdateInfo['solar_date'] }} tức ngày
                                    {{ $birthdateInfo['lunar_date'] }} âm lịch
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi:</strong>
                                    {{ $birthdateInfo['can_chi'] }}, Mệnh:
                                    {{ $birthdateInfo['hanh'] }}
                                    ({{ $birthdateInfo['menh'] }})
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi âm:</strong>
                                    {{ $year - explode('/', $birthdateInfo['solar_date'])[2] + 1 }} tuổi
                                </p>

                                <p class="mb-2">
                                    <strong>Dự kiến xuất hành:</strong>
                                    {{ $inputs['date_range'] ?? '' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        <div class="betwen-ds flex-wrap">
                            <div
                                class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người xem" width="28"
                                    height="28" class="me-1"> Danh Sách Điểm Theo Ngày
                            </div>
                            <div class="d-flex" style="gap: 10px">
                                <div class="position-relative mb-3">
                                    <button type="button" id="tabooFilterBtn"
                                        class="form-select-sm sort-select" onclick="return false;">
                                        <i class="bi bi-funnel me-2"></i>
                                        <span>Lọc ngày xấu</span>
                                        <i class="bi bi-chevron-down ms-2"></i>
                                    </button>

                                    <!-- Filter Modal/Dropdown -->
                                    <div id="tabooFilterModal" class="taboo-filter-modal d-none">
                                        <div class="taboo-filter-header">
                                            <h6 class="mb-0">Lọc ngày xấu</h6>
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
                                                <button type="button" id="clearAll" class="btn-quick-action">Bỏ chọn</button>
                                            </div>

                                                <div class="filter-options">
                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox" value="Tam Nương"
                                                            id="taboo1">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Tam Nương</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Kỵ"
                                                            id="taboo2">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Nguyệt Kỵ</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Tận"
                                                            id="taboo3">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Nguyệt Tận</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox"
                                                            value="Dương Công Kỵ Nhật" id="taboo4">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Dương Công Kỵ Nhật</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox" value="Sát Chủ Âm"
                                                            id="taboo5">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Sát Chủ Âm</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox"
                                                            value="Sát Chủ Dương" id="taboo6">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Sát Chủ Dương</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox"
                                                            value="Kim Thần Thất Sát" id="taboo7">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Kim Thần Thất Sát</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox"
                                                            value="Trùng Phục" id="taboo8">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Trùng Phục</span>
                                                    </label>

                                                    <label class="filter-option">
                                                        <input type="checkbox" class="taboo-checkbox" value="Thụ Tử"
                                                            id="taboo9">
                                                        <span class="checkmark"></span>
                                                        <span class="option-text">Thụ Tử</span>
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
                                <div>
                                    <select name="sort" class="form-select-sm sort-select" style="width: auto; height: 40px;"
                                        form="xuatHanhForm">
                                        <option value="desc" selected>Điểm giảm dần</option>
                                        <option value="asc">Điểm tăng dần</option>
                                        <option value="date_asc">Ngày tăng dần</option>
                                        <option value="date_desc">Ngày giảm dần</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                     
                        <div id="filterStatus" class="alert alert-success d-none mb-3" role="alert">
                            <i class="bi bi-funnel"></i>
                            <span id="filterStatusText"></span>
                        </div>

                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout" id="table-{{ $year }}"
                                    style=" width: 100%;">
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
                                                        $score =
                                                            $day['day_score']['score']['percentage'] ??
                                                            ($day['day_score']['percentage'] ?? 0);
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
                                            <tr class="table-row-{{ $year }}"
                                                data-index="{{ $index }}"
                                                style="{{ $index >= 10 ? 'display: none;' : '' }}"
                                                data-visible="{{ $index < 10 ? 'true' : 'false' }}"
                                                data-taboo-days="{{ implode(',', $day['day_score']['taboo_details']['taboo_types'] ?? []) }}">
                                                <td style="text-align: start">
                                                    <a
                                                        href="{{ route('xuat-hanh.details', ['date' => $day['date']->format('Y-m-d'), 'birthdate' => $formattedBirthdate, 'date_range' => $inputs['date_range'] ?? '', 'calendar_type' => $inputs['calendar_type'] ?? 'solar']) }}">
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

                                                        // Kiểm tra ngày hoàng đạo - sử dụng helper
                                                        if (
                                                            isset($day['day_score']['score']['hoangdao']) &&
                                                            $day['day_score']['score']['hoangdao'] === true
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
                                                            isset($day['day_score']['score']['tructot']) &&
                                                            $day['day_score']['score']['tructot'] === true
                                                        ) {
                                                            $trucName =
                                                                $day['day_score']['score']['truc']['details']['name'] ??
                                                                'Không xác định';
                                                            $supportFactors[] = "Trực tốt: Trực {$trucName}";
                                                        }

                                                        // Kiểm tra hợp tuổi - sử dụng helper
                                                        if (
                                                            isset($day['day_score']['score']['hopttuoi']) &&
                                                            $day['day_score']['score']['hopttuoi'] === true
                                                        ) {
                                                            $hopType = \App\Helpers\GoodBadDayHelper::getHopTuoiDetail(
                                                                $day['date'],
                                                                $birthdateInfo['dob']->year,
                                                            );
                                                            if ($hopType) {
                                                                $supportFactors[] = "Ngày hợp tuổi: {$hopType}";
                                                            }
                                                        }

                                                        // Kiểm tra sao tốt - gộp thành 1 dòng
                                                        $goodStars = $day['day_score']['score']['good_stars'] ?? [];
                                                        if (!empty($goodStars) && is_array($goodStars)) {
                                                            $starNames = implode(', ', $goodStars);
                                                            $supportFactors[] = "Sao tốt: {$starNames}";
                                                        }

                                                        // Chỉ lấy tối đa 4 yếu tố
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
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Không có yếu
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

                                <!-- Nút xem thêm -->
                                @if(count($yearData['days']) > 10)
                                    <div class="text-center mt-3">
                                        <button type="button"
                                                class="btn btn-outline-primary load-more-btn"
                                                data-year="{{ $year }}"
                                                data-loaded="10"
                                                data-total="{{ count($yearData['days']) }}">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Xem thêm 10 bảng
                                            <span class="text-muted ms-2">({{ count($yearData['days']) - 10 }} còn lại)</span>
                                        </button>
                                    </div>
                                @endif
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

<script>
    // Đưa dữ liệu PHP ra JavaScript cho taboo filter
    @if (isset($resultsByYear))
        window.resultsByYear = @json($resultsByYear);
    @endif
</script>

{{-- Include hybrid taboo filter script --}}
@include('components.taboo-filter-script')

<script>
    // Khởi tạo taboo filter cho xuất hành
    document.addEventListener('DOMContentLoaded', function() {
        if (window.resultsByYear && typeof initTabooFilter === 'function') {
            initTabooFilter(window.resultsByYear);
        }
    });
</script>
