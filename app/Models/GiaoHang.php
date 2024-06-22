<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenNguoiNhan', 'TienGiaoHang', 'DiaChi', 'SoDienThoai', 'GhiChu'
    ];
    protected $primaryKey = 'MaGiaoHang';
    protected $table = 'tbl_giaohang';
}
