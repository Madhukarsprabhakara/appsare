<?php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class PushoverChannel
{
    public function send($notifiable, Notification $notification)
    {
        // Get the Pushover message from the notification
        $message = $notification->toPushover($notifiable);

        // Send the notification via Pushover
        $response = Http::post('https://api.pushover.net/1/messages.json', [
            'token' => config('services.pushover.api_key'),
            'user' => $notifiable->routeNotificationForPushover(),
            'message' => $message->content,
            'title' => $message->title,
            'url' => $message->url,
            'url_title' => $message->url_title,
            'priority' => $message->priority,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to send Pushover notification: ' . $response->body());
        }
    }
}