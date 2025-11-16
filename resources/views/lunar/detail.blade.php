@extends('welcome')
@section('content')
    <div class="container-setup">
         <div class="col-xl-9 col-sm-12 col-12">
             <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                 <nav aria-label="breadcrumb" class="content-title-detail">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                    </li>


                    <li class="breadcrumb-item active" aria-current="page">
                    Lịch ngày {{ $dd }}/{{ $mm }}/{{ $yy }}
                    </li>
                </ol>
            </nav>

               
                <h1 class="content-title-home-lich" id="page-title">Lịch Âm Dương Ngày {{ $dd }} Tháng
                    {{ $mm }} Năm {{ $yy }}</h1>
            </div>
            <div>
                <button class="btn-today-home-pc btn-today-home justify-content-center align-items-center quickPickerBtn">
                    <i class="bi bi-calendar-event pe-2"></i>
                    <div>Xem nhanh theo ngày</div>
                </button>
            </div>
        </div>
        </div>

        <div id="detail-content">
            @include('lunar.today_content.content')
        </div>
    </div>

    <!-- Quick Picker Popup (same as convert page) -->
    @include('lunar.quickPickerOverlay')
@endsection


@push('scripts')
    @include('lunar.jsquickPickerOverlay')
@endpush
