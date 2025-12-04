@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.0') }}">
        <link rel="stylesheet" href="{{ asset('/css/la-so.css?v=11.1') }}">
        <style>
            .main-content-wrapper {
                background-image: url(../images/Quy_Trinh_Bg.png);
                background-repeat: no-repeat;
                background-position: top center;
                background-size: 100% auto;
                /* Ảnh full-width, giữ đúng tỉ lệ */
                background-color: #ffffff;
                /* Màu nền phía dưới */
            }

            .shimmer {
                position: relative;
                overflow: hidden;
                background: #f0f0f0;
                animation: pulse 1.5s infinite;
                border-radius: 8px;
            }

            @keyframes pulse {
                0% {
                    opacity: 0.75;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    opacity: 0.75;
                }
            }

            .shimmer::after {
                content: "";
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(120deg,
                        rgba(255, 255, 255, 0.0) 0%,
                        rgba(255, 255, 255, 0.5) 50%,
                        rgba(255, 255, 255, 0.0) 100%);
                animation: shimmer 1.5s infinite;
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
                }
            }
        </style>
    @endpush

    <div class="bg-la-so">
        <div class="container-setup">
            <nav aria-label="breadcrumb" class="content-title-detail">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: #2254AB; text-decoration: underline;">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('laso.create') }}" style="color: #2254AB; text-decoration: underline;">Lá số tử
                            vi</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Kết quả lá số
                    </li>
                </ol>
            </nav>

            <div class="mt-3">
                <div class="row g-0 g-lg-3">
                    <div class="col-xl-9 col-sm-12 col-12 ">
                        @if (isset($imageUrl) && $imageUrl)
                            <!-- Tiêu đề Số tử vi của tên -->
                            <h1 class="content-title-home-lich " style="color: #192E52">
                                @if (isset($normalizedData['ho_ten']) && $normalizedData['ho_ten'])
                                    Tổng Quan Lá Số Tử Vi Của {{ $normalizedData['ho_ten'] }}
                                @else
                                    Tổng Quan Lá Số Tử Vi Của Bạn
                                @endif
                            </h1>




                            <div class="box--bg-thang mt-3 mb-3">
                                <div class=" text-center">
                                    <div class="d-flex justify-content-center">
                                        <div class="img-zoom-container" id="img-zoom-container" style="position: relative;">

                                            <!-- Ảnh khung (placeholder) -->
                                            <img src="/images/la_so_news1.png" id="laso-frame" class="img-fluid shimmer"
                                                style="display:block;">

                                            <!-- Ảnh lá số thật — KHÔNG load trực tiếp -->
                                            <img id="laso-image" class="img-fluid" style="display:none;">

                                            <!-- Loading spinner -->
                                            <div id="laso-loading"
                                                style="position:absolute;top:50%;left:50%; transform:translate(-50%, -50%); font-weight:bold;">
                                                Đang tải lá số...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 ">
                                        <a href="{{ route('laso.download', ['url' => $imageUrl, 'ho_ten' => $normalizedData['ho_ten'] ?? '']) }}"
                                            class="btn btn-success me-2 mt-2" download>
                                            <i class="fas fa-download"></i> Tải lá số
                                        </a>

                                        <a href="{{ route('laso.create') }}" class="btn btn-primary me-2  mt-2">
                                            <i class="fas fa-plus"></i> Tạo lá số mới
                                        </a>
                                        <a href="{{ route('laso.edit') }}" class="btn btn-warning  mt-2">
                                            <i class="fas fa-edit"></i> Chỉnh sửa lá số
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div id="luanGiaiResults"></div>


                        <!-- App Download Banner -->
                        @include('la-so-tu-vi.app')
                    </div>
                    @include('tools.siderbardetail')
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image zoom functionality (if needed)
            const image = document.getElementById('laso-image');
            const container = document.getElementById('img-zoom-container');
            const lens = document.getElementById('img-zoom-lens');
            const result = document.getElementById('img-zoom-result');
            const realImgUrl = "{{ route('laso.image_proxy', ['url' => $imageUrl]) }}";

            const img = new Image();
            img.src = realImgUrl;

            img.onload = function() {
                // Gắn src vào ảnh hiển thị
                image.src = realImgUrl;
                image.style.display = "block";
                // Ẩn khung
                document.getElementById("laso-frame").style.display = "none";
                // Ẩn loading
                document.getElementById("laso-loading").style.display = "none";
            };

            // Auto chạy luận giải sau 1 giây
            setTimeout(function() {
                autoRunLuanGiai();
            }, 500);

            // Function tự động chạy luận giải
            function autoRunLuanGiai() {
                const luanGiaiBtn = document.getElementById('luanGiaiBtn');
                if (luanGiaiBtn) {
                    // Set button thành trạng thái loading
                    luanGiaiBtn.disabled = true;
                    luanGiaiBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i>Bạn đợi một chút nhé! Chúng tôi đang phân tích lá số và chuẩn bị luận giải cho bạn';
                }

                // Hiển thị thông báo đang xử lý
                showLuanGiaiLoading();

                // Gọi API luận giải
                fetch('{{ route('laso.luan_giai') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hiển thị kết quả luận giải
                            showLuanGiaiResults(data.data);
                        } else {
                            let errorMsg = 'Lỗi: ' + data.message;
                            if (data.debug) {
                                console.error('API Debug Info:', data.debug);
                                if (data.debug.status) {
                                    errorMsg += '\nHTTP Status: ' + data.debug.status;
                                }
                                if (data.debug.missing_field) {
                                    errorMsg += '\nThiếu trường: ' + data.debug.missing_field;
                                }
                            }
                            showLuanGiaiError(errorMsg);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showLuanGiaiError('Đã xảy ra lỗi khi luận giải. Vui lòng thử lại.');
                    })
                    .finally(() => {
                        // Khôi phục button
                        if (luanGiaiBtn) {
                            luanGiaiBtn.disabled = false;
                            luanGiaiBtn.innerHTML = '<i class="fas fa-brain"></i> Luận giải lại';
                        }
                    });
            }

            // Luận giải functionality cho nút click
            const luanGiaiBtn = document.getElementById('luanGiaiBtn');
            if (luanGiaiBtn) {
                luanGiaiBtn.addEventListener('click', function() {
                    autoRunLuanGiai();
                });
            }

            function showLuanGiaiLoading() {
                let resultsSection = document.getElementById('luanGiaiResults');
                if (!resultsSection) {
                    resultsSection = document.createElement('div');
                    resultsSection.id = 'luanGiaiResults';
                    resultsSection.className = 'card mt-4';

                    // Thêm vào vị trí cố định
                    const targetElement = document.getElementById('luanGiaiResults');
                    if (targetElement) {
                        targetElement.parentNode.replaceChild(resultsSection, targetElement);
                    }
                }

                // Hiển thị loading
                const loadingHtml = `
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="loading-container text-center py-5">
                            <div class="loading-animation mb-4">
                                <div class="brain-loading">
                                    <i class="fas fa-brain fa-3x text-primary pulse-animation"></i>
                                </div>
                                <div class="dots-loading mt-3">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                            </div>
                            <h4 class="text-primary mb-2 fade-in">Bạn đợi một chút nhé! Chúng tôi đang phân tích lá số và chuẩn bị luận giải cho bạn</h4>
                           
                        </div>
                    </div>

                    <style>
                        .pulse-animation {
                            animation: pulse 2s infinite;
                        }

                        @keyframes pulse {
                            0% { transform: scale(1); opacity: 1; }
                            50% { transform: scale(1.1); opacity: 0.7; }
                            100% { transform: scale(1); opacity: 1; }
                        }

                        .dots-loading {
                            display: flex;
                            justify-content: center;
                            gap: 8px;
                        }

                        .dot {
                            width: 8px;
                            height: 8px;
                            border-radius: 50%;
                            background-color: #2254AB;
                            animation: dotPulse 1.5s infinite ease-in-out;
                        }

                        .dot:nth-child(1) { animation-delay: 0s; }
                        .dot:nth-child(2) { animation-delay: 0.3s; }
                        .dot:nth-child(3) { animation-delay: 0.6s; }

                        @keyframes dotPulse {
                            0%, 80%, 100% {
                                transform: scale(0.8);
                                opacity: 0.5;
                            }
                            40% {
                                transform: scale(1.2);
                                opacity: 1;
                            }
                        }

                        .fade-in {
                            animation: fadeIn 1s ease-in;
                        }

                        .fade-in-delayed {
                            animation: fadeIn 1s ease-in 0.5s both;
                        }

                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        
                    </style>
                `;

                resultsSection.innerHTML = loadingHtml;

                // Scroll đến loading section

            }

            function showLuanGiaiError(errorMsg) {
                let resultsSection = document.getElementById('luanGiaiResults');
                if (!resultsSection) return;

                // Hiển thị error
                const errorHtml = `
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Lỗi luận giải:</strong><br>
                            ${errorMsg}
                        </div>
                        <div class="text-center">
                            <button onclick="autoRunLuanGiai()" class="btn btn-outline-primary">
                                <i class="fas fa-redo"></i> Thử lại
                            </button>
                        </div>
                    </div>
                `;

                resultsSection.innerHTML = errorHtml;
            }

            function showLuanGiaiResults(data) {
                // Tạo hoặc cập nhật section hiển thị kết quả luận giải
                let resultsSection = document.getElementById('luanGiaiResults');
                if (!resultsSection) {
                    resultsSection = document.createElement('div');
                    resultsSection.id = 'luanGiaiResults';
                    resultsSection.className = 'card mt-4';

                    // Thêm vào vị trí cố định
                    const targetElement = document.getElementById('luanGiaiResults');
                    if (targetElement) {
                        targetElement.parentNode.replaceChild(resultsSection, targetElement);
                    }
                }


                // Parse nội dung luận giải từ responseObject
                let luanGiaiContent = '';
                if (typeof data === 'string') {
                    luanGiaiContent = data;
                } else if (data && data.responseObject) {
                    luanGiaiContent = data.responseObject;
                } else if (data && typeof data === 'object') {
                    luanGiaiContent = JSON.stringify(data, null, 2);
                } else {
                    luanGiaiContent = 'Không có nội dung luận giải';
                }

                // Format nội dung - chuyển đổi từ markdown/text thành HTML
                const formattedContent = formatLuanGiaiContent(luanGiaiContent);

                // Tạo HTML hiển thị kết quả
                const resultsHtml = `
                   
                    <div class="box--bg-thang mt-3 mb-3">
                       
                        <div class="text-box-tong-quan">
                            ${formattedContent}
                        </div>
                    </div>
                `;

                resultsSection.innerHTML = resultsHtml;


            }

            function formatLuanGiaiContent(content) {
                if (!content || typeof content !== 'string') {
                    return '<p class="text-muted">Không có nội dung luận giải</p>';
                }

                // Escape HTML để tránh XSS
                const escapeHtml = (text) => {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                };

                const escaped = escapeHtml(content);

                // Format the content
                let formatted = escaped
                    // Convert **text** thành <strong>text</strong>
                    .replace(/\*\*(.*?)\*\*/g, '<strong class="text-primary">$1</strong>')
                    // Convert đoạn văn thành paragraphs
                    .replace(/\n\n/g, '</p><p>')
                    // Xử lý line breaks
                    .replace(/\n/g, '<br>');

                // Wrap trong paragraphs
                formatted = '<p>' + formatted + '</p>';

                // Cleanup empty paragraphs
                formatted = formatted.replace(/<p><\/p>/g, '');
                formatted = formatted.replace(/<p><br><\/p>/g, '');

                return formatted;
            }
        });
    </script>
@endpush
