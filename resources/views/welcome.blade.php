<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển Đổi Ngày Dương Sang Âm</title>
    <!-- Các link CSS nếu cần, ví dụ: Bootstrap hoặc custom CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/airbnb.css') }}"> {{-- hoặc dark, material_red --}}
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styledemo.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/repont.css') }}">
    <!-- ĐẢM BẢO CÓ DÒNG NÀY ĐỂ CSRF TOKEN HOẠT ĐỘNG! -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('layout.header')

    <div class=" container-setup">

        @yield('content')
    </div>

    @include('layout.footer')

    <!-- Nút gieo quẻ sticky, đặt ở đây cho dễ nhìn -->
    <div class="sticky-buttons">
        <button type="button" class="btn ms-auto shake-tilt-animation" id="openFortuneModalBtn" data-bs-toggle="modal"
            data-bs-target="#fortuneModal">
            <img src="{{ asset('icons/btn-hopque.svg') }}" width="60px" alt="hộp gieo quẻ" class="img-fluid">
        </button>
    </div>

    <!-- Đảm bảo file gieo-que.blade.php chứa các modal popup -->
    @include('gieo-que')


    <!-- JS của Bootstrap (nếu sử dụng Bootstrap) -->
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/flatpickr.js') }}"></script>
    <script src="{{ asset('/js/vn.js') }}"></script>
    @stack('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // --- Existing Flatpickr and Date Conversion Logic ---
            const maxDate = new Date(new Date().getFullYear(), 11, 31);

            function rangeShortcutPlugin() {
                const shortcuts = [{
                    label: "7 ngày tới",
                    days: 7
                }, {
                    label: "15 ngày tới",
                    days: 15
                }, {
                    label: "30 ngày tới",
                    days: 30
                }, ];
                return function(fp) {
                    return {
                        onReady: function() {
                            const container = document.createElement("div");
                            container.className =
                                "d-flex justify-content-center flex-wrap gap-2 p-2 border-top";
                            shortcuts.forEach(shortcut => {
                                const btn = document.createElement("button");
                                btn.className = "btn btn-sm btn-outline-primary";
                                btn.type = "button";
                                btn.textContent = shortcut.label;
                                btn.addEventListener("click", () => {
                                    const startDate = new Date();
                                    const endDate = new Date();
                                    endDate.setDate(startDate.getDate() + shortcut.days -
                                    1);
                                    fp.setDate([startDate, endDate], false);
                                    fp.altInput.value = fp.formatDate(startDate, "d/m/Y") +
                                        " - " + fp.formatDate(endDate, "d/m/Y");
                                    fp.close();
                                });
                                container.appendChild(btn);
                            });
                            fp.calendarContainer.appendChild(container);
                        }
                    };
                };
            }
            flatpickr("input[name='groom_dob']", {
                dateFormat: "d/m/Y",
                maxDate: maxDate,
                locale: "vn",
            });
            flatpickr("input[name='bride_dob']", {
                dateFormat: "d/m/Y",
                maxDate: maxDate,
                locale: "vn",
            });
            flatpickr(".dateuser", {
                dateFormat: "d/m/Y",
                maxDate: maxDate,
                locale: "vn",
            });
            flatpickr(".datehome", {
                altFormat: "d/m/Y",
                dateFormat: "d/m/Y",
                maxDate: maxDate,
                locale: "vn",
            });
            const overallMinDate = new Date(new Date().getFullYear() - 10, 0, 1);
            const overallMaxDate = new Date(new Date().getFullYear() + 10, 11, 31);
            flatpickr('.wedding_date_range', {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "vn",
                minDate: overallMinDate,
                maxDate: overallMaxDate,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 1) {
                        const startDate = selectedDates[0];
                        const newMaxDate = new Date(startDate);
                        newMaxDate.setMonth(startDate.getMonth() + 13, 0);
                        instance.set('minDate', startDate);
                        instance.set('maxDate', newMaxDate);
                    }
                    if (selectedDates.length === 0) {
                        instance.set('minDate', overallMinDate);
                        instance.set('maxDate', overallMaxDate);
                    }
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        instance.set('minDate', overallMinDate);
                        instance.set('maxDate', overallMaxDate);
                    }
                },
                plugins: [rangeShortcutPlugin()]
            });

            const duongInput = document.getElementById('duong_date');
            const amInput = document.getElementById('am_date');
            const cdateInput = document.getElementById('cdate');
            const form = document.getElementById('convertForm');
            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector(
                'meta[name="csrf-token"]').getAttribute('content') : '';

            async function updateDate(sourceElement, targetElement, apiUrl) {
                const dateValue = sourceElement.value;
                if (!dateValue) {
                    targetElement.value = '';
                    if (sourceElement.id === 'duong_date') {
                        cdateInput.value = '';
                    }
                    return;
                }
                try {
                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            date: dateValue
                        })
                    });
                    if (!response.ok) {
                        console.error('Lỗi server:', await response.text());
                        return;
                    }
                    const data = await response.json();
                    if (data.date) {
                        targetElement.value = data.date;
                        if (sourceElement.id === 'duong_date') {
                            cdateInput.value = sourceElement.value;
                        } else {
                            cdateInput.value = data.date;
                        }
                    } else if (data.error) {
                        console.error('Lỗi chuyển đổi:', data.error);
                    }
                } catch (error) {
                    console.error('Lỗi fetch:', error);
                }
            }
            if (duongInput) {
                duongInput.addEventListener('change', () => {
                    updateDate(duongInput, amInput, "{{ route('api.to.am') }}");
                });
            }
            if (amInput) {
                amInput.addEventListener('change', () => {
                    updateDate(amInput, duongInput, "{{ route('api.to.duong') }}");
                });
            }
            if (form) {
                form.addEventListener('submit', (e) => {
                    if (!cdateInput.value) {
                        e.preventDefault();
                        alert("Vui lòng chọn ngày để xem chi tiết.");
                    }
                });
            }
            // --- END Existing Flatpickr and Date Conversion Logic ---

            // --- FORTUNE TELLING LOGIC ---
            const openFortuneModalBtn = document.getElementById('openFortuneModalBtn');
            const drawFortuneBtn = document.getElementById('drawFortuneBtn');
            const revealFortuneBtn = document.getElementById('revealFortuneBtn');

            const fortuneModal = new bootstrap.Modal(document.getElementById('fortuneModal'));
            const fortuneResultModal = new bootstrap.Modal(document.getElementById('fortuneResultModal'));
            const fullDescriptionModal = new bootstrap.Modal(document.getElementById('fullDescriptionModal'));

            const fortuneNameElem = document.getElementById('fortuneName');
            const fortuneShortDescriptionElem = document.getElementById('fortuneShortDescription');
            const fortuneFullDescriptionElem = document.getElementById('fortuneFullDescription');
            const fullDescFortuneNameElem = document.getElementById('fullDescFortuneName');

            let currentFortune = null; // Biến lưu quẻ hiện tại đã gieo

            // Hàm để lấy ngày hiện tại ở định dạng YYYY-MM-DD
            function getTodayDateString() {
                const today = new Date();
                return today.getFullYear() + '-' +
                    String(today.getMonth() + 1).padStart(2, '0') + '-' +
                    String(today.getDate()).padStart(2, '0');
            }

            // Hàm để đặt cookie
            function setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            // Hàm để lấy cookie
            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            // Kiểm tra cookie khi mở modal gieo quẻ
            if (openFortuneModalBtn) {
                openFortuneModalBtn.addEventListener('click', () => {
                    const lastDrawDate = getCookie('lastFortuneDrawDate');
                    const today = getTodayDateString();

                    if (lastDrawDate === today) {
                        drawFortuneBtn.disabled = true;
                        drawFortuneBtn.innerHTML =
                            '<span class="fortune-btn-text">Đã Gieo Quẻ Hôm Nay</span>'; // Đã chỉnh sửa
                        drawFortuneBtn.classList.remove('btn-success');
                        drawFortuneBtn.classList.add('btn-secondary');
                    } else {
                        drawFortuneBtn.disabled = false;
                        drawFortuneBtn.innerHTML =
                        '<span class="fortune-btn-text">Gieo Quẻ</span>'; // Đã chỉnh sửa
                        drawFortuneBtn.classList.remove('btn-secondary');
                        drawFortuneBtn.classList.add('btn-success');
                    }
                });
            }


            // Xử lý khi nhấn nút "Gieo Quẻ"
            if (drawFortuneBtn) {
                drawFortuneBtn.addEventListener('click', async () => {
                    const lastDrawDate = getCookie('lastFortuneDrawDate');
                    const today = getTodayDateString();

                    if (lastDrawDate === today) {
                        alert('Bạn đã gieo quẻ hôm nay rồi. Vui lòng quay lại vào ngày mai!');
                        return;
                    }

                    try {
                        // Tải dữ liệu quẻ bói từ JSON file mới
                        const response = await fetch(
                        "{{ asset('data/divinations.json') }}"); // CẬP NHẬT ĐƯỜNG DẪN
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const fortunes = await response.json();

                        // Random một quẻ
                        currentFortune = fortunes[Math.floor(Math.random() * fortunes.length)];

                        // Cập nhật cookie để ghi nhận đã gieo quẻ hôm nay
                        setCookie('lastFortuneDrawDate', today, 1); // Cookie hết hạn sau 1 ngày

                        // Đổ dữ liệu vào popup kết quả (sử dụng các trường mới)
                        fortuneNameElem.textContent = currentFortune.ten_day_du; // Tên đầy đủ
                        // Kết hợp trieu_tuong và tinh_chat cho phần mô tả ngắn gọn
                        fortuneShortDescriptionElem.textContent =
                            `${currentFortune.trieu_tuong} - ${currentFortune.tinh_chat}`;

                        // Ẩn modal gieo quẻ, hiện modal kết quả
                        fortuneModal.hide();
                        fortuneResultModal.show();

                        // Vô hiệu hóa nút gieo quẻ sau khi gieo thành công
                        drawFortuneBtn.disabled = true;
                        drawFortuneBtn.innerHTML =
                            '<span class="fortune-btn-text">Đã Gieo Quẻ Hôm Nay</span>'; // Đã chỉnh sửa

                        drawFortuneBtn.classList.remove('btn-success');
                        drawFortuneBtn.classList.add('btn-secondary');

                    } catch (error) {
                        console.error('Lỗi khi gieo quẻ:', error);
                        alert('Không thể gieo quẻ lúc này. Vui lòng thử lại sau.');
                    }
                });
            }

            // Xử lý khi nhấn nút "Giải Quẻ" trong popup kết quả
            if (revealFortuneBtn) {
                revealFortuneBtn.addEventListener('click', () => {
                    if (currentFortune) {
                        fullDescFortuneNameElem.textContent = currentFortune
                        .ten_day_du; // Tên đầy đủ cho tiêu đề giải quẻ
                        // Format chi tiết quẻ bói với HTML
                        fortuneFullDescriptionElem.innerHTML = `
                            <p><strong>Số Quẻ:</strong> ${currentFortune.so}</p>
                            <p><strong>Chữ Hán:</strong> ${currentFortune.chu_Han} (${currentFortune.chu_Tau})</p>
                            <p><strong>Tên đầy đủ:</strong> ${currentFortune.ten_day_du}</p>
                            <p><strong>Triệu Tượng:</strong> ${currentFortune.trieu_tuong}</p>
                            <p><strong>Tính chất:</strong> ${currentFortune.tinh_chat}</p>
                            <p><strong>Luận giải:</strong> ${currentFortune.luan_giai}</p>
                        `;
                        fortuneResultModal.hide(); // Ẩn popup kết quả
                        fullDescriptionModal.show(); // Hiện popup giải quẻ chi tiết
                    }
                });
            }
            // --- END FORTUNE TELLING LOGIC ---
        });
    </script>


</body>

</html>
