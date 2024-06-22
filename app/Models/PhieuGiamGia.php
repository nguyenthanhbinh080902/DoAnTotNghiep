<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuGiamGia extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "tbl_phieugiamgia";
    protected $primaryKey = "MaGiamGia";
    protected $fillable = ["MaGiamGia", "TenMaGiamGia", "SlugMaGiamGia", "DonViTinh", "MaCode", "TriGia", 'ThoiGianBatDau', 'ThoiGianKetThuc', 'BacNguoiDung'];
}
