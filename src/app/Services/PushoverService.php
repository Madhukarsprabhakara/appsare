<?php

namespace App\Services;
use App\Models\Language;
use Illuminate\Support\Facades\Crypt;
use App\Models\PushoverConnect;
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
        
        
        if ($pushover_user_key)
        {
            $pushover_connect= new PushoverConnect();
            $pushover_connect->team_id=$team_id;
            $pushover_connect->user_id=\Auth::id();
            $pushover_connect->pushover_code=Crypt::encryptString($pushover_user_key);
            $pushover_connect->save();
            return true;
        }
        else
        {
            $pushoverConnect=$this->getPushoverConnection(\Auth::id());
            $deleted=$pushoverConnect->delete();
            if ($deleted)
            {
                return true;
            }
        }
        throw new \Exception('No team found for this user. Please create a team first.' ); 
    }
    public function getPushoverConnection($user_id)
    {
        $pushover_connect=PushoverConnect::where('user_id', $user_id)->first();
        if ($pushover_connect)
        {
            return $pushover_connect;
        }
        return false;
    }
    public function getPushoverToken($user_id)
    {
        $pushover_connect=$this->getPushoverConnection($user_id);
        if ($pushover_connect)
        {
            return Crypt::decryptString($pushover_connect->pushover_code);
        }
        return false;
    }
    
}