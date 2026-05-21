<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $und = University::where('kode', 'UND')->firstOrFail();
        $its = University::where('kode', 'ITS')->firstOrFail();
        $awanKarya = Company::where('nama', 'PT Awan Karya Teknologi')->firstOrFail();
        $dataCendekia = Company::where('nama', 'CV Data Cendekia')->firstOrFail();

        User::factory()->staff($und)->create([
            'name' => 'Sinta Career Center',
            'email' => 'staf@careerbridge.test',
            'telepon' => '081200000001',
            'password' => 'password',
        ]);

        User::factory()->staff($its)->create([
            'name' => 'Dimas CDC Kampus',
            'email' => 'staf-its@careerbridge.test',
            'telepon' => '081200000005',
            'password' => 'password',
        ]);

        User::factory()->lecturer($und)->create([
            'name' => 'Prof. Bima Prakoso',
            'email' => 'dosen@careerbridge.test',
            'nomor_induk' => 'DSN-001',
            'program_studi' => 'Sistem Informasi',
            'telepon' => '081200000002',
            'password' => 'password',
        ]);

        User::factory()->student($und)->create([
            'name' => 'Nadia Putri',
            'email' => 'mahasiswa@careerbridge.test',
            'nomor_induk' => '2204010101',
            'program_studi' => 'Teknik Informatika',
            'telepon' => '081200000003',
            'password' => 'password',
        ]);

        User::factory()->student($its)->create([
            'name' => 'Rafi Ananda',
            'email' => 'mahasiswa-its@careerbridge.test',
            'nomor_induk' => '2204020202',
            'program_studi' => 'Data Science',
            'telepon' => '081200000006',
            'password' => 'password',
        ]);

        User::factory()->companyRepresentative($awanKarya)->create([
            'name' => 'Raka HR Partner',
            'email' => 'hr@careerbridge.test',
            'telepon' => '081200000004',
            'password' => 'password',
        ]);

        User::factory()->companyRepresentative($dataCendekia)->create([
            'name' => 'Maya Talent Acquisition',
            'email' => 'hr-data@careerbridge.test',
            'telepon' => '081200000007',
            'password' => 'password',
        ]);
    }
}
