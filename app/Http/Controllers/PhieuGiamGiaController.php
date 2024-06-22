<?php

namespace App\Http\Controllers;

use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PhieuGiamGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function phieuGiamGia()
    {
        $phieuGiamGia = PhieuGiamGia::orderBy('MaGiamGia', 'DESC')->paginate(5);
        return view('admin.PhieuGiamGia.lietKePhieuGiamGia')->with(compact("phieuGiamGia"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function giaoDienTao()
    {
        //
        return view('admin.PhieuGiamGia.themPhieuGiamGia');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function taoPhieuGiamGia(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'TenMaGiamGia' => ['required', 'string', 'max:255'],
            'SlugMaGiamGia' => ['required', 'string', 'max:255', 'unique:tbl_phieugiamgia'],
            'TriGia' => ['required', 'string'],
            'BacNguoiDung' => ['required', 'integer'],
            'DonViTinh' => ['required', 'integer'],
            'ThoiGianBatDau' =>['required', 'date_format:Y-m-d\TH:i'],
            'ThoiGianKetThuc'=>['required','date_format:Y-m-d\TH:i','after:ThoiGianBatDau'],
        ], [
            'TenMaGiamGia.required' => "Vui lòng nhập tên phiếu giảm giá.",
            'SlugMaGiamGia.required' => "Vui lòng nhập slug phiếu giảm giá.",
            'TriGia.required' => "Vui lòng nhập trị giá phiếu giảm giá.",
            'BacNguoiDung.required' => "Vui lòng nhập Cấp bậc thành viên có thể dùng phiếu giảm giá.",
            'SlugMaGiamGia.unique' => "Mã code của phiếu giảm giá đã tồn tại.",
            'DonViTinh.required' => "Vui lòng nhập đơn vị tính của phiếu giảm giá.",
            'ThoiGianKetThuc.required' => "Vui lòng nhập ngày hết hiệu lực phiếu giảm giá.",
            'ThoiGianBatDau.required' => "Vui lòng nhập ngày có hiệu lực phiếu giảm giá.",
            'ThoiGianKetThuc.after' => "Ngày hết hiệu lực phải sau ngày có hiệu lực.",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }
        $data = $request->all();
        $phieu = new PhieuGiamGia();
        $phieu->TenMaGiamGia = $data['TenMaGiamGia'];
        $phieu->SlugMaGiamGia = $data['SlugMaGiamGia'];
        $phieu->TriGia = $data['TriGia'];
        $phieu->BacNguoiDung = $data['BacNguoiDung'];
        $phieu->MaCode = $this->generateDiscountCode($data['TenMaGiamGia']);
        $phieu->DonViTinh = $data['DonViTinh'];
        $phieu->ThoiGianBatDau = $data['ThoiGianBatDau'];
        $phieu->ThoiGianKetThuc = $data['ThoiGianKetThuc'];
        $phieu->save();

        return Redirect::to('/liet-ke-phieu-giam-gia')->with('message', 'Thêm mã giảm giá thành công');
    }

    private function generateDiscountCode(mixed $name)
    {
        // Chuyển đổi tên thành slug
        $slug = Str::slug($name, '-');

        // Lấy chữ cái đầu tiên sau mỗi dấu gạch ngang
        $parts = explode('-', $slug);
        $initials = '';
        foreach ($parts as $part) {
            $initials .= strtoupper($part[0]);
        }

        // Thêm số ngẫu nhiên dựa trên timestamp hiện tại
        $timestamp = now()->format('Y'); // Ví dụ: 20240530123456
        $code = $initials . $timestamp;

        // Đảm bảo mã giảm giá là duy nhất
        while (PhieuGiamGia::where('MaCode', $code)->exists()) {
            $timestamp = now()->format('Y') . rand(100, 999); // Thêm số ngẫu nhiên nếu bị trùng
            $code = $initials . $timestamp;
        }

        return $code;
    }

    /**
     * Display the specified resource.
     */
    public function timKiem(Request $request)
    {
        //
        $phieuGiamGia = PhieuGiamGia::where('TenMaGiamGia', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('SlugMaGiamGia', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('TriGia', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('MaCode', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('DonViTinh', 'LIKE', "%{$request->timKiem}%")
            ->get();
//        dd($phieuGiamGia);
        return view('admin.PhieuGiamGia.lietKePhieuGiamGia')->with(compact("phieuGiamGia"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function giaoDienSua($MaGiamGia)
    {
        //
        $suaPhieu = PhieuGiamGia::where('MaGiamGia', $MaGiamGia)->get();
        return view('admin.PhieuGiamGia.suaPhieuGiamGia', compact('suaPhieu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function suaPhieuGiamGia(Request $request, $MaGiamGia)
    {
        $validator = Validator::make($request->all(), [
            'TenMaGiamGia' => ['required', 'string', 'max:255'],
            'SlugMaGiamGia' => 'required|unique:tbl_phieugiamgia,SlugMaGiamGia,' . $MaGiamGia . ',MaGiamGia',
            'TriGia' => ['required', 'string'],
            'MaCode'=>'required|unique:tbl_phieugiamgia,MaCode,' . $MaGiamGia . ',MaGiamGia',
            'DonViTinh' => ['required', 'integer'],
            'BacNguoiDung' => ['required', 'integer'],
            'ThoiGianBatDau' =>['required', 'date_format:Y-m-d\TH:i'],
            'ThoiGianKetThuc'=>['required','date_format:Y-m-d\TH:i','after:ThoiGianBatDau'],
        ], [
            'TenMaGiamGia.required' => "Vui lòng nhập tên phiếu giảm giá.",
            'SlugMaGiamGia.required' => "Vui lòng nhập slug phiếu giảm giá.",
            'SlugMaGiamGia.unique' => "Slug đã tồn tại.",
            'TriGia.required' => "Vui lòng nhập trị giá phiếu giảm giá.",
            'BacNguoiDung.required' => "Vui lòng nhập Cấp bậc thành viên có thể dùng phiếu giảm giá.",
            'MaCode.required' => "Vui lòng nhập mã code của phiếu giảm giá.",
            'MaCode.unique' => "Mã code của phiếu giảm giá đã tồn tại.",
            'DonViTinh.required' => "Vui lòng nhập đơn vị tính của phiếu giảm giá.",
            'ThoiGianKetThuc.required' => "Vui lòng nhập ngày hết hiệu lực phiếu giảm giá.",
            'ThoiGianBatDau.required' => "Vui lòng nhập ngày có hiệu lực phiếu giảm giá.",
            'ThoiGianKetThuc.after' => "Ngày hết hiệu lực phải sau ngày có hiệu lực.",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }

        $phieu = PhieuGiamGia::find($MaGiamGia);
        $phieu->TenMaGiamGia = $request->TenMaGiamGia;
        $phieu->SlugMaGiamGia = $request->SlugMaGiamGia;
        $phieu->TriGia = $request->TriGia;
        $phieu->BacNguoiDung = $request->BacNguoiDung;
        $phieu->MaCode = $request->MaCode;
        $phieu->DonViTinh = $request->DonViTinh;
        $phieu->ThoiGianBatDau = $request->ThoiGianBatDau;
        $phieu->ThoiGianKetThuc = $request->ThoiGianKetThuc;
//        dd($request->ThoiGianKetThuc);
        $phieu->save();

        return Redirect::to('/liet-ke-phieu-giam-gia')->with('message', 'Sửa mã giảm giá thành công');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function Xoa($MaGiamGia)
    {
        //
//        $phieuGiamGia = PhieuGiamGia::find($MaGiamGia);
//        $phieuGiamGia->delete();
        $pheuGiamGia = PhieuGiamGia::findOrFail($MaGiamGia);
        $pheuGiamGia->TrangThai = 0;
        $pheuGiamGia->save();
        return Redirect::to('liet-ke-phieu-giam-gia')->with('status', 'Xóa mã giảm giá thành công');
    }
}
