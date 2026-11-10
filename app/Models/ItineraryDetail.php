<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryDetail extends Model
{
    protected $fillable = [
        'destination_id',
        'sort_order',
        'visit_date',
        'visit_time',
        'notes',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'visit_date' => 'date',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
