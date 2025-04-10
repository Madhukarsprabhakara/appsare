<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasecampConnect extends Model
{
    //
    protected $guarded = [];
    protected $hidden = ['code', 'access_token', 'refresh_token','expires_at'];
}
