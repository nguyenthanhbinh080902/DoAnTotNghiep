<?php

use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\ChuongTrinhGiamGiaController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\PhieuGiamGiaController;
use App\Http\Controllers\PhieuTraHangController;
use App\Http\Controllers\PhieuXuatController;
use App\Http\Controllers\QuyenController;
use App\Http\Controllers\TonKhoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhieuNhapController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DanhMucTSKTController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhiGiaoHangController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\QuenMatKhau;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\ThongSoKyThuatController;
use App\Http\Controllers\BaoHanhController;

// Trang admin

//BaoCao
Route::get('/bao-cao', [BaoCaoController::class, 'xem'])->name('xemBaoCao');
Route::get('/bao-cao-chi-tiet/{fileName}', [BaoCaoController::class, 'xemCT'])->name('xemBaoCaoCT');
Route::get('/tai-xuong/{fileName}', [BaoCaoController:: class, 'taiXuong'])->name('taiXuong');
Route::post('/tao-bao-cao', [BaoCaoController::class, 'xuLyTaoBaoCao'])->name('xuLyTaoBaoCao');
Route::post('/luu-bao-cao', [BaoCaoController::class, 'luuFile'])->name('luuFile');
Route::get('/xuatFilePN/{id}', [PhieuNhapController::class, 'xuatFilePN'])->name('xuatFilePN');

//TonKho
Route::get('liet-ke-ton-kho', [TonKhoController::class, 'lietKe'])->name('lietKeTonKho');
Route::get('tim-kiem-san-pham-ton-kho', [TonKhoController::class, 'timKiemSPTK'])->name('timKiemSPTK');
Route::post('/filter-by-date', [TonKhoController::class, 'filter_by_date'])->name('/filter-by-date');
Route::get('/Test', [TonKhoController::class, 'Test'])->name('/Test');
Route::get('/TrangLietKeBCDT', [TonKhoController::class, 'TrangLietKeBCDT'])->name('/TrangLietKeBCDT');
Route::post('/dashboard-filter', [TonKhoController::class, 'dashboard_filter'])->name('/dashboard-filter');
Route::post('/days-order', [TonKhoController::class, 'days_order'])->name('/days-order');
Route::post('/BaoCaoDoanhThuTheoDate', [TonKhoController::class, 'BaoCaoDoanhThuTheoDate'])->name('/BaoCaoDoanhThuTheoDate');
Route::get('/xuatFileBCDT', [TonKhoController::class, 'xuatFileBCDT'])->name('xuatFileBCDT');


//PhieuTraHang
Route::get('/xem-phieu-tra-hang', [PhieuTraHangController::class, 'xem'])->name('xemPTH');
Route::get('/xem-phieu-tra-hang-chi-tiet/{id}', [PhieuTraHangController::class, 'xemCTPTH'])->name('xemCTPTH');


Route::get('/luuPTH/{id}', [PhieuTraHangController::class, 'luuPTH'])->name('luuPTH');
Route::get('/xoaPTH/{id}', [PhieuTraHangController::class, 'xoaPTH'])->name('xoaPTH');

Route::get('/sua-phieu-tra-hang/{id}', [PhieuTraHangController::class, 'suaPTH'])->name('suaPTH');
Route::post('/sua-phieu-tra-hang', [PhieuTraHangController::class, 'xuLySuaPTH'])->name('xuLySuaPTH');
Route::post('/lap-phieu-tra-hang-chi-tiet', [PhieuTraHangController::class, 'xuLyLapTHCT'])->name('xuLyLapTHCT');
Route::get('xoa-chi-tiet-phieu-tra-hang/{id}/{maPTH}', [PhieuTraHangController::class, 'xoaCTPTHS'])->name('xoaCTPTHS');
Route::post('/update-soluong-pth', [PhieuTraHangController::class, 'updateSoLuong'])->name('update.soluong-pth');


Route::get('/lap-phieu-tra-hang/{id}/{maNCC}', [PhieuTraHangController::class, 'lapTH'])->name('lapTH');
Route::post('/lap-phieu-tra-hang', [PhieuTraHangController::class, 'xuLyLapTH'])->name('xuLyLapTH');
Route::post('/lap-phieu-tra-hang-chi-tiet1', [PhieuTraHangController::class, 'xuLyLapTHCT1'])->name('xuLyLapTHCT1');
// Route::get('/api/san-pham-th', [PhieuTraHangController::class, 'danhSachSanPham'])->name('api.san-pham-th');


//PhieuXuat
Route::get('/xem-phieu-xuat', [PhieuXuatController::class, 'xem'])->name('xemPX');
Route::get('/xem-chi-tiet-phieu-xuat/{id}', [PhieuXuatController::class, 'xemCT'])->name('xemCT');
Route::get('/tim-kiem-phieu-xuat', [PhieuXuatController::class, 'timKiemPX'])->name('timKiemPX');
Route::get('/phieu-xuat.loc', [PhieuXuatController::class, 'locPX'])->name('phieu-xuat.loc');

Route::get('/lap-phieu-xuat', [PhieuXuatController::class, 'taoPX'])->name('taoPX');
Route::post('/lap-phieu-xuat', [PhieuXuatController::class, 'xuLyLapPX'])->name('xuLyLapPX');
Route::post('/lap-phieu-xuat-chi-tiet1', [PhieuXuatController::class, 'xuLyLapPXCT1'])->name('xuLyLapPXCT1');
Route::post('/lap-phieu-xuat-chi-tiet', [PhieuXuatController::class, 'taoPXCT'])->name('xuLyLapPXCT');
Route::get('/luuPX/{id}', [PhieuXuatController::class, 'luuPX'])->name('luuPX');

Route::get('/xoa-phieu-xuat/{id}', [PhieuXuatController::class, 'xoaPX'])->name('xoaPX');
Route::get('/xoa-chi-tiet-phieu-xuat/{id}/{maPX}', [PhieuXuatController::class, 'xoaCTPXS'])->name('xoaCTPXS');
Route::get('/xoa-chi-tiet-phieu-xuat1/{id}/{maPX}', [PhieuXuatController::class, 'xoaCT'])->name('xoaCTL');

Route::get('/sua-phieu-xuat/{id}', [PhieuXuatController::class, 'suaPX'])->name('suaPX');
Route::post('/sua-phieu-xuat', [PhieuXuatController::class, 'suaPXP'])->name('suaPXP');
Route::post('/update-soluong-px', [PhieuXuatController::class, 'updateSoLuong'])->name('update.soluong-px');

// Route::get('/api/san-pham-px', [PhieuNhapController::class, 'danhSachSanPham'])->name('api.san-pham-px');

//PhieuNhap
Route::get('/liet-ke-phieu-nhap', [PhieuNhapController::class, 'trangXemPhieuNhap'])->name('xemPN');
Route::get('/xem-phieu-nhap/{id}', [PhieuNhapController::class, 'xemCTPN'])->name('xemCTPN');
Route::get('/tim-kiem-phieu-nhap', [PhieuNhapController::class, 'timKiemPN'])->name('timKiemPN');
Route::get('/phieu-nhap.loc', [PhieuNhapController::class, 'locPN'])->name('phieu-nhap.loc');

Route::get('/lap-phieu-nhap', [PhieuNhapController::class, 'lapPN'])->name('lapPN');
Route::post('/lap-phieu-nhap', [PhieuNhapController::class, 'xuLyPN'])->name('xuLyLapPN');
Route::post('/lap-phieu-nhap-chi-tiet', [PhieuNhapController::class, 'xuLyLapPNCT'])->name('xuLyLapPNCT');
Route::post('/lap-phieu-nhap-chi-tiet1', [PhieuNhapController::class, 'xuLyLapPNCT1'])->name('xuLyLapPNCT1');
Route::get('/api/san-pham-pn', [PhieuNhapController::class, 'danhSachSanPham'])->name('api.san-pham-pn');
Route::get('/xoa-phieu-nhap/{id}', [PhieuNhapController::class, 'xoaPN'])->name('xoaPN');
Route::get('/xoaCTPN/{id}', [PhieuNhapController::class, 'xoaCTPN'])->name('xoaCTPN');
Route::get('/xoaCTs/{id}', [PhieuNhapController::class, 'xoaCTS'])->name('xoaCTS');
Route::get('/luu-phieu-nhap/{id}', [PhieuNhapController::class, 'luuPN'])->name('luuPN');
Route::get('/sua-phieu-nhap/{id}', [PhieuNhapController::class, 'suaPN'])->name('suaPN');
Route::post('/xuLySuaPN', [PhieuNhapController::class, 'xuLySuaPN'])->name('xuLySuaPN');
Route::post('/update-soluong', [PhieuNhapController::class, 'updateSoLuong'])->name('update.soluong');


//Nha cung cap
Route::get('/liet-ke-nha-cung-cap', [NhaCungCapController::class, 'lietKe'])->name('lietKeNCC');
Route::get('/them-nha-cung-cap', [NhaCungCapController::class, 'themNCC'])->name('themNCC');
Route::post('/xuLyThemNCC', [NhaCungCapController::class, 'xuLyThemNCC']);
Route::get('/sua-nha-cung-cap/{id}', [NhaCungCapController::class, 'suaNCC'])->name('suaNCC');
Route::post('/xuLySuaNCC', [NhaCungCapController::class, 'xuLySuaNCC'])->name('xuLySuaNCC');
Route::get('/xoa-nha-cung-cap/{id}', [NhaCungCapController::class, 'xoaNCC'])->name('xoaNCC');
Route::get('/tim-kiem-nha-cung-cap', [NhaCungCapController::class, 'timkiemNCC'])->name('timkiemNCC');

// Thuong Hieu San Pham
Route::get('/trang-them-thuong-hieu', [ThuongHieuController::class, 'TrangThemThuongHieu'])->name('/TrangThemThuongHieu');
Route::get('/trang-liet-ke-thuong-hieu', [ThuongHieuController::class, 'TrangLietKeThuongHieu'])->name('/TrangLietKeThuongHieu');
Route::post('/them-thuong-hieu', [ThuongHieuController::class, 'ThemThuongHieu'])->name('/ThemThuongHieu');
Route::get('/kich-hoat-thuong-hieu/{MaThuongHieu}', [ThuongHieuController::class, 'KichHoatThuongHieu'])->name('/KichHoatThuongHieu');
Route::get('/KoKichHoatThuongHieu/{MaThuongHieu}', [ThuongHieuController::class, 'KoKichHoatThuongHieu'])->name('/KoKichHoatThuongHieu');
Route::get('/trang-sua-thuong-hieu/{MaThuongHieu}', [ThuongHieuController::class, 'TrangSuaThuongHieu'])->name('/TrangSuaThuongHieu');
Route::get('/xoa-thuong-hieu/{MaThuongHieu}', [ThuongHieuController::class, 'XoaThuongHieu'])->name('/XoaThuongHieu');
Route::post('/sua-thuong-hieu/{MaThuongHieu}', [ThuongHieuController::class, 'SuaThuongHieu'])->name('/SuaThuongHieu');
Route::get('/tim-kiem-thuong-hieu',[ThuongHieuController::class, 'timKiem'])->name('timKiemThuongHieu');

//Quyen
Route::get('/let-ke-quyen-han', [QuyenController::class, 'lietKe'])->name('lietKeQH');
Route::get('/them-quyen-han', [QuyenController::class, 'themQuyen'])->name('themQuyen');
Route::post('/them-quyen-han', [QuyenController::class, 'themQH'])->name('them-quyen-han');
Route::get('/xoaQH/{id}', [QuyenController::class, 'xoaQH'])->name('xoaQH');
Route::get('/them-vai-tro', [QuyenController::class, 'themQuyenTK'])->name('themQuyenTK');
Route::get('/liet-ke-vai-tro', [QuyenController::class, 'lietKeVaiTro'])->name('lietKeVaiTro');
Route::post('/xuLyThemQTK', [QuyenController::class, 'themQTK'])->name('/xuLyThemQTK');
Route::post('/update-vaitro', [QuyenController::class, 'updateVaiTro'])->name('update.vaitro');



//TaiKhoan
Route::get('/dang-nhap', [TaiKhoanController::class, 'dangNhap'])->name('dangNhap');
Route::post('/xuLyDN', [TaiKhoanController::class, 'xuLyDN']);
Route::get('/trang-quan-ly', [TaiKhoanController::class, 'trangAdmin'])->name('trangAdmin')->middleware('DangNhap');
Route::get('/dangXuat', [TaiKhoanController::class, 'dangXuat'])->name('dangXuat');
Route::get('/dang-ky', [TaiKhoanController::class, 'dangKy'])->name('dangKy');
Route::post('/xu-ly-dang-ky', [TaiKhoanController::class, 'xuLyDK'])->name('xuLyDK');
Route::get('/liet-ke-tai-khoan', [TaiKhoanController::class, 'lietKeTK'])->name('lietKeTK');
Route::get('/tao-tai-khoan', [TaiKhoanController::class, 'taoTK'])->name('taoTK');
Route::post('/xuLyTaoTK', [TaiKhoanController::class, 'xuLyTaoTK'])->name('xuLyTaoTK');
Route::get('/sua-tai-khoan/{id}', [TaiKhoanController::class, 'suaTK'])->name('suaTK');
Route::post('/xuLySuaTK', [TaiKhoanController::class, 'xuLySuaTK'])->name('xuLySuaTK');
Route::get('/xoaTK/{id}', [TaiKhoanController::class, 'xoaTK'])->name('xoaTK');
Route::post('/doi-mat-khau', [TaiKhoanController::class, 'doiMatKhau'])->name('doiMatKhau');
Route::get('/doi-mat-khau', [TaiKhoanController::class, 'trangDoiMatKhau'])->name('indexDMK');
Route::post('/dat-lai-mat-khau', [TaiKhoanController::class, 'datLaiMatKhau'])->name('datLaiMatKhau');
Route::get('/dat-lai-mat-khau', [TaiKhoanController::class, 'trangDatLaiMatKhau'])->name('indexDLMK');
Route::post('/quen-mat-khau', [TaiKhoanController::class, 'quenMatKhau'])->name('quenMatKhau');
Route::get('/quen-mat-khau', [TaiKhoanController::class, 'trangQMK'])->name('indexQMK');
Route::post('/xac-thuc-pin', [TaiKhoanController::class, 'xacThucPin'])->name('xacThucPin');
Route::get('/xac-thuc-pin', [TaiKhoanController::class, 'indexXTPin'])->name('indexXTPin');
Route::get('/tim-kiem-tai-khoan', [TaiKhoanController::class, 'timkiemTK'])->name('timKiemTK');
//Route::get('/cap-nhat-tai-khoan', [TaiKhoanController::class, 'capNhatTK'])->name('capNhatTK');
//Route::post('/xuLyCapNhatTK', [TaiKhoanController::class, 'xuLyCNTK'])->name('xuLyCapNhatTK');

Route::get('/dashboard', [TaiKhoanController::class, 'show_dashboard'])->name('/dashboard');
// Route::get('/trangAdmin', [TaiKhoanController::class, 'trangAdmin'])->name('/trangAdmin');



// Bài viết
Route::get('/trang-them-bai-viet', [BaiVietController::class, 'TrangThemBaiViet'])->name('/TrangThemBaiViet');
Route::get('/trang-liet-ke-bai-viet', [BaiVietController::class, 'TrangLietKeBaiViet'])->name('/TrangLietKeBaiViet');
Route::post('/ThemBaiViet', [BaiVietController::class, 'ThemBaiViet'])->name('/ThemBaiViet');
Route::get('/trang-sua-bai-viet/{MaBaiViet}', [BaiVietController::class, 'TrangSuaBaiViet'])->name('/TrangSuaBaiViet');
Route::get('/XoaBaiViet/{MaBaiViet}', [BaiVietController::class, 'XoaBaiViet'])->name('/XoaBaiViet');
Route::post('/SuaBaiViet/{MaBaiViet}', [BaiVietController::class, 'SuaBaiViet'])->name('/SuaBaiViet');
Route::get('/KoKichHoatBaiViet/{MaBaiViet}', [BaiVietController::class, 'KoKichHoatBaiViet'])->name('/KoKichHoatBaiViet');
Route::get('/KichHoatBaiViet/{MaBaiViet}', [BaiVietController::class, 'KichHoatBaiViet'])->name('/KichHoatBaiViet');
Route::get('/tim-kiem-bai-viet', [BaiVietController::class, 'timKiemBV'])->name('timKiemBV');

// Danh mục bài viết
Route::get('/trang-them-dmbv', [BaiVietController::class, 'TrangThemDanhMucBV'])->name('/TrangThemDanhMucBV');
Route::get('/trang-liet-ke-dmbv', [BaiVietController::class, 'TrangLietKeDanhMucBV'])->name('/TrangLietKeDanhMucBV');
Route::post('/ThemDanhMucBV', [BaiVietController::class, 'ThemDanhMucBV'])->name('/ThemDanhMucBV');
Route::get('/trang-sua-dmbv/{MaDanhMucBV}', [BaiVietController::class, 'TrangSuaDanhMucBV'])->name('/TrangSuaDanhMucBV');
Route::get('/XoaDanhMucBV/{MaDanhMucBV}', [BaiVietController::class, 'XoaDanhMucBV'])->name('/XoaDanhMucBV');
Route::post('/SuaDanhMucBV/{MaDanhMucBV}', [BaiVietController::class, 'SuaDanhMucBV'])->name('/SuaDanhMucBV');
Route::get('/KoKichHoatDanhMucBV/{MaDanhMucBV}', [BaiVietController::class, 'KoKichHoatDanhMucBV'])->name('/KoKichHoatDanhMucBV');
Route::get('/KichHoatDanhMucBV/{MaDanhMucBV}', [BaiVietController::class, 'KichHoatDanhMucBV'])->name('/KichHoatDanhMucBV');
Route::get('/dashboard', [TaiKhoanController::class, 'show_dashboard'])->name('/dashboard')->middleware('DangNhap');
Route::get('/tim-kiem-dmbv', [BaiVietController::class, 'timKiemDMBV'])->name('timKiemDMBV');

// Danh muc
Route::get('/trang-them-danh-muc', [DanhMucController::class, 'TrangThemDanhMuc'])->name('/TrangThemDanhMuc');
Route::get('/trang-liet-ke-danh-muc', [DanhMucController::class, 'TrangLietKeDanhMuc'])->name('/TrangLietKeDanhMuc');
Route::post('/them-danh-muc', [DanhMucController::class, 'ThemDanhMuc'])->name('/ThemDanhMuc');
Route::get('/kich-hoat-danh-muc/{MaDanhMuc}', [DanhMucController::class, 'KichHoatDanhMuc'])->name('/KichHoatDanhMuc');
Route::get('/khong-kich-hoat-danh-muc/{MaDanhMuc}', [DanhMucController::class, 'KoKichHoatDanhMuc'])->name('/KoKichHoatDanhMuc');
Route::get('/trang-sua-danh-muc/{MaDanhMuc}', [DanhMucController::class, 'TrangSuaDanhMuc'])->name('/TrangSuaDanhMuc');
Route::get('/xoa-danh-muc/{MaDanhMuc}', [DanhMucController::class, 'XoaDanhMuc'])->name('/XoaDanhMuc');
Route::post('/sua-danh-muc/{MaDanhMuc}', [DanhMucController::class, 'SuaDanhMuc'])->name('/SuaDanhMuc');
Route::get('/tim-kiem-loai-sp', [DanhMucController::class, 'timKiemLoaiSP'])->name('timKiemLSP');

// Thương hiệu thuộc danh mục
Route::get('/trang-them-thdm', [DanhMucController::class, 'trangThemTHDM'])->name('/trang-them-thdm');
Route::post('/them-thdm', [DanhMucController::class, 'themTHDM'])->name('/them-thdm');
Route::get('/trang-liet-ke-thtdm', [DanhMucController::class, 'trangLietKeTHDM'])->name('/trang-liet-ke-thtdm');
Route::get('/xoa-thdm/{MaTHDM}', [DanhMucController::class, 'xoaTHDM'])->name('/xoa-thdm');
Route::get('/trang-sua-thdm//{MaTHDM}', [DanhMucController::class, 'trangSuaTHDM'])->name('/trang-sua-thdm');
Route::post('/sua-thdm/{MaTHDM}', [DanhMucController::class, 'suaTHDM'])->name('/sua-thdm');

// Danh mục TSKT
Route::get('/trang-them-danh-muc-tskt', [DanhMucTSKTController::class, 'TrangThemDanhMucTSKT'])->name('/TrangThemDanhMucTSKT');
Route::get('/trang-liet-ke-danh-muc-tskt', [DanhMucTSKTController::class, 'TrangLietKeDanhMucTSKT'])->name('/TrangLietKeDanhMucTSKT');
Route::post('/them-danh-muc-tskt', [DanhMucTSKTController::class, 'ThemDanhMucTSKT'])->name('/ThemDanhMucTSKT');
Route::get('/trang-sua-danh-muc-tskt/{MaDMTSKT}', [DanhMucTSKTController::class, 'TrangSuaDanhMucTSKT'])->name('/TrangSuaDanhMucTSKT');
Route::post('/sua-danh-muc-tskt/{MaDMTSKT}', [DanhMucTSKTController::class, 'SuaDanhMucTSKT'])->name('/SuaDanhMucTSKT');
Route::get('/xoa-danh-muc-tskt/{MaDMTSKT}', [DanhMucTSKTController::class, 'XoaDanhMucTSKT'])->name('/XoaDanhMucTSKT');
Route::get('/tim-kiem-dmskt', [DanhMucTSKTController::class, 'timKiem'])->name('tim-kiem-dmtskt');

// TSKT
Route::get('/trang-them-tskt', [ThongSoKyThuatController::class, 'TrangThemTSKT'])->name('/TrangThemTSKT');
Route::get('/trang-liet-ke-tskt', [ThongSoKyThuatController::class, 'TrangLietKeTSKT'])->name('/TrangLietKeTSKT');
Route::post('/them-tskt', [ThongSoKyThuatController::class, 'ThemTSKT'])->name('/ThemTSKT');
Route::get('/trang-sua-tskt/{MaTSKT}', [ThongSoKyThuatController::class, 'TrangSuaTSKT'])->name('/TrangSuaTSKT');
Route::post('/sua-tskt/{MaTSKT}', [ThongSoKyThuatController::class, 'SuaTSKT'])->name('/SuaTSKT');
Route::get('/xoa-tskt/{MaTSKT}', [ThongSoKyThuatController::class, 'XoaTSKT'])->name('/XoaTSKT');
Route::post('/ChonDanhMucTSKT', [ThongSoKyThuatController::class, 'ChonDanhMucTSKT'])->name('/ChonDanhMucTSKT');
Route::get('/tim-kiem-tskt', [ThongSoKyThuatController::class, 'timKiem'])->name('timKiemTSKT');

// sản phẩm
Route::get('/trang-them-san-pham', [SanPhamController::class, 'TrangThemSanPham'])->name('/TrangThemSanPham');
Route::get('/trang-liet-ke-san-pham', [SanPhamController::class, 'TrangLietKeSanPham'])->name('/TrangLietKeSanPham');
Route::post('/them-san-pham', [SanPhamController::class, 'ThemSanPham'])->name('/ThemSanPham');
Route::get('/kich-hoat-san-pham/{MaSanPham}', [SanPhamController::class, 'KichHoatSanPham'])->name('/KichHoatSanPham');
Route::get('/khong-kich-hoat-san-pham/{MaSanPham}', [SanPhamController::class, 'KoKichHoatSanPham'])->name('/KoKichHoatSanPham');
Route::get('/trang-sua-san-pham/{MaSanPham}', [SanPhamController::class, 'TrangSuaSanPham'])->name('/TrangSuaSanPham');
Route::get('/xoa-san-pham/{MaSanPham}', [SanPhamController::class, 'XoaSanPham'])->name('/XoaSanPham');
Route::post('/sua-san-pham/{MaSanPham}', [SanPhamController::class, 'SuaSanPham'])->name('/SuaSanPham');
Route::post('/them-tskt-cho-san-pham', [SanPhamController::class, 'ThemTSKTChoSanPham'])->name('/ThemTSKTChoSanPham');
Route::post('/sua-tskt-cho-san-pham', [SanPhamController::class, 'SuaTSKTChoSanPham'])->name('/SuaTSKTChoSanPham');
Route::get('/trang-san-pham-tskt/{MaSanPham}', [SanPhamController::class, 'TrangSanPhamTSKT'])->name('/TrangSanPhamTSKT');
Route::get('/tim-kiem', [SanPhamController::class, 'timKiem'])->name('tim-kiem-san-pham');

// Phí giao hàng
Route::get('/trang-them-phi-giao-hang', [PhiGiaoHangController::class, 'TrangThemPhiGiaoHang'])->name('/TrangThemPhiGiaoHang');
Route::get('/trang-liet-ke-phi-giao-hang', [PhiGiaoHangController::class, 'TrangLietKePhiGiaoHang'])->name('/TrangLietKePhiGiaoHang');
Route::post('/them-phi-giao-hang', [PhiGiaoHangController::class, 'ThemPhiGiaoHang'])->name('/ThemPhiGiaoHang');
Route::get('/trang-sua-phi-giao-hang/{MaPhiGiaoHang}', [PhiGiaoHangController::class, 'TrangSuaPhiGiaoHang'])->name('/TrangSuaPhiGiaoHang');
Route::get('/xoa-phi-giao-hang/{MaPhiGiaoHang}', [PhiGiaoHangController::class, 'XoaPhiGiaoHang'])->name('/XoaPhiGiaoHang');
Route::post('/sua-phi-giao-hang/{MaPhiGiaoHang}', [PhiGiaoHangController::class, 'SuaPhiGiaoHang'])->name('/SuaPhiGiaoHang');
Route::post('/ChonDiaDiem', [PhiGiaoHangController::class, 'ChonDiaDiem'])->name('/ChonDiaDiem');
Route::get('/tim-kiem-phi-giao-hang', [PhiGiaoHangController::class, 'timKiem'])->name('timKiemPhiGiaoHang');

// Đơn hàng
Route::get('/TrangLietKeDonHang', [DonHangController::class, 'TrangLietKeDonHang'])->name('/TrangLietKeDonHang');
Route::get('/TrangChiTietDonHang/{order_code}', [DonHangController::class, 'TrangChiTietDonHang'])->name('/TrangChiTietDonHang');
Route::get('/XoaChiTietDonHang/{MaCTDH}/{order_code}', [DonHangController::class, 'XoaChiTietDonHang'])->name('/XoaChiTietDonHang');
Route::get('/XoaPhieuGiamGiaThuocDonHang/{MaDonHang}/{MaGiamGia}', [DonHangController::class, 'XoaPhieuGiamGiaThuocDonHang'])->name('/XoaPhieuGiamGiaThuocDonHang');
Route::get('/XoaDonHang/{MaDonHang}/{order_code}', [DonHangController::class, 'XoaDonHang'])->name('/XoaDonHang');
Route::get('/TrangSuaThongTinGiaoHang/{MaGiaoHang}/{order_code}', [DonHangController::class, 'TrangSuaThongTinGiaoHang'])->name('/TrangSuaThongTinGiaoHang');
Route::post('/SuaThongTinGiaoHang/{MaGiaoHang}/{order_code}', [DonHangController::class, 'SuaThongTinGiaoHang'])->name('/SuaThongTinGiaoHang');
Route::post('/SuaSoLuongSanPham/{MaCTDH}/{order_code}', [DonHangController::class, 'SuaSoLuongSanPham'])->name('/SuaSoLuongSanPham');
Route::post('/SuaTrangThaiDonHang/{MaDonHang}/{order_code}', [DonHangController::class, 'SuaTrangThaiDonHang'])->name('/SuaTrangThaiDonHang');

// Đánh giá
Route::post('/DanhGia', [DanhGiaController::class, 'DanhGia'])->name('/DanhGia');
Route::get('/trang-liet-ke-danh-gia', [DanhGiaController::class, 'TrangLietKeDanhGia'])->name('/TrangLietKeDanhGia');
Route::get('/kich-hoat-danh-gia/{MaDanhGia}', [DanhGiaController::class, 'KichHoatDanhGia'])->name('/KichHoatDanhGia');
Route::get('/khong-kich-hoat-danh-gia/{MaDanhGia}', [DanhGiaController::class, 'KoKichHoatDanhGia'])->name('/KoKichHoatDanhGia');
Route::get('/xoa-danh-gia/{MaDanhGia}', [DanhGiaController::class, 'XoaDanhGia'])->name('/XoaDanhGia');
Route::post('/BinhLuan', [DanhGiaController::class, 'BinhLuan'])->name('/BinhLuan');
Route::get('/trang-liet-ke-binh-luan', [DanhGiaController::class, 'TrangLietKeBinhLuan'])->name('/TrangLietKeBinhLuan');
Route::get('/kich-hoat-binh-luan/{MaBinhLuan}', [DanhGiaController::class, 'KichHoatBinhLuan'])->name('/KichHoatBinhLuan');
Route::get('/khong-kich-hoat-binh-luan/{MaBinhLuan}', [DanhGiaController::class, 'KoKichHoatBinhLuan'])->name('/KoKichHoatBinhLuan');
Route::get('/XoaBinhLuan/{MaBinhLuan}', [DanhGiaController::class, 'XoaBinhLuan'])->name('/XoaBinhLuan');
Route::get('/tim-kiem-danh-gia', [DanhGiaController::class, 'timKiemDanhGia'])->name('timKiemDanhGia');
Route::get('/tim-kiem-binh-luan', [DanhGiaController::class, 'timKiemBinhLuan'])->name('timKiemBinhLuan');

// Trang bán hàng
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/SanPhamThuocDanhMuc/{MaDanhMuc}', [HomeController::class, 'SanPhamThuocDanhMuc'])->name('/SanPhamThuocDanhMuc');
Route::get('/HienThiSanPhamTheoTH/{MaThuongHieu}/{MaDanhMuc}', [HomeController::class, 'HienThiSanPhamTheoTH'])->name('/HienThiSanPhamTheoTH');
Route::get('/HienThiDanhMucCha/{MaDanhMuc}', [HomeController::class, 'HienThiDanhMucCha'])->name('/HienThiDanhMucCha');
Route::get('/HienThiDanhMucCon/{MaDanhMuc}', [HomeController::class, 'HienThiDanhMucCon'])->name('/HienThiDanhMucCon');
Route::get('/ChiTietSanPham/{MaSanPham}', [HomeController::class, 'ChiTietSanPham'])->name('/ChiTietSanPham');
Route::get('/TimKiem', [HomeController::class, 'TimKiem'])->name('/TimKiem');
Route::get('/ThanhToan', [HomeController::class, 'ThanhToan'])->name('/ThanhToan');
Route::get('/thong-tin-tai-khoan', [HomeController::class, 'thongTinTaiKhoan'])->name('/thong-tin-tai-khoan');
Route::post('/thong-tin-tai-khoan', [TaiKhoanController::class, 'xuLyCNTK'])->name('/thongTinTaiKhoan');
Route::get('/TrangKhachHangDangNhap', [HomeController::class, 'TrangKhachHangDangNhap'])->name('/TrangKhachHangDangNhap');
Route::post('/KhachHangDangNhap', [HomeController::class, 'KhachHangDangNhap'])->name('/KhachHangDangNhap');
Route::get('/KhachHangDangXuat', [HomeController::class, 'KhachHangDangXuat'])->name('/KhachHangDangXuat');
Route::get('/HienThiSanPhamTheoTSKT/{MaTSKT}/{MaDanhMuc}', [HomeController::class, 'HienThiSanPhamTheoTSKT'])->name('/HienThiSanPhamTheoTSKT');
Route::get('/HienThiBaiViet', [HomeController::class, 'HienThiBaiViet'])->name('/HienThiBaiViet');
Route::get('/HienThiBaiVietTheoDMBV/{MaDanhMucBV}', [HomeController::class, 'HienThiBaiVietTheoDMBV'])->name('/HienThiBaiVietTheoDMBV');
Route::get('/ChiTietBaiViet/{MaBaiViet}', [HomeController::class, 'ChiTietBaiViet'])->name('/ChiTietBaiViet');
Route::post('/product-tabs', [HomeController::class, 'product_tabs'])->name('/product-tabs');
Route::get('/HienThiSanPhamTheoGiaGiam/{MaDanhMuc}', [HomeController::class, 'HienThiSanPhamTheoGiaGiam'])->name('/HienThiSanPhamTheoGiaGiam');
Route::get('/HienThiSanPhamTheoGiaTang/{MaDanhMuc}', [HomeController::class, 'HienThiSanPhamTheoGiaTang'])->name('/HienThiSanPhamTheoGiaTang');
Route::get('/HienThiSanPhamTheoSoLuongBan/{MaDanhMuc}', [HomeController::class, 'HienThiSanPhamTheoSoLuongBan'])->name('/HienThiSanPhamTheoSoLuongBan');


// GioHangController
Route::post('/ThemGioHang', [GioHangController::class, 'ThemGioHang'])->name('/ThemGioHang');
Route::get('/HienThiGioHang', [GioHangController::class, 'HienThiGioHang'])->name('/HienThiGioHang');
Route::get('/XoaSanPhamTrongGioHang/{session_id}', [GioHangController::class, 'XoaSanPhamTrongGioHang'])->name('/XoaSanPhamTrongGioHang');
Route::post('/ThayDoiSoLuong', [GioHangController::class, 'ThayDoiSoLuong'])->name('/ThayDoiSoLuong');
Route::get('/XoaGioHang', [GioHangController::class, 'XoaGioHang'])->name('/XoaGioHang');
Route::post('/TinhPhiGiaoHang', [GioHangController::class, 'TinhPhiGiaoHang'])->name('/TinhPhiGiaoHang');
Route::get('/HuyPhiGiaoHang', [GioHangController::class, 'HuyPhiGiaoHang'])->name('/HuyPhiGiaoHang');
Route::post('/ApDungPhieuGiamGia', [GioHangController::class, 'ApDungPhieuGiamGia'])->name('/ApDungPhieuGiamGia');
Route::get('/HuyPhieuGiamGia', [GioHangController::class, 'HuyPhieuGiamGia'])->name('/HuyPhieuGiamGia');
Route::post('/DatHang', [GioHangController::class, 'DatHang'])->name('/DatHang');
Route::post('/ThayDoiSoLuongSanPham/{session_id}', [GioHangController::class, 'ThayDoiSoLuongSanPham'])->name('/ThayDoiSoLuongSanPham');

// phieu giam gia
Route::get('/liet-ke-phieu-giam-gia', [PhieuGiamGiaController::class, 'phieuGiamGia'])->name('/liet-ke-phieu-giam-gia');
Route::get('/them-phieu-giam-gia', [PhieuGiamGiaController::class, 'giaoDienTao'])->name('/them-phieu-giam-gia');
Route::post('/them-phieu-giam-gia', [PhieuGiamGiaController::class, 'taoPhieuGiamGia'])->name('/them-phieu-giam-gia.post');
Route::get('/sua-phieu-giam-gia/{MaGiamGia}', [PhieuGiamGiaController::class, 'giaoDienSua'])->name('/sua-phieu-giam-gia');
Route::post('/sua-phieu-giam-gia/{MaGiamGia}', [PhieuGiamGiaController::class, 'suaPhieuGiamGia'])->name('/suaPhieuGG');
Route::get('/xoa-phieu-giam-gia/{MaGiamGia}', [PhieuGiamGiaController::class, 'Xoa'])->name('/xoa-phieu-giam-gia');
Route::get('/tim-kiem-phieu-giam-gia', [PhieuGiamGiaController::class, 'timKiem'])->name('/timKiem');

// ThemPhieuGiamGiaND
Route::get('/ThemPhieuGiamGiaND', [PhieuGiamGiaController::class, 'ThemPhieuGiamGiaND'])->name('/ThemPhieuGiamGiaND');
Route::get('/LietKePhieuGiamGiaND', [PhieuGiamGiaController::class, 'LietKePhieuGiamGiaND'])->name('/LietKePhieuGiamGiaND');
Route::get('/XemPhieuGiamGiaND/{Email}', [PhieuGiamGiaController::class, 'XemPhieuGiamGiaND'])->name('/XemPhieuGiamGiaND');

// chuong trinh giam gia
Route::get('/tao-chuong-trinh-giam-gia', [ChuongTrinhGiamGiaController::class, 'giaoDienTao'])->name('/tao-chuong-trinh-giam-gia');
Route::post('/tao-chuong-trinh-giam-gia', [ChuongTrinhGiamGiaController::class, 'taoChuongTrinhGiamGia'])->name('/taoChuongTrinhGiamGia');
//Route::get('/api/san-pham/{categoryId}', [ChuongTrinhGiamGiaController::class, 'danhSachSanPham'])->name('api.san-pham');
Route::get('/chuong-trinh-giam-gia', [ChuongTrinhGiamGiaController::class, 'giaoDienLietKe'])->name('/chuong-trinh-giam-gia');
Route::get('/xoa-chuong-trinh-giam-gia/{MaCT}', [ChuongTrinhGiamGiaController::class, 'xoa'])->name('/xoa-chuong-trinh-giam-gia');
Route::get('/sua-chuong-trinh-giam-gia/{MaCT}', [ChuongTrinhGiamGiaController::class, 'giaoDienSua'])->name('/sua-chuong-trinh-giam-gia');
Route::middleware('TrangThaiCTGG')->group(function () {
    Route::post('/sua-chuong-trinh-giam-gia/{MaCT}', [ChuongTrinhGiamGiaController::class, 'suaChuongTrinhGiamGia'])->name('/suaChuongTrinhGiamGia');
});
Route::get('/chuong-trinh-giam-gia/{MaCT}', [ChuongTrinhGiamGiaController::class, 'xemCT'])->name('/xem-chi-tiet-ctgg');
Route::get('/tim-kiem-chuong-trinh-giam-gia', [ChuongTrinhGiamGiaController::class, 'timKiem'])->name('/timKiemCTGG');

// Bảo hành controller
Route::get('/TrangLietKeBaoHanh', [BaoHanhController::class, 'TrangLietKeBaoHanh'])->name('/TrangLietKeBaoHanh');
Route::get('/TrangLietKePhieuBaoHanh', [BaoHanhController::class, 'TrangLietKePhieuBaoHanh'])->name('/TrangLietKePhieuBaoHanh');
Route::get('/TrangChiTietPhieuBaoHanh/{order_code}', [BaoHanhController::class, 'TrangChiTietPhieuBaoHanh'])->name('/TrangChiTietPhieuBaoHanh');
Route::get('/TrangLietKeLichSuBaoHanh', [BaoHanhController::class, 'TrangLietKeLichSuBaoHanh'])->name('/TrangLietKeLichSuBaoHanh');
Route::get('/TrangThemLichSuBaoHanh/{MaCTPBH}', [BaoHanhController::class, 'TrangThemLichSuBaoHanh'])->name('/TrangThemLichSuBaoHanh');
Route::post('/ThemLichSuBaoHanh/{MaCTPBH}', [BaoHanhController::class, 'ThemLichSuBaoHanh'])->name('/ThemLichSuBaoHanh');
Route::get('/xem-chi-tiet-dh/{order_code}', [HomeController::class, 'xemCTDH'])->name('ChiTietDonHang');
Route::post('/huy-don/{id}', [DonHangController::class, 'HuyDon'])->name('HuyDon');




