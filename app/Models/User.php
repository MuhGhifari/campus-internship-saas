<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'university_id',
        'company_id',
        'name',
        'email',
        'role',
        'nomor_induk',
        'program_studi',
        'telepon',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'student_id');
    }

    public function supervisedApplications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'campus_supervisor_id');
    }

    public function supervisedCompanyApplications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'company_supervisor_id');
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(LogbookEntry::class, 'assigned_by_id');
    }

    public function hasRole(string $role): bool
    {
        $aliases = [
            'dosen' => ['dosen', 'university_supervisor'],
            'university_supervisor' => ['university_supervisor', 'dosen'],
        ];

        return in_array($this->role, $aliases[$role] ?? [$role], true);
    }

    public function hasAnyRole(array $roles): bool
    {
        return collect($roles)->contains(fn (string $role) => $this->hasRole($role));
    }

    public function isInstitutionUser(): bool
    {
        return $this->hasAnyRole(['staf', 'perusahaan']);
    }

    public function isSupervisor(): bool
    {
        return $this->hasAnyRole(['company_supervisor', 'university_supervisor']);
    }
}
