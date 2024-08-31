<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest:gtk'])->group(function (){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login',[AuthController::class, 'login']);
});

Route::middleware(['guest:user'])->group(function (){
    Route::get('/admin', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/loginadmin',[AuthController::class, 'loginAdmin']);
});

Route::middleware(['auth:gtk'])->group(function(){
    Route::get('/dashboard', [Dashboard::class, 'index']);
    Route::get('/presensi/create',[PresensiController::class, 'create']);
    Route::post('/presensi/save', [PresensiController::class, 'store'])->name('presensi.save');
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/profile/edit', [ProfileController::class, 'editProfile']);
    Route::post('/profile/edit/save/{id_user}', [ProfileController::class, 'saveProfile']);
    Route::get('/history', [HistoryController::class, 'index']);
    Route::post('/history/get', [HistoryController::class, 'getHistory']);
    Route::get('/kegiatan', [KegiatanController::class, 'index']);
    Route::post('/kegiatan/get', [KegiatanController::class, 'getKegiatan']);
    Route::get('/kegiatan/tambah', [KegiatanController::class, 'formTambah']);
    Route::get('/kegiatan/detail/{id}', [KegiatanController::class, 'detailKegiatan'])->name('kegiatan.detail');
    Route::post('/kegiatan/tambah/save', [KegiatanController::class, 'tambahKegiatan']);
    Route::get('/izin',[IzinController::class, 'index']);
    Route::get('/izin/tambah',[IzinController::class, 'tambah']);
    Route::post('/izin/tambah/save',[IzinController::class, 'save']);
    Route::get('/cuti',[CutiController::class, 'index']);
    Route::get('/cuti/tambah',[CutiController::class, 'tambahCuti']);
    Route::post('/cuti/tambah/save',[CutiController::class, 'simpanCuti']);

    Route::get('/logout',[AuthController::class, 'logout']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/admin/dashboard', [Dashboard::class, 'adminDashboard']);
    Route::get('/admin/data/presensiHarian', [PresensiController::class, 'getPresensiHarian']);
    Route::get('/admin/data/presensi', [PresensiController::class, 'getPresensi']);
    Route::get('/admin/data/presensi/delete/{id}', [PresensiController::class, 'deletePresensi'])->name('presensi.delete');

    Route::get('/admin/data/guru', [GuruController::class, 'getGuru']);
    Route::post('/admin/data/guru/save', [GuruController::class, 'saveGuru']);
    Route::get('/admin/data/guru/jadwal/{id_user}', [GuruController::class, 'jadwalGuru'])->name('guru.jadwal');
    Route::get('/admin/data/guru/print/{id_user}', [GuruController::class, 'printGuru'])->name('guru.print');
    Route::get('/admin/data/guru/delete/{id_user}', [GuruController::class, 'delete'])->name('guru.delete');
    Route::post('/admin/data/guru/update/{id_user}', [GuruController::class, 'update'])->name('guru.update');
    Route::post('/admin/data/guru/jadwal/save', [GuruController::class, 'saveJadwal'])->name('jadwal.tambah');
    Route::post('/admin/data/guru/jadwal/update/{id}', [GuruController::class, 'updateJadwal'])->name('jadwal.update');
    Route::get('/admin/data/guru/jadwal/delete/{id}', [GuruController::class, 'deleteJadwal'])->name('jadwal.delete');

    Route::get('/admin/pengajuan/izin', [PresensiController::class, 'getIzin']);
    Route::post('/admin/pengajuan/izin/update/{id}', [PresensiController::class, 'updateIzin'])->name('izin.update');

    Route::get('/admin/history/izin', [PresensiController::class, 'getAllIzin']);
    Route::get('/admin/history/izin/delete/{id}', [PresensiController::class, 'deleteIzin'])->name('izin.delete');

    Route::get('/admin/data/kegiatan', [KegiatanController::class, 'getKegiatanGTK']);
    Route::get('/admin/history/kegiatan', [KegiatanController::class, 'getAllKegiatan']);
    Route::get('/admin/history/kegiatan/delete/{id}', [KegiatanController::class, 'deleteKegiatan'])->name('kegiatan.delete');

    Route::get('/admin/data/cuti', [CutiController::class, 'getPengajuanCuti']);
    Route::post('/admin/data/cuti/update/{id}', [CutiController::class, 'updateCuti'])->name('cuti.update');
    Route::get('/admin/history/cuti', [CutiController::class, 'getCuti']);
    Route::get('/admin/history/cuti/delete/{id}', [CutiController::class, 'deleteCuti'])->name('cuti.delete');
    
    Route::get('/admin/data-admin', [AdminController::class, 'getAdmin']);
    Route::post('/admin/data-admin/save', [AdminController::class, 'saveAdmin']);
    Route::post('/admin/data-admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update');
    Route::get('/admin/data-admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.delete');



    Route::get('/admin/logout', [AuthController::class, 'logoutAdmin']);
});
