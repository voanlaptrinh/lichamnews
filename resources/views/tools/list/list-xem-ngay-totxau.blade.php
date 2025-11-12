@extends('welcome')
@section('content')
    <div class="container-setup">
        <div class="content-title-detail"><a href="{{ route('home') }}"
                style="color: #2254AB; text-decoration: underline;">Trang chủ</a><i class="bi bi-chevron-right"></i> <a
                style="" href="">Xem ngày tốt</a> <i class="bi bi-chevron-right"></i> <span>
                Tổng quan</span></div>

        <h1 class="content-title-home-lich">Tổng quan</h1>

        <div class="mt-3">
            <div class="row g-0 g-lg-3">
                <div class="col-xl-9 col-sm-12 col-12 ">
                    <div class="box--bg-thang ">
                        <div class="row  g-3">
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="{{ route('totxau.form') }}" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span> Xem ngày <br>
                                                tốt</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">

                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                kết hôn</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                dạm ngõ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                động thổ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                xuất hành</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                nhập trạch</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                mua nhà</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                mua xe</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                trấn trạch</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                làm giấy tờ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                khai trương</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                ký hợp đồng</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                sang cát</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                dời bàn thờ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày <br>
                                                lập bàn thờ</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày
                                                cúng sao
                                                giải hạn</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày
                                                cầu an -
                                                làm phúc</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày
                                                nhận công
                                                việc mới</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-6">
                                <div class="box-tong-quan-tot-xau">
                                    <a href="" class=" p-2">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('icons/xem-ngay-tot.svg') }}" class="icon img-fluid"
                                                width="80px" height="80px">
                                        </div>

                                        <div class="read-more-link-cotot">
                                            <span>Xem ngày
                                                thi cử -
                                                phỏng vấn</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box--bg-thang mt-3 mb-3">
                        <div class="title-tong-quan-h2-log">asdasd</div>
                        <hr>
                        <div class="ms-lg-3 text-box-tong-quan">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius molestie venenatis. Nunc a lorem eget purus lacinia luctus sit amet ac odio. Sed neque massa, tempus id magna sed, sollicitudin faucibus elit. Maecenas faucibus urna quam. In placerat iaculis tellus ac iaculis. Vivamus sapien eros, sodales sed sem sit amet, posuere maximus dolor. Donec ut nisl dictum elit mollis cursus. Morbi porttitor accumsan lectus, vel laoreet est sagittis in. Pellentesque est magna, vestibulum non magna id, dapibus auctor mi. Vestibulum auctor sollicitudin sem eu molestie. Sed id purus sodales, ultrices purus vel, hendrerit sapien. Nunc maximus risus ut massa congue, vel molestie nisi elementum. Aliquam nisl odio, facilisis ut augue eget, sollicitudin tempus neque. Pellentesque tempor pretium leo, et dapibus ligula imperdiet ac. Nullam dapibus ut tortor ac efficitur.

                        </div>
                    </div>

                </div>
                @include('tools.siderbardetail')
            </div>
        </div>

    </div>
@endsection
