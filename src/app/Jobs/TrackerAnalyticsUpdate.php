<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TrackerAnalytics;

class TrackerAnalyticsUpdate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $succ = 'Success';
        $sixtyDaysAgo = Carbon::now()->subDays(60)->format('Y-m-d');
        $andata = collect(DB::select("select 
        date(created_at) as day,
        tracker_id,
        COUNT(CASE WHEN message = '$succ' THEN 1 END) AS successful_requests,
        COUNT(*) AS total_requests,
        ROUND(CASE 
          WHEN COUNT(*) = 0 THEN 0
          ELSE (COUNT(CASE WHEN message = '$succ' THEN 1 END) * 1.0 / COUNT(*)) * 100
        END,2) AS daily_sixty_day_uptime
        from tracker_events 
        where tracker_id in (select id from trackers) and created_at >= '$sixtyDaysAgo'
        group by date(created_at), tracker_id
        order by date(created_at), tracker_id"));

        // Transform the data into the desired format
        $transformedData = $andata->groupBy('tracker_id')->map(function ($group, $trackerId) {
            return [
                'tracker_id' => $trackerId,
                'daily_sixty_day_uptime' => json_encode($group->values()->toArray()),
            ];
        })->values();
        TrackerAnalytics::upsert($transformedData->toArray(), uniqueBy: ['tracker_id'], update: ['daily_sixty_day_uptime', 'percentage_sixty_day_uptime']);
        return;
    }
}
