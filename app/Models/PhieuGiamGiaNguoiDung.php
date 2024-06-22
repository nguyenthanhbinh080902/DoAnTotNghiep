<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuGiamGiaNguoiDung extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'MaGiamGia', 'Email', 'SoLuong',
    ];
    protected $primaryKey = 'MaPGGND';
    protected $table = 'tbl_phieugiamgianguoidung';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'Email');
    }

    public function PhieuGiamGia(){
        return $this->belongsTo(PhieuGiamGia::class, 'MaGiamGia');
    }
}
