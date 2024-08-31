<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CutiController extends Controller
{
    public function index(){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $cuti = DB::table('tb_cuti')
                ->join('tb_jenis_cuti', 'tb_jenis_cuti.kode', "=", 'tb_cuti.kode')
                ->select('tb_cuti.*', 'tb_jenis_cuti.jenis')
                ->where('tb_cuti.id_user', $id_user)
                ->orderBy('id', 'desc')
                ->get();
        // dd($cuti);
        return view('cuti', compact('cuti'));
    }

    public function tambahCuti(){
        $jenisCuti = DB::table('tb_jenis_cuti')
                    ->get();
        // $tgl1 = strtotime("2020-01-01");
        // $tgl2 = strtotime("2020-01-20");

        // $jarak = $tgl2 - $tgl1;

        // $hari = $jarak / 60 / 60 / 24;
        // dd($hari);
        return view('tambahcuti', compact('jenisCuti'));
    }

    public function simpanCuti(Request $request){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        $jenis = $request->jenis;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $dokumen = $id_user."-".$s.".".$request->file('dokumen')->getClientOriginalExtension();
        $folder_path_dokumen = "public/uploads/cuti/";
        $jarak = strtotime($tgl_akhir) - strtotime($tgl_awal);
        $hari = $jarak /60/60/24;
        $jenisCuti = DB::table('tb_jenis_cuti')
                    ->where('kode', $jenis)
                    ->first();
        if(!($hari > $jenisCuti->hari)){
            $data = [
                'id_user'=>$id_user,
                'kode'=>$jenis,
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir,
                'status_approved'=>12,
                'dokumen' => $dokumen
            ];
            $query = DB::table('tb_cuti')->insert($data);
            if($query){
                $request->file('dokumen')->storeAs($folder_path_dokumen, $dokumen);
                return redirect()->to('/cuti')->with(['success' => 'Data Pengajuan Cuti Berhasil Disimpan!']);
            } else {
                return redirect()->to('/cuti')->with(['error' => 'Data Pengajuan Cuti Gagal Disimpan!']);
            }
        } else {
            return redirect()->to('/cuti/tambah')->with(['error' => 'Melebihi Batas Waktu Cuti Yang Ditentukan!']);
        }
    }

    public function getPengajuanCuti(){
        $title = "Pengajuan Cuti";
        $sidebar = "5";
        $getCuti = DB::table('tb_cuti')
                    ->join('tb_gtk', 'tb_cuti.id_user', '=', 'tb_gtk.id_user')
                    ->join('tb_jenis_cuti', 'tb_cuti.kode', '=', 'tb_jenis_cuti.kode')
                    ->select('tb_cuti.*', 'tb_gtk.*', 'tb_jenis_cuti.*')
                    ->where('status_approved', '12')
                    ->get();
        $getJenisCuti = DB::table('tb_jenis_cuti')
                        ->get();
        return view('pengajuancuti', compact('title', 'sidebar', 'getCuti', 'getJenisCuti'));
    }

    public function updateCuti(Request $request, $id){
        $cekCuti = DB::table('tb_cuti')
                    ->where('id', $id)
                    ->first();
        if($cekCuti->tgl_akhir == NULL && $request->status == "13"){
            $data = [
                'id_user' => $request->id_user,
                'tgl_presensi' => $request->tgl_awal,
                'izin' => strtoupper($request->alasan)
            ];
            DB::table('tb_presensi')->insert($data);
        } else if(!($cekCuti->tgl_akhir == NULL) && $request->status == "13") {
            $tgl_awal = strtotime($request->tgl_awal);
            $tgl_akhir = strtotime($request->tgl_akhir);
            for ( $i = $tgl_awal; $i <= $tgl_akhir; $i = $i + 86400 ) {
                $thisDate = date( 'Y-m-d', $i );
                $data = [
                    'id_user' => $request->id_user,
                    'tgl_presensi' => $thisDate,
                    'izin' => "CUTI"
                ];
                DB::table('tb_presensi')->insert($data);
            }
        }
        $cuti = Cuti::find($id);
        $data = [
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'status_approved' => $request->status
        ];
        if($cuti->update($data)){
            return redirect()->to('/admin/data/cuti')->with(['success' => 'Data Pengajuan Cuti Berhasil Disimpan!']);
        } else {
            return redirect()->to('/admin/data/cuti')->with(['error' => 'Data Pengajuan Cuti Gagal Disimpan!']);
        }
    }

    public function getCuti(Request $request){
        $title = "History Cuti";
        $sidebar = "9";
        $cuti = DB::table('tb_cuti')
                    ->join('tb_gtk', 'tb_cuti.id_user', '=', 'tb_gtk.id_user')
                    ->join('tb_jenis_cuti', 'tb_cuti.kode', '=', 'tb_jenis_cuti.kode')
                    ->select('tb_cuti.*', 'tb_gtk.*', 'tb_jenis_cuti.*', 'tb_cuti.id as id_cuti')
                    ->orderBy('id_cuti', 'desc');
        if(!empty($request->nama)){
            $cuti->where('nama_lengkap', 'like','%'.$request->nama.'%');
        }
        $getCuti = $cuti->paginate(10);
        $getJenisCuti = DB::table('tb_jenis_cuti')
                        ->get();
        return view('historicuti', compact('title', 'sidebar', 'getCuti', 'getJenisCuti'));
    }

    public function deleteCuti($id){
        $cuti = Cuti::find($id);
        if($cuti->delete()){
            return redirect()->to('/admin/history/cuti')->with(['success' => 'Data Cuti Berhasil Dihapus!']);
        } else {
            return redirect()->to('/admin/history/cuti')->with(['error' => 'Data Cuti Gagal Dihapus!']);
        }
    }
}
