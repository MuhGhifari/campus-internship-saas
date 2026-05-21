<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode', 'alamat', 'email', 'telepon'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function partneredCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_partnerships')
            ->withPivot(['status', 'pesan', 'catatan_review', 'reviewed_at'])
            ->withTimestamps();
    }

    public function offerRequests(): HasMany
    {
        return $this->hasMany(InternshipOfferUniversity::class);
    }
}
