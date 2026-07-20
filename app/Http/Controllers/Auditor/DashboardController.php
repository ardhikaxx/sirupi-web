<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\UnitKerja;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPaket = PaketPengadaan::count();
        $totalPagu = PaketPengadaan::sum('pagu_anggaran');
        $paketDisetujui = PaketPengadaan::where('status', 'disetujui')->count();
        $totalUnitKerja = UnitKerja::count();

        $paketPerStatus = PaketPengadaan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $paketPerUnit = PaketPengadaan::select(
            'unit_kerja_id',
            DB::raw('count(*) as total'),
            DB::raw('sum(pagu_anggaran) as total_pagu')
        )
            ->groupBy('unit_kerja_id')
            ->with('unitKerja')
            ->get();

        $statusMap = [
            'draft' => 'Draft', 'diajukan' => 'Diajukan',
            'diverifikasi' => 'Terverifikasi', 'dikembalikan' => 'Dikembalikan',
            'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak',
            'dipublikasikan' => 'Dipublikasikan',
        ];

        $statusLabels = array_values($statusMap);
        $statusData = [];
        foreach ($statusMap as $key => $label) {
            $statusData[] = $paketPerStatus[$key] ?? 0;
        }

        $unitLabels = $paketPerUnit->pluck('unitKerja.nama')->toArray();
        $unitData = $paketPerUnit->pluck('total')->toArray();

        $recentActivities = ActivityLog::with('user')->latest()->take(10)->get();

        return view('auditor.index', compact(
            'totalPaket',
            'totalPagu',
            'paketDisetujui',
            'totalUnitKerja',
            'statusLabels',
            'statusData',
            'unitLabels',
            'unitData',
            'recentActivities'
        ));
    }
}
