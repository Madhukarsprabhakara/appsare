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
            if ($currentPlan == 'Small Business') {
                return;
            }
            abort(403,'Please upgrade your plan to "Small Business" to create additional trackers.');
        }
        abort(403, 'Please upgrade your plan to "Small Business" to create additional trackers.');
    }
    
}