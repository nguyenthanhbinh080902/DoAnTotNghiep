<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuBaoHanh extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'MaSanPham', 'SoLuong',  'TinhTrang', 'NgayBaoHanh', 'ThoiGianTra',
    ];
    protected $primaryKey = 'MaCTLSBH';
    protected $table = 'tbl_chitietlichsubaohanh';

    public function SanPham(){
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }
}
