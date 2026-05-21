<?php

namespace Database\Factories;

use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternshipApplication>
 */
class InternshipApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internship_offer_id' => InternshipOffer::factory(),
            'student_id' => User::factory(),
            'company_supervisor_id' => null,
            'campus_supervisor_id' => null,
            'status' => 'diajukan',
            'motivasi' => $this->faker->paragraph(),
            'resume_path' => null,
            'surat_pengantar_path' => null,
            'tanggal_mulai' => null,
            'tanggal_selesai' => null,
            'diterima_pada' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'berjalan',
            'tanggal_mulai' => now()->subWeeks(2)->toDateString(),
            'tanggal_selesai' => now()->addMonths(4)->toDateString(),
            'diterima_pada' => now()->subWeeks(3),
        ]);
    }
}
