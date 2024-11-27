<?php

namespace App\Services;
use App\Models\Tracker;
use App\Models\Team;
class TrackerService {
	public function getTrackersOnTeamId(Team $team)
    {
        
        return $team->trackers;
    }
    public function storeTracker(Array $tracker_to_save)
    {
        $tracker=Tracker::create($tracker_to_save);
        if ($tracker)
        {
            return true;
        }
        throw new \Exception('Something went wrong, could not save your tracker. Please try again.' ); 
    }
}