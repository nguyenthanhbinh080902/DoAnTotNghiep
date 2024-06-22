<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuXuat extends Model
{
    use HasFactory;
    protected $table = 'tbl_chitietphieuxuat';
    protected $primaryKey = 'MaCTPX';
    public $timestamps = false;

}
