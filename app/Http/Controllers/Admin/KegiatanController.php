<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $kegiatans = Kegiatan::with('program')->orderBy('kode')->paginate(10);
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        $programs = Program::with('tahunAnggaran')->get();
        return view('admin.kegiatan.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:kegiatans,kode',
            'nama' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $kegiatan = Kegiatan::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $kegiatan,
            "Membuat kegiatan: {$kegiatan->nama} ({$kegiatan->kode})"
        );

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::with(['program', 'subKegiatans', 'paketPengadaans'])->findOrFail($id);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $programs = Program::with('tahunAnggaran')->get();
        return view('admin.kegiatan.edit', compact('kegiatan', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:kegiatans,kode,' . $id,
            'nama' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $dataLama = $kegiatan->toArray();
        $kegiatan->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $kegiatan,
            $dataLama,
            $kegiatan->toArray(),
            "Memperbarui kegiatan: {$kegiatan->nama} ({$kegiatan->kode})"
        );

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.kegiatan.index')
                ->with('error', 'Kegiatan tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $kegiatan,
            "Menghapus kegiatan: {$kegiatan->nama} ({$kegiatan->kode})"
        );

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
