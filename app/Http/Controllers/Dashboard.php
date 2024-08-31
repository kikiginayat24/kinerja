<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Command\WhereamiCommand;

class Dashboard extends Controller{
    public function index(){
        $today = date("Y-m-d");
        $thisMonth = date("m");
        $thisYear = date("Y");
        $id_user = Auth::guard('gtk')->user()->id_user;
        $presensiToday = DB::table('tb_presensi')->where('id_user', $id_user)->where('tgl_presensi', $today)->first();
        $historyMonth = DB::table('tb_presensi')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
                        ->orderBy('tgl_presensi')
                        ->get();
        $rekapPresensi = DB::table('tb_presensi')
                        ->selectRaw('COUNT(status_presensi) as jumlahHadir')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
                        ->first();
        $rekapTelat = DB::table('tb_presensi')
                        ->selectRaw('COUNT(id_user) as jumlahTelat')
                        ->where('id_user', $id_user)
                        ->where('status_presensi', 'TELAT')
                        ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
                        ->first();
        $rekapIzin = DB::table('tb_presensi')
                        ->where('izin', 'IZIN')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
                        ->count();
        $rekapSakit = DB::table('tb_presensi')
                        ->where('izin', 'SAKIT')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
                        ->count();
        $namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('dashboard', compact('presensiToday', 'historyMonth', 'namaBulan', 'thisMonth', 'thisYear', 'rekapPresensi', 'rekapTelat', 'rekapIzin', 'rekapSakit'));
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

    // admin
    public function adminDashboard(){
        $jumlahGuru = DB::table('tb_gtk')
                        ->join('tb_jam_kerja', 'tb_gtk.id_user','=','tb_jam_kerja.id_user')
                        ->select('tb_gtk.*', 'tb_jam_kerja.*')
                        ->where('kode_hari', date('w'))
                        ->count();
        $jumlahHadir = DB::table('tb_presensi')
                        ->where('tgl_presensi', date("Y-m-d"))
                        ->count();
        $jumlahTelat = DB::table('tb_presensi')
                        ->where('tgl_presensi', date("Y-m-d"))
                        ->where('status_presensi', 'TELAT')
                        ->count();
        $jumlahDinasDalam = DB::table('tb_presensi')
                        ->where('tgl_presensi', date("Y-m-d"))
                        ->where('jenis_presensi', '11223')
                        ->count();
        $jumlahDinasLuar = DB::table('tb_presensi')
                        ->where('tgl_presensi', date("Y-m-d"))
                        ->where('jenis_presensi', '32211')
                        ->count();
        $jumlahPresensiKeluar = DB::table('tb_presensi')
                        ->where('tgl_presensi', date("Y-m-d"))
                        ->whereNotNull('jam_keluar')
                        ->count();
        $jumlahSakit = DB::table('tb_presensi')
                        ->where('tgl_presensi', date('Y-m-d'))
                        ->where('izin', 'SAKIT')
                        ->count();
        $jumlahIzin = DB::table('tb_presensi')
                        ->where('tgl_presensi', date('Y-m-d'))
                        ->where('izin', 'IZIN')
                        ->count();
        $jumlahCuti = DB::table('tb_presensi')
                        ->where('tgl_presensi', date('Y-m-d'))
                        ->where('izin', 'CUTI')
                        ->count();
        $title = "Dashboard";
        $sidebar = "1";
        return view('dashboardadmin', compact('title', 'jumlahHadir', 'jumlahGuru', 'jumlahTelat', 'jumlahDinasDalam', 'jumlahDinasLuar', 'jumlahPresensiKeluar', 'jumlahSakit', 'jumlahIzin', 'jumlahCuti', 'sidebar'));
    }
}
