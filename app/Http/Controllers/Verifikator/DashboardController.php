<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $menungguVerifikasi = PaketPengadaan::where('status', 'diajukan')->count();
        $diverifikasi = PaketPengadaan::where('status', 'diverifikasi')->count();
        $dikembalikan = PaketPengadaan::where('status', 'dikembalikan')->count();

        $paketMenunggu = PaketPengadaan::with(['unitKerja', 'user'])
            ->where('status', 'diajukan')
            ->latest()
            ->take(10)
            ->get();

        return view('verifikator.index', compact(
            'menungguVerifikasi',
            'diverifikasi',
            'dikembalikan',
            'paketMenunggu'
        ));
    }
}
