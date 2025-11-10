/**
 * Lunar-Solar Date Select Module
 * Reusable module for date selection with lunar/solar calendar support
 * Version: 2.0
 */

(function(window) {
    'use strict';

    class LunarSolarDateSelect {
        constructor(options = {}) {
            this.options = {
                daySelectId: options.daySelectId || 'ngaySelect',
                monthSelectId: options.monthSelectId || 'thangSelect',
                yearSelectId: options.yearSelectId || 'namSelect',
                hiddenInputId: options.hiddenInputId || 'ngayXem',
                solarRadioId: options.solarRadioId || 'solarCalendar',
                lunarRadioId: options.lunarRadioId || 'lunarCalendar',
                leapCheckboxId: options.leapCheckboxId || 'leapMonth',
                leapContainerId: options.leapContainerId || 'leapMonthContainer',
                monthInfoContainerId: options.monthInfoContainerId || 'monthInfoContainer',
                monthDaysInfoId: options.monthDaysInfoId || 'monthDaysInfo',
                defaultDay: options.defaultDay || 1,
                defaultMonth: options.defaultMonth || 1,
                defaultYear: options.defaultYear || 1945,
                yearRangeStart: options.yearRangeStart || 1900,
                yearRangeEnd: options.yearRangeEnd || new Date().getFullYear(),
                lunarApiUrl: options.lunarApiUrl || '/api/lunar-solar-convert',
                lunarMonthDaysUrl: options.lunarMonthDaysUrl || '/api/get-lunar-month-days',
                onChange: options.onChange || null,
                onCalendarTypeChange: options.onCalendarTypeChange || null,
                csrfToken: options.csrfToken || ''
            };

            this.daySelect = null;
            this.monthSelect = null;
            this.yearSelect = null;
            this.hiddenInput = null;
            this.solarRadio = null;
            this.lunarRadio = null;
            this.leapCheckbox = null;
            this.leapContainer = null;
            this.monthInfoContainer = null;
            this.monthDaysInfo = null;
            this.isLunar = false;
            this.isLeapMonth = false;
            this.hasLeapMonth = false;

            this.init();
        }

        init() {
            // Get DOM elements
            this.daySelect = document.getElementById(this.options.daySelectId);
            this.monthSelect = document.getElementById(this.options.monthSelectId);
            this.yearSelect = document.getElementById(this.options.yearSelectId);
            this.hiddenInput = document.getElementById(this.options.hiddenInputId);
            this.solarRadio = document.getElementById(this.options.solarRadioId);
            this.lunarRadio = document.getElementById(this.options.lunarRadioId);
            this.leapCheckbox = document.getElementById(this.options.leapCheckboxId);
            this.leapContainer = document.getElementById(this.options.leapContainerId);
            this.monthInfoContainer = document.getElementById(this.options.monthInfoContainerId);
            this.monthDaysInfo = document.getElementById(this.options.monthDaysInfoId);

            if (!this.daySelect || !this.monthSelect || !this.yearSelect) {
                console.error('Date select elements not found');
                return;
            }

            // Initialize select options
            this.initializeSelects();

            // Set up event listeners
            this.setupEventListeners();

            // Set default values
            this.setDefaultValues();

            // Update hidden input with initial value
            this.updateHiddenInput();
        }

        initializeSelects() {
            // Populate year select first
            this.populateYearSelect();

            // Populate month select (will check for leap months if lunar)
            this.populateMonthSelect();

            // Populate day select
            this.populateDaySelect(31);
        }

        populateDaySelect(maxDays) {
            const currentValue = this.daySelect.value;
            this.daySelect.innerHTML = '<option value="" disabled>Ngày</option>';

            for (let i = 1; i <= maxDays; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = String(i).padStart(2, '0');
                this.daySelect.appendChild(option);
            }

            // Restore previous value if valid
            if (currentValue && currentValue <= maxDays) {
                this.daySelect.value = currentValue;
            } else if (this.options.defaultDay <= maxDays) {
                this.daySelect.value = this.options.defaultDay;
            }
        }

        async populateMonthSelect() {
            const year = parseInt(this.yearSelect.value) || this.options.defaultYear;
            const currentMonth = this.monthSelect.value; // Lưu tháng hiện tại
            const currentIsLeap = this.isLeapMonth; // Lưu trạng thái tháng nhuận hiện tại

            // Show loading state when lunar calendar and need to check for leap months
            if (this.isLunar) {
                this.monthSelect.innerHTML = '<option value="">Đang tải...</option>';
                this.monthSelect.disabled = true;
            } else {
                this.monthSelect.innerHTML = '<option value="" disabled>Tháng</option>';
            }

            if (!this.isLunar) {
                this.monthSelect.innerHTML = '<option value="" disabled>Tháng</option>';
                // Solar calendar - simple 12 months
                for (let i = 1; i <= 12; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `Tháng ${i}`;
                    this.monthSelect.appendChild(option);
                }

                // Khôi phục tháng đã chọn trước đó (nếu có)
                if (currentMonth && currentMonth !== '') {
                    this.monthSelect.value = currentMonth;
                } else {
                    this.monthSelect.value = this.options.defaultMonth;
                }
            } else {
                // Lunar calendar - check for leap month
                let leapMonthNumber = 0;

                // Check which month has leap version in this year
                for (let m = 1; m <= 12; m++) {
                    try {
                        const response = await fetch(this.options.lunarMonthDaysUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.options.csrfToken
                            },
                            body: JSON.stringify({
                                month: m,
                                year: year,
                                isLeap: 1
                            })
                        });

                        const data = await response.json();
                        if (data.success && data.days > 0) {
                            leapMonthNumber = m;
                            break;
                        }
                    } catch (error) {
                        console.error('Error checking leap month:', error);
                    }
                }

                // Reset dropdown and re-enable
                this.monthSelect.innerHTML = '<option value="" disabled>Tháng</option>';
                this.monthSelect.disabled = false;

                // Add all months including leap month if exists
                for (let i = 1; i <= 12; i++) {
                    // Add normal month
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `Tháng ${i}`;
                    option.dataset.isLeap = '0';
                    this.monthSelect.appendChild(option);

                    // Add leap month after the normal month if it exists
                    if (i === leapMonthNumber) {
                        const leapOption = document.createElement('option');
                        leapOption.value = i;
                        leapOption.textContent = `Tháng ${i} nhuận`;
                        leapOption.dataset.isLeap = '1';
                        this.monthSelect.appendChild(leapOption);
                    }
                }

                // Khôi phục tháng đã chọn trước đó (bao gồm cả tháng nhuận)
                if (currentMonth && currentMonth !== '') {
                    // Tìm option phù hợp với tháng và trạng thái nhuận
                    let optionFound = false;
                    for (let i = 0; i < this.monthSelect.options.length; i++) {
                        const option = this.monthSelect.options[i];
                        if (option.value == currentMonth) {
                            if ((currentIsLeap && option.dataset.isLeap === '1') ||
                                (!currentIsLeap && option.dataset.isLeap !== '1')) {
                                this.monthSelect.selectedIndex = i;
                                optionFound = true;
                                break;
                            }
                        }
                    }

                    // Nếu không tìm thấy option phù hợp (ví dụ: năm mới không có tháng nhuận),
                    // chọn tháng thường cùng số
                    if (!optionFound) {
                        this.monthSelect.value = currentMonth;
                        this.isLeapMonth = false; // Reset về tháng thường
                    }
                } else {
                    this.monthSelect.value = this.options.defaultMonth;
                }
            }
        }

        populateYearSelect() {
            this.yearSelect.innerHTML = '<option value="" disabled>Năm</option>';

            for (let year = this.options.yearRangeEnd; year >= this.options.yearRangeStart; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                this.yearSelect.appendChild(option);
            }

            this.yearSelect.value = this.options.defaultYear;
        }

        setDefaultValues() {
            // Check if hidden input has existing value to preserve
            const existingValue = this.hiddenInput.value;
            if (existingValue && existingValue.trim() !== '') {
                console.log('📅 Preserving existing date value:', existingValue);
                this.parseAndSetExistingValue(existingValue);
                return;
            }

            // Only set defaults if no existing value
            console.log('📅 Setting default values (no existing value found)');
            this.daySelect.value = this.options.defaultDay;
            this.monthSelect.value = this.options.defaultMonth;
            this.yearSelect.value = this.options.defaultYear;
        }

        parseAndSetExistingValue(value) {
            // Parse existing value and set selects accordingly
            try {
                // Remove lunar indicators
                const cleanValue = value.replace(' (ÂL)', '').replace(' (ÂL-Nhuận)', '');

                // Check if it's lunar
                const isLunar = value.includes('(ÂL)');
                const isLeapMonth = value.includes('(ÂL-Nhuận)');

                // Parse date parts (format: DD/MM/YYYY)
                const parts = cleanValue.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0]);
                    const month = parseInt(parts[1]);
                    const year = parseInt(parts[2]);

                    // Set calendar type
                    if (isLunar && this.lunarRadio) {
                        this.lunarRadio.checked = true;
                        this.isLunar = true;
                        if (this.solarRadio) this.solarRadio.checked = false;
                    } else if (this.solarRadio) {
                        this.solarRadio.checked = true;
                        this.isLunar = false;
                        if (this.lunarRadio) this.lunarRadio.checked = false;
                    }

                    // Set leap month if applicable
                    if (isLeapMonth && this.leapCheckbox) {
                        this.leapCheckbox.checked = true;
                        this.isLeapMonth = true;
                    }

                    // Set select values
                    this.yearSelect.value = year;
                    this.monthSelect.value = month;
                    this.daySelect.value = day;

                    console.log('📅 Parsed and set existing value:', { day, month, year, isLunar, isLeapMonth });
                }
            } catch (error) {
                console.error('Error parsing existing date value:', error);
                // Fallback to defaults
                this.daySelect.value = this.options.defaultDay;
                this.monthSelect.value = this.options.defaultMonth;
                this.yearSelect.value = this.options.defaultYear;
            }
        }

        setupEventListeners() {
            // Date select changes
            this.daySelect.addEventListener('change', async () => await this.handleDateChange());
            this.monthSelect.addEventListener('change', async () => {
                // Check if selected option is leap month
                const selectedOption = this.monthSelect.options[this.monthSelect.selectedIndex];
                if (this.isLunar && selectedOption && selectedOption.dataset.isLeap === '1') {
                    this.isLeapMonth = true;
                    if (this.leapCheckbox) {
                        this.leapCheckbox.checked = true;
                    }
                } else {
                    this.isLeapMonth = false;
                    if (this.leapCheckbox) {
                        this.leapCheckbox.checked = false;
                    }
                }

                await this.updateDaysInMonth();
                await this.handleDateChange();
                // Update month info when month changes
                this.updateMonthInfoAfterSelection();
            });
            this.yearSelect.addEventListener('change', async () => {
                // Repopulate months when year changes (for lunar calendar to show leap months)
                if (this.isLunar) {
                    await this.populateMonthSelect();
                }
                await this.updateDaysInMonth();
                await this.handleDateChange();
                // Update month info when year changes
                this.updateMonthInfoAfterSelection();
            });

            // Calendar type changes
            if (this.solarRadio) {
                this.solarRadio.addEventListener('change', async () => {
                    if (this.solarRadio.checked) {
                        this.isLunar = false;
                        this.isLeapMonth = false;
                        this.hideLeapOption();
                        await this.populateMonthSelect();
                        await this.updateDaysInMonth();
                        this.handleCalendarTypeChange();
                        this.updateMonthInfoAfterSelection();
                    }
                });
            }

            if (this.lunarRadio) {
                this.lunarRadio.addEventListener('change', async () => {
                    if (this.lunarRadio.checked) {
                        this.isLunar = true;
                        await this.populateMonthSelect();
                        await this.updateDaysInMonth();
                        this.handleCalendarTypeChange();
                        this.updateMonthInfoAfterSelection();
                    }
                });
            }

            // Leap month checkbox (hidden but kept for compatibility)
            if (this.leapCheckbox) {
                this.leapCheckbox.addEventListener('change', async () => {
                    this.isLeapMonth = this.leapCheckbox.checked;
                    await this.updateDaysInMonth();
                    await this.handleDateChange();
                });
            }
        }

        async updateDaysInMonth() {
            const month = parseInt(this.monthSelect.value) || 1;
            const year = parseInt(this.yearSelect.value) || 1945;
            const currentDay = parseInt(this.daySelect.value);

            // Get leap status from selected option
            const selectedOption = this.monthSelect.options[this.monthSelect.selectedIndex];
            let isLeapForApi = false;
            if (this.isLunar && selectedOption && selectedOption.dataset.isLeap === '1') {
                this.isLeapMonth = true;
                isLeapForApi = true;
            } else if (this.isLunar) {
                this.isLeapMonth = false;
                isLeapForApi = false;
            }

            let daysInMonth = 31;

            if (!this.isLunar) {
                // Solar calendar calculation
                if (month === 2) {
                    daysInMonth = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0) ? 29 : 28;
                } else if ([4, 6, 9, 11].includes(month)) {
                    daysInMonth = 30;
                }
            } else {
                // Lunar calendar - get actual days from API
                try {
                    const response = await fetch(this.options.lunarMonthDaysUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.options.csrfToken
                        },
                        body: JSON.stringify({
                            month: month,
                            year: year,
                            isLeap: isLeapForApi ? 1 : 0
                        })
                    });

                    const data = await response.json();
                 
                    if (data.success && data.days > 0) {
                        daysInMonth = data.days;
                       
                    } else {
                        // Default fallback for lunar months
                        // Most lunar months have 29 or 30 days
                        daysInMonth = 29;
                        console.warn(`Could not get days for lunar month ${month}/${year}, using default ${daysInMonth}`);
                    }
                } catch (error) {
                    console.error('Error getting lunar month days:', error);
                    daysInMonth = 29;
                }
            }

            this.populateDaySelect(daysInMonth);

            // Restore day if still valid
            if (currentDay && currentDay <= daysInMonth) {
                this.daySelect.value = currentDay;
            }

            // Update month info display
            this.updateMonthInfoDisplay(daysInMonth);
        }

        async checkLeapMonth() {
            // This method is now deprecated as leap months are shown directly in the month select
            // Kept for backward compatibility
            this.hideLeapOption();
        }

        showLeapOption() {
            if (this.leapContainer) {
                this.leapContainer.style.display = 'block';
            }
        }

        hideLeapOption() {
            // Hide the separate leap month checkbox since we're using month select
            if (this.leapContainer) {
                this.leapContainer.style.display = 'none';
            }
            if (this.leapCheckbox) {
                this.leapCheckbox.checked = false;
            }
            // Don't reset isLeapMonth here as it might be set by month select
        }

        async handleDateChange() {
            await this.updateHiddenInput();

            if (this.options.onChange) {
                this.options.onChange(this.getSelectedDate());
            }
        }

        handleCalendarTypeChange() {
            this.updateHiddenInput();

            if (this.options.onCalendarTypeChange) {
                this.options.onCalendarTypeChange(this.isLunar);
            }
        }

        async updateHiddenInput() {
            const day = this.daySelect.value;
            const month = this.monthSelect.value;
            const year = this.yearSelect.value;

            if (!this.hiddenInput) return;

            if (day && month && year) {
                const formattedDay = String(day).padStart(2, '0');
                const formattedMonth = String(month).padStart(2, '0');
                const formattedYear = String(year);

                let displayString = `${formattedDay}/${formattedMonth}/${formattedYear}`;
                let actualValue = displayString; // Default to same as display

                if (this.isLunar) {
                    // Check if current selection is leap month
                    const selectedOption = this.monthSelect.options[this.monthSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.isLeap === '1') {
                        displayString += ' (ÂL-Nhuận)';
                        this.isLeapMonth = true;
                    } else {
                        displayString += ' (ÂL)';
                        this.isLeapMonth = false;
                    }

                    // Convert lunar to solar for the actual value
                    try {
                        const response = await fetch(this.options.lunarApiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.options.csrfToken
                            },
                            body: JSON.stringify({
                                day: parseInt(day),
                                month: parseInt(month),
                                year: parseInt(year),
                                type: 'lunar-to-solar',
                                isLeap: this.isLeapMonth
                            })
                        });

                        const result = await response.json();
                        if (result.success) {
                            // Use solar date as the actual value
                            actualValue = `${String(result.day).padStart(2, '0')}/${String(result.month).padStart(2, '0')}/${result.year}`;

                            // Store both lunar and solar info
                            this.hiddenInput.dataset.lunarDay = day;
                            this.hiddenInput.dataset.lunarMonth = month;
                            this.hiddenInput.dataset.lunarYear = year;
                            this.hiddenInput.dataset.lunarLeap = this.isLeapMonth ? '1' : '0';
                            this.hiddenInput.dataset.solarDay = result.day;
                            this.hiddenInput.dataset.solarMonth = result.month;
                            this.hiddenInput.dataset.solarYear = result.year;
                        }
                    } catch (error) {
                        console.error('Error converting lunar to solar:', error);
                    }
                } else {
                    // Solar date - use as is
                    this.hiddenInput.dataset.solarDay = day;
                    this.hiddenInput.dataset.solarMonth = month;
                    this.hiddenInput.dataset.solarYear = year;
                    // Clear lunar data
                    delete this.hiddenInput.dataset.lunarDay;
                    delete this.hiddenInput.dataset.lunarMonth;
                    delete this.hiddenInput.dataset.lunarYear;
                    delete this.hiddenInput.dataset.lunarLeap;
                }

                // Set display value (with ÂL marker if lunar)
                this.hiddenInput.dataset.displayValue = displayString;
                // Set actual value (always solar date for backend)
                this.hiddenInput.value = actualValue;
                this.hiddenInput.dataset.calendarType = this.isLunar ? 'lunar' : 'solar';
            } else {
                this.hiddenInput.value = '';
            }
        }

        getSelectedDate() {
            return {
                day: this.daySelect.value,
                month: this.monthSelect.value,
                year: this.yearSelect.value,
                formatted: this.hiddenInput.value,
                isLunar: this.isLunar,
                isLeapMonth: this.isLeapMonth,
                calendarType: this.isLunar ? 'lunar' : 'solar'
            };
        }

        async setDate(day, month, year, isLunar = false, isLeapMonth = false) {
            this.yearSelect.value = year;

            if (isLunar && this.lunarRadio) {
                this.lunarRadio.checked = true;
                this.isLunar = true;
                await this.populateMonthSelect();

                // Find and select the correct month (normal or leap)
                for (let i = 0; i < this.monthSelect.options.length; i++) {
                    const option = this.monthSelect.options[i];
                    if (option.value == month) {
                        if ((isLeapMonth && option.dataset.isLeap === '1') ||
                            (!isLeapMonth && option.dataset.isLeap !== '1')) {
                            this.monthSelect.selectedIndex = i;
                            this.isLeapMonth = isLeapMonth;
                            break;
                        }
                    }
                }
            } else if (this.solarRadio) {
                this.solarRadio.checked = true;
                this.isLunar = false;
                await this.populateMonthSelect();
                this.monthSelect.value = month;
            }

            await this.updateDaysInMonth();
            this.daySelect.value = day;
            this.updateHiddenInput();
        }

        reset() {
            this.setDate(
                this.options.defaultDay,
                this.options.defaultMonth,
                this.options.defaultYear,
                false,
                false
            );
        }

        // Convert current date to solar if lunar
        async convertToSolar() {
            if (!this.isLunar) return this.getSelectedDate();

            const date = this.getSelectedDate();

            try {
                const response = await fetch(this.options.lunarApiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.options.csrfToken
                    },
                    body: JSON.stringify({
                        day: date.day,
                        month: date.month,
                        year: date.year,
                        type: 'lunar-to-solar'
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    return result;
                }
            } catch (error) {
                console.error('Error converting lunar to solar:', error);
            }

            return date;
        }
        updateMonthInfoDisplay(daysInMonth) {
            if (this.monthInfoContainer && this.monthDaysInfo) {
                const month = parseInt(this.monthSelect.value);
                const year = parseInt(this.yearSelect.value);

                if (month && year) {
                    const selectedOption = this.monthSelect.options[this.monthSelect.selectedIndex];
                    let monthTypeText = '';

                    if (this.isLunar) {
                        if (selectedOption && selectedOption.dataset.isLeap === '1') {
                            monthTypeText = ` (Âm lịch - Tháng nhuận)`;
                        } else {
                            monthTypeText = ` (Âm lịch)`;
                        }
                    } else {
                        monthTypeText = ` (Dương lịch)`;
                    }

                    // Format month display for leap months
                    let monthDisplay = month;
                    if (this.isLunar && selectedOption && selectedOption.dataset.isLeap === '1') {
                        monthDisplay = `${month} nhuận`;
                    }

                    this.monthDaysInfo.textContent = `Tháng ${monthDisplay}/${year}${monthTypeText} có ${daysInMonth} ngày`;
                    // Display with neutral color - both 29 and 30 days are normal for lunar months
                    this.monthDaysInfo.style.color = '#333';
                    this.monthInfoContainer.style.display = 'block';
                } else {
                    this.monthInfoContainer.style.display = 'none';
                }
            }
        }

        updateMonthInfoAfterSelection() {
            // Get current days in month from day select
            const dayOptions = this.daySelect.options;
            const daysInMonth = dayOptions.length - 1; // Exclude the placeholder option

            if (daysInMonth > 0) {
                this.updateMonthInfoDisplay(daysInMonth);
            }
        }
    }

    // Export to window
    window.LunarSolarDateSelect = LunarSolarDateSelect;

})(window);