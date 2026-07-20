<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\PaketController;

Route::prefix('operator')->name('operator.')->middleware(['auth', 'role:operator', 'unit_kerja'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('paket', PaketController::class);
    Route::post('paket/{id}/submit', [PaketController::class, 'submit'])->name('paket.submit');
    Route::post('paket/{id}/upload-dokumen', [PaketController::class, 'uploadDokumen'])->name('paket.upload-dokumen');
    Route::delete('paket/{paketId}/dokumen/{dokumenId}', [PaketController::class, 'hapusDokumen'])->name('paket.hapus-dokumen');
    Route::post('paket/{id}/anggaran', [PaketController::class, 'storeAnggaran'])->name('paket.anggaran.store');
    Route::delete('paket/{paketId}/anggaran/{anggaranId}', [PaketController::class, 'destroyAnggaran'])->name('paket.anggaran.destroy');
    Route::post('paket/{id}/jadwal', [PaketController::class, 'storeJadwal'])->name('paket.jadwal.store');
    Route::delete('paket/{paketId}/jadwal/{jadwalId}', [PaketController::class, 'destroyJadwal'])->name('paket.jadwal.destroy');
    Route::post('paket/{id}/lokasi', [PaketController::class, 'storeLokasi'])->name('paket.lokasi.store');
    Route::delete('paket/{paketId}/lokasi/{lokasiId}', [PaketController::class, 'destroyLokasi'])->name('paket.lokasi.destroy');
});
