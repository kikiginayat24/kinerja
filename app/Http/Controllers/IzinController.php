<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinController extends Controller
{
    public function index(){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $dataIzin = DB::table('tb_izin')
                    ->where('id_user', $id_user)
                    ->orderBy('id', 'DESC')
                    ->get();
        return view('izin', compact('dataIzin'));
    }

    public function tambah(){
        return view('tambahizin');
    }

    public function save(Request $request){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $today = date("Y-m-d");
        $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $status_approved = 12;
        $dokumen = $id_user."-".$today."-".$s.".".$request->file('dokumen')->getClientOriginalExtension();
        $folder_path_dokumen = "public/uploads/izin/";
        if($tgl_akhir == NULL){
            $data = [
                'id_user' => $id_user,
                'keterangan' => $keterangan,
                'tgl_awal' => $tgl_awal,
                'status' => $status,
                'status_approved' =>$status_approved,
                'dokumen' => $dokumen
            ];
        } else {
            $data = [
                'id_user' => $id_user,
                'keterangan' => $keterangan,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'status' => $status,
                'status_approved' =>$status_approved,
                'dokumen' => $dokumen
            ];
        }
        $query = DB::table('tb_izin')->insert($data);
        if($query){
            $request->file('dokumen')->storeAs($folder_path_dokumen, $dokumen);
            return redirect()->to('/izin')->with(['success'=>'Terima Kasih! Data Pengajuan Izin Sudah Terkirim!']);
        } else {
            return redirect()->to('/izin')->with(['error'=>'Data Pengajuan Izin Gagal Terkirim!']);
        }
    }
}
