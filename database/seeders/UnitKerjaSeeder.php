<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['kode' => '001', 'nama' => 'Sekretariat/Direktorat Utama', 'alamat' => 'Jl. Merdeka No. 1, Jakarta Pusat', 'telepon' => '021-12345678', 'email' => 'sekretariat@sirupi.id', 'is_active' => true],
            ['kode' => '002', 'nama' => 'Bidang Perencanaan', 'alamat' => 'Jl. Merdeka No. 2, Jakarta Pusat', 'telepon' => '021-12345679', 'email' => 'perencanaan@sirupi.id', 'is_active' => true],
            ['kode' => '003', 'nama' => 'Bidang Keuangan', 'alamat' => 'Jl. Merdeka No. 3, Jakarta Pusat', 'telepon' => '021-12345680', 'email' => 'keuangan@sirupi.id', 'is_active' => true],
            ['kode' => '004', 'nama' => 'Bidang Sumber Daya Manusia', 'alamat' => 'Jl. Merdeka No. 4, Jakarta Pusat', 'telepon' => '021-12345681', 'email' => 'sdm@sirupi.id', 'is_active' => true],
            ['kode' => '005', 'nama' => 'Bidang Teknologi Informasi', 'alamat' => 'Jl. Merdeka No. 5, Jakarta Pusat', 'telepon' => '021-12345682', 'email' => 'ti@sirupi.id', 'is_active' => true],
            ['kode' => '006', 'nama' => 'Bidang Operasional', 'alamat' => 'Jl. Merdeka No. 6, Jakarta Pusat', 'telepon' => '021-12345683', 'email' => 'operasional@sirupi.id', 'is_active' => true],
            ['kode' => '007', 'nama' => 'Bidang Infrastruktur', 'alamat' => 'Jl. Merdeka No. 7, Jakarta Pusat', 'telepon' => '021-12345684', 'email' => 'infrastruktur@sirupi.id', 'is_active' => true],
            ['kode' => '008', 'nama' => 'Bidang Pelayanan Publik', 'alamat' => 'Jl. Merdeka No. 8, Jakarta Pusat', 'telepon' => '021-12345685', 'email' => 'pelayanan@sirupi.id', 'is_active' => true],
            ['kode' => '009', 'nama' => 'Bagian Hukum dan Organisasi', 'alamat' => 'Jl. Merdeka No. 9, Jakarta Pusat', 'telepon' => '021-12345686', 'email' => 'hukum@sirupi.id', 'is_active' => true],
            ['kode' => '010', 'nama' => 'Bagian Umum dan Pengadaan', 'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat', 'telepon' => '021-12345687', 'email' => 'umum@sirupi.id', 'is_active' => true],
        ];

        foreach ($data as $item) {
            DB::table('unit_kerjas')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
