@extends('welcome')
@section('content')
    <div class="main-container pt-5">
        <div class="header-section">

            <div class="input-group">
                <input type="number" id="ruler-input" value="0" min="0" step="1" />
                <span>mm (nhập số)</span>
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

            // --- DOM ELEMENTS & STATE ---
            let renderedCm = 0;
            let isDragging = false;
            let infoUpdateTimeout;
            let inputUpdateTimeout;

            const viewport = document.getElementById('ruler-viewport');
            const canvas = document.getElementById('ruler-canvas');
            const input = document.getElementById('ruler-input');
            const infoPanel = document.getElementById('info-panel');

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

                if (parseInt(input.value) !== targetMm) {
                    input.value = targetMm;
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
                        `<div class="info-item"><strong class="title">${ruler.description_title}:</strong> Độ dài ${cmValue} cm thuộc Cung <span class="cung">${selectedCung.name}</span> nằm trong khoảng <span class="khoang">${selectedKhoang.name}</span> - <span class="${typeClass}">${typeText}</span>. (${selectedCung.desc})</div>`;
                }
                infoPanel.innerHTML = infoHtml;
            }

            // --- EVENT LISTENERS ---
            input.addEventListener('input', () => {
                clearTimeout(inputUpdateTimeout);
                inputUpdateTimeout = setTimeout(() => {
                    const val = parseInt(input.value);
                    if (!isNaN(val)) {
                        updatePosition(val >= 0 ? val : 0); // Chặn nhập số âm
                    }
                }, INPUT_UPDATE_DELAY);
            });

            viewport.addEventListener('scroll', () => {
                // Cho phép cuộn tự do, không chặn ở đây
                const currentMm = Math.round((viewport.scrollLeft + viewport.clientWidth / 2) /
                    PIXELS_PER_MM);

                if (parseInt(input.value) !== currentMm) {
                    input.value = currentMm;
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
@endsection
