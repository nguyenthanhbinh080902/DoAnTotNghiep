<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenThuongHieu', 'SlugThuongHieu', 'HinhAnh', 'MoTa', 'TrangThai', 'ThoiGianTao', 'ThoiGianSua'
    ];
    protected $primaryKey = 'MaThuongHieu';
    protected $table = 'tbl_thuonghieu';

    // public function product(){
    //     return $this->hasMany(Brand::class);
    // }
}
