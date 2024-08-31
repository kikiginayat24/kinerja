<?php

namespace App\Http\Controllers;

// use Illuminate\Container\Attributes\Storage;

use App\Models\Izin;
use App\Models\Presensi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{

    public function create(){
        $tanggal = date("Y-m-d");
        $id_user = Auth::guard('gtk')->user()->id_user;
        $cek_presensi = DB::table('tb_presensi')->where('tgl_presensi', $tanggal)->where('id_user', $id_user)->whereNull('izin')->count();
        // dd($cek_presensi);
        return view('presensi.create', compact('cek_presensi'));
    }

    public function store(Request $request){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $jenis_presensi = $request->jenis_presensi;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $coordinate = explode(",", $lokasi);
        $lat = $coordinate[0];
        $lon = $coordinate[1];
        $latKantor = -6.981878;
        $lonKantor = 107.829737;
        $jadwal = DB::table('tb_jam_kerja')
                ->where('id_user', $id_user)
                ->where('kode_hari', date('w'))
                ->first();
        $cekJadwal = DB::table('tb_jam_kerja')
                    ->where('id_user', $id_user)
                    ->where('kode_hari', date('w'))
                    ->count();
        $cekIzin = DB::table('tb_presensi')
                    ->where('tgl_presensi', date('Y-m-d'))
                    ->whereNotNull('izin')
                    ->count();
        if($cekJadwal<1 && $jenis_presensi == "11223"){
            echo "error|Anda Tidak Diperkenankan Untuk Absen, Karena Tidak Ada Jadwal Hari Ini!";
        } else if($cekIzin>0) {
            echo "error|Anda Tidak Diperkenankan Untuk Absen, Karena Anda Memiliki Izin, Sakit, atau Cuti Pada Hari Ini";
        } else if($jenis_presensi == "11223") {
            $jam_masuk  = strtotime($jadwal->jam_masuk);
            $jam_datang = strtotime(date('H:i:s'));
            $selisih  = $jam_datang - $jam_masuk;
        }
        $radius = $this->radiusPresensi($latKantor,$lonKantor,$lat,$lon);
        $lokasiPresensi = round($radius['meters']);
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $cek_presensi = DB::table('tb_presensi')->where('tgl_presensi', $tgl_presensi)->where('id_user', $id_user)->whereNull('izin')->count();
        $cekAbsenMasuk = DB::table('tb_presensi')->where('tgl_presensi', $tgl_presensi)->where('id_user', $id_user)->whereNotNull('jam_masuk')->count();
        // dd(DB::table('tb_kegiatan')->where('id_user', $id_user)->where('tanggal',$tgl_presensi)->count() < 1);
        // dd($cekAbsenMasuk>0);
        if ($jenis_presensi == "11223" && $cekIzin<=0){ //Dinas Dalam
            if($lokasiPresensi > 10000000){
                echo "error|Radius Tidak Terjangkau, Jarak Anda ".$lokasiPresensi." Meter dari Kantor";
            } else if ((DB::table('tb_presensi')->where('tgl_presensi', $tgl_presensi)->whereNotNull('jam_keluar')->where('id_user', $id_user)->count())>0){
                echo "error|Anda Sudah Presensi";
            } else if($cekAbsenMasuk>0 && DB::table('tb_kegiatan')->where('id_user', $id_user)->where('tanggal',$tgl_presensi)->count() < 1){
                echo "error|Anda Belum Mengisi Kegiatan";
            } else if($cekJadwal<1){
                echo "error|Anda Tidak Diperkenankan Untuk Absen, Karena Tidak Ada Jadwal Hari Ini!";
            } else {
                if ($cek_presensi > 0){
                    $formatName = $id_user."-".$tgl_presensi."-Pulang";
                } else {
                    $formatName = $id_user."-".$tgl_presensi."-Masuk";
                }
                $image_parts = explode(";base64", $image);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $formatName.".png";
                $file = $folderPath.$fileName;
                if ($cek_presensi > 0){
                    $data = [
                        'jam_keluar' => $jam,
                        'foto_keluar' => $fileName,
                        'location_out' => $lokasi
                    ];
                    $query = DB::table('tb_presensi')->where('tgl_presensi',$tgl_presensi)->where('id_user',$id_user)->update($data);
                    if($query){
                        echo "success|Terima Kasih! Data Presensi Sudah Diinput!|out";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Data Presensi Gagal Diinput!|out2";
                    }
                } else {
                    if($selisih>0){
                        $status_telat = "TELAT";
                        $telat = "Walaupun Telat";
                    } else {
                        $status_telat = "TEPAT";
                        $telat = "Anda Tepat Waktu";
                    }
                    $data = [
                        'id_user' => $id_user,
                        'jenis_presensi' => $jenis_presensi,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_masuk' => $jam,
                        'foto_masuk' => $fileName,
                        'status_presensi' => $status_telat,
                        'location_in' => $lokasi,
                    ];
                    $query = DB::table('tb_presensi')->insert($data);
                    if($query){
                        echo "success|Terima Kasih! Data Presensi Sudah Diinput! ".$telat."|out";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Data Presensi Gagal Diinput!|out4";
                    }
                }
            }
        } else if ($jenis_presensi = "32211" && $cekIzin<=0){ // Dinas Luar
            if ((DB::table('tb_presensi')->where('tgl_presensi', $tgl_presensi)->whereNotNull('jam_keluar')->where('id_user', $id_user)->count())>0){
                echo "error|Anda Sudah Presensi";
            } else if($cekAbsenMasuk>0 && DB::table('tb_kegiatan')->where('id_user', $id_user)->where('tanggal',$tgl_presensi)->count() < 1){
                echo "error|Anda Belum Mengisi Kegiatan";
            } else {
                if ($cek_presensi > 0){
                    $formatName = $id_user."-".$tgl_presensi."-Pulang";
                } else {
                    $formatName = $id_user."-".$tgl_presensi."-Masuk";
                }
                $image_parts = explode(";base64", $image);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $formatName.".png";
                $file = $folderPath.$fileName;
                if ($cek_presensi > 0){
                    $data = [
                        'jam_keluar' => $jam,
                        'foto_keluar' => $fileName,
                        'location_out' => $lokasi
                    ];
                    $query = DB::table('tb_presensi')->where('tgl_presensi',$tgl_presensi)->where('id_user',$id_user)->update($data);
                    if($query){
                        echo "success|Terima Kasih! Data Presensi Sudah Diinput!|out";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Data Presensi Gagal Diinput!|out";
                    }
                } else {
                    $data = [
                        'id_user' => $id_user,
                        'jenis_presensi' => $jenis_presensi,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_masuk' => $jam,
                        'foto_masuk' => $fileName,
                        'status_presensi' => 'TEPAT',
                        'location_in' => $lokasi,
                    ];
                    $query = DB::table('tb_presensi')->insert($data);
                    if($query){
                        echo "success|Terima Kasih! Data Presensi Sudah Diinput!|out";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Data Presensi Gagal Diinput!|out";
                    }
                }
            }
        }
    }

    public function radiusPresensi($lat1, $lon1, $lat2, $lon2){
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1))*sin(deg2rad($lat2)))+(cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function radius(Request $request){
        $lat = $request->latitude;
        $lon = $request->longitude;
        $latKantor = -6.981878;
        $lonKantor = 107.829737;
        $radius = $this->radiusPresensi($latKantor,$lonKantor,$lat,$lon);
        return compact('radius');
    }

    public function getPresensi(Request $request){
        $presensi = DB::table('tb_presensi')
                        ->join('tb_gtk', 'tb_gtk.id_user', '=', 'tb_presensi.id_user')
                        ->select('tb_presensi.*', 'tb_gtk.*')
                        ->orderBy('tgl_presensi', 'desc')
                        ->orderBy('jam_masuk', 'desc');
        if(!empty($request->nama)){
            $presensi->where('nama_lengkap', 'like','%'.$request->nama.'%');
        }
        if(!empty($request->pangkat)){
            $presensi->where('pangkat', $request->pangkat);
        }
        // if(!empty($request->pagination)){
        //     $dataPresensi = $presensi->paginate($request->pagination);
        // } else {
        //     $dataPresensi = $presensi->paginate(5);
        // }
        $dataPresensi = $presensi->paginate(10);
        $jenisPangkat = DB::table('tb_pangkat')
                        ->get();
        $title = "Data Presensi";
        $sidebar = "6";
        return view('datapresensi', compact('title', 'dataPresensi', 'jenisPangkat', 'sidebar'));
    }

    public function getPresensiHarian(Request $request){
        $today = date("Y-m-d");
        $presensi = DB::table('tb_presensi')
                        ->join('tb_gtk', 'tb_gtk.id_user', '=', 'tb_presensi.id_user')
                        ->select('tb_presensi.*', 'tb_gtk.*')
                        ->where("tgl_presensi", $today)
                        ->orderBy('jam_masuk', 'desc');
        if(!empty($request->nama)){
            $presensi->where('nama_lengkap', 'like','%'.$request->nama.'%');
        }
        $dataPresensi = $presensi->paginate(10);
        $title = "Data Presensi Harian";
        $sidebar = "2";
        return view('datapresensiharian', compact('title', 'dataPresensi', 'sidebar'));
    }

    public function deletePresensi($id){
        $presensi = Presensi::find($id);
        if($presensi->delete()){
            return redirect()->to('/admin/data/presensi')->with(['success' => 'Data Presensi Berhasil Dihapus']);
        } else {
            return redirect()->to('/admin/data/presensi')->with(['error' => 'Data Presensi Gagal Dihapus']);
        }
    }

    public function getIzin(){
        $title = "Data Pengajuan Izin";
        $sidebar = "4";
        $getIzin = DB::table('tb_izin')
                    ->join('tb_gtk', 'tb_gtk.id_user', '=', 'tb_izin.id_user')
                    ->select('tb_izin.*', 'tb_gtk.*')
                    ->orderBy('tb_izin.id', 'desc')
                    ->where('status_approved', '12')
                    ->get();
        return view('pengajuanizin', compact('title', 'getIzin', 'sidebar'));
    }

    public function updateIzin(Request $request, $id){
        $cekIzin = DB::table('tb_izin')
                    ->where('id', $id)
                    ->first();
        if($cekIzin->tgl_akhir == NULL && $request->status == "13"){
            $data = [
                'id_user' => $request->id_user,
                'tgl_presensi' => $request->tgl_awal,
                'izin' => strtoupper($request->alasan)
            ];
            DB::table('tb_presensi')->insert($data);
        } else if(!($cekIzin->tgl_akhir == NULL) && $request->status == "13") {
            $tgl_awal = strtotime($request->tgl_awal);
            $tgl_akhir = strtotime($request->tgl_akhir);
            for ( $i = $tgl_awal; $i <= $tgl_akhir; $i = $i + 86400 ) {
                $thisDate = date( 'Y-m-d', $i );
                $data = [
                    'id_user' => $request->id_user,
                    'tgl_presensi' => $thisDate,
                    'izin' => strtoupper($request->alasan)
                ];
                DB::table('tb_presensi')->insert($data);
            }
        }
        $data = [
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'status_approved' => $request->status,
        ];
        $izin = Izin::find($id);
        if($izin->update($data)){
            return redirect()->to('/admin/pengajuan/izin')->with(['success' => 'Data Izin Berhasil Diubah, dan Tidak Dapat Diubah Kembali']);
        } else {
            return redirect()->to('/admin/pengajuan/izin')->with(['error' => 'Data Izin Gagal Diubah']);
        }
    }

    public function getAllIzin(Request $request){
        $title = "Data Izin";
        $sidebar = "7";
        $izin = DB::table('tb_izin')
                    ->join('tb_gtk', 'tb_gtk.id_user', '=', 'tb_izin.id_user')
                    ->select('tb_izin.*', 'tb_gtk.*')
                    ->orderBy('tb_izin.id', 'desc');
        if(!empty($request->nama)){
            $izin->where('nama_lengkap', 'like','%'.$request->nama.'%');
        }
        $getIzin = $izin->paginate(10);
        return view('dataizin', compact('title', 'getIzin', 'sidebar'));
    }

    public function deleteIzin($id){
        $izin = Izin::find($id);
        if($izin->delete()){
            return redirect()->to('/admin/history/izin')->with(['success' => 'Data Presensi Berhasil Dihapus']);
        } else {
            return redirect()->to('/admin/history/izin')->with(['error' => 'Data Presensi Gagal Dihapus']);
        }
    }
}
