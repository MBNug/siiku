<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(Auth::user()){
            return redirect()->intended('Dashboard');
        }

        return view('login.view_login');
    }
    public function proses(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],
            [
                'username.required' => 'username tidak boleh kosong',
            ]
        );

        $kredensial = $request->only('username','password');

        if(Auth::attempt($kredensial)){
            $request->session()->regenerate();
            $user = Auth::user();

            if($user){
                return redirect()->intended('/renstra/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'maaf username atau password anda salah'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
