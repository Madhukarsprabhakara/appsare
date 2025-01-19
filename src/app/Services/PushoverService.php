<?php

namespace App\Services;
use App\Models\Language;
use Illuminate\Support\Facades\Crypt;
class PushoverService {
	public function connectPushover($team_id)
    {
        $redirect_success = urlencode(config('services.pushover.base_redirect_success'));
        $redirect_failure = urlencode(config('services.pushover.base_redirect_failure'));
        $rand = bin2hex(random_bytes(20));
        session(['pushover_rand' => $rand]);
        $base_uri = config('services.pushover.base_redirect_uri');
        $fullUrl = "{$base_uri}?rand={$rand}&success={$redirect_success}&failure={$redirect_failure}";

        return $fullUrl;
    }
    public function savePushoverToken($team_id, $pushover_user_key)
    {
        
        
        if ($team_id)
        {
            $pushover_connect= new PushoverConnect();
            $pushover_connect->team_id=$team_id;
            $pushover_connect->user_id=\Auth::id();
            $pushover_connect->pushover_code=Crypt::encryptString($pushover_user_key);
            $pushover_connect->save();
            return true;
        }
        throw new \Exception('No team found for this user. Please create a team first.' ); 
    }
    
}