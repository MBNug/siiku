<?php

use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\TargetController;
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
    Route::resource('renstra.target', TargetController::class)->shallow();
    Route::get('/renstra/indikators/{kode}', [TargetController::class, 'getIndikator'])->name('renstra.getindikator');
    Route::get('/renstra/strategis/{kode}', [TargetController::class, 'getStrategi'])->name('renstra.getstrategi');
    Route::get('/renstra/tolak/{kode}', [TargetController::class, 'tolak'])->name('renstra.tolak');
    Route::get('/renstra/urungkan/{kode}', [TargetController::class, 'urungkan'])->name('renstra.urungkan');
    Route::get('/renstra/setujui/{renstradept}', [TargetController::class, 'setujui'])->name('renstra.setujui');

    //Config
    Route::get('/config/tahun', [ConfigController::class, 'index'])->name('config.index');
    Route::match(['put', 'post'], '/config/settahun', [ConfigController::class, 'storeTahun'])->name('config.settahun');
    Route::post('/config/setindikator', [ConfigController::class, 'storeIndikator'])->name('config.setindikator');
});


























// Route::group(['middleware'=> ['auth']], function(){
//     Route::group(['middleware' => ['cekUserLogin:1']], function(){
//         Route::resource('beranda',Beranda::class);
//     });

//     Route::group(['middleware' => ['cekUserLogin:2']], function(){
//         Route::resource('kasir',Kasir::class);
//     });
// });
