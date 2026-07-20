<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            [
                'kode' => 'P.01.2024',
                'nama' => 'Program Peningkatan Sarana dan Prasarana Aparatur',
                'tahun_anggaran_id' => 1,
                'pagu_anggaran' => 2_500_000_000,
            ],
            [
                'kode' => 'P.02.2024',
                'nama' => 'Program Pengembangan Sistem Informasi dan Teknologi',
                'tahun_anggaran_id' => 1,
                'pagu_anggaran' => 1_750_000_000,
            ],
            [
                'kode' => 'P.01.2025',
                'nama' => 'Program Peningkatan Kapasitas Sumber Daya Manusia',
                'tahun_anggaran_id' => 2,
                'pagu_anggaran' => 1_200_000_000,
            ],
            [
                'kode' => 'P.02.2025',
                'nama' => 'Program Pengadaan Barang dan Jasa Perkantoran',
                'tahun_anggaran_id' => 2,
                'pagu_anggaran' => 3_000_000_000,
            ],
            [
                'kode' => 'P.03.2025',
                'nama' => 'Program Rehabilitasi dan Pemeliharaan Infrastruktur',
                'tahun_anggaran_id' => 2,
                'pagu_anggaran' => 4_500_000_000,
            ],
            [
                'kode' => 'P.01.2026',
                'nama' => 'Program Digitalisasi Pelayanan Publik',
                'tahun_anggaran_id' => 3,
                'pagu_anggaran' => 5_000_000_000,
            ],
            [
                'kode' => 'P.02.2026',
                'nama' => 'Program Pembangunan dan Pengembangan Infrastruktur',
                'tahun_anggaran_id' => 3,
                'pagu_anggaran' => 4_000_000_000,
            ],
            [
                'kode' => 'P.03.2026',
                'nama' => 'Program Penguatan Tata Kelola dan Reformasi Birokrasi',
                'tahun_anggaran_id' => 3,
                'pagu_anggaran' => 1_800_000_000,
            ],
        ];

        foreach ($data as $item) {
            DB::table('programs')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
