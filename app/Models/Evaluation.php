<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_application_id',
        'evaluator_id',
        'tipe',
        'nilai_komunikasi',
        'nilai_kedisiplinan',
        'nilai_teknis',
        'nilai_kerja_sama',
        'catatan',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class, 'internship_application_id');
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function rataRata(): float
    {
        return round(collect([
            $this->nilai_komunikasi,
            $this->nilai_kedisiplinan,
            $this->nilai_teknis,
            $this->nilai_kerja_sama,
        ])->average(), 1);
    }
}
