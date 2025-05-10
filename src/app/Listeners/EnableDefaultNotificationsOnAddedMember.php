<?php

namespace App\Listeners;

use Laravel\Jetstream\Events\TeamMemberAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationSettingsService;
class EnableDefaultNotificationsOnAddedMember
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
    public function handle(TeamMemberAdded $event): void
    {
        //
        $notificationSettingsService = new NotificationSettingsService();
        
        $team = $event->team;
       
        $user = $event->user;
        $notificationSettingsService->setNotificationSettingsOnUser($team, $user);
        $notificationSettingsService->setNotificationSettingsOnTeam($team, $user);
    }
}
