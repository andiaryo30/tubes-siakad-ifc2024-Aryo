<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/jadwals', [JadwalController::class, 'index'])->name('jadwals.index');
    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::get('/krs/create', [KrsController::class, 'create'])->name('krs.create');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::delete('/krs/{kr}', [KrsController::class, 'destroy'])->name('krs.destroy');

    Route::middleware('role:admin')->group(function (): void {
        Route::resource('dosens', DosenController::class)->except('show');
        Route::resource('mahasiswas', MahasiswaController::class)->except('show');
        Route::resource('mata-kuliahs', MataKuliahController::class)->except('show');
        Route::resource('jadwals', JadwalController::class)->except(['index', 'show']);
    });
});
