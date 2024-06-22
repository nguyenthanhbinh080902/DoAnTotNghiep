<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongSoKyThuat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenTSKT', 'MaDMTSKT', 'TrangThai', 'SlugTSKT', 'MoTa', 'ThoiGianTao', 'ThoiGianSua'
    ];
    protected $primaryKey = 'MaTSKT';
    protected $table = 'tbl_thongsokythuat';

    public function DanhMucTSKT(){
        return $this->belongsTo(DanhMucTSKT::class, 'MaDMTSKT');
    }
}
