<div class="w-100" id="content-box-succes">
    <!-- Tabs cho các năm -->
    @if (isset($resultsByYear) && count($resultsByYear) > 0)
        <div class="box-tab-white mb-3">
          <div class="year-tabs ">
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
        </div>

    @endif

    <!-- Tab content -->
    <div class="tab-content">
        @php $firstYear = true; @endphp
        @foreach ($resultsByYear as $year => $yearData)
            <div class="tab-pane fade {{ $firstYear ? 'show active' : '' }}" id="year-{{ $year }}">

                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người ký hợp đồng" width="28"
                                height="28" class="me-1"> Thông Tin Người Ký Hợp Đồng
                        </div>
                        @if (isset($birthdateInfo))
                            <div class="info-grid">
                                @if(isset($personName))
                                <p class="mb-2">
                                    <strong>Họ tên:</strong>
                                    {{ $personName }}
                                </p>
                                @endif
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
                                    <strong>Tuổi âm:</strong>
                                    {{ $yearData['year_analysis']['lunar_age'] }} tuổi
                                </p>

                                <p class="mb-2">
                                    <strong>Thời gian ký hợp đồng:</strong>
                                    {{ $inputs['date_range'] ?? '' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Danh sách điểm theo ngày -->
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <!-- Filter and Sort Controls - trực tiếp trên table -->
                            <div class="betwen-ds flex-wrap mb-3">
                                <div class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                    <img src="{{ asset('icons/k_nen_1.svg') }}" alt="thông tin người ký hợp đồng"
                                        width="28" height="28" class="me-1"> Danh Sách Điểm Theo Ngày Ký Hợp Đồng
                                </div>
                                <div class="d-flex flex-wrap" style="gap: 10px">
                                    <div class="position-relative mb-3">
                                        <button type="button" class="taboo-filter-btn form-select-sm sort-select"
                                            data-year="{{ $year }}">
                                            <span>Lọc ngày xấu</span>
                                            <i class="bi bi-chevron-down ms-2"></i>
                                        </button>
                                    </div>

                                    <!-- Sắp xếp tích hợp điểm và ngày -->
                                    <div>
                                        <select name="sort" class="form-select-sm sort-select"
                                            style="width: auto; height: 40px;">
                                            <option value="desc" selected>Điểm giảm dần</option>
                                            <option value="asc">Điểm tăng dần</option>
                                            <option value="date_asc">Ngày tăng dần</option>
                                            <option value="date_desc">Ngày giảm dần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Status for this tab -->
                            <div id="filterStatus-{{ $year }}" class="alert alert-success d-none mb-3"
                                role="alert">
                                <i class="bi bi-funnel"></i>
                                <span id="filterStatusText-{{ $year }}"></span>
                            </div>
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout"
                                    id="table-{{ $year }}" style=" width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Yếu tố hỗ trợ ký hợp đồng</th>
                                            <th style="border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                            {{-- <th style="min-width: 120px;border-radius: 0 8px 8px 0">Chi tiết</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="text-center table-body-{{ $year }}">
                                        @foreach ($yearData['days'] as $index => $day)
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
                                                } elseif ($score < 70) {
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
                                                        href="{{ route('ky-hop-dong.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'birthdate' => $birthdateInfo['dob']->format('Y-m-d'),
                                                            'date_range' => $inputs['date_range'] ?? '',
                                                            'calendar_type' => $inputs['calendar_type'] ?? 'solar',
                                                            'name' => $personName ?? ''
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

                                                        // Kiểm tra ngày hoàng đạo - sử dụng helper
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

                                                        // Kiểm tra hợp tuổi - sử dụng helper
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

                                                        // Kiểm tra sao tốt - gộp thành 1 dòng
                                                        if (
                                                            isset($day['day_score']['good_stars']) &&
                                                            !empty($day['day_score']['good_stars'])
                                                        ) {
                                                            $starNames = implode(', ', $day['day_score']['good_stars']);
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
                                                            tố hỗ trợ đặc biệt
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
                                          
                                            Xem thêm 
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted text-center py-4">
                                Không có ngày nào trong khoảng thời gian đã chọn phù hợp để ký hợp đồng.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @php $firstYear = false; @endphp
        @endforeach
    </div>
</div>

   <!-- Filter Modal/Dropdown - Global -->
    <div id="tabooFilterModal" class="taboo-filter-modal d-none">
        <div class="taboo-filter-header">
            <h6 class="mb-0">Lọc ngày kỵ</h6>
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
                   
                </div>

                <div class="filter-options">
                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Tam Nương" id="taboo1">
                        <span class="checkmark"></span>
                        <span class="option-text">Tam Nương</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Kỵ" id="taboo2">
                        <span class="checkmark"></span>
                        <span class="option-text">Nguyệt Kỵ</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Nguyệt Tận" id="taboo3">
                        <span class="checkmark"></span>
                        <span class="option-text">Nguyệt Tận</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Dương Công Kỵ Nhật" id="taboo4">
                        <span class="checkmark"></span>
                        <span class="option-text">Dương Công Kỵ Nhật</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Sát Chủ Âm" id="taboo5">
                        <span class="checkmark"></span>
                        <span class="option-text">Sát Chủ Âm</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Sát Chủ Dương" id="taboo6">
                        <span class="checkmark"></span>
                        <span class="option-text">Sát Chủ Dương</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Kim Thần Thất Sát" id="taboo7">
                        <span class="checkmark"></span>
                        <span class="option-text">Kim Thần Thất Sát</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Trùng Phục" id="taboo8">
                        <span class="checkmark"></span>
                        <span class="option-text">Trùng Phục</span>
                    </label>

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Thụ Tử" id="taboo9">
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

@include('components.taboo-filter-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo taboo filter với dữ liệu từ backend
        const resultsByYear = @json($resultsByYear ?? []);

        // Khởi tạo filter sau khi DOM loaded
        setTimeout(() => {
            if (typeof initTabooFilter === 'function') {
                initTabooFilter(resultsByYear);
            }
        }, 300);

        // Không cần cập nhật links vì filter đã được lưu trong localStorage
    });
</script>