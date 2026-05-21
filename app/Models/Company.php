<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'university_id',
        'nama',
        'industri',
        'alamat',
        'website',
        'kontak_email',
        'kontak_telepon',
        'status',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
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
