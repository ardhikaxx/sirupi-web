<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $password = Hash::make('password');

        $data = [
            // Super Admin
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199001012024011001',
                'jabatan' => 'Super Administrator Sistem',
                'role' => 'super_admin',
                'unit_kerja_id' => 1,
                'telepon' => '081234567890',
                'is_active' => true,
            ],
            // Admin
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199001012024011002',
                'jabatan' => 'Administrator Sistem',
                'role' => 'admin',
                'unit_kerja_id' => 1,
                'telepon' => '081234567891',
                'is_active' => true,
            ],
            // Operators - 1 per unit
            [
                'name' => 'Operator Sekretariat',
                'email' => 'operator01@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199201012024012001',
                'jabatan' => 'Operator Sekretariat',
                'role' => 'operator',
                'unit_kerja_id' => 1,
                'telepon' => '081234567892',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Perencanaan',
                'email' => 'operator02@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199202012024012002',
                'jabatan' => 'Operator Bidang Perencanaan',
                'role' => 'operator',
                'unit_kerja_id' => 2,
                'telepon' => '081234567893',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Keuangan',
                'email' => 'operator03@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199203012024012003',
                'jabatan' => 'Operator Bidang Keuangan',
                'role' => 'operator',
                'unit_kerja_id' => 3,
                'telepon' => '081234567894',
                'is_active' => true,
            ],
            [
                'name' => 'Operator SDM',
                'email' => 'operator04@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199204012024012004',
                'jabatan' => 'Operator Bidang SDM',
                'role' => 'operator',
                'unit_kerja_id' => 4,
                'telepon' => '081234567895',
                'is_active' => true,
            ],
            [
                'name' => 'Operator TI',
                'email' => 'operator05@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199205012024012005',
                'jabatan' => 'Operator Bidang TI',
                'role' => 'operator',
                'unit_kerja_id' => 5,
                'telepon' => '081234567896',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Operasional',
                'email' => 'operator06@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199206012024012006',
                'jabatan' => 'Operator Bidang Operasional',
                'role' => 'operator',
                'unit_kerja_id' => 6,
                'telepon' => '081234567897',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Infrastruktur',
                'email' => 'operator07@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199207012024012007',
                'jabatan' => 'Operator Bidang Infrastruktur',
                'role' => 'operator',
                'unit_kerja_id' => 7,
                'telepon' => '081234567898',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Pelayanan Publik',
                'email' => 'operator08@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199208012024012008',
                'jabatan' => 'Operator Bidang Pelayanan Publik',
                'role' => 'operator',
                'unit_kerja_id' => 8,
                'telepon' => '081234567899',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Hukum',
                'email' => 'operator09@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199209012024012009',
                'jabatan' => 'Operator Bagian Hukum dan Organisasi',
                'role' => 'operator',
                'unit_kerja_id' => 9,
                'telepon' => '081234567800',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Umum',
                'email' => 'operator10@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199210012024012010',
                'jabatan' => 'Operator Bagian Umum dan Pengadaan',
                'role' => 'operator',
                'unit_kerja_id' => 10,
                'telepon' => '081234567801',
                'is_active' => true,
            ],
            // Verifikator
            [
                'name' => 'Verifikator Anggaran',
                'email' => 'verifikator01@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199301012024013001',
                'jabatan' => 'Verifikator Anggaran',
                'role' => 'verifikator',
                'unit_kerja_id' => 3,
                'telepon' => '081234567802',
                'is_active' => true,
            ],
            [
                'name' => 'Verifikator Teknis',
                'email' => 'verifikator02@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199302012024013002',
                'jabatan' => 'Verifikator Teknis',
                'role' => 'verifikator',
                'unit_kerja_id' => 5,
                'telepon' => '081234567803',
                'is_active' => true,
            ],
            // Pimpinan
            [
                'name' => 'Dr. H. Muhammad Faisal, S.E., M.M.',
                'email' => 'pimpinan@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '196801011998011001',
                'jabatan' => 'Kepala Dinas/PA',
                'role' => 'pimpinan',
                'unit_kerja_id' => 1,
                'telepon' => '081234567804',
                'is_active' => true,
            ],
            // Auditor
            [
                'name' => 'Auditor Internal',
                'email' => 'auditor@gmail.com',
                'password' => $password,
                'email_verified_at' => $now,
                'nip' => '199401012024014001',
                'jabatan' => 'Auditor Internal',
                'role' => 'auditor',
                'unit_kerja_id' => 9,
                'telepon' => '081234567805',
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            DB::table('users')->insert(array_merge($item, [
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
