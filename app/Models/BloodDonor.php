<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodDonor extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_donated_at' => 'date',
        'is_available' => 'boolean',
    ];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }
}

