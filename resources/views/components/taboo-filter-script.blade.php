{{-- JavaScript logic cho taboo filter --}}
<script>
// ========== TABOO FILTER FUNCTIONS ==========
function initTabooFilter(resultsByYear) {

    if (!resultsByYear) {
        console.log('No resultsByYear data, returning');
        return;
    }

    let originalData = {}; // Lưu dữ liệu gốc
    let currentFilteredData = {}; // Dữ liệu sau khi lọc

    // Lưu dữ liệu gốc cho mỗi năm
    Object.keys(resultsByYear).forEach(year => {
        originalData[year] = [...resultsByYear[year].days];
        currentFilteredData[year] = [...resultsByYear[year].days];
    });

    // Hàm kiểm tra xem ngày có chứa taboo không
    function hasTaboo(day, tabooNames) {
        // Kiểm tra trong day_score.score.issues (cấu trúc mới)
        if (day.day_score?.score?.issues && Array.isArray(day.day_score.score.issues)) {
            const found = day.day_score.score.issues.some(issue => {
                if (issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trong day_score.issues (fallback)
        if (day.day_score?.issues && Array.isArray(day.day_score.issues)) {
            const found = day.day_score.issues.some(issue => {
                if (issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                return false;
            });
            if (found) return true;
        }

        // Kiểm tra trong day.issues (fallback cũ)
        if (day.issues && Array.isArray(day.issues)) {
            return day.issues.some(issue => {
                if (issue.details && issue.details.tabooName) {
                    return tabooNames.includes(issue.details.tabooName);
                }
                return false;
            });
        }

        return false;
    }

    // Hàm cập nhật hiển thị table
    function updateTable(year, filteredDays) {
        const tbody = document.querySelector(`.table-body-${year}`);
        if (!tbody) return;

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

        // Ẩn/hiện các row
        allRows.forEach((row, index) => {
            if (filteredIndexes.has(index)) {
                row.style.display = '';  // Hiển thị
            } else {
                row.style.display = 'none';  // Ẩn
            }
        });

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
                // Chọn các taboo phổ biến
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

                const filteredDays = originalDays.filter(day => !hasTaboo(day, selectedTaboos));
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

    // Khởi tạo modal filter

    setupModalFilter();
  

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
                    const scoreA = a.day_score?.score?.percentage ?? a.day_score?.percentage ?? 0;
                    const scoreB = b.day_score?.score?.percentage ?? b.day_score?.percentage ?? 0;

                    return sortOrder === 'desc' ? scoreB - scoreA : scoreA - scoreB;
                });

                updateTable(year, sortedDays);
            });
        };

        sortSelect.addEventListener('change', sortSelect._tabooSortHandler);
    }
}
</script>