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
        //return $slackService->getSlackPublicChannelList($team_id);
        
        return $slackService->connectSlack($team_id);
    }
    public function handleCallback(SlackService $slackService)
    {
        //
        try {
            $saved=$slackService->saveSlackToken(\Auth::user()->currentTeam->id);
            if ($saved)
            {
                return \Redirect::route('trackers.index');
            }
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
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
