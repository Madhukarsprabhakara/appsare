<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\SlackService;
use App\Services\UserService;
class IntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SlackService $slackService, UserService $userService)
    {
        //
        try {
            $slackConnection=$slackService->getSlackConnection($userService->getLoggedinUserTeam()->id);
            return Inertia::render('Integrations/Show', [
                'slackConnection' => $slackConnection
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
    public function show(Integration $integration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Integration $integration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Integration $integration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Integration $integration)
    {
        //
    }
}
