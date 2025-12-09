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
    
</div>