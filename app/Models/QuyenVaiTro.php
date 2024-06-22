<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyenVaiTro extends Model
{
    use HasFactory;
    protected $table = 'tbl_quyenvaitro';
    public $timestamps = false;
    protected $primaryKey = 'MaQVT';
}
