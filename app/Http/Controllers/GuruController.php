<?php

namespace App\Http\Controllers;

use App\Models\GTK;
use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function getGuru(){
        $dataGtk = DB::table('tb_gtk')
                    ->join('tb_pangkat', 'tb_gtk.pangkat', '=', 'tb_pangkat.kode')
                    ->select('tb_gtk.*', 'tb_pangkat.*')
                    ->orderBy('nama_lengkap')
                    ->paginate(10);
        $jenisPangkat = DB::table('tb_pangkat')
                    ->get();
        $title = "Data Guru";
        $sidebar = "10";
        return view('datagtk', compact('title', 'dataGtk', 'jenisPangkat', 'sidebar'));
    }

    public function saveGuru(Request $request){
        $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
        $pw = $s;
        $data = [
            'id_user' => $request->npa,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tmt' => $request->tmt,
            'jabatan' => $request->jabatan,
            'pangkat' => $request->pangkat,
            'password' => Hash::make($pw),
            'token' => $pw,
            'foto' => "profil.jpg"
        ];
        $query = DB::table('tb_gtk')->insert($data);
        if ($query){
            return redirect()->to('/admin/data/guru')->with(['success' => 'Data GTK Berhasil Ditambahkan']);
        } else {
            return redirect()->to('/admin/data/guru')->with(['error' => 'Data GTK Gagal Ditambahkan']);
        }
    }

    public function update(Request $request, $id_user){
        $guru = Guru::find($id_user);
        $data =[
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tmt' => $request->tmt,
            'jabatan' => $request->jabatan,
            'pangkat' => $request->pangkat,
        ];

        if($guru->update($data)){
            return redirect()->to('/admin/data/guru')->with(['success' => 'Data GTK Berhasil Diupdate']);
        } else {
            return redirect()->to('/admin/data/guru')->with(['error' => 'Data GTK Gagal Diupdate']);
        }
    }

    public function printGuru(Request $request, $id){
        $dataGuru = Guru::find($id);
        if($request->print == "80"){
            return view('print.80mm', compact('dataGuru'));
        } else if($request->print == "57") {
            return view('print.57mm', compact('dataGuru'));
        }
    }

    public function delete($id){
        $guru = Guru::find($id);
        if($guru->delete()){
            return redirect()->to('/admin/data/guru')->with(['success' => 'Data GTK Berhasil Dihapus']);
        } else {
            return redirect()->to('/admin/data/guru')->with(['error' => 'Data GTK Gagal Dihapus']);
        }
    }

    public function jadwalGuru($id){
        $guru = Guru::find($id);
        $jadwalGuru = DB::table('tb_jam_kerja')->where('id_user', $id)->get();
        $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
        $title = "Jadwal ".$guru->nama_lengkap;
        $sidebar = "10";
        return view('jadwalguru', compact('guru', 'title', 'jadwalGuru', 'hari', 'sidebar'));
    }

    public function saveJadwal(Request $request){
        $cekHari = DB::table('tb_jam_kerja')->where('id_user', $request->id_user)->where('kode_hari', $request->hari)->count();
        if(!($cekHari>0)){
            $data = [
                'id_user' => $request->id_user,
                'kode_hari' => $request->hari,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar
            ];
            $query = DB::table('tb_jam_kerja')->insert($data);
            if($query){
                return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['success' => 'Jadwal Berhasil Ditambah']);
            } else {
                return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['error' => 'Jadwal Gagal Ditambah']);
            }
        } else {
            return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['error' => 'Gagal Input Jadwal Karena Hari Yang Dimasukkan Telah Ada']);
        }
    }

    public function updateJadwal(Request $request,$id){
        $cekHari = DB::table('tb_jam_kerja')->where('id_user', $request->id_user)->where('kode_hari', $request->hari)->count();
        if(!($cekHari>0)){
            $jadwal = Jadwal::find($id);
            $data =[
                'kode_hari' => $request->hari,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
            ];

            if($jadwal->update($data)){
                return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['success' => 'Data Jadwal Berhasil Diupdate']);
            } else {
                return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['error' => 'Data Jadwal Gagal Diupdate']);
            }
        } else {
            return redirect()->to('/admin/data/guru/jadwal/'.$request->id_user)->with(['error' => 'Gagal Input Jadwal Karena Hari Yang Dimasukkan Telah Ada']);
        }
    }

    public function deleteJadwal($id){
        $jadwal = Jadwal::find($id);
        if($jadwal->delete()){
            return redirect()->to('/admin/data/guru')->with(['success' => 'Data Jadwal Berhasil Dihapus']);
        } else {
            return redirect()->to('/admin/data/guru')->with(['error' => 'Data Jadwal Gagal Dihapus']);
        }
    }
}
