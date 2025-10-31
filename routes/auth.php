<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\AppPelamarController;
use App\Http\Controllers\Dashboard\AppPerusahaanController;
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

Route::middleware('auth')->group(function () {

    Route::post('app/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
Route::group([
    'prefix' => '/app',
    'middleware' =>'auth',
],
    function () {

        // Rute untuk pengguna dengan peran 'dashboard'
        /*Route::middleware('role:dashboard')->group(function () {
            Route::any('/', [DashboardController::class, 'index'])->name('home');

        });*/

        // Rute untuk pengguna dengan peran 'user'
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
        });

    });
