<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyPartnership;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnershipSeeder extends Seeder
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
        $raka = User::where('email', 'hr@careerbridge.test')->firstOrFail();
        $maya = User::where('email', 'hr-data@careerbridge.test')->firstOrFail();
        $sinta = User::where('email', 'staf@careerbridge.test')->firstOrFail();

        CompanyPartnership::factory()->accepted()->create([
            'company_id' => $awanKarya->id,
            'university_id' => $und->id,
            'requested_by' => $raka->id,
            'reviewed_by' => $sinta->id,
            'pesan' => 'Kami ingin membuka program magang teknologi untuk mahasiswa UND.',
            'catatan_review' => 'Disetujui untuk periode magang semester ini.',
            'reviewed_at' => now()->subMonth(),
        ]);

        CompanyPartnership::factory()->create([
            'company_id' => $awanKarya->id,
            'university_id' => $its->id,
            'requested_by' => $raka->id,
            'pesan' => 'Kami ingin memperluas kerja sama magang ke mahasiswa ITS.',
        ]);

        CompanyPartnership::factory()->create([
            'company_id' => $dataCendekia->id,
            'university_id' => $und->id,
            'requested_by' => $maya->id,
            'pesan' => 'Kami mencari mahasiswa untuk program data analyst intern.',
        ]);
    }
}
