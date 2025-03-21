<?php

namespace App\Http\Controllers;

use App\Models\StatusPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\StatusPageTracker;
use App\Services\TrackerService;
use App\Models\TrackerEvent;
use Illuminate\Support\Facades\DB;

class StatusPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {

            $statusPages = StatusPage::where('team_id', auth()->user()->currentTeam->id)->get();
            return Inertia::render('StatusPages/Show', [
                'statusPages' => $statusPages,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TrackerService $trackerService)
    {
        //
        try {
            $trackers = $trackerService->getTrackersOnTeamId(auth()->user()->currentTeam);
            return Inertia::render('StatusPages/Create', [
                'trackers' => $trackers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'url_slug' => 'required|string|max:255|unique:status_pages,url_slug',
                'selectedOptions' => 'required|array',

            ]);

            // Create the new status page
            $statusPage = StatusPage::create([
                'name' => $validated['name'],
                'url_slug' => $validated['url_slug'],
                'team_id' => auth()->user()->currentTeam->id, // Assuming the team ID is associated with the authenticated user
                'user_id' => auth()->id(), // Assuming the user ID is associated with the authenticated user
                'uuid' => \Str::uuid(),
            ]);

            // Attach the selected trackers to the status page
            $trackerIds = collect($validated['selectedOptions'])->pluck('value')->toArray();
            $statusPage->trackers()->attach($trackerIds);

            return redirect()->route('statuspages.index')->with('success', 'Status page created successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $url_slug)
    {
        //
        try {
            // return $uptimePercentages = TrackerEvent::select(
            //     'tracker_id',
            //     DB::raw("DATE_TRUNC('day', start_time) as day"),
            //     DB::raw("COUNT(CASE WHEN message = 'Success' THEN 1 END) as successful_requests"),
            //     DB::raw("COUNT(*) as total_requests")
            // )
            //     ->groupBy('tracker_id', DB::raw("DATE_TRUNC('day', start_time)"))
            //     ->get()
            //     ->map(function ($item) {
            //         return [
            //             'tracker_id' => $item->tracker_id,
            //             'day' => $item->day,
            //             'uptime_percentage' => round(($item->successful_requests / $item->total_requests) * 100, 2),
            //         ];
            //     });
            $statusPage = StatusPage::where('url_slug', $url_slug)->first();
            if (!$statusPage) {
                abort(404, 'Not Found');
            }
            $trackers = $statusPage->trackers;

            // Calculate uptime percentages for each tracker
            $trackersWithUptime = $trackers->map(function ($tracker) {
                $uptimeData = TrackerEvent::select(
                    DB::raw("DATE_TRUNC('day', start_time) as day"),
                    DB::raw("COUNT(CASE WHEN message = 'Success' THEN 1 END) as successful_requests"),
                    DB::raw("COUNT(*) as total_requests")
                )
                    ->where('tracker_id', $tracker->id)
                    ->whereNotNull('start_time')
                    ->groupBy(DB::raw("DATE_TRUNC('day', start_time)"))
                    ->get()
                    ->map(function ($item) {
                        return [
                            'day' => $item->day,
                            'uptime_percentage' => round(($item->successful_requests / $item->total_requests) * 100, 2),
                        ];
                    });

                // Add uptime data to the tracker
                $tracker->uptime = $uptimeData;
                return $tracker;
            });

           $trackersWithLatestState = $trackers->map(function ($tracker) {
                // Fetch the latest event for the tracker
                $latestEvent = TrackerEvent::where('tracker_id', $tracker->id)
                    ->orderBy('start_time', 'desc')
                    ->first();
    
                // Add the latest event message to the tracker
                $tracker->latest_message = $latestEvent ? $latestEvent->message : null;
    
                // Set the state based on the latest message
                $tracker->state = $latestEvent && $latestEvent->message === 'Success'
                    ? 'Operational'
                    : 'Down';
    
                return $tracker;
            });
            
            return Inertia::render('StatusPages/Publicv2', [
                'statusPage' => $statusPage,
                'trackers' => $trackersWithUptime,
                'trackersWithLatestState' => $trackersWithLatestState,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPage $statusPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPage $statusPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPage $statusPage)
    {
        //
    }
}
