<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenDanhMuc', 'SlugDanhMuc', 'DanhMucCha', 'MoTa', 'TrangThai', 'ThoiGianTao', 'ThoiGianSua'
    ];
    protected $primaryKey = 'MaDanhMuc';
    protected $table = 'tbl_danhmuc';

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'MaDanhMuc');
    }
}
