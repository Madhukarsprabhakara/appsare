<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Create a new action instance.
     */
    public function __construct(protected DeletesTeams $deletesTeams)
    {
    }

    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->deleteNotificationSettings($user);
            $this->deleteTeamSubscriptions($user);
            $this->cancelSubscription($user);
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     */
    protected function deleteTeams(User $user): void
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function (Team $team) {
            $this->deletesTeams->delete($team);
        });
    }
    protected function deleteNotificationSettings(User $user): void
    {
        DB::table('notification_settings')->where('user_id', $user->id)->delete();
    }
    protected function deleteTeamSubscriptions(User $user): void
    {
        DB::table('team_subscriptions')->where('user_id', $user->id)->delete();
    }
    protected function cancelSubscription(User $user): void
    {
        // Implement the logic to cancel the user's subscription here
        // For example, you might want to call a subscription service API
        // or update the user's subscription status in your database.
        if (optional($user->subscription())->recurring()) {
            $user->subscription()->cancelNow();
        }
    }
}
