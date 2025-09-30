// Home.js - JavaScript cho trang chính lịch vạn niên
class LunarCalendarApp {
    constructor(config) {
        this.currentYear = config.currentYear;
        this.currentMonth = config.currentMonth;
        this.currentDay = config.currentDay;
        this.labels = config.labels;
        this.dataValues = config.dataValues;
        this.ajaxUrl = config.ajaxUrl;
        this.calendarAjaxUrl = config.calendarAjaxUrl;
        this.currentChart = null;
        this.overlay = null;
    }

    init() {
        this.setupDateRangePicker();
        this.setupChart();
        this.setupNavigationButtons();
        this.setupMonthYearSelects();
        this.setupCalendarClickHandler();
        this.setupQuickPicker();
        this.setupPopstateHandler();
    }

    // Tạo overlay cho mobile
    createOverlay() {
        if (!this.overlay) {
            this.overlay = document.createElement('div');
            this.overlay.className = 'daterangepicker-overlay';
            document.body.appendChild(this.overlay);

            this.overlay.addEventListener('click', () => {
                $('#month-year-picker').data('daterangepicker').hide();
            });
        }
        return this.overlay;
    }

    setupDateRangePicker() {
        $('#month-year-picker').on('show.daterangepicker', (ev, picker) => {
            if (window.innerWidth <= 768) {
                const overlay = this.createOverlay();
                overlay.style.display = 'block';
            }
        });

        $('#month-year-picker').on('hide.daterangepicker', (ev, picker) => {
            if (this.overlay) {
                this.closePopup(this.overlay);
            }
        });

        $('#month-year-picker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'MM-YYYY',
                "applyLabel": "Chọn",
                "cancelLabel": "Hủy",
                "fromLabel": "Từ",
                "toLabel": "Đến",
                "customRangeLabel": "Tùy chỉnh",
                "weekLabel": "W",
                "daysOfWeek": ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                "monthNames": [
                    "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                    "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                ],
                "firstDay": 1
            }
        }, function(start, end, label) {
            const year = start.format('YYYY');
            const month = start.format('M');
            const day = start.format('D');
            // Redirect to specific date page if needed
            // This would need to be configured based on your routes
            console.log('Date selected:', year, month, day);
        });
    }

    setupChart() {
        const ctx = document.getElementById('myChart');
        if (!ctx) return;

        this.currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.labels,
                datasets: [{
                    label: 'Điểm ngày',
                    data: this.dataValues,
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return;

                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, getComputedStyle(document.documentElement)
                            .getPropertyValue('--bar-bottom-color') || '#4e79a7');
                        gradient.addColorStop(0.6, getComputedStyle(document.documentElement)
                            .getPropertyValue('--bar-mid-color') || '#59a14f');
                        gradient.addColorStop(1, getComputedStyle(document.documentElement)
                            .getPropertyValue('--bar-top-color') || '#9c755f');
                        return gradient;
                    },
                    borderRadius: {
                        topLeft: 8,
                        topRight: 8
                    },
                    borderSkipped: false,
                    hoverBackgroundColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--bar-top-color') || '#9c755f',
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.raw + '%';
                            }
                        },
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 8,
                        displayColors: false
                    }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: getComputedStyle(document.documentElement).getPropertyValue(
                                '--text-color-light') || '#333',
                            font: {
                                size: 13,
                                weight: '500'
                            },
                            padding: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            },
                            color: getComputedStyle(document.documentElement).getPropertyValue(
                                '--text-color-light') || '#333',
                            font: {
                                size: 13,
                                weight: '500'
                            },
                            padding: 10,
                        },
                        grid: {
                            color: getComputedStyle(document.documentElement).getPropertyValue(
                                '--grid-line-color') || '#ddd',
                            borderDash: [5, 5],
                            drawBorder: false,
                            drawOnChartArea: true,
                            drawTicks: false
                        }
                    }
                }
            },
            plugins: [{
                // Plugin custom để vẽ % trên đầu cột
                id: 'valueOnTop',
                afterDatasetsDraw(chart) {
                    const { ctx } = chart;
                    chart.data.datasets.forEach((dataset, i) => {
                        chart.getDatasetMeta(i).data.forEach((bar, index) => {
                            const value = dataset.data[index] + '%';
                            ctx.save();
                            ctx.font = 'bold 12px sans-serif';
                            ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue(
                                '--text-color-light') || '#333';
                            ctx.textAlign = 'center';
                            ctx.fillText(value, bar.x, bar.y - 6); // 6px phía trên đầu cột
                            ctx.restore();
                        });
                    });
                }
            }]
        });
    }

    getCurrentDate() {
        return new Date(this.currentYear, this.currentMonth - 1, this.currentDay);
    }

    async updatePageContent(year, month, day) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Hiển thị loading state
        document.body.style.cursor = 'wait';

        try {
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    yy: year,
                    mm: month,
                    dd: day,
                    birthdate: null
                })
            });

            const data = await response.json();

            if (data.success) {
                // Cập nhật các biến global
                this.currentYear = year;
                this.currentMonth = month;
                this.currentDay = day;

                // Cập nhật URL mà không reload trang
                const formattedMonth = month.toString().padStart(2, '0');
                const formattedDay = day.toString().padStart(2, '0');
                const newUrl = `/lich-nam-${year}/thang-${formattedMonth}/ngay-${formattedDay}`;
                history.pushState({year, month, day}, '', newUrl);

                // Cập nhật các select âm dương tương ứng
                this.updateSelectValues(year, month, day);

                // Cập nhật popup calendar nếu đang mở
                this.updatePopupIfOpen(year, month, day);

                // Cập nhật nội dung các element
                this.updateUIElements(data.data);

                // Cập nhật chart
                this.updateChart(data.data.labels, data.data.dataValues);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại.');
        } finally {
            document.body.style.cursor = 'default';
        }
    }

    updateUIElements(data) {
        // === START: CẬP NHẬT META TAGS ===
        if (data.metaTitle) {
            document.title = data.metaTitle;
        }
        if (data.metaDescription) {
            const metaDescriptionTag = document.querySelector('meta[name="description"]');
            if (metaDescriptionTag) {
                metaDescriptionTag.setAttribute('content', data.metaDescription);
            }
        }
        // === END: CẬP NHẬT META TAGS ===

        // Cập nhật title và breadcrumb cho trang detail
        const pageTitle = document.getElementById('page-title');
        const breadcrumbText = document.getElementById('breadcrumb-text');
        if (pageTitle) {
            pageTitle.textContent = `Lịch Âm Dương Ngày ${data.dd} Tháng ${data.mm} Năm ${data.yy}`;
        }
        if (breadcrumbText) {
            breadcrumbText.textContent = ` Lịch ngày ${data.dd}/${data.mm}/${data.yy}`;
        }

        // Cập nhật content cho trang detail
        const detailContent = document.getElementById('detail-content');
        if (detailContent && data.html) {
            detailContent.innerHTML = data.html;
            // Setup lại navigation buttons sau khi cập nhật HTML
            this.setupNavigationButtons();
            // Loại bỏ href khỏi các link trong content mới
            this.removeCalendarHrefs();
        }

        // Cập nhật ngày dương lịch (cho trang convert)
        const duongElement = document.querySelector('.date-number.duong');
        if (duongElement) duongElement.textContent = data.dd;

        // Cập nhật thứ trong box dương lịch (element đầu tiên)
        const weekdayElements = document.querySelectorAll('.date-weekday');
        if (weekdayElements[0]) {
            weekdayElements[0].textContent = data.weekday;
        }

        // Cập nhật tháng năm trong box dương lịch
        const monthYearElements = document.querySelectorAll('.date-special-event.text-dark');
        if (monthYearElements[0]) {
            monthYearElements[0].textContent = `Tháng ${data.mm} năm ${data.yy}`;
        }

        // Cập nhật ngày âm lịch
        const amElement = document.querySelector('.date-number.am');
        if (amElement) amElement.textContent = data.al[0];

        // Cập nhật tháng năm âm lịch trong box âm lịch (element thứ hai)
        if (weekdayElements[1]) {
            weekdayElements[1].textContent = `Tháng ${data.al[1]} (${data.al[4] || ''}) năm ${data.getThongTinCanChiVaIcon?.can_chi_nam || ''}`;
        }

        // Cập nhật can chi ngày tháng âm lịch (element thứ hai)
        if (monthYearElements[1]) {
            monthYearElements[1].textContent = `Ngày ${data.getThongTinCanChiVaIcon?.can_chi_ngay || ''} - Tháng ${data.getThongTinCanChiVaIcon?.can_chi_thang || ''}`;
        }

        // Cập nhật tiêu đề lịch vạn niên
        const calendarHeaderTitle = document.querySelector('.calendar-header-convert h5');
        if (calendarHeaderTitle) {
            calendarHeaderTitle.textContent = `Lịch vạn niên ${data.yy} - tháng ${data.mm}`;
        }

        // Cập nhật select tháng
        const monthSelect = document.getElementById('month-select');
        if (monthSelect) {
            monthSelect.value = parseInt(data.mm);
        }

        // Cập nhật select năm
        const yearSelect = document.getElementById('year-select');
        if (yearSelect) {
            yearSelect.value = parseInt(data.yy);
        }

        // Cập nhật trạng thái hoàng đạo/hắc đạo
        const statusElement = document.querySelector('.day-status');
        if (statusElement) {
            statusElement.className = 'day-status';
            if (data.tot_xau_result === 'tot') {
                statusElement.className += ' hoang-dao';
                statusElement.innerHTML = '<span class="status-dot"></span><span class="title-status-dot"> Hoàng đạo</span>';
            } else if (data.tot_xau_result === 'xau') {
                statusElement.className += ' hac-dao';
                statusElement.innerHTML = '<span class="status-dot"></span><span class="title-status-dot"> Hắc đạo</span>';
            } else {
                statusElement.innerHTML = '';
            }
        }

        // Cập nhật tiết khí
        const tietKhiElement = document.querySelector('.icon_tiet_khi')?.nextElementSibling?.querySelector('span');
        if (tietKhiElement) tietKhiElement.textContent = data.tietkhi?.tiet_khi || '';

        // Cập nhật ngũ hành nạp âm
        const napAmElement = document.querySelector('.icon_nap_am')?.nextElementSibling;
        if (napAmElement) napAmElement.innerHTML = `<strong class="title-font-detail-ngay">Ngũ hành nạp âm:</strong> ${data.getThongTinNgay?.nap_am?.napAm || ''}`;

        // Cập nhật giờ hoàng đạo
        const gioHoangDaoElement = document.querySelector('.icon_hoang_dao')?.nextElementSibling;
        if (gioHoangDaoElement) gioHoangDaoElement.innerHTML = `<strong class="title-font-detail-ngay">Giờ Hoàng đạo:</strong> ${data.getThongTinNgay?.gio_hoang_dao || ''}`;

        // Cập nhật điểm chỉ số
        const dialElement = document.querySelector('.progress-dial');
        if (dialElement) {
            const percentage = Math.round(data.getDaySummaryInfo?.score?.percentage || 0);
            dialElement.style.setProperty('--value', percentage);

            const percentElement = dialElement.querySelector('.dial-percent');
            if (percentElement) percentElement.textContent = percentage + '%';

            const statusElement = dialElement.querySelector('.dial-status');
            if (statusElement) {
                statusElement.textContent = data.getDaySummaryInfo?.score?.rating || '';
                statusElement.className = 'dial-status pt-2';

                const ratingColors = {
                    'Tốt': 'text-success',
                    'Xấu': 'text-danger',
                    'Trung bình': 'text-warning-tb',
                };
                const colorClass = ratingColors[data.getDaySummaryInfo?.score?.rating];
                if (colorClass) statusElement.classList.add(colorClass);
            }
        }

        // Cập nhật lịch tháng
        const calendarBodyContainer = document.getElementById('calendar-body-container');
        if (calendarBodyContainer && data.table_html) {
            calendarBodyContainer.querySelector('tbody').innerHTML = data.table_html;
        }

        // Cập nhật link "Xem chi tiết ngày"
        const detailLink = document.querySelector('.btn0mobie');
        if (detailLink) {
            // Format: lich-nam-YYYY/thang-MM/ngay-DD
            const formattedMonth = data.mm.toString().padStart(2, '0');
            const formattedDay = data.dd.toString().padStart(2, '0');
            const newDetailUrl = `/lich-nam-${data.yy}/thang-${formattedMonth}/ngay-${formattedDay}`;
            detailLink.href = newDetailUrl;
        }

        // Cập nhật sự kiện dương lịch
        const suKienDuongElements = document.querySelectorAll('.su-kien-duong');
        suKienDuongElements.forEach(el => el.remove());

        if (data.suKienDuongLich && data.suKienDuongLich.length > 0) {
            const containerDuong = document.querySelector('.date-special-event-duong');
            if (containerDuong) {
                data.suKienDuongLich.forEach(suKien => {
                    const div = document.createElement('div');
                    div.className = 'su-kien-duong';
                    div.textContent = suKien.ten_su_kien || suKien;
                    containerDuong.appendChild(div);
                });
            }
        }

        // Cập nhật sự kiện âm lịch
        const containerAm = document.querySelectorAll('.date-special-event-duong')[1];
        if (containerAm) {
            // Xóa sự kiện âm lịch cũ
            const suKienAmElements = containerAm.querySelectorAll('.su-kien-duong');
            suKienAmElements.forEach(el => el.remove());

            if (data.suKienAmLich && data.suKienAmLich.length > 0) {
                data.suKienAmLich.forEach(suKien => {
                    const div = document.createElement('div');
                    div.className = 'su-kien-duong';
                    div.textContent = suKien.ten_su_kien || suKien;
                    containerAm.appendChild(div);
                });
            }
        }
    }

    updateChart(labels, dataValues) {
        if (this.currentChart) {
            this.currentChart.data.labels = labels;
            this.currentChart.data.datasets[0].data = dataValues;
            this.currentChart.update();
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

                // Cập nhật nội dung qua AJAX thay vì chuyển trang
                this.updatePageContent(prevYear, prevMonth, prevDay);
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

                // Cập nhật nội dung qua AJAX thay vì chuyển trang
                this.updatePageContent(nextYear, nextMonth, nextDay);
            });
        });
    }

    setupMonthYearSelects() {
        const monthSelect = document.getElementById('month-select');
        const yearSelect = document.getElementById('year-select');
        const calendarBodyContainer = document.getElementById('calendar-body-container');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!monthSelect || !yearSelect || !calendarBodyContainer) return;

        const debounce = (func, delay) => {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        };

        const updateCalendar = async () => {
            const month = monthSelect.value;
            const year = yearSelect.value;

            // Cập nhật thẻ h5 với tháng và năm mới
            const h5Element = document.querySelector('.calendar-header-convert h5');
            if (h5Element) {
                h5Element.textContent = `Lịch vạn niên ${year} - tháng ${month}`;
            }

            try {
                const response = await fetch(this.calendarAjaxUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        nam: year,
                        thang: month
                    })
                });

                const data = await response.json();
                if (data.table_html) {
                    calendarBodyContainer.querySelector('tbody').innerHTML = data.table_html;
                    // Loại bỏ href khỏi các link mới được tải
                    this.removeCalendarHrefs();
                }
            } catch (error) {
                console.error('Error fetching calendar data:', error);
            }
         };

        const debouncedUpdateCalendar = debounce(updateCalendar, 300);

        monthSelect.addEventListener('change', debouncedUpdateCalendar);
        yearSelect.addEventListener('change', debouncedUpdateCalendar);
    }

    setupCalendarClickHandler() {
        // Sử dụng event delegation để xử lý click trên các ngày trong lịch
        const calendarBodyContainer = document.getElementById('calendar-body-container');
        if (calendarBodyContainer) {
            // Loại bỏ href khỏi tất cả các link lịch để không hiện URL khi hover
            this.removeCalendarHrefs();

            calendarBodyContainer.addEventListener('click', (e) => {
                console.log('Calendar click detected');
                // Tìm link ngày được click
                const link = e.target.closest('a[data-date-url]');
                const linkWithHref = e.target.closest('a[href*="/lich-nam-"]');

                console.log('Link with data-date-url:', link);
                console.log('Link with href:', linkWithHref);

                if (link || linkWithHref) {
                    e.preventDefault();

                    if (link) {
                        console.log('Using AJAX navigation with data-date-url');
                        const href = link.getAttribute('data-date-url');
                        this.processCalendarLink(href);
                    } else if (linkWithHref) {
                        console.log('Found link with href - processing and converting');
                        const href = linkWithHref.getAttribute('href');
                        this.processCalendarLink(href);
                        // Chuyển đổi link này để lần sau không bị
                        linkWithHref.setAttribute('data-date-url', href);
                        linkWithHref.removeAttribute('href');
                        linkWithHref.style.cursor = 'pointer';
                    }
                }
            });
        }
    }

    // Method để re-setup calendar click handler sau khi update calendar
    reSetupCalendarClickHandler() {
        // Calendar click handler đã được setup với event delegation
        // nên không cần setup lại
        this.removeCalendarHrefs();
    }

    // Xử lý link lịch và cập nhật content
    processCalendarLink(href) {
        if (!href) return;

        console.log('Processing calendar link:', href);

        // URL format: /lich-nam-YYYY/thang-MM/ngay-DD
        const regex = /\/lich-nam-(\d{4})\/thang-(\d{1,2})\/ngay-(\d{1,2})/;
        const match = href.match(regex);

        if (match) {
            const year = parseInt(match[1]);
            const month = parseInt(match[2]);
            const day = parseInt(match[3]);

            if (year && month && day) {
                console.log('Updating page content:', year, month, day);
                // Cập nhật nội dung qua AJAX
                this.updatePageContent(year, month, day);
            }
        }
    }

    // Loại bỏ href khỏi các link lịch CHỈ TRONG TABLE và chuyển thành data attribute
    removeCalendarHrefs() {
        // Chỉ tìm links trong calendar table, không ảnh hưởng đến các link khác
        const calendarBodyContainer = document.getElementById('calendar-body-container');
        if (!calendarBodyContainer) return;

        const calendarLinks = calendarBodyContainer.querySelectorAll('a[href*="/lich-nam-"]');
        console.log('Found calendar table links to process:', calendarLinks.length);

        calendarLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.includes('/lich-nam-')) {
                // Chuyển href thành data attribute
                link.setAttribute('data-date-url', href);
                // Loại bỏ href để không hiện URL khi hover
                link.removeAttribute('href');
                // Thêm cursor pointer để vẫn hiển thị như link
                link.style.cursor = 'pointer';
                console.log('Processed calendar table link:', href);
            }
        });
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

        // View button click
        viewDateBtn.addEventListener('click', async () => {
            const solarDay = parseInt(document.getElementById('solarDay').value);
            const solarMonth = parseInt(document.getElementById('solarMonth').value);
            const solarYear = parseInt(document.getElementById('solarYear').value);

            // Close popup first
            this.closePopup(quickPickerOverlay);

            // Update content via AJAX
            this.updatePageContent(solarYear, solarMonth, solarDay);
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

    // Cập nhật popup calendar nếu đang mở
    updatePopupIfOpen(year, month, day) {
        const quickPickerOverlay = document.getElementById('quickPickerOverlay');

        // Kiểm tra nếu popup đang mở
        if (quickPickerOverlay && quickPickerOverlay.classList.contains('show')) {
            // Cập nhật header popup
            this.updatePopupHeader(month, year);

            // Tạo lại calendar với ngày mới và highlight ngày hiện tại
            this.generatePopupCalendar(month, year, day);
        }
    }

    // Cập nhật các select âm dương khi thay đổi ngày
    async updateSelectValues(year, month, day) {
        // Cập nhật select dương lịch
        const solarDaySelect = document.getElementById('solarDay');
        const solarMonthSelect = document.getElementById('solarMonth');
        const solarYearSelect = document.getElementById('solarYear');

        if (solarDaySelect) solarDaySelect.value = day;
        if (solarMonthSelect) solarMonthSelect.value = month;
        if (solarYearSelect) solarYearSelect.value = year;

        // Chuyển đổi và cập nhật select âm lịch
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
            console.log('Error converting solar to lunar for selects:', error);
        }
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
                    // lunarSpan.style.position = 'absolute';
                    // lunarSpan.style.bottom = '2px';
                    // lunarSpan.style.right = '2px';
                    // lunarSpan.style.fontSize = '10px';
                    // lunarSpan.style.color = '#000000ff';
                    // lunarSpan.style.lineHeight = '1';
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

            // Click handler for day selection - view directly
            dayElement.addEventListener('click', async () => {
                document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
                dayElement.classList.add('selected');

                // Update solar date selects first
                document.getElementById('solarDay').value = day;
                document.getElementById('solarMonth').value = month;
                document.getElementById('solarYear').value = year;

                // Convert and update lunar date selects
                await this.convertSolarToLunar();

                // Close popup and view the selected date directly
                const quickPickerOverlay = document.getElementById('quickPickerOverlay');
                this.closePopup(quickPickerOverlay);

                // Update page content directly
                this.updatePageContent(year, month, day);
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

    setupPopstateHandler() {
        // Xử lý sự kiện khi người dùng dùng nút back/forward của browser
        window.addEventListener('popstate', (event) => {
            if (event.state && event.state.year && event.state.month && event.state.day) {
                // Có state data, cập nhật nội dung theo state
                const { year, month, day } = event.state;
                this.updatePageContentFromHistory(year, month, day);
            } else {
                // Không có state data, parse URL để lấy thông tin ngày
                const currentUrl = window.location.pathname;
                const urlMatch = currentUrl.match(/\/lich-nam-(\d{4})\/thang-(\d{1,2})\/ngay-(\d{1,2})/);

                if (urlMatch) {
                    const year = parseInt(urlMatch[1]);
                    const month = parseInt(urlMatch[2]);
                    const day = parseInt(urlMatch[3]);
                    this.updatePageContentFromHistory(year, month, day);
                }
            }
        });
    }

    async updatePageContentFromHistory(year, month, day) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Hiển thị loading state
        document.body.style.cursor = 'wait';

        try {
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    yy: year,
                    mm: month,
                    dd: day,
                    birthdate: null
                })
            });

            const data = await response.json();

            if (data.success) {
                // Cập nhật các biến global
                this.currentYear = year;
                this.currentMonth = month;
                this.currentDay = day;

                // KHÔNG cập nhật URL vì đã được browser xử lý

                // Cập nhật các select âm dương tương ứng
                this.updateSelectValues(year, month, day);

                // Cập nhật popup calendar nếu đang mở
                this.updatePopupIfOpen(year, month, day);

                // Cập nhật nội dung các element
                this.updateUIElements(data.data);

                // Cập nhật chart
                this.updateChart(data.data.labels, data.data.dataValues);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại.');
        } finally {
            document.body.style.cursor = 'default';
        }
    }
}

// Khởi tạo ứng dụng khi có dữ liệu cấu hình
window.initLunarCalendarApp = function(config) {
    new LunarCalendarApp(config);
};