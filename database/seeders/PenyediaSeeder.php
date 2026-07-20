<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyediaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            [
                'nama' => 'PT. Teknologi Solusi Nusantara',
                'npwp' => '01.234.567.8-901.000',
                'alamat' => 'Jl. Gatot Subroto Kav. 56, Jakarta Selatan',
                'telepon' => '021-29876543',
                'email' => 'info@tsn.co.id',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'CV. Karya Mandiri Sejahtera',
                'npwp' => '02.345.678.9-012.000',
                'alamat' => 'Jl. Ahmad Yani No. 123, Bandung',
                'telepon' => '022-73456789',
                'email' => 'karya.mandiri@cvmail.com',
                'jenis' => 'CV',
            ],
            [
                'nama' => 'PT. Bangun Cipta Konstruksi',
                'npwp' => '03.456.789.0-123.000',
                'alamat' => 'Jl. Sudirman No. 78, Jakarta Pusat',
                'telepon' => '021-57654321',
                'email' => 'bckonstruksi@pt-bck.com',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'CV. Multi Sarana Abadi',
                'npwp' => '04.567.890.1-234.000',
                'alamat' => 'Jl. Diponegoro No. 45, Surabaya',
                'telepon' => '031-84567890',
                'email' => 'msa@gmail.com',
                'jenis' => 'CV',
            ],
            [
                'nama' => 'PT. Konsultan Manajemen Terpadu',
                'npwp' => '05.678.901.2-345.000',
                'alamat' => 'Jl. Rasuna Said Kav. 12, Jakarta Selatan',
                'telepon' => '021-52987654',
                'email' => 'kmt@kmt.co.id',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'PD. Bina Karya',
                'npwp' => '06.789.012.3-456.000',
                'alamat' => 'Jl. Merdeka No. 67, Yogyakarta',
                'telepon' => '0274-5123456',
                'email' => 'binakarya@pdmail.com',
                'jenis' => 'PD',
            ],
            [
                'nama' => 'PT. Armada Transportindo',
                'npwp' => '07.890.123.4-567.000',
                'alamat' => 'Jl. Raya Bogor Km. 21, Depok',
                'telepon' => '021-67890123',
                'email' => 'armada.trans@att.net',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'CV. Cahaya Terang Abadi',
                'npwp' => '08.901.234.5-678.000',
                'alamat' => 'Jl. Pahlawan No. 34, Semarang',
                'telepon' => '024-35678901',
                'email' => 'cta.abadi@yahoo.com',
                'jenis' => 'CV',
            ],
            [
                'nama' => 'PT. Global Inovasi Teknologi',
                'npwp' => '09.012.345.6-789.000',
                'alamat' => 'Jl. TB Simatupang Kav. 89, Jakarta Selatan',
                'telepon' => '021-76543210',
                'email' => 'global.it@git.co.id',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'Firma Hukum & Organisasi Konsultan',
                'npwp' => '10.123.456.7-890.000',
                'alamat' => 'Jl. Matraman No. 12, Jakarta Timur',
                'telepon' => '021-85678901',
                'email' => 'hukum@fhok.com',
                'jenis' => 'Firma',
            ],
            [
                'nama' => 'PT. Sarana Prima Lestari',
                'npwp' => '11.234.567.8-901.000',
                'alamat' => 'Jl. Sisingamangaraja No. 56, Medan',
                'telepon' => '061-45678901',
                'email' => 'splestari@pt-spl.com',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'CV. Indah Persada Furniture',
                'npwp' => '12.345.678.9-012.000',
                'alamat' => 'Jl. Raya Cirebon No. 78, Cirebon',
                'telepon' => '0231-234567',
                'email' => 'ipfurniture@cvipf.com',
                'jenis' => 'CV',
            ],
            [
                'nama' => 'PT. Amalia Medika Utama',
                'npwp' => '13.456.789.0-123.000',
                'alamat' => 'Jl. Kesehatan No. 23, Makassar',
                'telepon' => '0411-5678901',
                'email' => 'amalia.medika@amu.co.id',
                'jenis' => 'PT',
            ],
            [
                'nama' => 'Koperasi Karya Bersama',
                'npwp' => '14.567.890.1-234.000',
                'alamat' => 'Jl. Siliwangi No. 90, Tasikmalaya',
                'telepon' => '0265-345678',
                'email' => 'koperasi@karya-bersama.id',
                'jenis' => 'Koperasi',
            ],
            [
                'nama' => 'PT. Percetakan Nasional Utama',
                'npwp' => '15.678.901.2-345.000',
                'alamat' => 'Jl. Industri No. 45, Bekasi',
                'telepon' => '021-89012345',
                'email' => 'pnutama@percetakan.co.id',
                'jenis' => 'PT',
            ],
        ];

        foreach ($data as $item) {
            DB::table('penyedias')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
