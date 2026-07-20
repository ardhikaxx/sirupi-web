<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $kategoris = Kategori::orderBy('kode')->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kategoris,kode',
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $kategori,
            "Membuat kategori: {$kategori->nama} ({$kategori->kode})"
        );

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kategori = Kategori::with('paketPengadaans')->findOrFail($id);
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:kategoris,kode,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $dataLama = $kategori->toArray();
        $kategori->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $kategori,
            $dataLama,
            $kategori->toArray(),
            "Memperbarui kategori: {$kategori->nama} ({$kategori->kode})"
        );

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $kategori,
            "Menghapus kategori: {$kategori->nama} ({$kategori->kode})"
        );

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
