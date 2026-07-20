<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $unitKerjaId = $user->unit_kerja_id;

        $totalPaket = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->count();

        $totalPagu = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->sum('pagu_anggaran');

        $paketPerStatus = PaketPengadaan::select('status', DB::raw('count(*) as total'))
            ->where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $paketTerbaru = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $paketDraft = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->where('status', 'draft')
            ->count();

        $paketDiajukan = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->where('status', 'diajukan')
            ->count();

        $paketDisetujui = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->count();

        $totalPaketSaya = $totalPaket;

        return view('operator.index', compact(
            'totalPaket',
            'totalPagu',
            'paketPerStatus',
            'paketTerbaru',
            'paketDraft',
            'paketDiajukan',
            'paketDisetujui',
            'totalPaketSaya'
        ));
    }
}
