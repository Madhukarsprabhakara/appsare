<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class CheckTeamSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // Default subscription status
        $subscriptionStatus = null;

        if ($user) {
            // Check if the current team has an active subscription
            $team = $user->currentTeam;

            $subscriptionStatusExist = $team->subscriptionExists()->exists();
            // Assuming TeamSubscription model has a `team_id` and `is_active_subscription` field
            if($subscriptionStatusExist) {
                $subscriptionStatus = $team->subscription()[0]->is_active_subscription;
            }
           
                
        }
        
        // Share the subscription status with the request
        Inertia::share([
            'subscription_status' => $subscriptionStatus,
        ]);
        // $request->merge(['subscription_status' => $subscriptionStatus]);
        // if (!$subscriptionStatus) {
        //     return redirect('/billing')->with('error', 'Your team does not have an active subscription. Please subscribe to continue.');
        // }

        return $next($request);
    }
}
