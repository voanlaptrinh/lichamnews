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
                    class="me-1">Nguyên tắc bố trí phòng ngủ
            </div>

            <ul>
                @foreach ($results['nguyenTac'] as $rule)
                    <li>{{ $rule }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Hướng phòng ngủ tốt nhất cho {{ $results['basicInfo']['gioiTinh'] }}
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
                                Những điều cần tránh khi kê giường ngủ
                            </h2>

                            <div>
                                <ul style="	list-style-type: decimal;">
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Đầu giường không có điểm tựa</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Không nên để đầu giường trống không hoặc tựa vào cửa sổ, vách kính, rèm.
                                            </li>
                                            <li>
                                                Gây mất cảm giác an toàn, dễ mất ngủ, mơ xấu.
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Đầu giường hướng vào nhà vệ sinh</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Nhà vệ sinh có uế khí, thủy khí → gây đau đầu, khó ngủ, bệnh lâu ngày không
                                                rõ nguyên nhân.
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Đầu giường hướng vào bếp hoặc sau bếp
                                        </h3>
                                        <ul class="mb-1">
                                            <li>
                                                Hỏa khí mạnh gây nóng nảy, mệt mỏi, xung đột, đặc biệt là với trẻ nhỏ, phụ
                                                nữ mang thai.
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Giường nằm dưới xà ngang, dầm trần </h3>
                                        <ul class="mb-1">
                                            <li>
                                                Gây áp lực tâm lý, "trực sát" đè lên cơ thể, dẫn đến đau nhức, bệnh mãn
                                                tính.
                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log"> Giường đối diện gương soi</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Gương phản xạ năng lượng → gây giật mình, mất ngủ, dễ gặp ác mộng, ly tán.
                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Đặt giường sát cửa ra vào hoặc đối diện cửa
                                            phòng</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Khí vào phòng xung thẳng vào người nằm → bất an, bệnh tật.
                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Kê giường dưới cầu thang, góc khuất, hoặc nơi có
                                            vật chắn trên đầu</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Phong khí bế tắc, người ngủ ở đó dễ bị ức chế, lo lắng, căng thẳng.
                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <h3 class="title-tong-quan-h4-log">Kê giường giữa phòng, không có điểm tựa</h3>
                                        <ul class="mb-1">
                                            <li>
                                                Giống như "con thuyền trôi nổi", thiếu ổn định, dễ mất phương hướng trong
                                                cuộc sống.
                                            </li>
                                        </ul>

                                    </li>
                                </ul>
                                <div>
                                    <h3 class="title-tong-quan-h4-log">Ghi nhớ nguyên tắc vàng khi kê giường ngủ:</h3>
                                    <p>Đầu giường phải vững – không xung – không uế – không động – không phản chiếu.</p>
                                </div>
                            </div>

                        </div>
                    </div>
</div>
