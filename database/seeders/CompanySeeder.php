<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->create([
            'nama' => 'PT Awan Karya Teknologi',
            'industri' => 'Teknologi Informasi',
            'alamat' => 'Jl. Cloud Raya No. 8, Jakarta',
            'website' => 'https://awan-karya.test',
            'kontak_email' => 'hr@awan-karya.test',
            'kontak_telepon' => '021-555-0202',
            'status' => 'aktif',
        ]);

        Company::factory()->create([
            'nama' => 'CV Data Cendekia',
            'industri' => 'Data dan Analitik',
            'alamat' => 'Jl. Statistik No. 12, Bandung',
            'website' => 'https://data-cendekia.test',
            'kontak_email' => 'people@data-cendekia.test',
            'kontak_telepon' => '022-555-0404',
            'status' => 'aktif',
        ]);
    }
}
