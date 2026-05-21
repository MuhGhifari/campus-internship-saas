<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipOffer extends Model
{
    protected $fillable = [
        'university_id',
        'company_id',
        'created_by',
        'judul',
        'bidang',
        'lokasi',
        'tipe_kerja',
        'kuota',
        'tanggal_mulai',
        'tanggal_selesai',
        'batas_lamaran',
        'deskripsi',
        'persyaratan',
        'benefit',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'batas_lamaran' => 'date',
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class);
    }
}
