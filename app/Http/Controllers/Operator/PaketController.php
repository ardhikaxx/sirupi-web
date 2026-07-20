<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PaketPengadaan;
use App\Models\PaketAnggaran;
use App\Models\PaketJadwal;
use App\Models\PaketLokasi;
use App\Models\Dokumen;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use App\Models\JenisPengadaan;
use App\Models\MetodePengadaan;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Penyedia;
use App\Models\Pejabat;
use App\Models\TahunAnggaran;
use App\Services\PaketPengadaanService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PaketController extends Controller
{
    protected $paketPengadaanService;
    protected $activityLogService;

    public function __construct(
        PaketPengadaanService $paketPengadaanService,
        ActivityLogService $activityLogService
    ) {
        $this->paketPengadaanService = $paketPengadaanService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = PaketPengadaan::with([
            'unitKerja', 'tahunAnggaran', 'program', 'kegiatan'
        ])
            ->where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                    ->orWhere('kode_paket', 'like', "%{$search}%");
            });
        }

        $pakets = $query->latest()->paginate(10);

        return view('operator.paket.index', compact('pakets'));
    }

    public function create()
    {
        $user = auth()->user();

        $tahunAnggarans = TahunAnggaran::where('is_active', true)->get();
        $programs = Program::whereHas('tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $kegiatans = Kegiatan::whereHas('program.tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $subKegiatans = SubKegiatan::whereHas('kegiatan.program.tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $sumberDanas = SumberDana::all();
        $jenisPengadaans = JenisPengadaan::all();
        $metodePengadaans = MetodePengadaan::all();
        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        $penyedias = Penyedia::all();
        $pejabats = Pejabat::where('unit_kerja_id', $user->unit_kerja_id)->get();

        return view('operator.paket.create', compact(
            'tahunAnggarans', 'programs', 'kegiatans', 'subKegiatans',
            'sumberDanas', 'jenisPengadaans', 'metodePengadaans',
            'kategoris', 'satuans', 'penyedias', 'pejabats'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'uraian_pekerjaan' => 'nullable|string',
            'pagu_anggaran' => 'nullable|numeric|min:0',
            'hps' => 'nullable|numeric|min:0',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'program_id' => 'required|exists:programs,id',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'sub_kegiatan_id' => 'nullable|exists:sub_kegiatans,id',
            'sumber_dana_id' => 'nullable|exists:sumber_danas,id',
            'jenis_pengadaan_id' => 'nullable|exists:jenis_pengadaans,id',
            'metode_pengadaan_id' => 'nullable|exists:metode_pengadaans,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'satuan_id' => 'nullable|exists:satuans,id',
            'penyedia_id' => 'nullable|exists:penyedias,id',
            'pptk_id' => 'nullable|exists:pejabats,id',
            'pp_id' => 'nullable|exists:pejabats,id',
            'pa_kpa_id' => 'nullable|exists:pejabats,id',
        ]);

        $kodePaket = $this->paketPengadaanService->generateKodePaket(
            $user->unit_kerja_id,
            $request->tahun_anggaran_id
        );

        $data = $request->all();
        $data['kode_paket'] = $kodePaket;
        $data['status'] = 'draft';
        $data['user_id'] = $user->id;
        $data['unit_kerja_id'] = $user->unit_kerja_id;

        $paket = PaketPengadaan::create($data);

        $this->activityLogService->logCreate(
            $user,
            $paket,
            "Membuat paket pengadaan: {$paket->nama_paket} ({$paket->kode_paket})"
        );

        return redirect()->route('operator.paket.index')
            ->with('success', 'Paket pengadaan berhasil dibuat.');
    }

    public function show($id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::with([
            'unitKerja', 'tahunAnggaran', 'program', 'kegiatan',
            'subKegiatan', 'sumberDana', 'jenisPengadaan',
            'metodePengadaan', 'kategori', 'satuan', 'penyedia',
            'pptk', 'pp', 'paKpa',
            'paketAnggarans.satuan',
            'paketJadwals',
            'paketLokasis',
            'dokumens.uploader',
            'riwayatPersetujuans.user',
        ])
            ->where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('operator.paket.show', compact('paket'));
    }

    public function edit($id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        $tahunAnggarans = TahunAnggaran::where('is_active', true)->get();
        $programs = Program::whereHas('tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $kegiatans = Kegiatan::whereHas('program.tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $subKegiatans = SubKegiatan::whereHas('kegiatan.program.tahunAnggaran', function ($q) {
            $q->where('is_active', true);
        })->get();
        $sumberDanas = SumberDana::all();
        $jenisPengadaans = JenisPengadaan::all();
        $metodePengadaans = MetodePengadaan::all();
        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        $penyedias = Penyedia::all();
        $pejabats = Pejabat::where('unit_kerja_id', $user->unit_kerja_id)->get();

        return view('operator.paket.edit', compact(
            'paket',
            'tahunAnggarans', 'programs', 'kegiatans', 'subKegiatans',
            'sumberDanas', 'jenisPengadaans', 'metodePengadaans',
            'kategoris', 'satuans', 'penyedias', 'pejabats'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'uraian_pekerjaan' => 'nullable|string',
            'pagu_anggaran' => 'nullable|numeric|min:0',
            'hps' => 'nullable|numeric|min:0',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'program_id' => 'required|exists:programs,id',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'sub_kegiatan_id' => 'nullable|exists:sub_kegiatans,id',
            'sumber_dana_id' => 'nullable|exists:sumber_danas,id',
            'jenis_pengadaan_id' => 'nullable|exists:jenis_pengadaans,id',
            'metode_pengadaan_id' => 'nullable|exists:metode_pengadaans,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'satuan_id' => 'nullable|exists:satuans,id',
            'penyedia_id' => 'nullable|exists:penyedias,id',
            'pptk_id' => 'nullable|exists:pejabats,id',
            'pp_id' => 'nullable|exists:pejabats,id',
            'pa_kpa_id' => 'nullable|exists:pejabats,id',
        ]);

        $dataLama = $paket->toArray();
        $paket->update($request->all());

        $this->activityLogService->logUpdate(
            $user,
            $paket,
            $dataLama,
            $paket->toArray(),
            "Memperbarui paket pengadaan: {$paket->nama_paket} ({$paket->kode_paket})"
        );

        return redirect()->route('operator.paket.index')
            ->with('success', 'Paket pengadaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        $this->activityLogService->logDelete(
            $user,
            $paket,
            "Menghapus paket pengadaan: {$paket->nama_paket} ({$paket->kode_paket})"
        );

        $paket->delete();

        return redirect()->route('operator.paket.index')
            ->with('success', 'Paket pengadaan berhasil dihapus.');
    }

    public function submitVerification($id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        try {
            $this->paketPengadaanService->submitForVerification($paket);

            $this->activityLogService->log(
                $user,
                'update',
                get_class($paket),
                $paket->id,
                "Mengajukan paket untuk verifikasi: {$paket->nama_paket} ({$paket->kode_paket})"
            );

            return redirect()->route('operator.paket.index')
                ->with('success', 'Paket berhasil diajukan untuk verifikasi.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadDokumen(Request $request, $id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tipe_dokumen' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('dokumen/' . $paket->id, 'public');

        $dokumen = Dokumen::create([
            'paket_pengadaan_id' => $paket->id,
            'nama_dokumen' => $request->nama_dokumen,
            'tipe_dokumen' => $request->tipe_dokumen,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'is_public' => $request->boolean('is_public'),
            'uploaded_by' => $user->id,
        ]);

        $this->activityLogService->logCreate(
            $user,
            $dokumen,
            "Mengunggah dokumen {$dokumen->nama_dokumen} untuk paket: {$paket->nama_paket}"
        );

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function hapusDokumen($id, $dokumenId)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $dokumen = Dokumen::where('paket_pengadaan_id', $paket->id)
            ->where('uploaded_by', $user->id)
            ->findOrFail($dokumenId);

        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $this->activityLogService->logDelete(
            $user,
            $dokumen,
            "Menghapus dokumen {$dokumen->nama_dokumen} dari paket: {$paket->nama_paket}"
        );

        $dokumen->delete();

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function addAnggaran(Request $request, $id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $request->validate([
            'nama_item' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'satuan_id' => 'required|exists:satuans,id',
            'harga_satuan' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $anggaran = PaketAnggaran::create([
            'paket_pengadaan_id' => $paket->id,
            'nama_item' => $request->nama_item,
            'volume' => $request->volume,
            'satuan_id' => $request->satuan_id,
            'harga_satuan' => $request->harga_satuan,
            'total' => $request->total,
        ]);

        $this->activityLogService->logCreate(
            $user,
            $anggaran,
            "Menambahkan item anggaran {$anggaran->nama_item} untuk paket: {$paket->nama_paket}"
        );

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Item anggaran berhasil ditambahkan.');
    }

    public function hapusAnggaran($id, $anggaranId)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $anggaran = PaketAnggaran::where('paket_pengadaan_id', $paket->id)
            ->findOrFail($anggaranId);

        $this->activityLogService->logDelete(
            $user,
            $anggaran,
            "Menghapus item anggaran {$anggaran->nama_item} dari paket: {$paket->nama_paket}"
        );

        $anggaran->delete();

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Item anggaran berhasil dihapus.');
    }

    public function addJadwal(Request $request, $id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $request->validate([
            'tahapan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal = PaketJadwal::create([
            'paket_pengadaan_id' => $paket->id,
            'tahapan' => $request->tahapan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
        ]);

        $this->activityLogService->logCreate(
            $user,
            $jadwal,
            "Menambahkan jadwal {$jadwal->tahapan} untuk paket: {$paket->nama_paket}"
        );

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function hapusJadwal($id, $jadwalId)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $jadwal = PaketJadwal::where('paket_pengadaan_id', $paket->id)
            ->findOrFail($jadwalId);

        $this->activityLogService->logDelete(
            $user,
            $jadwal,
            "Menghapus jadwal {$jadwal->tahapan} dari paket: {$paket->nama_paket}"
        );

        $jadwal->delete();

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function addLokasi(Request $request, $id)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan_desa' => 'nullable|string|max:255',
            'detail_alamat' => 'nullable|string',
        ]);

        $lokasi = PaketLokasi::create([
            'paket_pengadaan_id' => $paket->id,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan_desa' => $request->kelurahan_desa,
            'detail_alamat' => $request->detail_alamat,
        ]);

        $this->activityLogService->logCreate(
            $user,
            $lokasi,
            "Menambahkan lokasi untuk paket: {$paket->nama_paket}"
        );

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function hapusLokasi($id, $lokasiId)
    {
        $user = auth()->user();

        $paket = PaketPengadaan::where('unit_kerja_id', $user->unit_kerja_id)
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $lokasi = PaketLokasi::where('paket_pengadaan_id', $paket->id)
            ->findOrFail($lokasiId);

        $this->activityLogService->logDelete(
            $user,
            $lokasi,
            "Menghapus lokasi dari paket: {$paket->nama_paket}"
        );

        $lokasi->delete();

        return redirect()->route('operator.paket.show', $paket->id)
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
