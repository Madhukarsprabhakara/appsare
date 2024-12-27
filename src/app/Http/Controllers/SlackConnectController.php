<?php

namespace App\Http\Controllers;

use App\Models\SlackConnect;
use Illuminate\Http\Request;
use App\Services\SlackService;
use App\Services\EssentialService;
class SlackConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function redirect(SlackService $slackService)
    {
        //
        $team_id=\Auth::user()->currentTeam->id;
        return $slackService->connectSlack($team_id);
    }
    public function saveSlackToken(SlackService $slackService)
    {
        //
        return $slackService->saveSlackToken(\Auth::user()->currentTeam->id);
    }
    public function store(Request $request, EssentialService $essentialService, SlackService $slackService)
    {
        //
        $data=$request->all();
        $validated = $request->validate([
            'channel_id' => 'required|string',

        ]);    
        $slack_to_save=$essentialService->addUserIdTeamIdToArray($data);
        $status=$trackerService->storeTracker($tracker_to_save);

        if ($status)
        {
            return \Redirect::route('trackers.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SlackConnect $slackConnect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SlackConnect $slackConnect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SlackConnect $slackConnect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SlackConnect $slackConnect)
    {
        //
    }
}
