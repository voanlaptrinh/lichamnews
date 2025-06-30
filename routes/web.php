<?php

use App\Http\Controllers\BanThoController;
use App\Http\Controllers\BuyHouseController;
use App\Http\Controllers\CaiTangController;
use App\Http\Controllers\DongThoController;
use App\Http\Controllers\DuLichCongTacController;
use App\Http\Controllers\GiaiHanController;
use App\Http\Controllers\GiayToController;
use App\Http\Controllers\KhaiTruongController;
use App\Http\Controllers\KyHopDongController;
use App\Http\Controllers\LapBanThoController;
use App\Http\Controllers\LichController;
use App\Http\Controllers\LunarController;
use App\Http\Controllers\MuaXeController;
use App\Http\Controllers\NhanCongViecMoiController;
use App\Http\Controllers\NhapTrachController;
use App\Http\Controllers\PhongSinhController;
use App\Http\Controllers\ThiCuPhongVanController;
use App\Http\Controllers\TranTrachController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\XuatHanhController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [LunarController::class, 'index'])->name('home');
Route::post('/doi-lich', [LunarController::class, 'index'])->name('doi-lich');

Route::match(['get', 'post'], '/am-sang-duong', [LunarController::class, 'convertAmToDuong'])->name('convert.am.to.duong');

Route::get('/lich/nam/{nam}', [LichController::class, 'nam'])->name('lich.nam');
Route::get('/lich/nam/{nam}/thang/{thang}', [LichController::class, 'thang'])->name('lich.thang');
Route::get('/am-lich/nam/{nam}/thang/{thang}/ngay/{ngay}', [LichController::class, 'ngay'])->name('lich.nam.ngay');


// Đổi tên route cho phù hợp hơn
Route::get('/xem-tuoi-cuoi-hoi', [WeddingController::class, 'showForm'])->name('astrology.form');
Route::post('/xem-tuoi-cuoi-hoi', [WeddingController::class, 'check'])->name('astrology.check');


//Xem ngày mua nhà
Route::get('/xem-ngay-mua-nha', [BuyHouseController::class, 'showForm'])->name('buy-house.form');
Route::post('/xem-ngay-mua-nha', [BuyHouseController::class, 'checkDays'])->name('buy-house.check');


//Xem ngày động thổ
Route::get('/xem-ngay-dong-tho', [DongThoController::class, 'showForm'])->name('breaking.form');
Route::post('/xem-ngay-dong-tho', [DongThoController::class, 'checkDays'])->name('breaking.check');


//Xem ngày nhập trạch
Route::get('/xem-ngay-nhap-trach', [NhapTrachController::class, 'showForm'])->name('nhap-trach.form');
Route::post('/xem-ngay-nhap-trach', [NhapTrachController::class, 'checkDays'])->name('nhap-trach.check');

//Xem ngày xuất hành
Route::get('/xem-ngay-xuat-hanh', [XuatHanhController::class, 'showForm'])->name('xuat-hanh.form');
Route::post('/xem-ngay-xuat-hanh', [XuatHanhController::class, 'checkDays'])->name('xuat-hanh.check');

//Xem ngày khai trương
Route::get('/xem-ngay-khai-truong', [KhaiTruongController::class, 'showForm'])->name('khai-truong.form');
Route::post('/xem-ngay-khai-truong', [KhaiTruongController::class, 'checkDays'])->name('khai-truong.check');

//Xem ngày ký hợp đồng
Route::get('/xem-ngay-ky-hop-dong', [KyHopDongController::class, 'showForm'])->name('ky-hop-dong.form');
Route::post('/xem-ngay-ky-hop-dong', [KyHopDongController::class, 'checkDays'])->name('ky-hop-dong.check');

// Route cho chức năng xem ngày Cải táng
Route::get('/xem-ngay-cai-tang', [CaiTangController::class, 'showForm'])->name('cai-tang.form');
Route::post('/xem-ngay-cai-tang', [CaiTangController::class, 'checkDays'])->name('cai-tang.check');

// === ROUTE XEM NGÀY DỜI BÀN THỜ ===
Route::get('/xem-ngay-doi-ban-tho', [BanThoController::class, 'showForm'])->name('ban-tho.form');
Route::post('/xem-ngay-doi-ban-tho', [BanThoController::class, 'checkDays'])->name('ban-tho.check');

// === ROUTE XEM NGÀY Lập BÀN THỜ ===
Route::get('/xem-ngay-lap-ban-tho', [LapBanThoController::class, 'showForm'])->name('lap-ban-tho.form');
Route::post('/xem-ngay-lap-ban-tho', [LapBanThoController::class, 'checkDays'])->name('lap-ban-tho.check');

// === ROUTE XEM NGÀY Lập BÀN THỜ ===
Route::get('/xem-ngay-cung-sao-giai-han', [GiaiHanController::class, 'showForm'])->name('giai-han.form');
Route::post('/xem-ngay-cung-sao-giai-han', [GiaiHanController::class, 'checkDays'])->name('giai-han.check');

// === ROUTE XEM NGÀY tRẤN TRẠCH ===
Route::get('/xem-ngay-yem-tran-tran-trach', [TranTrachController::class, 'showForm'])->name('tran-trach.form');
Route::post('/xem-ngay-yem-tran-tran-trach', [TranTrachController::class, 'checkDays'])->name('tran-trach.check');

// === ROUTE Xem Ngày Cầu an - làm phúc - phóng sinh ===
Route::get('/xem-ngay-cau-an-lam-phuc-phong-sinh', [PhongSinhController::class, 'showForm'])->name('phong-sinh.form');
Route::post('/xem-ngay-cau-an-lam-phuc-phong-sinh', [PhongSinhController::class, 'checkDays'])->name('phong-sinh.check');

// === ROUTE Xem ngày mua xe - nhận xe mới ===
Route::get('/xem-ngay-mua-xe-nhan-xe', [MuaXeController::class, 'showForm'])->name('mua-xe.form');
Route::post('/xem-ngay-mua-xe-nhan-xe', [MuaXeController::class, 'checkDays'])->name('mua-xe.check');

// === ROUTE Xem ngày xuất hành du lịch công tác ===
Route::get('/xem-ngay-xuat-hanh-du-lich-cong-tac', [DuLichCongTacController::class, 'showForm'])->name('du-lich.form');
Route::post('/xem-ngay-xuat-hanh-du-lich-cong-tac', [DuLichCongTacController::class, 'checkDays'])->name('du-lich.check');

// === ROUTE Xem ngày thi cử phỏng vấn ===
Route::get('/xem-ngay-thi-cu-phong-van', [ThiCuPhongVanController::class, 'showForm'])->name('thi-cu.form');
Route::post('/xem-ngay-thi-cu-phong-van', [ThiCuPhongVanController::class, 'checkDays'])->name('thi-cu.check');


// === ROUTE Xem ngày nhận công việc mới ===
Route::get('/xem-ngay-nhan-cong-viec-moi', [NhanCongViecMoiController::class, 'showForm'])->name('cong-viec-moi.form');
Route::post('/xem-ngay-nhan-cong-viec-moi', [NhanCongViecMoiController::class, 'checkDays'])->name('cong-viec-moi.check');

// === ROUTE Xem Ngày làm giấy tờ - cccd, hộ chiếu ===
Route::get('/xem-ngay-lam-giay-to', [GiayToController::class, 'showForm'])->name('giay-to.form');
Route::post('/xem-ngay-lam-giay-to', [GiayToController::class, 'checkDays'])->name('giay-to.check');