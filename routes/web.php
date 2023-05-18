<?php

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
    // Route::resource('/renstra/target/{id}', TargetController::class. [
    //     'names' => [
    //         'index' => 'renstra.target.index',
    //         'create' => 'renstra.target.create'
    //     ]
    // ]);
    Route::get('/renstra/target/{id}', [TargetController::class, 'index'])->name('renstra.target.index');
    Route::get('/renstra/create/target/', [TargetController::class, 'create'])->name('renstra.target.create');
    Route::get('/renstra/indikators/{kode}', [TargetController::class, 'getIndikator'])->name('renstra.getdindikator');
});

// Route::group(['middleware'=> ['auth']], function(){
//     Route::group(['middleware' => ['cekUserLogin:1']], function(){
//         Route::resource('beranda',Beranda::class);
//     });

//     Route::group(['middleware' => ['cekUserLogin:2']], function(){
//         Route::resource('kasir',Kasir::class);
//     });
// });
