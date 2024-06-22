$data = $request->all();

echo '<pre>';
print_r($data);
echo '</pre>';

$allDanhMucCon = '';
        foreach($allDanhMuc as $key =>$valueDanhMuc){
            if($valueDanhMuc->DanhMucCha != $MaDanhMuc){
                $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $MaDanhMuc)->paginate(12);
            }else{
                $allDanhMucCon = DanhMuc::orderBy('MaDanhMuc', 'DESC')->where('MaDanhMuc', $valueDanhMuc['MaDanhMuc'])->get();
                foreach($allDanhMucCon as $key => $valueDanhMucCon){
                    $allSanPham = SanPham::where('TrangThai', '1')->where('MaDanhMuc', $valueDanhMucCon['MaDanhMuc'])->paginate(12);
                }
                return view('pages.SanPham.DanhMuc.HienThiDanhMucCha')
                ->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
                ->with(compact('allDanhGia', 'sanPhamNoiBat'));
            }
        }

return view('pages.SanPham.DanhMuc.HienThiDanhMucCha')
->with(compact('allDanhMuc', 'allThuongHieu', 'allSanPham', 'allTHDM', 'allDanhMucTSKT', 'allTSKT', 'MaDanhMuc'))
->with(compact('allDanhGia', 'sanPhamNoiBat'));
