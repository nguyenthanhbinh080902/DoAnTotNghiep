<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    use HasFactory;
    protected $table = 'tbl_chitietphieunhap';
    protected $primaryKey = 'MaCTPN';
    public $timestamps = false;

    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }
}
