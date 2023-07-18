<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Config;
use App\Models\Realisasi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class RenstraController extends Controller
{
    //
    public function index(){
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '<>', '00')->get();

        //realisasi - target yang tercapai
        $jmlrealisasis = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->count();
        $jmlrealisasis0 = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '=', 'Tidak Tercapai')->count();
        $jmlrealisasis1 = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '=', 'Tercapai')->count();
        $jmlrealisasis2 = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '=', 'Melampaui Target')->count();
        $jmlrealisasis3 = $jmlrealisasis - ($jmlrealisasis0+$jmlrealisasis1+$jmlrealisasis2);

        $dataPoints = array($jmlrealisasis0,$jmlrealisasis1,$jmlrealisasis2,$jmlrealisasis3); 
        
        $jmldept = $dept->count();

        //data Target
        $targetdisetujui=[];
        $targetditolak=[];
        $targetmenunggupersetujuan = [];
        $namadepartemen=[];
        for($i=1; $i<=$jmldept;$i++){
            $jmlapprovetarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '1')->count();
            $jmlrejecttarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '3')->count();
            $jmlwaitingtarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '2')->count();
            $deptname = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            $targetdisetujui[]=$jmlapprovetarget;
            $targetditolak[]=$jmlrejecttarget;
            $targetmenunggupersetujuan[]=$jmlwaitingtarget;
            $namadepartemen[]=$deptname->nama;
        }

        // Jumlah Target yang telah disetujui 
        $targetapproved= array();
        for($i=1; $i<=$jmldept;$i++){
            $jmlapprovetarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '1')->count();
            $namadept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            // dd($namadept);
            $targetapproved=Arr::add($targetapproved, $i, ['departemen'=>$namadept->nama, 'jumlah'=>$jmlapprovetarget]);
        } 
        
        // Jumlah Target yang ditolak
        $targetreject= array();
        for($i=1; $i<=$jmldept;$i++){
            $jmlrejecttarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '3')->count();
            $namadept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            // dd($namadept);
            $targetreject=Arr::add($targetreject, $i, ['departemen'=>$namadept->nama, 'jumlah'=>$jmlrejecttarget]);
        } 

        // Jumlah Target yang menunggu persetujuan
        $targetwaiting= array();
        for($i=1; $i<=$jmldept;$i++){
            $jmlwaitingtarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '2')->count();
            $namadept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            // dd($namadept);
            $targetwaiting=Arr::add($targetwaiting, $i, ['departemen'=>$namadept->nama, 'jumlah'=>$jmlwaitingtarget]);
        } 

        // // Jumlah Target yang menunggu persetujuan
        $ketercapaiantargetdept= array();
        for($i=1; $i<=$jmldept;$i++){
            $namadept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            $jmltotalrealisasidept = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
            if($jmltotalrealisasidept>0){
                $tidaktercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                $tercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                $melampauitarget = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                $sedangdiproses = $jmltotalrealisasidept - ($tidaktercapai+$tercapai+$melampauitarget);
            }else{
                $tidaktercapai = '-';
                $tercapai = '-';
                $melampauitarget = '-';
                $sedangdiproses ='-';
            }
            $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namadept->nama, '0'=>$tidaktercapai,'1'=>$tercapai,'2'=>$melampauitarget,'3'=>$sedangdiproses,'kode'=>'0'.$i]);
        } 

        //jumlah realiassi yang belum dicek oleh fakultas
        $RealisasiUncheck=array();
        for($i=1; $i<=$jmldept;$i++){
            $jmluncheckrealisasi = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', null)->count();
            $namadept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
            // dd($namadept);
            $RealisasiUncheck=Arr::add($RealisasiUncheck, $i, ['kode'=>'0'.$i,'departemen'=>$namadept->nama, 'jumlah'=>$jmluncheckrealisasi]);
        } 

        return view('renstra.dashboard', compact('jmldept','departemens','actConfig','dept','jmlrealisasis','jmlrealisasis0','jmlrealisasis1','jmlrealisasis2','jmlrealisasis3','dataPoints','ketercapaiantargetdept','targetapproved','targetreject','targetwaiting','RealisasiUncheck','namadepartemen','targetdisetujui','targetditolak','targetmenunggupersetujuan'))->with([
            'user'=> Auth::user()
        ]);
    }
}
