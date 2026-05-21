<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $fillable = ['nama', 'kode', 'alamat', 'email', 'telepon'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(InternshipOffer::class);
    }
}
