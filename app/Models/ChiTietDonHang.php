<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'MaSanPham', 'GiaSanPham', 'SoLuong'
    ];
    protected $primaryKey = 'MaCTDH';
    protected $table = 'tbl_chitietdonhang';

    public function SanPham(){
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }

    public function DonHang(){
        return $this->belongsTo(DonHang::class, 'order_code');
    }
}
