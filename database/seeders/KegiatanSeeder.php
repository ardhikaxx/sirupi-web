<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            // Program 1 - Sarana Prasarana (2024)
            ['kode' => 'K.01.01.2024', 'nama' => 'Belanja Peralatan dan Mesin', 'program_id' => 1, 'pagu_anggaran' => 1_200_000_000],
            ['kode' => 'K.01.02.2024', 'nama' => 'Belanja Modal Gedung dan Bangunan', 'program_id' => 1, 'pagu_anggaran' => 800_000_000],
            // Program 2 - Sistem Informasi (2024)
            ['kode' => 'K.02.01.2024', 'nama' => 'Pengembangan dan Pengelolaan Aplikasi', 'program_id' => 2, 'pagu_anggaran' => 1_000_000_000],
            ['kode' => 'K.02.02.2024', 'nama' => 'Pengadaan Perangkat TIK dan Jaringan', 'program_id' => 2, 'pagu_anggaran' => 750_000_000],
            // Program 3 - Kapasitas SDM (2025)
            ['kode' => 'K.01.01.2025', 'nama' => 'Pendidikan dan Pelatihan Aparatur', 'program_id' => 3, 'pagu_anggaran' => 600_000_000],
            ['kode' => 'K.01.02.2025', 'nama' => 'Sosialisasi dan Diseminasi Informasi', 'program_id' => 3, 'pagu_anggaran' => 400_000_000],
            // Program 4 - Barang Jasa (2025)
            ['kode' => 'K.02.01.2025', 'nama' => 'Pengadaan Alat Tulis Kantor dan Bahan Habis Pakai', 'program_id' => 4, 'pagu_anggaran' => 500_000_000],
            ['kode' => 'K.02.02.2025', 'nama' => 'Penyediaan Jasa Perkantoran', 'program_id' => 4, 'pagu_anggaran' => 1_500_000_000],
            // Program 5 - Rehabilitasi Infrastruktur (2025)
            ['kode' => 'K.03.01.2025', 'nama' => 'Rehabilitasi Gedung dan Bangunan', 'program_id' => 5, 'pagu_anggaran' => 2_500_000_000],
            ['kode' => 'K.03.02.2025', 'nama' => 'Rehabilitasi Jalan dan Jembatan', 'program_id' => 5, 'pagu_anggaran' => 1_500_000_000],
            // Program 6 - Digitalisasi (2026)
            ['kode' => 'K.01.01.2026', 'nama' => 'Pengembangan Layanan Digital Terpadu', 'program_id' => 6, 'pagu_anggaran' => 2_500_000_000],
            ['kode' => 'K.01.02.2026', 'nama' => 'Pembangunan Pusat Data dan Informasi', 'program_id' => 6, 'pagu_anggaran' => 2_000_000_000],
            // Program 7 - Infrastruktur (2026)
            ['kode' => 'K.02.01.2026', 'nama' => 'Pembangunan Gedung Serbaguna', 'program_id' => 7, 'pagu_anggaran' => 3_000_000_000],
            // Program 8 - Tata Kelola (2026)
            ['kode' => 'K.03.01.2026', 'nama' => 'Penguatan Reformasi Birokrasi', 'program_id' => 8, 'pagu_anggaran' => 500_000_000],
            ['kode' => 'K.03.02.2026', 'nama' => 'Penerapan Sistem Manajemen Mutu', 'program_id' => 8, 'pagu_anggaran' => 300_000_000],
        ];

        foreach ($data as $item) {
            DB::table('kegiatans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
