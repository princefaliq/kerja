<?php

use App\Http\Controllers\Crafto\HomeController;

use App\Http\Controllers\WilayahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' =>'auth',
], function () {
    Route::get('wilayah/provinces', [WilayahController::class, 'provinces']);
    Route::get('wilayah/regencies/{provinceCode}', [WilayahController::class, 'regencies']);
    Route::get('wilayah/districts/{regencyCode}', [WilayahController::class, 'districts']);
    Route::get('wilayah/villages/{districtCode}', [WilayahController::class, 'villages']);
});

Route::get('/perusahaan/list', [HomeController::class, 'getPerusahaan'])->name('perusahaan.list');
