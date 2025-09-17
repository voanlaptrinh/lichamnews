<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Xem Lịch Âm' }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <!-- Các link CSS nếu cần, ví dụ: Bootstrap hoặc custom CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/airbnb.css') }}"> {{-- hoặc dark, material_red --}}
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styledemo.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/repont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/daterangepicker.css') }}" />

    <!-- ĐẢM BẢO CÓ DÒNG NÀY ĐỂ CSRF TOKEN HOẠT ĐỘNG! -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>

<body>
    <div class="main-content-wrapper">
        @include('layout.header')

        <div class=" container-setup">

            @yield('content')
        </div>
    </div>

    @include('layout.footer')

    <!-- Nút gieo quẻ sticky, đặt ở đây cho dễ nhìn -->
    <div class="sticky-buttons">
        <button type="button" class="btn ms-auto shake-tilt-animation" id="openFortuneModalBtn">
            <img src="{{ asset('icons/btn-hopque.svg') }}" width="60px" alt="hộp gieo quẻ" class="img-fluid">
        </button>
    </div>

    <!-- Đảm bảo file gieo-que.blade.php chứa các modal popup -->
    @include('gieo-que')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- JS của Bootstrap (nếu sử dụng Bootstrap) -->
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/flatpickr.js') }}"></script>
    <script src="{{ asset('/js/vn.js') }}"></script>

    @stack('scripts')

    <script>
        // --- Helper functions for cookie management ---
        function getTodayDateString() {
            const today = new Date();
            return today.getFullYear() + '-' +
                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                String(today.getDate()).padStart(2, '0');
        }

        // Function to set fortune cookie with fortune index
        // Cookie expires at the end of the current day
        function setFortuneCookie(fortuneIndex) {
            const today = getTodayDateString();
            const endOfDay = new Date();
            endOfDay.setHours(23, 59, 59, 999); // Set to end of day
            const cookieValue = JSON.stringify({
                date: today,
                fortuneIndex: fortuneIndex
            });
            document.cookie =
                `lastFortuneDraw=${encodeURIComponent(cookieValue)}; expires=${endOfDay.toUTCString()}; path=/`;
        }

        // Function to get fortune cookie
        function getFortuneCookie() {
            const nameEQ = "lastFortuneDraw=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) {
                    try {
                        return JSON.parse(decodeURIComponent(c.substring(nameEQ.length, c.length)));
                    } catch (e) {
                        console.error("Error parsing fortune cookie:", e);
                        // Clear invalid cookie
                        document.cookie = "lastFortuneDraw=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        return null;
                    }
                }
            }
            return null;
        }

        document.addEventListener("DOMContentLoaded", async () => {
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
                                    endDate.setDate(startDate.getDate() + shortcut
                                        .days -
                                        1);
                                    fp.setDate([startDate, endDate], false);
                                    fp.altInput.value = fp.formatDate(startDate,
                                            "d/m/Y") +
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

            // const duongInput = document.getElementById('duong_date');
            // const amInput = document.getElementById('am_date');
            // const cdateInput = document.getElementById('cdate');
            // const form = document.getElementById('convertForm');
            // const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector(
            //     'meta[name="csrf-token"]').getAttribute('content') : '';

            // async function updateDate(sourceElement, targetElement, apiUrl) {
            //     const dateValue = sourceElement.value;
            //     if (!dateValue) {
            //         targetElement.value = '';
            //         if (sourceElement.id === 'duong_date') {
            //             cdateInput.value = '';
            //         }
            //         return;
            //     }
            //     try {
            //         const response = await fetch(apiUrl, {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'Accept': 'application/json',
            //                 'X-CSRF-TOKEN': csrfToken
            //             },
            //             body: JSON.stringify({
            //                 date: dateValue
            //             })
            //         });
            //         if (!response.ok) {
            //             console.error('Lỗi server:', await response.text());
            //             return;
            //         }
            //         const data = await response.json();
            //         if (data.date) {
            //             targetElement.value = data.date;
            //             if (sourceElement.id === 'duong_date') {
            //                 cdateInput.value = sourceElement.value;
            //             } else {
            //                 cdateInput.value = data.date;
            //             }
            //         } else if (data.error) {
            //             console.error('Lỗi chuyển đổi:', data.error);
            //         }
            //     } catch (error) {
            //         console.error('Lỗi fetch:', error);
            //     }
            // }
            // if (duongInput) {
            //     duongInput.addEventListener('change', () => {
            //         updateDate(duongInput, amInput, "{{ route('api.to.am') }}");
            //     });
            // }
            // if (amInput) {
            //     amInput.addEventListener('change', () => {
            //         updateDate(amInput, duongInput, "{{ route('api.to.duong') }}");
            //     });
            // }
            // if (form) {
            //     form.addEventListener('submit', (e) => {
            //         if (!cdateInput.value) {
            //             e.preventDefault();
            //             alert("Vui lòng chọn ngày để xem chi tiết.");
            //         }
            //     });
            // }
            // --- END Existing Flatpickr and Date Conversion Logic ---

            // --- FORTUNE TELLING LOGIC ---
            const openFortuneModalBtn = document.getElementById('openFortuneModalBtn');
            const drawFortuneBtn = document.getElementById('drawFortuneBtn');
            const revealFortuneBtn = document.getElementById('revealFortuneBtn');

            const fortuneModal = new bootstrap.Modal(document.getElementById('fortuneModal'));
            const fortuneResultModal = new bootstrap.Modal(document.getElementById('fortuneResultModal'));
            const fullDescriptionModal = new bootstrap.Modal(document.getElementById('fullDescriptionModal'));

            const fortuneNameElem = document.getElementById('fortuneName'); // For result modal
            // const fortuneShortDescriptionElem = document.getElementById('fortuneShortDescription'); // For result modal
            const fortuneFullDescriptionElem = document.getElementById(
            'fortuneFullDescription'); // For full description modal
            const fullDescFortuneNameElem = document.getElementById(
            'fullDescFortuneName'); // For full description modal title

            let currentFortune = null; // Biến toàn cục lưu quẻ hiện tại đã gieo

            const today = getTodayDateString();
            const lastFortuneDrawData = getFortuneCookie();

            // --- Logic kiểm tra và hiển thị quẻ ngay khi tải trang ---
            if (lastFortuneDrawData && lastFortuneDrawData.date === today && typeof lastFortuneDrawData
                .fortuneIndex === 'number') {
                try {
                    const response = await fetch("{{ asset('data/divinations.json') }}");
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const fortunes = await response.json();

                    currentFortune = fortunes[lastFortuneDrawData.fortuneIndex];

                    if (currentFortune) {
                        // Điền dữ liệu vào modal hiển thị chi tiết quẻ
                        // fullDescFortuneNameElem.textContent = currentFortune.ten_day_du;
                        fortuneFullDescriptionElem.innerHTML = `
                        <div>
                            <h3 class="currenfortune-daydu"> ${currentFortune.ten_day_du}</h3>
                            <div class="currenfortune-trieu-tuong">${currentFortune.trieu_tuong}</div>

                            <div class="currenfortune-tinh-chat"> ${currentFortune.tinh_chat}</div>
                            <div class="currenfortune-luan-giai"> ${currentFortune.luan_giai}</div>
                            </div>
                        `;
                        // Hiển thị modal chi tiết quẻ ngay lập tức
                        // fullDescriptionModal.show();

                        // Vô hiệu hóa nút "Gieo Quẻ" nếu nó tồn tại
                        if (drawFortuneBtn) {
                            drawFortuneBtn.disabled = true;
                            drawFortuneBtn.innerHTML =
                                '<span class="fortune-btn-text">Đã Gieo Quẻ Hôm Nay</span>';
                            drawFortuneBtn.classList.remove('btn-success');
                            drawFortuneBtn.classList.add('btn-secondary');
                        }
                    } else {
                        console.warn("Không tìm thấy quẻ cho index:", lastFortuneDrawData.fortuneIndex,
                            "Xóa cookie.");
                        document.cookie =
                        "lastFortuneDraw=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; // Xóa cookie không hợp lệ
                        // Kích hoạt lại nút "Gieo Quẻ"
                        if (drawFortuneBtn) {
                            drawFortuneBtn.disabled = false;
                            drawFortuneBtn.innerHTML = '<span class="fortune-btn-text">Gieo Quẻ</span>';
                            drawFortuneBtn.classList.remove('btn-secondary');
                            drawFortuneBtn.classList.add('btn-success');
                        }
                    }
                } catch (error) {
                    console.error('Lỗi khi tải dữ liệu quẻ bói hoặc hiển thị:', error);
                    // Trong trường hợp lỗi, cho phép gieo lại
                    if (drawFortuneBtn) {
                        drawFortuneBtn.disabled = false;
                        drawFortuneBtn.innerHTML = '<span class="fortune-btn-text">Gieo Quẻ</span>';
                        drawFortuneBtn.classList.remove('btn-secondary');
                        drawFortuneBtn.classList.add('btn-success');
                    }
                }
            } else {
                // Không có quẻ nào được gieo hôm nay, đảm bảo nút gieo quẻ được kích hoạt
                if (drawFortuneBtn) {
                    drawFortuneBtn.disabled = false;
                    drawFortuneBtn.innerHTML = '<span class="fortune-btn-text">Gieo Quẻ</span>';
                    drawFortuneBtn.classList.remove('btn-secondary');
                    drawFortuneBtn.classList.add('btn-success');
                }
            }

            // --- Event Listeners ---

            // Xử lý khi nhấn nút sticky "hộp gieo quẻ"
            if (openFortuneModalBtn) {
                openFortuneModalBtn.addEventListener('click', () => {
                    const currentDrawState = getFortuneCookie();
                    // Nếu đã gieo quẻ hôm nay VÀ biến currentFortune đã được điền (từ lúc tải trang hoặc đã gieo),
                    // thì hiển thị thẳng modal chi tiết quẻ.
                    // Ngược lại, hiển thị modal gieo quẻ ban đầu.
                    if (currentDrawState && currentDrawState.date === today && currentFortune) {
                        fullDescriptionModal.show();
                    } else {
                        fortuneModal.show();
                    }
                });
            }

            // Xử lý khi nhấn nút "Gieo Quẻ" trong modal fortuneModal
            if (drawFortuneBtn) {
                drawFortuneBtn.addEventListener('click', async () => {
                    const currentDrawState = getFortuneCookie();
                    if (currentDrawState && currentDrawState.date === today) {
                        alert('Bạn đã gieo quẻ hôm nay rồi. Vui lòng quay lại vào ngày mai!');
                        return;
                    }

                    try {
                        const response = await fetch("{{ asset('data/divinations.json') }}");
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const fortunes = await response.json();

                        const randomIndex = Math.floor(Math.random() * fortunes.length);
                        currentFortune = fortunes[randomIndex]; // Lưu trữ đối tượng quẻ đầy đủ

                        setFortuneCookie(randomIndex); // Lưu index của quẻ vào cookie

                        fortuneNameElem.textContent = currentFortune.chu_Tau;
                        // fortuneShortDescriptionElem.textContent = `${currentFortune.chu_Han}`;

                        fortuneModal.hide();
                        fortuneResultModal.show();

                        drawFortuneBtn.disabled = true;
                        drawFortuneBtn.innerHTML =
                            '<span class="fortune-btn-text">Đã Gieo Quẻ Hôm Nay</span>';
                        drawFortuneBtn.classList.remove('btn-success');
                        drawFortuneBtn.classList.add('btn-secondary');

                    } catch (error) {
                        console.error('Lỗi khi gieo quẻ:', error);
                        alert('Không thể gieo quẻ lúc này. Vui lòng thử lại sau.');
                    }
                });
            }

            // Xử lý khi nhấn nút "Giải Quẻ" trong modal fortuneResultModal
            if (revealFortuneBtn) {
                revealFortuneBtn.addEventListener('click', () => {
                    if (currentFortune) {
                        // fullDescFortuneNameElem.textContent = currentFortune.ten_day_du;
                        fortuneFullDescriptionElem.innerHTML = `
                            <p><strong>Số Quẻ:</strong> ${currentFortune.so}</p>
                            <p><strong>Chữ Hán:</strong> ${currentFortune.chu_Han} (${currentFortune.chu_Tau})</p>
                            <p><strong>Tên đầy đủ:</strong> ${currentFortune.ten_day_du}</p>
                            <p><strong>Triệu Tượng:</strong> ${currentFortune.trieu_tuong}</p>
                            <p><strong>Tính chất:</strong> ${currentFortune.tinh_chat}</p>
                            <p><strong>Luận giải:</strong> ${currentFortune.luan_giai}</p>
                        `;
                        fortuneResultModal.hide();
                        fullDescriptionModal.show();
                    }
                });
            }
            // --- END FORTUNE TELLING LOGIC ---
        });
    </script>


</body>

</html>
