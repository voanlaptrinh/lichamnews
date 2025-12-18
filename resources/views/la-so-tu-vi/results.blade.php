@extends('welcome')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('/css/vanilla-daterangepicker.css?v=11.5') }}">
        <link rel="stylesheet" href="{{ asset('/css/la-so.css?v=11.5') }}">
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
                                            class="btn btn-success me-2 mt-2 "
                                            style="background: linear-gradient(45deg, #2254AB, #4a90e2); border: none; padding: 10px 20px; border-radius: 25px; font-weight: 500;color: white; box-shadow: 0 4px 15px rgba(34, 84, 171, 0.3);"
                                            download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                                <path
                                                    d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                                                <path
                                                    d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                            </svg> Tải lá số
                                        </a>


                                        <a href="{{ route('laso.create') }}"
                                            style="background: linear-gradient(45deg, #2254AB, #4a90e2);border: none;padding: 10px 20px; border-radius: 25px;font-weight: 500; color: white; box-shadow: 0 4px 15px rgba(34, 84, 171, 0.3);"
                                            class="btn btn-primary me-2  mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-plus" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
  <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
</svg> Tạo lá số mới
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
            // Kiểm tra query parameters trực tiếp
            const urlParams = new URLSearchParams(window.location.search);
            const hasUserData = urlParams.has('ten') && urlParams.has('gt') && urlParams.has('ns');

            // Nếu không có session results nhưng không có user data, redirect về form
            @if (!isset($imageUrl) || !$imageUrl)
                if (!hasUserData) {
                    window.location.href = "{{ route('laso.create') }}";
                    return;
                }
            @endif

            // Image zoom functionality (if needed) - chỉ khi có ảnh
            @if (isset($imageUrl) && $imageUrl)
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

            // Kiểm tra DB trước, có thì hiển thị, không có thì gọi API
            @if (isset($cachedLuanGiai) && $cachedLuanGiai)
                // Có trong DB - hiển thị ngay
                setTimeout(function() {
                    console.log('Lấy luận giải từ DB');
                    const cachedContent = {
                        responseObject: @json($cachedLuanGiai->luan_giai_content)
                    };
                    showLuanGiaiResults(cachedContent);
                }, 500);
            @else
                // Không có trong DB - gọi API luận giải
                setTimeout(function() {
                    console.log('Không có trong DB - gọi API luận giải');
                    autoRunLuanGiai();
                }, 500);
            @endif

            // Function tự động chạy luận giải - gọi API
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
                                     Xem thêm <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg>
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

            // Thêm query parameters vào URL khi load trang nếu có
            @if (isset($urlParams) && !empty($urlParams))
                if (!hasUserData) {
                    @foreach($urlParams as $key => $value)
                        @if($value)
                            urlParams.set('{{ $key }}', '{{ $value }}');
                        @endif
                    @endforeach
                    window.history.replaceState({}, document.title, window.location.pathname + '?' + urlParams.toString());
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
