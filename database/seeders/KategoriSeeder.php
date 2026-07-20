<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => 'ITKOM', 'nama' => 'IT & Komunikasi'],
            ['kode' => 'ATK', 'nama' => 'Alat Tulis Kantor'],
            ['kode' => 'KEBERSIHAN', 'nama' => 'Jasa Kebersihan'],
            ['kode' => 'KEAMANAN', 'nama' => 'Jasa Keamanan'],
            ['kode' => 'KON-MAN', 'nama' => 'Konsultan Manajemen'],
            ['kode' => 'KON-TEK', 'nama' => 'Konsultan Teknik'],
            ['kode' => 'BANGUNAN', 'nama' => 'Pembangunan Gedung'],
            ['kode' => 'JALAN', 'nama' => 'Jalan dan Jembatan'],
            ['kode' => 'MEDIS', 'nama' => 'Peralatan Medis'],
            ['kode' => 'KENDARAAN', 'nama' => 'Kendaraan Bermotor'],
            ['kode' => 'MEBEL', 'nama' => 'Mebel & Perlengkapan'],
            ['kode' => 'PERCETAKAN', 'nama' => 'Percetakan'],
            ['kode' => 'PUBLIKASI', 'nama' => 'Buku & Publikasi'],
            ['kode' => 'MAKMIN', 'nama' => 'Makanan & Minuman'],
            ['kode' => 'RAWAT-GD', 'nama' => 'Perawatan Gedung'],
            ['kode' => 'TRANSPORT', 'nama' => 'Jasa Transportasi'],
        ];

        foreach ($data as $item) {
            DB::table('kategoris')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
