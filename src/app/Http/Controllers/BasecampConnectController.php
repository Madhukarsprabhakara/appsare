<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\BasecampConnect;
use Illuminate\Http\Request;
use App\Services\BasecampService;

class BasecampConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function redirect(BasecampService $basecampService)
    {
        $verificationCodeUrl = $basecampService->getBasecampVerificationCodeUrl();
        return \Redirect::to($verificationCodeUrl);
    }
    public function handleCallback(Request $request, BasecampService $basecampService)
    {
        //
        try {
            $data = $request->all();
            if (!isset($data['code'])) {
                return \Redirect::route('integrations.index');
            }
            $code = $data['code'];
            $token_response = $basecampService->getBasecampTokenResponse($code);
            $token_response_array = json_decode($token_response, true);
            $token_response_array_for_saving=$basecampService->getBasecampTokenArray($token_response_array, $code, \Auth::user()->currentTeam->id, $token_response_array['expires_in'],now()->addSeconds($token_response_array['expires_in'])->format('Y-m-d H:i:s'));
            $status=$basecampService->saveBasecampTokenResponse($token_response_array_for_saving);
            
            
            if ($status) {
                return \Redirect::route('integrations.index');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getBasecampProjects(BasecampService $basecampService)
    {
        $projects = $basecampService->getBasecampProjects();
        return response()->json($projects);
    }
    public function create()
    {
        //



        $response = Http::asForm()->post('https://launchpad.37signals.com/authorization/token', [
            'type' => 'web_server',
            'client_id' => 'd9c38d1cc4e71d83b80e0a3db2919fc4f7b023f6',
            'redirect_uri' => 'https://appsare.com/auth/basecamp/callback',
            'client_secret' => 'c3391ee3bfebd0f10a0abc9ec5b799f1729f7c9c',
            'code' => '42a42250',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            // Handle the response data
            return $data;
        } else {
            // Handle the error
            throw new \Exception('Failed to fetch token: ' . $response->body());
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
    public function show(BasecampConnect $basecampConnect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BasecampConnect $basecampConnect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BasecampConnect $basecampConnect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BasecampConnect $basecamp_connect)
    {
        //
        try {
            $status=$basecamp_connect->delete();
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
