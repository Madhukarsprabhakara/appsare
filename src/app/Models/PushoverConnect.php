<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushoverConnect extends Model
{
    //
    protected $guarded = [];
    protected $hidden = ['pushover_code'];
}
