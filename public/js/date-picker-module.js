/**
 * Date Picker Module - Reusable date picker components
 * Includes Solar Calendar, Lunar Calendar, and Date Range picker
 */

(function(window) {
    'use strict';

    // ========== SOLAR CALENDAR MODULE ==========
    class SolarCalendarPicker {
        constructor(options = {}) {
            this.options = {
                inputId: options.inputId || 'solarDateInput',
                calendarId: options.calendarId || 'solarCalendar',
                defaultToToday: options.defaultToToday !== false,
                onChange: options.onChange || null,
                dateFormat: options.dateFormat || 'dd/mm/yyyy',
                usePopup: options.usePopup !== false, // Default to popup style
                ...options
            };

            this.currentDate = new Date();
            this.selectedDate = null;
            this.calendar = null;
            this.input = null;
            this.overlay = null;
            this.pickerVisible = false;

            this.init();
        }

        init() {
            this.input = document.getElementById(this.options.inputId);
            if (!this.input) {
                console.error(`Input element with id "${this.options.inputId}" not found`);
                return;
            }

            // Create calendar container if not exists
            this.createCalendarHTML();
            this.createOverlay();
            this.setupEventListeners();

            if (this.options.defaultToToday) {
                this.selectDate(new Date());
            }
        }

        createOverlay() {
            if (!this.overlay && this.options.usePopup) {
                this.overlay = document.createElement('div');
                this.overlay.className = 'solar-calendar-overlay';
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
                `;
                document.body.appendChild(this.overlay);

                this.overlay.addEventListener('click', () => {
                    this.hideCalendar();
                });
            }
        }

        createCalendarHTML() {
            // Check if calendar already exists
            let calendarEl = document.getElementById(this.options.calendarId);
            if (!calendarEl) {
                calendarEl = document.createElement('div');
                calendarEl.id = this.options.calendarId;
                calendarEl.className = 'custom-calendar';
                calendarEl.style.display = 'none';
                calendarEl.innerHTML = `
                    <div class="calendar-header-date">
                        <button type="button" class="btn-nav prev-month"><i class="bi bi-chevron-left"></i></button>
                        <span class="month-year" style="cursor: pointer; text-decoration: underline;">October 2025</span>
                        <button type="button" class="btn-nav next-month"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div class="calendar-weekdays">
                        <div class="weekday">CN</div>
                        <div class="weekday">T2</div>
                        <div class="weekday">T3</div>
                        <div class="weekday">T4</div>
                        <div class="weekday">T5</div>
                        <div class="weekday">T6</div>
                        <div class="weekday">T7</div>
                    </div>
                    <div class="calendar-days"></div>
                    <div class="calendar-footer">
                        <button type="button" class="btn-calendar btn-clear">Xóa</button>
                        <button type="button" class="btn-calendar btn-today">Hôm nay</button>
                    </div>
                    <!-- Month/Year Picker -->
                    <div class="calendar-picker" style="display: none;">
                        <div class="picker-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; margin-bottom: 10px;">
                            <button type="button" class="btn-nav picker-prev-year"><i class="bi bi-chevron-left"></i></button>
                            <span class="picker-year" style="font-size: 18px; font-weight: bold;"></span>
                            <button type="button" class="btn-nav picker-next-year"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <div class="month-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;"></div>
                    </div>
                `;

                // Add inline styles for month items
                const styleSheet = document.createElement('style');
                styleSheet.innerHTML = `
                    .month-item {
                        padding: 10px;
                        text-align: center;
                        cursor: pointer;
                        border-radius: 8px;
                        transition: all 0.2s ease;
                        background: #f8f9fa;
                    }
                    .month-item:hover:not(.disabled) {
                        background: #007bff;
                        color: white;
                    }
                    .month-item.disabled {
                        opacity: 0.5;
                        cursor: not-allowed;
                    }
                    .calendar-days {
                        display: grid;
                        grid-template-columns: repeat(7, 1fr);
                        gap: 4px;
                    }
                    .calendar-day {
                        padding: 8px;
                        text-align: center;
                        cursor: pointer;
                        border-radius: 4px;
                        transition: all 0.2s ease;
                    }
                    .calendar-day:hover:not(.disabled):not(.empty) {
                        background: #e3f2fd;
                    }
                    .calendar-day.selected {
                        background: #007bff;
                        color: white;
                    }
                    .calendar-day.today {
                        border: 2px solid #007bff;
                        font-weight: bold;
                    }
                    .calendar-day.disabled {
                        opacity: 0.5;
                        cursor: not-allowed;
                    }
                    .calendar-day.empty {
                        cursor: default;
                    }
                `;

                // Only add styles once
                if (!document.getElementById('date-picker-styles')) {
                    styleSheet.id = 'date-picker-styles';
                    document.head.appendChild(styleSheet);
                }

                // Append to body for popup style
                document.body.appendChild(calendarEl);
            }
            this.calendar = calendarEl;
        }

        setupEventListeners() {
            // Input click to show calendar
            this.input.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleCalendar();
            });

            // Calendar navigation
            const prevBtn = this.calendar.querySelector('.prev-month');
            const nextBtn = this.calendar.querySelector('.next-month');
            const clearBtn = this.calendar.querySelector('.btn-clear');
            const todayBtn = this.calendar.querySelector('.btn-today');
            const monthYearSpan = this.calendar.querySelector('.month-year');

            // Month/Year picker elements
            const picker = this.calendar.querySelector('.calendar-picker');
            const pickerPrevYear = this.calendar.querySelector('.picker-prev-year');
            const pickerNextYear = this.calendar.querySelector('.picker-next-year');
            const pickerYear = this.calendar.querySelector('.picker-year');
            const monthGrid = this.calendar.querySelector('.month-grid');

            prevBtn.addEventListener('click', () => this.changeMonth(-1));
            nextBtn.addEventListener('click', () => this.changeMonth(1));
            clearBtn.addEventListener('click', () => this.clearDate());
            todayBtn.addEventListener('click', () => this.selectToday());

            // Click on month/year header to show picker
            monthYearSpan.addEventListener('click', () => this.togglePicker());

            // Picker navigation
            if (pickerPrevYear) {
                pickerPrevYear.addEventListener('click', () => {
                    this.currentDate.setFullYear(this.currentDate.getFullYear() - 1);
                    this.generateMonthPicker();
                });
            }

            if (pickerNextYear) {
                pickerNextYear.addEventListener('click', () => {
                    this.currentDate.setFullYear(this.currentDate.getFullYear() + 1);
                    this.generateMonthPicker();
                });
            }

            // Close calendar on outside click only if not using popup
            if (!this.options.usePopup) {
                document.addEventListener('click', (e) => {
                    if (!this.calendar.contains(e.target) && e.target !== this.input) {
                        this.hideCalendar();
                    }
                });
            }
        }

        togglePicker() {
            const picker = this.calendar.querySelector('.calendar-picker');
            const calendarDays = this.calendar.querySelector('.calendar-days');
            const weekdays = this.calendar.querySelector('.calendar-weekdays');

            this.pickerVisible = !this.pickerVisible;

            if (this.pickerVisible) {
                calendarDays.style.display = 'none';
                weekdays.style.display = 'none';
                picker.style.display = 'block';
                this.generateMonthPicker();
            } else {
                calendarDays.style.display = 'grid';
                weekdays.style.display = 'grid';
                picker.style.display = 'none';
                this.generateCalendar();
            }
        }

        generateMonthPicker() {
            const year = this.currentDate.getFullYear();
            const pickerYear = this.calendar.querySelector('.picker-year');
            const monthGrid = this.calendar.querySelector('.month-grid');

            pickerYear.textContent = year;
            monthGrid.innerHTML = '';

            const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                              'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

            const today = new Date();
            const currentYear = today.getFullYear();
            const currentMonth = today.getMonth();

            for (let i = 0; i < 12; i++) {
                const monthEl = document.createElement('div');
                monthEl.className = 'month-item';
                monthEl.textContent = monthNames[i];
                monthEl.dataset.month = i;

                // Disable future months if needed
                if (this.options.disableFuture && (year > currentYear || (year === currentYear && i > currentMonth))) {
                    monthEl.classList.add('disabled');
                } else {
                    monthEl.addEventListener('click', () => {
                        this.currentDate.setMonth(i);
                        this.togglePicker();
                    });
                }

                monthGrid.appendChild(monthEl);
            }
        }

        toggleCalendar() {
            if (this.calendar.style.display === 'none') {
                this.showCalendar();
            } else {
                this.hideCalendar();
            }
        }

        showCalendar() {
            if (this.options.usePopup && this.overlay) {
                // Show as centered popup
                this.overlay.style.display = 'block';
                this.calendar.style.display = 'block';
                this.calendar.style.position = 'fixed';
                this.calendar.style.top = '50%';
                this.calendar.style.left = '50%';
                this.calendar.style.transform = 'translate(-50%, -50%)';
                this.calendar.style.zIndex = '9999';
                this.calendar.style.backgroundColor = 'white';
                this.calendar.style.borderRadius = '12px';
                this.calendar.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.3)';
                this.calendar.style.maxWidth = '400px';
                this.calendar.style.width = '90%';
                this.calendar.style.padding = '20px';
            } else {
                this.calendar.style.display = 'block';
            }
            this.generateCalendar();
        }

        hideCalendar() {
            this.calendar.style.display = 'none';
            if (this.overlay) {
                this.overlay.style.display = 'none';
            }
            this.pickerVisible = false;
        }

        changeMonth(direction) {
            this.currentDate.setMonth(this.currentDate.getMonth() + direction);
            this.generateCalendar();
        }

        generateCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const firstDayWeek = firstDay.getDay();

            // Update header
            const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                              'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
            this.calendar.querySelector('.month-year').textContent = `${monthNames[month]} ${year}`;

            // Generate days
            const daysContainer = this.calendar.querySelector('.calendar-days');
            daysContainer.innerHTML = '';

            // Empty cells before month starts
            for (let i = 0; i < firstDayWeek; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'calendar-day empty';
                daysContainer.appendChild(emptyDiv);
            }

            // Days of month
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day';
                dayDiv.textContent = day;

                const currentDay = new Date(year, month, day);
                currentDay.setHours(0, 0, 0, 0);

                // Mark today
                if (currentDay.getTime() === today.getTime()) {
                    dayDiv.classList.add('today');
                }

                // Mark selected
                if (this.selectedDate &&
                    currentDay.getTime() === this.selectedDate.getTime()) {
                    dayDiv.classList.add('selected');
                }

                // Disable future dates if needed
                if (this.options.disableFuture && currentDay > today) {
                    dayDiv.classList.add('disabled');
                } else {
                    dayDiv.addEventListener('click', () => {
                        this.selectDate(new Date(year, month, day));
                    });
                }

                daysContainer.appendChild(dayDiv);
            }
        }

        selectDate(date) {
            this.selectedDate = new Date(date);
            this.selectedDate.setHours(0, 0, 0, 0);

            // Format and set input value
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            this.input.value = `${day}/${month}/${year}`;

            // Store in dataset
            this.input.dataset.date = `${day}/${month}/${year}`;
            this.input.dataset.day = date.getDate();
            this.input.dataset.month = date.getMonth() + 1;
            this.input.dataset.year = year;

            // Trigger callback
            if (this.options.onChange) {
                this.options.onChange(date, this.input.value);
            }

            this.hideCalendar();
        }

        clearDate() {
            this.selectedDate = null;
            this.input.value = '';
            delete this.input.dataset.date;
            delete this.input.dataset.day;
            delete this.input.dataset.month;
            delete this.input.dataset.year;

            if (this.options.onChange) {
                this.options.onChange(null, '');
            }

            this.hideCalendar();
        }

        selectToday() {
            this.selectDate(new Date());
        }

        getValue() {
            return this.input.value;
        }

        getDateObject() {
            return this.selectedDate;
        }

        destroy() {
            if (this.calendar) {
                this.calendar.remove();
            }
        }
    }

    // ========== LUNAR CALENDAR MODULE ==========
    class LunarCalendarPicker {
        constructor(options = {}) {
            this.options = {
                inputId: options.inputId || 'lunarDateInput',
                calendarId: options.calendarId || 'lunarCalendar',
                apiUrl: options.apiUrl || '/api/convert-lunar-to-solar',
                monthApiUrl: options.monthApiUrl || '/api/get-lunar-month-calendar',
                onChange: options.onChange || null,
                ...options
            };

            this.currentLunarMonth = 1;
            this.currentLunarYear = new Date().getFullYear();
            this.isLeapMonth = false;
            this.selectedDate = null;
            this.calendar = null;
            this.input = null;
            this.overlay = null;

            // Add cache and loading state
            this.cache = new Map();
            this.isLoading = false;
            this.requestQueue = [];
            this.lastRequestTime = 0;
            this.minRequestInterval = 500; // Minimum 500ms between requests

            this.init();
        }

        init() {
            this.input = document.getElementById(this.options.inputId);
            if (!this.input) {
                console.error(`Input element with id "${this.options.inputId}" not found`);
                return;
            }

            this.createCalendarHTML();
            this.createOverlay();
            this.setupEventListeners();
            this.initializeCurrentMonth();
        }

        createCalendarHTML() {
            let calendarEl = document.getElementById(this.options.calendarId);
            if (!calendarEl) {
                calendarEl = document.createElement('div');
                calendarEl.id = this.options.calendarId;
                calendarEl.className = 'custom-calendar lunar-calendar';
                calendarEl.style.display = 'none';
                calendarEl.innerHTML = `
                    <div class="calendar-header-date">
                        <button type="button" class="btn-nav lunar-prev-month"><i class="bi bi-chevron-left"></i></button>
                        <span class="month-year lunar-month-year" style="cursor: pointer; text-decoration: underline;">Tháng 1 Âm lịch 2025</span>
                        <button type="button" class="btn-nav lunar-next-month"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div id="leapMonthSelector" style="display: none; padding: 10px; text-align: center;">
                        <label style="margin-right: 10px;">
                            <input type="radio" name="monthType" value="normal" checked>
                            <span>Tháng thường</span>
                        </label>
                        <label>
                            <input type="radio" name="monthType" value="leap">
                            <span>Tháng nhuận</span>
                        </label>
                    </div>
                    <div class="calendar-weekdays">
                        <div class="weekday">CN</div>
                        <div class="weekday">T2</div>
                        <div class="weekday">T3</div>
                        <div class="weekday">T4</div>
                        <div class="weekday">T5</div>
                        <div class="weekday">T6</div>
                        <div class="weekday">T7</div>
                    </div>
                    <div class="calendar-days lunar-calendar-days" style="min-height: 240px;"></div>
                    <div class="calendar-footer">
                        <button type="button" class="btn-calendar btn-clear lunar-clear">Xóa</button>
                        <button type="button" class="btn-calendar btn-today lunar-today">Hôm nay</button>
                    </div>
                    <!-- Lunar Month/Year Picker -->
                    <div class="lunar-calendar-picker" style="display: none;">
                        <div class="picker-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; margin-bottom: 10px;">
                            <button type="button" class="btn-nav lunar-picker-prev-year"><i class="bi bi-chevron-left"></i></button>
                            <span class="lunar-picker-year" style="font-size: 18px; font-weight: bold;"></span>
                            <button type="button" class="btn-nav lunar-picker-next-year"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <div class="lunar-month-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;"></div>
                    </div>
                `;
                document.body.appendChild(calendarEl);
            }
            this.calendar = calendarEl;
        }

        createOverlay() {
            if (!this.overlay) {
                this.overlay = document.createElement('div');
                this.overlay.className = 'lunar-calendar-overlay';
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
                `;
                document.body.appendChild(this.overlay);

                this.overlay.addEventListener('click', () => {
                    this.hideCalendar();
                });
            }
        }

        setupEventListeners() {
            this.input.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                this.showCalendar();
            });

            const prevBtn = this.calendar.querySelector('.lunar-prev-month');
            const nextBtn = this.calendar.querySelector('.lunar-next-month');
            const clearBtn = this.calendar.querySelector('.lunar-clear');
            const todayBtn = this.calendar.querySelector('.lunar-today');
            const monthYearSpan = this.calendar.querySelector('.lunar-month-year');

            // Month/Year picker elements
            const picker = this.calendar.querySelector('.lunar-calendar-picker');
            const pickerPrevYear = this.calendar.querySelector('.lunar-picker-prev-year');
            const pickerNextYear = this.calendar.querySelector('.lunar-picker-next-year');

            prevBtn.addEventListener('click', () => this.changeMonth(-1));
            nextBtn.addEventListener('click', () => this.changeMonth(1));
            clearBtn.addEventListener('click', () => this.clearDate());
            todayBtn.addEventListener('click', () => this.selectToday());

            // Click on month/year header to show picker
            monthYearSpan.addEventListener('click', () => this.toggleLunarPicker());

            // Picker year navigation
            if (pickerPrevYear) {
                pickerPrevYear.addEventListener('click', () => {
                    this.pickerYear = (this.pickerYear || this.currentLunarYear) - 1;
                    this.generateLunarMonthPicker();
                });
            }

            if (pickerNextYear) {
                pickerNextYear.addEventListener('click', () => {
                    this.pickerYear = (this.pickerYear || this.currentLunarYear) + 1;
                    this.generateLunarMonthPicker();
                });
            }
        }

        toggleLunarPicker() {
            const picker = this.calendar.querySelector('.lunar-calendar-picker');
            const calendarDays = this.calendar.querySelector('.lunar-calendar-days');
            const weekdays = this.calendar.querySelector('.calendar-weekdays');
            const leapSelector = this.calendar.querySelector('#leapMonthSelector');

            this.pickerVisible = !this.pickerVisible;

            if (this.pickerVisible) {
                calendarDays.style.display = 'none';
                weekdays.style.display = 'none';
                leapSelector.style.display = 'none';
                picker.style.display = 'block';
                this.pickerYear = this.currentLunarYear;
                this.generateLunarMonthPicker();
            } else {
                calendarDays.style.display = 'grid';
                weekdays.style.display = 'grid';
                picker.style.display = 'none';
                this.generateLunarCalendar(this.currentLunarMonth, this.currentLunarYear);
            }
        }

        generateLunarMonthPicker() {
            const year = this.pickerYear || this.currentLunarYear;
            const pickerYearEl = this.calendar.querySelector('.lunar-picker-year');
            const monthGrid = this.calendar.querySelector('.lunar-month-grid');

            pickerYearEl.textContent = `Năm ${year} (Âm lịch)`;
            monthGrid.innerHTML = '';

            const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                              'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

            for (let i = 0; i < 12; i++) {
                const monthEl = document.createElement('div');
                monthEl.className = 'month-item';
                monthEl.textContent = monthNames[i];
                monthEl.dataset.month = i + 1;
                monthEl.style.cssText = `
                    padding: 10px;
                    text-align: center;
                    cursor: pointer;
                    border-radius: 8px;
                    transition: all 0.2s ease;
                    background: #f8f9fa;
                `;

                monthEl.addEventListener('mouseenter', () => {
                    monthEl.style.background = '#007bff';
                    monthEl.style.color = 'white';
                });

                monthEl.addEventListener('mouseleave', () => {
                    monthEl.style.background = '#f8f9fa';
                    monthEl.style.color = '';
                });

                monthEl.addEventListener('click', () => {
                    this.currentLunarMonth = i + 1;
                    this.currentLunarYear = year;
                    this.toggleLunarPicker();
                });

                monthGrid.appendChild(monthEl);
            }
        }

        showCalendar() {
            this.overlay.style.display = 'block';
            this.calendar.style.display = 'block';
            this.calendar.style.position = 'fixed';
            this.calendar.style.top = '50%';
            this.calendar.style.left = '50%';
            this.calendar.style.transform = 'translate(-50%, -50%)';
            this.calendar.style.zIndex = '9999';
            this.calendar.style.backgroundColor = 'white';
            this.calendar.style.borderRadius = '12px';
            this.calendar.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.3)';
            this.calendar.style.maxWidth = '400px';
            this.calendar.style.width = '90%';

            this.generateLunarCalendar(this.currentLunarMonth, this.currentLunarYear);
        }

        hideCalendar() {
            this.calendar.style.display = 'none';
            this.overlay.style.display = 'none';
        }

        changeMonth(direction) {
            // Cancel any pending request
            if (this.abortController) {
                this.abortController.abort();
            }

            // Clear any pending timeout
            clearTimeout(this.changeMonthTimeout);

            this.isLeapMonth = false;
            const normalRadio = this.calendar.querySelector('input[name="monthType"][value="normal"]');
            if (normalRadio) normalRadio.checked = true;

            this.currentLunarMonth += direction;
            if (this.currentLunarMonth < 1) {
                this.currentLunarMonth = 12;
                this.currentLunarYear--;
            } else if (this.currentLunarMonth > 12) {
                this.currentLunarMonth = 1;
                this.currentLunarYear++;
            }

            // Store the target month/year to prevent race conditions
            this.targetMonth = this.currentLunarMonth;
            this.targetYear = this.currentLunarYear;

            // Debounce the calendar generation
            this.changeMonthTimeout = setTimeout(() => {
                this.generateLunarCalendar(this.targetMonth, this.targetYear);
            }, 200);
        }

        async generateLunarCalendar(month, year, forceLeap = false) {
            // Verify this is still the target month (prevent race conditions)
            if (this.targetMonth && this.targetYear) {
                if (month !== this.targetMonth || year !== this.targetYear) {
                    console.log('Skipping outdated request for', month, year);
                    return;
                }
            }

            // Check cache first
            const cacheKey = `lunar-${year}-${month}-${forceLeap}`;
            if (this.cache.has(cacheKey)) {
                const cached = this.cache.get(cacheKey);
                // Use cache if less than 5 minutes old
                if (Date.now() - cached.timestamp < 5 * 60 * 1000) {
                    this.renderLunarCalendar(cached.data, month, year, forceLeap);
                    return;
                }
            }

            // Cancel previous request if exists
            if (this.abortController) {
                this.abortController.abort();
            }

            // Create new abort controller for this request
            this.abortController = new AbortController();

            // Rate limiting - wait at least 500ms between requests
            const now = Date.now();
            const timeSinceLastRequest = now - this.lastRequestTime;
            if (timeSinceLastRequest < this.minRequestInterval) {
                clearTimeout(this.changeMonthTimeout);
                this.changeMonthTimeout = setTimeout(() => {
                    this.generateLunarCalendar(month, year, forceLeap);
                }, this.minRequestInterval - timeSinceLastRequest);
                return;
            }

            this.isLoading = true;
            this.lastRequestTime = now;

            const daysContainer = this.calendar.querySelector('.lunar-calendar-days');
            const monthYear = this.calendar.querySelector('.lunar-month-year');
            const leapSelector = this.calendar.querySelector('#leapMonthSelector');

            // Show loading centered - Clear grid first
            daysContainer.style.display = 'flex';
            daysContainer.style.justifyContent = 'center';
            daysContainer.style.alignItems = 'center';
            daysContainer.style.minHeight = '240px';
            daysContainer.innerHTML = '<div style="text-align: center; padding: 20px;">Đang tải...</div>';

            const actualIsLeap = forceLeap || this.isLeapMonth;

            try {
                const response = await fetch(this.options.monthApiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        month: month,
                        year: year,
                        isLeap: actualIsLeap ? 1 : 0
                    }),
                    signal: this.abortController ? this.abortController.signal : undefined
                });

                if (!response.ok) {
                    if (response.status === 429) {
                        throw new Error('Quá nhiều yêu cầu. Vui lòng chờ một chút và thử lại.');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Cache the successful response
                this.cache.set(cacheKey, {
                    data: data,
                    timestamp: Date.now()
                });

                this.renderLunarCalendar(data, month, year, actualIsLeap);

            } catch (error) {
                // Ignore abort errors (user clicked too fast)
                if (error.name === 'AbortError') {
                    console.log('Request cancelled');
                    return;
                }

                console.error('Error fetching lunar calendar:', error);
                const daysContainer = this.calendar.querySelector('.lunar-calendar-days');
                daysContainer.style.display = 'flex';
                daysContainer.style.justifyContent = 'center';
                daysContainer.style.alignItems = 'center';
                daysContainer.style.minHeight = '240px';
                daysContainer.innerHTML = `<div style="text-align: center; color: #dc3545; padding: 20px;">${error.message || 'Lỗi kết nối'}</div>`;
            } finally {
                this.isLoading = false;
                this.abortController = null;
            }
        }

        renderLunarCalendar(data, month, year, actualIsLeap) {
            const daysContainer = this.calendar.querySelector('.lunar-calendar-days');
            const monthYear = this.calendar.querySelector('.lunar-month-year');
            const leapSelector = this.calendar.querySelector('#leapMonthSelector');

            // Reset container styles for grid display
            daysContainer.style.display = 'grid';
            daysContainer.style.gridTemplateColumns = 'repeat(7, 1fr)';
            daysContainer.style.justifyContent = '';
            daysContainer.style.alignItems = '';

            if (data.success) {
                    // Handle leap month selector
                    if (data.hasLeapMonth && data.leapMonthNumber === month) {
                        leapSelector.style.display = 'block';
                        const monthTypeRadios = leapSelector.querySelectorAll('input[name="monthType"]');
                        monthTypeRadios.forEach(radio => {
                            radio.onchange = () => {
                                this.isLeapMonth = (radio.value === 'leap');
                                this.generateLunarCalendar(month, year, this.isLeapMonth);
                            };
                        });
                    } else {
                        leapSelector.style.display = 'none';
                    }

                    // Update header
                    const leapText = actualIsLeap ? ' (nhuận)' : '';
                    monthYear.textContent = `Tháng ${month}${leapText} Âm lịch ${year}`;

                    // Clear and generate calendar
                    daysContainer.innerHTML = '';

                    // Add empty cells
                    for (let i = 0; i < data.firstDayOfWeek; i++) {
                        const emptyDiv = document.createElement('div');
                        emptyDiv.className = 'calendar-day empty';
                        daysContainer.appendChild(emptyDiv);
                    }

                    // Generate days
                    data.days.forEach(dayInfo => {
                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'calendar-day';
                        dayDiv.innerHTML = `
                            <div style="font-size: 18px; font-weight: bold;">${dayInfo.lunarDay}</div>
                            <div style="font-size: 10px; color: #666;">${dayInfo.solarDay}/${dayInfo.solarMonth}</div>
                        `;

                        dayDiv.onclick = () => {
                            this.selectLunarDate(dayInfo.lunarDay, month, year, actualIsLeap);
                        };

                        const dayOfWeek = parseInt(dayInfo.dayOfWeek);
                        if (dayOfWeek === 0 || dayOfWeek === 6) {
                            dayDiv.style.color = '#dc3545';
                        }

                        daysContainer.appendChild(dayDiv);
                    });
                }
            }

        async selectLunarDate(day, month, year, isLeap = false) {
            try {
                const response = await fetch(this.options.apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    },
                    body: JSON.stringify({
                        lunarDay: day,
                        lunarMonth: month,
                        lunarYear: year,
                        isLeap: isLeap ? 1 : 0
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const leapText = isLeap ? ' nhuận' : '';
                    const solarDate = `${String(data.solarDay).padStart(2, '0')}/${String(data.solarMonth).padStart(2, '0')}/${data.solarYear}`;
                    const lunarDisplay = `${day}/${month}${leapText}/${year} ÂL`;

                    this.input.value = `${solarDate} (${lunarDisplay})`;

                    // Store data
                    this.input.dataset.date = solarDate;
                    this.input.dataset.lunarDay = day;
                    this.input.dataset.lunarMonth = month;
                    this.input.dataset.lunarYear = year;
                    this.input.dataset.lunarLeap = isLeap ? '1' : '0';
                    this.input.dataset.solarDay = data.solarDay;
                    this.input.dataset.solarMonth = data.solarMonth;
                    this.input.dataset.solarYear = data.solarYear;

                    if (this.options.onChange) {
                        this.options.onChange(data, this.input.value);
                    }
                }
            } catch (error) {
                console.error('Error converting lunar to solar:', error);
            }

            this.hideCalendar();
        }

        async initializeCurrentMonth() {
            const today = new Date();
            try {
                const response = await fetch('/api/convert-solar-to-lunar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    },
                    body: JSON.stringify({
                        solarDay: today.getDate(),
                        solarMonth: today.getMonth() + 1,
                        solarYear: today.getFullYear()
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.currentLunarMonth = data.lunarMonth;
                    this.currentLunarYear = data.lunarYear;
                }
            } catch (error) {
                console.error('Error initializing lunar calendar:', error);
            }
        }

        async selectToday() {
            const today = new Date();
            try {
                const response = await fetch('/api/convert-solar-to-lunar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    },
                    body: JSON.stringify({
                        solarDay: today.getDate(),
                        solarMonth: today.getMonth() + 1,
                        solarYear: today.getFullYear()
                    })
                });

                const data = await response.json();
                if (data.success) {
                    await this.selectLunarDate(data.lunarDay, data.lunarMonth, data.lunarYear);
                }
            } catch (error) {
                console.error('Error selecting today:', error);
            }
        }

        clearDate() {
            this.input.value = '';
            delete this.input.dataset.lunarDay;
            delete this.input.dataset.lunarMonth;
            delete this.input.dataset.lunarYear;
            delete this.input.dataset.lunarLeap;
            delete this.input.dataset.solarDay;
            delete this.input.dataset.solarMonth;
            delete this.input.dataset.solarYear;

            if (this.options.onChange) {
                this.options.onChange(null, '');
            }

            this.hideCalendar();
        }

        getCSRFToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '';
        }

        destroy() {
            if (this.calendar) {
                this.calendar.remove();
            }
            if (this.overlay) {
                this.overlay.remove();
            }
        }
    }

    // ========== CALENDAR TYPE SWITCHER ==========
    class CalendarTypeSwitcher {
        constructor(options = {}) {
            this.options = {
                solarRadioId: options.solarRadioId || 'solarCalendar',
                lunarRadioId: options.lunarRadioId || 'lunarCalendar',
                inputId: options.inputId || 'dateInput',
                onChange: options.onChange || null,
                ...options
            };

            this.solarCalendar = null;
            this.lunarCalendar = null;
            this.currentType = 'solar';

            this.init();
        }

        init() {
            const solarRadio = document.getElementById(this.options.solarRadioId);
            const lunarRadio = document.getElementById(this.options.lunarRadioId);
            const input = document.getElementById(this.options.inputId);

            if (!solarRadio || !lunarRadio || !input) {
                console.error('Required elements not found');
                return;
            }

            // Initialize calendars with popup style
            this.solarCalendar = new SolarCalendarPicker({
                inputId: this.options.inputId,
                calendarId: `${this.options.inputId}_solar_calendar`,
                onChange: this.options.onChange,
                usePopup: true,
                defaultToToday: true
            });

            this.lunarCalendar = new LunarCalendarPicker({
                inputId: this.options.inputId,
                calendarId: `${this.options.inputId}_lunar_calendar`,
                onChange: this.options.onChange
            });

            // Setup radio button listeners
            solarRadio.addEventListener('change', () => {
                if (solarRadio.checked) {
                    this.switchToSolar();
                }
            });

            lunarRadio.addEventListener('change', () => {
                if (lunarRadio.checked) {
                    this.switchToLunar();
                }
            });

            // Initialize with solar by default
            if (solarRadio.checked) {
                this.switchToSolar();
            }
        }

        switchToSolar() {
            this.currentType = 'solar';
            const input = document.getElementById(this.options.inputId);

            // Clear input and update placeholder
            input.value = '';
            input.placeholder = 'Chọn ngày Dương lịch';
            input.dataset.calendarType = 'solar';

            // Rebind click event
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);

            // Reinitialize solar calendar with new input and popup style
            this.solarCalendar = new SolarCalendarPicker({
                inputId: this.options.inputId,
                calendarId: `${this.options.inputId}_solar_calendar`,
                onChange: this.options.onChange,
                usePopup: true,
                defaultToToday: false
            });
        }

        switchToLunar() {
            this.currentType = 'lunar';
            const input = document.getElementById(this.options.inputId);

            // Clear input and update placeholder
            input.value = '';
            input.placeholder = 'Chọn ngày Âm lịch';
            input.dataset.calendarType = 'lunar';

            // Rebind click event
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);

            // Reinitialize lunar calendar with new input
            this.lunarCalendar = new LunarCalendarPicker({
                inputId: this.options.inputId,
                calendarId: `${this.options.inputId}_lunar_calendar`,
                onChange: this.options.onChange
            });
        }

        getCurrentType() {
            return this.currentType;
        }

        getValue() {
            const input = document.getElementById(this.options.inputId);
            return input ? input.value : '';
        }

        destroy() {
            if (this.solarCalendar) {
                this.solarCalendar.destroy();
            }
            if (this.lunarCalendar) {
                this.lunarCalendar.destroy();
            }
        }
    }

    // ========== DATE RANGE PICKER MODULE ==========
    class DateRangePicker {
        constructor(options = {}) {
            this.options = {
                inputId: options.inputId || 'dateRangeInput',
                format: options.format || 'DD/MM/YY',
                separator: options.separator || ' - ',
                onChange: options.onChange || null,
                singleDatePicker: options.singleDatePicker || false,
                ...options
            };

            this.init();
        }

        init() {
            const input = document.getElementById(this.options.inputId);
            if (!input) {
                console.error(`Input element with id "${this.options.inputId}" not found`);
                return;
            }

            // Check if daterangepicker library is available
            if (typeof $ === 'undefined' || !$.fn.daterangepicker) {
                console.error('jQuery daterangepicker library not found');
                return;
            }

            // Initialize daterangepicker
            $(input).daterangepicker({
                singleDatePicker: this.options.singleDatePicker,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: this.options.format,
                    separator: this.options.separator,
                    applyLabel: 'Áp dụng',
                    cancelLabel: 'Hủy',
                    fromLabel: 'Từ',
                    toLabel: 'Đến',
                    weekLabel: 'W',
                    customRangeLabel: 'Tùy chọn',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    firstDay: 1
                }
            });

            // Handle change event
            $(input).on('apply.daterangepicker', (ev, picker) => {
                if (this.options.onChange) {
                    const startDate = picker.startDate.format('DD/MM/YYYY');
                    const endDate = picker.endDate.format('DD/MM/YYYY');
                    this.options.onChange({
                        startDate: startDate,
                        endDate: endDate,
                        value: input.value
                    });
                }
            });
        }

        getValue() {
            const input = document.getElementById(this.options.inputId);
            return input ? input.value : '';
        }

        getDateRange() {
            const value = this.getValue();
            if (!value) return { start: null, end: null };

            const parts = value.split(this.options.separator);
            if (parts.length !== 2) return { start: null, end: null };

            return {
                start: this.parseDate(parts[0].trim()),
                end: this.parseDate(parts[1].trim())
            };
        }

        parseDate(dateStr) {
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

        destroy() {
            const input = document.getElementById(this.options.inputId);
            if (input && $.fn.daterangepicker) {
                $(input).data('daterangepicker').remove();
            }
        }
    }

    // ========== UTILITY FUNCTIONS ==========
    const DatePickerUtils = {
        formatDate(date, format = 'dd/mm/yyyy') {
            if (!date) return '';
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();

            return format
                .replace('dd', day)
                .replace('mm', month)
                .replace('yyyy', year)
                .replace('yy', String(year).slice(-2));
        },

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
        },

        validateDateRange(startDate, endDate) {
            if (!startDate || !endDate) return true;
            const start = new Date(startDate);
            const end = new Date(endDate);
            return start <= end;
        }
    };

    // ========== EXPORT MODULES ==========
    window.DatePicker = {
        SolarCalendar: SolarCalendarPicker,
        LunarCalendar: LunarCalendarPicker,
        CalendarSwitcher: CalendarTypeSwitcher,
        DateRange: DateRangePicker,
        Utils: DatePickerUtils
    };

})(window);