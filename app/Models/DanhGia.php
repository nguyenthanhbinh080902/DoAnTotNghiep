<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Email', 'MaSanPham', 'NoiDung', 'SoSao', 'TrangThai', 'ThoiGianTao', 'ThoiGianSua',
    ];
    protected $primaryKey = 'MaDanhGia';
    protected $table = 'tbl_danhgia';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'Email');
    }

    public function SanPham(){
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }
}
