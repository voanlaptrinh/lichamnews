@extends('welcome')
@section('content')
    @push('styles')
        <style>
            body {
                background: white
            }

            .text-h3-404 {
                color: rgba(34, 84, 171, 1);
                font-weight: 600;
            }
        </style>
    @endpush
    <div class="d-flex justify-content-center pt-5 pb-5">
        <div>
            <div class="d-flex justify-content-center">
                <img src="{{ asset('icons/404_notfound.svg?v=1.0') }}" alt="404_notfound" class="img-fluid">
            </div>
            <div class="text-center">
                <h3 class="text-h3-404">Oops! Page not found</h3>
                <p style="max-width: 1000px">Rất tiếc, trang bạn tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm thời không khả
                    dụng. Vui lòng kiểm tra
                    lại địa chỉ URL hoặc quay lại trang chủ để tìm thông tin bạn cần. Cảm ơn bạn.</p>
            </div>
        </div>


    </div>
@endsection
