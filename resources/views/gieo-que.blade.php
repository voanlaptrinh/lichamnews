<!-- Fortune Telling Modal (Hộp popup ban đầu) -->
<div class="modal fade" id="fortuneModal" tabindex="-1" aria-labelledby="fortuneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content contetn-popup1">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('icons/hop-rut-que-popup.svg') }}" alt="Hộp rút quẻ" class="img-fluid">

            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn-gieu-tu-dong" id="drawFortuneBtn">Gieo Quẻ</button>
            </div>
        </div>
    </div>
</div>

<!-- Fortune Result Modal (Popup hiển thị kết quả quẻ) -->
<div class="modal fade" id="fortuneResultModal" tabindex="-1" aria-labelledby="fortuneResultModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fortuneResultModalLabel">Kết Quả Quẻ Bói</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Thêm class 'fortune-overlay-container' vào modal-body -->
            <div class="modal-body fortune-overlay-container">
                <!-- Thêm class 'fortune-overlay-text' vào h4 -->
                <div class="box-que-gieo">

                    <h4 id="fortuneName" class="fortune-overlay-text"></h4>
                    {{-- <span id="fortuneShortDescription"></span> --}}
                </div>

                <img src="{{ asset('icons/que_gieo_que.svg') }}" alt="Que rút quẻ" class="img-fluid">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-info" id="revealFortuneBtn">Giải Quẻ</button>
            </div>
        </div>
    </div>
</div>

<!-- Full Description Modal (Popup hiển thị giải quẻ chi tiết) -->
<div class="modal fade" id="fullDescriptionModal" tabindex="-1" aria-labelledby="fullDescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullDescriptionModalLabel">Giải Quẻ Chi Tiết: <span
                        id="fullDescFortuneName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fortune-card-inner-border">
                <!-- Lớp chứa nội dung thực tế của quẻ -->
                <div class="fortune-card-content-area">
                    <p id="fortuneFullDescription"></p>
                </div>
            </div>
           
        </div>
    </div>
</div>
