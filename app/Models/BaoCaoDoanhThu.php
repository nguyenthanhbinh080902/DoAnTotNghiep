<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoCaoDoanhThu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_date', 'sales', 'profit', 'quantity', 'total_order'  
    ];
    protected $primaryKey = 'MaBCDT';
    protected $table = 'tbl_baocaodoanhthu';

}
