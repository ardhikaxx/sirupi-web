<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Verifikator\DashboardController;
use App\Http\Controllers\Verifikator\PaketController;

Route::prefix('verifikator')->name('verifikator.')->middleware(['auth', 'role:verifikator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/{id}', [PaketController::class, 'show'])->name('paket.show');
    Route::post('/paket/{id}/setujui', [PaketController::class, 'setujui'])->name('paket.setujui');
    Route::post('/paket/{id}/kembalikan', [PaketController::class, 'kembalikan'])->name('paket.kembalikan');
});
