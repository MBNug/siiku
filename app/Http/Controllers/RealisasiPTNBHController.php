<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Config;
use App\Models\Pejabat;
use App\Models\Triwulan;
use App\Models\Realisasi;
use App\Models\Triwulan1;
use App\Models\Triwulan2;
use App\Models\Triwulan3;
use App\Models\Triwulan4;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Models\RealisasiPTNBH;
use App\Models\TempBuktiPTNBH;
use App\Models\Triwulan1PTNBH;
use App\Models\Triwulan2PTNBH;
use App\Models\Triwulan3PTNBH;
use App\Models\Triwulan4PTNBH;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreRealisasiPTNBHRequest;
use App\Http\Requests\UpdateRealisasiPTNBHRequest;

class RealisasiPTNBHController extends Controller
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
        $tahun = Config::where('status', '=', '1')->first();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        // alert()->error('Gagal!','Config Triwulan Belum diatur');

        if($triwulan === null){
            

            // Alert::error('Gagal!', "Config Triwulan Belum diatur");
            alert()->error('Gagal!','Config Tahun Belum diatur');

            return redirect()->back();
        }
        return view('ptnbh.realisasi.index', compact('departemens','title', 'triwulan')) ->with([
            'user'=> Auth::user()
        ]);
    }

    public function getRealisasi($ptnbhdept, Triwulan $triwulan)
    {   
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $actTri = Triwulan::where('status', '=', '1')->first();
        // dd($triwulan);
        // dd($actConfig);
        if($actConfig===null){
            Alert::error('Gagal!', "Config Tahun Belum diatur");
            return redirect()->back();
        }else{
            if($triwulan === null){
                Alert::error('Gagal!', "Config Triwulan Belum diatur");
                return redirect()->back();
            }
            else{
                if($triwulan->triwulan == '1'){
                    $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
                    $targets = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
                    $indikators = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
                    $errmsg1="Indikator Departemen ".$namadept->nama.' untuk tahun '.$actConfig->tahun.' belum diatur pihak fakultas.';
                    $errmsg2="Target Departemen ".$namadept->nama.' untuk tahun '.$actConfig->tahun.' belum diatur pihak fakultas.';
                    if($indikators->count()==0){
                        Alert::error('Data Belum Tersedia', $errmsg1);
                        return redirect()->back();
                    }
                    if($targets->count()==0){
                        Alert::error('Data Belum Tersedia', $errmsg1);
                        return redirect()->back();
                    }
                    
                    $targetsNotApproved = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> where('status', '!=', '1')-> get();
                    $errmsg2="Target Departemen ".$namadept->nama.' untuk tahun '.$actConfig->tahun.' belum disetujui pihak fakultas.';
                    if($targetsNotApproved->count()>0){
                        Alert::error('Data Belum Tersedia', $errmsg2);
                        return redirect()->back();
                    }
                    else{
                        $realisasis = Triwulan1PTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                        // dd($realisasis);
                        $t= $namadept->nama." ".$actConfig->tahun;
                        $title = 'Realisasi Departemen '.$t;
                        if($realisasis->count()==0){
                            return view('ptnbh.realisasi.triwulan1.uncreate', compact('title', 'ptnbhdept', 'triwulan')) ->with([
                                'user'=> Auth::user()
                            ]);
                        }
                        else{
                            
                            $departemens = Departemen::all();
                            return view('ptnbh.realisasi.triwulan1.triwulan1', compact('realisasis', 'departemens', 'title', 'ptnbhdept', 'triwulan', 'actTri')) ->with([
                                'user'=> Auth::user()
                            ]);
                        }
                    }
                }
                elseif($triwulan->triwulan == '2'){
                    $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
                    $realisasis = Triwulan2PTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                    // dd($realisasis);
                    $t= $namadept->nama." ".$actConfig->tahun;
                    $title = 'Realisasi Departemen '.$t;
                    $departemens = Departemen::all();
                    return view('ptnbh.realisasi.triwulan2.triwulan2', compact('realisasis', 'departemens', 'title', 'ptnbhdept', 'triwulan', 'actTri')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
                elseif($triwulan->triwulan == '3'){
                    $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
                    $realisasis = Triwulan3PTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                    // dd($realisasis);
                    $t= $namadept->nama." ".$actConfig->tahun;
                    $title = 'Realisasi Departemen '.$t;
                    $departemens = Departemen::all();
                    return view('ptnbh.realisasi.triwulan3.triwulan3', compact('realisasis', 'departemens', 'title', 'ptnbhdept', 'triwulan', 'actTri')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
                elseif($triwulan->triwulan == '4'){
                    $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
                    $realisasis = Triwulan4PTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                    // dd($realisasis);
                    $t= $namadept->nama." ".$actConfig->tahun;
                    $title = 'Realisasi Departemen '.$t;
                    $departemens = Departemen::all();
                    return view('ptnbh.realisasi.triwulan4.triwulan4', compact('realisasis', 'departemens', 'title', 'ptnbhdept', 'triwulan', 'actTri')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
                elseif($triwulan->triwulan == '0'){
                    $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
                    $realisasis = RealisasiPTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) ->paginate(10);
                    // dd($realisasis);
                    $t= $namadept->nama." ".$actConfig->tahun;
                    $title = 'Realisasi Departemen '.$t;
                    $departemens = Departemen::all();
                    return view('ptnbh.realisasi.realisasi', compact('realisasis', 'departemens', 'title', 'ptnbhdept', 'triwulan')) ->with([
                        'user'=> Auth::user()
                    ]);
                }
            }
            
        }
    }

    public function alertakhiriTriwulan(Departemen $departemen, Triwulan $triwulan){
        alert()->error('Akhiri Triwulan '.$triwulan->triwulan.'!','Ini akan membuat triwulan 1 tidak akan bisa diubah lagi dan beralih ke triwulan 2 untuk semua departemen.')
        ->showCancelButton('Cancel', '#aaa')
        ->showConfirmButton(
            //ptnbh/realisasi/departemen/01/%7B%7B%20/ptnbh/realisasi/departemen/01/realisasi/1/akhiri%7D%7D
            
            $btnText = '<a class="add-padding" href="/ptnbh/realisasi/departemen/'.$departemen->kode.'/realisasi/'.$triwulan->triwulan.'/akhiri">Yes</a>', // here is class for link
            $btnColor = '#38c177',
            ['className'  => 'no-padding'], // add class to button
        );
        return redirect()->back();
        
    }
    public function akhiriTriwulan(Departemen $departemen, Triwulan $triwulan)
    {
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        if($triwulan->triwulan == '1'){
            // dd($triwulan);
            $triwulan1 = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan1 as $t){
                if($t->status == 'Belum Diupdate'){
                    $triwulan2 = new Triwulan2PTNBH;
                    $triwulan2->kode = ''.$t->kode;
                    $triwulan2->strategi = ''.$t->strategi;
                    $triwulan2->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan2->satuan = ''.$t->satuan;
                    $triwulan2->keterangan = ''.$t->keterangan;
                    $triwulan2->definisi = ''.$t->definisi;
                    $triwulan2->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan2->target = ''.$t->target;
                    $triwulan2->nilai = '0';
                    $triwulan2->bukti1 = $t->bukti1;
                    $triwulan2->bukti2 = $t->bukti2;
                    $triwulan2->bukti3 = $t->bukti3;
                    $triwulan2->bukti4 = $t->bukti4;
                    $triwulan2->bukti5 = $t->bukti5;
                    $triwulan2->status = 'Belum Diupdate';
                    $triwulan2->nilaireal = '0';
                    $triwulan2->statusterakhir = 'Tidak Tercapai';
                    $triwulan2->save();

                    $t->nilai = '0';
                    $t->nilaireal = '0';
                    $t->status = 'Tidak Tercapai';
                    $t->update();
                }
                else{
                    $triwulan2 = new Triwulan2PTNBH;
                    $triwulan2->kode = ''.$t->kode;
                    $triwulan2->strategi = ''.$t->strategi;
                    $triwulan2->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan2->satuan = ''.$t->satuan;
                    $triwulan2->keterangan = ''.$t->keterangan;
                    $triwulan2->definisi = ''.$t->definisi;
                    $triwulan2->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan2->target = ''.$t->target;
                    $triwulan2->nilai = ''.$t->nilaireal;
                    $triwulan2->bukti1 = $t->bukti1;
                    $triwulan2->bukti2 = $t->bukti2;
                    $triwulan2->bukti3 = $t->bukti3;
                    $triwulan2->bukti4 = $t->bukti4;
                    $triwulan2->bukti5 = $t->bukti5;
                    $triwulan2->status = 'Belum Diupdate';
                    $triwulan2->nilaireal = $t->nilaireal;
                    $triwulan2->statusterakhir = $t->status;
                    $triwulan2->save();
                }
            }
            $triwulan1 = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan1 as $t){
                if($t->status == 'Belum Diupdate'){
                    $triwulan2 = new Triwulan2;
                    $triwulan2->kode = ''.$t->kode;
                    $triwulan2->strategi = ''.$t->strategi;
                    $triwulan2->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan2->satuan = ''.$t->satuan;
                    $triwulan2->keterangan = ''.$t->keterangan;
                    $triwulan2->definisi = ''.$t->definisi;
                    $triwulan2->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan2->target = ''.$t->target;
                    $triwulan2->nilai = '0';
                    $triwulan2->bukti1 = $t->bukti1;
                    $triwulan2->bukti2 = $t->bukti2;
                    $triwulan2->bukti3 = $t->bukti3;
                    $triwulan2->bukti4 = $t->bukti4;
                    $triwulan2->bukti5 = $t->bukti5;
                    $triwulan2->status = 'Belum Diupdate';
                    $triwulan2->nilaireal = '0';
                    $triwulan2->statusterakhir = 'Tidak Tercapai';
                    $triwulan2->save();

                    $t->nilai = '0';
                    $t->nilaireal = '0';
                    $t->status = 'Tidak Tercapai';
                    $t->update();
                }
                else{
                    $triwulan2 = new Triwulan2;
                    $triwulan2->kode = ''.$t->kode;
                    $triwulan2->strategi = ''.$t->strategi;
                    $triwulan2->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan2->satuan = ''.$t->satuan;
                    $triwulan2->keterangan = ''.$t->keterangan;
                    $triwulan2->definisi = ''.$t->definisi;
                    $triwulan2->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan2->target = ''.$t->target;
                    $triwulan2->nilai = ''.$t->nilaireal;
                    $triwulan2->bukti1 = $t->bukti1;
                    $triwulan2->bukti2 = $t->bukti2;
                    $triwulan2->bukti3 = $t->bukti3;
                    $triwulan2->bukti4 = $t->bukti4;
                    $triwulan2->bukti5 = $t->bukti5;
                    $triwulan2->status = 'Belum Diupdate';
                    $triwulan2->nilaireal = $t->nilaireal;
                    $triwulan2->statusterakhir = $t->status;
                    $triwulan2->save();
                }
            }
            $triwulan->status = '0';
            $triwulan->update();
            $triwulan2 = Triwulan::where('triwulan', '=', '2')->first();
            $triwulan2->status = '1';
            $triwulan2->update();
            Alert::success('Berhasil!', 'Triwulan 1 Berhasil diakhiri');
            $triwulan = Triwulan::where('triwulan', '=', '2')->first();

            return redirect()->action([RealisasiPTNBHController::class, 'getRealisasi'], ['kode'=> $departemen->kode, 'triwulan'=> $triwulan->triwulan]);
        }
        elseif($triwulan->triwulan == '2'){
            $triwulan2 = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();
                    $triwulan3 = new Triwulan3PTNBH;
                    $triwulan3->kode = ''.$t->kode;
                    $triwulan3->strategi = ''.$t->strategi;
                    $triwulan3->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan3->satuan = ''.$t->satuan;
                    $triwulan3->keterangan = ''.$t->keterangan;
                    $triwulan3->definisi = ''.$t->definisi;
                    $triwulan3->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan3->target = ''.$t->target;
                    $triwulan3->nilai = ''.$t->nilaireal;
                    $triwulan3->bukti1 = $t->bukti1;
                    $triwulan3->bukti2 = $t->bukti2;
                    $triwulan3->bukti3 = $t->bukti3;
                    $triwulan3->bukti4 = $t->bukti4;
                    $triwulan3->bukti5 = $t->bukti5;
                    $triwulan3->status = 'Belum Diupdate';
                    $triwulan3->nilaireal = $t->nilaireal;
                    $triwulan3->statusterakhir = $t->status;
                    $triwulan3->save();

                    
                }
                else{
                    $triwulan3 = new Triwulan3PTNBH;
                    $triwulan3->kode = ''.$t->kode;
                    $triwulan3->strategi = ''.$t->strategi;
                    $triwulan3->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan3->satuan = ''.$t->satuan;
                    $triwulan3->keterangan = ''.$t->keterangan;
                    $triwulan3->definisi = ''.$t->definisi;
                    $triwulan3->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan3->target = ''.$t->target;
                    $triwulan3->nilai = ''.$t->nilaireal;
                    $triwulan3->bukti1 = $t->bukti1;
                    $triwulan3->bukti2 = $t->bukti2;
                    $triwulan3->bukti3 = $t->bukti3;
                    $triwulan3->bukti4 = $t->bukti4;
                    $triwulan3->bukti5 = $t->bukti5;
                    $triwulan3->status = 'Belum Diupdate';
                    $triwulan3->nilaireal = $t->nilaireal;
                    $triwulan3->statusterakhir = $t->status;
                    $triwulan3->save();
                }
            }
            $triwulan2 = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();
                    $triwulan3 = new Triwulan3;
                    $triwulan3->kode = ''.$t->kode;
                    $triwulan3->strategi = ''.$t->strategi;
                    $triwulan3->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan3->satuan = ''.$t->satuan;
                    $triwulan3->keterangan = ''.$t->keterangan;
                    $triwulan3->definisi = ''.$t->definisi;
                    $triwulan3->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan3->target = ''.$t->target;
                    $triwulan3->nilai = ''.$t->nilaireal;
                    $triwulan3->bukti1 = $t->bukti1;
                    $triwulan3->bukti2 = $t->bukti2;
                    $triwulan3->bukti3 = $t->bukti3;
                    $triwulan3->bukti4 = $t->bukti4;
                    $triwulan3->bukti5 = $t->bukti5;
                    $triwulan3->status = 'Belum Diupdate';
                    $triwulan3->nilaireal = $t->nilaireal;
                    $triwulan3->statusterakhir = $t->status;
                    $triwulan3->save();

                    
                }
                else{
                    $triwulan3 = new Triwulan3;
                    $triwulan3->kode = ''.$t->kode;
                    $triwulan3->strategi = ''.$t->strategi;
                    $triwulan3->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan3->satuan = ''.$t->satuan;
                    $triwulan3->keterangan = ''.$t->keterangan;
                    $triwulan3->definisi = ''.$t->definisi;
                    $triwulan3->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan3->target = ''.$t->target;
                    $triwulan3->nilai = ''.$t->nilaireal;
                    $triwulan3->bukti1 = $t->bukti1;
                    $triwulan3->bukti2 = $t->bukti2;
                    $triwulan3->bukti3 = $t->bukti3;
                    $triwulan3->bukti4 = $t->bukti4;
                    $triwulan3->bukti5 = $t->bukti5;
                    $triwulan3->status = 'Belum Diupdate';
                    $triwulan3->nilaireal = $t->nilaireal;
                    $triwulan3->statusterakhir = $t->status;
                    $triwulan3->save();
                }
            }
            $triwulan->status = '0';
            $triwulan->update();
            $triwulan3 = Triwulan::where('triwulan', '=', '3')->first();
            $triwulan3->status = '1';
            $triwulan3->update();
            Alert::success('Berhasil!', 'Triwulan 2 Berhasil diakhiri');
            
            $triwulan = Triwulan::where('triwulan', '=', '3')->first();
            
            return redirect()->action([RealisasiPTNBHController::class, 'getRealisasi'], ['kode'=> $departemen->kode, 'triwulan'=> $triwulan->triwulan]);
        }
        elseif($triwulan->triwulan == '3'){
            $triwulan2 = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();


                    $triwulan4 = new Triwulan4PTNBH;
                    $triwulan4->kode = ''.$t->kode;
                    $triwulan4->strategi = ''.$t->strategi;
                    $triwulan4->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan4->satuan = ''.$t->satuan;
                    $triwulan4->keterangan = ''.$t->keterangan;
                    $triwulan4->definisi = ''.$t->definisi;
                    $triwulan4->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan4->target = ''.$t->target;
                    $triwulan4->nilai = ''.$t->nilaireal;
                    $triwulan4->bukti1 = $t->bukti1;
                    $triwulan4->bukti2 = $t->bukti2;
                    $triwulan4->bukti3 = $t->bukti3;
                    $triwulan4->bukti4 = $t->bukti4;
                    $triwulan4->bukti5 = $t->bukti5;
                    $triwulan4->status = 'Belum Diupdate';
                    $triwulan4->nilaireal = $t->nilaireal;
                    $triwulan4->statusterakhir = $t->status;
                    $triwulan4->save();

                    
                }
                else{
                    $triwulan4 = new Triwulan4PTNBH;
                    $triwulan4->kode = ''.$t->kode;
                    $triwulan4->strategi = ''.$t->strategi;
                    $triwulan4->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan4->satuan = ''.$t->satuan;
                    $triwulan4->keterangan = ''.$t->keterangan;
                    $triwulan4->definisi = ''.$t->definisi;
                    $triwulan4->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan4->target = ''.$t->target;
                    $triwulan4->nilai = ''.$t->nilaireal;
                    $triwulan4->bukti1 = $t->bukti1;
                    $triwulan4->bukti2 = $t->bukti2;
                    $triwulan4->bukti3 = $t->bukti3;
                    $triwulan4->bukti4 = $t->bukti4;
                    $triwulan4->bukti5 = $t->bukti5;
                    $triwulan4->status = 'Belum Diupdate';
                    $triwulan4->nilaireal = $t->nilaireal;
                    $triwulan4->statusterakhir = $t->status;
                    $triwulan4->save();
                }
            }
            $triwulan2 = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();


                    $triwulan4 = new Triwulan4;
                    $triwulan4->kode = ''.$t->kode;
                    $triwulan4->strategi = ''.$t->strategi;
                    $triwulan4->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan4->satuan = ''.$t->satuan;
                    $triwulan4->keterangan = ''.$t->keterangan;
                    $triwulan4->definisi = ''.$t->definisi;
                    $triwulan4->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan4->target = ''.$t->target;
                    $triwulan4->nilai = ''.$t->nilaireal;
                    $triwulan4->bukti1 = $t->bukti1;
                    $triwulan4->bukti2 = $t->bukti2;
                    $triwulan4->bukti3 = $t->bukti3;
                    $triwulan4->bukti4 = $t->bukti4;
                    $triwulan4->bukti5 = $t->bukti5;
                    $triwulan4->status = 'Belum Diupdate';
                    $triwulan4->nilaireal = $t->nilaireal;
                    $triwulan4->statusterakhir = $t->status;
                    $triwulan4->save();

                    
                }
                else{
                    $triwulan4 = new Triwulan4;
                    $triwulan4->kode = ''.$t->kode;
                    $triwulan4->strategi = ''.$t->strategi;
                    $triwulan4->indikator_kinerja = ''.$t->indikator_kinerja;
                    $triwulan4->satuan = ''.$t->satuan;
                    $triwulan4->keterangan = ''.$t->keterangan;
                    $triwulan4->definisi = ''.$t->definisi;
                    $triwulan4->cara_perhitungan = ''.$t->cara_perhitungan;
                    $triwulan4->target = ''.$t->target;
                    $triwulan4->nilai = ''.$t->nilaireal;
                    $triwulan4->bukti1 = $t->bukti1;
                    $triwulan4->bukti2 = $t->bukti2;
                    $triwulan4->bukti3 = $t->bukti3;
                    $triwulan4->bukti4 = $t->bukti4;
                    $triwulan4->bukti5 = $t->bukti5;
                    $triwulan4->status = 'Belum Diupdate';
                    $triwulan4->nilaireal = $t->nilaireal;
                    $triwulan4->statusterakhir = $t->status;
                    $triwulan4->save();
                }
            }
            $triwulan->status = '0';
            $triwulan->update();
            $triwulan4 = Triwulan::where('triwulan', '=', '4')->first();
            $triwulan4->status = '1';
            $triwulan4->update();
            Alert::success('Berhasil!', 'Triwulan 3 Berhasil diakhiri');
           
            $triwulan = Triwulan::where('triwulan', '=', '4')->first();
            
            return redirect()->action([RealisasiPTNBHController::class, 'getRealisasi'], ['kode'=> $departemen->kode, 'triwulan'=> $triwulan->triwulan]);
        }
        elseif($triwulan->triwulan == '4'){
            $triwulan2 = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();


                    $realisasi = new RealisasiPTNBH;
                    $realisasi->kode = ''.$t->kode;
                    $realisasi->strategi = ''.$t->strategi;
                    $realisasi->indikator_kinerja = ''.$t->indikator_kinerja;
                    $realisasi->satuan = ''.$t->satuan;
                    $realisasi->keterangan = ''.$t->keterangan;
                    $realisasi->definisi = ''.$t->definisi;
                    $realisasi->cara_perhitungan = ''.$t->cara_perhitungan;
                    $realisasi->target = ''.$t->target;
                    $realisasi->nilai = ''.$t->nilaireal;
                    $realisasi->bukti1 = $t->bukti1;
                    $realisasi->bukti2 = $t->bukti2;
                    $realisasi->bukti3 = $t->bukti3;
                    $realisasi->bukti4 = $t->bukti4;
                    $realisasi->bukti5 = $t->bukti5;
                    $realisasi->status = $t->status;
                    $realisasi->nilaireal = $t->nilaireal;
                    $realisasi->save();

                    
                }
                else{
                    $realisasi = new RealisasiPTNBH;
                    $realisasi->kode = ''.$t->kode;
                    $realisasi->strategi = ''.$t->strategi;
                    $realisasi->indikator_kinerja = ''.$t->indikator_kinerja;
                    $realisasi->satuan = ''.$t->satuan;
                    $realisasi->keterangan = ''.$t->keterangan;
                    $realisasi->definisi = ''.$t->definisi;
                    $realisasi->cara_perhitungan = ''.$t->cara_perhitungan;
                    $realisasi->target = ''.$t->target;
                    $realisasi->nilai = ''.$t->nilaireal;
                    $realisasi->bukti1 = $t->bukti1;
                    $realisasi->bukti2 = $t->bukti2;
                    $realisasi->bukti3 = $t->bukti3;
                    $realisasi->bukti4 = $t->bukti4;
                    $realisasi->bukti5 = $t->bukti5;
                    $realisasi->status = $t->status;
                    $realisasi->nilaireal = $t->nilaireal;
                    $realisasi->save();
                }
            }
            $triwulan2 = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan2 as $t){
                if($t->status == 'Belum Diupdate'){

                    $t->status = $t->statusterakhir;
                    $t->update();


                    $realisasi = new Realisasi;
                    $realisasi->kode = ''.$t->kode;
                    $realisasi->strategi = ''.$t->strategi;
                    $realisasi->indikator_kinerja = ''.$t->indikator_kinerja;
                    $realisasi->satuan = ''.$t->satuan;
                    $realisasi->keterangan = ''.$t->keterangan;
                    $realisasi->definisi = ''.$t->definisi;
                    $realisasi->cara_perhitungan = ''.$t->cara_perhitungan;
                    $realisasi->target = ''.$t->target;
                    $realisasi->nilai = ''.$t->nilaireal;
                    $realisasi->bukti1 = $t->bukti1;
                    $realisasi->bukti2 = $t->bukti2;
                    $realisasi->bukti3 = $t->bukti3;
                    $realisasi->bukti4 = $t->bukti4;
                    $realisasi->bukti5 = $t->bukti5;
                    $realisasi->status = $t->status;
                    $realisasi->nilaireal = $t->nilaireal;
                    $realisasi->save();

                    
                }
                else{
                    $realisasi = new Realisasi;
                    $realisasi->kode = ''.$t->kode;
                    $realisasi->strategi = ''.$t->strategi;
                    $realisasi->indikator_kinerja = ''.$t->indikator_kinerja;
                    $realisasi->satuan = ''.$t->satuan;
                    $realisasi->keterangan = ''.$t->keterangan;
                    $realisasi->definisi = ''.$t->definisi;
                    $realisasi->cara_perhitungan = ''.$t->cara_perhitungan;
                    $realisasi->target = ''.$t->target;
                    $realisasi->nilai = ''.$t->nilaireal;
                    $realisasi->bukti1 = $t->bukti1;
                    $realisasi->bukti2 = $t->bukti2;
                    $realisasi->bukti3 = $t->bukti3;
                    $realisasi->bukti4 = $t->bukti4;
                    $realisasi->bukti5 = $t->bukti5;
                    $realisasi->status = $t->status;
                    $realisasi->nilaireal = $t->nilaireal;
                    $realisasi->save();
                }
            }
            $triwulan1 = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan2 = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan3 = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan4 = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan1 as $t){
                $t->delete();
            }
            foreach($triwulan2 as $t){
                $t->delete();
            }
            foreach($triwulan3 as $t){
                $t->delete();
            }
            foreach($triwulan4 as $t){
                $t->delete();
            }
            $triwulan1 = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan2 = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan3 = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->get();
            $triwulan4 = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->get();
            foreach($triwulan1 as $t){
                $t->delete();
            }
            foreach($triwulan2 as $t){
                $t->delete();
            }
            foreach($triwulan3 as $t){
                $t->delete();
            }
            foreach($triwulan4 as $t){
                $t->delete();
            }



            $triwulan->status = '0';
            $triwulan->update();
            $realisasi = Triwulan::where('triwulan', '=', '0')->first();
            $realisasi->status = '1';
            $realisasi->update();
            $tahun = Config::where('status', '=', '1')->first();
            $tahun->statusterakhir = '2';
            $tahun->update();
            Alert::success('Berhasil!', 'Triwulan 4 Berhasil diakhiri');
            
            $triwulan = Triwulan::where('triwulan', '=', '0')->first();
            
            return redirect()->action([RealisasiPTNBHController::class, 'getRealisasi'], ['kode'=> $departemen->kode, 'triwulan'=> $triwulan->triwulan]);
        }
        
        
        
    }


    public function downloadPDFRealisasi(Departemen $departemen, Triwulan $triwulan)
    {
        $pejabatDep = Pejabat::where('kode', 'like', $departemen->kode.'%')->first();
        $pejabatFak = Pejabat::where('kode', '=', '0099')->first();
        if($pejabatDep === null || $pejabatFak === null){
            Alert::error('Data Pejabat', 'Data pejabat belum diatur!');
            return redirect()->back();
        }
        
        if($triwulan->triwulan == '1'){
            $data = Triwulan1PTNBH::where('kode', 'like', $departemen->kode.'%')->get();
        }
        elseif($triwulan->triwulan == '2'){
            $data = Triwulan2PTNBH::where('kode', 'like', $departemen->kode.'%')->get();
        }
        elseif($triwulan->triwulan == '3'){
            $data = Triwulan3PTNBH::where('kode', 'like', $departemen->kode.'%')->get();
        }
        elseif($triwulan->triwulan == '4'){
            $data = Triwulan4PTNBH::where('kode', 'like', $departemen->kode.'%')->get();
        }
        elseif($triwulan->triwulan == '0'){
            $data = RealisasiPTNBH::where('kode', 'like', $departemen->kode.'%')->get();
        }
        
        //Gabung strategi 
        $combinedData = $data->groupBy('strategi')->map(function($group){
            $indikators = $group->pluck('indikator_kinerja')->toArray();
            $satuans = $group->pluck('satuan')->toArray();
            $targets = $group->pluck('target')->toArray();
            $keterangans = $group->pluck('keterangan')->toArray();
            $ketercapaians = $group->pluck('status')->toArray();
            $nilaireals = $group->pluck('nilaireal')->toArray();

            return [
                'strategi'=>$group->first()->strategi,
                'indikators' => $indikators,
                'satuans' => $satuans,
                'targets' => $targets,
                'keterangans' => $keterangans,
                'ketercapaians' => $ketercapaians,
                'nilaireals' => $nilaireals,

            ];
        });
        // dd($combinedData);


        // $view = view('ptnbh.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'));
        // dd($pdf);

        $tahun = DB::table('configs') -> where('status', '=', '1') -> pluck('tahun');
        if($triwulan != '0'){
            $filename = 'Realisasi PTNBH FSM '.$tahun[0].'_Departemen '.$departemen->nama.'Triwulan '.$triwulan->triwulan.'.pdf';
        }
        else{
            $filename = 'Realisasi PTNBH FSM '.$tahun[0].'_Departemen '.$departemen->nama.'.pdf';
        }
        


        $view = view('ptnbh.realisasi.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen', 'triwulan'))->render();


        // $pdf = new PDF();
        // $pdf->AddPage();
        // $pdf->WriteHTML($view);
        $pdf=PDF::loadView('ptnbh.realisasi.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen', 'triwulan'));
        $pdf->setOption('enable-local-file-access', true);

        // dd($pejabatDep);
        return $pdf->stream($filename);
        return view('ptnbh.realisasi.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen', 'triwulan')) ->with([
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRealisasiPTNBHRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($ptnbhdept, $triwulan, StoreRealisasiPTNBHRequest $request)
    {
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $targets = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> get();
        foreach($targets as $t){
            // $kode = $ptnbhdept.$indikator->kode;
            DB::statement("INSERT INTO triwulan1_p_t_n_b_h_s (kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan, target) SELECT kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan, target FROM target_p_t_n_b_h_s where kode='$t->kode'");
        }
        $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
        Alert::success('Berhasil!', 'Realisasi Berhasil dibuat');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RealisasiPTNBH  $realisasiPTNBH
     * @return \Illuminate\Http\Response
     */
    public function show(Departemen $departemen, Triwulan $triwulan,  $realisasi)
    {
        if($triwulan->triwulan == '1'){
            $realisasi = Triwulan1PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '2'){
            $realisasi = Triwulan2PTNBH::where('kode', '=', ''.$realisasi)->first();

        }
        elseif($triwulan->triwulan == '3'){
            $realisasi = Triwulan3PTNBH::where('kode', '=', ''.$realisasi)->first();

        }
        elseif($triwulan->triwulan == '4'){
            $realisasi = Triwulan4PTNBH::where('kode', '=', ''.$realisasi)->first();

        }
        elseif($triwulan->triwulan == '0'){
            $realisasi = RealisasiPTNBH::where('kode', '=', ''.$realisasi)->first();

        }
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
        $triwulan = Triwulan::where('status', '=', '1')->first();
        return view('ptnbh.realisasi.show', compact('departemen','realisasi', 'title', 'files', 'triwulan'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealisasiPTNBH  $realisasiPTNBH
     * @return \Illuminate\Http\Response
     */
    public function edit(RealisasiPTNBH $realisasiPTNBH)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRealisasiPTNBHRequest  $request
     * @param  \App\Models\RealisasiPTNBH  $realisasiPTNBH
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRealisasiPTNBHRequest $request, Departemen $departemen, Triwulan $triwulan, $realisasi)
    {
        //
        // dd($request);
        if($triwulan->triwulan == '1'){
            $realisasi = Triwulan1PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '2'){
            $realisasi = Triwulan2PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '3'){
            $realisasi = Triwulan3PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '4'){
            $realisasi = Triwulan4PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '0'){
            $realisasi = RealisasiPTNBH::where('kode', '=', ''.$realisasi)->first();
        }

        $validator= Validator::make($request->all(),[
            'nilai' => 'required',
        ]);

        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $temp_buktis = TempBuktiPTNBH::all();
        if($validator->fails()){
            foreach($temp_buktis as $temp_bukti){
                Storage::deleteDirectory('uploads/tmp/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$temp_bukti->folder);
                $temp_bukti->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Storage::deleteDirectory('uploads/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$realisasi->kode);
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
            'bukti1' => null,
            'bukti2' => null,
            'bukti3' => null,
            'bukti4' => null,
            'bukti5' => null,
            'status' => "Sedang Diproses",
        ];
        $realisasi->update($datarealisasi);

        if(count($temp_buktis)>5){
            Alert::error('Error!', 'Hanya bisa mengunggah sampai dengan 5 file.');
            return back();
        }
        else{
            
            foreach($temp_buktis as $key => $temp_bukti){
                Storage::copy('uploads/tmp/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$temp_bukti->folder.'/'.$temp_bukti->file, 'uploads/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$realisasi->kode.'/'.$temp_bukti->file);
                $path = 'uploads/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$realisasi->kode.'/'.$temp_bukti->file;
                $datarealisasi['bukti'.($key + 1)] = $path;
                Storage::deleteDirectory('uploads/tmp/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$temp_bukti->folder);
                $temp_bukti->delete();
            }
        }
        
        $realisasi->update($datarealisasi);
        Alert::success('Berhasil!', 'Data Realisasi berhasil disimpan');
        return redirect(route('ptnbh.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]));
    }
    
    public function update2(UpdateRealisasiPTNBHRequest $request, Departemen $departemen, Triwulan $triwulan, $realisasi)
    {
        //
        if($triwulan->triwulan == '1'){
            $realisasi = Triwulan1PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '2'){
            $realisasi = Triwulan2PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '3'){
            $realisasi = Triwulan3PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '4'){
            $realisasi = Triwulan4PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '0'){
            $realisasi = RealisasiPTNBH::where('kode', '=', ''.$realisasi)->first();
        }

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
        $triwulan = Triwulan::where('status', '=', '1')->first();

        Alert::success('Berhasil!', 'Data Realisasi berhasil disimpan');
        return redirect(route('ptnbh.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealisasiPTNBH  $realisasiPTNBH
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealisasiPTNBH $realisasiPTNBH)
    {
        //
    }

    public function form(Departemen $departemen,Triwulan $triwulan, $realisasi){
        if($triwulan->triwulan == '1'){
            $realisasi = Triwulan1PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '2'){
            $realisasi = Triwulan2PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '3'){
            $realisasi = Triwulan3PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '4'){
            $realisasi = Triwulan4PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '0'){
            $realisasi = RealisasiPTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        // dd($realisasi);
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
        return view('ptnbh.realisasi.form', compact('departemen','realisasi', 'title', 'files', 'triwulan'))->with([
            'user'=> Auth::user()
        ]);
    }

    public function tmpUpload(Request $request, Departemen $departemen, Triwulan $triwulan, $realisasi){
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        if($triwulan->triwulan == '1'){
            $realisasi = Triwulan1PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '2'){
            $realisasi = Triwulan2PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '3'){
            $realisasi = Triwulan3PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '4'){
            $realisasi = Triwulan4PTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        elseif($triwulan->triwulan == '0'){
            $realisasi = RealisasiPTNBH::where('kode', '=', ''.$realisasi)->first();
        }
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            
            $originalName = $files->getClientOriginalName();
            $folder = uniqid($realisasi->kode.'-', true);
            $files->storeAs('uploads/tmp/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$folder, $originalName, 'public');
                TempBuktiPTNBH::create([
                    'folder' => $folder,
                    'file' => $originalName
                ]);

            return $folder;
        }
    }

    public function tmpDelete(){
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $triwulan = DB::table('triwulans') -> where('status', '=', '1') -> first();
        $temp_bukti = TempBuktiPTNBH::where('folder', request()->getContent())->first();
        if($temp_bukti){
            Storage::deleteDirectory('uploads/tmp/'.$tahun->tahun.'/'.$triwulan->triwulan.'/'.$temp_bukti->folder);
            $temp_bukti->delete();
        }
        return response()->noContent();
    }

}
