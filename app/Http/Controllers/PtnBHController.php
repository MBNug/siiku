<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\TargetPTNBH;
use App\Models\IndikatorPTNBH;
use App\Models\Config;
use App\Models\Triwulan;
use App\Models\Triwulan1PTNBH;
use App\Models\Triwulan2PTNBH;
use App\Models\Triwulan3PTNBH;
use App\Models\Triwulan4PTNBH;
use App\Models\RealisasiPTNBH;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class PtnBHController extends Controller
{
    public function index(){
        $levelakun = Auth::user();
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $title = "Dashboard";
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $check = 0;
        $err=0;
        if($actConfig==null){
            $err = 1;
            return view('ptnbh.dashboard', compact('err'))->with([
                'user'=> Auth::user()
            ]);
        }

        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '<>', '00')->get();
        $jmldept = $dept->count();
        $jmlindikator = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->count()/$jmldept;
        $indikator = IndikatorPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->count();
        $jmltarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->count();
        $jmlbelumdisetujui = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '<>', '1')->count();
        $jmlrealisasi = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->count();

        
        //dekan dan fakultas
        if ($levelakun->level <2){
            if($jmlbelumdisetujui!=0){
                //fase pengisian Target
                $targetdisetujui=[];
                $targetditolak=[];
                $targetmenunggupersetujuan = [];
                $namadepartemen=[];
                if($jmlbelumdisetujui>0){    
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmlapprovetarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', '1')->count();
                        $jmlrejecttarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', '3')->count();
                        $jmlwaitingtarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', '2')->count();
                        $targetdisetujui[]=$jmlapprovetarget;
                        $targetditolak[]=$jmlrejecttarget;
                        $targetmenunggupersetujuan[]=$jmlwaitingtarget;
                        $namadepartemen[]=$dept[$i]->nama;
                    }
                }
                return view('ptnbh.dashboard', compact('actConfig','err','title','triwulan','targetdisetujui','targetditolak','targetmenunggupersetujuan','namadepartemen','jmlbelumdisetujui','jmlindikator','jmltarget','jmlrealisasi','indikator'))->with([
                    'user'=> Auth::user()
                ]);
            }else{ //fase pengisian Realisasi
                $jmltriwulan1 = Triwulan1PTNBH::count();
                $ketercapaiantargetdept= array();
                $jmlmelampaui = 0; 
                $jmltercapai = 0;
                $jmltidaktercapai = 0;
                $jmlmenunggu = 0; 
                $jmlbelumdiupdate = 0;
                $namadept=[]; 
                $ketercapaianpertriwulan=[];
                if($triwulan->triwulan == '1'){
                    if ($jmltriwulan1==0){
                        return view('ptnbh.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','jmltriwulan1','check','jmlindikator','jmltarget','jmlrealisasi','indikator'))->with([
                            'user'=> Auth::user()
                        ]);
                    }
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '2'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '3'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '4'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '0'){
                    $check = 1;
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                // dd($namadept);
                return view('ptnbh.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','ketercapaiantargetdept','jmltriwulan1','ketercapaianpertriwulan','namadept','check','jmltarget','jmlrealisasi','indikator'))->with([
                    'user'=> Auth::user()
                ]);
            }
        }else{//departemen

            // /////////////////////////////////////////////////////
            $jmltriwulan1 = Triwulan1PTNBH::count();
            $ketercapaiantargetdept= array();
            $jmlmelampaui = 0; 
            $jmltercapai = 0;
            $jmltidaktercapai = 0;
            $jmlmenunggu = 0; 
            $jmlbelumdiupdate = 10;
            $triwulanY=[]; 
            $ketercapaianpertriwulan=[];
            $kode = substr(Auth::user()->kode, 0, 2);
            
            for($i=1; $i<=4;$i++){
                if($i==1){
                    $jmltotalrealisasidept = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                    
                }
                elseif($i==2){
                    $jmltotalrealisasidept = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }
                elseif($i==3){
                    $jmltotalrealisasidept = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }
                elseif($i==4){
                    $jmltotalrealisasidept = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }else{
                    $jmltotalrealisasidept = RealisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }

                if($jmltotalrealisasidept>0){
                    if($i==1){
                        $jmltidaktercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==2){
                        $jmltidaktercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==3){
                        $jmltidaktercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==4){
                        $jmltidaktercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }else{
                        $jmltidaktercapai = realisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = realisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = realisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = realisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = realisasiPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }                    
                }else{
                    $jmltidaktercapai = '-';
                    $jmltercapai = '-';
                    $jmlmelampauitarget = '-';
                    $jmlmenunggu = '-';
                    $jmlbelumdiupdate ='-';
                    $totalketercapaian = 0;
                }
                // dd($i);
                $ketercapaianpertriwulan[]=$totalketercapaian;
                $triwulanY[]=$i;
                $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['triwulan'=>$i, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate]);
                // dd($ketercapaiantargetdept);
            }
            return view('ptnbh.dashboard', compact('err','title','triwulan','jmltarget','jmlindikator','jmlbelumdisetujui','jmltriwulan1','check','actConfig','jmlrealisasi','indikator','ketercapaianpertriwulan','triwulanY','ketercapaiantargetdept','kode'))->with([
                'user'=> Auth::user()
            ]);
        }
    }
    public function gantiData(Request $request){
        $levelakun = Auth::user();
        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $title = "Dashboard";
        $triwulan = $request;
        $check = 0;
        // dd($triwulan->triwulan);
        $err=0;
        if($actConfig==null){
            $err = 1;
            return view('ptnbh.dashboard', compact('err'))->with([
                'user'=> Auth::user()
            ]);
        }

        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '<>', '00')->get();
        $jmldept = $dept->count();
        $jmlindikator = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->count()/$jmldept;
        
        //dekan dan fakultas
        if ($levelakun->level <2){
            $jmlbelumdisetujui = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '<>', '1')->count();
            
            if($jmlbelumdisetujui!=0){
                //fase pengisian Target
                $targetdisetujui=[];
                $targetditolak=[];
                $targetmenunggupersetujuan = [];
                $namadepartemen=[];
                if($jmlbelumdisetujui>0){            
                    for($i=1; $i<=$jmldept;$i++){
                        $jmlapprovetarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '1')->count();
                        $jmlrejecttarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '3')->count();
                        $jmlwaitingtarget = TargetPTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', '2')->count();
                        $deptname = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $targetdisetujui[]=$jmlapprovetarget;
                        $targetditolak[]=$jmlrejecttarget;
                        $targetmenunggupersetujuan[]=$jmlwaitingtarget;
                        $namadepartemen[]=$deptname->nama;
                    }
                }
                return view('ptnbh.dashboard', compact('err','title','triwulan','targetdisetujui','targetditolak','targetmenunggupersetujuan','namadepartemen','jmlbelumdisetujui','jmlindikator'))->with([
                    'user'=> Auth::user()
                ]);
            }else{ //fase pengisian Realisasi
                $jmltriwulan1 = Triwulan1PTNBH::count();
                $ketercapaiantargetdept= array();
                $jmlmelampaui = 0; 
                $jmltercapai = 0;
                $jmltidaktercapai = 0;
                $jmlmenunggu = 0; 
                $jmlbelumdiupdate = 0;
                $namadept=[]; 
                $ketercapaianpertriwulan=[];
                if($triwulan->triwulan == '1'){
                    if ($jmltriwulan1==0){
                        return view('ptnbh.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','jmltriwulan1','check'))->with([
                            'user'=> Auth::user()
                        ]);
                    }
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan1PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '2'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan2PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '3'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan3PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }
                elseif($triwulan->triwulan == '4'){
                    for($i=0; $i<$jmldept;$i++){
                        $kode=$dept[$i]->kode;
                        $jmltotalrealisasidept = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan4PTNBH::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Belum Diupdate')->count();
                            $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                        }else{
                            $jmltidaktercapai = '-';
                            $jmltercapai = '-';
                            $jmlmelampauitarget = '-';
                            $jmlmenunggu = '-';
                            $jmlbelumdiupdate ='-';
                            $totalketercapaian = 0;
                        }
                        $ketercapaianpertriwulan[]=$totalketercapaian;
                        $namadept[]=$dept[$i]->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$dept[$i]->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>$kode]);
                    }
                }

                // dd($namadept);
                return view('ptnbh.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','ketercapaiantargetdept','jmltriwulan1','ketercapaianpertriwulan','namadept','check'))->with([
                    'user'=> Auth::user()
                ]);
            }
        }else{//departemen
            
            return view('ptnbh.dashboard', compact('err','title','triwulan','cek'))->with([
                'user'=> Auth::user()
            ]);
        }
    }
}

