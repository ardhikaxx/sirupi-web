<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
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
        $query = PaketPengadaan::with(['unitKerja', 'user', 'program', 'kegiatan'])
            ->where('status', 'diverifikasi');

        if ($request->filled('unit_kerja_id')) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                    ->orWhere('kode_paket', 'like', "%{$search}%");
            });
        }

        $pakets = $query->latest()->paginate(15);

        return view('pimpinan.paket.index', compact('pakets'));
    }

    public function show($id)
    {
        $paket = PaketPengadaan::with([
            'unitKerja', 'tahunAnggaran', 'program', 'kegiatan',
            'subKegiatan', 'sumberDana', 'jenisPengadaan',
            'metodePengadaan', 'kategori', 'satuan', 'penyedia',
            'pptk', 'pp', 'paKpa', 'user',
            'paketAnggarans.satuan',
            'paketJadwals',
            'paketLokasis',
            'dokumens.uploader',
            'riwayatPersetujuans.user',
        ])->findOrFail($id);

        return view('pimpinan.paket.show', compact('paket'));
    }

    public function setujui(Request $request, $id)
    {
        $request->validate(['catatan' => 'nullable|string|max:1000']);

        $paket = PaketPengadaan::findOrFail($id);

        try {
            $this->paketPengadaanService->approve($paket, auth()->id(), $request->catatan ?? '', true);

            $this->activityLogService->log(
                auth()->user(),
                'update',
                get_class($paket),
                $paket->id,
                "Menyetujui paket {$paket->nama_paket} ({$paket->kode_paket})"
            );

            return redirect()->route('pimpinan.paket.index')
                ->with('success', 'Paket berhasil disetujui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan' => 'required|string|min:10|max:1000']);

        $paket = PaketPengadaan::findOrFail($id);

        try {
            $this->paketPengadaanService->approve($paket, auth()->id(), $request->catatan, false);

            $this->activityLogService->log(
                auth()->user(),
                'update',
                get_class($paket),
                $paket->id,
                "Menolak paket {$paket->nama_paket} ({$paket->kode_paket}) dengan catatan: {$request->catatan}"
            );

            return redirect()->route('pimpinan.paket.index')
                ->with('success', 'Paket ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
