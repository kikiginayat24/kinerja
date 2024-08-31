<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getAdmin(){
        $title = "Data Admin";
        $sidebar = "11";
        $getAdmin = DB::table('users')
                    ->orderBy('id')
                    ->get();
        return view('admin', compact('title', 'sidebar', 'getAdmin'));
    }

    public function saveAdmin(Request $request){
        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'akses' =>$request->akses,
            'password' => Hash::make($request->password)
        ];

        $admin = DB::table('users')->insert($data);
        if($admin){
            return redirect()->to('/admin/data-admin')->with(['success' => 'Data Admin Telah Ditambah!']);
        } else {
            return redirect()->to('/admin/data-admin')->with(['error' => 'Data Admin Gagal Ditambah!']);
        }
    }

    public function updateAdmin(Request $request, $id){
        $admin = Admin::find($id);
        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'akses' =>$request->akses,
            'password' => Hash::make($request->password)
        ];
        if($admin->update($data)){
            return redirect()->to('/admin/data-admin')->with(['success' => 'Data Admin Telah Diupdate!']);
        } else {
            return redirect()->to('/admin/data-admin')->with(['error' => 'Data Admin Gagal Diupdate!']);
        }
    }

    public function deleteAdmin($id){
        $admin = Admin::find($id);
        if($admin->delete()){
            return redirect()->to('/admin/data-admin')->with(['success' => 'Data Admin Telah Dihapus!']);
        } else {
            return redirect()->to('/admin/data-admin')->with(['error' => 'Data Admin Gagal Dihapus!']);
        }
    }
}
