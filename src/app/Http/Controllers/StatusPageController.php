<?php

namespace App\Http\Controllers;

use App\Models\StatusPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $statusPages = StatusPage::all();
            return Inertia::render('StatusPages/Show', [
                'statusPages' => $statusPages
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
        try {
            return Inertia::render('StatusPages/Create');
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
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
    public function show(StatusPage $statusPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPage $statusPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPage $statusPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPage $statusPage)
    {
        //
    }
}
