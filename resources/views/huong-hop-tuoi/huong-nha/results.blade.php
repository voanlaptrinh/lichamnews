<div class="w-100" id="content-box-succes">
    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Thông tin chủ nhà
            </div>
            <div class="info-grid">
                <p class="mb-2">
                    <strong>Ngày sinh:</strong>
                    {{ $results['basicInfo']['ngaySinhDuongLich'] }} tức ngày
                    {{ $results['basicInfo']['ngaySinhAmLich'] }} Âm lịch
                </p>
                <p class="mb-2">
                    <strong>Tuổi:</strong>
                    <b> {{ $results['ageInfo']['tuoiAm'] }}</b>
                </p>
                 <p class="mb-2">
                    <strong>Cung phi:</strong>
                    
                    {{ $results['basicInfo']['menhQuai'] }}
                </p>
                <p class="mb-2">
                    <strong>Giới tính:</strong>
                    {{ $results['basicInfo']['gioiTinh'] }}
                </p>
                <p class="mb-2">
                    <strong>Nhóm:</strong>
                    <span>
                        {{ $results['basicInfo']['thuocNhom'] }}
                    </span>
                </p>

            </div>


        </div>
    </div>
    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Nguyên tắc chọn hướng nhà
            </div>
            <div class="info-grid">
                <p class="mb-2">
                    <strong class="text-success">Chọn hướng cát:</strong>
                    <span>
                        {{ implode(', ', $results['nguyenTac']['huongCat']) }}
                    </span>
                </p>
                <p class="mb-2">
                    <strong class="text-danger">Tránh hướng hung:</strong>
                    <span>
                        {{ implode(', ', $results['nguyenTac']['huongHung']) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Gợi ý hướng nhà cho bạn
            </div>

            <table class="table align-middle">
                <thead class="text-center" style="background-color: #e8ebee;">
                    <tr>
                        <th style="border-radius: 8px 0 0 8px">Hướng</th>
                        <th style="">Ý nghĩa</th>
                        <th style="border-radius: 0 8px 8px 0">Ưu tiên</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($results['huongNhaTotChiTiet'] as $item)
                        <tr>
                            <td><b>{{ $item['huong'] }}</b> ({{ $item['loai'] }})</td>
                            <td>{{ $item['y_nghia'] }}</td>
                            <td>{{ $item['uu_tien'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="box--bg-thang mt-3 mb-3">
        <div class="text-box-tong-quan">
            <h2 class="title-tong-quan-h3-log fw-bolder mb-3">Cách hoá giải không chọn được hướng nhà tốt</h2>
            <p class="mb-3">
                Khi nhà không hợp hướng mệnh, tức phạm <b>"Trạch Mệnh tương khắc"</b>, bạn không nên quá lo lắng - phong
                thuỷ hiện đại có nhiều cách hoá giải hiệu quả. Dưới đây là các giải pháp phổ biến và hiệu nghiệm:
            </p>
            <ul style="	list-style-type: decimal;">
                <li>
                    <h3 class="title-tong-quan-h4-log fw-bolder">Xoay hướng của chính (nếu có thể)</h3>
                    <ul class="mb-3">
                        <li>Dùng vách chéo, bình phong, hành lang để "định hướng khí" đi vào nhà theo cửa tốt</li>
                        <li>Hoặc thiết kế của phụ / của lùi để chuyển hướng nạp khí</li>
                    </ul>
                </li>
                <li>
                    <h3 class="title-tong-quan-h4-log fw-bolder">Dùng giường đặt quải treo trước cửa</h3>
                    <ul class="mb-3">
                        <li>Treo giường đặt quải lớn hoặc phẳng ở phía trên cửa chính để trấn sát, chuyển hướng khí</li>
                        <li>Chỉ dùng khi thực sự cần, và phải đặt đúng loại - đúng vị trí (nên có người am hiểu hướng
                            dẫn)</li>
                    </ul>
                </li>
                <li>
                    <h3 class="title-tong-quan-h4-log fw-bolder">Xoay hướng bàn thờ, bếp, giường về hướng tốt</h3>
                    <p class="mb-2">Dù của chính xấu, bạn vẫn có thể:</p>
                    <ul class="mb-2">
                        <li>Đặt ban thờ quay về hướng cáy theo mệnh</li>
                        <li>Đặt bếp toạ hung - hướng cát</li>
                        <li>Đặt giường ngủ quay đầu về hướng tốt</li>
                    </ul>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                        </svg> Việc này giúp bù lại khí xấu từ hướng nhà</p>
                </li>
                <li>
                    <h3 class="title-tong-quan-h4-log fw-bolder">Dùng vật phẩm phong thuỷ hoá giải</h3>
                    <ul class="mb-3">
                        <li>Tỳ hưu, thiềm thừ, long quy, hồ lô, đá thạch anh... đặt ở vị trí phù hợp giúp trấn sát -
                            chuyển hoá năng lượng</li>
                        <li>Chuông gió, cây phong thuỷ, hoặc nước chảy - hồ các cũng giúp dẫn khí theo hướng tốt</li>
                    </ul>

                </li>
                <li>
                    <h3 class="title-tong-quan-h4-log fw-bolder">Chia nhỏ dòng khí (khi khẩu)</h3>
                    <p class="mb-2">Thiết kế không gian như:</p>

                    <ul class="mb-3">
                        <li>Rèm che cửa</li>
                        <li>Kê thêm ngăn khí xung</li>
                        <li>Thảm phong thuỷ tại nối đi</li>
                    </ul>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                        </svg> Nhằm làm chậm, tán khí xấu trước khi đi sâu và nhà.</p>
                </li>
              
            </ul>
             <h3 class="title-tong-quan-h4-log fw-bolder">Ghi nhớ nguyên tắc</h3>
                    <ul>
                        <li>
                            Hướng không hợp - chọn phòng hợp. Của không tốt - điều tốt
                        </li>
                        <li>
                            Trong phong thuỷ, hướng nhà là quan trọng, nhưng không quyết định tất cả - bạn hoàn toàn có thể điểu chỉnh bên trong để "hung hoá cát"
                        </li>
                    </ul>
        </div>
    </div>



</div>
