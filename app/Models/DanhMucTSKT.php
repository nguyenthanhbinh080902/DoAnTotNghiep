<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTSKT extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenDMTSKT', 'SlugDMTSKT', 'MaDanhMuc', 'TrangThai', 'MoTa', 'ThoiGianTao', 'ThoiGianSua'
    ];
    protected $primaryKey = 'MaDMTSKT';
    protected $table = 'tbl_danhmuctskt';

    public function DanhMuc(){
        return $this->belongsTo(DanhMuc::class, 'MaDanhMuc');
    }
}
