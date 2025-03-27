<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    //
    protected $guarded = [];

    public function statusPages()
    {
        return $this->belongsToMany(StatusPage::class, 'status_page_trackers', 'tracker_id', 'status_page_id');
    }
    public function analytics()
    {
        return $this->hasOne(TrackerAnalytics::class);
    }
    public function latestEvent()
    {
        return $this->hasOne(TrackerEvent::class)->latestOfMany();
    }
}
