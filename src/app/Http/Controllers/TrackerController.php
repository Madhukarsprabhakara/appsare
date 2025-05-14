<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TrackerService;
use App\Services\EssentialService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Services\SubscriptionPlanEligibility;
use App\Events\TrackerCreated;

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
    public function store(Request $request, SubscriptionPlanEligibility $subscriptionPlanEligibility, EssentialService $essentialService, TrackerService $trackerService)
    {
        //
        $domain_expiry = null;
        $ssl_cert_expiry = null;
        $subscriptionPlanEligibility->isEligibleToCreateTrackers($request->user());
        $data = $request->all();
        $validated = $request->validate([
            'url' => 'required|string',

        ]);
        // Validate the URL format
        // ssl cert check
        // dns check

        if ($trackerService->checkDNS($data['url'])) {
            $domain_expiry = $trackerService->checkDomainNameExpiry($data['url']);
            $ssl_cert_expiry = $trackerService->checkSSLCertExpiry($data['url']);
        } else {
            abort(403, 'Invalid URL or DNS record not found.');
        }

        $tracker_to_save = $essentialService->addUserIdTeamIdToArray($data);
        $status = $trackerService->storeTracker($tracker_to_save, $domain_expiry, $ssl_cert_expiry);

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
    public function update(Request $request, Tracker $tracker, TrackerService $trackerService)
    {
        //

        $data = $request->all();
        Validator::make($data, [
            'url' => 'required|url:http,https|max:255',
        ])->validateWithBag('editTracker');

        if ($trackerService->checkDNS($data['url'])) {
            $domain_expiry = $trackerService->checkDomainNameExpiry($data['url']);
            $ssl_cert_expiry = $trackerService->checkSSLCertExpiry($data['url']);
            $trackerService->updateTracker($data, $tracker, $domain_expiry, $ssl_cert_expiry);
            
        } else {
            abort(403, 'Invalid URL or DNS record not found.');
        }


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
        $tracker->domainCert()->delete();
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
