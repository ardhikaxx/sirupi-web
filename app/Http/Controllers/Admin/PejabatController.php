<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pejabat;
use App\Models\UnitKerja;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class PejabatController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $pejabats = Pejabat::with('unitKerja')->orderBy('nama')->paginate(10);
        return view('admin.pejabat.index', compact('pejabats'));
    }

    public function create()
    {
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        return view('admin.pejabat.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30|unique:pejabats,nip',
            'jabatan' => 'required|string|max:255',
            'tipe' => 'required|in:pptk,pp,pa_kpa',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        ]);

        $pejabat = Pejabat::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $pejabat,
            "Membuat pejabat: {$pejabat->nama} ({$pejabat->jabatan})"
        );

        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Pejabat berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pejabat = Pejabat::with(['unitKerja', 'paketPengadaansAsPptk', 'paketPengadaansAsPp', 'paketPengadaansAsPaKpa'])->findOrFail($id);
        return view('admin.pejabat.show', compact('pejabat'));
    }

    public function edit($id)
    {
        $pejabat = Pejabat::findOrFail($id);
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        return view('admin.pejabat.edit', compact('pejabat', 'unitKerjas'));
    }

    public function update(Request $request, $id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30|unique:pejabats,nip,' . $id,
            'jabatan' => 'required|string|max:255',
            'tipe' => 'required|in:pptk,pp,pa_kpa',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        ]);

        $dataLama = $pejabat->toArray();
        $pejabat->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $pejabat,
            $dataLama,
            $pejabat->toArray(),
            "Memperbarui pejabat: {$pejabat->nama} ({$pejabat->jabatan})"
        );

        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Pejabat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $paketCount = $pejabat->paketPengadaansAsPptk()->count()
            + $pejabat->paketPengadaansAsPp()->count()
            + $pejabat->paketPengadaansAsPaKpa()->count();

        if ($paketCount > 0) {
            return redirect()->route('admin.pejabat.index')
                ->with('error', 'Pejabat tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $pejabat,
            "Menghapus pejabat: {$pejabat->nama} ({$pejabat->jabatan})"
        );

        $pejabat->delete();

        return redirect()->route('admin.pejabat.index')
            ->with('success', 'Pejabat berhasil dihapus.');
    }
}
