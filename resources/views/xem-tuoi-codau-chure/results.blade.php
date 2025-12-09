<div class="w-100" id="content-box-success">
    <div class="card border-0 mb-3 w-100 box-detial-year">
        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="thông tin người xem" width="28" height="28"
                    class="me-1">Thông tin hai người
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 border rounded mb-3">
                        <h6 class="fw-bold mb-2">Người A - {{ $results['person1']['gender'] }}</h6>
                        <p class="mb-1">
                            <strong>Ngày sinh:</strong>
                            {{ $results['person1']['ngaySinhDuongLich']->format('d/m/Y') }} tức ngày
                            {{ $results['person1']['ngaySinhAmLich'][0]}}/{{ $results['person1']['ngaySinhAmLich'][1]}}/{{ $results['person1']['ngaySinhAmLich'][2]}} âm lịch
                        </p>
                        <p class="mb-1">
                            <strong>Can Chi:</strong> {{ $results['person1']['can_chi'] }}
                        </p>
                        <p class="mb-1">
                            <strong>Mệnh:</strong> {{ $results['person1']['nap_am'] }} ({{ $results['person1']['nap_am_hanh'] }})
                        </p>
                        <p class="mb-0">
                            <strong>Cung Phi:</strong> {{ $results['person1']['cung_phi'] }} ({{ $results['person1']['cung_phi_hanh'] }})
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded mb-3">
                        <h6 class="fw-bold mb-2">Người B - {{ $results['person2']['gender'] }}</h6>
                        <p class="mb-1">
                            <strong>Ngày sinh:</strong>
                            {{ $results['person2']['ngaySinhDuongLich']->format('d/m/Y') }} tức ngày
                            {{ $results['person2']['ngaySinhAmLich'][0]}}/{{ $results['person2']['ngaySinhAmLich'][1]}}/{{ $results['person2']['ngaySinhAmLich'][2]}} âm lịch
                        </p>
                        <p class="mb-1">
                            <strong>Can Chi:</strong> {{ $results['person2']['can_chi'] }}
                        </p>
                        <p class="mb-1">
                            <strong>Mệnh:</strong> {{ $results['person2']['nap_am'] }} ({{ $results['person2']['nap_am_hanh'] }})
                        </p>
                        <p class="mb-0">
                            <strong>Cung Phi:</strong> {{ $results['person2']['cung_phi'] }} ({{ $results['person2']['cung_phi_hanh'] }})
                        </p>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="p-3 border rounded mb-3">
                        <h6 class="fw-bold mb-2">Người B - {{ $results['person2']['gender'] }}</h6>
                        <p class="mb-1">
                            <strong>Ngày sinh:</strong>
                            {{ $results['person2']['ngaySinhDuongLich']->format('d/m/Y') }} tức ngày
                            {{ $results['person2']['ngaySinhAmLich'] }} âm lịch
                        </p>
                        <p class="mb-1">
                            <strong>Can Chi:</strong> {{ $results['person2']['can_chi'] }}
                        </p>
                        <p class="mb-1">
                            <strong>Mệnh:</strong> {{ $results['person2']['nap_am'] }} ({{ $results['person2']['nap_am_hanh'] }})
                        </p>
                        <p class="mb-0">
                            <strong>Cung Phi:</strong> {{ $results['person2']['cung_phi'] }} ({{ $results['person2']['cung_phi_hanh'] }})
                        </p>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="card border-0 mb-3 w-100 box-detial-year">
        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="kết quả phân tích" width="28" height="28"
                    class="me-1">Kết quả phân tích tuổi hợp nhau
            </div>

            <div class="text-center p-4 mb-4 bg-light rounded">
                <h3 class="text-primary mb-2">{{ $results['conclusion']['title'] }}</h3>
                <h4>Tổng điểm:
                    <span class="badge bg-{{ $results['total_score'] >= 7 ? 'success' : ($results['total_score'] >= 4 ? 'warning' : 'danger') }} fs-5">
                        {{ $results['total_score'] }}/10
                    </span>
                </h4>
                <div class="mt-3 text-start">
                    {!! $results['conclusion']['description'] !!}
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 mb-3 w-100 box-detial-year">
        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="phân tích chi tiết" width="28" height="28"
                    class="me-1">Phân tích chi tiết theo từng tiêu chí
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="text-center" style="background-color: #e8ebee;">
                        <tr>
                            <th style="border-radius: 8px 0 0 8px">Tiêu chí</th>
                            <th>Người A</th>
                            <th>Người B</th>
                            <th>Mối quan hệ</th>
                            <th style="border-radius: 0 8px 8px 0">Điểm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results['details'] as $detail)
                        @dd($detail)
                            <tr>
                                <td><strong>{{ $detail['tieu_chi'] }}</strong></td>
                                <td>{{ $detail['gia_tri_a'] }}</td>
                                <td>{{ $detail['gia_tri_b'] }}</td>
                                <td>{{ $detail['moi_quan_he'] }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $detail['diem'] == 2 ? 'bg-success' : ($detail['diem'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ $detail['diem'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(isset($results['loi_khuyen']) && !empty($results['loi_khuyen']))
    <div class="card border-0 mb-3 w-100 box-detial-year">
        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="lời khuyên" width="28" height="28"
                    class="me-1">Lời khuyên
            </div>

            <div class="alert alert-info">
                {!! $results['loi_khuyen'] !!}
            </div>
        </div>
    </div>
    @endif
</div>