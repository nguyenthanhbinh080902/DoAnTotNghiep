<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuongTrinhGiamGia extends Model
{
    use HasFactory;
    protected $table = 'tbl_chuongtrinhgiamgia';
    public $timestamps = false;
    protected $primaryKey = 'MaCTGG';
    protected $fillable = [
        'SlugCTGG', 'TenCTGG', 'order_code', 'HinhAnh',
        'MoTa', 'TrangThai', 'ThoiGianTao', 'ThoiGianSua', 
        'ThoiGianKetThuc', 'ThoiGianBatDau'
    ];

    public function SanPham()
    {
        return $this->belongsToMany(SanPham::class, 'tbl_chuongtrinhgiamgiasp', 'MaCTGG', 'MaSanPham')
            ->withPivot('PhanTramGiam');
    }

    public function chuongTrinhGiamGiaSPs()
    {
        return $this->hasMany(ChuongTrinhGiamGiaSP::class, 'MaCTGG');
    }
}
