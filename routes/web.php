<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoperasiController;
use App\Http\Controllers\PenilaianController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('koperasi', KoperasiController::class);
Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
Route::get('/penilaian/proses', [PenilaianController::class, 'proses'])->name('penilaian.proses');
