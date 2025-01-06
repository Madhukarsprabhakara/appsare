<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlackConnect extends Model
{
    //
    protected $guarded = [];
    protected $hidden = ['slack_bot_code'];
}
