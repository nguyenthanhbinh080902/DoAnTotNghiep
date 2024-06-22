<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBaoHanh extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'TenKhachHang', 'SoDienThoai',  'ThoiGianTao', 'ThoiGianSua',
    ];
    protected $primaryKey = 'MaPhieuBaoHanh';
    protected $table = 'tbl_phieubaohanh';

    public function DonHang(){
        return $this->belongsTo(DonHang::class, 'order_code');
    }
}
