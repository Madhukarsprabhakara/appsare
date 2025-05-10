<?php

namespace App\Http\Controllers;

use App\Models\ApiNotification;
use Illuminate\Http\Request;
use App\Models\Tracker;
use App\Models\Team;
use App\Models\User;
use App\Notifications\ServiceUp;
use App\Notifications\ServiceDown;
class ApiNotificationController extends Controller
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
    public function create(Request $request)
    {
        //
        try {
            $data=$request->all();
            $validated = $request->validate([
                'url' => 'required|string',
                'tracker_id' => 'required|integer',
                'service_type' => 'required|integer',
            ]);
            $tracker = Tracker::find($data['tracker_id']);
            $team = Team::find($tracker->team_id);
            $all_users = $team->allUsers();
            foreach ($all_users as $user) {
                //check for disabled notificatons here 
                if ($data['service_type'] === 1) {
                    User::find($user->id)->notify(new ServiceUp($data['url'], $tracker->team_id, $user->id));
                }
                if ($data['service_type'] === 0) {
                    User::find($user->id)->notify(new ServiceDown($data['url'], $tracker->team_id, $user->id));
                }
                
            }
            return 'Notification sent';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
    public function show(ApiNotification $apiNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiNotification $apiNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiNotification $apiNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiNotification $apiNotification)
    {
        //
    }
}
