<?php

namespace App\Listeners;

use App\Events\TrackerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleTrackerCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TrackerCreated $event): void
    {
        //

        $event->tracker->domainCert()->create([
            'tracker_id' => $event->tracker->id,
            'domain_expires_at' => $event->domain_expiry,
            'cert_expires_at' => $event->ssl_cert_expiry,
        ]);
    }
}
