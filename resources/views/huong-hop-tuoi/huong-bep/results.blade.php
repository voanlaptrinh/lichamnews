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
                    {{ $results['basicInfo']['ngaySinhAmLich'] }} âm lịch
                </p>
                <p class="mb-2">
                    <strong>Giới tính:</strong>
                    {{ $gender }}
                </p>
                <p class="mb-2">
                    <strong>Tuổi:</strong>
                    <b> {{ $results['ageInfo']['tuoiAm'] }}</b>
                </p>
                <p class="mb-2">
                    <strong>Mệnh quái:</strong>

                    {{ $results['basicInfo']['menhQuai'] }}
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
                    class="me-1">Nguyên tắc chọn hướng bếp
            </div>

            <div>
                @foreach ($results['nguyenTac']['rules'] as $rule)
                    <p>{{ $rule }}</p>
                @endforeach
                <p><em>Lưu ý: {{ $results['nguyenTac']['note'] }}</em></p>
            </div>
        </div>
    </div>

    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Hướng bếp tốt nhất cho {{ $results['basicInfo']['gioiTinh'] }}
                {{ $nam_sinh }}
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
                    @foreach ($results['huongBepTotNhat'] as $item)
                        <tr>
                            <td>{{ $item['huong'] }} ({{ $item['loai'] }})</td>
                            <td>{{ $item['y_nghia'] }}</td>
                            <td>{{ $item['uu_tien'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-lg-12">
        <div class="box--bg-thang mt-3 mb-3">
            <div class="text-box-tong-quan">
                <h5>
                    NHỮNG ĐIỀU CẦN TRÁNH KHI ĐẶT BẾP
                </h5>

                <div>
                    <ul style="	list-style-type: decimal;">
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp đối diện cửa chính</h3>
                            <ul class="mb-1">
                                <li>
                                    Gọi là "Khai môn kiến táo" → mất tài lộc, gia đạo bất an.
                                </li>
                                <li>
                                    Người trong nhà dễ nóng nảy, tiêu tán của cải.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp đối diện nhà vệ sinh</h3>
                            <ul class="mb-1">
                                <li>
                                    Uế khí từ WC xung thẳng vào bếp → thực phẩm bị ảnh hưởng, dễ sinh bệnh.
                                </li>
                                <li>
                                    Gây xung khí giữa Thủy (WC) – Hỏa (bếp) → bất ổn, khẩu thiệt.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp gần hoặc trên giếng nước, bồn rửa, máy giặt
                            </h3>
                            <ul class="mb-1">
                                <li>
                                    Thủy khắc Hỏa → bếp dễ tắt lửa, hao tài, tổn khí.
                                </li>
                                <li>
                                    Gọi là "Thủy Hỏa tương xung" → vợ chồng bất hòa.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp ở giữa nhà ("Trung cung") </h3>
                            <ul class="mb-1">
                                <li>
                                    Trung tâm nhà cần tĩnh, an ổn → đặt bếp vào giữa gây động, ảnh hưởng toàn cục.
                                </li>
                                <li>
                                    Phạm vào "hỏa thiêu trung cung" → nhà dễ ly tán, bệnh tật kéo dài.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Bếp không có chỗ tựa (lưng bếp trống)</h3>
                            <ul class="mb-1">
                                <li>
                                    Giống như "bếp trôi nổi" → không vững tài khí, dễ hao hụt.
                                </li>
                                <li>
                                    Bếp nên tựa vào tường vững chắc, kín đáo.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Miệng bếp nhìn thẳng ra cửa hoặc đường đi</h3>
                            <ul class="mb-1">
                                <li>
                                    Bếp bị "khí xung" → đun nấu không yên, mất tập trung, tán khí.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp dưới xà ngang</h3>
                            <ul class="mb-1">
                                <li>
                                    Gây "áp đỉnh sát" → ảnh hưởng tới người phụ nữ trong nhà: đau đầu, suy nhược.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bếp trên hoặc dưới phòng ngủ</h3>
                            <ul class="mb-1">
                                <li>
                                    Gây "Hỏa thiêu nhân đinh" → bệnh tật kéo dài, xung đột trong nhà.
                                </li>
                            </ul>

                        </li>
                    </ul>
                    <div>
                        <h3 class="title-tong-quan-h4-log">Nguyên tắc vàng khi đặt bếp:</h3>
                        <p>Tọa hung – hướng cát, tránh xung – tránh thủy – tránh động – tránh uế.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
