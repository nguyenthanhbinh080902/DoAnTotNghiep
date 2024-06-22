<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XaPhuongThiTran extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'TenXaPhuong', 'type', 'MaQuanHuyen'
    ];
    protected $primaryKey = 'MaXaPhuong';
    protected $table = 'tbl_xaphuongthitran';
}
