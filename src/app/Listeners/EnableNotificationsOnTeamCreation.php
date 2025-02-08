<?php

namespace App\Listeners;

use Laravel\Jetstream\Events\TeamCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\NotificationSetting;
class EnableNotificationsOnTeamCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TeamCreated $event): void
    {
        //save notification settings
        $notificationSetting = new NotificationSetting();
        $notificationSetting->team_id = $event->team->id;
        $notificationSetting->user_id = $event->team->owner->id;
        $notificationSetting->notificatons_enabled = true;
        $notificationSetting->save();
    }
}
