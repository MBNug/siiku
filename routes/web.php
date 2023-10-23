<?php

use App\Models\Target;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\TargetPTNBHController;
use App\Http\Controllers\RealisasiPTNBHController;
use App\Http\Controllers\PtnBHController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[RenstraController::class, 'index'])->middleware('auth');
Route::get('/renstra/dashboard/',[RenstraController::class, 'index'])->middleware('auth')->name('renstra.dashboard');
Route::get('/renstra/dashboard/filter/',[RenstraController::class, 'gantiData'])->middleware('auth')->name('renstra.dashboard.filter');
Route::get('/ptnbh/dashboard/',[PtnBHController::class, 'index'])->middleware('auth')->name('ptnbh.dashboard');
Route::get('/ptnbh/dashboard/filter/',[PtnBHController::class, 'gantiData'])->middleware('auth')->name('ptnbh.dashboard.filter');

Route::controller(LoginController::class)->group(function(){
    Route::get('login','index')->name('login');
    Route::post('login/proses','proses');
    Route::get('logout','logout');
});


Route::group(['middleware' => ['auth']], function(){
    // Route::resource('/renstra/target/{id}', TargetController::class)->only(['store']);
    // Route::post('/renstra/dasboard/', [TargetController::class, 'store'])->name('renstra.target.store');
    // Route::get('/renstra/target/{id}', [TargetController::class, 'index'])->name('renstra.target.index');
    // Route::get('/renstra/create/target/', [TargetController::class, 'create'])->name('renstra.target.create');
    // Route::resource('renstra.target', TargetController::class)->shallow();

    //Target-renstra
    Route::get('/renstra/target/', [TargetController::class, 'index'])->name('renstra.target.index');
    Route::get('/renstra/target/departemen/{kode}', [TargetController::class, 'getTarget'])->name('renstra.targetdepartemen');
    Route::get('/renstra/target/departemen/store/{kode}', [TargetController::class, 'store'])->name('renstra.target.store');
    Route::get('/renstra/target/departemen/edit/{kode}', [TargetController::class, 'edit'])->name('renstra.target.edit');
    Route::put('/renstra/target/departemen/update/{kode}', [TargetController::class, 'update'])->name('renstra.target.kirim');
    Route::get('/renstra/target/departemen/setujui/{kode}', [TargetController::class, 'setujui'])->name('renstra.target.setujui');
    Route::get('/renstra/target/departemen/tolak/{kode}', [TargetController::class, 'tolak'])->name('renstra.target.tolak');
    Route::get('/renstra/target/departemen/batal/{kode}', [TargetController::class, 'batal'])->name('renstra.target.batal');
    Route::get('/renstra/target/departemen/setujuisemua/{kode}', [TargetController::class, 'AllAprove'])->name('renstra.target.AllAprove');
    Route::get('/renstra/indikators/{kode}', [TargetController::class, 'getIndikator'])->name('renstra.getindikator');
    Route::get('/renstra/strategis/{kode}', [TargetController::class, 'getStrategi'])->name('renstra.getstrategi');
    Route::get('/renstra/target/departemen/{departemen}/download', [TargetController::class, 'downloadPDFTarget'])->name('renstra.target.download');


    //realisasi-renstra 
    Route::get('/renstra/realisasi/', [RealisasiController::class, 'index'])->name('renstra.realisasi.index');
    Route::get('/renstra/realisasi/departemen/{kode}/{triwulan}', [RealisasiController::class, 'getRealisasi'])->name('renstra.realisasidepartemen');
    Route::get('/renstra/realisasi/departemen/store/{kode}/{triwulan}', [RealisasiController::class, 'store'])->name('renstra.realisasi.store');
    Route::get('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}', [RealisasiController::class, 'form'])->name('renstra.realisasi.form');
    Route::put('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/simpan', [RealisasiController::class, 'update'])->name('renstra.realisasi.simpan');
    Route::put('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/simpan2', [RealisasiController::class, 'update2'])->name('renstra.realisasi.simpan2');
    Route::post('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/tmp-upload', [RealisasiController::class, 'tmpUpload'])->name('renstra.realisasi.tmpUpload');
    Route::delete('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/tmp-delete', [RealisasiController::class, 'tmpDelete'])->name('renstra.realisasi.tmpDelete');
    Route::get('/renstra/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/show', [RealisasiController::class, 'show'])->name('renstra.realisasi.show');
    Route::get('/renstra/realisasi/departemen/{departemen}/realisasi/{triwulan}/akhiri-triwulan', [RealisasiController::class, 'alertakhiriTriwulan'])->name('renstra.realisasi.alertakhiritriwulan');
    Route::get('/renstra/realisasi/departemen/{departemen}/realisasi/{triwulan}/akhiri', [RealisasiController::class, 'akhiriTriwulan'])->name('renstra.realisasi.akhiritriwulan');
    Route::get('/renstra/realisasi/departemen/{departemen}/{triwulan}/download', [RealisasiController::class, 'downloadPDFRealisasi'])->name('renstra.realisasi.download');




    //Target-PTNBH
    Route::get('/ptnbh/target/', [TargetPTNBHController::class, 'index'])->name('ptnbh.target.index');
    Route::get('/ptnbh/target/departemen/{kode}', [TargetPTNBHController::class, 'getTarget'])->name('ptnbh.targetdepartemen');
    Route::get('/ptnbh/target/departemen/store/{kode}', [TargetPTNBHController::class, 'store'])->name('ptnbh.target.store');
    Route::get('/ptnbh/target/departemen/edit/{kode}', [TargetPTNBHController::class, 'edit'])->name('ptnbh.target.edit');
    Route::put('/ptnbh/target/departemen/update/{kode}', [TargetPTNBHController::class, 'update'])->name('ptnbh.target.kirim');
    Route::get('/ptnbh/target/departemen/setujui/{kode}', [TargetPTNBHController::class, 'setujui'])->name('ptnbh.target.setujui');
    Route::get('/ptnbh/target/departemen/tolak/{kode}', [TargetPTNBHController::class, 'tolak'])->name('ptnbh.target.tolak');
    Route::get('/ptnbh/target/departemen/batal/{kode}', [TargetPTNBHController::class, 'batal'])->name('ptnbh.target.batal');
    Route::get('/ptnbh/target/departemen/setujuisemua/{kode}', [TargetPTNBHController::class, 'AllAprove'])->name('ptnbh.target.AllAprove');
    Route::get('/ptnbh/indikators/{kode}', [TargetPTNBHController::class, 'getIndikator'])->name('ptnbh.getindikator');
    Route::get('/ptnbh/strategis/{kode}', [TargetPTNBHController::class, 'getStrategi'])->name('ptnbh.getstrategi');
    Route::get('/ptnbh/target/departemen/{departemen}/download', [TargetPTNBHController::class, 'downloadPDFTarget'])->name('ptnbh.target.download');


    //realisasi-PTNBH 
    Route::get('/ptnbh/realisasi/', [RealisasiPTNBHController::class, 'index'])->name('ptnbh.realisasi.index');
    Route::get('/ptnbh/realisasi/departemen/{kode}/{triwulan}', [RealisasiPTNBHController::class, 'getRealisasi'])->name('ptnbh.realisasidepartemen');
    Route::get('/ptnbh/realisasi/departemen/store/{kode}/{triwulan}', [RealisasiPTNBHController::class, 'store'])->name('ptnbh.realisasi.store');
    Route::get('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}', [RealisasiPTNBHController::class, 'form'])->name('ptnbh.realisasi.form');
    Route::put('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/simpan', [RealisasiPTNBHController::class, 'update'])->name('ptnbh.realisasi.simpan');
    Route::put('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/simpan2', [RealisasiPTNBHController::class, 'update2'])->name('ptnbh.realisasi.simpan2');
    Route::post('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/tmp-upload', [RealisasiPTNBHController::class, 'tmpUpload'])->name('ptnbh.realisasi.tmpUpload');
    Route::delete('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/tmp-delete', [RealisasiPTNBHController::class, 'tmpDelete'])->name('ptnbh.realisasi.tmpDelete');
    Route::get('/ptnbh/departemen/{departemen}/realisasi/{triwulan}/{realisasi}/show', [RealisasiPTNBHController::class, 'show'])->name('ptnbh.realisasi.show');
    Route::get('/ptnbh/realisasi/departemen/{departemen}/realisasi/{triwulan}/akhiri-triwulan', [RealisasiPTNBHController::class, 'alertakhiriTriwulan'])->name('ptnbh.realisasi.alertakhiritriwulan');
    Route::get('/ptnbh/realisasi/departemen/{departemen}/realisasi/{triwulan}/akhiri', [RealisasiPTNBHController::class, 'akhiriTriwulan'])->name('ptnbh.realisasi.akhiritriwulan');
    Route::get('/ptnbh/realisasi/departemen/{departemen}/{triwulan}/download', [RealisasiPTNBHController::class, 'downloadPDFRealisasi'])->name('ptnbh.realisasi.download');
    
    //Config
    Route::get('/config/tahun', [ConfigController::class, 'index'])->name('config.index');
    Route::match(['put', 'post'], '/config/settahun', [ConfigController::class, 'storeTahun'])->name('config.settahun');
    Route::post('/config/setindikator', [ConfigController::class, 'alertStoreIndikator'])->name('config.setindikator');
    Route::get('/config/setindikator/new', [ConfigController::class, 'storeIndikator'])->name('config.setindikatorbaru');
    Route::post('/config/setindikatorptnbh', [ConfigController::class, 'alertStoreIndikatorPTNBH'])->name('config.setindikatorptnbh');
    Route::get('/config/setindikatorptnbh/new', [ConfigController::class, 'storeIndikatorPTNBH'])->name('config.setindikatorptnbhbaru');
    Route::match(['put', 'post'], '/config/settriwulan', [ConfigController::class, 'storeTriwulan'])->name('config.settriwulan');

    //ConfigPejabat
    Route::resource('/config/pejabat', PejabatController::class);

    //ConfigDepartemen
    Route::resource('/config/departemen', DepartemenController::class);

    //configUser
    // Route::get('/renstra/departemen/{departemen}/realisasi/{realisasi}', [RealisasiController::class, 'form'])->name('renstra.realisasi.form');
    Route::get('/user/gantiPassword', [UserController::class, 'index'])->name('user.gantipassword');
    Route::put('/user/gantiPassword/update', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    
});


























// Route::group(['middleware'=> ['auth']], function(){
//     Route::group(['middleware' => ['cekUserLogin:1']], function(){
//         Route::resource('beranda',Beranda::class);
//     });

//     Route::group(['middleware' => ['cekUserLogin:2']], function(){
//         Route::resource('kasir',Kasir::class);
//     });
// });
