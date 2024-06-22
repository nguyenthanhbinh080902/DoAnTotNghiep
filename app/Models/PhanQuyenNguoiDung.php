<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanQuyenNguoiDung extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'MaPhanQuyen', 'MaTaiKhoan'
    ];
    protected $primaryKey = 'MaPQND';
    protected $table = 'tbl_phanquyennguoidung';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan');
    }

    public function PhanQuyen(){
        return $this->belongsTo(PhanQuyen::class, 'MaPhanQuyen');
    }
}
