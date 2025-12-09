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
                        <h6 class="fw-bold mb-2">
                            @if($results['type'] === 'capdoi')
                                Bạn - {{ $results['person1']['gender'] }}
                            @else
                                Bạn - {{ $results['person1']['gender'] }}
                            @endif
                        </h6>
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
                        <h6 class="fw-bold mb-2">
                            @if($results['type'] === 'capdoi')
                                Người ấy - {{ $results['person2']['gender'] }}
                            @else
                                Đối tác - {{ $results['person2']['gender'] }}
                            @endif
                        </h6>
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
            </div>
        </div>
    </div>

   

    @if($results['type'] === 'capdoi')
        <!-- Tab cho cặp đôi -->
        <div class="card border-0 mb-3 w-100 box-detial-year">
            <div class="card-body box1-con-year">
                <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                    <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="phân tích chi tiết" width="28" height="28"
                        class="me-1">Bình giải mức độ tương hợp
                </div>

             

                <!-- Tab Content -->
                <div class="tab-content" id="compatibilityTabsContent">
                    <!-- Direction 1 Tab -->
                    <div class="tab-pane fade show active" id="direction1" role="tabpanel" aria-labelledby="direction1-tab">
                        @include('xem-tuoi-codau-chure.partials.compatibility-table', [
                            'conclusion' => $results['conclusion'],
                            'direction' => $results['direction1'],
                            'person1' => $results['person1'],
                            'person2' => $results['person2']
                        ])
                    </div>

                    <!-- Direction 2 Tab -->
                    <div class="tab-pane fade" id="direction2" role="tabpanel" aria-labelledby="direction2-tab">
                        @include('xem-tuoi-codau-chure.partials.compatibility-table', [
                             'conclusion' => $results['conclusion'],
                            'direction' => $results['direction2'],
                            'person1' => $results['person2'],
                            'person2' => $results['person1']
                        ])
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Chỉ 1 tab cho đối tác -->
        <div class="card border-0 mb-3 w-100 box-detial-year">
            <div class="card-body box1-con-year">
                <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                    <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="phân tích chi tiết" width="28" height="28"
                        class="me-1">Phân tích chi tiết theo từng tiêu chí
                </div>

                {{-- <div class="mb-3">
                    <h5 class="text-center">
                        {{ $results['direction1']['from_label'] }} đối với {{ $results['direction1']['to_label'] }}
                        <span class="badge bg-primary">{{ $results['direction1']['total_score'] }}/10</span>
                    </h5>
                </div> --}}

                @include('xem-tuoi-codau-chure.partials.compatibility-table', [
                     'conclusion' => $results['conclusion'],
                    'direction' => $results['direction1'],
                    'person1' => $results['person2'],
                    'person2' => $results['person1']
                ])
            </div>
        </div>
    @endif
 <div class="card border-0 mb-3 w-100 box-detial-year">
        <div class="card-body box1-con-year">
            <div class="text-primary mb-3 title-tong-quan-h4-log text-dark d-flex align-items-center fw-bolder">
                <img src="{{ asset('/icons/dac-diem1.svg') }}" alt="kết quả phân tích" width="28" height="28"
                    class="me-1">Tổng quan đánh giá
            </div>

            <div class="text-center bg-light rounded">
                
                <div class="mt-3 text-start">
                    {!! $results['conclusion']['description'] !!}
                </div>
            </div>
        </div>
    </div>
 
</div>