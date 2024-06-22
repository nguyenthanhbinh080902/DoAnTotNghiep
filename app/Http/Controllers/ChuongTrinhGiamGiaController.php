<?php

namespace App\Http\Controllers;

use App\Models\ChuongTrinhGiamGia;
use App\Models\ChuongTrinhGiamGiaSP;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Rules\KiemTraTGCTGG;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;

class ChuongTrinhGiamGiaController extends Controller
{
    //
    public function giaoDienTao()
    {
        $categories = DanhMuc::where('TrangThai', '1')->get();
        return view('admin.ChuongTrinhGiamGia.themChuongTrinhGiamGia', compact( 'categories'));
    }

    public function taoChuongTrinhGiamGia(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'TenCTGG' => 'required',
            'SlugCTGG' => ['required', 'unique:tbl_chuongtrinhgiamgia'],
            'HinhAnh' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'MoTa' => 'required',
//            'MaSanPham' => 'required|array',
//            'PhanTramGiam' => 'required',
            'selectedProducts' => 'required|json',
            'ThoiGianKetThuc' => ['required','date','after:ThoiGianBatDau'],
            'ThoiGianBatDau' => [
                'required',
                'date',
                'after_or_equal:today',
                new KiemTraTGCTGG($request->ThoiGianBatDau, $request->ThoiGianKetThuc, $request->MaCTGG)],
        ], [
            'TenCTGG.required' => "Vui lòng nhập tên chương trình giảm giá.",
            'SlugCTGG.required' => "Vui lòng nhập slug.",
            'SlugCTGG.unique' => "Slug đã tồn tại.",
            'selectedProducts.required' => 'Vui lòng chọn sản phẩm',
            'MoTa.required' => "Vui lòng nhập mô tả.",
//            "MaSanPham.required" => "Vui lòng chọn sản phẩm",
//            'PhanTramGiam.required' => "Vui lòng nhập phần trăm giảm",
            'HinhAnh.required' => 'Vui lòng nhập hình ảnh.',
            'HinhAnh.image' => 'Vui lòng chọn đúng định dạng file hình ảnh',
            'ThoiGianBatDau.required' => "Vui lòng chọn thời gian bắt đầu chương trình giảm giá có hiệu lực.",
            'ThoiGianBatDau.after_or_equal' => 'Thời gian bắt đầu phải ít nhất bắt đầu từ hôm nay.',
            'ThoiGianKetThuc.required' => "Vui lòng chọn thời gian kết thúc chương trình giảm giá.",
            'ThoiGianKetThuc.after' => 'Thời gian kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
//            dd($validator->errors());
            // Lưu trữ dữ liệu bảng vào session
            session()->put('selectedProducts', $request->input('selectedProducts'));
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }
//        dd($request->all());

        // Xử lý upload hình ảnh
        $imagePath = null;
        if ($request->hasFile('HinhAnh')) {
            $image = $request->file('HinhAnh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/ChuongTrinhGiamGia'), $imageName);
            $imagePath = 'upload/ChuongTrinhGiamGia/' . $imageName;
        }

        $trangThai = 0;
        if($request->TrangThai !== null){
            $trangThai = $request->TrangThai;
        }

//        dd($imagePath);
        // Lưu thông tin chương trình giảm giá vào cơ sở dữ liệu

        $selectedProducts = json_decode($request->selectedProducts, true);


        $discountProgram = new ChuongTrinhGiamGia();
        $discountProgram->TenCTGG = $request->TenCTGG;
        $discountProgram->SlugCTGG = $request->SlugCTGG;
        $discountProgram->HinhAnh = $imagePath;
        $discountProgram->TrangThai = 0;
        $discountProgram->ThoiGianTao = Carbon::now();
        $discountProgram->MoTa = $request->MoTa;
        $discountProgram->ThoiGianBatDau = $request->ThoiGianBatDau;
        $discountProgram->ThoiGianKetThuc = $request->ThoiGianKetThuc;
        $discountProgram->save();


        foreach ($selectedProducts as $product) {
            $discountProgram->SanPham()->attach($product['id'], ['PhanTramGiam' => $product['phanTramGiam']]);
        }

        session()->forget('selectedProducts');
        return redirect()->route('/chuong-trinh-giam-gia')->with('success', 'Discount program created successfully!');
    }

    public function danhSachSanPham($categoryId)
    {
        // Lấy danh sách sản phẩm theo danh mục
        $products = SanPham::where('MaDanhMuc', $categoryId)->get(['MaSanPham as id', 'GiaSanPham', 'TenSanPham']);

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($products);
    }

    public function giaoDienLietKe()
    {
        // Lấy tất cả các chương trình giảm giá từ cơ sở dữ liệu
        $discountPrograms = ChuongTrinhGiamGia::orderBy('MaCTGG', 'DESC')->paginate(5);

        // Trả về view và truyền dữ liệu chương trình giảm giá cho view
        return view('admin.ChuongTrinhGiamGia.lietKeChuongTrinhGiamGia', compact('discountPrograms'));
    }

    public function xoa($MaCT)
    {
        $discountProgram = ChuongTrinhGiamGia::findOrFail($MaCT);
        $discountProgram->TrangThai = 0;
        $discountProgram->save();
        return redirect()->route('/chuong-trinh-giam-gia')->with('success', 'Chương trình giảm giá đã được xóa thành công!');
    }

    public function giaoDienSua($MaCT)
    {
        $chuongTrinh = ChuongTrinhGiamGia::findOrFail($MaCT);
        $categories = DanhMuc::where('TrangThai', 1)->get();
        $selectedProducts = $chuongTrinh->SanPham()->get(['tbl_sanpham.MaSanPham as id', 'tbl_sanpham.GiaSanPham', 'tbl_sanpham.TenSanPham', 'tbl_chuongtrinhgiamgiasp.PhanTramGiam']);

//        dd($ChuongTrinhGiamGiaSP);
        return view('admin.ChuongTrinhGiamGia.suaChuongTrinhGiamGia', compact('categories', 'selectedProducts', 'chuongTrinh'));
    }

    public function suaChuongTrinhGiamGia(Request $request, $MaCT)
    {
        $validator = Validator::make($request->all(), [
            'TenCTGG' => 'required',
            'SlugCTGG' => [
                'required',
                Rule::unique('tbl_chuongtrinhgiamgia', 'SlugCTGG')->ignore($MaCT, 'MaCTGG'),
            ],
            'HinhAnh' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'MoTa' => 'required',
            'TrangThai' => 'required',
//            'MaSanPham' => 'required|array',
//            'PhanTramGiam' => 'required',
//            'ThoiGianBatDau' => '',
//            'ThoiGianKetThuc' => ''
        ], [
            'TenCTGG.required' => "Vui lòng nhập tên chương trình giảm giá.",
            'SlugCTGG.required' => "Vui lòng nhập slug.",
            'SlugCTGG.unique' => "Slug đã tồn tại.",
            'MoTa.required' => "Vui lòng nhập mô tả.",
            'TrangThai.required' => "Vui lòng chọn trạng thái.",
//            "MaSanPham.required" => "Vui lòng chọn sản phẩm",
//            'PhanTramGiam.required' => "Vui lòng nhập phần trăm giảm",
            'HinhAnh.required' => 'Vui lòng nhập hình ảnh.',
            'HinhAnh.image' => 'Vui lòng chọn đúng định dạng file hình ảnh'
        ]);

        if ($validator->fails()) {
            session()->put('selectedProducts', $request->input('selectedProducts'));
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }

        $discountProgram = ChuongTrinhGiamGia::findOrFail($MaCT);

        if ($request->hasFile('HinhAnh')) {
            $path_unlink = $discountProgram->HinhAnh;
            if (file_exists($path_unlink)) {
                unlink($path_unlink);
            }
            $image = $request->file('HinhAnh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/ChuongTrinhGiamGia'), $imageName);
            $discountProgram->HinhAnh = 'upload/ChuongTrinhGiamGia/' . $imageName;
        }

        $discountProgram->TenCTGG = $request->TenCTGG;
        $discountProgram->SlugCTGG = $request->SlugCTGG;
        $discountProgram->MoTa = $request->MoTa;
        $discountProgram->TrangThai = $request->TrangThai;
        $discountProgram->ThoiGianSua = Carbon::now();
        $discountProgram->ThoiGianBatDau = $request-> ThoiGianBatDau;
        $discountProgram->ThoiGianKetThuc = $request->ThoiGianKetThuc;
        $discountProgram->save();

//        dd($discountProgram->SanPham());

        // Cập nhật các sản phẩm trong chương trình giảm giá
        // Cập nhật sản phẩm liên quan
        $selectedProducts = json_decode($request->selectedProducts, true);
//        dd($selectedProducts);
        if($selectedProducts !== null){

            $discountProgram->SanPham()->detach();
            foreach ($selectedProducts as $product) {
                $discountProgram->SanPham()->attach($product['id'], ['PhanTramGiam' => $product['phanTramGiam']]);
            }
        }

        session()->forget('selectedProducts');
        return redirect()->route('/chuong-trinh-giam-gia')->with('success', 'Chương trình giảm giá đã được cập nhật thành công!');
    }

    public function xemCT($MaCT)
    {
        $discountProgram = ChuongTrinhGiamGia::findOrFail($MaCT);
        return view('admin.ChuongTrinhGiamGia.xemCT', compact('discountProgram'));
    }

    public function layThongTinChiTiet(Request $request)
    {
        $ids = $request->input('ids');
        $products = SanPham::whereIn('MaSanPham', $ids)
            ->whereNotNull('SoLuongHienTai')
            ->where('SoLuongHienTai', '>', 0)
            ->select('MaSanPham as id', 'TenSanPham', 'GiaSanPham')
            ->get();

        return response()->json($products);
    }

    public function timKiem(Request $request)
    {
        //
        $tuKhoa = $request->timKiem;
        $discountPrograms = ChuongTrinhGiamGia::where('TenCTGG', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('SlugCTGG', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('MoTa', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('ThoiGianTao', 'LIKE', "%{$request->timKiem}%")
            ->orWhere('ThoiGianSua', 'LIKE', "%{$request->timKiem}%")
//            ->orWhere('TrangThai', 'LIKE', "%{$request->timKiem}%")
//            ->orWhereHas('chuongTrinhGiamGiaSPs', function ($query) use ($tuKhoa){
//                $query->where('PhanTramGiam', "%$tuKhoa%");
//            })
            ->get();
//        dd($phieuGiamGia);
        return view('admin.ChuongTrinhGiamGia.lietKeChuongTrinhGiamGia')->with(compact("discountPrograms"));
    }
}
