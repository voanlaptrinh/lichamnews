@extends('welcome')

@section('content')
   @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/thansohoc.css?v=11.5') }}">
         <!-- Tailwind CSS -->
      <script src="https://cdn.tailwindcss.com"></script>
         <script>
                 tailwind.config = {
                    theme: {
                       extend: {
                            colors: {
                              primary: 
         '#1e40af',
                                secondary: 
          '#7c3aed'
                           }
                         }
                    }
                }
             </script>
    @endpush

<div class="container mx-auto px-4 py-8">
    {{-- Header Section --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            🔮 Thần Số Học
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Khám phá bản chất con người qua các con số. Tìm hiểu số chủ đạo, số tên, biểu đồ ngày sinh và nhiều bí ẩn khác về cuộc đời bạn.
        </p>
    </div>

    {{-- Main Form --}}
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('numerology.calculate') }}" method="POST" id="numerologyForm">
            @csrf

            {{-- Error Display --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6">
                    <ul class="list-none">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center">
                                <span class="mr-2">⚠️</span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Personal Information --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="mr-3">👤</span>
                    Thông tin cá nhân
                </h2>

                {{-- Full Name --}}
                <div class="mb-6">
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Họ và tên đầy đủ *
                    </label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Ví dụ: Nguyễn Văn An"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Nhập họ tên tiếng Việt có dấu để kết quả chính xác nhất</p>
                </div>

                {{-- Birth Date --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Ngày sinh *
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        {{-- Day --}}
                        <div>
                            <label for="birth_day" class="block text-xs text-gray-600 mb-1">Ngày</label>
                            <select
                                id="birth_day"
                                name="birth_day"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Chọn ngày</option>
                                @for($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ old('birth_day') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Month --}}
                        <div>
                            <label for="birth_month" class="block text-xs text-gray-600 mb-1">Tháng</label>
                            <select
                                id="birth_month"
                                name="birth_month"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Tháng</option>
                                @php
                                    $months = [
                                        1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4',
                                        5 => 'Tháng 5', 6 => 'Tháng 6', 7 => 'Tháng 7', 8 => 'Tháng 8',
                                        9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
                                    ];
                                @endphp
                                @foreach($months as $value => $label)
                                    <option value="{{ $value }}" {{ old('birth_month') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Year --}}
                        <div>
                            <label for="birth_year" class="block text-xs text-gray-600 mb-1">Năm</label>
                            <select
                                id="birth_year"
                                name="birth_year"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Năm</option>
                                @for($i = date('Y'); $i >= 1900; $i--)
                                    <option value="{{ $i }}" {{ old('birth_year') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Gender --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Giới tính *
                    </label>
                    <div class="flex gap-6">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="radio"
                                name="gender"
                                value="male"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                {{ old('gender') == 'male' ? 'checked' : '' }}
                                required
                            >
                            <span class="ml-2 text-gray-700">👨 Nam</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="radio"
                                name="gender"
                                value="female"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                {{ old('gender') == 'female' ? 'checked' : '' }}
                                required
                            >
                            <span class="ml-2 text-gray-700">👩 Nữ</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl text-lg transition duration-300 transform hover:scale-105 shadow-lg"
                    id="submitBtn"
                >
                    <span class="flex items-center justify-center">
                        <span class="mr-2">✨</span>
                        Tính Toán Thần Số Học
                        <span class="ml-2">🔮</span>
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- Features Preview --}}
    <div class="mt-16 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
            Những gì bạn sẽ khám phá
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">📊</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Các Số Cơ Bản</h3>
                <p class="text-gray-600">Số chủ đạo, số tên, số linh hồn, số tính cách và các con số quan trọng khác</p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">⏰</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Chu Kỳ Cuộc Đời</h3>
                <p class="text-gray-600">4 đỉnh cao cuộc đời, chu kỳ 9 năm và năm cá nhân hiện tại</p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">📈</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Biểu Đồ & Mui Tên</h3>
                <p class="text-gray-600">Biểu đồ ngày sinh Pythagorean và phân tích mui tên cá tính</p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">🎭</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Nghiệp Quả</h3>
                <p class="text-gray-600">Bài học cần học và nghiệp quả từ kiếp trước</p>
            </div>

            {{-- Feature 5 --}}
            <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">🎯</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Năng Lực Bẩm Sinh</h3>
                <p class="text-gray-600">4 năng lực: giao tiếp, sáng tạo, tổ chức và trực giác</p>
            </div>

            {{-- Feature 6 --}}
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl">
                <div class="text-3xl mb-4">🍀</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Màu Sắc & Số May Mắn</h3>
                <p class="text-gray-600">Màu sắc theo ngũ hành, con số và hướng may mắn</p>
            </div>
        </div>
    </div>
</div>

{{-- Loading Animation --}}
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Đang tính toán...</h3>
        <p class="text-gray-600">Vui lòng chờ trong giây lát</p>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('numerologyForm').addEventListener('submit', function() {
    document.getElementById('loadingOverlay').classList.remove('hidden');
});

// Auto-adjust days based on month selection
document.getElementById('birth_month').addEventListener('change', function() {
    const month = parseInt(this.value);
    const year = parseInt(document.getElementById('birth_year').value) || 2000;
    const daySelect = document.getElementById('birth_day');
    const selectedDay = daySelect.value;

    // Calculate days in month
    let daysInMonth = new Date(year, month, 0).getDate();

    // Clear existing options except first one
    daySelect.innerHTML = '<option value="">Chọn ngày</option>';

    // Add days
    for(let i = 1; i <= daysInMonth; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        if(i == selectedDay) option.selected = true;
        daySelect.appendChild(option);
    }
});

// Trigger day adjustment on year change too
document.getElementById('birth_year').addEventListener('change', function() {
    document.getElementById('birth_month').dispatchEvent(new Event('change'));
});
</script>
@endpush
@endsection