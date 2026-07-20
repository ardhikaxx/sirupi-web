<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UnitKerjaSeeder::class,
            TahunAnggaranSeeder::class,
            ProgramSeeder::class,
            KegiatanSeeder::class,
            SubKegiatanSeeder::class,
            SumberDanaSeeder::class,
            JenisPengadaanSeeder::class,
            MetodePengadaanSeeder::class,
            KategoriSeeder::class,
            SatuanSeeder::class,
            PenyediaSeeder::class,
            PejabatSeeder::class,
            UserSeeder::class,
            PaketPengadaanSeeder::class,
        ]);
    }
}
