<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipOffer extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'internship_offer_universities')
            ->withPivot(['status', 'catatan_review', 'reviewed_at'])
            ->withTimestamps();
    }

    public function universityRequests(): HasMany
    {
        return $this->hasMany(InternshipOfferUniversity::class);
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
