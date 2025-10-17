// JavaScript riêng cho trang lịch âm hôm nay và ngày mai - Optimized with BasePicker
// Khi chọn ngày sẽ redirect sang trang detai_home

class TodayTomorrowPicker extends BasePicker {
    constructor(config) {
        super(config);
    }

    init() {
        this.setupQuickPicker();
        this.setupNavigationButtons();
    }

    // Implementation required by BasePicker
    setupCalendarDayListeners(calendarDays, month, year) {
        // Use event delegation - single listener instead of multiple
        calendarDays.removeEventListener('click', this.calendarDayClickHandler);
        this.calendarDayClickHandler = async (e) => {
            const dayElement = e.target.closest('.calendar-day:not(.empty)');
            if (!dayElement) return;

            const day = parseInt(dayElement.dataset.day);
            const month = parseInt(dayElement.dataset.month);
            const year = parseInt(dayElement.dataset.year);

            // Remove selection from all days
            calendarDays.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
            dayElement.classList.add('selected');

            // Update selects quickly
            const solarDay = document.getElementById('solarDay');
            const solarMonth = document.getElementById('solarMonth');
            const solarYear = document.getElementById('solarYear');

            if (solarDay) solarDay.value = day;
            if (solarMonth) solarMonth.value = month;
            if (solarYear) solarYear.value = year;

            // Convert and update lunar date selects
            await this.convertSolarToLunar();

            // Close popup and redirect to detai_home route
            const quickPickerOverlay = document.getElementById('quickPickerOverlay');
            this.closePopup(quickPickerOverlay);

            // Redirect to detai_home route
            const detailUrl = `/lich-nam-${year}/thang-${month}/ngay-${day}`;
            window.location.href = detailUrl;
        };

        this.addEventListenerTracked(calendarDays, 'click', this.calendarDayClickHandler);
    }

    setupQuickPicker() {
        const quickPickerOverlay = document.getElementById('quickPickerOverlay');
        const quickPickerBtns = document.querySelectorAll('.quickPickerBtn');
        const closeQuickPicker = document.getElementById('closeQuickPicker');
        const viewDateBtn = document.getElementById('viewDateBtn');

        if (!quickPickerOverlay || quickPickerBtns.length === 0 || !closeQuickPicker || !viewDateBtn) {
            return; // Elements not found, skip setup
        }

        let currentPopupYear = this.currentYear;
        let currentPopupMonth = this.currentMonth;

        // Open popup - add event listener to all quick picker buttons
        quickPickerBtns.forEach(btn => {
            btn.addEventListener('click', async () => {
                // Lấy ngày hiện tại từ các nguồn có sẵn
                const currentDay = parseInt(document.getElementById('solarDay')?.value || this.currentDay);
                const currentMonth = parseInt(document.getElementById('solarMonth')?.value || this.currentMonth);
                const currentYear = parseInt(document.getElementById('solarYear')?.value || this.currentYear);

                // Cập nhật popup với ngày từ select
                currentPopupMonth = currentMonth;
                currentPopupYear = currentYear;

                // Cập nhật select dương lịch trong popup
                const popupSolarDay = document.getElementById('solarDay');
                const popupSolarMonth = document.getElementById('solarMonth');
                const popupSolarYear = document.getElementById('solarYear');

                if (popupSolarDay) popupSolarDay.value = currentDay;
                if (popupSolarMonth) popupSolarMonth.value = currentMonth;
                if (popupSolarYear) popupSolarYear.value = currentYear;

                // Convert solar to lunar and update lunar selects trong popup
                await this.updateLunarSelectsFromSolar(currentDay, currentMonth, currentYear);

                quickPickerOverlay.style.display = 'flex';
                setTimeout(() => quickPickerOverlay.classList.add('show'), 10);
                document.body.classList.add('modal-open');
                this.generatePopupCalendarOptimized(currentPopupMonth, currentPopupYear, currentDay);
            });
        });

        // Close popup
        closeQuickPicker.addEventListener('click', () => {
            this.closePopup(quickPickerOverlay);
        });

        // Close on overlay click
        quickPickerOverlay.addEventListener('click', (e) => {
            if (e.target === quickPickerOverlay) {
                this.closePopup(quickPickerOverlay);
            }
        });

        // Navigation buttons
        document.getElementById('prevMonthBtn').addEventListener('click', async () => {
            currentPopupMonth--;
            if (currentPopupMonth < 1) {
                currentPopupMonth = 12;
                currentPopupYear--;
            }
            this.updatePopupHeader(currentPopupMonth, currentPopupYear);
            await this.generatePopupCalendarOptimized(currentPopupMonth, currentPopupYear);
        });

        document.getElementById('nextMonthBtn').addEventListener('click', async () => {
            currentPopupMonth++;
            if (currentPopupMonth > 12) {
                currentPopupMonth = 1;
                currentPopupYear++;
            }
            this.updatePopupHeader(currentPopupMonth, currentPopupYear);
            await this.generatePopupCalendarOptimized(currentPopupMonth, currentPopupYear);
        });

        // Sync calendar when solar date selects change
        document.getElementById('solarDay').addEventListener('change', async () => {
            await this.convertSolarToLunar();
            await this.syncCalendarWithSolarDate();
        });
        document.getElementById('solarMonth').addEventListener('change', async () => {
            await this.convertSolarToLunar();
            await this.syncCalendarWithSolarDate();
        });
        document.getElementById('solarYear').addEventListener('change', async () => {
            await this.convertSolarToLunar();
            await this.syncCalendarWithSolarDate();
        });

        // Add event listeners for lunar date changes
        document.getElementById('lunarDay').addEventListener('change', async () => {
            await this.convertLunarToSolar();
        });
        document.getElementById('lunarMonth').addEventListener('change', async () => {
            await this.convertLunarToSolar();
        });
        document.getElementById('lunarYear').addEventListener('change', async () => {
            await this.convertLunarToSolar();
        });

        // View button click - redirect to detai_home
        viewDateBtn.addEventListener('click', () => {
            const solarDay = parseInt(document.getElementById('solarDay').value);
            const solarMonth = parseInt(document.getElementById('solarMonth').value);
            const solarYear = parseInt(document.getElementById('solarYear').value);

            // Close popup first
            this.closePopup(quickPickerOverlay);

            // Redirect to detai_home route
            const detailUrl = `/lich-nam-${solarYear}/thang-${solarMonth}/ngay-${solarDay}`;
            window.location.href = detailUrl;
        });
    }

    updatePopupHeader(month, year) {
        const monthSpan = document.getElementById('popupMonth');
        const yearSpan = document.getElementById('popupYear');
        if (monthSpan) monthSpan.textContent = month;
        if (yearSpan) yearSpan.textContent = year;
    }

    closePopup(overlay) {
        overlay.classList.remove('show');
        document.body.classList.remove('modal-open');
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300); // Wait for transition to complete
    }

    async generatePopupCalendar(month, year, highlightDay = null) {
        const calendarDays = document.getElementById('popupCalendarDays');
        if (!calendarDays) return;

        const firstDay = new Date(year, month - 1, 1);
        const lastDay = new Date(year, month, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Thứ 2 = 0

        // Clear calendar first
        calendarDays.innerHTML = '';

        // Fetch lunar dates for entire month from API in background
        const lunarDatesPromise = this.fetchLunarDatesForMonth(month, year, daysInMonth);

        // Add empty cells for previous month
        for (let i = 0; i < startingDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendarDays.appendChild(emptyDay);
        }

        // Add days of current month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.style.position = 'relative';

            // Solar date (main number)
            const solarSpan = document.createElement('span');
            solarSpan.textContent = day;
            dayElement.appendChild(solarSpan);

            // Add placeholder lunar date (will be updated when API returns)
            const lunarSpan = document.createElement('div');
            lunarSpan.className = 'lunar-date-popup';
            lunarSpan.textContent = '...'; // Temporary placeholder
            lunarSpan.setAttribute('data-day', day);
            dayElement.appendChild(lunarSpan);

            // Highlight current day - use select values if available
            const selectedDay = highlightDay || parseInt(document.getElementById('solarDay')?.value || this.currentDay);
            const selectedMonth = parseInt(document.getElementById('solarMonth')?.value || this.currentMonth);
            const selectedYear = parseInt(document.getElementById('solarYear')?.value || this.currentYear);

            if (year === selectedYear && month === selectedMonth && day === selectedDay) {
                dayElement.classList.add('current-day');
                dayElement.classList.add('selected'); // Also mark as selected
            }

            // Click handler for day selection - redirect to detai_home
            dayElement.addEventListener('click', async () => {
                document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
                dayElement.classList.add('selected');

                // Update solar date selects first
                document.getElementById('solarDay').value = day;
                document.getElementById('solarMonth').value = month;
                document.getElementById('solarYear').value = year;

                // Convert and update lunar date selects
                await this.convertSolarToLunar();

                // Close popup and redirect to detai_home route
                const quickPickerOverlay = document.getElementById('quickPickerOverlay');
                this.closePopup(quickPickerOverlay);

                // Redirect to detai_home route
                const detailUrl = `/lich-nam-${year}/thang-${month}/ngay-${day}`;
                window.location.href = detailUrl;
            });

            calendarDays.appendChild(dayElement);
        }

        // Update lunar dates when API returns
        lunarDatesPromise.then(lunarDatesMap => {
            for (let day = 1; day <= daysInMonth; day++) {
                const lunarSpan = calendarDays.querySelector(`[data-day="${day}"]`);
                if (lunarSpan && lunarDatesMap[day]) {
                    lunarSpan.textContent = lunarDatesMap[day].lunarDay;
                }
            }
        });
    }

    async updateLunarSelectsFromSolar(day, month, year) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/api/convert-solar-to-lunar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    solarDay: day,
                    solarMonth: month,
                    solarYear: year
                })
            });

            const data = await response.json();
            if (data.success) {
                const lunarDaySelect = document.getElementById('lunarDay');
                const lunarMonthSelect = document.getElementById('lunarMonth');
                const lunarYearSelect = document.getElementById('lunarYear');

                if (lunarDaySelect) lunarDaySelect.value = data.lunarDay;
                if (lunarMonthSelect) lunarMonthSelect.value = data.lunarMonth;
                if (lunarYearSelect) lunarYearSelect.value = data.lunarYear;
            }
        } catch (error) {
            // Error updating lunar selects - handled silently
        }
    }

    async fetchLunarDatesForMonth(month, year, daysInMonth) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            // Fetch lunar dates for entire month in ONE request
            const response = await fetch('/api/get-month-lunar-dates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    month: month,
                    year: year
                })
            });

            const data = await response.json();

            if (data.success && data.dates) {
                return data.dates;
            } else {
                console.error('Lỗi khi lấy dữ liệu âm lịch:', data.error);
                return {};
            }
        } catch (error) {
            console.error('Lỗi khi lấy dữ liệu âm lịch cho tháng:', error);
            return {};
        }
    }

    async syncCalendarWithSolarDate() {
        const day = parseInt(document.getElementById('solarDay').value);
        const month = parseInt(document.getElementById('solarMonth').value);
        const year = parseInt(document.getElementById('solarYear').value);

        // Update popup calendar view
        this.updatePopupHeader(month, year);
        await this.generatePopupCalendarOptimized(month, year, day);

        // Highlighting is now handled in generatePopupCalendar
    }

    async convertLunarToSolar() {
        const lunarDay = document.getElementById('lunarDay').value;
        const lunarMonth = document.getElementById('lunarMonth').value;
        const lunarYear = document.getElementById('lunarYear').value;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/api/convert-lunar-to-solar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    lunarDay: parseInt(lunarDay),
                    lunarMonth: parseInt(lunarMonth),
                    lunarYear: parseInt(lunarYear)
                })
            });

            const data = await response.json();
            if (data.success) {
                // Update solar date selects
                document.getElementById('solarDay').value = data.solarDay;
                document.getElementById('solarMonth').value = data.solarMonth;
                document.getElementById('solarYear').value = data.solarYear;

                // Update popup calendar header and regenerate with new solar date
                this.updatePopupHeader(data.solarMonth, data.solarYear);
                await this.generatePopupCalendar(data.solarMonth, data.solarYear, data.solarDay);
            }
        } catch (error) {
            console.error('Error converting lunar to solar:', error);
        }
    }

    // Simple synchronous lunar date calculation for calendar display
    convertSolarToLunarSync(day, month, year) {
        // Simple approximation - in a real app, you'd want a proper lunar algorithm
        // This is a basic approximation for display purposes
        const solarDate = new Date(year, month - 1, day);
        const lunarNewYear2024 = new Date(2024, 1, 10); // Feb 10, 2024 (example)
        const daysDiff = Math.floor((solarDate - lunarNewYear2024) / (1000 * 60 * 60 * 24));

        // Very basic lunar month approximation (29.5 days per lunar month)
        const lunarDay = ((daysDiff % 30) + 1);
        const lunarMonth = Math.floor(daysDiff / 30) % 12 + 1;

        return {
            lunarDay: lunarDay > 0 ? lunarDay : 1,
            lunarMonth: lunarMonth > 0 ? lunarMonth : 1,
            lunarYear: year
        };
    }

    async convertSolarToLunar() {
        const solarDay = document.getElementById('solarDay').value;
        const solarMonth = document.getElementById('solarMonth').value;
        const solarYear = document.getElementById('solarYear').value;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/api/convert-solar-to-lunar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    solarDay: parseInt(solarDay),
                    solarMonth: parseInt(solarMonth),
                    solarYear: parseInt(solarYear)
                })
            });

            const data = await response.json();
            if (data.success) {
                // Update lunar date selects
                document.getElementById('lunarDay').value = data.lunarDay;
                document.getElementById('lunarMonth').value = data.lunarMonth;
                document.getElementById('lunarYear').value = data.lunarYear;
            }
        } catch (error) {
            console.error('Error converting solar to lunar:', error);
        }
    }

    setupNavigationButtons() {
        // Lấy TẤT CẢ các element nút bấm prev
        const prevBtns = document.querySelectorAll('.prev-day-btn');
        // Lấy TẤT CẢ các element nút bấm next
        const nextBtns = document.querySelectorAll('.next-day-btn');

        // --- Xử lý các nút "Ngày trước" ---
        prevBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                const currentDate = this.getCurrentDate();
                const prevDate = new Date(currentDate);
                prevDate.setDate(currentDate.getDate() - 1);

                const prevYear = prevDate.getFullYear();
                const prevMonth = prevDate.getMonth() + 1;
                const prevDay = prevDate.getDate();

                // Redirect đến route detai_home
                const detailUrl = `/lich-nam-${prevYear}/thang-${prevMonth}/ngay-${prevDay}`;
                window.location.href = detailUrl;
            });
        });

        // --- Xử lý các nút "Ngày sau" ---
        nextBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                const currentDate = this.getCurrentDate();
                const nextDate = new Date(currentDate);
                nextDate.setDate(currentDate.getDate() + 1);

                const nextYear = nextDate.getFullYear();
                const nextMonth = nextDate.getMonth() + 1;
                const nextDay = nextDate.getDate();

                // Redirect đến route detai_home
                const detailUrl = `/lich-nam-${nextYear}/thang-${nextMonth}/ngay-${nextDay}`;
                window.location.href = detailUrl;
            });
        });
    }

    getCurrentDate() {
        return new Date(this.currentYear, this.currentMonth - 1, this.currentDay);
    }
}