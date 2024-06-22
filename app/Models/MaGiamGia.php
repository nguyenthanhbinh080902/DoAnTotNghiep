<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenMaGiamGia', 'SlugMaGIamGia', 'TinhNang',
        'SoTien', 'MaCode', 'HinhAnh'
    ];
    protected $primaryKey = 'MaGiamGia';
    protected $table = 'tbl_magiamgia';
}
