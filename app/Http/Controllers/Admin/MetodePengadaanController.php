<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodePengadaan;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class MetodePengadaanController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $metodePengadaans = MetodePengadaan::orderBy('kode')->paginate(10);
        return view('admin.metode-pengadaan.index', compact('metodePengadaans'));
    }

    public function create()
    {
        return view('admin.metode-pengadaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:metode_pengadaans,kode',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $metodePengadaan = MetodePengadaan::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $metodePengadaan,
            "Membuat metode pengadaan: {$metodePengadaan->nama} ({$metodePengadaan->kode})"
        );

        return redirect()->route('admin.metode-pengadaan.index')
            ->with('success', 'Metode pengadaan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $metodePengadaan = MetodePengadaan::with('paketPengadaans')->findOrFail($id);
        return view('admin.metode-pengadaan.show', compact('metodePengadaan'));
    }

    public function edit($id)
    {
        $metodePengadaan = MetodePengadaan::findOrFail($id);
        return view('admin.metode-pengadaan.edit', compact('metodePengadaan'));
    }

    public function update(Request $request, $id)
    {
        $metodePengadaan = MetodePengadaan::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:metode_pengadaans,kode,' . $id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $dataLama = $metodePengadaan->toArray();
        $metodePengadaan->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $metodePengadaan,
            $dataLama,
            $metodePengadaan->toArray(),
            "Memperbarui metode pengadaan: {$metodePengadaan->nama} ({$metodePengadaan->kode})"
        );

        return redirect()->route('admin.metode-pengadaan.index')
            ->with('success', 'Metode pengadaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $metodePengadaan = MetodePengadaan::findOrFail($id);

        if ($metodePengadaan->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.metode-pengadaan.index')
                ->with('error', 'Metode pengadaan tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $metodePengadaan,
            "Menghapus metode pengadaan: {$metodePengadaan->nama} ({$metodePengadaan->kode})"
        );

        $metodePengadaan->delete();

        return redirect()->route('admin.metode-pengadaan.index')
            ->with('success', 'Metode pengadaan berhasil dihapus.');
    }
}
