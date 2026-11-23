<?php

namespace App\Http\Controllers;

use App\Models\config;
use App\Models\Target;
use App\Models\Pejabat;
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
use App\Models\Triwulan;
use PDF;


class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departemens = Departemen::where('kode', '<>', '00')->get();
        $title = 'Target Departemen ';
        $triwulan = Triwulan::where('status', '=', '1')->first();
        return view('renstra.target.index', compact('departemens','title', 'triwulan')) ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * mendisplay tabel target sesuai dengan departemen.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTarget($renstradept)
    {
        $authUser = Auth::user();
        if ($authUser->level == 2 && substr($authUser->kode, 0, 2) !== $renstradept) {
            abort(403, 'Anda tidak punya akses ke departemen ini.');
        }

        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        // dd($actConfig);
        if($actConfig===null){
            Alert::error('Gagal!', "Config Tahun Belum diatur");
            return redirect()->back();
        }else{
            $namadept = DB::table('departemens') -> where('kode', '=', $renstradept)->first();
            $targets = Target::where('kode', 'like', $renstradept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> paginate(10);
            $t= $namadept->nama." ".$actConfig->tahun;
            $title = 'Target Departemen '.$t;
            // dd($title);
            if($targets->count()==0){
                return view('renstra.target.uncreate', compact('title', 'renstradept', 'triwulan')) ->with([
                    'user'=> Auth::user()
                ]);
            }
            else{
                $s = DB::table('targets') -> where('kode', 'like', $renstradept.'%') -> where('status', '!=', "1")-> count();
                // dd($status);
                $status=0;
                if($s>0){
                    $status=2;
                }else{
                    $status=1;
                }
                $departemens = Departemen::all();
                return view('renstra.target.target', compact('targets', 'departemens', 'title', 'renstradept',"status", 'triwulan')) ->with([
                    'user'=> Auth::user()
                ]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($renstradept)
    {
        //
        // $strategis = Strategi::all();
        // $departemens = Departemen::all();
        // $dept = Departemen::where('kode', '=', $renstradept)->pluck('nama');
        // return view('renstra.target.create', compact('departemens', 'strategis', 'renstradept', 'dept'))->with([
        //     'user'=> Auth::user()
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($renstradept, StoreTargetRequest $request)
    {
        $this->authorizeDepartmentAccess($renstradept);
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $indikatorlama = DB::table('indikators') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // dd($indikatorlama);
        $jmlindikatorlama = count($indikatorlama);
        $errmsg = 'Config Indikator untuk tahun '.$tahun->tahun.' belum diatur.';
        if($jmlindikatorlama==0){
            Alert::error('Gagal!', $errmsg);
            return redirect()->back();
        }else{
            foreach($indikatorlama as $indikator){
                DB::statement(
                    "INSERT INTO targets (kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan) SELECT CONCAT(?, kode), strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan FROM indikators WHERE kode = ?",
                    [$renstradept, $indikator->kode]
                );
            }
            $namadept = DB::table('departemens') -> where('kode', '=', $renstradept)->first();
            Alert::success('Berhasil!', 'Target Berhasil dibuat');
            return redirect()->back();
        // return redirect(route('renstra.target.index', $renstradept));
        }
        // dd($target);

        // $request->validate([
        //     'indikator_kinerja' => 'required',
        //     'strategi' => 'required',
        //     'tahun' => 'required',
        //     'departemen' => 'required',
        //     'target' => 'required',
        // ]);
        // $request->request->add(['kode' => ''.$kode]);
        // $request->merge(['strategi' => ''.$strategi->nama]);
        // $request->merge(['indikator_kinerja' => ''.$indikator[0]]);

        // // dd($request);
        // if($target==null){
        //     Target::create($request->all());
        //     Alert::success('Berhasil!', 'Target baru berhasil ditambahkan');
        //     return redirect(route('renstra.target.index', $renstradept));
        // }
        // else{
        //     Alert::error('Gagal!', 'Target untuk indikator ini telah diatur.');
        //     return redirect(route('renstra.target.index', $renstradept));
        // }
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
    public function edit($kode)
    {   
        $this->authorizeDepartmentAccess($kode);
        $target = DB::table('targets') -> where('kode', '=', $kode) -> first();
        if($target && ($target->status == 2 || $target->status == 3)){
            DB::table('targets')->where('kode', $kode)->update(['status' => '4']);
            return redirect()->back();
        }else{
            Alert::error('Gagal!', 'Nilai target sedang diedit user lain');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetRequest  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetRequest $request, $kode)
    {   
        $this->authorizeDepartmentAccess($kode);
        $target = DB::table('targets') -> where('kode', '=', $kode) -> first();
        // dd($target);
        if($target && ($target->status == 4 || $target->status == 0)){
            $value=$request->target;
            if($value!=null){
                // dd($value);
                if($value != $target->target){
                    DB::table('targets')->where('kode', $kode)->update([
                        'status' => '2',
                        'target' => $value,
                    ]);
                    Alert::success('Berhasil!', 'Target berhasil diupdate');
                    return redirect()->back();
                }else{
                    Alert::error('Gagal!', 'Anda belum merubah nilai target.');
                    return redirect()->back();    
                }
            }else{
                Alert::error('Gagal!', 'Anda belum mengisi nilai target.');
                return redirect()->back();    
            }
        }else{
            Alert::error('Gagal!', 'Target untuk indikator ini sudah direvisi, mohon cek ulang nilai target.');
            return redirect()->back();
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetRequest  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function setujui($kode){
        DB::table('targets')->where('kode', $kode)->update(['status' => '1']);
        return redirect()->back();
    }
    public function tolak($kode){
        DB::table('targets')->where('kode', $kode)->update(['status' => '3']);
        return redirect()->back();
    }
    public function batal($kode){
        DB::table('targets')->where('kode', $kode)->update(['status' => '2']);
        return redirect()->back();
    }
    public function AllAprove($renstradept){
        DB::table('targets')->where('kode', 'like', $renstradept . '%')->where('status', '2')->update(['status' => '1']);
        return redirect()->back();
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

    /*
    Download PDF Target
    */

    public function downloadPDFTarget(Departemen $departemen)
    {
        $this->authorizeDepartmentAccess($departemen->kode);
        $pejabatDep = Pejabat::where('kode', 'like', $departemen->kode.'%')->first();
        $pejabatFak = Pejabat::where('kode', '=', '0099')->first();
        if($pejabatDep === null || $pejabatFak === null){
            Alert::error('Data Pejabat', 'Data pejabat belum diatur!');
            return redirect()->back();
        }
        
        
        $data = Target::where('kode', 'like', $departemen->kode.'%')->get();
        //Gabung strategi 
        $combinedData = $data->groupBy('strategi')->map(function($group){
            $indikators = $group->pluck('indikator_kinerja')->toArray();
            $satuans = $group->pluck('satuan')->toArray();
            $targets = $group->pluck('target')->toArray();
            $keterangans = $group->pluck('keterangan')->toArray();
            return [
                'strategi'=>$group->first()->strategi,
                'indikators' => $indikators,
                'satuans' => $satuans,
                'targets' => $targets,
                'keterangans' => $keterangans,

            ];
        });


        // $view = view('renstra.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'));
        // dd($pdf);

        $tahun = DB::table('configs') -> where('status', '=', '1') -> pluck('tahun');
        $filename = 'Target Renstra FSM '.$tahun[0].'_'.$departemen->nama.'.pdf';


        $view = view('renstra.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'))->render();


        // $pdf = new PDF();
        // $pdf->AddPage();
        // $pdf->WriteHTML($view);
        $pdf=PDF::loadView('renstra.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'));
        $pdf->setOption('enable-local-file-access', true);

        // dd($pejabatDep);
        return $pdf->stream($filename.'.pdf');
        return view('renstra.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen')) ->with([
            'user'=> Auth::user()
        ]);
    }
}
