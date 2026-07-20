<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\UnitKerja;
use App\Models\TahunAnggaran;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketPengadaan::with(['unitKerja', 'program', 'kegiatan', 'satuan', 'tahunAnggaran'])
            ->where('is_published', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                    ->orWhere('kode_paket', 'like', "%{$search}%")
                    ->orWhere('uraian_pekerjaan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('unit_kerja_id')) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('tahun_anggaran_id')) {
            $query->where('tahun_anggaran_id', $request->tahun_anggaran_id);
        }

        $pakets = $query->orderBy('published_at', 'desc')->paginate(12);

        $totalPaket = PaketPengadaan::where('is_published', true)->count();
        $totalPagu = PaketPengadaan::where('is_published', true)->sum('pagu_anggaran');
        $totalUnitKerja = UnitKerja::where('is_active', true)->count();
        $recentPakets = PaketPengadaan::with(['unitKerja', 'tahunAnggaran'])
            ->where('is_published', true)
            ->latest('published_at')
            ->take(5)
            ->get();
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        $tahunAnggarans = TahunAnggaran::where('is_active', true)->get();
        $tahuns = $tahunAnggarans->pluck('tahun')->sort()->values();

        return view('public.home', compact(
            'pakets', 'unitKerjas', 'tahunAnggarans', 'tahuns',
            'totalPaket', 'totalPagu', 'totalUnitKerja', 'recentPakets'
        ));
    }
}
