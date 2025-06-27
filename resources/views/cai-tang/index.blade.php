@extends('welcome')

@section('content')
    <div class="container mt-4 mb-5">
        {{-- PHẦN FORM GIỮ NGUYÊN --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h1 class="h3 mb-0">Xem ngày sang cát - cải táng - động mộ</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('cai-tang.check') }}" method="POST">
                    @csrf

                    <div class="row">
                        <h4 class="text-center">THông tin người đứng lễ</h4>
                        <div class="col-md-6 mb-3">
                            <label for="birthdate" class="form-label">Ngày sinh</label>
                            {{-- SỬA Ở ĐÂY: Thêm lại class "dateuser" --}}
                            <input type="text" class="form-control dateuser @error('birthdate') is-invalid @enderror"
                                id="birthdate" name="birthdate" placeholder="dd/mm/yyyy"
                                value="{{ old('birthdate', $inputs['birthdate'] ?? '') }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="wedding_date_range" class="form-label">Dự kiến thời gian mua</label>
                            {{-- SỬA Ở ĐÂY: Thêm lại class "wedding_date_range" --}}
                            <input type="text"
                                class="form-control wedding_date_range @error('date_range') is-invalid @enderror"
                                id="date_range" name="date_range" placeholder="dd/mm/yy - dd/mm/yy"
                                value="{{ old('date_range', $inputs['date_range'] ?? '') }}">
                            @error('date_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <h4 class="text-center">
                            Thông tin người mất
                        </h4>
                        <div class="col-md-6">
                            <label for="wedding_date_range" class="form-label">Năm sinh âm lịch</label>
                            <select name="birth_mat" class="form-select">
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= 1800; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="wedding_date_range" class="form-label">Năm Mất âm lịch</label>
                            <select name="nam_mat" class="form-select">
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= 1800; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Xem Kết Quả</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- PHẦN HIỂN THỊ KẾT QUẢ --}}
        @if (isset($resultsByYear))
            {{-- *** CARD THÔNG TIN TÓM TẮT MỚI - GIỐNG NHƯ ẢNH *** --}}
            <div class="card shadow-sm mb-4" style="border: 2px dotted #0d6efd;">
                <div class="card-header bg-white border-0 text-center">
                    <h2 class="h4 mb-0 text-uppercase" style="color: #0d6efd;">Thông tin cơ bản về người xem</h2>
                </div>
                <div class="card-body">
                    {{-- Thông tin người đứng lễ --}}
                    <h5 class="fw-bold">Thông tin người đứng lễ</h5>
                    <ul class="list-unstyled ps-3">
                      
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Ngày sinh dương lịch:</strong> {{ $hostInfo['dob_str'] }}
                        </li>
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Ngày sinh âm lịch:</strong> {{ $hostInfo['lunar_dob_str'] }}
                            ({{ \App\Helpers\KhiVanHelper::canchiNam($hostInfo['dob_obj']->year) }})
                        </li>
                       
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Tuổi âm:</strong> {{ $hostInfo['lunar_age_now'] }} tuổi
                        </li>
                    </ul>

                    {{-- Thông tin người mất --}}
                    <h5 class="fw-bold mt-4">Thông tin về người mất</h5>
                    <ul class="list-unstyled ps-3">
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Năm sinh âm lịch:</strong> {{ $deceasedInfo['birth_year_lunar'] }}
                            ({{ $deceasedInfo['birth_can_chi'] }})
                        </li>
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Năm mất âm lịch:</strong> {{ $deceasedInfo['death_year_lunar'] }}
                            ({{ $deceasedInfo['death_can_chi'] }})
                        </li>
                        <li class="mb-2">
                            <span class="text-warning me-2">◆</span>
                            <strong>Tuổi:</strong> {{ $deceasedInfo['birth_can_chi'] }}
                        </li>
                    </ul>

                    {{-- Thời gian dự kiến --}}

                </div>
            </div>

            {{-- Phần phân tích các năm và ngày tốt --}}
            @foreach ($resultsByYear as $year => $data)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="h5 mb-0">Phân tích chi tiết năm {{ $year }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- Phân tích cho người đứng lễ --}}
                        <div class="alert @if ($data['host_analysis']['is_bad_year']) alert-warning @else alert-info @endif">
                            <h6 class="alert-heading">Đối với người đứng lễ (Tuổi mụ:
                                {{ $data['host_analysis']['lunar_age'] }})</h6>
                            <p class="mb-0">{!! $data['host_analysis']['description'] !!}</p>
                        </div>
                  
                        @php $deceasedResult = $data['deceased_analysis']; @endphp
                        <div class="border p-3 rounded mt-3">
                            <h6 class="text-uppercase">Xem tuổi người mất năm {{ $year }}</h6>
                            <p>Kiểm tra năm <strong>{{ $deceasedResult['check_year_can_chi'] }}
                                    ({{ $deceasedResult['check_year'] }})</strong> có phạm Thái Tuế, Tuế Phá (lục xung) với
                                tuổi người mất hay không?</p>
                            <p class="mt-3">
                                <strong>Người mất sinh năm {{ $deceasedResult['deceased_birth_year'] }}
                                    ({{ $deceasedResult['deceased_can_chi'] }}):</strong>
                            </p>
                            <ul class="list-unstyled ps-3">
                                <li>→ Năm {{ $deceasedResult['check_year_can_chi'] }}
                                    @if ($deceasedResult['is_thai_tue'])
                                        <strong class="text-danger">Phạm Thái Tuế</strong>
                                    @else
                                        <strong class="text-success">Không phạm Thái Tuế</strong>
                                    @endif
                                </li>
                                <li>→ @if ($deceasedResult['is_tue_pha'])
                                        <strong class="text-danger">Phạm Tuế Phá (xung Thái Tuế)</strong>
                                    @else
                                        <strong class="text-success">Không phạm Tuế Phá</strong>
                                    @endif
                                </li>
                            </ul>
                            <p class="mt-3"><strong>Kết luận:</strong></p>
                            <div class="alert @if ($deceasedResult['is_bad']) alert-danger @else alert-success @endif">
                                {!! $deceasedResult['conclusion'] !!}
                            </div>
                        </div>

                     
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection
