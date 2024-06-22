<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTraHang extends Model
{
    use HasFactory;
    protected $table = 'tbl_phieutrahang';
    public $timestamps = false;
}
