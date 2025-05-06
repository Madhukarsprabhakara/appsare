<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TeamSubscription;
use Illuminate\Support\Facades\Log;
use Spark\Events\SubscriptionCreated;
class HandleSubscriptionCreated
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
    public function handle(SubscriptionCreated $event): void
    {
        //
        $user = $event->billable; // The user who canceled the subscription
        

        // Example: Activate the team's subscription
        if ($user->currentTeam) {
            $team = $user->currentTeam;

            // Update the team's subscription status

            TeamSubscription::upsert([
                ['is_active_subscription' => true, 'user_id' => $user->id, 'team_id' => $team->id]
            ], uniqueBy: ['team_id'], update: ['is_active_subscription', 'user_id', 'team_id']);
            Log::info('Subscription created for user: ' . $user->id);

        }
        
        
    }
}
