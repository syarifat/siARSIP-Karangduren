<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KategoriController;

Route::get('/', function() {
    return redirect()->route('arsip.index');
});

Route::resource('arsip', ArsipController::class);
Route::get('arsip/{id}/download', [ArsipController::class, 'download'])->name('arsip.download');
Route::resource('kategori', KategoriController::class);
Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('arsip/{id}/download', [ArsipController::class, 'download'])->name('arsip.download');
