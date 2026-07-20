<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubKegiatan;
use App\Models\Kegiatan;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class SubKegiatanController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $subKegiatans = SubKegiatan::with('kegiatan.program')->orderBy('kode')->paginate(10);
        return view('admin.sub-kegiatan.index', compact('subKegiatans'));
    }

    public function create()
    {
        $kegiatans = Kegiatan::with('program')->get();
        return view('admin.sub-kegiatan.create', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:sub_kegiatans,kode',
            'nama' => 'required|string|max:255',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $subKegiatan = SubKegiatan::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $subKegiatan,
            "Membuat sub kegiatan: {$subKegiatan->nama} ({$subKegiatan->kode})"
        );

        return redirect()->route('admin.sub-kegiatan.index')
            ->with('success', 'Sub kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $subKegiatan = SubKegiatan::with(['kegiatan.program', 'paketPengadaans'])->findOrFail($id);
        return view('admin.sub-kegiatan.show', compact('subKegiatan'));
    }

    public function edit($id)
    {
        $subKegiatan = SubKegiatan::findOrFail($id);
        $kegiatans = Kegiatan::with('program')->get();
        return view('admin.sub-kegiatan.edit', compact('subKegiatan', 'kegiatans'));
    }

    public function update(Request $request, $id)
    {
        $subKegiatan = SubKegiatan::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:sub_kegiatans,kode,' . $id,
            'nama' => 'required|string|max:255',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $dataLama = $subKegiatan->toArray();
        $subKegiatan->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $subKegiatan,
            $dataLama,
            $subKegiatan->toArray(),
            "Memperbarui sub kegiatan: {$subKegiatan->nama} ({$subKegiatan->kode})"
        );

        return redirect()->route('admin.sub-kegiatan.index')
            ->with('success', 'Sub kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subKegiatan = SubKegiatan::findOrFail($id);

        if ($subKegiatan->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.sub-kegiatan.index')
                ->with('error', 'Sub kegiatan tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $subKegiatan,
            "Menghapus sub kegiatan: {$subKegiatan->nama} ({$subKegiatan->kode})"
        );

        $subKegiatan->delete();

        return redirect()->route('admin.sub-kegiatan.index')
            ->with('success', 'Sub kegiatan berhasil dihapus.');
    }
}
