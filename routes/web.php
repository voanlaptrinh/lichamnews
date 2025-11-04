<?php

use App\Http\Controllers\BanThoController;
use App\Http\Controllers\BuyHouseController;
use App\Http\Controllers\CaiTangController;
use App\Http\Controllers\CompatibilityController;
use App\Http\Controllers\DongThoController;
use App\Http\Controllers\DuLichCongTacController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\GiaiHanController;
use App\Http\Controllers\GiayToController;
use App\Http\Controllers\HoroscopeController;
use App\Http\Controllers\KhaiTruongController;
use App\Http\Controllers\KyHopDongController;
use App\Http\Controllers\LapBanThoController;
use App\Http\Controllers\LichController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\LunarController;
use App\Http\Controllers\MuaXeController;
use App\Http\Controllers\NhanCongViecMoiController;
use App\Http\Controllers\NhapTrachController;
use App\Http\Controllers\PhongSinhController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ThiCuPhongVanController;
use App\Http\Controllers\ThuocLoBanController;
use App\Http\Controllers\TotXauController;
use App\Http\Controllers\TranTrachController;
use App\Http\Controllers\VanKhanController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\XemHuongBanLamViecController;
use App\Http\Controllers\XemHuongBanThoController;
use App\Http\Controllers\XemHuongBepController;
use App\Http\Controllers\XemHuongNhaController;
use App\Http\Controllers\XemHuongPhongNguController;
use App\Http\Controllers\XuatHanhController;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::post('/ajax/lich-thang', [LichController::class, 'getLichThangAjax'])->name('lich.thang.ajax');
Route::post('/ajax/date-data', [LunarController::class, 'getDateDataAjax'])->name('lunar.getDateDataAjax');
Route::get('/llms.txt', function () {
    $path = public_path('llms.txt');
    if (!file_exists($path)) {
        abort(404);
    }

    $contents = file_get_contents($path);

    // N?u c� BOM ? d?u, lo?i b?
    if (substr($contents, 0, 3) === "\xEF\xBB\xBF") {
        $contents = substr($contents, 3);
    }

    // �p ch?c UTF-8 (an to�n): chuy?n n?u detect kh�ng ph?i UTF-8
    if (!mb_check_encoding($contents, 'UTF-8')) {
        $contents = mb_convert_encoding($contents, 'UTF-8', 'auto');
    }

    return response($contents, 200)
        ->header('Content-Type', 'text/plain; charset=utf-8')
        ->header('X-Content-Type-Options', 'nosniff');
});

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
Route::get('/lich-nam-{nam}/thang-{thang}/ngay-{ngay}', [LunarController::class, 'detail'])->name('detai_home');
Route::post('/lunar/detail/ajax', [LunarController::class, 'detailAjax'])->name('lunar.detail.ajax');
Route::get('/lich-am-hom-nay', [LunarController::class, 'todaySimple'])->name('am-lich-hom-nay');
Route::get('/lich-am-ngay-mai', [LunarController::class, 'tomorrowSimple'])->name('am-lich-ngay-mai');
Route::post('/doi-lich', [LunarController::class, 'index'])->name('doi-lich');
Route::match(['get', 'post'], '/doi-ngay-am-duong', [LunarController::class, 'convertAmToDuong'])->name('convert.am.to.duong');
Route::get('/lich-nam-{nam}', [LichController::class, 'nam'])->name('lich.nam');
Route::get('/lich-nam-{nam}/thang-{thang}-nhuan', [LichController::class, 'thangNhuan'])->name('lich.thang.nhuan');
Route::get('/lich-nam-{nam}/thang-{thang}-am', [LichController::class, 'thangAm'])->name('lich.thang.am');
Route::get('/lich-nam-{nam}/thang-{thang}', [LichController::class, 'thang'])->name('lich.thang');
Route::get('lien-he-voi-chung-toi', [FooterController::class, 'lienHe'])->name('lien-he-voi-chung-toi');
Route::get('dieu-khoan-dich-vu', [FooterController::class, 'dieuKhoan'])->name('dieu-khoan');
Route::get('chinh-sach-bao-mat', [FooterController::class, 'chinhSach'])->name('chinh-sach');


//list xem ngày tốt
Route::prefix('tools')->group(function () {
    Route::get('/xem-ngay-tot',  [ListController::class, 'XemNgayTots'])->name('totxau.list');
});



//xem ngày tốt xấu
Route::prefix('xem-ngay-tot-xau')->group(function () {
    Route::get('/',  [TotXauController::class, 'showForm'])->name('totxau.form');
    Route::post('/check-days', [TotXauController::class, 'checkDays'])->name('totxau.checkDays');
    Route::get('/chi-tiet/{date}', [TotXauController::class, 'showDayDetails'])->name('totxau.dayDetails');
});
Route::prefix('xem-ngay-mua-nha')->group(function () {
    //Xem ngày mua nhà
    Route::get('/', [BuyHouseController::class, 'showForm'])->name('buy-house.form');
    Route::post('/', [BuyHouseController::class, 'checkDays'])->name('buy-house.check');
    Route::get('/chi-tiet/{date}', [BuyHouseController::class, 'showDayDetails'])->name('buy-house.details');
});


// Xem tuổi để cưới hỏi
Route::prefix('xem-tuoi-cuoi-hoi')->group(function () {
    Route::get('/', [WeddingController::class, 'showForm'])->name('astrology.form');
    Route::post('/', [WeddingController::class, 'check'])->name('astrology.check');
    Route::get('/chi-tiet', [WeddingController::class, 'showDayDetails'])->name('wedding.day.details');
});



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

// === ROUTE Xem hướng ban thờ ===
Route::get('/xem-huong-ban-tho', [XemHuongBanThoController::class, 'showForm'])->name('huong-ban-tho.form');
Route::post('/xem-huong-ban-tho', [XemHuongBanThoController::class, 'check'])->name('huong-ban-tho.check');

// === ROUTE Xem hướng nhà ===
Route::get('/xem-huong-nha', [XemHuongNhaController::class, 'showForm'])->name('huong-nha.form');
Route::post('/xem-huong-nha', [XemHuongNhaController::class, 'check'])->name('huong-nha.check');

// === ROUTE Xem hướng bếp ===
Route::get('/xem-huong-bep', [XemHuongBepController::class, 'showForm'])->name('huong-bep.form');
Route::post('/xem-huong-bep', [XemHuongBepController::class, 'check'])->name('huong-bep.check');

// === ROUTE Xem hướng phòng ngủ ===
Route::get('/xem-huong-phong-ngu', [XemHuongPhongNguController::class, 'showForm'])->name('huong-phong-ngu.form');
Route::post('/xem-huong-phong-ngu', [XemHuongPhongNguController::class, 'check'])->name('huong-phong-ngu.check');

// === ROUTE Xem hướng bàn làm việc ===
Route::get('/xem-huong-ban-lam-viec', [XemHuongBanLamViecController::class, 'showForm'])->name('huong-ban-lam-viec.form');
Route::post('/xem-huong-ban-lam-viec', [XemHuongBanLamViecController::class, 'check'])->name('huong-ban-lam-viec.check');

// === ROUTE Xem 12 cung hoàng đạo ===

// Route hiển thị danh sách 12 cung hoàng đạo
Route::get('/cung-hoang-dao', [HoroscopeController::class, 'index'])->name('horoscope.index');
// Route hiển thị trang chi tiết của một cung (mặc định là hôm nay)
Route::get('/cung-hoang-dao/{signSlug}', [HoroscopeController::class, 'showFromSlug'])->name('horoscope.show');
// Route hiển thị trang chi tiết của một cung với type (cung-hoang-dao/bach-duong/hom-nay)
Route::get('/cung-hoang-dao/{signSlug}/{typeSlug}', [HoroscopeController::class, 'showWithType'])->name('horoscope.show.type');
// Route API nội bộ để JavaScript gọi đến, route này sẽ gọi API bên ngoài
Route::get('/api/horoscope-data/{sign}/{type}', [HoroscopeController::class, 'fetchData'])->name('horoscope.data');

//===End ROute xem 12 cung hoàng đạo ===



Route::get('/thuoc-lo-ban', [ThuocLoBanController::class, 'index'])->name('thuoc-lo-ban.index');



// Route để hiển thị danh sách
Route::get('/van-khan', [VanKhanController::class, 'index'])->name('van-khan.index');

// Route để hiển thị chi tiết, với {id} là tham số động
Route::get('/van-khan/{id}', [VanKhanController::class, 'show'])->name('van-khan.show');

Route::get('/xem-tuoi', [CompatibilityController::class, 'showForm'])->name('compatibility.form');

// Route để xử lý và trả kết quả (POST)
Route::post('/xem-tuoi', [CompatibilityController::class, 'calculate'])->name('compatibility.calculate');

// Sitemap routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-static.xml', [App\Http\Controllers\SitemapController::class, 'staticPages'])->name('sitemap.static');
Route::get('/sitemap-tools.xml', [App\Http\Controllers\SitemapController::class, 'tools'])->name('sitemap.tools');
// Route::get('/sitemap-posts.xml', [App\Http\Controllers\SitemapController::class, 'posts'])->name('sitemap.posts');
Route::get('/sitemap-years.xml', [App\Http\Controllers\SitemapController::class, 'years'])->name('sitemap.years');
Route::get('/sitemap-months.xml', [App\Http\Controllers\SitemapController::class, 'months'])->name('sitemap.months');
Route::get('/sitemap-days.xml', [SitemapController::class, 'daysIndex'])->name('sitemap.days.index');
Route::get('/sitemap-days-{year}.xml', [SitemapController::class, 'daysByYear'])->name('sitemap.days.byYear');


