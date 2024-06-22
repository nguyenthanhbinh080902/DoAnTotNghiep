<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuBaoHanh extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'MaSanPham', 'SoLuong',  'ThoiGianBaoHanh', 'ThoiGianBatDau', 'ThoiGianKetThuc',
    ];
    protected $primaryKey = 'MaCTPBH';
    protected $table = 'tbl_chitietphieubaohanh';

    public function PhieuBaoHanh(){
        return $this->belongsTo(PhieuBaoHanh::class, 'order_code');
    }

    public function SanPham(){
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }
}
