<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PaketController;

Route::prefix('publik')->name('publik.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/cari', [PaketController::class, 'search'])->name('paket.search');
    Route::get('/paket/{id}', [PaketController::class, 'show'])->name('paket.show');
});
