<?php

namespace App\Http\Controllers;

use App\Models\PushoverConnect;
use Illuminate\Http\Request;
use App\Services\PushoverService;

class PushoverConnectController extends Controller
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
    public function redirect(PushoverService $pushoverService)
    {
        //
        $team_id=\Auth::user()->currentTeam->id;
        return \Redirect::to($pushoverService->connectPushover($team_id));
    }
    public function handleCallback(Request $request, PushoverService $pushoverService)
    {
        //
        try {
            $data=$request->all();
            $pushover_user_key=$data['pushover_user_key'];
            $saved=$pushoverService->savePushoverToken(\Auth::user()->currentTeam->id, $pushover_user_key);
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PushoverConnect $pushoverConnect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PushoverConnect $pushoverConnect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PushoverConnect $pushoverConnect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PushoverService $pushoverService)
    {
        //
        try {
            $team_id=\Auth::user()->currentTeam->id;
            return \Inertia::location($pushoverService->connectPushover($team_id));
            //return response()->json(['redirect_url' => $pushoverService->connectPushover($team_id)]);
            
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
