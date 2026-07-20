<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/api/kegiatan/{programId}', [App\Http\Controllers\Api\KegiatanController::class, 'byProgram']);
Route::get('/api/sub-kegiatan/{kegiatanId}', [App\Http\Controllers\Api\SubKegiatanController::class, 'byKegiatan']);

require __DIR__ . '/public.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/operator.php';
require __DIR__ . '/verifikator.php';
require __DIR__ . '/pimpinan.php';
require __DIR__ . '/auditor.php';
require __DIR__ . '/admin.php';
