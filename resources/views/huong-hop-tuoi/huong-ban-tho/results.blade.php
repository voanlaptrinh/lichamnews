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
                    <strong>Tuổi:</strong>
                    <b> {{ $results['ageInfo']['tuoiAm'] }}</b>, mệnh:
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
                    class="me-1">Nguyên tắc đặt bàn thờ
            </div>

            <ul>
                <li>{{ $results['nguyenTacDatBanTho'][0] }}</li>
                <li>{{ $results['nguyenTacDatBanTho'][1] }}</li>
            </ul>
        </div>
    </div>

    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Hướng đặt bàn thờ tốt nhất cho {{ $results['basicInfo']['gioiTinh'] }}
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
                    @foreach ($results['huongDatBanThoTotNhat'] as $item)
                        <tr>
                            <td>{{ $item['huong'] }}</td>
                            <td>{{ $item['y_nghia'] }}</td>
                            <td>{{ $item['uu_tien'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-lg-12">
        <div class=" card border-0 mb-3 w-100 box-detial-year">

            <div class="card-body box1-con-year">
                <h2 class="title-tong-quan-h3-log fw-bolder">
                    Những điều cần tránh khi đặt bàn thờ
                </h2>

                <div>
                    <ul style="	list-style-type: decimal;">
                        <li>
                            <h3 class="title-tong-quan-h4-log">Bàn thờ đặt đối diện cửa ra vào hoặc cửa sổ lớn</h3>
                            <ul class="mb-1">
                                <li>
                                    Làm khí bị xung, tán tài, mất linh khí, dễ động.
                                </li>
                                <li>
                                    Gây mất sự trang nghiêm, dễ bị quấy nhiễu.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Tựa lưng bàn thờ vào khoảng trống</h3>
                            <ul class="mb-1">
                                <li>
                                    Tượng trưng cho không có điểm tựa, tổ tiên không được “an vị”.
                                </li>
                                <li>
                                    Phải tựa vào tường vững chắc, không rung lắc.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bàn thờ dưới xà ngang, gầm cầu thang, nhà vệ sinh
                            </h3>
                            <ul class="mb-1">
                                <li>
                                    Gây áp lực sát khí, mất tôn nghiêm.
                                </li>
                                <li>
                                    Dễ sinh bệnh, bất an về tinh thần.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Đặt bàn thờ cạnh bếp, nhà tắm, hoặc nơi ô uế </h3>
                            <ul class="mb-1">
                                <li>
                                    Hỏa khí, thủy khí và tạp khí phá hủy trường năng lượng tâm linh.
                                </li>
                                <li>
                                    Phạm đại kỵ, tổ tiên không ứng.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log"> Bài trí bàn thờ lộn xộn, bừa bộn</h3>
                            <ul class="mb-1">
                                <li>
                                    Đồ thờ, ảnh thờ đặt sai thứ tự, hoa héo, hương tàn.
                                </li>
                                <li>
                                    Làm mất phúc khí, giảm sự linh ứng.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Bàn thờ quá cao hoặc quá thấp</h3>
                            <ul class="mb-1">
                                <li>
                                    Cao quá → khó chăm sóc, cách xa con cháu.
                                </li>
                                <li>
                                    Thấp quá → bất kính, không hợp nguyên lý “thiên cao, địa thấp”.
                                </li>
                            </ul>

                        </li>
                        <li>
                            <h3 class="title-tong-quan-h4-log">Dưới bàn thờ làm tủ, nhà kho, hoặc để đồ linh tinh</h3>
                            <ul class="mb-1">
                                <li>
                                    Làm mất đi sự thanh tịnh, không khí trang nghiêm.
                                </li>
                                <li>
                                    Cao quá → khó chăm sóc, cách xa con cháu.
                                </li>
                                <li>
                                    Thấp quá → bất kính, không hợp nguyên lý “thiên cao, địa thấp”.
                                </li>
                            </ul>

                        </li>
                    </ul>
                    
                </div>
              
            </div>
        </div>
    </div>
</div>
