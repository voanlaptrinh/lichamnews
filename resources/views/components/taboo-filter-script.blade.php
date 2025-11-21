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

    if (!resultsByYear) {
        console.log('No resultsByYear data, returning');
        return;
    }

    console.log('initTabooFilter called with data:', resultsByYear);

    let originalData = {}; // Lưu dữ liệu gốc
    let currentFilteredData = {}; // Dữ liệu sau khi lọc

    // Lưu dữ liệu gốc cho mỗi năm
    Object.keys(resultsByYear).forEach(year => {
        originalData[year] = [...resultsByYear[year].days];
        currentFilteredData[year] = [...resultsByYear[year].days];
    });

    // Hàm kiểm tra xem ngày có chứa taboo không - Phiên bản hybrid tương thích
    function hasTaboo(day, tabooNames) {
        // Kiểm tra trong wedding tool - dual score structure (groom_score và bride_score)
        if (day.groom_score && day.bride_score) {
            console.log('Wedding tool detected, checking groom_score and bride_score for taboos:', tabooNames);
            // Kiểm tra trong groom_score
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

            // Kiểm tra trong bride_score
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
    function updateTable(year, filteredDays) {
        // Tìm tbody theo nhiều selector để tương thích
        let tbody = document.querySelector(`.table-body-${year}`); // Selector mới
        if (!tbody) {
            tbody = document.querySelector(`#table-${year} tbody`); // Selector fallback
        }
        if (!tbody) {
            tbody = document.querySelector('.table tbody'); // Selector tổng quát
        }
        if (!tbody) {
            console.warn(`Không tìm thấy tbody cho năm ${year}`);
            return;
        }

        // Lấy số lượng hiện tại đang hiển thị để duy trì pagination
        const loadMoreBtn = tbody.closest('.card-body')?.querySelector('.load-more-btn');
        let currentLoaded = 10; // Default
        if (loadMoreBtn && loadMoreBtn.dataset.loaded) {
            currentLoaded = parseInt(loadMoreBtn.dataset.loaded) || 10;
        }

        // Lấy tất cả row hiện tại (từ blade template gốc)
        const allRows = Array.from(tbody.querySelectorAll('tr:not(.empty-filter-row)'));

        // Tạo set các index của ngày được hiển thị
        const filteredIndexes = new Set();
        filteredDays.forEach((filteredDay) => {
            // Tìm index trong dữ liệu gốc dựa trên so sánh ngày
            const originalIndex = originalData[year].findIndex(originalDay => {
                // So sánh ngày - có thể cần format khác nhau
                if (filteredDay.date && originalDay.date) {
                    // Chuyển về string để so sánh
                    const filteredDateStr = new Date(filteredDay.date).toDateString();
                    const originalDateStr = new Date(originalDay.date).toDateString();
                    return filteredDateStr === originalDateStr;
                }
                return false;
            });
            if (originalIndex !== -1) {
                filteredIndexes.add(originalIndex);
            }
        });

        // Ẩn/hiện các row với pagination
        let visibleCount = 0;
        allRows.forEach((row, index) => {
            if (filteredIndexes.has(index)) {
                // Row thuộc filter results
                if (visibleCount < currentLoaded) {
                    row.style.display = '';  // Hiển thị theo pagination
                    row.dataset.visible = 'true';
                    visibleCount++;
                } else {
                    row.style.display = 'none';  // Ẩn nếu vượt quá pagination
                    row.dataset.visible = 'false';
                }
            } else {
                row.style.display = 'none';  // Ẩn vì không thuộc filter
                row.dataset.visible = 'false';
            }
        });

        // Cập nhật load more button với filtered results
        if (loadMoreBtn) {
            const totalFiltered = filteredIndexes.size;
            // Sử dụng filteredDays.length thay vì filteredIndexes.size để đảm bảo đúng số lượng
            const actualTotal = filteredDays.length;
            loadMoreBtn.dataset.loaded = Math.min(currentLoaded, actualTotal).toString();
            loadMoreBtn.dataset.total = actualTotal.toString();

            const remaining = actualTotal - Math.min(currentLoaded, actualTotal);
            if (remaining > 0 && actualTotal > currentLoaded) {
                loadMoreBtn.style.display = '';
                loadMoreBtn.innerHTML = `
                    <i class="bi bi-plus-circle me-2"></i>
                    Xem thêm ${Math.min(10, remaining)} bảng
                    <span class="text-muted ms-2">(${remaining} còn lại)</span>
                `;
            } else {
                loadMoreBtn.style.display = 'none';
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
    }

    // Xử lý modal filter
    const setupModalFilter = () => {
        const filterBtn = document.getElementById('tabooFilterBtn');
        const modal = document.getElementById('tabooFilterModal');
        const backdrop = document.getElementById('tabooFilterBackdrop');
        const closeBtn = document.getElementById('closeFilterModal');
        const badge = document.getElementById('filterBadge');


        // Mở modal
        if (filterBtn) {
           
            filterBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

             
                modal.classList.remove('d-none');
                backdrop.classList.remove('d-none');
                // document.body.classList.add('menu-open');

                return false;
            });
        } else {
            console.log('Filter button NOT found');
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

    // Xử lý áp dụng filter taboo
    const applyBtn = document.getElementById('applyTabooFilter');
    if (applyBtn) {
        // Remove any existing listeners
        applyBtn.removeEventListener('click', applyBtn._tabooHandler);

        applyBtn._tabooHandler = function() {
            const selectedTaboos = Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value);

            if (selectedTaboos.length === 0) {
                alert('Vui lòng chọn ít nhất một loại taboo để lọc');
                return;
            }

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

            // Lưu trạng thái filter
            saveFilterState();

            // Hiển thị trạng thái
            const filterStatus = document.getElementById('filterStatus');
            const filterStatusText = document.getElementById('filterStatusText');
            if (filterStatus && filterStatusText) {
                filterStatus.classList.remove('d-none');
                filterStatusText.textContent = `Đã lọc ${totalFiltered} ngày có ${selectedTaboos.join(', ')}. Hiển thị ${totalDays - totalFiltered}/${totalDays} ngày.`;
            }

            // Đóng modal sau khi áp dụng
            const modal = document.getElementById('tabooFilterModal');
            const backdrop = document.getElementById('tabooFilterBackdrop');
            if (modal) modal.classList.add('d-none');
            if (backdrop) backdrop.classList.add('d-none');

            // Scroll đến bảng điểm
            const resultTable = document.querySelector('.table-responsive');
            if (resultTable) {
                resultTable.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

            // Khôi phục hiển thị tất cả row cho tất cả năm
            Object.keys(resultsByYear).forEach(year => {
                const tbody = document.querySelector(`.table-body-${year}`);
                if (tbody) {
                    // Hiển thị lại tất cả row gốc
                    const allRows = tbody.querySelectorAll('tr:not(.empty-filter-row)');
                    allRows.forEach(row => {
                        row.style.display = '';
                    });

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

            // Ẩn trạng thái
            const filterStatus = document.getElementById('filterStatus');
            if (filterStatus) {
                filterStatus.classList.add('d-none');
            }

            // Đóng modal
            const modal = document.getElementById('tabooFilterModal');
            const backdrop = document.getElementById('tabooFilterBackdrop');
            if (modal) modal.classList.add('d-none');
            if (backdrop) backdrop.classList.add('d-none');

            // Scroll đến bảng điểm
            const resultTable = document.querySelector('.table-responsive');
            if (resultTable) {
                resultTable.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        clearBtn.addEventListener('click', clearBtn._tabooHandler);
    }

    // ========== LƯU VÀ KHÔI PHỤC TRẠNG THÁI FILTER ==========

    // Lấy tên tool từ URL để tách biệt storage giữa các tool
    function getCurrentToolName() {
        const path = window.location.pathname;
        // Danh sách đầy đủ các tools theo routes
        if (path.includes('/xem-ngay-tot-xau') || path.includes('/tot-xau')) return 'tot-xau';
        if (path.includes('/xem-ngay-mua-nha') || path.includes('/mua-nha')) return 'mua-nha';
        if (path.includes('/xem-ngay-ket-hon') || path.includes('/ket-hon')) return 'ket-hon';
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
        const selectedTaboos = Array.from(document.querySelectorAll('.taboo-checkbox:checked')).map(cb => cb.value);

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

        // Hiển thị trạng thái
        const filterStatus = document.getElementById('filterStatus');
        const filterStatusText = document.getElementById('filterStatusText');
        if (filterStatus && filterStatusText) {
            filterStatus.classList.remove('d-none');
            filterStatusText.textContent = `Đã lọc ${totalFiltered} ngày có ${selectedTaboos.join(', ')}. Hiển thị ${totalDays - totalFiltered}/${totalDays} ngày.`;
        }
    }

    // Khởi tạo modal filter
    setupModalFilter();

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
  

    // Tích hợp với bộ lọc sắp xếp hiện tại
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        // Remove any existing listeners
        sortSelect.removeEventListener('change', sortSelect._tabooSortHandler);

        sortSelect._tabooSortHandler = function() {
            const sortOrder = this.value;

            Object.keys(currentFilteredData).forEach(year => {
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

                    // Wedding tool - dual score structure: tính điểm trung bình của groom và bride
                    if (a.groom_score && a.bride_score) {
                        const groomScoreA = a.groom_score.percentage || 0;
                        const brideScoreA = a.bride_score.percentage || 0;
                        scoreA = (groomScoreA + brideScoreA) / 2;
                    }
                    // Ưu tiên: cấu trúc từ FunctionHelper (xuất hành): day_score.score.percentage
                    else if (a.day_score?.score?.percentage !== undefined) {
                        scoreA = a.day_score.score.percentage;
                    }
                    // Cấu trúc từ GoodBadDayHelper (mua xe): day_score.percentage
                    else if (a.day_score?.percentage !== undefined) {
                        scoreA = a.day_score.percentage;
                    }
                    // Cấu trúc cũ: score trực tiếp
                    else if (a.score !== undefined) {
                        scoreA = a.score;
                    }
                    // Fallback: percentage trực tiếp
                    else if (a.percentage !== undefined) {
                        scoreA = a.percentage;
                    }

                    // Wedding tool - dual score structure: tính điểm trung bình của groom và bride
                    if (b.groom_score && b.bride_score) {
                        const groomScoreB = b.groom_score.percentage || 0;
                        const brideScoreB = b.bride_score.percentage || 0;
                        scoreB = (groomScoreB + brideScoreB) / 2;
                    }
                    else if (b.day_score?.score?.percentage !== undefined) {
                        scoreB = b.day_score.score.percentage;
                    }
                    else if (b.day_score?.percentage !== undefined) {
                        scoreB = b.day_score.percentage;
                    }
                    else if (b.score !== undefined) {
                        scoreB = b.score;
                    }
                    else if (b.percentage !== undefined) {
                        scoreB = b.percentage;
                    }

                    return sortOrder === 'desc' ? scoreB - scoreA : scoreA - scoreB;
                });

                updateTable(year, sortedDays);
            });
        };

        sortSelect.addEventListener('change', sortSelect._tabooSortHandler);
    }
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

function clearFilter() {
    const clearBtn = document.getElementById('clearTabooFilter');
    if (clearBtn && clearBtn._tabooHandler) {
        clearBtn._tabooHandler();
    }
}
</script>