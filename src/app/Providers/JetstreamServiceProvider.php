<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;
use Illuminate\Http\Request;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Inertia::share([
            'trial_days' => function (Request $request) {
                return $request->user() && $request->user()->trial_ends_at
                    ? abs((int) round($request->user()->trial_ends_at->diffInDays(now())))
                    : null;
            },
            'subscription_status' => function (Request $request) {
                $user = $request->user();
                // Default subscription status
                $subscriptionStatus = null;

                if ($user) {
                    // Check if the current team has an active subscription
                    $team = $user->currentTeam;

                    $subscriptionStatusExist = $team->subscriptionExists()->exists();
                    // Assuming TeamSubscription model has a `team_id` and `is_active_subscription` field
                    if ($subscriptionStatusExist) {
                        $subscriptionStatus = $team->subscription()[0]->is_active_subscription;
                    }
                }
                return $subscriptionStatus;
            },
            // 'subscription_status' => function (Request $request) {
            //     return $request->subscription_status ?? false;
            // },
        ]);
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to read, create, and update.');
    }
}
