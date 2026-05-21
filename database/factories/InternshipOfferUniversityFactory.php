<?php

namespace Database\Factories;

use App\Models\InternshipOffer;
use App\Models\InternshipOfferUniversity;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternshipOfferUniversity>
 */
class InternshipOfferUniversityFactory extends Factory
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
            'university_id' => University::factory(),
            'requested_by' => null,
            'reviewed_by' => null,
            'status' => 'menunggu',
            'catatan_review' => null,
            'reviewed_at' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diterima',
            'catatan_review' => 'Posisi magang disetujui untuk mahasiswa kampus.',
            'reviewed_at' => now(),
        ]);
    }
}
