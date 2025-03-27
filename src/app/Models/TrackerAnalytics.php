<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerAnalytics extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'daily_sixty_day_uptime' => 'array',
    ];
}
