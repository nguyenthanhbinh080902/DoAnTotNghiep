<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Email', 'MaBaiViet', 'BaiVietCha', 'NoiDung', 'TrangThai', 'ThoiGianTao', 'ThoiGianSua',
    ];
    protected $primaryKey = 'MaBinhLuan';
    protected $table = 'tbl_binhluan';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'Email');
    }

    public function BaiViet(){
        return $this->belongsTo(BaiViet::class, 'MaBaiViet');
    }
}
