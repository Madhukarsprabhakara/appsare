<?php

namespace App\Services;

use App\Models\BasecampConnect;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class BasecampService
{
    public function getBasecampVerificationCodeUrl()
    {

        ////
        $type = 'web_server';
        $client_id = config('services.basecamp.client_id');
        $redirect_uri = config('services.basecamp.redirect');
        $base_uri = config('services.basecamp.temp_code_url');
        $fullUrl = "{$base_uri}?type={$type}&client_id={$client_id}&redirect_uri={$redirect_uri}";
        return $fullUrl;
    }
    public function getBasecampTokenResponse($verification_code)
    {
        return $response = Http::asForm()->post(config('services.basecamp.api_auth_url'), [
            'type' => 'web_server',
            'client_id' => config('services.basecamp.client_id'),
            'redirect_uri' => config('services.basecamp.redirect'),
            'client_secret' => config('services.basecamp.client_secret'),
            'code' => $verification_code,
        ]);
    }
    public function saveBasecampTokenResponse($token_response_array_for_saving)
    {
        return BasecampConnect::upsert($token_response_array_for_saving, uniqueBy: ['team_id'], update: ['team_id', 'expires_at', 'expires_in', 'access_token', 'refresh_token', 'code']);
    }
    public function saveBasecampRefreshTokenResponse($token_response_array_for_saving) 
    {
        return BasecampConnect::upsert($token_response_array_for_saving, uniqueBy: ['team_id'], update: [ 'expires_at', 'expires_in', 'access_token']);
    }
    public function getBasecampTokenArray($token_response_array, $code, $team_id, $expires_in, $expires_at)
    {
        $token_response_array['team_id'] =  $team_id;
        $token_response_array['expires_at'] = $expires_at;
        $token_response_array['expires_in'] = $expires_in;
        $token_response_array['access_token'] = Crypt::encryptString($token_response_array['access_token']);
        $token_response_array['refresh_token'] = Crypt::encryptString($token_response_array['refresh_token']);
        $token_response_array['code'] = Crypt::encryptString($code);
        return $token_response_array;
    }
    public function getBasecampConnection($team_id)
    {
        $basecamp_connect = BasecampConnect::where('team_id', $team_id)->first();
        if ($basecamp_connect) {
            return $basecamp_connect;
        }
        return false;
    }
    public function getBasecampToken($team_id)
    {
        $basecamp_connect = $this->getBasecampConnection($team_id);
        if ($basecamp_connect) {
            return Crypt::decryptString($basecamp_connect->access_token);
        }
        return false;
    }
    public function refreshTokenIfExpired(BasecampConnect $basecamp_connect) 
    {
        //return $basecamp_connect;
        if ($basecamp_connect) {
            
            $url= 'https://launchpad.37signals.com/authorization/token?type=refresh&refresh_token=' . Crypt::decryptString($basecamp_connect->refresh_token) . '&client_id=' . config('services.basecamp.client_id') . '&client_secret=' . config('services.basecamp.client_secret');
            $response = Http::asForm()->post($url);
            
            if ($response->successful()) {
                $token_response_array = json_decode($response, true);
                $expires_at=now()->addSeconds($token_response_array['expires_in'])->format('Y-m-d H:i:s');
                $token_response_array['expires_at']=$expires_at;
                $token_response_array['team_id'] = $basecamp_connect->team_id;
                $token_response_array['access_token']=Crypt::encryptString($token_response_array['access_token']);
                return $this->saveBasecampRefreshTokenResponse($token_response_array);
            }
        }
        return false;
    }
    public function getBasecampProjects($accountId)
    {
        //send get request to get all projects
        try {
            $url = 'https://3.basecampapi.com/' . $accountId . '/projects.json';

            //return $this->getBasecampToken(\Auth::user()->currentTeam->id);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getBasecampToken(\Auth::user()->currentTeam->id), // Replace with your actual authorization token
            ])->get($url);

            if ($response->successful()) {

                // Handle the response data
                return $response;
            } 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
