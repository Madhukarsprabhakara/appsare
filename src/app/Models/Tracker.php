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
}
