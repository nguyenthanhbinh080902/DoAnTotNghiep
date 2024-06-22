<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhiGiaoHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'MaThanhPho', 'MaQuanHuyen', 'MaXaPhuong', 'SoTien'
    ];
    protected $primaryKey = 'MaPhiGiaoHang';
    protected $table = 'tbl_phigiaohang';

    public function TinhThanhPho(){
        return $this->belongsTo(TinhThanhPho::class, 'MaThanhPho');
    }

    public function QuanHuyen(){
        return $this->belongsTo(QuanHuyen::class, 'MaQuanHuyen');
    }

    public function XaPhuongThiTran(){
        return $this->belongsTo(XaPhuongThiTran::class, 'MaXaPhuong');
    }
}
