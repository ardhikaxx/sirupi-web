<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $unitKerjas = UnitKerja::paginate(10);
        return view('admin.unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        return view('admin.unit-kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:unit_kerjas,kode',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $unitKerja = UnitKerja::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $unitKerja,
            "Membuat unit kerja: {$unitKerja->nama}"
        );

        return redirect()->route('admin.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function show($id)
    {
        $unitKerja = UnitKerja::with(['users', 'paketPengadaans'])->findOrFail($id);
        return view('admin.unit-kerja.show', compact('unitKerja'));
    }

    public function edit($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        return view('admin.unit-kerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, $id)
    {
        $unitKerja = UnitKerja::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:unit_kerjas,kode,' . $id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $dataLama = $unitKerja->toArray();
        $unitKerja->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $unitKerja,
            $dataLama,
            $unitKerja->toArray(),
            "Memperbarui unit kerja: {$unitKerja->nama}"
        );

        return redirect()->route('admin.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);

        if ($unitKerja->users()->count() > 0) {
            return redirect()->route('admin.unit-kerja.index')
                ->with('error', 'Unit kerja tidak dapat dihapus karena masih memiliki pengguna.');
        }

        if ($unitKerja->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.unit-kerja.index')
                ->with('error', 'Unit kerja tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $unitKerja,
            "Menghapus unit kerja: {$unitKerja->nama}"
        );

        $unitKerja->delete();

        return redirect()->route('admin.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil dihapus.');
    }
}
