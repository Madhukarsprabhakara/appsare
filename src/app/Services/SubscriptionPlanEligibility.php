<?php

namespace App\Services;

class SubscriptionPlanEligibility {
	public function getCurrentPlan($user) {
        return $user->sparkPlan();
    }
    public function getTrialDays($user) {
        return $user->trial_ends_at ? $user->trial_ends_at->diffInDays(now()) : 0;
    }
    public function isEligibleToCreateTeam($user) {
        
        if ($user->onTrial()) {
            return true;
        }
        if ($user->subscribed()) {
            $currentPlan=$user->sparkPlan()->name;
            if ($currentPlan == 'Small Business') {
                return;
            }
            abort(403,'Please upgrade your plan to "Small Business" to create additional teams.');
        }
        abort(403, 'Please upgrade your plan to "Small Business" to create additional teams.');
    }
    public function isEligibleToCreateTrackers($user) {
        if ($user->onTrial()) {
            return true;
        }
        if ($user->subscribed()) {
            $currentPlan=$user->sparkPlan()->name;
            $trackerCount = $user->currentTeam->trackersOnly()->count();
            $trackerLimits = [
                'Indie Hacker - The dream' => 10,
                'Indie Hacker - Realized' => 50,
                'Small Business' => 100,
            ];
            if (isset($trackerLimits[$currentPlan])) {
                $allowedTrackers = $trackerLimits[$currentPlan];

                // Restrict if the team exceeds the allowed number of trackers
                if ($trackerCount > $allowedTrackers) {
                    abort(403,'You are not allowed to have more than '.$allowedTrackers.' trackers on the "'.$currentPlan.'" plan. Please Contact ms@appsare.com.');
                }
                
            }
            
        }
        
    }
    
}