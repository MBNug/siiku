<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Target;
use App\Models\config;
use App\Models\Strategi;
use App\Models\Indikator;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departemens = Departemen::where('kode', '<>', '00')->get();
        $title = 'Realisasi Departemen ';
        return view('renstra.realisasi.index', compact('departemens','title')) ->with([
            'user'=> Auth::user()
        ]);
    }


    /**
     * mendisplay tabel target sesuai dengan departemen.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRealisasi($renstradept)
    {   
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        // dd($actConfig);
        if($actConfig===null){
            Alert::error('Gagal!', "Config Tahun Belum diatur");
            return redirect()->back();
        }else{
            $namadept = DB::table('departemens') -> where('kode', '=', $renstradept)->first();
            $targets = DB::table('targets') -> where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
            $errmsg1="Indikator Departemen ".$namadept->nama.' untuk tahun '.$actConfig->tahun.' belum diatur pihak fakultas.';
            if($targets->count()==0){
                Alert::error('Data Belum Tersedia', $errmsg1);
                return redirect()->back();
            }
            $targetsNotApproved = DB::table('targets') -> where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> where('status', '!=', '1')-> get();
            $errmsg2="Indikator Departemen ".$namadept->nama.' untuk tahun '.$actConfig->tahun.' belum disetujui pihak fakultas.';
            if($targetsNotApproved->count()>0){
                Alert::error('Data Belum Tersedia', $errmsg2);
                return redirect()->back();
            }
            else{
                $realisasis = DB::table('realisasis') -> where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
                $t= $namadept->nama." ".$actConfig->tahun;
                $title = 'Realisasi Departemen '.$t;
                if($realisasis->count()==0){
                    return view('renstra.realisasi.uncreate', compact('title', 'renstradept')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
                else{
                    $departemens = Departemen::all();
                    return view('renstra.realisasi.realisasi', compact('realisasis', 'departemens', 'title', 'renstradept')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRealisasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($renstradept, StoreTargetRequest $request)
    {
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $targets = DB::table('targets') -> where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
        foreach($targets as $target){
            // $kode = $renstradept.$indikator->kode;
            DB::statement("INSERT INTO realisasis (kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan, target) SELECT kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan,target FROM targets where kode='$target->kode'");
        }
        $namadept = DB::table('departemens') -> where('kode', '=', $renstradept)->first();
        Alert::success('Berhasil!', 'Realisasi Berhasil dibuat');
        return redirect()->back();
        // $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        // $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // // dd($indikatorlama);
        // $jmlindikatorlama = count($indikatorlama);
        // $errmsg = 'Config Indikator untuk tahun '.$tahun->tahun.' belum diatur.';
        // if($jmlindikatorlama==0){
        //     Alert::error('Gagal!', $errmsg);
        //     return redirect()->back();
        // }else{
        // return redirect(route('renstra.target.index', $renstradept));
    // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function show(Realisasi $realisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Realisasi $realisasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRealisasiRequest  $request
     * @param  \App\Models\Realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRealisasiRequest $request, Realisasi $realisasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Realisasi $realisasi)
    {
        //
    }
}
