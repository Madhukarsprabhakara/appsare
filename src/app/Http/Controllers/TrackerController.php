<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TrackerService;
use App\Services\EssentialService;
use App\Services\UserService;
class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TrackerService $trackerService, UserService $userService)
    {
        try {
            
             $trackers=$trackerService->getTrackersOnTeamId($userService->getLoggedinUserTeam());
             return Inertia::render('Trackers/Show', [
                    'trackers' => $trackers, 

                    
            ]);
        }
        catch (\Exception $e)
        {
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
        $data=$request->all();
        $validated = $request->validate([
            'url' => 'required|string',

        ]);    
        $tracker_to_save=$essentialService->addUserIdTeamIdToArray($data);
        $status=$trackerService->storeTracker($tracker_to_save);

        if ($status)
        {
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
