<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = University::query()->get();
        $companies = Company::query()->get();

        $und = $universities->firstWhere('kode', 'UND') ?? $universities->firstOrFail();
        $its = $universities->firstWhere('kode', 'ITS') ?? $universities->skip(1)->first() ?? $und;
        $awanKarya = $companies->firstWhere('nama', 'PT Awan Karya Teknologi') ?? $companies->firstOrFail();
        $dataCendekia = $companies->firstWhere('nama', 'CV Data Cendekia') ?? $companies->skip(1)->first() ?? $awanKarya;

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
            'email' => 'pembimbing-kampus@careerbridge.test',
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

        User::factory()->companySupervisor($awanKarya)->create([
            'name' => 'Adit Pembimbing Produk',
            'email' => 'pj-perusahaan@careerbridge.test',
            'nomor_induk' => 'SPV-001',
            'telepon' => '081200000008',
            'password' => 'password',
        ]);

        User::factory()->companyRepresentative($dataCendekia)->create([
            'name' => 'Maya Talent Acquisition',
            'email' => 'hr-data@careerbridge.test',
            'telepon' => '081200000007',
            'password' => 'password',
        ]);

        User::factory()
            ->count(10)
            ->sequence(fn (Sequence $sequence) => [
                'university_id' => $universities[$sequence->index % $universities->count()]->id,
            ])
            ->create();

        $universities->each(function (University $university): void {
            User::factory()->count(2)->student($university)->create();
            User::factory()->count(1)->lecturer($university)->create();
        });

        $companies->each(function (Company $company): void {
            User::factory()->count(1)->companyRepresentative($company)->create();
            User::factory()->count(2)->companySupervisor($company)->create();
        });
    }
}
