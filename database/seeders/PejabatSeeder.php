<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PejabatSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            // Unit 1 - Sekretariat
            ['nama' => 'Dr. Ahmad Syahputra, S.E., M.M.', 'nip' => '197001011994121001', 'jabatan' => 'PPTK Sekretariat', 'tipe' => 'PPTK', 'unit_kerja_id' => 1],
            ['nama' => 'Dewi Sartika, S.H., M.H.', 'nip' => '197502011995032002', 'jabatan' => 'Pejabat Pengadaan Sekretariat', 'tipe' => 'PP', 'unit_kerja_id' => 1],
            ['nama' => 'Ir. Bambang Wijaya, M.T.', 'nip' => '196803011993101003', 'jabatan' => 'KPA Sekretariat', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 1],

            // Unit 2 - Perencanaan
            ['nama' => 'Rina Marlina, S.Si., M.T.', 'nip' => '198005052005042004', 'jabatan' => 'PPTK Bidang Perencanaan', 'tipe' => 'PPTK', 'unit_kerja_id' => 2],
            ['nama' => 'Agus Salim, S.E.', 'nip' => '198106122006031005', 'jabatan' => 'Pejabat Pengadaan Perencanaan', 'tipe' => 'PP', 'unit_kerja_id' => 2],
            ['nama' => 'Dr. Hendra Gunawan, M.Si.', 'nip' => '197207151996032006', 'jabatan' => 'PA/KPA Bidang Perencanaan', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 2],

            // Unit 3 - Keuangan
            ['nama' => 'Siti Nurhaliza, S.E., M.Ak.', 'nip' => '198303032007042007', 'jabatan' => 'PPTK Bidang Keuangan', 'tipe' => 'PPTK', 'unit_kerja_id' => 3],
            ['nama' => 'Dodi Irawan, A.Md.', 'nip' => '198405042008052008', 'jabatan' => 'Pejabat Pengadaan Keuangan', 'tipe' => 'PP', 'unit_kerja_id' => 3],
            ['nama' => 'Drs. H. Rahmat Hidayat, M.M.', 'nip' => '196906062000061009', 'jabatan' => 'PA/KPA Bidang Keuangan', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 3],

            // Unit 4 - SDM
            ['nama' => 'Fajar Nugroho, S.Kom., M.M.', 'nip' => '198607072011071010', 'jabatan' => 'PPTK Bidang SDM', 'tipe' => 'PPTK', 'unit_kerja_id' => 4],
            ['nama' => 'Nina Susanti, S.Sos.', 'nip' => '198708082012082011', 'jabatan' => 'Pejabat Pengadaan SDM', 'tipe' => 'PP', 'unit_kerja_id' => 4],
            ['nama' => 'Drs. Arief Budiman, M.Pd.', 'nip' => '197109092001092012', 'jabatan' => 'PA/KPA Bidang SDM', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 4],

            // Unit 5 - TI
            ['nama' => 'Dimas Ardiansyah, S.T., M.Kom.', 'nip' => '198910102014101013', 'jabatan' => 'PPTK Bidang TI', 'tipe' => 'PPTK', 'unit_kerja_id' => 5],
            ['nama' => 'Putri Wulandari, S.Kom.', 'nip' => '199011112015112014', 'jabatan' => 'Pejabat Pengadaan TI', 'tipe' => 'PP', 'unit_kerja_id' => 5],
            ['nama' => 'Ir. Eko Prasetyo, M.T.', 'nip' => '197312122002122015', 'jabatan' => 'PA/KPA Bidang TI', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 5],

            // Unit 6 - Operasional
            ['nama' => 'Gilang Permana, S.T., M.M.', 'nip' => '199112132016131016', 'jabatan' => 'PPTK Bidang Operasional', 'tipe' => 'PPTK', 'unit_kerja_id' => 6],
            ['nama' => 'Ratna Dewi, A.Md.', 'nip' => '199201142017141017', 'jabatan' => 'Pejabat Pengadaan Operasional', 'tipe' => 'PP', 'unit_kerja_id' => 6],
            ['nama' => 'Drs. H. Supriyadi, M.Si.', 'nip' => '197401152003151018', 'jabatan' => 'PA/KPA Bidang Operasional', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 6],

            // Unit 7 - Infrastruktur
            ['nama' => 'Hariyanto, S.T., M.T.', 'nip' => '199302162018162019', 'jabatan' => 'PPTK Bidang Infrastruktur', 'tipe' => 'PPTK', 'unit_kerja_id' => 7],
            ['nama' => 'Sari Puspita, S.E.', 'nip' => '199403172019172020', 'jabatan' => 'Pejabat Pengadaan Infrastruktur', 'tipe' => 'PP', 'unit_kerja_id' => 7],
            ['nama' => 'Ir. Budi Santoso, M.Eng.', 'nip' => '197504182004182021', 'jabatan' => 'PA/KPA Bidang Infrastruktur', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 7],

            // Unit 8 - Pelayanan Publik
            ['nama' => 'Maya Anggraini, S.Sos., M.Si.', 'nip' => '199504192020192022', 'jabatan' => 'PPTK Bidang Pelayanan Publik', 'tipe' => 'PPTK', 'unit_kerja_id' => 8],
            ['nama' => 'Adi Pratama, S.Kom.', 'nip' => '199605202021202023', 'jabatan' => 'Pejabat Pengadaan Pelayanan Publik', 'tipe' => 'PP', 'unit_kerja_id' => 8],
            ['nama' => 'Drs. H. Syamsul Bahri, M.M.', 'nip' => '197606212005212024', 'jabatan' => 'PA/KPA Bidang Pelayanan Publik', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 8],

            // Unit 9 - Hukum
            ['nama' => 'Lestari Purnamasari, S.H., M.H.', 'nip' => '199707222022222025', 'jabatan' => 'PPTK Bagian Hukum dan Organisasi', 'tipe' => 'PPTK', 'unit_kerja_id' => 9],
            ['nama' => 'Bambang Hermawan, S.H.', 'nip' => '199807232023232026', 'jabatan' => 'Pejabat Pengadaan Hukum', 'tipe' => 'PP', 'unit_kerja_id' => 9],
            ['nama' => 'Dr. Hj. Farida Hanum, S.H., M.Hum.', 'nip' => '197803242006242027', 'jabatan' => 'PA/KPA Bagian Hukum dan Organisasi', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 9],

            // Unit 10 - Umum
            ['nama' => 'Rudi Hartono, S.E., M.M.', 'nip' => '199908252025252028', 'jabatan' => 'PPTK Bagian Umum dan Pengadaan', 'tipe' => 'PPTK', 'unit_kerja_id' => 10],
            ['nama' => 'Indah Permata Sari, S.E.', 'nip' => '200009262026262029', 'jabatan' => 'Pejabat Pengadaan Umum', 'tipe' => 'PP', 'unit_kerja_id' => 10],
            ['nama' => 'Drs. H. Mulyadi, M.T.', 'nip' => '198009272009272030', 'jabatan' => 'PA/KPA Bagian Umum dan Pengadaan', 'tipe' => 'PA_KPA', 'unit_kerja_id' => 10],
        ];

        foreach ($data as $item) {
            DB::table('pejabats')->insert(array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
