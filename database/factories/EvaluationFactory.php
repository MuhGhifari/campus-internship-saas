<?php

namespace Database\Factories;

use App\Models\Evaluation;
use App\Models\InternshipApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internship_application_id' => InternshipApplication::factory(),
            'evaluator_id' => User::factory(),
            'tipe' => 'kampus',
            'nilai_komunikasi' => $this->faker->numberBetween(75, 95),
            'nilai_kedisiplinan' => $this->faker->numberBetween(75, 95),
            'nilai_teknis' => $this->faker->numberBetween(75, 95),
            'nilai_kerja_sama' => $this->faker->numberBetween(75, 95),
            'catatan' => $this->faker->sentence(),
        ];
    }
}
