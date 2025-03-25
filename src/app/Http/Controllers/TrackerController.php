<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TrackerService;
use App\Services\EssentialService;
use App\Services\UserService;
use App\Models\TrackerEvent;
use Illuminate\Support\Facades\DB;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TrackerService $trackerService, UserService $userService)
    {
        try {

            $trackers = $trackerService->getTrackersOnTeamId($userService->getLoggedinUserTeam());
            // Fetch all tracker events for the trackers in one query
            $trackerIds = $trackers->pluck('id');
            $trackerEvents = TrackerEvent::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw("COUNT(CASE WHEN message = 'Success' THEN 1 END) as successful_requests"),
                DB::raw("COUNT(*) as total_requests"),
                'tracker_id'
            )
                ->whereIn('tracker_id', $trackerIds) // Fetch events for all trackers in one query
                ->whereNotNull('created_at') // Optional: Exclude null start_time
                ->groupBy('tracker_id', DB::raw("DATE(created_at)"))
                ->get();

            // Group tracker events by tracker_id
            $eventsByTracker = $trackerEvents->groupBy('tracker_id');

            // Map trackers and attach uptime data
            $trackersWithUptime = $trackers->map(function ($tracker) use ($eventsByTracker) {
                $uptimeData = $eventsByTracker->get($tracker->id, collect())->map(function ($item) {
                    return [
                        'day' => $item->day,
                        'uptime_percentage' => round(($item->successful_requests / $item->total_requests) * 100, 2),
                    ];
                });

                // Add uptime data to the tracker
                $tracker->uptime = $uptimeData;
                return $tracker;
            });

            return Inertia::render('Trackers/Show', [
                'trackers' => $trackersWithUptime,



            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Trackers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, EssentialService $essentialService, TrackerService $trackerService)
    {
        //
        $data = $request->all();
        $validated = $request->validate([
            'url' => 'required|string',

        ]);
        $tracker_to_save = $essentialService->addUserIdTeamIdToArray($data);
        $status = $trackerService->storeTracker($tracker_to_save);

        if ($status) {
            return \Redirect::route('trackers.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tracker $tracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tracker $tracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tracker $tracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracker $tracker)
    {
        //
    }
}
