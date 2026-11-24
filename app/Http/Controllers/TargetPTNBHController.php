<?php

namespace App\Http\Controllers;


use App\Models\Pejabat;
use App\Models\Departemen;
use App\Models\TargetPTNBH;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTargetPTNBHRequest;
use App\Models\Triwulan;
use App\Http\Requests\UpdateTargetPTNBHRequest;
use PDF;

class TargetPTNBHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departemens = Departemen::where('kode', '<>', '00')->get();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        $title = 'Target Departemen ';
        return view('ptnbh.target.index', compact('departemens','title','triwulan')) ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * mendisplay tabel target sesuai dengan departemen.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTarget($ptnbhdept)
    {
        $authUser = Auth::user();
        if ($authUser->level == 2 && substr($authUser->kode, 0, 2) !== $ptnbhdept) {
            abort(403, 'Anda tidak punya akses ke departemen ini.');
        }

        $actConfig = DB::table('configs') -> where('status', '=', '1') -> first();
        $triwulan = Triwulan::where('status', '=', '1')->first();
        // dd($actConfig);
        if($actConfig===null){
            Alert::error('Gagal!', "Config Tahun Belum diatur");
            return redirect()->back();
        }else{
            $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
            if (!$namadept) {
                abort(404);
            }
            $targets = TargetPTNBH::where('kode', 'like', $ptnbhdept.'%')-> where('kode', 'like', '%'.$actConfig->tahun) -> paginate(10);
            $t= $namadept->nama." ".$actConfig->tahun;
            $title = 'Target Departemen '.$t;
            // dd($title);
            if($targets->count()==0){
                return view('ptnbh.target.uncreate', compact('title', 'ptnbhdept','triwulan')) ->with([
                    'user'=> Auth::user()
                ]);
            }
            else{
                $s = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', $ptnbhdept.'%') -> where('status', '!=', "1")-> count();
                // dd($status);
                $status=0;
                if($s>0){
                    $status=2;
                }else{
                    $status=1;
                }
                $departemens = Departemen::all();
                return view('ptnbh.target.target', compact('targets', 'departemens', 'title', 'ptnbhdept',"status")) ->with([
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
    public function create($ptnbhdept)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($ptnbhdept, StoreTargetPTNBHRequest $request)
    {
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $this->authorizeDepartmentAccess($ptnbhdept);
        $indikatorlama = DB::table('indikator_p_t_n_b_h_s') -> where('kode', 'like', '%'.$tahun->tahun) -> get();
        // dd($indikatorlama);
        $jmlindikatorlama = count($indikatorlama);
        $errmsg = 'Config Indikator untuk tahun '.$tahun->tahun.' belum diatur.';
        if($jmlindikatorlama==0){
            Alert::error('Gagal!', $errmsg);
            return redirect()->back();
        }else{
            foreach($indikatorlama as $indikator){
                DB::statement(
                    "INSERT INTO target_p_t_n_b_h_s (kode, strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan) SELECT CONCAT(?, kode), strategi, indikator_kinerja, satuan, keterangan, definisi, cara_perhitungan FROM indikator_p_t_n_b_h_s WHERE kode = ?",
                    [$ptnbhdept, $indikator->kode]
                );
            }
            $namadept = DB::table('departemens') -> where('kode', '=', $ptnbhdept)->first();
            Alert::success('Berhasil!', 'Target Berhasil dibuat');
            return redirect()->back();
       
        }
        
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetPTNBH  $target
     * @return \Illuminate\Http\Response
     */
    public function show(TargetPTNBH $target)
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
        $target = DB::table('target_p_t_n_b_h_s') -> where('kode', '=', $kode) -> first();
        if($target && ($target->status == 2 || $target->status == 3)){
            DB::table('target_p_t_n_b_h_s')->where('kode', $kode)->update(['status' => '4']);
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
    public function update(UpdateTargetPTNBHRequest $request, $kode)
    {   
        $this->authorizeDepartmentAccess($kode);
        $target = DB::table('target_p_t_n_b_h_s') -> where('kode', '=', $kode) -> first();
        // dd($target);
        if($target && ($target->status == 4 || $target->status == 0)){
            $value=$request->target;
            if($value!=null){
                // dd($value);
                if($value != $target->target){
                    DB::table('target_p_t_n_b_h_s')->where('kode', $kode)->update([
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
    public function destroy(TargetPTNBH $target)
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
        DB::table('target_p_t_n_b_h_s')->where('kode', $kode)->update(['status' => '1']);
        return redirect()->back();
    }
    public function tolak($kode){
        DB::table('target_p_t_n_b_h_s')->where('kode', $kode)->update(['status' => '3']);
        return redirect()->back();
    }
    public function batal($kode){
        DB::table('target_p_t_n_b_h_s')->where('kode', $kode)->update(['status' => '2']);
        return redirect()->back();
    }
    public function AllAprove($ptnbhdept){
        DB::table('target_p_t_n_b_h_s')->where('kode', 'like', $ptnbhdept . '%')->where('status', '2')->update(['status' => '1']);
        return redirect()->back();
    }
    
    /*
    Ajax
    */
    public function getIndikator($kode)
    {
        $definisi = DB::table('indikator_p_t_n_b_h_s')->where('kode', $kode)->pluck('definisi');
        $cara_perhitungan = DB::table('indikator_p_t_n_b_h_s')->where('kode', $kode)->pluck('cara_perhitungan');
        $satuan = DB::table('indikator_p_t_n_b_h_s')->where('kode', $kode)->pluck('satuan');
        $keterangan = DB::table('indikator_p_t_n_b_h_s')->where('kode', $kode)->pluck('keterangan');
        return Response::json(['success'=>true, 'definisi'=>$definisi, 'cara_perhitungan'=>$cara_perhitungan, 'satuan'=>$satuan, 'keterangan'=>$keterangan]);
    }
    public function getStrategi($kode='s')
    {
        $indikator['data'] = DB::table('indikator_p_t_n_b_h_s')->where('kode', 'like', $kode.'%')->select('kode', 'indikator_kinerja')->get();
        // return Response::json(['success'=>true]);
        return response()->json($indikator);

    }

    /*
    Download PDF Target
    */

    public function downloadPDFTarget(Departemen $departemen)
    {
        $this->authorizeDepartmentAccess($departemen->kode);
        $data = TargetPTNBH::where('kode', 'like', $departemen->kode.'%')->get();
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


        // $view = view('ptnbh.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'));
        // dd($pdf);
        $pejabatDep = Pejabat::where('kode', 'like', $departemen->kode.'%')->first();
        $pejabatFak = Pejabat::where('kode', '=', '0099')->first();

        $tahun = DB::table('configs') -> where('status', '=', '1') -> pluck('tahun');
        $filename = 'Target PTNBH FSM '.$tahun[0].'_'.$departemen->nama.'.pdf';


        $view = view('ptnbh.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'))->render();


        // $pdf = new PDF();
        // $pdf->AddPage();
        // $pdf->WriteHTML($view);
        $pdf=PDF::loadView('ptnbh.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen'));
        $pdf->setOption('enable-local-file-access', true);

        // dd($pejabatDep);
        return $pdf->stream($filename.'.pdf');
        return view('ptnbh.target.pdf', compact('combinedData', 'pejabatDep', 'pejabatFak', 'tahun', 'departemen')) ->with([
            'user'=> Auth::user()
        ]);
    }
}
