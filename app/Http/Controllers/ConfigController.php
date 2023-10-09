<?php

namespace App\Http\Controllers;

use App\Models\config;
use App\Models\Target;
use App\Models\Triwulan;
use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Triwulan1;
use App\Models\Triwulan2;
use App\Models\Triwulan3;
use App\Models\Triwulan4;
use App\Models\TargetPTNBH;
use Illuminate\Http\Request;
use App\Models\IndikatorPTNBH;
use App\Models\RealisasiPTNBH;
use App\Models\Triwulan1PTNBH;
use App\Models\Triwulan2PTNBH;
use App\Models\Triwulan3PTNBH;
use App\Models\Triwulan4PTNBH;
use App\Imports\IndikatorImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IndikatorPTNBHImport;
use Illuminate\Support\Facades\Storage;
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

    public function alertStoreIndikator(Request $request){
        $actConfig1 = Config::where('status', '=', '1')->first();
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // dd($indikatorlama);
        $jmlindikatorlama = count($indikatorlama);
        if($actConfig1 != null)
        {
            $this->validate($request, 
                [
                    'indikator' => 'required|mimes:xlsx,xls,csv'
                ],
                [
                    'indikator.mimes' => 'Format yang diterima hanya .xls,.xlsx, dan .csv'
                ]
            );
    
            $file = $request->file('indikator');
     
            // membuat nama file unik
            $nama_file = 'IndikatorNew.xlsx';

            // upload ke folder file_indikator di dalam folder public
            if(Storage::exists('file_indikator/renstra/'.$actConfig1->tahun.'/new/'.$nama_file)){
                Storage::delete('file_indikator/renstra/'.$actConfig1->tahun.'/new/'.$nama_file);
            }
            $file->storeAs('file_indikator/renstra/'.$actConfig1->tahun.'/new/',$nama_file, 'public');
            
            // dd($request);
            if($jmlindikatorlama==0){
                Storage::move('file_indikator/renstra/'.$actConfig1->tahun.'/new/IndikatorNew.xlsx', 'file_indikator/renstra/'.$actConfig1->tahun.'/Indikator.xlsx');
                Excel::import(new IndikatorImport, public_path('storage/file_indikator/renstra/'.$actConfig1->tahun.'/Indikator.xlsx'));
                Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
                return redirect(route('config.index'));
            }
            else{
                alert()->error('Ubah Indikator Aktif !','Ini akan membuat indikator, target, dan realisasi sekarang akan dihapus!')
                ->showCancelButton('Cancel', '#aaa')
                ->showConfirmButton(
                    $btnText = '<a class="add-padding" href="/config/setindikator/new">Yes</a>', // here is class for link
                    $btnColor = '#17356d',
                    ['className'  => 'no-padding'], // add class to button
                );
                return redirect()->back();
            }
        } 
        else
        {
            Alert::error('Gagal', 'Config Tahun belum diatur!');
            return redirect(route('config.index'));
        }
    }
    public function alertStoreIndikatorPTNBH(Request $request){
        $actConfig1 = Config::where('status', '=', '1')->first();
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $indikatorlama = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // dd($indikatorlama);
        $jmlindikatorlama = count($indikatorlama);
        if($actConfig1 != null)
        {
            $this->validate($request, [
                'indikatorptnbh' => 'required|mimes:xlsx,xls,csv'
            ],
            [
                'indikator.mimes' => 'Format yang diterima hanya .xls,.xlsx, dan .csv'
            ]);
    
            $file = $request->file('indikatorptnbh');
     
            // membuat nama file unik
            $nama_file = 'IndikatorNew.xlsx';

            // upload ke folder file_indikator di dalam folder public
            if(Storage::exists('file_indikator/ptnbh/'.$actConfig1->tahun.'/new/'.$nama_file)){
                Storage::delete('file_indikator/ptnbh/'.$actConfig1->tahun.'/new/'.$nama_file);
            }
            $file->storeAs('file_indikator/ptnbh/'.$actConfig1->tahun.'/new/',$nama_file, 'public');
            
            // dd($request);
            if($jmlindikatorlama==0){
                Storage::move('file_indikator/ptnbh/'.$actConfig1->tahun.'/new/IndikatorNew.xlsx', 'file_indikator/ptnbh/'.$actConfig1->tahun.'/Indikator.xlsx');
                Excel::import(new IndikatorPTNBHImport, public_path('storage/file_indikator/ptnbh/'.$actConfig1->tahun.'/Indikator.xlsx'));
                Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
                return redirect(route('config.index'));
            }
            else{
                alert()->error('Ubah Indikator PTNBH Aktif !','Ini akan membuat indikator, target, dan realisasi sekarang akan dihapus!')
                ->showCancelButton('Cancel', '#aaa')
                ->showConfirmButton(
                    $btnText = '<a class="add-padding" href="/config/setindikatorptnbh/new">Yes</a>', // here is class for link
                    $btnColor = '#17356d',
                    ['className'  => 'no-padding'], // add class to button
                );
                return redirect()->back();
            }
        } 
        else
        {
            Alert::error('Gagal', 'Config Tahun belum diatur!');
            return redirect(route('config.index'));
        }
    }

    public function storeIndikator(Request $request)
    {
        $actConfig1 = Config::where('status', '=', '1')->first();
        
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $targetlama = DB::table('targets') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $realisasilama = DB::table('realisasis') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan1lama = DB::table('triwulan1s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan2lama = DB::table('triwulan2s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan3lama = DB::table('triwulan3s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan4lama = DB::table('triwulan4s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // dd($targetlama);
        

        $jmlindikatorlama = count($indikatorlama);
        $jmltargetlama = count($targetlama);
        $jmlrealisasilama = count($realisasilama);
        $jmltriwulan1lama = count($triwulan1lama);
        $jmltriwulan2lama = count($triwulan2lama);
        $jmltriwulan3lama = count($triwulan3lama);
        $jmltriwulan4lama = count($triwulan4lama);

        if($jmlindikatorlama!=0){
            Storage::delete('file_indikator/renstra/'.$actConfig1->tahun.'/Indikator.xlsx');
            for ($i = 0; $i < $jmlindikatorlama; $i++){
                Indikator::destroy($indikatorlama[$i]->kode);
            }
        }
        if($jmltargetlama!=0){
            for ($i = 0; $i < $jmltargetlama; $i++){
                Target::destroy($targetlama[$i]->kode);
            }
        }
        if($jmltriwulan1lama!=0){
            for ($i = 0; $i < $jmltriwulan1lama; $i++){
                Triwulan1::destroy($triwulan1lama[$i]->kode);
            }
            if($jmltriwulan2lama!=0){
                for ($i = 0; $i < $jmltriwulan2lama; $i++){
                    Triwulan2::destroy($triwulan2lama[$i]->kode);
                }
                if($jmltriwulan3lama!=0){
                    for ($i = 0; $i < $jmltriwulan3lama; $i++){
                        Triwulan3::destroy($triwulan3lama[$i]->kode);
                    }
                    if($jmltriwulan4lama!=0){
                        for ($i = 0; $i < $jmltriwulan4lama; $i++){
                            Triwulan4::destroy($triwulan4lama[$i]->kode);
                        }
                        if($jmlrealisasilama!=0){
                            for ($i = 0; $i < $jmlrealisasilama; $i++){
                                Realisasi::destroy($realisasilama[$i]->kode);
                            }
                            
                        }
                    }
                }
            }
        }
        
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $triwulan4 = Triwulan::where('triwulan', '=', '4')->first();

        if($triwulan->triwulan == '0'){
            $triwulan->status='0';
            $triwulan->save();
            $triwulan4->status='1';
            $triwulan4->save();
        }
        
        // import data
        Storage::move('file_indikator/renstra/'.$actConfig1->tahun.'/new/IndikatorNew.xlsx', 'file_indikator/renstra/'.$actConfig1->tahun.'/Indikator.xlsx');
        Excel::import(new IndikatorImport, public_path('storage/file_indikator/renstra/'.$actConfig1->tahun.'/Indikator.xlsx'));
        Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
        return redirect(route('config.index'));
    }
    public function storeIndikatorPTNBH(Request $request)
    {
        $actConfig1 = Config::where('status', '=', '1')->first();
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $indikatorlama = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $targetlama = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $realisasilama = DB::table('realisasi_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan1lama = DB::table('triwulan1_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan2lama = DB::table('triwulan2_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan3lama = DB::table('triwulan3_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        $triwulan4lama = DB::table('triwulan4_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();

        

        $jmlindikatorlama = count($indikatorlama);
        $jmltargetlama = count($targetlama);
        $jmlrealisasilama = count($realisasilama);
        $jmltriwulan1lama = count($triwulan1lama);
        $jmltriwulan2lama = count($triwulan2lama);
        $jmltriwulan3lama = count($triwulan3lama);
        $jmltriwulan4lama = count($triwulan4lama);

        if($jmlindikatorlama!=0){
            Storage::delete('file_indikator/ptnbh/'.$actConfig1->tahun.'/Indikator.xlsx');
            for ($i = 0; $i < $jmlindikatorlama; $i++){
                IndikatorPTNBH::destroy($indikatorlama[$i]->kode);
            }
        }
        if($jmltargetlama!=0){
            for ($i = 0; $i < $jmltargetlama; $i++){
                TargetPTNBH::destroy($targetlama[$i]->kode);
            }
        }
        if($jmltriwulan1lama!=0){
            for ($i = 0; $i < $jmltriwulan1lama; $i++){
                Triwulan1PTNBH::destroy($triwulan1lama[$i]->kode);
            }
            if($jmltriwulan2lama!=0){
                for ($i = 0; $i < $jmltriwulan2lama; $i++){
                    Triwulan2PTNBH::destroy($triwulan2lama[$i]->kode);
                }
                if($jmltriwulan3lama!=0){
                    for ($i = 0; $i < $jmltriwulan3lama; $i++){
                        Triwulan3PTNBH::destroy($triwulan3lama[$i]->kode);
                    }
                    if($jmltriwulan4lama!=0){
                        for ($i = 0; $i < $jmltriwulan4lama; $i++){
                            Triwulan4PTNBH::destroy($triwulan4lama[$i]->kode);
                        }
                        if($jmlrealisasilama!=0){
                            for ($i = 0; $i < $jmlrealisasilama; $i++){
                                RealisasiPTNBH::destroy($realisasilama[$i]->kode);
                            }
                            
                        }
                    }
                }
            }
        }
        
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $triwulan4 = Triwulan::where('triwulan', '=', '4')->first();

        if($triwulan->triwulan == '0'){
            $triwulan->status='0';
            $triwulan->save();
            $triwulan4->status='1';
            $triwulan4->save();
        }
        // import data
        Storage::move('file_indikator/ptnbh/'.$actConfig1->tahun.'/new/IndikatorNew.xlsx', 'file_indikator/ptnbh/'.$actConfig1->tahun.'/Indikator.xlsx');
        Excel::import(new IndikatorPTNBHImport, public_path('storage/file_indikator/ptnbh/'.$actConfig1->tahun.'/Indikator.xlsx'));
        Alert::success('Berhasil', 'Config Indikator berhasil diubah!');
        return redirect(route('config.index'));
		
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
