<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\TahunAnggaran;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahunAnggarans = TahunAnggaran::all();
        $unitKerjas = UnitKerja::where('is_active', true)->get();

        $query = PaketPengadaan::with(['unitKerja', 'tahunAnggaran']);

        if ($tahun = $request->tahun) {
            $query->where('tahun_anggaran_id', $tahun);
        }

        if ($unitKerja = $request->unit_kerja) {
            $query->where('unit_kerja_id', $unitKerja);
        }

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $totalPaket = (clone $query)->count();
        $totalDraft = (clone $query)->where('status', 'draft')->count();
        $totalDisetujui = (clone $query)->where('status', 'disetujui')->count();
        $totalDipublikasikan = (clone $query)->where('is_published', true)->count();

        $ringkasanStatus = (clone $query)
            ->select('status', DB::raw('count(*) as total'), DB::raw('sum(pagu_anggaran) as total_pagu'))
            ->groupBy('status')
            ->get();

        $pakets = $query->latest()->get();

        return view('admin.laporan.index', compact(
            'tahunAnggarans',
            'unitKerjas',
            'totalPaket',
            'totalDraft',
            'totalDisetujui',
            'totalDipublikasikan',
            'ringkasanStatus',
            'pakets'
        ));
    }

    public function paketPerUnit(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $data = PaketPengadaan::select(
            'unit_kerja_id',
            DB::raw('count(*) as total_paket'),
            DB::raw('sum(pagu_anggaran) as total_pagu'),
            DB::raw('sum(case when status = \'dipublikasikan\' then 1 else 0 end) as published'),
            DB::raw('sum(case when status = \'draft\' then 1 else 0 end) as draft')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy('unit_kerja_id')
            ->with('unitKerja')
            ->get();

        return view('admin.laporan.paket-per-unit', compact('data', 'tahun'));
    }

    public function paketPerStatus(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $data = PaketPengadaan::select(
            'status',
            DB::raw('count(*) as total'),
            DB::raw('sum(pagu_anggaran) as total_pagu')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy('status')
            ->get();

        return view('admin.laporan.paket-per-status', compact('data', 'tahun'));
    }

    public function rekapAnggaran(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $data = PaketPengadaan::select(
            DB::raw('sum(pagu_anggaran) as total_pagu'),
            DB::raw('sum(hps) as total_hps'),
            DB::raw('count(*) as total_paket')
        )
            ->whereYear('created_at', $tahun)
            ->first();

        $perUnit = PaketPengadaan::select(
            'unit_kerja_id',
            DB::raw('sum(pagu_anggaran) as total_pagu'),
            DB::raw('count(*) as total_paket')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy('unit_kerja_id')
            ->with('unitKerja')
            ->get();

        return view('admin.laporan.rekap-anggaran', compact('data', 'perUnit', 'tahun'));
    }

    public function exportPdf(Request $request)
    {
        $query = PaketPengadaan::with(['unitKerja', 'tahunAnggaran']);

        if ($tahun = $request->tahun) {
            $query->where('tahun_anggaran_id', $tahun);
        }
        if ($unitKerja = $request->unit_kerja) {
            $query->where('unit_kerja_id', $unitKerja);
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $pakets = $query->latest()->get();
        $html = view('admin.laporan.pdf', compact('pakets'))->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'laporan-rup-' . date('Y-m-d') . '.html', ['Content-Type' => 'text/html']);
    }

    public function exportExcel(Request $request)
    {
        $query = PaketPengadaan::with(['unitKerja', 'tahunAnggaran']);

        if ($tahun = $request->tahun) {
            $query->where('tahun_anggaran_id', $tahun);
        }
        if ($unitKerja = $request->unit_kerja) {
            $query->where('unit_kerja_id', $unitKerja);
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $pakets = $query->latest()->get();
        $html = view('admin.laporan.excel', compact('pakets'))->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'laporan-rup-' . date('Y-m-d') . '.xls', ['Content-Type' => 'application/vnd.ms-excel']);
    }
}
