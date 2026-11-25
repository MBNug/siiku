<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Triwulan;
use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Models\IndikatorPTNBH;
use App\Imports\IndikatorImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IndikatorPTNBHImport;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreConfigRequest;
use App\Http\Requests\UpdateConfigRequest;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actConfig = DB::table('configs')->where('status', '=', '1')->get();
        $actConfigTriwulan = DB::table('triwulans')->where('status', '=', '1')->get();
        $triwulans = DB::table('triwulans')->get();
        $triwulan = $actConfigTriwulan->first();

        $countAct = $actConfig->count();
        $countActTriwulan = $actConfigTriwulan->count();

        return view('config.tahun', compact('actConfig', 'countAct', 'actConfigTriwulan', 'countActTriwulan', 'triwulans', 'triwulan'))->with([
            'user' => Auth::user()
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTahun(StoreConfigRequest $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer|between:2000,2100',
        ]);

        $tahunInt = (int) $validated['tahun'];
        $config = Config::firstOrCreate(
            ['tahun' => $tahunInt],
            ['status' => '0', 'statusterakhir' => '0', 'triwulanterakhir' => '0']
        );

        $actConfig1 = Config::where('status', '=', '1')->first();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $triwulan1 = Triwulan::firstOrCreate(['triwulan' => '1'], ['status' => '0']);
        $triwulan0 = Triwulan::firstOrCreate(['triwulan' => '0'], ['status' => '0']);
        $currentTwVal = $triwulan ? (string) $triwulan->triwulan : '1';

        if ($actConfig1 === null) {
            $config->status = '1';
            $config->save();
            DB::table('triwulans')->update(['status' => '0']);
            $triwulan1->status = '1';
            $triwulan1->save();

            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }

        if ((int) $actConfig1->tahun === $tahunInt || $config->status == '1') {
            Alert::error('Gagal!', 'Pilih Tahun yang berbeda!');
            return redirect(route('config.index'));
        }

        if ($config->status == '0') {
            $actConfig1->statusterakhir = $actConfig1->status;
            $actConfig1->status = '3';
            $actConfig1->triwulanterakhir = $currentTwVal;
            $actConfig1->save();

            $config->status = '1';
            $config->save();

            DB::table('triwulans')->update(['status' => '0']);
            $triwulan1->status = '1';
            $triwulan1->save();

            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }

        if ($config->status == '2') {
            $actConfig1->status = '3';
            $actConfig1->triwulanterakhir = $currentTwVal;
            $actConfig1->save();

            $config->status = '1';
            $config->statusterakhir = '2';
            $config->save();

            DB::table('triwulans')->update(['status' => '0']);
            $triwulan0->status = '1';
            $triwulan0->save();

            Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
            return redirect(route('config.index'));
        }

        $actConfig1->status = $actConfig1->statusterakhir ?: '0';
        $actConfig1->triwulanterakhir = $currentTwVal;
        $actConfig1->save();

        $targetTwKey = (string) ($config->triwulanterakhir ?? '1');
        $config->status = '1';
        $config->statusterakhir = '3';
        $config->save();

        DB::table('triwulans')->update(['status' => '0']);
        $triwulanN = Triwulan::where('triwulan', '=', $targetTwKey)->first() ?? $triwulan1;
        $triwulanN->status = '1';
        $triwulanN->save();

        Alert::success('Berhasil', 'Config Tahun berhasil diubah!');
        return redirect(route('config.index'));
    }

    public function storeTriwulan(StoreConfigRequest $request)
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
                'indikator' => 'required|file|mimes:xlsx,xls,csv|max:10240'
            ]);
    
            $file = $request->file('indikator');
    
            $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
            $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
            $jmlindikatorlama = count($indikatorlama);
            if($jmlindikatorlama!=0){
                for ($i = 0; $i < $jmlindikatorlama; $i++){
                    Indikator::destroy($indikatorlama[$i]->kode);
                }
            }
            $storedPath = $file->store('file_indikator/renstra/'.$actConfig1->tahun, 'public');
    
            // import data
            Excel::import(new IndikatorImport, Storage::disk('public')->path($storedPath));
    
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
                'indikatorptnbh' => 'required|file|mimes:xlsx,xls,csv|max:10240'
            ]);
    
            $file = $request->file('indikatorptnbh');
    
            $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
            $indikatorlama = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
            $jmlindikatorlama = count($indikatorlama);
            if($jmlindikatorlama!=0){
                for ($i = 0; $i < $jmlindikatorlama; $i++){
                    IndikatorPTNBH::destroy($indikatorlama[$i]->kode);
                }
            }
            $storedPath = $file->store('file_indikator/ptnbh/'.$actConfig1->tahun, 'public');
    
            // import data
            Excel::import(new IndikatorPTNBHImport, Storage::disk('public')->path($storedPath));
    
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
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConfigRequest  $request
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfigRequest $request, Config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function destroy(Config $config)
    {
        //
    }
}
