<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UniversitySeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            PartnershipSeeder::class,
            InternshipOfferSeeder::class,
            InternshipApplicationSeeder::class,
        ]);
    }
}
