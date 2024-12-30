<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\TrackerEvent;
use App\Jobs\ServiceDownActions;
use App\Notifications\ServiceUp;
use App\Models\User;
use App\Models\Team;
use App\Models\Tracker;
class WebsiteStatusCheck30 implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $tracker_id, $url;
    public function __construct($tracker_id, $url)
    {
        //
        $this->tracker_id=$tracker_id;
        $this->url=$url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       
       try {
            //get the latest tracker id event
            $previous_event=TrackerEvent::where('tracker_id', $this->tracker_id)->latest()->first();
            //fire head request
            $start_time = microtime(true);
            $response = Http::retry(3, 100)->timeout(15)->head($this->url);
            $end_time = microtime(true);
            $response_time = $end_time - $start_time;
            $response_time*1000;
            //insert into tracker_event table
            $tracker_event=new TrackerEvent;
            $tracker_event->tracker_id=$this->tracker_id;
            $tracker_event->response_time=$response_time;
            $tracker_event->epoch_start_time=$start_time;
            $tracker_event->epoch_end_time=$end_time;
            if ($response->status()>=200 && $response->status()<=399)
            {
               $tracker_event->message='Success'; 
            }
            else
            {
                $tracker_event->message='Failed'; 
            }
            $tracker_event->http_status_code=$response->status();
            $tracker_event->save();
            //compare the previous tracker id event
            if ($tracker_event->message==='Success')
            {
                if ($previous_event->message!=='Success')
                {
                    $tracker=Tracker::find($this->tracker_id);
                    $team=Team::find($tracker->team_id);
                    $all_users=$team->allUsers();
                    foreach ($all_users as $user)
                    {
                       User::find($user->id)->notify(new ServiceUp($this->url, $tracker->team_id));
                    }
                }
            } 
            //if fail->pass - send notification that app is up
            //if pass->pass do noting 
       }
       catch (\Exception $e)
       {
            //if pass->fail - send notification
            if ($previous_event->message==='Success')
            {
                      
                $tracker_event=new TrackerEvent;
                if (isset($e->response))
                {
                    $response = $e->response;
                    $tracker_event->http_status_code=$response->status();
                }
                else
                {
                    $response = $e->getMessage();
                    $tracker_event->http_status_code='500';
                }
                
                $tracker_event->tracker_id=$this->tracker_id;
                
                $tracker_event->message=$e->getMessage();
                $tracker_event->save();
                //dispatch notification job - with tracker id and url
                ServiceDownActions::dispatch($this->tracker_id, $this->url, $tracker_event->id);  
            }
            else
            {
                $tracker_event=new TrackerEvent;
                if (isset($e->response))
                {
                    $response = $e->response;
                    $tracker_event->http_status_code=$response->status();
                }
                else
                {
                    $response = $e->getMessage();
                    $tracker_event->http_status_code='500';
                }
                
                $tracker_event->tracker_id=$this->tracker_id;
                
                $tracker_event->message=$e->getMessage();
                $tracker_event->save();
            }
            //if fail -> fail - do nothing
            
       }
        

    }
}
