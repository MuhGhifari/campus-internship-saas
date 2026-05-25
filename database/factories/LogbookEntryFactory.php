<?php

namespace Database\Factories;

use App\Models\InternshipApplication;
use App\Models\LogbookEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LogbookEntry>
 */
class LogbookEntryFactory extends Factory
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
            'student_id' => User::factory(),
            'assigned_by_id' => User::factory(),
            'tanggal' => now()->subDay()->toDateString(),
            'due_date' => now()->addWeek()->toDateString(),
            'judul_kegiatan' => $this->faker->sentence(4),
            'deskripsi' => $this->faker->paragraph(),
            'kendala' => $this->faker->optional()->sentence(),
            'status' => 'todo',
            'catatan_pembimbing' => null,
            'score' => null,
            'score_notes' => null,
            'completed_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'done',
            'score' => 88,
            'score_notes' => 'Pekerjaan selesai dengan dokumentasi yang jelas.',
            'catatan_pembimbing' => 'Progres baik, lanjutkan dokumentasi pekerjaan.',
            'completed_at' => now(),
        ]);
    }
}
