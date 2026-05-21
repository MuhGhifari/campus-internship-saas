<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyPartnership;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyPartnership>
 */
class CompanyPartnershipFactory extends Factory
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
            'university_id' => University::factory(),
            'requested_by' => null,
            'reviewed_by' => null,
            'status' => 'menunggu',
            'pesan' => 'Kami ingin mengajukan kerja sama program magang.',
            'catatan_review' => null,
            'reviewed_at' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diterima',
            'catatan_review' => 'Proposal kerja sama disetujui.',
            'reviewed_at' => now(),
        ]);
    }
}
