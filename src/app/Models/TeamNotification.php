<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamNotification extends Model
{
    //
    protected $guarded = [];
    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }
}
