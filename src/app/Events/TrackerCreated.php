<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TrackerCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $tracker, $domain_expiry, $ssl_cert_expiry;
    public function __construct($tracker, $domain_expiry = null, $ssl_cert_expiry = null)
    {
        //
        $this->domain_expiry = $domain_expiry;
        $this->ssl_cert_expiry = $ssl_cert_expiry;
        $this->tracker = $tracker;
    }
    public function broadcastOn()
    {
        return new Channel('tracker-created');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
   
}
