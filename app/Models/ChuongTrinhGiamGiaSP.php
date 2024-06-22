<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuongTrinhGiamGiaSP extends Model
{
    use HasFactory;
    protected $primaryKey = 'MaCTGGSP';
    protected $fillable = [
        'MaSanPham', 'MaCTGG', 'PhanTramGiam', 'order_code'
    ];
    protected $table = 'tbl_chuongtrinhgiamgiasp';
    public $timestamps = false;
    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }

    public function ChuongTrinhGiamGia()
    {
        return $this->belongsTo(ChuongTrinhGiamGia::class, 'MaCTGG', 'MaCTGG');
    }
}
