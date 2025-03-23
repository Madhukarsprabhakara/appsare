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

            // Fetch all tracker events for the trackers in one query
            $trackerIds = $trackers->pluck('id');
        $trackerEvents = TrackerEvent::selectRaw("
            DATE_TRUNC('day', start_time) AS day,
            COUNT(CASE WHEN message = 'Success' THEN 1 END) AS successful_requests,
            COUNT(*) AS total_requests,
            tracker_id
        ")
        ->whereIn('tracker_id', $trackerIds)
        ->whereNotNull('start_time')
        ->groupBy('tracker_id', DB::raw("DATE_TRUNC('day', start_time)"))
        ->get();
            // $trackerEvents = TrackerEvent::select(
            //     DB::raw("DATE_TRUNC('day', start_time) as day"),
            //     DB::raw("COUNT(CASE WHEN message = 'Success' THEN 1 END) as successful_requests"),
            //     DB::raw("COUNT(*) as total_requests"),
            //     'tracker_id'
            // )
            //     ->whereIn('tracker_id', $trackerIds) // Fetch events for all trackers in one query
            //     ->whereNotNull('start_time') // Exclude null start_time
            //     ->groupBy('tracker_id', DB::raw("DATE_TRUNC('day', start_time)"))
            //     ->get();

            // Group tracker events by tracker_id
            $eventsByTracker = $trackerEvents->groupBy('tracker_id');

            // Fetch the latest event for all trackers in one query
            $latestEvents = TrackerEvent::whereIn('id', function ($query) use ($trackerIds) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('tracker_events')
                    ->whereIn('tracker_id', $trackerIds)
                    ->whereNotNull('start_time')
                    ->groupBy('tracker_id');
            })->get();
            
            // return $latestEvents = TrackerEvent::select('tracker_events.*')
            //     ->join(
            //         DB::raw('(SELECT tracker_id, MAX(start_time) as latest_start_time FROM tracker_events GROUP BY tracker_id) as latest_events'),
            //         function ($join) {
            //             $join->on('tracker_events.tracker_id', '=', 'latest_events.tracker_id')
            //                 ->on('tracker_events.start_time', '=', 'latest_events.latest_start_time');
            //         }
            //     )
            //     ->whereIn('tracker_events.tracker_id', $trackerIds)
            //     ->get();

                // return $latestEvent = $latestEvents->firstWhere('tracker_id',18);


            // Map trackers and attach uptime data and latest state
            $trackersWithData = $trackers->map(function ($tracker) use ($eventsByTracker, $latestEvents) {
                // Attach uptime data
                $uptimeData = $eventsByTracker->get($tracker->id, collect())->map(function ($item) {
                    return [
                        'day' => $item->day,
                        'uptime_percentage' => round(($item->successful_requests / $item->total_requests) * 100, 2),
                    ];
                });

                $tracker->uptime = $uptimeData;

                // Attach latest event data
                $latestEvent = $latestEvents->firstWhere('tracker_id', $tracker->id);
                $tracker->latest_message = $latestEvent ? $latestEvent->message : null;
                $tracker->state = $latestEvent && $latestEvent->message === 'Success'
                    ? 'Operational'
                    : 'Down';

                return $tracker;
            });
            
            return Inertia::render('StatusPages/Publicv2', [
                'statusPage' => $statusPage,
                'trackers' => $trackersWithData,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
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
