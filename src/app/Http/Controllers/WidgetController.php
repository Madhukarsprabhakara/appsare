<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use Illuminate\Http\Request;
use App\Models\Tracker;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tracker $tracker)
    {
        //
        //$tracker = Tracker::findOrFail($trackerId);
        return view('widgets.uptime', [
            'trackerId' => $tracker->id,
            'uptime' => $tracker->uptime_percentage

        ]);
    }

    public function uptime(Tracker $tracker)
    {
        //
        //return $tracker;
        return view('widgets.uptime', [
            'trackerId' => $tracker->id,
            'uptime' => $tracker->uptime_percentage

        ]);
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
    public function show(Widget $widget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Widget $widget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Widget $widget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Widget $widget)
    {
        //
    }
}
