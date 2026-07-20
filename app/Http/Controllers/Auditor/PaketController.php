<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketPengadaan::with(['unitKerja', 'user', 'program', 'kegiatan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('unit_kerja_id')) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('tahun_anggaran_id')) {
            $query->where('tahun_anggaran_id', $request->tahun_anggaran_id);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                    ->orWhere('kode_paket', 'like', "%{$search}%");
            });
        }

        $pakets = $query->latest()->paginate(15);

        return view('auditor.paket.index', compact('pakets'));
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

        $activityLogs = ActivityLog::where('model', PaketPengadaan::class)
            ->where('model_id', $paket->id)
            ->with('user')
            ->latest()
            ->get();

        return view('auditor.paket.show', compact('paket', 'activityLogs'));
    }

    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $activityLogs = $query->latest()->paginate(20);

        return view('auditor.activity-log.index', compact('activityLogs'));
    }
}
