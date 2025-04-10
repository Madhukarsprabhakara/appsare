<?php

namespace App\Services;

use App\Models\BasecampConnect;
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
}
