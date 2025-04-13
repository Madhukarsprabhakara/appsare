<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
class BasecampCampfireChannel
{
    public function send($notifiable, Notification $notification)
    {
        // Get the Basecamp message from the notification
        $message = $notification->toBasecampCampfire($notifiable);

        // Fetch the access token and Campfire URL from the notifiable (e.g., team or user)
        $accessToken = Crypt::decryptString($notifiable->routeNotificationForBasecampCampfire()['access_token']);
        $campfireUrl = $notifiable->routeNotificationForBasecampCampfire()['campfire_url'];

        // Send the notification via Basecamp Campfire
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post($campfireUrl, [
            'content' => $message->content,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to send Basecamp Campfire notification: ' . $response->body());
        }
    }
}