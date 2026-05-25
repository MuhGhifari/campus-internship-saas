<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogbookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_application_id',
        'student_id',
        'assigned_by_id',
        'tanggal',
        'due_date',
        'judul_kegiatan',
        'deskripsi',
        'kendala',
        'status',
        'catatan_pembimbing',
        'score',
        'score_notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'due_date' => 'date',
            'completed_at' => 'datetime',
            'score' => 'integer',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class, 'internship_application_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }
}
