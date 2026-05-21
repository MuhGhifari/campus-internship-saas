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
        'tanggal',
        'judul_kegiatan',
        'deskripsi',
        'kendala',
        'status',
        'catatan_pembimbing',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class, 'internship_application_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
