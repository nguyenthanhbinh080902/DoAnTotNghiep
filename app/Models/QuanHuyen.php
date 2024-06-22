<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenQuanHuyen', 'type', 'MaThanhPho'
    ];
    protected $primaryKey = 'MaQuanHuyen';
    protected $table = 'tbl_quanhuyen';
}
