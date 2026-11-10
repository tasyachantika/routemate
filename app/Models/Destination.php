<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'country',
        'city',
        'description',
        'address',
        'photo',
        'latitude',
        'longitude',
        'entrance_fee',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'entrance_fee' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function itineraryDetails(): HasMany
    {
        return $this->hasMany(ItineraryDetail::class);
    }
}
