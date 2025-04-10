<?php

namespace App\Services;
use App\Models\BasecampConnect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
class BasecampService {
	public function getBasecampVerificationCodeUrl()
    {
        
        ////
        $type='web_server';
        $client_id =config('services.basecamp.client_id');
        $redirect_uri=config('services.basecamp.redirect');
        $base_uri = config('services.basecamp.temp_code_url');
        $fullUrl = "{$base_uri}?type={$type}&client_id={$client_id}&redirect_uri={$redirect_uri}";
        return $fullUrl;
    }
    public function getBasecampToken($verification_code)
    {
        return $response = Http::asForm()->post('https://launchpad.37signals.com/authorization/token', [
            'type' => 'web_server',
            'client_id' => config('services.basecamp.client_id'),
            'redirect_uri' => config('services.basecamp.redirect'),
            'client_secret' => config('services.basecamp.client_secret'),
            'code' => $verification_code,
        ]);
    }
    public function storeBasecampToken($team_id, $token_response, $temp_code)
    {
        $basecamp_connect=BasecampConnect::where('team_id', $team_id)->first();
        if ($basecamp_connect)
        {
            $basecamp_connect->code=$token_response['code'];
            $basecamp_connect->access_token=$token_response['access_token'];
            $basecamp_connect->refresh_token=$token_response['refresh_token'];
            $basecamp_connect->expires_in=$token_response['expires_in'];
            $basecamp_connect->expires_at=$token_response['expires_at'];
            $basecamp_connect->save();
        }
        else
        {
            $this->createBasecampConnect($team_id, $token_response);
        }
    }
    
    
}