@extends('welcome')
@section('content')
    <div class="container-setup">
        <h6 class="content-title-detail"><a href="{{ route('home') }}">Trang chủ</a> <i class="bi bi-chevron-right"></i>
            Tiện ích <i class="bi bi-chevron-right"></i> <span style="color: #2254AB">Đổi ngày âm dương </span></h6>


        <div class="row g-0 justify-content-center pt-lg-5 pt-4">
            <div class="col-xl-10 col-lg-12 col-md-12 col-12">
                <div class="backv-doi-lich ">
                    <div class="">
                        <div class="row g-3 --pading">
                            <div class="col-lg-8">
                                <h6>Chọn ngày dương lịch bất kỳ:</h6>
                                <p>Chọn ngày dương lịch bất kỳ ngày dương lịch bất kỳ ngày dương lịch bất kỳ.</p>
                                <form action="">
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <input type="text" value="" name=""
                                                    class="form-control dateuser" placeholder="Chọn ngày">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar-date-fill"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <input type="text" value="" class="form-control dateuser"
                                                    placeholder="Chọn ngày">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar-date-fill"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block">
                                <img src="{{ asset('icons/datedoilich.svg') }}" alt="ảnh đổi lich" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
