<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'nama',
        'industri',
        'alamat',
        'website',
        'kontak_email',
        'kontak_telepon',
        'status',
    ];

    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'company_partnerships')
            ->withPivot(['status', 'pesan', 'catatan_review', 'reviewed_at'])
            ->withTimestamps();
    }

    public function partnerships(): HasMany
    {
        return $this->hasMany(CompanyPartnership::class);
    }

    public function representatives(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(InternshipOffer::class);
    }
}
