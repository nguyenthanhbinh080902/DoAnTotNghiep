<?php

namespace App\Http\Middleware;

use App\Models\ChuongTrinhGiamGia;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrangThaiCTGG
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem yêu cầu đến có đặt trạng thái thành 1 không
        if ($request->input('TrangThai') == 1) {
            // Cập nhật tất cả các chương trình giảm giá khác về trạng thái 0
            DB::table('tbl_chuongtrinhgiamgia')->update(['TrangThai' => 0]);
        }

        return $next($request);
    }
}
