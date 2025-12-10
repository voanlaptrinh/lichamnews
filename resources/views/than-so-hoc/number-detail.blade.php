@extends('welcome')

@section('title', $pageTitle)

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/css/thansohoc.css?v=11.3') }}">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1e40af',
                    secondary: '#7c3aed'
                }
            }
        }
    }
</script>
@endpush

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $title }}</h1>
            <div class="bg-white rounded-2xl shadow-lg p-6 inline-block">
                <div class="flex items-center justify-center">
                    <span class="bg-blue-500 text-white text-6xl font-bold px-8 py-6 rounded-full mr-6">
                        {{ $number }}
                    </span>
                    <div class="text-left">
                        @if(isset($data['title']))
                            <h2 class="text-2xl font-bold text-blue-600 mb-2">{{ $data['title'] }}</h2>
                        @endif
                        <p class="text-gray-600">
                            @switch($type)
                                @case('birth_day')
                                    Ngày sinh với số {{ $number }}
                                    @break
                                @case('expression')
                                    Số tên với giá trị {{ $number }}
                                    @break
                                @case('soul_urge')
                                    Số linh hồn với giá trị {{ $number }}
                                    @break
                                @case('personality')
                                    Số tính cách với giá trị {{ $number }}
                                    @break
                                @case('attitude')
                                    Số thái độ với giá trị {{ $number }}
                                    @break
                                @case('maturity')
                                    Số trưởng thành với giá trị {{ $number }}
                                    @break
                                @case('personal_year')
                                    Năm cá nhân {{ $number }}
                                    @break
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Breadcrumb --}}
        <div class="mb-8">
            <nav class="text-sm breadcrumbs">
                <ol class="flex space-x-2">
                    <li><a href="{{ route('numerology.index') }}" class="text-blue-600 hover:text-blue-800">Thần Số Học</a></li>
                    <li class="text-gray-500">›</li>
                    <li class="text-gray-700">{{ $title }}</li>
                </ol>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                {{-- Calculation Method --}}
                <div class="mb-8 p-6 bg-blue-50 rounded-lg">
                    <h3 class="text-xl font-bold text-blue-800 mb-3">
                        <span class="mr-2">🧮</span>
                        Cách tính
                    </h3>
                    <p class="text-blue-700">{{ $data['calculation'] }}</p>
                </div>

                {{-- Main Interpretation --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        <span class="mr-2">📖</span>
                        Ý nghĩa chi tiết
                    </h3>
                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $data['interpretation'] }}</p>
                    </div>
                </div>

                {{-- Additional Sections --}}
                @if(!empty($data['sections']))
                    <div class="space-y-6">
                        @foreach($data['sections'] as $section)
                            @if(!empty($section['content']))
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-xl font-bold text-gray-800 mb-3">{{ $section['title'] }}</h4>
                                    <p class="text-gray-700 leading-relaxed">{{ $section['content'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Special sections for birth day --}}
                @if($type === 'birth_day' && isset($data['sections']) && !empty($data['sections']))
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($data['sections'] as $section)
                            @if(!empty($section['content']))
                                <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg p-6">
                                    <h4 class="text-lg font-bold text-purple-800 mb-3">{{ $section['title'] }}</h4>
                                    <p class="text-purple-700 text-sm leading-relaxed">{{ $section['content'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Related Numbers --}}
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <span class="mr-2">🔢</span>
                        Các số khác
                    </h3>
                    <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-{{ $type === 'personal_year' ? '9' : '11' }} gap-3">
                        @foreach($type === 'personal_year' ? [1,2,3,4,5,6,7,8,9] : [1,2,3,4,5,6,7,8,9,11,22] as $num)
                            @if($num != $number)
                                <a href="{{ route('numerology.' . $type . '.detail', $num) }}"
                                   class="bg-gray-100 hover:bg-blue-100 text-center py-3 px-2 rounded-lg transition-colors">
                                    <span class="text-lg font-bold text-gray-700">{{ $num }}</span>
                                </a>
                            @else
                                <div class="bg-blue-500 text-white text-center py-3 px-2 rounded-lg">
                                    <span class="text-lg font-bold">{{ $num }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Back to Calculator --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('numerology.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg transition font-semibold">
                        🔄 Tính toán thần số học của bạn
                    </a>
                </div>
            </div>
        </div>

        {{-- SEO Content --}}
        <div class="max-w-4xl mx-auto mt-8">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Về {{ $title }}</h3>
                <div class="prose prose-lg max-w-none text-gray-600">
                    <p>
                        @switch($type)
                            @case('birth_day')
                                Số ngày sinh trong thần số học có ý nghĩa quan trọng, thể hiện những tài năng và đặc điểm bẩm sinh của bạn.
                                Số {{ $number }} mang trong mình những năng lượng và thuộc tính riêng biệt, ảnh hưởng đến tính cách và vận mệnh.
                                @break
                            @case('expression')
                                Số tên (Expression Number) được tính từ tổng giá trị các chữ cái trong họ tên đầy đủ của bạn.
                                Số {{ $number }} thể hiện mục đích sống, tài năng và cách bạn thể hiện bản thân trong cuộc sống.
                                @break
                            @case('soul_urge')
                                Số linh hồn (Soul Urge Number) được tính từ các nguyên âm trong tên, thể hiện khát vọng và mong muốn sâu thẳm nhất.
                                Số {{ $number }} cho biết điều gì thúc đẩy bạn từ bên trong.
                                @break
                            @case('personality')
                                Số tính cách (Personality Number) được tính từ các phụ âm trong tên, thể hiện cách người khác nhìn nhận bạn.
                                Số {{ $number }} cho biết ấn tượng đầu tiên bạn tạo ra cho người khác.
                                @break
                            @case('attitude')
                                Số thái độ (Attitude Number) được tính từ ngày và tháng sinh, thể hiện cách bạn tiếp cận cuộc sống.
                                Số {{ $number }} cho biết thái độ và cách phản ứng tự nhiên của bạn.
                                @break
                            @case('maturity')
                                Số trưởng thành (Maturity Number) thể hiện mục tiêu và phương hướng phát triển trong giai đoạn trưởng thành.
                                Số {{ $number }} cho biết bạn sẽ hướng đến điều gì khi trưởng thành hơn.
                                @break
                            @case('personal_year')
                                Năm cá nhân {{ $number }} trong thần số học thể hiện năng lượng và chủ đề chính mà bạn sẽ trải nghiệm trong năm này.
                                Mỗi năm cá nhân mang một năng lượng riêng biệt, ảnh hưởng đến mọi khía cạnh cuộc sống của bạn.
                                @break
                        @endswitch
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.breadcrumbs ol {
    list-style: none;
    padding: 0;
    margin: 0;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

@media print {
    body { -webkit-print-color-adjust: exact; }
    .no-print { display: none !important; }
}
</style>
@endpush

@endsection