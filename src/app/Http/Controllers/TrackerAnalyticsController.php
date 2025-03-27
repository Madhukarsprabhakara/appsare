<?php

namespace App\Http\Controllers;

use App\Models\TrackerAnalytics;
use Illuminate\Http\Request;
use App\Models\TrackerEvent;
use App\Models\Tracker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Jobs\TrackerAnalyticsUpdate;

class TrackerAnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
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
            return response()->json($transformedData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dispatch job to update the analytics data
        try {
            TrackerAnalyticsUpdate::dispatch();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(TrackerAnalytics $trackerAnalytics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackerAnalytics $trackerAnalytics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrackerAnalytics $trackerAnalytics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackerAnalytics $trackerAnalytics)
    {
        //
    }
}
