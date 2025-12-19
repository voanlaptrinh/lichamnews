@extends('welcome')
@section('content')
    <div class="main-container pt-5">
        <div class="header-section">
            <div class="input-group">
                <input type="number" id="ruler-input" value="0" min="0" step="0.1" />
                <span id="unit-display">mm</span>
                <div class="unit-selector">
                    <label>
                        <input type="radio" name="unit" value="mm" checked />
                        
                        mm
                    </label>
                    <label>
                        <input type="radio" name="unit" value="inch" />
                        inch
                    </label>
                </div>
                <span>(nhập số)</span>
            </div>
        </div>

        <div class="ruler-area">
            <div class="drag-hint">? Hãy kéo thước</div>
            <div class="ruler-viewport" id="ruler-viewport">
                <div class="ruler-canvas" id="ruler-canvas"></div>
            </div>
            <div class="marker"></div>
        </div>

        <div class="info-panel" id="info-panel"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rulersData = @json($rulersData);

            // --- JS CONFIGURATION ---
            const PIXELS_PER_MM = 8;
            const RULER_LENGTH_CM = 10000;
            const CHUNK_CM = 200;
            const SCROLL_UPDATE_DELAY = 300;
            const INPUT_UPDATE_DELAY = 2000;
            const MM_PER_INCH = 25.4;

            // --- DOM ELEMENTS & STATE ---
            let renderedCm = 0;
            let isDragging = false;
            let infoUpdateTimeout;
            let inputUpdateTimeout;
            let currentUnit = 'mm';

            const viewport = document.getElementById('ruler-viewport');
            const canvas = document.getElementById('ruler-canvas');
            const input = document.getElementById('ruler-input');
            const infoPanel = document.getElementById('info-panel');
            const unitDisplay = document.getElementById('unit-display');
            const unitRadios = document.querySelectorAll('input[name="unit"]');

            // --- UNIT CONVERSION FUNCTIONS ---
            function mmToInch(mm) {
                return mm / MM_PER_INCH;
            }

            function inchToMm(inch) {
                return inch * MM_PER_INCH;
            }

            function convertValue(value, fromUnit, toUnit) {
                if (fromUnit === toUnit) return value;
                if (fromUnit === 'mm' && toUnit === 'inch') {
                    return mmToInch(value);
                }
                if (fromUnit === 'inch' && toUnit === 'mm') {
                    return inchToMm(value);
                }
                return value;
            }

            function formatValue(value, unit) {
                if (unit === 'inch') {
                    return parseFloat(value.toFixed(3));
                }
                return Math.round(value);
            }

            // --- RULER GENERATION (LAZY LOADING) ---
            function appendRulerChunk(startCm, endCm) {
                const chunkContainer = document.createElement('div');
                chunkContainer.className = 'ruler-chunk';
                chunkContainer.style.position = 'absolute';
                chunkContainer.style.left = `${startCm * 10 * PIXELS_PER_MM}px`;
                chunkContainer.style.width = `${(endCm - startCm) * 10 * PIXELS_PER_MM}px`;

                let chunkHtml = '';
                for (const key in rulersData) {
                    const ruler = rulersData[key];
                   let scaleHtml = '<div class="ruler-scale">';
                    for (let cm = startCm; cm < endCm; cm++) {
                        let marksHtml = '';
                        // Vòng lặp để vẽ 9 vạch mm nhỏ
                        for (let mm = 1; mm < 10; mm++) {
                            marksHtml += `<div class="scale-mark-mm ${mm === 5 ? 'mid' : ''}"></div>`;
                        }
                        // Bọc các vạch mm trong một wrapper cho mỗi cm
                        scaleHtml += `<div class="scale-mark-wrapper" data-cm="${cm}" style="width: ${10 * PIXELS_PER_MM}px;">${marksHtml}</div>`;
                    }
                    scaleHtml += '</div>';

                    let contentHtml = '<div class="khoang-container">';
                    let currentAbsoluteMm = startCm * 10;
                    const endAbsoluteMm = endCm * 10;
                    const cycleLengthMm = ruler.total_length * 10;

                    if (cycleLengthMm > 0) {
                        const startNormalizedMm = currentAbsoluteMm % cycleLengthMm;
                        let khoangStartIndex = 0;
                        let accumulatedSize = 0;
                        for (let i = 0; i < ruler.khoang.length; i++) {
                            const khoangSize = cycleLengthMm / ruler.khoang.length;
                            if (startNormalizedMm >= accumulatedSize && startNormalizedMm < accumulatedSize +
                                khoangSize) {
                                khoangStartIndex = i;
                                break;
                            }
                            accumulatedSize += khoangSize;
                        }

                        let drawnLengthMm = 0;
                        while (drawnLengthMm < (endCm - startCm) * 10) {
                            for (let i = 0; i < ruler.khoang.length; i++) {
                                const khoangIndex = (khoangStartIndex + i) % ruler.khoang.length;
                                const khoang = ruler.khoang[khoangIndex];
                                const khoangSizeMm = cycleLengthMm / ruler.khoang.length;
                                let cungItemsHtml = '<div class="cung-container">';
                                for (const cung of khoang.cung) {
                                    const cungSizeMm = khoangSizeMm / khoang.cung.length;
                                    const cungClass = khoang.type === 'good' ? 'text-good' : 'text-bad';
                                    cungItemsHtml +=
                                        `<div class="cung-item ${cungClass}" style="width: ${cungSizeMm * PIXELS_PER_MM}px;">${cung.name}</div>`;
                                }
                                cungItemsHtml += '</div>';
                                contentHtml +=
                                    `<div class="ruler-khoang" style="width: ${khoangSizeMm * PIXELS_PER_MM}px;"><div class="khoang-name ${khoang.type === 'good' ? 'text-good' : 'text-bad'}">${khoang.name}</div>${cungItemsHtml}</div>`;
                                drawnLengthMm += khoangSizeMm;
                                if (drawnLengthMm >= (endCm - startCm) * 10) break;
                            }
                        }
                    }
                    contentHtml += '</div>';

                    chunkHtml += `<div class="ruler" data-ruler-key="${key}">
                                      <div class="ruler-title">${ruler.name}</div>
                                      <div class="ruler-body">${scaleHtml}${contentHtml}</div>
                                  </div>`;
                }

                chunkContainer.innerHTML = chunkHtml;
                canvas.appendChild(chunkContainer);
                renderedCm = endCm;
            }

            // --- CORE LOGIC & UPDATES ---
            function updatePosition(mm, behavior = 'smooth') {
                const targetMm = Math.max(0, mm); // Đảm bảo mm không bao giờ âm
                const newScrollLeft = (targetMm * PIXELS_PER_MM) - (viewport.clientWidth / 2);

                viewport.scrollTo({
                    left: newScrollLeft < 0 ? 0 : newScrollLeft,
                    behavior: behavior
                });

                // Convert mm to current unit for display
                const displayValue = formatValue(convertValue(targetMm, 'mm', currentUnit), currentUnit);
                if (parseFloat(input.value) !== displayValue) {
                    input.value = displayValue;
                }
                scheduleInfoUpdate(targetMm, SCROLL_UPDATE_DELAY);
            }

            function scheduleInfoUpdate(mm, delay) {
                clearTimeout(infoUpdateTimeout);
                if (mm >= 0) {
                    infoPanel.style.opacity = '0.5';
                }
                infoUpdateTimeout = setTimeout(() => {
                    updateInfoPanel(mm);
                    infoPanel.style.opacity = '1';
                }, delay);
            }

            function updateInfoPanel(mm) {
                if (mm < 0) {
                    infoPanel.innerHTML = '';
                    return;
                }
                let infoHtml = '';
                const cmValue = (mm / 10).toFixed(1);
                const inchValue = mmToInch(mm).toFixed(3);
                const unitInfo = `${cmValue} cm (${mm} mm / ${inchValue} inch)`;

                for (const key in rulersData) {
                    const ruler = rulersData[key];
                    const cycleLengthMm = ruler.total_length * 10;
                    let normalizedMm = mm % cycleLengthMm;
                    if (mm > 0 && normalizedMm === 0) normalizedMm = cycleLengthMm;
                    const khoangSizeMm = cycleLengthMm / ruler.khoang.length;
                    const khoangIndex = Math.floor(normalizedMm / khoangSizeMm);
                    if (!ruler.khoang[khoangIndex]) continue;
                    const selectedKhoang = ruler.khoang[khoangIndex];
                    const posInKhoang = normalizedMm - khoangIndex * khoangSizeMm;
                    const cungSizeMm = khoangSizeMm / selectedKhoang.cung.length;
                    const cungIndex = Math.floor(posInKhoang / cungSizeMm);
                    const selectedCung = selectedKhoang.cung[cungIndex];
                    if (!selectedCung) continue;
                    const typeClass = selectedKhoang.type === 'good' ? 'type-good' : 'type-bad';
                    const typeText = selectedKhoang.type === 'good' ? 'TỐT' : 'XẤU';
                    infoHtml +=
                        `<div class="info-item"><strong class="title">${ruler.description_title}:</strong> Độ dài ${unitInfo} thuộc Cung <span class="cung">${selectedCung.name}</span> nằm trong khoảng <span class="khoang">${selectedKhoang.name}</span> - <span class="${typeClass}">${typeText}</span>. (${selectedCung.desc})</div>`;
                }
                infoPanel.innerHTML = infoHtml;
            }

            // --- EVENT LISTENERS ---
            input.addEventListener('input', () => {
                clearTimeout(inputUpdateTimeout);
                inputUpdateTimeout = setTimeout(() => {
                    const val = parseFloat(input.value);
                    if (!isNaN(val) && val >= 0) {
                        // Convert input value to mm for internal processing
                        const mmValue = convertValue(val, currentUnit, 'mm');
                        updatePosition(mmValue);
                    }
                }, INPUT_UPDATE_DELAY);
            });

            // Unit change event listeners
            unitRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const oldUnit = currentUnit;
                        currentUnit = this.value;
                        unitDisplay.textContent = currentUnit;

                        // Convert current input value to new unit
                        const currentInputValue = parseFloat(input.value) || 0;
                        const mmValue = convertValue(currentInputValue, oldUnit, 'mm');
                        const newValue = formatValue(convertValue(mmValue, 'mm', currentUnit), currentUnit);
                        input.value = newValue;

                        // Update step for better UX
                        input.step = currentUnit === 'inch' ? '0.001' : '0.1';
                    }
                });
            });

            viewport.addEventListener('scroll', () => {
                // Cho phép cuộn tự do, không chặn ở đây
                const currentMm = Math.round((viewport.scrollLeft + viewport.clientWidth / 2) /
                    PIXELS_PER_MM);

                // Convert mm to current unit for display
                const displayValue = formatValue(convertValue(currentMm, 'mm', currentUnit), currentUnit);
                if (parseFloat(input.value) !== displayValue) {
                    input.value = displayValue;
                }

                scheduleInfoUpdate(currentMm, SCROLL_UPDATE_DELAY);

                if (viewport.scrollLeft + viewport.clientWidth > (renderedCm - 100) * 10 * PIXELS_PER_MM &&
                    renderedCm < RULER_LENGTH_CM) {
                    appendRulerChunk(renderedCm, Math.min(renderedCm + CHUNK_CM, RULER_LENGTH_CM));
                }
            });

            viewport.addEventListener('mousedown', () => {
                isDragging = true;
                viewport.style.cursor = 'grabbing';
                clearTimeout(infoUpdateTimeout);
            });

            window.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    viewport.style.cursor = 'grab';

                    const currentMm = Math.round((viewport.scrollLeft + viewport.clientWidth / 2) /
                        PIXELS_PER_MM);

                    // 👉 Nếu người dùng kéo về nhỏ hơn mốc ban đầu -> tự trở lại
                    if (currentMm < initialMm) {
                        updatePosition(initialMm, 'smooth');
                    } else {
                        // Cập nhật thông tin lần cuối sau khi kéo
                        scheduleInfoUpdate(currentMm, SCROLL_UPDATE_DELAY);
                    }
                }
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                // Cho phép kéo về âm tự do
                viewport.scrollLeft -= e.movementX * 1.5;
            });
            let initialMm = 75;
            // --- INITIALIZATION ---
            function init() {
                initialMm = parseInt(input.value) || 0;
   document.documentElement.style.setProperty('--pixel-per-mm', `${PIXELS_PER_MM}px`);
                PADDING_LEFT_PX = viewport.clientWidth;
                canvas.style.paddingLeft = `${PADDING_LEFT_PX}px`;

                // SỬA ĐỔI: Chỉ vẽ 2 mét (CHUNK_CM) ban đầu
                appendRulerChunk(0, CHUNK_CM);

                updatePosition(initialMm, 'auto');
            }

            init();
        });
    </script>

    <style>
        .header-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        #ruler-input {
            width: 120px;
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }

        #ruler-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.3);
        }

        #unit-display {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
            min-width: 40px;
        }

        .unit-selector {
            display: flex;
            gap: 15px;
            padding: 0 15px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }

        .unit-selector label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            font-weight: 500;
            color: #6c757d;
            transition: color 0.2s;
        }

        .unit-selector label:hover {
            color: #495057;
        }

        .unit-selector input[type="radio"] {
            margin: 0;
            cursor: pointer;
        }

        .unit-selector input[type="radio"]:checked + span {
            color: #007bff;
            font-weight: bold;
        }

        .info-panel .info-item {
            margin: 10px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }

        .info-panel .title {
            color: #495057;
        }

        .info-panel .cung {
            background: #e3f2fd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .info-panel .khoang {
            background: #fff3e0;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .type-good {
            color: #28a745;
            font-weight: bold;
        }

        .type-bad {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
@endsection
