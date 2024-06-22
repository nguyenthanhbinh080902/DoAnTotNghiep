<?php

namespace App\Http\Controllers;

use App\Models\Quyen;
use App\Models\QuyenVaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class QuyenController extends Controller
{
    //
    public function lietKe(){
        $data = DB::table('tbl_quyenvaitro')
                    ->join('tbl_quyen', 'tbl_quyenvaitro.MaQuyen', '=', 'tbl_quyen.MaPhanQuyen')
                    ->join('tbl_vaitro', 'tbl_vaitro.MaVaiTro', '=', 'tbl_quyenvaitro.MaVaiTro')
                    ->select('tbl_quyen.TenPhanQuyen', 'tbl_vaitro.TenVaiTro', 'tbl_quyenvaitro.MaQVT')
                    ->groupBy('tbl_quyenvaitro.MaQuyen', 'tbl_vaitro.TenVaiTro', 'tbl_quyenvaitro.MaQVT')
                    ->get();
        $result = [];

        foreach ($data as $row) {
            $phanQuyen = $row->TenPhanQuyen;
            $vaiTro = $row->TenVaiTro;
            $maQVT = $row->MaQVT;
            
            if (!isset($result[$phanQuyen])) {
                $result[$phanQuyen] = [];
            }
            
            $result[$phanQuyen][] = [
                "TenVaiTro" => $vaiTro,
                "MaQVT" => $maQVT
            ];
        }

        return view('admin.Quyen.lietKe', compact('result'));
    }

    public function lietKeVaiTro(){
        $data = Quyen::all();
        return view('admin.Quyen.lietKeVaiTro', compact('data'));
    }

    public function updateVaiTro(Request $request){
        $maPQ = $request->input('MaPhanQuyen');
        $tenPQ = $request->input('TenPhanQuyen');
        if ($maPQ) {
            if(!empty($tenPQ)){
                Quyen::where('MaPhanQuyen', $maPQ)->update([
                    'TenPhanQuyen' => $tenPQ,
                ]);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Bạn chưa nhập tên vai trò']);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy vai trò']);
    }

    public function xoaQH($id){
        DB::delete("DELETE FROM tbl_quyenvaitro WHERE MaQVT = ?", [$id]);
        return redirect()->back();
    }
    public function themQuyen(){
        $quyen = DB::select("SELECT * FROM tbl_vaitro");
        $quyenTK = DB::select("SELECT * FROM tbl_quyen");
        return view('admin.Quyen.themQuyen', compact('quyen', 'quyenTK'));
    }

    public function themQuyenTK(){
        return view('admin.Quyen.themQuyenTK');
    }

    public function themQTK(Request $request){
        $messages = [
            'tenquyen.required' => 'Vui lòng nhập tên quyền hạn.',
        ];
        $valid = $request->validate([
            'tenquyen' => 'required',
        ], $messages);
        $quyen = new Quyen();
        $quyen->TenPhanQuyen = $request->tenquyen;
        $quyen->save();
        return redirect()->route('lietKeVaiTro');
    }
    public function themQH(Request $request){

        $maQuyen = $request->tenQuyen;
        $quyenHan = $request->MaQuyen;
        
        if($maQuyen){
            $kt = QuyenVaiTro::where('MaQuyen', $maQuyen)
                            ->where('MaVaiTro', $quyenHan)
                            ->first();
            if($kt){
                return response()->json(['success' => false, 'message' => 'Quyền hạn này đã có rồi']);
            }else{
                $qvt = new QuyenVaiTro();
                $qvt->MaQuyen = $maQuyen;
                $qvt->MaVaiTro = $quyenHan;
                $qvt->save();
                $quyen = DB::select("SELECT TenPhanQuyen FROM tbl_quyen WHERE MaPhanQuyen = ?", [$maQuyen]);
                $vaitro = DB::select("SELECT TenVaiTro FROM tbl_vaitro WHERE MaVaiTro = ?", [$quyenHan]);
                return response()->json([
                    'success' => true,
                    'tenQuyen' => $quyen[0]->TenPhanQuyen,
                    'tenQH' => $vaitro[0]->TenVaiTro,
                ]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy quyền']);
    }


}
