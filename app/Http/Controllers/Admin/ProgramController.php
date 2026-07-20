<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\TahunAnggaran;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $programs = Program::with('tahunAnggaran')->orderBy('kode')->paginate(10);
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        $tahunAnggarans = TahunAnggaran::where('is_active', true)->get();
        return view('admin.program.create', compact('tahunAnggarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:programs,kode',
            'nama' => 'required|string|max:255',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $program = Program::create($request->all());

        $this->activityLogService->logCreate(
            auth()->user(),
            $program,
            "Membuat program: {$program->nama} ({$program->kode})"
        );

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    public function show($id)
    {
        $program = Program::with(['tahunAnggaran', 'kegiatans', 'paketPengadaans'])->findOrFail($id);
        return view('admin.program.show', compact('program'));
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $tahunAnggarans = TahunAnggaran::where('is_active', true)->get();
        return view('admin.program.edit', compact('program', 'tahunAnggarans'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:programs,kode,' . $id,
            'nama' => 'required|string|max:255',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'pagu_anggaran' => 'nullable|numeric|min:0',
        ]);

        $dataLama = $program->toArray();
        $program->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $program,
            $dataLama,
            $program->toArray(),
            "Memperbarui program: {$program->nama} ({$program->kode})"
        );

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        if ($program->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.program.index')
                ->with('error', 'Program tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $program,
            "Menghapus program: {$program->nama} ({$program->kode})"
        );

        $program->delete();

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil dihapus.');
    }
}
