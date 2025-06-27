<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển Đổi Ngày Dương Sang Âm</title>
    <!-- Các link CSS nếu cần, ví dụ: Bootstrap hoặc custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css"> {{-- hoặc dark, material_red --}}

    <link rel="stylesheet" href="{{ asset('/css/styledemo.css') }}">
</head>

<body>

    @yield('content')

    <!-- JS của Bootstrap (nếu sử dụng Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>



    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const maxDate = new Date(new Date().getFullYear(), 11, 31); // 31/12 năm nay
            function rangeShortcutPlugin() {
                // Danh sách các nút chọn nhanh
                const shortcuts = [{
                        label: "7 ngày tới",
                        days: 7
                    },
                    {
                        label: "15 ngày tới",
                        days: 15
                    },
                    {
                        label: "30 ngày tới",
                        days: 30
                    },

                ];

                return function(fp) {
                    return {
                        onReady: function() {
                            // DÙNG LUÔN CLASS CỦA BOOTSTRAP ĐỂ TẠO LAYOUT
                            const container = document.createElement("div");
                            container.className = "d-flex justify-content-center gap-2 p-2 border-top";

                            shortcuts.forEach(shortcut => {
                                const btn = document.createElement("button");
                                // DÙNG LUÔN CLASS CỦA BOOTSTRAP ĐỂ TẠO NÚT
                                btn.className = "btn btn-sm btn-outline-primary";
                                btn.type = "button";
                                btn.textContent = shortcut.label;

                                btn.addEventListener("click", () => {
                                    const today = new Date();
                                    let startDate, endDate;

                                    if (shortcut.days === 'this_month') {
                                        startDate = new Date(today.getFullYear(), today
                                            .getMonth(), 1);
                                        endDate = new Date(today.getFullYear(), today
                                            .getMonth() + 1, 0);
                                        if (startDate < today && today.getDate() !== 1) {
                                            startDate = today;
                                        }
                                    } else {
                                        startDate = today;
                                        endDate = new Date();
                                        endDate.setDate(today.getDate() + shortcut.days -
                                            1);
                                    }

                                    fp.setDate([startDate, endDate]);
                                    fp.close();
                                });

                                container.appendChild(btn);
                            });

                            fp.calendarContainer.appendChild(container);
                        }
                    };
                };
            }
            // Flatpickr cho ngày sinh chú rể
            flatpickr("input[name='groom_dob']", {
                dateFormat: "d/m/Y",
                maxDate: maxDate,
                locale: "vn",

            });

            // Flatpickr cho ngày sinh cô dâu
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
                        newMaxDate.setFullYear(startDate.getFullYear() + 1);

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

                plugins: [
                    rangeShortcutPlugin()
                ]
            });

            const duongInput = document.getElementById('duong_date');
            const amInput = document.getElementById('am_date');
            const cdateInput = document.getElementById('cdate');
            const csrf = document.querySelector('input[name="_token"]').value;

            // Sự kiện đổi ngày dương → âm
            if (duongInput) {
                duongInput.addEventListener('change', async () => {
                    const duongDate = duongInput.value;
                    if (duongDate) {
                        const res = await fetch('/api/convert-to-am', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                date: duongDate
                            })
                        });

                        const data = await res.json();
                        if (data.date) {
                            amInput.value = data.date;
                            cdateInput.value = duongDate;
                        }
                    }
                });
            }

            // Sự kiện đổi ngày âm → dương
            if (amInput) {
                amInput.addEventListener('change', async () => {
                    const amDate = amInput.value;
                    if (amDate) {
                        const res = await fetch('/api/convert-to-duong', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                date: amDate
                            })
                        });

                        const data = await res.json();
                        if (data.date) {
                            duongInput.value = data.date;
                            cdateInput.value = data.date;
                        }
                    }
                });
            }

            // Kiểm tra trước khi submit form
            const form = document.getElementById('convertForm');
            if (form) {
                form.addEventListener('submit', (e) => {
                    if (!cdateInput.value) {
                        e.preventDefault();
                        alert("Vui lòng chọn ngày dương hoặc ngày âm.");
                    }
                });
            }
        });
    </script>


</body>

</html>
