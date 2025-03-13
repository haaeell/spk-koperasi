<?php

use App\Http\Controllers\HasilController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoperasiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SubKriteriaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('koperasi', KoperasiController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('sub-kriteria', SubKriteriaController::class);
    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::delete('/penilaian/reset', [PenilaianController::class, 'reset'])->name('penilaian.reset');

    Route::get('/perhitungan', [PenilaianController::class, 'perhitungan'])->name('penilaian.perhitungan');
    Route::get('/hasil', [PenilaianController::class, 'hasil'])->name('penilaian.hasil');
    Route::post('/simpan-hasil', [PenilaianController::class, 'simpanHasil'])->name('simpan-hasil');
    Route::get('/riwayat', [PenilaianController::class, 'riwayat'])->name('riwayat');
    Route::get('/download-template', [KoperasiController::class, 'downloadTemplate'])->name('downloadTemplate');
    Route::post('/import', [KoperasiController::class, 'import'])->name('import');
});
