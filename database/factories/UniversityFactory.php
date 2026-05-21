<?php

namespace Database\Factories;

use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<University>
 */
class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => 'Universitas '.$this->faker->unique()->city(),
            'kode' => strtoupper($this->faker->unique()->lexify('???')),
            'alamat' => $this->faker->address(),
            'email' => $this->faker->unique()->companyEmail(),
            'telepon' => $this->faker->phoneNumber(),
        ];
    }
}
