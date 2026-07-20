<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAnggaranSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            [
                'tahun' => 2024,
                'nama' => 'Tahun Anggaran 2024',
                'tanggal_mulai' => '2024-01-01',
                'tanggal_selesai' => '2024-12-31',
                'is_active' => false,
            ],
            [
                'tahun' => 2025,
                'nama' => 'Tahun Anggaran 2025',
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'is_active' => false,
            ],
            [
                'tahun' => 2026,
                'nama' => 'Tahun Anggaran 2026',
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-12-31',
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            DB::table('tahun_anggarans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
