<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(){
        $id_user = Auth::guard('gtk')
                ->user()
                ->id_user;
        $data = DB::table('tb_gtk')
                ->where('id_user', $id_user)
                ->first();
        return view('profile', compact('data'));
    }

    public function editProfile(){
        $id_user = Auth::guard('gtk')
                ->user()
                ->id_user;
        $data = DB::table('tb_gtk')
                ->where('id_user', $id_user)
                ->first();
        return view('editprofile', compact('data'));
    }

    public function saveProfile(Request $request){
        $id_user = Auth::guard('gtk')->user()->id_user;
        $ttl = $request->ttl;
        $jk = $request->jk;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $data = DB::table('tb_gtk')
                ->where('id_user', $id_user)
                ->first();
        $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        if (!(($request->image) == "data:," )){
            // $foto = $id_user.".".$request->file('foto')->getClientOriginalName().".".$request->file('foto')->getClientOriginalExtension();
            $image = $request->image;
            $folderPath = "public/uploads/foto_gtk/";
            $formatName = $id_user."-".$s."-"."Profil";
            $image_parts = explode(";base64", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $formatName.".png";
            $foto = $folderPath.$fileName;

        } else {
            $fileName = $data->foto;
        }
        if(empty($request->password)){
            $update = [
                'id_user' => $id_user,
                'ttl' => $ttl,
                'jk' => $jk,
                'no_hp' => $no_hp,
                'foto' => $fileName
            ];
        } else {
            $update = [
                'id_user' => $id_user,
                'ttl' => $ttl,
                'jk' => $jk,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $fileName
            ];
        }
        // echo($request->image);
        $query = DB::table('tb_gtk')->where('id_user', $id_user)->update($update);
        if ($query){
            if(!(($request->image) == "data:," )){
                // $request->file('foto')->storeAs($folderPath, $foto);
                // dd($image_base64);
                Storage::put($foto,$image_base64);
            }
            echo "success|Terima Kasih! Data Profil Sudah Diupdate!|out";
        } else {
            echo "error|Data Profil Gagal Diupdate!|out";
        }
    }
}
