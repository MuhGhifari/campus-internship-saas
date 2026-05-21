<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'mahasiswa',
            'nomor_induk' => fake()->unique()->numerify('##########'),
            'program_studi' => fake()->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Desain Komunikasi Visual']),
            'telepon' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function staff(University $university): static
    {
        return $this->state(fn (array $attributes) => [
            'university_id' => $university->id,
            'company_id' => null,
            'role' => 'staf',
            'nomor_induk' => null,
            'program_studi' => null,
        ]);
    }

    public function lecturer(University $university): static
    {
        return $this->state(fn (array $attributes) => [
            'university_id' => $university->id,
            'company_id' => null,
            'role' => 'dosen',
        ]);
    }

    public function student(University $university): static
    {
        return $this->state(fn (array $attributes) => [
            'university_id' => $university->id,
            'company_id' => null,
            'role' => 'mahasiswa',
        ]);
    }

    public function companyRepresentative(Company $company): static
    {
        return $this->state(fn (array $attributes) => [
            'university_id' => null,
            'company_id' => $company->id,
            'role' => 'perusahaan',
            'nomor_induk' => null,
            'program_studi' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
