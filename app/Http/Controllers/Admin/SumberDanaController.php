<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SumberDana;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class SumberDanaController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $sumberDanas = SumberDana::orderBy('kode')->paginate(10);
        return view('admin.sumber-dana.index', compact('sumberDanas'));
    }

    public function create()
    {
        return view('admin.sumber-dana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:sumber_danas,kode',
            'nama' => 'required|string|max:255',
        ]);

        $sumberDana = SumberDana::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $sumberDana,
            "Membuat sumber dana: {$sumberDana->nama} ({$sumberDana->kode})"
        );

        return redirect()->route('admin.sumber-dana.index')
            ->with('success', 'Sumber dana berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sumberDana = SumberDana::with('paketPengadaans')->findOrFail($id);
        return view('admin.sumber-dana.show', compact('sumberDana'));
    }

    public function edit($id)
    {
        $sumberDana = SumberDana::findOrFail($id);
        return view('admin.sumber-dana.edit', compact('sumberDana'));
    }

    public function update(Request $request, $id)
    {
        $sumberDana = SumberDana::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:sumber_danas,kode,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $dataLama = $sumberDana->toArray();
        $sumberDana->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $sumberDana,
            $dataLama,
            $sumberDana->toArray(),
            "Memperbarui sumber dana: {$sumberDana->nama} ({$sumberDana->kode})"
        );

        return redirect()->route('admin.sumber-dana.index')
            ->with('success', 'Sumber dana berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sumberDana = SumberDana::findOrFail($id);

        if ($sumberDana->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.sumber-dana.index')
                ->with('error', 'Sumber dana tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $sumberDana,
            "Menghapus sumber dana: {$sumberDana->nama} ({$sumberDana->kode})"
        );

        $sumberDana->delete();

        return redirect()->route('admin.sumber-dana.index')
            ->with('success', 'Sumber dana berhasil dihapus.');
    }
}
