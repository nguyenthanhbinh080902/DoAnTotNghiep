<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TichDiem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Email', 'TongDiem', 'SoLuongDonHang'
    ];
    protected $primaryKey = 'MaTichDiem';
    protected $table = 'tbl_tichdiem';

    public function TaiKhoan(){
        return $this->belongsTo(TaiKhoan::class, 'Email');
    }
}
