<script>
/**
 * Next Year Button Handler Module
 * Xử lý logic hiển thị và chuyển tab cho nút "Xem năm tiếp theo"
 */
window.NextYearButtonHandler = (function() {
    'use strict';

    let isInitialized = false;

    // Hiển thị nút "Xem năm tiếp theo"
    function showNextYearButton(year, source = 'unknown') {
        const container = document.getElementById(`next-year-container-${year}`);
        if (container) {
            container.style.display = 'block';
            console.log(`Showing next year button for year ${year} (from ${source})`);
            return true;
        }
        return false;
    }

    // Ẩn nút "Xem năm tiếp theo"
    function hideNextYearButton(year, source = 'unknown') {
        const container = document.getElementById(`next-year-container-${year}`);
        if (container) {
            container.style.display = 'none';
            console.log(`Hiding next year button for year ${year} (from ${source})`);
            return true;
        }
        return false;
    }

    // Xử lý logic khi nút "Xem thêm" thay đổi trạng thái
    function handleLoadMoreButtonChange(year, hasMoreData, source = 'unknown') {
        if (hasMoreData) {
            hideNextYearButton(year, source);
        } else {
            showNextYearButton(year, source);
        }
    }

    // Chuyển sang tab năm tiếp theo
    function switchToNextYear(currentYear, nextYear, source = 'unknown') {
        console.log(`Switching from year ${currentYear} to ${nextYear} (from ${source})`);

        const nextYearTabLink = document.querySelector(`a[href="#year-${nextYear}"]`);
        if (!nextYearTabLink) {
            console.log(`Tab link not found for year ${nextYear}`);
            return false;
        }

        // Kích hoạt tab mới
        nextYearTabLink.click();

        // Scroll xuống table sau khi chuyển tab
        setTimeout(() => {
            const nextYearTabPane = document.querySelector(`#year-${nextYear}`);
            if (nextYearTabPane && nextYearTabPane.classList.contains('active')) {
                const table = nextYearTabPane.querySelector('#bang-chi-tiet') ||
                             nextYearTabPane.querySelector('.table-responsive') ||
                             nextYearTabPane.querySelector('table');
                if (table) {
                    table.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        }, 300);

        return true;
    }

    // Đồng bộ trạng thái tất cả nút
    function syncAllButtonStates() {
        // Tìm tất cả container nút "Xem năm tiếp theo" để lấy danh sách năm
        const nextYearContainers = document.querySelectorAll('[id^="next-year-container-"]');

        nextYearContainers.forEach(container => {
            const year = container.id.replace('next-year-container-', '');
            const loadMoreBtn = document.querySelector(`.load-more-btn[data-year="${year}"]`);

            if (!loadMoreBtn) {
                // Không có nút "Xem thêm" → hiển thị nút "Xem năm tiếp theo"
                showNextYearButton(year, 'sync-no-pagination');
            } else {
                const loaded = parseInt(loadMoreBtn.dataset.loaded) || 10;
                const total = parseInt(loadMoreBtn.dataset.total) || 0;
                const remaining = total - loaded;
                const isVisible = loadMoreBtn.style.display !== 'none' && remaining > 0;

                handleLoadMoreButtonChange(year, isVisible, 'sync-all');
            }
        });
    }

    // Khởi tạo event listeners
    function initialize() {
        if (isInitialized) return;

        // Xử lý click nút "Xem năm tiếp theo" - chỉ cần 1 listener duy nhất
        document.addEventListener('click', function(event) {
            if (event.target.closest('.next-year-btn')) {
                event.preventDefault();
                const btn = event.target.closest('.next-year-btn');
                const currentYear = btn.dataset.currentYear;
                const nextYear = btn.dataset.nextYear;

                switchToNextYear(currentYear, nextYear, 'click-handler');
            }
        });

        // Sync khi chuyển tab
        document.addEventListener('shown.bs.tab', function() {
            setTimeout(syncAllButtonStates, 100);
        });

        // Click trên nav-link (fallback)
        document.addEventListener('click', function(event) {
            if (event.target.matches('a[data-bs-toggle="pill"]') || event.target.closest('a[data-bs-toggle="pill"]')) {
                setTimeout(syncAllButtonStates, 200);
            }
        });

        // Sync ban đầu
        setTimeout(syncAllButtonStates, 1000);

        isInitialized = true;
       


    }

    // Public API
    return {
        init: initialize,
        show: showNextYearButton,
        hide: hideNextYearButton,
        handleLoadMoreChange: handleLoadMoreButtonChange,
        switchToNext: switchToNextYear,
        syncAll: syncAllButtonStates
    };
})();

// Tự động khởi tạo khi DOM ready
document.addEventListener('DOMContentLoaded', function() {
    window.NextYearButtonHandler.init();
});
</script>