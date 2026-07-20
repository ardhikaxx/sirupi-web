<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAnggaran;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class TahunAnggaranController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $tahunAnggarans = TahunAnggaran::orderBy('tahun', 'desc')->paginate(10);
        return view('admin.tahun-anggaran.index', compact('tahunAnggarans'));
    }

    public function create()
    {
        return view('admin.tahun-anggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2099|unique:tahun_anggarans,tahun',
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $tahunAnggaran = TahunAnggaran::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $tahunAnggaran,
            "Membuat tahun anggaran: {$tahunAnggaran->nama} ({$tahunAnggaran->tahun})"
        );

        return redirect()->route('admin.tahun-anggaran.index')
            ->with('success', 'Tahun anggaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tahunAnggaran = TahunAnggaran::with('paketPengadaans')->findOrFail($id);
        return view('admin.tahun-anggaran.show', compact('tahunAnggaran'));
    }

    public function edit($id)
    {
        $tahunAnggaran = TahunAnggaran::findOrFail($id);
        return view('admin.tahun-anggaran.edit', compact('tahunAnggaran'));
    }

    public function update(Request $request, $id)
    {
        $tahunAnggaran = TahunAnggaran::findOrFail($id);

        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2099|unique:tahun_anggarans,tahun,' . $id,
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $dataLama = $tahunAnggaran->toArray();
        $tahunAnggaran->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $tahunAnggaran,
            $dataLama,
            $tahunAnggaran->toArray(),
            "Memperbarui tahun anggaran: {$tahunAnggaran->nama} ({$tahunAnggaran->tahun})"
        );

        return redirect()->route('admin.tahun-anggaran.index')
            ->with('success', 'Tahun anggaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahunAnggaran = TahunAnggaran::findOrFail($id);

        if ($tahunAnggaran->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.tahun-anggaran.index')
                ->with('error', 'Tahun anggaran tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $tahunAnggaran,
            "Menghapus tahun anggaran: {$tahunAnggaran->nama} ({$tahunAnggaran->tahun})"
        );

        $tahunAnggaran->delete();

        return redirect()->route('admin.tahun-anggaran.index')
            ->with('success', 'Tahun anggaran berhasil dihapus.');
    }

    public function setActive($id)
    {
        TahunAnggaran::where('is_active', true)->update(['is_active' => false]);

        $tahunAnggaran = TahunAnggaran::findOrFail($id);
        $tahunAnggaran->update(['is_active' => true]);

        $this->activityLogService->log(
            auth()->user(),
            'update',
            get_class($tahunAnggaran),
            $tahunAnggaran->id,
            "Mengaktifkan tahun anggaran: {$tahunAnggaran->nama} ({$tahunAnggaran->tahun})"
        );

        return redirect()->route('admin.tahun-anggaran.index')
            ->with('success', 'Tahun anggaran aktif berhasil diubah.');
    }
}
