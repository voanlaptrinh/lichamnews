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
                    {{ $results['ageInfo']['tuoiAm'] }}
                </p>
                <p class="mb-2">
                    <strong>Mệnh quái :</strong>
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
                    class="me-1">Nguyên tắc chọn hướng bàn làm việc
            </div>

            <div>
                @foreach ($results['nguyenTac'] as $rule)
                    {!! $rule !!}
                @endforeach
            </div>
        </div>
    </div>

    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Hướng bàn làm việc tốt nhất cho {{ $results['basicInfo']['gioiTinh'] }}
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
                    @foreach ($results['huongTotChiTiet'] as $item)
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
    <div class="box--bg-thang mt-3 mb-3">
        <div class="text-box-tong-quan">
            <h2 class="title-tong-quan-h3-log fw-bolder">
                Những điều cần lưu ý khi đặt bàn làm việc
            </h2>

            <div>
                <ul style="	list-style-type: decimal;">
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh ngồi quay lưng vào cửa</h3>
                        <ul class="mb-1">
                            <li>
                                Gây mất cảm giác an toàn, dễ bị phân tâm và thiếu tập trung.
                            </li>
                            <li>
                                Có thể bị "người sau lưng" tác động, ảnh hưởng công việc.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh đặt bàn đối diện nhà vệ sinh</h3>
                        <ul class="mb-1">
                            <li>
                                Uế khí từ nhà vệ sinh ảnh hưởng đến sức khỏe và tinh thần.
                            </li>
                            <li>
                                Gây khó tập trung, giảm hiệu quả công việc.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh ngồi dưới xà ngang hoặc dầm trần
                        </h3>
                        <ul class="mb-1">
                            <li>
                                Gây áp lực tâm lý, đau đầu, stress.
                            </li>
                            <li>
                                Ảnh hưởng đến khả năng sáng tạo và ra quyết định.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh đặt bàn ở giữa phòng không có tựa lưng
                        </h3>
                        <ul class="mb-1">
                            <li>
                                Thiếu cảm giác ổn định, không có "hậu thuẫn".
                            </li>
                            <li>
                                Dễ gặp khó khăn trong công việc, thiếu sự hỗ trợ.
                            </li>
                        </ul>

                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh đặt bàn gần bếp hoặc nơi có nhiều
                            tiếng ồn</h3>
                        <ul class="mb-1">
                            <li>
                                Hỏa khí và tiếng ồn gây mất tập trung, nóng nảy.
                            </li>
                            <li>
                                Ảnh hưởng đến chất lượng công việc và sức khỏe.
                            </li>
                        </ul>

                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh đặt bàn đối diện gương</h3>
                        <ul class="mb-1">
                            <li>
                                Gương phản chiếu ánh sáng gây chói mắt, mệt mỏi.
                            </li>
                            <li>
                                Có thể gây phân tâm và giảm hiệu suất làm việc.
                            </li>
                        </ul>

                    </li>
                    <li>
                        <h3 class="title-tong-quan-h4-log">Tránh để bàn làm việc lộn xộn, bừa bộn</h3>
                        <ul class="mb-1">
                            <li>
                                Môi trường lộn xộn ảnh hưởng đến tư duy và sáng tạo.
                            </li>
                            <li>
                                Gây stress và giảm động lực làm việc.
                            </li>
                        </ul>

                    </li>
                </ul>
                <div>
                    <h3 class="title-tong-quan-h4-log">Nguyên tắc vàng khi đặt bàn làm việc:</h3>
                    <p>Tựa vững – tầm nhìn rộng – ánh sáng đủ – không gian thoáng – hướng cát – tránh
                        sát khí.</p>
                </div>
            </div>
        </div>
    </div>
</div>
