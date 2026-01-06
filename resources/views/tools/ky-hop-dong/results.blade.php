<div class="w-100" id="content-box-succes">
    @php
        // Combine all days from all years into one array
        $allDays = [];
        foreach ($resultsByYear as $year => $yearData) {
            if (isset($yearData['days']) && count($yearData['days']) > 0) {
                foreach ($yearData['days'] as $day) {
                    $allDays[] = $day;
                }
            }
        }

        // Sort all days by score (descending by default)
        usort($allDays, function ($a, $b) {
            $scoreA = $a['day_score']['percentage'] ?? 0;
            $scoreB = $b['day_score']['percentage'] ?? 0;
            return $scoreB <=> $scoreA; // Điểm cao xuống thấp
        });
    @endphp

    @if (isset($resultsByYear) && count($resultsByYear) > 0)


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
                                    <strong>Ngày sinh dương lịch:</strong>
                                    {{ $birthdateInfo['dob']->format('d/m/Y') }}
                                </p>
                                 <p class="mb-2">
                                    <strong>Ngày sinh âm lịch:</strong>
                                  
                                    {{ $birthdateInfo['lunar_dob_str'] }}
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi:</strong>
                                    <b>{{ $birthdateInfo['can_chi_nam'] }}</b>
                                </p>
                                 <p class="mb-2">
                                    <strong>Mệnh:</strong>
                                   
                                    {{ $birthdateInfo['menh']['hanh'] }}
                                    ({{ $birthdateInfo['menh']['napAm'] }})
                                </p>
                                <p class="mb-2">
                                    <strong>Tuổi âm:</strong>
                                    @php
                                        $currentYear = date('Y');
                                        $lunarAge = $currentYear - $birthdateInfo['dob']->year + 1;
                                    @endphp
                                    {{ $lunarAge }} tuổi
                                </p>

                                <p class="mb-2">
                                    <strong>Thời gian ký hợp đồng:</strong>
                                    {{ $inputs['date_range'] ?? '' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Gợi ý ngày tốt cho bạn -->
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        @if (count($allDays) > 0)
                            <!-- Filter and Sort Controls -->
                            <div class="betwen-ds flex-wrap mb-3">
                                <div class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                    <img src="{{ asset('icons/k_nen_1.svg') }}" alt="gợi ý ngày ký hợp đồng"
                                        width="28" height="28" class="me-1"> Gợi ý ngày tốt cho bạn
                                </div>
                                <div class="d-flex flex-wrap" style="gap: 10px">
                                    <div class="position-relative mb-3">
                                        <button type="button" class="taboo-filter-btn form-select-sm sort-select"
                                            data-year="all">
                                            <span>Lọc ngày xấu</span>
                                            <i class="bi bi-chevron-down ms-2"></i>
                                        </button>
                                    </div>

                                    <!-- Sắp xếp tích hợp điểm và ngày -->
                                    <div>
                                        <select name="sort" class="form-select-sm sort-select"
                                            style="width: auto; height: 40px;">
                                            <option value="desc" selected>Điểm giảm dần</option>
                                            <option value="date_asc">Ngày tăng dần</option>
                                            <option value="date_desc">Ngày giảm dần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Status -->
                            <div id="filterStatus" class="alert alert-success d-none mb-3" role="alert">
                                <i class="bi bi-funnel"></i>
                                <span id="filterStatusText"></span>
                            </div>
                            <div class="table-responsive w-100" id="bang-chi-tiet">
                                <table class="table table-hover align-middle w-100 table-layout"
                                    id="table-all" style=" width: 100%;">
                                    <thead class="text-center" style="background-color: #e8ebee;">
                                        <tr>
                                            <th style="border-radius: 8px 0 0 8px">Ngày</th>
                                            <th style="">Yếu tố hỗ trợ ký hợp đồng</th>
                                            <th style=" border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center table-body-all">
                                        @foreach ($allDays as $index => $day)
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
                                                // Lấy taboo days từ issues - tương thích với các tool khác
                                                $tabooTypes = [];

                                                // Kiểm tra cấu trúc issues trong day_score
                                                if (
                                                    isset($day['day_score']['issues']) &&
                                                    is_array($day['day_score']['issues'])
                                                ) {
                                                    foreach ($day['day_score']['issues'] as $issue) {
                                                        if (
                                                            isset($issue['source']) &&
                                                            $issue['source'] === 'Taboo' &&
                                                            isset($issue['details']['tabooName'])
                                                        ) {
                                                            $tabooTypes[] = $issue['details']['tabooName'];
                                                        }
                                                    }
                                                }

                                                // Check for checkTabooDays structure (fallback)
                                                if (
                                                    empty($tabooTypes) &&
                                                    isset($day['day_score']['checkTabooDays']['issues']) &&
                                                    is_array($day['day_score']['checkTabooDays']['issues'])
                                                ) {
                                                    foreach ($day['day_score']['checkTabooDays']['issues'] as $issue) {
                                                        if (isset($issue['details']['tabooName'])) {
                                                            $tabooTypes[] = $issue['details']['tabooName'];
                                                        }
                                                    }
                                                }

                                                // Check for taboo_details.taboo_types as fallback
                                                if (
                                                    empty($tabooTypes) &&
                                                    isset($day['day_score']['taboo_details']['taboo_types']) &&
                                                    is_array($day['day_score']['taboo_details']['taboo_types'])
                                                ) {
                                                    $tabooTypes = $day['day_score']['taboo_details']['taboo_types'];
                                                }

                                                // Remove duplicates
                                                $tabooTypes = array_unique($tabooTypes);
                                            @endphp
                                            <tr class="table-row-all {{ $index >= 10 ? 'pagination-hidden' : '' }}" data-index="{{ $index }}"
                                                data-visible="{{ $index < 10 ? 'true' : 'false' }}"
                                                data-taboo-days="{{ implode(',', $tabooTypes) }}">
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
                                                                <div class="hv-memorial-lunar-calendar-info d-flex">
                                                                    <span>
                                                                        {{ $day['al_name'][0] ?? '' }}/{{ $day['al_name'][1] ?? '' }}
                                                                    ÂL</span> <i class="bi bi-chevron-right"></i></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td style="text-align: start">
                                                    @php
                                                        $supportFactors = [];
 if (
                                                            $day['day_score']['tu']['details']['data']['nature'] ==
                                                            'Tốt'
                                                        ) {
                                                            $nameBatTu =
                                                                $day['day_score']['tu']['details']['data']['name'];
                                                            $supportFactors[] = "Thập nhị bát tú: Sao {$nameBatTu}";
                                                        }
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
 if (
                                                    $day['day_score']['hopttuoi'] === true &&
                                                    $day['day_score']['hopTuoiReason'] != 'Trùng (Đồng Chi)'
                                                ) {
                                                    $supportFactors[] =
                                                        'Ngày hợp tuổi: ' . $day['day_score']['hopTuoiReason'];
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
                                                           $badTypes = ['Lục xung', 'Tương hại', 'Tương phá' , 'Tự hình'];

                                                            if (
                                                                $hopType &&
                                                                $hopType !== 'Trung bình (không xung, không hợp)' &&
                                                                !in_array($hopType, $badTypes)
                                                            ) {
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
                                @if(count($allDays) > 10)
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-outline-primary load-more-btn" data-year="all"
                                            data-loaded="10" data-total="{{ count($allDays) }}">
                                            Xem thêm
                                        </button>
                                    </div>
                                @endif

                        <div class="card-body box1-con-year pe-1 ps-1">
                            <div class="text-primary mb-2  text-dark d-flex align-items-center p-3"
                                style="border: 1px solid rgb(173, 173, 173);border-radius: 10px">
                                ⚠️ Chú ý: Đây là các thông tin xem mang tính chất tham khảo, không thay thế cho các
                                tư vấn
                                chuyên môn. Người dùng tự chịu trách nhiệm với mọi quyết định cá nhân dựa trên thông
                                tin
                                tham khảo tại Phong Lịch.
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted text-center py-4">
                        Không có ngày nào trong khoảng thời gian đã chọn.
                    </p>
                @endif
            </div>
        </div>
    @endif

    <!-- Filter Modal/Dropdown - Global -->
    <div id="tabooFilterModal" class="taboo-filter-modal d-none">
        <div class="taboo-filter-header">
            <h6 class="mb-0">
                <i class="bi bi-heart" style="color: #e91e63;"></i>
                Lọc ngày xấu
            </h6>
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

                    <label class="filter-option">
                        <input type="checkbox" class="taboo-checkbox" value="Lục xung" id="taboo10">
                        <span class="checkmark"></span>
                        <span class="option-text">Lục Xung</span>
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

<style>
.pagination-hidden {
    display: none;
}

/* Khi filter active, hiển thị tất cả rows để filter có thể truy cập */
.filter-active .pagination-hidden {
    display: table-row !important;
}

/* Class để ẩn rows bị filter */
.filtered-out {
    display: none !important;
}
</style>

@include('components.taboo-filter-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Expose user's 'chi' to global scope
        window.userChi = '{{ explode(' ', ($birthdateInfo['can_chi_nam'] ?? ''))[1] ?? '' }}';

        // Khởi tạo taboo filter với dữ liệu từ backend - combine all days
        const resultsByYear = {
            'all': {
                days: @json($allDays ?? [])
            }
        };

        // Đảm bảo tất cả rows đều có trong DOM để taboo filter có thể truy cập
        setTimeout(() => {
            if (typeof window.initTabooFilter === 'function') {

                const filterButton = document.querySelector('.taboo-filter-btn');
                const modal = document.getElementById('tabooFilterModal');
                const allTbodies = document.querySelectorAll('tbody');

                allTbodies.forEach((tbody, index) => {
                    const rowsWithTaboo = tbody.querySelectorAll('tr[data-taboo-days]');
                    const totalRows = tbody.querySelectorAll('tr');
                });

                // Override updateTable function để đảm bảo filter hoạt động với tất cả rows
                const originalInitTabooFilter = window.initTabooFilter;
                window.initTabooFilter = function(resultsByYear) {
                    // Gọi hàm gốc
                    originalInitTabooFilter(resultsByYear);

                    // Override applyTabooFilter để đảm bảo filter hoạt động đúng
                    setTimeout(() => {
                        const applyBtn = document.getElementById('applyTabooFilter');
                        if (applyBtn && applyBtn._tabooHandler) {
                            const originalHandler = applyBtn._tabooHandler;
                            applyBtn._tabooHandler = function() {
                                const selectedTaboos = Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value);
                                window.currentSelectedTaboos = selectedTaboos;

                                if (selectedTaboos.length > 0) {
                                    // Add filter-active class để CSS có thể hoạt động - QUAN TRỌNG!
                                    const table = document.querySelector('.table');
                                    if (table) {
                                        table.classList.add('filter-active');
                                    }

                                    // Lấy tất cả rows bao gồm hidden ones
                                    const tbody = document.querySelector('.table-body-all');
                                    if (tbody) {
                                        const allRows = tbody.querySelectorAll('tr[data-taboo-days]');

                                        // BƯỚC 1: Xóa tất cả classes cũ và reset
                                        allRows.forEach(row => {
                                            row.classList.remove('filtered-out', 'pagination-hidden');
                                            row.style.removeProperty('display');
                                        });

                                        // BƯỚC 2: Apply filter trên TẤT CẢ rows
                                        let unfilteredRows = [];
                                        allRows.forEach((row, index) => {
                                            const tabooData = row.getAttribute('data-taboo-days');
                                            let shouldHide = false;

                                            if (tabooData && tabooData.trim()) {
                                                const rowTaboos = tabooData.split(',').map(t => t.trim()).filter(t => t);
                                                shouldHide = selectedTaboos.some(selectedTaboo => rowTaboos.includes(selectedTaboo));

                                            }

                                            if (shouldHide) {
                                                row.classList.add('filtered-out');
                                            } else {
                                                unfilteredRows.push(row);
                                            }
                                        });

                                        // BƯỚC 3: Apply pagination CHỈ trên các rows không bị filter

                                        unfilteredRows.forEach((row, unfilteredIndex) => {
                                            if (unfilteredIndex >= 10) {
                                                row.classList.add('pagination-hidden');
                                            }
                                        });

                                        // BƯỚC 4: Update pagination button
                                        const loadMoreBtn = document.querySelector('.load-more-btn');
                                        if (loadMoreBtn) {
                                            const visibleUnfilteredCount = Math.min(unfilteredRows.length, 10);
                                            const totalUnfilteredCount = unfilteredRows.length;

                                            loadMoreBtn.dataset.loaded = visibleUnfilteredCount;
                                            loadMoreBtn.dataset.total = totalUnfilteredCount;

                                            if (totalUnfilteredCount > 10) {
                                                loadMoreBtn.style.display = '';
                                                loadMoreBtn.innerHTML = 'Xem thêm';
                                            } else {
                                                loadMoreBtn.style.display = 'none';
                                            }

                                        }
                                    }
                                }

                                // Show filter status
                                const filterStatus = document.getElementById('filterStatus');
                                const filterStatusText = document.getElementById('filterStatusText');
                                if (filterStatus && filterStatusText && selectedTaboos.length > 0) {
                                    filterStatus.classList.remove('d-none');
                                    filterStatusText.textContent = `Đã lọc ${selectedTaboos.join(', ')}.`;
                                }

                                // Close modal
                                const modal = document.getElementById('tabooFilterModal');
                                const backdrop = document.getElementById('tabooFilterBackdrop');
                                if (modal) modal.classList.add('d-none');
                                if (backdrop) backdrop.classList.add('d-none');
                            };
                        }

                        // Override clearTabooFilter
                        const clearBtn = document.getElementById('clearTabooFilter');
                        if (clearBtn && clearBtn._tabooHandler) {
                            clearBtn._tabooHandler = function() {
                                window.currentSelectedTaboos = [];
                                document.querySelectorAll('.taboo-checkbox').forEach(cb => cb.checked = false);

                                // Remove filter-active class
                                const table = document.querySelector('.table');
                                if (table) {
                                    table.classList.remove('filter-active');
                                }

                                // Reset all rows to normal pagination
                                const tbody = document.querySelector('.table-body-all');
                                if (tbody) {
                                    const allRows = tbody.querySelectorAll('tr[data-taboo-days]');

                                    // BƯỚC 1: Reset tất cả về trạng thái ban đầu
                                    allRows.forEach((row, index) => {
                                        row.style.removeProperty('display');
                                        row.classList.remove('filtered-out');

                                        if (index < 10) {
                                            row.classList.remove('pagination-hidden');
                                        } else {
                                            row.classList.add('pagination-hidden');
                                        }
                                    });

                                    // BƯỚC 2: Reset pagination button
                                    const loadMoreBtn = document.querySelector('.load-more-btn');
                                    if (loadMoreBtn) {
                                        loadMoreBtn.dataset.loaded = '10';
                                        loadMoreBtn.dataset.total = allRows.length.toString();

                                        if (allRows.length > 10) {
                                            loadMoreBtn.style.display = '';
                                            loadMoreBtn.innerHTML = 'Xem thêm';
                                        } else {
                                            loadMoreBtn.style.display = 'none';
                                        }

                                    }
                                }

                                // Hide filter status
                                const filterStatus = document.getElementById('filterStatus');
                                if (filterStatus) {
                                    filterStatus.classList.add('d-none');
                                }

                                // Close modal
                                const modal = document.getElementById('tabooFilterModal');
                                const backdrop = document.getElementById('tabooFilterBackdrop');
                                if (modal) modal.classList.add('d-none');
                                if (backdrop) backdrop.classList.add('d-none');
                            };
                        }
                    }, 100);
                };

                window.initTabooFilter(resultsByYear);
            } else {
                console.error('initTabooFilter function not found');
            }
        }, 500);
    });
</script>