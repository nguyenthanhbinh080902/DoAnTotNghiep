<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DangNhap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('xuLyDN')) {
            // Nếu đến từ phương thức xuLyDN, tiếp tục xử lý yêu cầu mà không cần đăng nhập
            return $next($request);
        }
    
        // Kiểm tra xem session 'user' có tồn tại hay không
        if ($request->session()->has('user')) {
            // Nếu session 'user' tồn tại, cho phép tiếp tục truy cập
            return $next($request);
        }
    
        // Nếu không có session 'user', chuyển hướng đến trang đăng nhập
        return redirect('/dang-nhap');
    }
}
