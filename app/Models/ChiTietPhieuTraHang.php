<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuTraHang extends Model
{
    use HasFactory;
    protected $table = 'tbl_chitietphieutrahang';
    protected $primaryKey = 'MaCTPTH';
    public $timestamps = false;
}
