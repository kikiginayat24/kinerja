<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(){
        $bulan = date("m");
        $tahun = date("Y");
        $id_user = Auth::guard('gtk')->user()->id_user;
        $historyMonth = DB::table('tb_presensi')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
                        ->orderBy('tgl_presensi')
                        ->get();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('history', compact('namaBulan', 'historyMonth'));
    }

    public function getHistory(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_user = Auth::guard('gtk')->user()->id_user;
        $historyMonth = DB::table('tb_presensi')
                        ->where('id_user', $id_user)
                        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
                        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
                        ->orderBy('tgl_presensi')
                        ->get();
        return view('gethistory', compact('historyMonth'));
    }
}
