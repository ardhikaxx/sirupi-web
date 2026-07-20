<?php

namespace App\Services;

use App\Models\PaketPengadaan;
use App\Models\RiwayatPersetujuan;
use App\Models\TahunAnggaran;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PaketPengadaanService
{
    public function submitForVerification(PaketPengadaan $paket): PaketPengadaan
    {
        if ($paket->status !== 'draft') {
            throw new RuntimeException('Hanya paket dengan status draft yang dapat diajukan.');
        }

        if (!$paket->pagu_anggaran || $paket->pagu_anggaran <= 0) {
            throw new RuntimeException('Pagu anggaran harus diisi sebelum mengajukan paket.');
        }

        if (!$paket->program_id || !$paket->kegiatan_id) {
            throw new RuntimeException('Program dan kegiatan harus dipilih sebelum mengajukan paket.');
        }

        DB::transaction(function () use ($paket) {
            $statusDari = $paket->status;
            $paket->update(['status' => 'diajukan']);

            RiwayatPersetujuan::create([
                'paket_pengadaan_id' => $paket->id,
                'user_id' => $paket->user_id,
                'aksi' => 'submit',
                'status_dari' => $statusDari,
                'status_ke' => 'diajukan',
                'catatan' => 'Paket diajukan untuk verifikasi',
            ]);
        });

        return $paket->fresh();
    }

    public function verify(PaketPengadaan $paket, int $userId, string $catatan, bool $disetujui): PaketPengadaan
    {
        if ($paket->status !== 'diajukan') {
            throw new RuntimeException('Hanya paket dengan status diajukan yang dapat diverifikasi.');
        }

        $statusKe = $disetujui ? 'diverifikasi' : 'dikembalikan';
        $aksi = $disetujui ? 'verifikasi_setuju' : 'verifikasi_kembali';
        $statusDari = $paket->status;

        DB::transaction(function () use ($paket, $userId, $catatan, $statusKe, $aksi, $statusDari) {
            $paket->update(['status' => $statusKe]);

            RiwayatPersetujuan::create([
                'paket_pengadaan_id' => $paket->id,
                'user_id' => $userId,
                'aksi' => $aksi,
                'status_dari' => $statusDari,
                'status_ke' => $statusKe,
                'catatan' => $catatan,
            ]);
        });

        return $paket->fresh();
    }

    public function approve(PaketPengadaan $paket, int $userId, string $catatan, bool $disetujui): PaketPengadaan
    {
        if ($paket->status !== 'diverifikasi') {
            throw new RuntimeException('Hanya paket dengan status diverifikasi yang dapat disetujui.');
        }

        $statusKe = $disetujui ? 'disetujui' : 'ditolak';
        $aksi = $disetujui ? 'approve_setuju' : 'approve_tolak';
        $statusDari = $paket->status;

        DB::transaction(function () use ($paket, $userId, $catatan, $statusKe, $aksi, $statusDari) {
            $paket->update(['status' => $statusKe]);

            RiwayatPersetujuan::create([
                'paket_pengadaan_id' => $paket->id,
                'user_id' => $userId,
                'aksi' => $aksi,
                'status_dari' => $statusDari,
                'status_ke' => $statusKe,
                'catatan' => $catatan,
            ]);
        });

        return $paket->fresh();
    }

    public function publish(PaketPengadaan $paket, int $userId): PaketPengadaan
    {
        if ($paket->status !== 'disetujui') {
            throw new RuntimeException('Hanya paket dengan status disetujui yang dapat dipublikasikan.');
        }

        $statusDari = $paket->status;

        DB::transaction(function () use ($paket, $userId, $statusDari) {
            $paket->update([
                'status' => 'dipublikasikan',
                'is_published' => true,
                'published_at' => now(),
            ]);

            RiwayatPersetujuan::create([
                'paket_pengadaan_id' => $paket->id,
                'user_id' => $userId,
                'aksi' => 'publikasi',
                'status_dari' => $statusDari,
                'status_ke' => 'dipublikasikan',
                'catatan' => 'Paket telah dipublikasikan',
            ]);
        });

        return $paket->fresh();
    }

    public function generateKodePaket(int $unitKerjaId, int $tahunAnggaranId): string
    {
        $unitKerja = UnitKerja::findOrFail($unitKerjaId);
        $tahunAnggaran = TahunAnggaran::findOrFail($tahunAnggaranId);

        $tahun = $tahunAnggaran->tahun;
        $kodeUnit = str_pad($unitKerja->kode, 5, '0', STR_PAD_LEFT);

        $urutan = PaketPengadaan::where('unit_kerja_id', $unitKerjaId)
            ->where('tahun_anggaran_id', $tahunAnggaranId)
            ->withTrashed()
            ->count() + 1;

        $noUrut = str_pad($urutan, 4, '0', STR_PAD_LEFT);

        return 'RUP-' . $tahun . '-' . $kodeUnit . '-' . $noUrut;
    }
}
