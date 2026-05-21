<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipOfferUniversity extends Model
{
    protected $fillable = [
        'internship_offer_id',
        'university_id',
        'requested_by',
        'reviewed_by',
        'status',
        'catatan_review',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return ['reviewed_at' => 'datetime'];
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(InternshipOffer::class, 'internship_offer_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
