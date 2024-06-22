<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhThanhPho extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenThanhPho', 'type'
    ];
    protected $primaryKey = 'MaThanhPho';
    protected $table = 'tbl_tinhthanhpho';
}
