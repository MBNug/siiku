<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Strategi;
use App\Models\Indikator;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $targets = DB::table('targets') -> where('kode', 'like', $id.'%') -> get();
        $departemens = Departemen::all();
        return view('renstra.target.index', compact('targets', 'departemens')) ->with([
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
        $strategis = Strategi::all();
        $indikators = Indikator::all();
        $departemens = Departemen::all();
        return view('renstra.target.create', compact('indikators', 'departemens', 'strategis'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTargetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetRequest  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetRequest $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
        //
    }


    /*
    Ajax
    */
    public function getIndikator($kode)
    {
        $definisi = DB::table('indikators')->where('kode', $kode)->pluck('definisi');
        $cara_perhitungan = DB::table('indikators')->where('kode', $kode)->pluck('cara_perhitungan');
        $satuan = DB::table('indikators')->where('kode', $kode)->pluck('satuan');
        $keterangan = DB::table('indikators')->where('kode', $kode)->pluck('keterangan');
        return Response::json(['success'=>true, 'definisi'=>$definisi, 'cara_perhitungan'=>$cara_perhitungan, 'satuan'=>$satuan, 'keterangan'=>$keterangan]);

    }
}
