<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'unique_visitors' => 'integer',
        'page_views' => 'integer',
    ];
}

