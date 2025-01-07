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
                return \Redirect::route('integrations.index');
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
    public function update(Request $request, SlackConnect $slack_connect)
    {
        //
        try {
            $data=$request->all();
            \Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
            ])->validateWithBag('updateSlackChannelId');
            $slack_connect->slack_channel_id = $data['name'];
            $status=$slack_connect->save();
            if ($status)
            {
                return to_route('integrations.index');
            }
            
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SlackConnect $slack_connect)
    {
        //
        try {
            $status=$slack_connect->delete();
            if ($status)
            {
                return back(303);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        
    }
}
