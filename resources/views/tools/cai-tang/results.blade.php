<div class="w-100">
    <!-- Filter and Sort Controls - Outside tabs -->
   

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
                            {{ $year }}s
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
    <div class="tab-content ">
        @php $firstYear = true; @endphp
        @foreach ($resultsByYear as $year => $yearData)
            <div class="tab-pane fade {{ $firstYear ? 'show active' : '' }}" id="year-{{ $year }}">
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- Thông tin người đứng lễ --}}

                                <div
                                    class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người đứng lễ"
                                        width="28" height="28" class="me-1"> Thông Tin Người Đứng Lễ
                                </div>
                                @if (isset($hostInfo))
                                    <div class="info-grid">
                                        <p class="mb-2">
                                            <strong>Ngày sinh:</strong>
                                            {{ $hostInfo['dob_str'] }} tức ngày
                                            {{ $hostInfo['lunar_dob_str'] }} âm lịch
                                        </p>
                                        <p class="mb-2">
                                            <strong>Tuổi:</strong>
                                            <b>{{ $hostInfo['can_chi_nam'] }}</b>, Mệnh:
                                            {{ $hostInfo['menh']['hanh'] ?? 'Không rõ' }}
                                            ({{ $hostInfo['menh']['napAm'] ?? 'Không rõ' }})
                                        </p>
                                        <p class="mb-2">
                                            <strong>Tuổi âm:</strong>
                                            {{ $yearData['host_analysis']['lunar_age'] }} tuổi
                                        </p>
                                        <p class="mb-2">
                                            <strong>Thời gian cải táng:</strong>
                                            {{ $inputs['date_range'] ?? '' }}
                                        </p>
                                    </div>
                                @endif


                            </div>
                            <div class="col-lg-6">
                                {{-- Thông tin người mất --}}

                                <div
                                    class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                                    <img src="{{ asset('icons/dac-diem1.svg') }}" alt="thông tin người mất"
                                        width="28" height="28" class="me-1"> Thông Tin Người Mất
                                </div>
                                @if (isset($deceasedInfo))
                                    <div class="info-grid">
                                        <p class="mb-2">
                                            <strong>Năm sinh âm lịch:</strong>
                                            {{ $deceasedInfo['birth_year_lunar'] }}
                                            ({{ $deceasedInfo['birth_can_chi'] }})
                                        </p>
                                        <p class="mb-2">
                                            <strong>Năm mất âm lịch:</strong>
                                            {{ $deceasedInfo['death_year_lunar'] }}
                                            ({{ $deceasedInfo['death_can_chi'] }})
                                        </p>
                                        <p class="mb-2">
                                            <strong>Tuổi người mất:</strong>
                           
                                            {{ $deceasedInfo['napAm_birth']['napAm'] }}
                                        </p>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                {{-- Phân tích người đứng lễ --}}
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-1 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="phân tích người đứng lễ" width="28"
                                height="28" class="me-1"> Kiểm tra Kim Lâu - Hoang Ốc - Tam Tai - Thái Tuế
                        </div>
                        <div class="info-grid">
                            @php $deceasedResult = $yearData['deceased_analysis']; @endphp
                            <p class="mb-2">
                                Kiểm tra người đứng lễ sinh năm {{ $hostInfo['dob_obj']->year }}
                                ({{ \App\Helpers\KhiVanHelper::canchiNam($hostInfo['dob_obj']->year) }})
                                có gặp hạn Kim Lâu, Tam Tai, Hoang Ốc hoặc xung với năm
                                {{ $deceasedResult['check_year_can_chi'] ?? $year }} không?
                            </p>
                            <ul>
                                <li>{{ $yearData['host_analysis']['kimLau']['is_bad'] ? 'Phạm Kim Lâu' : 'Không phạm Kim Lâu' }}
                                </li>
                                <li>{{ $yearData['host_analysis']['hoangOc']['is_bad'] ? 'Phạm Hoang Ốc' : 'Không phạm Hoang Ốc' }}
                                </li>
                                <li>{{ $yearData['host_analysis']['tamTai']['is_bad'] ? 'Phạm Tam Tai' : 'Không phạm Tam Tai' }}
                                </li>
                
                            </ul>
                            <p><strong>Kết luận:</strong> {!! $yearData['host_analysis']['description'] !!}</p>
                        </div>
                    </div>
                </div>

                {{-- Phân tích người mất --}}
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body box1-con-year">
                        <div
                            class="text-primary mb-1 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                            <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="phân tích người mất" width="28"
                                height="28" class="me-1"> Kiểm tra Thái Tuế - Tuế Phá cho người mất
                        </div>
                        <div class="info-grid">
                            @php $deceasedResult = $yearData['deceased_analysis']; @endphp
                            <p class="mb-2">
                                Kiểm tra năm <strong>{{ $deceasedResult['check_year_can_chi'] ?? $year }}
                                    ({{ $deceasedResult['check_year'] ?? $year }})</strong> có phạm Thái Tuế, Tuế Phá
                                (lục xung) với
                                tuổi người mất hay không?
                            </p>
                            <p class="mb-2">
                                <strong>Người mất sinh năm
                                    {{ $deceasedResult['deceased_birth_year'] ?? $deceasedInfo['birth_year_lunar'] }}
                                    ({{ $deceasedResult['deceased_can_chi'] ?? $deceasedInfo['birth_can_chi'] }}):</strong>
                            </p>
                            <ul>
                                <li> Năm {{ $deceasedResult['check_year_can_chi'] ?? $year }}
                                    @if ($deceasedResult['is_thai_tue'] ?? false)
                                        <strong style="color: #dc3545">Phạm Thái Tuế</strong>
                                    @else
                                        <strong style="color: #28a745">Không phạm Thái Tuế</strong>
                                    @endif
                                </li>
                                <li>@if ($deceasedResult['is_tue_pha'] ?? false)
                                        <strong style="color: #dc3545">Phạm Tuế Phá (xung Thái Tuế)</strong>
                                    @else
                                        <strong style="color: #28a745">Không phạm Tuế Phá</strong>
                                    @endif
                                </li>
                            </ul>
                            <p><strong>Kết luận:</strong>
                                <span style="color: {{ $deceasedResult['is_bad'] ?? false ? '#dc3545' : '#28a745' }}">
                                    {!! $deceasedResult['conclusion'] ?? 'Không có vấn đề gì với năm này' !!}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Bảng điểm chi tiết --}}
                <div class="card border-0 mb-3 w-100 box-detial-year">
                    <div class="card-body">
                        @if (isset($yearData['days']) && count($yearData['days']) > 0)
                            <!-- Filter and Sort Controls - trực tiếp trên table -->
                            <div class="betwen-ds flex-wrap mb-3">
                                <div class="text-primary mb-0 title-tong-quan-h4-log text-dark fw-bolder">
                                    <img src="{{ asset('icons/k_nen_1.svg') }}" alt="bảng điểm cải táng"
                                        width="28" height="28" class="me-1"> Danh Sách Điểm Theo Ngày Cải Táng
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
                                            <th style="">Yếu tố hỗ trợ cải táng</th>
                                            <th style="border-radius: 0 8px 8px 0" class="score-header">Điểm</th>
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
                                                        href="{{ route('cai-tang.details', [
                                                            'date' => $day['date']->format('Y-m-d'),
                                                            'birthdate' => $hostInfo['dob_obj']->format('Y-m-d'),
                                                            'birth_mat' => $deceasedInfo['birth_year_lunar'],
                                                            'nam_mat' => $deceasedInfo['death_year_lunar'],
                                                            'date_range' => $inputs['date_range'] ?? '',
                                                            'calendar_type' => $inputs['calendar_type'] ?? 'solar',
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
                                                                $hostInfo['dob_obj']->year,
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

                                                        // Giờ tốt
                                                        if (!empty($day['good_hours'])) {
                                                            $goodHoursList = is_array($day['good_hours'])
                                                                ? implode(', ', $day['good_hours'])
                                                                : $day['good_hours'];
                                                            $supportFactors[] = "Giờ hoàng đạo: {$goodHoursList}";
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
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Không có
                                                            yếu
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
                                Không có ngày nào trong khoảng thời gian đã chọn phù hợp để cải táng.
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
