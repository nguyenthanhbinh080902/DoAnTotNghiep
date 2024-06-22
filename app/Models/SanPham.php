<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenSanPham', 'SlugSanPham', 'MaThuongHieu', 'MaDanhMuc',
        'HinhAnh', 'TrangThai', 'MoTa', 'SoLuongHienTai', 'SoLuongBan', 'SoLuongTrongKho',
        'GiaSanPham', 'ThoiGianTao', 'ThoiGianSua', 'ThongSoKyThuat',
        'ChieuCao', 'ChieuNgang', 'ChieuDay', 'CanNang', 'ThoiGianBaoHanh',
    ];
    protected $primaryKey = 'MaSanPham';
    protected $table = 'tbl_sanpham';

    public function DanhMuc(){
        return $this->belongsTo(DanhMuc::class, 'MaDanhMuc');
    }

    public function ThuongHieu(){
        return $this->belongsTo(ThuongHieu::class, 'MaThuongHieu');
    }

    public function ChuongTrinhGiamGia()
    {
        return $this->belongsToMany(ChuongTrinhGiamGia::class, 'tbl_chuongtrinhgiamgiasp', 'MaSanPham', 'MaCTGG')
            ->withPivot('PhanTramGiam');
    }
}
