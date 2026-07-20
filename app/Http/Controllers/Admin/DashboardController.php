<?php

namespace App\Http\Controllers\Admin;

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
        $paketDipublikasikan = PaketPengadaan::where('is_published', true)->count();

        $paketPerStatus = PaketPengadaan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $paketPerUnit = PaketPengadaan::select('unit_kerja_id', DB::raw('count(*) as total'), DB::raw('sum(pagu_anggaran) as total_pagu'))
            ->groupBy('unit_kerja_id')
            ->with('unitKerja')
            ->get();

        $statusMap = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diverifikasi' => 'Terverifikasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
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

        $chartData = PaketPengadaan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('count(*) as total'),
            DB::raw('sum(pagu_anggaran) as total_pagu')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return view('admin.index', compact(
            'totalPaket',
            'totalPagu',
            'paketPerStatus',
            'paketPerUnit',
            'paketDisetujui',
            'paketDipublikasikan',
            'statusLabels',
            'statusData',
            'unitLabels',
            'unitData',
            'recentActivities',
            'chartData'
        ));
    }
}
