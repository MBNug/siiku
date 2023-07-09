<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $departemens = Departemen::where('kode', '<>', '00')->get();
        $title = 'Ganti Password ';
        return view('user.gantiPassword', compact('title')) ->with([
            'user'=> Auth::user()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateUserRequest $request){
        $user = Auth::user();
        $request->validate([
            'passwordlama' => 'required',
            'passwordbaru' => 'required',
            'konfirmasipassword' => 'required'
        ],
        [
            'passwordlama.required' => 'tidak boleh kosong',
            'passwordbaru.required' => 'tidak boleh kosong',
            'konfirmasipassword.required' => 'tidak boleh kosong',
            ]
        );
        $passwordlama = $request->passwordlama;
        // dd();
        if(Hash::check($passwordlama, $user->password)){
            $passwordbaru= $request->passwordbaru;
            $konfirmasipassword= $request->konfirmasipassword;
            if($passwordbaru!=$passwordlama){
                if($passwordbaru==$konfirmasipassword){
                    $newpass=bcrypt($konfirmasipassword);
                    DB::statement("UPDATE users SET password = '$newpass' where id='$user->id'");    
                    Alert::success('Berhasil!', 'Password Berhasil dirubah');
                    return redirect()->intended('/renstra/dashboard');
                }else{
                    return back()->withErrors([
                        'konfirmasipassword' => 'maaf konfirmasi password tidak cocok dengan password baru'
                    ])->onlyInput('passwordlama','passwordbaru');
                }
            }else{
                return back()->withErrors([
                    'passwordbaru' => 'maaf Password baru tidak boleh sama dengan password lama'
                ])->onlyInput('passwordlama');
            }
        }else{
            return back()->withErrors([
                'passwordlama' => 'maaf Password lama anda salah'
            ])->onlyInput('passwordlama','passwordbaru','konfirmasipassword');
        }
        // dd($user->password);
    }
}
