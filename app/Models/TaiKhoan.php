<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaiKhoan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Email', 'TenTaiKhoan', 'SoDienThoai', 'MatKhau', 'HinhAnh',
        'TrangThai', 'BacNguoiDung', 'ThoiGianTao', 'ThoiGianSua', 'Quyen', 'Pin'
    ];
    protected $primaryKey = 'MaTaiKhoan';
    protected $table = 'tbl_taikhoan';
}
