<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => 'PT '.$this->faker->unique()->company(),
            'industri' => $this->faker->randomElement(['Teknologi Informasi', 'Keuangan', 'Pendidikan', 'Kesehatan', 'Manufaktur']),
            'alamat' => $this->faker->address(),
            'website' => 'https://'.$this->faker->unique()->domainName(),
            'kontak_email' => $this->faker->unique()->companyEmail(),
            'kontak_telepon' => $this->faker->phoneNumber(),
            'status' => 'aktif',
        ];
    }
}
