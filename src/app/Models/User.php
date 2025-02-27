<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spark\Billable;
use Illuminate\Notifications\Slack\SlackRoute;
use App\Services\SlackService;
use App\Services\PushoverService;
use Illuminate\Notifications\Slack\SlackWebhookChannel;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
class User extends Authenticatable
{
    use HasApiTokens, Billable;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function routeNotificationForSlack(Notification $notification): mixed
    {
        $team_id = $notification->toArray($this)['team_id'];
        $slackService = new SlackService();
        $slack_connect=$slackService->getSlackConnection($team_id);
        return SlackRoute::make($slack_connect->slack_channel_id, $slack_connect->slack_bot_code); 
        
    }
    public function routeNotificationForPushover()
    {
        $pushoverService = new PushoverService();
        $pushover_connect=$pushoverService->getPushoverConnection($this->id);
        $encryptedValue=$pushover_connect->makeVisible('pushover_code')->toArray();
        return Crypt::decryptString($encryptedValue['pushover_code']);
    }
}
