<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            // Kegiatan 1 - Peralatan Mesin
            ['kode' => 'SK.01.01.2024', 'nama' => 'Pengadaan Laptop dan Notebook ASN', 'kegiatan_id' => 1, 'pagu_anggaran' => 500_000_000],
            ['kode' => 'SK.01.02.2024', 'nama' => 'Pengadaan Printer dan Scanner', 'kegiatan_id' => 1, 'pagu_anggaran' => 200_000_000],
            // Kegiatan 2 - Modal Gedung
            ['kode' => 'SK.01.03.2024', 'nama' => 'Renovasi Ruang Kerja Kantor', 'kegiatan_id' => 2, 'pagu_anggaran' => 400_000_000],
            ['kode' => 'SK.01.04.2024', 'nama' => 'Pembangunan Ruang Arsip Digital', 'kegiatan_id' => 2, 'pagu_anggaran' => 350_000_000],
            // Kegiatan 3 - Aplikasi
            ['kode' => 'SK.02.01.2024', 'nama' => 'Pengembangan Sistem Informasi Kepegawaian', 'kegiatan_id' => 3, 'pagu_anggaran' => 600_000_000],
            ['kode' => 'SK.02.02.2024', 'nama' => 'Pengembangan Aplikasi Layanan Publik', 'kegiatan_id' => 3, 'pagu_anggaran' => 400_000_000],
            // Kegiatan 4 - TIK
            ['kode' => 'SK.02.03.2024', 'nama' => 'Pengadaan Server dan Storage', 'kegiatan_id' => 4, 'pagu_anggaran' => 500_000_000],
            ['kode' => 'SK.02.04.2024', 'nama' => 'Pengadaan Perangkat Jaringan', 'kegiatan_id' => 4, 'pagu_anggaran' => 250_000_000],
            // Kegiatan 5 - Diklat
            ['kode' => 'SK.01.01.2025', 'nama' => 'Bimbingan Teknis Pengadaan Barang dan Jasa', 'kegiatan_id' => 5, 'pagu_anggaran' => 300_000_000],
            ['kode' => 'SK.01.02.2025', 'nama' => 'Diklat Kepemimpinan Tingkat IV', 'kegiatan_id' => 5, 'pagu_anggaran' => 200_000_000],
            // Kegiatan 6 - Sosialisasi
            ['kode' => 'SK.01.03.2025', 'nama' => 'Sosialisasi Standar Pelayanan Publik', 'kegiatan_id' => 6, 'pagu_anggaran' => 150_000_000],
            // Kegiatan 7 - ATK
            ['kode' => 'SK.02.01.2025', 'nama' => 'Pengadaan Alat Tulis Kantor', 'kegiatan_id' => 7, 'pagu_anggaran' => 500_000_000],
            // Kegiatan 8 - Jasa Perkantoran
            ['kode' => 'SK.02.02.2025', 'nama' => 'Penyediaan Jasa Kebersihan Kantor', 'kegiatan_id' => 8, 'pagu_anggaran' => 600_000_000],
            ['kode' => 'SK.02.03.2025', 'nama' => 'Penyediaan Jasa Keamanan Kantor', 'kegiatan_id' => 8, 'pagu_anggaran' => 500_000_000],
            // Kegiatan 9 - Rehab Gedung
            ['kode' => 'SK.03.01.2025', 'nama' => 'Rehabilitasi Total Gedung A', 'kegiatan_id' => 9, 'pagu_anggaran' => 1_500_000_000],
            // Kegiatan 10 - Rehab Jalan
            ['kode' => 'SK.03.02.2025', 'nama' => 'Peningkatan Jalan Akses Kantor', 'kegiatan_id' => 10, 'pagu_anggaran' => 1_200_000_000],
            // Kegiatan 11 - Layanan Digital
            ['kode' => 'SK.01.01.2026', 'nama' => 'Pembangunan Portal Layanan Digital Terpadu', 'kegiatan_id' => 11, 'pagu_anggaran' => 1_500_000_000],
            ['kode' => 'SK.01.02.2026', 'nama' => 'Aplikasi Sistem Pengaduan Masyarakat', 'kegiatan_id' => 11, 'pagu_anggaran' => 800_000_000],
            // Kegiatan 12 - Pusat Data
            ['kode' => 'SK.01.03.2026', 'nama' => 'Pembangunan Data Center', 'kegiatan_id' => 12, 'pagu_anggaran' => 1_200_000_000],
            ['kode' => 'SK.01.04.2026', 'nama' => 'Pengadaan UPS dan Genset Data Center', 'kegiatan_id' => 12, 'pagu_anggaran' => 500_000_000],
            // Kegiatan 13 - Gedung Serbaguna
            ['kode' => 'SK.02.01.2026', 'nama' => 'Pembangunan Gedung Serbaguna', 'kegiatan_id' => 13, 'pagu_anggaran' => 2_500_000_000],
            // Kegiatan 14 - Reformasi Birokrasi
            ['kode' => 'SK.03.01.2026', 'nama' => 'Penyusunan Standar Operasional Prosedur', 'kegiatan_id' => 14, 'pagu_anggaran' => 200_000_000],
            ['kode' => 'SK.03.02.2026', 'nama' => 'Monitoring dan Evaluasi Kinerja', 'kegiatan_id' => 14, 'pagu_anggaran' => 150_000_000],
            // Kegiatan 15 - Manajemen Mutu
            ['kode' => 'SK.03.03.2026', 'nama' => 'Sertifikasi Sistem Manajemen Mutu ISO', 'kegiatan_id' => 15, 'pagu_anggaran' => 200_000_000],
        ];

        foreach ($data as $item) {
            DB::table('sub_kegiatans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
