<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDanaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => 'APBN', 'nama' => 'Anggaran Pendapatan dan Belanja Negara'],
            ['kode' => 'APBD-P', 'nama' => 'APBD Provinsi'],
            ['kode' => 'APBD-K', 'nama' => 'APBD Kabupaten/Kota'],
            ['kode' => 'PNBP', 'nama' => 'Penerimaan Negara Bukan Pajak'],
            ['kode' => 'HIBAH', 'nama' => 'Hibah'],
            ['kode' => 'BLN', 'nama' => 'Bantuan Luar Negeri'],
            ['kode' => 'SWASTA', 'nama' => 'Swasta/CSR'],
        ];

        foreach ($data as $item) {
            DB::table('sumber_danas')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
