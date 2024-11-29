<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\TrackerEvent;
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
       
        //fire head request
        $start_time = microtime(true);
        $response = Http::retry(3, 100)->head($this->url);
        $end_time = microtime(true);
        $response_time = $end_time - $start_time;
        $response_time*1000;
        //insert into tracker_event table
        $tracker_event=new TrackerEvent;
        $tracker_event->tracker_id=$this->tracker_id;
        $tracker_event->response_time=$response_time;
        $tracker_event->epoch_start_time=$start_time;
        $tracker_event->epoch_end_time=$end_time;
        $tracker_event->http_status_code=$response->status();
        $tracker_event->message='Success';
        $tracker_event->save();

    }
}
