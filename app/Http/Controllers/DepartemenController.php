<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Target;
use App\Models\Realisasi;
use App\Models\Triwulan1;
use App\Models\Triwulan2;
use App\Models\Triwulan3;
use App\Models\Triwulan4;
use App\Models\Departemen;
use App\Models\TargetPTNBH;
use App\Models\RealisasiPTNBH;
use App\Models\Triwulan1PTNBH;
use App\Models\Triwulan2PTNBH;
use App\Models\Triwulan3PTNBH;
use App\Models\Triwulan4PTNBH;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departemens = Departemen::where('kode', '<>', '00')->get();
        

        return view('config.departemen.index', compact('departemens')) ->with([
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
        return view('config.departemen.create') ->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartemenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartemenRequest $request)
    {
        //
        $dep = Departemen::where('kode', '=', $request->kode)->first();
        // dd($dep);
        $request->validate([
            'kode' => 'required|unique:departemens,kode',
            'nama' => 'required|unique:departemens,nama',
        ]);
        if($dep === null){
            $newuser1 = [
                'kode' => $request->kode.'01',
                'name' => "Kadep ".$request->nama, 
                'username' => "kadep".$request->nama, 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadep".$request->nama."@gmail.com", 
            ];
            $newuser2 = [
                'kode' => $request->kode.'00',
                'name' => "Administrator ".$request->nama, 
                'username' => "admin".$request->nama, 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "admin".$request->nama."@gmail.com", 
            ];
            User::create($newuser1);
            User::create($newuser2);
            Departemen::create($request->all());
            Alert::success('Berhasil!', 'Departemen baru berhasil ditambahkan');
            return redirect(route('departemen.index'));
        }
        else{
            Alert::error('Gagal!', 'Kode untuk departemen ini sudah ada.');
            return redirect(route('departemen.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function edit(Departemen $departeman)
    {
        //
        // dd($departemen->kode);
        return view('config.departemen.edit', compact('departeman'))->with([
            'user'=> Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartemenRequest  $request
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departeman)
    {
        //
        if($request->kode == $departeman->kode && $request->nama == $departeman->nama){
            Alert::error('Gagal!', 'Anda belum merubah nilai target.');
            return redirect()->back();
        }
        else{
            $request->validate([
                'kode' => 'required|unique:departemens,kode,'.$departeman->kode.',kode|max:99|numeric',
                'nama' => 'required|unique:departemens,nama,'.$departeman->nama.',nama',
            ],
            [
                'kode.required' => "Masukkan kode departemen",
                'kode.unique' => "Kode ini telah dipakai departemen lain",
                'kode.numeric' => "Pastikan kode dalam format numerik",
                'nama.unique' => "Departemen ini sudah ada",
                'nama.required' => "Masukkan nama departemen"
            ]
            );
            
            $newuser1 = User::where('kode', '=', $departeman->kode.'01')->first();
            $newuser2 = User::where('kode', '=', $departeman->kode.'00')->first();
            // dd($newuser1);
            // $newuser1->merge(['kode' => $request->kode.'01']);
            $newuser1->kode = $request->kode.'01';
            $newuser1->name = "Kadep ".$request->nama;
            $newuser1->username = "kadep".$request->nama;
            $newuser1->email = "kadep".$request->nama."@gmail.com";
            $newuser2->kode = $request->kode.'00';
            $newuser2->name = "Administrator ".$request->nama;
            $newuser2->username = "admin".$request->nama;
            $newuser2->email = "admin".$request->nama."@gmail.com";
            $newuser1->save();
            $newuser2->save();
            $departeman->update($request->all());

            Alert::success('Berhasil!', 'Departemen berhasil diupdate');
            return redirect(route('departemen.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */

    public function destroy(Departemen $departeman)
    {
        //
        $kode = $departeman->kode;
        $targetlama = DB::table('target_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();
        $realisasilama = DB::table('realisasi_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan1lama = DB::table('triwulan1_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan2lama = DB::table('triwulan2_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan3lama = DB::table('triwulan3_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan4lama = DB::table('triwulan4_p_t_n_b_h_s') -> where('kode', 'like', $kode.'%') -> get();

        

        $jmltargetlama = count($targetlama);
        $jmlrealisasilama = count($realisasilama);
        $jmltriwulan1lama = count($triwulan1lama);
        $jmltriwulan2lama = count($triwulan2lama);
        $jmltriwulan3lama = count($triwulan3lama);
        $jmltriwulan4lama = count($triwulan4lama);

        
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

        $targetlama = DB::table('targets') -> where('kode', 'like', $kode.'%') -> get();
        $realisasilama = DB::table('realisasis') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan1lama = DB::table('triwulan1s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan2lama = DB::table('triwulan2s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan3lama = DB::table('triwulan3s') -> where('kode', 'like', $kode.'%') -> get();
        $triwulan4lama = DB::table('triwulan4s') -> where('kode', 'like', $kode.'%') -> get();
        // dd($targetlama);
        

        
        $jmltargetlama = count($targetlama);
        $jmlrealisasilama = count($realisasilama);
        $jmltriwulan1lama = count($triwulan1lama);
        $jmltriwulan2lama = count($triwulan2lama);
        $jmltriwulan3lama = count($triwulan3lama);
        $jmltriwulan4lama = count($triwulan4lama);

        
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
        $user = User::where('kode', 'like', $kode.'%')->get();
        // dd($user);
        for($i = 0; $i<2;$i++){
            user::destroy($user[$i]->kode);
        }
        $departeman->delete();
        Alert::success('Berhasil!', 'Departemen berhasil dihapus');
        return redirect(route('departemen.index'));

    }
    public function hapus(Departemen $departeman)
    {
        //
        
        

    }
}
