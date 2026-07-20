<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodePengadaanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => 'TENDER', 'nama' => 'Tender', 'keterangan' => 'Metode pemilihan penyedia barang/pekerjaan konstruksi/jasa lainnya untuk nilai di atas batas tertentu'],
            ['kode' => 'TENDER-CEPAT', 'nama' => 'Tender Cepat', 'keterangan' => 'Tender dengan proses yang dipercepat untuk kebutuhan mendesak'],
            ['kode' => 'PL', 'nama' => 'Penunjukan Langsung', 'keterangan' => 'Penunjukan langsung kepada penyedia tertentu dalam kondisi khusus'],
            ['kode' => 'PD', 'nama' => 'Pengadaan Langsung', 'keterangan' => 'Pengadaan langsung untuk nilai kecil'],
            ['kode' => 'SELEKSI', 'nama' => 'Seleksi', 'keterangan' => 'Metode pemilihan penyedia jasa konsultansi'],
            ['kode' => 'SELEKSI-CEPAT', 'nama' => 'Seleksi Cepat', 'keterangan' => 'Seleksi dengan proses yang dipercepat'],
            ['kode' => 'SAYEMBARA', 'nama' => 'Sayembara', 'keterangan' => 'Metode pemilihan untuk pekerjaan yang memerlukan gagasan kreatif'],
            ['kode' => 'KONTES', 'nama' => 'Kontes', 'keterangan' => 'Metode pemilihan berdasarkan kompetisi'],
            ['kode' => 'SWAKELOLA', 'nama' => 'Swakelola', 'keterangan' => 'Pekerjaan yang direncanakan, dikerjakan, dan diawasi sendiri'],
            ['kode' => 'EPURCHASING', 'nama' => 'E-Purchasing', 'keterangan' => 'Pengadaan melalui katalog elektronik'],
        ];

        foreach ($data as $item) {
            DB::table('metode_pengadaans')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
