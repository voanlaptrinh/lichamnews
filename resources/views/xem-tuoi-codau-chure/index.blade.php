@extends('welcome')

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="text-center mb-4">Xem Tuổi Hợp Nhau</h1>

        <!-- FORM NHẬP LIỆU -->
        <div class="card form-card">
            <div class="card-body">
                <form action="{{ route('compatibility.calculate') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Người thứ nhất -->
                        <div class="col-md-6 border-end">
                            <h5 class="mb-3">Thông tin người thứ nhất</h5>
                            <div class="mb-3">
                                <label for="dob1" class="form-label">Ngày sinh (Dương lịch)</label>
                                <input type="text" class="form-control" id="dob1" name="dob1"
                                    placeholder="Chọn ngày sinh" value="{{ old('dob1', $input['dob1'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="gender1" class="form-label">Giới tính</label>
                                <select class="form-select" id="gender1" name="gender1">
                                    {{-- TỐI ƯU HÓA: Sử dụng old() để chọn đúng giá trị khi validation lỗi --}}
                                    <option value="Nam" @if (old('gender1', $input['gender1'] ?? 'Nam') == 'Nam') selected @endif>Nam</option>
                                    <option value="Nữ" @if (old('gender1', $input['gender1'] ?? 'Nam') == 'Nữ') selected @endif>Nữ</option>
                                </select>
                            </div>
                        </div>

                        <!-- Người thứ hai -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Thông tin người thứ hai</h5>
                            <div class="mb-3">
                                <label for="dob2" class="form-label">Ngày sinh (Dương lịch)</label>
                                <input type="text" class="form-control" id="dob2" name="dob2"
                                    placeholder="Chọn ngày sinh" value="{{ old('dob2', $input['dob2'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="gender2" class="form-label">Giới tính</label>
                                <select class="form-select" id="gender2" name="gender2">
                                    {{-- TỐI ƯU HÓA: Sử dụng old() với giá trị mặc định là Nữ --}}
                                    <option value="Nam" @if (old('gender2', $input['gender2'] ?? 'Nữ') == 'Nam') selected @endif>Nam</option>
                                    <option value="Nữ" @if (old('gender2', $input['gender2'] ?? 'Nữ') == 'Nữ') selected @endif>Nữ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label for="type" class="form-label">Mục đích xem</label>
                            <select class="form-select" id="type" name="type">
                                {{-- TỐI ƯU HÓA: Sử dụng old() --}}
                                <option value="capdoi" @if (old('type', $input['type'] ?? 'capdoi') == 'capdoi') selected @endif>Xem tuổi Vợ Chồng
                                </option>
                                <option value="laman" @if (old('type', $input['type'] ?? 'capdoi') == 'laman') selected @endif>Xem tuổi Làm Ăn
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary w-100 mt-3 mt-md-0">Xem kết quả</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- PHẦN HIỂN THỊ KẾT QUẢ (giữ nguyên) -->
        @if (isset($result))
            @php
                $criteriaNames = [
                    'ngu_hanh_nap_am' => 'Ngũ Hành Nạp Âm',
                    'thien_can' => 'Thiên Can',
                    'dia_chi' => 'Địa Chi',
                    'cung_phi' => 'Cung Phi Bát Trạch',
                    'ngu_hanh_cung_phi' => 'Ngũ Hành Cung Phi',
                ];
                $personInfoMapping = [
                    'ngu_hanh_nap_am' => 'nap_am_hanh',
                    'thien_can' => 'thien_can',
                    'dia_chi' => 'dia_chi',
                    'cung_phi' => 'cung_phi',
                    'ngu_hanh_cung_phi' => 'cung_phi_hanh',
                ];
            @endphp
            <div class="card result-card">
                <div class="card-header text-center bg-primary text-white">
                    <h2>KẾT QUẢ PHÂN TÍCH</h2>
                </div>
                <div class="card-body">
                    <div class="text-start p-3 mb-4 bg-light rounded">
                        <p class="result-summary text-primary">{{ $result['conclusion']['title'] }}</p>
                        <h3>Tổng điểm: <span class="badge bg-success score-badge">{{ $result['total_score'] }}/10</span>
                        </h3>
                        <p class="mt-2 fst-italic">Diễn giải: {!! $result['conclusion']['description'] !!}</p>
                    </div>
                    <div class="row text-center mb-4">
                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <h5>{{ $result['person1']['gender'] }} - {{ $result['person1']['year'] }}</h5>
                                <p>Dương lịch: {{ $birthdate1->day }} / {{ $birthdate1->month }} / {{ $birthdate1->year }}
                                </p>
                                <p>Âm lịch: {{ $birthdateal1[0] }} / {{ $birthdateal1[1] }} / {{ $birthdateal1[2] }}</p>
                                <p class="mb-0"><strong>Can Chi:</strong> {{ $result['person1']['can_chi'] }}</p>
                                <p class="mb-0"><strong>Mệnh:</strong> {{ $result['person1']['nap_am'] }}
                                    ({{ $result['person1']['nap_am_hanh'] }})</p>
                                <p class="mb-0"><strong>Cung Phi:</strong> {{ $result['person1']['cung_phi'] }}
                                    ({{ $result['person1']['cung_phi_hanh'] }})</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <h5>{{ $result['person2']['gender'] }} - {{ $result['person2']['year'] }}</h5>
                                <p>Dương lịch: {{ $birthdate2->day }} / {{ $birthdate2->month }} /
                                    {{ $birthdate2->year }}</p>
                                <p>Âm lịch: {{ $birthdateal2[0] }} / {{ $birthdateal2[1] }} / {{ $birthdateal2[2] }}</p>
                                <p class="mb-0"><strong>Can Chi:</strong> {{ $result['person2']['can_chi'] }}</p>
                                <p class="mb-0"><strong>Mệnh:</strong> {{ $result['person2']['nap_am'] }}
                                    ({{ $result['person2']['nap_am_hanh'] }})</p>
                                <p class="mb-0"><strong>Cung Phi:</strong> {{ $result['person2']['cung_phi'] }}
                                    ({{ $result['person2']['cung_phi_hanh'] }})</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tiêu chí</th>
                                    <th>{{ $result['person1']['gender'] }} {{ $result['person1']['year'] }}</th>
                                    <th>{{ $result['person2']['gender'] }} {{ $result['person2']['year'] }}</th>
                                    <th>Mối quan hệ</th>
                                    <th>Điểm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['details'] as $key => $detail)
                                    <tr>
                                        <td><strong>{{ $criteriaNames[$key] ?? $key }}</strong></td>
                                        <td>{{ $result['person1'][$personInfoMapping[$key]] }}</td>
                                        <td>{{ $result['person2'][$personInfoMapping[$key]] }}</td>
                                        <td>{{ $detail['relation'] }}</td>
                                        <td> <span
                                                class="badge {{ $detail['score'] == 2 ? 'bg-success' : ($detail['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                {{ $detail['score'] }} </span> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // --- KHỞI TẠO FLATPCIKR ---
                const flatpickrConfig = {
                    locale: "vn",
                    dateFormat: "d-m-Y",
                    allowInput: true,
                    maxDate: "today",
                };
                flatpickr("#dob1", flatpickrConfig);
                flatpickr("#dob2", flatpickrConfig);

                // --- XỬ LÝ LOGIC GIỚI TÍNH VÀ MỤC ĐÍCH XEM ---
                const typeSelect = document.getElementById('type');
                const gender1Select = document.getElementById('gender1');
                const gender2Select = document.getElementById('gender2');

                // Hàm này chỉ đồng bộ giới tính khi mục đích là 'Xem tuổi Vợ Chồng'
                function syncGenders(sourceSelect) {
                    // Nếu mục đích không phải xem vợ chồng, không làm gì cả
                    if (typeSelect.value !== 'capdoi') return;

                    // Nếu là xem vợ chồng, tự động đổi giới tính của người còn lại
                    if (sourceSelect.id === 'gender1') {
                        gender2Select.value = (gender1Select.value === 'Nam') ? 'Nữ' : 'Nam';
                    } else if (sourceSelect.id === 'gender2') {
                        gender1Select.value = (gender2Select.value === 'Nam') ? 'Nữ' : 'Nam';
                    }
                }

                // Hàm này được gọi khi người dùng thay đổi mục đích xem
                function handleTypeChange() {
                    // Nếu chuyển sang chế độ 'Xem tuổi Vợ Chồng' và 2 giới tính đang giống nhau
                    if (typeSelect.value === 'capdoi' && gender1Select.value === gender2Select.value) {
                        // Tự động đổi giới tính người thứ 2
                        gender2Select.value = (gender1Select.value === 'Nam') ? 'Nữ' : 'Nam';
                    }
                    // Nếu chuyển sang 'Xem tuổi Làm Ăn', không cần làm gì, hàm syncGenders sẽ tự động bị vô hiệu hóa
                }

                // Gán sự kiện cho các thẻ select
                gender1Select.addEventListener('change', function() {
                    syncGenders(this);
                });
                gender2Select.addEventListener('change', function() {
                    syncGenders(this);
                });
                typeSelect.addEventListener('change', handleTypeChange);

                // Chạy hàm này 1 lần khi tải trang để đảm bảo trạng thái ban đầu luôn đúng
                handleTypeChange();
            });
        </script>
    @endpush
@endsection
