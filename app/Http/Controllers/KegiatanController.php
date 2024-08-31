<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
class KegiatanController extends Controller
{
    public function index(){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $cekAbsen = DB::table('tb_presensi')
                    ->where('id_user', $id_user)
                    ->where('tgl_presensi', date("Y-m-d"))
                    ->count();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $date = date("d");
        $month = date("m");
        $year = date("Y");
        $kegiatanHari = DB::table('tb_kegiatan')
                        ->where('id_user', $id_user)
                        ->whereRaw('DAY(tanggal)="'.$date.'"')
                        ->whereRaw('MONTH(tanggal)="'.$month.'"')
                        ->whereRaw('YEAR(tanggal)="'.$year.'"')
                        ->orderBy('jam')
                        ->get();
        if($cekAbsen < 1){
            $pesan = "Anda tidak diperkenankan untuk mengisi kegiatan, karena anda belum melakukan presensi masuk pada hari ini";
            return view('kegiatan', compact('cekAbsen','pesan'));
        }
        return view('kegiatan', compact('cekAbsen', 'namaBulan', 'kegiatanHari'));
    }

    public function getKegiatan(Request $request){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $activityMonth = DB::table('tb_kegiatan')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tanggal)="'.$bulan.'"')
                        ->whereRaw('YEAR(tanggal)="'.$tahun.'"')
                        ->orderBy('tanggal')
                        ->get();
        return view('getkegiatan', compact('activityMonth'));
    }

    public function formTambah(){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $today = date("Y-m-d");
        $cekJenis = DB::table('tb_presensi')
                    ->where('id_user', $id_user)
                    ->where('tgl_presensi', $today)
                    ->first();
        return view('tambahkegiatan', compact('cekJenis'));
    }

    public function tambahKegiatan(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $id_user = Auth::guard('gtk')->user()->id_user;
        $today = date("Y-m-d");
        $jam = date("H:i:s");
        $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        $folder_path_foto = "public/uploads/kegiatan/foto/";
        $folder_path_st = "public/uploads/kegiatan/foto/dinas-luar/surat-tugas/";
        $folder_path_sppd = "public/uploads/kegiatan/foto/dinas-luar/sppd/";
        $folder_path_undangan = "public/uploads/kegiatan/foto/dinas-luar/undangan/";
        $judul = $request->judul;
        $jurnal = $request->jurnal;
        // $dokFoto = $request->foto;
        // $dokST = $request->st;
        // $dokSPPD = $request->sppd;
        // $dokUndangan = $request->undangan;
        // dd($request->hasFile('foto'));
        $foto = $id_user."-".$today."-".$s.".".$request->file('foto')->getClientOriginalExtension();

        // $st = $request->st;
        // $sppd = $request->sppd;
        // $undangan = $request->undangan;

        $cekKegiatan = DB::table('tb_presensi')
        ->where('id_user', $id_user)
        ->where('tgl_presensi',$today)
        ->first();
        if($cekKegiatan->jenis_presensi == "11223"){
            $data = [
                'id_user' => $id_user,
                'judul' => $judul,
                'jurnal' => $jurnal,
                'foto' => $foto,
                'tanggal' => $today,
                'jam' => $jam
            ];
        } else if($cekKegiatan->jenis_presensi == "32211"){
            $st = $id_user."-".$today."-".$s."Surat-Tugas".".".$request->file('st')->getClientOriginalExtension();
            $sppd = $id_user."-".$today."-".$s."SPPD".".".$request->file('sppd')->getClientOriginalExtension();
            if($request->hasFile('undangan')){
                $undangan = $id_user."-".$today."-".$s."Undangan".".".$request->file('undangan')->getClientOriginalExtension();
            }
            $data = [
                'id_user' => $id_user,
                'judul' => $judul,
                'jurnal' => $jurnal,
                'foto' => $foto,
                'st' => $st,
                'sppd' => $sppd,
                'undangan' => $undangan,
                'tanggal' => $today,
                'jam' => $jam
            ];
        }

        $query = DB::table('tb_kegiatan')->where('id_user', $id_user)->insert($data);

        if($query){
            $request->file('foto')->storeAs($folder_path_foto, $foto);
            if($cekKegiatan->jenis_presensi == "32211"){
                $request->file('st')->storeAs($folder_path_st, $st);
                $request->file('sppd')->storeAs($folder_path_sppd, $sppd);
                if($request->hasFile('undangan')){
                    $request->file('foto')->storeAs($folder_path_undangan, $undangan);
                }
            }
            return redirect()->to('/kegiatan')->with(['success' => 'Terima Kasih! Data Kegiatan Sudah Ditambahkan!']);
        } else {
            return redirect()->to('/kegiatan')->with(['error' => 'Data Kegiatan Gagal Ditambahkan!']);
        }
    }

    public function detailKegiatan($id){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $detailKegiatan = DB::table('tb_kegiatan')
                ->where('id_user', $id_user)
                ->where('id', $id)
                ->first();
        return view('detailkegiatan', compact('detailKegiatan'));
    }

    public function getKegiatanGTK(){
        $title = "Data Kegiatan Harian";
        $sidebar = "3";
        $getKegiatan = DB::table('tb_kegiatan')
                        ->join('tb_gtk', 'tb_kegiatan.id_user', '=', 'tb_gtk.id_user')
                        ->select('tb_kegiatan.*', 'tb_gtk.*', 'tb_kegiatan.foto as fotoKegiatan')
                        ->where('tanggal', date('Y-m-d'))
                        ->orderBy('jam', 'desc')
                        ->get();
        return view('datakegiatan', compact('getKegiatan', 'title', 'sidebar'));
    }

    public function getAllKegiatan(Request $request){
        $title = "Data Kegiatan";
        $sidebar = "8";
        $kegiatan = DB::table('tb_kegiatan')
                    ->join('tb_gtk', 'tb_kegiatan.id_user', '=', 'tb_gtk.id_user')
                    ->select('tb_kegiatan.*', 'tb_gtk.*', 'tb_kegiatan.foto as fotoKegiatan')
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('jam', 'desc');
        if(!empty($request->nama)){
            $kegiatan->where('nama_lengkap', 'like','%'.$request->nama.'%');
        }
        $getKegiatan = $kegiatan->paginate(10);

        return view('historikegiatan', compact('getKegiatan', 'title', 'sidebar'));
    }

    public function deleteKegiatan($id){
        $kegiatan = Kegiatan::find($id);
        if($kegiatan->delete()){
            return redirect()->to('/admin/history/kegiatan')->with(['success' => 'Data Kegiatan Berhasil Dihapus']);
        } else {
            return redirect()->to('/admin/history/kegiatan')->with(['error' => 'Data Kegiatan Gagal Dihapus']);
        }
    }
}
