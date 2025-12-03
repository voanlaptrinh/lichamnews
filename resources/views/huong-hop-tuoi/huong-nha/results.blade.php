<div class="w-100" id="content-box-succes">
    <div class=" card border-0 mb-3 w-100 box-detial-year">

        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Thông tin chủ nhà
            </div>


        </div>
    </div>

    <h2 class="h4 mb-3">Kết quả xem hướng nhà cho gia chủ sinh ngày
        {{ $results['basicInfo']['ngaySinhDuongLich'] }}</h2>

   
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white text-center"><strong>THÔNG TIN CƠ BẢN</strong></div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-day me-2 text-primary"></i>Ngày sinh dương lịch:</span>
                    <span class="fw-bold">{{ $results['basicInfo']['ngaySinhDuongLich'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-moon me-2 text-primary"></i>Ngày sinh âm lịch:</span>
                    <span class="fw-bold">{{ $results['basicInfo']['ngaySinhAmLich'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-venus-mars me-2 text-primary"></i>Giới tính:</span>
                    <span class="fw-bold">{{ $results['basicInfo']['gioiTinh'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-star-of-life me-2 text-primary"></i>Mệnh quái:</span>
                    <span class="fw-bold">{{ $results['basicInfo']['menhQuai'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users me-2 text-primary"></i>Thuộc nhóm:</span>
                    <span class="fw-bold text-danger">{{ $results['basicInfo']['thuocNhom'] }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- 2. NGUYÃŠN Táº®C CHá»ŒN HÆ¯á»šNG (THEO MáºªU HÃŒNH áº¢NH) --}}
    <div class="card mb-4">
        <div class="card-header text-center"><strong>NGUYÊN TẮC CHỌN HƯỚNG NHÀ</strong></div>
        <div class="card-body">
            <p><i class="fas fa-check-circle text-success me-2"></i><strong class="text-success">Chọn hướng
                    cát:</strong> {{ implode(', ', $results['nguyenTac']['huongCat']) }}</p>
            <p><i class="fas fa-times-circle text-danger me-2"></i><strong class="text-danger">Tránh hướng
                    hung:</strong> {{ implode(', ', $results['nguyenTac']['huongHung']) }}</p>
        </div>
    </div>

    {{-- 3. Báº¢NG CHI TIáº¾T HÆ¯á»šNG Tá»T (GIá»® Láº I VÃŒ Ráº¤T Há»®U ÃCH) --}}
    <div class="card mb-3">
        <div class="card-header bg-success text-white"><strong>PHÂN TÍCH CHI TIẾT CÁC HƯỚNG TỐT</strong></div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hướng</th>
                        <th> Loại Cát Tinh </th>
                        <th>Ý nghĩa</th>
                        <th>Mức độ tốt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results['huongNhaTotChiTiet'] as $huong)
                        <tr>
                            <td class="fw-bold fs-5">{{ $huong['Huong'] }}</td>
                            <td>{{ $huong['Loai'] }}</td>
                            <td class="text-start p-3">{{ $huong['Y nghia'] }}</td>
                            <td><span class="badge bg-success fs-6">{{ $huong['Uu tien'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
