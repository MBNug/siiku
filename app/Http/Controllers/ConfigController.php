<?php

namespace App\Http\Controllers;

use App\Models\config;
use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Imports\IndikatorImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
            if($actConfig2 =Config::find($actConfig1->tahun) == $config){
                Alert::error('Gagal!', 'Pilih Tahun yang berbeda!');
                return redirect(route('config.index'));
            }
            else{
                $actConfig2 =Config::find($actConfig1->tahun);
                $actConfig2->status = '0';
                $actConfig2->save();
                $config->status = '1';
                $config->save();
                Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
                return redirect(route('config.index'));
            }
            
        }
        

        //
    }

    public function storeIndikator(Request $request)
    {
        $actConfig1 = Config::where('status', '=', '1')->first();
        // dd($actConfig1);
        if($actConfig1 != null)
        {
            $this->validate($request, [
                'indikator' => 'required'
            ]);
    
            $file = $request->file('indikator');
     
            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();
     
            // upload ke folder file_indikator di dalam folder public
            $file->storeAs('file_indikator',$nama_file);
            // dd($request);
    
            $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
            $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
            // dd($indikatorlama);
            $jmlindikatorlama = count($indikatorlama);
            if($jmlindikatorlama!=0){
                for ($i = 0; $i < $jmlindikatorlama; $i++){
                    Indikator::destroy($indikatorlama[$i]->kode);
                }
            }
    
            // import data
            Excel::import(new IndikatorImport, storage_path('app/file_indikator/'.$nama_file));
    
            Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
            return redirect(route('config.index'));
        } 
        else
        {
            Alert::error('Gagal', 'Config Tahun belum diatur!');
            return redirect(route('config.index'));
        }
		
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
