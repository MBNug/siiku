<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DepartemenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\RealisasiController;
use App\Models\Target;

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
    Route::get('/renstra/target/departemen/urungkan/{kode}', [TargetController::class, 'urungkan'])->name('renstra.target.urungkan');
    Route::get('/renstra/target/departemen/tolak/{kode}', [TargetController::class, 'tolak'])->name('renstra.target.tolak');
    Route::get('/renstra/indikators/{kode}', [TargetController::class, 'getIndikator'])->name('renstra.getindikator');
    Route::get('/renstra/strategis/{kode}', [TargetController::class, 'getStrategi'])->name('renstra.getstrategi');


    //realisasi-renstra 
    Route::get('/renstra/realisasi/', [RealisasiController::class, 'index'])->name('renstra.realisasi.index');
    Route::get('/renstra/realisasi/departemen/{kode}', [RealisasiController::class, 'getRealisasi'])->name('renstra.realisasidepartemen');
    Route::get('/renstra/realisasi/departemen/store/{kode}', [RealisasiController::class, 'store'])->name('renstra.realisasi.store');
    Route::get('/renstra/departemen/{departemen}/realisasi/{realisasi}', [RealisasiController::class, 'form'])->name('renstra.realisasi.form');
    Route::put('/renstra/departemen/{departemen}/realisasi/{realisasi}/simpan', [RealisasiController::class, 'update'])->name('renstra.realisasi.simpan');
    Route::put('/renstra/departemen/{departemen}/realisasi/{realisasi}/simpan2', [RealisasiController::class, 'update2'])->name('renstra.realisasi.simpan2');
    
    //Config
    Route::get('/config/tahun', [ConfigController::class, 'index'])->name('config.index');
    Route::match(['put', 'post'], '/config/settahun', [ConfigController::class, 'storeTahun'])->name('config.settahun');
    Route::post('/config/setindikator', [ConfigController::class, 'storeIndikator'])->name('config.setindikator');

    //ConfigPejabat
    Route::resource('/config/pejabat', PejabatController::class);

    //ConfigDepartemen
    Route::resource('/config/departemen', DepartemenController::class);
    
});


























// Route::group(['middleware'=> ['auth']], function(){
//     Route::group(['middleware' => ['cekUserLogin:1']], function(){
//         Route::resource('beranda',Beranda::class);
//     });

//     Route::group(['middleware' => ['cekUserLogin:2']], function(){
//         Route::resource('kasir',Kasir::class);
//     });
// });
