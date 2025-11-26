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

        /* Image zoom container */
        .img-zoom-container {
            position: relative;
            display: inline-block;
            cursor: crosshair;
        }

        .img-zoom-lens {
            position: absolute;
            border: 1px solid #d4af37;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(2px);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
            pointer-events: none;
            z-index: 1000;
        }

        .img-zoom-result {
            position: absolute;
            border: 2px solid #d4af37;
            width: 300px;
            height: 300px;
            background-repeat: no-repeat;
            z-index: 1001;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: none;
            background-color: white;
        }

        .img-zoom-result::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: linear-gradient(45deg, #d4af37, #f4f0c0, #d4af37);
            border-radius: 18px;
            z-index: -1;
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
                    <div class="img-zoom-container" id="img-zoom-container">
                        <img src="{{ route('laso.image_proxy', ['url' => $imageUrl]) }}" alt="Lá số tử vi"
                            class="img-fluid laso-image" id="laso-image">
                        <div class="img-zoom-lens" id="img-zoom-lens"></div>
                        <div class="img-zoom-result" id="img-zoom-result"></div>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imgZoomContainer = document.getElementById('img-zoom-container');
            const img = document.getElementById('laso-image');
            const lens = document.getElementById('img-zoom-lens');
            const result = document.getElementById('img-zoom-result');

            if (!imgZoomContainer || !img || !lens || !result) return;

            let zoomRatio = 2.5; // Tỷ lệ phong to

            // Đợi ảnh load xong
            img.onload = function() {
                initImageZoom();
            };

            // Nếu ảnh đã load
            if (img.complete) {
                initImageZoom();
            }

            function initImageZoom() {
                const imgRect = img.getBoundingClientRect();
                const containerRect = imgZoomContainer.getBoundingClientRect();

                // Kiểm tra ảnh đã load chưa
                if (!img.complete || img.naturalWidth === 0) {
                    console.log('Image not fully loaded, retrying...');
                    setTimeout(initImageZoom, 100);
                    return;
                }

                // Tạo một image mới để đảm bảo crossorigin
                const bgImg = new Image();
                bgImg.crossOrigin = "anonymous";

                bgImg.onload = function() {
                    // Set background image cho zoom result
                    result.style.backgroundImage = `url("${bgImg.src}")`;

                    // Tính toán kích thước background
                    const imgDisplayWidth = img.clientWidth;
                    const imgDisplayHeight = img.clientHeight;

                    result.style.backgroundSize = `${imgDisplayWidth * zoomRatio}px ${imgDisplayHeight * zoomRatio}px`;
                    result.style.backgroundRepeat = 'no-repeat';

                    console.log('Zoom image loaded successfully');
                };

                bgImg.onerror = function() {
                    // Fallback: dùng trực tiếp src của img gốc
                    result.style.backgroundImage = `url("${img.src}")`;
                    result.style.backgroundSize = `${img.clientWidth * zoomRatio}px ${img.clientHeight * zoomRatio}px`;
                    result.style.backgroundRepeat = 'no-repeat';
                    console.log('Using fallback image source');
                };

                bgImg.src = img.src;

                // Mouse enter - hiển thị zoom
                imgZoomContainer.addEventListener('mouseenter', function() {
                    lens.style.display = 'block';
                    result.style.display = 'block';
                });

                // Mouse leave - ẩn zoom
                imgZoomContainer.addEventListener('mouseleave', function() {
                    lens.style.display = 'none';
                    result.style.display = 'none';
                });

                // Mouse move - cập nhật vị trí
                imgZoomContainer.addEventListener('mousemove', function(e) {
                    updateZoom(e);
                });

                // Touch support cho mobile
                imgZoomContainer.addEventListener('touchmove', function(e) {
                    e.preventDefault();
                    if (e.touches.length === 1) {
                        updateZoom(e.touches[0]);
                    }
                });

                function updateZoom(e) {
                    const imgRect = img.getBoundingClientRect();
                    const containerRect = imgZoomContainer.getBoundingClientRect();

                    // Tính vị trí chuột relative với ảnh
                    const x = e.clientX - imgRect.left;
                    const y = e.clientY - imgRect.top;

                    // Kiểm tra chuột có trong ảnh không
                    if (x < 0 || y < 0 || x > imgRect.width || y > imgRect.height) {
                        lens.style.display = 'none';
                        result.style.display = 'none';
                        return;
                    }

                    lens.style.display = 'block';
                    result.style.display = 'block';

                    // Cập nhật vị trí lens
                    const lensWidth = parseInt(window.getComputedStyle(lens).width);
                    const lensHeight = parseInt(window.getComputedStyle(lens).height);

                    let lensX = x - (lensWidth / 2);
                    let lensY = y - (lensHeight / 2);

                    // Giới hạn lens trong ảnh
                    lensX = Math.max(0, Math.min(lensX, imgRect.width - lensWidth));
                    lensY = Math.max(0, Math.min(lensY, imgRect.height - lensHeight));

                    lens.style.left = lensX + 'px';
                    lens.style.top = lensY + 'px';

                    // Cập nhật vị trí result (bên phải ảnh)
                    const resultWidth = parseInt(window.getComputedStyle(result).width);
                    const resultHeight = parseInt(window.getComputedStyle(result).height);

                    let resultX = containerRect.width + 20; // Bên phải container
                    let resultY = y - (resultHeight / 2);

                    // Nếu không đủ chỗ bên phải, hiển thị bên trái
                    if (resultX + resultWidth > window.innerWidth - 20) {
                        resultX = -resultWidth - 20;
                    }

                    // Giới hạn result trong viewport
                    resultY = Math.max(20 - containerRect.top, Math.min(resultY,
                        window.innerHeight - resultHeight - 20 - containerRect.top));

                    result.style.left = resultX + 'px';
                    result.style.top = resultY + 'px';

                    // Cập nhật background position cho zoom
                    const bgPosX = ((lensX + lensWidth/2) / imgRect.width) * 100;
                    const bgPosY = ((lensY + lensHeight/2) / imgRect.height) * 100;

                    result.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
                }
            }

            // Cập nhật khi resize window
            window.addEventListener('resize', function() {
                if (img.complete) {
                    initImageZoom();
                }
            });
        });
    </script>
@endsection
