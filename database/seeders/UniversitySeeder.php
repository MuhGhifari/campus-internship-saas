<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        University::factory()->create([
            'nama' => 'Universitas Nusantara Digital',
            'kode' => 'UND',
            'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
            'email' => 'karier@und.ac.id',
            'telepon' => '021-555-0101',
        ]);

        University::factory()->create([
            'nama' => 'Institut Teknologi Selatan',
            'kode' => 'ITS',
            'alamat' => 'Jl. Inovasi No. 21, Bandung',
            'email' => 'cdc@its.test',
            'telepon' => '022-555-0303',
        ]);
    }
}
