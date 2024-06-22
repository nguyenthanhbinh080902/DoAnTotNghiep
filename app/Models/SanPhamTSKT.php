<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamTSKT extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'MaSanPham', 'MaTSKT', 'ThoiGianTao', 'ThoiGianSua'
    ];
    protected $primaryKey = 'MaTSKTSP';
    protected $table = 'tbl_thongsokythuatsp';

    public function ThongSoKyThuat(){
        return $this->belongsTo(ThongSoKyThuat::class, 'MaTSKT');
    }

    public function SanPham(){
        return $this->belongsTo(SanPham::class, 'MaSanPham');
    }
}
