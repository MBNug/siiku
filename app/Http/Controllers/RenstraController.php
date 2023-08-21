<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Config;
use App\Models\Triwulan;
use App\Models\Triwulan1;
use App\Models\Triwulan2;
use App\Models\Triwulan3;
use App\Models\Triwulan4;
use App\Models\Realisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class RenstraController extends Controller
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
            return view('renstra.dashboard', compact('err'))->with([
                'user'=> Auth::user()
            ]);
        }

        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '<>', '00')->get();
        $jmldept = $dept->count();
        $jmlindikator = Target::where('kode', 'like', '%'.$actConfig->tahun)->count()/$jmldept;
        $indikator = Indikator::where('kode', 'like', '%'.$actConfig->tahun)->count();
        $jmltarget = Target::where('kode', 'like', '%'.$actConfig->tahun)->count();
        $jmlbelumdisetujui = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '<>', '1')->count();
        $jmlrealisasi = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->count();

        
        //dekan dan fakultas
        if ($levelakun->level <2){
            if($jmlbelumdisetujui!=0){
                //fase pengisian Target
                $targetdisetujui=[];
                $targetditolak=[];
                $targetmenunggupersetujuan = [];
                $namadepartemen=[];
                if($jmlbelumdisetujui>0){            
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
                }
                return view('renstra.dashboard', compact('actConfig','err','title','triwulan','targetdisetujui','targetditolak','targetmenunggupersetujuan','namadepartemen','jmlbelumdisetujui','jmlindikator','jmltarget','jmlrealisasi','indikator'))->with([
                    'user'=> Auth::user()
                ]);
            }else{ //fase pengisian Realisasi
                $jmltriwulan1 = Triwulan1::count();
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
                        return view('renstra.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','jmltriwulan1','check','jmlindikator','jmltarget','jmlrealisasi','indikator'))->with([
                            'user'=> Auth::user()
                        ]);
                    }
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '2'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();;
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '3'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '4'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '0'){
                    $check = 1;
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                // dd($namadept);
                return view('renstra.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','ketercapaiantargetdept','jmltriwulan1','ketercapaianpertriwulan','namadept','check','jmltarget','jmlrealisasi','indikator'))->with([
                    'user'=> Auth::user()
                ]);
            }
        }else{//departemen

            // /////////////////////////////////////////////////////
            $jmltriwulan1 = Triwulan1::count();
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
                    $jmltotalrealisasidept = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                    
                }
                elseif($i==2){
                    $jmltotalrealisasidept = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }
                elseif($i==3){
                    $jmltotalrealisasidept = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }
                elseif($i==4){
                    $jmltotalrealisasidept = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }else{
                    $jmltotalrealisasidept = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                }

                if($jmltotalrealisasidept>0){
                    if($i==1){
                        $jmltidaktercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==2){
                        $jmltidaktercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==3){
                        $jmltidaktercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }
                    elseif($i==4){
                        $jmltidaktercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
                        $totalketercapaian = $jmltercapai + $jmlmelampauitarget;
                    }else{
                        $jmltidaktercapai = realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tidak Tercapai')->count();
                        $jmltercapai = realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Tercapai')->count();
                        $jmlmelampauitarget = realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Melampaui Target')->count();
                        $jmlmenunggu = realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->where('status', '=', 'Sedang Diproses')->count();
                        $jmlbelumdiupdate = realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', $kode.'%')->count();
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
            return view('renstra.dashboard', compact('err','title','triwulan','jmltarget','jmlindikator','jmlbelumdisetujui','jmltriwulan1','check','actConfig','jmlrealisasi','indikator','ketercapaianpertriwulan','triwulanY','ketercapaiantargetdept','kode'))->with([
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
            return view('renstra.dashboard', compact('err'))->with([
                'user'=> Auth::user()
            ]);
        }

        $departemens = Departemen::all();
        $dept = Departemen::where('kode', '<>', '00')->get();
        $jmldept = $dept->count();
        $jmlindikator = Target::where('kode', 'like', '%'.$actConfig->tahun)->count()/$jmldept;
        
        //dekan dan fakultas
        if ($levelakun->level <2){
            $jmlbelumdisetujui = Target::where('kode', 'like', '%'.$actConfig->tahun)->where('status', '<>', '1')->count();
            
            if($jmlbelumdisetujui!=0){
                //fase pengisian Target
                $targetdisetujui=[];
                $targetditolak=[];
                $targetmenunggupersetujuan = [];
                $namadepartemen=[];
                if($jmlbelumdisetujui>0){            
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
                }
                return view('renstra.dashboard', compact('err','title','triwulan','targetdisetujui','targetditolak','targetmenunggupersetujuan','namadepartemen','jmlbelumdisetujui','jmlindikator'))->with([
                    'user'=> Auth::user()
                ]);
            }else{ //fase pengisian Realisasi
                $jmltriwulan1 = Triwulan1::count();
                $ketercapaiantargetdept= array();
                $jmlmelampaui = 0; 
                $jmltercapai = 0;
                $jmltidaktercapai = 0;
                $jmlmenunggu = 0; 
                $jmlbelumdiupdate = 0;
                $namadept=[]; 
                $ketercapaianpertriwulan=[];
                // dd($triwulan);
                if($triwulan->triwulan == '1'){
                    // dd($triwulan->triwulan);
                    if ($jmltriwulan1==0){
                        return view('renstra.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','jmltriwulan1','check'))->with([
                            'user'=> Auth::user()
                        ]);
                    }
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan1::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '2'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan2::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();;
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '3'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan3::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '4'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Triwulan4::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }
                elseif($triwulan->triwulan == '0'){
                    for($i=1; $i<=$jmldept;$i++){
                        $namedept = DB::table('departemens') -> where('kode', '=', '0'.$i)->first();
                        $jmltotalrealisasidept = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->count();
                        if($jmltotalrealisasidept>0){
                            $jmltidaktercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tidak Tercapai')->count();
                            $jmltercapai = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Tercapai')->count();
                            $jmlmelampauitarget = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Melampaui Target')->count();
                            $jmlmenunggu = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Sedang Diproses')->count();
                            $jmlbelumdiupdate = Realisasi::where('kode', 'like', '%'.$actConfig->tahun)->where('kode', 'like', '0'.$i.'%')->where('status', '=', 'Belum Diupdate')->count();
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
                        $namadept[]=$namedept->nama;
                        $ketercapaiantargetdept=Arr::add($ketercapaiantargetdept, $i, ['departemen'=>$namedept->nama, '0'=>$jmlmelampauitarget,'1'=>$jmltercapai,'2'=>$jmltidaktercapai,'3'=>$jmlmenunggu,'4'=>$jmlbelumdiupdate,'kode'=>'0'.$i]);
                    }
                }

                // dd($namadept);
                return view('renstra.dashboard', compact('actConfig','err','title','triwulan','jmlbelumdisetujui','jmlindikator','ketercapaiantargetdept','jmltriwulan1','ketercapaianpertriwulan','namadept','check'))->with([
                    'user'=> Auth::user()
                ]);
            }
        }else{//departemen
            
            return view('renstra.dashboard', compact('err','title','triwulan','cek'))->with([
                'user'=> Auth::user()
            ]);
        }
    }
}

