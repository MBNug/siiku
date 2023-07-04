<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;
use App\Models\User;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departemens = Departemen::where('kode', '<>', '00')->get();
        

        return view('config.departemen.index', compact('departemens')) ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('config.departemen.create') ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartemenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartemenRequest $request)
    {
        //
        $dep = Departemen::where('kode', '=', $request->kode)->first();
        // dd($dep);
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);
        if($dep === null){
            $newuser1 = [
                'kode' => $request->kode.'01',
                'name' => "Kadep ".$request->nama, 
                'username' => "kadep".$request->nama, 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadep".$request->nama."@gmail.com", 
            ];
            $newuser2 = [
                'kode' => $request->kode.'00',
                'name' => "Administrator ".$request->nama, 
                'username' => "admin".$request->nama, 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "admin".$request->nama."@gmail.com", 
            ];
            User::create($newuser1);
            User::create($newuser2);
            Departemen::create($request->all());
            Alert::success('Berhasil!', 'Departemen baru berhasil ditambahkan');
            return redirect(route('departemen.index'));
        }
        else{
            Alert::error('Gagal!', 'Kode untuk departemen ini sudah ada.');
            return redirect(route('departemen.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function edit(Departemen $departeman)
    {
        //
        // dd($departemen->kode);
        return view('config.departemen.edit', compact('departeman'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartemenRequest  $request
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departeman)
    {
        //
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);
        $departeman->update($request->all());
        Alert::success('Berhasil!', 'Departemen berhasil diupdate');
        return redirect(route('departemen.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departemen $departeman)
    {
        //
    }
}
