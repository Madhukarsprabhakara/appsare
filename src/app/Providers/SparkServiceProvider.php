<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Spark\Plan;
use Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Spark::billable(User::class)->resolve(function (Request $request) {
            return $request->user();
        });

        Spark::billable(User::class)->authorize(function (User $billable, Request $request) {
            return $request->user() &&
                $request->user()->id == $billable->id;
        });

        Spark::billable(User::class)->checkPlanEligibility(function (User $billable, Plan $plan) {
            // Get the total number of trackers for the user's team
            $teamTrackersCount = $billable->currentTeam->trackersOnly()->count();
            // $teamCount = $user->ownedTeams->count();
            // Define tracker limits for each plan
            $trackerLimits = [
                'Indie Hacker - The dream' => 10,
                'Indie Hacker - Realized' => 50,
                'Small Business' => 100,
            ];

            // Check if the plan has a defined tracker limit
            if (isset($trackerLimits[$plan->name])) {
                $allowedTrackers = $trackerLimits[$plan->name];

                // Restrict if the team exceeds the allowed number of trackers
                if ($teamTrackersCount > $allowedTrackers) {
                    throw ValidationException::withMessages([
                        'plan' => "Your team has too many trackers for the selected plan. The \"{$plan->name}\" plan allows up to {$allowedTrackers} trackers and you currently have {$teamTrackersCount} trackers.",
                    ]);
                }
                // if ($teamCount > 1) {
                //     throw ValidationException::withMessages([
                //         'plan' => "Your team has too many teams for the selected plan. The \"{$plan->name}\" plan allows only one team and you currently have {$teamCount} teams.",
                //     ]);
                // }
            }
        });
    }
}
