<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Crafto\LupaPaswordController;
use App\Http\Controllers\Dashboard\AppAbsenController;
use App\Http\Controllers\Dashboard\AppMyprofileController;
use App\Http\Controllers\Dashboard\AppPelamarController;
use App\Http\Controllers\Dashboard\AppPerusahaanController;
use App\Http\Controllers\Dashboard\AppTestimoniController;
use App\Http\Controllers\UserController;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware('guest')->group(function () {

    Route::get('app/login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('app/login', [AuthenticatedSessionController::class, 'store']);

});

Route::middleware('guest')->group(function () {
    // tampilkan form minta reset link
    Route::get('password/forgot', [LupaPaswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // kirim email reset link
    Route::post('password/email', [LupaPaswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // tampilkan form reset (dengan token)
    Route::get('password/reset/{token}', [LupaPaswordController::class, 'showResetForm'])
        ->name('password.reset');

    // proses reset password
    Route::post('password/reset', [LupaPaswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::post('app/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
Route::group([
    'prefix' => '/app',
    'middleware' =>'auth',
],
    function () {

        // Rute untuk pengguna dengan peran 'admin'
        Route::middleware('role:Admin')->group(function () {
            Route::any('user', [UserController::class, 'index'])->name('user.index');
            Route::get('user/create', [UserController::class, 'create'])->name('user.create');
            Route::post('user/store', [UserController::class, 'store'])->name('user.store');
            Route::delete('user/delete', [UserController::class, 'destroy'])->name('user.destroy');
            Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');

            Route::post('/perusahaan/import', [AppPerusahaanController::class, 'import'])->name('perusahaan.import');

            Route::get('perusahaan/data', [AppPerusahaanController::class, 'data'])->name('perusahaan.data');
            Route::get('perusahaan', [AppPerusahaanController::class, 'index'])->name('perusahaan.index')->name('perusahaan.index');

            Route::get('pelamar', [AppPelamarController::class, 'index'])->name('pelamar.index')->name('pelamar.index');
            Route::get('pelamar/data', [AppPelamarController::class, 'data'])->name('pelamar.data');
            Route::get('myprofile/{id}', [AppMyprofileController::class, 'show'])->name('myprofile.show');

            Route::get('absen/qr', [AppAbsenController::class, 'index'])->name('absen.qr.index');
            Route::get('absen/qr/code', [AppAbsenController::class, 'code'])->name('absen.qr.code');
            Route::get('absen/qr/generate', [AppAbsenController::class, 'generate'])->name('absen.qr.generate');
            Route::get('absen/qr/generate', [AppAbsenController::class, 'generate'])->name('absen.qr.generate');
            Route::get('absen/qr/status', [AppAbsenController::class, 'status'])->name('absen.qr.status');
            Route::get('absen/data', [AppAbsenController::class, 'data'])->name('absen.data');

            Route::get('testimoni', [AppTestimoniController::class, 'index'])->name('testimoni.index');
            Route::post('/testimoni/{id}/status', [AppTestimoniController::class, 'updateStatus'])->name('admin.testimoni.status');
            Route::get('/testimoni/data', [AppTestimoniController::class, 'data'])->name('admin.testimoni.data');
        });

    });
