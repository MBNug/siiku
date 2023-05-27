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
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;


class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($renstradept)
    {
        $targets = DB::table('targets') -> where('kode', 'like', $renstradept.'%') -> get();
        $s = DB::table('targets') -> where('kode', 'like', $renstradept.'%') -> where('status', '!=', "1")-> count();
        // dd($status);
        $namadept = DB::table('departemens') -> where('kode', '=', $renstradept)->first();
        $title = 'Target Departemen '.$namadept->nama;
        $status=0;
        if($s>0){
            $status=2;
        }else{
            $status=1;
        }
        // dd($title);
        // dd($namadept);
        $departemens = Departemen::all();
        return view('renstra.target.index', compact('targets', 'departemens', 'title', 'renstradept',"status")) ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($renstradept)
    {
        //
        $strategis = Strategi::all();
        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '=', $renstradept)->pluck('nama');
        return view('renstra.target.create', compact('departemens', 'strategis', 'renstradept', 'dept'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($renstradept, StoreTargetRequest $request)
    {
        $strategi = Strategi::where('kode', '=', $request->strategi)->first();
        $indikator = Indikator::where('kode', '=', $request->indikator_kinerja)->pluck('indikator_kinerja');
        $kode = ''.$request->departemen.$request->indikator_kinerja.$request->tahun;
        $target = Target::where('kode', '=', $kode)->first();
        // dd($target);

        $request->validate([
            'indikator_kinerja' => 'required',
            'strategi' => 'required',
            'tahun' => 'required',
            'departemen' => 'required',
            'target' => 'required',
        ]);
        $request->request->add(['kode' => ''.$kode]);
        $request->merge(['strategi' => ''.$strategi->nama]);
        $request->merge(['indikator_kinerja' => ''.$indikator[0]]);

        // dd($request);
        if($target==null){
            Target::create($request->all());
            Alert::success('Berhasil!', 'Target baru berhasil ditambahkan');
            return redirect(route('renstra.target.index', $renstradept));
        }
        else{
            Alert::error('Gagal!', 'Target untuk indikator ini telah diatur.');
            return redirect(route('renstra.target.index', $renstradept));
        }
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
        // dd($target);
        $departemens = Departemen::all();
        // return view('renstra.target.edit', compact('departemens','target'));
        return view('renstra.target.edit', compact('departemens', 'target'))->with([
            'user'=> Auth::user()
        ]);
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
        // dd('hello');
        $request->validate([
            'target' => 'required',
        ]);

        $target->update([
            'target'   => $request->target,
            'status'   => '3'
        ]);


        $renstradept = substr($target->kode, 0,1);
        return redirect(route('renstra.target.index', "0".$renstradept));
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
    public function getStrategi($kode='s')
    {
        $indikator['data'] = DB::table('indikators')->where('kode', 'like', $kode.'%')->select('kode', 'indikator_kinerja')->get();
        // return Response::json(['success'=>true]);
        return response()->json($indikator);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetRequest  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function tolak($kode){
        DB::statement("UPDATE targets SET status = '2' where kode='$kode'");
        return redirect()->back();
    }
    public function urungkan($kode){
        DB::statement("UPDATE targets SET status = '0' where kode='$kode'");
        return redirect()->back();
    }
    public function setujui($renstradept){
        DB::statement("UPDATE targets set status = '1' where kode like '$renstradept%' and status != '2'");
        return redirect()->back();
    }
}
