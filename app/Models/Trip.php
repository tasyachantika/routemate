<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = [
        'title',
        'destination_country',
        'start_date',
        'end_date',
        'currency',
        'timezone',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ItineraryDetail::class)->orderBy('sort_order');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(TripBudget::class);
    }

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'itinerary_details')
            ->withPivot('id', 'sort_order', 'visit_date', 'visit_time', 'notes')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }
}
