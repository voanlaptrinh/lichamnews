{{--
TABOO FILTER HYBRID SCRIPT - Tương thích với nhiều cấu trúc dữ liệu
=====================================================================

Script này được thiết kế để hoạt động với nhiều cấu trúc dữ liệu khác nhau:

1. Cấu trúc Wedding Tool (kết hôn) - Dual score:
   day.groom_score.issues[] và day.bride_score.issues[] với issue.source = 'Taboo'
   day.groom_score.percentage + day.bride_score.percentage cho điểm số (average)

2. Cấu trúc FunctionHelper (xuất hành):
   day.day_score.score.issues[] với issue.source = 'Taboo' và issue.details.tabooName
   day.day_score.score.percentage cho điểm số

3. Cấu trúc GoodBadDayHelper (mua xe):
   day.day_score.issues[] với issue.source = 'Taboo' và issue.details.tabooName
   day.day_score.percentage cho điểm số

4. Cấu trúc từ controller:
   day.day_score.checkTabooDays.issues[] với issue.details.tabooName

5. Cấu trúc cũ (tương thích ngược):
   day.issues[] với issue.details.tabooName hoặc issue.name

6. Cấu trúc đơn giản:
   day.taboo_days[] với string hoặc object.name

Supports multiple tbody selectors:
- .table-body-{year} (preferred)
- #table-{year} tbody (fallback)
- .table tbody (general fallback)

UI Patterns:
- Dropdown filter (tabooFilterModal với backdrop)
- Modal filter (cho backward compatibility)
--}}
<script>
// ========== TABOO FILTER HYBRID FUNCTIONS ==========
function initTabooFilter(resultsByYear) {
    console.log('=== TABOO FILTER SCRIPT LOADED ===');
    console.log('initTabooFilter called with data:', Object.keys(resultsByYear || {}));

    // Debug function để kiểm tra trạng thái dữ liệu
    function debugDataStatus() {
        console.log('=== DATA STATUS DEBUG ===');
        Object.keys(resultsByYear || {}).forEach(year => {
            console.log(`Year ${year}:`, {
                hasYearData: !!resultsByYear[year],
                hasDays: !!(resultsByYear[year] && resultsByYear[year].days),
                daysCount: resultsByYear[year]?.days?.length || 0,
                originalDataCount: originalData[year]?.length || 0,
                currentFilteredDataCount: currentFilteredData[year]?.length || 0,
                firstDayStructure: resultsByYear[year]?.days?.[0] ? Object.keys(resultsByYear[year].days[0]) : 'No days'
            });
        });
        console.log('=== END DATA STATUS ===');
    }

    if (!resultsByYear) {
        console.log('No resultsByYear data, returning');
        return;
    }

    console.log('initTabooFilter called with data:', resultsByYear);

    let originalData = {}; // Lưu dữ liệu gốc
    let currentFilteredData = {}; // Dữ liệu sau khi lọc

    // Expose data globally để có thể access từ pagination functions
    window.tabooFilterData = {
        originalData: originalData,
        currentFilteredData: currentFilteredData
    };

    // Lưu dữ liệu gốc cho mỗi năm
    Object.keys(resultsByYear).forEach(year => {
        console.log(`Initializing data for year ${year}:`, resultsByYear[year]);
        if (resultsByYear[year] && resultsByYear[year].days) {
            originalData[year] = [...resultsByYear[year].days];
            currentFilteredData[year] = [...resultsByYear[year].days];
            console.log(`Year ${year}: ${originalData[year].length} days loaded`);

            // Debug: log first day structure for each year
            if (originalData[year].length > 0) {
                console.log(`Year ${year} first day structure:`, originalData[year][0]);
            }
        } else {
            console.warn(`Year ${year}: No days data found`);
            originalData[year] = [];
            currentFilteredData[year] = [];
        }
    });

    // Gọi debug function sau khi khởi tạo
    debugDataStatus();

    // Hàm kiểm tra xem ngày có chứa taboo không - Phiên bản hybrid tương thích
    function hasTaboo(day, tabooNames) {
        console.log('Checking day for taboos:', {
            date: day.date,
            tabooNames: tabooNames,
            dayStructure: Object.keys(day),
            hasGroomScore: !!day.groom_score,
            hasBrideScore: !!day.bride_score,
            hasDayScore: !!day.day_score
        });

        // Kiểm tra trong wedding tool - dual score structure (groom_score và bride_score)
        if (day.groom_score && day.bride_score) {
            console.log('Wedding tool detected, checking groom_score and bride_score for taboos:', tabooNames);

            // Kiểm tra trong groom_score.taboo_details.taboo_types (cấu trúc wedding)
            if (day.groom_score.taboo_details && day.groom_score.taboo_details.taboo_types && Array.isArray(day.groom_score.taboo_details.taboo_types)) {
                console.log('Groom taboo_types found:', day.groom_score.taboo_details.taboo_types);
                const found = day.groom_score.taboo_details.taboo_types.some(tabooName => {
                    console.log('Checking groom taboo:', tabooName, 'in list:', tabooNames);
                    return tabooNames.includes(tabooName);
                });
                if (found) return true;
            }

            // Kiểm tra trong bride_score.taboo_details.taboo_types (cấu trúc wedding)
            if (day.bride_score.taboo_details && day.bride_score.taboo_details.taboo_types && Array.isArray(day.bride_score.taboo_details.taboo_types)) {
                console.log('Bride taboo_types found:', day.bride_score.taboo_details.taboo_types);
                const found = day.bride_score.taboo_details.taboo_types.some(tabooName => {
                    console.log('Checking bride taboo:', tabooName, 'in list:', tabooNames);
                    return tabooNames.includes(tabooName);
                });
                if (found) return true;
            }

            // Fallback: Kiểm tra trong groom_score.issues (nếu có)
            if (day.groom_score.issues && Array.isArray(day.groom_score.issues)) {
                console.log('Groom issues found:', day.groom_score.issues);
                const found = day.groom_score.issues.some(issue => {
                    console.log('Checking groom issue:', issue);
                    if (issue.source === 'Taboo' && issue.details && issue.details.tabooName) {
                        console.log('Found groom taboo:', issue.details.tabooName, 'in list:', tabooNames);
                        return tabooNames.includes(issue.details.tabooName);
                    }
                    if (issue.name && tabooNames.includes(issue.name)) {
                        return true;
                    }
                    if (issue.reason) {
                        return tabooNames.some(taboo => issue.reason.includes(taboo));
                    }
                    return false;
                });
                if (found) return true;
            }

            // Fallback: Kiểm tra trong bride_score.issues (nếu có)
            if (day.bride_score.issues && Array.isArray(day.bride_score.issues)) {
                console.log('Bride issues found:', day.bride_score.issues);
                const found = day.bride_score.issues.some(issue => {
                    console.log('Checking bride issue:', issue);
                    if (issue.source === 'Taboo' && issue.details && issue.details.tabooName) {
                        console.log('Found bride taboo:', issue.details.tabooName, 'in list:', tabooNames);
                        return tabooNames.includes(issue.details.tabooName);
                    }
                    if (issue.name && tabooNames.includes(issue.name)) {
                        return true;
                    }
                    if (issue.reason) {
                        return tabooNames.some(taboo => issue.reason.includes(taboo));
                    }
                    return false;
                });
                if (found) return true;
            }

            // Kiểm tra trong day_score chung cho wedding (nếu có)
            if (day.day_score?.issues && Array.isArray(day.day_score.issues)) {
                const found = day.day_score.issues.some(issue => {
                    if (issue.source === 'Taboo' && issue.details && issue.details.tabooName) {
                        return tabooNames.includes(issue.details.tabooName);
                    }
                    if (issue.name && tabooNames.includes(issue.name)) {
                        return true;
                    }
                    if (issue.reason) {
                        return tabooNames.some(taboo => issue.reason.includes(taboo));
                    }
                    return false;
                });
                if (found) return true;
            }
        }

        // Kiểm tra trong day_score.score.issues (cấu trúc từ FunctionHelper - xuất hành)
        if (day.day_score?.score?.issues && Array.isArray(day.day_score.score.issues)) {
            const found = day.day_score.score.issues.some(issue => {
                // Kiểm tra source = 'Taboo' và details.tabooName
                if (issue.source === 'Taboo' && issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                // Fallback: kiểm tra trong issue.name
                if (issue.name && tabooNames.includes(issue.name)) {
                    return true;
                }
                // Fallback: kiểm tra trong reason cho các taboo phổ biến
                if (issue.reason) {
                    return tabooNames.some(taboo => issue.reason.includes(taboo));
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trong day_score.issues (cấu trúc mới từ GoodBadDayHelper - mua xe)
        if (day.day_score?.issues && Array.isArray(day.day_score.issues)) {
            const found = day.day_score.issues.some(issue => {
                // Kiểm tra source = 'Taboo' và details.tabooName
                if (issue.source === 'Taboo' && issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                // Fallback: kiểm tra trong issue.name
                if (issue.name && tabooNames.includes(issue.name)) {
                    return true;
                }
                // Fallback: kiểm tra trong reason cho các taboo phổ biến
                if (issue.reason) {
                    return tabooNames.some(taboo => issue.reason.includes(taboo));
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trong day_score.taboo_details.taboo_types (cấu trúc ban thờ)
        if (day.day_score?.taboo_details?.taboo_types && Array.isArray(day.day_score.taboo_details.taboo_types)) {
            console.log('Ban Tho taboo_details.taboo_types found:', day.day_score.taboo_details.taboo_types);
            const found = day.day_score.taboo_details.taboo_types.some(tabooName => {
                console.log('Checking ban tho taboo:', tabooName, 'in list:', tabooNames);
                return tabooNames.includes(tabooName);
            });
            if (found) return true;
        }

        // Kiểm tra trong day_score.checkTabooDays.issues (cấu trúc từ controller)
        if (day.day_score?.checkTabooDays?.issues && Array.isArray(day.day_score.checkTabooDays.issues)) {
            const found = day.day_score.checkTabooDays.issues.some(issue => {
                if (issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                if (issue.name && tabooNames.includes(issue.name)) {
                    return true;
                }
                if (issue.reason) {
                    return tabooNames.some(taboo => issue.reason.includes(taboo));
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trong day.issues (cấu trúc cũ để tương thích với view khác)
        if (day.issues && Array.isArray(day.issues)) {
            const found = day.issues.some(issue => {
                if (issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                if (issue.name && tabooNames.includes(issue.name)) {
                    return true;
                }
                if (issue.reason) {
                    return tabooNames.some(taboo => issue.reason.includes(taboo));
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trực tiếp trong day.taboo_days (cấu trúc đơn giản nhất)
        if (day.taboo_days && Array.isArray(day.taboo_days)) {
            const found = day.taboo_days.some(taboo => {
                if (typeof taboo === 'string') {
                    return tabooNames.includes(taboo);
                }
                if (taboo.name) {
                    return tabooNames.includes(taboo.name);
                }
                return false;
            });
            if (found) return true;
        }

        return false;
    }

    // Hàm cập nhật hiển thị table - Phiên bản hybrid
    function updateTable(year, filteredDays, preserveCurrentLoaded = false) {
        console.log(`Updating table for year ${year} with ${filteredDays.length} filtered days, preserveCurrentLoaded=${preserveCurrentLoaded}`);

        // Log dates để debug
        if (filteredDays.length > 0) {
            console.log(`First filtered day date: ${filteredDays[0].date}`);
            console.log(`Last filtered day date: ${filteredDays[filteredDays.length - 1].date}`);
        }

        // Tìm tbody theo nhiều selector để tương thích - chỉ trong tab đúng
        const activeTabPane = document.querySelector(`#year-${year}`);
        console.log(`Looking for table in tab: year-${year}`, activeTabPane);

        let tbody = null;
        if (activeTabPane) {
            // Tìm trong tab cụ thể trước
            tbody = activeTabPane.querySelector(`.table-body-${year}`);
            if (!tbody) {
                tbody = activeTabPane.querySelector(`#table-${year} tbody`);
            }
            if (!tbody) {
                tbody = activeTabPane.querySelector('.table tbody');
            }
        }

        // Fallback: tìm global nếu không tìm thấy trong tab
        if (!tbody) {
            tbody = document.querySelector(`.table-body-${year}`);
            if (!tbody) {
                tbody = document.querySelector(`#table-${year} tbody`);
            }
        }

        if (!tbody) {
            console.warn(`Không tìm thấy tbody cho năm ${year}`, {
                activeTabPane: activeTabPane,
                year: year
            });
            return;
        }

        console.log(`Found tbody for year ${year}:`, tbody);

        // Lấy tất cả row hiện tại (từ blade template gốc)
        const allRows = Array.from(tbody.querySelectorAll('tr:not(.empty-filter-row)'));

        // Lấy load more button
        const loadMoreBtn = tbody.closest('.card-body')?.querySelector('.load-more-btn');

        // Xác định số lượng hiện tại được hiển thị
        let currentLoaded = 10; // Default là 10
        if (preserveCurrentLoaded && loadMoreBtn) {
            // Lấy số đã load từ button hoặc đếm số rows visible hiện tại
            const loadedFromBtn = parseInt(loadMoreBtn.dataset.loaded);
            const currentVisible = allRows.filter(row => row.style.display !== 'none').length;
            currentLoaded = loadedFromBtn || currentVisible || 10;
            console.log(`DEBUG: Preserving pagination - loadedFromBtn=${loadedFromBtn}, currentVisible=${currentVisible}, using currentLoaded=${currentLoaded}`);
        } else {
            console.log(`DEBUG: NOT preserving pagination, reset to default currentLoaded=${currentLoaded}`);
        }

        // Ẩn tất cả rows trước
        allRows.forEach(row => {
            row.style.display = 'none';
            row.dataset.visible = 'false';
        });

        // Hiển thị theo thứ tự của filteredDays với pagination
        let visibleCount = 0;
        console.log(`Processing ${filteredDays.length} filtered days for year ${year}`);

        filteredDays.forEach((filteredDay, filteredIndex) => {
            if (visibleCount >= currentLoaded) return; // Dừng khi đã đủ items cho pagination

            // Tìm row DOM tương ứng với filteredDay
            const originalIndex = originalData[year].findIndex(originalDay => {
                if (filteredDay.date && originalDay.date) {
                    const filteredDateStr = new Date(filteredDay.date).toDateString();
                    const originalDateStr = new Date(originalDay.date).toDateString();
                    const match = filteredDateStr === originalDateStr;
                    if (filteredIndex < 3) { // Log first few for debugging
                        console.log(`Date comparison for year ${year}: ${filteredDateStr} vs ${originalDateStr} = ${match}`);
                    }
                    return match;
                }
                return false;
            });

            if (originalIndex !== -1 && allRows[originalIndex]) {
                allRows[originalIndex].style.display = '';
                allRows[originalIndex].dataset.visible = 'true';
                visibleCount++;
                if (visibleCount <= 3) { // Log first few visible rows
                    console.log(`Showing row ${originalIndex} for date ${filteredDay.date} in year ${year}`);
                }
            } else {
                console.warn(`Could not find row for date ${filteredDay.date} in year ${year}, originalIndex: ${originalIndex}, allRows.length: ${allRows.length}`);
            }
        });

        // Cập nhật load more button với filtered results
        if (loadMoreBtn) {
            const actualTotal = filteredDays.length;

            // Khi apply filter (không preserve), reset về 10; khi preserve thì giữ nguyên
            let actualLoaded;
            if (preserveCurrentLoaded) {
                actualLoaded = Math.min(visibleCount, actualTotal);
            } else {
                // Reset về 10 khi apply filter mới
                actualLoaded = Math.min(10, actualTotal);
            }

            console.log(`UpdateTable - Year: ${year}, Total: ${actualTotal}, Loaded: ${actualLoaded}, Visible: ${visibleCount}, currentLoaded: ${currentLoaded}, preserveCurrentLoaded: ${preserveCurrentLoaded}`);

            loadMoreBtn.dataset.loaded = actualLoaded.toString();
            loadMoreBtn.dataset.total = actualTotal.toString();

            console.log(`Button data updated for year ${year}: loaded=${actualLoaded}, total=${actualTotal}`);

            const remaining = actualTotal - actualLoaded;

            // Chỉ hiện load more button khi:
            // 1. Còn items để load (remaining > 0)
            // 2. Tổng số filtered items > 10
            if (remaining > 0 && actualTotal > 10) {
                loadMoreBtn.style.display = '';
                loadMoreBtn.innerHTML = `
                    <i class="bi bi-plus-circle me-2"></i>
                    Xem thêm ${Math.min(10, remaining)} bảng
                    <span class="text-muted ms-2">(${remaining} còn lại)</span>
                `;
                console.log(`Load more button updated: ${Math.min(10, remaining)} bảng (${remaining} còn lại)`);
            } else {
                loadMoreBtn.style.display = 'none';
                console.log(`Load more button hidden - remaining: ${remaining}, total: ${actualTotal}`);
            }
        }

        // Hiển thị thông báo nếu không có ngày nào
        if (filteredDays.length === 0) {
            // Thêm row thông báo nếu chưa có
            let emptyRow = tbody.querySelector('.empty-filter-row');
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-filter-row';
                emptyRow.innerHTML = `
                    <td colspan="3" class="text-center text-muted py-4">
                        Tất cả ngày đều có taboo đã chọn để lọc.
                    </td>
                `;
                tbody.appendChild(emptyRow);
            }
            emptyRow.style.display = '';
        } else {
            // Ẩn row thông báo nếu có
            const emptyRow = tbody.querySelector('.empty-filter-row');
            if (emptyRow) {
                emptyRow.style.display = 'none';
            }
        }

        // Debug: Đếm lại số rows thực sự visible sau khi update
        const finalVisibleRows = Array.from(tbody.querySelectorAll('tr:not(.empty-filter-row)')).filter(row => row.style.display !== 'none');
        console.log(`FINAL DEBUG for year ${year}: Expected ${filteredDays.length} filtered days, actually showing ${finalVisibleRows.length} visible rows, currentLoaded was ${currentLoaded}`);

        if (finalVisibleRows.length !== Math.min(filteredDays.length, currentLoaded)) {
            console.warn(`MISMATCH DETECTED: Expected ${Math.min(filteredDays.length, currentLoaded)} but showing ${finalVisibleRows.length}`);
        }
    }

    // Ensure only one filter section is active (remove duplicates if any)
    const ensureSingleFilterSection = () => {
        const filterModals = document.querySelectorAll('#tabooFilterModal');
        const filterBackdrops = document.querySelectorAll('#tabooFilterBackdrop');

        // Keep all filter buttons (they have different data-year attributes now)
        const filterBtns = document.querySelectorAll('.taboo-filter-btn');
        console.log(`Found ${filterBtns.length} filter buttons (should be one per tab)`);

        // Remove duplicate modals (keep only one)
        if (filterModals.length > 1) {
            console.warn(`Found ${filterModals.length} filter modals, keeping only the first one`);
            for (let i = 1; i < filterModals.length; i++) {
                filterModals[i].remove();
            }
        }

        // Remove duplicate backdrops (keep only one)
        if (filterBackdrops.length > 1) {
            console.warn(`Found ${filterBackdrops.length} filter backdrops, keeping only the first one`);
            for (let i = 1; i < filterBackdrops.length; i++) {
                filterBackdrops[i].remove();
            }
        }
    };

    // Xử lý modal filter
    const setupModalFilter = () => {
        // Ensure only one filter section exists
        ensureSingleFilterSection();

        // Tìm tất cả nút filter với nhiều selector khác nhau để tương thích với tất cả tools
        const filterBtnSelectors = [
            '.taboo-filter-btn',    // Selector cho các tool thông thường
            '#tabooFilterBtn',      // Selector cho wedding tool
            '[data-filter="taboo"]', // Selector dự phòng
            '.filter-btn-taboo'     // Selector bổ sung
        ];

        const allFilterBtns = [];
        filterBtnSelectors.forEach(selector => {
            const btns = document.querySelectorAll(selector);
            btns.forEach(btn => {
                if (!allFilterBtns.includes(btn)) {
                    allFilterBtns.push(btn);
                }
            });
        });

        const modal = document.getElementById('tabooFilterModal');
        const backdrop = document.getElementById('tabooFilterBackdrop');
        const closeBtn = document.getElementById('closeFilterModal');
        const badge = document.getElementById('filterBadge');

        // Hàm mở modal chung cho tất cả tools
        const openModal = (e) => {
            e.preventDefault();
            e.stopPropagation();

            if (modal && backdrop) {
                modal.classList.remove('d-none');
                backdrop.classList.remove('d-none');
                // document.body.classList.add('menu-open');
            }

            return false;
        };

        // Bind event cho tất cả filter buttons tìm được
        allFilterBtns.forEach((filterBtn, index) => {
            if (filterBtn) {
                filterBtn.addEventListener('click', openModal);
                const toolType = filterBtn.dataset.year || filterBtn.id || `button-${index}`;
                console.log('Filter button bound for:', toolType);
            }
        });

        if (allFilterBtns.length === 0) {
            console.log('No filter buttons found with any selector');
        } else {
            console.log('Found', allFilterBtns.length, 'filter buttons total across all tools');
        }

        // Đóng modal
        const closeModal = () => {
            modal.classList.add('d-none');
            backdrop.classList.add('d-none');
            // document.body.classList.remove('menu-open');
        };

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeModal);
        }

        // Quick select buttons
        const selectCommonBtn = document.getElementById('selectCommon');
        const selectAllBtn = document.getElementById('selectAll');
        const clearAllBtn = document.getElementById('clearAll');

        if (selectCommonBtn) {
            selectCommonBtn.addEventListener('click', () => {
                // Chọn các taboo phổ biến cho kết hôn
                const commonTaboos = ['Tam Nương', 'Nguyệt Kỵ', 'Nguyệt Tận'];
                document.querySelectorAll('.taboo-checkbox').forEach(cb => {
                    cb.checked = commonTaboos.includes(cb.value);
                });
                updateFilterBadge();
            });
        }

        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', () => {
                document.querySelectorAll('.taboo-checkbox').forEach(cb => cb.checked = true);
                updateFilterBadge();
            });
        }

        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', () => {
                document.querySelectorAll('.taboo-checkbox').forEach(cb => cb.checked = false);
                updateFilterBadge();
            });
        }

        // Update badge on checkbox change
        document.querySelectorAll('.taboo-checkbox').forEach(cb => {
            cb.addEventListener('change', updateFilterBadge);
        });
    };

    // Cập nhật badge số lượng filter
    const updateFilterBadge = () => {
        const selectedCount = document.querySelectorAll('.taboo-checkbox:checked').length;
        const badge = document.getElementById('filterBadge');

        if (badge) {
            if (selectedCount > 0) {
                badge.textContent = selectedCount;
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }
        }
    };

    // Debug: check for multiple apply buttons and checkboxes
    const allApplyBtns = document.querySelectorAll('#applyTabooFilter');
    const allCheckboxes = document.querySelectorAll('.taboo-checkbox');
    console.log('DEBUG: Found', allApplyBtns.length, 'apply buttons');
    console.log('DEBUG: Found', allCheckboxes.length, 'total checkboxes');

    // Xử lý áp dụng filter taboo
    const applyBtn = document.getElementById('applyTabooFilter');
    if (applyBtn) {
        // Remove any existing listeners
        applyBtn.removeEventListener('click', applyBtn._tabooHandler);

        applyBtn._tabooHandler = function() {
            const allCheckboxes = document.querySelectorAll('.taboo-checkbox:checked');
            console.log('DEBUG: All checked checkboxes found:', allCheckboxes.length);
            console.log('DEBUG: All checked checkbox values:', Array.from(allCheckboxes).map(cb => cb.value));

            const selectedTaboos = [...new Set(Array.from(allCheckboxes).map(cb => cb.value))];
            console.log('DEBUG: Deduplicated selectedTaboos:', selectedTaboos);

            if (selectedTaboos.length === 0) {
                alert('Vui lòng chọn ít nhất một loại taboo để lọc');
                return;
            }

            let totalFiltered = 0;
            let totalDays = 0;

            // Lọc cho từng năm
            Object.keys(resultsByYear).forEach(year => {
                const originalDays = originalData[year];

                if (!originalDays || originalDays.length === 0) {
                    console.warn(`Skipping year ${year}: No original data available`);
                    return;
                }

                totalDays += originalDays.length;

                const filteredDays = originalDays.filter(day => {
                    const hasTabooResult = hasTaboo(day, selectedTaboos);
                    return !hasTabooResult;
                });
                totalFiltered += (originalDays.length - filteredDays.length);

                // Cập nhật dữ liệu hiện tại
                currentFilteredData[year] = filteredDays;

                console.log(`Applying filter to year ${year}: ${originalDays.length} -> ${filteredDays.length} days`);
                updateTable(year, filteredDays);
            });

            // Debug data status after applying filter
            console.log('=== AFTER APPLYING FILTER ===');
            debugDataStatus();

            // Lưu trạng thái filter
            saveFilterState();

            // Hiển thị trạng thái - tương thích với cả per-year và global filter status
            let totalDaysOriginal = 0;
            let totalDaysFiltered = 0;
            let totalDaysRemaining = 0;

            Object.keys(resultsByYear).forEach(year => {
                const currentYearDays = originalData[year]?.length || 0;
                const currentYearFiltered = (originalData[year]?.length || 0) - (currentFilteredData[year]?.length || 0);
                const currentYearRemaining = currentFilteredData[year]?.length || 0;

                totalDaysOriginal += currentYearDays;
                totalDaysFiltered += currentYearFiltered;
                totalDaysRemaining += currentYearRemaining;

                // Per-year filter status (cho các tool có nhiều tab năm)
                const filterStatus = document.getElementById(`filterStatus-${year}`);
                const filterStatusText = document.getElementById(`filterStatusText-${year}`);

                if (filterStatus && filterStatusText) {
                    filterStatus.classList.remove('d-none');

                    // Tính số ngày đang hiển thị thực tế bằng cách đếm rows visible trong DOM
                    const targetTab = document.querySelector(`#year-${year}`);
                    let actualVisibleCount = 10; // fallback default

                    if (targetTab) {
                        const table = targetTab.querySelector('#bang-chi-tiet table tbody');
                        if (table) {
                            // Lấy tất cả rows, loại trừ các rows không mong muốn
                            const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                            const visibleRows = Array.from(allRows).filter(row => {
                                const style = window.getComputedStyle(row);
                                const isVisible = row.style.display !== 'none' &&
                                                style.display !== 'none' &&
                                                !row.classList.contains('d-none') &&
                                                !row.hasAttribute('hidden');
                                return isVisible;
                            });

                            actualVisibleCount = visibleRows.length;
                            console.log(`DEBUG DETAILED: Year ${year}`);
                            console.log(`- Total rows found: ${allRows.length}`);
                            console.log(`- Visible rows: ${actualVisibleCount}`);
                            console.log(`- First few visible row dates:`, visibleRows.slice(0, 3).map(row => row.textContent.match(/\d{1,2}\/\d{1,2}\/\d{4}/)?.[0] || 'No date'));
                        }
                    }

                    const currentVisibleCount = actualVisibleCount;

                    // Ensure unique taboo names in message
                    const uniqueTaboos = [...new Set(selectedTaboos)];
                    filterStatusText.textContent = `Đã lọc ${currentYearFiltered} ngày có ${uniqueTaboos.join(', ')} trong năm ${year}. Hiển thị ${currentVisibleCount}/${currentYearDays} ngày.`;

                    console.log(`DEBUG: Filter status for year ${year} - filtered: ${currentYearFiltered}, remaining: ${currentYearRemaining}, visible: ${currentVisibleCount}, total: ${currentYearDays}`);
                }
            });

            // Global filter status (cho các tool chỉ có 1 filter status chung)
            const globalFilterStatus = document.getElementById('filterStatus');
            const globalFilterStatusText = document.getElementById('filterStatusText');

            if (globalFilterStatus && globalFilterStatusText) {
                globalFilterStatus.classList.remove('d-none');

                const uniqueTaboos = [...new Set(selectedTaboos)];
                if (Object.keys(resultsByYear).length > 1) {
                    globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${uniqueTaboos.join(', ')} trong ${Object.keys(resultsByYear).length} năm. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
                } else {
                    globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${uniqueTaboos.join(', ')}. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
                }
            }

            // Đóng modal sau khi áp dụng
            const modal = document.getElementById('tabooFilterModal');
            const backdrop = document.getElementById('tabooFilterBackdrop');
            if (modal) modal.classList.add('d-none');
            if (backdrop) backdrop.classList.add('d-none');

            // Scroll đến bảng điểm của tab hiện tại
            const activeTab = document.querySelector('.tab-pane.show.active');
            if (activeTab) {
                const activeYear = activeTab.id.replace('year-', '');
                scrollToTable(activeYear);
            }
        };

        applyBtn.addEventListener('click', applyBtn._tabooHandler);
    }

    // Xử lý xóa filter taboo
    const clearBtn = document.getElementById('clearTabooFilter');
    if (clearBtn) {
        // Remove any existing listeners
        clearBtn.removeEventListener('click', clearBtn._tabooHandler);

        clearBtn._tabooHandler = function() {
            // Bỏ chọn tất cả checkbox
            document.querySelectorAll('.taboo-checkbox').forEach(cb => cb.checked = false);

            // Cập nhật badge
            updateFilterBadge();

            // Khôi phục hiển thị tất cả row cho tất cả năm với pagination ban đầu
            Object.keys(resultsByYear).forEach(year => {
                const tbody = document.querySelector(`.table-body-${year}`);
                if (tbody) {
                    // Hiển thị lại tất cả row gốc với pagination reset về 10
                    const allRows = tbody.querySelectorAll('tr:not(.empty-filter-row)');
                    allRows.forEach((row, index) => {
                        // Chỉ hiển thị 10 row đầu, ẩn phần còn lại
                        if (index < 10) {
                            row.style.display = '';
                            row.dataset.visible = 'true';
                        } else {
                            row.style.display = 'none';
                            row.dataset.visible = 'false';
                        }
                    });

                    // Reset load more button về trạng thái ban đầu
                    const loadMoreBtn = tbody.closest('.card-body')?.querySelector('.load-more-btn');
                    if (loadMoreBtn) {
                        const totalRows = allRows.length;
                        const visibleRows = 10; // Luôn reset về 10 rows visible

                        loadMoreBtn.dataset.loaded = visibleRows.toString();
                        loadMoreBtn.dataset.total = totalRows.toString();

                        // Chỉ hiện load more button khi tổng số rows > 10
                        if (totalRows > 10) {
                            loadMoreBtn.style.display = '';
                            const remaining = totalRows - visibleRows;
                            loadMoreBtn.innerHTML = `
                                <i class="bi bi-plus-circle me-2"></i>
                                Xem thêm ${Math.min(10, remaining)} bảng
                                <span class="text-muted ms-2">(${remaining} còn lại)</span>
                            `;
                        } else {
                            loadMoreBtn.style.display = 'none';
                        }
                    }

                    // Ẩn row thông báo empty nếu có
                    const emptyRow = tbody.querySelector('.empty-filter-row');
                    if (emptyRow) {
                        emptyRow.style.display = 'none';
                    }
                }

                currentFilteredData[year] = [...originalData[year]];
            });

            // Lưu trạng thái filter (rỗng)
            saveFilterState();

            // Ẩn trạng thái cho tất cả tabs và global status
            Object.keys(resultsByYear).forEach(year => {
                const filterStatus = document.getElementById(`filterStatus-${year}`);
                if (filterStatus) {
                    filterStatus.classList.add('d-none');
                }
            });

            // Ẩn global filter status
            const globalFilterStatus = document.getElementById('filterStatus');
            if (globalFilterStatus) {
                globalFilterStatus.classList.add('d-none');
            }

            // Đóng modal
            const modal = document.getElementById('tabooFilterModal');
            const backdrop = document.getElementById('tabooFilterBackdrop');
            if (modal) modal.classList.add('d-none');
            if (backdrop) backdrop.classList.add('d-none');

            // Scroll đến bảng điểm của tab hiện tại
            const activeTab = document.querySelector('.tab-pane.show.active');
            if (activeTab) {
                const activeYear = activeTab.id.replace('year-', '');
                scrollToTable(activeYear);
            }
        };

        clearBtn.addEventListener('click', clearBtn._tabooHandler);
    }

    // ========== DATE PARSING FROM DOM ROWS ==========
    function getDateFromRow(row) {
        // Try different ways to find the date - compatible with all tools

        // Method 1: Look for link with details and strong tag
        let dateText = row.querySelector('a[href*="details"] strong');
        if (dateText) {
            const text = dateText.textContent;
            const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
            if (match) {
                const dateStr = match[1];
                const parts = dateStr.split('/');
                const date = new Date(parts[2], parts[1] - 1, parts[0]);
                console.log('Date parsed from link strong:', dateStr, '->', date);
                return date;
            }
        }

        // Method 2: Look for any strong element with date pattern
        const allStrong = row.querySelectorAll('strong');
        for (let strong of allStrong) {
            const text = strong.textContent;
            const match = text.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
            if (match) {
                const dateStr = match[1];
                const parts = dateStr.split('/');
                const date = new Date(parts[2], parts[1] - 1, parts[0]);
                console.log('Date parsed from strong element:', dateStr, '->', date);
                return date;
            }
        }

        // Method 3: Look for any text with date pattern in the entire row
        const allText = row.textContent;
        const match = allText.match(/(\d{1,2}\/\d{1,2}\/\d{4})/);
        if (match) {
            const dateStr = match[1];
            const parts = dateStr.split('/');
            const date = new Date(parts[2], parts[1] - 1, parts[0]);
            console.log('Date parsed from row text:', dateStr, '->', date);
            return date;
        }

        // Method 4: Look for data attributes
        if (row.dataset && row.dataset.date) {
            const date = new Date(row.dataset.date);
            console.log('Date parsed from data attribute:', row.dataset.date, '->', date);
            return date;
        }

        console.warn('No date found in row:', row.innerHTML.substring(0, 200));
        return new Date(0); // Fallback to epoch
    }

    // ========== DOM-BASED TABLE SORTING ==========
    function sortTableByDOM(tbody, sortOrder) {
        console.log('Sorting table DOM by:', sortOrder);

        // Get all visible rows (not hidden by filter or pagination)
        const allRows = Array.from(tbody.querySelectorAll('tr'));
        const visibleRows = allRows.filter(row => {
            return row.style.display !== 'none' &&
                   !row.classList.contains('empty-filter-row') &&
                   !row.classList.contains('d-none');
        });

        console.log(`Found ${visibleRows.length} visible rows out of ${allRows.length} total`);

        // Sort visible rows
        visibleRows.sort((a, b) => {
            if (sortOrder === 'date_asc' || sortOrder === 'date_desc') {
                const dateA = getDateFromRow(a);
                const dateB = getDateFromRow(b);
                const result = sortOrder === 'date_asc' ? dateA - dateB : dateB - dateA;
                return result;
            } else {
                // Sort by score (existing logic)
                const scoreA = getScoreFromRow(a);
                const scoreB = getScoreFromRow(b);
                return sortOrder === 'asc' ? scoreA - scoreB : scoreB - scoreA;
            }
        });

        // Get hidden rows to preserve them
        const hiddenRows = allRows.filter(row => {
            return row.style.display === 'none' ||
                   row.classList.contains('empty-filter-row') ||
                   row.classList.contains('d-none');
        });

        // Clear table and re-append: sorted visible + hidden rows
        tbody.innerHTML = '';
        visibleRows.forEach(row => tbody.appendChild(row));
        hiddenRows.forEach(row => tbody.appendChild(row));

        console.log(`Table sorted: ${visibleRows.length} visible + ${hiddenRows.length} hidden rows`);
    }

    // ========== APPLY SORT TO SPECIFIC YEAR ==========
    function applySortToYear(year, sortOrder, shouldScroll = false) {
        console.log(`Applying sort to year ${year} with order: ${sortOrder}`);

        // Find the table for this specific year
        const yearTab = document.querySelector(`#year-${year}`);
        if (!yearTab) {
            console.warn(`No tab found for year ${year}`);
            return;
        }

        // Try multiple ways to find the table body
        let tbody = yearTab.querySelector(`#table-${year} tbody`) ||
                   yearTab.querySelector('.table tbody') ||
                   yearTab.querySelector('tbody');

        if (!tbody) {
            console.warn(`No table body found for year ${year}`);
            return;
        }

        console.log(`Found table for year ${year}, applying ${sortOrder} sort`);

        // Check if we need to sort data or DOM
        if (currentFilteredData[year] && currentFilteredData[year].length > 0) {
            // If we have filtered data, sort that and update table
            console.log(`Sorting filtered data for year ${year}`);
            const filteredDays = [...currentFilteredData[year]];

            filteredDays.sort((a, b) => {
                if (sortOrder === 'date_asc' || sortOrder === 'date_desc') {
                    const dateA = new Date(a.date);
                    const dateB = new Date(b.date);
                    return sortOrder === 'date_asc' ? dateA - dateB : dateB - dateA;
                } else {
                    const scoreA = getScore(a);
                    const scoreB = getScore(b);
                    return sortOrder === 'asc' ? scoreA - scoreB : scoreB - scoreA;
                }
            });

            updateTable(year, filteredDays);
        } else {
            // No filtered data, sort DOM directly
            console.log(`Sorting DOM directly for year ${year}`);
            sortTableByDOM(tbody, sortOrder);
        }

        // Scroll to table if requested
        if (shouldScroll) {
            setTimeout(() => {
                const table = yearTab.querySelector('#bang-chi-tiet');
                if (table) {
                    table.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        }

        console.log(`Sort applied successfully to year ${year}`);
    }

    // ========== LOAD MORE BUTTON HANDLER ==========
    function setupLoadMoreHandler() {
        // Global click handler for load more buttons
        document.addEventListener('click', function(event) {
            if (event.target.closest('.load-more-btn')) {
                event.preventDefault();
                event.stopPropagation();

                const btn = event.target.closest('.load-more-btn');
                const year = btn.dataset.year;
                const currentLoaded = parseInt(btn.dataset.loaded) || 10;
                const total = parseInt(btn.dataset.total) || 0;
                const loadAmount = 10;

                console.log(`Taboo Filter: Load more for year ${year}: showing ${currentLoaded + loadAmount} out of ${total}`);

                // Show more rows for this specific year
                const yearTab = document.querySelector(`#year-${year}`);
                if (yearTab) {
                    const rows = yearTab.querySelectorAll(`.table-row-${year}`);

                    for (let i = currentLoaded; i < Math.min(currentLoaded + loadAmount, total); i++) {
                        if (rows[i]) {
                            rows[i].style.display = '';
                            rows[i].dataset.visible = 'true';
                        }
                    }

                    // Update button
                    const newLoaded = Math.min(currentLoaded + loadAmount, total);
                    btn.dataset.loaded = newLoaded;
                    const remaining = total - newLoaded;

                    if (remaining > 0) {
                        btn.innerHTML = `
                            <i class="bi bi-plus-circle me-2"></i>
                            Xem thêm 10 bảng
                            <span class="text-muted ms-2">(${remaining} còn lại)</span>
                        `;
                    } else {
                        btn.style.display = 'none';
                    }

                    console.log(`Taboo Filter: Updated load more - loaded=${newLoaded}, remaining=${remaining}`);

                    // Update filter status for this year if filter is active
                    if (typeof window.updateFilterStatusOnPagination === 'function') {
                        window.updateFilterStatusOnPagination(year);
                    }
                }

                return false;
            }
        });

        console.log('Load more handler setup complete');
    }

    // ========== LƯU VÀ KHÔI PHỤC TRẠNG THÁI FILTER ==========

    // Lấy tên tool từ URL để tách biệt storage giữa các tool
    function getCurrentToolName() {
        const path = window.location.pathname;
        // Danh sách đầy đủ các tools theo routes
        if (path.includes('/xem-ngay-tot-xau') || path.includes('/tot-xau')) return 'tot-xau';
        if (path.includes('/xem-ngay-mua-nha') || path.includes('/mua-nha')) return 'mua-nha';
        if (path.includes('/xem-ngay-ket-hon') || path.includes('/ket-hon') || path.includes('/wedding')) return 'ket-hon';
        if (path.includes('/xem-ngay-dam-ngo') || path.includes('/dam-ngo')) return 'dam-ngo';
        if (path.includes('/xem-ngay-khai-truong') || path.includes('/khai-truong')) return 'khai-truong';
        if (path.includes('/xem-ngay-dong-tho') || path.includes('/dong-tho')) return 'dong-tho';
        if (path.includes('/xem-ngay-nhap-trach') || path.includes('/nhap-trach')) return 'nhap-trach';
        if (path.includes('/xem-ngay-xuat-hanh') || path.includes('/xuat-hanh')) return 'xuat-hanh';
        if (path.includes('/xem-ngay-mua-xe') || path.includes('/mua-xe')) return 'mua-xe';
        if (path.includes('/xem-ngay-thi-cu-phong-van') || path.includes('/thi-cu')) return 'thi-cu';
        if (path.includes('/xem-ngay-ky-hop-dong') || path.includes('/ky-hop-dong')) return 'ky-hop-dong';
        if (path.includes('/xem-ngay-cai-tang') || path.includes('/cai-tang')) return 'cai-tang';
        if (path.includes('/xem-ngay-doi-ban-tho') || path.includes('/ban-tho')) return 'ban-tho';
        if (path.includes('/xem-ngay-lap-ban-tho') || path.includes('/lap-ban-tho')) return 'lap-ban-tho';
        if (path.includes('/xem-ngay-cung-sao-giai-han') || path.includes('/giai-han')) return 'giai-han';
        if (path.includes('/xem-ngay-tran-trach') || path.includes('/tran-trach')) return 'tran-trach';
        if (path.includes('/xem-ngay-cau-an-lam-phuc') || path.includes('/phong-sinh')) return 'phong-sinh';
        if (path.includes('/xem-ngay-nhan-cong-viec-moi') || path.includes('/cong-viec-moi')) return 'cong-viec-moi';
        if (path.includes('/xem-ngay-lam-giay-to') || path.includes('/giay-to')) return 'giay-to';
        return 'default';
    }

    // Lưu trạng thái filter vào localStorage theo từng tool riêng biệt
    function saveFilterState() {
        const selectedTaboos = [...new Set(Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value))];

        // Lấy tên tool và tạo key riêng cho từng tool
        const toolName = getCurrentToolName();
        const storageKey = `tabooFilter_${toolName}`;

        // Lưu vào localStorage theo tool
        if (selectedTaboos.length > 0) {
            localStorage.setItem(storageKey, JSON.stringify(selectedTaboos));
        } else {
            localStorage.removeItem(storageKey);
        }

        // Không cần lưu vào URL vì đã có localStorage
    }

    // Khôi phục trạng thái filter từ localStorage theo tool cụ thể
    function restoreFilterState() {
        let selectedTaboos = [];

        // Chỉ sử dụng localStorage, không dùng URL parameters
        const toolName = getCurrentToolName();
        const storageKey = `tabooFilter_${toolName}`;
        const savedFilter = localStorage.getItem(storageKey);

        if (savedFilter) {
            try {
                selectedTaboos = JSON.parse(savedFilter);
            } catch (e) {
                console.log('Error parsing saved filter for', toolName, ':', e);
                selectedTaboos = [];
            }
        }

        if (selectedTaboos.length > 0) {
            console.log('Restoring filter state for', getCurrentToolName(), ':', selectedTaboos);

            // Đợi UI được render hoàn toàn
            const waitForCheckboxes = (attempts = 0) => {
                const checkboxes = document.querySelectorAll('.taboo-checkbox');

                if (checkboxes.length > 0 || attempts > 20) {
                    // Khôi phục checkbox states
                    checkboxes.forEach(cb => {
                        cb.checked = selectedTaboos.includes(cb.value);
                    });

                    // Áp dụng filter tự động với delay để đảm bảo data đã load
                    setTimeout(() => {
                        applyFilterWithValues(selectedTaboos);
                    }, 300);

                    updateFilterBadge();
                } else {
                    // Retry sau 200ms
                    setTimeout(() => waitForCheckboxes(attempts + 1), 200);
                }
            };

            waitForCheckboxes();
        }
    }

    // Hàm áp dụng filter với giá trị cho trước (không cần modal)
    function applyFilterWithValues(selectedTaboos) {
        if (selectedTaboos.length === 0) return;

        let totalFiltered = 0;
        let totalDays = 0;

        // Lọc cho từng năm
        Object.keys(resultsByYear).forEach(year => {
            const originalDays = originalData[year];
            totalDays += originalDays.length;

            const filteredDays = originalDays.filter(day => {
                const hasTabooResult = hasTaboo(day, selectedTaboos);
                return !hasTabooResult;
            });
            totalFiltered += (originalDays.length - filteredDays.length);

            // Cập nhật dữ liệu hiện tại
            currentFilteredData[year] = filteredDays;

            updateTable(year, filteredDays);
        });

        // Hiển thị trạng thái cho cả per-year và global filter status
        let totalDaysOriginal = 0;
        let totalDaysFiltered = 0;
        let totalDaysRemaining = 0;

        Object.keys(resultsByYear).forEach(year => {
            const currentYearDays = originalData[year]?.length || 0;
            const currentYearFiltered = (originalData[year]?.length || 0) - (currentFilteredData[year]?.length || 0);
            const currentYearRemaining = currentFilteredData[year]?.length || 0;

            totalDaysOriginal += currentYearDays;
            totalDaysFiltered += currentYearFiltered;
            totalDaysRemaining += currentYearRemaining;

            // Per-year filter status
            const filterStatus = document.getElementById(`filterStatus-${year}`);
            const filterStatusText = document.getElementById(`filterStatusText-${year}`);

            if (filterStatus && filterStatusText) {
                filterStatus.classList.remove('d-none');
                filterStatusText.textContent = `Đã lọc ${currentYearFiltered} ngày có ${selectedTaboos.join(', ')} trong năm ${year}. Hiển thị ${currentYearRemaining}/${currentYearDays} ngày.`;
            }
        });

        // Global filter status
        const globalFilterStatus = document.getElementById('filterStatus');
        const globalFilterStatusText = document.getElementById('filterStatusText');

        if (globalFilterStatus && globalFilterStatusText) {
            globalFilterStatus.classList.remove('d-none');

            if (Object.keys(resultsByYear).length > 1) {
                globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${selectedTaboos.join(', ')} trong ${Object.keys(resultsByYear).length} năm. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
            } else {
                globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${selectedTaboos.join(', ')}. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
            }
        }
    }

    // Khởi tạo modal filter
    setupModalFilter();

    // Khởi tạo tab switch listener
    setupTabSwitchListener();

    // Khôi phục trạng thái filter khi trang load - tăng thời gian chờ
    setTimeout(() => {
        restoreFilterState();
    }, 800);

    // Thêm listener cho sự kiện quay lại từ trang khác
    window.addEventListener('pageshow', function(event) {
        // Nếu trang được load từ cache (quay lại từ trang khác)
        if (event.persisted) {
            setTimeout(() => {
                restoreFilterState();
            }, 300);
        }
    });
  

    // Thêm listener cho tab switching để cập nhật filter status và áp dụng sort
    function setupTabSwitchListener() {
        const tabLinks = document.querySelectorAll('.nav-pills .nav-link');
        tabLinks.forEach(tabLink => {
            tabLink.addEventListener('click', function() {
                // Delay để đợi tab switching hoàn tất
                setTimeout(() => {
                    // Lấy tab năm hiện tại đang active
                    const activeTab = document.querySelector('.tab-pane.show.active');
                    if (activeTab) {
                        const activeYear = activeTab.id.replace('year-', '');
                        console.log('Tab switched to year:', activeYear);

                        // Kiểm tra xem có filter nào đang active không
                        const selectedTaboos = [...new Set(Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value))];

                        if (selectedTaboos.length > 0) {
                            console.log('Reapplying filter for year', activeYear, 'with taboos:', selectedTaboos);

                            // Luôn áp dụng lại filter cho tab mới để đảm bảo đồng bộ
                            const originalDays = originalData[activeYear];
                            if (originalDays && originalDays.length > 0) {
                                console.log(`Applying filter to year ${activeYear} with ${originalDays.length} original days`);

                                const filteredDays = originalDays.filter(day => {
                                    const hasTabooResult = hasTaboo(day, selectedTaboos);
                                    return !hasTabooResult;
                                });

                                currentFilteredData[activeYear] = filteredDays;
                                console.log('Filter reapplied to year', activeYear, '- filtered', originalDays.length - filteredDays.length, 'days, remaining:', filteredDays.length);

                                // Cập nhật table ngay lập tức
                                updateTable(activeYear, filteredDays);
                            } else {
                                console.warn(`No original data found for year ${activeYear}`, {
                                    originalData: originalData,
                                    activeYear: activeYear,
                                    originalDataForYear: originalData[activeYear]
                                });
                            }
                        }

                        // Áp dụng sort order hiện tại cho tab mới
                        const currentTabSortSelect = activeTab.querySelector('select[name="sort"]');
                        if (currentTabSortSelect && currentTabSortSelect.value !== 'desc') {
                            console.log('Applying current sort order', currentTabSortSelect.value, 'to year', activeYear);
                            applySortToYear(activeYear, currentTabSortSelect.value, true); // Thêm shouldScroll = true
                        } else {
                            // Nếu không có sort hoặc sort = default (desc), chỉ update table
                            updateTable(activeYear, currentFilteredData[activeYear]);
                            // Vẫn scroll xuống table để user thấy kết quả
                            setTimeout(() => {
                                scrollToTable(activeYear);
                            }, 200);
                        }
                    }

                    // Cập nhật filter status
                    updateFilterStatusForActiveTab();
                }, 150);
            });
        });

        // Thêm listener cho Bootstrap tab events để đảm bảo bắt được sự kiện tab switching
        const tabPanes = document.querySelectorAll('.tab-pane[id^="year-"]');
        tabPanes.forEach(tabPane => {
            tabPane.addEventListener('shown.bs.tab', function(event) {
                const activeYear = event.target.id.replace('year-', '');
                console.log('Bootstrap tab shown event for year:', activeYear);

                // Kiểm tra và áp dụng filter nếu cần
                const selectedTaboos = [...new Set(Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value))];

                if (selectedTaboos.length > 0) {
                    // Đảm bảo filter được áp dụng cho tab mới
                    setTimeout(() => {
                        const originalDays = originalData[activeYear];
                        if (originalDays) {
                            const filteredDays = originalDays.filter(day => {
                                const hasTabooResult = hasTaboo(day, selectedTaboos);
                                return !hasTabooResult;
                            });

                            currentFilteredData[activeYear] = filteredDays;
                            console.log('Bootstrap tab event: Filter reapplied to year', activeYear, '- filtered', originalDays.length - filteredDays.length, 'days');

                            // Cập nhật table ngay lập tức
                            updateTable(activeYear, filteredDays);
                        }

                        // Áp dụng sort order hiện tại
                        const currentTabPane = document.getElementById(`year-${activeYear}`);
                        const currentTabSortSelect = currentTabPane ? currentTabPane.querySelector('select[name="sort"]') : null;
                        if (currentTabSortSelect && currentTabSortSelect.value !== 'desc') {
                            applySortToYear(activeYear, currentTabSortSelect.value, true); // Thêm shouldScroll = true
                        } else {
                            // Scroll xuống table ngay cả khi không có sort
                            setTimeout(() => {
                                scrollToTable(activeYear);
                            }, 200);
                        }

                        updateFilterStatusForActiveTab();
                    }, 100);
                }
            });
        });
    }

    // Helper function để áp dụng sort cho một năm cụ thể
    function applySortToYear(year, sortOrder, shouldScroll = false) {
        if (!currentFilteredData[year] || currentFilteredData[year].length === 0) {
            console.log(`No data for year ${year} to sort`);
            return;
        }

        const sortedDays = [...currentFilteredData[year]];

        sortedDays.sort((a, b) => {
            // Kiểm tra xem có sắp xếp theo ngày không
            if (sortOrder === 'date_asc' || sortOrder === 'date_desc') {
                // Sắp xếp theo ngày
                const dateA = new Date(a.date);
                const dateB = new Date(b.date);
                return sortOrder === 'date_asc' ? dateA - dateB : dateB - dateA;
            }

            // Sắp xếp theo điểm số từ nhiều cấu trúc dữ liệu khác nhau
            let scoreA = 0;
            let scoreB = 0;

            // Cấu trúc từ FunctionHelper (xuất hành): day_score.score.percentage
            if (a.day_score?.score?.percentage !== undefined) {
                scoreA = a.day_score.score.percentage;
            }
            // Cấu trúc từ GoodBadDayHelper (mua xe): day_score.percentage
            else if (a.day_score?.percentage !== undefined) {
                scoreA = a.day_score.percentage;
            }
            // Wedding tool - dual score structure
            else if (a.groom_score && a.bride_score) {
                const groomScoreA = a.groom_score.percentage || 0;
                const brideScoreA = a.bride_score.percentage || 0;
                scoreA = (groomScoreA + brideScoreA) / 2;
            }
            // Cấu trúc cũ: score trực tiếp
            else if (a.score !== undefined) {
                scoreA = a.score;
            }
            // Fallback: percentage trực tiếp
            else if (a.percentage !== undefined) {
                scoreA = a.percentage;
            }

            if (b.day_score?.score?.percentage !== undefined) {
                scoreB = b.day_score.score.percentage;
            }
            else if (b.day_score?.percentage !== undefined) {
                scoreB = b.day_score.percentage;
            }
            else if (b.groom_score && b.bride_score) {
                const groomScoreB = b.groom_score.percentage || 0;
                const brideScoreB = b.bride_score.percentage || 0;
                scoreB = (groomScoreB + brideScoreB) / 2;
            }
            else if (b.score !== undefined) {
                scoreB = b.score;
            }
            else if (b.percentage !== undefined) {
                scoreB = b.percentage;
            }

            return sortOrder === 'desc' ? scoreB - scoreA : scoreA - scoreB;
        });

        console.log(`Applied sort ${sortOrder} to year ${year}, length: ${sortedDays.length}`);

        // Cập nhật currentFilteredData với thứ tự mới
        currentFilteredData[year] = sortedDays;

        // Cập nhật hiển thị
        updateTable(year, sortedDays, true);

        // Auto-scroll xuống table nếu được yêu cầu
        if (shouldScroll) {
            setTimeout(() => {
                scrollToTable(year);
            }, 200);
        }
    }

    // Helper function để scroll xuống table của một năm cụ thể
    function scrollToTable(year) {
        // Tìm tab pane của năm cụ thể trước
        const activeTabPane = document.querySelector(`#year-${year}`);

        if (!activeTabPane) {
            console.log(`Tab pane not found for year ${year}`);
            return;
        }

        // Tìm table trong tab pane của năm cụ thể
        const tableContainer = activeTabPane.querySelector(`#table-${year}`) ||
                              activeTabPane.querySelector('.table-responsive') ||
                              activeTabPane.querySelector('#bang-chi-tiet');

        if (tableContainer) {
            console.log(`Scrolling to table for year ${year}`);
            tableContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            console.log(`Table container not found for year ${year} in its tab pane`);

            // Fallback: scroll đến tab pane nếu không tìm thấy table
            activeTabPane.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Hàm cập nhật filter status cho tất cả tabs
    function updateFilterStatusForActiveTab() {
        const selectedTaboos = [...new Set(Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value))];

        if (selectedTaboos.length === 0) {
            // Ẩn tất cả filter status nếu không có filter
            Object.keys(resultsByYear).forEach(year => {
                const filterStatus = document.getElementById(`filterStatus-${year}`);
                if (filterStatus) {
                    filterStatus.classList.add('d-none');
                }
            });

            // Ẩn global filter status
            const globalFilterStatus = document.getElementById('filterStatus');
            if (globalFilterStatus) {
                globalFilterStatus.classList.add('d-none');
            }
            return;
        }

        // Cập nhật filter status cho cả per-year và global
        let totalDaysOriginal = 0;
        let totalDaysFiltered = 0;
        let totalDaysRemaining = 0;

        Object.keys(resultsByYear).forEach(year => {
            const currentYearDays = originalData[year]?.length || 0;
            const currentYearFiltered = (originalData[year]?.length || 0) - (currentFilteredData[year]?.length || 0);
            const currentYearRemaining = currentFilteredData[year]?.length || 0;

            totalDaysOriginal += currentYearDays;
            totalDaysFiltered += currentYearFiltered;
            totalDaysRemaining += currentYearRemaining;

            // Per-year filter status
            const filterStatus = document.getElementById(`filterStatus-${year}`);
            const filterStatusText = document.getElementById(`filterStatusText-${year}`);

            if (filterStatus && filterStatusText) {
                filterStatus.classList.remove('d-none');

                // Tính số ngày đang hiển thị thực tế bằng cách đếm rows visible trong DOM
                const targetTab = document.querySelector(`#year-${year}`);
                let actualVisibleCount = 10; // fallback default

                if (targetTab) {
                    const table = targetTab.querySelector('#bang-chi-tiet table tbody');
                    if (table) {
                        // Lấy tất cả rows, loại trừ các rows không mong muốn
                        const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                        const visibleRows = Array.from(allRows).filter(row => {
                            const style = window.getComputedStyle(row);
                            const isVisible = row.style.display !== 'none' &&
                                            style.display !== 'none' &&
                                            !row.classList.contains('d-none') &&
                                            !row.hasAttribute('hidden');
                            return isVisible;
                        });

                        actualVisibleCount = visibleRows.length;
                        console.log(`DEBUG UPDATEFILTER: Year ${year} - Total: ${allRows.length}, Visible: ${actualVisibleCount}`);
                    }
                }

                const currentVisibleCount = actualVisibleCount;

                // Ensure unique taboo names in message
                const uniqueTaboos = [...new Set(selectedTaboos)];
                filterStatusText.textContent = `Đã lọc ${currentYearFiltered} ngày có ${uniqueTaboos.join(', ')} trong năm ${year}. Hiển thị ${currentVisibleCount}/${currentYearDays} ngày.`;
            }
        });

        // Global filter status
        const globalFilterStatus = document.getElementById('filterStatus');
        const globalFilterStatusText = document.getElementById('filterStatusText');

        if (globalFilterStatus && globalFilterStatusText) {
            globalFilterStatus.classList.remove('d-none');

            const uniqueTaboos = [...new Set(selectedTaboos)];
            if (Object.keys(resultsByYear).length > 1) {
                globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${uniqueTaboos.join(', ')} trong ${Object.keys(resultsByYear).length} năm. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
            } else {
                globalFilterStatusText.textContent = `Đã lọc ${totalDaysFiltered} ngày có ${uniqueTaboos.join(', ')}. Hiển thị ${totalDaysRemaining}/${totalDaysOriginal} ngày.`;
            }
        }
    }

    // Tích hợp với bộ lọc sắp xếp hiện tại - Updated to work with all sort controls
    // Chỉ setup sort handler của taboo filter nếu không có hệ thống sort cũ
    const hasLegacySortSystem = document.querySelector('.--detail-success');

    if (!hasLegacySortSystem) {
        const sortSelects = document.querySelectorAll('select[name="sort"]'); // Tìm tất cả select sort
        console.log('Sort selects found:', sortSelects.length);

        sortSelects.forEach((sortSelect, index) => {
            console.log(`Setting up sort handler for sort control ${index + 1}...`);
            // Remove any existing listeners
            sortSelect.removeEventListener('change', sortSelect._tabooSortHandler);

            sortSelect._tabooSortHandler = function() {
                const sortOrder = this.value;
                console.log('Sort triggered with order:', sortOrder, 'from select', index + 1);

                // Tìm tab chứa dropdown sort này
                const parentTabPane = this.closest('.tab-pane');
                if (parentTabPane) {
                    const activeYear = parentTabPane.id.replace('year-', '');
                    console.log(`Processing year ${activeYear} from its own sort dropdown`);

                    // Đồng bộ tất cả dropdown sort khác về cùng giá trị
                    sortSelects.forEach(otherSelect => {
                        if (otherSelect !== this) {
                            otherSelect.value = sortOrder;
                        }
                    });

                    applySortToYear(activeYear, sortOrder, true); // Thêm shouldScroll = true

                    // Cập nhật filter status sau khi sort
                    updateFilterStatusForActiveTab();
                } else {
                    console.log('No parent tab pane found for this sort select');
                }
            };

            sortSelect.addEventListener('change', sortSelect._tabooSortHandler);
            console.log(`Sort handler attached successfully to sort control ${index + 1}`);
        });

        if (sortSelects.length === 0) {
            console.log('No sort select elements found');
        }
    } else {
        console.log('Legacy sort system detected, skipping taboo filter sort setup');
    }

    // Setup load more handler
    setupLoadMoreHandler();
}

// Expose initTabooFilter ra global scope để có thể gọi từ index.blade.php
window.initTabooFilter = initTabooFilter;

// Global functions để có thể gọi từ dropdown buttons
function applyFilter() {
    const applyBtn = document.getElementById('applyTabooFilter');
    if (applyBtn && applyBtn._tabooHandler) {
        applyBtn._tabooHandler();
    }
}

// Function để update filter status khi pagination thay đổi
function updateFilterStatusOnPagination(year) {
    const selectedTaboos = [...new Set(Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value))];

    if (selectedTaboos.length === 0) return;

    const filterStatus = document.getElementById(`filterStatus-${year}`);
    const filterStatusText = document.getElementById(`filterStatusText-${year}`);

    // Use global reference to avoid scope issues
    const tabooData = window.tabooFilterData;
    if (!tabooData || !tabooData.originalData || !tabooData.currentFilteredData) {
        console.warn(`tabooFilterData not available for year ${year}`);
        return;
    }

    const originalData = tabooData.originalData;
    const currentFilteredData = tabooData.currentFilteredData;

    if (filterStatus && filterStatusText && originalData[year] && currentFilteredData[year]) {
        const currentYearDays = originalData[year].length;
        const currentYearFiltered = originalData[year].length - currentFilteredData[year].length;
        const currentYearRemaining = currentFilteredData[year].length;

        // Đếm thực tế số rows visible trong DOM
        const targetTab = document.querySelector(`#year-${year}`);
        let actualVisibleCount = 10; // fallback default

        if (targetTab) {
            const table = targetTab.querySelector('#bang-chi-tiet table tbody');
            if (table) {
                // Lấy tất cả rows, loại trừ các rows không mong muốn
                const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
                const visibleRows = Array.from(allRows).filter(row => {
                    const style = window.getComputedStyle(row);
                    const isVisible = row.style.display !== 'none' &&
                                    style.display !== 'none' &&
                                    !row.classList.contains('d-none') &&
                                    !row.hasAttribute('hidden');
                    return isVisible;
                });

                actualVisibleCount = visibleRows.length;
                console.log(`DEBUG PAGINATION: Year ${year} - Total: ${allRows.length}, Visible: ${actualVisibleCount}`);
                console.log(`- Visible dates sample:`, visibleRows.slice(0, 3).map(row => row.textContent.match(/\d{1,2}\/\d{1,2}\/\d{4}/)?.[0] || 'No date'));
            }
        }

        const uniqueTaboos = [...new Set(selectedTaboos)];
        filterStatusText.textContent = `Đã lọc ${currentYearFiltered} ngày có ${uniqueTaboos.join(', ')} trong năm ${year}. Hiển thị ${actualVisibleCount}/${currentYearDays} ngày.`;

        console.log(`Updated filter status for year ${year} on pagination: showing ${actualVisibleCount}/${currentYearRemaining} filtered days`);
    }
}

// Expose function globally để gọi từ pagination
window.updateFilterStatusOnPagination = updateFilterStatusOnPagination;

// Debug function để inspect DOM details
function debugDOMDetails(year) {
    console.log('=== debugDOMDetails called for year:', year);

    const targetTab = document.querySelector(`#year-${year}`);
    if (!targetTab) {
        console.log(`No tab found for year ${year}`);
        return;
    }

    const table = targetTab.querySelector('#bang-chi-tiet table tbody');
    if (!table) {
        console.log(`No table found for year ${year}`);
        return;
    }

    const allRows = table.querySelectorAll('tr:not(.empty-filter-row)');
    console.log(`=== DOM DEBUG for Year ${year} ===`);
    console.log(`Total rows: ${allRows.length}`);

    allRows.forEach((row, index) => {
        const style = window.getComputedStyle(row);
        const isVisible = row.style.display !== 'none' &&
                        style.display !== 'none' &&
                        !row.classList.contains('d-none') &&
                        !row.hasAttribute('hidden');

        const dateMatch = row.textContent.match(/\d{1,2}\/\d{1,2}\/\d{4}/);
        const date = dateMatch ? dateMatch[0] : 'No date';

        if (isVisible && index < 15) { // Show first 15 visible
            console.log(`Row ${index}: ${date} - VISIBLE`);
        } else if (!isVisible && index < 5) { // Show first 5 hidden
            console.log(`Row ${index}: ${date} - HIDDEN (display: ${row.style.display}, computed: ${style.display})`);
        }
    });

    const visibleCount = Array.from(allRows).filter(row => {
        const style = window.getComputedStyle(row);
        return row.style.display !== 'none' &&
               style.display !== 'none' &&
               !row.classList.contains('d-none') &&
               !row.hasAttribute('hidden');
    }).length;

    console.log(`=== SUMMARY: ${visibleCount} visible out of ${allRows.length} total ===`);
}

window.debugDOMDetails = debugDOMDetails;

function clearFilter() {
    const clearBtn = document.getElementById('clearTabooFilter');
    if (clearBtn && clearBtn._tabooHandler) {
        clearBtn._tabooHandler();
    }
}
</script>