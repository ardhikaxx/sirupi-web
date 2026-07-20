<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $satuans = Satuan::orderBy('kode')->paginate(10);
        return view('admin.satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('admin.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:satuans,kode',
            'nama' => 'required|string|max:255',
        ]);

        $satuan = Satuan::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $satuan,
            "Membuat satuan: {$satuan->nama} ({$satuan->kode})"
        );

        return redirect()->route('admin.satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $satuan = Satuan::with('paketPengadaans')->findOrFail($id);
        return view('admin.satuan.show', compact('satuan'));
    }

    public function edit($id)
    {
        $satuan = Satuan::findOrFail($id);
        return view('admin.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:satuans,kode,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $dataLama = $satuan->toArray();
        $satuan->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $satuan,
            $dataLama,
            $satuan->toArray(),
            "Memperbarui satuan: {$satuan->nama} ({$satuan->kode})"
        );

        return redirect()->route('admin.satuan.index')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);

        if ($satuan->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.satuan.index')
                ->with('error', 'Satuan tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $satuan,
            "Menghapus satuan: {$satuan->nama} ({$satuan->kode})"
        );

        $satuan->delete();

        return redirect()->route('admin.satuan.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }
}
