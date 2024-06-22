<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class NhaCungCapController extends Controller
{
    //
    public function lietKe(){
        $ncc = DB::table('tbl_nhacungcap')
                ->leftJoin('tbl_phieunhap', 'tbl_nhacungcap.MaNhaCungCap', '=', 'tbl_phieunhap.MaNhaCungCap')
                ->select('tbl_nhacungcap.*', DB::raw('count(tbl_phieunhap.MaPhieuNhap) as so_luong_phieu_nhap'))
                ->groupBy('tbl_nhacungcap.MaNhaCungCap')
                ->orderByDesc('tbl_nhacungcap.TrangThai')
                ->orderByDesc('so_luong_phieu_nhap')
                ->paginate(5);
        return view('admin.NhaCungCap.lietKeNCC', ['data'=>$ncc]);
        
    }

    public function themNCC(Request $request){
        $test = $request->source;
        return view('admin.NhaCungCap.themNCC', ['test' => $test]);
    }

    public function xuLyThemNCC(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'tennhacungcap.required' => 'Vui lòng nhập tên nhà cung cấp.',
            'tennhacungcap.unique' => 'Tên nhà cung cấp đã được sử dụng.',
            'sdt.regex' => 'Định dạng số điện thoại không hợp lệ.',
            'diachi.required' => 'Vui lòng nhập địa chỉ',
            'nguoiDaiDien.required' => 'Vui lòng nhập tên người đại diện',
        ];
        $valid = $request->validate([
            'email' => [
            'required',
            'email',
                Rule::unique('tbl_nhacungcap')->ignore($request->user_id),
            ],
            'tennhacungcap' => [
                'required',
                Rule::unique('tbl_nhacungcap')->ignore($request->user_id),
            ],
            'sdt' => ['nullable','regex:/^(\+84|0)[0-9]{9,10}$/'],
            'diachi' => 'required',
            'nguoiDaiDien' => 'required',
        ], $messages);

        if (!$valid) {
            return redirect()->back()->withInput();
        }

        $tenNCC = $request->tennhacungcap;
        $maNCC = 'NCC' . date('YmdHis');
        $thoiGianTao = date('Y-m-d H:i:s');

        $nhacungcap = new NhaCungCap();
        $nhacungcap->MaNhaCungCap = $maNCC;
        $nhacungcap->TenNhaCungCap = $tenNCC;
        $nhacungcap->DiaChi = $request->diachi;
        $nhacungcap->TenNguoiDaiDien = $request->nguoiDaiDien;
        $nhacungcap->SoDienThoai = $request->sdt;
        $nhacungcap->Email = $request->email;
        $nhacungcap->TrangThai = 1;
        $nhacungcap->ThoiGianTao = $thoiGianTao;
        $nhacungcap->save();

        // if ($request->nccMoi == 'NCCMoi') {
        //     // Chuyển hướng người dùng đến trang tạo mới phiếu nhập
        //     return redirect('/lap-phieu-nhap')->with('success', 'Thêm nhà cung cấp thành công!');
        // }else{
            return redirect('/liet-ke-nha-cung-cap')->with('success', 'Thên nhà cung cấp thành công!');
        // }
        

    }


    public function suaNCC($id){
        $ncc = DB::select("SELECT * FROM tbl_nhacungcap WHERE tbl_nhacungcap.MaNhaCungCap = ? LIMIT 1", [$id]);
        return view('admin.NhaCungCap.suaNCC', ['data'=>$ncc]);
    }

    public function xuLySuaNCC(Request $request){
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'tennhacungcap.required' => 'Vui lòng nhập tên nhà cung cấp.',
            'tennhacungcap.unique' => 'Tên nhà cung cấp đã được sử dụng.',
            'sdt.regex' => 'Định dạng số điện thoại không hợp lệ.',
            'diachi.required' => 'Vui lòng nhập địa chỉ',
            'nguoiDaiDien.required' => 'Vui lòng nhập tên người đại diện',
        ];
        $valid = $request->validate([
            'email' => [
            'required',
            'email',
                Rule::unique('tbl_nhacungcap')->ignore($request->maNCC, 'MaNhaCungCap'),
            ],
            'tennhacungcap' => [
                'required',
                Rule::unique('tbl_nhacungcap')->ignore($request->maNCC, 'MaNhaCungCap'),
            ],
            'sdt' => ['nullable','regex:/^(\+84|0)[0-9]{9,10}$/'],
            'diachi' => 'required',
            'nguoiDaiDien' => 'required',
        ], $messages);
        
        $valid = $request->all();
        $maNCC = $request->maNCC;
        $tenNCC = $request->tennhacungcap;
        $tenNguoiDaiDien = $request->nguoiDaiDien;
        $email = $request->email;
        $sdt = $request->sdt;
        $diachi = $request->diachi;
        $trangThai = $request->trangThai;
        $thoigiansua = date('Y-m-d H:i:s');

        NhaCungCap::where('MaNhaCungCap', $maNCC)->update([
            'TenNhaCungCap' => $tenNCC,
            'DiaChi' => $diachi,
            'TenNguoiDaiDien' => $tenNguoiDaiDien,
            'SoDienThoai' => $sdt,
            'Email' => $email,
            'TrangThai' => $trangThai,
            'ThoiGianSua' => $thoigiansua,        
        ]);
        return redirect('/liet-ke-nha-cung-cap')->with('success', 'Nha cung cap đã được sửa thành công!');
    }

    public function xoaNCC($id){
        // DB::delete('DELETE FROM tbl_nhacungcap WHERE MaNhaCungCap = ?', [$id]);
        NhaCungCap::where('MaNhaCungCap', $id)->update([
            'TrangThai' => 0,
        ]);
        return redirect('/liet-ke-nha-cung-cap')->with('Success', 'Xoa nha cung cap thanh cong');
    }

    public function timkiemNCC(Request $request){
        $data = NhaCungCap::select('tbl_nhacungcap.*')
            ->where(function($query) use ($request) {
                $query->where('tbl_nhacungcap.TenNhaCungCap', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere('tbl_nhacungcap.DiaChi', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere('tbl_nhacungcap.TenNguoiDaiDien', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere('tbl_nhacungcap.Email', 'LIKE', "%{$request->timKiem}%")
                    ->orWhere('tbl_nhacungcap.SoDienThoai', 'LIKE', "%{$request->timKiem}%");
            })
            ->paginate(5);
        return view('admin.NhaCungCap.lietkeNCC', compact('data'));
    }

}
