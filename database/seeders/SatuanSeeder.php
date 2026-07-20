<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => 'UNIT', 'nama' => 'Unit'],
            ['kode' => 'BUAH', 'nama' => 'Buah'],
            ['kode' => 'PAKET', 'nama' => 'Paket'],
            ['kode' => 'SET', 'nama' => 'Set'],
            ['kode' => 'LUSIN', 'nama' => 'Lusin'],
            ['kode' => 'RIM', 'nama' => 'Rim'],
            ['kode' => 'METER', 'nama' => 'Meter'],
            ['kode' => 'KG', 'nama' => 'Kilogram'],
            ['kode' => 'LITER', 'nama' => 'Liter'],
            ['kode' => 'BULAN', 'nama' => 'Bulan'],
            ['kode' => 'TAHUN', 'nama' => 'Tahun'],
            ['kode' => 'HARI', 'nama' => 'Hari'],
            ['kode' => 'JAM', 'nama' => 'Jam'],
            ['kode' => 'LEMBAR', 'nama' => 'Lembar'],
            ['kode' => 'DUS', 'nama' => 'Dus'],
            ['kode' => 'BATANG', 'nama' => 'Batang'],
            ['kode' => 'ROLL', 'nama' => 'Roll'],
            ['kode' => 'LAYANAN', 'nama' => 'Layanan'],
            ['kode' => 'KEGIATAN', 'nama' => 'Kegiatan'],
            ['kode' => 'DOKUMEN', 'nama' => 'Dokumen'],
            ['kode' => 'ORANG', 'nama' => 'Orang'],
            ['kode' => 'KALI', 'nama' => 'Kali'],
            ['kode' => 'PERSEN', 'nama' => 'Persen'],
        ];

        foreach ($data as $item) {
            DB::table('satuans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
