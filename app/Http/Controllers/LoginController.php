<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    

    public function index(){
        return view('login');
    }
    
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('LoginError', 'Login Failed!');
    }

    public function logout(Request $request){
        Auth::logout(); // Lakukan proses logout user

        $request->session()->invalidate(); // Invalidasi session
        $request->session()->regenerateToken(); // Regenerasi CSRF token
        $request->session()->flush(); // Hapus semua data session

        // Redirect ke halaman login dengan pesan logout
        return redirect('/')->with('logoutMessage', 'You have been logged out.');
    }
}
