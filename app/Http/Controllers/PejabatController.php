<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use App\Models\Departemen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StorePejabatRequest;
use App\Http\Requests\UpdatePejabatRequest;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pejabats = Pejabat::all();
        

        return view('config.pejabat.index', compact('pejabats')) ->with([
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
        $departemens = Departemen::all();
        return view('config.pejabat.create', compact('departemens'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePejabatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePejabatRequest $request)
    {
        //
        $kode = ''.$request->departemen.$request->jabatan;
        $departemen = Departemen::where('kode', '=', $request->departemen)->pluck('nama');
        $pejabat = Pejabat::where('kode', '=', $kode)-> first();
        $jabatan = substr($request->jabatan, 0,2);
        // dd(strcmp($jabatan, '99'));
        if(strcmp($jabatan, '01') == 0){
            $jabatan = "Kepala Departemen ".$departemen[0];
        }
        elseif(strcmp($jabatan, '02') == 0){
            $jabatan = "Admin Operator Departemen ".$departemen[0];
        }
        elseif(strcmp($jabatan, '99') == 0){
            $jabatan = "Dekan";
        }
        elseif(strcmp($jabatan, '98') == 0){
            $jabatan = "Wakil Dekan 1";
        }
        elseif(strcmp($jabatan, '97') == 0){
            $jabatan = "Wakil Dekan 2";
        }
        elseif(strcmp($jabatan, '96') == 0){
            $jabatan = "Wakil Dekan 3";
        }
        elseif(strcmp($jabatan, '95') == 0){
            $jabatan = "Wakil Dekan 4";
        }
        elseif(strcmp($jabatan, '94') == 0){
            $jabatan = "Admin Operator Fakultas";
        }
        $request->validate([
            'departemen' => 'required',
            'jabatan' => 'required',
            'nama' => 'required',
            'nip' => 'required|numeric',
            'tandatangan' => 'required|max:2048',
        ]);


        $request->request->add(['kode' => ''.$kode]);
        $request->merge(['departemen' => ''.$departemen[0]]);
        $request->merge(['jabatan' => ''.$jabatan]);

        if($pejabat == null){
            $pejabatnew = new Pejabat;
            $pejabatnew->kode = $request->kode;
            $pejabatnew->departemen = $request->input('departemen');
            $pejabatnew->jabatan = $request->input('jabatan');
            $pejabatnew->nama = $request->input('nama');
            $pejabatnew->nip = $request->input('nip');
            $pejabatnew->tandatangan = $request->file('tandatangan')->store('tandatangan', 'public');
            $pejabatnew->save();
            Alert::success('Berhasil!', 'Pejabat baru berhasil ditambahkan');
            return redirect(route('pejabat.index'));
        }
        else{
            Alert::error('Gagal!', 'Pejabat untuk jabatan ini telah diatur.');
            return redirect(route('pejabat.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pejabat  $pejabat
     * @return \Illuminate\Http\Response
     */
    public function show(Pejabat $pejabat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pejabat  $pejabat
     * @return \Illuminate\Http\Response
     */
    public function edit(Pejabat $pejabat)
    {
        //
        // dd($pejabat);
        $departemens = Departemen::all();
        return view('config.pejabat.edit', compact('pejabat', 'departemens'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePejabatRequest  $request
     * @param  \App\Models\Pejabat  $pejabat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePejabatRequest $request, Pejabat $pejabat)
    {
        //
        $request->validate([
            'departemen' => 'required',
            'jabatan' => 'required',
            'nama' => 'required',
            'nip' => 'required',
            'tandatangan' => 'required|max:2048',
        ]);

        $pejabat->update($request->all());
        Alert::success('Berhasil!', 'Pejabat berhasil diupdate');
        return redirect(route('pejabat.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pejabat  $pejabat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pejabat $pejabat)
    {
        //
    }
}
