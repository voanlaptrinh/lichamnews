@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.0') }}">
        <link rel="stylesheet" href="{{ asset('/css/la-so.css?v=11.3') }}">
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

            /* Luan Giai Expand Styles */
            .luan-giai-container {
                position: relative;
            }

            .luan-giai-content {
                max-height: 300px;
                overflow: hidden;
                transition: max-height 0.5s ease-in-out;
            }

            .luan-giai-content.expanded {
                max-height: none;
            }

            .luan-giai-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 100px;
                background: linear-gradient(transparent, rgba(255, 255, 255, 0.9));
                display: flex;
                align-items: flex-end;
                justify-content: center;
                padding-bottom: 15px;
                transition: opacity 0.3s ease-in-out;
            }

            .luan-giai-overlay.hidden {
                opacity: 0;
                pointer-events: none;
            }

            .xem-them-btn {
                background: linear-gradient(45deg, #2254AB, #4a90e2);
                border: none;
                padding: 10px 20px;
                border-radius: 25px;
                font-weight: 500;
                color: white;
                box-shadow: 0 4px 15px rgba(34, 84, 171, 0.3);
                transition: all 0.3s ease;
            }

            .xem-them-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(34, 84, 171, 0.4);
                color: white;
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
            <h1 class="content-title-home-lich " style="color: #192E52">
                @if (isset($normalizedData['ho_ten']) && $normalizedData['ho_ten'])
                    Tổng Quan Lá Số Tử Vi Của {{ $normalizedData['ho_ten'] }}
                @else
                    Tổng Quan Lá Số Tử Vi Của Bạn
                @endif
            </h1>
            <div class="mt-3">
                <div class="row g-0 g-lg-3">
                    <div class="col-xl-9 col-sm-12 col-12 ">
                        @if (isset($imageUrl) && $imageUrl)
                            <!-- Tiêu đề Số tử vi của tên -->
                            <div class="box--bg-thang mb-3">
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
                        @else
                            <!-- Trường hợp đang load từ share link -->
                            <div class="box--bg-thang mb-3">
                                <div class="text-center py-5">
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
                                    <h4 class="text-primary mb-2 fade-in">Đang tải lá số được chia sẻ...</h4>
                                    <p class="text-muted">Vui lòng đợi trong giây lát</p>
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
            // Kiểm tra hash URL trước tiên
            const hash = window.location.hash;
            const hasShare = window.location.search.includes('share=');
            const hasHashData = hash.includes('thong-tin=');

            // Nếu không có session results nhưng có hash data, redirect với share param
            @if(!isset($imageUrl) || !$imageUrl)
                if (hasHashData && !hasShare) {
                    const hashParts = hash.split('thong-tin=');
                    if (hashParts.length > 1) {
                        const hashData = hashParts[1];
                        window.location.href = window.location.pathname + '?share=' + hashData + hash;
                        return;
                    }
                }

                // Nếu không có gì, redirect về form
                if (!hasShare && !hasHashData) {
                    window.location.href = "{{ route('laso.create') }}";
                    return;
                }
            @endif

            // Image zoom functionality (if needed) - chỉ khi có ảnh
            @if(isset($imageUrl) && $imageUrl)
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
            @endif

            // Tạo ID duy nhất cho lá số này
            const lasoId = generateLasoId();

            // Kiểm tra cache database và tự động hiển thị nếu có
            @if(isset($cachedLuanGiai) && $cachedLuanGiai)
                // Có cache trong database, hiển thị ngay
                setTimeout(function() {
                    console.log('Hiển thị luận giải từ database cache');
                    const cachedContent = {
                        responseObject: @json($cachedLuanGiai->luan_giai_content)
                    };
                    showLuanGiaiResults(cachedContent);
                }, 500);
            @else
                // Không có cache, tự động chạy luận giải
                setTimeout(function() {
                    autoRunLuanGiai();
                }, 500);
            @endif

            // Function tạo ID consistent cho lá số (giữ lại để tương thích với server)
            function generateLasoId() {
                // Không còn cần thiết cho localStorage nhưng giữ lại để tương thích
                return 'laso_placeholder';
            }

            // Function tự động chạy luận giải (không cache localStorage)
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

                // Gọi API luận giải (server sẽ kiểm tra database cache)
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
                        <h3 class="text-center mb-4" style="color: #2254AB; font-weight: 600;">
                            <i class="fas fa-brain me-2"></i>Luận Giải Tổng Quan
                        </h3>
                        <div class="luan-giai-container">
                            <div class="text-box-tong-quan luan-giai-content" id="luanGiaiContent">
                                ${formattedContent}
                            </div>
                            <div class="luan-giai-overlay" id="luanGiaiOverlay">
                                <button class="btn btn-primary xem-them-btn" onclick="showFullLuanGiai()">
                                    <i class="fas fa-chevron-down"></i> Xem thêm
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                resultsSection.innerHTML = resultsHtml;

                // Kiểm tra xem có cần hiển thị nút "Xem thêm" không
                setTimeout(() => {
                    checkIfNeedExpandButton();
                }, 100);
            }

            // Function để kiểm tra và hiển thị nút xem thêm
            function checkIfNeedExpandButton() {
                const content = document.getElementById('luanGiaiContent');
                const overlay = document.getElementById('luanGiaiOverlay');

                if (content && overlay) {
                    // Kiểm tra nếu nội dung cao hơn max-height
                    if (content.scrollHeight > 300) {
                        overlay.style.display = 'flex';
                    } else {
                        overlay.style.display = 'none';
                    }
                }
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

            // Thêm hash vào URL khi load trang nếu có
            @if (isset($urlHash) && $urlHash)
                if (!window.location.hash && !window.location.search.includes('share=')) {
                    const urlHash = '{{ $urlHash }}';
                    window.history.replaceState({}, document.title, window.location.pathname + '#thong-tin=' + urlHash);
                }
            @endif


        });

        // Global function để xử lý nút "Xem thêm"
        function showFullLuanGiai() {
            const content = document.getElementById('luanGiaiContent');
            const overlay = document.getElementById('luanGiaiOverlay');

            if (content && overlay) {
                content.classList.add('expanded');
                overlay.classList.add('hidden');

                // Scroll xuống một chút để người dùng thấy nội dung mở rộng
                setTimeout(() => {
                    content.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }
        }
    </script>
@endpush
