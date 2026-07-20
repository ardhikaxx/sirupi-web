<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UnitKerjaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TahunAnggaranController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\SubKegiatanController;
use App\Http\Controllers\Admin\SumberDanaController;
use App\Http\Controllers\Admin\JenisPengadaanController;
use App\Http\Controllers\Admin\MetodePengadaanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\PenyediaController;
use App\Http\Controllers\Admin\PejabatController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\LaporanController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('user', UserController::class);
    Route::post('user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::resource('tahun-anggaran', TahunAnggaranController::class);
    Route::post('tahun-anggaran/{id}/activate', [TahunAnggaranController::class, 'activate'])->name('tahun-anggaran.activate');
    Route::resource('program', ProgramController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('sub-kegiatan', SubKegiatanController::class);
    Route::resource('sumber-dana', SumberDanaController::class);
    Route::resource('jenis-pengadaan', JenisPengadaanController::class);
    Route::resource('metode-pengadaan', MetodePengadaanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('penyedia', PenyediaController::class);
    Route::resource('pejabat', PejabatController::class);
    Route::get('paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('paket/{id}', [PaketController::class, 'show'])->name('paket.show');
    Route::post('paket/{id}/publish', [PaketController::class, 'publish'])->name('paket.publish');
    Route::post('paket/bulk-publish', [PaketController::class, 'bulkPublish'])->name('paket.bulk-publish');
    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log');
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
});
