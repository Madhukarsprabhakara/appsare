<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\NotificationSettingsService;
class NotificationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NotificationSettingsService $notificationSettingsService)
    {
        //
        try {

            return Inertia::render('NotificationSettings/Show',[
                'notificationSettings' => $notificationSettingsService->getGlobalNotificationSettingsOnTeam(auth()->user()->currentTeam),
                'userNotificationSettings' => $notificationSettingsService->getNotificationSettingsOnUser(auth()->user(), auth()->user()->currentTeam),
                'teamNotificationSettings' => $notificationSettingsService->getNotificationSettingsOnTeam(auth()->user(), auth()->user()->currentTeam),
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateChannelNotificationSettings(Request $request, NotificationSettingsService $notificationSettingsService)
    {
        //
        $validated = $request->validate([
            'team_id' => 'required|numeric|exists:teams,id',
            'user_id' => 'required|numeric|exists:users,id',
            'notification_type_id' => 'required|numeric|exists:notification_types,id',
            'is_enabled' => 'required|boolean',
        ]);

        if ($validated['notification_type_id'] === 1) { // Assuming 1 is for team notifications
            $notificationSettingsService->updateNotificationSettingsOnUser($validated);
        }
        if ($validated['notification_type_id'] === 2) { // Assuming 1 is for team notifications
            $notificationSettingsService->updateNotificationSettingsOnTeam($validated);
        }
        if ($validated['notification_type_id'] === 3) { // Assuming 1 is for team notifications
            $notificationSettingsService->updateNotificationSettingsOnTeam($validated);
        }
        if ($validated['notification_type_id'] === 4) { // Assuming 1 is for team notifications
            $notificationSettingsService->updateNotificationSettingsOnUser($validated);
        }

        
        return back(303);
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
    public function show(NotificationSetting $notificationSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationSetting $notificationSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotificationSetting $notificationSetting)
    {
        //
        try {
             if ($notificationSetting['notificatons_enabled'])
             {
                 $notificationSetting->update(['notificatons_enabled' => false]);
             }
             else
             {
                 $notificationSetting->update(['notificatons_enabled' => true]);
             }
             return \Redirect::back();
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);    
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationSetting $notificationSetting)
    {
        //
    }
}
