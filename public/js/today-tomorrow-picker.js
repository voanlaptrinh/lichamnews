// JavaScript riêng cho trang lịch âm hôm nay và ngày mai
// Khi chọn ngày sẽ redirect sang trang detai_home

class TodayTomorrowPicker {
    constructor(config) {
        this.currentYear = config.currentYear;
        this.currentMonth = config.currentMonth;
        this.currentDay = config.currentDay;
        this.overlay = null;
    }

    init() {
        this.setupQuickPicker();
        this.setupNavigationButtons();
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
            btn.addEventListener('click', () => {
                // Lấy ngày hiện tại từ select thay vì từ biến global
                const currentDay = parseInt(document.getElementById('solarDay')?.value || this.currentDay);
                const currentMonth = parseInt(document.getElementById('solarMonth')?.value || this.currentMonth);
                const currentYear = parseInt(document.getElementById('solarYear')?.value || this.currentYear);

                // Cập nhật popup với ngày từ select
                currentPopupMonth = currentMonth;
                currentPopupYear = currentYear;

                quickPickerOverlay.style.display = 'flex';
                setTimeout(() => quickPickerOverlay.classList.add('show'), 10);
                document.body.classList.add('modal-open');
                this.generatePopupCalendar(currentPopupMonth, currentPopupYear, currentDay);
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
        document.getElementById('prevMonthBtn').addEventListener('click', () => {
            currentPopupMonth--;
            if (currentPopupMonth < 1) {
                currentPopupMonth = 12;
                currentPopupYear--;
            }
            this.updatePopupHeader(currentPopupMonth, currentPopupYear);
            this.generatePopupCalendar(currentPopupMonth, currentPopupYear);
        });

        document.getElementById('nextMonthBtn').addEventListener('click', () => {
            currentPopupMonth++;
            if (currentPopupMonth > 12) {
                currentPopupMonth = 1;
                currentPopupYear++;
            }
            this.updatePopupHeader(currentPopupMonth, currentPopupYear);
            this.generatePopupCalendar(currentPopupMonth, currentPopupYear);
        });

        // Sync calendar when solar date selects change
        document.getElementById('solarDay').addEventListener('change', () => {
            this.syncCalendarWithSolarDate(currentPopupMonth, currentPopupYear);
            this.convertSolarToLunar();
        });
        document.getElementById('solarMonth').addEventListener('change', () => {
            this.syncCalendarWithSolarDate(currentPopupMonth, currentPopupYear);
            this.convertSolarToLunar();
        });
        document.getElementById('solarYear').addEventListener('change', () => {
            this.syncCalendarWithSolarDate(currentPopupMonth, currentPopupYear);
            this.convertSolarToLunar();
        });

        // Add event listeners for lunar date changes
        document.getElementById('lunarDay').addEventListener('change', () => {
            this.convertLunarToSolar();
        });
        document.getElementById('lunarMonth').addEventListener('change', () => {
            this.convertLunarToSolar();
        });
        document.getElementById('lunarYear').addEventListener('change', () => {
            this.convertLunarToSolar();
        });

        // View button click - redirect to detai_home
        viewDateBtn.addEventListener('click', () => {
            const solarDay = parseInt(document.getElementById('solarDay').value);
            const solarMonth = parseInt(document.getElementById('solarMonth').value);
            const solarYear = parseInt(document.getElementById('solarYear').value);

            // Close popup first
            this.closePopup(quickPickerOverlay);

            // Redirect to detai_home route
            const formattedMonth = solarMonth.toString().padStart(2, '0');
            const formattedDay = solarDay.toString().padStart(2, '0');
            const detailUrl = `/lich-nam-${solarYear}/thang-${formattedMonth}/ngay-${formattedDay}`;
            window.location.href = detailUrl;
        });
    }

    updatePopupHeader(month, year) {
        const monthSpan = document.getElementById('popupMonth');
        const yearSpan = document.getElementById('popupYear');
        if (monthSpan) monthSpan.textContent = month.toString().padStart(2, '0');
        if (yearSpan) yearSpan.textContent = year;
    }

    closePopup(overlay) {
        overlay.classList.remove('show');
        document.body.classList.remove('modal-open');
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300); // Wait for transition to complete
    }

    generatePopupCalendar(month, year, highlightDay = null) {
        const calendarDays = document.getElementById('popupCalendarDays');
        if (!calendarDays) return;

        const firstDay = new Date(year, month - 1, 1);
        const lastDay = new Date(year, month, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Thứ 2 = 0

        calendarDays.innerHTML = '';

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

            // Convert to lunar date
            try {
                const lunarResult = this.convertSolarToLunarSync(day, month, year);
                if (lunarResult) {
                    const lunarSpan = document.createElement('div');
                    lunarSpan.className = 'lunar-date-popup';
                    lunarSpan.textContent = lunarResult.lunarDay;
                    dayElement.appendChild(lunarSpan);
                }
            } catch (e) {
                console.log('Lunar conversion failed for:', day, month, year);
            }

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
                const formattedMonth = month.toString().padStart(2, '0');
                const formattedDay = day.toString().padStart(2, '0');
                const detailUrl = `/lich-nam-${year}/thang-${formattedMonth}/ngay-${formattedDay}`;
                window.location.href = detailUrl;
            });

            calendarDays.appendChild(dayElement);
        }
    }

    syncCalendarWithSolarDate() {
        const day = parseInt(document.getElementById('solarDay').value);
        const month = parseInt(document.getElementById('solarMonth').value);
        const year = parseInt(document.getElementById('solarYear').value);

        // Update popup calendar view
        this.updatePopupHeader(month, year);
        this.generatePopupCalendar(month, year, day);

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

                // Sync calendar
                this.syncCalendarWithSolarDate();
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
                const formattedMonth = prevMonth.toString().padStart(2, '0');
                const formattedDay = prevDay.toString().padStart(2, '0');
                const detailUrl = `/lich-nam-${prevYear}/thang-${formattedMonth}/ngay-${formattedDay}`;
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
                const formattedMonth = nextMonth.toString().padStart(2, '0');
                const formattedDay = nextDay.toString().padStart(2, '0');
                const detailUrl = `/lich-nam-${nextYear}/thang-${formattedMonth}/ngay-${formattedDay}`;
                window.location.href = detailUrl;
            });
        });
    }

    getCurrentDate() {
        return new Date(this.currentYear, this.currentMonth - 1, this.currentDay);
    }
}