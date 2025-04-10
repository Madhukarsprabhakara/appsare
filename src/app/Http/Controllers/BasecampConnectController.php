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
        $verificationCodeUrl=$basecampService->getBasecampVerificationCodeUrl();
        return \Redirect::to($verificationCodeUrl);
        
    }
    public function handleCallback(Request $request, BasecampService $basecampService)
    {
        //
        try {
            $data=$request->all();
            $code=$data['code'];
             $token=$basecampService->getBasecampToken($code);
             $token->code=$code;
               
                return $token;
            $basecamp_connect=BasecampConnect::where('team_id', \Auth::user()->currentTeam->id)->first();
            if ($basecamp_connect)
            {
                $basecamp_connect->basecamp_code=$code;
                $basecamp_connect->save();
                return \Redirect::route('integrations.index');
            }
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for creating a new resource.
     */
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
    public function destroy(BasecampConnect $basecampConnect)
    {
        //
    }
}
