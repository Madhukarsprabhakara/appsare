<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\ServiceDown;
use App\Models\Tracker;
use App\Models\Team;
use App\Models\User;
use App\Models\TrackerNotification;
class ServiceDownActions implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $tracker_id, $url, $tracker_event_id;
    public function __construct($tracker_id, $url, $tracker_event_id)
    {
        //
        $this->tracker_id=$tracker_id;
        $this->url=$url;
        $this->tracker_event_id=$tracker_event_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //create notifications
        //not acknowledged and not up send max 3 times in
        //send notifications (email) with signed urls if not acknowledged max 10 times (default) - queue it up
        $tracker=Tracker::find($this->tracker_id);
        $team=Team::find($tracker->team_id);
        $all_users=$team->allUsers();
        foreach ($all_users as $user)
        {
           User::find($user->id)->notify(new ServiceDown($this->url, $tracker->team_id));
        }
        
    }
}
