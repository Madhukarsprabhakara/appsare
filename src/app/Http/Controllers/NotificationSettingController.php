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
                'notificationSettings' => $notificationSettingsService->getNotificationSettingsOnTeam(auth()->user()->currentTeam)
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
