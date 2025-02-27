<?php

namespace App\Services;
use App\Models\SlackConnect;
use App\Models\Team;
use Laravel\Socialite\Facades\Socialite;
 
class SlackService {
	
    public function connectSlack($team_id)
    {
        $team=Team::where('id', $team_id)->first();
        if ($team)
        {
            return Socialite::driver('slack')
            ->asBotUser()
            ->setScopes(['chat:write', 'chat:write.public', 'chat:write.customize','channels:read','groups:read','im:read','mpim:read
'])
            ->redirectUrl('https://appsare.com/auth/slack/callback')
            ->redirect();   
        }
        throw new \Exception('No team found for this user. Please create a team first.' ); 
    }
    public function saveSlackToken($team_id)
    {
        $slack_user = Socialite::driver('slack')->asBotUser()->user();
        //return json_encode($slack_user);
        //$team=Team::where('id', $team_id)->first();
        
        if ($team_id)
        {
            $slack_connect= new SlackConnect();
            $slack_connect->team_id=$team_id;
            $slack_connect->user_id=\Auth::id();
            $slack_connect->slack_bot_code=$slack_user->token;
            //$slack_connect->slack_channel_id=$slack_user->user['id'];
            $slack_connect->save();
            return true;
        }
        throw new \Exception('No team found for this user. Please create a team first.' ); 
    }
    public function getSlackConnection($team_id)
    {
        $slack_connect=SlackConnect::where('team_id', $team_id)->first();
        if ($slack_connect)
        {
            return $slack_connect;
        }
        return false;
    }
    public function storeSlack(Array $Slack_to_save)
    {
        $slack_connect=Tracker::SlackConnect($tracker_to_save);
        if ($slack_connect)
        {
            return true;
        }
        throw new \Exception('Something went wrong, could not save your slack details. Please try again.' ); 
    }
    public function getSlackPublicChannelList($team_id)
    {
        $slack_connect=SlackConnect::where('team_id', $team_id)->first();
        if ($slack_connect)
        {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://slack.com/api/conversations.list', [
                'query' => [
                    'token' => $slack_connect->slack_bot_code,
                    'types' => 'public_channel',
                ]
            ]);
            $response = json_decode($response->getBody());
            return $response;
        }
        throw new \Exception('No slack details found for this team. Please connect your slack account.' ); 
    }
}