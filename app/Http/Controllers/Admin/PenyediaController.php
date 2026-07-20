<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyedia;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class PenyediaController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $penyedias = Penyedia::orderBy('nama')->paginate(10);
        return view('admin.penyedia.index', compact('penyedias'));
    }

    public function create()
    {
        return view('admin.penyedia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:30|unique:penyedias,npwp',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jenis' => 'nullable|string|max:100',
        ]);

        $penyedia = Penyedia::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $penyedia,
            "Membuat penyedia: {$penyedia->nama}"
        );

        return redirect()->route('admin.penyedia.index')
            ->with('success', 'Penyedia berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penyedia = Penyedia::with('paketPengadaans')->findOrFail($id);
        return view('admin.penyedia.show', compact('penyedia'));
    }

    public function edit($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        return view('admin.penyedia.edit', compact('penyedia'));
    }

    public function update(Request $request, $id)
    {
        $penyedia = Penyedia::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:30|unique:penyedias,npwp,' . $id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jenis' => 'nullable|string|max:100',
        ]);

        $dataLama = $penyedia->toArray();
        $penyedia->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $penyedia,
            $dataLama,
            $penyedia->toArray(),
            "Memperbarui penyedia: {$penyedia->nama}"
        );

        return redirect()->route('admin.penyedia.index')
            ->with('success', 'Penyedia berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penyedia = Penyedia::findOrFail($id);

        if ($penyedia->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.penyedia.index')
                ->with('error', 'Penyedia tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $penyedia,
            "Menghapus penyedia: {$penyedia->nama}"
        );

        $penyedia->delete();

        return redirect()->route('admin.penyedia.index')
            ->with('success', 'Penyedia berhasil dihapus.');
    }
}
