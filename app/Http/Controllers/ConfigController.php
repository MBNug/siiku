<?php

namespace App\Http\Controllers;

use App\Models\config;
use App\Models\Triwulan;
use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Models\IndikatorPTNBH;
use App\Imports\IndikatorImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IndikatorPTNBHImport;
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
        $actConfigTriwulan = DB::table('triwulans') -> where('status', '=', '1') -> get();
        $triwulans = DB::table('triwulans') -> get();

        if ($actConfig===null){
            $countAct = 0;
        }
        else{
            $countAct = count($actConfig);
        }
        if ($actConfigTriwulan===null){
            $countActTriwulan = 0;
        }
        else{
            $countActTriwulan = count($actConfigTriwulan);
        }
        return view('config.tahun', compact('actConfig', 'countAct', 'actConfigTriwulan', 'countActTriwulan', 'triwulans'))->with([
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
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $triwulan1 = Triwulan::where('triwulan', '=', '1')->first();
        $triwulan0 = Triwulan::where('triwulan', '=', '0')->first();
        // dd($actConfig===null);
        // dd($actConfig);
        $request->validate([
            'tahun' => 'required',
        ]);


        // kalo null semua tahun jadi 1 triwulan1 jadi 1
        //kalo tahun null triwulan not null, tahun jadi 1, triwulan1 jadi 1
        //kalo tahun not null triwulan not null.
                 // kalo config = 2, tahun jadi 1+triwulan, triwulan 0 jadi 1. dan hanya bisa akses realisasi
                 // kalo config = 1+triwulan, config jadi 1, triwulan N jadi 1 
                 // kalo config 0 kasih warning tahun ini tidak ada data yang bisa dilihat dan ini akan mengubah tahun aktif yang sedang diisi.

        if($actConfig1 === null){
           
            $config->status = '1';
            $config->save();
            $triwulan1->status = '1';
            $triwulan1->save();
            
            
            // dd($config);

            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }
        else{
            if($config->status == '1'){
                Alert::error('Gagal!', 'Pilih Tahun yang berbeda!');
                return redirect(route('config.index'));
            }
            elseif($config->status =='0'){
                $actConfig1->statusterakhir = $actConfig1->status;
                $actConfig1->status = '3';
                $actConfig1->triwulanterakhir = $triwulan->triwulan;
                $actConfig1->save();
                $config->status = '1';
                $config->save();
                if($triwulan->triwulan != '1'){
                    $triwulan->status='0';
                    $triwulan->save();
                    $triwulan1->status='1';
                    $triwulan1->save();
                }
                // dd($triwulan1);
                Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
                return redirect(route('config.index'));
            }
            elseif($config->status =='2'){
                $actConfig1->status = '3';
                $actConfig1->triwulanterakhir = $triwulan->triwulan;
                $actConfig1->save();
                $config->status = '1';
                $config->statusterakhir = '2';
                $config->save();
                $triwulan->status = '0';
                $triwulan->save();
                $triwulan0->status = '1';
                $triwulan0->save();
                Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
                return redirect(route('config.index'));

            }
            else{
                $actConfig1->status = $actConfig1->statusterakhir;
                $actConfig1->triwulanterakhir = $triwulan->triwulan;
                $actConfig1->save();
                $config->status = '1';
                $config->statusterakhir = '3';
                $config->save();
                $triwulan->status = '0';
                $triwulan->save();
                $triwulanN = Triwulan::where('triwulan', '=', $config->triwulanterakhir)->first();
                $triwulanN->status = '1';
                $triwulanN->save();
                // $actConfig2 =Config::find($actConfig1->tahun);
                // $actConfig2->status = '0';
                // $actConfig2->save();
                // $config->status = '1';
                // $config->save();
                Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
                return redirect(route('config.index'));
            }
            
        }
        

        //
    }
    public function storeTriwulan(StoreconfigRequest $request)
    {

        // $config = DB::table('configs') -> where('tahun', '=', $request->tahun) -> first();
        $config =Triwulan::find($request->triwulan);
        // dd($config);

        $actConfig1 = Triwulan::where('status', '=', '1')->first();
        // dd($actConfig===null);
        // dd($actConfig);
        $request->validate([
            'triwulan' => 'required',
        ]);

        if($actConfig1 === null){
            $config->status = '1';
            $config->save();
            // dd($config);

            Alert::success('Berhasil', 'Config Triwulan berhasil diubah!');
            return redirect(route('config.index'));
        }
        else{
            if($actConfig2 =Triwulan::find($actConfig1->triwulan) == $config){
                Alert::error('Gagal!', 'Pilih Triwulan yang berbeda!');
                return redirect(route('config.index'));
            }
            else{
                $actConfig2 =Triwulan::find($actConfig1->triwulan);
                $actConfig2->status = '0';
                $actConfig2->save();
                $config->status = '1';
                $config->save();
                Alert::success('Berhasil', 'Config Triwulan berhasil diubah!');
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
            $file->storeAs('file_indikator/renstra/'.$actConfig1->tahun,$nama_file, 'public');
    
            // import data
            Excel::import(new IndikatorImport, public_path('storage/file_indikator/renstra/'.$actConfig1->tahun.'/'.$nama_file));
    
            Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
            return redirect(route('config.index'));
        } 
        else
        {
            Alert::error('Gagal', 'Config Tahun belum diatur!');
            return redirect(route('config.index'));
        }
		
    }
    public function storeIndikatorPTNBH(Request $request)
    {
        $actConfig1 = Config::where('status', '=', '1')->first();
        // dd($actConfig1);
        if($actConfig1 != null)
        {
            $this->validate($request, [
                'indikatorptnbh' => 'required'
            ]);
    
            $file = $request->file('indikatorptnbh');
     
            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();
     
            // upload ke folder file_indikator di dalam folder public
            
            // dd($request);
    
            $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
            $indikatorlama = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
            // dd($indikatorlama);
            $jmlindikatorlama = count($indikatorlama);
            if($jmlindikatorlama!=0){
                for ($i = 0; $i < $jmlindikatorlama; $i++){
                    IndikatorPTNBH::destroy($indikatorlama[$i]->kode);
                }
            }
            $file->storeAs('file_indikator/ptnbh/'.$actConfig1->tahun,$nama_file, 'public');
    
            // import data
            Excel::import(new IndikatorPTNBHImport, public_path('storage/file_indikator/ptnbh/'.$actConfig1->tahun.'/'.$nama_file));
    
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
