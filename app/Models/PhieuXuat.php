<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuXuat extends Model
{
    use HasFactory;
    protected $table = 'tbl_phieuxuat';
    public $timestamps = false;
}
