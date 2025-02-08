<?php

namespace App\Services;
use App\Models\Team;
use App\Models\NotificationSetting;
class NotificationSettingsService {
	public function getNotificationSettingsOnTeam(Team $team) {
       	
        return NotificationSetting::where('team_id', $team->id)->get();
        
    }
    public function setNotificationSettingsOnTeam(Team $team, $notificationSettings) {
       	
       	
        
    }
    
}