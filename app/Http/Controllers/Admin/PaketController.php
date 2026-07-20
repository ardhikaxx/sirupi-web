<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\TahunAnggaran;
use App\Models\UnitKerja;
use App\Services\PaketPengadaanService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    protected $paketPengadaanService;
    protected $activityLogService;

    public function __construct(
        PaketPengadaanService $paketPengadaanService,
        ActivityLogService $activityLogService
    ) {
        $this->paketPengadaanService = $paketPengadaanService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $query = PaketPengadaan::with([
            'unitKerja', 'tahunAnggaran', 'program', 'kegiatan', 'user'
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('unit_kerja_id')) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('tahun_anggaran_id')) {
            $query->where('tahun_anggaran_id', $request->tahun_anggaran_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                    ->orWhere('kode_paket', 'like', "%{$search}%");
            });
        }

        $pakets = $query->latest()->paginate(15);
        $tahunAnggarans = TahunAnggaran::all();
        $unitKerjas = UnitKerja::where('is_active', true)->get();

        return view('admin.paket.index', compact('pakets', 'tahunAnggarans', 'unitKerjas'));
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
            'user',
            'paketAnggarans.satuan',
            'paketJadwals',
            'paketLokasis',
            'dokumens.uploader',
            'riwayatPersetujuans.user',
        ])->findOrFail($id);

        return view('admin.paket.show', compact('paket'));
    }

    public function publish($id)
    {
        $paket = PaketPengadaan::findOrFail($id);

        try {
            $this->paketPengadaanService->publish($paket, auth()->id());

            $this->activityLogService->log(
                auth()->user(),
                'update',
                get_class($paket),
                $paket->id,
                "Mempublikasikan paket: {$paket->nama_paket} ({$paket->kode_paket})"
            );

            return redirect()->route('admin.paket.index')
                ->with('success', 'Paket berhasil dipublikasikan.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function bulkPublish(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:paket_pengadaans,id',
        ]);

        $berhasil = 0;
        $gagal = 0;

        foreach ($request->ids as $id) {
            $paket = PaketPengadaan::find($id);

            if (!$paket || $paket->status !== 'disetujui') {
                $gagal++;
                continue;
            }

            try {
                $this->paketPengadaanService->publish($paket, auth()->id());

                $this->activityLogService->log(
                    auth()->user(),
                    'update',
                    get_class($paket),
                    $paket->id,
                    "Mempublikasikan paket (bulk): {$paket->nama_paket} ({$paket->kode_paket})"
                );

                $berhasil++;
            } catch (\RuntimeException $e) {
                $gagal++;
            }
        }

        return redirect()->route('admin.paket.index')
            ->with('success', "{$berhasil} paket berhasil dipublikasikan. {$gagal} paket gagal dipublikasikan.");
    }
}
