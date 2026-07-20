<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPengadaanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => 'BRG', 'nama' => 'Barang'],
            ['kode' => 'PK', 'nama' => 'Pekerjaan Konstruksi'],
            ['kode' => 'JK', 'nama' => 'Jasa Konsultansi'],
            ['kode' => 'JL', 'nama' => 'Jasa Lainnya'],
        ];

        foreach ($data as $item) {
            DB::table('jenis_pengadaans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
