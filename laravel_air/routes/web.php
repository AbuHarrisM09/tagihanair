<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PakaiController;
use App\Http\Controllers\Admin\TagihanController;
use App\Http\Controllers\PelangganTagihanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'check.level:Administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pemakaian
    Route::get('/pakai', [PakaiController::class, 'index'])->name('pakai.index');
    Route::get('/pakai/create', [PakaiController::class, 'create'])->name('pakai.create');
    Route::post('/pakai', [PakaiController::class, 'store'])->name('pakai.store');
    Route::delete('/pakai/{pakai}', [PakaiController::class, 'destroy'])->name('pakai.destroy');
    Route::get('/pakai/code', [PakaiController::class, 'generateCode'])->name('pakai.code');
    Route::get('/pakai/meteran/{idPelanggan}', [PakaiController::class, 'getMeteranAwal'])->name('pakai.meteran');
    
    // Tagihan
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/{tagihan}/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');
    Route::post('/tagihan/{tagihan}/bayar', [TagihanController::class, 'prosesBayar'])->name('tagihan.prosesBayar');
    Route::get('/tagihan/lunas', [TagihanController::class, 'lunas'])->name('tagihan.lunas');
    Route::delete('/tagihan/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');
});

// Pelanggan routes
Route::middleware(['auth', 'check.level:Pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/tagihan', [PelangganTagihanController::class, 'index'])->name('tagihan');
    Route::get('/tagihan/lunas', [PelangganTagihanController::class, 'lunas'])->name('tagihan.lunas');
});

// Default redirect
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isPelanggan()) {
            return redirect()->route('pelanggan.tagihan');
        }
    }
    return redirect()->route('login');
});
