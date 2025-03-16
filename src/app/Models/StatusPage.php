<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPage extends Model
{
    //
    protected $guarded = [];

    public function trackers()
    {
        return $this->belongsToMany(Tracker::class, 'status_page_trackers', 'status_page_id', 'tracker_id');
    }
}
