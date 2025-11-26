@extends('welcome')
@section('content')
    <style>
        /* Custom CSS cho nút hành động lá số */
        .btn-laso-action {
            display: inline-flex;
            /* Để icon và text nằm trên cùng một hàng và căn giữa */
            align-items: center;
            justify-content: center;
            padding: 12px 30px;
            /* Padding cho nút */
            border-radius: 50px;
            /* Tạo hình dạng bo tròn như viên thuốc */
            border: 1px solid #B99E58;
            /* Màu và độ dày border */
            font-size: 1.1rem;
            /* Kích thước chữ */
            font-weight: 600;
            /* Độ đậm của chữ */
            text-decoration: none;
            /* Bỏ gạch chân cho link */
            color: #6B4226;
            /* Màu chữ (nâu đỏ đậm) */
            cursor: pointer;
            white-space: nowrap;
            /* Ngăn không cho chữ xuống dòng */

            /* Gradient Background */
            background: linear-gradient(to bottom, #FFFCD9 0%, #FAF9EC 50%, #F1EFD7 75%, #F4F0C0 100%);

            /* Chuyển động mượt mà khi hover */
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            /* Bóng mờ nhẹ */
        }

        .btn-laso-action i {
            margin-right: 8px;
            /* Khoảng cách giữa icon và chữ */
            color: #6B4226;
            /* Màu icon */
        }

        .btn-laso-action:hover {
            color: #4C1D00;
            /* Màu chữ đậm hơn khi hover */
            /* Thay đổi gradient nhẹ khi hover để tạo hiệu ứng */
            background: linear-gradient(to top, #FFFCD9 0%, #FAF9EC 50%, #F1EFD7 75%, #F4F0C0 100%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bóng rõ hơn khi hover */
            transform: translateY(-1px);
            /* Nâng nút lên một chút */
        }

        .btn-laso-action:active {
            transform: translateY(0);
            /* Đẩy nút xuống khi click */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            background: #F4F0C0;
            /* Màu nền đơn giản hơn khi active */
        }

        /* Lá số tử vi image responsive */
        .laso-image {
            max-height: 80vh;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        /* Mobile responsive cho lá số */
        @media (max-width: 768px) {
            .laso-image {
                max-height: 70vh;
                max-width: 95vw;
            }
        }
    </style>

    <div class="bg-la-so mb-2">
        <div class="container-setup">
            <nav aria-label="breadcrumb" class="content-title-detail">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                    </li>

                    <li class="breadcrumb-item">
                        Tử vi & Phong thuỷ
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        Lá số tử vi
                    </li>
                </ol>
            </nav>

            @if ($imageUrl)
                <div class="d-flex justify-content-center">

                    <img src="{{ route('laso.image_proxy', ['url' => $imageUrl]) }}" alt="Lá số tử vi"
                        class="img-fluid laso-image">
                </div>
            @else
                <div class="alert alert-warning">
                    Không thể hiển thị ảnh lá số.
                </div>
            @endif

            <div class="d-flex justify-content-center gap-3 mt-4">
                {{-- Nút "Chỉnh sửa lá số" (sẽ quay lại form) --}}
                <a href="{{ route('laso.create') }}" class="btn-laso-action">
                    <i class="fas fa-edit"></i> Chỉnh sửa lá số
                </a>

                {{-- Nút "Tải xuống lá số" --}}
                @if ($imageUrl)
                    <a href="{{ route('laso.download', ['url' => $imageUrl, 'ho_ten' => $normalizedData['ho_ten'] ?? '']) }}"
                        class="btn-laso-action" download>
                        <i class="fas fa-download"></i> Tải xuống lá số
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
