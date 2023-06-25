<?php

namespace App\Http\Controllers;

use App\Models\config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreconfigRequest;
use App\Http\Requests\UpdateconfigRequest;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> get();

        if ($actConfig===null){
            $countAct = 0;
        }
        else{
            $countAct = count($actConfig);
        }
        return view('config.tahun', compact('actConfig', 'countAct'))->with([
            'user'=> Auth::user()
        ]);;
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreconfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTahun(StoreconfigRequest $request)
    {

        // $config = DB::table('configs') -> where('tahun', '=', $request->tahun) -> first();
        $config =Config::find($request->tahun);
        // dd($config);

        $actConfig1 = Config::where('status', '=', '1')->first();
        $actConfig2 =Config::find($actConfig1->tahun);
        // dd($actConfig===null);
        // dd($actConfig);
        $request->validate([
            'tahun' => 'required',
        ]);

        if($actConfig1 === null){
            $config->status = '1';
            $config->save();
            // dd($config);

            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }
        else{
            $actConfig2->status = '0';
            $actConfig2->save();
            $config->status = '1';
            $config->save();
            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }
        

        //
    }

    public function storeIndikator(StoreconfigRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\config  $config
     * @return \Illuminate\Http\Response
     */
    public function show(config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\config  $config
     * @return \Illuminate\Http\Response
     */
    public function edit(config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateconfigRequest  $request
     * @param  \App\Models\config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateconfigRequest $request, config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\config  $config
     * @return \Illuminate\Http\Response
     */
    public function destroy(config $config)
    {
        //
    }
}
