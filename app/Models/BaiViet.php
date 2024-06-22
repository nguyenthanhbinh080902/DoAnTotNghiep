<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenBaiViet', 'SlugBaiViet', 'MaDanhMucBV', 'HinhAnh',
        'TrangThai', 'MoTa', 'ThoiGianTao', 'ThoiGianSua'   
    ];
    protected $primaryKey = 'MaBaiViet';
    protected $table = 'tbl_baiviet';

    public function DanhMucBV(){
        return $this->belongsTo(DanhMucBaiViet::class, 'MaDanhMucBV');
    }
}
