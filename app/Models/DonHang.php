<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Email', 'MaGiaoHang', 'MaGiamGia', 'TrangThai',
        'order_code', 'ThoiGianTao', 'ThoiGianSua',
    ];
    protected $primaryKey = 'MaDonHang';
    protected $table = 'tbl_donhang';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'Email');
    }

    public function PhieuGiamGia(){
        return $this->belongsTo(PhieuGiamGia::class, 'MaGiamGia');
    }

    public function GiaoHang(){
        return $this->belongsTo(GiaoHang::class, 'MaGiaoHang');
    }

    public function ChiTietDonHang(){
        return $this->hasMany(ChiTietDonHang::class, 'order_code');
    }
}
