# Custom Calendar Module - Hướng Dẫn Sử Dụng

## 📦 Module Đã Được Tích Hợp Sẵn

File `custom-calendar.js` cung cấp 3 class chính:
1. **CustomCalendar** - Calendar cho single date input
2. **GlobalCalendar** - Calendar có thể dùng cho nhiều inputs
3. **DateUtils** - Utility functions cho xử lý dates

## 🚀 Cách Sử Dụng Ở View Mới

### **1. Thêm HTML Cho Calendar**

```html
<!-- Custom Calendar Popup -->
<div class="custom-calendar" id="myCalendar" style="display: none;">
    <div class="calendar-header">
        <button type="button" id="myPrevMonth">‹</button>
        <span id="myMonthYear"></span>
        <button type="button" id="myNextMonth">›</button>
    </div>
    <div class="calendar-days" id="myCalendarDays">
        <!-- JavaScript sẽ generate -->
    </div>
    <div class="calendar-footer">
        <button type="button" id="myClearDate">Xóa</button>
        <button type="button" id="myTodayDate">Hôm nay</button>
    </div>
</div>
```

### **2. Thêm Input Date**

```html
<input type="text"
       id="myDateInput"
       class="form-control"
       placeholder="Chọn ngày"
       readonly>
```

### **3. Khởi Tạo Calendar Trong Script**

```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo custom calendar
    const calendar = new CustomCalendar({
        inputId: 'myDateInput',       // ID của input
        calendarId: 'myCalendar',     // ID của calendar popup
        defaultToToday: true          // Set ngày mặc định là hôm nay
    });
});
```

## 🎯 **Ví Dụ: View Báo Cáo**

### File: `resources/views/reports/index.blade.php`

```blade
@extends('welcome')

@section('content')
<div class="container mt-5">
    <h2>Báo Cáo Theo Ngày</h2>

    <form id="reportForm">
        <!-- Input Date -->
        <div class="mb-3">
            <label>Ngày Báo Cáo</label>
            <input type="text"
                   id="reportDate"
                   class="form-control"
                   placeholder="Chọn ngày"
                   readonly>
        </div>

        <button type="submit" class="btn btn-primary">
            Xem Báo Cáo
        </button>
    </form>

    <!-- Custom Calendar -->
    <div class="custom-calendar" id="reportCalendar" style="display: none;">
        <div class="calendar-header">
            <button type="button" id="reportPrevMonth">‹</button>
            <span id="reportMonthYear"></span>
            <button type="button" id="reportNextMonth">›</button>
        </div>
        <div class="calendar-days" id="reportCalendarDays"></div>
        <div class="calendar-footer">
            <button type="button" id="reportClearDate">Xóa</button>
            <button type="button" id="reportTodayDate">Hôm nay</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize calendar
    const reportCalendar = new CustomCalendar({
        inputId: 'reportDate',
        calendarId: 'reportCalendar',
        defaultToToday: true
    });

    // Form submission
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const dateValue = document.getElementById('reportDate').value;
        if (!dateValue) {
            alert('Vui lòng chọn ngày');
            return;
        }

        // Parse date sử dụng DateUtils
        const date = DateUtils.parseVietnameseDate(dateValue);
        const isoDate = DateUtils.formatDateValue(date);

        console.log('Report date:', isoDate);

        // Submit to backend...
    });
});
</script>
@endsection
```

## 📚 **API Reference**

### **CustomCalendar Class**

```javascript
const calendar = new CustomCalendar({
    inputId: 'myInput',        // Required: ID của input element
    calendarId: 'myCalendar',  // Required: ID của calendar popup
    defaultToToday: true       // Optional: Set ngày mặc định (default: true)
});
```

**Methods:**
```javascript
calendar.getValue()           // Lấy giá trị input (string)
calendar.setValue('01/01/25') // Set giá trị input
calendar.getDateObject()      // Lấy Date object
```

### **GlobalCalendar Class**

Dùng cho trường hợp có nhiều inputs cùng dùng 1 calendar:

```javascript
const globalCal = new GlobalCalendar('globalCalendarId');

// Attach vào input
globalCal.attachToInput(document.getElementById('input1'));
globalCal.attachToInput(document.getElementById('input2'));
```

### **DateUtils Object**

```javascript
// Parse Vietnamese date format (dd/mm/yy)
const date = DateUtils.parseVietnameseDate('01/01/25');

// Format date to display (dd/mm/yyyy)
const displayDate = DateUtils.formatDateDisplay(new Date());

// Format date to ISO (yyyy-mm-dd)
const isoDate = DateUtils.formatDateValue(new Date());

// Validate date range
const isValid = DateUtils.validateDateRange('01/01/25 - 31/01/25');

// Parse date range
const range = DateUtils.parseDateRange('01/01/25 - 31/01/25');
console.log(range.start, range.end); // Date objects
```

## 🎨 **CSS Classes**

Calendar sử dụng các class sau (đã có sẵn trong CSS):
- `.custom-calendar` - Container
- `.calendar-header` - Header với navigation
- `.calendar-days` - Grid chứa các ngày
- `.calendar-day` - Mỗi ô ngày
- `.calendar-day.today` - Ngày hôm nay
- `.calendar-day.selected` - Ngày được chọn
- `.calendar-day.other-month` - Ngày tháng khác
- `.calendar-footer` - Footer với buttons

## ⚠️ **Lưu Ý**

1. **IDs Phải Unique**: Mỗi calendar cần có ID riêng
2. **Read-only Input**: Input nên set `readonly` để prevent manual entry
3. **Date Format**: Sử dụng format `dd/mm/yy` cho hiển thị
4. **CSS Required**: Đảm bảo CSS calendar đã được load

## 📝 **Multiple Calendars Example**

```javascript
// View có nhiều date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Calendar 1
    const startDateCal = new CustomCalendar({
        inputId: 'startDate',
        calendarId: 'startCalendar',
        defaultToToday: true
    });

    // Calendar 2
    const endDateCal = new CustomCalendar({
        inputId: 'endDate',
        calendarId: 'endCalendar',
        defaultToToday: false
    });

    // Validation: End date >= Start date
    form.addEventListener('submit', function(e) {
        const start = DateUtils.parseVietnameseDate(startDateCal.getValue());
        const end = DateUtils.parseVietnameseDate(endDateCal.getValue());

        if (end < start) {
            alert('Ngày kết thúc phải >= ngày bắt đầu');
            e.preventDefault();
        }
    });
});
```

## 🔗 **Related**

- **Date Range Picker**: Dùng class `.wedding_date_range` cho range selection
- **File Location**: `/public/js/custom-calendar.js`
- **CSS**: Included in main layout (welcome.blade.php)

---

**Version**: 1.0
**Last Updated**: 2025
**Maintainer**: Development Team
