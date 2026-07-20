<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPengadaan;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class JenisPengadaanController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $jenisPengadaans = JenisPengadaan::orderBy('kode')->paginate(10);
        return view('admin.jenis-pengadaan.index', compact('jenisPengadaans'));
    }

    public function create()
    {
        return view('admin.jenis-pengadaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_pengadaans,kode',
            'nama' => 'required|string|max:255',
        ]);

        $jenisPengadaan = JenisPengadaan::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $jenisPengadaan,
            "Membuat jenis pengadaan: {$jenisPengadaan->nama} ({$jenisPengadaan->kode})"
        );

        return redirect()->route('admin.jenis-pengadaan.index')
            ->with('success', 'Jenis pengadaan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jenisPengadaan = JenisPengadaan::with('paketPengadaans')->findOrFail($id);
        return view('admin.jenis-pengadaan.show', compact('jenisPengadaan'));
    }

    public function edit($id)
    {
        $jenisPengadaan = JenisPengadaan::findOrFail($id);
        return view('admin.jenis-pengadaan.edit', compact('jenisPengadaan'));
    }

    public function update(Request $request, $id)
    {
        $jenisPengadaan = JenisPengadaan::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_pengadaans,kode,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $dataLama = $jenisPengadaan->toArray();
        $jenisPengadaan->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $jenisPengadaan,
            $dataLama,
            $jenisPengadaan->toArray(),
            "Memperbarui jenis pengadaan: {$jenisPengadaan->nama} ({$jenisPengadaan->kode})"
        );

        return redirect()->route('admin.jenis-pengadaan.index')
            ->with('success', 'Jenis pengadaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisPengadaan = JenisPengadaan::findOrFail($id);

        if ($jenisPengadaan->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.jenis-pengadaan.index')
                ->with('error', 'Jenis pengadaan tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $jenisPengadaan,
            "Menghapus jenis pengadaan: {$jenisPengadaan->nama} ({$jenisPengadaan->kode})"
        );

        $jenisPengadaan->delete();

        return redirect()->route('admin.jenis-pengadaan.index')
            ->with('success', 'Jenis pengadaan berhasil dihapus.');
    }
}
