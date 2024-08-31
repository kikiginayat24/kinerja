<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::guard('gtk')->attempt(['id_user'=>$request->user, 'password'=>$request->password])){
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'NPA-PGRI atau Password Salah']);
        }
    }

    public function logout(){
        if(Auth::guard('gtk')->check()){
            Auth::guard('gtk')->logout();
            return redirect('/');
        }
    }

    public function loginAdmin(Request $request){
        if(Auth::guard('user')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('/admin/dashboard');
        } else {
            return redirect('/admin')->with(['warning' => 'E-mail atau Password Salah']);
        }
    }

    public function logoutAdmin (){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/admin');
        }
    }
}
