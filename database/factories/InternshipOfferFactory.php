<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\InternshipOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternshipOffer>
 */
class InternshipOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'created_by' => null,
            'judul' => $this->faker->randomElement(['Backend Developer Intern', 'UI/UX Research Intern', 'Data Analyst Intern', 'Quality Assurance Intern']),
            'bidang' => $this->faker->randomElement(['Software Engineering', 'Product Design', 'Data', 'Quality Assurance']),
            'lokasi' => $this->faker->city(),
            'tipe_kerja' => $this->faker->randomElement(['onsite', 'remote', 'hybrid']),
            'kuota' => $this->faker->numberBetween(1, 6),
            'tanggal_mulai' => now()->addWeeks(3)->toDateString(),
            'tanggal_selesai' => now()->addMonths(5)->toDateString(),
            'batas_lamaran' => now()->addDays(14)->toDateString(),
            'deskripsi' => $this->faker->paragraph(),
            'persyaratan' => $this->faker->sentence(),
            'benefit' => $this->faker->sentence(),
            'status' => 'menunggu',
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'terbit',
        ]);
    }
}
