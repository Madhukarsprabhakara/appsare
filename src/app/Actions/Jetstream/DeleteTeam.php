<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        // Delete the related entry from notification_settings
        \DB::table('notification_settings')->where('team_id', $team->id)->delete();
        $team->purge();
    }
}
