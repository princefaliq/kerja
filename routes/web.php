<?php

use App\Http\Controllers\Crafto\LamarController;
use App\Http\Controllers\Crafto\LowonganController;
use App\Http\Controllers\Crafto\HomeController;
use App\Http\Controllers\Crafto\ProfileController;
use App\Http\Controllers\Dashboard\AppLamaranController;
use App\Http\Controllers\Dashboard\AppLowonganController;
use App\Http\Controllers\Dashboard\AppMyprofileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [HomeController::class, 'index']);
Route::get('/lowongan-kerja', [LowonganController::class, 'index']);
Route::get('/lowongan-kerja/{slug}', [LowonganController::class, 'detil']);
Route::get('/register', [LowonganController::class, 'register_index']);
Route::post('/register/store', [LowonganController::class, 'register_store']);
Route::get('/login', [LowonganController::class, 'login']);




Route::group([
    'prefix' => 'melamar',
    'middleware' =>'auth',
], function () {
    //Route::get('{slug}', [LamarController::class, 'index']);
    Route::post('/', [LamarController::class, 'daftar'])->name('melamar.daftar');
});

Route::group([
    'prefix' => 'profile',
    'middleware' =>['auth','role:User'],
], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('store', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/update-foto', [ProfileController::class, 'updateFoto'])->name('profile.update-foto');
    Route::post('/update-nama', [ProfileController::class, 'updateNama'])->name('profile.update-nama');
    Route::post('/update-data', [ProfileController::class, 'updateData'])->name('profile.update-data');
    Route::post('/update-dokumen', [ProfileController::class, 'updateDokumen'])->name('profile.update-dokumen');
    Route::delete('/hapus-dokumen/{field}', [ProfileController::class, 'hapusDokumen'])
        ->name('profile.hapusDokumen');
    Route::any('/artikel', [AppLowonganController::class, 'index'])->name('artikel.index');

});

Route::group([
    'prefix' => '/app',
    'middleware' =>['auth','role:Admin|Perusahaan'],
],
    function () {
        // Rute untuk pengguna dengan peran 'dashboard'
        Route::any('/', [DashboardController::class, 'index']);
        Route::get('/dashboard/user-data', [DashboardController::class, 'getUserData'])->name('dashboard.user.data');
        Route::get('/dashboard/widget-data', [DashboardController::class, 'widgetData'])->name('dashboard.widget.data');

        Route::any('/lowongan', [AppLowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/lowongan/qrcode/{slug}', [AppLowonganController::class, 'qrcode'])->name('lowongan.qrcode');
        Route::get('/lowongan/qrcode/download/{slug}', [AppLowonganController::class, 'downloadQrcode'])->name('lowongan.qrcode.download');
        Route::get('/lowongan/edit/{id}', [AppLowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/update/{id}', [AppLowonganController::class, 'update'])->name('lowongan.update');

        Route::any('/lamaran', [AppLamaranController::class, 'index'])->name('lamaran.index');


        //my Profile
        Route::get('/myprofile', [AppMyprofileController::class, 'index'])->name('myprofile.index');
        Route::get('/myprofile/edit', [AppMyprofileController::class, 'edit'])->name('myprofile.edit');
        Route::put('/myprofile/update', [AppMyprofileController::class, 'update'])->name('myprofile.update');



        Route::middleware('role:Perusahaan')->group(function () {
            Route::get('/lowongan/create', [AppLowonganController::class, 'create']);
            Route::post('/lowongan/store', [AppLowonganController::class, 'store']);

            Route::post('/lowongan/toggle-status', [AppLowonganController::class, 'toggleStatus'])->name('lowongan.toggleStatus');

            Route::get('/lamaran/{id}', [AppLamaranController::class, 'show'])->name('lamaran.show');
            Route::put('/lamaran/{id}/status', [AppLamaranController::class, 'updateStatus'])->name('lamaran.updateStatus');
        });

    }
);

require __DIR__.'/auth.php';
