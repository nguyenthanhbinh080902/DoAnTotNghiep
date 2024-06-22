<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucBaiViet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenDanhMucBV', 'SlugDanhMucBV', 'TrangThai',
        'MoTa', 'ThoiGianTao', 'ThoiGianSua',
    ];
    protected $primaryKey = 'MaDanhMucBV';
    protected $table = 'tbl_danhmucbaiviet';
}
