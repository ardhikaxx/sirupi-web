<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPaket = PaketPengadaan::count();
        $totalPagu = PaketPengadaan::sum('pagu_anggaran');

        $menungguPersetujuan = PaketPengadaan::where('status', 'diverifikasi')->count();
        $disetujui = PaketPengadaan::where('status', 'disetujui')->count();
        $ditolak = PaketPengadaan::where('status', 'ditolak')->count();
        $rataPagu = $totalPaket > 0 ? $totalPagu / $totalPaket : 0;
        $nilaiDisetujui = PaketPengadaan::where('status', 'disetujui')->sum('pagu_anggaran');

        $statusMap = [
            'draft' => 'Draft', 'diajukan' => 'Diajukan',
            'diverifikasi' => 'Terverifikasi', 'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak', 'dipublikasikan' => 'Dipublikasikan',
        ];

        $paketPerStatus = PaketPengadaan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusLabels = array_values($statusMap);
        $statusData = [];
        foreach ($statusMap as $key => $label) {
            $statusData[] = $paketPerStatus[$key] ?? 0;
        }

        $paketMenunggu = PaketPengadaan::with(['unitKerja'])
            ->where('status', 'diverifikasi')
            ->latest()
            ->take(10)
            ->get();

        return view('pimpinan.index', compact(
            'totalPaket',
            'totalPagu',
            'menungguPersetujuan',
            'disetujui',
            'ditolak',
            'rataPagu',
            'nilaiDisetujui',
            'statusLabels',
            'statusData',
            'paketMenunggu'
        ));
    }
}
