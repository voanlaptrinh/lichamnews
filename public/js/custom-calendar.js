/**
 * Custom Calendar Module
 * Có thể tái sử dụng cho nhiều view khác nhau
 */

class CustomCalendar {
    constructor(options = {}) {
        this.options = {
            inputId: options.inputId || 'ngayXem',
            calendarId: options.calendarId || 'customCalendar',
            defaultToToday: options.defaultToToday !== false,
            usePopup: options.usePopup !== false, // Default to popup style
            ...options
        };

        this.currentDate = new Date();
        this.selectedDate = null;
        this.pickerVisible = false;
        this.overlay = null;

        this.init();
    }

    init() {
        this.input = document.getElementById(this.options.inputId);
        this.calendar = document.getElementById(this.options.calendarId);

        if (!this.input || !this.calendar) {
            console.warn('Custom calendar elements not found');
            return;
        }

        // Create overlay if using popup mode
        if (this.options.usePopup) {
            this.createOverlay();
        }

        // Main calendar elements
        this.monthYear = this.calendar.querySelector('[id*="monthYear"]');
        this.calendarDays = this.calendar.querySelector('[id*="calendarDays"]');
        this.weekdays = this.calendar.querySelector('.calendar-weekdays');
        this.prevBtn = this.calendar.querySelector('[id*="prevMonth"]');
        this.nextBtn = this.calendar.querySelector('[id*="nextMonth"]');
        this.clearBtn = this.calendar.querySelector('[id*="clearDate"]');
        this.todayBtn = this.calendar.querySelector('[id*="todayDate"]');

        // Picker elements
        this.picker = this.calendar.querySelector('#monthYearPicker');
        this.pickerYear = this.calendar.querySelector('#pickerYear');
        this.pickerPrevYear = this.calendar.querySelector('#pickerPrevYear');
        this.pickerNextYear = this.calendar.querySelector('#pickerNextYear');
        this.monthGrid = this.calendar.querySelector('#monthGrid');

        this.monthNames = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        this.setupEventListeners();

        if (this.options.defaultToToday) {
            const today = new Date();
            this.selectedDate = today;
            this.input.value = this.formatDateDisplay(today);

            // Store date in dataset for form submission
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();
            this.input.dataset.date = `${day}/${month}/${year}`;
            this.input.dataset.solarDay = today.getDate();
            this.input.dataset.solarMonth = today.getMonth() + 1;
            this.input.dataset.solarYear = year;
        }

        this.generateCalendar(this.currentDate);
    }

    createOverlay() {
        // Create overlay
        this.overlay = document.createElement('div');
        this.overlay.className = 'calendar-overlay';
        this.overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            display: none;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        `;
        document.body.appendChild(this.overlay);

        // Move calendar to overlay
        this.overlay.appendChild(this.calendar);

        // Style calendar as popup
        this.calendar.classList.add('calendar-popup');
        this.calendar.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 20px;
            display: none;
            width: 380px;
            max-width: 95vw;
            animation: slideUp 0.3s ease;
        `;

        // Add CSS animation
        if (!document.getElementById('calendar-popup-styles')) {
            const style = document.createElement('style');
            style.id = 'calendar-popup-styles';
            style.textContent = `
                @keyframes slideUp {
                    from {
                        opacity: 0;
                        transform: translate(-50%, -45%);
                    }
                    to {
                        opacity: 1;
                        transform: translate(-50%, -50%);
                    }
                }
                .calendar-overlay.show {
                    animation: fadeIn 0.2s ease;
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
            `;
            document.head.appendChild(style);
        }

        // Close overlay on click
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.hideCalendar();
            }
        });
    }

    showCalendar() {
        if (this.options.usePopup && this.overlay) {
            this.overlay.style.display = 'block';
            this.calendar.style.display = 'block';
            this.overlay.classList.add('show');
        } else {
            this.calendar.style.display = 'block';
        }
        this.generateCalendar(this.currentDate);
    }

    hideCalendar() {
        if (this.options.usePopup && this.overlay) {
            this.overlay.classList.remove('show');
            setTimeout(() => {
                this.overlay.style.display = 'none';
                this.calendar.style.display = 'none';
            }, 200);
        } else {
            this.calendar.style.display = 'none';
        }
    }

    setupEventListeners() {
        this.input.addEventListener('click', (e) => {
            e.stopPropagation();
            if (this.calendar.style.display === 'none' || !this.calendar.style.display) {
                this.showCalendar();
            } else {
                this.hideCalendar();
            }
        });

        this.monthYear.addEventListener('click', () => this.togglePicker());

        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.generateCalendar(this.currentDate);
            });
        }

        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.generateCalendar(this.currentDate);
            });
        }

        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => {
                this.selectedDate = null;
                this.input.value = '';

                // Clear all date data
                delete this.input.dataset.date;
                delete this.input.dataset.solarDay;
                delete this.input.dataset.solarMonth;
                delete this.input.dataset.solarYear;
                delete this.input.dataset.lunarDay;
                delete this.input.dataset.lunarMonth;
                delete this.input.dataset.lunarYear;
                delete this.input.dataset.lunarLeap;

                this.hideCalendar();
                this.generateCalendar(this.currentDate);
            });
        }

        if (this.todayBtn) {
            this.todayBtn.addEventListener('click', () => {
                const today = new Date();
                this.selectedDate = today;
                this.currentDate = new Date(today);
                this.input.value = this.formatDateDisplay(today);

                // Store date in dataset for form submission
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();
                this.input.dataset.date = `${day}/${month}/${year}`;
                this.input.dataset.solarDay = today.getDate();
                this.input.dataset.solarMonth = today.getMonth() + 1;
                this.input.dataset.solarYear = year;

                // Clear lunar data if exists
                delete this.input.dataset.lunarDay;
                delete this.input.dataset.lunarMonth;
                delete this.input.dataset.lunarYear;
                delete this.input.dataset.lunarLeap;

                this.hideCalendar();
                this.generateCalendar(this.currentDate);
            });
        }

        // Picker navigation
        this.pickerPrevYear.addEventListener('click', () => {
            this.currentDate.setFullYear(this.currentDate.getFullYear() - 1);
            this.generateMonthPicker(this.currentDate.getFullYear());
        });

        this.pickerNextYear.addEventListener('click', () => {
            this.currentDate.setFullYear(this.currentDate.getFullYear() + 1);
            this.generateMonthPicker(this.currentDate.getFullYear());
        });

        // Only add document click listener for non-popup mode
        if (!this.options.usePopup) {
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.input-group') && !e.target.closest('.custom-calendar')) {
                    this.hideCalendar();
                }
            });
        }
    }

    togglePicker() {
        this.pickerVisible = !this.pickerVisible;
        if (this.pickerVisible) {
            this.calendarDays.style.display = 'none';
            this.weekdays.style.display = 'none';
            this.picker.style.display = 'block';
            this.generateMonthPicker(this.currentDate.getFullYear());
        } else {
            this.calendarDays.style.display = 'grid';
            this.weekdays.style.display = 'grid';
            this.picker.style.display = 'none';
            this.generateCalendar(this.currentDate);
        }
    }

    generateMonthPicker(year) {
        this.pickerYear.textContent = year;
        this.monthGrid.innerHTML = '';
        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth();

        this.pickerNextYear.disabled = year >= currentYear;

        for (let i = 0; i < 12; i++) {
            const monthEl = document.createElement('div');
            monthEl.className = 'month-item';
            monthEl.textContent = this.monthNames[i];
            monthEl.dataset.month = i;

            if (year > currentYear || (year === currentYear && i > currentMonth)) {
                monthEl.classList.add('disabled');
            } else {
                monthEl.addEventListener('click', () => {
                    this.currentDate.setFullYear(year, i, 1);
                    this.togglePicker();
                });
            }
            this.monthGrid.appendChild(monthEl);
        }
    }

    generateCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        this.monthYear.textContent = `${this.monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const firstDayWeek = firstDay.getDay();

        this.calendarDays.innerHTML = '';

        for (let i = firstDayWeek - 1; i >= 0; i--) {
            const day = new Date(year, month, -i);
            this.calendarDays.appendChild(this.createDayElement(day, true));
        }

        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayDate = new Date(year, month, day);
            this.calendarDays.appendChild(this.createDayElement(dayDate, false));
        }

        const remainingCells = 42 - this.calendarDays.children.length;
        for (let day = 1; day <= remainingCells; day++) {
            const dayDate = new Date(year, month + 1, day);
            this.calendarDays.appendChild(this.createDayElement(dayDate, true));
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (this.nextBtn) {
            const nextMonthDate = new Date(date);
            nextMonthDate.setMonth(date.getMonth() + 1, 1);
            this.nextBtn.disabled = nextMonthDate > today;
        }
    }

    createDayElement(date, isOtherMonth) {
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        dayEl.textContent = date.getDate();

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (isOtherMonth) dayEl.classList.add('other-month');
        if (date > today) dayEl.classList.add('disabled');
        if (date.toDateString() === today.toDateString()) dayEl.classList.add('today');
        if (this.selectedDate && date.toDateString() === this.selectedDate.toDateString()) {
            dayEl.classList.add('selected');
        }

        dayEl.addEventListener('click', () => {
            if (date > today || isOtherMonth) return;

            this.selectedDate = new Date(date);
            this.input.value = this.formatDateDisplay(this.selectedDate);

            // Store date in dataset for form submission
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            this.input.dataset.date = `${day}/${month}/${year}`;
            this.input.dataset.solarDay = date.getDate();
            this.input.dataset.solarMonth = date.getMonth() + 1;
            this.input.dataset.solarYear = year;

            // Clear lunar data if exists
            delete this.input.dataset.lunarDay;
            delete this.input.dataset.lunarMonth;
            delete this.input.dataset.lunarYear;
            delete this.input.dataset.lunarLeap;

            this.hideCalendar();
            this.generateCalendar(this.currentDate);
        });

        return dayEl;
    }

    formatDateDisplay(date) {
        return date.toLocaleDateString('vi-VN');
    }

    formatDateValue(date) {
        return date.toISOString().split('T')[0];
    }

    parseVietnameseDate(dateStr) {
        if (!dateStr) return null;
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            let year = parseInt(parts[2], 10);
            if (year < 100) year += 2000;
            return new Date(year, month, day);
        }
        return null;
    }

    getValue() { return this.input.value; }
    setValue(dateStr) {
        const date = this.parseVietnameseDate(dateStr);
        if (date) {
            this.selectedDate = date;
            this.input.value = this.formatDateDisplay(date);
            this.generateCalendar(date);
        }
    }
    getDateObject() { return this.selectedDate; }
}

// Global Calendar for multiple inputs
class GlobalCalendar {
    constructor(calendarId = 'globalCalendar') {
        this.calendarId = calendarId;
        this.currentDate = new Date();
        this.currentInput = null;

        this.init();
    }

    init() {
        this.calendar = document.getElementById(this.calendarId);

        if (!this.calendar) {
            console.warn('Global calendar not found');
            return;
        }

        this.monthYear = this.calendar.querySelector('[id*="monthYear"]');
        this.calendarDays = this.calendar.querySelector('[id*="calendarDays"]');
        this.prevBtn = this.calendar.querySelector('[id*="prevMonth"]');
        this.nextBtn = this.calendar.querySelector('[id*="nextMonth"]');
        this.clearBtn = this.calendar.querySelector('[id*="clearDate"]');
        this.todayBtn = this.calendar.querySelector('[id*="todayDate"]');

        this.monthNames = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        this.setupEventListeners();
    }

    setupEventListeners() {
        // Navigation
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.generateCalendar(this.currentDate);
            });
        }

        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.generateCalendar(this.currentDate);
            });
        }

        // Actions
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => {
                if (this.currentInput) {
                    this.currentInput.value = '';
                    this.calendar.style.display = 'none';
                }
            });
        }

        if (this.todayBtn) {
            this.todayBtn.addEventListener('click', () => {
                if (this.currentInput) {
                    const today = new Date();
                    this.currentDate = new Date(today);
                    this.currentInput.value = this.formatDateDisplay(today);
                    this.calendar.style.display = 'none';
                }
            });
        }

        // Hide on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.date-input') &&
                !e.target.closest('.global-calendar') &&
                !this.currentInput?.contains(e.target)) {
                this.calendar.style.display = 'none';
            }
        });
    }

    attachToInput(input) {
        input.addEventListener('click', (e) => {
            e.stopPropagation();
            this.currentInput = input;
            this.positionCalendar(input);
            this.calendar.style.display = 'block';
            this.generateCalendar(this.currentDate);
        });
    }

    positionCalendar(inputElement) {
        const rect = inputElement.getBoundingClientRect();
        const calendarHeight = 350;
        const windowHeight = window.innerHeight;

        let top = rect.bottom + window.scrollY + 5;
        if (top + calendarHeight > windowHeight + window.scrollY) {
            top = rect.top + window.scrollY - calendarHeight - 5;
        }

        this.calendar.style.left = rect.left + window.scrollX + 'px';
        this.calendar.style.top = top + 'px';
    }

    generateCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        this.monthYear.textContent = `${this.monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const firstDayWeek = firstDay.getDay();

        this.calendarDays.innerHTML = '';

        // Previous month days
        for (let i = firstDayWeek - 1; i >= 0; i--) {
            const day = new Date(year, month, -i);
            const dayEl = this.createDayElement(day, true);
            this.calendarDays.appendChild(dayEl);
        }

        // Current month days
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayDate = new Date(year, month, day);
            const dayEl = this.createDayElement(dayDate, false);
            this.calendarDays.appendChild(dayEl);
        }

        // Next month days
        const remainingCells = 42 - this.calendarDays.children.length;
        for (let day = 1; day <= remainingCells; day++) {
            const dayDate = new Date(year, month + 1, day);
            const dayEl = this.createDayElement(dayDate, true);
            this.calendarDays.appendChild(dayEl);
        }
    }

    createDayElement(date, isOtherMonth) {
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        dayEl.textContent = date.getDate();

        if (isOtherMonth) {
            dayEl.classList.add('other-month');
        }

        // Check if today
        const today = new Date();
        if (date.toDateString() === today.toDateString()) {
            dayEl.classList.add('today');
        }

        // Check if selected
        if (this.currentInput) {
            const inputValue = this.currentInput.value;
            if (inputValue) {
                const inputDate = this.parseVietnameseDate(inputValue);
                if (inputDate && date.toDateString() === inputDate.toDateString()) {
                    dayEl.classList.add('selected');
                }
            }
        }

        dayEl.addEventListener('click', () => {
            if (!isOtherMonth && this.currentInput) {
                const formattedDate = this.formatDateDisplay(date);
                this.currentInput.value = formattedDate;
                this.calendar.style.display = 'none';
                this.generateCalendar(this.currentDate);
            }
        });

        return dayEl;
    }

    formatDateDisplay(date) {
        return date.toLocaleDateString('vi-VN');
    }

    parseVietnameseDate(dateStr) {
        if (!dateStr) return null;
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            let year = parseInt(parts[2], 10);

            if (year < 100) {
                year += 2000;
            }

            return new Date(year, month, day);
        }
        return null;
    }
}

// Date utilities
const DateUtils = {
    parseVietnameseDate(dateStr) {
        if (!dateStr) return null;
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            let year = parseInt(parts[2], 10);

            if (year < 100) {
                year += 2000;
            }

            return new Date(year, month, day);
        }
        return null;
    },

    formatDateDisplay(date) {
        if (!date) return '';
        return date.toLocaleDateString('vi-VN');
    },

    formatDateValue(date) {
        if (!date) return '';
        return date.toISOString().split('T')[0];
    },

    validateDateRange(rangeValue) {
        if (!rangeValue || rangeValue.indexOf(' - ') === -1) {
            return true;
        }

        const parts = rangeValue.split(' - ');
        if (parts.length !== 2) return true;

        const fromDate = this.parseVietnameseDate(parts[0]);
        const toDate = this.parseVietnameseDate(parts[1]);

        if (fromDate && toDate && fromDate > toDate) {
            alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
            return false;
        }
        return true;
    },

    parseDateRange(rangeValue) {
        if (!rangeValue || rangeValue.indexOf(' - ') === -1) {
            return { start: null, end: null };
        }

        const parts = rangeValue.split(' - ');
        if (parts.length !== 2) {
            return { start: null, end: null };
        }

        return {
            start: this.parseVietnameseDate(parts[0]),
            end: this.parseVietnameseDate(parts[1])
        };
    }
};

// Export for use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { CustomCalendar, GlobalCalendar, DateUtils };
}
