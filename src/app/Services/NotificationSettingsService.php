<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Models\NotificationSetting;
use App\Models\TeamNotification;
use App\Models\UserNotification;

class NotificationSettingsService
{

    public function getGlobalNotificationSettingsOnTeam(Team $team)
    {

        return NotificationSetting::where('team_id', $team->id)->get();
    }
    public function setNotificationSettingsOnTeam(Team $team, User $user)
    {

        TeamNotification::upsert([
            ['team_id' => $team->id, 'user_id' => $user->id, 'notification_type_id' => 2, 'is_enabled' => false],
            ['team_id' => $team->id, 'user_id' => $user->id, 'notification_type_id' => 3, 'is_enabled' => false],

        ], uniqueBy: ['team_id', 'notification_type_id'], update: ['team_id', 'user_id', 'notification_type_id', 'is_enabled']);
    }
    public function setNotificationSettingsOnUser(Team $team, User $user)
    {

        UserNotification::upsert([
            ['team_id' => $team->id, 'user_id' => $user->id, 'notification_type_id' => 1, 'is_enabled' => true],
            ['team_id' => $team->id, 'user_id' => $user->id, 'notification_type_id' => 4, 'is_enabled' => false],

        ], uniqueBy: ['team_id', 'user_id', 'notification_type_id'], update: ['team_id', 'user_id', 'notification_type_id', 'is_enabled']);
    }
    public function updateNotificationSettingsOnUser($data_to_update)
    {
        UserNotification::upsert([
            $data_to_update
        ], uniqueBy: ['team_id', 'user_id', 'notification_type_id'], update: ['team_id', 'user_id', 'notification_type_id', 'is_enabled']);
    }
    public function updateNotificationSettingsOnTeam($data_to_update)
    {
        TeamNotification::upsert([
            $data_to_update
        ], uniqueBy: ['team_id', 'notification_type_id'], update: ['team_id', 'user_id', 'notification_type_id', 'is_enabled']);
    }
    public function getNotificationSettingsOnUser(User $user, Team $team)
    {

        return UserNotification::where('user_id', $user->id)->where('team_id', $team->id)->with('notificationType')->get();
    }
    public function getNotificationSettingsOnTeam(User $user, Team $team)
    {
        return TeamNotification::where('team_id', $team->id)->with('notificationType')->get();
    }
    public function shouldSendEmail(User $user, Team $team): bool
    {
        $notificationSetting = UserNotification::where('user_id', $user->id)
            ->where('team_id', $team->id)
            ->where('notification_type_id', 1) // Assuming 1 is the ID for email notifications
            ->first();

        return $notificationSetting ? $notificationSetting->is_enabled : false;
    }
    public function shouldSendSlack(User $user, Team $team): bool
    {
        $notificationSetting = TeamNotification::where('user_id', $user->id)
            ->where('team_id', $team->id)
            ->where('notification_type_id', 3) // Assuming 2 is the ID for Slack notifications
            ->first();

        return $notificationSetting ? $notificationSetting->is_enabled : false;
    }
    public function shouldSendPushover(User $user, Team $team): bool
    {
        $notificationSetting = UserNotification::where('user_id', $user->id)
            ->where('team_id', $team->id)
            ->where('notification_type_id', 4) // Assuming 3 is the ID for Pushover notifications
            ->first();

        return $notificationSetting ? $notificationSetting->is_enabled : false;
    }
    public function shouldSendBasecamp(User $user, Team $team): bool
    {
        $notificationSetting = TeamNotification::where('user_id', $user->id)
            ->where('team_id', $team->id)
            ->where('notification_type_id', 2) // Assuming 4 is the ID for Basecamp notifications
            ->first();

        return $notificationSetting ? $notificationSetting->is_enabled : false;
    }
}
