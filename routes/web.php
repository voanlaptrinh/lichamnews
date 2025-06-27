<?php

use App\Http\Controllers\BuyHouseController;
use App\Http\Controllers\CaiTangController;
use App\Http\Controllers\DongThoController;
use App\Http\Controllers\KhaiTruongController;
use App\Http\Controllers\KyHopDongController;
use App\Http\Controllers\LichController;
use App\Http\Controllers\LunarController;
use App\Http\Controllers\NhapTrachController;
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



Route::get('/', [LunarController::class, 'index']);
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