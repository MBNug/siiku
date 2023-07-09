<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreRealisasiRequest;
use App\Http\Requests\UpdateRealisasiRequest;

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
                $realisasis = Realisasi::where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                // dd($realisasis);
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
    public function store($renstradept, StoreRealisasiRequest $request)
    {
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $targets = DB::table('targets') -> where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
        foreach($targets as $t){
            // $kode = $renstradept.$indikator->kode;
            DB::statement("INSERT INTO realisasis (kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan, target) SELECT kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan, target FROM targets where kode='$t->kode'");
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
    public function update(UpdateRealisasiRequest $request, Departemen $departemen, Realisasi $realisasi)
    {
        //
        $request->validate([
            'nilai' => 'required',
            'files.*' => 'required'
        ]);
        $datarealisasi = 
        [
            'kode' => ''.$realisasi->kode,
            'strategi' => ''.$realisasi->strategi,
            'indikator_kinerja' => ''.$realisasi->indikator_kinerja,
            'satuan' => ''.$realisasi->satuan,
            'keterangan' => ''.$realisasi->keterangan,
            'definisi' => ''.$realisasi->definisi,
            'cara_perhitungan' => ''.$realisasi->cara_perhitungan,
            'target' => ''.$realisasi->target,
            'nilai' => ''.$request->nilai,
        ];
        $realisasi->update($datarealisasi);

        if ($request->hasFile('files')) {
            $files = $request->file('files');

            if (count($files) <= 5) {
                foreach ($files as $key => $file) {
                    if ($file->getSize() > 5 * 1024 * 1024) {
                        Alert::error('Error!', 'Ukuran File Maksimal 5MB');
                        return redirect()->back();
                    }
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/'.$realisasi->kode, $originalName, 'public');
                    $datarealisasi['bukti'.($key + 1)] = $path;
                }
            } else {
                Alert::error('Error!', 'Hanya bisa mengunggah sampai dengan 5 file.');
                return back();
            }

        }
        $realisasi->update($datarealisasi);
        Alert::success('Berhasil!', 'Data Realisasi berhasil disimpan');
        return redirect(route('renstra.realisasidepartemen', $departemen->kode));
    }

    public function update2(UpdateRealisasiRequest $request, Departemen $departemen, Realisasi $realisasi)
    {
        //
        $request->validate([
            'status' => 'required',
            'nilaireal' => 'required'
        ]);
        $datarealisasi = 
        [
            'kode' => ''.$realisasi->kode,
            'strategi' => ''.$realisasi->strategi,
            'indikator_kinerja' => ''.$realisasi->indikator_kinerja,
            'satuan' => ''.$realisasi->satuan,
            'keterangan' => ''.$realisasi->keterangan,
            'definisi' => ''.$realisasi->definisi,
            'cara_perhitungan' => ''.$realisasi->cara_perhitungan,
            'target' => ''.$realisasi->target,
            'nilai' => $realisasi->nilai,
            'bukti1' => $realisasi->bukti1,
            'bukti2' => $realisasi->bukti2,
            'bukti3' => $realisasi->bukti3,
            'bukti4' => $realisasi->bukti4,
            'bukti5' => $realisasi->bukti5,
            'status' => $request->status,
            'nilaireal' => $request->nilaireal,
        ];

        // dd($datarealisasi);
        $realisasi->update($datarealisasi);

        Alert::success('Berhasil!', 'Data Realisasi berhasil disimpan');
        return redirect(route('renstra.realisasidepartemen', $departemen->kode));
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

    public function form(Departemen $departemen, Realisasi $realisasi){
        $files = 
        [
            'bukti1' => $realisasi->bukti1,
            'bukti2' => $realisasi->bukti2,
            'bukti3' => $realisasi->bukti3,
            'bukti4' => $realisasi->bukti4,
            'bukti5' => $realisasi->bukti5,
        ];
        // dd($files);
        $title = "Realisasi Departemen ".$departemen->nama;
        return view('renstra.realisasi.form', compact('departemen','realisasi', 'title', 'files'))->with([
            'user'=> Auth::user()
        ]);
    }
}
