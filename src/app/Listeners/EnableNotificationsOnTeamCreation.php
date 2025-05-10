<?php

namespace App\Listeners;

use Laravel\Jetstream\Events\TeamCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\NotificationSetting;
use App\Services\NotificationSettingsService;
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
        $notificationSettingsService = new NotificationSettingsService();
        
        //save notification settings
        $notificationSetting = new NotificationSetting();
        $notificationSetting->team_id = $event->team->id;
        $notificationSetting->user_id = $event->team->owner->id;
        $notificationSetting->notificatons_enabled = true;
        $notificationSetting->save();

        //save channel based notification settings
        $notificationSettingsService->setNotificationSettingsOnUser($event->team, $event->team->owner);
        $notificationSettingsService->setNotificationSettingsOnTeam($event->team, $event->team->owner);

        
    }
}
