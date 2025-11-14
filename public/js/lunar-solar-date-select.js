/**
 * Lunar-Solar Date Select Module
 * Reusable module for date selection with lunar/solar calendar support
 * Version: 2.0
 */

(function(window) {
    'use strict';

    class LunarSolarDateSelect {
        constructor(options = {}) {
            // Create unique instance ID for debugging and state isolation
            this.instanceId = `lsd_${Math.random().toString(36).substr(2, 9)}`;

            // Flag to prevent API calls during initialization
            this.isInitializing = true;

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
                defaultYear: options.defaultYear || 2000,
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

            // Initialize cache for leap months and year data
            if (!window.leapMonthsCache) window.leapMonthsCache = {};
            if (!window.yearMonthDataCache) window.yearMonthDataCache = {};

            // Initialize asynchronously to handle existing values properly
            this.init().catch(error => {
                console.error('Error initializing LunarSolarDateSelect:', error);
            });
        }

        async init() {
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

            // Set default values (async to handle existing values)
            const hasExistingValue = await this.setDefaultValues();

            // Update hidden input with initial value only if no existing value was parsed
            if (!hasExistingValue) {
                await this.updateHiddenInput();
            }

            // Mark initialization as complete
            this.isInitializing = false;
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
                // Lunar calendar - use cached year data for leap months
                let leapMonths = [];

                // Try to get cached data first
                if (window.leapMonthsCache && window.leapMonthsCache[year]) {
                    leapMonths = window.leapMonthsCache[year];
                } else {
                    // Get all leap months for the year in one API call
                    try {
                        const response = await fetch('/api/get-year-leap-months', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.options.csrfToken
                            },
                            body: JSON.stringify({
                                year: year
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            leapMonths = data.leapMonths;

                            // Cache the result for future use
                            if (!window.leapMonthsCache) window.leapMonthsCache = {};
                            window.leapMonthsCache[year] = leapMonths;

                            // Also cache full month data for getDaysInMonth optimization
                            if (!window.yearMonthDataCache) window.yearMonthDataCache = {};
                            window.yearMonthDataCache[year] = data.allMonthsData;
                        }
                    } catch (error) {
                        console.error('Error getting leap months for year:', error);
                        leapMonths = [];
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
                    if (leapMonths.includes(i)) {
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

        async setDefaultValues() {
            // Check if hidden input has existing value to preserve
            const existingValue = this.hiddenInput.value;
            if (existingValue && existingValue.trim() !== '') {
                await this.parseAndSetExistingValue(existingValue);
                return true; // Indicates existing value was parsed
            }

            // Only set defaults if they are provided (not null/undefined)
            if (this.options.defaultDay !== null && this.options.defaultDay !== undefined) {
                this.daySelect.value = this.options.defaultDay;
            }
            if (this.options.defaultMonth !== null && this.options.defaultMonth !== undefined) {
                this.monthSelect.value = this.options.defaultMonth;
            }
            if (this.options.defaultYear !== null && this.options.defaultYear !== undefined) {
                this.yearSelect.value = this.options.defaultYear;
            }
            return false; // Indicates defaults were set
        }

        async parseAndSetExistingValue(value) {
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

                  

                    // Set calendar type first
                    if (isLunar && this.lunarRadio) {
                        this.lunarRadio.checked = true;
                        this.isLunar = true;
                        this.isLeapMonth = isLeapMonth;
                        if (this.solarRadio) this.solarRadio.checked = false;
                    } else if (this.solarRadio) {
                        this.solarRadio.checked = true;
                        this.isLunar = false;
                        this.isLeapMonth = false;
                        if (this.lunarRadio) this.lunarRadio.checked = false;
                    }

                    // Set leap month state
                    if (isLeapMonth && this.leapCheckbox) {
                        this.leapCheckbox.checked = true;
                    } else if (this.leapCheckbox) {
                        this.leapCheckbox.checked = false;
                    }

                    // Set year first
                    this.yearSelect.value = year;

                    // Populate month select with proper lunar/solar months
                    if (this.isLunar) {
                        await this.populateMonthSelect();
                    }

                    // Set month (including leap month if applicable)
                    if (this.isLunar && isLeapMonth) {
                        // Find the leap month option
                        for (let i = 0; i < this.monthSelect.options.length; i++) {
                            const option = this.monthSelect.options[i];
                            if (option.value == month && option.dataset.isLeap === '1') {
                                this.monthSelect.selectedIndex = i;
                                break;
                            }
                        }
                    } else {
                        this.monthSelect.value = month;
                    }

                    // Update days in month
                    await this.updateDaysInMonth();

                    // Set day
                    this.daySelect.value = day;

                    // Pre-populate solar data if lunar calendar to avoid duplicate API calls
                    if (this.isLunar && this.hiddenInput.value && this.hiddenInput.value.trim() !== '') {
                        // Extract solar date from existing value
                        const solarParts = this.hiddenInput.value.split('/');
                        if (solarParts.length === 3) {
                            this.hiddenInput.dataset.solarDay = parseInt(solarParts[0]);
                            this.hiddenInput.dataset.solarMonth = parseInt(solarParts[1]);
                            this.hiddenInput.dataset.solarYear = parseInt(solarParts[2]);
                            this.hiddenInput.dataset.lunarDay = day;
                            this.hiddenInput.dataset.lunarMonth = month;
                            this.hiddenInput.dataset.lunarYear = year;
                            this.hiddenInput.dataset.lunarLeap = isLeapMonth ? '1' : '0';
                            this.hiddenInput.dataset.calendarType = 'lunar';
                            this.hiddenInput.dataset.displayValue = `${String(day).padStart(2, '0')}/${String(month).padStart(2, '0')}/${year}${isLeapMonth ? ' (ÂL-Nhuận)' : ' (ÂL)'}`;
                          
                        }
                    }

                  
                }
            } catch (error) {
                console.error('❌ Error parsing existing date value:', error);
                // Fallback to defaults only if they are defined
                if (this.options.defaultDay !== null && this.options.defaultDay !== undefined) {
                    this.daySelect.value = this.options.defaultDay;
                }
                if (this.options.defaultMonth !== null && this.options.defaultMonth !== undefined) {
                    this.monthSelect.value = this.options.defaultMonth;
                }
                if (this.options.defaultYear !== null && this.options.defaultYear !== undefined) {
                    this.yearSelect.value = this.options.defaultYear;
                }
            }
        }

        setupEventListeners() {
            // Bind methods to preserve 'this' context
            const boundHandleMonthChange = this.handleMonthChange.bind(this);
            const boundHandleYearChange = this.handleYearChange.bind(this);
            const boundHandleSolarRadioChange = this.handleSolarRadioChange.bind(this);
            const boundHandleLunarRadioChange = this.handleLunarRadioChange.bind(this);

            // Date select changes
            this.daySelect.addEventListener('change', async () => await this.handleDateChange());
            this.monthSelect.addEventListener('change', boundHandleMonthChange);
            this.yearSelect.addEventListener('change', boundHandleYearChange);

            // Calendar type changes
            if (this.solarRadio) {
                this.solarRadio.addEventListener('change', boundHandleSolarRadioChange);
            }

            if (this.lunarRadio) {
                this.lunarRadio.addEventListener('change', boundHandleLunarRadioChange);
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

        async handleMonthChange() {
            // Update leap month state based on current instance's month selection
            this.updateLeapMonthState();
            await this.updateDaysInMonth();
            if (!this.isInitializing) {
                await this.handleDateChange();
            }
            this.updateMonthInfoAfterSelection();
        }

        async handleYearChange() {
            // Repopulate months when year changes (for lunar calendar to show leap months)
            if (this.isLunar) {
                await this.populateMonthSelect();
            }
            await this.updateDaysInMonth();
            if (!this.isInitializing) {
                await this.handleDateChange();
            }
            this.updateMonthInfoAfterSelection();
        }

        async handleSolarRadioChange() {
            if (this.solarRadio.checked && this.isLunar) {
               

                // Get current lunar date before conversion
                const currentDay = parseInt(this.daySelect.value);
                const currentMonth = parseInt(this.monthSelect.value);
                const currentYear = parseInt(this.yearSelect.value);

                // Convert current lunar date to corresponding solar date
                if (currentDay && currentMonth && currentYear) {
                    try {
                        const response = await fetch(this.options.lunarApiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.options.csrfToken
                            },
                            body: JSON.stringify({
                                day: currentDay,
                                month: currentMonth,
                                year: currentYear,
                                type: 'lunar-to-solar',
                                isLeap: this.isLeapMonth
                            })
                        });

                        const result = await response.json();
                        if (result.success) {
                            // Switch to solar calendar
                            this.isLunar = false;
                            this.isLeapMonth = false;
                            this.hideLeapOption();
                            await this.populateMonthSelect();

                            // Set the converted solar date
                            this.yearSelect.value = result.year;
                            this.monthSelect.value = result.month;
                            await this.updateDaysInMonth();
                            this.daySelect.value = result.day;

                           
                        } else {
                            throw new Error('Conversion failed');
                        }
                    } catch (error) {
                        console.error('Error converting lunar to solar:', error);
                        // Fallback: just switch calendar type without conversion
                        this.isLunar = false;
                        this.isLeapMonth = false;
                        this.hideLeapOption();
                        await this.populateMonthSelect();
                        await this.updateDaysInMonth();
                    }
                } else {
                    // No date selected, just switch calendar type
                    this.isLunar = false;
                    this.isLeapMonth = false;
                    this.hideLeapOption();
                    await this.populateMonthSelect();
                    await this.updateDaysInMonth();
                }

                this.handleCalendarTypeChange();
                this.updateMonthInfoAfterSelection();
            }
        }

        async handleLunarRadioChange() {
            if (this.lunarRadio.checked && !this.isLunar) {
               

                // Get current solar date before conversion
                const currentDay = parseInt(this.daySelect.value);
                const currentMonth = parseInt(this.monthSelect.value);
                const currentYear = parseInt(this.yearSelect.value);

                // Convert current solar date to corresponding lunar date
                if (currentDay && currentMonth && currentYear) {
                    try {
                        const response = await fetch(this.options.lunarApiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.options.csrfToken
                            },
                            body: JSON.stringify({
                                day: currentDay,
                                month: currentMonth,
                                year: currentYear,
                                type: 'solar-to-lunar'
                            })
                        });

                        const result = await response.json();
                        if (result.success) {
                            // Switch to lunar calendar
                            this.isLunar = true;
                            await this.populateMonthSelect();

                            // Set the converted lunar date
                            this.yearSelect.value = result.year;

                            // Find and select the correct month (including leap month)
                            this.isLeapMonth = result.isLeap || false;
                            const targetMonth = result.month;

                            // Select the appropriate month option (normal or leap)
                            for (let i = 0; i < this.monthSelect.options.length; i++) {
                                const option = this.monthSelect.options[i];
                                if (option.value == targetMonth) {
                                    if ((this.isLeapMonth && option.dataset.isLeap === '1') ||
                                        (!this.isLeapMonth && option.dataset.isLeap !== '1')) {
                                        this.monthSelect.selectedIndex = i;
                                        break;
                                    }
                                }
                            }

                            await this.updateDaysInMonth();
                            this.daySelect.value = result.day;

                          
                        } else {
                            throw new Error('Conversion failed');
                        }
                    } catch (error) {
                        console.error('Error converting solar to lunar:', error);
                        // Fallback: just switch calendar type without conversion
                        this.isLunar = true;
                        await this.populateMonthSelect();
                        await this.updateDaysInMonth();
                    }
                } else {
                    // No date selected, just switch calendar type
                    this.isLunar = true;
                    await this.populateMonthSelect();
                    await this.updateDaysInMonth();
                }

                this.handleCalendarTypeChange();
                this.updateMonthInfoAfterSelection();
            }
        }

        updateLeapMonthState() {
            // Check if selected option is leap month for THIS instance only
            const selectedOption = this.monthSelect.options[this.monthSelect.selectedIndex];
            const wasLeap = this.isLeapMonth;

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

         
        }

        async updateDaysInMonth() {
            const month = parseInt(this.monthSelect.value) || 1;
            const year = parseInt(this.yearSelect.value) || 2000;
            const currentDay = parseInt(this.daySelect.value);

            // Ensure leap month state is current for this instance
            this.updateLeapMonthState();

            // Get leap status from current instance state
            let isLeapForApi = false;
            if (this.isLunar) {
                isLeapForApi = this.isLeapMonth;
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
                // Lunar calendar - try cached data first, then API if needed
                let usedCache = false;

                // Check if we have cached month data for this year
                if (window.yearMonthDataCache && window.yearMonthDataCache[year] && window.yearMonthDataCache[year][month]) {
                    const cachedData = window.yearMonthDataCache[year][month];

                    if (isLeapForApi && cachedData.leapDays > 0) {
                        daysInMonth = cachedData.leapDays;
                        usedCache = true;
                    } else if (!isLeapForApi && cachedData.regularDays > 0) {
                        daysInMonth = cachedData.regularDays;
                        usedCache = true;
                    }
                }

                // If no cached data available, use API
                if (!usedCache) {
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
            // Skip during initialization to prevent unnecessary API calls
            if (this.isInitializing) {
              
                return;
            }

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

            // Skip API calls during initialization unless specifically needed
            if (this.isInitializing && this.isLunar) {
               
                // But still set the display value if we can
                if (day && month && year) {
                    const formattedDay = String(day).padStart(2, '0');
                    const formattedMonth = String(month).padStart(2, '0');
                    const formattedYear = String(year);
                    let displayString = `${formattedDay}/${formattedMonth}/${formattedYear}`;
                    if (this.isLeapMonth) {
                        displayString += ' (ÂL-Nhuận)';
                    } else {
                        displayString += ' (ÂL)';
                    }
                    this.hiddenInput.dataset.displayValue = displayString;
                    this.hiddenInput.dataset.calendarType = 'lunar';
                }
                return;
            }

            if (day && month && year) {
                const formattedDay = String(day).padStart(2, '0');
                const formattedMonth = String(month).padStart(2, '0');
                const formattedYear = String(year);

                let displayString = `${formattedDay}/${formattedMonth}/${formattedYear}`;
                let actualValue = displayString; // Default to same as display

                if (this.isLunar) {
                    // Ensure leap month state is current for this instance
                    this.updateLeapMonthState();

                    // Use instance state instead of re-checking DOM
                    if (this.isLeapMonth) {
                        displayString += ' (ÂL-Nhuận)';
                    } else {
                        displayString += ' (ÂL)';
                    }

                    // Check if we already have solar data AND the lunar date hasn't changed
                    const existingSolarDay = this.hiddenInput.dataset.solarDay;
                    const existingSolarMonth = this.hiddenInput.dataset.solarMonth;
                    const existingSolarYear = this.hiddenInput.dataset.solarYear;
                    const existingLunarDay = this.hiddenInput.dataset.lunarDay;
                    const existingLunarMonth = this.hiddenInput.dataset.lunarMonth;
                    const existingLunarYear = this.hiddenInput.dataset.lunarYear;
                    const existingLunarLeap = this.hiddenInput.dataset.lunarLeap;

                   

                    // During initialization, if we have complete solar data, always use it
                    if (this.isInitializing && existingSolarDay && existingSolarMonth && existingSolarYear) {
                       
                        actualValue = `${String(existingSolarDay).padStart(2, '0')}/${String(existingSolarMonth).padStart(2, '0')}/${existingSolarYear}`;

                        // Update lunar info
                        this.hiddenInput.dataset.lunarDay = day;
                        this.hiddenInput.dataset.lunarMonth = month;
                        this.hiddenInput.dataset.lunarYear = year;
                        this.hiddenInput.dataset.lunarLeap = this.isLeapMonth ? '1' : '0';
                    }
                    // If lunar data is missing but we have solar data, also use cached approach
                    else if (existingSolarDay && existingSolarMonth && existingSolarYear && (!existingLunarDay || !existingLunarMonth || !existingLunarYear)) {
                     
                        actualValue = `${String(existingSolarDay).padStart(2, '0')}/${String(existingSolarMonth).padStart(2, '0')}/${existingSolarYear}`;

                        // Force update lunar info since it was missing
                        this.hiddenInput.dataset.lunarDay = day;
                        this.hiddenInput.dataset.lunarMonth = month;
                        this.hiddenInput.dataset.lunarYear = year;
                        this.hiddenInput.dataset.lunarLeap = this.isLeapMonth ? '1' : '0';
                    } else {
                        // Only use cached solar data if lunar date AND leap status haven't changed
                        const lunarDateUnchanged = (
                            existingLunarDay == day &&
                            existingLunarMonth == month &&
                            existingLunarYear == year &&
                            existingLunarLeap == (this.isLeapMonth ? '1' : '0')
                        );

                       

                        if (existingSolarDay && existingSolarMonth && existingSolarYear && lunarDateUnchanged) {
                        
                            // Use existing solar data only if lunar date is exactly the same
                            actualValue = `${String(existingSolarDay).padStart(2, '0')}/${String(existingSolarMonth).padStart(2, '0')}/${existingSolarYear}`;

                            // Update lunar info
                            this.hiddenInput.dataset.lunarDay = day;
                            this.hiddenInput.dataset.lunarMonth = month;
                            this.hiddenInput.dataset.lunarYear = year;
                            this.hiddenInput.dataset.lunarLeap = this.isLeapMonth ? '1' : '0';
                        } else {
                     

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
                        }
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

            // Check if we already have solar data cached
            const existingSolarDay = this.hiddenInput.dataset.solarDay;
            const existingSolarMonth = this.hiddenInput.dataset.solarMonth;
            const existingSolarYear = this.hiddenInput.dataset.solarYear;

            if (existingSolarDay && existingSolarMonth && existingSolarYear) {
                return {
                    success: true,
                    day: parseInt(existingSolarDay),
                    month: parseInt(existingSolarMonth),
                    year: parseInt(existingSolarYear)
                };
            }

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
                        type: 'lunar-to-solar',
                        isLeap: this.isLeapMonth
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        // Cache the result
                        this.hiddenInput.dataset.solarDay = result.day;
                        this.hiddenInput.dataset.solarMonth = result.month;
                        this.hiddenInput.dataset.solarYear = result.year;
                    }
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