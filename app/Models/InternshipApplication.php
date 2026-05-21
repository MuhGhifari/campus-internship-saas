<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InternshipApplication extends Model
{
    protected $fillable = [
        'internship_offer_id',
        'student_id',
        'company_supervisor_id',
        'campus_supervisor_id',
        'status',
        'motivasi',
        'resume_path',
        'surat_pengantar_path',
        'tanggal_mulai',
        'tanggal_selesai',
        'diterima_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'diterima_pada' => 'datetime',
        ];
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(InternshipOffer::class, 'internship_offer_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function companySupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_supervisor_id');
    }

    public function campusSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'campus_supervisor_id');
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(LogbookEntry::class);
    }

    public function evaluation(): HasOne
    {
        return $this->hasOne(Evaluation::class);
    }
}
