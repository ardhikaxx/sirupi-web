<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\UnitKerja;
use App\Models\JenisPengadaan;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketPengadaan::with(['unitKerja', 'tahunAnggaran', 'jenisPengadaan'])
            ->where('is_published', true);

        if ($keyword = $request->keyword) {
            $query->where('nama_paket', 'like', "%{$keyword}%");
        }

        if ($unitKerjaId = $request->unit_kerja_id) {
            $query->where('unit_kerja_id', $unitKerjaId);
        }

        if ($tahun = $request->tahun) {
            $query->whereHas('tahunAnggaran', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            });
        }

        if ($jenisPengadaanId = $request->jenis_pengadaan_id) {
            $query->where('jenis_pengadaan_id', $jenisPengadaanId);
        }

        $pakets = $query->latest()->paginate(15);
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        $tahuns = PaketPengadaan::where('is_published', true)
            ->whereHas('tahunAnggaran')
            ->with('tahunAnggaran')
            ->get()
            ->pluck('tahunAnggaran.tahun')
            ->unique()
            ->sort()
            ->values();
        $jenisPengadaans = JenisPengadaan::all();

        return view('public.paket.index', compact('pakets', 'unitKerjas', 'tahuns', 'jenisPengadaans'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function show($id)
    {
        $paket = PaketPengadaan::with([
            'unitKerja',
            'tahunAnggaran',
            'program',
            'kegiatan',
            'subKegiatan',
            'sumberDana',
            'jenisPengadaan',
            'metodePengadaan',
            'kategori',
            'satuan',
            'penyedia',
            'pptk',
            'pp',
            'paKpa',
            'paketAnggarans.satuan',
            'paketJadwals',
            'paketLokasis',
            'dokumens' => function ($q) {
                $q->where('is_public', true);
            },
        ])
            ->where('is_published', true)
            ->findOrFail($id);

        return view('public.paket.show', compact('paket'));
    }
}
