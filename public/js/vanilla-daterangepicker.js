/**
 * Vanilla JavaScript Date Range Picker
 * Không sử dụng thư viện - 100% vanilla JS
 * Cho phép bôi đen và chọn khoảng thời gian
 */

class VanillaDateRangePicker {
    constructor(inputElement, options = {}) {
        this.input = inputElement;
        this.options = {
            format: options.format || 'dd/mm/yy',
            minDate: options.minDate || null,
            maxDate: options.maxDate || null,
            shortcuts: options.shortcuts !== false,
            autoApply: options.autoApply || false,
            ...options
        };

        this.startDate = null;
        this.endDate = null;
        this.hoverDate = null;
        this.currentLeftMonth = new Date();
        this.currentRightMonth = new Date(new Date().setMonth(new Date().getMonth() + 1));
        this.currentSingleMonth = new Date(); // For mobile single calendar

        this.isSelecting = false;
        this.container = null;
        this.overlay = null;
        this.scrollPosition = 0;
        this.isMobile = true; // Always use mobile-style interface

        this.monthNames = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        this.dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];

        this.init();
    }

    init() {
        this.createElements();
        this.attachEventListeners();
    }

    createElements() {
        // Tạo overlay
        this.overlay = document.createElement('div');
        this.overlay.className = 'daterangepicker-overlay';
        document.body.appendChild(this.overlay);

        // Tạo container chính
        this.container = document.createElement('div');
        this.container.className = 'daterangepicker-container';

        // Always add mobile-view class for unified interface
        this.container.classList.add('mobile-view');

        // Tạo content wrapper (chứa shortcuts + calendars)
        const content = document.createElement('div');
        content.className = 'daterangepicker-content';

        // Tạo shortcuts
        if (this.options.shortcuts) {
            const shortcuts = this.createShortcuts();
            content.appendChild(shortcuts);
        }

        // Tạo calendars
        const calendars = document.createElement('div');
        calendars.className = 'daterangepicker-calendars';

        // Sử dụng giao diện thống nhất cho cả mobile và desktop
        const unifiedCalendar = this.createMobileCalendar();
        calendars.appendChild(unifiedCalendar);
        content.appendChild(calendars);

        // Thêm content vào container
        this.container.appendChild(content);

        // Tạo footer với nút - nằm ngoài content, ở dưới cùng
        const footer = this.createFooter();
        this.container.appendChild(footer);

        document.body.appendChild(this.container);
    }

    createShortcuts() {
        const shortcuts = document.createElement('div');
        shortcuts.className = 'daterangepicker-shortcuts';

        const ul = document.createElement('ul');

        const shortcutsList = [
            { label: 'Hôm nay', days: 0 },
            { label: 'Ngày mai', days: 1, single: true },
            { label: '7 ngày tới', days: 6 },
            { label: '30 ngày tới', days: 29 },
            { label: 'Tháng này', type: 'thisMonth' },
            { label: 'Tháng sau', type: 'nextMonth' }
        ];

        shortcutsList.forEach(shortcut => {
            const li = document.createElement('li');
            li.textContent = shortcut.label;
            li.addEventListener('click', () => this.applyShortcut(shortcut));
            ul.appendChild(li);
        });

        shortcuts.appendChild(ul);
        return shortcuts;
    }

    createMobileCalendar() {
        const calendar = document.createElement('div');
        calendar.className = 'daterangepicker-calendar mobile-calendar';
        calendar.setAttribute('data-position', 'mobile');

        // Header với navigation
        const header = document.createElement('div');
        header.className = 'daterangepicker-header mobile-header';

        // Navigation controls
        const nav = document.createElement('div');
        nav.className = 'mobile-nav-controls';
        nav.innerHTML = `
            <button class="nav-btn prev-month-mobile" type="button" title="Tháng trước">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </button>
            <div class="month-year-display" style="cursor: pointer;" title="Click để chọn nhanh tháng/năm">
                <span class="daterangepicker-month-year">${this.monthNames[this.currentSingleMonth.getMonth()]} ${this.currentSingleMonth.getFullYear()}</span>
            </div>
            <button class="nav-btn next-month-mobile" type="button" title="Tháng sau">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </button>
        `;
        header.appendChild(nav);
        calendar.appendChild(header);

        // Table
        const table = document.createElement('table');
        const thead = document.createElement('thead');
        const headRow = document.createElement('tr');

        this.dayNames.forEach(day => {
            const th = document.createElement('th');
            th.textContent = day;
            headRow.appendChild(th);
        });

        thead.appendChild(headRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        table.appendChild(tbody);

        calendar.appendChild(table);

        // Selected dates display for mobile
        const selectedInfo = document.createElement('div');
        selectedInfo.className = 'mobile-selected-info';
        selectedInfo.innerHTML = `
            <div class="selected-dates-display">
                <div class="selected-date-item">
                    <label>Từ ngày:</label>
                    <span class="start-date-value">--/--/----</span>
                </div>
                <div class="selected-date-item">
                    <label>Đến ngày:</label>
                    <span class="end-date-value">--/--/----</span>
                </div>
            </div>
        `;
        calendar.appendChild(selectedInfo);

        return calendar;
    }

    createCalendar(position) {
        const calendar = document.createElement('div');
        calendar.className = 'daterangepicker-calendar';
        calendar.dataset.position = position;

        const header = this.createCalendarHeader(position);
        calendar.appendChild(header);

        const table = this.createCalendarTable(position);
        calendar.appendChild(table);

        return calendar;
    }

    createCalendarHeader(position) {
        const header = document.createElement('div');
        header.className = 'daterangepicker-header';

        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.innerHTML = '<i class="bi bi-chevron-left"></i>';
        prevBtn.className = 'prev-btn';
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.changeMonth(position, -1);
        });
        if (position === 'right') prevBtn.style.visibility = 'hidden';

        const monthYear = document.createElement('span');
        monthYear.className = 'daterangepicker-month-year';

        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.innerHTML = '<i class="bi bi-chevron-right"></i>';
        nextBtn.className = 'next-btn';
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.changeMonth(position, 1);
        });
        if (position === 'left') nextBtn.style.visibility = 'hidden';

        header.appendChild(prevBtn);
        header.appendChild(monthYear);
        header.appendChild(nextBtn);

        return header;
    }

    createCalendarTable(position) {
        const table = document.createElement('table');
        table.className = 'daterangepicker-table';

        // Header với tên các ngày
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        this.dayNames.forEach(day => {
            const th = document.createElement('th');
            th.textContent = day;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Body chứa các ngày
        const tbody = document.createElement('tbody');
        tbody.dataset.position = position;
        table.appendChild(tbody);

        return table;
    }

    createFooter() {
        const footer = document.createElement('div');
        footer.className = 'daterangepicker-footer';

        const cancelBtn = document.createElement('button');
        cancelBtn.type = 'button';
        cancelBtn.className = 'daterangepicker-btn';
        cancelBtn.textContent = 'Hủy';
        cancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.cancel();
        });

        const applyBtn = document.createElement('button');
        applyBtn.type = 'button';
        applyBtn.className = 'daterangepicker-btn primary';
        applyBtn.textContent = 'Áp dụng';
        applyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.apply();
        });

        footer.appendChild(cancelBtn);
        footer.appendChild(applyBtn);

        return footer;
    }

    attachEventListeners() {
        // Click vào input để mở picker
        this.input.addEventListener('click', (e) => {
            e.stopPropagation();
            this.show();
        });

        this.input.addEventListener('focus', (e) => {
            e.stopPropagation();
            this.show();
        });

        // Click vào overlay để đóng
        this.overlay.addEventListener('click', () => this.hide());

        // Ngăn click trong container đóng picker
        this.container.addEventListener('click', (e) => e.stopPropagation());

        // Navigation cho calendar thống nhất
        setTimeout(() => {
            const prevBtn = this.container.querySelector('.prev-month-mobile');
            const nextBtn = this.container.querySelector('.next-month-mobile');
            const monthYearDisplay = this.container.querySelector('.month-year-display');

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    this.currentSingleMonth.setMonth(this.currentSingleMonth.getMonth() - 1);
                    this.renderCalendars();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    this.currentSingleMonth.setMonth(this.currentSingleMonth.getMonth() + 1);
                    this.renderCalendars();
                });
            }

            // Click vào month-year để mở quick selector
            if (monthYearDisplay) {
                monthYearDisplay.addEventListener('click', () => {
                    this.showMonthYearSelector();
                });
            }
        }, 100);
    }

    show() {
        // Parse giá trị hiện tại trong input nếu có
        this.parseInputValue();

        // Set current month for unified view
        if (this.startDate) {
            this.currentSingleMonth = new Date(this.startDate.getFullYear(), this.startDate.getMonth(), 1);
        }

        // Render calendars
        this.renderCalendars();

        // Position container
        this.positionContainer();

        // Lưu vị trí scroll hiện tại
        this.scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

        // Khóa scroll body khi popup hiện
        const scrollbarWidth = this.getScrollbarWidth();

        // Thêm class cho html và body
        document.documentElement.classList.add('daterangepicker-open');
        document.body.classList.add('daterangepicker-open');

        // Set position fixed và top để giữ vị trí scroll
        document.body.style.position = 'fixed';
        document.body.style.top = `-${this.scrollPosition}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
        document.body.style.overflow = 'hidden';

        // Thêm padding để tránh layout shift khi scrollbar biến mất
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        // Hiển thị
        this.overlay.classList.add('show');
        this.container.classList.add('show');
    }

    hide() {
        this.overlay.classList.remove('show');
        this.container.classList.remove('show');
        this.resetSelection();

        // Mở khóa scroll body khi đóng popup
        document.documentElement.classList.remove('daterangepicker-open');
        document.body.classList.remove('daterangepicker-open');

        // Reset styles
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        // Restore vị trí scroll
        window.scrollTo(0, this.scrollPosition);
    }

    getScrollbarWidth() {
        // Tính width của scrollbar để tránh layout shift
        const outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll';
        document.body.appendChild(outer);

        const inner = document.createElement('div');
        outer.appendChild(inner);

        const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
        outer.parentNode.removeChild(outer);

        return scrollbarWidth;
    }

    parseInputValue() {
        const value = this.input.value.trim();
        if (!value) return;

        const parts = value.split(' - ');
        if (parts.length === 2) {
            this.startDate = this.parseDate(parts[0]);
            this.endDate = this.parseDate(parts[1]);
            if (this.startDate) {
                this.currentLeftMonth = new Date(this.startDate);
                this.currentRightMonth = new Date(this.startDate);
                this.currentRightMonth.setMonth(this.currentRightMonth.getMonth() + 1);
            }
        }
    }

    parseDate(dateStr) {
        // Parse dd/mm/yy hoặc dd/mm/yyyy
        const parts = dateStr.split('/');
        if (parts.length !== 3) return null;

        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        let year = parseInt(parts[2], 10);

        // Nếu năm là 2 chữ số, chuyển thành 4 chữ số
        if (year < 100) {
            year += 2000;
        }

        const date = new Date(year, month, day);
        return isNaN(date.getTime()) ? null : date;
    }

    positionContainer() {
        // CSS đã xử lý position với fixed và căn giữa
        // Không cần tính toán position nữa
        // Container luôn ở giữa màn hình với CSS: left: 50%, top: 50%, transform: translate(-50%, -50%)
    }

    renderCalendars() {
        // Always use single calendar view
        this.renderCalendar('mobile', this.currentSingleMonth);
        this.updateMobileSelectedDisplay();
    }

    updateMobileSelectedDisplay() {
        const startDisplay = this.container.querySelector('.start-date-value');
        const endDisplay = this.container.querySelector('.end-date-value');

        if (startDisplay) {
            startDisplay.textContent = this.startDate ? this.formatDate(this.startDate) : '--/--/----';
        }
        if (endDisplay) {
            endDisplay.textContent = this.endDate ? this.formatDate(this.endDate) : '--/--/----';
        }
    }

    renderCalendar(position, date) {
        const calendar = this.container.querySelector(`[data-position="${position}"]`);
        if (!calendar) {
            console.error('❌ Calendar not found for position:', position);
            return;
        }

        // Update header
        const monthYear = calendar.querySelector('.daterangepicker-month-year');
        monthYear.textContent = `${this.monthNames[date.getMonth()]} ${date.getFullYear()}`;

        // Render days
        const tbody = calendar.querySelector('tbody');
        tbody.innerHTML = '';

        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0);

        // Ngày đầu tuần (0 = CN, 1 = T2, ...)
        const startDayOfWeek = firstDay.getDay();
        const daysInMonth = lastDay.getDate();
        const daysInPrevMonth = prevLastDay.getDate();

        let currentDate = 1;
        let nextMonthDate = 1;

        // Tạo 6 tuần
        for (let week = 0; week < 6; week++) {
            const row = document.createElement('tr');

            for (let day = 0; day < 7; day++) {
                const cell = document.createElement('td');
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'daterangepicker-day';

                let cellDate;

                // Ngày của tháng trước
                if (week === 0 && day < startDayOfWeek) {
                    const prevDate = daysInPrevMonth - startDayOfWeek + day + 1;
                    button.textContent = prevDate;
                    button.classList.add('other-month');
                    cellDate = new Date(date.getFullYear(), date.getMonth() - 1, prevDate);
                }
                // Ngày của tháng hiện tại
                else if (currentDate <= daysInMonth) {
                    button.textContent = currentDate;
                    cellDate = new Date(date.getFullYear(), date.getMonth(), currentDate);

                    // Kiểm tra ngày hôm nay
                    if (this.isToday(cellDate)) {
                        button.classList.add('today');
                    }

                    currentDate++;
                }
                // Ngày của tháng sau
                else {
                    button.textContent = nextMonthDate;
                    button.classList.add('other-month');
                    cellDate = new Date(date.getFullYear(), date.getMonth() + 1, nextMonthDate);
                    nextMonthDate++;
                }

                // Check disabled
                if (this.isDisabled(cellDate)) {
                    button.classList.add('disabled');
                    button.disabled = true;
                } else {
                    // Store date in button's dataset để tránh closure issue
                    button.dataset.date = cellDate.toISOString();

                    // Add click event listener với preventDefault
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const clickedDate = new Date(e.currentTarget.dataset.date);
                        console.log('📅 Clicked date:', this.formatDate(clickedDate));

                        this.selectDate(clickedDate);
                    });

                    // Add hover effect for range preview (without re-rendering)
                    button.addEventListener('mouseenter', (e) => {
                        if (!this.isSelecting || !this.startDate || this.endDate) return;

                        const hoverDate = new Date(e.currentTarget.dataset.date);
                        this.updateHoverPreview(hoverDate);
                    });

                    button.addEventListener('mouseleave', (e) => {
                        if (!this.isSelecting) return;
                        this.clearHoverPreview();
                    });
                }

                // Check selected
                this.updateDayClass(button, cellDate);

                cell.appendChild(button);
                row.appendChild(cell);
            }

            tbody.appendChild(row);
        }
    }

    updateDayClass(button, date) {
        if (!this.startDate) return;

        const dateTime = date.getTime();
        const startTime = this.startDate.getTime();
        const endTime = this.endDate ? this.endDate.getTime() : (this.hoverDate ? this.hoverDate.getTime() : null);

        // Start date
        if (this.isSameDay(date, this.startDate)) {
            button.classList.add('start-date');
            if (this.endDate && this.isSameDay(date, this.endDate)) {
                button.classList.add('end-date');
            }
        }
        // End date
        else if (this.endDate && this.isSameDay(date, this.endDate)) {
            button.classList.add('end-date');
        }
        // In range
        else if (endTime && dateTime > startTime && dateTime < endTime) {
            button.classList.add('in-range');
        }
    }

    selectDate(date) {
        if (this.isDisabled(date)) {
            return;
        }

        // Nếu chưa có startDate hoặc đã có cả start và end, reset và bắt đầu lại
        if (!this.startDate || (this.startDate && this.endDate)) {
            this.startDate = new Date(date);
            this.startDate.setHours(0, 0, 0, 0);
            this.endDate = null;
            this.isSelecting = true;
            console.log('✅ Chọn ngày bắt đầu:', this.formatDate(this.startDate));
        }
        // Nếu đã có startDate nhưng chưa có endDate
        else {
            const selectedDate = new Date(date);
            selectedDate.setHours(0, 0, 0, 0);

            // Nếu click vào cùng ngày với startDate, set endDate = startDate
            if (selectedDate.getTime() === this.startDate.getTime()) {
                this.endDate = new Date(this.startDate);
                this.isSelecting = false;
            }
            else if (selectedDate < this.startDate) {
                // Nếu chọn ngày trước startDate, swap chúng
                this.endDate = new Date(this.startDate);
                this.startDate = selectedDate;
                this.isSelecting = false;
            } else {
                this.endDate = selectedDate;
                this.isSelecting = false;
            }
            console.log('✅ Chọn ngày kết thúc:', this.formatDate(this.endDate));
            console.log('✅ Khoảng:', this.formatDate(this.startDate), '-', this.formatDate(this.endDate));

            // Auto apply nếu được cấu hình
            if (this.options.autoApply) {
                setTimeout(() => this.apply(), 100);
                return;
            }
        }

        this.renderCalendars();
    }

    updateHoverPreview(hoverDate) {
        // Update hover preview without full re-render
        if (!this.isSelecting || !this.startDate || this.endDate) return;

        // Clear previous hover state
        this.clearHoverPreview();

        // Add hover state to buttons in range
        const buttons = this.container.querySelectorAll('.daterangepicker-day:not(.disabled)');
        buttons.forEach(button => {
            const buttonDate = new Date(button.dataset.date);
            if (!buttonDate) return;

            const btnTime = buttonDate.getTime();
            const startTime = this.startDate.getTime();
            const hoverTime = hoverDate.getTime();

            if (hoverTime > startTime && btnTime > startTime && btnTime <= hoverTime) {
                button.classList.add('hover-range');
            } else if (hoverTime < startTime && btnTime >= hoverTime && btnTime < startTime) {
                button.classList.add('hover-range');
            }
        });
    }

    clearHoverPreview() {
        const hoverButtons = this.container.querySelectorAll('.hover-range');
        hoverButtons.forEach(btn => btn.classList.remove('hover-range'));
    }

    changeMonth(position, direction) {
        if (position === 'left') {
            this.currentLeftMonth = new Date(
                this.currentLeftMonth.getFullYear(),
                this.currentLeftMonth.getMonth() + direction,
                1
            );
            this.currentRightMonth = new Date(
                this.currentLeftMonth.getFullYear(),
                this.currentLeftMonth.getMonth() + 1,
                1
            );
        } else {
            this.currentRightMonth = new Date(
                this.currentRightMonth.getFullYear(),
                this.currentRightMonth.getMonth() + direction,
                1
            );
            this.currentLeftMonth = new Date(
                this.currentRightMonth.getFullYear(),
                this.currentRightMonth.getMonth() - 1,
                1
            );
        }

        this.renderCalendars();
    }

    applyShortcut(shortcut) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (shortcut.type === 'thisMonth') {
            this.startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            this.endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        } else if (shortcut.type === 'nextMonth') {
            this.startDate = new Date(today.getFullYear(), today.getMonth() + 1, 1);
            this.endDate = new Date(today.getFullYear(), today.getMonth() + 2, 0);
        } else if (shortcut.single) {
            this.startDate = new Date(today);
            this.startDate.setDate(today.getDate() + shortcut.days);
            this.endDate = new Date(this.startDate);
        } else {
            this.startDate = new Date(today);
            this.endDate = new Date(today);
            this.endDate.setDate(today.getDate() + shortcut.days);
        }

        this.currentLeftMonth = new Date(this.startDate);
        this.currentRightMonth = new Date(this.startDate);
        this.currentRightMonth.setMonth(this.currentRightMonth.getMonth() + 1);

        this.renderCalendars();

        // Auto apply cho shortcuts
        if (this.options.autoApply) {
            this.apply();
        }
    }

    apply() {
        if (!this.startDate || !this.endDate) return;

        const startStr = this.formatDate(this.startDate);
        const endStr = this.formatDate(this.endDate);
        this.input.value = `${startStr} - ${endStr}`;

        // Trigger change event
        const event = new Event('change', { bubbles: true });
        this.input.dispatchEvent(event);

        this.hide();
    }

    cancel() {
        this.hide();
    }

    resetSelection() {
        this.isSelecting = false;
        this.hoverDate = null;
    }

    formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        let year = date.getFullYear();

        if (this.options.format === 'dd/mm/yy') {
            year = String(year).slice(-2);
        } else if (this.options.format === 'dd/mm/yyyy') {
            // Keep full year
            year = String(year);
        }

        return `${day}/${month}/${year}`;
    }

    isToday(date) {
        const today = new Date();
        return this.isSameDay(date, today);
    }

    isSameDay(date1, date2) {
        if (!date1 || !date2) return false;
        return date1.getDate() === date2.getDate() &&
               date1.getMonth() === date2.getMonth() &&
               date1.getFullYear() === date2.getFullYear();
    }

    isDisabled(date) {
        if (this.options.minDate && date < this.options.minDate) return true;
        if (this.options.maxDate && date > this.options.maxDate) return true;
        return false;
    }

    showMonthYearSelector() {
        // Tạo overlay mờ
        const selectorOverlay = document.createElement('div');
        selectorOverlay.className = 'month-year-selector-overlay';

        // Tạo modal chọn tháng năm
        const selector = document.createElement('div');
        selector.className = 'month-year-selector';

        const currentYear = this.currentSingleMonth.getFullYear();
        const currentMonth = this.currentSingleMonth.getMonth();

        // Header
        const header = document.createElement('div');
        header.className = 'selector-header';
        header.innerHTML = '<h3>Chọn Tháng và Năm</h3>';

        // Year selector
        const yearSection = document.createElement('div');
        yearSection.className = 'year-section';
        yearSection.innerHTML = `
            <div class="year-controls">
                <button type="button" class="year-prev"><i class="bi bi-chevron-left"></i></button>
                <input type="number" class="year-input" value="${currentYear}" min="1900" max="2100">
                <button type="button" class="year-next"><i class="bi bi-chevron-right"></i></button>
            </div>
        `;

        // Month grid
        const monthGrid = document.createElement('div');
        monthGrid.className = 'month-grid';

        this.monthNames.forEach((month, index) => {
            const monthBtn = document.createElement('button');
            monthBtn.type = 'button';
            monthBtn.className = 'month-btn';
            if (index === currentMonth) {
                monthBtn.classList.add('active');
            }
            monthBtn.textContent = month.replace('Tháng ', '');
            monthBtn.dataset.month = index;
            monthGrid.appendChild(monthBtn);
        });

        // Footer buttons
        const footer = document.createElement('div');
        footer.className = 'selector-footer';
        footer.innerHTML = `
            <button type="button" class="btn-cancel-selector">Hủy</button>
            <button type="button" class="btn-today-selector">Hôm nay</button>
            <button type="button" class="btn-apply-selector">Chọn</button>
        `;

        selector.appendChild(header);
        selector.appendChild(yearSection);
        selector.appendChild(monthGrid);
        selector.appendChild(footer);

        // Add selector to overlay, then overlay to container
        selectorOverlay.appendChild(selector);
        this.container.appendChild(selectorOverlay);

        // Click overlay to close
        selectorOverlay.addEventListener('click', (e) => {
            if (e.target === selectorOverlay) {
                selectorOverlay.remove();
            }
        });

        // Event handlers
        let selectedMonth = currentMonth;
        let selectedYear = currentYear;

        const yearInput = selector.querySelector('.year-input');
        const yearPrev = selector.querySelector('.year-prev');
        const yearNext = selector.querySelector('.year-next');

        yearPrev.addEventListener('click', () => {
            selectedYear--;
            yearInput.value = selectedYear;
        });

        yearNext.addEventListener('click', () => {
            selectedYear++;
            yearInput.value = selectedYear;
        });

        yearInput.addEventListener('change', (e) => {
            selectedYear = parseInt(e.target.value);
        });

        // Month selection
        monthGrid.addEventListener('click', (e) => {
            if (e.target.classList.contains('month-btn')) {
                selector.querySelectorAll('.month-btn').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                selectedMonth = parseInt(e.target.dataset.month);
            }
        });

        // Today button
        selector.querySelector('.btn-today-selector').addEventListener('click', () => {
            const today = new Date();
            this.currentSingleMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            this.renderCalendars();
            selectorOverlay.remove();
        });

        // Cancel button
        selector.querySelector('.btn-cancel-selector').addEventListener('click', () => {
            selectorOverlay.remove();
        });

        // Apply button
        selector.querySelector('.btn-apply-selector').addEventListener('click', () => {
            this.currentSingleMonth = new Date(selectedYear, selectedMonth, 1);
            this.renderCalendars();
            selectorOverlay.remove();
        });
    }

    destroy() {
        if (this.container) {
            this.container.remove();
        }
        if (this.overlay) {
            this.overlay.remove();
        }
    }
}

// Auto initialize cho tất cả input có class wedding_date_range
document.addEventListener('DOMContentLoaded', function() {
    const dateRangeInputs = document.querySelectorAll('.wedding_date_range');

    dateRangeInputs.forEach(input => {
        new VanillaDateRangePicker(input, {
            format: 'dd/mm/yyyy',
            shortcuts: true,
            autoApply: false
        });
    });

    console.log('✅ Vanilla Date Range Picker đã khởi tạo cho', dateRangeInputs.length, 'inputs');
});
