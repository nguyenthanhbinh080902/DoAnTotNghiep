<?php

namespace App\Http\Controllers;

use App\Mail\DoiMatKhau;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\TaiKhoan;
use App\Models\BaoCaoDoanhThu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TaiKhoanController extends Controller
{
    public function dangNhap(Request $request){
        session::forget('user');
        session::forget('path');
        return view('auth.dangNhap');
    }

    public function xuLyDN(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'matkhau.required' => 'Vui lòng nhập mật khẩu.',
        ];

        $valid = $request->validate([
            'email' => 'required',
            'matkhau' => 'required',
        ], $messages);

        $valid = $request->all();
        $email = $request->input('email');
        $matkhau = $request->input('matkhau');
        $taikhoan = TaiKhoan::where('Email', $email)->first();

        if ($taikhoan && password_verify($matkhau, $taikhoan->MatKhau)) {
            if(empty($taikhoan->Quyen)){
                if($taikhoan->TrangThai == 0){
                    return redirect()->back()->withInput()->withErrors([
                        'email' => 'Tài khoản đã vô hiệu hóa. Mời liên hệ quản trị viên hoặc tạo tài khoản mới',
                    ]);
                }
                $request->session()->put('user', [
                    'TenTaiKhoan' => $taikhoan->TenTaiKhoan,
                    'Quyen' => $taikhoan->Quyen,
                    'Email' => $taikhoan->Email,
                ]);
                return redirect('/');
            }
            else{
                if($taikhoan->TrangThai == 0){
                    return redirect()->back()->withInput()->withErrors([
                        'email' => 'Tài khoản đã bị vô hiệu hóa. Mời liên hệ quản trị viên hoặc tạo tài khoản mới',
                    ]);
                }
                

                $request->session()->put('user', [
                    'TenTaiKhoan' => $taikhoan->TenTaiKhoan,
                    'Quyen' => $taikhoan->Quyen,
                    'Email' => $taikhoan->Email,
                ]);
                if($taikhoan->Quyen != "Quản trị viên cấp cao"){
                    $data = DB::table('tbl_quyenvaitro')
                    ->join('tbl_quyen', 'tbl_quyenvaitro.MaQuyen', '=', 'tbl_quyen.MaPhanQuyen')
                    ->join('tbl_vaitro', 'tbl_vaitro.MaVaiTro', '=', 'tbl_quyenvaitro.MaVaiTro')
                    ->select('tbl_vaitro.*')
                    ->where('tbl_quyen.TenPhanQuyen', '=', $taikhoan->Quyen)
                    ->get();
                    $request->session()->put(['path' => $data]);
                }
                
                
                return redirect('/dashboard');
            }
        }else {
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ]);
        }
    }


    public function dangKy(){
        return view('auth.dangKy');
    }

    public function xuLyDK(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'tentaikhoan.required' => 'Vui lòng nhập tên tài khoản.',
            'tentaikhoan.unique' => 'Tên tài khoản đã được sử dụng.',
            'matkhau.required' => 'Vui lòng nhập mật khẩu.',
        ];
        $valid = $request->validate([
            'email' => [
            'required',
            'email',
                Rule::unique('tbl_taikhoan')->ignore($request->user_id),
            ],
            'tentaikhoan' => [
                'required',
                Rule::unique('tbl_taikhoan')->ignore($request->user_id),
            ],
            'matkhau' => 'required',
        ], $messages);

        if (!$valid) {
            return redirect()->back()->withInput();
        }

        $maTK = 'TK' . date('YmdHis');
        $thoiGianTao = date('Y-m-d H:i:s');
        $matkhauMoi = bcrypt($request->matkhau);

        $taiKhoan = new TaiKhoan();
        $taiKhoan->MaTaiKhoan = $maTK;
        $taiKhoan->Email = $request->email;
        $taiKhoan->TenTaiKhoan = $request->tentaikhoan;
        $taiKhoan->MatKhau = $matkhauMoi;
        $taiKhoan->BacNguoiDung = 1;
        $taiKhoan->TrangThai = 1;
        $taiKhoan->ThoiGianTao = $thoiGianTao;
        $taiKhoan->save();

        return redirect('/dang-nhap')->with('success', 'Tài khoản đăng ký thành công!');
    }

    public function xuLyCNTK(Request $request){
        $messages = [
            'HinhAnh.image' => "Vui lòng chọn đúng file hình ảnh.",
            'SoDienThoai.regex' => 'Định dạng số điện thoại không hợp lệ.',
        ];
        $valid = Validator::make ( $request->all() ,[
            'SoDienThoai' =>['nullable','regex:/^(\+84|0)[0-9]{9,10}$/'],
            'HinhAnh' => ['nullable','image','mimes:jpeg,png,jpg,gif|max:2048'], // Giới hạn kích thước và loại hình ảnh
        ], $messages);

        if ($valid->fails()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($valid->errors());
        }
        // Lưu hình ảnh vào thư mục lưu trữ và lấy đường dẫn
        if ($request->hasFile('HinhAnh')) {
            $hinhanh = $request->file('HinhAnh');
            $tenHinhAnh = time() . '.' . $hinhanh->getClientOriginalExtension();
            $duongDan = public_path('upload/Profile');
            $hinhanh->move($duongDan, $tenHinhAnh);
            $duongDanHinhAnh = 'upload/Profile/' . $tenHinhAnh;
        } else {
            $duongDanHinhAnh = ''; // Nếu không có hình ảnh được tải lên
        }

        $valid = $request->all();
        $tenTK = session(('user'))['TenTaiKhoan'];
        $thoiGianSua = Carbon::now();
        $sdt = $request->SoDienThoai;
        $tenNguoiDung = $request->TenNguoiDung;
        $email = $request->Email;
        $diaChi = $request->DiaChi;
        $hinhAnh = $duongDanHinhAnh;

        TaiKhoan::where('TenTaiKhoan', $tenTK)->update([
            'TenNguoiDung' => $tenNguoiDung,
            'Email' => $email,
            'DiaChi' => $diaChi,
            'SoDienThoai' => $sdt,
            'ThoiGianSua' => $thoiGianSua,
            'HinhAnh' => $hinhAnh
        ]);


        $request->session()->put('user', [
            'TenTaiKhoan' => $tenTK,
            'Quyen' => $request->quyen
        ]);

        return redirect('/thong-tin-tai-khoan')->with('success', 'Tài khoản đã được sửa thành công!');
    }

    public function dangXuat(){
        session::forget('user');
        session::forget('cart');
        session::forget('PhiGiaoHang');
        session::forget('PhieuGiamGia');
        session::forget('path');
        return redirect('/dang-nhap'); // Chuyển hướng về trang đăng nhập
    }

    public function lietKeTK(){
        $tk = DB::table('tbl_taikhoan')
                    ->select('tbl_taikhoan.*')
                    ->orderByDesc('tbl_taikhoan.TrangThai')
                    ->where('Quyen', '!=', null)
                    ->paginate(5);
        return view('admin.TaiKhoan.lietKeTK', ['data'=>$tk]);
    }

    public function taoTK(){
        $quyen = DB::select("SELECT TenPhanQuyen FROM tbl_quyen");
        return view('admin.TaiKhoan.taoTK', compact('quyen'));
    }

    public function xuLyTaoTK(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'tentaikhoan.required' => 'Vui lòng nhập tên tài khoản.',
            'tentaikhoan.unique' => 'Tên tài khoản đã được sử dụng.',
            'matkhau.required' => 'Vui lòng nhập mật khẩu.',
            'sdt.regex' => 'Định dạng số điện thoại không hợp lệ.',
        ];
        $valid = $request->validate([
            'email' => [
            'required',
            'email',
                Rule::unique('tbl_taikhoan')->ignore($request->user_id),
            ],
            'tentaikhoan' => [
                'required',
                Rule::unique('tbl_taikhoan')->ignore($request->user_id),
            ],
            'matkhau' => 'required',
            'sdt' => ['nullable','regex:/^(\+84|0)[0-9]{9,10}$/'],
        ], $messages);

        if(!$valid){
            return redirect()->back()->withInput();
        }

        $maTK = 'TKNV' . date('YmdHis');
        $valid = $request->all();
        $thoiGianTao = date('Y-m-d H:i:s');
        $matkhauMoi = bcrypt($request->matkhau);
        // Tạo tài khoản mới
        $taiKhoan = new TaiKhoan();
        $taiKhoan->MaTaiKhoan = $maTK;
        $taiKhoan->Email = $request->email;
        $taiKhoan->TenTaiKhoan = $request->tentaikhoan;
        $taiKhoan->SoDienThoai = $request->sdt;
        $taiKhoan->MatKhau = $matkhauMoi;
        $taiKhoan->TrangThai = 1;
        $taiKhoan->ThoiGianTao = $thoiGianTao;
        $taiKhoan->Quyen = $request->quyen;
        $taiKhoan->save();

        return redirect('/liet-ke-tai-khoan')->with('success', 'Tài khoản đã được tạo thành công!');
    }



    public function suaTK($id){
        $quyen = DB::select("SELECT TenPhanQuyen FROM tbl_quyen");
        $tk = DB::select("SELECT * FROM tbl_taikhoan WHERE tbl_taikhoan.MaTaiKhoan = ? LIMIT 1", [$id]);
        return view('admin.TaiKhoan.suaTK', ['data'=>$tk, 'quyen' => $quyen]);
    }

    public function xuLySuaTK(Request $request){
        $message = [
            'sdt.regex' => 'Định dạng số điện thoại không hợp lệ.',
        ];
        $valid = $request->validate([
            'sdt' => ['nullable','regex:/^(\+84|0)[0-9]{9,10}$/'],
        ], $message);

        $maTK = $request->maTK;
        $quyen = $request->quyen;
        $trangThai = $request->trangThai;
        $thoiGianSua = date('Y-m-d H:i:s');
        TaiKhoan::where('MaTaiKhoan', $maTK)->update([
            'SoDienThoai' => $request->sdt,
            'Quyen' => $quyen,
            'TrangThai' => $trangThai,
            'ThoiGianSua' => $thoiGianSua,
        ]);
        return redirect('/liet-ke-tai-khoan')->with('success', 'Tài khoản đã được sửa thành công!');
    }

    public function xoaTK($id){
        TaiKhoan::where('MaTaiKhoan', $id)->update([
            'TrangThai' => 0,
        ]);
        return redirect('/liet-ke-tai-khoan')->with('success', 'Tài khoản đã được xóa thành công!');
    }

    public function timkiemTK(Request $request){
        $tuKhoa = $request->timKiem;
        $data = TaiKhoan::where('Quyen', 'NOT LIKE', null)
            ->where('TenTaiKhoan', 'LIKE', "%$tuKhoa%")
            ->paginate(5);
       
        return view('admin.TaiKhoan.lietkeTK')->with(compact("data"));
    }

    public function show_dashboard(){
        $user = session('user');
        
        $dauThangTruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $baoCaoDoanhThu = BaoCaoDoanhThu::orderBy('MaBCDT', 'DESC')->whereBetween('order_date', [$dauThangTruoc, $now])->get();
        return view('admin.dashboard', compact('user', 'baoCaoDoanhThu'));
        
    }

//
    public  function trangDatLaiMatKhau()
    {
        return view('auth.datLaiMatKhau');
    }
    //
    public function datlaiMatKhau(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'MatKhauCu' => ['required', 'string', 'min:8'],
            'MatKhauMoi' => ['required', 'string'],
            'MatKhauMoi2' => ['required', 'string'],
        ],[
            'MatKhauMoi.required' =>'Vui lòng nhập mật khẩu mới.',
            'MatKhauMoi2.required' =>'Vui lòng nhập lại mật khẩu mới.'
        ]);

        if ($validator->fails()) {
//            $message = $validator->errors();
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors( $validator->errors());
//            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

//        $user = TaiKhoan::where('TenTaiKhoan', $request->session()->get('user.TenTaiKhoan'))->first();
//        dd($user);
        if($request -> MatKhauMoi == $request -> MatKhauMoi2)
            TaiKhoan::where('TenTaiKhoan', $request->session()->get('user.TenTaiKhoan'))->update([
                'MatKhau' => bcrypt($request->MatKhauMoi)
            ]);
        return view('auth.dangNhap');
    }

    public  function trangDoiMatKhau()
    {
        return view('auth.doiMatKhau');
    }
    //
    public function doiMatKhau(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'MatKhauCu' => ['required', 'string', 'min:8'],
            'MatKhauCu' => ['required', 'string'],
            'MatKhauMoi' => ['required', 'string'],
            'MatKhauMoi2' => ['required', 'string'],
        ],[
            'MatKhauCu.required' => 'Vui lòng nhập mật khẩu cũ.',
            'MatKhauMoi.required' =>'Vui lòng nhập mật khẩu mới.',
            'MatKhauMoi2.required' =>'Vui lòng nhập lại mật khẩu mới.'
        ]);

        if ($validator->fails()) {
//            $message = $validator->errors();
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors( $validator->errors());
//            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $user = TaiKhoan::where('TenTaiKhoan', $request->session()->get('user.TenTaiKhoan'))->first();
//        dd($user);
        if (!$user || !password_verify($request->MatKhauCu, $user->MatKhau)){
            return redirect()->back()->withErrors("error", "Mật khẩu cũ không đúng");
        }

        if($request->MatKhauMoi != $request->MatKhauMoi2){
            return redirect()->back()->withErrors("error", "Mật khẩu nhập lại không khớp");
        }
        TaiKhoan::where('TenTaiKhoan', $request->session()->get('user.TenTaiKhoan'))->update([
            'MatKhau' => bcrypt($request->MatKhauMoi)
        ]);
        return view('auth.dangNhap');
    }

    public  function trangQMK()
    {
        return view('auth.quenMatKhau');
    }

    public function indexXTPin()
    {
        return view('auth.xacThucPin');
    }
    //
    public function quenMatKhau(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => ['required', 'string', 'Email', 'max:255'],
        ],[
            'Email.required' =>  "Vui lòng nhập Email.",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors( $validator->errors());
//            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $verify = TaiKhoan::where('Email', $request->all()['Email'])->exists();

        if ($verify) {
            $verify2 = TaiKhoan::where('Email', $request -> Email)->first();

            $Pin = random_int(100000, 999999);
            $password_reset = DB::table('tbl_taikhoan')
                ->where(['Email' => $request->all()['Email'],])
                ->update([
//            'Email' => $request->all()['Email'],
                    'Pin' => $Pin,
                    'ThoiGianSua' => Carbon::now()
                ]);

            if ($password_reset) {
                $request->session()->put('user', [
                    'TenTaiKhoan' => $verify2 -> TenTaiKhoan,
                    'Quyen' => $verify2 -> Quyen,
                ]);
                Mail::to($request->all()['Email'])->send(new DoiMatKhau($Pin));
                return redirect('/xac-thuc-pin') -> with('success', 'Vui lòng kiểm tra email');
            }
        } else {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors( 'Email này không tồn tại.');
        }
    }

    public function xacThucPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Pin' => ['required'],
        ],[
            'Pin.required' => "Vui lòng nhập mã pin",

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors( $validator->errors());
//            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $check = DB::table('tbl_taikhoan')
            ->where([
                'TenTaiKhoan' => $request->session()->get('user.TenTaiKhoan'),
                'Pin' => $request->all()['Pin'],
            ]);

        if ($check->exists()) {
            $difference = Carbon::now()->diffInSeconds($check->first()->ThoiGianSua);
            if ($difference > 3600) {
                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors('Mã pin hết hiệu lực.');
//                return new JsonResponse(['success' => false, 'message' => "Pin Expired"], 400);
            }
            return redirect('/dat-lai-mat-khau');
        } else {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors('Mã pin không .');
        }
    }
}
