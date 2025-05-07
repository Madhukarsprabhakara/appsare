<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPage extends Model
{
    //
    protected $guarded = [];

    public function trackers()
    {
        return $this->belongsToMany(Tracker::class, 'status_page_trackers', 'status_page_id', 'tracker_id')->with('analytics','latestEvent');    ;
    }
    public function trackersWithoutEvents()
    {
        return $this->belongsToMany(Tracker::class, 'status_page_trackers', 'status_page_id', 'tracker_id'); 
    }
    public function announcements()
    {
        return $this->hasMany(StatusPageAnnouncement::class)
        ->orderBy('id', 'desc')
        ->take(5);
    }
}
