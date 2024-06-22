<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;
    protected $table = 'tbl_nhacungcap';
    public $timestamps = false;
    protected $primaryKey = 'MaNhaCungCap';
}
