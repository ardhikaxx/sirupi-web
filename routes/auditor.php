<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auditor\DashboardController;
use App\Http\Controllers\Auditor\PaketController;

Route::prefix('auditor')->name('auditor.')->middleware(['auth', 'role:auditor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/{id}', [PaketController::class, 'show'])->name('paket.show');
    Route::get('/activity-log', [PaketController::class, 'activityLog'])->name('activity-log');
});
