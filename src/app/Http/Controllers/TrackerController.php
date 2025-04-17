<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TrackerService;
use App\Services\EssentialService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
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

            return Inertia::render('Trackers/Show', [
                'trackers' => $trackers,



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
        try {

            return Inertia::render('Trackers/Edit', [
                'tracker' => $tracker,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tracker $tracker)
    {
        //

        $data = $request->all();
        Validator::make($data, [
            'url' => 'required|url:http,https|max:255',
        ])->validateWithBag('editTracker');


        $tracker->update([
            'url' => $data['url'],
        ]);
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracker $tracker)
    {
        //
        // Delete the associated events
        $tracker->events()->delete();
        // Optionally, you can also delete the status page itself
        // Delete associated status page relationships
        DB::table('status_page_trackers')->where('tracker_id', $tracker->id)->delete();

        // Delete associated tracker analytics
        DB::table('tracker_analytics')->where('tracker_id', $tracker->id)->delete();
        $status = $tracker->delete();
        if ($status) {
            return redirect()->route('trackers.index', [], 303);
        }
        return response()->json([
            'message' => 'Failed to delete tracker'
        ], 500);
    }
}
